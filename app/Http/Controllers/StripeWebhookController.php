<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingService;
use Stripe\Webhook;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $this->processCompletedSession($session);
        }

        return response()->json(['status' => 'success']);
    }

    protected function processCompletedSession($session)
    {
        $reference = $session->metadata->reference ?? null;
        
        if (!$reference) {
            Log::error('Stripe Webhook: Reference missing in metadata');
            return;
        }

        // Find the pending booking
        $booking = \App\Models\Booking::where('booking_reference', $reference)->first();

        if (!$booking) {
            Log::error("Stripe Webhook: Booking record not found for reference: {$reference}");
            return;
        }

        if ($booking->status === 'confirmed') {
            Log::info("Stripe Webhook: Booking {$reference} already confirmed.");
            return;
        }

        $sessionData = json_decode($booking->api_booking_details, true);

        // Update status
        $booking->update(['status' => 'confirmed']);

        // Create items and payment record
        foreach ($sessionData['travelers'] ?? [] as $index => $traveler) {
            \App\Models\BookingItem::updateOrCreate(
                ['booking_id' => $booking->id, 'item_name' => ($traveler['first_name'] ?? 'Traveler') . ' ' . ($traveler['last_name'] ?? ($index + 1))],
                ['item_type' => 'traveler', 'amount' => 0, 'details' => json_encode($traveler)]
            );
        }

        \App\Models\Payment::updateOrCreate(
            ['transaction_id' => $session->id],
            [
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'amount' => $booking->total_amount,
                'currency' => $booking->currency,
                'gateway' => 'stripe',
                'status' => 'paid',
                'gateway_response' => json_encode($session)
            ]
        );

        Log::info("Stripe Webhook: Booking {$reference} confirmed successfully via Webhook.");
    }
}

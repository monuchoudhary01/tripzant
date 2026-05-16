<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\MpgsService;
use App\Services\StripeService;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string', // flight, hotel
            'total_amount' => 'required|numeric',
            'gateway' => 'required|string', // stripe, mpgs
            'travelers' => 'required|array',
            'item_data' => 'nullable|array',
            'reference' => 'nullable|string'
        ]);

        $reference = $validated['reference'] ?? ('API-' . strtoupper(bin2hex(random_bytes(4))));
        $gateway = $validated['gateway'];
        
        $bookingData = [
            'type'         => $validated['type'],
            'total_amount' => $validated['total_amount'],
            'travelers'    => $validated['travelers'],
            'item_data'    => $validated['item_data'] ?? null,
            'reference'    => $reference,
            'gateway'      => $gateway,
            'user_id'      => auth()->id(),
            'currency'     => ($gateway === 'mpgs') ? 'LKR' : 'INR',
            'source'       => 'mobile_api'
        ];

        // Create pending booking record
        Booking::create([
            'user_id' => auth()->id(),
            'booking_reference' => $reference,
            'type' => $validated['type'],
            'total_amount' => $validated['total_amount'],
            'currency' => $bookingData['currency'],
            'status' => 'pending',
            'api_booking_details' => json_encode($bookingData)
        ]);

        if ($gateway === 'stripe') {
            $stripe = app(StripeService::class);
            $session = $stripe->createCheckoutSession([
                'item_name' => ucfirst($validated['type']) . ' Booking - Tripzant',
                'amount' => $validated['total_amount'],
                'email' => auth()->user()->email ?? null,
                'success_url' => route('api.payment.success', ['reference' => $reference]),
                'cancel_url' => route('api.payment.cancel', ['reference' => $reference]),
                'metadata' => ['reference' => $reference, 'source' => 'mobile_api']
            ]);

            return response()->json([
                'success' => true,
                'gateway' => 'stripe',
                'checkout_url' => $session->url ?? null,
                'reference' => $reference
            ]);
        } 
        
        if ($gateway === 'mpgs') {
            $mpgs = app(MpgsService::class);
            $session = $mpgs->createCheckoutSession([
                'order_id' => $reference,
                'amount' => $validated['total_amount'],
                'currency' => 'LKR'
            ]);

            return response()->json([
                'success' => true,
                'gateway' => 'mpgs',
                'session_id' => $session['session']['id'] ?? null,
                'merchant_id' => config('payments.mpgs.merchant_id'),
                'reference' => $reference
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid gateway'], 400);
    }

    public function success(Request $request)
    {
        $reference = $request->input('reference');
        $transactionId = $request->input('transaction_id') ?? $request->input('session_id');
        $gateway = $request->input('gateway', 'stripe');

        $booking = Booking::where('booking_reference', $reference)->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        if ($booking->status === 'confirmed') {
            return response()->json(['success' => true, 'message' => 'Booking already confirmed', 'booking' => $booking]);
        }

        // --- MPGS Specific Verification ---
        if ($gateway === 'mpgs') {
            $mpgs = app(MpgsService::class);
            $orderDetails = $mpgs->getOrderDetails($reference);
            
            if (isset($orderDetails['status']) && ($orderDetails['status'] === 'CAPTURED' || $orderDetails['status'] === 'AUTHORIZED')) {
                // Payment is valid
            } else {
                return response()->json([
                    'success' => false, 
                    'message' => 'Payment verification failed with Commercial Bank',
                    'details' => $orderDetails
                ], 400);
            }
        }

        // Logic similar to CheckoutController@success
        $sessionData = json_decode($booking->api_booking_details, true);
        
        $booking->update(['status' => 'confirmed']);
        
        // Save items
        foreach ($sessionData['travelers'] ?? [] as $index => $traveler) {
            \App\Models\BookingItem::create([
                'booking_id' => $booking->id,
                'item_name' => ($traveler['first_name'] ?? 'Traveler') . ' ' . ($traveler['last_name'] ?? ($index + 1)),
                'item_type' => 'traveler',
                'amount' => 0,
                'details' => json_encode($traveler)
            ]);
        }

        // Payment record
        \App\Models\Payment::create([
            'user_id' => auth()->id() ?? $booking->user_id,
            'booking_id' => $booking->id,
            'transaction_id' => $transactionId ?? ('API-' . uniqid()),
            'amount' => $booking->total_amount,
            'currency' => $booking->currency,
            'gateway' => $sessionData['gateway'] ?? 'unknown',
            'status' => 'paid',
            'gateway_response' => json_encode($request->all())
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking confirmed successfully',
            'booking' => $booking
        ]);
    }
}

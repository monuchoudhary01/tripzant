<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingService
{
    /**
     * Complete a booking after payment success
     */
    public function completeBooking($sessionData, $transactionId, $gateway, $gatewayResponse = null)
    {
        return DB::transaction(function () use ($sessionData, $transactionId, $gateway, $gatewayResponse) {
            $type = $sessionData['type'] ?? 'flight';
            $totalAmount = $sessionData['total_amount'];
            $travelers = $sessionData['travelers'] ?? [];
            $reference = $sessionData['reference'] ?? (strtoupper($type) . '-' . strtoupper(bin2hex(random_bytes(4))));
            $userId = $sessionData['user_id'] ?? (auth()->id() ?? null);

            // 1. Create Main Booking
            $booking = Booking::create([
                'user_id' => $userId,
                'booking_reference' => $reference,
                'type' => $type,
                'total_amount' => $totalAmount,
                'currency' => $sessionData['currency'] ?? 'LKR',
                'status' => 'confirmed',
                'api_booking_details' => json_encode($sessionData)
            ]);

            // 2. Save each traveler/item
            foreach ($travelers as $index => $traveler) {
                BookingItem::create([
                    'booking_id' => $booking->id,
                    'item_name' => ($traveler['first_name'] ?? 'Traveler') . ' ' . ($traveler['last_name'] ?? ($index + 1)),
                    'item_type' => 'traveler',
                    'amount' => 0,
                    'details' => json_encode($traveler)
                ]);
            }

            // 3. Create Payment Record
            Payment::create([
                'user_id' => $userId,
                'booking_id' => $booking->id,
                'transaction_id' => $transactionId,
                'amount' => $totalAmount,
                'currency' => $sessionData['currency'] ?? 'LKR',
                'gateway' => $gateway,
                'status' => 'success', // or 'paid'
                'gateway_response' => json_encode($gatewayResponse)
            ]);

            Log::info("Booking completed successfully: {$reference} via {$gateway}");

            return $booking;
        });
    }

    /**
     * Check if a booking already exists for a reference or transaction
     */
    public function bookingExists($reference)
    {
        return Booking::where('booking_reference', $reference)->exists();
    }
}

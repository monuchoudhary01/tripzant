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
                'status' => 'paid',
                'gateway_response' => json_encode($gatewayResponse)
            ]);

            // 4. Create Detailed Sub-Records
            $this->createSubRecords($booking, $sessionData);

            Log::info("Booking completed successfully: {$reference} via {$gateway}");

            return $booking;
        });
    }

    /**
     * Create Detailed Sub-Records (Flight/Hotel) and Passengers
     */
    public function createSubRecords($booking, $sessionData)
    {
        $type = $sessionData['type'] ?? 'flight';
        $travelers = $sessionData['travelers'] ?? [];
        $itemData = $sessionData['item_data'] ?? null;
        $reference = $booking->booking_reference;

        if ($itemData) {
            $item = is_string($itemData) ? json_decode($itemData, true) : $itemData;
            
            if ($type === 'flight') {
                $itineraries = $item['itineraries'] ?? [];
                $firstSeg = $itineraries[0]['segments'][0] ?? null;
                $lastItin = end($itineraries);
                $lastSeg = end($lastItin['segments']) ?? $firstSeg;

                \App\Models\FlightBooking::updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'pnr' => $reference,
                        'airline_pnr' => $reference,
                        'origin' => $firstSeg['departure']['iataCode'] ?? '???',
                        'destination' => $lastSeg['arrival']['iataCode'] ?? '???',
                        'departure_at' => isset($firstSeg['departure']['at']) ? date('Y-m-d H:i:s', strtotime($firstSeg['departure']['at'])) : null,
                        'arrival_at' => isset($lastSeg['arrival']['at']) ? date('Y-m-d H:i:s', strtotime($lastSeg['arrival']['at'])) : null,
                        'airline_code' => $firstSeg['carrierCode'] ?? '??',
                        'flight_number' => $firstSeg['number'] ?? '000',
                        'cabin_class' => $item['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] ?? 'ECONOMY',
                        'itinerary_details' => json_encode($itineraries),
                        'fare_rules' => json_encode($item['travelerPricings'][0]['fareDetailsBySegment'] ?? [])
                    ]
                );
            } elseif ($type === 'hotel') {
                \App\Models\HotelBooking::updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'hotel_id' => $item['hotelCode'] ?? ($item['code'] ?? ''),
                        'hotel_name' => $item['name'] ?? 'Hotel',
                        'check_in' => $sessionData['checkIn'] ?? ($item['checkIn'] ?? date('Y-m-d')),
                        'check_out' => $sessionData['checkOut'] ?? ($item['checkOut'] ?? date('Y-m-d', strtotime('+1 day'))),
                        'rooms' => (int)($sessionData['rooms'] ?? 1),
                        'guests' => count($travelers),
                        'room_type' => $item['rooms'][0]['name'] ?? 'Standard Room',
                        'confirmation_number' => $reference,
                        'hotel_details' => json_encode($item),
                    ]
                );
            }
        }

        // Create Passengers (Standardized Table)
        foreach ($travelers as $p) {
            \App\Models\Passenger::updateOrCreate(
                ['booking_id' => $booking->id, 'first_name' => $p['first_name'] ?? 'Guest', 'last_name' => $p['last_name'] ?? 'User'],
                [
                    'type' => $p['type'] ?? 'adult',
                    'title' => $p['title'] ?? 'Mr',
                    'gender' => $p['gender'] ?? null,
                    'dob' => $p['dob'] ?? null,
                    'passport_number' => $p['passport'] ?? ($p['passport_number'] ?? null),
                    'passport_expiry' => $p['p_expiry'] ?? ($p['passport_expiry'] ?? null),
                    'nationality' => $p['nationality'] ?? null,
                    'extra_details' => json_encode($p)
                ]
            );
        }
    }

    /**
     * Check if a booking already exists for a reference or transaction
     */
    public function bookingExists($reference)
    {
        return Booking::where('booking_reference', $reference)->exists();
    }
}

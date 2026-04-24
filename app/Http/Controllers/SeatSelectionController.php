<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class SeatSelectionController extends Controller
{
    /**
     * Show the seat selection view with dynamic booking data.
     */
    public static function normalizeFlight($raw): array
    {
        if (!is_array($raw)) return [];

        $seg = $raw['itineraries'][0]['segments'][0] ?? null;
        $lastSeg = null;
        if (!empty($raw['itineraries'][0]['segments'])) {
            $lastSeg = end($raw['itineraries'][0]['segments']);
        }

        return [
            'airline'        => $raw['airline'] ?? ($raw['carrier'] ?? ($seg['carrierCode'] ?? 'N/A')),
            'flight_number'  => $raw['flight_number'] ?? ($raw['number'] ?? ($seg ? ($seg['carrierCode'] . $seg['number']) : 'N/A')),
            'dep_city'       => $raw['from'] ?? ($raw['departure_city'] ?? ($seg['departure']['iataCode'] ?? '???')),
            'arr_city'       => $raw['to'] ?? ($raw['arrival_city'] ?? ($lastSeg['arrival']['iataCode'] ?? '???')),
            'departure_at'   => $raw['departure_at'] ?? ($seg['departure']['at'] ?? null),
            'arrival_at'     => $raw['arrival_at'] ?? ($lastSeg['arrival']['at'] ?? null),
            'duration'       => $raw['duration'] ?? ($raw['itineraries'][0]['duration'] ?? null),
            'price'          => $raw['price'] ?? ($raw['total_price'] ?? 0),
        ];
    }

    public function index(Request $request)
    {
        $reference = $request->input('reference');
        $mode      = $request->input('mode');
        $booking   = null;

        if ($mode === 'pending' && str_starts_with($reference ?? '', 'TEMP-')) {
            $pendingData = session('pending_traveler_booking', []);

            if (empty($pendingData)) {
                return redirect()->route('flights.index')->with('error', 'Session expired. Please search again.');
            }

            $rawItem = $pendingData['item_data'];
            if (is_string($rawItem)) $rawItem = json_decode($rawItem, true);

            $normalizedFlight = self::normalizeFlight($rawItem ?? []);
            $legs = [$normalizedFlight];

            $travelers = $pendingData['travelers'] ?? [];

            $fakeTotalAmount = $pendingData['total_amount'] ?? 0;

            $fakeBooking = new \stdClass();
            $fakeBooking->booking_reference = $reference;
            $fakeBooking->total_amount      = $fakeTotalAmount;
            $fakeBooking->api_booking_details = null;
            $fakeBooking->items = collect([]);

            return view('seat-selection', [
                'booking'    => $fakeBooking,
                'passengers' => $travelers,
                'flight'     => $normalizedFlight,
                'legs'       => $legs,
                'reference'  => $reference,
            ]);
        }

        if ($reference) {
            $booking = Booking::with('items')->where('booking_reference', $reference)->first();
        }

        if (!$booking && auth()->check()) {
            $booking = Booking::with('items')
                ->where('user_id', auth()->id())
                ->where('status', 'confirmed')
                ->latest()
                ->first();
        }

        if (!$booking) {
            return redirect()->route('flights.index')->with('error', 'Booking session not found.');
        }

        $passengers = [];
        $flight = null;
        $legs = [];
        if ($booking->api_booking_details) {
            $apiData = json_decode($booking->api_booking_details, true);
            $rawFlight = $apiData['item_data'] ?? ($apiData['item'] ?? null);

            if (is_array($rawFlight)) {
                if (isset($rawFlight[0]) && is_array($rawFlight[0])) {
                    $legs = array_map([self::class, 'normalizeFlight'], $rawFlight);
                    $flight = $legs[0];
                } else {
                    $flight = self::normalizeFlight($rawFlight);
                    $legs = [$flight];
                }
            }
        }

        foreach ($booking->items as $item) {
            $details = json_decode($item->details, true);
            if (is_array($details)) {
                $passengers[] = $details;
            }
        }

        if (empty($passengers) && $booking->api_booking_details) {
            $apiData   = json_decode($booking->api_booking_details, true);
            $travelers = $apiData['travelers'] ?? [];
            foreach ($travelers as $traveler) {
                if (is_array($traveler)) {
                    $passengers[] = $traveler;
                }
            }
        }

        return view('seat-selection', [
            'booking'    => $booking,
            'passengers' => $passengers,
            'flight'     => $flight,
            'legs'       => $legs,
            'reference'  => $booking->booking_reference
        ]);
    }

    /**
     * Show the add-ons / ancillaries view with dynamic booking data.
     */
    public function customize(Request $request)
    {
        $reference = $request->input('reference');
        $booking   = null;

        if (str_starts_with($reference ?? '', 'TEMP-')) {
            $pendingData = session('pending_traveler_booking', []);

            if (empty($pendingData)) {
                return redirect()->route('flights.index')->with('error', 'Session expired. Please search again.');
            }

            $rawItem = $pendingData['item_data'];
            if (is_string($rawItem)) $rawItem = json_decode($rawItem, true);

            $normalizedFlight = self::normalizeFlight($rawItem ?? []);
            $travelers        = $pendingData['travelers'] ?? [];

            $fakeBooking = new \stdClass();
            $fakeBooking->booking_reference  = $reference;
            $fakeBooking->total_amount       = $pendingData['total_amount'] ?? 0;
            $fakeBooking->api_booking_details = null;
            $fakeBooking->items = collect([]);

            return view('add-ons', [
                'booking'    => $fakeBooking,
                'passengers' => $travelers,
                'flight'     => $normalizedFlight,
                'reference'  => $reference,
            ]);
        }

        if ($reference) {
            $booking = Booking::with('items')->where('booking_reference', $reference)->first();
        }

        if (!$booking && auth()->check()) {
            $booking = Booking::with('items')
                ->where('user_id', auth()->id())
                ->where('status', 'confirmed')
                ->latest()
                ->first();
        }

        if (!$booking) {
            return redirect()->route('flights.index')->with('error', 'Booking session not found.');
        }

        $passengers = [];
        $flight = null;
        if ($booking->api_booking_details) {
            $apiData = json_decode($booking->api_booking_details, true);
            $rawFlight = $apiData['item_data'] ?? ($apiData['item'] ?? null);
            if (is_array($rawFlight) && isset($rawFlight[0]) && is_array($rawFlight[0])) {
                $rawFlight = $rawFlight[0];
            }
            $flight = self::normalizeFlight($rawFlight ?? []);
        }

        foreach ($booking->items as $item) {
            $details = json_decode($item->details, true);
            if (is_array($details)) {
                $passengers[] = isset($details['first_name']) ? $details : array_values($details);
            }
        }
        $passengers = array_filter(array_map(fn($p) => is_array($p) && isset($p['first_name']) ? $p : null, $passengers));

        if (empty($passengers) && $booking->api_booking_details) {
            $apiData    = json_decode($booking->api_booking_details, true);
            $passengers = array_filter($apiData['travelers'] ?? [], fn($t) => is_array($t));
        }

        return view('add-ons', [
            'booking'    => $booking,
            'passengers' => array_values($passengers),
            'flight'     => $flight,
            'reference'  => $booking->booking_reference
        ]);
    }
}

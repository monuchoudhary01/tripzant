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

        // If 'itineraries' is present at root, this is a full flight offer. 
        // We use the first one by default if called directly, but usually we map over them.
        $itinerary = $raw['itineraries'][0] ?? $raw; 
        $segments = $itinerary['segments'] ?? ($raw['segments'] ?? []);
        
        $seg = $segments[0] ?? null;
        $lastSeg = !empty($segments) ? end($segments) : null;

        // Extract cabin from segment if available
        $cabin = 'ECONOMY';
        if ($seg && isset($seg['cabin'])) $cabin = $seg['cabin'];
        elseif (isset($raw['cabin'])) $cabin = $raw['cabin'];

        return [
            'airline'        => $raw['airline'] ?? ($raw['carrier'] ?? ($seg['carrierCode'] ?? 'N/A')),
            'flight_number'  => $raw['flight_number'] ?? ($raw['number'] ?? ($seg ? ($seg['carrierCode'] . $seg['number']) : 'N/A')),
            'dep_city'       => $raw['dep_city'] ?? ($raw['from'] ?? ($raw['departure_city'] ?? ($seg['departure']['iataCode'] ?? '???'))),
            'arr_city'       => $raw['arr_city'] ?? ($raw['to'] ?? ($raw['arrival_city'] ?? ($lastSeg['arrival']['iataCode'] ?? '???'))),
            'departure_at'   => $raw['departure_at'] ?? ($seg['departure']['at'] ?? null),
            'arrival_at'     => $raw['arrival_at'] ?? ($lastSeg['arrival']['at'] ?? null),
            'duration'       => $raw['duration'] ?? ($itinerary['duration'] ?? null),
            'price'          => $raw['price'] ?? ($raw['total_price'] ?? 0),
            'cabin'          => $cabin,
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

            // Handle potential 'data' wrapper from Amadeus responses
            $offer = $rawItem['data'] ?? $rawItem;

            // Extract multiple legs for Round-trip / Multi-city / Split Mode
            $legs = [];
            if (isset($offer[0]) && is_array($offer[0])) {
                // Split Mode: Array of multiple flights
                $legs = array_map([self::class, 'normalizeFlight'], $offer);
            } elseif (isset($offer['itineraries']) && is_array($offer['itineraries'])) {
                // Single offer with multiple itineraries
                foreach ($offer['itineraries'] as $itinerary) {
                    // Create a pseudo-offer for each itinerary to reuse normalization
                    $pseudoOffer = array_merge($offer, ['itineraries' => [$itinerary]]);
                    $legs[] = self::normalizeFlight($pseudoOffer);
                }
            } else {
                $legs = [self::normalizeFlight($offer ?? [])];
            }

            $normalizedFlight = $legs[0] ?? [];
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
                $offer = $rawFlight['data'] ?? $rawFlight;

                if (isset($rawFlight[0]) && is_array($rawFlight[0])) {
                    // Split mode or explicit legs array
                    $legs = array_map([self::class, 'normalizeFlight'], $rawFlight);
                } elseif (isset($offer['itineraries'])) {
                    // Single offer with multiple itineraries
                    foreach ($offer['itineraries'] as $itinerary) {
                        $pseudoOffer = array_merge($offer, ['itineraries' => [$itinerary]]);
                        $legs[] = self::normalizeFlight($pseudoOffer);
                    }
                } else {
                    $legs = [self::normalizeFlight($offer)];
                }
                $flight = $legs[0] ?? null;
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
            $travelers = $pendingData['travelers'] ?? [];

            $fakeBooking = new \stdClass();
            $fakeBooking->booking_reference  = $reference;
            $fakeBooking->total_amount       = $pendingData['total_amount'] ?? 0;
            $fakeBooking->api_booking_details = null;
            $fakeBooking->items = collect([]);

            // Extract legs for summary
            $offer = $rawItem['data'] ?? $rawItem;
            $legs = [];
            if (isset($offer[0]) && is_array($offer[0])) {
                // Split Mode: Array of multiple flights
                $legs = array_map([self::class, 'normalizeFlight'], $offer);
            } elseif (isset($offer['itineraries']) && is_array($offer['itineraries'])) {
                foreach ($offer['itineraries'] as $itinerary) {
                    $pseudoOffer = array_merge($offer, ['itineraries' => [$itinerary]]);
                    $legs[] = self::normalizeFlight($pseudoOffer);
                }
            } else {
                $legs = [self::normalizeFlight($offer ?? [])];
            }

            return view('add-ons', [
                'booking'    => $fakeBooking,
                'passengers' => $travelers,
                'flight'     => $legs[0] ?? [],
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
                $offer = $rawFlight['data'] ?? $rawFlight;

                if (isset($offer['itineraries'])) {
                    foreach ($offer['itineraries'] as $itinerary) {
                        $pseudoOffer = array_merge($offer, ['itineraries' => [$itinerary]]);
                        $legs[] = self::normalizeFlight($pseudoOffer);
                    }
                } elseif (isset($rawFlight[0]) && is_array($rawFlight[0])) {
                    $legs = array_map([self::class, 'normalizeFlight'], $rawFlight);
                } else {
                    $legs = [self::normalizeFlight($offer)];
                }
            }
            $flight = $legs[0] ?? null;
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
            'legs'       => $legs,
            'reference'  => $booking->booking_reference
        ]);
    }
}

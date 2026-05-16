<?php

namespace App\Services;

class FlightService
{
    protected $amadeus;
    protected $markupService;

    public function __construct(AmadeusService $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * Flight Inspiration Search (Show prices on map)
     */
    public function inspirationSearch($origin, $maxPrice = null)
    {
        $params = [];
        if ($maxPrice) $params['maxPrice'] = $maxPrice;

        $response = $this->amadeus->flightInspirationSearch($origin, $params);

        if (isset($response['error'])) {
            return ['success' => false, 'error' => $response['message'] ?? 'API Error'];
        }

        return [
            'success' => true,
            'data' => $response['data'] ?? []
        ];
    }

    /**
     * Search Flights across Amadeus
     */
    public function search($params)
    {
        // Harden against array inputs (common in Multi-city)
        $from = is_array($params['from'] ?? null) ? ($params['from'][0] ?? 'DEL') : ($params['from'] ?? 'DEL');
        $to = is_array($params['to'] ?? null) ? ($params['to'][0] ?? 'BOM') : ($params['to'] ?? 'BOM');
        $date = is_array($params['date'] ?? null) ? ($params['date'][0] ?? date('Y-m-d')) : ($params['date'] ?? date('Y-m-d'));

        $queryParams = [
            'originLocationCode' => $from,
            'destinationLocationCode' => $to,
            'departureDate' => $date,
            'adults' => $params['adults'] ?? 1,
            'max' => 10, // Max 10 for Sandbox stability
        ];

        if (!empty($params['children'])) $queryParams['children'] = $params['children'];
        if (!empty($params['infants'])) $queryParams['infants'] = $params['infants'];
        if (!empty($params['cabin'])) $queryParams['travelClass'] = strtoupper($params['cabin']);

        $response = $this->amadeus->get('/v2/shopping/flight-offers', $queryParams);

        if (isset($response['error'])) {
             \Log::error('Amadeus Search Error', ['params' => $queryParams, 'error' => $response]);
             return ['success' => false, 'data' => [], 'error' => $response['message'] ?? 'API Error', 'raw_data' => []];
        }

        $data = $response;
        if (!isset($data['data']) || empty($data['data'])) {
             return ['success' => true, 'data' => [], 'raw_data' => [], 'msg' => 'No flights found for this route/date on Amadeus.'];
        }
        
        if (isset($data['data']) && !empty($data['data'])) {
            // Apply markup using MarkupService if available, else simple fallback
            $markupPct = (float) config('tripzant.markups.b2c', 5);
            $grouped = [];
            
            foreach ($data['data'] as $offer) {
                $baseAmount = (float) $offer['price']['total'];
                $sellPrice = round($baseAmount * (1 + $markupPct / 100));
                
                $itineries = $offer['itineraries'][0] ?? null;
                $segments = $itineries['segments'] ?? [];
                $firstSeg = $segments[0] ?? null;
                $lastSeg = end($segments) ?? null;
                
                if (!$firstSeg) continue;
                
                // Create unique key for the flight
                $flightKey = ($firstSeg['carrierCode'] ?? '??') . ($firstSeg['number'] ?? 'XXX') . ($firstSeg['departure']['at'] ?? '000');
                
                $fareDetails = $offer['travelerPricings'][0]['fareDetailsBySegment'][0] ?? [];
                $class = $fareDetails['class'] ?? 'Y';
                $seats = $offer['numberOfBookableSeats'] ?? 9;

                $itineraryKey = $itineries['duration'] ?? 'PT0H0M';

                if (!isset($grouped[$flightKey])) {
                    $grouped[$flightKey] = [
                        'airline_code' => $offer['validatingAirlineCodes'][0] ?? ($firstSeg['carrierCode'] ?? '??'),
                        'airline' => $this->getAirlineName($offer['validatingAirlineCodes'][0] ?? ($firstSeg['carrierCode'] ?? '??')),
                        'flight_number' => $firstSeg['number'] ?? 'XXX',
                        'departure_at' => $firstSeg['departure']['at'] ?? null,
                        'arrival_at' => $lastSeg['arrival']['at'] ?? null,
                        'price' => $sellPrice, // Cheapest so far
                        'net_price' => $baseAmount,
                        'currency' => $offer['price']['currency'],
                        'number_of_changes' => count($segments) - 1,
                        'duration' => $this->formatDuration($itineraryKey),
                        'fare_class' => $class,
                        'cabin' => $fareDetails['cabin'] ?? 'ECONOMY',
                        'baggage' => $fareDetails['includedCheckedBags']['weight'] ?? ($fareDetails['includedCheckedBags']['quantity'] ?? '15'),
                        'baggage_unit' => $fareDetails['includedCheckedBags']['weightUnit'] ?? 'KG',
                        'is_refundable' => !($offer['pricingOptions']['noRestrictionFare'] ?? false),
                        'dep_city' => $firstSeg['departure']['iataCode'] ?? '???',
                        'arr_city' => $lastSeg['arrival']['iataCode'] ?? '???',
                        'terminal' => $firstSeg['departure']['terminal'] ?? 'T1',
                        'inventory' => [],
                        'gds_id' => $offer['id'], // Primary ID
                        'source' => 'amadeus'
                    ];
                }
                
                // Add this class to inventory if not already present
                $exists = false;
                foreach($grouped[$flightKey]['inventory'] as $inv) {
                    if($inv['class'] == $class) { $exists = true; break; }
                }
                if(!$exists) {
                    $grouped[$flightKey]['inventory'][] = [
                        'class' => $class,
                        'seats' => $seats,
                        'price' => $sellPrice,
                        'gds_id' => $offer['id']
                    ];
                }

                // Keep lowest price as main price
                if ($sellPrice < $grouped[$flightKey]['price']) {
                    $grouped[$flightKey]['price'] = $sellPrice;
                    $grouped[$flightKey]['net_price'] = $baseAmount;
                    $grouped[$flightKey]['fare_class'] = $class;
                    $grouped[$flightKey]['gds_id'] = $offer['id'];
                }
            }
            
            // Convert grouped to sequential array
            $formatted = array_values($grouped);
            $data['raw_data'] = $data['data']; // Keep original for pricing/booking calls
            $data['data'] = $formatted;
        }

        return $data;
    }

    public function getAirlineName($code)
    {
        $airlines = [
            '6E' => 'IndiGo', 'UK' => 'Vistara', 'AI' => 'Air India',
            'SG' => 'SpiceJet', 'QP' => 'Akasa Air', 'IX' => 'Air India Express',
            'I5' => 'AirAsia India', 'G8' => 'Go First', 'AA' => 'American Airlines',
            'EK' => 'Emirates', 'QR' => 'Qatar Airways', 'EY' => 'Etihad',
            'SQ' => 'Singapore Airlines', 'LH' => 'Lufthansa', 'AF' => 'Air France',
            'BA' => 'British Airways', 'DL' => 'Delta Airlines', 'UA' => 'United Airlines',
        ];

        return $airlines[$code] ?? $code;
    }

    public function formatDuration($duration)
    {
        return str_replace(['PT', 'H', 'M'], ['', 'h ', 'm'], $duration);
    }

    /**
     * Get Detailed Pricing & Fare Rules
     */
    public function getFlightPrice($flightOffer)
    {
        return $this->amadeus->post('/v1/shopping/flight-offers/pricing', [
            'data' => [
                'type' => 'flight-offers-pricing',
                'flightOffers' => [$flightOffer]
            ]
        ]);
    }

    /**
     * Create Flight Order (Final Booking)
     */
    public function createOrder($flightOffer, $travelers)
    {
        return $this->amadeus->post('/v1/booking/flight-orders', [
            'data' => [
                'type' => 'flight-order',
                'flightOffers' => [$flightOffer],
                'travelers' => $travelers
            ]
        ]);
    }
}

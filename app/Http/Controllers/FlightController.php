<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlightService;
use App\Services\AuditLogService;
use App\Services\PricingService;

class FlightController extends Controller
{
    protected $flightService;
    protected $hybridFlightService;

    public function __construct(FlightService $flightService, \App\Services\HybridFlightService $hybridFlightService)
    {
        $this->flightService = $flightService;
        $this->hybridFlightService = $hybridFlightService;
    }

    public function index(Request $request)
    {
        $multiCity = $request->input('multi_city') == '1';
        $tripType = $request->input('trip', 'oneway');
        
        if ($multiCity) {
            $origins = $request->input('origin', []);
            $destinations = $request->input('destination', []);
            $dates = $request->input('departure_date', []);
            
            // For general display/params, use first leg details
            $origin = is_array($origins) ? ($origins[0] ?? 'DEL') : $origins;
            $destination = is_array($destinations) ? (end($destinations) ?: 'BOM') : $destinations;
            $departureDate = is_array($dates) ? ($dates[0] ?? date('Y-m-d')) : $dates;
            $returnDate = null;
        } else {
            $origin = $request->input('origin', 'DEL');
            $destination = $request->input('destination', 'BOM');
            $departureDate = $request->input('departure_date', date('Y-m-d', strtotime('+7 days')));
            $returnDate = $request->input('return_date');
        }
        
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'departure_date' => $departureDate,
            'return_date' => $returnDate,
            'adults' => $request->input('adults', 1),
            'children' => $request->input('children', 0),
            'infants' => $request->input('infants', 0),
            'cabin_class' => $request->input('cabin_class', 'ECONOMY'),
        ];

        $allFlightsSorted = [];
        $allRawData = [];
        $allDictionaries = [];
        $isRoundTrip = ($tripType === 'round' || !empty($returnDate)) && !$multiCity;

        if ($multiCity) {
            $origins = $request->input('origin', []);
            $destinations = $request->input('destination', []);
            $dates = $request->input('departure_date', []);

            if (is_array($origins)) {
                foreach ($origins as $idx => $org) {
                    $legParams = [
                        'from' => $org,
                        'to' => $destinations[$idx] ?? 'BOM',
                        'date' => $dates[$idx] ?? date('Y-m-d'),
                        'adults' => $params['adults'],
                        'children' => $params['children'],
                        'infants' => $params['infants'],
                        'cabin' => $params['cabin_class']
                    ];
                    
                    $res = $this->hybridFlightService->search($legParams);
                    $flights = $res['data'] ?? [];
                    
                    // Aggregate raw data and dictionaries
                    if (isset($res['raw_data'])) $allRawData = array_merge($allRawData, $res['raw_data']);
                    if (isset($res['dictionaries'])) {
                        foreach ($res['dictionaries'] as $key => $values) {
                            $allDictionaries[$key] = array_merge($allDictionaries[$key] ?? [], $values);
                        }
                    }

                    foreach($flights as $f) { 
                        $f->segment_index = $idx; 
                    }
                    
                    $allFlightsSorted = array_merge($allFlightsSorted, array_map(fn($f) => $f->toArray(), $flights));
                }
            }
        } else {
            // LEG 0: Onward
            $onwardParams = [
                'from' => $origin,
                'to' => $destination,
                'date' => $departureDate,
                'adults' => $params['adults'],
                'children' => $params['children'],
                'infants' => $params['infants'],
                'cabin' => $params['cabin_class']
            ];
            $searchRes = $this->hybridFlightService->search($onwardParams);
            $onwardFlights = $searchRes['data'] ?? [];
            $metadata = $searchRes['meta'] ?? [];

            // Aggregate raw data and dictionaries
            if (isset($searchRes['raw_data'])) $allRawData = array_merge($allRawData, $searchRes['raw_data']);
            if (isset($searchRes['dictionaries'])) {
                foreach ($searchRes['dictionaries'] as $key => $values) {
                    $allDictionaries[$key] = array_merge($allDictionaries[$key] ?? [], $values);
                }
            }

            foreach ($onwardFlights as $of) {
                $of->segment_index = 0;
            }

            $allFlightsSorted = array_merge($allFlightsSorted, array_map(fn($f) => $f->toArray(), $onwardFlights));

            // LEG 1: Return (If applicable)
            if ($isRoundTrip && $returnDate) {
                $returnParams = $onwardParams;
                $returnParams['from'] = $destination;
                $returnParams['to'] = $origin;
                $returnParams['date'] = $returnDate;
                
                $returnRes = $this->hybridFlightService->search($returnParams);
                $returnFlights = $returnRes['data'] ?? [];
                
                // Aggregate raw data and dictionaries
                if (isset($returnRes['raw_data'])) $allRawData = array_merge($allRawData, $returnRes['raw_data']);
                if (isset($returnRes['dictionaries'])) {
                    foreach ($returnRes['dictionaries'] as $key => $values) {
                        $allDictionaries[$key] = array_merge($allDictionaries[$key] ?? [], $values);
                    }
                }

                if (isset($returnRes['meta'])) {
                    $metadata = array_merge_recursive($metadata, $returnRes['meta']);
                }
                foreach($returnFlights as $rf) { 
                    $rf->segment_index = 1; 
                }
                $allFlightsSorted = array_merge($allFlightsSorted, array_map(fn($f) => $f->toArray(), $returnFlights));
            }
        }

        // --- Cleaned: Mock Data Fallback Removed ---
        if (empty($allFlightsSorted)) {
            $currency = 'INR';
            $errorMessage = "No real-time flights found for this route currently.";
        } else {
            $currency = $allFlightsSorted[0]['currency'] ?? 'INR';
        }

        $prices = array_column($allFlightsSorted, 'price');
        $minPrice = count($prices) > 0 ? min($prices) : 0;
        $maxPrice = count($prices) > 0 ? max($prices) : 0;

        $stopCounts = ['Non Stop' => 0, '1 Stop' => 0, '2+ Stops' => 0];
        $airlinesFilter = [];
        $morningDeparturesCount = 0;
        $refundableCount = 0;
        $cabinCounts = ['ECONOMY' => 0, 'PREMIUM_ECONOMY' => 0, 'BUSINESS' => 0, 'FIRST' => 0];

        foreach ($allFlightsSorted as $f) {
            $cabin = strtoupper($f['cabin'] ?? 'ECONOMY');
            if (isset($cabinCounts[$cabin])) $cabinCounts[$cabin]++;
            
            $stops = (int)($f['stops'] ?? 0);
            if ($stops === 0) $stopCounts['Non Stop']++;
            elseif ($stops === 1) $stopCounts['1 Stop']++;
            else $stopCounts['2+ Stops']++;

            $airline = $f['airline'] ?? 'Other';
            if (!isset($airlinesFilter[$airline])) {
                $airlinesFilter[$airline] = ['count' => 1, 'min_price' => $f['price'] ?? 0];
            } else {
                $airlinesFilter[$airline]['count']++;
                if (($f['price'] ?? 0) < $airlinesFilter[$airline]['min_price']) $airlinesFilter[$airline]['min_price'] = $f['price'] ?? 0;
            }

            if (isset($f['departure_at'])) {
                $hour = (int) date('H', strtotime($f['departure_at']));
                if ($hour >= 6 && $hour < 12) $morningDeparturesCount++;
            }
            if (!empty($f['is_refundable'])) $refundableCount++;
        }

        $view = view('flight-listing', [
            'flights' => $allFlightsSorted,
            'params' => $params,
            'isRoundTrip' => $isRoundTrip,
            'isMultiCity' => $multiCity,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'stopCounts' => $stopCounts,
            'airlinesFilter' => $airlinesFilter,
            'morningDeparturesCount' => $morningDeparturesCount,
            'refundableCount' => $refundableCount,
            'cabinCounts' => $cabinCounts,
            'currency' => $currency,
            'travelDate' => $departureDate,
            'returnDate' => $returnDate,
            'error_message' => $errorMessage ?? null,
            'adults' => $params['adults'],
            'children' => $params['children'],
            'infants' => $params['infants'],
            'cabinClass' => $params['cabin_class'],
            'origin' => $origin,
            'destination' => $destination,
            'isGroupBooking' => ($params['adults'] + $params['children'] >= 10),
            'totalPassengers' => $params['adults'] + $params['children']
        ]);

        AuditLogService::log('Flight', 'Search', "Flight search from {$origin} to {$destination}", $params);

        // Final Aggregate Cache - Ensures all legs are available for details/checkout
        $finalResponse = [
            'success' => true,
            'data' => $allFlightsSorted,
            'raw_data' => $allRawData,
            'dictionaries' => $allDictionaries,
            'meta' => $metadata ?? []
        ];
        $cacheKey = 'flight_search_' . session()->getId();
        \Illuminate\Support\Facades\Cache::put($cacheKey, $finalResponse, now()->addMinutes(30));

        return $view;
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function details(Request $request)
    {
        $id = $request->input('id');
        
        $cacheKey = 'flight_search_' . session()->getId();
        $fullResult = \Illuminate\Support\Facades\Cache::get($cacheKey) ?: \Illuminate\Support\Facades\Cache::get('flight_search_full', []);
        $rawFlights = $fullResult['raw_data'] ?? [];
        
        // Handle dictionaries which might be in meta or root
        $dictionaries = $fullResult['dictionaries'] ?? ($fullResult['meta']['dictionaries'] ?? []);

        // Find the flight by ID in the raw data
        $flightOffer = collect($rawFlights)->first(function($item) use ($id) {
            $itemId = is_array($item) ? ($item['id'] ?? null) : ($item->id ?? null);
            return $itemId == $id;
        });

        if (!$flightOffer) {
            return response()->json(['error' => 'Flight selection expired. Please search again.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $flightOffer,
            'dictionaries' => (object)$dictionaries // Ensure it's an object in JSON
        ]);
    }

    public function book(Request $request)
    {
        $id = $request->input('id');
        $cacheKey = 'flight_search_' . session()->getId();
        $cachedResults = \Illuminate\Support\Facades\Cache::get($cacheKey) ?: \Illuminate\Support\Facades\Cache::get('flight_search_full', []);
        $rawFlights = $cachedResults['raw_data'] ?? [];
        
        $flightOffer = null;
        foreach ($rawFlights as $raw) {
            $rawId = is_object($raw) ? ($raw->id ?? null) : ($raw['id'] ?? null);
            if ($rawId == $id) {
                $flightOffer = is_object($raw) ? (array)$raw : $raw;
                break;
            }
        }

        if (!$flightOffer) {
            return response()->json(['error' => 'Flight selection expired. Please search again.'], 404);
        }

        $frontendTravelers = $request->input('travelers', []);
        if (empty($frontendTravelers)) {
            return response()->json(['error' => 'Passenger details are missing.'], 400);
        }

        // Map Frontend structured passengers to Amadeus format
        $amadeusTravelers = [];
        foreach ($frontendTravelers as $index => $t) {
            $amadeusTravelers[] = [
                'id' => (string) ($index + 1),
                'dateOfBirth' => $t['dob'] ?? '1990-01-01',
                'name' => [
                    'firstName' => strtoupper($t['first_name']),
                    'lastName' => strtoupper($t['last_name'])
                ],
                'gender' => strtoupper(substr($t['gender'] ?? 'MALE', 0, 4)),
                'contact' => [
                    'emailAddress' => $t['email'] ?? $request->user()->email ?? 'booking@tripzant.com',
                    'phones' => [[
                        'deviceType' => 'MOBILE',
                        'countryCallingCode' => '91',
                        'number' => $t['mobile'] ?? '9999999999'
                    ]]
                ],
                'documents' => [[
                    'documentType' => 'PASSPORT',
                    'birthPlace' => 'DELHI', // Standardized for demo
                    'issuanceCountry' => 'IN',
                    'expiryDate' => $t['p_expiry'] ?? '2030-01-01',
                    'number' => $t['passport'] ?? 'Z1234567',
                    'issuanceDate' => '2020-01-01',
                    'nationality' => 'IN',
                    'holder' => true
                ]]
            ];
        }

        // TravelPayouts usually redirects to their site, but if they hit book here, we should probably warn or redirect
        if (($flightOffer['source'] ?? '') === 'travelpayouts') {
             return response()->json(['error' => 'This flight must be booked via our partner site.', 'redirect' => $flightOffer['booking_link'] ?? '#'], 400);
        }

        // Process Amadeus Booking
        $orderResponse = $this->flightService->createOrder($flightOffer, $amadeusTravelers);

            if (isset($orderResponse['error']) || isset($orderResponse['errors'])) {
                return response()->json(['error' => 'Amadeus API Error: ' . json_encode($orderResponse['errors'])], 400);
            }

        $bookingData = $orderResponse['data'] ?? [];
        $pnr = $bookingData['associatedRecords'][0]['reference'] ?? ('PNR-' . rand(1000, 9000));

        // 2. Create Internal Record (Main Booking)
        $primaryContact = $frontendTravelers[0] ?? [];
        
        $booking = \App\Models\Booking::create([
            'user_id' => auth()->id() ?? null,
            'booking_type' => 'flight',
            'api_reference' => $pnr,
            'net_price' => $flightOffer['price']['total'] ?? 0,
            'selling_price' => $request->input('total_amount') ?? ($flightOffer['price']['total'] ?? 0),
            'payment_status' => 'confirmed',
            'contact_email' => $request->user()->email ?? null,
            'contact_phone' => $primaryContact['mobile'] ?? null,
            'booking_details' => json_encode([
                'flight' => $flightOffer,
                'is_affiliate' => false,
            ]),
            'api_response' => json_encode($bookingData),
            'status' => 'confirmed',
        ]);

        // 2a. Create Detailed Flight Booking Record
        $itineraries = $flightOffer['itineraries'][0] ?? [];
        $segments = $itineraries['segments'] ?? [];
        $firstSeg = $segments[0] ?? null;
        $lastSeg = end($segments) ?? null;

        \App\Models\FlightBooking::create([
            'booking_id' => $booking->id,
            'pnr' => $pnr,
            'airline_pnr' => $bookingData['associatedRecords'][1]['reference'] ?? $pnr, // Some GDS return 2 references
            'origin' => $firstSeg['departure']['iataCode'] ?? '???',
            'destination' => $lastSeg['arrival']['iataCode'] ?? '???',
            'departure_at' => isset($firstSeg['departure']['at']) ? date('Y-m-d H:i:s', strtotime($firstSeg['departure']['at'])) : null,
            'arrival_at' => isset($lastSeg['arrival']['at']) ? date('Y-m-d H:i:s', strtotime($lastSeg['arrival']['at'])) : null,
            'airline_code' => $firstSeg['carrierCode'] ?? '??',
            'flight_number' => $firstSeg['number'] ?? '000',
            'cabin_class' => $flightOffer['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] ?? 'ECONOMY',
            'itinerary_details' => json_encode($itineraries),
            'fare_rules' => json_encode($flightOffer['travelerPricings'][0]['fareDetailsBySegment'] ?? [])
        ]);

        // 2b. Create Passenger Records
        foreach ($frontendTravelers as $t) {
            \App\Models\Passenger::create([
                'booking_id' => $booking->id,
                'type' => $t['type'] ?? 'adult',
                'title' => $t['title'] ?? 'Mr',
                'first_name' => $t['first_name'],
                'last_name' => $t['last_name'],
                'dob' => $t['dob'] ?? null,
                'passport_number' => $t['passport'] ?? null,
                'passport_expiry' => $t['p_expiry'] ?? null,
                'extra_details' => json_encode($t)
            ]);
        }

        // 2c. Create Payment Record (Simulated Success)
        \App\Models\Payment::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id() ?? 0,
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'payment_gateway' => 'Razorpay', // Default for now
            'amount' => $booking->selling_price,
            'currency' => $flightOffer['price']['currency'] ?? 'INR',
            'status' => 'successful',
        ]);

        // 2d. Create Invoice
        \App\Models\Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => 'INV-' . date('Ymd') . '-' . $booking->id,
            'amount' => $booking->selling_price,
            'tax_amount' => $booking->selling_price * 0.18, // 18% GST simulation
            'status' => 'paid',
        ]);

        // Trigger Accounting Auto-Posting
        try {
            app(\App\Services\AccountingService::class)->postBookingEntries($booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Accounting Sync Failed: ' . $e->getMessage());
        }

        AuditLogService::log('Flight', 'Booking', "Flight booking created. PNR: {$pnr}", $request->all(), $orderResponse);

        // 3. Return booking reference for success page
        return response()->json([
            'success' => true,
            'booking_id' => $pnr
        ]);
    }

    private function getMockFlightOffer($id)
    {
        $isVueling = strpos($id, '2') !== false;
        return [
            'type' => 'flight-offer',
            'id' => $id,
            'source' => 'GDS',
            'lastTicketingDate' => date('Y-m-d', strtotime('+3 days')),
            'itineraries' => [
                [
                    'duration' => $isVueling ? 'PT3H30M' : 'PT2H30M',
                    'segments' => [
                        [
                            'departure' => [
                                'iataCode' => 'STN',
                                'terminal' => 'T1',
                                'at' => date('Y-m-d\T06:15:00'),
                            ],
                            'arrival' => [
                                'iataCode' => 'DBV',
                                'at' => date('Y-m-d\T09:45:00'),
                            ],
                            'carrierCode' => $isVueling ? 'VY' : 'W9',
                            'number' => $isVueling ? '6127' : '4452',
                            'aircraft' => ['code' => '32A'],
                            'duration' => 'PT2H30M',
                            'id' => '1',
                            'numberOfStops' => 0,
                        ]
                    ]
                ]
            ],
            'price' => [
                'currency' => 'INR',
                'total' => $isVueling ? '1250.00' : '946.00',
                'base' => $isVueling ? '1000.00' : '800.00',
            ],
            'travelerPricings' => [
                [
                    'travelerId' => '1',
                    'fareOption' => 'STANDARD',
                    'travelerType' => 'ADULT',
                    'price' => [
                        'currency' => 'INR',
                        'total' => $isVueling ? '1250.00' : '946.00',
                    ],
                    'fareDetailsBySegment' => [
                        [
                            'segmentId' => '1',
                            'cabin' => 'ECONOMY',
                            'fareBasis' => 'WEBOW',
                            'class' => 'W',
                            'includedCheckedBags' => ['weight' => 20, 'weightUnit' => 'KG']
                        ]
                    ]
                ]
            ]
        ];
    }

    public function mapSearch(Request $request)
    {
        $origin = $request->input('origin', 'DEL');
        $maxPrice = $request->input('maxPrice');

        $result = $this->flightService->inspirationSearch($origin, $maxPrice);

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $result['data']
        ]);
    }
    
    public function airportSearch(Request $request)
    {
        $keyword = $request->input('query');
        if (!$keyword) return response()->json([]);

        $result = app(\App\Services\AmadeusService::class)->locationSearch($keyword);

        if (isset($result['error'])) {
            // Mock fallback for autocomplete if API is down
            return response()->json([
                ['iataCode' => 'DEL', 'name' => 'Indira Gandhi International', 'address' => ['cityName' => 'Delhi']],
                ['iataCode' => 'BOM', 'name' => 'Chhatrapati Shivaji International', 'address' => ['cityName' => 'Mumbai']],
                ['iataCode' => 'LHR', 'name' => 'London Heathrow', 'address' => ['cityName' => 'London']],
            ]);
        }

        return response()->json($result['data'] ?? []);
    }
}

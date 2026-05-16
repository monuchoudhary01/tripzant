<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FlightService;
use App\Services\HybridFlightService;
use App\Services\TravelPayoutsFlightService;
use App\Services\PricingService;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Cache;

class FlightController extends Controller
{
    protected $flightService;
    protected $hybridFlightService;
    protected $tpService;
    protected $bookingService;

    public function __construct(
        FlightService $flightService, 
        HybridFlightService $hybridFlightService,
        TravelPayoutsFlightService $tpService,
        \App\Services\BookingService $bookingService
    ) {
        $this->flightService = $flightService;
        $this->hybridFlightService = $hybridFlightService;
        $this->tpService = $tpService;
        $this->bookingService = $bookingService;
    }

    public function priceCalendar(Request $request)
    {
        $params = [
            'from' => $request->input('origin', 'DEL'),
            'to' => $request->input('destination', 'BOM'),
            'date' => $request->input('departure_date', date('Y-m-d')),
        ];

        $months = $request->input('months', 4);
        $calendarData = $this->tpService->getCalendarRange($params, $months);

        // Apply markups
        foreach ($calendarData as $date => &$data) {
            $price = (float)($data['price'] ?? ($data['value'] ?? 0));
            if ($price > 0) {
                $pricing = PricingService::calculateSellingPrice($price, 'flight');
                $data['price'] = $pricing['selling_price'];
                $data['markup'] = $pricing['markup'];
                $data['currency'] = 'INR';
            }
        }

        return response()->json([
            'success' => true,
            'origin' => $params['from'],
            'destination' => $params['to'],
            'calendar' => $calendarData
        ]);
    }

    public function search(Request $request)
    {
        $multiCity = $request->input('multi_city') == '1';
        $tripType = $request->input('trip', 'oneway');
        
        $origin = $request->input('origin', 'DEL');
        $destination = $request->input('destination', 'BOM');
        $departureDate = $request->input('departure_date', date('Y-m-d', strtotime('+7 days')));
        $returnDate = $request->input('return_date');
        
        // Safety for mixed scalar/array inputs (common if multi-city form fields are partially present)
        if (is_array($origin)) $origin = reset($origin);
        if (is_array($destination)) $destination = reset($destination);
        if (is_array($departureDate)) $departureDate = reset($departureDate);
        if (is_array($returnDate)) $returnDate = reset($returnDate);
        
        $baggage = $request->input('baggage');
        if (is_array($baggage)) $baggage = reset($baggage);
        
        $paxCount = $request->input('pax_count');
        if (is_array($paxCount)) $paxCount = reset($paxCount);
        
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'departure_date' => $departureDate,
            'return_date' => $returnDate,
            'adults' => $request->input('adults', 1),
            'children' => $request->input('children', 0),
            'infants' => $request->input('infants', 0),
            'cabin_class' => $request->input('cabin_class', 'ECONOMY'),
            'trip_type' => $tripType,
            'multi_city' => $multiCity,
            'baggage' => $baggage
        ];

        $allFlightsSorted = [];
        $allRawData = [];
        $allDictionaries = [];

        if ($multiCity) {
            $origins = $request->input('origin', []);
            $destinations = $request->input('destination', []);
            $dates = $request->input('departure_date', []);

            if (is_array($origins)) {
                foreach ($origins as $idx => $org) {
                    $legParams = [
                        'from' => $org,
                        'to' => $destinations[$idx] ?? '',
                        'date' => $dates[$idx] ?? date('Y-m-d'),
                        'adults' => $params['adults'],
                        'children' => $params['children'],
                        'infants' => $params['infants'],
                        'cabin' => $params['cabin_class'],
                        'baggage' => $params['baggage']
                    ];
                    
                    $res = $this->hybridFlightService->search($legParams);
                    $flights = $res['data'] ?? [];
                    
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
            // Onward
            $onwardParams = [
                'from' => $origin,
                'to' => $destination,
                'date' => $departureDate,
                'adults' => $params['adults'],
                'children' => $params['children'],
                'infants' => $params['infants'],
                'cabin' => $params['cabin_class'],
                'baggage' => $params['baggage']
            ];
            $searchRes = $this->hybridFlightService->search($onwardParams);
            $onwardFlights = $searchRes['data'] ?? [];
            
            if (isset($searchRes['raw_data'])) $allRawData = array_merge($allRawData, $searchRes['raw_data']);
            if (isset($searchRes['dictionaries'])) {
                foreach ($searchRes['dictionaries'] as $key => $values) {
                    $allDictionaries[$key] = array_merge($allDictionaries[$key] ?? [], $values);
                }
            }

            foreach ($onwardFlights as $of) { $of->segment_index = 0; }
            $allFlightsSorted = array_merge($allFlightsSorted, array_map(fn($f) => $f->toArray(), $onwardFlights));

            // Return
            if (($tripType === 'round' || !empty($returnDate))) {
                $returnParams = $onwardParams;
                $returnParams['from'] = $destination;
                $returnParams['to'] = $origin;
                $returnParams['date'] = $returnDate;
                
                $returnRes = $this->hybridFlightService->search($returnParams);
                $returnFlights = $returnRes['data'] ?? [];
                
                if (isset($returnRes['raw_data'])) $allRawData = array_merge($allRawData, $returnRes['raw_data']);
                if (isset($returnRes['dictionaries'])) {
                    foreach ($returnRes['dictionaries'] as $key => $values) {
                        $allDictionaries[$key] = array_merge($allDictionaries[$key] ?? [], $values);
                    }
                }

                foreach($returnFlights as $rf) { $rf->segment_index = 1; }
                $allFlightsSorted = array_merge($allFlightsSorted, array_map(fn($f) => $f->toArray(), $returnFlights));
            }
        }

        // Cache for details/booking (Use auth id, session id, or IP + User Agent as fallback)
        $clientId = auth()->id() ?: (session()->isStarted() ? session()->getId() : md5($request->ip() . $request->userAgent()));
        $cacheKey = 'api_flight_search_' . $clientId;
        Cache::put($cacheKey, [
            'data' => $allFlightsSorted,
            'raw_data' => $allRawData,
            'dictionaries' => $allDictionaries
        ], now()->addMinutes(30));

        return response()->json([
            'success' => true,
            'flights' => $allFlightsSorted,
            'calendar' => $searchRes['meta']['calendar'] ?? [],
            'dictionaries' => $allDictionaries,
            'params' => $params
        ]);
    }

    public function details(Request $request, $id)
    {
        $clientId = auth()->id() ?: (session()->isStarted() ? session()->getId() : md5($request->ip() . $request->userAgent()));
        $cacheKey = 'api_flight_search_' . $clientId;
        $cached = \Illuminate\Support\Facades\Cache::get($cacheKey);
        
        if (!$cached) {
            return response()->json(['success' => false, 'message' => 'Search session expired.'], 404);
        }

        $flight = collect($cached['data'])->firstWhere('id', $id);
        
        if (!$flight) {
            return response()->json(['success' => false, 'message' => 'Flight not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'flight' => $flight,
            'dictionaries' => $cached['dictionaries']
        ]);
    }

    public function book(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'travelers' => 'required|array|min:1',
            'travelers.*.first_name' => 'required|string',
            'travelers.*.last_name' => 'required|string',
            'travelers.*.dob' => 'required|date',
            'travelers.*.gender' => 'required|in:MALE,FEMALE,OTHER,M,F',
        ]);

        $id = $request->input('id');
        $clientId = auth()->id() ?: (session()->isStarted() ? session()->getId() : md5($request->ip() . $request->userAgent()));
        $cacheKey = 'api_flight_search_' . $clientId;
        $cached = \Illuminate\Support\Facades\Cache::get($cacheKey);

        $flightOffer = null;
        if ($cached) {
            // 1. Try to find in the user's specific search result raw_data
            $flightOffer = collect($cached['raw_data'] ?? [])->first(function($item) use ($id) {
                $itemId = is_array($item) ? ($item['id'] ?? null) : ($item->id ?? null);
                return $itemId == $id;
            });

            if (!$flightOffer) {
                // Fallback to searching in the formatted 'data' array
                $flightOffer = collect($cached['data'] ?? [])->firstWhere('id', $id);
            }
        }

        // 2. GLOBAL FALLBACK: If not in session, try the universal flight_data cache (highly robust)
        if (!$flightOffer) {
            $flightOffer = \Illuminate\Support\Facades\Cache::get('flight_data_' . $id);
        }

        if (!$flightOffer) {
            return response()->json(['success' => false, 'message' => 'Search session expired. Please search again.'], 404);
        }

        // Standardize flight offer structure for Amadeus (Handles SOAP UnifiedFlight fallback)
        if (is_object($flightOffer)) {
            $flightOffer = method_exists($flightOffer, 'toArray') ? $flightOffer->toArray() : (array)$flightOffer;
        }

        if (isset($flightOffer['departure_city']) || !isset($flightOffer['itineraries'])) {
            $flightOffer = [
                'id' => $flightOffer['id'] ?? $id,
                'type' => 'flight-offer',
                'source' => $flightOffer['source'] ?? 'amadeus',
                'itineraries' => [
                    [
                        'duration' => $flightOffer['duration'] ?? 'PT2H',
                        'segments' => [
                            [
                                'departure' => [
                                    'iataCode' => $flightOffer['departure_city'] ?? ($flightOffer['from'] ?? '???'),
                                    'at' => $flightOffer['departure_at'] ?? '',
                                    'terminal' => $flightOffer['terminal'] ?? 'T1'
                                ],
                                'arrival' => [
                                    'iataCode' => $flightOffer['arrival_city'] ?? ($flightOffer['to'] ?? '???'),
                                    'at' => $flightOffer['arrival_at'] ?? ''
                                ],
                                'carrierCode' => $flightOffer['airline_code'] ?? '??',
                                'number' => $flightOffer['flight_number'] ?? '000',
                                'duration' => $flightOffer['duration'] ?? 'PT2H'
                            ]
                        ]
                    ]
                ],
                'price' => [
                    'currency' => $flightOffer['currency'] ?? 'INR',
                    'total' => $flightOffer['price'] ?? 0,
                    'base' => ($flightOffer['price'] ?? 0) * 0.8
                ],
                'travelerPricings' => [
                    [
                        'travelerId' => "1",
                        'fareOption' => "STANDARD",
                        'travelerType' => "ADULT",
                        'price' => [
                            'currency' => $flightOffer['currency'] ?? 'INR',
                            'total' => $flightOffer['price'] ?? 0,
                        ],
                        'fareDetailsBySegment' => [
                            [
                                'segmentId' => "1",
                                'cabin' => $flightOffer['cabin'] ?? 'ECONOMY',
                                'class' => 'Y',
                                'includedCheckedBags' => [
                                    'weight' => (int)str_replace(' KG', '', $flightOffer['baggage'] ?? '15'),
                                    'weightUnit' => 'KG'
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        // Map travelers to Amadeus format
        $travelers = $request->input('travelers');
        $amadeusTravelers = [];
        foreach ($travelers as $index => $t) {
            $amadeusTravelers[] = [
                'id' => (string)($index + 1),
                'dateOfBirth' => $t['dob'],
                'name' => [
                    'firstName' => strtoupper($t['first_name']),
                    'lastName' => strtoupper($t['last_name'])
                ],
                'gender' => strtoupper($t['gender'] == 'M' ? 'MALE' : ($t['gender'] == 'F' ? 'FEMALE' : $t['gender'])),
                'contact' => [
                    'emailAddress' => $t['email'] ?? auth()->user()->email ?? 'customer@tripzant.com',
                    'phones' => [[
                        'deviceType' => 'MOBILE',
                        'countryCallingCode' => '91',
                        'number' => $t['mobile'] ?? '9999999999'
                    ]]
                ]
            ];
        }

        // 1. Create Order via Amadeus
        $orderResponse = $this->flightService->createOrder($flightOffer, $amadeusTravelers);

        if (isset($orderResponse['errors']) || isset($orderResponse['error'])) {
            return response()->json([
                'success' => false, 
                'message' => $orderResponse['message'] ?? 'Amadeus Booking Failed', 
                'details' => $orderResponse['details'] ?? null,
                'errors' => $orderResponse['errors'] ?? []
            ], 400);
        }

        $bookingData = $orderResponse['data'] ?? [];
        $pnr = $bookingData['associatedRecords'][0]['reference'] ?? null;

        if (!$pnr) {
            return response()->json(['success' => false, 'message' => 'No PNR generated by airline.'], 400);
        }

        // 2. Persist to Database via BookingService
        $sessionData = [
            'type' => 'flight',
            'reference' => $pnr,
            'user_id' => auth()->id(),
            'total_amount' => $request->input('total_amount') ?? ($flightOffer['price']['total'] ?? 0),
            'currency' => $flightOffer['price']['currency'] ?? 'INR',
            'travelers' => $travelers,
            'item_data' => $flightOffer,
            'api_response' => $bookingData
        ];

        try {
            $booking = $this->bookingService->completeBooking(
                $sessionData, 
                'API-' . strtoupper(uniqid()), 
                'API_DIRECT', 
                $bookingData
            );

            AuditLogService::log('Flight', 'Booking', "API Flight booking created. PNR: {$pnr}", $request->all(), $orderResponse);

            return response()->json([
                'success' => true,
                'message' => 'Booking confirmed successfully.',
                'booking_id' => $booking->id,
                'pnr' => $pnr,
                'details' => $booking
            ]);

        } catch (\Exception $e) {
            \Log::error('API Booking Persistence Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Booking created on GDS but failed to save locally. Please contact support.',
                'pnr' => $pnr,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bookings(Request $request)
    {
        $bookings = auth()->user()->bookings()->where('booking_type', 'flight')->get();
        return response()->json(['success' => true, 'bookings' => $bookings]);
    }
}

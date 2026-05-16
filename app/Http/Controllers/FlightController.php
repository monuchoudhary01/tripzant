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
        $maxBudget = $request->input('max_budget');
        
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
            $origin = $request->input('origin');
            if (is_array($origin)) $origin = $origin[0] ?? 'DEL';
            else $origin = $origin ?? 'DEL';

            // Extract IATA code if in "City (IATA)" format
            if (preg_match('/\(([A-Z]{3})\)/', $origin, $matches)) {
                $origin = $matches[1];
            }

            $destination = $request->input('destination');
            if (is_array($destination)) $destination = $destination[0] ?? 'BOM';
            else $destination = $destination ?? 'BOM';

            // Extract IATA code if in "City (IATA)" format
            if (preg_match('/\(([A-Z]{3})\)/', $destination, $matches)) {
                $destination = $matches[1];
            }

            $departureDate = $request->input('departure_date');
            if (is_array($departureDate)) $departureDate = $departureDate[0] ?? date('Y-m-d', strtotime('+7 days'));
            else $departureDate = $departureDate ?? date('Y-m-d', strtotime('+7 days'));

            // Standardize Date Format (Handle "Wed, 20 May" or "2026-05-20")
            if ($departureDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $departureDate)) {
                try {
                    $departureDate = date('Y-m-d', strtotime($departureDate));
                } catch (\Exception $e) {
                    $departureDate = date('Y-m-d', strtotime('+7 days'));
                }
            }

            $returnDate = $request->input('return_date');
            if ($returnDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $returnDate) && $returnDate !== 'Add Return') {
                try {
                    $returnDate = date('Y-m-d', strtotime($returnDate));
                } catch (\Exception $e) {
                    $returnDate = null;
                }
            }
        }
        
        $cabinInput = $request->input('cabin_class', 'ECONOMY');
        $cabinMap = [
            'Economy' => 'ECONOMY',
            'Premium Economy' => 'PREMIUM_ECONOMY',
            'Premium' => 'PREMIUM_ECONOMY',
            'Business' => 'BUSINESS',
            'First' => 'FIRST'
        ];
        $cabinCode = $cabinMap[$cabinInput] ?? strtoupper(str_replace(' ', '_', $cabinInput));

        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'departure_date' => $departureDate,
            'return_date' => $returnDate,
            'adults' => $request->input('adults', 1),
            'children' => $request->input('children', 0),
            'infants' => $request->input('infants', 0),
            'cabin_class' => $cabinCode,
        ];

        $allFlightsSorted = [];
        $allRawData = [];
        $allDictionaries = [];
        $isRoundTrip = ($tripType === 'round' || !empty($returnDate)) && !$multiCity;
        $reqCurrency = strtoupper($request->route('currency') ?? session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD')));

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
                        'cabin' => $params['cabin_class'],
                        'currency' => $reqCurrency
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
                'cabin' => $params['cabin_class'],
                'currency' => $reqCurrency
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

        $totalBeforeBudget = count($allFlightsSorted);
        // Apply Max Budget Filter if present (Strict filtering for "Search by Budget" flow)
        if ($maxBudget) {
            $allFlightsSorted = array_filter($allFlightsSorted, function($f) use ($maxBudget) {
                return ($f['price'] ?? 0) <= $maxBudget;
            });
            $allFlightsSorted = array_values($allFlightsSorted);
        }

        $fareType = $request->input('fare_type', 'regular');
        if (!empty($allFlightsSorted) && in_array($fareType, ['student', 'senior'])) {
            $discount = ($fareType === 'student') ? 0.05 : 0.08;
            foreach ($allFlightsSorted as &$f) {
                $f['original_price'] = $f['price'];
                $f['price'] = $f['price'] * (1 - $discount);
                $f['fare_type_applied'] = $fareType;
            }
            usort($allFlightsSorted, function($a, $b) {
                return $a['price'] <=> $b['price'];
            });
        }

        if (empty($allFlightsSorted)) {
            $currency = $reqCurrency;
            if ($totalBeforeBudget > 0 && $maxBudget) {
                $errorMessage = "We found " . $totalBeforeBudget . " flights, but none were within your budget of ₹" . number_format($maxBudget) . ".";
                $isBudgetError = true;
            } else {
                $errorMessage = "No flights found for this route currently.";
                $isBudgetError = false;
            }
        } else {
            $currency = $allFlightsSorted[0]['currency'] ?? $reqCurrency;
            $isBudgetError = false;
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

        $bankOffers = \App\Models\Offer::where('is_active', true)->orderBy('sort_order')->get();

        $viewData = [
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
            'isBudgetError' => $isBudgetError ?? false,
            'fareType' => $fareType,
            'bankOffers' => $bankOffers,
            'adults' => $params['adults'],
            'children' => $params['children'],
            'infants' => $params['infants'],
            'cabinClass' => $params['cabin_class'],
            'origin' => $origin,
            'destination' => $destination,
            'isGroupBooking' => ($params['adults'] + $params['children'] >= 10),
            'totalPassengers' => $params['adults'] + $params['children'],
            'initialMaxBudget' => $maxBudget
        ];

        if ($request->mode === 'map') {
            $formatted = [];
            $airportCoords = [
                'BOM' => ['lat' => 19.0896, 'lng' => 72.8656],
                'DEL' => ['lat' => 28.5562, 'lng' => 77.1000],
                'BLR' => ['lat' => 13.1986, 'lng' => 77.7066],
                'MAA' => ['lat' => 12.9941, 'lng' => 80.1709],
                'HYD' => ['lat' => 17.2403, 'lng' => 78.4294],
                'CCU' => ['lat' => 22.6547, 'lng' => 88.4467],
                'GOI' => ['lat' => 15.3803, 'lng' => 73.8314],
                'AMD' => ['lat' => 23.0772, 'lng' => 72.6347],
                'COK' => ['lat' => 10.1520, 'lng' => 76.3920],
                'DXB' => ['lat' => 25.2532, 'lng' => 55.3657],
                'LHR' => ['lat' => 51.4700, 'lng' => -0.4543],
                'SIN' => ['lat' => 1.3644, 'lng' => 103.9915],
                'JFK' => ['lat' => 40.6413, 'lng' => -73.7781],
                'SFO' => ['lat' => 37.6213, 'lng' => -122.3790],
                'SYD' => ['lat' => -33.9399, 'lng' => 151.1753],
                'BKK' => ['lat' => 13.6898, 'lng' => 100.7501],
            ];
            
            foreach($allFlightsSorted as $index => $f) {
                $dest = $f['destination'] ?? $destination;
                $coords = $airportCoords[$dest] ?? [
                    'lat' => 20 + rand(-100, 100)/20,
                    'lng' => 78 + rand(-100, 100)/20
                ];
                
                $formatted[] = [
                    'id' => $f['id'] ?? ('f_' . $index),
                    'type' => 'flight',
                    'title' => ($f['airline_name'] ?? ($f['airline'] ?? 'Flight')) . ' to ' . $dest,
                    'airline_code' => $f['airline_code'] ?? '6E',
                    'airline_name' => $f['airline_name'] ?? ($f['airline'] ?? 'Airline'),
                    'dest_code' => $dest,
                    'origin_code' => $origin,
                    'meta' => date('d M H:i', strtotime($f['departure_at'] ?? $departureDate)) . ' | ' . ($f['airline'] ?? ''),
                    'price' => '₹' . number_format($f['price'] ?? 0, 0),
                    'price_raw' => $f['price'] ?? 0,
                    'departure_at' => $f['departure_at'] ?? $departureDate,
                    'arrival_at' => $f['arrival_at'] ?? null,
                    'departure_time' => isset($f['departure_at']) ? date('H:i', strtotime($f['departure_at'])) : '--:--',
                    'arrival_time' => isset($f['arrival_at']) ? date('H:i', strtotime($f['arrival_at'])) : '--:--',
                    'duration' => $f['duration'] ?? '',
                    'stops' => $f['stops'] ?? 0,
                    'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109c05e?q=80&w=400',
                    'lat' => $coords['lat'],
                    'lng' => $coords['lng'],
                    'is_direct' => ($f['stops'] ?? 0) == 0
                ];
            }
            
            $originCoord = $airportCoords[$origin] ?? ['lat' => 28.5562, 'lng' => 77.1000];

            return view('explore-map', [
                'dynamicFlights' => json_encode($formatted),
                'dynamicHotels' => json_encode([]),
                'dynamicTours' => json_encode([]),
                'flights' => $formatted,
                'origin' => $origin,
                'destination' => $destination,
                'departure_date' => $departureDate,
                'return_date' => $returnDate,
                'adults' => $params['adults'],
                'children' => $params['children'],
                'originCoords' => json_encode($originCoord),
                'activeTab' => 'flights'
            ]);
        }

        if ($multiCity) {
            $viewData['numSegments'] = count($origins);
            $viewData['multiCityOrigins'] = $origins;
            $viewData['multiCityDestinations'] = $destinations;
            $viewData['multiCityDates'] = $dates;
        }

        $view = view('flight-listing', $viewData);

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

    public function getFareClasses(Request $request)
    {
        $id = $request->input('id');
        $basePrice = (float) $request->input('price');
        
        $cabins = [
            'ECONOMY' => ['multiplier' => 1.0, 'name' => 'Economy', 'seats' => 9],
            'PREMIUM_ECONOMY' => ['multiplier' => 1.5, 'name' => 'Premium Economy', 'seats' => 4],
            'BUSINESS' => ['multiplier' => 3.2, 'name' => 'Business', 'seats' => 2],
            'FIRST' => ['multiplier' => 5.5, 'name' => 'First Class', 'seats' => 1]
        ];

        $results = [];
        foreach ($cabins as $code => $data) {
            $cabinPrice = $basePrice * $data['multiplier'];
            $results[$code] = [
                'regular' => round($cabinPrice),
                'student' => round($cabinPrice * 0.95),
                'senior' => round($cabinPrice * 0.92),
                'name' => $data['name'],
                'seats' => $data['seats']
            ];
        }

        return response()->json(['success' => true, 'fares' => $results]);
    }

    public function selectFare(Request $request)
    {
        try {
        $id        = $request->input('id');
        $price     = (float) $request->input('price');
        $cabin     = $request->input('cabin', 'ECONOMY');
        $fareType  = $request->input('fare_type', 'regular');

        // Patch the cached flight data so checkout reads the selected price
        $cacheKey  = 'flight_data_' . $id;
        $searchKey = 'flight_search_' . session()->getId();

        $existing = \Illuminate\Support\Facades\Cache::get($cacheKey);

        if (!$existing) {
            // Fall back to the search cache
            $fullResult = \Illuminate\Support\Facades\Cache::get($searchKey)
                       ?: \Illuminate\Support\Facades\Cache::get('flight_search_full', []);
            $rawFlights = $fullResult['data'] ?? [];
            foreach ($rawFlights as $flight) {
                $fid = is_object($flight) ? ($flight->id ?? null) : ($flight['id'] ?? null);
                if ($fid == $id) {
                    $existing = is_object($flight) ? $flight->toArray() : $flight;
                    break;
                }
            }
        }

        if ($existing) {
            // Update the price and cabin to what user selected in the modal
            $existing['price']       = $price;
            $existing['cabin']       = $cabin;
            $existing['fare_type']   = $fareType;
            // Also patch nested price array if it exists (Amadeus REST style)
            if (isset($existing['price']) && is_array($existing['price'])) {
                $existing['price']['total'] = $price;
            }
            \Illuminate\Support\Facades\Cache::put($cacheKey, $existing, now()->addMinutes(30));
        }

        return response()->json([
            'success'      => true,
            'redirect'     => route('checkout', ['type' => 'flight', 'id' => $id]),
            'selected_price' => $price,
            'cabin'        => $cabin,
        ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Flight Select Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function details(Request $request)
    {
        $id = $request->input('id');
        
        // 1. Try to fetch from individual flight cache (robust)
        $flightOffer = \Illuminate\Support\Facades\Cache::get('flight_data_' . $id);
        $dictionaries = [];

        if (!$flightOffer) {
            // 2. Fallback to session search results
            $cacheKey = 'flight_search_' . session()->getId();
            $fullResult = \Illuminate\Support\Facades\Cache::get($cacheKey) ?: \Illuminate\Support\Facades\Cache::get('flight_search_full', []);
            $rawFlights = $fullResult['raw_data'] ?? [];
            $dictionaries = $fullResult['dictionaries'] ?? ($fullResult['meta']['dictionaries'] ?? []);

            $flightOffer = collect($rawFlights)->first(function($item) use ($id) {
                $itemId = is_array($item) ? ($item['id'] ?? null) : ($item->id ?? null);
                return $itemId == $id;
            });
        }

        if (!$flightOffer) {
            return response()->json(['error' => 'Flight selection expired. Please search again.'], 404);
        }

        // Ensure it's an array for easier checking
        if (is_object($flightOffer)) {
            $flightOffer = method_exists($flightOffer, 'toArray') ? $flightOffer->toArray() : (array)$flightOffer;
        }

        if (isset($flightOffer['departure_city']) || !isset($flightOffer['itineraries'])) {
            $flightOffer = array_merge($flightOffer, [
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
                    'currency' => $flightOffer['currency'] ?? strtoupper(session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD'))),
                    'total' => $flightOffer['price'] ?? 0,
                    'base' => ($flightOffer['price'] ?? 0) * 0.8
                ],
                'travelerPricings' => [
                    [
                        'travelerId' => "1",
                        'fareOption' => "STANDARD",
                        'travelerType' => "ADULT",
                        'price' => [
                            'currency' => $flightOffer['currency'] ?? strtoupper(session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD'))),
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
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $flightOffer,
            'dictionaries' => (object)$dictionaries
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
                    'birthPlace' => 'DELHI',
                    'issuanceCountry' => 'IN',
                    'expiryDate' => $t['p_expiry'] ?? '2030-01-01',
                    'number' => $t['passport'] ?? 'Z1234567',
                    'issuanceDate' => '2020-01-01',
                    'nationality' => 'IN',
                    'holder' => true
                ]]
            ];
        }

        if (($flightOffer['source'] ?? '') === 'travelpayouts') {
             return response()->json(['error' => 'This flight must be booked via our partner site.', 'redirect' => $flightOffer['booking_link'] ?? '#'], 400);
        }

        // Process Amadeus Booking
        $orderResponse = $this->flightService->createOrder($flightOffer, $amadeusTravelers);

        if (isset($orderResponse['error']) || isset($orderResponse['errors'])) {
            return response()->json(['error' => 'Amadeus API Error: ' . json_encode($orderResponse['errors'] ?? $orderResponse['error'])], 400);
        }

        $bookingData = $orderResponse['data'] ?? [];
        $pnr = $bookingData['associatedRecords'][0]['reference'] ?? null;
        
        if (!$pnr) {
            return response()->json(['error' => 'Booking failed: No PNR returned from airline.'], 400);
        }

        // 2. Create Internal Record (Main Booking)
        $primaryContact = $frontendTravelers[0] ?? [];
        
        $booking = \App\Models\Booking::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'flight',
            'booking_reference' => $pnr,
            'total_amount' => $request->input('total_amount') ?? ($flightOffer['price']['total'] ?? 0),
            'currency' => $flightOffer['price']['currency'] ?? 'INR',
            'status' => 'confirmed',
            'api_booking_details' => json_encode([
                'flight' => $flightOffer,
                'contact' => $primaryContact,
                'is_affiliate' => false,
            ]),
        ]);

        // 2a. Create Detailed Flight Booking Record
        $allItineraries = $flightOffer['itineraries'] ?? [];
        $firstItinerary = $allItineraries[0] ?? [];
        $lastItinerary = end($allItineraries) ?? $firstItinerary;
        
        $firstSegments = $firstItinerary['segments'] ?? [];
        $lastSegments = $lastItinerary['segments'] ?? $firstSegments;
        
        $firstSeg = $firstSegments[0] ?? null;
        $lastSeg = end($lastSegments) ?? null;

        \App\Models\FlightBooking::create([
            'booking_id' => $booking->id,
            'pnr' => $pnr,
            'airline_pnr' => $bookingData['associatedRecords'][1]['reference'] ?? $pnr,
            'origin' => $firstSeg['departure']['iataCode'] ?? '???',
            'destination' => $lastSeg['arrival']['iataCode'] ?? '???',
            'departure_at' => isset($firstSeg['departure']['at']) ? date('Y-m-d H:i:s', strtotime($firstSeg['departure']['at'])) : null,
            'arrival_at' => isset($lastSeg['arrival']['at']) ? date('Y-m-d H:i:s', strtotime($lastSeg['arrival']['at'])) : null,
            'airline_code' => $firstSeg['carrierCode'] ?? '??',
            'flight_number' => $firstSeg['number'] ?? '000',
            'cabin_class' => $flightOffer['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] ?? 'ECONOMY',
            'itinerary_details' => json_encode($allItineraries), // Save ALL itineraries for round-trip/multi-city
            'fare_details' => json_encode($flightOffer['travelerPricings'][0]['fareDetailsBySegment'] ?? [])
        ]);

        // 2b. Create Passenger Records
        foreach ($frontendTravelers as $t) {
            \App\Models\Passenger::create([
                'booking_id' => $booking->id,
                'type' => $t['type'] ?? 'adult',
                'title' => $t['title'] ?? 'Mr',
                'first_name' => $t['first_name'],
                'last_name' => $t['last_name'],
                'gender' => $t['gender'] ?? null,
                'dob' => $t['dob'] ?? null,
                'passport_number' => $t['passport'] ?? null,
                'passport_expiry' => $t['p_expiry'] ?? null,
                'nationality' => $t['nationality'] ?? null,
                'extra_details' => json_encode($t)
            ]);
        }

        // 2c. Create Payment Record (Simulated Success)
        \App\Models\Payment::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id() ?? 0,
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'payment_gateway' => 'Razorpay', // Default for now
            'amount' => $booking->total_amount,
            'currency' => $flightOffer['price']['currency'] ?? 'INR',
            'status' => 'successful',
        ]);

        // 2d. Create Invoice
        \App\Models\Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => 'INV-' . date('Ymd') . '-' . $booking->id,
            'amount' => $booking->total_amount,
            'tax_amount' => $booking->total_amount * 0.18, // 18% GST simulation
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
            return response()->json([]);
        }

        return response()->json($result['data'] ?? []);
    }
}

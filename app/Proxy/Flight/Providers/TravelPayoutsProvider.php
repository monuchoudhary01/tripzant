<?php

namespace App\Proxy\Flight\Providers;

use App\Proxy\Flight\FlightProvider;
use App\Proxy\Flight\UnifiedFlight;
use App\Services\TravelPayoutsFlightService;

class TravelPayoutsProvider implements FlightProvider
{
    protected $tpService;

    public function __construct(TravelPayoutsFlightService $tpService)
    {
        $this->tpService = $tpService;
    }

    public function getName(): string { return 'travelpayouts'; }
    public function supportsBooking(): bool { return false; }

    public function search(array $params): array
    {
        try {
            $results = $this->tpService->search($params);
            $flights = $results['data'] ?? [];
            $calendarData = $results['calendar'] ?? [];
            
            $unified = [];
            foreach ($flights as $f) {
                $fId = $f['id'] ?? uniqid('tp_');
                $f['id'] = $fId; // Inject into raw data for cache lookup
                
                // Create a mock Amadeus-style structure for raw_data to satisfy the UI modal
                $mockRaw = array_merge($f, [
                    'itineraries' => [
                        [
                            'duration' => $f['duration'] ?? '2h 00m',
                            'segments' => [
                                [
                                    'departure' => [
                                        'iataCode' => $params['from'] ?? '???',
                                        'at' => $f['departure_at'] ?? null,
                                        'terminal' => $f['terminal'] ?? '1'
                                    ],
                                    'arrival' => [
                                        'iataCode' => $params['to'] ?? '???',
                                        'at' => $f['arrival_at'] ?? null,
                                        'terminal' => $f['terminal'] ?? '1'
                                    ],
                                    'carrierCode' => $f['airline_code'] ?? 'TP',
                                    'number' => $f['flight_number'] ?? '000',
                                    'duration' => $f['duration'] ?? '2h 00m'
                                ]
                            ]
                        ]
                    ],
                    'price' => [
                        'total' => $f['price'],
                        'base' => $f['net_price'] ?? ($f['price'] * 0.9),
                        'currency' => $f['currency'] ?? 'INR'
                    ],
                    'travelerPricings' => [
                        [
                            'fareDetailsBySegment' => [
                                [
                                    'cabin' => $f['cabin'] ?? 'ECONOMY',
                                    'class' => 'Y',
                                    'includedCheckedBags' => [
                                        'weight' => $f['baggage'] ?? '15',
                                        'weightUnit' => $f['baggage_unit'] ?? 'KG'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'pricingOptions' => [
                        'noRestrictionFare' => $f['is_refundable'] ?? true
                    ]
                ]);

                $unified[] = new UnifiedFlight([
                    'id' => $fId,
                    'airline_code' => $f['airline_code'] ?? 'TP',
                    'airline_name' => $f['airline'] ?? 'TravelPayouts',
                    'flight_number' => $f['flight_number'] ?? '000',
                    'departure_at' => $f['departure_at'] ?? null,
                    'arrival_at' => $f['arrival_at'] ?? null,
                    'departure_city' => $params['from'] ?? '???',
                    'arrival_city' => $params['to'] ?? '???',
                    'duration' => $f['duration'] ?? '2h 00m',
                    'stops' => $f['number_of_changes'] ?? 0,
                    'price' => (float) $f['price'],
                    'net_price' => (float) ($f['net_price'] ?? $f['price']),
                    'currency' => $f['currency'] ?? 'INR',
                    'cabin' => $f['cabin'] ?? 'ECONOMY',
                    'baggage' => $f['baggage'] ?? '15',
                    'baggage_unit' => $f['baggage_unit'] ?? 'KG',
                    'terminal' => $f['terminal'] ?? 'T1',
                    'booking_class' => $f['class'] ?? 'Y',
                    'seats_available' => $f['seats_left'] ?? 9,
                    'source' => 'travelpayouts',
                    'raw_data' => $mockRaw
                ]);
            }
            
            return [
                'flights' => $unified,
                'meta' => ['calendar' => $calendarData]
            ];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('TravelPayoutsProvider Search Error: ' . $e->getMessage());
            return ['flights' => [], 'meta' => []];
        }
    }
}

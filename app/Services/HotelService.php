<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\HotelBooking;
use App\Models\HotelSearchLog;

class HotelService
{
    protected $baseUrl;
    protected $apiKey;
    protected $secret;

    public function __construct()
    {
        // Read credentials from database (global_settings), fallback to config/.env
        $settings = \App\Models\GlobalSetting::where('group', 'api_credentials')->get()->pluck('value', 'key');
        
        $env = $settings['hotelbeds_api_env'] ?? config('services.hotelbeds.env', 'test');
        $this->baseUrl = ($env === 'production') 
                        ? 'https://api.hotelbeds.com/hotel-api/1.0' 
                        : 'https://api.test.hotelbeds.com/hotel-api/1.0';
        
        $this->apiKey = $settings['hotelbeds_api_key'] ?? config('services.hotelbeds.key');
        $this->secret = $settings['hotelbeds_api_secret'] ?? config('services.hotelbeds.secret');
    }

    protected function getHeaders()
    {
        $timestamp = time();
        $signature = hash("sha256", $this->apiKey . $this->secret . $timestamp);

        return [
            'Api-key' => $this->apiKey,
            'X-Signature' => $signature,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Search Hotels via HotelBeds APItude
     */
    public function search($params)
    {
        $destinationCode = $params['destinationCode'] ?? 'DXB';
        $checkIn = $params['checkIn'] ?? date('Y-m-d', strtotime('+7 days'));
        $checkOut = $params['checkOut'] ?? date('Y-m-d', strtotime('+8 days'));

        $paxes = [];
        $childCount = (int)($params['children'] ?? 0);
        for ($i = 0; $i < $childCount; $i++) {
            $paxes[] = ['type' => 'CH', 'age' => 8];
        }

        $payload = [
            'stay' => [
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
            ],
            'occupancies' => [
                [
                    'rooms' => (int)($params['rooms'] ?? 1),
                    'adults' => (int)($params['adults'] ?? 2),
                    'children' => $childCount,
                    'paxes' => $paxes
                ]
            ],
            'destination' => [
                'code' => $destinationCode
            ]
        ];

        // Log search
        if (class_exists('App\\Models\\HotelSearchLog')) {
            HotelSearchLog::create([
                'user_id' => Auth::id(),
                'city_name' => $params['city_name'] ?? null,
                'destination_code' => $destinationCode,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'rooms' => $params['rooms'] ?? 1,
                'adults' => $params['adults'] ?? 2,
                'children' => $params['children'] ?? 0,
                'search_params' => json_encode($params),
            ]);
        }

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/hotels", $payload);

            if ($response->failed()) {
                Log::error('HotelBeds Search Error', [
                    'status' => $response->status(),
                    'res' => $response->body(),
                    'payload' => $payload,
                    'headers' => $this->getHeaders()
                ]);

                // Fallback to Mock Data in Test Env if Quota Exceeded
                $env = \App\Models\GlobalSetting::where('key', 'hotelbeds_api_env')->first()->value ?? 'test';
                if ($env === 'test' || $response->status() == 403) {
                    return $this->getMockSearch($destinationCode);
                }

                return ['hotels' => ['hotels' => []], 'is_mock' => false, 'error' => true, 'message' => 'HotelBeds API Error: ' . ($response->json('error.message') ?? 'Connection failed')];
            }

            $data = $response->json();
            $hotels = $data['hotels']['hotels'] ?? [];
            $formatted = [];
            $markupPct = $this->getMarkupPct();

            foreach ($hotels as $h) {
                $net = $h['minRate'] ?? 0;
                if ($net == 0 && isset($h['rooms'][0]['rates'][0]['net'])) {
                    $net = $h['rooms'][0]['rates'][0]['net'];
                }
                
                $sell = round($net * (1 + $markupPct / 100), 2);

                $formatted[] = [
                    'code' => $h['code'],
                    'name' => $h['name'],
                    'main_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?fit=crop&w=800&q=80',
                    'price' => $sell,
                    'rating' => isset($h['categoryCode']) ? (int) substr($h['categoryCode'], 0, 1) : 4,
                    'facilities' => array_map(function($f) { return $f['description'] ?? $f; }, $h['facilities'] ?? []),
                    'rooms' => array_map(function($r) use ($markupPct, $h) {
                        return [
                            'name' => $r['name'],
                            'rates' => array_map(function($rt) use ($markupPct, $h) {
                                $rtNet = (float) $rt['net'];
                                return [
                                    'rateKey' => $rt['rateKey'],
                                    'net' => $rtNet,
                                    'sellingRate' => round($rtNet * (1 + $markupPct / 100), 2),
                                    'currency' => 'EUR', // Usually EUR in test
                                    'boardName' => $rt['boardName'],
                                    'hotelCode' => $h['code']
                                ];
                            }, $r['rates'] ?? [])
                        ];
                    }, $h['rooms'] ?? [])
                ];
            }

            return ['hotels' => ['hotels' => $formatted]];

        } catch (\Exception $e) {
            Log::error('HotelService Search Exception: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get Detailed information including Content (Images, Desc) and Availability (Rates)
     */
    public function getDetails($hotelCode, $checkIn, $checkOut, $adults = 2, $children = 0, $rooms = 1)
    {
        $paxes = [];
        for ($i = 0; $i < (int)$children; $i++) {
            $paxes[] = ['type' => 'CH', 'age' => 8];
        }

        // 1. Fetch Availability (Rates)
        $availPayload = [
            'stay' => ['checkIn' => $checkIn, 'checkOut' => $checkOut],
            'occupancies' => [
                [
                    'rooms' => (int) $rooms, 
                    'adults' => (int) $adults, 
                    'children' => (int) $children,
                    'paxes' => $paxes
                ]
            ],
            'hotels' => ['hotel' => [(int) $hotelCode]]
        ];

        try {
            // Get Rates
            $availResponse = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/hotels", $availPayload);

            // Get Content (Images, Facilities, etc.)
            $contentUrl = str_replace('hotel-api/1.0', 'hotel-content-api/3.0', $this->baseUrl) . "/hotels/{$hotelCode}/details?language=ENG";
            $contentResponse = Http::withHeaders($this->getHeaders())->get($contentUrl);

            $hAvail = $availResponse->json()['hotels']['hotels'][0] ?? null;
            $hContent = $contentResponse->json()['hotel'] ?? null;

            if ($availResponse->failed()) {
                $env = \App\Models\GlobalSetting::where('key', 'hotelbeds_api_env')->first()->value ?? 'test';
                if ($env === 'test' || $availResponse->status() == 403) {
                    return $this->getMockDetails($hotelCode);
                }
                return ['content' => [], 'availability' => []];
            }

            $markupPct = $this->getMarkupPct();
            
            // Format Availability
            $avail = ['rooms' => []];
            foreach ($hAvail['rooms'] as $r) {
                $avail['rooms'][] = [
                    'code' => $r['code'] ?? '',
                    'name' => $r['name'],
                    'rates' => array_map(function($rt) use ($markupPct, $hAvail) {
                        return [
                            'rateKey' => $rt['rateKey'],
                            'net' => (float) $rt['net'],
                            'sellingRate' => round((float) $rt['net'] * (1 + $markupPct / 100), 2),
                            'currency' => $rt['currency'] ?? 'EUR',
                            'boardName' => $rt['boardName'] ?? 'Room Only',
                            'hotelCode' => $hAvail['code']
                        ];
                    }, $r['rates'] ?? [])
                ];
            }

            // Format Content (Images)
            $images = [];
            if (isset($hContent['images'])) {
                foreach ($hContent['images'] as $img) {
                    $images[] = [
                        'path' => $img['path'],
                        'roomCode' => $img['roomCode'] ?? null,
                        'type' => $img['imageTypeCode'] ?? ''
                    ];
                }
            }

            $mainImgPath = isset($images[0]) ? $images[0]['path'] : null;
            $mainImgUrl = $mainImgPath ? "https://photos.hotelbeds.com/giata/" . $mainImgPath : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?fit=crop&w=800&q=80';

            $hotelContent = [
                'code' => $hAvail['code'],
                'name' => $hContent['name']['content'] ?? $hAvail['name'],
                'description' => $hContent['description'] ?? ['content' => 'Luxury stay experience.'],
                'address' => $hContent['address'] ?? ['content' => $hAvail['destinationName'] ?? 'City Center'],
                'main_image' => $mainImgUrl,
                'images' => $images,
                'facilities' => array_map(function($f) { 
                    return $f['description']['content'] ?? $f['facilityCode']; 
                }, $hContent['facilities'] ?? []),
                'categoryName' => $hContent['category']['description']['content'] ?? 'Hotel'
            ];

            return [
                'content' => $hotelContent,
                'availability' => $avail
            ];

        } catch (\Exception $e) {
            \Log::error('HotelService getDetails Exception: ' . $e->getMessage());
            return ['content' => [], 'availability' => []];
        }
    }

    /**
     * CheckRate endpoint for HotelBeds
     */
    public function checkRate($rateKey)
    {
        try {
            $payload = [
                'rooms' => [
                    ['rateKey' => $rateKey]
                ]
            ];
            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/checkrates", $payload);

            if ($response->failed()) {
                if (strpos($rateKey, 'MOCK') !== false) {
                    return $this->getMockCheckRate($rateKey);
                }
                return ['error' => true, 'message' => 'Rate expired.'];
            }

            $data = $response->json();
            $hotel = $data['hotel'];
            $markupPct = $this->getMarkupPct();

            return [
                'hotel' => [
                    'code' => $hotel['code'],
                    'name' => $hotel['name'],
                    'rooms' => array_map(function($r) use ($markupPct, $hotel) {
                        return [
                            'name' => $r['name'],
                            'rates' => array_map(function($rt) use ($markupPct, $hotel) {
                                return [
                                    'rateKey' => $rt['rateKey'],
                                    'net' => (float) $rt['net'],
                                    'sellingRate' => round((float) $rt['net'] * (1 + $markupPct / 100), 2),
                                    'currency' => $rt['currency'] ?? 'EUR',
                                    'boardName' => $rt['boardName'],
                                    'hotelCode' => $hotel['code']
                                ];
                            }, $r['rates'])
                        ];
                    }, $hotel['rooms'])
                ]
            ];

        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create a firm booking
     */
    public function book($params)
    {
        $payload = [
            'holder' => [
                'name' => $params['holder_name'],
                'surname' => $params['holder_surname']
            ],
            'rooms' => [
                [
                    'rateKey' => $params['rateKey'],
                    'paxes' => array_map(function($p) {
                        return [
                            'roomId' => 1,
                            'type' => $p['type'] ?? 'AD',
                            'name' => $p['name'],
                            'surname' => $p['surname']
                        ];
                    }, $params['paxes'])
                ]
            ],
            'clientReference' => 'TRP-' . time()
        ];

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/bookings", $payload);

            if ($response->failed()) {
                return ['error' => true, 'message' => $response->json()['error']['message'] ?? 'Booking Failed'];
            }

            $booking = $response->json()['booking'];

            // Log booking
            if (class_exists('App\\Models\\HotelBooking')) {
                HotelBooking::create([
                    'booking_id' => $params['booking_id'] ?? null,
                    'hotel_code' => $booking['hotel']['code'] ?? '',
                    'hotel_name' => $booking['hotel']['name'] ?? '',
                    'confirmation_number' => $booking['hotel']['confirmationNumber'] ?? null,
                    'check_in' => $booking['hotel']['checkIn'] ?? null,
                    'check_out' => $booking['hotel']['checkOut'] ?? null,
                    'rooms' => count($booking['hotel']['rooms'] ?? []),
                    'room_type' => $booking['hotel']['rooms'][0]['name'] ?? null,
                    'hotel_details' => json_encode($booking['hotel']),
                ]);
            }

            return [
                'booking' => [
                    'reference' => $booking['reference'],
                    'hotelReference' => $booking['hotel']['confirmationNumber'] ?? null,
                    'totalNet' => $booking['totalNet'],
                    'hotel' => $booking['hotel']
                ]
            ];

        } catch (\Exception $e) {
            \Log::error('HotelBeds Book Exception: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    protected function getMarkupPct()
    {
        return (float) (\App\Models\GlobalSetting::where('key', 'default_b2c_markup')->first()->value ?? 10);
    }

    /**
     * Return Realistic Mock Data for UI Testing
     */
    protected function getMockSearch($destCode)
    {
        $cityNames = [
            'DXB' => 'Dubai',
            'JAI' => 'Jaipur',
            'GOI' => 'Goa',
            'DEL' => 'Delhi',
            'BOM' => 'Mumbai',
            'BLR' => 'Bangalore',
            'MAA' => 'Chennai',
            'CCU' => 'Kolkata',
            'HYD' => 'Hyderabad',
            'PNQ' => 'Pune',
            'SXR' => 'Srinagar',
            'IXC' => 'Chandigarh',
            'COK' => 'Kochi',
            'AYJ' => 'Ayodhya',
            'IXL' => 'Leh',
            'AGR' => 'Agra',
            'UDR' => 'Udaipur',
            'DED' => 'Rishikesh',
            'SLV' => 'Shimla',
            'KUU' => 'Manali'
        ];

        $cityName = $cityNames[$destCode] ?? $destCode;

        $mockHotels = [
            [
                'code' => 'MOCK1',
                'name' => 'The Grand Heritage ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?fit=crop&w=800&q=80',
                'facilities' => ['Premium Spa', 'Infinity Pool', 'Luxury Dining', '24/7 Butler'],
                'minRate' => 12000.00,
                'price' => 12000.00,
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'latitude' => 28.61,
                'longitude' => 77.20,
                'rooms' => [
                    [
                        'name' => 'Royal Suite',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_1', 'net' => 10000, 'sellingRate' => 12000, 'currency' => 'INR', 'boardName' => 'Breakfast Included', 'hotelCode' => 'MOCK1']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK2',
                'name' => $cityName . ' Regency & Spa',
                'main_image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?fit=crop&w=800&q=80',
                'facilities' => ['City View', 'Executive Lounge', 'Fitness Center'],
                'minRate' => 8500.00,
                'price' => 8500.00,
                'rating' => 4,
                'categoryCode' => '4EST',
                'destinationName' => $cityName,
                'latitude' => 28.62,
                'longitude' => 77.21,
                'rooms' => [
                    [
                        'name' => 'Deluxe City View',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_2', 'net' => 7500, 'sellingRate' => 8500, 'currency' => 'INR', 'boardName' => 'Room Only', 'hotelCode' => 'MOCK2']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK3',
                'name' => 'Riverside Retreat ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?fit=crop&w=800&q=80',
                'facilities' => ['Nature Trail', 'Organic Kitchen', 'Yoga Deck'],
                'minRate' => 6200.00,
                'price' => 6200.00,
                'rating' => 4,
                'categoryCode' => '4EST',
                'destinationName' => $cityName,
                'latitude' => 28.63,
                'longitude' => 77.22,
                'rooms' => [
                    [
                        'name' => 'Eco Garden Room',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_3', 'net' => 5500, 'sellingRate' => 6200, 'currency' => 'INR', 'boardName' => 'Bed & Breakfast', 'hotelCode' => 'MOCK3']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK4',
                'name' => 'The Urban Oasis ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?fit=crop&w=800&q=80',
                'facilities' => ['Rooftop Bar', 'Business Center', 'Valet Parking'],
                'minRate' => 9800.00,
                'price' => 9800.00,
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'latitude' => 28.64,
                'longitude' => 77.23,
                'rooms' => [
                    [
                        'name' => 'Executive Suite',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_4', 'net' => 8800, 'sellingRate' => 9800, 'currency' => 'INR', 'boardName' => 'Full Board', 'hotelCode' => 'MOCK4']]
                    ]
                ]
            ]
        ];

        return [
            'hotels' => ['hotels' => $mockHotels],
            'is_mock' => true,
            'message' => 'Showing Simulated Results for ' . $cityName . ' (API Quota Exceeded)'
        ];
    }

    /**
     * Return Realistic Mock Details
     */
    protected function getMockDetails($hotelCode)
    {
        $basePrice = 12500;
        if ($hotelCode === 'MOCK1') $basePrice = 25000;
        if ($hotelCode === 'MOCK2') $basePrice = 18000;

        $hotelContent = [
            'code' => $hotelCode,
            'name' => ($hotelCode === 'MOCK1' ? 'Burj Al Arab Jumeirah (Mock)' : ($hotelCode === 'MOCK2' ? 'Atlantis The Palm (Mock)' : 'Grand Millennium Dubai (Mock)')),
            'description' => ['content' => 'Experience world-class service and luxury. This 5-star property offers spacious rooms, premium dining, and breathtaking views.'],
            'address' => ['content' => 'Sheikh Zayed Road, Exit 36, Dubai'],
            'main_image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?fit=crop&w=1200&q=80',
            'images' => [
                ['path' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?fit=crop&w=1200&q=80'],
                ['path' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?fit=crop&w=1200&q=80']
            ],
            'facilities' => ['Free WiFi', 'Swimming Pool', 'Spa', 'Fitness Center', 'Parking'],
            'categoryName' => '5 Star Hotel'
        ];

        $avail = [
            'rooms' => [
                [
                    'code' => 'STD',
                    'name' => 'Standard Room (Mock)',
                    'rates' => [
                        [
                            'rateKey' => 'MOCK_RK_' . $hotelCode . '_STD',
                            'net' => $basePrice * 0.88,
                            'sellingRate' => $basePrice,
                            'currency' => 'INR',
                            'boardName' => 'Room Only',
                            'hotelCode' => $hotelCode
                        ]
                    ]
                ],
                [
                    'code' => 'DLX',
                    'name' => 'Premium Suite (Mock)',
                    'rates' => [
                        [
                            'rateKey' => 'MOCK_RK_' . $hotelCode . '_DLX',
                            'net' => ($basePrice * 1.5) * 0.88,
                            'sellingRate' => $basePrice * 1.5,
                            'currency' => 'INR',
                            'boardName' => 'Bed & Breakfast',
                            'hotelCode' => $hotelCode
                        ]
                    ]
                ]
            ]
        ];

        return [
            'content' => $hotelContent,
            'availability' => $avail,
            'is_mock' => true
        ];
    }

    /**
     * Return Mock Rate Data for Checkout
     */
    protected function getMockCheckRate($rateKey)
    {
        // Extract hotel code and room type from key if possible
        $sellingRate = 12500.00; 
        
        if (strpos($rateKey, 'MOCK1') !== false) $sellingRate = 25000.00;
        elseif (strpos($rateKey, 'MOCK2') !== false) $sellingRate = 18000.00;

        if (strpos($rateKey, '_DLX') !== false) {
            $sellingRate = $sellingRate * 1.5;
        }

        return [
            'hotel' => [
                'code' => 'MOCK_HOTEL',
                'name' => 'Grand Millennium Dubai (Mock)',
                'rooms' => [
                    [
                        'name' => (strpos($rateKey, '_DLX') !== false ? 'Premium Suite (Mock)' : 'Standard Room (Mock)'),
                        'rates' => [
                            [
                                'rateKey' => $rateKey,
                                'net' => $sellingRate * 0.88,
                                'sellingRate' => $sellingRate,
                                'currency' => 'INR',
                                'boardName' => (strpos($rateKey, '_DLX') !== false ? 'Bed & Breakfast' : 'Room Only'),
                                'hotelCode' => 'MOCK_HOTEL'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}

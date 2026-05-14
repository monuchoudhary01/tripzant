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

                $imgId = (int)$h['code'] % 20;
                $mainImage = "https://images.unsplash.com/photo-" . ([
                    '1566073771259-6a8506099945', '1542314831-068cd1dbfeeb', '1582719478250-c89cae4dc85b', 
                    '1517841905240-472988babdf9', '1571896349842-33c89424de2d', '1520250497591-112f2f40a3f4',
                    '1551882547-ff43c63fedfe', '1561501900-3701fa6a0864', '1549294413-26f195af03c1',
                    '1445019980597-93fa8acb246c', '1618773928121-c32242e63f39', '1596436889106-be35e843f974',
                    '1566665797739-1674de7a421a', '1521783593447-5702b9bfd275', '1564501049412-61c2a3083791',
                    '1578683062331-624344d8f8cd', '1455587734955-081b22074882', '1535827848775-03999ef75825',
                    '1560662105-57f8ad6fc2d1', '1562790351-d273a46380c1'
                ][$imgId] ?? '1566073771259-6a8506099945') . "?fit=crop&w=800&q=80";

                $formatted[] = [
                    'code' => $h['code'],
                    'name' => $h['name'],
                    'main_image' => $mainImage,
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
                'minRate' => 12000.00 + rand(-500, 500),
                'price' => 12000.00 + rand(-500, 500),
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
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
                'minRate' => 8500.00 + rand(-300, 300),
                'price' => 8500.00 + rand(-300, 300),
                'rating' => 4,
                'categoryCode' => '4EST',
                'destinationName' => $cityName,
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
                'minRate' => 6200.00 + rand(-200, 200),
                'price' => 6200.00 + rand(-200, 200),
                'rating' => 4,
                'categoryCode' => '4EST',
                'destinationName' => $cityName,
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
                'minRate' => 9800.00 + rand(-400, 400),
                'price' => 9800.00 + rand(-400, 400),
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Executive Suite',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_4', 'net' => 8800, 'sellingRate' => 9800, 'currency' => 'INR', 'boardName' => 'Full Board', 'hotelCode' => 'MOCK4']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK5',
                'name' => 'Lakeside Palace ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?fit=crop&w=800&q=80',
                'facilities' => ['Lake View', 'Fine Dining', 'Wellness Center'],
                'minRate' => 11000.00 + rand(-500, 500),
                'price' => 11000.00 + rand(-500, 500),
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Lake View Premier',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_5', 'net' => 9500, 'sellingRate' => 11000, 'currency' => 'INR', 'boardName' => 'Breakfast Included', 'hotelCode' => 'MOCK5']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK6',
                'name' => 'Skyline Heights ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?fit=crop&w=800&q=80',
                'facilities' => ['Helipad', 'Rooftop Pool', 'Luxury Bar'],
                'minRate' => 15000.00 + rand(-1000, 1000),
                'price' => 15000.00 + rand(-1000, 1000),
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Skyline Suite',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_6', 'net' => 13000, 'sellingRate' => 15000, 'currency' => 'INR', 'boardName' => 'All Inclusive', 'hotelCode' => 'MOCK6']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK7',
                'name' => 'Classic Comfort ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1551882547-ff43c63fedfe?fit=crop&w=800&q=80',
                'facilities' => ['Free Parking', 'Pet Friendly', 'Laundry'],
                'minRate' => 4500.00 + rand(-200, 200),
                'price' => 4500.00 + rand(-200, 200),
                'rating' => 3,
                'categoryCode' => '3EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Standard Double',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_7', 'net' => 4000, 'sellingRate' => 4500, 'currency' => 'INR', 'boardName' => 'Room Only', 'hotelCode' => 'MOCK7']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK8',
                'name' => 'The Boutique Stay ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1561501900-3701fa6a0864?fit=crop&w=800&q=80',
                'facilities' => ['Art Gallery', 'Customized Meals', 'Quiet Zone'],
                'minRate' => 7800.00 + rand(-400, 400),
                'price' => 7800.00 + rand(-400, 400),
                'rating' => 4,
                'categoryCode' => '4EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Artisanal Room',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_8', 'net' => 6800, 'sellingRate' => 7800, 'currency' => 'INR', 'boardName' => 'Bed & Breakfast', 'hotelCode' => 'MOCK8']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK9',
                'name' => 'Metro Plaza Hotel ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1549294413-26f195af03c1?fit=crop&w=800&q=80',
                'facilities' => ['Near Metro', 'Fast WiFi', 'Meeting Rooms'],
                'minRate' => 5500.00 + rand(-300, 300),
                'price' => 5500.00 + rand(-300, 300),
                'rating' => 3,
                'categoryCode' => '3EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Business Standard',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_9', 'net' => 4800, 'sellingRate' => 5500, 'currency' => 'INR', 'boardName' => 'Room Only', 'hotelCode' => 'MOCK9']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK10',
                'name' => 'The Zenith ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?fit=crop&w=800&q=80',
                'facilities' => ['Smart Rooms', 'Tesla Charging', 'Library'],
                'minRate' => 13500.00 + rand(-700, 700),
                'price' => 13500.00 + rand(-700, 700),
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Zenith Executive',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_10', 'net' => 11800, 'sellingRate' => 13500, 'currency' => 'INR', 'boardName' => 'Half Board', 'hotelCode' => 'MOCK10']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK11',
                'name' => 'Sapphire Suites ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?fit=crop&w=800&q=80',
                'facilities' => ['Personal Gym', 'Sauna', 'Wine Cellar'],
                'minRate' => 16500.00 + rand(-1200, 1200),
                'price' => 16500.00 + rand(-1200, 1200),
                'rating' => 5,
                'categoryCode' => '5EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Sapphire Royal',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_11', 'net' => 14500, 'sellingRate' => 16500, 'currency' => 'INR', 'boardName' => 'All Inclusive', 'hotelCode' => 'MOCK11']]
                    ]
                ]
            ],
            [
                'code' => 'MOCK12',
                'name' => 'Green Gardenia ' . $cityName,
                'main_image' => 'https://images.unsplash.com/photo-1596436889106-be35e843f974?fit=crop&w=800&q=80',
                'facilities' => ['Roof Garden', 'Solar Powered', 'Compostable Kit'],
                'minRate' => 7200.00 + rand(-400, 400),
                'price' => 7200.00 + rand(-400, 400),
                'rating' => 4,
                'categoryCode' => '4EST',
                'destinationName' => $cityName,
                'rooms' => [
                    [
                        'name' => 'Green Deluxe',
                        'rates' => [['rateKey' => 'MOCK_RK_' . $destCode . '_12', 'net' => 6300, 'sellingRate' => 7200, 'currency' => 'INR', 'boardName' => 'Bed & Breakfast', 'hotelCode' => 'MOCK12']]
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

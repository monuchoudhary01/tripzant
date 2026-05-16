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

                $errorMessage = $response->json('error.message') ?? $response->json('error') ?? 'Connection failed';
                return ['hotels' => ['hotels' => []], 'is_mock' => false, 'error' => true, 'message' => 'HotelBeds API Error: ' . $errorMessage];
            }

            $data = $response->json();
            $hotels = $data['hotels']['hotels'] ?? [];
            $formatted = [];
            $markupPct = $this->getMarkupPct();
            $userCurrency = strtoupper($params['currency'] ?? session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD')));

            foreach ($hotels as $h) {
                $net = $h['minRate'] ?? 0;
                if ($net == 0 && isset($h['rooms'][0]['rates'][0]['net'])) {
                    $net = $h['rooms'][0]['rates'][0]['net'];
                }
                
                $sell = round($net * (1 + $markupPct / 100), 2);
                $apiCurrency = strtoupper($h['currency'] ?? ($h['rooms'][0]['rates'][0]['currency'] ?? 'EUR'));
                if ($apiCurrency !== $userCurrency) {
                    $sell = \App\Helpers\CurrencyConverter::convertBetween($sell, $apiCurrency, $userCurrency);
                }

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
                    'rooms' => array_map(function($r) use ($markupPct, $h, $apiCurrency, $userCurrency) {
                        return [
                            'name' => $r['name'],
                            'rates' => array_map(function($rt) use ($markupPct, $h, $apiCurrency, $userCurrency) {
                                $rtNet = (float) $rt['net'];
                                $sellingRate = round($rtNet * (1 + $markupPct / 100), 2);
                                if ($apiCurrency !== $userCurrency) {
                                    $sellingRate = \App\Helpers\CurrencyConverter::convertBetween($sellingRate, $apiCurrency, $userCurrency);
                                }
                                return [
                                    'rateKey' => $rt['rateKey'],
                                    'net' => $rtNet,
                                    'sellingRate' => $sellingRate,
                                    'currency' => $userCurrency,
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

            if ($availResponse->failed()) {
                return ['content' => [], 'availability' => []];
            }

            // Get Content (Images, Facilities, etc.)
            $contentUrl = str_replace('hotel-api/1.0', 'hotel-content-api/3.0', $this->baseUrl) . "/hotels/{$hotelCode}/details?language=ENG";
            $contentResponse = Http::withHeaders($this->getHeaders())->get($contentUrl);

            $hAvail = $availResponse->json()['hotels']['hotels'][0] ?? null;
            $hContent = $contentResponse->json()['hotel'] ?? null;

            if (!$hAvail) {
                return ['content' => [], 'availability' => []];
            }

            $markupPct = $this->getMarkupPct();
            $userCurrency = strtoupper(session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD')));
            
            // Format Availability
            $avail = ['rooms' => []];
            foreach ($hAvail['rooms'] as $r) {
                $avail['rooms'][] = [
                    'code' => $r['code'] ?? '',
                    'name' => $r['name'],
                    'rates' => array_map(function($rt) use ($markupPct, $hAvail, $userCurrency) {
                        $apiCurrency = strtoupper($rt['currency'] ?? 'EUR');
                        $sellingRate = round((float) $rt['net'] * (1 + $markupPct / 100), 2);
                        if ($apiCurrency !== $userCurrency) {
                            $sellingRate = \App\Helpers\CurrencyConverter::convertBetween($sellingRate, $apiCurrency, $userCurrency);
                        }
                        return [
                            'rateKey' => $rt['rateKey'],
                            'net' => (float) $rt['net'],
                            'sellingRate' => $sellingRate,
                            'currency' => $userCurrency,
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
                return ['error' => true, 'message' => 'Rate expired.'];
            }

            $data = $response->json();
            $hotel = $data['hotel'];
            $markupPct = $this->getMarkupPct();
            $userCurrency = strtoupper(session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD')));

            return [
                'hotel' => [
                    'code' => $hotel['code'],
                    'name' => $hotel['name'],
                    'rooms' => array_map(function($r) use ($markupPct, $hotel, $userCurrency) {
                        return [
                            'name' => $r['name'],
                            'rates' => array_map(function($rt) use ($markupPct, $hotel, $userCurrency) {
                                $apiCurrency = strtoupper($rt['currency'] ?? 'EUR');
                                $sellingRate = round((float) $rt['net'] * (1 + $markupPct / 100), 2);
                                if ($apiCurrency !== $userCurrency) {
                                    $sellingRate = \App\Helpers\CurrencyConverter::convertBetween($sellingRate, $apiCurrency, $userCurrency);
                                }
                                return [
                                    'rateKey' => $rt['rateKey'],
                                    'net' => (float) $rt['net'],
                                    'sellingRate' => $sellingRate,
                                    'currency' => $userCurrency,
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
}

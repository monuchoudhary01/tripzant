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
        $this->baseUrl = config('services.hotelbeds.env') === 'production' 
                        ? 'https://api.hotelbeds.com/hotel-api/1.0' 
                        : 'https://api.test.hotelbeds.com/hotel-api/1.0';
        $this->apiKey = config('services.hotelbeds.key');
        $this->secret = config('services.hotelbeds.secret');
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
                Log::error('HotelBeds Search Error', ['res' => $response->json()]);
                return ['hotels' => ['hotels' => []], 'is_mock' => false, 'error' => true, 'message' => 'HotelBeds API Error'];
            }

            $data = $response->json();
            $hotels = $data['hotels']['hotels'] ?? [];
            $formatted = [];
            $markupPct = (float) config('tripzant.markups.b2c', 10);

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

            if (!$hAvail) {
                return ['content' => [], 'availability' => []];
            }

            $markupPct = (float) config('tripzant.markups.b2c', 10);
            
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
                return ['error' => true, 'message' => 'Rate expired.'];
            }

            $data = $response->json();
            $hotel = $data['hotel'];
            $markupPct = (float) config('tripzant.markups.b2c', 10);

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
}

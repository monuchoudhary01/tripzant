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

        $payload = [
            'stay' => [
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
            ],
            'occupancies' => [
                [
                    'rooms' => 1,
                    'adults' => $params['adults'] ?? 2,
                    'children' => 0
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
                // Fallback to Mocks if API fails
                $mockData = $this->getMockHotels($destinationCode);
                return ['hotels' => ['hotels' => $mockData], 'is_mock' => true, 'msg' => 'HotelBeds API Error'];
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
     * Get Detailed information. HotelBeds includes rate details in standard search,
     * so we just do a targeted search for the specific hotel.
     */
    public function getDetails($hotelCode, $checkIn, $checkOut)
    {
        $payload = [
            'stay' => [
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
            ],
            'occupancies' => [
                [
                    'rooms' => 1,
                    'adults' => 2,
                    'children' => 0
                ]
            ],
            'hotels' => [
                'hotel' => [(int) $hotelCode]
            ]
        ];

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/hotels", $payload);

            if ($response->failed() || empty($response->json()['hotels']['hotels'])) {
                return ['content' => [], 'availability' => []];
            }

            $h = $response->json()['hotels']['hotels'][0];
            $markupPct = (float) config('tripzant.markups.b2c', 10);
            
            $avail = ['rooms' => []];
            foreach ($h['rooms'] as $r) {
                $avail['rooms'][] = [
                    'name' => $r['name'],
                    'rates' => array_map(function($rt) use ($markupPct, $h) {
                        return [
                            'rateKey' => $rt['rateKey'],
                            'net' => (float) $rt['net'],
                            'sellingRate' => round((float) $rt['net'] * (1 + $markupPct / 100), 2),
                            'currency' => 'EUR',
                            'boardName' => $rt['boardName'],
                            'hotelCode' => $h['code']
                        ];
                    }, $r['rates'])
                ];
            }

            $hotelContent = [
                'code' => $h['code'],
                'name' => $h['name'],
                'destinationCode' => $h['destinationCode'] ?? '',
                'main_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?fit=crop&w=800&q=80',
                'facilities' => array_map(function($f) { return $f['description'] ?? $f; }, $h['facilities'] ?? [])
            ];

            return [
                'content' => $hotelContent,
                'availability' => $avail
            ];

        } catch (\Exception $e) {
            return ['content' => [], 'availability' => []];
        }
    }

    /**
     * CheckRate endpoint for HotelBeds
     */
    public function checkRate($rateKey)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/checkrates/" . $rateKey);

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

    private function getMockHotels($cityCode)
    {
        $hotels = [];
        $names = ['Grand Royal Hotel', 'City Plaza', 'Ocean View Resort', 'The Majestic', 'Budget Inn', 'Skyline Suites'];
        
        for ($i = 0; $i < 10; $i++) {
            $name = $names[array_rand($names)] . ' ' . ($i + 1);
            $net = rand(5000, 25000);
            $markupPct = (float) config('tripzant.markups.b2c', 10);
            $sell = round($net * (1 + $markupPct / 100), 2);

            $hotels[] = [
                'code' => 'MOCK-' . $cityCode . '-' . $i,
                'name' => $name,
                'main_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?fit=crop&w=800&q=80',
                'facilities' => ['WIFI', 'PARKING', 'POOL'],
                'rooms' => [
                    [
                        'name' => 'Deluxe Room',
                        'rates' => [
                            [
                                'rateKey' => 'MOCK-RATE-' . $i,
                                'net' => $net,
                                'sellingRate' => $sell,
                                'currency' => 'INR',
                                'boardName' => 'Breakfast Included',
                                'hotelCode' => 'MOCK-' . $cityCode . '-' . $i
                            ]
                        ]
                    ]
                ]
            ];
        }
        return $hotels;
    }
}

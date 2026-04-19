<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransferService
{
    protected $baseUrl;
    protected $apiKey;
    protected $secret;

    public function __construct()
    {
        $this->baseUrl = config('services.hotelbeds.env') === 'production' 
                        ? 'https://api.hotelbeds.com/transfer-api/1.0' 
                        : 'https://api.test.hotelbeds.com/transfer-api/1.0';
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
     * Search Transfers via HotelBeds
     */
    public function search($params)
    {
        $payload = [
            'language' => 'en',
            'from' => [
                'type' => 'IATA',
                'code' => $params['startLocation'] ?? 'PMI' // Palma de Mallorca Airport
            ],
            'to' => [
                'type' => 'ATLAS',
                'code' => $params['endLocation'] ?? 'PMI' // Palma de Mallorca Resort
            ],
            'outbound' => $params['startDateTime'] ?? date('Y-m-d\TH:i:s', strtotime('+2 days')),
            'adults' => $params['passengers'] ?? 2,
            'children' => 0
        ];

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/availability", $payload);

            if ($response->failed()) {
                Log::error('HotelBeds Transfer Error', ['res' => $response->json(), 'payload' => $payload]);
                return ['success' => false, 'data' => []];
            }

            $data = $response->json();
            $services = $data['services'] ?? [];

            $markupPct = (float) config('tripzant.markups.b2c', 10);
            $formatted = [];

            foreach ($services as $service) {
                // Determine price
                $net = (float) ($service['price']['totalAmount'] ?? 0);
                $sell = round($net * (1 + $markupPct / 100), 2);
                
                $img = $service['content']['images'][0]['url'] ?? 
                       'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=400&q=80';

                $formatted[] = [
                    'id' => $service['id'] ?? rand(1000, 9999),
                    'provider' => $service['supplier']['name'] ?? 'Local Transfer',
                    'vehicle' => $service['vehicle']['name'] ?? 'Standard Car',
                    'category' => $service['category']['name'] ?? 'PRIVATE',
                    'description' => $service['content']['transferDetailInfo'][0]['description'] ?? 'Comfortable transfer',
                    'price' => $sell,
                    'net_price' => $net,
                    'original_price' => round($sell * 1.3, 0),
                    'currency' => $data['currency'] ?? 'USD',
                    'cancellation' => 'Free Cancellation',
                    'max_pax' => $service['minPaxCapacity'] ?? 4,
                    'image' => $img
                ];
            }

            return ['success' => true, 'data' => $formatted];

        } catch (\Exception $e) {
            Log::error('TransferService Error: ' . $e->getMessage());
            return ['success' => false, 'data' => []];
        }
    }
}

<?php

// Load Laravel (assuming we are in the project root)
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\HotelService;
use Illuminate\Support\Facades\Config;

$service = new HotelService();

$params = [
    'checkIn' => date('Y-m-d', strtotime('+7 days')),
    'checkOut' => date('Y-m-d', strtotime('+8 days')),
    'destinationCode' => 'DXB',
    'adults' => 2
];

echo "Testing HotelBeds API...\n";
echo "Base URL: " . config('tripzant.hotelbeds.base_url') . "\n";
echo "API Key: " . (config('tripzant.hotelbeds.key') ? 'PRESENT' : 'MISSING') . "\n";
echo "API Secret: " . (config('tripzant.hotelbeds.secret') ? 'PRESENT' : 'MISSING') . "\n";

try {
    $results = $service->search($params);
    if (isset($results['error'])) {
        echo "ERROR: " . $results['message'] . "\n";
        // Let's call it manually here to see the raw body
        $apiKey = config('tripzant.hotelbeds.key');
        $secret = config('tripzant.hotelbeds.secret');
        $baseUrl = config('tripzant.hotelbeds.base_url');
        $sig = hash("sha256", $apiKey . $secret . time());
        
        $resp = Http::withHeaders([
            'Api-Key' => $apiKey,
            'X-Signature' => $sig,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($baseUrl . '/hotel-api/1.0/hotels', [
            'stay' => [
                'checkIn' => $params['checkIn'],
                'checkOut' => $params['checkOut']
            ],
            'occupancies' => [
                ['rooms' => 1, 'adults' => 2, 'children' => 0]
            ],
            'destination' => ['code' => 'DXB'],
        ]);
        
        echo "Raw Response (Status " . $resp->status() . "):\n";
        echo $resp->body() . "\n";
    } else {
        echo "SUCCESS! Found " . count($results['hotels']['hotels'] ?? []) . " hotels.\n";
        if (count($results['hotels']['hotels'] ?? []) > 0) {
            echo "First hotel: " . $results['hotels']['hotels'][0]['name'] . "\n";
        }
    }
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

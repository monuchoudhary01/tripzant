<?php

namespace App\Proxy\Flight\Providers;

use App\Proxy\Flight\UnifiedFlight;
use Illuminate\Support\Facades\Log;

class RapidAPIProvider
{
    public function search(array $params)
    {
        $apiKey = "b493832341msh7db10645a560350p11edc3jsn73556b46e8d5";
        $apiHost = "kiwi-com-cheap-flights.p.rapidapi.com";

        // Convert dates to DD/MM/YYYY for traditional Kiwi search
        $outboundDate = date('d/m/Y', strtotime($params['date'] ?? 'today'));
        
        $queryParams = [
            'source' => (strlen($params['from']) === 3) ? "City:" . strtolower($params['from']) : $params['from'],
            'destination' => (strlen($params['to']) === 3) ? "City:" . strtolower($params['to']) : $params['to'],
            'outbound' => $outboundDate,
            'currency' => 'usd',
            'locale' => 'en',
            'adults' => 1,
            'limit' => 20
        ];

        $url = "https://kiwi-com-cheap-flights.p.rapidapi.com/round-trip?" . http_build_query($queryParams);

        Log::info("DEBUG: Kiwi API URL: $url");

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-key: $apiKey",
                "x-rapidapi-host: $apiHost",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = json_decode($response, true);
        $unified = [];

        if ($httpCode !== 200 || !isset($data['itineraries']) || empty($data['itineraries']) || isset($data['error'])) {
            Log::info("RapidAPIProvider: API Error or Empty results.");
            return [
                'flights' => [],
                'meta' => []
            ];
        }

        // Logic for parsing real data if present
        foreach ($data['itineraries'] as $it) {
            $segments = $it['outbound']['sectorSegments'] ?? $it['segments'] ?? [];
            if (empty($segments)) continue;

            $firstSeg = $segments[0]['segment'] ?? $segments[0];
            $lastSeg = end($segments)['segment'] ?? end($segments);

            $unified[] = new UnifiedFlight([
                'id' => $it['id'] ?? uniqid('kiwi_'),
                'gds_id' => $it['id'] ?? uniqid('kiwi_'),
                'airline_code' => $firstSeg['carrier']['code'] ?? 'XX',
                'airline_name' => $firstSeg['carrier']['name'] ?? 'Airline',
                'flight_number' => $firstSeg['code'] ?? '000',
                'departure_at' => $firstSeg['source']['localTime'] ?? date('Y-m-d H:i:s'),
                'arrival_at' => $lastSeg['destination']['localTime'] ?? date('Y-m-d H:i:s'),
                'departure_city' => $firstSeg['source']['station']['code'] ?? '???',
                'arrival_city' => $lastSeg['destination']['station']['code'] ?? '???',
                'duration' => floor(($it['duration'] ?? 0) / 3600) . 'h ' . (($it['duration'] ?? 0) % 3600 / 60) . 'm',
                'stops' => count($segments) - 1,
                'price' => (float) ($it['price']['amount'] ?? 0),
                'net_price' => (float) ($it['price']['amount'] ?? 0),
                'currency' => 'INR',
                'cabin' => 'ECONOMY',
                'baggage' => '7 KG',
                'baggage_unit' => '',
                'terminal' => 'T1',
                'source' => 'rapidapi',
                'raw_data' => $it
            ]);
        }

        return [
            'flights' => $unified,
            'meta' => $data['metadata'] ?? []
        ];
    }
}

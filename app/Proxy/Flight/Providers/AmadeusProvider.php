<?php

namespace App\Proxy\Flight\Providers;

use App\Proxy\Flight\FlightProvider;
use App\Proxy\Flight\UnifiedFlight;
use App\Services\AmadeusService;
use Illuminate\Support\Facades\Log;

class AmadeusProvider implements FlightProvider
{
    protected $amadeus;

    public function __construct(AmadeusService $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    public function getName(): string { return 'amadeus'; }
    public function supportsBooking(): bool { return true; }

    public function search(array $params): array
    {
        $queryParams = [
            'originLocationCode' => $params['from'] ?? 'DEL',
            'destinationLocationCode' => $params['to'] ?? 'BOM',
            'departureDate' => $params['date'] ?? date('Y-m-d'),
            'adults' => $params['adults'] ?? 1,
            'max' => 15,
        ];

        if (!empty($params['cabin'])) $queryParams['travelClass'] = strtoupper($params['cabin']);

        $response = $this->amadeus->get('/v2/shopping/flight-offers', $queryParams);

        if (isset($response['error']) || !isset($response['data'])) {
            Log::error('AmadeusProvider Search Error', ['error' => $response]);
            return ['flights' => [], 'meta' => []];
        }

        $unified = [];
        foreach ($response['data'] as $offer) {
            $itinerary = $offer['itineraries'][0] ?? null;
            if (!$itinerary) continue;
            
            $segments = $itinerary['segments'] ?? [];
            if (empty($segments)) continue;

            $firstSeg = $segments[0];
            $lastSeg = end($segments);
            $fareDetails = $offer['travelerPricings'][0]['fareDetailsBySegment'][0] ?? [];

            $unified[] = new UnifiedFlight([
                'id' => $offer['id'],
                'airline_code' => $offer['validatingAirlineCodes'][0] ?? $firstSeg['carrierCode'],
                'airline_name' => $this->getAirlineName($offer['validatingAirlineCodes'][0] ?? $firstSeg['carrierCode']),
                'flight_number' => $firstSeg['number'] ?? '000',
                'departure_at' => $firstSeg['departure']['at'] ?? null,
                'arrival_at' => $lastSeg['arrival']['at'] ?? null,
                'departure_city' => $firstSeg['departure']['iataCode'] ?? '???',
                'arrival_city' => $lastSeg['arrival']['iataCode'] ?? '???',
                'duration' => $this->formatDuration($itinerary['duration'] ?? 'PT0H'),
                'stops' => count($segments) - 1,
                'price' => (float) ($offer['price']['total'] ?? 0),
                'net_price' => (float) ($offer['price']['total'] ?? 0),
                'currency' => $offer['price']['currency'] ?? 'INR',
                'cabin' => $fareDetails['cabin'] ?? 'ECONOMY',
                'baggage' => $fareDetails['includedCheckedBags']['weight'] ?? ($fareDetails['includedCheckedBags']['quantity'] ?? '15'),
                'baggage_unit' => $fareDetails['includedCheckedBags']['weightUnit'] ?? (isset($fareDetails['includedCheckedBags']['weight']) ? 'KG' : 'PC'),
                'terminal' => $firstSeg['departure']['terminal'] ?? 'T1',
                'source' => 'amadeus',
                'raw_data' => $offer
            ]);
        }

        return [
            'flights' => $unified,
            'meta' => [
                'dictionaries' => $response['dictionaries'] ?? []
            ]
        ];
    }

    private function getAirlineName($code)
    {
        $airlines = ['6E' => 'IndiGo', 'UK' => 'Vistara', 'AI' => 'Air India', 'SG' => 'SpiceJet', 'QP' => 'Akasa Air'];
        return $airlines[$code] ?? $code;
    }

    private function formatDuration($duration)
    {
        return str_replace(['PT', 'H', 'M'], ['', 'h ', 'm'], $duration);
    }
}

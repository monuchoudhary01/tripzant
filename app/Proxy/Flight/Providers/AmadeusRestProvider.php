<?php

namespace App\Proxy\Flight\Providers;

use App\Proxy\Flight\FlightProvider;
use App\Proxy\Flight\UnifiedFlight;
use App\Services\FlightService;
use Illuminate\Support\Facades\Log;

class AmadeusRestProvider implements FlightProvider
{
    protected $flightService;

    public function __construct(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    public function getName(): string { return 'amadeus_rest'; }
    public function supportsBooking(): bool { return true; }

    public function search(array $params): array
    {
        // Map common keys to what FlightService expects
        $restParams = [
            'from' => $params['from'] ?? 'DEL',
            'to' => $params['to'] ?? 'BOM',
            'date' => $params['date'] ?? date('Y-m-d'),
            'adults' => $params['adults'] ?? 1,
            'children' => $params['children'] ?? 0,
            'infants' => $params['infants'] ?? 0,
            'cabin' => $params['cabin'] ?? 'ECONOMY',
            'currency' => $params['currency'] ?? 'INR'
        ];

        $response = $this->flightService->search($restParams);

        if (!($response['success'] ?? false)) {
            return ['flights' => [], 'meta' => []];
        }

        $flights = $response['data']['data'] ?? [];
        $unified = [];

        foreach ($flights as $offer) {
            $itinerary = $offer['itineraries'][0] ?? null;
            if (!$itinerary) continue;

            $segments = $itinerary['segments'] ?? [];
            $firstSeg = $segments[0] ?? null;
            $lastSeg = end($segments) ?? $firstSeg;

            if (!$firstSeg) continue;

            $offerCurrency = strtoupper(is_array($offer['price'] ?? null) ? ($offer['price']['currency'] ?? 'INR') : ($offer['currency'] ?? 'INR'));
            $targetCurrency = strtoupper($params['currency'] ?? $offerCurrency);
            $priceVal = (float) (is_array($offer['price'] ?? null) ? ($offer['price']['total'] ?? 0) : ($offer['price'] ?? 0));
            $netPriceVal = (float) (is_array($offer['price'] ?? null) ? ($offer['price']['base'] ?? $offer['price']['total'] ?? 0) : ($offer['net_price'] ?? $offer['price'] ?? 0));

            if ($offerCurrency !== $targetCurrency) {
                $priceVal = \App\Helpers\CurrencyConverter::convertBetween($priceVal, $offerCurrency, $targetCurrency);
                $netPriceVal = \App\Helpers\CurrencyConverter::convertBetween($netPriceVal, $offerCurrency, $targetCurrency);
                $offerCurrency = $targetCurrency;
            }

            $unified[] = new UnifiedFlight([
                'id' => $offer['id'] ?? $offer['gds_id'] ?? uniqid('amadeus_'),
                'airline_code' => $firstSeg['carrierCode'] ?? ($offer['airline_code'] ?? '??'),
                'airline_name' => $this->getAirlineName($firstSeg['carrierCode'] ?? ($offer['airline_code'] ?? '')),
                'flight_number' => $firstSeg['number'] ?? ($offer['flight_number'] ?? '000'),
                'departure_at' => date('Y-m-d H:i:s', strtotime($firstSeg['departure']['at'] ?? ($offer['departure_at'] ?? 'now'))),
                'arrival_at' => date('Y-m-d H:i:s', strtotime($lastSeg['arrival']['at'] ?? ($offer['arrival_at'] ?? 'now'))),
                'departure_city' => $firstSeg['departure']['iataCode'] ?? ($offer['dep_city'] ?? '???'),
                'arrival_city' => $lastSeg['arrival']['iataCode'] ?? ($offer['arr_city'] ?? '???'),
                'duration' => $itinerary['duration'] ?? ($offer['duration'] ?? 'N/A'),
                'stops' => count($segments) - 1,
                'price' => $priceVal,
                'net_price' => $netPriceVal,
                'currency' => $offerCurrency,
                'cabin' => $offer['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] ?? ($offer['cabin'] ?? 'ECONOMY'),
                'baggage' => '15 KG', // Default for REST
                'source' => 'amadeus',
                'raw_data' => $offer // Keep original for booking
            ]);
        }

        return [
            'flights' => $unified,
            'meta' => [
                'dictionaries' => $response['data']['dictionaries'] ?? []
            ]
        ];
    }

    protected function getAirlineName($code)
    {
        $airlines = [
            'AI' => 'Air India',
            '6E' => 'IndiGo',
            'UK' => 'Vistara',
            'SG' => 'SpiceJet',
            'QP' => 'Akasa Air',
            'I5' => 'AirAsia India',
            'EK' => 'Emirates',
            'QR' => 'Qatar Airways'
        ];
        return $airlines[$code] ?? $code;
    }
}

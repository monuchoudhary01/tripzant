<?php

namespace App\Proxy\Flight\Providers;

use App\Proxy\Flight\FlightProvider;
use App\Proxy\Flight\UnifiedFlight;

class ScraperProvider implements FlightProvider
{
    public function getName(): string { return 'scraper'; }
    public function supportsBooking(): bool { return false; } // Scraped data not for booking

    public function search(array $params): array
    {
        // Simulate a scraper fetching direct prices from OTA sites like MMT, Expedia for comparison
        $unified = [];
        $basePrice = rand(3800, 4500); // Usually cheaper but not bookable via API
        
        $unified[] = new UnifiedFlight([
            'id' => 'scrape_' . rand(100, 999),
            'airline_code' => '6E',
            'airline_name' => 'IndiGo (Direct Scrape)',
            'flight_number' => 'S-101',
            'departure_at' => ($params['date'] ?? date('Y-m-d')) . 'T08:00:00',
            'arrival_at' => ($params['date'] ?? date('Y-m-d')) . 'T10:00:00',
            'departure_city' => $params['from'] ?? 'DEL',
            'arrival_city' => $params['to'] ?? 'BOM',
            'duration' => '2h 0m',
            'stops' => 0,
            'price' => (float) $basePrice,
            'net_price' => (float) $basePrice,
            'currency' => 'INR',
            'cabin' => 'ECONOMY',
            'baggage' => '15',
            'baggage_unit' => 'KG',
            'terminal' => 'T1',
            'source' => 'scraper',
            'raw_data' => ['note' => 'Scraped from external OTA site']
        ]);

        return $unified;
    }
}

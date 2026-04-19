<?php

namespace App\Services;

use App\Proxy\Flight\Providers\AmadeusProvider;
use App\Proxy\Flight\Providers\TravelPayoutsProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HybridFlightService
{
    protected $providers = [];
    protected $pricingService;

    public function __construct(
        AmadeusProvider $amadeus,
        TravelPayoutsProvider $travelPayouts,
        PricingService $pricingService
    ) {
        // We now only use Amadeus and TravelPayouts
        $this->providers = [
            'amadeus' => $amadeus,
            'travelpayouts' => $travelPayouts
        ];

        $this->pricingService = $pricingService;
    }

    /**
     * Unified Hybrid Search
     */
    public function search(array $params)
    {
        $allResults = [];
        $metadata = [];
        $cheapestFare = PHP_INT_MAX;
        $bestDeal = null;

        \Illuminate\Support\Facades\Log::info('HybridFlightService: Active Providers (Amadeus & TravelPayouts)');

        foreach ($this->providers as $name => $provider) {
            try {
                \Illuminate\Support\Facades\Log::info("Calling provider: $name");
                $results = $provider->search($params);
                
                $flights = $results['flights'] ?? [];
                $providerMeta = $results['meta'] ?? [];
                
                // Merge metadata (like calendar data)
                $metadata = array_merge_recursive($metadata, $providerMeta);

                if (is_array($flights)) {
                    foreach ($flights as $flight) {
                        // Apply Pricing Logic based on User Role (Markup etc.)
                        $pricing = PricingService::calculateSellingPrice($flight->net_price, 'flight');
                        
                        $flight->price = $pricing['selling_price'];
                        $flight->markup_value = $pricing['markup'];
                        
                        $allResults[] = $flight;

                        // Track Cheapest
                        if ($flight->price < $cheapestFare) {
                            $cheapestFare = $flight->price;
                            $bestDeal = $flight;
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Provider $name failed: " . $e->getMessage());
            }
        }

        // Tag the Cheapest Flight as "Best Deal"
        if ($bestDeal) {
            foreach ($allResults as $f) {
                if ($f->id === $bestDeal->id && $f->source === $bestDeal->source) {
                    $f->is_cheapest = true;
                }
            }
        }

        // Sort by price ascending
        usort($allResults, function($a, $b) {
            return $a->price <=> $b->price;
        });

        $finalResponse = [
            'success' => true,
            'total' => count($allResults),
            'currency' => 'INR',
            'data' => $allResults,
            'meta' => $metadata,
            'dictionaries' => $metadata['dictionaries'] ?? [],
            'raw_data' => array_map(fn($f) => $f->raw_data, $allResults)
        ];

        // Cache results for 30 mins to support Details/Booking views
        Cache::put('flight_search_full', $finalResponse, now()->addMinutes(30));

        return $finalResponse;
    }
}

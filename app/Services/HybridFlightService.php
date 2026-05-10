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
                $startTimeProvider = microtime(true);
                \Illuminate\Support\Facades\Log::info("HybridFlightService: Calling provider: $name");
                
                $results = $provider->search($params);
                
                $flights = $results['flights'] ?? [];
                $count = count($flights);
                $duration = round(microtime(true) - $startTimeProvider, 2);
                
                \Illuminate\Support\Facades\Log::info("HybridFlightService: Provider $name returned $count flights in {$duration}s");
                
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
                \Illuminate\Support\Facades\Log::error("HybridFlightService: Provider $name FAILED: " . $e->getMessage());
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

        // --- Baggage Filtering ---
        if (isset($params['baggage']) && $params['baggage'] !== '') {
            $requiredBags = (int)$params['baggage'];
            $allResults = array_values(array_filter($allResults, function($f) use ($requiredBags) {
                // If weight is numeric, compare. If it's a string like "15 KG", extract number.
                $bagVal = is_object($f) ? ($f->baggage ?? 0) : ($f['baggage'] ?? 0);
                if (is_string($bagVal)) {
                    $bagVal = (int) filter_var($bagVal, FILTER_SANITIZE_NUMBER_INT);
                }
                return $bagVal >= $requiredBags;
            }));
        }

        $finalResponse = [
            'success' => true,
            'total' => count($allResults),
            'currency' => 'INR',
            'data' => $allResults,
            'meta' => $metadata,
            'dictionaries' => $metadata['dictionaries'] ?? [],
            'raw_data' => array_map(function($f) {
                return is_object($f) ? $f->toArray() : $f;
            }, $allResults)
        ];

        // Cache results for 30 mins to support Details/Booking views
        $cacheKey = 'flight_search_' . session()->getId();
        Cache::put($cacheKey, $finalResponse, now()->addMinutes(30));
        
        // Global ID lookup cache - extremely robust for checkout
        foreach ($allResults as $flight) {
            $fId = is_object($flight) ? ($flight->id ?? null) : ($flight['id'] ?? null);
            if ($fId) {
                $fArray = is_object($flight) ? $flight->toArray() : $flight;
                Cache::put('flight_data_' . $fId, $fArray, now()->addMinutes(60));
            }
        }

        Cache::put('flight_search_full', $finalResponse, now()->addMinutes(30)); // Keep for legacy

        return $finalResponse;
    }
}

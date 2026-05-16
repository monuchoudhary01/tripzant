<?php

namespace App\Services;

use App\Models\CargoProvider;
use Illuminate\Support\Facades\Http;

class CargoService
{
    /**
     * Auto-import cargo providers based on city/country.
     * Module 5: Global Supplier Auto-Import
     */
    public function autoImportProviders($city, $country)
    {
        // Real-time Logistics API integration required for provider auto-import.
        // Mock data removed to ensure strictly real-time data flow.
        \Log::info('CargoService: autoImportProviders requested for ' . $city . ', but API not yet integrated.');
        
        return true;
    }

    /**
     * Price Calculation Engine (Module 2)
     */
    public function calculateFinalPrice($providerId, $weight, $insurancePlan = 'None', $itemValue = 0)
    {
        $provider = CargoProvider::findOrFail($providerId);
        $base = $provider->base_rate + ($weight * $provider->per_kg_rate);
        
        $insurance = 0;
        if($insurancePlan == 'Basic') $insurance = 15.00;
        if($insurancePlan == 'Premium') $insurance = $itemValue * 0.05;

        $tax = $base * 0.10;

        return [
            'base' => round($base, 2),
            'insurance' => round($insurance, 2),
            'tax' => round($tax, 2),
            'total' => round($base + $insurance + $tax, 2)
        ];
    }
}

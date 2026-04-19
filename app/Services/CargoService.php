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
        // Mocking API call to a logistics aggregator like Google Places or specific Logistics APIs
        // In a real scenario, this would use Http::get('https://api.logistics.com/v1/providers', [...])
        
        $mockRes = [
            ['name' => 'ShipGlobal ' . $city, 'rate' => 55.00],
            ['name' => 'TransitPro ' . $country, 'rate' => 48.00]
        ];

        foreach($mockRes as $res) {
            CargoProvider::firstOrCreate(
                ['name' => $res['name']],
                [
                    'base_rate' => $res['rate'],
                    'per_kg_rate' => 5.00,
                    'rating' => 4.4,
                    'supported_countries' => [$country],
                    'is_active' => true
                ]
            );
        }

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

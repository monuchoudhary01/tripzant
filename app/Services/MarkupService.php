<?php

namespace App\Services;

class MarkupService
{
    /**
     * Calculate final price based on user role and portal.
     * 
     * @param float $netFare The base price from the API
     * @param string|null $role User role (b2c, b2b, corporate, iata)
     * @param float|null $customMarkup Optional custom markup for specific agents
     * @return array [selling_price, profit, markup_applied]
     */
    public function calculate($netFare, $role = 'b2c', $customMarkup = null)
    {
        // 1. Get default markup from config if not provided
        $markupPercent = $customMarkup ?? config("tripzant.markups.{$role}", 10);
        
        // 2. Calculate markup value
        $markupValue = ($netFare * $markupPercent) / 100;
        
        // 3. Final selling price
        $sellingPrice = $netFare + $markupValue;

        return [
            'net_fare' => round($netFare, 2),
            'markup_percent' => $markupPercent,
            'profit' => round($markupValue, 2),
            'selling_price' => round($sellingPrice, 2),
        ];
    }
}

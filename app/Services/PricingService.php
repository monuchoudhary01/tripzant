<?php

namespace App\Services;

use App\Models\MarkupSetting;
use Illuminate\Support\Facades\Auth;

class PricingService
{
    /**
     * Calculate selling price based on dynamic markups
     */
    public static function calculateSellingPrice($netPrice, $module)
    {
        $role = Auth::check() ? Auth::user()->role : 'b2c';
        
        // Map roles if necessary (e.g. b2b_agent, corporate)
        if ($role === 'agent') $role = 'b2b_agent';
        
        $markup = MarkupSetting::where('module', $module)
            ->where('user_role', $role)
            ->where('is_active', true)
            ->first();

        if (!$markup) {
            // Fallback to B2C if role specific not found
            $markup = MarkupSetting::where('module', $module)
                ->where('user_role', 'b2c')
                ->where('is_active', true)
                ->first();
        }

        if (!$markup) return ['selling_price' => $netPrice, 'markup' => 0];

        $markupValue = 0;
        if ($markup->markup_type === 'percent') {
            $markupValue = ($netPrice * $markup->markup_value) / 100;
        } else {
            $markupValue = $markup->markup_value;
        }

        return [
            'selling_price' => $netPrice + $markupValue,
            'markup' => $markupValue,
            'type' => $markup->markup_type,
            'rate' => $markup->markup_value
        ];
    }
}

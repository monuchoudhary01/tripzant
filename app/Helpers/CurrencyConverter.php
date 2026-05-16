<?php

namespace App\Helpers;

use App\Models\Currency;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;

class CurrencyConverter
{
    /**
     * Convert an amount from Base Currency (AUD) to User's Selected Currency
     *
     * @param float $amount The amount in base currency (AUD)
     * @param string|null $targetCurrency Optional target currency (defaults to user cookie)
     * @return float The converted amount
     */
    public static function convert($amount, $targetCurrency = null)
    {
        if (!$targetCurrency) {
            $targetCurrency = Cookie::get('user_currency', 'AUD');
        }

        // If target is AUD, no conversion needed
        if (strtoupper($targetCurrency) === 'AUD') {
            return (float) $amount;
        }

        // Fetch exchange rate from cache or DB
        $rate = Cache::remember('currency_rate_' . $targetCurrency, 3600, function () use ($targetCurrency) {
            $currency = Currency::where('code', strtoupper($targetCurrency))->first();
            return $currency ? $currency->exchange_rate : 1.0;
        });

        return (float) $amount * $rate;
    }

    /**
     * Format an amount with the correct symbol
     *
     * @param float $amount The amount in base currency (AUD)
     * @param bool $includeSymbol Whether to include the currency symbol
     * @return string Formatted amount
     */
    public static function format($amount, $includeSymbol = true)
    {
        $targetCurrency = Cookie::get('user_currency', 'AUD');
        $convertedAmount = self::convert($amount, $targetCurrency);
        
        if (!$includeSymbol) {
            return number_format($convertedAmount, 2);
        }

        $symbol = Cache::remember('currency_symbol_' . $targetCurrency, 3600, function () use ($targetCurrency) {
            $currency = Currency::where('code', strtoupper($targetCurrency))->first();
            return $currency ? $currency->symbol : '$';
        });

        return $symbol . number_format($convertedAmount, 2);
    }
}

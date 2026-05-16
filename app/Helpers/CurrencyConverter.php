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

    /**
     * Convert an amount between any two currencies
     *
     * @param float $amount The amount in fromCurrency
     * @param string $fromCurrency The source currency code (e.g. USD, INR)
     * @param string $toCurrency The target currency code (e.g. EUR, AUD)
     * @return float The converted amount
     */
    public static function convertBetween($amount, $fromCurrency, $toCurrency)
    {
        $fromCurrency = strtoupper($fromCurrency);
        $toCurrency = strtoupper($toCurrency);

        if ($fromCurrency === $toCurrency) {
            return (float) $amount;
        }

        // Fetch rate for source currency
        $fromRate = Cache::remember('currency_rate_' . $fromCurrency, 3600, function () use ($fromCurrency) {
            $currency = Currency::where('code', $fromCurrency)->first();
            return $currency ? $currency->exchange_rate : 1.0;
        });

        // Fetch rate for target currency
        $toRate = Cache::remember('currency_rate_' . $toCurrency, 3600, function () use ($toCurrency) {
            $currency = Currency::where('code', $toCurrency)->first();
            return $currency ? $currency->exchange_rate : 1.0;
        });

        if ($fromRate == 0) {
            $fromRate = 1.0;
        }

        // Convert to base currency first, then to target currency
        $baseAmount = (float) $amount / $fromRate;
        return $baseAmount * $toRate;
    }
}

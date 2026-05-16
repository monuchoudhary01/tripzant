<?php

if (!function_exists('format_price')) {
    /**
     * Format price based on global currency settings
     */
    function format_price($amount, $fromCurrency = 'AUD') {
        $currencyCode = session('user_currency', Cookie::get('user_currency', 'AUD'));
        
        // Strip commas and non-numeric characters except decimals
        $cleanAmount = preg_replace('/[^0-9.]/', '', $amount);
        
        // Get currency data from cache/DB
        $currency = \App\Models\Currency::where('code', $currencyCode)->first();
        $rate = $currency ? $currency->exchange_rate : 1;
        $symbol = $currency ? $currency->symbol : '$';

        $convertedAmount = (float)$cleanAmount * $rate;

        return $symbol . ' ' . number_format($convertedAmount, 2);
    }
}

if (!function_exists('current_currency_symbol')) {
    function current_currency_symbol() {
        $currencyCode = session('user_currency', Cookie::get('user_currency', 'AUD'));
        $currency = \App\Models\Currency::where('code', $currencyCode)->first();
        return $currency ? $currency->symbol : '$';
    }
}

if (!function_exists('current_currency_code')) {
    function current_currency_code() {
        return session('user_currency', Cookie::get('user_currency', 'AUD'));
    }
}

if (!function_exists('localized_url')) {
    /**
     * Generate a localized URL with /{locale}/{currency}/ prefix
     */
    function localized_url($path = '/') {
        $locale = strtolower(session('user_locale', Cookie::get('user_locale', 'en')));
        $currency = strtolower(session('user_currency', Cookie::get('user_currency', 'aud')));
        
        $path = ltrim($path, '/');
        return url("/{$locale}/{$currency}/{$path}");
    }
}

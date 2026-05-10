<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mastercard MPGS Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Commercial Bank of Sri Lanka MPGS (Mastercard Payment 
    | Gateway Services).
    |
    */

    'mpgs' => [
        'merchant_id' => env('MPGS_MERCHANT_ID', 'EASIWORLDLKR'),
        'api_password' => env('MPGS_API_PASSWORD', '1f74741e4c6477941266051d959df1d0'),
        'api_base_url' => env('MPGS_API_BASE_URL', 'https://cbcmpgs.gateway.mastercard.com/api/rest/version/100'),
        'currency' => env('MPGS_CURRENCY', 'LKR'),
        'test_mode' => env('MPGS_TEST_MODE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration (Existing)
    |--------------------------------------------------------------------------
    */
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Amadeus GDS Configuration
    |--------------------------------------------------------------------------
    */
    'amadeus' => [
        'key' => env('AMADEUS_API_KEY'),
        'secret' => env('AMADEUS_API_SECRET'),
        'env' => env('AMADEUS_API_ENV', 'test'),
        'base_url' => env('AMADEUS_API_ENV') === 'production' 
            ? 'https://api.amadeus.com' 
            : 'https://test.api.amadeus.com',
        
        'providers' => [
            'CA' => [
                'country' => 'Canada',
                'pcc' => 'YYCC42484',
                'currency' => 'CAD',
                'wsap' => '1ASIWIBEESI',
                'user' => 'WSESIIBE',
                'password' => 'zmry#GcJ*9JR'
            ],
            'NZ' => [
                'country' => 'New Zealand',
                'pcc' => 'AKLNZ21GB',
                'currency' => 'NZD',
                'wsap' => '1ASIWSBESAT',
                'user' => 'WSESIIBE',
                'password' => 'HUXkxNhW4@hP'
            ],
            'LK' => [
                'country' => 'Sri Lanka',
                'pcc' => 'CMBVS32YZ',
                'currency' => 'LKR',
                'wsap' => '1ASIWIBEESI',
                'user' => 'WSESIIBE',
                'password' => 'prWC5RnJ%ARx'
            ],
            'UK' => [
                'country' => 'United Kingdom',
                'pcc' => 'LONU121LU',
                'currency' => 'GBP',
                'wsap' => env('AMADEUS_WSAP_UK', '1ASIWIBEESI'),
                'user' => env('AMADEUS_USER_UK', 'WSESIIBE'),
                'password' => env('AMADEUS_PASS_UK', '')
            ],
            'US' => [
                'country' => 'United States',
                'pcc' => 'LAX1S24L2',
                'currency' => 'USD',
                'wsap' => env('AMADEUS_WSAP_US', '1ASIWIBEESI'),
                'user' => env('AMADEUS_USER_US', 'WSESIIBE'),
                'password' => env('AMADEUS_PASS_US', '')
            ],
            'AU' => [
                'country' => 'Australia',
                'pcc' => 'BNEA8217Z',
                'currency' => 'AUD',
                'wsap' => '1ASIWSBESAT',
                'user' => 'WSESIIBE',
                'password' => 'HUXkxNhW4@hP'
            ],
            'IN' => [
                'country' => 'India',
                'pcc' => 'JAIVS3793',
                'currency' => 'INR',
                'wsap' => '1ASIWIBEESI',
                'user' => 'WSESIIBE',
                'password' => 'prWC5RnJ%ARx'
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | HotelBeds API Configuration
    |--------------------------------------------------------------------------
    */
    'hotelbeds' => [
        'key' => env('HOTELBEDS_API_KEY'),
        'secret' => env('HOTELBEDS_API_SECRET'),
        'env' => env('HOTELBEDS_API_ENV', 'test'),
        'base_url' => env('HOTELBEDS_API_ENV') === 'live'
            ? 'https://api.hotelbeds.com'
            : 'https://api.test.hotelbeds.com',
        
        'activities' => [
            'key' => env('HOTELBEDS_ACTIVITIES_KEY', 'dd4b5246f090347ed6d343be7531274d'),
            'secret' => env('HOTELBEDS_ACTIVITIES_SECRET', ''),
        ],
        'transfers' => [
            'key' => env('HOTELBEDS_TRANSFERS_KEY', 'c6a73faa7b2908551b062310b99035a8'),
            'secret' => env('HOTELBEDS_TRANSFERS_SECRET', ''),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Portal Markups (%)
    |--------------------------------------------------------------------------
    */
    'markups' => [
        'b2c' => env('DEFAULT_B2C_MARKUP', 10),
        'b2b' => env('DEFAULT_B2B_MARKUP', 5),
        'corporate' => env('DEFAULT_CORPORATE_MARKUP', 7),
        'iata' => env('DEFAULT_IATA_MARKUP', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Wallet & Financial Settings
    |--------------------------------------------------------------------------
    */
    'wallet' => [
        'currency' => env('WALLET_CURRENCY', 'INR'),
        'min_recharge' => env('MIN_WALLET_RECHARGE', 500),
        'enable_credit' => true,
    ],
];

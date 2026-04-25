<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'travelpayouts' => [
        'token' => env('TRAVELPAYOUTS_TOKEN'),
        'marker' => env('NEXT_PUBLIC_TRAVELPAYOUTS_MARKER'),
    ],

    'hotelbeds' => [
        'key' => env('HOTELBEDS_API_KEY'),
        'secret' => env('HOTELBEDS_API_SECRET'),
        'env' => env('HOTELBEDS_API_ENV', 'test'),
        'base_url' => (env('HOTELBEDS_API_ENV') === 'production' || env('HOTELBEDS_API_ENV') === 'live')
                        ? 'https://api.hotelbeds.com/hotel-api/1.0' 
                        : 'https://api.test.hotelbeds.com/hotel-api/1.0',
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'whatsapp' => [
        'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
        'app_id' => env('WHATSAPP_APP_ID'),
        'access' => env('WHATSAPP_ACCESS', false),
    ],

];

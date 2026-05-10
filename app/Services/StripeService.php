<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        // Read from database first (admin panel), fallback to .env
        $settings   = \App\Models\GlobalSetting::where('group', 'payments')->get()->pluck('value', 'key');
        $secretKey  = $settings['payment_stripe_secret_key'] ?? config('services.stripe.secret');

        Stripe::setApiKey($secretKey);
    }

    /**
     * Create a Stripe Checkout Session
     */
    public function createCheckoutSession($params)
    {
        try {
            return Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => $params['item_name'],
                        ],
                        'unit_amount' => (int) round($params['amount'] * 100), // Stripe uses cents/paise
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $params['success_url'],
                'cancel_url' => $params['cancel_url'],
                'customer_email' => $params['email'] ?? null,
                'metadata' => $params['metadata'] ?? [],
            ]);
        } catch (\Exception $e) {
            \Log::error('Stripe Session Error: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}

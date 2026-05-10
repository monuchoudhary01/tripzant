<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpgsService
{
    protected $merchantId;
    protected $apiPassword;
    protected $baseUrl;
    protected $apiVersion = '100';

    public function __construct()
    {
        $settings = \App\Models\GlobalSetting::where('group', 'payments')->get()->pluck('value', 'key');
        
        $this->merchantId  = $settings['payment_mpgs_merchant_id'] ?? config('payments.mpgs.merchant_id');
        $this->apiPassword = $settings['payment_mpgs_api_password'] ?? config('payments.mpgs.api_password');
        $this->baseUrl     = $settings['payment_mpgs_api_base_url'] ?? config('payments.mpgs.api_base_url');
    }

    /**
     * Create a Checkout Session (Version 100)
     */
    public function createCheckoutSession($params)
    {
        $url = "{$this->baseUrl}/merchant/{$this->merchantId}/session";

        $payload = [
            'apiOperation' => 'CREATE_CHECKOUT_SESSION',
            'order' => [
                'id' => $params['order_id'] ?? 'TRP-' . time(),
                'amount' => number_format($params['amount'], 2, '.', ''),
                'currency' => $params['currency'] ?? config('payments.mpgs.currency'),
                'description' => 'Tripzant Travel Booking - ' . ($params['order_id'] ?? 'N/A'),
            ],
            'interaction' => [
                'operation' => 'PURCHASE'
            ]
        ];

        try {
            // Mastercard requires basic auth: 'merchant.{merchantId}' : '{apiPassword}'
            $response = Http::withBasicAuth('merchant.' . $this->merchantId, $this->apiPassword)
                ->withOptions([
                    'curl' => [
                        CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_CONNECTTIMEOUT => 10,
                    ],
                    'verify' => false, 
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('MPGS API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload
            ]);

            return [
                'error' => true, 
                'message' => $response->json('error.explanation') ?? 'Failed to create MPGS session'
            ];

        } catch (\Exception $e) {
            Log::error('MPGS Exception: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Retrieve Order Details
     */
    public function getOrderDetails($orderId)
    {
        $url = "{$this->baseUrl}/merchant/{$this->merchantId}/order/{$orderId}";

        try {
            $response = Http::withBasicAuth('merchant.' . $this->merchantId, $this->apiPassword)
                ->get($url);

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => true, 'message' => 'Failed to retrieve order details'];
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}

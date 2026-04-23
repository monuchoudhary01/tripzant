<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Services\AuditLogService;

class AmadeusService
{
    protected $baseUrl;
    protected $apiKey;
    protected $apiSecret;
    protected $ndcOid;
    public $lastRequest = []; // To store last request metadata for testing

    public function __construct()
    {
        // Default from config
        $this->baseUrl = config('tripzant.amadeus.base_url', 'https://test.api.amadeus.com');
        $this->apiKey = config('tripzant.amadeus.key');
        $this->apiSecret = config('tripzant.amadeus.secret');
        $this->ndcOid = config('tripzant.amadeus.ndc_oid');

        // Prefer dynamic keys from DB if available (as requested by user)
        try {
            $dbConfig = \App\Models\ApiConfig::where('provider_name', 'amadeus')->where('is_active', true)->first();
            if ($dbConfig && $dbConfig->credentials) {
                $creds = is_array($dbConfig->credentials) ? $dbConfig->credentials : json_decode($dbConfig->credentials, true);
                if (!empty($creds['api_key']) || !empty($creds['client_id'])) {
                    $this->apiKey = $creds['api_key'] ?? $creds['client_id'];
                }
                if (!empty($creds['api_secret']) || !empty($creds['client_secret'])) {
                    $this->apiSecret = $creds['api_secret'] ?? $creds['client_secret'];
                }
                if (!empty($creds['base_url'])) {
                    $this->baseUrl = $creds['base_url'];
                }
            }
        } catch (\Exception $e) {
            \Log::warning('AmadeusService: Fallback to static config due to DB error: ' . $e->getMessage());
        }
    }

    /**
     * Get Access Token from Amadeus (Cached)
     */
    public function getAccessToken()
    {
        return Cache::remember('amadeus_token', 1500, function () {
            if (!$this->apiKey || !$this->apiSecret) {
                \Log::error('Amadeus API keys missing');
                return null;
            }

                try {
                $response = Http::when(app()->isLocal(), fn($r) => $r->withoutVerifying())->asForm()->post($this->baseUrl . '/v1/security/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->apiKey,
                    'client_secret' => $this->apiSecret,
                ]);

                if ($response->successful()) {
                    return $response->json()['access_token'] ?? null;
                }

                \Log::error('Amadeus Token fetch failed', ['response' => $response->body()]);
            } catch (\Exception $e) {
                \Log::error('Amadeus Token connection error: ' . $e->getMessage());
            }
            return null;
        });
    }

    /**
     * Generate a unique client reference for request tracking
     */
    protected function generateClientRef()
    {
        return 'client_' . Str::random(16);
    }

    /**
     * Generic GET Request
     */
    public function get($endpoint, $params = [])
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['error' => true, 'message' => 'Authentication failed'];
        }

        $clientRef = $this->generateClientRef();
        $startTime = microtime(true);
        $timestamp = now()->toIso8601ZuluString();

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Ama-Client-Ref' => $clientRef,
            'Accept' => 'application/json',
            'X-Amadeus-Target-Source' => $this->ndcOid,
            'X-Amadeus-Navigation-Target-Source' => $this->ndcOid,
        ];

        try {
            $response = Http::when(app()->isLocal(), fn($r) => $r->withoutVerifying())->withHeaders($headers)->get($this->baseUrl . $endpoint, $params);
            $executionTime = microtime(true) - $startTime;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'status' => 500,
                'message' => 'Could not connect to Amadeus Sandbox. Connection issue.',
                'details' => $e->getMessage()
            ];
        }

        $this->lastRequest = [
            'client_ref' => $clientRef,
            'timestamp' => $timestamp,
            'endpoint' => $endpoint,
            'method' => 'GET'
        ];

        if (!$response->successful()) {
            $errorData = [
                'error' => true,
                'status' => $response->status(),
                'message' => $response->json()['errors'][0]['detail'] ?? 'API Error',
                'details' => $response->json() ?? null
            ];
            
            AuditLogService::logApi('Amadeus', $endpoint, 'GET', $params, $response->json() ?? [], $response->status(), $executionTime, $clientRef, $headers, $timestamp);
            return $errorData;
        }

        $result = $response->json();
        AuditLogService::logApi('Amadeus', $endpoint, 'GET', $params, $result, $response->status(), $executionTime, $clientRef, $headers, $timestamp);

        return $result;
    }

    /**
     * Generic POST Request
     */
    public function post($endpoint, $payload = [])
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['error' => true, 'message' => 'Authentication failed'];
        }

        $clientRef = $this->generateClientRef();
        $startTime = microtime(true);
        $timestamp = now()->toIso8601ZuluString();

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Ama-Client-Ref' => $clientRef,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Amadeus-Target-Source' => $this->ndcOid, // Required for NDC
        ];

        try {
            $response = Http::when(app()->isLocal(), fn($r) => $r->withoutVerifying())->withHeaders($headers)->post($this->baseUrl . $endpoint, $payload);
            $executionTime = microtime(true) - $startTime;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'status' => 500,
                'message' => 'Could not connect to Amadeus Sandbox. Connection issue.',
                'details' => $e->getMessage()
            ];
        }

        $this->lastRequest = [
            'client_ref' => $clientRef,
            'timestamp' => $timestamp,
            'endpoint' => $endpoint,
            'method' => 'POST'
        ];

        if (!$response->successful()) {
            $errorData = [
                'error' => true,
                'status' => $response->status(),
                'message' => $response->json()['errors'][0]['detail'] ?? 'API Error',
                'details' => $response->json() ?? null
            ];

            AuditLogService::logApi('Amadeus', $endpoint, 'POST', $payload, $response->json(), $response->status(), $executionTime, $clientRef, $headers, $timestamp);
            return $errorData;
        }

        $result = $response->json();
        AuditLogService::logApi('Amadeus', $endpoint, 'POST', $payload, $result, $response->status(), $executionTime, $clientRef, $headers, $timestamp);

        return $result;
    }
    /**
     * Flight Inspiration Search (Show prices on map)
     * Endpoint: /v1/shopping/flight-destinations
     */
    public function flightInspirationSearch($origin, $params = [])
    {
        $params['origin'] = $origin;
        return $this->get('/v1/shopping/flight-destinations', $params);
    }

    /**
     * Flight Offers Search
     * Endpoint: /v2/shopping/flight-offers
     */
    public function flightOffersSearch($params = [])
    {
        return $this->get('/v2/shopping/flight-offers', $params);
    }

    /**
     * Flight Offers Search (POST version - Better for NDC)
     * Endpoint: /v2/shopping/flight-offers
     */
    public function flightOffersSearchPost($payload = [])
    {
        return $this->post('/v2/shopping/flight-offers', $payload);
    }

    /**
     * Airport & City Search (Locations)
     * Endpoint: /v1/reference-data/locations
     */
    public function locationSearch($keyword, $subType = 'AIRPORT,CITY')
    {
        return $this->get('/v1/reference-data/locations', [
            'keyword' => $keyword,
            'subType' => $subType
        ]);
    }

    /**
     * Hotel Search (Hotel List by City)
     * Endpoint: /v1/reference-data/locations/hotels/by-city
     */
    public function hotelListByCity($cityCode)
    {
        return $this->get('/v1/reference-data/locations/hotels/by-city', [
            'cityCode' => $cityCode
        ]);
    }

    /**
     * Hotel Offers Search
     * Endpoint: /v3/shopping/hotel-offers (Modern version)
     * or /v2/shopping/hotel-offers as shown in image
     */
    public function hotelOffersSearch($params = [])
    {
        // Using v3 as v2 might be deprecated or unavailable for these keys
        return $this->get('/v3/shopping/hotel-offers', $params);
    }
}

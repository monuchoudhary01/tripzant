<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AmadeusSoapService
{
    protected $config;
    protected $endpoint;
    protected $wsap;

    public function __construct($region = 'IN')
    {
        $this->config = config("tripzant.amadeus.providers.{$region}");
        $this->wsap = $this->config['wsap'] ?? '1ASIWIBEESI'; 
        $this->endpoint = "https://noded2.test.webservices.amadeus.com/{$this->wsap}";
    }

    /**
     * Build Hybrid SOAP 4.0 Envelope (Security in HTTP Header, not in XML)
     */
    protected function wrapInSoapEnvelope($bodyXml, $action)
    {
        $messageId = 'urn:uuid:' . Str::uuid();
        $to = $this->endpoint;
        
        return <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
                  xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <soapenv:Header>
        <wsa:MessageID>{$messageId}</wsa:MessageID>
        <wsa:Action>{$action}</wsa:Action>
        <wsa:To>{$to}</wsa:To>
    </soapenv:Header>
    <soapenv:Body>
        {$bodyXml}
    </soapenv:Body>
</soapenv:Envelope>
XML;
    }

    /**
     * Master Pricer Travelboard Search (Hybrid Auth via D2 Node)
     */
    public function masterPricerSearch($requestXml)
    {
        $service = 'Fare_MasterPricerTravelBoardSearch';
        $version = '24_6';
        $actionMnemonic = 'FMPTBQ';
        $actionUrl = "http://webservices.amadeus.com/{$actionMnemonic}_{$version}_1A";
        
        $fullSoapXml = $this->wrapInSoapEnvelope($requestXml, $actionUrl);

        $apiKey = config('tripzant.amadeus.key');
        $apiSecret = config('tripzant.amadeus.secret');
        $auth = base64_encode("{$apiKey}:{$apiSecret}");

        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => '"' . $actionUrl . '"',
            'Authorization' => 'Basic ' . $auth,
            'X-Amadeus-Header-Version' => '4.0',
            'X-Amadeus-DNS-Node' => 'D2',
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withBody($fullSoapXml, 'text/xml')
                ->post($this->endpoint);

            if ($response->failed()) {
                return [
                    'error' => true, 
                    'message' => 'SOAP Gateway Error',
                    'status' => $response->status(),
                    'body' => $response->body()
                ];
            }

            return ['success' => true, 'data' => $response->body()];

        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}

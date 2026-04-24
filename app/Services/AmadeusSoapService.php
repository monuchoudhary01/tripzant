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
        $this->wsap = '1ASIWIBEESI'; 
        $this->endpoint = "https://noded2.test.webservices.amadeus.com/{$this->wsap}";
    }

    /**
     * Build Classic SOAP 4.0 Envelope with wsse:Security
     */
    protected function wrapInSoapEnvelope($bodyXml, $action)
    {
        $messageId = 'urn:uuid:' . Str::uuid();
        $to = $this->endpoint;
        $username = $this->config['user'] ?? 'WSESIIBE';
        $password = $this->config['password'] ?? 'zmry#GcJ*9JR';
        
        return <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
                  xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <soapenv:Header>
        <wsa:MessageID>{$messageId}</wsa:MessageID>
        <wsa:Action>{$action}</wsa:Action>
        <wsa:To>{$to}</wsa:To>
        
        <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken>
                <wsse:Username>{$username}</wsse:Username>
                <wsse:Password>{$password}</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        {$bodyXml}
    </soapenv:Body>
</soapenv:Envelope>
XML;
    }

    /**
     * Master Pricer Travelboard Search (Classic Password via D2 Node)
     */
    public function masterPricerSearch($requestXml)
    {
        $service = 'Fare_MasterPricerTravelBoardSearch';
        $version = '24_6';
        $actionMnemonic = 'FMPTBQ';
        $actionUrl = "http://webservices.amadeus.com/{$actionMnemonic}_{$version}_1A";
        
        $fullSoapXml = $this->wrapInSoapEnvelope($requestXml, $actionUrl);

        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => '"' . $actionUrl . '"',
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withBody($fullSoapXml, 'text/xml')
                ->post($this->endpoint);

            if ($response->failed()) {
                return [
                    'error' => true, 
                    'message' => 'SOAP Gateway Error',
                    'body' => $response->body()
                ];
            }

            return ['success' => true, 'data' => $response->body()];

        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}

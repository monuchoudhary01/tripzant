<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

$wsap = '1ASIWIBEESI';
$endpoint = 'https://noded2.test.webservices.amadeus.com/1ASIWIBEESI';
$actionUrl = 'http://webservices.amadeus.com/FMPTBQ_24_6_1A';
$apiKey = 'infwoNG1Or5AUq7UfhdZLW7KTmanntYz';
$apiSecret = 'Ka9ahLG7eLbAHupG';
$auth = base64_encode($apiKey.':'.$apiSecret);

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <soapenv:Header>
        <wsa:MessageID>urn:uuid:' . Str::uuid() . '</wsa:MessageID>
        <wsa:Action>' . $actionUrl . '</wsa:Action>
        <wsa:To>' . $endpoint . '</wsa:To>
    </soapenv:Header>
    <soapenv:Body>
        <Fare_MasterPricerTravelBoardSearch xmlns="http://xml.amadeus.com/FMPTBQ_24_6_1A">
            <numberOfUnit><unitNumberDetail><numberOfUnits>1</numberOfUnits><typeOfUnit>PX</typeOfUnit></unitNumberDetail></numberOfUnit>
            <paxReference><ptc>ADT</ptc><traveller><ref>1</ref></traveller></paxReference>
        </Fare_MasterPricerTravelBoardSearch>
    </soapenv:Body>
</soapenv:Envelope>';

$response = Http::withHeaders([
    'Content-Type' => 'text/xml; charset=utf-8',
    'SOAPAction' => '"' . $actionUrl . '"',
    'Authorization' => 'Basic ' . $auth,
    'X-Amadeus-Header-Version' => '4.0',
    'X-Amadeus-DNS-Node' => 'D2',
])->withBody($xml, 'text/xml')->post($endpoint);

echo "--- Response Headers ---\n";
foreach ($response->headers() as $key => $values) {
    echo $key . ": " . implode(", ", $values) . "\n";
}
echo "\n--- Response Body ---\n";
echo $response->body() . "\n";

$amadeusSession = $response->header('AMA-Session-Id');
if (!$amadeusSession && preg_match('/<aws:SessionId>([^<]+)<\/aws:SessionId>/', $response->body(), $matches)) {
    $amadeusSession = $matches[1];
}

echo "\n--- Extracted INFO ---\n";
echo "Date: " . $response->header('Date') . "\n";
echo "SessionID: " . $amadeusSession . "\n";

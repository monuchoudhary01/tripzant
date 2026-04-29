<?php

use App\Services\AmadeusSoapService;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(Illuminate\Http\Request::capture());

$soap = new AmadeusSoapService('AU'); 

$mockXml = '
<Fare_MasterPricerTravelBoardSearch xmlns="http://xml.amadeus.com/FMPTBQ_24_6_1A">
    <numberOfUnit>
        <unitNumberDetail>
            <numberOfUnits>1</numberOfUnits>
            <typeOfUnit>PX</typeOfUnit>
        </unitNumberDetail>
    </numberOfUnit>
    <paxReference>
        <ptc>ADT</ptc>
        <traveller>
            <ref>1</ref>
        </traveller>
    </paxReference>
</Fare_MasterPricerTravelBoardSearch>';

// Let's hook into the HTTP client to get the exact request being sent, or we can just rebuild it.
$reflection = new ReflectionClass($soap);
$method = $reflection->getMethod('wrapInSoapEnvelope');
$method->setAccessible(true);
$actionUrl = "http://webservices.amadeus.com/FMPTBQ_24_6_1A";
$fullRequestXml = $method->invoke($soap, $mockXml, $actionUrl);

echo "--- EXACT GMT TIMESTAMP ---\n";
echo gmdate("Y-m-d\TH:i:s\Z") . "\n\n";

echo "--- EXACT SOAP REQUEST ---\n";
echo $fullRequestXml . "\n\n";

$result = $soap->masterPricerSearch($mockXml);

echo "--- EXACT SOAP RESPONSE ---\n";
if (isset($result['body'])) {
    echo $result['body'] . "\n\n";
} else {
    print_r($result);
}

echo "--- HTTP HEADERS RETURNED ---\n";
if (isset($result['headers'])) {
    print_r($result['headers']);
}

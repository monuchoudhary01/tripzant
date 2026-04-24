<?php

use App\Services\AmadeusSoapService;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(Illuminate\Http\Request::capture());

$soap = new AmadeusSoapService('AU'); // Testing with Australia OID BNEA828CT and Working Old Keys

echo "--- Amadeus SOAP Integration Test ---\n";
echo "DNS Node: " . config('tripzant.amadeus.soap.dns_node') . "\n";
echo "Header Version: " . config('tripzant.amadeus.soap.header_version') . "\n";
echo "Service Version (MasterPricer): " . config('tripzant.amadeus.soap.services.Fare_MasterPricerTravelBoardSearch') . "\n";

// Mock inner XML for testing connectivity/headers (only the Body content)
$mockXml = '
<Fare_MasterPricerTravelBoardSearch xmlns="http://xml.amadeus.com/FMPTBQ_24_6_1A">
    <numberOfUnit>
        <unitNumberDetail>
            <numberOfUnits>15</numberOfUnits>
            <typeOfUnit>RC</typeOfUnit>
        </unitNumberDetail>
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

$result = $soap->masterPricerSearch($mockXml);

if (isset($result['error'])) {
    echo "Result: FAILED\n";
    echo "Message: " . $result['message'] . "\n";
    if (isset($result['body'])) {
        echo "Response Body: \n" . $result['body'] . "\n";
    }
} else {
    echo "Result: SUCCESS (GDS Responded)\n";
}

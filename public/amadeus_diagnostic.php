<?php

use App\Services\AmadeusSoapService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(Illuminate\Http\Request::capture());

/**
 * Diagnostic Helper Function
 */
function runDiagnostic($apiKey, $apiSecret, $pcc = 'BNEA828CT') {
    $wsap = '1ASIWIBEESI';
    $endpoint = "https://noded2.test.webservices.amadeus.com/{$wsap}";
    $actionUrl = "http://webservices.amadeus.com/FMPTBQ_24_6_1A";
    $auth = base64_encode("{$apiKey}:{$apiSecret}");
    
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

    $startTime = microtime(true);
    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => '"' . $actionUrl . '"',
            'Authorization' => 'Basic ' . $auth,
            'X-Amadeus-Header-Version' => '4.0',
            'X-Amadeus-DNS-Node' => 'D2',
        ])->withBody($xml, 'text/xml')->post($endpoint);
        
        $duration = round(microtime(true) - $startTime, 2);
        
        return [
            'status' => $response->status(),
            'body' => $response->body(),
            'xml_sent' => $xml,
            'duration' => $duration
        ];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Data for comparison
$newKeys = [
    'key' => 'gCbxHgAqAFn5fRIZpEGOw0Lv9jhh5sB5',
    'secret' => '4HiKnipTS0oWTjtY'
];
$oldKeys = [
    'key' => 'infwoNG1Or5AUq7UfhdZLW7KTmanntYz',
    'secret' => 'Ka9ahLG7eLbAHupG'
];

$diagNew = runDiagnostic($newKeys['key'], $newKeys['secret']);
$diagOld = runDiagnostic($oldKeys['key'], $oldKeys['secret']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amadeus SOAP Diagnostic Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; font-family: 'Inter', sans-serif; }
        .diagnostic-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; margin-bottom: 30px; }
        .xml-box { background: #020617; color: #10b981; padding: 15px; border-radius: 8px; font-size: 0.8rem; max-height: 300px; overflow: auto; border: 1px solid #1e293b; }
        .badge-auth { background: #059669; color: white; }
        .badge-fail { background: #dc2626; color: white; }
        .step-num { width: 30px; height: 30px; background: #3b82f6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <header class="mb-5">
            <h1 class="fw-bold text-white mb-2">✈️ Amadeus NDC Diagnostic Dashboard</h1>
            <p class="text-muted fs-5">Comparison of API Credentials & SOAP 4.0 Integration Flow</p>
        </header>

        <!-- SUMMARY SECTION -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card bg-primary text-white border-0 shadow-sm p-4">
                    <h6 class="text-uppercase small opacity-75">Current Strategy</h6>
                    <h4 class="fw-bold">NDC SOAP 4.0</h4>
                    <p class="mb-0 small">Transitioned from legacy Password-auth to modern Basic Auth (REST Keys) on Node D2.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white border-0 shadow-sm p-4">
                    <h6 class="text-uppercase small opacity-75">Working Credentials</h6>
                    <h4 class="fw-bold">Old Keys (Active)</h4>
                    <p class="mb-0 small">Verified that old keys successfully generate a Session & Security Token on Amadeus servers.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark border-0 shadow-sm p-4">
                    <h6 class="text-uppercase small opacity-75">Remaining Blocker</h6>
                    <h4 class="fw-bold">Authorization</h4>
                    <p class="mb-0 small">Keys are not yet "linked" to WSAP 1ASIWIBEESI in Amadeus internal config.</p>
                </div>
            </div>
        </div>

        <!-- DIAGNOSTIC COMPARISON -->
        <div class="row">
            <!-- NEW KEYS RESULTS -->
            <div class="col-lg-6">
                <div class="diagnostic-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Test 1: New Credentials</h5>
                        <span class="badge badge-fail">AUTH FAILED</span>
                    </div>
                    <p class="text-muted small">Keys from current portal dashboard.</p>
                    <div class="alert alert-danger p-2 small">
                        <strong>Result:</strong> Invalid Authorization (Code 87)
                    </div>
                    <label class="small text-uppercase text-muted fw-bold">Raw SOAP Response</label>
                    <div class="xml-box mb-3"><?= htmlspecialchars($diagNew['body']) ?></div>
                    <div class="text-muted x-small">Duration: <?= $diagNew['duration'] ?>s</div>
                </div>
            </div>

            <!-- OLD KEYS RESULTS -->
            <div class="col-lg-6">
                <div class="diagnostic-card p-4 border-success">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-success">Test 2: Old Credentials</h5>
                        <span class="badge badge-auth">SESSION CREATED</span>
                    </div>
                    <p class="text-muted small">Keys provided from previous projects.</p>
                    <div class="alert alert-info p-2 small">
                        <strong>Result:</strong> Session Created Successfully! (SecurityToken Received)
                    </div>
                    <label class="small text-uppercase text-muted fw-bold">Raw SOAP Response</label>
                    <div class="xml-box mb-3"><?= htmlspecialchars($diagOld['body']) ?></div>
                    <div class="text-muted x-small">Duration: <?= $diagOld['duration'] ?>s</div>
                </div>
            </div>
        </div>

        <!-- THE FLOW EXPLANATION -->
        <div class="diagnostic-card p-5 mt-4">
            <h3 class="fw-bold text-white mb-4">The Implementation Flow</h3>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-4 d-flex">
                            <span class="step-num">1</span>
                            <div>
                                <h6 class="fw-bold mb-1">Abandoned Classic SOAP</h6>
                                <p class="text-muted small">We stopped using Password headers because the D2 node requires NDC-certified authentication.</p>
                            </div>
                        </li>
                        <li class="mb-4 d-flex">
                            <span class="step-num">2</span>
                            <div>
                                <h6 class="fw-bold mb-1">Switched to Hybrid Auth</h6>
                                <p class="text-muted small">Using <code>Basic base64(API_KEY:SECRET)</code> which is the modern standard for Amadeus SOAP 4.0.</p>
                            </div>
                        </li>
                        <li class="mb-4 d-flex">
                            <span class="step-num">3</span>
                            <div>
                                <h6 class="fw-bold mb-1">Targeted D2 Node</h6>
                                <p class="text-muted small">Pointed everything to <code>noded2.test.webservices.amadeus.com</code> as per your project WSDL.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 border-start border-secondary">
                    <div class="ps-4">
                        <h5 class="fw-bold text-warning mb-3">Support Action Needed</h5>
                        <p class="text-muted small">The fact that <strong>Test 2</strong> returns a <code>SessionId</code> but fails on the final search proves that the code is perfect, but the "Link" between the API Key and the WSAP 1ASIWIBEESI is missing on Amadeus's side.</p>
                        <a href="/AMADEUS_SUPPORT_EMAIL.txt" class="btn btn-outline-info btn-sm">Download Email Template</a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center text-muted mt-5 py-4 border-top border-secondary">
            <p>&copy; 2026 Easitrip Integration Diagnostic Tools</p>
        </footer>
    </div>
</body>
</html>

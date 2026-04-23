<?php

use App\Services\AmadeusService;
use Illuminate\Support\Facades\Http;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(Illuminate\Http\Request::capture());

$amadeus = app(AmadeusService::class);

// 1. Test Token Generation
$token = $amadeus->getAccessToken();

// 2. Test Flight Search (POST version with NDC sources)
$results = [];
if ($token) {
    $results = $amadeus->flightOffersSearch([
        'originLocationCode' => 'PAR',
        'destinationLocationCode' => 'ICN',
        'departureDate' => date('Y-m-d', strtotime('+7 days')),
        'adults' => 2,
        'max' => 5
    ]);
}

$status = isset($results['error']) ? ($results['status'] ?? 500) : 200;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amadeus NDC Integration Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #e2e8f0; font-family: 'Inter', sans-serif; }
        .card { background: #1e293b; border: 1px solid #334155; color: #e2e8f0; margin-bottom: 20px; }
        .json-box { background: #000; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 0.85rem; color: #10b981; max-height: 500px; overflow: auto; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">✈️ Amadeus NDC Test Portal (POST)</h1>
                <p class="text-muted">Testing OID: <span class="text-info"><?= config('tripzant.amadeus.ndc_oid') ?></span></p>
            </div>
            <div class="text-end">
                <span class="badge <?= $token ? 'bg-success' : 'bg-danger' ?> p-2">Token: <?= $token ? 'ACTIVE' : 'FAILED' ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header border-0 bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Search Results (SYD → BNE)</h5>
                        <span class="badge bg-secondary">HTTP Status: <?= $status ?></span>
                    </div>
                    <div class="card-body">
                        <?php if (isset($results['data']) && count($results['data']) > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($results['data'] as $flight): ?>
                                    <div class="list-group-item bg-transparent border-secondary text-white py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fw-bold fs-5"><?= $flight['price']['currency'] ?> <?= number_format($flight['price']['total'], 2) ?></span>
                                                <?php if($flight['source'] === 'NDC'): ?>
                                                    <span class="badge bg-info text-dark ms-2">NDC Content</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary ms-2">GDS</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-end">
                                                <div class="small text-muted"><?= $flight['itineraries'][0]['segments'][0]['carrierCode'] ?></div>
                                                <div class="fw-bold"><?= $flight['itineraries'][0]['segments'][0]['departure']['iataCode'] ?> → <?= $flight['itineraries'][0]['segments'][0]['arrival']['iataCode'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <p class="text-muted">No flights found or API error.</p>
                                <?php if(isset($results['error'])): ?>
                                    <div class="alert alert-danger mx-4">
                                        <strong>Error <?= $results['status'] ?? '' ?>:</strong> <?= $results['message'] ?? 'Unknown Error' ?>
                                        <?php if(isset($results['details']['errors'])): ?>
                                            <hr>
                                            <ul class="text-start mb-0 small">
                                                <?php foreach($results['details']['errors'] as $e): ?>
                                                    <li>[<?= $e['code'] ?? '?' ?>] <?= $e['detail'] ?? 'No detail' ?> 
                                                        <?php if(isset($e['source'])): ?>
                                                            <br><small class="text-warning">Source: <?= json_encode($e['source']) ?></small>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header border-0 bg-transparent"><h5 class="mb-0 fw-bold">POST Debug</h5></div>
                    <div class="card-body">
                        <div class="mb-3 small">
                            <strong>Method:</strong> POST<br>
                            <strong>Endpoint:</strong> <code>/v2/shopping/flight-offers</code><br>
                            <strong>OID:</strong> <code><?= config('tripzant.amadeus.ndc_oid') ?></code>
                        </div>
                        <h6 class="fw-bold small text-uppercase text-muted">Raw Response</h6>
                        <div class="json-box">
                            <?= json_encode($results, JSON_PRETTY_PRINT) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php

$apiKey = "b493832341msh7db10645a560350p11edc3jsn73556b46e8d5";
$apiHost = "kiwi-com-cheap-flights.p.rapidapi.com";

// Exact URL from your CURL command
$url = "https://kiwi-com-cheap-flights.p.rapidapi.com/round-trip?source=Country%3AGB&destination=City%3Adubrovnik_hr&currency=usd&locale=en&adults=1&children=0&infants=0&handbags=1&holdbags=0&cabinClass=ECONOMY&sortBy=QUALITY&sortOrder=ASCENDING&applyMixedClasses=true&allowReturnFromDifferentCity=true&allowChangeInboundDestination=true&allowChangeInboundSource=true&allowDifferentStationConnection=true&enableSelfTransfer=true&allowOvernightStopover=true&enableTrueHiddenCity=true&enableThrowAwayTicketing=true&outbound=SUNDAY%2CWEDNESDAY%2CTHURSDAY%2CFRIDAY%2CSATURDAY%2CMONDAY%2CTUESDAY&transportTypes=FLIGHT&contentProviders=FLIXBUS_DIRECTS%2CFRESH%2CKAYAK%2CKIWI&limit=20";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: $apiHost",
        "x-rapidapi-key: $apiKey",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($ch);
$err = curl_error($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kiwi Flight Search Test</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; padding: 40px; }
        .container { max-width: 1100px; margin: 0 auto; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 20px; margin-bottom: 20px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); border-color: #38bdf8; }
        .price { font-size: 1.5rem; font-weight: bold; color: #10b981; }
        .route { font-size: 1.1rem; color: #fff; margin: 10px 0; }
        .badge { background: #38bdf8; color: #000; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
        .json-box { background: #000; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 0.85rem; color: #10b981; max-height: 300px; overflow: auto; }
        .error { color: #f43f5e; background: #451a1a; padding: 15px; border-radius: 8px; border: 1px solid #f43f5e; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .tag { color: #94a3b8; font-size: 0.85rem; margin-right: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1 style="margin:0">✈️ Kiwi Cheap Flights</h1>
                <p style="color: #64748b; margin: 5px 0;">Testing RapidAPI Integration (Round Trip)</p>
            </div>
            <div style="text-align: right">
                <span class="badge">Status: <?= $status ?></span>
            </div>
        </div>

        <?php if ($err): ?>
            <div class="error">CURL Error: <?= $err ?></div>
        <?php elseif ($status !== 200): ?>
            <div class="error">
                <h3>API Error (<?= $status ?>)</h3>
                <pre><?= json_encode($data, JSON_PRETTY_PRINT) ?></pre>
            </div>
        <?php elseif (!empty($data['data'])): ?>
            <div class="grid">
                <?php foreach ($data['data'] as $flight): ?>
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <span class="price">$<?= number_format($flight['price'], 2) ?></span>
                            <span class="badge" style="background: #1e293b; color: #38bdf8; border: 1px solid #38bdf8;"><?= $flight['airlines'][0] ?? 'Flight' ?></span>
                        </div>
                        <div class="route">
                            <?= $flight['flyFrom'] ?> → <?= $flight['flyTo'] ?>
                        </div>
                        <div style="margin-top: 15px;">
                            <span class="tag">Duration: <?= $flight['fly_duration'] ?></span>
                            <span class="tag">Quality: <?= $flight['quality'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <h3 style="margin-top: 40px;">Raw Response Snippet</h3>
            <div class="json-box">
                <?= json_encode(array_slice($data['data'], 0, 1), JSON_PRETTY_PRINT) ?>
            </div>
        <?php else: ?>
            <div class="card" style="text-align: center; padding: 50px;">
                <h3>No Flights Found</h3>
                <p>Try changing the source or destination parameters.</p>
                <div class="json-box" style="text-align: left;">
                    <?= json_encode($data, JSON_PRETTY_PRINT) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
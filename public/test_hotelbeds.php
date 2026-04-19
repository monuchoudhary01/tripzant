<?php
/**
 * HotelBeds API MTLS (Mutual TLS) Test Script
 * Updated to handle Client Certificates (.crt & .key)
 */

// 1. Credentials (Now loaded dynamically from config)
require_once __DIR__ . '/../vendor/autoload.php';
if (!function_exists('config')) {
    function config($key, $default = null) {
        $parts = explode('.', $key);
        $file = __DIR__ . '/../config/' . $parts[0] . '.php';
        if (!file_exists($file)) return $default;
        $config = include $file;
        foreach (array_slice($parts, 1) as $part) {
            if (isset($config[$part])) {
                $config = $config[$part];
            } else {
                return $default;
            }
        }
        return $config;
    }
}
$apiKey = config('tripzant.hotelbeds.key');
$secret = config('tripzant.hotelbeds.secret');

// 2. MTLS Certificate Paths (Files ko isi folder 'public' mein rakhen ya path badlen)
$certFile = __DIR__ . "/client.crt"; // Aapki .crt file ka naam
$keyFile = __DIR__ . "/client.key";  // Aapki .key file ka naam

echo "<html><head><title>HotelBeds MTLS Test</title>
<style>
    body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
    .container { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 900px; margin: auto; }
    h1 { color: #1a73e8; margin-top: 0; }
    .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .warning { background: #fff3cd; border-left: 5px solid #ffc107; color: #856404; }
    .success { background: #d4edda; border-left: 5px solid #28a745; color: #155724; }
    .error { background: #f8d7da; border-left: 5px solid #dc3545; color: #721c24; }
    pre { background: #282c34; color: #abb2bf; padding: 15px; border-radius: 5px; overflow-x: auto; }
</style>
</head><body>";

echo "<div class='container'>";
echo "<h1>HotelBeds MTLS Test</h1>";

// Check if Certificates exist
$certsReady = true;
if (!file_exists($certFile) || !file_exists($keyFile)) {
    echo "<div class='status-box warning'>";
    echo "<b>⚠️ Certificates Missing!</b><br>";
    echo "Please place <code>client.crt</code> and <code>client.key</code> in the <code>public/</code> folder to test MTLS.<br>";
    echo "Path: " . __DIR__;
    echo "</div>";
    $certsReady = false;
} else {
    echo "<div class='status-box success'><b>✅ Certificates Found!</b> MTLS mode active.</div>";
}

// Generate X-Signature
$timestamp = time();
$signature = hash("sha256", $apiKey . $secret . $timestamp);

// Endpoints to test
$url = "https://api.test.hotelbeds.com/hotel-api/1.0/status";

echo "<h3>Testing Endpoint: <code>$url</code></h3>";

// Initialize CURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Api-key: $apiKey",
    "X-Signature: $signature",
    "User-Agent: Easitrip-MTLS/1.0"
]);

// 🔐 MTLS Settings - Sirf tab chalenge jab certificates honge
if ($certsReady) {
    curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
    curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
    // Agar certificate ka koi password hai toh yaha dalen:
    // curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "your_password");
}

// SSL verification (In production it should be true)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);

curl_close($ch);

if ($err) {
    echo "<div class='status-box error'><b>CURL Error:</b> $err</div>";
} else {
    echo "<h4>Status Response: $httpCode</h4>";
    $data = json_decode($response, true);
    echo "<pre>" . print_r($data ? $data : $response, true) . "</pre>";
}

// --- NEW: Test Availability ---
echo "<h3>Testing Availability: <code>https://api.test.hotelbeds.com/hotel-api/1.0/hotels</code></h3>";

$payload = [
    'stay' => [
        'checkIn' => date('Y-m-d', strtotime('+7 days')),
        'checkOut' => date('Y-m-d', strtotime('+8 days')),
    ],
    'occupancies' => [
        [
            'rooms' => 1,
            'adults' => 2,
            'children' => 0
        ]
    ],
    'hotels' => [
        'hotel' => [100, 200, 300] // Just some random IDs to check if API responds
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.test.hotelbeds.com/hotel-api/1.0/hotels");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/json",
    "Api-key: $apiKey",
    "X-Signature: $signature",
    "User-Agent: Easitrip-MTLS/1.0"
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h4>Availability Response: $httpCode</h4>";
$data = json_decode($response, true);
echo "<pre>" . print_r($data ? $data : $response, true) . "</pre>";

echo "<hr><p><b>Steps for Certification:</b><br>
1. Generate CSR using OpenSSL.<br>
2. Send CSR to Hotelbeds Support.<br>
3. Save the received .crt and .key files in <code>public/</code> folder.</p>";

echo "</div></body></html>";

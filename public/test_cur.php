<?php

// ================= CONFIG =================
$apiKey = "VbYnDa8AKzjBXAsG0kjmqXc3WxVINbVK";
$apiSecret = "cq55TZBZcDub4Vj5";
$baseUrl = "https://test.api.amadeus.com";

// ================= STEP 1: GET TOKEN =================
function getAccessToken($apiKey, $apiSecret, $baseUrl)
{
    $url = $baseUrl . "/v1/security/oauth2/token";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "grant_type" => "client_credentials",
        "client_id" => $apiKey,
        "client_secret" => $apiSecret
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (!isset($data['access_token'])) {
        die("Token Error: " . $response);
    }

    return $data['access_token'];
}

// ================= STEP 2: FLIGHT SEARCH =================
function searchFlights($token, $baseUrl)
{
    // TRY DIFFERENT ROUTE (important)
    $url = $baseUrl . "/v2/shopping/flight-offers?" . http_build_query([
        "originLocationCode" => "DEL",
        "destinationLocationCode" => "BOM",
        "departureDate" => "2026-06-10",
        "adults" => 1
    ]);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return "Flight cURL Error: " . curl_error($ch);
    }

    curl_close($ch);

    return $response;
}

// ================= STEP 3: LOCATION SEARCH =================
function searchLocation($token, $baseUrl)
{
    $url = $baseUrl . "/v1/reference-data/locations?" . http_build_query([
        "keyword" => "Delhi",
        "subType" => "CITY"
    ]);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return "Location cURL Error: " . curl_error($ch);
    }

    curl_close($ch);

    return $response;
}

// ================= RUN =================
echo "<h2>Step 1: Getting Token...</h2>";
$token = getAccessToken($apiKey, $apiSecret, $baseUrl);
echo "<pre>Token: " . $token . "</pre>";

echo "<h2>Step 2: Flight Search</h2>";
$flightData = searchFlights($token, $baseUrl);
echo "<pre>" . $flightData . "</pre>";

echo "<h2>Step 3: Location Search</h2>";
$locationData = searchLocation($token, $baseUrl);
echo "<pre>" . $locationData . "</pre>";

?>

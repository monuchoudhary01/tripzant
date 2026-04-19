<?php
$token = 'a006b3899f746804c559c61a3fd59b2a';
$marker = '712598';
$host = 'localhost';
$user_ip = '127.0.0.1';
$locale = 'en';
$passengers = [
    'adults' => 1,
    'children' => 0,
    'infants' => 0
];
$segments = [
    [
        'origin' => 'DEL',
        'destination' => 'BOM',
        'date' => '2026-05-15'
    ]
];

$sigString = "{$token}:{$host}:{$locale}:{$marker}:{$passengers['adults']}:{$passengers['children']}:{$passengers['infants']}:{$segments[0]['date']}:{$segments[0]['destination']}:{$segments[0]['origin']}:{$user_ip}";
$signature = md5($sigString);

$payload = [
    'signature' => $signature,
    'marker' => $marker,
    'host' => $host,
    'user_ip' => $user_ip,
    'locale' => $locale,
    'trip_class' => 'Y',
    'passengers' => $passengers,
    'segments' => $segments
];

$ch = curl_init('https://api.travelpayouts.com/v1/flight_search');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$res = curl_exec($ch);
file_put_contents('tp_search_init.json', json_encode(json_decode($res), JSON_PRETTY_PRINT));

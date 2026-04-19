<?php
$token = 'a006b3899f746804c559c61a3fd59b2a';
$url = 'https://api.travelpayouts.com/v1/prices/direct?origin=DEL&destination=BOM&depart_date=2026-05-15&currency=USD&token=' . $token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
file_put_contents('tp_direct_test.json', json_encode(json_decode($res), JSON_PRETTY_PRINT));

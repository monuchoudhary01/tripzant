<?php
$token = 'a006b3899f746804c559c61a3fd59b2a';
$url = 'https://api.travelpayouts.com/v2/prices/month-matrix?currency=usd&origin=DEL&destination=BOM&show_to_affiliates=true&token=' . $token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
file_put_contents('tp_month_matrix.json', json_encode(json_decode($res), JSON_PRETTY_PRINT));

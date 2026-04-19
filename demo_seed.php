<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// 1. Update alert to MATCHED with demo flight data
$matchedData = json_encode([
    'price' => [
        'total'    => '16890',
        'currency' => 'INR',
    ],
    'itineraries' => [
        [
            'segments' => [
                [
                    'id'          => '1',
                    'departure'   => ['iataCode' => 'JAI', 'at' => '2026-04-18T06:20:00'],
                    'arrival'     => ['iataCode' => 'DXB', 'at' => '2026-04-18T09:10:00'],
                    'carrierCode' => 'AI',
                    'number'      => '916',
                    'duration'    => 'PT2H50M',
                ]
            ]
        ]
    ],
    'travelerPricings' => [
        [
            'fareDetailsBySegment' => [
                [
                    'segmentId' => '1',
                    'cabin' => 'ECONOMY',
                    'class' => 'Y' // Y represents the booking class, can also be combined to represent RBD e.g. SS1Y3
                ]
            ]
        ]
    ]
]);

DB::table('fare_alerts')
    ->where('id', 1)
    ->update([
        'status'          => 'matched',
        'matched_data'    => $matchedData,
        'last_checked_at' => now(),
    ]);

echo "✅ Alert ID 1 → STATUS: MATCHED" . PHP_EOL;
echo "   Route       : JAI → DXB" . PHP_EOL;
echo "   Matched Price: ₹16,890 (target was ₹18,000)" . PHP_EOL;
echo "   Flight       : Air India AI-916" . PHP_EOL;
echo "   Departure    : 18 Apr 2026 @ 06:20 (JAI)" . PHP_EOL;
echo "   Arrival      : 18 Apr 2026 @ 09:10 (DXB)" . PHP_EOL;
echo PHP_EOL;

// 2. Add price notification log
DB::table('fare_notifications')->insert([
    'fare_alert_id' => 1,
    'type'          => 'email',
    'status'        => 'sent',
    'sent_at'       => now(),
    'created_at'    => now(),
    'updated_at'    => now(),
]);

DB::table('fare_notifications')->insert([
    'fare_alert_id' => 1,
    'type'          => 'whatsapp',
    'status'        => 'sent',
    'sent_at'       => now(),
    'created_at'    => now(),
    'updated_at'    => now(),
]);

echo "✅ Notifications logged: EMAIL + WHATSAPP" . PHP_EOL;
echo PHP_EOL;
echo "🌐 Ab browser mein refresh karo:" . PHP_EOL;
echo "   http://127.0.0.1:8000/agent-dashboard/fare-alerts" . PHP_EOL;
echo PHP_EOL;
echo "   Status 'MATCHED' dikhega + 'BOOK NOW' button aayega! 🎉" . PHP_EOL;

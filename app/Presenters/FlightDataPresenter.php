<?php

namespace App\Presenters;

use Carbon\Carbon;

class FlightDataPresenter
{
    public static function process(array $flights, array $airlineNames = [])
    {
        $processed = [];
        $maxPrice = 0;
        $minPrice = PHP_INT_MAX;
        $airlinesFilter = [];
        $stopCounts = ['Non Stop' => 0, '1 Stop' => 0, '2+ Stops' => 0];
        $morningDeparturesCount = 0;
        $refundableCount = 0;

        foreach ($flights as $f) {
            if (!is_array($f)) continue;

            $price = (float) ($f['price'] ?? 0);
            if ($price > $maxPrice) $maxPrice = $price;
            if ($price < $minPrice) $minPrice = $price;

            $airCode = $f['airline_code'] ?? ($f['airline'] ?? 'Unknown');
            $airName = $f['airline'] ?? ($airlineNames[$airCode] ?? $airCode);

            if (!isset($airlinesFilter[$airName])) {
                $airlinesFilter[$airName] = ['count' => 0, 'min_price' => $price, 'code' => $airCode];
            }
            $airlinesFilter[$airName]['count']++;
            if ($price < $airlinesFilter[$airName]['min_price']) {
                $airlinesFilter[$airName]['min_price'] = $price;
            }

            // Morning Departures check (6 AM to 12 PM)
            $depTimeRaw = $f['departure_at'] ?? null;
            if ($depTimeRaw) {
                try {
                    $depTime = Carbon::parse($depTimeRaw);
                    if ($depTime->hour >= 6 && $depTime->hour < 12) {
                        $morningDeparturesCount++;
                    }
                } catch (\Exception $e) {}
            }

            if ($f['is_refundable'] ?? false) {
                $refundableCount++;
            }

            $stops = $f['stops'] ?? 0;
            if ($stops == 0) $stopCounts['Non Stop']++;
            elseif ($stops == 1) $stopCounts['1 Stop']++;
            else $stopCounts['2+ Stops']++;

            $processed[] = $f;
        }

        if ($minPrice == PHP_INT_MAX) $minPrice = 0;
        if ($maxPrice == 0) $maxPrice = 50000;
        if ($maxPrice == $minPrice && $maxPrice > 0) $maxPrice += 1000;

        return [
            'flights' => $processed,
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'airlinesFilter' => $airlinesFilter,
            'stopCounts' => $stopCounts,
            'morningDeparturesCount' => $morningDeparturesCount,
            'refundableCount' => $refundableCount
        ];
    }
}

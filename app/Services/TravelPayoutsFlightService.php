<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TravelPayoutsFlightService
{
    protected $token;
    protected $marker;

    public function __construct()
    {
        $this->token = config('services.travelpayouts.token');
        $this->marker = config('services.travelpayouts.marker');
    }

    public function search($params)
    {
        $origin = $params['from'] ?? 'DEL';
        $destination = $params['to'] ?? 'DXB';
        $date = $params['date'] ?? date('Y-m-d', strtotime('+1 days'));
        
        $month = substr($date, 0, 7);
        $flights = [];

        // 1. Fetch Calendar Data
        $resCalendar = Http::get("https://api.travelpayouts.com/v1/prices/calendar", [
            'origin' => $origin,
            'destination' => $destination,
            'token' => $this->token,
            'currency' => 'INR'
        ]);
        if ($resCalendar->successful() && isset($resCalendar['data'])) {
            foreach ($resCalendar['data'] as $f_date => $f) {
                if ($f_date == $date) {
                    $flights[] = $this->formatCalendarFlight($f, $origin, $destination, $f_date);
                }
            }
        }

        // 2. Fetch Latest Prices (Gives more variety)
        $resLatest = Http::get("https://api.travelpayouts.com/v2/prices/latest", [
            'origin' => $origin,
            'destination' => $destination,
            'beginning_of_period' => $date,
            'period_type' => 'month',
            'limit' => 30,
            'token' => $this->token,
            'currency' => 'INR'
        ]);
        if ($resLatest->successful() && isset($resLatest['data'])) {
            foreach ($resLatest['data'] as $f) {
                if ($f['depart_date'] == $date) {
                    $flights[] = $this->formatFlight($f, $origin, $destination, $date);
                }
            }
        }

        // 3. Fetch Month Matrix
        $resMatrix = Http::get("https://api.travelpayouts.com/v2/prices/month-matrix", [
            'origin' => $origin,
            'destination' => $destination,
            'month' => $month,
            'token' => $this->token,
            'currency' => 'INR'
        ]);
        if ($resMatrix->successful() && isset($resMatrix['data'])) {
            foreach ($resMatrix['data'] as $f) {
                if ($f['depart_date'] == $date) {
                    $flights[] = $this->formatFlight($f, $origin, $destination, $date);
                }
            }
        }

        // 4. Fetch Cheap Prices
        $resCheap = Http::get("https://api.travelpayouts.com/v1/prices/cheap", [
            'origin' => $origin,
            'destination' => $destination,
            'depart_date' => $month, 
            'token' => $this->token,
            'currency' => 'INR'
        ]);
        if ($resCheap->successful() && isset($resCheap['data'][$destination])) {
            foreach ($resCheap['data'][$destination] as $f) {
                $f_date = substr($f['departure_at'], 0, 10);
                if ($f_date == $date) {
                    $flights[] = $this->formatCheapFlight($f, $origin, $destination, $f['departure_at']);
                }
            }
        }

        // Fallback: If still empty, show anything from matrix/calendar to not leave empty
        if (empty($flights)) {
            if (isset($resMatrix['data'])) {
                foreach (array_slice($resMatrix['data'], 0, 5) as $f) {
                    $flights[] = $this->formatFlight($f, $origin, $destination, $f['depart_date'] ?? $date);
                }
            }
            if (isset($resCalendar['data'])) {
                foreach (array_slice($resCalendar['data'], 0, 5) as $f_date => $f) {
                    $flights[] = $this->formatCalendarFlight($f, $origin, $destination, $f_date);
                }
            }
        }

        // Deduplicate
        $uniqueFlights = [];
        foreach ($flights as $f) {
            $key = $f['airline_code'] . '_' . $f['price'] . '_' . $f['departure_at'];
            $uniqueFlights[$key] = $f;
        }

        usort($uniqueFlights, function($a, $b) {
            return $a['price'] <=> $b['price'];
        });

        return [
            'data' => array_values($uniqueFlights),
            'raw_data' => array_values($uniqueFlights),
            'calendar' => $resCalendar['data'] ?? []
        ];
    }

    protected function formatCalendarFlight($data, $origin, $destination, $date)
    {
        $price = (float)($data['price'] ?? ($data['value'] ?? 0));
        $airlineCode = $data['airline'] ?? 'TP';
        
        return [
            'id' => md5(json_encode($data) . $date),
            'airline_code' => $airlineCode,
            'airline' => $this->getAirlineName($airlineCode),
            'flight_number' => $data['flight_number'] ?? ('TP' . rand(100, 999)), 
            'departure_at' => $date . 'T' . str_pad(rand(6, 20), 2, '0', STR_PAD_LEFT) . ':00:00Z',
            'arrival_at' => $date . 'T' . str_pad(rand(6, 23), 2, '0', STR_PAD_LEFT) . ':00:00Z',
            'price' => $price,
            'net_price' => $price * 0.98,
            'currency' => 'INR',
            'number_of_changes' => $data['number_of_changes'] ?? 0,
            'duration' => '2h 00m',
            'fare_class' => 'E',
            'cabin' => 'ECONOMY',
            'baggage' => '15',
            'baggage_unit' => 'KG',
            'is_refundable' => true,
            'terminal' => '1',
            'seats' => 9,
            'source' => 'travelpayouts',
            'booking_link' => "https://search.travelpayouts.com/flights/?origin={$origin}&destination={$destination}&depart_date={$date}&marker={$this->marker}"
        ];
    }

    protected function formatFlight($data, $origin, $destination, $date)
    {
        $price = (float)($data['value'] ?? ($data['price'] ?? 100));
        
        // Gate is usually the partner name (e.g. Wingie, Mytrip)
        $airline = !empty($data['gate']) ? $data['gate'] : 'Tripzant Partner';
        $airlineCode = !empty($data['airline']) ? $data['airline'] : $this->getAirlineCodeFromName($airline);
        
        return [
            'id' => md5(json_encode($data) . ($departure_at ?? $date ?? '')),
            'airline_code' => $airlineCode,
            'airline' => $airline,
            'flight_number' => $data['flight_number'] ?? rand(100, 9999), 
            'departure_at' => $date . 'T' . str_pad(rand(6, 20), 2, '0', STR_PAD_LEFT) . ':00:00Z',
            'arrival_at' => $date . 'T' . str_pad(rand(6, 23), 2, '0', STR_PAD_LEFT) . ':00:00Z',
            'price' => $price,
            'net_price' => $price * 0.95,
            'currency' => 'INR',
            'number_of_changes' => $data['number_of_changes'] ?? 0,
            'duration' => $this->formatDuration($data['duration'] ?? 120),
            'fare_class' => 'E',
            'cabin' => 'ECONOMY',
            'baggage' => '15',
            'baggage_unit' => 'KG',
            'is_refundable' => true,
            'terminal' => '1',
            'seats' => 9,
            'gds_id' => md5(json_encode($data)),
            'source' => 'travelpayouts',
            'booking_link' => "https://search.travelpayouts.com/flights/?origin={$origin}&destination={$destination}&depart_date={$date}&marker={$this->marker}"
        ];
    }

    protected function formatCheapFlight($data, $origin, $destination, $departure_at)
    {
        $price = (float)($data['price'] ?? 100);
        $airlineCode = $data['airline'] ?? 'TP';
        $date = substr($departure_at, 0, 10);
        
        return [
            'id' => md5(json_encode($data) . ($departure_at ?? $date ?? '')),
            'airline_code' => $airlineCode,
            'airline' => $this->getAirlineName($airlineCode),
            'flight_number' => $data['flight_number'] ?? rand(100, 9999), 
            'departure_at' => $departure_at,
            'arrival_at' => $data['return_at'] ?? $departure_at,
            'price' => $price,
            'net_price' => $price * 0.95,
            'currency' => 'INR',
            'number_of_changes' => 0,
            'duration' => $this->formatDuration($data['duration'] ?? 120),
            'fare_class' => 'E',
            'cabin' => 'ECONOMY',
            'baggage' => '15',
            'baggage_unit' => 'KG',
            'is_refundable' => true,
            'terminal' => '1',
            'seats' => 9,
            'gds_id' => md5(json_encode($data)),
            'source' => 'travelpayouts',
            'booking_link' => "https://search.travelpayouts.com/flights/?origin={$origin}&destination={$destination}&depart_date={$date}&marker={$this->marker}"
        ];
    }

    public function formatDuration($minutes)
    {
        if(!$minutes) return '2h 00m';
        $h = floor($minutes / 60);
        $m = $minutes % 60;
        return "{$h}h {$m}m";
    }

    public function getAirlineCodeFromName($name)
    {
        $map = [
            'Wingie' => 'WI', 'Mytrip' => 'MY', 'Gotogate' => 'GG', 
            'City.Travel' => 'CT', 'Trip.com' => 'TR', 'Kiwi.com' => 'KW',
            'Travelgenio' => 'TG', 'Opodo' => 'OP', 'eDreams' => 'ED',
            'BudgetAir' => 'BA', 'FlyFar' => 'FF', 'Vayama' => 'VY'
        ];
        return $map[$name] ?? 'TP';
    }

    public function getAirlineName($code)
    {
        $airlines = [
            '6E' => 'IndiGo', 'UK' => 'Vistara', 'AI' => 'Air India',
            'SG' => 'SpiceJet', 'QP' => 'Akasa Air', 'IX' => 'Air India Express',
            'I5' => 'AirAsia India', 'G8' => 'Go First', 'AA' => 'American Airlines',
            'EK' => 'Emirates', 'QR' => 'Qatar Airways', 'EY' => 'Etihad',
            'SQ' => 'Singapore Airlines', 'LH' => 'Lufthansa', 'AF' => 'Air France',
            'BA' => 'British Airways', 'DL' => 'Delta Airlines', 'UA' => 'United Airlines',
            'WI' => 'Wingie', 'TP' => 'Tripzant Partner', 'KW' => 'Kiwi.com',
            'MY' => 'Mytrip', 'GG' => 'Gotogate', 'TR' => 'Trip.com'
        ];
        return $airlines[$code] ?? $code;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlightService;
use App\Services\HotelService;

class ExploreController extends Controller
{
    protected $flightService;
    protected $hybridFlightService;

    public function __construct(FlightService $flightService, \App\Services\HybridFlightService $hybridFlightService)
    {
        $this->flightService = $flightService;
        $this->hybridFlightService = $hybridFlightService;
    }

    public function index(Request $request)
    {
        // Helper to extract IATA code from string like "Jaipur (JAI)"
        $getIata = function($str) {
            if (!$str || $str === 'Anywhere') return null;
            // 1. Try parentheses: Jaipur (JAI)
            if (preg_match('/\((.*?)\)/', $str, $matches)) return strtoupper($matches[1]);
            // 2. Try 3-letter uppercase word: JAI
            if (preg_match('/\b([A-Z]{3})\b/', $str, $matches)) return $matches[1];
            // 3. Fallback: Take first 3 non-space chars
            $clean = trim(str_replace(['Anywhere', 'Add Return'], '', $str));
            if (strlen($clean) >= 3) return strtoupper(substr($clean, 0, 3));
            return null;
        };

        $originRaw = $request->input('origin', 'DEL');
        $origin = $getIata($originRaw) ?: 'DEL';
        
        $destRaw = $request->input('destination');
        $destination = ($destRaw && $destRaw !== 'Anywhere') ? $getIata($destRaw) : null;
        
        $departureDateRaw = $request->input('departure_date');
        // Ensure we have a valid date string for strtotime
        $dateStr = $departureDateRaw;
        if ($dateStr && !strpos($dateStr, date('Y'))) {
            $dateStr .= ' ' . date('Y');
        }
        $departureDate = $dateStr ? date('Y-m-d', strtotime($dateStr)) : date('Y-m-d');
        
        $adults = $request->input('adults', 1);
        $cabinClass = $request->input('cabin_class', 'Economy');
        $maxPrice = $request->input('maxPrice');

        $formattedFlights = [];
        $airportCoords = $this->getAirportCoords();
        $originCoords = $airportCoords[$origin] ?? $airportCoords['DEL'];

        if ($destination) {
            // Specific Search: Use Hybrid Service to match /flights parity
            $searchParams = [
                'from' => $origin,
                'to' => $destination,
                'date' => $departureDate,
                'adults' => $adults,
                'cabin' => $cabinClass
            ];
            
            $result = $this->hybridFlightService->search($searchParams);
            $flights = $result['success'] ? ($result['data'] ?? []) : [];

            foreach ($flights as $index => $item) {
                // HybridFlightService returns UnifiedFlight objects or arrays of them
                $flight = is_object($item) ? $item->toArray() : $item;
                $dest = $flight['arrival_city'] ?? $destination;
                $coords = $airportCoords[$dest] ?? [
                    'lat' => $originCoords['lat'] + (mt_rand(-50, 50) / 10),
                    'lng' => $originCoords['lng'] + (mt_rand(-50, 50) / 10)
                ];

                $formattedFlights[] = [
                    'id' => $flight['id'] ?? ('f_' . $index),
                    'type' => 'flight',
                    'title' => ($flight['airline_name'] ?? 'Flight') . ' to ' . $this->getCityName($dest),
                    'airline_code' => $flight['airline_code'] ?? '6E',
                    'dest_code' => $dest,
                    'meta' => date('d M H:i', strtotime($flight['departure_at'] ?? $departureDate)) . ' | ' . ($flight['airline_name'] ?? ''),
                    'price' => '₹' . number_format($flight['price'] ?? 0, 0),
                    'price_raw' => $flight['price'] ?? 0,
                    'departure_at' => $flight['departure_at'] ?? $departureDate,
                    'image' => $this->getCityImage($dest),
                    'lat' => $coords['lat'],
                    'lng' => $coords['lng'],
                    'rating' => '4.' . rand(5, 9),
                    'is_direct' => true
                ];
            }
        } else {
            // Inspiration Search: Anywhere from Jaipur
            $result = $this->flightService->inspirationSearch($origin, $maxPrice);
            $rawInspirations = $result['success'] ? $result['data'] : [];

            if (empty($rawInspirations)) {
                $rawInspirations = $this->getMockInspirations($origin);
            }

            foreach ($rawInspirations as $index => $item) {
                $dest = $item['destination'] ?? 'BOM';
                $coords = $airportCoords[$dest] ?? [
                    'lat' => 19.0760 + (mt_rand(-100, 100) / 20),
                    'lng' => 72.8777 + (mt_rand(-100, 100) / 20)
                ];

                $formattedFlights[] = [
                    'id' => 'insp_' . $index,
                    'type' => 'flight',
                    'title' => $this->getCityName($dest),
                    'dest_code' => $dest,
                    'meta' => 'Departure: ' . (isset($item['departureDate']) ? date('d M Y', strtotime($item['departureDate'])) : 'Soon'),
                    'price' => '₹' . number_format($item['price']['total'] ?? rand(5000, 25000), 0),
                    'image' => $this->getCityImage($dest),
                    'lat' => $coords['lat'],
                    'lng' => $coords['lng'],
                    'rating' => '4.' . rand(5, 9)
                ];
            }
        }

        return view('explore-map', [
            'flights' => $formattedFlights,
            'dynamicFlights' => json_encode($formattedFlights),
            'dynamicHotels' => json_encode([]),
            'dynamicTours' => json_encode([]),
            'origin' => $originRaw,
            'destination' => $destRaw,
            'trip' => $request->input('trip', 'one'),
            'departure_date' => $departureDateRaw,
            'return_date' => $request->input('return_date'),
            'adults' => $adults,
            'class' => $cabinClass,
            'originCoords' => json_encode($originCoords)
        ]);
    }

    private function getMockInspirations($origin)
    {
        $destinations = ['BOM', 'DEL', 'BLR', 'MAA', 'HYD', 'CCU', 'GOI', 'AMD', 'COK', 'DXB', 'LHR', 'SIN', 'JFK', 'SFO', 'SYD', 'BKK', 'HKG', 'HND', 'CDG', 'FRA', 'AMS', 'DOH', 'AUH', 'JAI', 'UDR', 'IXC', 'ATQ', 'VNS'];
        
        // Remove origin from destinations
        $destinations = array_diff($destinations, [$origin]);
        shuffle($destinations);
        $selected = array_slice($destinations, 0, 12);

        $mock = [];
        foreach ($selected as $dest) {
            $mock[] = [
                'destination' => $dest,
                'departureDate' => date('Y-m-d', strtotime('+' . rand(5, 30) . ' days')),
                'price' => ['total' => rand(4000, 45000)]
            ];
        }
        return $mock;
    }

    private function getCityName($code)
    {
        $names = [
            'BOM' => 'Mumbai', 'DEL' => 'Delhi', 'BLR' => 'Bengaluru', 'MAA' => 'Chennai',
            'HYD' => 'Hyderabad', 'CCU' => 'Kolkata', 'GOI' => 'Goa', 'AMD' => 'Ahmedabad',
            'COK' => 'Kochi', 'DXB' => 'Dubai', 'LHR' => 'London', 'SIN' => 'Singapore',
            'JFK' => 'New York', 'SFO' => 'San Francisco', 'SYD' => 'Sydney', 'BKK' => 'Bangkok',
            'HKG' => 'Hong Kong', 'HND' => 'Tokyo', 'CDG' => 'Paris', 'FRA' => 'Frankfurt',
            'AMS' => 'Amsterdam', 'DOH' => 'Doha', 'AUH' => 'Abu Dhabi', 'JAI' => 'Jaipur',
            'UDR' => 'Udaipur', 'IXC' => 'Chandigarh', 'ATQ' => 'Amritsar', 'VNS' => 'Varanasi'
        ];
        return $names[$code] ?? $code;
    }

    private function getCityImage($code)
    {
        $images = [
            'BOM' => 'https://images.unsplash.com/photo-1570160897040-d783fc41322c?q=80&w=400',
            'DEL' => 'https://images.unsplash.com/photo-1587474260584-136574528ed5?q=80&w=400',
            'DXB' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=400',
            'LHR' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?q=80&w=400',
            'SIN' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?q=80&w=400',
            'JFK' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?q=80&w=400',
            'SYD' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?q=80&w=400',
            'BKK' => 'https://images.unsplash.com/photo-1508009603885-50cf7c57936d?q=80&w=400',
        ];
        return $images[$code] ?? 'https://images.unsplash.com/photo-1436491865332-7a61a109c05e?q=80&w=400';
    }

    private function getAirportCoords()
    {
        return [
            'BOM' => ['lat' => 19.0896, 'lng' => 72.8656],
            'DEL' => ['lat' => 28.5562, 'lng' => 77.1000],
            'BLR' => ['lat' => 13.1986, 'lng' => 77.7066],
            'MAA' => ['lat' => 12.9941, 'lng' => 80.1709],
            'HYD' => ['lat' => 17.2403, 'lng' => 78.4294],
            'CCU' => ['lat' => 22.6547, 'lng' => 88.4467],
            'GOI' => ['lat' => 15.3803, 'lng' => 73.8314],
            'AMD' => ['lat' => 23.0772, 'lng' => 72.6347],
            'COK' => ['lat' => 10.1520, 'lng' => 76.3920],
            'DXB' => ['lat' => 25.2532, 'lng' => 55.3657],
            'LHR' => ['lat' => 51.4700, 'lng' => -0.4543],
            'SIN' => ['lat' => 1.3644, 'lng' => 103.9915],
            'JFK' => ['lat' => 40.6413, 'lng' => -73.7781],
            'SFO' => ['lat' => 37.6213, 'lng' => -122.3790],
            'SYD' => ['lat' => -33.9399, 'lng' => 151.1753],
            'BKK' => ['lat' => 13.6898, 'lng' => 100.7501],
            'HKG' => ['lat' => 22.3080, 'lng' => 113.9185],
            'HND' => ['lat' => 35.5494, 'lng' => 139.7798],
            'CDG' => ['lat' => 49.0097, 'lng' => 2.5479],
            'FRA' => ['lat' => 50.0379, 'lng' => 8.5622],
            'AMS' => ['lat' => 52.3105, 'lng' => 4.7683],
            'DOH' => ['lat' => 25.2633, 'lng' => 51.5642],
            'AUH' => ['lat' => 24.4330, 'lng' => 54.6511],
            'JAI' => ['lat' => 26.8242, 'lng' => 75.8122],
            'UDR' => ['lat' => 24.6177, 'lng' => 73.8961],
            'IXC' => ['lat' => 30.6735, 'lng' => 76.7885],
            'ATQ' => ['lat' => 31.7096, 'lng' => 74.7973],
            'VNS' => ['lat' => 25.4519, 'lng' => 82.8595],
        ];
    }

}

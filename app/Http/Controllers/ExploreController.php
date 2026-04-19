<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlightService;
use App\Services\HotelService;

class ExploreController extends Controller
{
    protected $flightService;

    public function __construct(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    public function index(Request $request)
    {
        $origin = $request->input('origin', 'DEL');
        $maxPrice = $request->input('maxPrice');

        $result = $this->flightService->inspirationSearch($origin, $maxPrice);
        $rawInspirations = $result['success'] ? $result['data'] : [];

        $formattedFlights = [];
        $airportCoords = $this->getAirportCoords();

        foreach ($rawInspirations as $index => $item) {
            $dest = $item['destination'] ?? 'BOM';
            $coords = $airportCoords[$dest] ?? [
                'lat' => 19.0760 + (mt_rand(-500, 500) / 100),
                'lng' => 72.8777 + (mt_rand(-500, 500) / 100)
            ];

            $formattedFlights[] = [
                'id' => 'f_' . $index,
                'type' => 'flight',
                'title' => 'To ' . $dest,
                'meta' => 'Departure: ' . ($item['departureDate'] ?? 'Soon'),
                'price' => '₹' . number_format($item['price']['total'] ?? 0, 0),
                'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109c05e?q=80&w=400&auto=format&fit=crop',
                'lat' => $coords['lat'],
                'lng' => $coords['lng'],
                'rating' => '4.' . rand(5, 9)
            ];
        }

        return view('explore-map', [
            'flights' => $formattedFlights,
            'dynamicFlights' => json_encode($formattedFlights),
            'dynamicHotels' => json_encode([]),
            'dynamicTours' => json_encode([])
        ]);
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
            'DXB' => ['lat' => 25.2532, 'lng' => 55.3657],
            'DOH' => ['lat' => 25.2633, 'lng' => 51.5642],
            'AUH' => ['lat' => 24.4330, 'lng' => 54.6511],
        ];
    }
}

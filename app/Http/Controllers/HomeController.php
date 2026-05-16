<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tours = \App\Models\Tour::where('is_active', true)->take(3)->get();
        $esims = \App\Models\EsimPlan::where('is_active', true)->take(12)->get();
        $homestays = \App\Models\Homestay::take(3)->get();
        $offers = \App\Models\Offer::where('is_active', true)->orderBy('sort_order')->take(10)->get();
        $festivals = \App\Models\Festival::where('is_active', true)->orderBy('sort_order')->take(4)->get();

        // Fetch dynamic hotels for homepage (Top Rated)
        $hotelService = app(\App\Services\HotelService::class);
        $hotelResults = $hotelService->search(['destinationCode' => 'DEL', 'adults' => 2, 'rooms' => 1]);
        $hotels = array_slice($hotelResults['hotels']['hotels'] ?? [], 0, 4);

        // Fetch Popular Flight Routes from DB
        $popularRoutesFromDb = \App\Models\FlightBooking::select('origin', 'destination', \DB::raw('count(*) as total'))
            ->groupBy('origin', 'destination')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        if ($popularRoutesFromDb->count() >= 4) {
            $popularRoutes = $popularRoutesFromDb->map(function($route) {
                $recent = \App\Models\FlightBooking::where('origin', $route->origin)
                    ->where('destination', $route->destination)
                    ->latest()
                    ->first();
                $fare = json_decode($recent->fare_details, true);
                $route->price = $fare['total'] ?? 4250;
                return $route;
            });
        } else {
            // Expanded List as requested
            $popularRoutes = collect([
                (object)['origin' => 'DEL', 'destination' => 'BOM', 'price' => 4250],
                (object)['origin' => 'BLR', 'destination' => 'DEL', 'price' => 5100],
                (object)['origin' => 'BOM', 'destination' => 'GOI', 'price' => 3400],
                (object)['origin' => 'MAA', 'destination' => 'HYD', 'price' => 3200],
                (object)['origin' => 'CCU', 'destination' => 'DEL', 'price' => 4800],
                (object)['origin' => 'DXB', 'destination' => 'BOM', 'price' => 14200],
                (object)['origin' => 'DEL', 'destination' => 'LHR', 'price' => 45000],
                (object)['origin' => 'BOM', 'destination' => 'JFK', 'price' => 65000],
                (object)['origin' => 'BLR', 'destination' => 'SIN', 'price' => 22000],
                (object)['origin' => 'DEL', 'destination' => 'DXB', 'price' => 18500],
            ]);
        }

        $cityMap = [
            'BOM' => 'Mumbai', 'DEL' => 'Delhi', 'BLR' => 'Bangalore', 'MAA' => 'Chennai',
            'CCU' => 'Kolkata', 'HYD' => 'Hyderabad', 'DXB' => 'Dubai', 'SIN' => 'Singapore',
            'JAI' => 'Jaipur', 'GOI' => 'Goa', 'AMD' => 'Ahmedabad', 'LKO' => 'Lucknow',
            'PNQ' => 'Pune', 'SXR' => 'Srinagar', 'IXC' => 'Chandigarh', 'LHR' => 'London',
            'JFK' => 'New York', 'COK' => 'Kochi', 'AYJ' => 'Ayodhya', 'IXL' => 'Leh',
            'AGR' => 'Agra', 'UDR' => 'Udaipur', 'DED' => 'Rishikesh', 'SLV' => 'Shimla',
            'KUU' => 'Manali'
        ];

        foreach($popularRoutes as $route) {
            $route->origin_name = $cityMap[$route->origin] ?? $route->origin;
            $route->destination_name = $cityMap[$route->destination] ?? $route->destination;
        }

        // Popular Destinations (Hotels in India) - Expanded List
        $popularDestinations = collect([
          [
    
        'name' => 'Jaipur',
        'code' => 'JAI',
        'image' => 'https://images.unsplash.com/photo-1477587458883-47145ed94245?q=80&w=1200',
        'desc' => 'Pink City & Palaces',
        'price' => '3,200'
    ],
    [
        'name' => 'Goa',
        'code' => 'GOI',
        'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?q=80&w=1200',
        'desc' => 'Beaches & Nightlife',
        'price' => '4,500'
    ],
    [
        'name' => 'Delhi',
        'code' => 'DEL',
        'image' => 'https://images.unsplash.com/photo-1587474260584-136574528ed5?q=80&w=1200',
        'desc' => 'Capital Heritage',
        'price' => '2,800'
    ],
    [
        'name' => 'Udaipur',
        'code' => 'UDR',
        'image' => 'https://images.unsplash.com/photo-1599661046827-dacff0c0f09a?q=80&w=1200',
        'desc' => 'City of Lakes',
        'price' => '5,400'
    ],
    [
        'name' => 'Mumbai',
        'code' => 'BOM',
        'image' => 'https://images.unsplash.com/photo-1529253355930-ddbe423a2ac7?q=80&w=1200',
        'desc' => 'Dream City',
        'price' => '4,200'
    ],
    [
        'name' => 'Bangalore',
        'code' => 'BLR',
        'image' => 'https://images.unsplash.com/photo-1596176530529-78163a4f7af2?q=80&w=1200',
        'desc' => 'Silicon Valley',
        'price' => '3,800'
    ],
    [
        'name' => 'Rishikesh',
        'code' => 'DED',
        'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?q=80&w=1200',
        'desc' => 'Yoga Capital',
        'price' => '2,500'
    ],
    [
        'name' => 'Agra',
        'code' => 'AGR',
        'image' => 'https://images.unsplash.com/photo-1548013146-72479768bada?q=80&w=1200',
        'desc' => 'Taj Mahal',
        'price' => '3,500'
    ],
    [
        'name' => 'Chennai',
        'code' => 'MAA',
        'image' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?q=80&w=1200',
        'desc' => 'Cultural Gateway',
        'price' => '3,100'
    ],
    [
        'name' => 'Srinagar',
        'code' => 'SXR',
        'image' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?q=80&w=1200',
        'desc' => 'Paradise on Earth',
        'price' => '6,200'
    ],
    [
        'name' => 'Kolkata',
        'code' => 'CCU',
        'image' => 'https://images.unsplash.com/photo-1558431382-27e39cbef4bc?q=80&w=1200',
        'desc' => 'City of Joy',
        'price' => '2,900'
    ],
    [
        'name' => 'Manali',
        'code' => 'KUU',
        'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?q=80&w=1200',
        'desc' => 'Snow & Adventure',
        'price' => '4,800'
    ],
    [
        'name' => 'Munnar',
        'code' => 'COK',
        'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=1200',
        'desc' => 'Tea Gardens',
        'price' => '4,400'
    ],
    [
        'name' => 'Ayodhya',
        'code' => 'AYJ',
        'image' => 'https://images.unsplash.com/photo-1707127116715-e2376f9d372d?q=80&w=1200',
        'desc' => 'Holy City',
        'price' => '3,200'
    ],
    [
        'name' => 'Leh',
        'code' => 'IXL',
        'image' => 'https://images.unsplash.com/photo-1581793745862-99fde7fa73d2?q=80&w=1200',
        'desc' => 'High Passes',
        'price' => '10,200'
    ],
    [
        'name' => 'Hyderabad',
        'code' => 'HYD',
        'image' => 'https://images.unsplash.com/photo-1567157577867-05ccb1388e66?q=80&w=1200',
        'desc' => 'Nizam City',
        'price' => '3,900'
    ]
        ]);

        return view('index', compact('tours', 'esims', 'homestays', 'hotels', 'popularRoutes', 'popularDestinations', 'offers', 'festivals'));
    }

    public function deals()
    {
        $offers = \App\Models\Offer::where('is_active', true)->orderBy('sort_order')->get();
        $categories = [
            'flights' => __('categories.flights', [], 'Flights'),
            'hotels' => __('categories.hotels', [], 'Hotels'),
            'homestays' => __('categories.homestays', [], 'Homestays'),
            'cabs' => __('categories.cabs', [], 'Cabs'),
            'trains' => __('categories.trains', [], 'Trains'),
            'holidays' => __('categories.tours', [], 'Holidays'),
            'insurance' => __('categories.insurance', [], 'Insurance'),
            'esim' => __('categories.esim', [], 'eSIM'),
            'bank_offer' => __('categories.bank_offer', [], 'Bank Offer'),
        ];
        
        return view('deals', compact('offers', 'categories'));
    }
}

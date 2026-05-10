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

        // Fetch dynamic hotels for homepage (Top Rated)
        $hotelService = app(\App\Services\HotelService::class);
        $hotelResults = $hotelService->search(['destinationCode' => 'DXB', 'adults' => 2, 'rooms' => 1]);
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
            ['name' => 'Jaipur', 'code' => 'JAI', 'image' => 'https://images.unsplash.com/photo-1599661046289-e31897846e41?w=400', 'desc' => 'Pink City & Palaces', 'price' => '3,200'],
            ['name' => 'Goa', 'code' => 'GOI', 'image' => 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=400', 'desc' => 'Beaches & Nightlife', 'price' => '4,500'],
            ['name' => 'Delhi', 'code' => 'DEL', 'image' => 'https://images.unsplash.com/photo-1585123334904-845d60e97b29?w=400', 'desc' => 'Capital Heritage', 'price' => '2,800'],
            ['name' => 'Udaipur', 'code' => 'UDR', 'image' => 'https://images.unsplash.com/photo-1590050752117-23a9d7fc2140?w=400', 'desc' => 'City of Lakes', 'price' => '5,400'],
            ['name' => 'Mumbai', 'code' => 'BOM', 'image' => 'https://images.unsplash.com/photo-1566552881560-0be862a7c445?w=400', 'desc' => 'Dream City', 'price' => '4,200'],
            ['name' => 'Bangalore', 'code' => 'BLR', 'image' => 'https://images.unsplash.com/photo-1596402184320-417d717867cd?w=400', 'desc' => 'Silicon Valley', 'price' => '3,800'],
            ['name' => 'Rishikesh', 'code' => 'DED', 'image' => 'https://images.unsplash.com/photo-1598971861713-54ad16a7e72e?w=400', 'desc' => 'Yoga Capital', 'price' => '2,500'],
            ['name' => 'Agra', 'code' => 'AGR', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/d/da/Taj_Mahal%2C_Agra%2C_India_edit2.jpg', 'desc' => 'Taj Mahal', 'price' => '3,500'],
            ['name' => 'Chennai', 'code' => 'MAA', 'image' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=400', 'desc' => 'Cultural Gateway', 'price' => '3,100'],
            ['name' => 'Kasauli', 'code' => 'IXC', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Hill Station', 'price' => '6,200'],
            ['name' => 'Kolkata', 'code' => 'CCU', 'image' => 'https://images.unsplash.com/photo-1558431382-27e39cbef4bc?w=400', 'desc' => 'City of Joy', 'price' => '2,900'],
            ['name' => 'Pune', 'code' => 'PNQ', 'image' => 'https://images.unsplash.com/photo-1562916359-2d1142bc30a9?w=400', 'desc' => 'Cultural Capital', 'price' => '3,600'],
            ['name' => 'Manali', 'code' => 'KUU', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Snow & Adventure', 'price' => '4,800'],
            ['name' => 'Lonavala', 'code' => 'PNQ', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Weekend Gateway', 'price' => '5,100'],
            ['name' => 'Shimla', 'code' => 'SLV', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Queen of Hills', 'price' => '5,900'],
            ['name' => 'Munnar', 'code' => 'COK', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Tea Gardens', 'price' => '4,400'],
            ['name' => 'Ayodhya', 'code' => 'AYJ', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Holy City', 'price' => '3,200'],
            ['name' => 'Gulmarg', 'code' => 'SXR', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Skiing Destination', 'price' => '8,500'],
            ['name' => 'Leh', 'code' => 'IXL', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'High Passes', 'price' => '10,200'],
            ['name' => 'Hyderabad', 'code' => 'HYD', 'image' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400', 'desc' => 'Nizam City', 'price' => '3,900'],
        ]);

        return view('index', compact('tours', 'esims', 'homestays', 'hotels', 'popularRoutes', 'popularDestinations'));
    }
}

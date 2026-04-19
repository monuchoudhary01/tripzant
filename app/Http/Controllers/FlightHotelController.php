<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightHotelController extends Controller
{
    public function index()
    {
        return view('flight-hotel.index');
    }

    public function search(Request $request)
    {
        $from = $request->input('from', 'Delhi');
        $to = $request->input('to', 'Goa');
        $date = $request->input('date', date('Y-m-d'));

        // Mock Bundle Data
        $bundles = [
            [
                'id' => 1,
                'title' => 'Luxury Escape: Taj Exotica + Indigo Flights',
                'location' => 'Benaulim, Goa',
                'hotel_name' => 'Taj Exotica Resort & Spa',
                'airline' => 'Indigo',
                'flight_type' => 'Non-stop',
                'rating' => 4.9,
                'duration' => '3 Nights / 4 Days',
                'price' => 45500,
                'original_price' => 58000,
                'image' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=600&auto=format&fit=crop&q=80',
                'features' => ['Breakfast Included', 'Airport Transfers', 'Luxury Room']
            ],
            [
                'id' => 2,
                'title' => 'Beachside Bliss: Novotel + Air India',
                'location' => 'Candolim, Goa',
                'hotel_name' => 'Novotel Goa Resort',
                'airline' => 'Air India',
                'flight_type' => 'Non-stop',
                'rating' => 4.5,
                'duration' => '2 Nights / 3 Days',
                'price' => 28900,
                'original_price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&auto=format&fit=crop&q=80',
                'features' => ['Wifi', 'Swimming Pool', 'Buffet Breakfast']
            ],
            [
                'id' => 3,
                'title' => 'Budget Explorer: Ibis Styles + Vistara',
                'location' => 'Calangute, Goa',
                'hotel_name' => 'Ibis Styles Goa',
                'airline' => 'Vistara',
                'flight_type' => '1 Stop',
                'rating' => 4.2,
                'duration' => '3 Nights / 4 Days',
                'price' => 19500,
                'original_price' => 24000,
                'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&auto=format&fit=crop&q=80',
                'features' => ['City Center', 'Modern Rooms', 'Prime Location']
            ]
        ];

        return view('flight-hotel.results', compact('bundles', 'from', 'to', 'date'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homestay;
use App\Models\Booking;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Auth;

class HomestayController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('city', 'Kochi');
        $homestays = Homestay::all(); // Simplified filter
        if ($city) {
            $homestays = Homestay::where('city', 'LIKE', "%$city%")->get();
        }

        return view('homestay-listing', compact('homestays', 'city'));
    }

    public function show($id)
    {
        $homestay = Homestay::findOrFail($id);
        return view('homestay-details', compact('homestay'));
    }

    public function book(Request $request)
    {
        $home = Homestay::findOrFail($request->homestay_id);
        $pricing = \App\Services\PricingService::calculateSellingPrice($home->price_per_night, 'homestay');
        
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'booking_type' => 'homestay',
            'api_reference' => 'HS-' . strtoupper(bin2hex(random_bytes(4))),
            'net_price' => $home->price_per_night, 
            'selling_price' => $pricing['selling_price'],
            'markup' => $pricing['markup'],
            'payment_status' => 'confirmed',
            'status' => 'confirmed',
            'contact_email' => Auth::user()->email ?? $request->email,
            'booking_details' => json_encode([
                'name' => $home->name,
                'city' => $home->city,
                'address' => $home->address
            ])
        ]);

        AuditLogService::log('Homestay', 'Booking', "Homestay booked: {$home->name}", $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Homestay booked successfully!',
            'booking_id' => $booking->api_reference
        ]);
    }
}

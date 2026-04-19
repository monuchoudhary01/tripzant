<?php

namespace App\Http\Controllers;

use App\Models\CargoBooking;
use App\Models\CargoProvider;
use App\Models\CargoTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CargoController extends Controller
{
    /**
     * Public Cargo Landing Page (Home Page, Cargo Tab)
     */
    public function landing()
    {
        $providers = CargoProvider::where('is_active', true)->limit(3)->get();
        return view('cargo.landing', compact('providers'));
    }

    /**
     * Public Tracking View
     */
    public function trackView(Request $request)
    {
        $ref = $request->query('ref');
        $booking = null;
        if($ref) {
            $booking = CargoBooking::where('booking_ref', $ref)->with('tracking')->first();
        }
        return view('cargo.tracking', compact('booking', 'ref'));
    }

    /**
     * Quick Calculate Estimate for Landing Page
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0.5',
        ]);

        // Simple math for estimate before login
        $price = 300 + ($request->weight * 85); 
        
        return response()->json([
            'success' => true,
            'estimate' => round($price, 2),
            'days' => '5-7 Days'
        ]);
    }
}

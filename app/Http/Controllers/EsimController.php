<?php

namespace App\Http\Controllers;

use App\Models\EsimPlan;
use App\Models\Booking;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Auth;

class EsimController extends Controller
{
    public function index()
    {
        $plans = EsimPlan::where('is_active', true)->get();
        return view('esim.index', compact('plans'));
    }

    public function book(Request $request)
    {
        $plan = EsimPlan::findOrFail($request->plan_id);
        $pricing = \App\Services\PricingService::calculateSellingPrice($plan->price, 'esim');
        
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'booking_type' => 'esim',
            'api_reference' => 'SIM-' . strtoupper(bin2hex(random_bytes(4))),
            'net_price' => $plan->price, 
            'selling_price' => $pricing['selling_price'],
            'markup' => $pricing['markup'],
            'payment_status' => 'confirmed',
            'status' => 'confirmed',
            'contact_email' => Auth::user()->email ?? $request->email,
            'booking_details' => json_encode([
                'region' => $plan->region,
                'data' => $plan->data_amount,
                'validity' => $plan->validity_days
            ])
        ]);

        AuditLogService::log('eSIM', 'Booking', "eSIM booking created for region: {$plan->region}", $request->all());

        return response()->json([
            'success' => true,
            'message' => 'eSIM purchased successfully!',
            'booking_id' => $booking->api_reference
        ]);
    }
}

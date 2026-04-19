<?php

namespace App\Http\Controllers;

use App\Models\InsurancePlan;
use App\Models\Booking;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Auth;

class InsuranceController extends Controller
{
    public function index()
    {
        $plans = InsurancePlan::all();
        return view('booking-insurance', compact('plans'));
    }

    public function book(Request $request)
    {
        $plan = InsurancePlan::findOrFail($request->plan_id);
        $pricing = \App\Services\PricingService::calculateSellingPrice($plan->price, 'insurance');
        
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'booking_type' => 'insurance',
            'api_reference' => 'INS-' . strtoupper(bin2hex(random_bytes(4))),
            'net_price' => $plan->price, 
            'selling_price' => $pricing['selling_price'],
            'markup' => $pricing['markup'],
            'payment_status' => 'confirmed',
            'status' => 'confirmed',
            'contact_email' => Auth::user()->email ?? $request->email,
            'booking_details' => json_encode([
                'plan_name' => $plan->name,
                'provider' => $plan->provider,
                'sum_insured' => $plan->sum_insured
            ])
        ]);

        AuditLogService::log('Insurance', 'Booking', "Insurance booking created for plan: {$plan->name}", $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Insurance booked successfully!',
            'booking_id' => $booking->api_reference
        ]);
    }
}

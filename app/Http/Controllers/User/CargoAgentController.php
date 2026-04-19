<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CargoBooking;
use App\Models\CargoTracking;
use App\Models\CargoDeliveryAgent;
use Illuminate\Http\Request;

class CargoAgentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function dashboard() {
        // Logic for Cargo Agent Dashboard (Module 6)
        $agent = CargoDeliveryAgent::where('user_id', auth()->id())->first();
        
        // if(!$agent) {
        //     return redirect()->route('dashboard.index')->with('error', 'You are not registered as a cargo agent.');
        // }

        $activePickups = CargoBooking::where('status', 'Pickup scheduled')
            /* ->when($agent, function($q) use ($agent) {
                return $q->where('origin_city', 'LIKE', '%' . $agent->current_location . '%');
            }) */
            ->get();

        $myDeliveries = CargoBooking::where('status', 'Picked Up')
            ->orWhere('status', 'Warehouse')
            ->get(); // In a real app, filter by assigned_agent_id

        return view('cargo.agent.dashboard', compact('agent', 'activePickups', 'myDeliveries'));
    }

    public function acceptPickup(Request $request) {
        $booking = CargoBooking::where('booking_ref', $request->booking_ref)->firstOrFail();
        
        // Global Dynamic Routing: Assign carrier based on region/provider
        $carriers = ['DHL Global Express', 'FedEx International', 'UPS WorldWide', 'Aramex Logistics'];
        $assignedCarrier = $carriers[$booking->provider_id % count($carriers)];
        
        $hub = 'Any Nearest ' . $assignedCarrier . ' Hub / Drop-off Point';
        
        $booking->update([
            'status' => 'Picked Up',
            'pickup_option' => 'In Transit to ' . $hub
        ]);

        // Log tracking (Module 3)
        CargoTracking::create([
            'booking_id' => $booking->id,
            'status' => 'Picked Up',
            'location_name' => $booking->origin_city,
            'description' => 'Parcel collected by TripZant Agent. Enroute to ' . $hub
        ]);

        return response()->json(['success' => true, 'message' => 'Accepted! Drop at ' . $hub]);
    }

    public function earnings() {
        $agent = CargoDeliveryAgent::where('user_id', auth()->id())->first();
        // Mock earnings for flow demo
        $earnings = [
            'total' => 1250.00,
            'this_month' => 450.00,
            'pending' => 120.00
        ];
        return view('cargo.agent.earnings', compact('agent', 'earnings'));
    }

    public function history() {
        $agent = CargoDeliveryAgent::where('user_id', auth()->id())->first();
        // In real app, filter bookings by assigned_agent_id and delivered status
        $history = CargoBooking::where('status', 'Delivered')->latest()->paginate(15);
        return view('cargo.agent.history', compact('agent', 'history'));
    }

    public function updateLocation(Request $request) {
        $request->validate([
            'booking_ref' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);

        $booking = CargoBooking::where('booking_ref', $request->booking_ref)->firstOrFail();
        
        CargoTracking::create([
            'booking_id' => $booking->id,
            'status' => $booking->status,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
            'description' => 'Location update from agent mobile app.'
        ]);

        return response()->json(['success' => true]);
    }
}

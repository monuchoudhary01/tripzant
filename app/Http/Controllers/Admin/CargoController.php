<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CargoBooking;
use App\Models\CargoProvider;
use App\Models\CargoTracking;
use App\Models\CargoPromoCode;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // Add admin role check middleware here if exists
    }

    public function index() {
        $bookings = CargoBooking::with(['user', 'provider'])->latest()->paginate(10);
        $totalRevenue = CargoBooking::sum('total_price');
        $totalCommission = $bookings->sum(function($b) {
            return $b->total_price * ($b->provider->commission_percentage / 100);
        });
        
        // Latest logistics activity logs
        $logs = CargoTracking::with('booking')->latest()->take(10)->get();

        return view('admin.cargo.index', compact('bookings', 'totalRevenue', 'totalCommission', 'logs'));
    }

    public function providers() {
        $providers = CargoProvider::latest()->get();
        return view('admin.cargo.providers', compact('providers'));
    }

    public function bookings() {
        $bookings = CargoBooking::with(['user', 'provider'])->latest()->paginate(50);
        return view('admin.cargo.bookings', compact('bookings'));
    }

    public function storeProvider(Request $request) {
        $request->validate([
            'name' => 'required',
            'base_rate' => 'required|numeric',
            'commission_percentage' => 'required|numeric'
        ]);

        CargoProvider::create($request->all());
        return back()->with('success', 'Cargo Provider added successfully.');
    }

    public function updateStatus(Request $request) {
        $request->validate([
            'booking_id' => 'required|exists:cargo_bookings,id',
            'status' => 'required',
            'location' => 'nullable',
            'description' => 'nullable'
        ]);

        $booking = CargoBooking::findOrFail($request->booking_id);
        $booking->update(['status' => $request->status]);

        // Automatically log tracking entry (Module 3)
        CargoTracking::create([
            'booking_id' => $booking->id,
            'status' => $request->status,
            'location_name' => $request->location ?? $booking->origin_city,
            'description' => $request->description ?? "Shipment status updated to {$request->status}."
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated and tracking logged.']);
    }

    public function promoCodes() {
        $promoCodes = CargoPromoCode::latest()->get();
        return view('admin.cargo.promo_codes', compact('promoCodes'));
    }
}

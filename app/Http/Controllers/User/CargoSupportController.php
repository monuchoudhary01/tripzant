<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CargoBooking;
use App\Models\CargoTracking;
use Illuminate\Http\Request;

class CargoSupportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * WAREHOUSE CLERK (Module 4)
     */
    public function warehouseDashboard() {
        $parcels = CargoBooking::whereIn('status', ['Picked Up', 'Warehouse', 'Customs'])->get();
        return view('cargo.support.warehouse', compact('parcels'));
    }

    /**
     * CUSTOMS OFFICER (Module 4)
     */
    public function customsDashboard() {
        $declarations = CargoBooking::with('customs')->where('status', 'Warehouse')->orWhere('status', 'Customs')->get();
        return view('cargo.support.customs', compact('declarations'));
    }

    public function processStatus(Request $request) {
        $booking = CargoBooking::where('booking_ref', $request->booking_ref)->firstOrFail();
        $booking->update(['status' => $request->status]);

        CargoTracking::create([
            'booking_id' => $booking->id,
            'status' => $request->status,
            'location_name' => $request->location ?? 'Regional Hub',
            'description' => $request->description ?? "Parcel processed at " . auth()->user()->role . " facility."
        ]);

        return response()->json(['success' => true]);
    }
}

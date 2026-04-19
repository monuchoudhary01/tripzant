<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homestay;
use Illuminate\Support\Facades\Auth;

class HomestayController extends Controller
{
    public function index()
    {
        $homestays = Homestay::all(); // Simplified for now, should ideally be filtered by owner
        return view('partner.manage-homestays', compact('homestays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_night' => 'required|numeric',
        ]);

        Homestay::create([
            'name' => $request->name,
            'price_per_night' => $request->price_per_night,
            'city' => $request->city ?? 'Unknown',
            'address' => $request->address ?? 'N/A',
            'status' => 'Live'
        ]);

        return back()->with('success', 'Property listed successfully!');
    }
}

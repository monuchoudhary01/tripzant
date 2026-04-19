<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::where('supplier_id', Auth::id())->orWhereNull('supplier_id')->get();
        return view('partner.manage-tours', compact('tours'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
        ]);

        Tour::create([
            'supplier_id' => Auth::id(),
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
            'status' => 'Live',
            'location' => $request->location ?? 'Global'
        ]);

        return back()->with('success', 'Tour created successfully!');
    }
}

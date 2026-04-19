<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Train;

class TrainController extends Controller
{
    public function index(Request $request)
    {
        $origin = $request->input('from', 'New Delhi');
        $destination = $request->input('to', 'Mumbai');
        
        $trains = Train::where('origin', 'LIKE', "%$origin%")
            ->where('destination', 'LIKE', "%$destination%")
            ->get();

        return view('train-listing', compact('trains', 'origin', 'destination'));
    }
}

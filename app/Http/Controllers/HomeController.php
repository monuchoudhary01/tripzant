<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tours = \App\Models\Tour::where('is_active', true)->take(3)->get();
        $esims = \App\Models\EsimPlan::where('is_active', true)->take(12)->get();
        $homestays = \App\Models\Homestay::take(3)->get();

        return view('index', compact('tours', 'esims', 'homestays'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalServiceProviderController extends Controller
{
    public function dashboard() { return view('provider.dashboard'); }
    public function profile() { return view('provider.profile'); }
    public function services() { return view('provider.services'); }
    public function hotels() { return view('provider.hotels'); }
    public function tourBuilders() { return view('provider.tour_builders'); }
    public function requests() { return view('provider.requests'); }
    public function bookings() { return view('provider.bookings'); }
    public function earnings() { return view('provider.earnings'); }
    public function reviews() { return view('provider.reviews'); }
    public function searchProviders() { return view('provider.search_providers'); }
}

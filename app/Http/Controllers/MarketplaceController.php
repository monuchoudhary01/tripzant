<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Display the marketplace home
     */
    public function index()
    {
        $providers = User::where('role', User::ROLE_AFFILIATE)
                         ->where('is_approved', true)
                         ->latest()
                         ->get();

        return view('marketplace.index', compact('providers'));
    }

    /**
     * Show provider profile
     */
    public function providerProfile($id)
    {
        $provider = User::where('role', User::ROLE_AFFILIATE)
                        ->where('is_approved', true)
                        ->findOrFail($id);

        return view('marketplace.provider', compact('provider'));
    }

    /**
     * Book service (Mock for now)
     */
    public function bookService(Request $request, $id)
    {
        // Mock booking logic
        return back()->with('success', 'Service booked successfully! The provider will contact you shortly.');
    }
}

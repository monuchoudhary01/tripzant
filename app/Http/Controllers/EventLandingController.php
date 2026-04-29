<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventLead;

class EventLandingController extends Controller
{
    /**
     * Show the landing page for the Melbourne Sri Lankan New Year Event.
     */
    public function showMelbourneEvent()
    {
        return view('events.event');
    }

    /**
     * Store the lead information from the event.
     */
    public function storeLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'raffle_code' => 'required|string|max:50|unique:event_leads,raffle_code',
        ]);

        $raffleCode = $validated['raffle_code'];
        
        // Attempt to parse the code into parts if it matches the format
        $parts = explode('-', $raffleCode);
        $alphabetic = $parts[0] ?? null;
        $number = $parts[1] ?? null;
        $colour = $parts[2] ?? null;

        $lead = EventLead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'raffle_alphabetic' => $alphabetic,
            'raffle_number' => $number,
            'raffle_colour' => $colour,
            'raffle_code' => $raffleCode,
            'event_name' => 'Symphony in the Stratosphere 2026'
        ]);

        return back()->with('success', 'Thank you! We will get in touch soon. Your journey with Tripzant starts here!');
    }
}

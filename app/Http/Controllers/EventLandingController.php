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
        return view('events.melbourne-sri-lanka');
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
        ]);

        $types = ['A', 'B', 'C', 'N', 'X', 'Y', 'Z'];
        $colors = ['Red', 'Blue', 'Green', 'Gold', 'Silver'];

        do {
            $type = $types[array_rand($types)];
            $number = rand(1000, 9999);
            $color = $colors[array_rand($colors)];
            $raffleCode = $type . '-' . $number . '-' . $color;
        } while (EventLead::where('raffle_code', $raffleCode)->exists());

        $lead = EventLead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'raffle_alphabetic' => $type,
            'raffle_number' => (string) $number,
            'raffle_colour' => $color,
            'raffle_code' => $raffleCode,
            'event_name' => 'Symphony in the Stratosphere 2026'
        ]);

        return back()->with('success', 'Thank you! We will get in touch soon. Your journey with Tripzant starts here!');
    }
}

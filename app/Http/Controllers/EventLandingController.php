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
            'next_visit_sri_lanka' => 'nullable|string|max:255',
            'next_holiday_destination' => 'nullable|string|max:255',
            'wants_tour_builder' => 'sometimes|boolean'
        ]);

        $lead = EventLead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'next_visit_sri_lanka' => $validated['next_visit_sri_lanka'],
            'next_holiday_destination' => $validated['next_holiday_destination'],
            'wants_tour_builder' => $request->has('wants_tour_builder'),
            'event_name' => 'Melbourne Sri Lankan New Year 2026'
        ]);

        return back()->with('success', 'Thank you! We will get in touch soon. Your journey with Tripzant starts here!');
    }
}

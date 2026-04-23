<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class SeatSelectionController extends Controller
{
    /**
     * Show the seat selection view with dynamic booking data.
     */
    public function index(Request $request)
    {
        $reference = $request->input('reference');
        $booking = null;

        if ($reference) {
            $booking = Booking::with('items')->where('booking_reference', $reference)->first();
        }

        if (!$booking && auth()->check()) {
            $booking = Booking::with('items')
                ->where('user_id', auth()->id())
                ->where('status', 'confirmed')
                ->latest()
                ->first();
        }

        if (!$booking) {
            return redirect()->route('flights.index')->with('error', 'Booking session not found.');
        }

        $passengers = [];
        $flight = null;
        $legs = [];
        if ($booking->api_booking_details) {
            $apiData = json_decode($booking->api_booking_details, true);
            $flight = $apiData['item_data'] ?? ($apiData['item'] ?? null);
            
            // Handle both single flight object and array of flights (split mode)
            if (is_array($flight)) {
                if (isset($flight[0]) && is_array($flight[0])) {
                    $legs = $flight;
                    $flight = $flight[0]; // Set primary flight for simple references
                } else {
                    $legs = [$flight];
                }
            } else {
                $legs = [$flight];
            }
        }

        // Try to get passengers from booking_items first
        foreach ($booking->items as $item) {
            $details = json_decode($item->details, true);
            if (is_array($details)) {
                $passengers[] = $details;
            }
        }

        // Fallback: if no items, recover travelers from api_booking_details
        if (empty($passengers) && $booking->api_booking_details) {
            $apiData = json_decode($booking->api_booking_details, true);
            $travelers = $apiData['travelers'] ?? [];
            foreach ($travelers as $traveler) {
                if (is_array($traveler)) {
                    $passengers[] = $traveler;
                }
            }
        }

        return view('seat-selection', [
            'booking' => $booking,
            'passengers' => $passengers,
            'flight' => $flight,
            'legs' => $legs,
            'reference' => $booking->booking_reference
        ]);
    }

    /**
     * Show the add-ons / ancillaries view with dynamic booking data.
     */
    public function customize(Request $request)
    {
        $reference = $request->input('reference');
        $booking = null;

        if ($reference) {
            $booking = Booking::with('items')->where('booking_reference', $reference)->first();
        }

        if (!$booking && auth()->check()) {
            $booking = Booking::with('items')
                ->where('user_id', auth()->id())
                ->where('status', 'confirmed')
                ->latest()
                ->first();
        }

        if (!$booking) {
            return redirect()->route('flights.index')->with('error', 'Booking session not found.');
        }

        $passengers = [];
        $flight = null;
        if ($booking->api_booking_details) {
            $apiData = json_decode($booking->api_booking_details, true);
            $flight = $apiData['item_data'] ?? ($apiData['item'] ?? null);
            // If multi-leg array, use first leg
            if (is_array($flight) && isset($flight[0]) && is_array($flight[0])) {
                $flight = $flight[0];
            }
        }

        // Get passengers from booking_items
        foreach ($booking->items as $item) {
            $details = json_decode($item->details, true);
            if (is_array($details)) {
                $passengers[] = isset($details['first_name']) ? $details : array_values($details);
            }
        }
        $passengers = array_filter(array_map(fn($p) => is_array($p) && isset($p['first_name']) ? $p : null, $passengers));

        // Fallback: recover from api_booking_details travelers
        if (empty($passengers) && $booking->api_booking_details) {
            $apiData = json_decode($booking->api_booking_details, true);
            $passengers = array_filter($apiData['travelers'] ?? [], fn($t) => is_array($t));
        }

        return view('add-ons', [
            'booking' => $booking,
            'passengers' => array_values($passengers),
            'flight' => $flight,
            'reference' => $booking->booking_reference
        ]);
    }
}

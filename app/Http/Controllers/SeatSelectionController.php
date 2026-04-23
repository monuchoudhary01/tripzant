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
            $flight = $apiData['item'] ?? null;
            
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

        foreach ($booking->items as $item) {
            $details = json_decode($item->details, true);
            if (is_array($details)) {
                $passengers = array_merge($passengers, $details);
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
            $flight = $apiData['item'] ?? null;
        }

        foreach ($booking->items as $item) {
            $details = json_decode($item->details, true);
            if (is_array($details)) {
                $passengers = array_merge($passengers, $details);
            }
        }

        return view('add-ons', [
            'booking' => $booking,
            'passengers' => $passengers,
            'flight' => $flight,
            'reference' => $booking->booking_reference
        ]);
    }
}

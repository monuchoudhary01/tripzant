<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\HotelService;
use App\Models\HotelBooking;
use Illuminate\Support\Facades\DB;

class HotelBookingController extends Controller
{
    public function book(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'hotel_code' => 'required|string',
            'room_type' => 'required|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'guests' => 'required|array',
            'guests.*.name' => 'required|string',
            'guests.*.surname' => 'required|string',
            'guests.*.type' => 'required|string',
            'rate_key' => 'required|string',
            'holder_name' => 'required|string',
            'holder_surname' => 'required|string',
            'email' => 'required|email',
        ]);

        $hotelService = new HotelService();
        DB::beginTransaction();
        try {
            $bookingResult = $hotelService->book([
                'holder_name' => $validated['holder_name'],
                'holder_surname' => $validated['holder_surname'],
                'rateKey' => $validated['rate_key'],
                'paxes' => $validated['guests'],
                'booking_id' => null // can be set if you want to link to a main booking
            ]);

            if (isset($bookingResult['error'])) {
                DB::rollBack();
                return response()->json(['error' => $bookingResult['message'] ?? 'Booking failed'], 422);
            }

            // Save booking in DB (already handled in HotelService if patched)
            DB::commit();
            return response()->json(['success' => true, 'booking' => $bookingResult['booking']]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

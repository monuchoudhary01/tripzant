<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->latest()->get();
        
        $totalBookings = $bookings->count();
        $totalGmv = $bookings->sum('selling_price');
        $totalCommission = $bookings->sum('commission');
        $cancelRate = $totalBookings > 0 ? ($bookings->where('status', 'cancelled')->count() / $totalBookings) * 100 : 0;

        return view('admin.bookings', compact('bookings', 'totalBookings', 'totalGmv', 'totalCommission', 'cancelRate'));
    }
}

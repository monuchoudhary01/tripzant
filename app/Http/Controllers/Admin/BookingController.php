<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%$search%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%$search%");
                  });
            });
        }

        $bookings = $query->latest()->paginate(20);
        
        $totalBookings = Booking::count();
        $totalGmv = Booking::sum('total_amount');
        $totalCommission = 0; // Column missing in bookings table, maybe in a relation?
        $cancelRate = $totalBookings > 0 ? (Booking::where('status', 'cancelled')->count() / $totalBookings) * 100 : 0;

        return view('admin.bookings', compact('bookings', 'totalBookings', 'totalGmv', 'totalCommission', 'cancelRate'));
    }

    public function flights(Request $request)
    {
        $query = Booking::where('type', 'flight')->with(['user', 'flightBooking']);

        // Advanced Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('pnr')) {
            $pnr = $request->pnr;
            $query->whereHas('flightBooking', function($q) use ($pnr) {
                $q->where('pnr', 'like', "%$pnr%");
            });
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('booking_reference', 'like', "%$search%");
        }
        if ($request->filled('user_name')) {
            $userName = $request->user_name;
            $query->whereHas('user', function($q) use ($userName) {
                $q->where('name', 'like', "%$userName%");
            });
        }
        if ($request->filled('journey_date')) {
            $date = $request->journey_date;
            $query->whereHas('flightBooking', function($q) use ($date) {
                $q->whereDate('departure_at', $date);
            });
        }

        $bookings = $query->latest()->paginate(15);

        $stats = [
            'total' => Booking::where('type', 'flight')->count(),
            'confirmed' => Booking::where('type', 'flight')->where('status', 'confirmed')->count(),
            'pending' => Booking::where('type', 'flight')->where('status', 'pending')->count(),
            'cancelled' => Booking::where('type', 'flight')->where('status', 'cancelled')->count(),
            'revenue' => Booking::where('type', 'flight')->where('status', 'confirmed')->sum('total_amount'),
        ];

        return view('admin.flights', compact('bookings', 'stats'));
    }

    public function hotels(Request $request)
    {
        $query = Booking::where('type', 'hotel')->with(['user', 'hotelBooking']);

        // Advanced Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('hotel')) {
            $hotel = $request->hotel;
            $query->whereHas('hotelBooking', function($q) use ($hotel) {
                $q->where('hotel_name', 'like', "%$hotel%");
            });
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('booking_reference', 'like', "%$search%");
        }
        if ($request->filled('city')) {
            $city = $request->city;
            $query->whereHas('hotelBooking', function($q) use ($city) {
                $q->where('city', 'like', "%$city%");
            });
        }

        $bookings = $query->latest()->paginate(15);

        $stats = [
            'total' => Booking::where('type', 'hotel')->count(),
            'confirmed' => Booking::where('type', 'hotel')->where('status', 'confirmed')->count(),
            'pending' => Booking::where('type', 'hotel')->where('status', 'pending')->count(),
            'cancelled' => Booking::where('type', 'hotel')->where('status', 'cancelled')->count(),
            'revenue' => Booking::where('type', 'hotel')->where('status', 'confirmed')->sum('total_amount'),
        ];

        return view('admin.hotels', compact('bookings', 'stats'));
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'flightBooking', 'hotelBooking', 'passengers'])->findOrFail($id);
        return response()->json($booking);
    }

    public function detail($id)
    {
        $booking = Booking::with(['user', 'flightBooking', 'hotelBooking', 'passengers', 'payments'])->findOrFail($id);
        
        $otherBookings = Booking::where('user_id', $booking->user_id)
            ->where('id', '!=', $id)
            ->with(['flightBooking', 'hotelBooking'])
            ->latest()
            ->take(5)
            ->get();
        
        if ($booking->type === 'flight') {
            return view('admin.flight-detail', compact('booking', 'otherBookings'));
        } elseif ($booking->type === 'hotel') {
            return view('admin.hotel-detail', compact('booking', 'otherBookings'));
        }
        
        return view('admin.bookings.show', compact('booking', 'otherBookings'));
    }


    public function exportFlights()
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=flight_bookings_' . date('Y-m-d') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $bookings = Booking::where('type', 'flight')->with(['user', 'flightBooking'])->latest()->get();

        $callback = function() use($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Ref', 'User', 'Airline', 'Flight No', 'Origin', 'Destination', 'Date', 'PNR', 'Amount', 'Status']);

            foreach ($bookings as $booking) {
                $fb = $booking->flightBooking;
                $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
                
                $pnr = $fb->pnr ?? ($details['pnr'] ?? 'N/A');
                $airline = $fb->airline_code ?? ($details['airline_code'] ?? 'N/A');
                $flightNo = $fb->flight_number ?? ($details['flight_number'] ?? 'N/A');
                $origin = $fb->origin ?? ($details['origin'] ?? 'N/A');
                $destination = $fb->destination ?? ($details['destination'] ?? 'N/A');
                $date = $fb->departure_at ?? ($details['departure_at'] ?? 'N/A');

                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->user->name ?? 'User',
                    $airline,
                    $flightNo,
                    $origin,
                    $destination,
                    $date,
                    $pnr,
                    $booking->total_amount,
                    $booking->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportHotels()
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=hotel_bookings_' . date('Y-m-d') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $bookings = Booking::where('type', 'hotel')->with(['user', 'hotelBooking'])->latest()->get();

        $callback = function() use($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Ref', 'User', 'Hotel Name', 'City', 'Check In', 'Check Out', 'Rooms', 'Amount', 'Status']);

            foreach ($bookings as $booking) {
                $hb = $booking->hotelBooking;
                $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
                
                $hotel = $hb->hotel_name ?? ($details['hotel_name'] ?? 'N/A');
                $city = $hb->city ?? ($details['city_name'] ?? 'N/A');
                $checkIn = $hb->check_in ?? ($details['check_in'] ?? 'N/A');
                $checkOut = $hb->check_out ?? ($details['check_out'] ?? 'N/A');
                $rooms = $hb->rooms ?? ($details['rooms'] ?? 1);

                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->user->name ?? 'User',
                    $hotel,
                    $city,
                    $checkIn,
                    $checkOut,
                    $rooms,
                    $booking->total_amount,
                    $booking->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

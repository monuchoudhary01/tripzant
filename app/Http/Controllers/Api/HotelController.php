<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HotelService;
use App\Services\AuditLogService;

class HotelController extends Controller
{
    protected $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function search(Request $request)
    {
        $params = [
            'checkIn'         => $request->checkin ?? date('Y-m-d', strtotime('+7 days')),
            'checkOut'        => $request->checkout ?? date('Y-m-d', strtotime('+8 days')),
            'destinationCode' => $request->city_code ?? 'DXB',
            'adults'          => $request->adults ?? 2,
            'children'        => $request->children ?? 0,
            'rooms'           => $request->rooms ?? 1,
        ];

        $results = $this->hotelService->search($params);
        $hotels  = $results['hotels']['hotels'] ?? [];
        
        // Simple pagination simulation if needed, but HotelBeds returns all results usually
        
        return response()->json([
            'success' => true,
            'hotels' => $hotels,
            'params' => $params
        ]);
    }

    public function details(Request $request, $code)
    {
        $checkIn   = $request->input('checkIn', date('Y-m-d', strtotime('+7 days')));
        $checkOut  = $request->input('checkOut', date('Y-m-d', strtotime('+8 days')));
        $adults    = $request->input('adults', 2);
        $children  = $request->input('children', 0);
        $rooms     = $request->input('rooms', 1);

        $data = $this->hotelService->getDetails($code, $checkIn, $checkOut, $adults, $children, $rooms);

        return response()->json([
            'success' => true,
            'hotel' => $data['content'] ?? null,
            'availability' => $data['availability'] ?? null,
            'params' => [
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
                'adults' => $adults,
                'children' => $children,
                'rooms' => $rooms
            ]
        ]);
    }

    public function bookings(Request $request)
    {
        $bookings = auth()->user()->bookings()->where('booking_type', 'hotel')->get();
        return response()->json(['success' => true, 'bookings' => $bookings]);
    }
}

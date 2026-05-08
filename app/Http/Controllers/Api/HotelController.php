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

    /**
     * @OA\Get(
     *     path="/hotels/search",
     *     tags={"Hotels"},
     *     summary="Search Hotels",
     *     description="Search for hotels based on city code and dates",
     *     @OA\Parameter(name="city_code", in="query", required=false, @OA\Schema(type="string", example="DXB"), description="Destination city code (e.g. DXB)"),
     *     @OA\Parameter(name="checkin", in="query", required=false, @OA\Schema(type="string", format="date", example="2024-12-01"), description="Check-in date (YYYY-MM-DD)"),
     *     @OA\Parameter(name="checkout", in="query", required=false, @OA\Schema(type="string", format="date", example="2024-12-05"), description="Check-out date (YYYY-MM-DD)"),
     *     @OA\Parameter(name="adults", in="query", @OA\Schema(type="integer", example=2), description="Number of adults"),
     *     @OA\Response(response=200, description="List of hotels")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/hotels/details/{code}",
     *     tags={"Hotels"},
     *     summary="Hotel Details",
     *     description="Get room types and availability for a specific hotel",
     *     @OA\Parameter(name="code", in="path", required=true, @OA\Schema(type="string"), description="Hotel code"),
     *     @OA\Parameter(name="checkIn", in="query", @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="checkOut", in="query", @OA\Schema(type="string", format="date")),
     *     @OA\Response(response=200, description="Hotel content and availability")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/hotels/bookings",
     *     tags={"Hotels"},
     *     summary="My Hotel Bookings",
     *     description="Get list of hotel bookings for the authenticated user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of hotel bookings")
     * )
     */
    public function bookings(Request $request)
    {
        $bookings = auth()->user()->bookings()->where('booking_type', 'hotel')->get();
        return response()->json(['success' => true, 'bookings' => $bookings]);
    }
}

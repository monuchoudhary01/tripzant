<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityService;

use App\Models\Booking;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(Request $request)
    {
        $userCurrency = strtoupper($request->route('currency') ?? session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD')));
        $params = [
            'latitude' => $request->lat ?? '48.8566',
            'longitude' => $request->lng ?? '2.3522',
            'destinationCode' => $request->destination ?? 'PMI',
            'from' => $request->from ?? date('Y-m-d', strtotime('+3 days')),
            'to' => $request->to ?? date('Y-m-d', strtotime('+10 days')),
            'currency' => $userCurrency,
        ];

        $results = $this->activityService->search($params);
        $apiTours = $results['data'] ?? [];

        // Fetch local tours and map them to the UI structure
        $localTours = \App\Models\Tour::where('is_active', true)->get()->map(function($tour) use ($userCurrency) {
            $images = is_array($tour->images) ? $tour->images : json_decode($tour->images, true);
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'description' => $tour->description,
                'duration' => $tour->duration,
                'rating' => 4.8,
                'reviews' => rand(50, 200),
                'price' => \App\Helpers\CurrencyConverter::convertBetween($tour->price, 'INR', $userCurrency),
                'original_price' => \App\Helpers\CurrencyConverter::convertBetween(round($tour->price * 1.2, 0), 'INR', $userCurrency),
                'currency' => $userCurrency,
                'image' => (isset($images[0]) && $images[0]) ? $images[0] : 'https://images.unsplash.com/photo-1548013146-72479768b921?w=800&auto=format&fit=crop&q=80',
                'destinations' => $tour->location,
                'discount' => '20% OFF'
            ];
        })->toArray();

        $allTours = array_merge($apiTours, $localTours);

        return view('tours.listings', [
            'tours' => $allTours,
            'params' => $params
        ]);
    }

    public function book(Request $request)
    {
        // Activity booking logic (usually involves calling the API first)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'booking_type' => 'tour',
            'api_reference' => 'T-ACT-' . strtoupper(bin2hex(random_bytes(4))),
            'net_price' => $request->net_price ?? ($request->price * 0.9),
            'selling_price' => $request->price,
            'markup' => $request->price - ($request->net_price ?? ($request->price * 0.9)),
            'payment_status' => 'confirmed',
            'status' => 'confirmed',
            'contact_email' => Auth::user()->email ?? $request->email,
            'booking_details' => json_encode($request->all())
        ]);

        AuditLogService::log('Activity', 'Booking', "Activity booked: {$request->title}", $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Activity booked successfully!',
            'booking_id' => $booking->api_reference
        ]);
    }

    public function show($id)
    {
        // Try finding in local DB first
        $tour = \App\Models\Tour::find($id);
        
        if ($tour) {
            $images = is_array($tour->images) ? $tour->images : json_decode($tour->images, true);
            $formatted = [
                'id' => $tour->id,
                'title' => $tour->title,
                'description' => $tour->description,
                'duration' => $tour->duration,
                'price' => $tour->price,
                'image' => (isset($images[0]) && $images[0]) ? $images[0] : 'https://images.unsplash.com/photo-1548013146-72479768b921?w=800&auto=format&fit=crop&q=80',
                'location' => $tour->location,
                'itinerary' => is_array($tour->itinerary) ? $tour->itinerary : json_decode($tour->itinerary, true)
            ];
            return view('tours.details', ['tour' => $formatted]);
        }

        // Handle API detail lookup logic if needed here...
        
        return view('tours.details', ['tour' => null]);
    }
}

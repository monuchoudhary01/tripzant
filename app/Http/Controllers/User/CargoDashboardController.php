<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CargoBooking;
use App\Models\CargoProvider;
use App\Models\CargoTracking;
use App\Models\CargoCustomsDeclaration;
use App\Models\CargoInsurance;
use App\Models\CargoPromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CargoDashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $bookings = CargoBooking::where('user_id', auth()->id())
            ->with(['provider', 'tracking'])
            ->latest()
            ->get();
        return view('cargo.dashboard.index', compact('bookings'));
    }

    public function create() {
        return view('cargo.dashboard.book');
    }

    public function searchProviders(Request $request) {
        $request->validate([
            'origin_city' => 'required',
            'destination_city' => 'required',
            'weight' => 'required|numeric',
        ]);

        $weight = $request->weight;
        $providers = CargoProvider::where('is_active', true)->get();

        $results = $providers->map(function($provider) use ($weight) {
            $base_price = $provider->base_rate + ($weight * $provider->per_kg_rate);
            $eta_days = rand(3, 7); 
            
            return [
                'id' => $provider->id,
                'name' => $provider->name,
                'logo' => $provider->logo_url,
                'price' => round($base_price, 2),
                'eta' => $eta_days . ' Days',
                'rating' => $provider->rating,
                'type' => $provider->name == 'DHL Express' ? 'Fastest' : ($provider->name == 'AusPost International' ? 'Cheapest' : 'Best Rated')
            ];
        });

        $cheapest = $results->sortBy('price')->first();
        $fastest = $results->where('name', 'DHL Express')->first() ?? $results->first();
        $bestRated = $results->sortByDesc('rating')->first();

        return response()->json([
            'success' => true,
            'providers' => $results,
            'recommendations' => [
                'cheapest' => $cheapest,
                'fastest' => $fastest,
                'best_rated' => $bestRated
            ]
        ]);
    }

    public function store(Request $request) {
        $bookingRef = 'TZC-' . strtoupper(Str::random(10));
        $trackingId = 'TRK' . strtoupper(substr(md5(time()), 0, 10));

        $bookingId = DB::table('cargo_bookings')->insertGetId([
            'booking_ref' => $bookingRef,
            'tracking_id' => $trackingId,
            'user_id' => auth()->id(),
            'provider_id' => $request->provider_id ?? 1,
            'origin_country' => 'Australia',
            'origin_city' => $request->origin_city ?? 'Melbourne',
            'destination_country' => 'India',
            'destination_city' => $request->destination_city ?? 'New Delhi',
            'parcel_type' => $request->parcel_type ?? 'Standard',
            'weight' => $request->weight ?? 1,
            'base_price' => 100,
            'tax_fee' => 10,
            'total_price' => 110,
            'status' => 'Pickup scheduled',
            'sender_details' => json_encode([
                'name' => auth()->user()->name,
                'address' => $request->sender_address ?? '123 Pilot Lane, Melbourne',
                'phone' => '0400 000 000'
            ]),
            'receiver_details' => json_encode([
                'name' => $request->receiver_name ?? 'Guest Receiver',
                'address' => $request->receiver_address ?? '456 Global Way, New Delhi',
                'phone' => '9880000000'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tax_exemption_letters')->insert([
            'booking_id' => $bookingId,
            'tracking_id' => $trackingId,
            'sender_details' => json_encode(['name' => auth()->user()->name]),
            'receiver_details' => json_encode(['name' => $request->receiver_name]),
            'item_details' => json_encode(['desc' => $request->item_description, 'cat' => 'Gifts', 'val' => 110]),
            'barcode_data' => json_encode(['v' => url('/cargo/verify/'.$trackingId)]),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'booking_id' => $bookingId,
            'redirect' => route('cargo.dashboard.tracking', $bookingRef)
        ]);
    }

    public function tracking($ref) {
        $booking = CargoBooking::where('booking_ref', $ref)
            ->with(['provider', 'tracking'])
            ->firstOrFail();
            
        $exemption = DB::table('tax_exemption_letters')->where('tracking_id', $booking->tracking_id)->first();
        
        return view('cargo.dashboard.track', compact('booking', 'exemption'));
    }

    public function verifyShipment($tracking_id) {
        $letter = DB::table('tax_exemption_letters')->where('tracking_id', $tracking_id)->first();
        
        if (!$letter) {
            return view('cargo.dashboard.verify', ['status' => 'Invalid', 'msg' => 'No exemption record found.']);
        }

        return view('cargo.dashboard.verify', [
            'status' => 'Authentic',
            'letter' => $letter,
            'sender' => json_decode($letter->sender_details),
            'receiver' => json_decode($letter->receiver_details),
            'item' => json_decode($letter->item_details)
        ]);
    }

    public function downloadLetter($ref) {
        $booking = CargoBooking::where('booking_ref', $ref)->firstOrFail();
        $exemption = DB::table('tax_exemption_letters')->where('tracking_id', $booking->tracking_id)->first();
        
        if (!$exemption) return redirect()->back()->with('error', 'Not eligible.');

        return view('cargo.dashboard.letter', [
            'booking' => $booking,
            'sender' => json_decode($exemption->sender_details),
            'receiver' => json_decode($exemption->receiver_details),
            'item' => json_decode($exemption->item_details)
        ]);
    }

    public function shippingLabel($ref) {
        $booking = CargoBooking::where('booking_ref', $ref)->firstOrFail();
        
        $carriers = ['DHL Global Express', 'FedEx International', 'UPS WorldWide', 'Aramex Logistics'];
        $assignedCarrier = $carriers[$booking->provider_id % count($carriers)];

        return view('cargo.dashboard.labels.shipping', [
            'booking' => $booking,
            'carrier' => $assignedCarrier,
            'sender' => is_string($booking->sender_details) ? json_decode($booking->sender_details) : (object)$booking->sender_details,
            'receiver' => is_string($booking->receiver_details) ? json_decode($booking->receiver_details) : (object)$booking->receiver_details,
        ]);
    }
}

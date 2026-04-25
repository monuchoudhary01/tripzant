<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\AuditLogService;
use App\Services\PricingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'flight');
        $mode = $request->input('mode');
        $id = $request->input('id', $request->input('amp;id'));
        $item = null;

        $totalPrice = 0;
        if ($mode === 'split') {
            $item = session('split_flights', []);
            $type = 'flight';
            if (is_array($item)) {
                $totalPrice = array_sum(array_column($item, 'price'));
            }
        } elseif ($type === 'flight') {
            // 1. Try Global Cache First (Most robust)
            $item = \Illuminate\Support\Facades\Cache::get('flight_data_' . $id);
            
            if (empty($item)) {
                // 2. Try Session Cache
                $cacheKey = 'flight_search_' . session()->getId();
                $cachedResults = \Illuminate\Support\Facades\Cache::get($cacheKey) ?: \Illuminate\Support\Facades\Cache::get('flight_search_full', []);
                $rawFlights = $cachedResults['data'] ?? [];
                
                foreach ($rawFlights as $flight) {
                    $fid = is_object($flight) ? ($flight->id ?? null) : ($flight['id'] ?? null);
                    if ($fid == $id) {
                        $item = is_object($flight) ? $flight->toArray() : $flight;
                        break;
                    }
                }
            }

            if ($item) {
                $item = is_object($item) ? $item->toArray() : $item;
                $priceVal = $item['price'] ?? ($item['total_price'] ?? 0);
                
                // If price is an object (Amadeus raw style), extract total
                if (is_array($priceVal) || is_object($priceVal)) {
                    $priceVal = is_array($priceVal) ? ($priceVal['total'] ?? 0) : ($priceVal->total ?? 0);
                }
                
                $totalPrice = (float) $priceVal;
            }
        } else {
            if ($type === 'homestay') $item = \App\Models\Homestay::find($id);
            elseif ($type === 'tour') $item = \App\Models\Tour::find($id);
            elseif ($type === 'esim') $item = \App\Models\EsimPlan::find($id);
            elseif ($type === 'insurance') $item = \App\Models\InsurancePlan::find($id);
            
            if ($item && isset($item->price)) {
                $totalPrice = $item->price;
            }
        }

        return view('checkout', compact('type', 'item', 'totalPrice'));
    }

    public function initSplit(Request $request)
    {
        $flightsData = $request->input('flights', '[]');
        $flights = json_decode($flightsData, true);
        if (!$flights || !is_array($flights)) {
            return response()->json(['success' => false, 'message' => 'Invalid flight data']);
        }
        
        session(['split_flights' => $flights]);
        return response()->json(['success' => true, 'redirect' => route('checkout', ['mode' => 'split', 'type' => 'flight'])]);
    }

    public function saveTravelers(Request $request)
    {
        try {
            $type = $request->input('type', 'flight');
            $travelers = $request->input('travelers', []);
            $totalAmount = floatval($request->input('total_amount', 0));
            $itemData = $request->input('item_data');

            if (empty($travelers)) {
                return response()->json(['success' => false, 'message' => 'Traveler details missing.']);
            }

            if ($totalAmount <= 0 && $itemData) {
                $item = is_string($itemData) ? json_decode($itemData, true) : (array)$itemData;
                $priceVal = $item['price'] ?? ($item['total_price'] ?? 0);
                if (is_array($priceVal)) $priceVal = $priceVal['total'] ?? 0;
                $totalAmount = floatval($priceVal) * count($travelers);
            }

            session(['pending_traveler_booking' => [
                'type'         => $type,
                'total_amount' => $totalAmount,
                'travelers'    => $travelers,
                'item_data'    => $itemData,
            ]]);

            $tempRef = 'TEMP-' . strtoupper(bin2hex(random_bytes(4)));

            return response()->json([
                'success'  => true,
                'redirect' => route('seat.selection', ['reference' => $tempRef, 'mode' => 'pending'])
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function initiatePayment(Request $request)
    {
        try {
            $reference  = $request->input('reference');
            $totalAmount = floatval($request->input('total_amount', 0));
            $addons     = $request->input('addons', []);

            $pendingData = session('pending_traveler_booking', []);

            if ($totalAmount <= 0 && isset($pendingData['total_amount'])) {
                $totalAmount = floatval($pendingData['total_amount']);
            }

            if ($totalAmount <= 0) {
                return response()->json(['success' => false, 'message' => 'Payment amount is invalid (₹0).']);
            }

            $travelers = $pendingData['travelers'] ?? [];
            $seats     = $request->input('seats', []);

            // Assign seats to travelers from Leg 0 (if available)
            if (!empty($seats) && isset($seats[0])) {
                foreach ($travelers as $idx => &$traveler) {
                    if (isset($seats[0][$idx]['seatId'])) {
                        $traveler['seat'] = $seats[0][$idx]['seatId'];
                    }
                }
            }

            $email     = $travelers[0]['email'] ?? (auth()->user()->email ?? null);
            $type      = $pendingData['type'] ?? 'flight';

            session(['pending_generic_booking' => [
                'type'         => $type,
                'total_amount' => $totalAmount,
                'travelers'    => $travelers,
                'addons'       => $addons,
                'item_data'    => $pendingData['item_data'] ?? null,
                'reference'    => $reference,
            ]]);

            $stripe  = app(\App\Services\StripeService::class);
            $session = $stripe->createCheckoutSession([
                'item_name'   => 'Flight Booking — Tripzant',
                'amount'      => $totalAmount,
                'email'       => $email,
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => url()->previous(),
                'metadata'    => ['type' => $type, 'user_id' => auth()->id()],
            ]);

            if (isset($session->url)) {
                return response()->json(['success' => true, 'redirect' => $session->url]);
            }

            throw new \Exception($session['message'] ?? 'Stripe session creation failed.');

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function process(Request $request)
    {
        try {
            $type = $request->input('type', 'flight');
            
            // Get amount — from JSON body (numeric) or form post (string)
            $totalAmount = floatval($request->input('total_amount', 0));
            $travelers = $request->input('travelers', []);

            // If amount is still 0, try to recover from cached item
            if ($totalAmount <= 0) {
                $itemData = $request->input('item_data');
                if ($itemData) {
                    $item = is_string($itemData) ? json_decode($itemData, true) : (array)$itemData;
                    $priceVal = $item['price'] ?? ($item['total_price'] ?? 0);
                    if (is_array($priceVal)) $priceVal = $priceVal['total'] ?? 0;
                    $totalAmount = floatval($priceVal);
                }
            }

            if ($totalAmount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount invalid hai (₹0). Flight dobara search karein ya page reload karein.'
                ]);
            }

            // Store pending booking in session
            session(['pending_generic_booking' => [
                'type' => $type,
                'total_amount' => $totalAmount,
                'travelers' => $travelers,
                'extra_services' => $request->input('extra_services'),
                'item_data' => $request->input('item_data')
            ]]);

            $stripe = app(\App\Services\StripeService::class);
            $session = $stripe->createCheckoutSession([
                'item_name' => ucfirst($type) . ' Booking - Tripzant',
                'amount' => $totalAmount,
                'email' => Auth::user()->email ?? ($travelers[0]['email'] ?? null),
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url()->previous(),
                'metadata' => [
                    'type' => $type,
                    'user_id' => Auth::id()
                ]
            ]);

            if (isset($session->url)) {
                return response()->json([
                    'success' => true,
                    'redirect' => $session->url
                ]);
            }

            // Stripe returned an error array
            $stripeMsg = $session['message'] ?? 'Stripe payment session create nahi ho saka.';
            throw new \Exception($stripeMsg);

        } catch (\Exception $e) {
            \App\Services\AuditLogService::log('BOOKING', 'PAYMENT_ERROR', $e->getMessage(), $request->all());
            return response()->json([
                'success' => false, 
                'message' => 'Payment Error: ' . $e->getMessage()
            ]);
        }
    }

    public function success(Request $request)
    {
        $sessionData = session('pending_generic_booking');
        if (!$sessionData) {
            return redirect()->route('home')->with('error', 'Session expired.');
        }

        $type = $sessionData['type'];
        $totalAmount = $sessionData['total_amount'];
        $travelers = $sessionData['travelers'] ?? [];

        // Create Booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'booking_reference' => strtoupper($type) . '-' . strtoupper(bin2hex(random_bytes(4))),
            'type' => $type,
            'total_amount' => $totalAmount,
            'currency' => 'INR',
            'status' => 'confirmed',
            'api_booking_details' => json_encode($sessionData)
        ]);

        // Save each traveler as a BookingItem so seat-selection can load the manifest
        foreach ($travelers as $index => $traveler) {
            \App\Models\BookingItem::create([
                'booking_id' => $booking->id,
                'item_name' => ($traveler['first_name'] ?? 'Traveler') . ' ' . ($traveler['last_name'] ?? ($index + 1)),
                'item_type' => 'traveler',
                'amount' => 0,
                'details' => json_encode($traveler)
            ]);
        }

        // Create Payment Record
        \App\Models\Payment::create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'transaction_id' => $request->query('session_id', 'STRIPE-' . uniqid()),
            'amount' => $totalAmount,
            'currency' => 'INR',
            'gateway' => 'stripe',
            'status' => 'paid',
            'gateway_response' => json_encode($request->all())
        ]);

        session()->forget('pending_generic_booking');

        return redirect()->route('booking.confirmation', ['reference' => $booking->booking_reference])
                         ->with('success', 'Payment Successful!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\AuditLogService;
use App\Services\PricingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\BookingService;

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

                // If it's a UnifiedFlight (from SOAP), wrap it in a mock REST structure
                // We keep original properties too for compatibility with flat-accessing JS
                if (isset($item['departure_city'])) {
                    $mockOffer = array_merge($item, [
                        'id' => $item['id'],
                        'itineraries' => [
                            [
                                'duration' => $item['duration'] ?? 'PT2H',
                                'segments' => [
                                    [
                                        'departure' => [
                                            'iataCode' => $item['departure_city'],
                                            'at' => $item['departure_at'],
                                            'terminal' => $item['terminal'] ?? 'T1'
                                        ],
                                        'arrival' => [
                                            'iataCode' => $item['arrival_city'],
                                            'at' => $item['arrival_at']
                                        ],
                                        'carrierCode' => $item['airline_code'],
                                        'number' => $item['flight_number'],
                                        'duration' => $item['duration'] ?? 'PT2H'
                                    ]
                                ]
                            ]
                        ],
                        'price' => [
                            'currency' => $item['currency'] ?? 'INR',
                            'total' => $item['price'],
                            'base' => $item['price'] * 0.8
                        ],
                        'travelerPricings' => [
                            [
                                'fareDetailsBySegment' => [
                                    [
                                        'cabin' => $item['cabin'] ?? 'ECONOMY',
                                        'class' => 'Y',
                                        'includedCheckedBags' => [
                                            'weight' => str_replace(' KG', '', $item['baggage'] ?? '15'),
                                            'weightUnit' => 'KG'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]);
                    $item = $mockOffer;
                }

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
            $seats     = $request->input('seats', []); // This is selectionsByLeg {0: {paxIdx: {seatId, price}}, 1: ...}

            // Assign seats to travelers for ALL legs
            foreach ($travelers as $idx => &$traveler) {
                $paxSeats = [];
                foreach ($seats as $legIdx => $legSeats) {
                    if (isset($legSeats[$idx]['seatId'])) {
                        $paxSeats[$legIdx] = $legSeats[$idx]['seatId'];
                    }
                }
                // Store all seats as an array in the traveler object
                $traveler['all_seats'] = $paxSeats;
                // Keep 'seat' as legacy for the first leg
                $traveler['seat'] = $paxSeats[0] ?? null;
            }

            $email     = $travelers[0]['email'] ?? (auth()->user()->email ?? null);
            $type      = $pendingData['type'] ?? 'flight';
            $gateway   = $request->input('gateway', 'stripe');

            $bookingData = [
                'type'         => $type,
                'total_amount' => $totalAmount,
                'travelers'    => $travelers,
                'addons'       => $addons,
                'seats_by_leg' => $seats,
                'item_data'    => $pendingData['item_data'] ?? null,
                'reference'    => $reference,
                'gateway'      => $gateway,
                'user_id'      => auth()->id(),
                'currency'     => ($gateway === 'mpgs') ? 'LKR' : 'INR'
            ];

            session(['pending_generic_booking' => $bookingData]);

            // Create a pending booking in DB for tracking/webhook
            Booking::create([
                'user_id' => auth()->id(),
                'booking_reference' => $reference,
                'type' => $type,
                'total_amount' => $totalAmount,
                'currency' => $bookingData['currency'],
                'status' => 'pending',
                'api_booking_details' => json_encode($bookingData)
            ]);

            if ($gateway === 'mpgs') {
                $mpgs = app(\App\Services\MpgsService::class);
                $session = $mpgs->createCheckoutSession([
                    'order_id' => $reference,
                    'amount'   => $totalAmount,
                    'currency' => 'LKR',
                ]);

                if (isset($session['session']['id'])) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('checkout.mpgs', ['reference' => $reference])
                    ]);
                }

                throw new \Exception($session['message'] ?? 'Commercial Bank session creation failed.');
            } else {
                $stripe  = app(\App\Services\StripeService::class);
                $session = $stripe->createCheckoutSession([
                    'item_name'   => 'Flight Booking — Tripzant',
                    'amount'      => $totalAmount,
                    'email'       => $email,
                    'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}&reference=' . $reference,
                    'cancel_url'  => url()->previous(),
                    'metadata'    => ['type' => $type, 'user_id' => auth()->id(), 'reference' => $reference],
                ]);

                if (isset($session->url)) {
                    return response()->json(['success' => true, 'redirect' => $session->url]);
                }

                throw new \Exception($session['message'] ?? 'Stripe session creation failed.');
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function showMpgsCheckout(Request $request)
    {
        $reference = $request->query('reference');
        $sessionData = session('pending_generic_booking');

        if (!$sessionData || $sessionData['reference'] !== $reference) {
            return redirect()->route('flights.index')->with('error', 'Booking session not found.');
        }

        $mpgs = app(\App\Services\MpgsService::class);
        $session = $mpgs->createCheckoutSession([
            'order_id' => $reference,
            'amount'   => $sessionData['total_amount'],
            'currency' => 'LKR',
        ]);

        if (!isset($session['session']['id'])) {
            return redirect()->back()->with('error', 'Could not initialize payment gateway.');
        }

        $paymentSettings = \App\Models\GlobalSetting::where('group', 'payments')->get()->pluck('value', 'key');
        $merchantId = $paymentSettings['payment_mpgs_merchant_id'] ?? config('payments.mpgs.merchant_id');

        return view('payment.mpgs-checkout', [
            'order_id'   => $reference,
            'amount'     => $sessionData['total_amount'],
            'currency'   => 'LKR',
            'session'    => $session,
            'merchant_id' => $merchantId
        ]);
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
        $reference = $request->query('reference');
        $sessionData = session('pending_generic_booking');

        // If session lost, recover from DB
        if (!$sessionData && $reference) {
            $booking = Booking::where('booking_reference', $reference)->first();
            if ($booking) {
                $sessionData = json_decode($booking->api_booking_details, true);
            }
        }

        if (!$sessionData) {
            return redirect()->route('home')->with('error', 'Session expired.');
        }

        $gateway = $sessionData['gateway'] ?? 'stripe';
        $transactionId = $request->query('session_id') ?? $request->query('resultIndicator') ?? ('TXN-' . uniqid());

        // Use BookingService to complete the booking
        $bookingService = app(BookingService::class);
        
        // Find existing pending booking
        $booking = Booking::where('booking_reference', $sessionData['reference'] ?? '')->first();
        
        if ($booking && $booking->status === 'confirmed') {
            return redirect()->route('booking.confirmation', ['reference' => $booking->booking_reference]);
        }

        if ($booking) {
            // Update existing
            $booking->update(['status' => 'confirmed']);
            
            // Create items and payment
            foreach ($sessionData['travelers'] ?? [] as $index => $traveler) {
                \App\Models\BookingItem::updateOrCreate(
                    ['booking_id' => $booking->id, 'item_name' => ($traveler['first_name'] ?? 'Traveler') . ' ' . ($traveler['last_name'] ?? ($index + 1))],
                    ['item_type' => 'traveler', 'amount' => 0, 'details' => json_encode($traveler)]
                );
            }

            \App\Models\Payment::updateOrCreate(
                ['transaction_id' => $transactionId],
                [
                    'user_id' => Auth::id() ?: ($booking->user_id),
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_amount,
                    'currency' => $booking->currency,
                    'gateway' => $gateway,
                    'status' => 'paid',
                    'gateway_response' => json_encode($request->all())
                ]
            );
        } else {
            // Fallback to service if something went wrong with pending record
            $booking = $bookingService->completeBooking($sessionData, $transactionId, $gateway, $request->all());
        }

        session()->forget('pending_generic_booking');
        session()->forget('pending_traveler_booking');

        return redirect()->route('booking.confirmation', ['reference' => $booking->booking_reference])
                         ->with('success', 'Payment Successful via ' . strtoupper($gateway) . '!');
    }
}

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
            $item = json_decode($request->input('flights'), true);
            $type = 'flight';
            if (is_array($item)) {
                $totalPrice = array_sum(array_column($item, 'price'));
            }
        } elseif ($type === 'flight') {
            $cacheKey = 'flight_search_' . session()->getId();
            $flightResults = Cache::get($cacheKey) ?: Cache::get('flight_search_full');
            
            if ($flightResults && isset($flightResults['data'])) {
                foreach ($flightResults['data'] as $flight) {
                    $fId = is_array($flight) ? ($flight['id'] ?? '') : ($flight->id ?? '');
                    if ($fId == $id) {
                        $item = is_array($flight) ? $flight : $flight->toArray();
                        break;
                    }
                }
            }

            if ($item) {
                $priceData = $item['price'] ?? ($item['total_price'] ?? 0);
                $totalPrice = is_array($priceData) ? ($priceData['total'] ?? 100) : $priceData;
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

        $stripeKey = config('services.stripe.key');

        return view('checkout', compact('type', 'item', 'stripeKey', 'totalPrice'));
    }

    public function process(Request $request)
    {
        try {
            $type = $request->input('type', 'flight');
            $totalAmount = floatval($request->input('total_amount', 0));
            $travelers = $request->input('travelers', []);

            if ($totalAmount <= 0) {
                throw new \Exception("Invalid amount: {$totalAmount}");
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
                'item_name' => ucfirst($type) . ' Booking',
                'amount' => $totalAmount,
                'email' => Auth::user()->email ?? $travelers[0]['email'] ?? null,
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

            throw new \Exception($session['message'] ?? 'Stripe Session Failed');

        } catch (\Exception $e) {
            \App\Services\AuditLogService::log('BOOKING', 'PAYMENT_ERROR', $e->getMessage(), $request->all());
            return response()->json(['success' => false, 'message' => 'Processing Error: ' . $e->getMessage()]);
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

        return redirect()->route('seat.selection', ['reference' => $booking->booking_reference])
                         ->with('success', 'Payment Successful!');
    }
}

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
            $flightResults = Cache::get('flight_search_full');
            
            // Try Unified Data first (has city names, times etc.)
            if ($flightResults && isset($flightResults['data'])) {
                foreach ($flightResults['data'] as $flight) {
                    $fId = is_array($flight) ? ($flight['id'] ?? '') : ($flight->id ?? '');
                    if ($fId == $id) {
                        $item = is_array($flight) ? $flight : $flight->toArray();
                        break;
                    }
                }
            }

            // Fallback to Raw Data if not found in unified (for backward compatibility)
            if (!$item && $flightResults && isset($flightResults['raw_data'])) {
                foreach ($flightResults['raw_data'] as $flight) {
                    $fId = is_array($flight) ? ($flight['id'] ?? '') : ($flight->id ?? '');
                    if ($fId == $id) {
                        $item = is_array($flight) ? $flight : $flight->toArray();
                        break;
                    }
                }
            }

            if ($item) {
                // Extract numeric price from potential Amadeus price object
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

        $stripeKey = \App\Models\GlobalSetting::where('key', 'stripe_publishable_key')->value('value');

        return view('checkout', compact('type', 'item', 'stripeKey', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $stripeSecret = \App\Models\GlobalSetting::where('key', 'stripe_secret_key')->value('value');
        if (!$stripeSecret) {
            return response()->json(['success' => false, 'message' => 'Stripe is not configured. Please contact admin.']);
        }

        \Stripe\Stripe::setApiKey($stripeSecret);

        try {
            $type = $request->input('type', 'flight');
            $totalAmount = floatval($request->input('total_amount', 0));
            $stripeToken = $request->input('stripeToken');

            if ($totalAmount <= 0) {
                throw new \Exception("Invalid amount: {$totalAmount}");
            }

            // 1. Stripe Charge
            $charge = \Stripe\Charge::create([
                'amount' => $totalAmount * 100, // in paise
                'currency' => 'inr',
                'description' => "Booking for " . ucfirst($type),
                'source' => $stripeToken,
            ]);

            if ($charge->status !== 'succeeded') {
                throw new \Exception("Payment failed with status: {$charge->status}");
            }

            // 2. Create Booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'booking_reference' => strtoupper($type) . '-' . strtoupper(bin2hex(random_bytes(4))),
                'type' => $type,
                'total_amount' => $totalAmount,
                'currency' => 'INR',
                'status' => 'confirmed',
                'api_booking_details' => json_encode($request->except(['_token', 'stripeToken']))
            ]);

            // 3. Create Payment Record
            \App\Models\Payment::create([
                'user_id' => Auth::id(),
                'booking_id' => $booking->id,
                'transaction_id' => $charge->id,
                'amount' => $totalAmount,
                'currency' => 'INR',
                'gateway' => 'stripe',
                'status' => 'paid',
                'gateway_response' => json_encode($charge)
            ]);

            // 4. Create Booking Item
            \App\Models\BookingItem::create([
                'booking_id' => $booking->id,
                'item_name' => ucfirst($type) . ' Booking',
                'item_type' => $type,
                'amount' => $totalAmount,
                'details' => json_encode($request->input('travelers', []))
            ]);

            \App\Services\AuditLogService::log('BOOKING', 'PAYMENT_SUCCESS', "Stripe Payment Success: {$charge->id} for Booking {$booking->booking_reference}", $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Payment Successful! Now select your preferred seats.',
                'redirect' => route('seat.selection', ['reference' => $booking->booking_reference])
            ]);

        } catch (\Stripe\Exception\CardException $e) {
            return response()->json(['success' => false, 'message' => 'Card Error: ' . $e->getError()->message]);
        } catch (\Exception $e) {
            \App\Services\AuditLogService::log('BOOKING', 'PAYMENT_ERROR', $e->getMessage(), $request->all());
            return response()->json(['success' => false, 'message' => 'Processing Error: ' . $e->getMessage()]);
        }
    }
}

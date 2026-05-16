<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HotelService;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

class HotelController extends Controller
{
    protected $hotelService;
    protected $walletService;

    public function __construct(HotelService $hotelService, WalletService $walletService)
    {
        $this->hotelService = $hotelService;
        $this->walletService = $walletService;
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->input('code');
        $coupon = \App\Models\Coupon::where('code', $code)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', date('Y-m-d'));
            })->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        return response()->json([
            'success'         => true,
            'message'         => 'Coupon applied successfully!',
            'discount_amount' => $coupon->discount_amount,
            'discount_type'   => $coupon->discount_type,
            'code'            => $coupon->code
        ]);
    }

    /**
     * Show the main Hotel Search Engine / Default Listings
     */
    public function index(Request $request)
    {
        $checkIn = $request->checkin ?? ($request->checkIn ?? date('Y-m-d', strtotime('+7 days')));
        $checkOut = $request->checkout ?? ($request->checkOut ?? date('Y-m-d', strtotime('+8 days')));

        // Standardize Date Format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $checkIn)) {
            $checkIn = date('Y-m-d', strtotime($checkIn));
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $checkOut)) {
            $checkOut = date('Y-m-d', strtotime($checkOut));
        }

        $cityMap = [
            'BOM' => 'Mumbai', 'DEL' => 'Delhi', 'BLR' => 'Bangalore', 'MAA' => 'Chennai',
            'CCU' => 'Kolkata', 'HYD' => 'Hyderabad', 'DXB' => 'Dubai', 'SIN' => 'Singapore',
            'JAI' => 'Jaipur', 'GOI' => 'Goa', 'AMD' => 'Ahmedabad', 'LKO' => 'Lucknow',
            'PNQ' => 'Pune', 'SXR' => 'Srinagar', 'IXC' => 'Chandigarh', 'LHR' => 'London',
            'JFK' => 'New York', 'COK' => 'Kochi', 'AYJ' => 'Ayodhya', 'IXL' => 'Leh',
            'AGR' => 'Agra', 'UDR' => 'Udaipur', 'DED' => 'Rishikesh', 'SLV' => 'Shimla',
            'KUU' => 'Manali'
        ];

        $destCode = $request->city_code ?? ($request->destination ?? ($request->destinationCode ?? 'DEL'));
        $destName = $request->city ?? ($cityMap[$destCode] ?? $destCode);
        $userCurrency = strtoupper($request->route('currency') ?? session('user_currency', \Illuminate\Support\Facades\Cookie::get('user_currency', 'AUD')));

        $params = [
            'checkIn'         => $checkIn,
            'checkOut'        => $checkOut,
            'destinationCode' => $destCode,
            'destinationName' => $destName,
            'adults'          => $request->adults ?? 2,
            'children'        => $request->children ?? 0,
            'rooms'           => $request->rooms ?? 1,
            'currency'        => $userCurrency,
        ];

        $results = $this->hotelService->search($params);
        $hotels  = $results['hotels']['hotels'] ?? [];
        $error   = $results['error'] ?? null;
        $message = $results['message'] ?? null;

        AuditLogService::log('Hotel', 'Search', "Hotel search in {$params['destinationCode']}", $params);

        if ($request->mode === 'map') {
            $formatted = [];
            $coords = [
                'BKK' => [13.75, 100.51], 
                'DXB' => [25.2, 55.27], 
                'DEL' => [28.61, 77.21],
                'JAI' => [26.91, 75.78],
                'GOI' => [15.29, 73.98],
                'BOM' => [19.07, 72.87],
                'BLR' => [12.97, 77.59]
            ];
            $c = $coords[$params['destinationCode']] ?? [28.6, 77.2];
            $currencyObj = \App\Models\Currency::where('code', $userCurrency)->first();
            $sym = $currencyObj ? $currencyObj->symbol : '$';

            foreach($hotels as $h) {
                $formatted[] = [
                    'id' => $h['code'], 'type' => 'hotel', 'title' => $h['name'],
                    'price' => $sym . number_format($h['price'] ?? 0, 0), 'rating' => $h['rating'] ?? 4,
                    'image' => $h['main_image'] ?? ($h['image'] ?? null), 'lat' => $h['latitude'] ?? ($c[0] + rand(-50,50)/1000),
                    'lng' => $h['longitude'] ?? ($c[1] + rand(-50,50)/1000), 'meta' => ($h['rating'] ?? 4) . ' Star | ' . ($h['location'] ?? 'City Center')
                ];
            }
            return view('explore-map', [
                'dynamicHotels' => json_encode($formatted), 'dynamicFlights' => json_encode([]),
                'dynamicTours' => json_encode([]), 'flights' => [], 'origin' => 'DEL',
                'destination' => $params['destinationCode'], 'departure_date' => $params['checkIn'],
                'return_date' => $params['checkOut'], 'adults' => $params['adults'],
                'children' => $params['children'], 'rooms' => $params['rooms'],
                'originCoords' => json_encode(['lat' => $c[0], 'lng' => $c[1]]), 'activeTab' => 'hotels'
            ]);
        }

        return view('hotel.results', compact('hotels', 'params', 'error', 'message'));
    }

    public function search(Request $request)
    {
        return redirect()->route('hotels.index', $request->all());
    }

    /**
     * Show Hotel Details
     */
    public function details(Request $request)
    {
        $hotelCode = $request->input('hotel_code');
        $checkIn   = $request->input('checkIn');
        $checkOut  = $request->input('checkOut');
        $adults    = $request->input('adults', 2);
        $children  = $request->input('children', 0);

        $rooms     = $request->input('rooms', 1);

        $data = $this->hotelService->getDetails($hotelCode, $checkIn, $checkOut, $adults, $children, $rooms);

        AuditLogService::log('Hotel', 'Details', "Viewed hotel: {$hotelCode} for {$adults} adults, {$children} children");

        $destName = $data['content']['address']['content'] ?? ($data['content']['destinationName'] ?? 'City Center');
        // Extract city from address if it's long
        if (strpos($destName, ',') !== false) {
            $parts = explode(',', $destName);
            $destName = trim(end($parts));
        }

        return view('hotel.details', [
            'hotelContent' => $data['content'],
            'hotelAvail'   => $data['availability'],
            'params'       => [
                'checkIn'  => $checkIn, 
                'checkOut' => $checkOut,
                'adults'   => $adults,
                'children' => $children,
                'rooms'    => $request->input('rooms', 1),
                'destinationName' => $destName,
                'destinationCode' => $data['content']['destinationCode'] ?? ''
            ],
        ]);
    }

    /**
     * Checkout — requires auth.
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            session(['url.intended' => url()->full()]);
            return redirect()->route('login')
                ->with('info', 'Please log in to continue your hotel booking.');
        }

        $rateKey  = $request->input('rate_key');
        $checkIn  = $request->input('checkIn');
        $checkOut = $request->input('checkOut');

        $validation = $this->hotelService->checkRate($rateKey);

        if (isset($validation['error']) || empty($validation['hotel'])) {
            return redirect()->back()->with('error', $validation['message'] ?? 'Could not validate hotel rates. Please try again.');
        }

        $booking = $validation['hotel'] ?? [];
        $rate    = $validation['hotel']['rooms'][0]['rates'][0] ?? [];

        $params = [
            'checkIn'  => $checkIn,
            'checkOut' => $checkOut,
            'adults'   => $request->input('adults', 2),
            'children' => $request->input('children', 0),
            'rooms'    => $request->input('rooms', 1),
        ];

        $coupons = \App\Models\Coupon::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', date('Y-m-d'));
            })->get();

        $paymentSettings = \App\Models\GlobalSetting::where('group', 'payments')->get()->pluck('value', 'key');
        $enabledGateways = [
            'stripe' => ($paymentSettings['payment_stripe_enabled'] ?? '0') === '1',
            'mpgs'   => ($paymentSettings['payment_mpgs_enabled'] ?? '0') === '1',
        ];

        return view('hotel.checkout', compact('booking', 'rate', 'params', 'coupons', 'enabledGateways'));
    }

    /**
     * Finalize Booking — auth required
     */
    public function book(Request $request)
    {
        $request->validate([
            'rate_key'      => 'required|string',
            'total_fare'    => 'required|numeric',
            'pax_name.0'    => 'required|string|max:100',
            'pax_surname.0' => 'required|string|max:100',
            'email'         => 'required|email',
        ]);

        $user      = Auth::user();
        $rateKey   = $request->input('rate_key');
        $totalFare = (float) $request->input('final_total', $request->input('total_fare'));
        $adults    = (int) $request->input('adults', 1);
        $children  = (int) $request->input('children', 0);
        $rooms     = (int) $request->input('rooms', 1);

        $paymentMethod = $request->input('payment_method', 'online');

        // 1. Handle Online Payment Flow
        if ($paymentMethod === 'online') {
            $gateway = $request->input('gateway', 'stripe');
            session(['pending_hotel_booking' => $request->all()]);

            if ($gateway === 'mpgs') {
                $reference = 'H-' . strtoupper(bin2hex(random_bytes(4)));
                session(['pending_hotel_reference' => $reference]);
                return redirect()->route('hotel.payment.mpgs', ['reference' => $reference]);
            } else {
                $stripe = app(\App\Services\StripeService::class);
                $session = $stripe->createCheckoutSession([
                    'item_name'   => 'Hotel Booking: ' . $request->input('hotel_name'),
                    'amount'      => $totalFare,
                    'email'       => $request->input('email') ?? $user->email,
                    'success_url' => route('hotel.payment.process') . '?session_id={CHECKOUT_SESSION_ID}&gateway=stripe',
                    'cancel_url'  => route('hotel.checkout') . '?error=Payment cancelled',
                    'metadata'    => [
                        'booking_type' => 'hotel',
                        'hotel_name'   => $request->input('hotel_name')
                    ]
                ]);

                if (isset($session->url)) {
                    return redirect()->away($session->url);
                }

                return back()->with('error', 'Stripe session creation failed.');
            }
        }

        // 2. Handle Wallet Deduction
        if ($paymentMethod === 'wallet') {
            if ($user->role === 'b2c') {
                return back()->with('error', 'Wallet payment not available for B2C accounts.');
            }
            
            $deduction = $this->walletService->deduct($user, $totalFare, 'Hotel Booking: ' . $request->input('hotel_name'));
            if (!$deduction['success']) {
                return back()->withInput()->with('error', $deduction['message']);
            }
        }

        // 3. Build pax list
        $paxes = [];
        for ($i = 0; $i < $adults; $i++) {
            $paxes[] = [
                'name'    => $request->input("pax_name.{$i}", "Adult {$i}"),
                'surname' => $request->input("pax_surname.{$i}", ""),
                'type'    => 'AD',
            ];
        }
        for ($j = 0; $j < $children; $j++) {
            $idx = $adults + $j;
            $paxes[] = [
                'name'    => $request->input("pax_name.{$idx}", "Child {$j}"),
                'surname' => $request->input("pax_surname.{$idx}", ""),
                'type'    => 'CH',
                'age'     => 8,
            ];
        }

        // 4. Attempt live HotelBeds booking
        $bookingResult = $this->hotelService->book([
            'holder_name'    => $paxes[0]['name'],
            'holder_surname' => $paxes[0]['surname'],
            'rateKey'        => $rateKey,
            'paxes'          => $paxes,
        ]);

        if (isset($bookingResult['error'])) {
            return back()->with('error', $bookingResult['message'] ?? 'Hotel booking failed. Please try again.');
        }

        $bookingRef = $bookingResult['booking']['reference'];

        // 5. Create internal booking record
        try {
            $bookingRecord = \App\Models\Booking::create([
                'user_id'             => $user->id,
                'type'                => 'hotel',
                'booking_reference'   => $bookingRef,
                'status'              => 'confirmed',
                'total_amount'        => $totalFare,
                'currency'            => 'INR',
                'api_booking_details' => json_encode([
                    'hotel_name' => $request->input('hotel_name'),
                    'room_name'  => $request->input('room_name'),
                    'check_in'   => $request->input('checkIn'),
                    'check_out'  => $request->input('checkOut'),
                    'is_mock'    => false,
                    'paxes'      => $paxes,
                    'board_name' => $request->input('board_name'),
                ]),
            ]);

            // Hotel booking detail record
            \App\Models\HotelBooking::create([
                'booking_id'          => $bookingRecord->id,
                'hotel_id'            => $request->input('hotel_code'),
                'hotel_name'          => $request->input('hotel_name'),
                'check_in'            => $request->input('checkIn'),
                'check_out'           => $request->input('checkOut'),
                'rooms'               => (int)($request->input('rooms', 1)),
                'guests'              => (int)($request->input('adults', 1)) + (int)($request->input('children', 0)),
                'room_type'           => $request->input('room_name'),
                'confirmation_number' => $bookingResult['booking']['hotelReference'] ?? null,
                'hotel_details'       => json_encode($bookingResult['booking']['hotel'] ?? []),
            ]);

            // Passenger records
            foreach ($paxes as $p) {
                \App\Models\Passenger::create([
                    'booking_id' => $bookingRecord->id,
                    'type'       => ($p['type'] ?? 'AD') == 'AD' ? 'adult' : 'child',
                    'title'      => ($p['type'] ?? 'AD') == 'AD' ? 'Mr' : 'Mstr',
                    'first_name' => $p['name'],
                    'last_name'  => $p['surname'],
                ]);
            }

            // Payment record
            \App\Models\Payment::create([
                'booking_id'        => $bookingRecord->id,
                'user_id'           => $user->id,
                'transaction_id'    => 'TXN-HOT-' . strtoupper(uniqid()),
                'gateway'           => $user->role !== 'b2c' ? 'wallet' : 'online',
                'amount'            => $totalFare,
                'currency'          => 'INR',
                'status'            => 'paid',
            ]);

            // Invoice
            \App\Models\Invoice::create([
                'booking_id'     => $bookingRecord->id,
                'invoice_number' => 'INV-HOT-' . date('Ymd') . '-' . $bookingRecord->id,
                'amount'         => $totalFare,
                'tax_amount'     => round($totalFare * 0.12, 2),
                'status'         => 'paid',
            ]);

            // Accounting auto-post
            try {
                app(\App\Services\AccountingService::class)->postBookingEntries($bookingRecord);
            } catch (\Exception $e) {
                \Log::warning('Accounting sync skipped: ' . $e->getMessage());
            }

            AuditLogService::log('Hotel', 'Booking', "Hotel booked. Ref: {$bookingRef}");

        } catch (\Exception $e) {
            \Log::error('Hotel Booking DB Error: ' . $e->getMessage());
        }

        return redirect()->route('hotel.confirmation')->with([
            'success'        => 'Hotel Booked Successfully!',
            'reference'      => $bookingRef,
            'hotel_name'     => $request->input('hotel_name'),
            'check_in'       => $request->input('checkIn'),
            'check_out'      => $request->input('checkOut'),
            'room_name'      => $request->input('room_name'),
            'total_fare'     => $totalFare,
            'guest_name'     => $paxes[0]['name'] . ' ' . $paxes[0]['surname'],
            'contact_email'  => $request->input('email') ?? $user->email,
            'is_mock'        => false,
        ]);
    }

    /**
     * Show Simulated Payment Gateway
     */
    public function showPaymentGateway(Request $request)
    {
        $amount = $request->query('amount');
        $hotel  = $request->query('hotel');

        if (!session('pending_hotel_booking')) {
            return redirect()->route('hotels.index')->with('error', 'Booking session expired.');
        }

        return view('hotel.payment', compact('amount', 'hotel'));
    }

    /**
     * Show MPGS Checkout Page for Hotels
     */
    public function showMpgsCheckout(Request $request)
    {
        $reference = $request->query('reference');
        $params    = session('pending_hotel_booking');

        if (!$params || session('pending_hotel_reference') !== $reference) {
            return redirect()->route('hotels.index')->with('error', 'Booking session not found.');
        }

        $totalFare = (float) ($params['final_total'] ?? $params['total_fare']);

        $mpgs = app(\App\Services\MpgsService::class);
        $session = $mpgs->createCheckoutSession([
            'order_id' => $reference,
            'amount'   => $totalFare,
            'currency' => 'LKR',
        ]);

        if (!isset($session['session']['id'])) {
            return redirect()->back()->with('error', 'Could not initialize payment gateway.');
        }

        $paymentSettings = \App\Models\GlobalSetting::where('group', 'payments')->get()->pluck('value', 'key');
        $merchantId = $paymentSettings['payment_mpgs_merchant_id'] ?? config('payments.mpgs.merchant_id');

        return view('hotel.mpgs-checkout', [
            'order_id'    => $reference,
            'amount'      => $totalFare,
            'currency'    => 'LKR',
            'session'     => $session,
            'merchant_id' => $merchantId
        ]);
    }

    /**
     * Process Online Payment & Complete Booking
     */
    public function processPayment(Request $request)
    {
        $params = session('pending_hotel_booking');
        if (!$params) {
            return redirect()->route('hotels.index')->with('error', 'Booking session expired.');
        }

        // Verify Gateway Response
        $gateway = $request->input('gateway');
        if ($gateway === 'stripe') {
            if (!$request->has('session_id')) {
                return redirect()->route('hotel.checkout')->with('error', 'Stripe payment verification failed.');
            }
        } elseif ($gateway === 'mpgs') {
            if (!$request->has('resultIndicator')) {
                return redirect()->route('hotel.checkout')->with('error', 'MPGS payment verification failed.');
            }
        }

        $user      = Auth::user();
        $totalFare = (float) ($params['final_total'] ?? $params['total_fare']);
        $adults    = (int) ($params['adults'] ?? 1);
        $children  = (int) ($params['children'] ?? 0);
        $rooms     = (int) ($params['rooms'] ?? 1);

        // 1. Build pax list
        $paxes = [];
        for ($i = 0; $i < $adults; $i++) {
            $paxes[] = [
                'name'    => $params["pax_name"][$i] ?? "Adult {$i}",
                'surname' => $params["pax_surname"][$i] ?? "",
                'type'    => 'AD',
            ];
        }
        for ($j = 0; $j < $children; $j++) {
            $idx = $adults + $j;
            $paxes[] = [
                'name'    => $params["pax_name"][$idx] ?? "Child {$j}",
                'surname' => $params["pax_surname"][$idx] ?? "",
                'type'    => 'CH',
                'age'     => 8,
            ];
        }

        // 2. Attempt live HotelBeds booking
        $bookingResult = $this->hotelService->book([
            'holder_name'    => $paxes[0]['name'],
            'holder_surname' => $paxes[0]['surname'],
            'rateKey'        => $params['rate_key'],
            'paxes'          => $paxes,
        ]);

        if (isset($bookingResult['error'])) {
            return redirect()->route('hotel.checkout')->with('error', $bookingResult['message'] ?? 'Booking failed on API after payment. Please contact support.');
        }

        $bookingRef = $bookingResult['booking']['reference'];

        // 3. Create internal booking record
        try {
            $bookingRecord = \App\Models\Booking::create([
                'user_id'             => $user->id,
                'type'                => 'hotel',
                'booking_reference'   => $bookingRef,
                'status'              => 'confirmed',
                'total_amount'        => $totalFare,
                'currency'            => 'INR',
                'api_booking_details' => json_encode([
                    'hotel_name' => $params['hotel_name'],
                    'room_name'  => $params['room_name'],
                    'check_in'   => $params['checkIn'],
                    'check_out'  => $params['checkOut'],
                    'rooms'      => $params['rooms'] ?? 1,
                    'children'   => $params['children'] ?? 0,
                    'is_mock'    => false,
                    'paxes'      => $paxes,
                ]),
            ]);

            // Hotel booking detail
            \App\Models\HotelBooking::create([
                'booking_id'          => $bookingRecord->id,
                'hotel_id'            => $params['hotel_code'],
                'hotel_name'          => $params['hotel_name'],
                'check_in'            => $params['checkIn'],
                'check_out'           => $params['checkOut'],
                'rooms'               => $rooms,
                'guests'              => $adults + $children,
                'room_type'           => $params['room_name'],
                'confirmation_number' => $bookingResult['booking']['hotelReference'] ?? null,
                'hotel_details'       => json_encode($bookingResult['booking']['hotel'] ?? []),
            ]);

            // Passenger records
            foreach ($paxes as $p) {
                \App\Models\Passenger::create([
                    'booking_id' => $bookingRecord->id,
                    'type'       => ($p['type'] ?? 'AD') == 'AD' ? 'adult' : 'child',
                    'title'      => ($p['type'] ?? 'AD') == 'AD' ? 'Mr' : 'Mstr',
                    'first_name' => $p['name'],
                    'last_name'  => $p['surname'],
                ]);
            }

            // Payment record
            \App\Models\Payment::create([
                'booking_id'        => $bookingRecord->id,
                'user_id'           => $user->id,
                'transaction_id'    => $request->query('session_id', 'STRIPE-' . uniqid()),
                'gateway'           => 'stripe',
                'amount'            => $totalFare,
                'currency'          => 'INR',
                'status'            => 'paid',
                'gateway_response'  => json_encode($request->all()),
            ]);

            // Invoice
            \App\Models\Invoice::create([
                'booking_id'     => $bookingRecord->id,
                'invoice_number' => 'INV-HOT-' . date('Ymd') . '-' . $bookingRecord->id,
                'amount'         => $totalFare,
                'tax_amount'     => round($totalFare * 0.12, 2),
                'status'         => 'paid',
            ]);

            // Accounting sync
            try {
                app(\App\Services\AccountingService::class)->postBookingEntries($bookingRecord);
            } catch (\Exception $e) {
                \Log::warning('Accounting sync skipped: ' . $e->getMessage());
            }

            session()->forget('pending_hotel_booking');

            AuditLogService::log('Hotel', 'Payment Success', "Payment processed for Ref: {$bookingRef}");

        } catch (\Exception $e) {
            \Log::error('Hotel Payment DB Error: ' . $e->getMessage());
        }

        return redirect()->route('hotel.confirmation')->with([
            'success'        => 'Payment Successful & Hotel Booked!',
            'reference'      => $bookingRef,
            'hotel_name'     => $params['hotel_name'],
            'check_in'       => $params['checkIn'],
            'check_out'      => $params['checkOut'],
            'room_name'      => $params['room_name'],
            'total_fare'     => $totalFare,
            'guest_name'     => $paxes[0]['name'] . ' ' . $paxes[0]['surname'],
            'is_mock'        => false,
        ]);
    }

    /**
     * Show Booking Confirmation Page
     */
    public function showConfirmation(Request $request)
    {
        if (!session('reference')) {
            return redirect()->route('hotels.index');
        }

        return view('hotel.confirmation');
    }
}

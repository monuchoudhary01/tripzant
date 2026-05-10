<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MpgsService;
use App\Services\StripeService;

class PaymentController extends Controller
{
    protected $mpgsService;
    protected $stripeService;

    public function __construct(MpgsService $mpgsService, StripeService $stripeService)
    {
        $this->mpgsService = $mpgsService;
        $this->stripeService = $stripeService;
    }

    /**
     * Test MPGS Gateway
     */
    public function testMpgs()
    {
        $params = [
            'amount' => '100.00',
            'currency' => 'LKR',
            'order_id' => 'TEST-' . time(),
            'description' => 'MPGS Integration Test',
            'success_url' => route('mpgs.callback'),
            'cancel_url' => route('mpgs.cancel'),
        ];

        $session = $this->mpgsService->createCheckoutSession($params);

        if (isset($session['error'])) {
            return view('payment.test-error', ['message' => $session['message']]);
        }

        return view('payment.mpgs-checkout', [
            'session' => $session,
            'merchant_id' => config('payments.mpgs.merchant_id'),
            'amount' => $params['amount'],
            'currency' => $params['currency'],
            'order_id' => $params['order_id']
        ]);
    }

    /**
     * Test Stripe Gateway
     */
    public function testStripe()
    {
        $params = [
            'amount' => 10, // 10 INR
            'item_name' => 'Stripe Integration Test',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
            'email' => 'test@tripzant.com'
        ];

        $session = $this->stripeService->createCheckoutSession($params);

        if (isset($session['error'])) {
            return back()->with('error', $session['message']);
        }

        return redirect($session->url);
    }

    /**
     * MPGS Callback
     */
    public function mpgsCallback(Request $request)
    {
        $resultIndicator = $request->query('resultIndicator');
        $sessionVersion = $request->query('sessionVersion');
        
        // In a real scenario, you'd verify the resultIndicator against the session successIndicator
        // and potentially call $this->mpgsService->getOrderDetails($orderId) to confirm status.
        
        return view('payment.success', [
            'gateway' => 'Mastercard MPGS',
            'data' => $request->all()
        ]);
    }

    /**
     * MPGS Cancel
     */
    public function mpgsCancel()
    {
        return view('payment.cancel', ['gateway' => 'Mastercard MPGS']);
    }

    /**
     * Generic Payment Success
     */
    public function success()
    {
        return view('payment.success', ['gateway' => 'Stripe']);
    }

    /**
     * Generic Payment Cancel
     */
    public function cancel()
    {
        return view('payment.cancel', ['gateway' => 'Stripe']);
    }
}

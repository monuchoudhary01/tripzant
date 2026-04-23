@extends('layouts.app')

@section('title', 'Secure Payment — Tripzant')

@section('styles')
<style>
    .payment-bg { background: #f0f4f8; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .payment-container { background: #fff; border-radius: 30px; box-shadow: 0 30px 60px rgba(0,0,0,0.1); overflow: hidden; max-width: 900px; width: 100%; display: flex; }
    .payment-sidebar { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff; width: 350px; padding: 40px; }
    .payment-main { flex: 1; padding: 50px; }
    .p-brand { font-size: 24px; font-weight: 900; letter-spacing: -1px; margin-bottom: 50px; }
    .amount-display { margin-bottom: 40px; }
    .amount-display .label { font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
    .amount-display .val { font-size: 32px; font-weight: 900; }
    .hotel-info { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); }
    .card-input-wrapper { background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 20px; padding: 30px; margin-bottom: 30px; }
    .card-field { border: none; background: transparent; font-size: 18px; font-weight: 700; width: 100%; outline: none; }
    .pay-btn { background: #2563eb; color: #fff; border: none; width: 100%; padding: 20px; border-radius: 20px; font-weight: 900; font-size: 18px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
    .pay-btn:hover { background: #1d4ed8; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(37,99,235,0.3); }
    .p-methods { display: flex; gap: 15px; margin-bottom: 30px; }
    .p-method { flex: 1; border: 2px solid #e2e8f0; border-radius: 15px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.2s; }
    .p-method.active { border-color: #2563eb; background: #eff6ff; }
    .p-method i { font-size: 20px; display: block; margin-bottom: 5px; }
    .p-method span { font-size: 11px; font-weight: 800; text-transform: uppercase; }
</style>
@endsection

@section('content')
<div class="payment-bg">
    <div class="payment-container">
        <div class="payment-sidebar d-none d-md-block">
            <div class="p-brand">Tripzant<span class="text-primary">Pay</span></div>
            
            <div class="amount-display">
                <div class="label">Total Amount</div>
                <div class="val">₹{{ number_format($amount, 2) }}</div>
            </div>

            <div class="hotel-info">
                <div class="label mb-2" style="font-size:10px; opacity:0.6;">Booking Details</div>
                <div class="fw-800 fs-5 mb-1">{{ $hotel }}</div>
                <div class="small opacity-70 fw-600">Secure Online Reservation</div>
            </div>

            <div class="mt-auto pt-5">
                <div class="d-flex align-items-center gap-2 small opacity-50">
                    <i class="fas fa-lock"></i>
                    <span>PCI-DSS Compliant Gateway</span>
                </div>
            </div>
        </div>

        <div class="payment-main">
            <h2 class="outfit fw-900 text-navy mb-4">Complete Payment</h2>
            
            <div class="p-methods">
                <div class="p-method active"><i class="fas fa-credit-card"></i><span>Card</span></div>
                <div class="p-method"><i class="fab fa-google-pay"></i><span>UPI / GPay</span></div>
                <div class="p-method"><i class="fas fa-university"></i><span>Net Banking</span></div>
            </div>

            <form action="{{ route('hotel.payment.process') }}" method="POST" id="payForm">
                @csrf
                <input type="hidden" name="transaction_id" id="txnId">
                
                <div class="card-input-wrapper">
                    <div class="mb-4">
                        <label class="c-label">Card Number</label>
                        <input type="text" class="card-field" placeholder="xxxx xxxx xxxx 4242" value="4242 4242 4242 4242">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="c-label">Expiry Date</label>
                            <input type="text" class="card-field" placeholder="MM / YY" value="12 / 26">
                        </div>
                        <div class="col-6">
                            <label class="c-label">CVV</label>
                            <input type="password" class="card-field" placeholder="xxx" value="123">
                        </div>
                    </div>
                </div>

                <button type="submit" class="pay-btn" id="payBtn">
                    <span id="btnText">PAY ₹{{ number_format($amount, 0) }} NOW</span>
                    <span id="btnLoader" class="d-none"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
                </button>

                <div class="mt-4 text-center">
                    <img src="https://help.shippo.com/hc/article_attachments/360046522332/payment-logos.png" height="30" style="opacity:0.5; filter: grayscale(1);">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('payForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('payBtn');
    const text = document.getElementById('btnText');
    const loader = document.getElementById('btnLoader');
    
    btn.disabled = true;
    text.classList.add('d-none');
    loader.classList.remove('d-none');

    // Simulate Network Latency
    setTimeout(() => {
        document.getElementById('txnId').value = 'PAY-' + Math.random().toString(36).substr(2, 9).toUpperCase();
        this.submit();
    }, 2000);
});
</script>
@endsection

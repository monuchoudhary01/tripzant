@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="font-weight-light my-2">Secure Checkout</h3>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/payment/commercial_bank.png') }}" alt="Commercial Bank" class="img-fluid mb-3" style="max-height: 60px;">
                        <h4>Mastercard Payment Gateway</h4>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <p class="text-muted mb-1">Order ID</p>
                            <h5>#{{ $order_id }}</h5>
                        </div>
                        <div class="col-sm-6 text-sm-right">
                            <p class="text-muted mb-1">Total Amount</p>
                            <h3 class="text-primary">{{ $currency }} {{ number_format($amount, 2) }}</h3>
                        </div>
                    </div>

                    <hr>

                    <div class="text-center mt-5">
                        <p class="mb-4">Click the button below to complete your payment securely via Commercial Bank of Sri Lanka.</p>
                        
                        <button type="button" class="btn btn-primary btn-lg px-5 shadow" onclick="if(window.Checkout) { if(Checkout.showLightbox) Checkout.showLightbox(); else Checkout.showPaymentPage(); } else { alert('Payment library not loaded yet'); }">
                            Pay Now with Mastercard
                        </button>
                        
                        <div class="mt-4">
                            <img src="{{ asset('assets/img/payment/Logos-02.jpg') }}" alt="Card Logos" class="img-fluid" style="max-height: 40px;">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-3">
                    <div class="small text-center text-muted">
                        Secure payment powered by Mastercard MPGS & Commercial Bank
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Mastercard Checkout Script --}}
<script src="https://cbcmpgs.gateway.mastercard.com/static/checkout/checkout.min.js"
        data-error="errorCallback"
        data-cancel="cancelCallback"
        data-complete="completePayment">
</script>

<script type="text/javascript">
    function errorCallback(error) {
        console.error("MPGS Error Details:", error);
        alert("Payment Error: " + (error.explanation || "System Error (Check Console)"));
    }

    function cancelCallback() {
        console.log('Payment cancelled');
        window.location.href = "{{ route('mpgs.cancel') }}";
    }

    Checkout.configure({
        session: {
            id: "{{ $session['session']['id'] }}"
        },
        merchant: "{{ $merchant_id }}",
        interaction: {
            merchant: {
                name: 'Tripzant'
            },
            displayControl: {
                billingAddress: 'HIDE',
                customerEmail: 'HIDE'
            }
        }
    });

    // Handle session success after interaction
    function completePayment(indicator, version) {
        window.location.href = "{{ route('checkout.success') }}?resultIndicator=" + indicator + "&sessionVersion=" + version;
    }
</script>
@endsection

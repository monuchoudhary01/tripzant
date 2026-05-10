@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="font-weight-light my-2">Hotel Booking Checkout</h3>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/payment/commercial_bank.png') }}" alt="Commercial Bank" class="img-fluid mb-3" style="max-height: 60px;">
                        <h4>Mastercard Payment Gateway</h4>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <p class="text-muted mb-1">Booking Reference</p>
                            <h5>#{{ $order_id }}</h5>
                        </div>
                        <div class="col-sm-6 text-sm-right">
                            <p class="text-muted mb-1">Total Payable</p>
                            <h3 class="text-primary">{{ $currency }} {{ number_format($amount, 2) }}</h3>
                        </div>
                    </div>

                    <hr>

                    <div class="text-center mt-5">
                        <p class="mb-4">Click below to pay via Commercial Bank. Your booking will be confirmed immediately after payment.</p>
                        
                        <button type="button" class="btn btn-primary btn-lg px-5 shadow" onclick="if(window.Checkout) { if(Checkout.showLightbox) Checkout.showLightbox(); else Checkout.showPaymentPage(); } else { alert('Payment library not loaded yet'); }">
                            Pay Now & Confirm Hotel
                        </button>
                        
                        <div class="mt-4">
                            <img src="{{ asset('assets/img/payment/Logos-02.jpg') }}" alt="Card Logos" class="img-fluid" style="max-height: 40px;">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-3">
                    <div class="small text-center text-muted">
                        Transaction Secured by Mastercard MPGS
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
        alert("Payment Error: " + (error.explanation || "System Error"));
    }

    function cancelCallback() {
        window.location.href = "{{ route('hotel.checkout') }}?error=Payment cancelled";
    }

    Checkout.configure({
        session: {
            id: "{{ $session['session']['id'] }}"
        },
        merchant: "{{ $merchant_id }}",
        interaction: {
            merchant: {
                name: 'Tripzant Hotels'
            },
            displayControl: {
                billingAddress: 'HIDE',
                customerEmail: 'HIDE'
            }
        }
    });

    // Handle session success after interaction
    function completePayment(indicator, version) {
        window.location.href = "{{ route('hotel.payment.process') }}?gateway=mpgs&resultIndicator=" + indicator + "&sessionVersion=" + version;
    }
</script>
@endsection

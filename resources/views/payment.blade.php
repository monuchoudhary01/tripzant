@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold">Payment Gateway Test Center</h1>
        <p class="lead text-muted">Select the gateway you wish to test for your booking integration.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white p-0">
            <ul class="nav nav-tabs nav-fill border-0" id="paymentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-3 font-weight-bold border-0" id="combank-tab" data-bs-toggle="tab" data-bs-target="#combank" type="button" role="tab">
                        <img src="{{ asset('assets/img/payment/commercial_bank.png') }}" height="25" class="me-2"> Commercial Bank (MPGS)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 font-weight-bold border-0" id="stripe-tab" data-bs-toggle="tab" data-bs-target="#stripe" type="button" role="tab">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="25" class="me-2"> Stripe
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-5">
            <div class="tab-content" id="paymentTabsContent">
                
                <!-- Commercial Bank Tab -->
                <div class="tab-pane fade show active text-center" id="combank" role="tabpanel">
                    <div class="mb-4 d-flex justify-content-center align-items-center gap-3">
                        <img src="{{ asset('assets/img/payment/commercial_bank.png') }}" alt="Commercial Bank" style="height: 80px;">
                        <span class="h2 text-muted">+</span>
                        <img src="https://www.mastercard.us/content/dam/mccom/global/logos/logo-mastercard-mobile.svg" alt="Mastercard" style="height: 60px;">
                    </div>
                    <h3>Commercial Bank MPGS</h3>
                    <p class="text-muted mb-4">Mastercard Payment Gateway (Hosted Checkout) integration via Commercial Bank of Sri Lanka.</p>
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <div class="bg-light p-4 rounded-4 mb-4 text-start">
                                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Integration Details:</h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>Method:</strong> Hosted Checkout (Light Box)</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>API Version:</strong> 100 (Latest)</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>Merchant:</strong> TESTEASIWORLDLKR</li>
                                    <li><i class="fas fa-check text-success me-2"></i> <strong>Security:</strong> TLS 1.2 Enforced</li>
                                </ul>
                            </div>
                            <a href="{{ route('test.mpgs') }}" class="btn btn-primary btn-lg w-100 shadow py-3 fw-bold">Test Commercial Bank Gateway</a>
                        </div>
                    </div>
                </div>

                <!-- Stripe Tab -->
                <div class="tab-pane fade text-center" id="stripe" role="tabpanel">
                    <div class="mb-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" style="height: 80px;">
                    </div>
                    <h3>Stripe Payments</h3>
                    <p class="text-muted mb-4">International payment gateway for global card processing.</p>
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <div class="bg-light p-4 rounded-4 mb-4 text-start">
                                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Integration Details:</h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>Method:</strong> Stripe Checkout Session</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>Currencies:</strong> INR, USD, EUR, etc.</li>
                                    <li><i class="fas fa-check text-success me-2"></i> <strong>Features:</strong> 3D Secure, Apple/Google Pay</li>
                                </ul>
                            </div>
                            <a href="{{ route('test.stripe') }}" class="btn btn-dark btn-lg w-100 shadow py-3 fw-bold">Test Stripe Gateway</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        border-bottom: 3px solid transparent !important;
        color: #6c757d;
        transition: all 0.3s ease;
        background: transparent !important;
    }
    .nav-tabs .nav-link.active {
        color: #0076f7 !important;
        border-bottom: 3px solid #0076f7 !important;
    }
    .nav-tabs .nav-link:hover {
        border-bottom: 3px solid #e9ecef !important;
    }
    .card {
        border-radius: 20px;
        overflow: hidden;
    }
    .btn-lg {
        border-radius: 12px;
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
</style>
@endsection

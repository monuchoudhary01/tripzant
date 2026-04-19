@extends('layouts.app')

@section('title', 'Global Cargo & International Shipping | Trip Zant')

@section('content')
<!-- Hero Section -->
<section class="cargo-hero position-relative overflow-hidden" style="background: linear-gradient(135deg, #011233 0%, #004e92 100%); padding: 120px 0;">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white animate__animated animate__fadeInLeft">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">#1 GLOBAL LOGISTICS NETWORK</span>
                <h1 class="display-3 fw-900 mb-4 line-height-1">Ship Anything,<br>Anywhere. Fast.</h1>
                <p class="lead opacity-75 mb-5">Join 100,000+ travelers sending cargo globally with real-time tracking, automated customs, and premium insurance.</p>
                
                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('cargo.dashboard.book') }}" class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Start Shipping <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="#tracking" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold">Track Parcel</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 text-center animate__animated animate__zoomIn">
                <div class="hero-image-container position-relative">
                    <img src="https://img.freepik.com/free-photo/logistics-transportation-container-cargo-ship-cargo-plane-with-working-crane-bridge-shipyard_35048-518.jpg" class="img-fluid rounded-4 shadow-2xl border border-white border-5" style="max-width: 90%; transform: rotate(3deg);" alt="Logistics">
                    <!-- Floating Card -->
                    <div class="position-absolute bottom-0 start-0 bg-white p-4 rounded-4 shadow-lg text-start animate__animated animate__fadeInUp animate__delay-1s" style="width: 280px; transform: translate(-20%, 20%);">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-circle bg-soft-success me-3"><i class="fas fa-check text-success"></i></div>
                            <h6 class="mb-0 fw-bold text-navy">Customs Cleared</h6>
                        </div>
                        <div class="progress rounded-pill mb-2" style="height: 6px;">
                            <div class="progress-bar bg-success w-100"></div>
                        </div>
                        <small class="text-muted">Regional Hub: Melbourne VIC</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Estimate Engine (Module 2 Preview) -->
<section class="py-5 bg-white shadow-sm position-relative" style="margin-top: -50px; z-index: 10;">
    <div class="container text-center">
        <div class="card border-0 shadow-xl rounded-4 p-4 p-lg-5 mx-auto" style="max-width: 1000px;">
            <div class="row align-items-center g-4">
                <div class="col-md-3">
                    <h5 class="fw-bold text-navy mb-0">Quick Estimate</h5>
                    <p class="small text-muted mb-0">Instant pricing preview</p>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control rounded-pill py-3 px-4 border-light bg-light" placeholder="Origin City">
                </div>
                <div class="col-md-3">
                    <input type="number" id="est_weight" class="form-control rounded-pill py-3 px-4 border-light bg-light" placeholder="Weight (KG)">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 rounded-pill py-3 fw-bold" onclick="getQuickEstimate()">Get Price <i class="fas fa-calculator ms-2"></i></button>
                </div>
            </div>
            <div id="est_result" class="mt-4 text-primary fw-bold d-none">
                Estimated Price: <span id="price_val">$0.00</span> | <span class="text-muted">Time: 5-7 Days</span>
            </div>
        </div>
    </div>
</section>

<!-- Core Features (The Cargo Flow Characters) -->
<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-900 text-navy">Why Choose Trip Zant Cargo?</h2>
            <p class="text-muted">The complete logistics bridge between IATA agents and travelers.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 reveal">
                    <div class="icon-shape bg-soft-primary text-primary fs-3 mb-4"><i class="fas fa-shield-virus"></i></div>
                    <h5 class="fw-bold">Seamless Customs</h5>
                    <p class="text-muted small">Our automated QR-code based customs declaration handles item valuation and compliance signatures instantly.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 reveal">
                    <div class="icon-shape bg-soft-warning text-warning fs-3 mb-4"><i class="fas fa-map-location-dot"></i></div>
                    <h5 class="fw-bold">Uber-Like Tracking</h5>
                    <p class="text-muted small">Monitor your parcel's movement with GPS precision. Real-time updates from our network of pickup agents.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 reveal">
                    <div class="icon-shape bg-soft-success text-success fs-3 mb-4"><i class="fas fa-percentage"></i></div>
                    <h5 class="fw-bold">Cross-Benefit Rewards</h5>
                    <p class="text-muted small">Every cargo shipment unlocks exclusive promo codes for Flight, Hotel, and Tour bookings on Trip Zant.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- B2B Section (Secondary Income for Cargo Shops) -->
<section class="py-5 bg-navy text-white overflow-hidden position-relative">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-900 mb-4">Are you a Local Cargo Shop?</h2>
                <h4 class="text-warning mb-4">Earn Secondary Income through Trip Zant B2B</h4>
                <p class="opacity-75 mb-5 fs-5">Join our portal to offer your customers Flights, Hotels, and Tours while shipping their boxes. Boost your revenue with the world's first integrated Travel & Cargo platform.</p>
                
                <ul class="list-unstyled mb-5">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-check-circle text-warning me-3"></i> Offer IATA Flight bookings instantly
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-check-circle text-warning me-3"></i> Create custom holiday packages
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-check-circle text-warning me-3"></i> High-commission payouts from travel sales
                    </li>
                </ul>
                
                <a href="{{ route('partner.signup') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-navy shadow-lg">Join as Partner <i class="fas fa-store-alt ms-2"></i></a>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                <div class="p-5 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-20 animate__animated animate__pulse animate__infinite">
                    <i class="fas fa-store fa-10x opacity-50"></i>
                    <h3 class="mt-4 fw-bold">B2B Shop Merchant</h3>
                    <p class="small opacity-75">Connect your logistic business to travel.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tracking & QR Section (Module 3) -->
<section id="tracking" class="py-5 bg-light">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 text-center order-2 order-lg-1">
                <div class="card border-0 shadow-lg rounded-4 p-5 animate__animated animate__fadeInUp">
                    <h5 class="fw-900 mb-4 text-navy">QR LOGIN FOR SENDERS</h5>
                    <div class="p-3 bg-white border border-2 border-primary d-inline-block rounded-4 mb-4">
                         <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://tripzant.com/cargo/dashboard" width="180" alt="QR Code">
                    </div>
                    <p class="small text-muted mb-0">Scan at any Aus Post or Shop partner point to start your customs declaration instantly.</p>
                </div>
            </div>
            <div class="col-lg-7 order-1 order-lg-2">
                <h2 class="fw-900 text-navy mb-4">Global Shipment Tracking</h2>
                <div class="input-group input-group-lg mb-4 shadow-sm">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-4 text-primary"><i class="fas fa-search"></i></span>
                    <input type="text" id="track_ref" class="form-control border-start-0 py-4 rounded-end-pill" placeholder="Enter Reference (e.g. TZC-12345)">
                    <button class="btn btn-primary px-5 rounded-pill ms-2 fw-bold" onclick="window.location.href='/cargo/track?ref=' + document.getElementById('track_ref').value">Track Now</button>
                </div>
                <div class="row mt-5">
                    <div class="col-6">
                        <h4 class="fw-bold mb-1">100+</h4>
                        <p class="text-muted small">Global Carriers Ready</p>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold mb-1">24/7</h4>
                        <p class="text-muted small">Customs Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function getQuickEstimate() {
        const weight = document.getElementById('est_weight').value;
        if(!weight) return;
        
        fetch('/cargo/estimate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ weight: weight })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('price_val').innerText = '$' + data.estimate;
            document.getElementById('est_result').classList.remove('d-none');
        });
    }
</script>

<style>
    .bg-navy { background: #011233; }
    .text-navy { color: #011233; }
    .bg-soft-primary { background: rgba(0, 118, 247, 0.1); }
    .bg-soft-success { background: rgba(28, 200, 138, 0.1); }
    .bg-soft-warning { background: rgba(246, 194, 62, 0.1); }
    .line-height-1 { line-height: 1.1; }
    .icon-shape { width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .icon-circle { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
</style>
@endsection

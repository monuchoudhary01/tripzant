@extends('layouts.app')

@section('title', "Travel eSIM — Instant Global Data Plans | Trip Zant")

@section('content')
<style>
    :root {
        --esim-primary: #008489;
        --esim-navy: #0b3d61;
        --esim-orange: #f97316;
    }

    .esim-hero {
        background: linear-gradient(135deg, #0b3d61 0%, #001f3f 100%);
        padding: 100px 0 150px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .esim-hero::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 80% 20%, rgba(0, 168, 225, 0.15) 0%, transparent 40%);
        pointer-events: none;
    }

    .esim-search-box {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        margin-top: -80px;
        position: relative;
        z-index: 10;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .feature-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: rgba(var(--primary-rgb), 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .esim-plan-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        background: #fff;
        transition: all 0.3s ease;
    }

    .esim-plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        border-color: var(--primary);
    }

    .step-number {
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        margin-bottom: 15px;
    }

    .faq-item {
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 0;
    }

    .faq-question {
        font-weight: 800;
        color: var(--esim-navy);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-sim-illustration {
        position: absolute;
        right: -50px;
        top: 50%;
        transform: translateY(-50%) rotate(-15deg);
        opacity: 0.2;
        font-size: 400px;
        color: #fff;
    }
</style>

<div class="esim-page">
    <!-- Hero Banner -->
    <section class="esim-hero text-center">
        <i class="fas fa-sim-card hero-sim-illustration"></i>
        <div class="container position-relative" style="z-index: 2;">
            <span class="badge bg-primary-light text-primary px-3 py-2 rounded-pill fw-900 mb-3" style="background: rgba(255,255,255,0.1); color: #fff;">NEXT-GEN ROAMING</span>
            <h1 class="display-3 fw-900 mb-3">Stay Connected Anywhere <span class="text-orange">with eSIM</span></h1>
            <p class="fs-5 text-white-50 mb-5">Instant global data plans for 190+ countries. No physical SIM, no roaming fees.</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="#plans" class="btn btn-orange px-5 py-3 rounded-pill fw-bold hvr-grow">Buy eSIM <i class="fas fa-bolt ms-2"></i></a>
                <a href="#how-it-works" class="btn btn-outline-light px-5 py-3 rounded-pill fw-bold">How it Works</a>
            </div>
        </div>
    </section>

    <!-- Search / Selector -->
    <div class="container">
        <div class="esim-search-box">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="small fw-800 text-muted mb-2">WHERE ARE YOU GOING?</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-0 py-3 fw-bold" placeholder="Country or Region (e.g. Dubai, India)">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="small fw-800 text-muted mb-2">DURATION</label>
                    <select class="form-select bg-light border-0 py-3 fw-bold">
                        <option>7 Days</option>
                        <option>15 Days</option>
                        <option>30 Days</option>
                        <option>Unlimited</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="small fw-800 text-muted mb-2">DATA PLAN</label>
                    <select class="form-select bg-light border-0 py-3 fw-bold">
                        <option>1GB</option>
                        <option>5GB</option>
                        <option>10GB</option>
                        <option>Unlimited Data</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary w-100 py-3 rounded-3 fw-900 hvr-grow" id="esimSearchBtn">VIEW PLANS</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <section class="py-100 bg-white">
        <div class="container">
            <div class="row g-5 text-center stagger-children">
                <div class="col-md-4">
                    <div class="feature-icon-box mx-auto"><i class="fas fa-globe"></i></div>
                    <h5 class="fw-900 text-navy">Global Coverage</h5>
                    <p class="text-muted small">Stay connected in 100+ countries with top-tier network providers.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon-box mx-auto" style="background: rgba(34,197,94,0.1); color: #22c55e;"><i class="fas fa-qrcode"></i></div>
                    <h5 class="fw-900 text-navy">Instant Activation</h5>
                    <p class="text-muted small">Buy, scan, and you're online in 2 minutes. No physical SIM needed.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon-box mx-auto" style="background: rgba(249,115,22,0.1); color: #f97316;"><i class="fas fa-piggy-bank"></i></div>
                    <h5 class="fw-900 text-navy">No Roaming Charges</h5>
                    <p class="text-muted small">Fixed local prices. Save up to 90% compared to typical carriers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Plan Listing -->
    <section class="py-5 bg-light" id="plans">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-900 text-navy">Trending eSIM Plans</h2>
                <p class="text-muted">Best value plans for your next trip</p>
            </div>
            <div class="row g-4">
                @foreach($plans as $p)
                <div class="col-lg-3 col-md-6">
                    <div class="esim-plan-card">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <img src="https://flagcdn.com/w80/{{ $p->country_code }}.png" width="40" class="rounded-1 border">
                            <h6 class="fw-900 text-navy mb-0">{{ $p->region }}</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-bold">DATA</span>
                            <span class="fw-900 text-navy">{{ $p->data_amount }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted small fw-bold">VALIDITY</span>
                            <span class="fw-900 text-navy">{{ $p->validity_days }} Days</span>
                        </div>
                        <div class="text-center">
                            <div class="fw-900 text-navy fs-2 mb-3">${{ number_format($p->price, 2) }}</div>
                            <button onclick="buyEsim('{{ $p->id }}')" class="btn btn-navy w-100 rounded-pill fw-bold">Buy Now</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-100 bg-white" id="how-it-works">
        <div class="container">
            <h2 class="fw-900 text-navy text-center mb-5">How It Works</h2>
            <div class="row g-5">
                <div class="col-md-3 text-center">
                    <div class="step-number mx-auto">1</div>
                    <h6 class="fw-900 text-navy">Choose Destination</h6>
                    <p class="text-muted x-small">Select the country or region where you are traveling.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="step-number mx-auto">2</div>
                    <h6 class="fw-900 text-navy">Select a Plan</h6>
                    <h6 class="text-muted x-small">Pick the data amount and duration that fits your needs.</h6>
                </div>
                <div class="col-md-3 text-center">
                    <div class="step-number mx-auto">3</div>
                    <h6 class="fw-900 text-navy">Scan QR Code</h6>
                    <p class="text-muted x-small">Receive a QR code instantly via email. Scan it in settings.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="step-number mx-auto">4</div>
                    <h6 class="fw-900 text-navy">Stay Connected</h6>
                    <p class="text-muted x-small">Switch on the data plan and enjoy 5G speeds globally.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Destinations & FAQs -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <h4 class="fw-900 text-navy mb-4">Frequently Asked Questions</h4>
                    <div class="faq-list">
                        <div class="faq-item">
                            <div class="faq-question">What is an eSIM? <i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">How do I activate it? <i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">Is my phone compatible? <i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">Can I keep my WhatsApp number? <i class="fas fa-plus"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="fw-900 text-navy mb-4">Why Travelers Love Us</h4>
                    <div class="p-4 bg-white rounded-4 border shadow-sm mb-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="https://ui-avatars.com/api/?name=Alex+J&background=0b3d61&color=fff" class="rounded-circle" width="50">
                            <div>
                                <h6 class="fw-900 text-navy mb-0">Alex Johnson</h6>
                                <span class="text-warning small"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                            </div>
                        </div>
                        <p class="text-muted small mb-0">"Bought a plan for my Japan trip. Activated in 30 seconds at Narita airport. Faster than buying a local SIM!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBtn = document.getElementById('esimSearchBtn');
        const plansSection = document.getElementById('plans');

        if (searchBtn && plansSection) {
            searchBtn.addEventListener('click', function() {
                // Show loading state
                const originalContent = searchBtn.innerHTML;
                searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> SEARCHING...';
                searchBtn.disabled = true;

                // Simulate search time
                setTimeout(() => {
                    // Reset button
                    searchBtn.innerHTML = originalContent;
                    searchBtn.disabled = false;

                    // Smooth scroll to plans
                    plansSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    // Highlight the section briefly
                    plansSection.style.transition = 'background 0.5s';
                    plansSection.style.background = '#e0f2f1';
                    setTimeout(() => {
                        plansSection.style.background = '#f8fafc';
                    }, 1000);
                }, 800);
            });
        }
    });
</script>
@section('scripts')
<script>
    function buyEsim(planId) {
        if (!confirm('Proceed to purchase this eSIM plan?')) return;

        fetch("{{ route('esim.book.post') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ plan_id: planId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Success! Your eSIM QR code will be sent to your email. Order ID: ' + data.booking_id);
                window.location.href = "{{ localized_url('/') }}";
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Celebrate Sri Lankan New Year 2026 - Melbourne | Tripzant')

@section('content')
<div class="event-landing-wrapper">
    <!-- Festive Header Section -->
    <section class="event-hero">
        <div class="event-hero-overlay"></div>
        <div class="container position-relative text-center py-5">
            <div class="festive-logo mb-4 animate__animated animate__fadeInDown">
                <img src="/img/logo.svg" alt="Tripzant" style="height: 60px; filter: brightness(0) invert(1);">
            </div>
            <h1 class="festive-title mb-2 animate__animated animate__zoomIn">Symphony in the <span class="highlight-gold">Stratosphere</span></h1>
            <p class="festive-subtitle mb-4">An exclusive evening of prestige, nostalgia, and world-class music with Anjalee</p>
            
            <div class="event-meta-info d-flex justify-content-center gap-4 mb-5 flex-wrap">
                <div class="meta-item"><i class="fas fa-calendar-alt me-2"></i> 09 May 2026</div>
                <div class="meta-item"><i class="fas fa-map-marker-alt me-2"></i> Springvale City Hall, VIC</div>
                <div class="meta-item"><i class="fas fa-clock me-2"></i> 6:30 PM Onwards</div>
            </div>

            <div class="flyer-preview mb-5 animate__animated animate__fadeInUp">
                <div class="bg-white p-2 rounded-4 shadow-lg d-inline-block border border-warning" style="max-width: 350px;">
                    <img src="/img/image.jpeg?v={{ time() }}" alt="Symphony in the Stratosphere" class="img-fluid rounded-3">
                </div>
            </div>

            <div class="animate__animated animate__pulse animate__infinite">
                <a href="#register-form" class="btn btn-festive-lg px-5 py-3 rounded-pill fw-bold shadow-lg">
                    Join the Celebration <i class="fas fa-arrow-down ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Lead Capture Form Section -->
    <section class="lead-capture-section py-5" id="register-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-lg rounded-4 p-4 mb-5 animate__animated animate__bounceIn">
                            <div class="d-flex align-items-center gap-3">
                                <div class="fs-1"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <h4 class="fw-bold mb-1">Success!</h4>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="glass-card p-5 animate__animated animate__fadeInUp">
                        <div class="text-center mb-5">
                            <h2 class="section-title text-navy">Join the <span class="highlight-orange">Tripzant</span> Community</h2>
                            <p class="text-muted">Fill in your details and enter the grand raffle draw!</p>
                        </div>

                        <form action="{{ route('event.submit') }}" method="POST" class="event-form">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Client Name</label>
                                    <input type="text" name="name" class="form-control premium-input" placeholder="Enter your full name" value="{{ old('name') }}" required>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control premium-input" placeholder="name@example.com" value="{{ old('email') }}" required>
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Whatsapp Number</label>
                                    <input type="text" name="phone" class="form-control premium-input" placeholder="+61 XXX XXX XXX" value="{{ old('phone') }}" required>
                                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                
                                <!-- Raffle Draw Section -->
                                <div class="col-md-12 mt-4">
                                    <h5 class="fw-bold mb-3 text-navy border-bottom pb-2"><i class="fas fa-ticket-alt text-warning me-2"></i> Raffle Draw Details</h5>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Raffle Draw Code</label>
                                    <input type="text" name="raffle_code" class="form-control premium-input" placeholder="e.g. A-1024-Red" value="{{ old('raffle_code') }}" required>
                                    @error('raffle_code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    <div class="form-text small opacity-75">Format: Alphabetic-Number-Colour (e.g., A-1024-Red)</div>
                                </div>

                                <div class="col-12 mt-4 text-center">
                                    <button type="submit" class="btn btn-orange-lg px-5 py-3 rounded-pill fw-bold shadow-lg w-100">
                                        Connect with Tripzant <i class="fas fa-paper-plane ms-2"></i>
                                    </button>
                                    <p class="mt-3 text-muted small"><i class="fas fa-lock me-1"></i> Your data is safe with us. We don't spam.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer Festive Message -->
    <footer class="event-footer py-5 text-center text-white">
        <div class="container">
            <h3 class="fw-bold mb-3">Subha Aluth Avuruddak Wewa!</h3>
            <p class="opacity-75 mb-4">Let's make 2026 the year of your most memorable journey.</p>
            <div class="social-links d-flex justify-content-center gap-3">
                <a href="#" class="social-item"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-item"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-item"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </footer>
</div>

<style>
    /* Theme Colors */
    :root {
        --festive-red: #d32f2f;
        --festive-gold: #ffc107;
        --festive-green: #2e7d32;
        --orange: #f97316;
        --navy: #0b3d61;
    }

    .event-landing-wrapper {
        background: #f8fafc;
        overflow-x: hidden;
    }

    /* Hero Styling */
    .event-hero {
        background: url('/assets/img/events/festive-bg.png') center/cover no-repeat;
        padding: 100px 0;
        position: relative;
        color: white;
    }

    .event-hero-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(11, 61, 97, 0.8), rgba(11, 61, 97, 0.4));
    }

    .festive-title {
        font-size: 3.5rem;
        font-weight: 900;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    }

    .highlight-gold { color: var(--festive-gold); }
    .highlight-orange { color: var(--orange); }
    .highlight-navy { color: var(--navy); }

    .festive-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .meta-item {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: bold;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Form Styling */
    .glass-card {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        margin-top: -80px;
        position: relative;
        z-index: 10;
        border: 1px solid #f1f5f9;
        transition: transform 0.3s ease;
    }

    .premium-input {
        padding: 12px 20px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        transition: all 0.3s;
    }

    .premium-input:focus {
        background: white;
        border-color: var(--orange);
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
    }

    .question-box {
        transition: transform 0.3s;
    }

    .question-box:hover {
        transform: translateY(-5px);
    }

    .custom-radio .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
        cursor: pointer;
    }

    .custom-radio .form-check-label {
        font-weight: 600;
        margin-left: 8px;
        cursor: pointer;
        padding-top: 2px;
    }

    .btn-orange-lg {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: white;
        font-size: 1.1rem;
        border: none;
        transition: all 0.3s;
    }

    .btn-orange-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(234, 88, 12, 0.3);
        color: white;
    }

    /* Preview Styling */
    .preview-mockup-wrap {
        border: 10px solid #1e293b;
        border-radius: 2rem;
        background: #1e293b;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.2);
    }

    /* Footer Styling */
    .event-footer {
        background: var(--navy);
    }

    .social-item {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-item:hover {
        background: var(--orange);
        transform: scale(1.1);
        color: white;
    }

    /* New Festive Button Styles */
    .btn-festive-lg {
        background: linear-gradient(135deg, var(--festive-gold) 0%, #ff8f00 100%);
        color: #0b3d61;
        border: none;
        font-size: 1.25rem;
        transition: all 0.3s;
    }

    .btn-festive-lg:hover {
        transform: scale(1.05);
        color: #0b3d61;
        box-shadow: 0 15px 30px rgba(255, 193, 7, 0.4);
    }

    @media (max-width: 768px) {
        .festive-title { font-size: 2.2rem; }
        .glass-card { padding: 2rem !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection

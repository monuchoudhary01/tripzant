@extends('layouts.app')

@section('title', 'Coming Soon | Tripzant - Your Global Travel Partner')

@section('content')
<div class="coming-soon-wrapper">
    <div class="container text-center py-5">
        <div class="mb-5 animate__animated animate__zoomIn">
            <img src="/img/logo.svg" alt="Tripzant" class="company-logo">
        </div>
        
        <h1 class="display-3 fw-900 text-navy mb-3 animate__animated animate__fadeInUp">Something <span class="highlight-orange">Extraordinary</span> is Coming</h1>
        <p class="fs-5 text-muted mb-5 animate__animated animate__fadeInUp animate__delay-1s">We are building the future of personalized travel. Stay tuned for a revolutionary way to explore the world.</p>
        
        <div class="countdown-container d-flex justify-content-center gap-4 mb-5 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="countdown-item">
                <span class="number">12</span>
                <span class="label">Days</span>
            </div>
            <div class="countdown-item">
                <span class="number">08</span>
                <span class="label">Hrs</span>
            </div>
            <div class="countdown-item">
                <span class="number">45</span>
                <span class="label">Min</span>
            </div>
            <div class="countdown-item">
                <span class="number">20</span>
                <span class="label">Sec</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="glass-card-sm p-4 rounded-5 shadow-lg border-0 bg-white">
                    <h5 class="fw-bold text-navy mb-3">Notify Me on Launch</h5>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control rounded-pill px-4" placeholder="Enter your email">
                        <button type="submit" class="btn btn-navy rounded-pill px-4 fw-bold">Notify</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="event-shortcut mt-5 animate__animated animate__fadeIn animate__delay-3s">
            <p class="text-muted mb-2">Attending our Melbourne Event?</p>
            <a href="{{ route('event') }}" class="btn btn-outline-orange rounded-pill px-5 py-2 fw-bold">Go to Event Page <i class="fas fa-calendar-star ms-2"></i></a>
        </div>
    </div>
</div>

<style>
    .coming-soon-wrapper {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.05), transparent),
                    radial-gradient(circle at bottom left, rgba(11, 61, 97, 0.05), transparent);
    }
    .display-3 { font-size: 4.5rem; }
    .company-logo { height: 100px; }
    .highlight-orange { color: #f97316; }
    .countdown-item {
        background: white;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        min-width: 100px;
        border: 1px solid #f1f5f9;
    }
    .countdown-item .number {
        display: block;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0b3d61;
        line-height: 1;
    }
    .countdown-item .label {
        font-size: 0.8rem;
        text-transform: uppercase;
        font-weight: 800;
        color: #94a3b8;
        letter-spacing: 1px;
    }
    .btn-outline-orange {
        color: #f97316;
        border: 2px solid #f97316;
        transition: all 0.3s;
    }
    .btn-outline-orange:hover {
        background: #f97316;
        color: white;
    }
</style>
@endsection

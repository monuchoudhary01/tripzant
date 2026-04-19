@extends('layouts.hotel_master')

@section('title', 'B2C Distribution Gateway | Hotel Super Panel')

@section('styles')
<style>
    .ps-dist-card { background: #fff; border-radius: 24px; border: 1px solid var(--ps-border); padding: 35px; margin-bottom: 25px; }
    .ps-url-well { background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 16px; padding: 25px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">B2C Distribution Gateway</h2>
        <p class="text-muted fw-600 mb-0">Connect your high-performance public portal with your website and Google My Business profile.</p>
    </div>
    <div class="form-check form-switch h4"><label class="fw-800 tiny uppercase me-3 opacity-50">Portal Visibility:</label><input class="form-check-input" type="checkbox" checked></div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <!-- 1. Your Direct Booking URL -->
        <div class="ps-dist-card border-0 shadow-sm">
             <h6 class="tiny fw-900 uppercase text-muted mb-4 ls-1"><i class="fas fa-link me-1"></i> Your Unique Public URL</h6>
             <p class="small fw-700 text-muted mb-4">Every property in your portfolio gets a distinct, 0% commission booking URL optimized for conversion.</p>
             <div class="ps-url-well">
                  <div class="fw-800 text-navy h5 mb-0" style="word-break: break-all;">https://easitrip.com/book/radisson-blu-delhi</div>
                  <button class="btn btn-dark px-4 py-3 rounded-pill fw-900 tiny border-0 shadow-sm" onclick="alert('Direct Link Copied! Send it to your guests on WhatsApp.')"><i class="fas fa-copy me-1"></i> COPY LINK</button>
             </div>
        </div>

        <!-- 2. Integration with Official Website -->
        <div class="ps-dist-card border-0 shadow-sm">
             <h6 class="tiny fw-900 uppercase text-muted mb-4 ls-1"><i class="fas fa-plug me-1"></i> Official Website Sync</h6>
             <p class="small fw-700 text-muted mb-4">Paste this link into your website's **"Book Now"** button to replace your expensive 15-20% commission OTAs.</p>
             <div class="bg-light p-4 rounded-4 border-0 mb-4">
                  <div class="tiny fw-900 text-primary mb-3">Copy-Paste Button Action:</div>
                  <code class="small fw-700 text-dark">window.location.href = "https://easitrip.com/book/radisson-blu-delhi"</code>
             </div>
             <p class="tiny fw-700 text-muted mb-0"><i class="fas fa-info-circle me-1"></i> Pro Tip: Using our direct portal saved typical hotels over **₹1,25,000** in monthly commission fees.</p>
        </div>
    </div>

    <!-- Right Sidebar: Global Sync -->
    <div class="col-lg-5">
        <!-- Google My Business -->
        <div class="ps-dist-card border-0 shadow-sm bg-primary bg-opacity-5">
             <h6 class="tiny fw-900 uppercase text-primary mb-4 ls-1"><i class="fab fa-google me-1"></i> Google My Business (GMB) Sync</h6>
             <p class="small fw-700 text-muted mb-4">Add your booking URL to GMB to receive direct bookings from Google Maps & Search results.</p>
             <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 border-0 shadow-sm" style="background:#4285f4;"><i class="fab fa-google me-2"></i> PUSH TO GOOGLE MAPS</button>
        </div>

        <!-- Domain Mapping -->
        <div class="ps-dist-card border-0 shadow-sm">
             <h6 class="tiny fw-900 uppercase text-muted mb-4 ls-1"><i class="fas fa-globe me-1"></i> White-Label Custom Domain</h6>
             <p class="small fw-700 text-muted mb-4">Map your portal to your own domain for a premium branded experience (e.g., booking.radisson.com).</p>
             <div class="input-group mb-4">
                  <span class="input-group-text bg-light border-0 fw-800 small text-muted">booking.</span>
                  <input type="text" class="form-control py-3 fw-700 bg-light border-0" placeholder="yourhotel.com">
             </div>
             <button class="btn btn-outline-dark w-100 py-3 rounded-pill fw-800 border-2">SETUP WHITE-LABEL</button>
        </div>
    </div>
</div>
@endsection

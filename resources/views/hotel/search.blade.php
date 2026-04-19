@extends('layouts.hotel_master')

@section('title', 'Service Booking Center | Hotel Partner Engine')

@section('styles')
<style>
    .ps-hero-search { background: #101828; border-radius: 32px; padding: 60px; position: relative; overflow: hidden; margin-bottom: 40px; }
    .ps-hero-search::after { content: ''; position: absolute; right: -10%; top: -20%; width: 400px; height: 400px; background: rgba(99, 102, 241, 0.1); border-radius: 50%; filter: blur(100px); }
    
    .ps-search-form { background: #fff; border-radius: 24px; padding: 12px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 60px rgba(0,0,0,0.1); flex-wrap: wrap; }
    .ps-search-group { flex-grow: 1; min-width: 200px; padding: 10px 20px; border-radius: 16px; border: 1px solid transparent; transition: 0.2s; position: relative; }
    .ps-search-group:hover, .ps-search-group:focus-within { background: #f9fafb; border-color: #f2f4f7; }
    .ps-search-group label { display: block; font-size: 10px; font-weight: 800; text-transform: uppercase; color: #667085; letter-spacing: 1.2px; margin-bottom: 4px; }
    .ps-search-group input { border: none; background: transparent; width: 100%; font-weight: 800; color: #101828; outline: none; font-size: 15px; }
    
    .service-selection { display: flex; gap: 15px; margin-bottom: 30px; }
    .service-tab { padding: 12px 24px; border-radius: 12px; background: rgba(255,255,255,0.1); color: #fff; font-weight: 800; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 10px; border: 1px solid transparent; transition: 0.2s; cursor: pointer; }
    .service-tab:hover { background: rgba(255,255,255,0.15); }
    .service-tab.active { background: #fff; color: #101828; border-color: #fff; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.2); }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 36px;">Service Booking Engine</h2>
        <p class="text-muted fw-600 mb-0">Book cross-travel services for your in-house guests and walk-in clients.</p>
    </div>
</div>

<div class="ps-hero-search">
    <div class="service-selection">
        <div class="service-tab active"><i class="fas fa-plane"></i> FLIGHT SEARCH</div>
        <div class="service-tab" onclick="location.href='{{ route('hotel.results') }}'"><i class="fas fa-building"></i> EXTERNAL HOTELS</div>
        <div class="service-tab"><i class="fas fa-shuttle-van"></i> TRANSFERS</div>
        <div class="service-tab"><i class="fas fa-map-marked-alt"></i> TOURS</div>
    </div>

    <form action="{{ route('hotels.search') }}" method="POST" class="ps-search-form">
        @csrf
        <div class="ps-search-group">
            <label>City Code</label>
            <input type="text" name="city_code" placeholder="e.g. DXB" value="DXB" required>
        </div>
        <div class="ps-search-group">
            <label>Check In</label>
            <input type="date" name="checkin" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
        </div>
        <div class="ps-search-group">
            <label>Check Out</label>
            <input type="date" name="checkout" value="{{ date('Y-m-d', strtotime('+8 days')) }}" required>
        </div>
        <div class="ps-search-group">
            <label>Guests</label>
            <select name="adults" class="ps-search-group border-0 p-0 text-navy fw-800" style="background: transparent; outline: none; width: 100%; border:0 !important; cursor:pointer;">
                <option value="1">01 Adult</option>
                <option value="2" selected>02 Adults</option>
                <option value="3">03 Adults</option>
                <option value="4">04 Adults</option>
            </select>
        </div>
        
        <button type="submit" class="ps-btn-primary ms-2 px-5 py-3 h-100"><i class="fas fa-search me-2"></i> SEARCH HOTELS</button>
    </form>
</div>

<div class="row g-4 mb-5">
    <!-- Special Offers for Hotel Partners -->
    <div class="col-md-6">
        <div class="ps-card-stat p-5" style="background: linear-gradient(135deg, #eef2ff, #fff); border-left: 6px solid var(--ps-accent);">
             <h4 class="outfit fw-900 text-navy mb-3">Partner Exclusive: Air India Express</h4>
             <p class="text-muted fw-700 small mb-5">Get additional 5% commission on all domestic flights booked through your portal until the end of May.</p>
             <button class="btn ps-btn-primary px-5 py-3 border-0">ACTIVATION CODE: AIRINDIA5</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ps-card-stat p-5" style="background: linear-gradient(135deg, #f0fdf4, #fff); border-left: 6px solid #10b981;">
             <h4 class="outfit fw-900 text-navy mb-3">Car Rental Fleet Service</h4>
             <p class="text-muted fw-700 small mb-5">Manage airport pick-ups for your guests easily with our corporate rental tie-up. Lowest net rates guaranteed.</p>
             <button class="btn btn-success px-5 py-3 border-0 fw-900 rounded-pill">LINK FLEET MANAGER</button>
        </div>
    </div>
</div>
@endsection

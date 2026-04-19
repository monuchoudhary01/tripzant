@extends('layouts.hotel_master')

@section('title', 'Tours & Activities | Partner Super App')

@section('styles')
<style>
    .ps-tour-card { background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--ps-border); transition: 0.2s; }
    .ps-tour-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .ps-tour-img { height: 200px; background-size: cover; background-position: center; position: relative; }
    .ps-tour-price { position: absolute; bottom: 15px; left: 15px; background: #fff; padding: 6px 14px; border-radius: 8px; font-weight: 800; color: var(--ps-primary); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Tours & Sightseeing</h2>
        <p class="text-muted fw-600 mb-0">Book guided tours & activities for your guests and earn instant margin.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-light rounded-pill px-4 fw-800 border-0">CATEGORY: ALL</button>
        <button class="btn btn-light rounded-pill px-4 fw-800 border-0">CITY: DELHI NCR</button>
    </div>
</div>

<div class="row g-4">
    <!-- Tour Item -->
    <div class="col-md-4">
        <div class="ps-tour-card">
            <div class="ps-tour-img" style="background-image: url('https://images.unsplash.com/photo-1548013146-72479768bbaa?auto=format&fit=crop&q=80&w=600');">
                 <div class="ps-tour-price">₹2,499 <small class="text-muted">+ 10% COMM.</small></div>
            </div>
            <div class="p-4">
                 <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">CULTURAL TOUR • 4 HOURS</div>
                 <h5 class="outfit fw-800 text-navy mb-3">Old Delhi Food & Heritage Walking Tour</h5>
                 <p class="text-muted small fw-600 mb-4">Includes private guide, all tastings, and rickshaw ride through Chandni Chowk.</p>
                 <button class="btn ps-btn-primary w-100 py-3 rounded-pill">BOOK FOR GUEST</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="ps-tour-card">
            <div class="ps-tour-img" style="background-image: url('https://images.unsplash.com/photo-1595166411516-ec0d170f3f22?auto=format&fit=crop&q=80&w=600');">
                 <div class="ps-tour-price">₹12,800 <small class="text-muted">+ ₹1,200 COMM.</small></div>
            </div>
            <div class="p-4">
                 <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">DAY TRIP • FULL DAY</div>
                 <h5 class="outfit fw-800 text-navy mb-3">Same Day Taj Mahal Private Tour by Car</h5>
                 <p class="text-muted small fw-600 mb-4">Pickup from your hotel door. Includes AC Car, Guide, and Monument Entries.</p>
                 <button class="btn ps-btn-primary w-100 py-3 rounded-pill">BOOK FOR GUEST</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="ps-tour-card">
            <div class="ps-tour-img" style="background-image: url('https://images.unsplash.com/photo-1561339670-4368427958b4?auto=format&fit=crop&q=80&w=600');">
                 <div class="ps-tour-price">₹1,500 <small class="text-muted">MARKUP: ₹250</small></div>
            </div>
            <div class="p-4">
                 <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">EVENING • 2 HOURS</div>
                 <h5 class="outfit fw-800 text-navy mb-3">Qutub Minar Evening Illumination Skip-the-line</h5>
                 <p class="text-muted small fw-600 mb-4">Experience the world's tallest brick minaret under the golden lights.</p>
                 <button class="btn ps-btn-primary w-100 py-3 rounded-pill">BOOK FOR GUEST</button>
            </div>
        </div>
    </div>
</div>
@endsection

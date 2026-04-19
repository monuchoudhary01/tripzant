@extends('layouts.hotel_master')

@section('title', 'Global Hotel Inventory | Partner Super App')

@section('styles')
<style>
    .ps-hotel-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); display: flex; overflow: hidden; margin-bottom: 25px; transition: 0.2s; }
    .ps-hotel-card:hover { border-color: var(--ps-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .ps-hotel-img { width: 300px; min-width: 300px; background-size: cover; background-position: center; position: relative; }
    .ps-hotel-info { padding: 30px; flex-grow: 1; }
    .ps-hotel-action { width: 250px; padding: 30px; border-left: 1px dashed var(--ps-border); background: #f8fafc; text-align: center; display: flex; flex-direction: column; justify-content: center; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">External Property Network</h2>
        <p class="text-muted fw-600 mb-0">Book stays in globally aggregated properties for your clients and guests. B2B net rates applied.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
         <span class="tiny fw-800 text-muted uppercase">Sorting by:</span>
         <select class="form-select border-0 bg-light rounded-pill fw-800 py-2 small ps-3">
             <option>Highest Commission</option>
             <option>Lowest Price</option>
         </select>
    </div>
</div>

<div class="row g-4">
    <!-- Hotel 1 -->
    <div class="col-12 ps-hotel-card">
        <div class="ps-hotel-img" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=600');"></div>
        <div class="ps-hotel-info">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-2">Singapore • Marina Bay</div>
             <h4 class="outfit fw-900 text-navy mb-2">The Ritz-Carlton, Millenia</h4>
             <p class="text-muted small fw-600 mb-4 lh-base">Experience world-class service. Located in the heart of Marina Bay, offering panoramic views of the skyline. B2B Exclusive Allocation.</p>
             <div class="d-flex gap-3">
                  <span class="badge bg-light text-muted p-2 rounded fw-800" style="font-size: 10px;"><i class="fas fa-star text-warning me-1"></i> 5.0 LUXURY</span>
                  <span class="badge bg-light text-muted p-2 rounded fw-800" style="font-size: 10px;"><i class="fas fa-wifi me-1"></i> FREE HIGH-SPEED WI-FI</span>
                  <span class="badge bg-light text-muted p-2 rounded fw-800" style="font-size: 10px;"><i class="fas fa-swimmer me-1"></i> INFINITY POOL</span>
             </div>
        </div>
        <div class="ps-hotel-action">
             <div class="tiny fw-800 text-muted uppercase mb-1">Per Night Net</div>
             <div class="h3 fw-900 text-navy outfit mb-1">₹32,500</div>
             <span class="tiny text-success fw-900 mb-4 ls-1">MARKUP: ₹4,800 +</span>
             <button class="btn ps-btn-primary w-100 py-3 rounded-pill">BOOK ROOM</button>
        </div>
    </div>

    <!-- Hotel 2 -->
    <div class="col-12 ps-hotel-card">
        <div class="ps-hotel-img" style="background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=600');"></div>
        <div class="ps-hotel-info">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-2">Dubai • Palm Jumeirah</div>
             <h4 class="outfit fw-900 text-navy mb-2">Atlantis The Palm</h4>
             <p class="text-muted small fw-600 mb-4 lh-base">Iconic luxury resort on the Palm. Includes unlimited access to Aquaventure Waterpark for all guests.</p>
             <div class="d-flex gap-3">
                  <span class="badge bg-light text-muted p-2 rounded fw-800" style="font-size: 10px;"><i class="fas fa-star text-warning me-1"></i> 5.0 ULTRA</span>
                  <span class="badge bg-light text-muted p-2 rounded fw-800" style="font-size: 10px;"><i class="fas fa-utensils me-1"></i> ALL INCLUSIVE</span>
             </div>
        </div>
        <div class="ps-hotel-action">
             <div class="tiny fw-800 text-muted uppercase mb-1">Per Night Net</div>
             <div class="h3 fw-900 text-navy outfit mb-1">₹45,200</div>
             <span class="tiny text-success fw-900 mb-4 ls-1">COMMISSION: ₹6,500</span>
             <button class="btn ps-btn-primary w-100 py-3 rounded-pill">BOOK ROOM</button>
        </div>
    </div>
</div>
@endsection

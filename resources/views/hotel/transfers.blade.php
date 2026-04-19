@extends('layouts.hotel_master')

@section('title', 'Transfers Hub | Hotel Partner Super App')

@section('styles')
<style>
    .ps-transfer-row { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 30px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; transition: 0.2s; }
    .ps-transfer-row:hover { border-color: var(--ps-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .ps-vehicle-icon { width: 60px; height: 60px; border-radius: 12px; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #101828; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Seamless Transit & Transfers</h2>
        <p class="text-muted fw-600 mb-0">Arrange airport, station and point-to-point transfers for guests. Lowest corporate rates.</p>
    </div>
    <button class="ps-btn-primary px-4 py-2 small fw-800 border-0 rounded-pill"><i class="fas fa-plus me-1"></i> ADD CUSTOM ROUTE</button>
</div>

<div class="row g-4">
    <!-- Transfer Type 1 -->
    <div class="col-12 ps-transfer-row">
        <div class="d-flex align-items-center gap-4 flex-grow-1">
             <div class="ps-vehicle-icon"><i class="fas fa-car-side"></i></div>
             <div>
                  <h5 class="outfit fw-800 text-navy mb-1">Standard Economy Sedan (Maruti Dzire or similar)</h5>
                  <div class="tiny fw-700 text-muted uppercase ls-1"><i class="fas fa-users me-1"></i> 3 Pax • <i class="fas fa-suitcase me-1"></i> 2 Bags</div>
             </div>
        </div>
        <div class="px-5 border-start border-end text-center d-none d-md-block" style="width: 250px;">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Fare: IGI Airport to Hotel</div>
             <div class="h5 fw-900 text-navy mb-0 outfit">₹850.00</div>
             <span class="tiny text-success fw-800">COMMISSION: ₹150</span>
        </div>
        <div class="ps-3 d-flex flex-column gap-2" style="width: 200px;">
             <button class="btn ps-btn-primary py-2 rounded-pill small fw-800 border-0">BOOK INSTANT</button>
             <button class="btn btn-outline-secondary py-2 rounded-pill tiny fw-800 border-2">SCHEDULE LATER</button>
        </div>
    </div>

    <!-- Transfer Type 2 -->
    <div class="col-12 ps-transfer-row" style="background:#eef2ff; border-color:RGBA(99,102,241,0.2);">
        <div class="d-flex align-items-center gap-4 flex-grow-1">
             <div class="ps-vehicle-icon" style="background:#fff; color:#6366f1;"><i class="fas fa-van-shuttle"></i></div>
             <div>
                  <h5 class="outfit fw-800 text-navy mb-1">Premium Innova Crysta MPV (Shared or Private)</h5>
                  <div class="tiny fw-800 text-primary uppercase ls-1"><i class="fas fa-users me-1"></i> 6 Pax • <i class="fas fa-suitcase me-1"></i> 4 Bags</div>
             </div>
        </div>
        <div class="px-5 border-start border-end text-center d-none d-md-block" style="width: 250px;">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Fare: IGI Airport to Hotel</div>
             <div class="h5 fw-900 text-navy mb-0 outfit">₹1,450.00</div>
             <span class="tiny text-success fw-800">COMMISSION: ₹250</span>
        </div>
        <div class="ps-3 d-flex flex-column gap-2" style="width: 200px;">
             <button class="btn ps-btn-primary py-2 rounded-pill small fw-800 border-0">BOOK INSTANT</button>
             <button class="btn btn-outline-secondary py-2 rounded-pill tiny fw-800 border-2">SCHEDULE LATER</button>
        </div>
    </div>
</div>
@endsection

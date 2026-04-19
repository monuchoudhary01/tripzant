@extends('layouts.hotel_master')

@section('title', 'Won Deals | QuikHotel Terminal')

@section('styles')
<style>
    .h-deal-card { background: #fff; border-radius: 20px; border: 1px solid var(--h-border); padding: 30px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; position: relative; }
    .h-deal-card:hover { border-color: #22c55e; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
    .h-deal-avatar { width: 50px; height: 50px; border-radius: 12px; background: #f0fdf4; color: #15803d; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .h-deal-body { padding: 0 25px; flex-grow: 1; }
</style>
@endsection

@section('content')
<div class="mb-5">
    <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px;">Success Hub - Finalized Deals</h2>
    <p class="text-muted fw-600 mb-0">Review and manage all successful negotiations that converted into confirmed guest stays.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="h-glass-card shadow-sm border-0 p-4 text-center">
             <h4 class="outfit fw-900 text-success mb-1">₹85.2L</h4>
             <div class="tiny fw-700 text-muted uppercase">Concluded Revenue</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="h-glass-card shadow-sm border-0 p-4 text-center">
             <h4 class="outfit fw-900 text-navy mb-1">124</h4>
             <div class="tiny fw-700 text-muted uppercase">Successful Deals</div>
        </div>
    </div>
</div>

<!-- List of Finalized Deals -->
<div class="h-deal-card">
    <div class="h-deal-avatar"><i class="fas fa-check-double"></i></div>
    <div class="h-deal-body">
        <div class="d-flex justify-content-between align-items-center mb-1">
             <h5 class="mb-0 outfit fw-900 text-navy">MICE Group - Singapore Agents</h5>
             <span class="badge bg-success text-small px-3 py-2 rounded-pill">CONFIRMED</span>
        </div>
        <p class="text-muted small fw-600 mb-3">#DEAL-9012 • 40 Guests • 4 Nights Stay</p>
        <div class="d-flex gap-3">
             <span class="tiny fw-700 text-muted uppercase"><i class="fas fa-wallet me-1"></i> Net Value: ₹12,40,000</span>
             <span class="tiny fw-700 text-muted uppercase"><i class="fas fa-calendar-check me-1"></i> Finalized: April 02, 2024</span>
        </div>
    </div>
    <div class="text-end d-flex gap-2">
         <button class="btn btn-outline-secondary btn-sm px-4 fw-800 rounded-pill"><i class="fas fa-file-invoice"></i> INVOICE</button>
         <button class="btn btn-success btn-sm px-4 fw-800 rounded-pill shadow-sm">DOWNLOAD VOUCHER</button>
    </div>
</div>

<div class="h-deal-card">
    <div class="h-deal-avatar"><i class="fas fa-check-double"></i></div>
    <div class="h-deal-body">
        <div class="d-flex justify-content-between align-items-center mb-1">
             <h5 class="mb-0 outfit fw-900 text-navy">Corporate Delegate - NYC Agents</h5>
             <span class="badge bg-success text-small px-3 py-2 rounded-pill">CONFIRMED</span>
        </div>
        <p class="text-muted small fw-600 mb-3">#DEAL-8995 • 1 Guest • 3 Nights Stay</p>
        <div class="d-flex gap-3">
             <span class="tiny fw-700 text-muted uppercase"><i class="fas fa-wallet me-1"></i> Net Value: ₹45,500</span>
             <span class="tiny fw-700 text-muted uppercase"><i class="fas fa-calendar-check me-1"></i> Finalized: March 28, 2024</span>
        </div>
    </div>
    <div class="text-end d-flex gap-2">
         <button class="btn btn-outline-secondary btn-sm px-4 fw-800 rounded-pill"><i class="fas fa-file-invoice"></i> INVOICE</button>
         <button class="btn btn-success btn-sm px-4 fw-800 rounded-pill shadow-sm">DOWNLOAD VOUCHER</button>
    </div>
</div>

<div class="text-center py-4">
    <button class="btn btn-link text-muted fw-800 text-decoration-none small">EXPLORE HISTORICAL ARCHIVES <i class="fas fa-archive ms-2"></i></button>
</div>
@endsection

@extends('layouts.hotel_master')

@section('title', 'Guest Relations CRM | Partner Super App')

@section('styles')
<style>
    .ps-guest-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; transition: 0.2s; }
    .ps-guest-card:hover { border-color: var(--ps-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .ps-guest-avatar { width: 48px; height: 48px; border-radius: 12px; background: #eef2ff; color: #6366f1; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 800; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Guest Intelligence & CRM</h2>
        <p class="text-muted fw-600 mb-0">Manage guest profiles, loyalty history, and service interactions for your property.</p>
    </div>
    <button class="ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm"><i class="fas fa-user-plus me-2"></i> REGISTER NEW GUEST</button>
</div>

<div class="row mb-5">
    <!-- Quick Stats -->
    <div class="col-md-3">
        <div class="bg-white p-4 rounded-4 border border-faint">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">In-House Guests</div>
             <div class="h3 fw-900 text-navy outfit">42</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white p-4 rounded-4 border border-faint">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Repeat Clients</div>
             <div class="h3 fw-900 text-navy outfit">18</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white p-4 rounded-4 border border-faint">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Avg. LTV / Guest</div>
             <div class="h3 fw-900 text-navy outfit">₹85,400</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white p-4 rounded-4 border border-faint">
             <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Ancillary Upsell</div>
             <div class="h3 fw-900 text-navy outfit">45%</div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <div class="mb-5">
         <h5 class="outfit fw-900 text-navy mb-4 border-bottom pb-4">Recent Guest Interaction Logs</h5>
         
         <div class="ps-guest-card">
              <div class="d-flex align-items-center gap-4 flex-grow-1">
                   <div class="ps-guest-avatar">JW</div>
                   <div>
                        <h6 class="outfit fw-800 text-navy mb-0">Johnathan Wick (United Kingdom)</h6>
                        <span class="tiny text-muted fw-800"><i class="fas fa-envelope me-1"></i> j.wick@email.com • <i class="fas fa-phone me-1"></i> +44 20-1234-5678</span>
                   </div>
              </div>
              <div class="px-5 border-start border-end text-center d-none d-md-block" style="width: 250px;">
                   <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Loyalty Tier</div>
                   <div class="badge bg-soft-blue text-primary px-3 py-1 rounded-pill fw-800 outfit">GOLD MEMBER</div>
                   <div class="tiny text-muted fw-700 mt-1">4 Past Bookings</div>
              </div>
              <div class="ps-3 d-flex flex-column gap-2" style="width: 200px;">
                   <button class="btn btn-light py-2 rounded-pill small fw-800 border-0">GUEST HISTORY</button>
                   <button class="btn ps-btn-primary py-2 rounded-pill tiny fw-800 border-0 shadow-sm" onclick="location.href='{{ route('hotel.search') }}'">BOOK SERVICE</button>
              </div>
         </div>

         <div class="ps-guest-card">
              <div class="d-flex align-items-center gap-4 flex-grow-1">
                   <div class="ps-guest-avatar">RS</div>
                   <div>
                        <h6 class="outfit fw-800 text-navy mb-0">Rahul Sharma (India)</h6>
                        <span class="tiny text-muted fw-800"><i class="fas fa-envelope me-1"></i> r.sharma@email.com • <i class="fas fa-phone me-1"></i> +91 91234 56789</span>
                   </div>
              </div>
              <div class="px-5 border-start border-end text-center d-none d-md-block" style="width: 250px;">
                   <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Loyalty Tier</div>
                   <div class="badge bg-light text-muted px-3 py-1 rounded-pill fw-800 outfit">NEW GUEST</div>
                   <div class="tiny text-muted fw-700 mt-1">First Time Stay</div>
              </div>
              <div class="ps-3 d-flex flex-column gap-2" style="width: 200px;">
                   <button class="btn btn-light py-2 rounded-pill small fw-800 border-0">GUEST HISTORY</button>
                   <button class="btn ps-btn-primary py-2 rounded-pill tiny fw-800 border-0 shadow-sm" onclick="location.href='{{ route('hotel.search') }}'">BOOK SERVICE</button>
              </div>
         </div>
    </div>
</div>
@endsection

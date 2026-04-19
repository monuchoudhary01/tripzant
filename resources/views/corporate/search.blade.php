@extends('layouts.app')

@section('title', "Corporate Flight Search — Tripzant")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="employee" active="search" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Corporate Flight Search</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Search for business travel. Subject to organization policy & admin approval.</p>
                </div>
            </div>

            <!-- Search Widget Integration -->
            <div class="card border-0 shadow-lg rounded-5 bg-white p-5 mb-5 animate-up">
                 <div class="row align-items-center mb-5 border-bottom pb-4">
                     <div class="col-md-6">
                         <h6 class="fw-900 text-navy uppercase tracking-widest small mb-0"><i class="fas fa-plane-departure me-2 text-primary"></i> Trip Details</h6>
                     </div>
                     <div class="col-md-6 text-end">
                         <span class="badge bg-blue-subtle text-blue rounded-pill px-3 py-1 x-small fw-bold">POLICY: DOMESTIC_ECONOMY_MAX_10K</span>
                     </div>
                 </div>

                 <!-- Reusing the search widget style but adapted for corporate layout if needed -->
                 <div class="corporate-search-box bg-light rounded-5 p-4 py-5 shadow-sm">
                    <form action="{{ route('corporate.booking.listing') }}" method="GET">
                        <div class="row g-4 px-4 align-items-end">
                            <div class="col-md-3">
                                <label class="x-small fw-900 text-muted uppercase mb-3">Origin City</label>
                                <div class="bg-white rounded-4 p-3 shadow-none border">
                                     <h6 class="fw-900 text-navy mb-0">Delhi (DEL)</h6>
                                     <span class="x-small text-muted fw-bold">Indira Gandhi Intl Airport</span>
                                </div>
                            </div>
                            <div class="col-md-1 text-center pb-2">
                                <div class="bg-white rounded-circle shadow-sm border p-2 d-inline-block cursor-pointer"><i class="fas fa-exchange-alt text-primary"></i></div>
                            </div>
                            <div class="col-md-3">
                                <label class="x-small fw-900 text-muted uppercase mb-3">Destination</label>
                                <div class="bg-white rounded-4 p-3 shadow-none border">
                                     <h6 class="fw-900 text-navy mb-0">Mumbai (BOM)</h6>
                                     <span class="x-small text-muted fw-bold">Chhatrapati Shivaji Intl</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="x-small fw-900 text-muted uppercase mb-3">Departure Date</label>
                                <div class="bg-white rounded-4 p-3 shadow-none border">
                                     <h6 class="fw-900 text-navy mb-0">22 May, 2026</h6>
                                     <span class="x-small text-muted fw-bold">Friday</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-navy w-100 rounded-pill py-4 fw-900 x-small uppercase shadow-lg">SEARCH FLIGHTS <i class="fas fa-search ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                 </div>
            </div>

            <!-- Policy Guidelines for Employees -->
            <div class="row g-5">
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100">
                        <h5 class="fw-900 text-navy mb-5 border-bottom pb-4">Corporate Travel Policy Refresher</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-5 border-dashed border-primary border-2 mb-4">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Price Cap Rule</h6>
                                     <p class="x-small text-muted mb-0">Domestic flights must be under ₹10,000 for auto-approval. Above this, Travel Manager approval is mandatory.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-5 border-dashed border-success border-2 mb-4">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Booking Advance</h6>
                                     <p class="x-small text-muted mb-0">Please book at least 7 days in advance to ensure lowest negotiated corporate fares are available.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                     <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 h-100 overflow-hidden position-relative">
                         <div class="position-relative" style="z-index: 2;">
                            <h6 class="fw-900 uppercase opacity-50 x-small mb-4">Your Recent Trips</h6>
                            <div class="d-flex flex-column gap-3">
                                 <div class="p-3 bg-white-subtle rounded-4 d-flex justify-content-between align-items-center">
                                      <div>
                                           <span class="d-block fw-900 small">DEL → BLR</span>
                                           <span class="x-small opacity-50 fw-bold">ISSUED | 12 MAR</span>
                                      </div>
                                      <i class="fas fa-chevron-right opacity-50"></i>
                                 </div>
                                 <div class="p-3 bg-white-subtle rounded-4 d-flex justify-content-between align-items-center">
                                      <div>
                                           <span class="d-block fw-900 small">BOM → DEL</span>
                                           <span class="x-small opacity-50 fw-bold">PENDING | 15 MAY</span>
                                      </div>
                                      <span class="badge bg-warning text-dark x-small px-2">WAITING</span>
                                 </div>
                            </div>
                         </div>
                         <div style="position:absolute; right:-30px; bottom:-30px; width:150px; height:150px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                     </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .bg-blue-subtle { background: #eff6ff; color: #3b82f6; }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .border-dashed { border-style: dashed !important; }
    .border-primary { border-color: #3b82f660 !important; }
    .border-success { border-color: #10b98160 !important; }
</style>
@endsection

@extends('layouts.app')

@section('title', "Travel Policies — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="policies" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Corporate Travel Policy Hub</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Define Budget Caps, Allowed Airlines, and Approval Workflows.</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">DEPLOY NEW POLICY <i class="fas fa-rocket ms-2 text-warning"></i></button>
                </div>
            </div>

            <div class="row g-5">
                <!-- Policy Configuration Section -->
                <div class="col-xl-7">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 h-100">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4">Domestic Flight Governance</h6>
                        <div class="d-flex flex-column gap-5">
                             <div class="row g-4 align-items-center pb-5 border-bottom border-light">
                                 <div class="col-md-5">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Max Flight Price</h6>
                                     <span class="x-small text-muted fw-bold">Price Cap per Passenger</span>
                                 </div>
                                 <div class="col-md-7">
                                      <div class="input-group bg-light rounded-4 border-0 p-1">
                                          <span class="input-group-text bg-transparent border-0 fw-900 text-navy">₹</span>
                                          <input type="number" class="form-control bg-transparent border-0 fw-900 text-navy" value="10000">
                                      </div>
                                 </div>
                             </div>

                             <div class="row g-4 align-items-center pb-5 border-bottom border-light">
                                 <div class="col-md-5">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Cabin Class Restriction</h6>
                                     <span class="x-small text-muted fw-bold">Allowed Seating Types</span>
                                 </div>
                                 <div class="col-md-7">
                                      <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                          <option value="economy">ECONOMY ONLY (RECOMMENDED)</option>
                                          <option value="premium">ECONOMY & PREMIUM ECONOMY</option>
                                          <option value="business">ALL CLASSES (EXECUTIVE LEVEL)</option>
                                      </select>
                                 </div>
                             </div>

                             <div class="row g-4 align-items-center pb-5 border-bottom border-light">
                                 <div class="col-md-5">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Allowed Airline Access</h6>
                                     <span class="x-small text-muted fw-bold">Organization Preferred Partners</span>
                                 </div>
                                 <div class="col-md-7">
                                     <div class="d-flex gap-4 p-2 bg-light rounded-4 flex-wrap">
                                          <span class="badge bg-navy text-white rounded-pill px-3 py-2 x-small fw-bold">Indigo <i class="fas fa-times ms-2"></i></span>
                                          <span class="badge bg-navy text-white rounded-pill px-3 py-2 x-small fw-bold">Air India <i class="fas fa-times ms-2"></i></span>
                                          <span class="badge bg-navy text-white rounded-pill px-3 py-2 x-small fw-bold">Vistara <i class="fas fa-times ms-2"></i></span>
                                          <button class="badge bg-white text-navy border-0 rounded-pill px-3 py-2 x-small fw-bold uppercase">+ Add Airline</button>
                                     </div>
                                 </div>
                             </div>

                             <div class="row g-4 align-items-center">
                                 <div class="col-md-5">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Advance Booking Rule</h6>
                                     <span class="x-small text-muted fw-bold">Minimum days before departure</span>
                                 </div>
                                 <div class="col-md-7">
                                      <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                          <option value="7">MIN 7 DAYS PRIOR (BEST YIELD)</option>
                                          <option value="3">MIN 3 DAYS PRIOR</option>
                                          <option value="0">SAME DAY ALLOWED</option>
                                      </select>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Live Rule Analytics -->
                <div class="col-xl-5">
                    <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 h-100 position-relative overflow-hidden">
                        <div class="position-relative" style="z-index: 2;">
                             <div class="mb-5 border-bottom border-white-subtle pb-4">
                                  <h6 class="fw-900 mb-2 uppercase tracking-wide opacity-50">Impact Simulation Center</h6>
                             </div>
                             <div class="d-flex flex-column gap-5">
                                 <div class="p-4 bg-white-subtle rounded-4 d-flex align-items-center gap-4">
                                     <div class="bg-white rounded-circle p-2 px-3 text-navy"><i class="fas fa-shield-alt h4 mb-0"></i></div>
                                     <div>
                                          <h6 class="fw-900 mb-1 small uppercase">Policy Guard Active</h6>
                                          <p class="x-small opacity-75 mb-0">Bookings exceeding ₹10,000 will be auto-flagged for Admin intervention.</p>
                                     </div>
                                 </div>
                                 <div class="p-4 bg-white-subtle rounded-4 d-flex align-items-center gap-4">
                                     <div class="bg-white rounded-circle p-2 px-3 text-navy"><i class="fas fa-coins h4 mb-0"></i></div>
                                     <div>
                                          <h6 class="fw-900 mb-1 small uppercase">Monthly Savings Yield</h6>
                                          <p class="x-small opacity-75 mb-0">Current Domestic Price Cap saves ~18% compared to open market bookings.</p>
                                     </div>
                                 </div>
                             </div>
                        </div>
                        <div style="position:absolute; right:-30px; bottom:-30px; width:200px; height:200px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
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
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .border-white-subtle { border-color: rgba(255,255,255,0.1) !important; }
    .bg-light { background: #f1f5f9 !important; }
</style>
@endsection

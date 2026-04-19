@extends('layouts.app')

@section('title', "Markup Settings — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="markups" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Revenue & Markup Configuration</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Global Yield Optimization Hub | Domestic vs International Rules</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">DEPLOY MARKUP RULES <i class="fas fa-rocket ms-2 text-warning"></i></button>
                </div>
            </div>

            <div class="row g-5">
                <!-- Markup Rule Form -->
                <div class="col-xl-7">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 h-100">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">SET ACTIVE REVENUE LOGIC</h6>
                        <div class="d-flex flex-column gap-5">
                             <div class="row g-4 align-items-center pb-5 border-bottom border-light">
                                 <div class="col-md-4">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Domestic Flight Hub</h6>
                                     <span class="x-small text-muted fw-bold">Fixed Amount per Pax</span>
                                 </div>
                                 <div class="col-md-5">
                                      <div class="input-group bg-light rounded-4 border-0 p-1">
                                          <span class="input-group-text bg-transparent border-0 fw-900 text-navy">₹</span>
                                          <input type="number" class="form-control bg-transparent border-0 fw-900 text-navy" value="500">
                                      </div>
                                 </div>
                                 <div class="col-md-3">
                                      <div class="form-check form-switch d-flex justify-content-end p-0">
                                          <input class="form-check-input ms-0 border-0 bg-navy shadow-none" type="checkbox" checked style="width: 50px; height: 24px;">
                                      </div>
                                 </div>
                             </div>

                             <div class="row g-4 align-items-center pb-5 border-bottom border-light">
                                 <div class="col-md-4">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">International Flight Hub</h6>
                                     <span class="x-small text-muted fw-bold">Percentage (%) on Base Fare</span>
                                 </div>
                                 <div class="col-md-5">
                                      <div class="input-group bg-light rounded-4 border-0 p-1">
                                          <span class="input-group-text bg-transparent border-0 fw-900 text-navy">%</span>
                                          <input type="number" class="form-control bg-transparent border-0 fw-900 text-navy" value="3.5">
                                      </div>
                                 </div>
                                 <div class="col-md-3">
                                      <div class="form-check form-switch d-flex justify-content-end p-0">
                                          <input class="form-check-input ms-0 border-0 bg-navy shadow-none" type="checkbox" checked style="width: 50px; height: 24px;">
                                      </div>
                                 </div>
                             </div>

                             <div class="row g-4 align-items-center">
                                 <div class="col-md-4">
                                     <h6 class="fw-900 text-navy mb-1 small uppercase">Special Airline Surcharge</h6>
                                     <span class="x-small text-muted fw-bold">Specific to EK, AI, UK (GDS Yield)</span>
                                 </div>
                                 <div class="col-md-5">
                                      <div class="input-group bg-light rounded-4 border-0 p-1 opacity-50">
                                          <span class="input-group-text bg-transparent border-0 fw-900 text-navy">₹</span>
                                          <input type="number" class="form-control bg-transparent border-0 fw-900 text-navy" value="0" disabled>
                                      </div>
                                 </div>
                                 <div class="col-md-3">
                                      <div class="form-check form-switch d-flex justify-content-end p-0">
                                          <input class="form-check-input ms-0 border-0 bg-light shadow-none" type="checkbox" style="width: 50px; height: 24px;">
                                      </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Simulation/Preview Panel -->
                <div class="col-xl-5">
                    <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 h-100 position-relative overflow-hidden">
                        <div class="position-relative" style="z-index: 2;">
                             <h6 class="fw-900 mb-5 uppercase tracking-wide opacity-50">Earnings Simulation Hub</h6>
                             <div class="p-4 bg-white-subtle rounded-4 mb-4 border border-white-subtle">
                                 <span class="d-block x-small opacity-75 uppercase fw-bold mb-2 tracking-widest">Base B2B Fare Example</span>
                                 <h4 class="fw-900 mb-0">₹10,000</h4>
                             </div>
                             <div class="p-4 bg-white-subtle rounded-4 mb-4 border-dashed border-warning border-1">
                                 <span class="d-block x-small opacity-75 uppercase fw-bold mb-2 tracking-widest">+ Applied Agent Yield Hub</span>
                                 <h4 class="fw-900 mb-0 text-warning">₹350 (3.5%)</h4>
                             </div>
                             <div class="p-4 bg-white-subtle rounded-4 mb-0 border border-white-subtle">
                                 <span class="d-block x-small opacity-75 uppercase fw-bold mb-2 tracking-widest">Final Customer Selling Price</span>
                                 <h4 class="fw-900 mb-0">₹10,350</h4>
                             </div>
                        </div>
                        <div style="position:absolute; right:-50px; bottom:-50px; width:250px; height:250px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
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
    .border-dashed { border-style: dashed !important; }
    .bg-light { background: #f1f5f9 !important; }
    .form-check-input:checked { background-color: #0b3d61 !important; border-color: #0b3d61 !important; }
</style>
@endsection

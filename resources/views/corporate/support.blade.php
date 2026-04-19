@extends('layouts.app')

@section('title', "Corporate Support Hub — Tripzant")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="support" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Corporate Dedicated Support HUB</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Connect with your Account Manager Hub | GDS Expert Desk.</p>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-xl-8">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 animate-up">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4">Submit High-Priority Assist Request</h6>
                        <form action="#" method="POST">
                             <div class="row g-4 mb-5">
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">CONCERN CATEGORY</label>
                                     <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                         <option value="fare">GDS FARE DISCREPANCY</option>
                                         <option value="billing">CORPORATE BILLING HUB</option>
                                         <option value="policy">POLICY COMPLIANCE HELP</option>
                                         <option value="tech">TECHNICAL PORTAL ASSIST</option>
                                     </select>
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">PRIORITY LEVEL</label>
                                     <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                         <option value="high">URGENT (ACTION REQ)</option>
                                         <option value="med">MODERATE (FYI)</option>
                                         <option value="low">GENERAL QUERY</option>
                                     </select>
                                 </div>
                                 <div class="col-md-12 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">TICKET NARRATIVE</label>
                                     <textarea class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" rows="5" placeholder="Describe the operational issue in detail..."></textarea>
                                 </div>
                             </div>

                             <button type="button" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-lg">DISPATCH FOR ASSIST <i class="fas fa-paper-plane ms-2"></i></button>
                        </form>
                    </div>
                </div>

                <div class="col-xl-4 sticky-top" style="top: 100px; height: fit-content;">
                     <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 animate-up delay-1 overflow-hidden position-relative">
                         <div class="position-relative" style="z-index: 2;">
                            <h6 class="fw-900 uppercase opacity-50 x-small mb-4">Dedicated Corporate Desk</h6>
                            <div class="d-flex flex-column gap-4">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white rounded-circle p-2 px-3 text-navy"><i class="fas fa-headset"></i></div>
                                     <div class="small fw-bold">1800-TRIPZANT-CORP</div>
                                 </div>
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white rounded-circle p-2 px-3 text-navy"><i class="fas fa-envelope"></i></div>
                                     <div class="small fw-bold">corp-assist@tripzant.com</div>
                                 </div>
                                 <div class="d-flex align-items-center gap-3 px-1">
                                      <div class="x-small opacity-50 fw-bold">SLA: 15 MIN (PRIO) | 4 HOURS (GEN)</div>
                                 </div>
                            </div>
                            <button class="btn btn-warning w-100 rounded-pill py-3 fw-900 x-small uppercase mt-5 shadow-sm">START LIVE VIDEO ASSIST</button>
                         </div>
                         <div style="position:absolute; right:-50px; bottom:-50px; width:200px; height:200px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
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
    .bg-light { background: #f1f5f9 !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .delay-1 { animation-delay: 0.1s; }
</style>
@endsection

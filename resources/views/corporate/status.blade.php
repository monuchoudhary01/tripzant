@extends('layouts.app')

@section('title', "Request Status — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="employee" active="status" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Travel Request Status</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Track your business travel authorizations and ticketing logs.</p>
                </div>
            </div>

            <div class="row g-5">
                <!-- Request Details View -->
                <div class="col-xl-8">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 h-100 animate-up">
                         <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-5">
                             <div class="d-flex align-items-center gap-4">
                                 <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center shadow-lg" style="width: 60px; height: 60px;"><i class="fas fa-paper-plane h4 mb-0"></i></div>
                                 <div>
                                      <h4 class="fw-900 text-navy mb-1">Request #TR-{{ $id }}</h4>
                                      <span class="x-small text-muted fw-bold uppercase">Submitted on 01 APR, 12:45 PM</span>
                                 </div>
                             </div>
                             <div class="text-end">
                                  <span class="badge bg-warning text-dark px-4 py-3 rounded-pill fw-900 uppercase x-small shadow-sm border border-warning border-opacity-10"><i class="fas fa-hourglass-half me-2"></i> PENDING ADMIN REVIEW</span>
                             </div>
                         </div>

                         <div class="d-flex flex-column gap-5">
                             <h6 class="fw-900 text-navy uppercase tracking-widest small mb-1 opacity-50">Flight Breakdown Hub</h6>
                             <div class="p-4 bg-light rounded-5 border-dashed border-primary border-1">
                                  <div class="row align-items-center gx-5">
                                       <div class="col-md-5">
                                            <div class="d-flex justify-content-between align-items-center text-center">
                                                 <div>
                                                      <h4 class="fw-900 text-navy mb-1">07:15</h4>
                                                      <span class="x-small text-muted fw-bold uppercase">DEL (Delhi)</span>
                                                 </div>
                                                 <div class="flex-grow-1 px-3 text-center">
                                                      <div class="timeline-line bg-navy opacity-10 position-relative" style="height:2px; width:100%;">
                                                           <i class="fas fa-plane text-navy opacity-50" style="position:relative; top:-10px;"></i>
                                                      </div>
                                                 </div>
                                                 <div>
                                                      <h4 class="fw-900 text-navy mb-1">09:30</h4>
                                                      <span class="x-small text-muted fw-bold uppercase">BOM (Mumbai)</span>
                                                 </div>
                                            </div>
                                       </div>
                                       <div class="col-md-3 border-start border-light ps-5">
                                            <span class="d-block x-small opacity-50 fw-bold uppercase">NEGOTIATED FARE</span>
                                            <h4 class="fw-900 text-navy mb-0">₹4,820</h4>
                                       </div>
                                       <div class="col-md-4 text-end">
                                            <span class="badge bg-green-subtle text-green px-3 py-1 rounded-pill x-small fw-bold border">IN TRAVEL POLICY <i class="fas fa-check-circle ms-1"></i></span>
                                       </div>
                                  </div>
                             </div>

                             <div class="traveler-meta mt-4 p-5 bg-navy text-white rounded-5 shadow-2">
                                  <h6 class="fw-900 mb-4 uppercase tracking-widest opacity-50 small border-bottom border-white-subtle pb-3">Traveler Information Hub</h6>
                                  <div class="row g-4">
                                       <div class="col-md-6">
                                            <span class="d-block x-small opacity-50 fw-900 uppercase">Primary Passenger</span>
                                            <h6 class="fw-bold mb-0">Rahul Khanna (E-ID: 90281)</h6>
                                       </div>
                                       <div class="col-md-6">
                                            <span class="d-block x-small opacity-50 fw-900 uppercase">Seating Class</span>
                                            <h6 class="fw-bold mb-0">Economy (Corporate Negotiated UK)</h6>
                                       </div>
                                  </div>
                             </div>
                         </div>
                    </div>
                </div>

                <!-- Approval Lifecycle Timeline -->
                <div class="col-xl-4 sticky-top" style="top: 100px; height: fit-content;">
                     <div class="card border-0 shadow-sm rounded-5 bg-white p-5 animate-up delay-1">
                         <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4">Lifecycle Dashboard</h6>
                         <div class="d-flex flex-column gap-5 mt-4">
                             <div class="d-flex gap-4">
                                  <div class="bg-green text-white rounded-circle p-2 px-3 fw-900 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="fas fa-check"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">Request Submitted</h6>
                                       <p class="x-small text-muted mb-0">Flow initiated successfully by Employee.</p>
                                       <span class="x-small opacity-30 fw-bold d-block mt-1 uppercase">01 APR, 12:45 PM</span>
                                  </div>
                             </div>
                             <div class="d-flex gap-4 opacity-50">
                                  <div class="bg-light text-navy rounded-circle p-2 px-3 fw-900 d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;"><i class="fas fa-user-shield h4 mb-0 opacity-20"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">Admin Verification</h6>
                                       <p class="x-small text-muted mb-0">Verification by Finance/Travel Manager.</p>
                                       <span class="x-small opacity-30 fw-bold d-block mt-1 uppercase">PENDING</span>
                                  </div>
                             </div>
                             <div class="d-flex gap-4 opacity-50">
                                  <div class="bg-light text-navy rounded-circle p-2 px-3 fw-900 d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;"><i class="fas fa-plane-arrival h4 mb-0 opacity-20"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">Ticketing via GDS</h6>
                                       <p class="x-small text-muted mb-0">PNR issuance and itinerary download.</p>
                                       <span class="x-small opacity-30 fw-bold d-block mt-1 uppercase">NOT STARTED</span>
                                  </div>
                             </div>
                         </div>

                         <div class="mt-5 border-top border-light pt-4 text-center">
                              <p class="x-small text-muted fw-bold mb-0">Need urgent approval? Contact your <br><span class="text-primary text-decoration-none">Travel Administrator Hub</span>.</p>
                         </div>
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
    .bg-light { background: #f8f9fa !important; }
    .bg-primary { background: #1a73e8 !important; }
    .bg-green { background: #10b981 !important; }
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .border-white-subtle { border-color: rgba(255,255,255,0.1) !important; }
    .border-dashed { border-style: dashed !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .shadow-2 { box-shadow: 0 20px 40px rgba(0, 31, 63, 0.15); }
    .delay-1 { animation-delay: 0.1s; }
</style>
@endsection

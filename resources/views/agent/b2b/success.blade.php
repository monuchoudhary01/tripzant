@extends('layouts.app')

@section('title', "Booking Confirmed — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="search" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid text-center">
            <!-- Success Animation / Alert -->
            <div class="mb-5 animate-up">
                 <div class="success-icon bg-green text-white rounded-circle shadow-lg mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 48px;"><i class="fas fa-check"></i></div>
                 <h1 class="fw-900 text-navy mb-2">Ticketing Completed!</h1>
                 <p class="text-muted small fw-bold mb-0 opacity-75 uppercase tracking-widest">PNR: <span class="text-navy fw-900">RT882P</span> | Amadeus GDS Node A1</p>
            </div>

            <!-- E-Ticket Card -->
            <div class="e-ticket-card bg-white rounded-5 shadow-lg border-0 p-0 mx-auto text-start overflow-hidden position-relative mb-5" style="max-width: 900px; animate-up delay-1">
                 <div class="ticket-header bg-navy p-5 text-white d-flex justify-content-between align-items-center">
                     <div class="d-flex align-items-center gap-4">
                         <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/IndiGo_Airlines_logo.svg" height="40" class="brightness-0 invert" alt="">
                         <div class="ps-4 border-start border-white-subtle">
                             <h4 class="fw-900 mb-0">IndiGo Airlines</h4>
                             <span class="x-small opacity-75 fw-bold uppercase">PNR: RT882P</span>
                         </div>
                     </div>
                     <div class="text-end">
                         <span class="badge bg-green-subtle text-green rounded-pill px-4 py-2 x-small fw-bold uppercase">CONFIRMED (B2B NET)</span>
                     </div>
                 </div>
                 
                 <div class="ticket-body p-5">
                      <div class="row g-5 mb-5 align-items-center">
                          <div class="col-md-4">
                              <h3 class="fw-900 text-navy mb-1" style="font-size: 32px;">06:15</h3>
                              <span class="h6 fw-bold text-muted d-block uppercase tracking-tighter">DEL | NEW DELHI</span>
                              <span class="x-small fw-bold mt-2 pt-2 d-block text-primary">18 APRIL, 2026</span>
                          </div>
                          <div class="col-md-4 text-center">
                               <div class="small fw-bold text-muted mb-2">2h 15m (Non-Stop)</div>
                               <div class="d-flex align-items-center justify-content-center gap-3">
                                   <div class="line flex-grow-1 bg-light" style="height: 1px;"></div>
                                   <i class="fas fa-plane text-navy"></i>
                                   <div class="line flex-grow-1 bg-light" style="height: 1px;"></div>
                               </div>
                               <span class="x-small fw-bold text-navy uppercase mt-2 d-block">IndiGo 6E-242 (Economy)</span>
                          </div>
                          <div class="col-md-4 text-end">
                              <h3 class="fw-900 text-navy mb-1" style="font-size: 32px;">08:30</h3>
                              <span class="h6 fw-bold text-muted d-block uppercase tracking-tighter">BOM | MUMBAI</span>
                              <span class="x-small fw-bold mt-2 pt-2 d-block text-primary">SAME DAY ARRIVAL</span>
                          </div>
                      </div>

                      <div class="p-4 bg-light rounded-4 d-flex justify-content-between align-items-center mb-5 border border-dashed border-primary">
                          <div class="d-flex align-items-center gap-4">
                              <div class="avatar bg-white border rounded-circle shadow-sm p-3 fw-900 text-navy d-flex align-items-center justify-content-center" style="width:50px; height:50px;">RP</div>
                              <div>
                                  <h6 class="fw-900 text-navy mb-1 uppercase">Rohit Sharma</h6>
                                  <span class="x-small text-muted fw-bold">E-TICKET NO: 6E-20260406-882P</span>
                              </div>
                          </div>
                          <div class="text-end border-start border-white-subtle ps-5">
                              <span class="x-small fw-bold text-muted d-block mb-1">Status:</span>
                              <span class="badge bg-green text-white x-small fw-bold rounded-pill">TICKETED</span>
                          </div>
                      </div>

                      <div class="d-flex justify-content-between align-items-center">
                           <div class="qr-placeholder d-flex align-items-center gap-4 bg-light p-3 rounded-4">
                                <div class="bg-white p-2 rounded-3 border"><i class="fas fa-qrcode text-navy" style="font-size: 32px;"></i></div>
                                <div>
                                     <h6 class="fw-900 text-navy x-small mb-1 uppercase">Contactless Check-In</h6>
                                     <p class="x-small text-muted mb-0 opacity-75">Scan QR at Airport Self-Checkin Kiosk</p>
                                </div>
                           </div>
                           <div class="d-flex gap-3">
                                <button class="btn btn-outline-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm"><i class="fas fa-print me-2"></i> Print Ticket</button>
                                <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-lg"><i class="fas fa-download me-2"></i> Download E-Ticket PDF</button>
                           </div>
                      </div>
                 </div>
                 <div style="position:absolute; right: -50px; bottom: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(11,61,97,0.03) 0%, transparent 70%); border-radius: 50%;"></div>
            </div>

            <!-- Follow-up Options -->
            <div class="mt-5 pt-3 animate-up delay-2">
                 <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide opacity-50">Post-Booking Management</h6>
                 <div class="d-flex justify-content-center gap-4">
                      <a href="{{ route('agent.b2b.index') }}" class="btn btn-light rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">GO TO DASHBOARD</a>
                      <a href="{{ route('agent.b2b.search') }}" class="btn btn-light rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">BOOK ANOTHER FLIGHT</a>
                      <a href="{{ route('agent.b2b.bookings') }}" class="btn btn-light rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">MANAGE ALL BOOKINGS</a>
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
    .bg-green { background: #10b981 !important; }
    .text-green { color: #10b981 !important; }
    .bg-green-subtle { background: rgba(16, 185, 129, 0.1); }
    .brightness-0 { filter: brightness(0); }
    .invert { filter: invert(1); }
    .border-dashed { border-style: dashed !important; }
    .border-white-subtle { border-color: rgba(255,255,255,0.1) !important; }

    .animate-up { animation: slideInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
</style>
@endsection

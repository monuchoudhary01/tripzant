@extends('layouts.app')

@section('title', "Review Booking — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="search" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 border-bottom pb-4">
                 <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Step 4: Final Review & PNR Generation</h2>
                 <p class="text-muted small fw-bold mb-0 opacity-75">Reviewing your B2B Net Fare before deducting wallet balance.</p>
            </div>

            <div class="row g-5">
                <div class="col-xl-8">
                    <!-- Ticket Review Card -->
                    <div class="bg-navy text-white rounded-5 p-5 shadow-lg position-relative overflow-hidden mb-5 animate-up">
                         <div class="position-relative" style="z-index: 2;">
                             <div class="d-flex justify-content-between align-items-center mb-5">
                                 <h6 class="fw-900 uppercase tracking-widest opacity-75 mb-0">TRIPZANT B2B AIRLINE PASS</h6>
                                 <span class="badge bg-white-subtle text-white rounded-pill px-4 py-2 x-small fw-bold">Amadeus GDS Node A1</span>
                             </div>
                             
                             <div class="row g-5 align-items-center mb-5">
                                 <div class="col-md-4">
                                     <h3 class="fw-900 mb-1">06:15</h3>
                                     <span class="h6 fw-bold opacity-75 d-block">DEL (New Delhi)</span>
                                     <span class="x-small fw-bold border-top mt-2 pt-2 d-block">18 APR, 2026</span>
                                 </div>
                                 <div class="col-md-4 text-center">
                                      <div class="small fw-bold mb-2 opacity-50">2h 15m Duration</div>
                                      <div class="d-flex align-items-center justify-content-center gap-3">
                                          <div class="line flex-grow-1 bg-white-subtle" style="height: 1px;"></div>
                                          <i class="fas fa-plane text-warning"></i>
                                          <div class="line flex-grow-1 bg-white-subtle" style="height: 1px;"></div>
                                      </div>
                                      <span class="x-small fw-bold text-warning uppercase mt-2 d-block">IndiGo 6E-242</span>
                                 </div>
                                 <div class="col-md-4 text-end">
                                     <h3 class="fw-900 mb-1">08:30</h3>
                                     <span class="h6 fw-bold opacity-75 d-block">BOM (Mumbai)</span>
                                     <span class="x-small fw-bold border-top mt-2 pt-2 d-block">ARRIVING SAME DAY</span>
                                 </div>
                             </div>

                             <div class="p-4 bg-white-subtle rounded-4 d-flex justify-content-between align-items-center border border-white-subtle">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white text-navy rounded-circle p-2 px-3 fw-900">RP</div>
                                     <div>
                                         <h6 class="fw-900 mb-0 small uppercase">Rohit Sharma</h6>
                                         <span class="x-small opacity-75 fw-bold">ADULT | ECONOMY | VEG MEAL</span>
                                     </div>
                                 </div>
                                 <div class="text-end">
                                     <span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold uppercase">Ready For Ticketing</span>
                                 </div>
                             </div>
                         </div>
                         <div style="position:absolute; right:-30px; bottom:-30px; width:200px; height:200px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                    </div>

                    <!-- PNR Rules / Notes -->
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 border-start border-primary border-5">
                         <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide">Important GDS Disclaimers</h6>
                         <ul class="d-flex flex-column gap-3 small fw-bold text-muted p-0 m-0" style="list-style: none;">
                             <li><i class="fas fa-check-circle text-primary me-2"></i> PNR will be generated instantly upon wallet deduction.</li>
                             <li><i class="fas fa-check-circle text-primary me-2"></i> Tickets are usually Non-Refundable (as per B2B Net Fare conditions).</li>
                             <li><i class="fas fa-check-circle text-primary me-2"></i> Ensure passenger name exactly matches the government ID / Passport.</li>
                             <li><i class="fas fa-check-circle text-primary me-2"></i> Standard baggage weight: 15KG Check-in + 7KG Hand baggage.</li>
                         </ul>
                    </div>
                </div>

                <div class="col-xl-4 sticky-top" style="top: 100px; height: fit-content;">
                    <!-- Price / Wallet Logic -->
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 overflow-hidden">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Final Ledger Breakdown</h6>
                        
                        <div class="d-flex flex-column gap-4 border-bottom border-light pb-5 mb-5">
                             <div class="d-flex justify-content-between">
                                 <span class="small fw-bold text-muted">B2B Net Fare (Base)</span>
                                 <span class="small fw-900 text-navy">₹{{ number_format(request('net_fare', 5000)) }}</span>
                             </div>
                             <div class="d-flex justify-content-between">
                                 <span class="small fw-bold text-muted">Agent Margin Setup</span>
                                 <span class="small fw-900 text-primary">+ ₹{{ number_format(request('margin', 500)) }}</span>
                             </div>
                             <div class="d-flex justify-content-between pt-2 border-top border-light">
                                 <h6 class="fw-900 text-navy uppercase mb-0">Selling Price Total</h6>
                                 <h6 class="fw-900 text-navy mb-0">₹{{ number_format(intval(request('net_fare', 5000)) + intval(request('margin', 500))) }}</h6>
                             </div>
                        </div>

                        <!-- Wallet Check UI -->
                        <div class="wallet-check-box p-4 rounded-5 bg-light mb-5 border-dashed border-primary border-2 text-center animate-pulse">
                            <span class="x-small fw-900 text-muted uppercase d-block mb-3">Live Wallet Authorization</span>
                            <h4 class="fw-900 text-navy mb-2">₹{{ number_format($wallet->balance) ?? 0 }}</h4>
                            <p class="x-small text-muted fw-bold mb-0 opacity-75">CURRENT BALANCE IN YOUR WALLET</p>
                            
                            @if(($wallet->balance ?? 0) < intval(request('net_fare', 5000)))
                            <div class="alert alert-danger mt-4 rounded-4 border-0 mb-0 d-flex flex-column align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span class="x-small fw-900 uppercase">Insufficient Wallet Funds</span>
                                <a href="{{ route('agent.b2b.wallet.add') }}" class="btn btn-danger btn-sm rounded-pill fw-bold x-small py-2 px-4 shadow-sm w-100 mt-2 uppercase">RECHARGE NOW</a>
                            </div>
                            @else
                            <div class="alert alert-success mt-4 rounded-4 border-0 mb-0 d-flex align-items-center gap-3 py-2">
                                <i class="fas fa-check-shield"></i>
                                <span class="x-small fw-900 uppercase tracking-tighter">Funds Verified & Active</span>
                            </div>
                            @endif
                        </div>

                        <!-- Issuance Button -->
                        <form action="{{ route('agent.b2b.issue-ticket') }}" method="POST">
                            @csrf
                            <input type="hidden" name="net_fare" value="{{ request('net_fare', 5000) }}">
                            <input type="hidden" name="flight_code" value="{{ request('flight_code', '6E-242') }}">
                            <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-lg" {{ ($wallet->balance ?? 0) < intval(request('net_fare', 5000)) ? 'disabled' : '' }}>ISSUE FINAL TICKET <i class="fas fa-bolt ms-2 text-warning"></i></button>
                        </form>
                        <p class="text-center x-small text-muted mt-4 mb-0 italic">Payment processed directly from your B2B Wallet balance. <span class="fw-900">PNR is non-reversible.</span></p>
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
    .btn-outline-navy { border: 1px solid #001f3f; color: #001f3f; }
    .btn-outline-navy:hover { background: #001f3f; color: #fff; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(0.98); } 100% { transform: scale(1); } }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981; }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

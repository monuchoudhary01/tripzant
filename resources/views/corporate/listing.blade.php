@extends('layouts.app')

@section('title', "Corporate Flight Availability — Tripzant")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f1f5f9; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="employee" active="search" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Flight Search Summary Bar -->
            <div class="bg-navy text-white rounded-5 p-4 py-3 mb-5 shadow-lg d-flex justify-content-between align-items-center animate-up">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white-subtle rounded-4 p-2 px-3 text-center">
                        <span class="d-block x-small uppercase fw-bold opacity-75">DEL</span>
                        <span class="fw-900 border-bottom border-light">Delhi</span>
                    </div>
                    <i class="fas fa-exchange-alt"></i>
                    <div class="bg-white-subtle rounded-4 p-2 px-3 text-center">
                        <span class="d-block x-small uppercase fw-bold opacity-75">BOM</span>
                        <span class="fw-900 border-bottom border-light">Mumbai</span>
                    </div>
                    <div class="ms-4 border-start border-light border-2 ps-4 py-1">
                        <span class="d-block x-small uppercase fw-bold opacity-75">22 MAY, 2026</span>
                        <span class="fw-900">1 Adult, Economy</span>
                    </div>
                </div>
                <button class="btn btn-warning rounded-pill x-small fw-900 px-4 py-2 uppercase shadow-sm" onclick="history.back()">EDIT SEARCH <i class="fas fa-search ms-1"></i></button>
            </div>

            <!-- Corporate Policy Warning (Mock) -->
            <div class="alert bg-blue-subtle text-blue rounded-5 p-4 mb-5 border-dashed border-primary border-2 d-flex align-items-center gap-4 animate-up">
                 <div class="bg-blue-light rounded-circle p-3 text-center d-flex align-items-center justify-content-center shadow-none" style="width: 50px; height: 50px;"><i class="fas fa-info-circle h4 mb-0"></i></div>
                 <div class="flex-grow-1">
                      <h6 class="fw-900 mb-1 small uppercase">Corporate Travel Policy Active</h6>
                      <p class="x-small mb-0 opacity-75">Your organization limits domestic flights to ₹10,000. Bookings above this will require multi-level approval from Rahul Khanna (Finance Manager).</p>
                 </div>
            </div>

            <!-- Main Results Column -->
            <div class="row g-5 mt-4">
                <div class="col-xl-9">
                    <div class="d-flex flex-column gap-4">
                       @php
                       $flights = [
                           ['airline' => 'IndiGo', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/af/IndiGo_Airlines_logo.svg', 'dep' => '07:15', 'arr' => '09:30', 'net' => 4820, 'type' => 'CORP_FARE', 'benefit' => 'Free Seat + Meal'],
                           ['airline' => 'Air India', 'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/30/Air_India_Logo.svg/1200px-Air_India_Logo.svg.png', 'dep' => '10:00', 'arr' => '12:15', 'net' => 5400, 'type' => 'SAVER', 'benefit' => 'Regular Fare'],
                           ['airline' => 'Vistara', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Vistara_Logo.svg', 'dep' => '15:30', 'arr' => '17:45', 'net' => 6100, 'type' => 'CORP_FARE', 'benefit' => 'Zero Date Change Fees'],
                       ];
                       @endphp

                       @foreach($flights as $f)
                       <div class="flight-card bg-white rounded-5 shadow-sm p-5 border-0 transition-all hover-up-md">
                            <div class="row align-items-center g-4">
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <img src="{{ $f['logo'] }}" height="28" class="mb-3 opacity-75" alt="">
                                        <h6 class="fw-900 text-navy mb-0 small">{{ $f['airline'] }}</h6>
                                        <span class="x-small text-muted fw-bold opacity-75">{{ $f['type'] == 'CORP_FARE' ? 'Corporate Fare' : 'B2C Saver' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between align-items-center text-center px-4">
                                        <div>
                                            <h4 class="fw-900 text-navy mb-1">{{ $f['dep'] }}</h4>
                                            <span class="x-small text-muted fw-bold uppercase">DEL</span>
                                        </div>
                                        <div class="flex-grow-1 px-4 text-center">
                                            <div class="small fw-bold text-muted mb-2 opacity-50">2h 15m</div>
                                            <div class="timeline-line bg-light position-relative" style="height:2px; width:100%;">
                                                <div class="dot bg-navy rounded-circle" style="width:8px; height:8px; top:-3px; left:0; position:absolute;"></div>
                                                <i class="fas fa-plane text-navy" style="position:relative; top:-10px;"></i>
                                                <div class="dot bg-navy rounded-circle" style="width:8px; height:8px; top:-3px; right:0; position:absolute;"></div>
                                            </div>
                                            <div class="x-small text-green fw-bold mt-2 uppercase tracking-wide">In-Policy <i class="fas fa-check-circle ms-1"></i></div>
                                        </div>
                                        <div>
                                            <h4 class="fw-900 text-navy mb-1">{{ $f['arr'] }}</h4>
                                            <span class="x-small text-muted fw-bold uppercase">BOM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 border-start border-light ps-5 text-center">
                                    <h3 class="fw-900 text-navy mb-1">₹{{ number_format($f['net']) }}</h3>
                                    <span class="x-small text-primary fw-900 uppercase d-block mb-2">{{ $f['benefit'] }}</span>
                                    @if($f['type'] == 'CORP_FARE')
                                         <span class="badge bg-green-subtle text-green px-3 py-1 rounded-pill x-small fw-bold border">LCL: LOWEST CORP LIMIT</span>
                                    @endif
                                </div>
                                <div class="col-md-2 text-end">
                                    <form action="{{ route('corporate.booking.submit-request') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="flight_id" value="123">
                                        <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-sm">REQUEST FLOW <i class="fas fa-paper-plane ms-1"></i></button>
                                    </form>
                                    <div class="mt-3 text-center">
                                         <a href="#" class="x-small text-muted text-decoration-none border-bottom">Fare Rules</a>
                                    </div>
                                </div>
                            </div>
                       </div>
                       @endforeach
                    </div>
                </div>

                <div class="col-xl-3">
                     <div class="card border-0 shadow-sm rounded-5 bg-white p-5 sticky-top" style="top: 100px;">
                         <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4">Trip Policy Guard</h6>
                         <div class="d-flex flex-column gap-5 mt-4">
                             <div class="policy-item d-flex gap-4">
                                  <div class="bg-blue-light text-blue rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-layer-group h4 mb-0"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">Fare Class</h6>
                                       <p class="x-small text-muted mb-0">ECONOMY CLASS ONLY (IN POLICY)</p>
                                  </div>
                             </div>
                             <div class="policy-item d-flex gap-4">
                                  <div class="bg-green-light text-green rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-shield-alt h4 mb-0"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">Negotiated Fares</h6>
                                       <p class="x-small text-muted mb-0">Exclusive airline accords are active on UK/AI.</p>
                                  </div>
                             </div>
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
    .bg-blue-subtle { background: #eff6ff; color: #2563eb; }
    .bg-blue-light { background: rgba(37, 99, 235, 0.05); }
    .flight-card:hover { transform: translateY(-8px); shadow: 0 20px 40px rgba(0, 31, 63, 0.05); }
    .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .border-dashed { border-style: dashed !important; }
    .hover-up-md:hover { transform: translateY(-10px); }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
</style>
@endsection

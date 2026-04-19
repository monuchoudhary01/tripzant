@extends('layouts.app')

@section('title', "My B2B Global Deals | Trip Zant Agent")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .deal-card { background: #fff; border-radius: 24px; padding: 30px; border: 1px solid #edf2f7; transition: 0.3s; }
    .deal-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
    .agreement-badge { background: #f7fafc; color: #4a5568; font-weight: 800; font-size: 10px; padding: 4px 12px; border-radius: 8px; border: 1px solid #edf2f7; }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f7fafc; min-height: 95vh;">
    <div class="container container-fluid">
        <!-- Dashboard Header -->
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <a href="{{ route('agent.dashboard') }}" class="text-decoration-none small fw-bold text-muted uppercase"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
                <h2 class="fw-900 text-dark mb-0 mt-2">B2B Global Deal Flow Management</h2>
                <p class="text-muted small fw-bold mb-0">Coordinate international ticketing and finalize profit-sharing agreements.</p>
            </div>
            <div class="text-end">
                <div class="small fw-bold text-muted mb-1 uppercase">Active Deal Potential</div>
                <div class="badge bg-primary text-white px-4 py-2 rounded-pill fw-900 fs-5 shadow-lg">₹12,48,500.00</div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Summary Stats -->
            <div class="col-md-3">
                <div class="deal-card text-center">
                    <div class="h3 fw-900 text-dark mb-1">12</div>
                    <div class="x-small fw-900 text-muted uppercase">ACTIVE DEALS</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="deal-card text-center">
                    <div class="h3 fw-900 text-primary mb-1">₹8,400</div>
                    <div class="x-small fw-900 text-muted uppercase">AVERAGE PROFIT / PKG</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="deal-card text-center">
                    <div class="h3 fw-900 text-warning mb-1">4</div>
                    <div class="x-small fw-900 text-muted uppercase">PENDING AGREEMENTS</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="deal-card text-center">
                    <div class="h3 fw-900 text-success mb-1">124</div>
                    <div class="x-small fw-900 text-muted uppercase">SETTLED TICKETS</div>
                </div>
            </div>

            <!-- Main Deals Feed -->
            <div class="col-lg-12 mt-5">
                <h6 class="fw-900 text-dark mb-4 ls-1"><i class="fas fa-file-contract me-2 text-primary"></i> Active B2B Agreements & Coordination</h6>
                
                <div class="row g-4">
                    @php
                    $deals = [
                        ['id' => 'DEAL-8821', 'partner' => 'Dubai Skyline (IATA: 882045)', 'route' => 'Delhi → Dubai', 'pax' => 42, 'fare' => '₹7,80,000', 'profit' => '₹12,000', 'split' => '60/40', 'status' => 'PENDING AGREEMENT'],
                        ['id' => 'DEAL-9920', 'partner' => 'London Tube (IATA: 120224)', 'route' => 'Mumbai → London', 'pax' => 15, 'fare' => '₹12,40,000', 'profit' => '₹45,000', 'split' => '50/50', 'status' => 'ACCEPTED ✅'],
                        ['id' => 'DEAL-1022', 'partner' => 'Singapore Wings (IATA: 332115)', 'route' => 'Bangalore → Singapore', 'pax' => 4, 'fare' => '₹1,94,200', 'profit' => '₹8,000', 'split' => '70/30', 'status' => 'DRAFT'],
                    ];
                    @endphp
                    @foreach($deals as $d)
                    <div class="col-md-12">
                        <div class="deal-card p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="x-small fw-900 text-primary mb-1 uppercase">{{ $d['id'] }}</div>
                                    <h6 class="fw-900 text-dark mb-1">{{ $d['route'] }}</h6>
                                    <div class="x-small fw-bold text-muted">{{ $d['partner'] }}</div>
                                </div>
                                <div class="col-md-2 text-center border-start border-end border-light">
                                    <div class="x-small fw-900 text-muted uppercase mb-1">PASSENGERS</div>
                                    <div class="badge bg-navy text-white rounded-pill x-small px-3 fw-900">{{ $d['pax'] }} PAX</div>
                                </div>
                                <div class="col-md-3 text-center border-end border-light">
                                    <div class="x-small fw-900 text-muted uppercase mb-1">PROFIT SPLIT ({{ $d['split'] }})</div>
                                    <div class="d-flex justify-content-center gap-2 align-items-center">
                                        <div class="p-2 bg-success-subtle text-success rounded-3 small fw-900 shadow-sm">+{{ $d['profit'] }}</div>
                                        <i class="fas fa-arrow-right-arrow-left text-muted opacity-50 x-small"></i>
                                        <span class="x-small fw-bold text-muted">PARTNER SHARE</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="mb-3">
                                        <span class="agreement-badge {{ $d['status'] == 'ACCEPTED ✅' ? 'text-success border-success bg-success-subtle' : '' }} uppercase">{{ $d['status'] }}</span>
                                    </div>
                                    @if($d['status'] == 'PENDING AGREEMENT')
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-navy btn-sm rounded-pill px-4 fw-900 small shadow-sm" style="background:#1a202c; color:#fff;" data-bs-toggle="modal" data-bs-target="#agreementModal">REVIEW & ACCEPT</button>
                                        <button class="btn btn-outline-danger btn-sm rounded-pill fw-900 small shadow-sm px-3">REJECT</button>
                                    </div>
                                    @elseif($d['status'] == 'ACCEPTED ✅')
                                    <div class="d-flex gap-2 justify-content-end">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-900 small border-2" data-bs-toggle="dropdown">
                                                <i class="fas fa-tools me-1"></i> MODIFY
                                            </button>
                                            <ul class="dropdown-menu border-0 shadow-sm rounded-3">
                                                <li><a class="dropdown-item x-small fw-bold" href="#"><i class="fas fa-calendar-alt me-2 text-primary"></i> REBOOK DATE</a></li>
                                                <li><a class="dropdown-item x-small fw-bold" href="#"><i class="fas fa-user-edit me-2 text-warning"></i> CHANGE NAMES</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item x-small fw-bold text-danger" href="#"><i class="fas fa-times-circle me-2"></i> CANCEL BOOKING</a></li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-navy btn-sm rounded-pill px-4 fw-900 small shadow-sm" style="background:#1a202c; color:#fff;">
                                            <i class="fas fa-ticket me-1 text-primary"></i> ISSUE TICKETS
                                        </button>
                                    </div>
                                    @else
                                    <button class="btn btn-primary btn-sm rounded-pill px-4 fw-900 small shadow-sm">RESUME DRAFT</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agreement & Split Review Modal -->
<div class="modal fade" id="agreementModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
            <div class="modal-body p-0" id="agreementBody">
                <div class="row g-0">
                    <div class="col-lg-5 p-5 bg-dark text-white d-flex flex-column justify-content-center text-center position-relative">
                        <div id="signaturePreview" class="d-none animate__animated animate__fadeIn">
                            <div class="mb-4">
                                <div class="badge bg-success rounded-pill px-3 py-1 x-small mb-3">SIGNED & VERIFIED</div>
                                <div class="display-1 text-white opacity-25"><i class="fas fa-stamp"></i></div>
                            </div>
                            <div class="h3 fw-900 text-white mb-0" style="font-family: 'Dancing Script', cursive; font-size: 40px;">Indus Travels</div>
                            <div class="x-small opacity-50 mt-2">D-ID: {{ time() }}</div>
                        </div>

                        <div id="agreementInitial">
                            <i class="fas fa-file-signature display-2 mb-4 text-primary opacity-50"></i>
                            <h4 class="fw-900 mb-2">B2B PROFIT AGREEMENT</h4>
                            <p class="small opacity-75 mb-0 fw-bold uppercase ls-1">Agreement ID: AG-8821-MMT</p>
                        </div>
                    </div>
                    <div class="col-lg-7 p-5 bg-white">
                        <h6 class="fw-900 text-dark mb-4 ls-1">Deal Finalization Details</h6>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-muted">Total Booking Price:</span>
                                <span class="small fw-900 text-dark">₹7,80,000.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                <span class="small fw-bold text-muted">Total Deal Profit:</span>
                                <span class="small fw-900 text-navy">₹10,000.00</span>
                            </div>
                            <div class="d-flex justify-content-between mt-3 bg-success-subtle p-3 rounded-4">
                                <div>
                                    <div class="x-small fw-900 text-success uppercase">YOUR SHARE (60%)</div>
                                    <div class="h4 fw-900 text-success mb-0">₹6,000</div>
                                </div>
                                <div class="text-end">
                                    <div class="x-small fw-900 text-muted uppercase">PARTNER (40%)</div>
                                    <div class="h4 fw-900 text-muted mb-0">₹4,000</div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="signatureZone" class="mb-4 d-none animate__animated animate__fadeInUp">
                            <label class="form-label x-small fw-900 text-navy uppercase mb-2">Authenticated Signature Pad</label>
                            <div class="p-3 border rounded-4 bg-light text-center" style="border-style: dashed !important; border-width: 2px !important;">
                                <div class="p-3 bg-white rounded-3 shadow-sm" style="font-family: 'Dancing Script', cursive; font-size: 28px; color: #1a202c;">
                                    Indus Travels
                                </div>
                                <p class="x-small fw-bold text-muted mt-2 mb-0">Electronic Signature Applied Automatically</p>
                            </div>
                        </div>

                        <div class="d-grid gap-2" id="actionZone">
                            <button id="signBtn" class="btn btn-navy py-3 rounded-pill fw-900 shadow-sm" style="background:#1a202c; color:#fff;" onclick="startSigning()">SIGN & FINALIZE DEAL</button>
                            <button class="btn btn-outline-dark py-2 rounded-pill fw-900 small shadow-sm" data-bs-dismiss="modal">DISPUTE / NEED CHANGES</button>
                        </div>

                        <div id="successZone" class="d-none animate__animated animate__zoomIn">
                            <div class="text-center p-4">
                                <i class="fas fa-check-circle text-success display-4 mb-3"></i>
                                <h5 class="fw-900 text-dark">Agreement Finalized!</h5>
                                <p class="small text-muted fw-bold mb-4">Tickets will be issued by partner within 30 minutes.</p>
                                <button class="btn btn-navy w-100 rounded-pill py-3 fw-900" style="background:#1a202c; color:#fff;" data-bs-dismiss="modal">CLOSE PANEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

<script>
function startSigning() {
    const signBtn = document.getElementById('signBtn');
    signBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> AUTHENTICATING IATA ID...';
    
    setTimeout(() => {
        document.getElementById('signatureZone').classList.remove('d-none');
        document.getElementById('actionZone').classList.add('d-none');
        document.getElementById('agreementInitial').classList.add('d-none');
        document.getElementById('signaturePreview').classList.remove('d-none');
        
        setTimeout(() => {
            document.getElementById('signatureZone').classList.add('d-none');
            document.getElementById('successZone').classList.remove('d-none');
        }, 2000);
    }, 1500);
}
</script>
@endsection

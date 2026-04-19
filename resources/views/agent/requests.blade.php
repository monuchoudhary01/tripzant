@extends('layouts.app')

@section('title', "Consolidator Ticket Requests | IATA Main Portal")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .nav-link-agent {
        display: flex; align-items: center; gap: 12px; padding: 15px 20px; border-radius: 12px; 
        color: #4a5568; text-decoration: none; font-weight: 800; font-size: 13px; transition: 0.3s;
    }
    .nav-link-agent:hover, .nav-link-agent.active { background: #3182ce15; color: #3182ce; }
    .nav-link-agent.active { border-left: 4px solid #3182ce; }
    
    .request-card { background: #fff; border-radius: 24px; padding: 30px; border: 1px solid #edf2f7; transition: 0.3s; }
    .request-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,0.05); }
    .side-border-info { border-left: 6px solid #0891b2; }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f7fafc; min-height: 95vh;">
    <div class="container container-fluid">
        <div class="row g-4">
            <!-- Sidebar (IATA Principal) -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="mb-4 pb-4 border-bottom border-light text-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-900 shadow-lg mx-auto mb-3" style="width: 60px; height: 60px;">IP</div>
                        <h6 class="fw-900 text-dark mb-1 small uppercase">Indus IATA Principal</h6>
                        <div class="badge bg-navy text-white rounded-pill x-small fw-bold px-3 py-1 mt-1">MAIN CONSOLIDATOR</div>
                    </div>
                    
                    <div class="sidebar-nav d-flex flex-column gap-1">
                        <a href="{{ route('agent.dashboard') }}" class="nav-link-agent"><i class="fas fa-th-large"></i> Dashboard Overview</a>
                        <a href="#" class="nav-link-agent active"><i class="fas fa-ticket-alt"></i> Sub-Agent Requests <span class="badge bg-danger rounded-pill ms-auto px-2">12</span></a>
                        <a href="{{ route('agent.network') }}" class="nav-link-agent"><i class="fas fa-globe-americas"></i> Partner Network</a>
                        <a href="{{ route('agent.connections') }}" class="nav-link-agent"><i class="fas fa-users"></i> Global Partners</a>
                        <a href="{{ route('agent.ticketing') }}" class="nav-link-agent"><i class="fas fa-plane"></i> Direct Ticketing</a>
                        <a href="{{ route('agent.transactions') }}" class="nav-link-agent"><i class="fas fa-file-invoice-dollar"></i> Settlements</a>
                        <hr class="opacity-10 my-3">
                        <a href="/" class="nav-link-agent text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>

            <!-- Requests Management Area -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <h2 class="fw-900 text-dark mb-1">Sub-Agent Issuance Queue</h2>
                        <p class="text-muted small fw-bold uppercase ls-1">Approve & Issue Tickets for Non-IATA Partners 🎫⚖️</p>
                    </div>
                    <div class="badge bg-white shadow-sm border rounded-pill px-4 py-3 text-dark fw-900 x-small uppercase ls-1">Auto-Queued: <span class="text-primary">GDS AMADEUS LIVE</span></div>
                </div>

                <!-- Sub-Agent Stats (Consolidator Perspective) -->
                <div class="row g-4 mb-5">
                    @foreach(['Awaiting Review' => 8, 'Issuance in Progress' => 4, 'Total Issued (Today)' => 142] as $label => $count)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                            <div class="x-small fw-900 text-muted uppercase mb-1">{{ $label }}</div>
                            <div class="h2 fw-900 text-dark mb-0">{{ $count }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Live Request Feed -->
                <h6 class="fw-900 text-dark mb-4 ls-1 uppercase shadow-sm d-inline-block px-3 py-1 bg-white rounded-pill">Incoming Ticketing Requests</h6>
                
                @php
                $requests = [
                    ['agency' => 'Global Travel Agency', 'pnr' => 'PNR-H88219', 'route' => 'DEL → DXB', 'fare' => '₹48,200', 'wallet' => '₹5,00,000', 'pax' => 'Rahul Singh', 'status' => 'PENDING'],
                    ['agency' => 'Elite Holidays', 'pnr' => 'PNR-X11442', 'route' => 'BOM → LHR', 'fare' => '₹82,400', 'wallet' => '₹24,000', 'pax' => 'John Doe', 'status' => 'INSUFFICIENT BALANCE ⚠️'],
                    ['agency' => 'Metro Travels', 'pnr' => 'PNR-Z99112', 'route' => 'BLR → SIN', 'fare' => '₹32,100', 'wallet' => '₹1,50,000', 'pax' => 'Sonia J.', 'status' => 'PENDING'],
                ];
                @endphp

                @foreach($requests as $r)
                <div class="request-card mb-4 side-border-info">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="x-small fw-900 text-info mb-1 uppercase ls-1">Sub-Agent Request</div>
                            <h6 class="fw-900 text-dark mb-1">{{ $r['agency'] }}</h6>
                            <div class="badge bg-light text-muted rounded-pill x-small px-3 fw-bold border">{{ $r['pnr'] }}</div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="x-small fw-900 text-muted uppercase mb-1">ROUTE | PAX</div>
                            <div class="small fw-900 text-dark">{{ $r['route'] }}</div>
                            <div class="x-small fw-bold text-muted">{{ $r['pax'] }}</div>
                        </div>
                        <div class="col-md-3 text-center border-start border-end border-light">
                            <div class="x-small fw-900 text-muted uppercase mb-1">FARE | WALLET</div>
                            <div class="small fw-900 text-navy">{{ $r['fare'] }}</div>
                            <div class="x-small fw-bold {{ str_contains($r['status'], '⚠️') ? 'text-danger' : 'text-success' }} ls-1">{{ $r['status'] == 'PENDING' ? 'Wallet: '.$r['wallet'] : $r['status'] }}</div>
                        </div>
                        <div class="col-md-3 text-end">
                            @if(str_contains($r['status'], '⚠️'))
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-900 small shadow-sm border-2 me-2">REJECT</button>
                            <button class="btn btn-navy btn-sm rounded-pill px-4 fw-900 small shadow-sm disabled text-white" style="background:#1a202c; color:#fff;">ISSUE TICKET</button>
                            @else
                            <button class="btn btn-navy btn-sm rounded-pill px-4 fw-900 small shadow-sm text-white" style="background:#1a202c; color:#fff;" data-bs-toggle="modal" data-bs-target="#issuanceModal">ISSUE TICKET</button>
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-900 small shadow-sm border-2 ms-2">REVIEW PNR</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Ticket Issuance Confirmation Modal -->
<div class="modal fade" id="issuanceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
            <div class="modal-body p-0" id="issuanceBody">
                <div class="row g-0">
                    <div class="col-lg-5 p-5 bg-navy text-white d-flex flex-column justify-content-center text-center position-relative" style="background: #1a202c;">
                        <i class="fas fa-ticket-alt display-1 mb-4 text-primary opacity-25"></i>
                        <h4 class="fw-900 mb-2">IATA TICKET ISSUANCE</h4>
                        <p class="small opacity-50 mb-0 fw-bold uppercase ls-1">Principal Authorization Required</p>
                    </div>
                    <div class="col-lg-7 p-5 bg-white">
                        <h6 class="fw-900 text-dark mb-4 ls-1">Issuance Finalization</h6>
                        
                        <div class="p-4 bg-light rounded-4 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="x-small fw-bold text-muted">Sub-Agent:</span>
                                <span class="x-small fw-900 text-dark">Global Travel Agency</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="x-small fw-bold text-muted">GDS PNR:</span>
                                <span class="x-small fw-900 text-info">H88219-DXB</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                <span class="small fw-bold text-dark">DEDUCT FROM WALLET:</span>
                                <span class="small fw-900 text-navy">₹48,200.00</span>
                            </div>
                        </div>

                        <div id="issuanceAction">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="verifyCheck" checked>
                                <label class="form-check-label x-small fw-bold text-muted" for="verifyCheck">I have verified the PNR fare rules and sub-agent credit status.</label>
                            </div>
                            <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 shadow-sm" onclick="processIssuance()">AUTHORIZE & ISSUE TICKET</button>
                        </div>

                        <!-- Success State (Hidden) -->
                        <div id="issuanceSuccess" class="d-none animate__animated animate__zoomIn text-center py-4">
                            <div class="badge bg-success rounded-pill px-4 py-2 fw-900 mb-4 ls-1">TICKETED SUCCESSFULLY ✅</div>
                            <h5 class="fw-900 text-dark">E-Ticket Generated!</h5>
                            <p class="small text-muted fw-bold mb-4">The PNR has been updated and the sub-agent wallet has been deducted.</p>
                            <button class="btn btn-navy w-100 py-3 rounded-pill fw-900 shadow-sm text-white" style="background:#1a202c;" data-bs-dismiss="modal">CLOSE PANEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function processIssuance() {
    const btn = document.querySelector('#issuanceAction button');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> CONNECTING TO AMADEUS GDS...';
    btn.classList.add('disabled');
    
    setTimeout(() => {
        document.getElementById('issuanceAction').classList.add('d-none');
        document.getElementById('issuanceSuccess').classList.remove('d-none');
    }, 2500);
}
</script>
@endsection

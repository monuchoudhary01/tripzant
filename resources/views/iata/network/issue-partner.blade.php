@extends('layouts.iata_panel')

@section('title', 'Collaborative Issuance | IATA Panel')

@section('iata_content')
<div class="row g-4 justify-content-center">
    <div class="col-xl-9">
        <div class="d-flex align-items-center gap-3 mb-5">
            <a href="{{ route('iata.flight.pnr-list') }}" class="btn btn-light rounded-circle shadow-sm" style="width: 45px; height: 45px; line-height: 31px;"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h4 class="fw-800 text-navy mb-0 outfit">Collaborative Ticket Issuance</h4>
                <p class="text-muted small fw-700 uppercase mb-0">Issue PNR <span class="text-primary">{{ $pnr }}</span> through a partner agent system.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- PNR Details Preview -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100">
                    <h6 class="fw-800 text-navy mb-4 outfit uppercase border-bottom pb-3">PNR Details</h6>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small fw-800 uppercase">Passenger</span>
                        <span class="fw-800 text-navy outfit">MR RAHUL SHARMA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small fw-800 uppercase">Route</span>
                        <span class="fw-800 text-navy outfit">DEL <i class="fas fa-arrow-right mx-1 text-primary"></i> BOM</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted small fw-800 uppercase">Flight</span>
                        <span class="fw-800 text-navy outfit">AI-102 | Economy</span>
                    </div>

                    <div class="bg-light p-4 rounded-4 text-center">
                        <div class="text-muted small fw-800 uppercase mb-1">Total Fare to Issue</div>
                        <div class="h3 fw-900 text-navy outfit mb-0">₹6,250</div>
                    </div>
                </div>
            </div>

            <!-- Partner Selection -->
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100">
                    <h6 class="fw-800 text-navy mb-4 outfit uppercase border-bottom pb-3">Select Authorized Partner Agent</h6>
                    
                    <div class="d-flex flex-column gap-3 mb-4">
                        @php
                        $partners = [
                            ['name' => 'Swift Wings India', 'id' => 'IATA-440292', 'split' => '60/40', 'balance' => '₹8.4L', 'signal' => 'green'],
                            ['name' => 'Royal Emirates Travel', 'id' => 'IATA-880112', 'split' => '₹500 Fixed', 'balance' => '₹1.2L', 'signal' => 'green'],
                            ['name' => 'London Global GDS', 'id' => 'IATA-998822', 'split' => '50/50', 'balance' => '₹0.0', 'signal' => 'red'],
                        ];
                        @endphp

                        @foreach($partners as $p)
                        <div class="partner-select-card p-3 rounded-4 border {{ $p['signal'] == 'red' ? 'opacity-50 pointer-events-none' : '' }}" onclick="selectPartner(this, '{{ $p['name'] }}', '{{ $p['split'] }}')">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        <div class="avatar bg-blue-soft rounded-circle d-flex align-items-center justify-content-center fw-800" style="width: 48px; height: 48px;">{{ substr($p['name'], 0, 1) }}</div>
                                        <span class="position-absolute bottom-0 end-0 p-1 border border-2 border-white rounded-circle {{ $p['signal'] == 'green' ? 'bg-success' : 'bg-danger' }}" style="width: 14px; height: 14px;"></span>
                                    </div>
                                    <div>
                                        <div class="fw-800 text-navy">{{ $p['name'] }}</div>
                                        <div class="x-small fw-700 text-primary">{{ $p['id'] }}</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="x-small fw-800 text-muted uppercase">Split Rule</div>
                                    <div class="small fw-900 text-success outfit">{{ $p['split'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div id="selectionPreview" class="d-none">
                        <div class="bg-blue-soft p-4 rounded-4 mb-4 border border-primary border-opacity-25 animate__animated animate__fadeIn">
                            <h6 class="fw-800 text-navy outfit mb-3">Issuance Summary via <span id="partnerName"></span></h6>
                            <div class="row small fw-700">
                                <div class="col-6 mb-2 text-muted">Estimated Profit:</div>
                                <div class="col-6 mb-2 text-end text-navy">₹1,500</div>
                                <div class="col-6 mb-2 text-muted">Your Share (60%):</div>
                                <div class="col-6 mb-2 text-end text-success">+₹900</div>
                                <div class="col-6 text-muted">Partner Share (40%):</div>
                                <div class="col-6 text-end text-primary">+₹600</div>
                            </div>
                        </div>
                        <button class="btn btn-iata w-100 py-3 outfit fw-800 rounded-pill shadow-lg" onclick="startIssuance(this)">
                            <i class="fas fa-check-circle me-2"></i> AUTHORIZE & ISSUE TICKET
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="collabSuccess" class="position-fixed top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center" style="background: rgba(15, 23, 42, 0.95); z-index: 9999;">
    <div class="card border-0 rounded-5 p-5 text-center bg-white shadow-lg animate__animated animate__zoomIn" style="max-width: 500px;">
        <div class="mb-5">
            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; border: 5px solid #dcfce7;">
                <i class="fas fa-handshake text-white fs-1"></i>
            </div>
        </div>
        <h2 class="fw-900 text-navy outfit mb-2">Collaboration Successful!</h2>
        <p class="text-muted fw-700 h5 mb-5 px-4">Ticket issued via <span class="text-primary" id="finalPartner">Partner</span>. Profit split has been auto-distributed to both wallets.</p>
        
        <div class="row g-3">
             <div class="col-6">
                 <div class="p-3 bg-light rounded-4">
                     <div class="x-small fw-800 text-muted uppercase">Ticket Issued</div>
                     <div class="fw-900 text-navy">{{ $pnr }}</div>
                 </div>
             </div>
             <div class="col-6">
                 <div class="p-3 bg-light rounded-4">
                     <div class="x-small fw-800 text-muted uppercase">Your Profit</div>
                     <div class="fw-900 text-success">+₹900</div>
                 </div>
             </div>
        </div>

        <div class="d-grid gap-3 mt-5">
            <button class="btn btn-iata py-3 outfit fw-800 rounded-pill">DOWNLOAD PARTNER INVOICE</button>
            <a href="{{ route('iata.network.profits') }}" class="btn btn-light py-3 border fw-800 rounded-pill">VIEW PROFIT SHARING DASHBOARD</a>
        </div>
    </div>
</div>

<script>
    function selectPartner(el, name, split) {
        document.querySelectorAll('.partner-select-card').forEach(c => c.classList.remove('active', 'border-primary'));
        el.classList.add('active', 'border-primary', 'bg-light');
        document.getElementById('selectionPreview').classList.remove('d-none');
        document.getElementById('partnerName').innerText = name;
        document.getElementById('finalPartner').innerText = name;
    }

    function startIssuance(btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i> VALIDATING PARTNER CREDIT...';
        
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-charging-station fa-fade me-2"></i> ISSUING TICKET VIA PARTNER GDS...';
            setTimeout(() => {
                document.getElementById('collabSuccess').classList.remove('d-none');
                document.getElementById('collabSuccess').classList.add('d-flex');
            }, 2000);
        }, 1500);
    }
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .partner-select-card { cursor: pointer; transition: 0.2s; border: 2px solid transparent; }
    .partner-select-card:hover { border-color: #e2e8f0; background: #f8fafc; }
    .partner-select-card.active { border-color: var(--iata-blue) !important; background: #f0f7ff !important; }
    .bg-blue-soft { background-color: #eff6ff; color: #1e40af; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

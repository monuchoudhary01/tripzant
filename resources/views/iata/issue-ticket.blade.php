@extends('layouts.iata_panel')

@section('title', 'Amadeus B2B | Final Ticket Issuance')

@section('iata_content')
<div class="row justify-content-center mb-5">
    <div class="col-xl-9">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h4 class="fw-800 text-navy mb-1 outfit">Review & Issue Ticket</h4>
                <p class="text-muted fw-700 mb-0">Agent ID: AT-992042 | Session expires in 12:45</p>
            </div>
            <div class="text-end">
                <div class="small fw-800 text-muted uppercase mb-1">Available Funds</div>
                <div class="h4 fw-900 text-success outfit mb-0">₹1,45,280.00</div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <!-- Payment Selection -->
                <div class="card border-0 shadow-sm rounded-4 bg-white p-5 border border-light mb-4">
                    <h6 class="fw-800 text-navy mb-4 outfit uppercase border-bottom pb-3">Select Payment Mode</h6>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="payment-card d-block cursor-pointer">
                                <input type="radio" name="payment_mode" class="d-none" checked>
                                <div class="p-4 border rounded-4 bg-light text-center transition-all h-100 position-relative border-2 border-primary">
                                    <div class="position-absolute top-0 end-0 p-2 text-primary"><i class="fas fa-check-circle"></i></div>
                                    <i class="fas fa-wallet fs-2 text-primary mb-3"></i>
                                    <div class="fw-800 text-navy">Agent Wallet</div>
                                    <div class="text-muted small fw-600">Deduct from ₹1.45L</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="payment-card d-block cursor-pointer">
                                <input type="radio" name="payment_mode" class="d-none">
                                <div class="p-4 border rounded-4 bg-light text-center transition-all h-100 opacity-50 border-2">
                                    <i class="fas fa-credit-card fs-2 text-muted mb-3"></i>
                                    <div class="fw-800 text-navy">Credit Limit</div>
                                    <div class="text-muted small fw-600">Bal: ₹5.0L</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 rounded-4 p-4 mb-4 small fw-600 text-navy bg-warning bg-opacity-10">
                         <i class="fas fa-info-circle me-2"></i> After clicking "Issue Ticket", the amount ₹6,050.00 will be instantly deducted from your agent wallet. This action cannot be reversed.
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="termsCheck" checked>
                        <label class="form-check-label x-small fw-700 text-muted" for="termsCheck">
                            I agree to the airline fare rules, cancellation policies, and Amadeus GDS terms of service.
                        </label>
                    </div>

                    <button class="btn btn-iata w-100 py-4 outfit fs-4 rounded-4 shadow-lg mb-3" id="btnIssue" onclick="simulateIssuance()">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                             <i class="fas fa-print"></i>
                             <span>GENERATE PNR & ISSUE TICKET</span>
                        </div>
                    </button>
                    <div class="text-center">
                         <a href="#" class="text-muted small fw-800 text-decoration-none uppercase">Cancel Booking Request</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-0 border border-light overflow-hidden position-sticky" style="top: 100px;">
                    <div class="p-4 bg-navy text-white text-center">
                        <div class="x-small fw-800 uppercase tracking-widest opacity-50 mb-1">Pre-Issuance Summary</div>
                        <div class="h5 fw-800 outfit mb-0">OFFICIAL QUOTATION</div>
                    </div>
                    
                    <div class="p-4">
                        <div class="mb-4 text-center border-bottom pb-4">
                            <div class="fw-900 h2 text-navy mb-0 outfit">₹6,250.00</div>
                            <div class="text-muted small fw-800 uppercase mt-1">Gross Agent Fare</div>
                        </div>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted fw-700 small uppercase">Lead Passenger</span>
                                <span class="fw-800 text-navy small">MR RAHUL SHARMA</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted fw-700 small uppercase">Flight Route</span>
                                <span class="fw-800 text-navy small">DEL → BOM</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted fw-700 small uppercase">Carrier</span>
                                <span class="fw-800 text-navy small">Air India (AI-102)</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-3 text-success">
                                <span class="fw-800 small uppercase">Your Commission</span>
                                <span class="fw-900 small">+₹200.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-navy border-top pt-3 border-2">
                                <span class="fw-900 uppercase small">Net Payable</span>
                                <span class="fw-900 outfit h5 mb-0">₹6,050.00</span>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-4">
                             <div class="fw-800 text-navy mb-2 small uppercase outfit"><i class="fas fa-ticket-alt me-2"></i> PNR Status</div>
                             <div class="d-flex align-items-center gap-2">
                                 <div class="pulse-green"></div>
                                 <span class="text-success fw-800 uppercase" style="font-size: 11px;">System Hold - Ready</span>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Issuance Success Overlay -->
<div id="issuanceOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center" style="background: rgba(15, 23, 42, 0.95); z-index: 9999;">
    <!-- Loading State -->
    <div id="loadingContent" class="text-center text-white">
        <div class="spinner-border text-primary mb-4" role="status" style="width: 5rem; height: 5rem; border-width: 0.5rem;"></div>
        <h3 class="fw-900 outfit mb-2">Communicating with GDS...</h3>
        <p class="text-muted fw-700">Please do not refresh or close the browser window.</p>
    </div>

    <!-- Success State -->
    <div id="successContent" class="card border-0 rounded-4 p-5 text-center bg-white shadow-lg d-none" style="max-width: 500px;">
        <div class="mb-4">
            <div class="bg-green-soft rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                <i class="fas fa-check text-success fs-1"></i>
            </div>
        </div>
        <div class="badge bg-green-soft text-success mb-3 px-4 py-2 fw-800">ISSUANCE SUCCESS</div>
        <h2 class="fw-900 text-navy outfit mb-1">AX782S</h2>
        <p class="text-muted fw-700 mb-4">Ticket number <span class="text-primary fw-800">098-9920110421</span> has been successfully generated for Rahul Sharma.</p>
        
        <div class="row g-2 mb-4">
            <div class="col-6">
                 <button class="btn btn-navy w-100 py-3 rounded-3 fw-800"><i class="fas fa-download me-2"></i> E-TICKET</button>
            </div>
            <div class="col-6">
                 <button class="btn btn-outline-navy w-100 py-3 rounded-3 fw-800"><i class="fas fa-envelope me-2"></i> SEND EMAIL</button>
            </div>
        </div>
        <a href="{{ route('iata.dashboard') }}" class="fw-800 text-primary text-decoration-none border-top pt-3 d-block">GO TO DASHBOARD <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function simulateIssuance() {
        const btn = document.getElementById('btnIssue');
        const overlay = document.getElementById('issuanceOverlay');
        const loading = document.getElementById('loadingContent');
        const success = document.getElementById('successContent');

        overlay.classList.remove('d-none');
        overlay.classList.add('d-flex');

        setTimeout(() => {
            loading.classList.add('d-none');
            success.classList.remove('d-none');
            success.classList.add('animate__animated', 'animate__zoomIn');
        }, 3000);
    }
</script>
@endsection

@section('styles')
<style>
    .bg-navy { background-color: #0f172a; }
    .btn-navy { background-color: #0f172a; color: white; }
    .btn-navy:hover { background-color: #1e293b; color: white; }
    .btn-outline-navy { border: 2px solid #0f172a; color: #0f172a; }
    .btn-outline-navy:hover { background-color: #0f172a; color: white; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .cursor-pointer { cursor: pointer; }
    .payment-card input:checked + div { border-color: var(--iata-blue) !important; background-color: #f0f7ff !important; opacity: 1 !important; transform: scale(1.02); }
    .pulse-green { width: 10px; height: 10px; background: #10b981; border-radius: 50%; box-shadow: 0 0 0 rgba(16, 185, 129, 0.4); animation: pulse 2s infinite; }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }
</style>
@endsection


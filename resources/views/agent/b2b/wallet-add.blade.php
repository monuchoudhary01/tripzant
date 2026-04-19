@extends('layouts.app')

@section('title', "Add Money to Wallet — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="wallet-add" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Add Money to Wallet</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Secure Multi-Gateway Recharge System | Instant Credit</p>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-xl-6">
                    <div class="card border-0 shadow-lg rounded-5 bg-navy text-white p-5 h-100 position-relative overflow-hidden mb-5">
                        <div class="position-relative" style="z-index: 2;">
                            <span class="x-small fw-bold opacity-75 uppercase tracking-widest d-block mb-3">Live Wallet Balance</span>
                            <h1 class="fw-900 mb-2">₹{{ number_format($wallet->balance) }}</h1>
                            <p class="small opacity-75 mb-5 uppercase tracking-tighter fw-bold">Ready for instant ticketing</p>
                            
                            <div class="p-4 bg-white-subtle rounded-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="d-block x-small opacity-75 uppercase fw-bold mb-1">Last Recharge</span>
                                    <span class="fw-900">₹{{ number_format(rand(10000, 50000)) }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="d-block x-small opacity-75 uppercase fw-bold mb-1">Auto-Settlement</span>
                                    <span class="badge bg-green text-white x-small fw-bold rounded-pill">ON NODE</span>
                                </div>
                            </div>
                        </div>
                        <div style="position:absolute; right:-50px; bottom:-50px; width:200px; height:200px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="bg-white rounded-5 shadow-sm p-5 border-0 h-100">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Enter Amount & Choose Payment Method</h6>
                        <form action="{{ route('agent.b2b.wallet.topup') }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label class="x-small fw-900 text-muted uppercase mb-3">Amount to Pay (INR)</label>
                                <div class="input-group border rounded-4 overflow-hidden p-2 bg-light shadow-none">
                                    <span class="input-group-text bg-transparent border-0 fw-900 text-navy px-4 h5 mb-0">₹</span>
                                    <input type="number" name="amount" class="form-control bg-transparent border-0 fw-900 text-navy shadow-none h4 mb-0" placeholder="50,000" min="100" required>
                                </div>
                            </div>
    
                            <div class="d-flex flex-column gap-3 mb-5">
                                 <label class="x-small fw-900 text-muted uppercase">Select Gateway Node</label>
                                 <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-4 border border-primary border-2">
                                     <div class="bg-white rounded-circle p-3 text-primary shadow-sm"><i class="fas fa-university"></i></div>
                                     <div class="flex-grow-1">
                                         <h6 class="fw-900 text-navy mb-1 small">IMPS / NEFT / RTGS</h6>
                                         <p class="x-small text-muted mb-0">Zero gateway fees. Instant via Virtual A/C.</p>
                                     </div>
                                     <input type="radio" name="node" checked>
                                 </div>
                                 <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-4 border">
                                     <div class="bg-white rounded-circle p-3 text-primary shadow-sm"><i class="fab fa-google-pay"></i></div>
                                     <div class="flex-grow-1">
                                         <h6 class="fw-900 text-navy mb-1 small">UPI / GPay / PhonePe</h6>
                                         <p class="x-small text-muted mb-0">Direct UPI payment. Instant credit limit update.</p>
                                     </div>
                                      <input type="radio" name="node">
                                 </div>
                            </div>

                            <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-lg">AUTHORIZE RECHARGE <i class="fas fa-bolt ms-2 text-warning"></i></button>
                        </form>
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
    .bg-green { background: #10b981 !important; }
    .border-primary { border-color: #0b3d61 !important; }
</style>
@endsection

@extends('layouts.app')

@section('title', "Balance & Wallet — Tripzant B2B Agent Portal")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
    <x-partner-sidebar active="wallet" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
                <div>
                    <h2 class="fw-900 text-navy mb-1"><i class="fas fa-wallet me-2 text-primary"></i> Prepaid Wallet & Credits</h2>
                    <p class="text-muted small mb-0 uppercase tracking-wider fw-bold">Live API Balance Tracking | Recharge Hub</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm" data-bs-toggle="modal" data-bs-target="#topupModal">ADD FUNDS <i class="fas fa-plus ms-2 text-warning"></i></button>
                </div>
            </div>

            <!-- Wallet Overview -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg bg-navy text-white p-5 rounded-5 overflow-hidden h-100 position-relative">
                        <div class="position-relative" style="z-index: 2;">
                            <span class="x-small fw-bold white-subtle d-block mb-3 uppercase tracking-wider">Net Available Balance</span>
                            <h1 class="fw-900 mb-2">₹{{ number_format($wallet->balance) }}</h1>
                            <p class="small opacity-75 mb-5">Funds verified for instant ticketing via Amadeus Node</p>
                            
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 bg-white-subtle rounded-4">
                                        <span class="d-block x-small opacity-75 uppercase fw-bold mb-1">Credit Limit</span>
                                        <span class="fw-bold fw-900">₹{{ number_format($wallet->credit_limit) }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white-subtle rounded-4">
                                        <span class="d-block x-small opacity-75 uppercase fw-bold mb-1">Total Spent (30D)</span>
                                        <span class="fw-bold fw-900">₹14.28L</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="position:absolute; right:-50px; bottom:-50px; width:250px; height:250px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100">
                        <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide">Secure Recharge Methods</h6>
                        <div class="d-flex flex-column gap-3">
                            <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-4 hover-up-sm transition-all border border-transparent hover-border-primary cursor-pointer">
                                <div class="icon-box bg-white text-primary rounded-circle p-3 shadow-sm" style="width:50px; height:50px;"><i class="fas fa-university"></i></div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-900 text-navy mb-1 small">IMPS / NEFT / RTGS</h6>
                                    <p class="x-small text-muted mb-0">Instant top-up via Virtual Account Mapping</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted x-small"></i>
                            </div>
                            <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-4 hover-up-sm transition-all border border-transparent hover-border-primary cursor-pointer">
                                <div class="icon-box bg-white text-primary rounded-circle p-3 shadow-sm" style="width:50px; height:50px;"><i class="fab fa-google-pay"></i></div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-900 text-navy mb-1 small">UPI Payment</h6>
                                    <p class="x-small text-muted mb-0">Recharge using any UPI App (PhonePe, GPay)</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted x-small"></i>
                            </div>
                            <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-4 hover-up-sm transition-all border border-transparent hover-border-primary cursor-pointer">
                                <div class="icon-box bg-white text-primary rounded-circle p-3 shadow-sm" style="width:50px; height:50px;"><i class="fas fa-credit-card"></i></div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-900 text-navy mb-1 small">Corporate Cards</h6>
                                    <p class="x-small text-muted mb-0">Credit/Debit Cards (1.8% convenience fee)</p>
                                </div>
                                <i class="fas fa-chevron-right text-muted x-small"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5">
                <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-list-alt me-2 text-primary"></i> Detailed Transaction Ledger</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">TIMESTAMP</th>
                                <th class="py-3">TXN TYPE</th>
                                <th class="py-3">DETAILS</th>
                                <th class="py-3">TXN ID</th>
                                <th class="py-3">AMOUNT</th>
                                <th class="py-3 text-end">BALANCE AFTER</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @foreach($recentTransactions as $txn)
                            <tr class="py-4 border-bottom">
                                <td class="text-muted">{{ $txn->created_at->format('d M H:i') }}</td>
                                <td>
                                    <span class="badge {{ $txn->type == 'topup' ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} rounded-pill px-3 py-1 uppercase x-small">
                                        {{ $txn->type }}
                                    </span>
                                </td>
                                <td class="text-navy fw-900">{{ $txn->description }}</td>
                                <td class="text-muted x-small">#TXN-{{ rand(100000, 999999) }}</td>
                                <td class="{{ $txn->type == 'topup' ? 'text-green' : 'text-red' }}">
                                    {{ $txn->type == 'topup' ? '+' : '-' }}₹{{ number_format($txn->amount) }}
                                </td>
                                <td class="text-navy text-end">₹{{ number_format(rand(100000, 500000)) }}</td>
                            </tr>
                            @endforeach
                            @if(count($recentTransactions) == 0)
                            <tr><td colspan="6" class="text-center py-5 text-muted small fw-bold">No transactions recorded.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal remains the same as in index -->
<div class="modal fade" id="topupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
            <div class="modal-header bg-navy text-white p-4 px-5">
                <h5 class="modal-title fw-900 uppercase">PREPAID RECHARGE</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('agent.b2b.wallet-topup') }}" method="POST">
                @csrf
                <div class="modal-body p-5">
                    <div class="mb-4">
                        <label class="form-label x-small fw-900 text-muted uppercase">Enter Top-up Amount (INR)</label>
                        <div class="input-group border rounded-4 overflow-hidden p-1 bg-light">
                            <span class="input-group-text bg-transparent border-0 fw-900 text-navy px-3">₹</span>
                            <input type="number" name="amount" class="form-control bg-transparent border-0 fw-900 text-navy" style="font-size: 24px;" placeholder="50,000" required>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill py-3 fw-900 shadow-sm uppercase tracking-wider">Authorize Payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .white-subtle { color: rgba(255,255,255,0.7); }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444; }
    .hover-up-sm:hover { transform: translateY(-5px); transition: 0.3s; }
    .transition-all { transition: all 0.3s ease; }
    .hover-border-primary:hover { border-color: #3182ce !important; }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection

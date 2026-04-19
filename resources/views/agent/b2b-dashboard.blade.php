@extends('layouts.app')

@section('title', "Tripzant B2B Agent Portal - Smart Booking & Wallet")

@section('content')
<div class="b2b-portal-wrapper d-flex" style="background: #f4f7fa; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <!-- Simple Sidebar for B2B -->
    <aside class="b2b-sidebar bg-white border-end d-none d-lg-block shadow-sm" style="width: 280px;">
        <div class="p-4 text-center border-bottom">
            <h4 class="fw-900 text-primary mb-0">TRIPZANT <span class="text-navy">B2B</span></h4>
            <p class="x-small text-muted fw-bold uppercase mt-1">Verified Agent Hub</p>
        </div>
        <nav class="p-3 d-flex flex-column gap-2 mt-3">
            <a href="{{ route('agent.b2b.index') }}" class="nav-link-b2b active"><i class="fas fa-th-large me-3"></i> Agent Overview</a>
            <a href="{{ route('agent.b2b.bookings') }}" class="nav-link-b2b"><i class="fas fa-plane-departure me-3"></i> My Bookings</a>
            <a href="{{ route('agent.b2b.reports') }}" class="nav-link-b2b"><i class="fas fa-file-invoice me-3"></i> Financial Reports</a>
            <a href="{{ route('agent.b2b.settings') }}" class="nav-link-b2b"><i class="fas fa-user-cog me-3"></i> Profile Settings</a>
        </nav>
        
        <div class="mt-auto p-4 border-top">
            <div class="wallet-card bg-primary text-white p-4 rounded-4 shadow-sm">
                <span class="x-small fw-bold opacity-75 uppercase">Total Wallet Balance</span>
                <h3 class="fw-900 mb-0 mt-1">₹{{ number_format($wallet->balance) }}</h3>
                <button class="btn btn-white btn-sm w-100 mt-3 rounded-pill fw-bold small py-2" data-bs-toggle="modal" data-bs-target="#topupModal">TOP UP WALLET</button>
            </div>
        </div>
    </aside>

    <main class="flex-grow-1 p-5 overflow-auto">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-900 text-navy mb-1">Welcome Back, {{ Auth::user()->name }}</h2>
                <p class="text-muted fw-bold small uppercase tracking-wider">B2B NET FARE PORTAL | IATA AUTHORIZED</p>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('flights.index') }}" class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm"><i class="fas fa-search me-2"></i> SEARCH FLIGHTS</a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fw-bold">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 fw-bold">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 bg-white">
                    <span class="x-small fw-900 text-muted mb-2 uppercase">Total Bookings (MTD)</span>
                    <div class="h3 fw-900 text-navy mb-0">124</div>
                    <p class="x-small text-success fw-bold mt-2"><i class="fas fa-arrow-up"></i> +12% VS LAST MONTH</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 bg-white">
                    <span class="x-small fw-900 text-muted mb-2 uppercase">Total Margin Earned</span>
                    <div class="h3 fw-900 text-primary mb-0">₹42,850</div>
                    <p class="x-small text-muted fw-bold mt-2">PRE-SET MARGIN: ₹500/ticket</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-navy text-white text-center">
                    <span class="x-small fw-bold white-subtle mb-2 uppercase">Agent Wallet Status</span>
                    <div class="h3 fw-900 mb-0 mt-1">₹{{ number_format($wallet->balance) }}</div>
                    <div class="mt-3">
                        <span class="badge bg-green-subtle text-green rounded-pill x-small px-3 py-2 fw-bold">FUNDS READY FOR TICKETING</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Transactions Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-5 h-100">
                    <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide d-flex align-items-center">
                        <i class="fas fa-history me-3 text-primary"></i> Wallet Transaction History
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="x-small text-muted fw-bold uppercase border-bottom">
                                <tr>
                                    <th class="py-3">DATE</th>
                                    <th class="py-3">TXN TYPE</th>
                                    <th class="py-3">DETAILS</th>
                                    <th class="py-3">AMOUNT</th>
                                    <th class="py-3 text-end">STATUS</th>
                                </tr>
                            </thead>
                            <tbody class="small fw-bold">
                                @forelse($recentTransactions as $txn)
                                <tr class="py-4">
                                    <td class="text-muted">{{ $txn->created_at->format('d M H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $txn->type == 'topup' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-3 py-1 uppercase x-small">
                                            {{ strtoupper($txn->type) }}
                                        </span>
                                    </td>
                                    <td class="text-navy fw-900">{{ $txn->description }}</td>
                                    <td class="{{ $txn->type == 'topup' ? 'text-success' : 'text-danger' }}">
                                        {{ $txn->type == 'topup' ? '+' : '-' }}₹{{ number_format($txn->amount) }}
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-light text-navy rounded-pill px-3 py-1 x-small fw-bold">{{ strtoupper($txn->status) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No transactions found. Top up your wallet to get started!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pre-Book Verification rules -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                    <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide"><i class="fas fa-hand-holding-usd me-2 text-primary"></i> Margin Control</h6>
                    <div class="margin-input-box p-4 bg-light rounded-4 mb-4 text-center">
                        <span class="x-small fw-bold text-muted uppercase d-block mb-3">Your Default Margin (Per Pax)</span>
                        <div class="input-group input-group-lg border-0 shadow-none">
                            <span class="input-group-text bg-white border-0 fw-900 text-navy pr-0">₹</span>
                            <input type="number" class="form-control bg-white border-0 fw-900 text-navy text-center" value="500" readonly>
                        </div>
                        <button class="btn btn-link small text-primary fw-900 text-decoration-none mt-3">UPDATE DEFAULT MARGIN</button>
                    </div>

                    <div class="info-box p-3 bg-primary-subtle rounded-3 mb-3 border-start border-primary border-4">
                        <h6 class="fw-900 text-primary mb-1 x-small uppercase">B2B Rule #1</h6>
                        <p class="x-small text-muted mb-0">Booking is blocked if Wallet Balance < Net Fare. Instant issuance only.</p>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-900 text-navy mb-3 uppercase tracking-wide x-small">Help & Support</h6>
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                            <div class="bg-navy text-white rounded-circle p-2 fw-900 x-small" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-headset"></i></div>
                            <div>
                                <h6 class="mb-0 fw-900 small">24/7 B2B Support</h6>
                                <span class="x-small text-muted">+91 1800-TRIPZANT</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Top-up Modal -->
<div class="modal fade" id="topupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
            <div class="modal-header bg-navy text-white p-4 px-5">
                <h5 class="modal-title fw-900">WALLET RECHARGE</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('agent.b2b.wallet-topup') }}" method="POST">
                @csrf
                <div class="modal-body p-5">
                    <div class="mb-4">
                        <label class="form-label x-small fw-900 text-muted uppercase">Enter Amount (INR)</label>
                        <div class="input-group input-group-lg border rounded-4 overflow-hidden p-1">
                            <span class="input-group-text bg-white border-0 fw-900 text-navy px-4">₹</span>
                            <input type="number" name="amount" class="form-control border-0 fw-900 text-navy" placeholder="e.g. 50000" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill py-3 fw-900 shadow-sm">PAY NOW & ADD FUNDS</button>
                    </div>
                    <p class="text-center x-small text-muted mt-4 mb-0 italic">Secure payment processing via IATA Settlement Gateway.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .btn-navy { background: #001f3f; color: #fff; }
    .btn-navy:hover { background: #003366; color: #fff; }
    .bg-navy { background: #001f3f !important; }
    .text-navy { color: #001f3f !important; }
    .white-subtle { color: rgba(255,255,255,0.7); }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981; }
    .btn-white { background: #fff; color: #3182ce; border: none; }
    .btn-white:hover { background: #f8fafc; color: #2c5282; }

    .nav-link-b2b {
        display: flex; align-items: center; padding: 15px 20px; border-radius: 12px; 
        color: #64748b; text-decoration: none; font-weight: 800; font-size: 14px; transition: 0.3s;
    }
    .nav-link-b2b:hover { background: #f8fafc; color: #3182ce; transform: translateX(5px); }
    .nav-link-b2b.active { background: #3182ce15; color: #3182ce; border-left: 4px solid #3182ce; }
</style>
@endsection

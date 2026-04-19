@extends('layouts.app')

@section('title', "Agent Financial Transactions | Trip Zant")

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
    
    .transaction-card { background: #fff; border-radius: 20px; padding: 30px; border: 1px solid #edf2f7; transition: 0.3s; }
    .passenger-detail-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 15px; margin-top: 10px; }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f7fafc; min-height: 95vh;">
    <div class="container container-fluid">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="mb-4 pb-4 border-bottom border-light text-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-900 shadow-lg mx-auto mb-3" style="width: 60px; height: 60px;">IA</div>
                        <h6 class="fw-900 text-dark mb-1 small uppercase">Indus Travels</h6>
                        <div class="badge bg-success-subtle text-success rounded-pill x-small fw-bold px-3">IATA VERIFIED</div>
                    </div>
                    
                    <div class="sidebar-nav d-flex flex-column gap-1">
                        <a href="{{ route('agent.dashboard') }}" class="nav-link-agent"><i class="fas fa-th-large"></i> Overview</a>
                        <a href="{{ route('agent.network') }}" class="nav-link-agent"><i class="fas fa-globe-americas"></i> Global Network</a>
                        <a href="{{ route('agent.connections') }}" class="nav-link-agent"><i class="fas fa-users"></i> My Connections</a>
                        <a href="{{ route('agent.ticketing') }}" class="nav-link-agent"><i class="fas fa-ticket-alt"></i> Ticketing Desk</a>
                        <a href="{{ route('agent.profit-sharing') }}" class="nav-link-agent"><i class="fas fa-hand-holding-usd"></i> Profit Sharing</a>
                        <a href="{{ route('agent.transactions') }}" class="nav-link-agent active"><i class="fas fa-file-invoice-dollar"></i> Transactions</a>
                        <hr class="opacity-10 my-3">
                        <a href="/" class="nav-link-agent text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="mb-5 d-flex justify-content-between align-items-end">
                    <div>
                        <h2 class="fw-900 text-dark mb-1">Financial Settlement & Transactions</h2>
                        <p class="text-muted small fw-bold uppercase">B2B Commission Payouts & Settlement Ledger 💳</p>
                    </div>
                    <button class="btn btn-navy rounded-pill px-4 py-3 fw-900 small shadow-lg text-white" style="background:#1a202c;">DOWNLOAD LEDGER PDF</button>
                </div>

                <!-- Financial Summary Cards -->
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="transaction-card border-start border-4 border-success">
                            <div class="x-small fw-900 text-muted uppercase mb-2">Total Yield (Earnings)</div>
                            <div class="h3 fw-900 text-dark mb-1">₹8,40,250.00</div>
                            <div class="x-small fw-bold text-success"><i class="fas fa-arrow-up me-1"></i> +12% vs last month</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transaction-card border-start border-4 border-primary">
                            <div class="x-small fw-900 text-muted uppercase mb-2">Settled Payments</div>
                            <div class="h3 fw-900 text-primary mb-1">₹6,80,000.00</div>
                            <div class="x-small fw-bold text-muted uppercase">PAID TO WALLET</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transaction-card border-start border-4 border-warning">
                            <div class="x-small fw-900 text-muted uppercase mb-2">Pending Settlements</div>
                            <div class="h3 fw-900 text-warning mb-1">₹1,60,250.00</div>
                            <div class="x-small fw-bold text-warning uppercase">WAITING FOR RECONCILE</div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Ledger with Accordion for Passengers -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-900 text-dark mb-4 ls-1">Detailed Settlement Ledger</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 x-small fw-900 py-3 text-dark">DATE</th>
                                    <th class="border-0 x-small fw-900 py-3 text-dark">TRANSACTION ID</th>
                                    <th class="border-0 x-small fw-900 py-3 text-dark">PARTNER AGENT</th>
                                    <th class="border-0 x-small fw-900 py-3 text-dark text-end">EARNINGS</th>
                                    <th class="border-0 x-small fw-900 py-3 text-dark text-center">STATUS</th>
                                    <th class="border-0 x-small fw-900 py-3 text-dark"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $transactions = [
                                    ['date' => '02 Apr 2026', 'id' => 'TX-88204-A', 'partner' => 'Dubai Skyline (IATA: 882045)', 'amount' => '₹4,500.00', 'pax' => [['name' => 'Rahul Khanna', 'passport' => 'Z1234567', 'ticket' => 'EK-128441'], ['name' => 'Sonia Khanna', 'passport' => 'Z7654321', 'ticket' => 'EK-128442']], 'status' => 'Settled'],
                                    ['date' => '01 Apr 2026', 'id' => 'TX-12022-B', 'partner' => 'London Express (IATA: 120224)', 'amount' => '₹1,200.00', 'pax' => [['name' => 'John Doe', 'passport' => 'L99887766', 'ticket' => 'BA-882215']], 'status' => 'Pending'],
                                    ['date' => '31 Mar 2026', 'id' => 'TX-99488-C', 'partner' => 'NYC Global (IATA: 994882)', 'amount' => '₹8,400.00', 'pax' => [['name' => 'Michael Smith', 'passport' => 'US-12399', 'ticket' => 'UA-44112']], 'status' => 'Settled'],
                                ];
                                @endphp
                                @foreach($transactions as $index => $t)
                                <tr>
                                    <td class="small fw-bold text-muted">{{ $t['date'] }}</td>
                                    <td class="small fw-900 text-dark">{{ $t['id'] }}</td>
                                    <td>
                                        <div class="small fw-900 text-primary">{{ $t['partner'] }}</div>
                                    </td>
                                    <td class="text-end fw-900 text-success small">{{ $t['amount'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $t['status'] == 'Settled' ? 'success' : 'warning' }}-subtle text-{{ $t['status'] == 'Settled' ? 'success' : 'warning' }} rounded-pill x-small px-3 fw-900 uppercase">{{ strtoupper($t['status']) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="collapse" data-bs-target="#paxDetail{{ $index }}">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="paxDetail{{ $index }}">
                                    <td colspan="6" class="border-0 p-0">
                                        <div class="passenger-detail-box mx-3 mb-4">
                                            <div class="row g-2">
                                                <div class="col-12"><h6 class="x-small fw-900 text-dark uppercase mb-2"><i class="fas fa-users-viewfinder me-2 text-primary"></i> Linked Passenger Details ({{ count($t['pax']) }} PAX)</h6></div>
                                                @foreach($t['pax'] as $p)
                                                <div class="col-md-4">
                                                    <div class="bg-white p-3 rounded-4 shadow-sm border border-light">
                                                        <div class="small fw-900 text-dark mb-1">{{ $p['name'] }}</div>
                                                        <div class="x-small fw-bold text-muted uppercase">Passport: {{ $p['passport'] }}</div>
                                                        <div class="x-small fw-bold text-primary ls-1 mt-1">Ticket #{{ $p['ticket'] }}</div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="col-12 mt-3 pt-2 border-top">
                                                    <a href="#" class="x-small fw-900 text-primary text-decoration-none"><i class="fas fa-file-invoice me-1"></i> VIEW SETTLEMENT VOUCHER</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

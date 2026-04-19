@extends('layouts.app')

@section('title', "My B2B Global Connections | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .connection-card {
        background: #fff; border-radius: 20px; transition: 0.3s; border: 1px solid #edf2f7; overflow: hidden;
    }
    .connection-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.05); }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .nav-link-agent {
        display: flex; align-items: center; gap: 12px; padding: 15px 20px; border-radius: 12px; 
        color: #4a5568; text-decoration: none; font-weight: 800; font-size: 13px; transition: 0.3s;
    }
    .nav-link-agent:hover, .nav-link-agent.active { background: #3182ce15; color: #3182ce; }
    .nav-link-agent.active { border-left: 4px solid #3182ce; }
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
                        <a href="{{ route('agent.connections') }}" class="nav-link-agent active"><i class="fas fa-users"></i> My Connections</a>
                        <a href="{{ route('agent.ticketing') }}" class="nav-link-agent"><i class="fas fa-ticket-alt"></i> Ticketing Desk</a>
                        <a href="{{ route('agent.profit-sharing') }}" class="nav-link-agent"><i class="fas fa-hand-holding-usd"></i> Profit Sharing</a>
                        <a href="{{ route('agent.transactions') }}" class="nav-link-agent"><i class="fas fa-file-invoice-dollar"></i> Transactions</a>
                        <hr class="opacity-10 my-3">
                        <a href="/" class="nav-link-agent text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <h2 class="fw-900 text-dark mb-1">My Global Connections</h2>
                        <p class="text-muted small fw-bold uppercase">Enterprise Partnerships & Active Collaborations 🤝</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-dark rounded-pill px-4 small fw-900 py-3">ACTIVE (42)</button>
                        <button class="btn btn-navy text-white rounded-pill px-4 small fw-900 py-3 shadow-lg" style="background:#1a202c;" onclick="window.location='{{ route('agent.network') }}'">+ NEW PARTNER</button>
                    </div>
                </div>

                <!-- My Connections Grid -->
                <div class="row g-4">
                    @php
                    $connections = [
                        ['id' => '882045', 'name' => 'Dubai Skyline Travel', 'city' => 'Dubai, UAE', 'status' => 'Active', 'yield' => '₹4,50,000', 'deals' => 24],
                        ['id' => '120224', 'name' => 'London Express Hub', 'city' => 'London, UK', 'status' => 'Active', 'yield' => '₹1,20,500', 'deals' => 8],
                        ['id' => '449122', 'name' => 'Singapore Wings', 'city' => 'Singapore, SG', 'status' => 'Pending', 'yield' => '₹0', 'deals' => 0],
                        ['id' => '994882', 'name' => 'NYC Global Agency', 'city' => 'New York, USA', 'status' => 'Active', 'yield' => '₹2,84,000', 'deals' => 12],
                    ];
                    @endphp
                    @foreach($connections as $c)
                    <div class="col-md-6">
                        <div class="connection-card p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center fw-900 shadow-sm" style="width: 50px; height: 50px;">{{ substr($c['name'], 0, 1) }}</div>
                                    <div>
                                        <h6 class="fw-900 text-dark mb-0">{{ $c['name'] }}</h6>
                                        <div class="x-small fw-bold text-muted"><i class="fas fa-location-dot me-1"></i> {{ $c['city'] }}</div>
                                    </div>
                                </div>
                                <span class="badge bg-{{ $c['status'] == 'Active' ? 'success' : 'warning' }}-subtle text-{{ $c['status'] == 'Active' ? 'success' : 'warning' }} rounded-pill x-small px-3 fw-900">{{ strtoupper($c['status']) }}</span>
                            </div>

                            <div class="row text-center bg-light bg-opacity-50 rounded-4 p-3 mb-4 g-2">
                                <div class="col-6 shadow-sm bg-white rounded-3 p-2">
                                    <div class="x-small fw-bold text-muted uppercase" style="font-size: 9px;">Total Yield</div>
                                    <div class="small fw-900 text-success">{{ $c['yield'] }}</div>
                                </div>
                                <div class="col-6 shadow-sm bg-white rounded-3 p-2">
                                    <div class="x-small fw-bold text-muted uppercase" style="font-size: 9px;">Deals Closed</div>
                                    <div class="small fw-900 text-dark">{{ $c['deals'] }}</div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('agent.chat', ['id' => $c['id']]) }}" class="btn btn-navy text-white w-100 rounded-pill small fw-900 py-3 shadow-sm" style="background:#1a202c;">
                                            <i class="fas fa-comments me-2"></i> CHAT
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('agent.profile', ['id' => $c['id']]) }}" class="btn btn-outline-dark w-100 rounded-pill small fw-900 py-3 border-2">
                                            <i class="fas fa-eye me-2"></i> PROFILE
                                        </a>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <a href="{{ route('agent.deals') }}" class="btn btn-primary w-100 rounded-pill small fw-900 py-3 shadow-lg">
                                            <i class="fas fa-file-contract me-2"></i> CREATE DEAL
                                        </a>
                                    </div>
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
@endsection

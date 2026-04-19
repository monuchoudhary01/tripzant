@extends('layouts.app')

@section('title', "My Allocated Segments | Trip Zant Investor")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .segment-card-detailed {
        background: #fff; border-radius: 20px; transition: 0.3s;
        border: 1px solid #f1f5f9; overflow: hidden;
    }
    .segment-card-detailed:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
    .route-icon-box {
        width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 95vh;">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <a href="{{ route('investor.dashboard') }}" class="text-decoration-none small fw-bold text-muted uppercase"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
                <h2 class="fw-900 text-navy mt-2">My Traveling Segments</h2>
                <p class="text-muted small fw-bold">Manage and monitor route-specific liquidity allocations.</p>
            </div>
            <button class="btn btn-navy rounded-pill px-4 py-3 fw-900 shadow-lg text-white" style="background: #0f172a;">
                <i class="fas fa-map-plus me-2"></i> REQUEST NEW SEGMENT
            </button>
        </div>

        <!-- Segment Filters -->
        <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
            <button class="btn btn-dark rounded-pill px-4 small fw-900">ALL ROUTES</button>
            <button class="btn btn-outline-dark rounded-pill px-4 small fw-900">DOMESTIC (INDIA)</button>
            <button class="btn btn-outline-dark rounded-pill px-4 small fw-900">INTERNATIONAL</button>
            <button class="btn btn-outline-dark rounded-pill px-4 small fw-900">HIGH DEMAND</button>
        </div>

        <div class="row g-4">
            @php
            $mySegments = [
                ['from' => 'Mumbai', 'to' => 'Delhi', 'invested' => 50000, 'balance' => 32400, 'pax' => 120, 'earnings' => 12000, 'type' => 'Domestic'],
                ['from' => 'Delhi', 'to' => 'Dubai', 'invested' => 200000, 'balance' => 145000, 'pax' => 54, 'earnings' => 5400, 'type' => 'International'],
                ['from' => 'Kolkata', 'to' => 'Jaipur', 'invested' => 30000, 'balance' => 12000, 'pax' => 180, 'earnings' => 18000, 'type' => 'Domestic'],
                ['from' => 'Bangalore', 'to' => 'Singapore', 'invested' => 500000, 'balance' => 480000, 'pax' => 12, 'earnings' => 1200, 'type' => 'International'],
            ];
            @endphp
            @foreach($mySegments as $seg)
            <div class="col-lg-6">
                <div class="segment-card-detailed">
                    <div class="p-4 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-{{ $seg['type'] == 'Domestic' ? 'primary' : 'success' }}-subtle text-{{ $seg['type'] == 'Domestic' ? 'primary' : 'success' }} rounded-pill x-small px-3 fw-900 uppercase">{{ $seg['type'] }}</span>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                    <li><a class="dropdown-item x-small fw-bold" href="#">Add Liquidity</a></li>
                                    <li><a class="dropdown-item x-small fw-bold" href="#">View Analytics</a></li>
                                    <li><a class="dropdown-item x-small fw-bold text-danger" href="#">Terminate Segment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="route-icon-box bg-light text-navy">
                                <i class="fas fa-plane-departure"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h4 class="fw-900 text-navy mb-0">{{ $seg['from'] }}</h4>
                                    <i class="fas fa-arrow-right-long text-muted"></i>
                                    <h4 class="fw-900 text-navy mb-0 text-end">{{ $seg['to'] }}</h4>
                                </div>
                                <div class="x-small fw-bold text-muted uppercase">Allocated Travel Segment</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-light bg-opacity-50">
                        <div class="row g-4 text-center">
                            <div class="col-4">
                                <div class="x-small fw-bold text-muted uppercase mb-1" style="font-size: 9px;">Total Invested</div>
                                <div class="small fw-900 text-navy">₹{{ number_format($seg['invested']) }}</div>
                            </div>
                            <div class="col-4 border-start border-end border-light">
                                <div class="x-small fw-bold text-muted uppercase mb-1" style="font-size: 9px;">Available Bal</div>
                                <div class="small fw-900 text-primary">₹{{ number_format($seg['balance']) }}</div>
                            </div>
                            <div class="col-4">
                                <div class="x-small fw-bold text-muted uppercase mb-1" style="font-size: 9px;">Total Earnings</div>
                                <div class="small fw-900 text-success">₹{{ number_format($seg['earnings']) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="x-small fw-bold text-muted">Tickets Funded:</span>
                            <span class="small fw-900 text-navy ms-2">{{ $seg['pax'] }} PAX</span>
                        </div>
                        <a href="{{ route('investor.earnings') }}" class="btn btn-navy btn-sm rounded-pill px-4 fw-900 shadow-sm" style="background:#0f172a; color:#fff; font-size: 11px;">VIEW DETAILS</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- System Logic Info -->
        <div class="card border-0 shadow-sm rounded-4 p-5 mt-5 bg-navy text-white" style="background: linear-gradient(45deg, #0f172a, #1eccd1);">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-900 mb-3 text-white">How Segment-Based Funding Works?</h4>
                    <p class="opacity-75 mb-0 fw-bold small">When a customer books a flight on your assigned route (e.g. {{ $mySegments[0]['from'] }} to {{ $mySegments[0]['to'] }}), our system automatically selects your wallet for funding. You earn an instant <span class="text-warning">₹100 commission per passenger</span> once the ticket is issued.</p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <i class="fas fa-shield-halved display-4 opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

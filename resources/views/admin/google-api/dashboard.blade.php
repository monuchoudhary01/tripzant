@extends('layouts.admin')

@section('title', 'Google API Dashboard | Price Comparison')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-900 text-navy mb-1">Global Price Comparison</h2>
        <p class="text-muted small mb-0">Unified dashboard for Flights & Hotels across multiple platforms.</p>
    </div>
    <div class="d-flex gap-3">
        <button class="btn btn-outline-navy rounded-pill px-4 fw-bold small"><i class="fas fa-sync-alt me-2"></i> Refresh Data</button>
        <button class="btn btn-admin-primary px-4 shadow-sm"><i class="fas fa-download me-2"></i> Export Report</button>
    </div>
</div>

<!-- Source Status -->
<div class="row g-4 mb-5">
    @php
    $sources = [
        ['name' => 'Google Flights/Hotels', 'status' => 'Live (Mock)', 'icon' => 'fab fa-google', 'color' => '#4285F4'],
        ['name' => 'B2C Platform', 'status' => 'Stable', 'icon' => 'fas fa-shopping-cart', 'color' => '#f97316'],
        ['name' => 'B2C CAU', 'status' => 'Protected', 'icon' => 'fas fa-user-lock', 'color' => '#8b5cf6'],
        ['name' => 'B2B Platform', 'status' => 'Active', 'icon' => 'fas fa-building', 'color' => '#10b981'],
    ];
    @endphp
    @foreach($sources as $source)
    <div class="col-xl-3 col-md-6">
        <div class="card-admin d-flex align-items-center gap-4 py-4 hvr-grow" style="border-left: 5px solid {{ $source['color'] }};">
            <div class="source-icon fs-2" style="color: {{ $source['color'] }}">
                <i class="{{ $source['icon'] }}"></i>
            </div>
            <div>
                <h6 class="fw-800 text-navy mb-1 text-uppercase small">{{ $source['name'] }}</h6>
                <div class="d-flex align-items-center gap-2">
                    <span class="pulse-dot" style="background: {{ $source['color'] }}"></span>
                    <span class="text-muted" style="font-size: 12px;">{{ $source['status'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <!-- Flights Summary -->
    <div class="col-xl-6">
        <div class="card-admin">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h5 class="fw-900 text-navy mb-0"><i class="fas fa-plane-arrival me-2 text-primary"></i> Lowest Flight Prices</h5>
                <a href="{{ route('admin.google-api.flights') }}" class="btn btn-link link-primary p-0 fw-bold text-decoration-none small">View Comparison <i class="fas fa-external-link-alt ms-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table-admin">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 small fw-800">ROUTE</th>
                            <th class="border-0 small fw-800 text-center">BEST PRICE</th>
                            <th class="border-0 small fw-800 shadow-sm bg-white rounded-end">PROVIDER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $flights_summary = [
                            ['route' => 'DEL → MUM', 'price' => '₹4,250', 'provider' => 'Google API', 'color' => 'bg-danger'],
                            ['route' => 'BLR → DXB', 'price' => '₹18,900', 'provider' => 'B2C Platform', 'color' => 'bg-warning'],
                            ['route' => 'LON → NYK', 'price' => '₹45,200', 'provider' => 'B2B Partner', 'color' => 'bg-success'],
                            ['route' => 'SIN → SYD', 'price' => '₹32,150', 'provider' => 'Google API', 'color' => 'bg-danger'],
                        ];
                        @endphp
                        @foreach($flights_summary as $f)
                        <tr>
                            <td class="fw-900 text-navy">{{ $f['route'] }}</td>
                            <td class="text-center"><span class="price-pill-admin">{{ $f['price'] }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="dot-sm {{ $f['color'] }}"></span>
                                    <span class="fw-bold small">{{ $f['provider'] }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Hotels Summary -->
    <div class="col-xl-6">
        <div class="card-admin">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h5 class="fw-900 text-navy mb-0"><i class="fas fa-hotel me-2 text-orange"></i> Lowest Hotel Rates</h5>
                <a href="{{ route('admin.google-api.hotels') }}" class="btn btn-link link-orange p-0 fw-bold text-decoration-none small">View Comparison <i class="fas fa-external-link-alt ms-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table-admin">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 small fw-800">CITY</th>
                            <th class="border-0 small fw-800 text-center">AVG PRICE</th>
                            <th class="border-0 small fw-800 shadow-sm bg-white rounded-end">PROVIDER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $hotels_summary = [
                            ['city' => 'Goa', 'price' => '₹2,500/night', 'provider' => 'B2C CAU', 'color' => 'bg-purple'],
                            ['city' => 'Dubai', 'price' => '₹7,800/night', 'provider' => 'Google Hotels', 'color' => 'bg-info'],
                            ['city' => 'New York', 'price' => '₹12,400/night', 'provider' => 'B2B Partner', 'color' => 'bg-success'],
                            ['city' => 'Paris', 'price' => '₹11,200/night', 'provider' => 'Google Hotels', 'color' => 'bg-info'],
                        ];
                        @endphp
                        @foreach($hotels_summary as $h)
                        <tr>
                            <td class="fw-900 text-navy">{{ $h['city'] }}</td>
                            <td class="text-center"><span class="price-pill-admin orange">{{ $h['price'] }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="dot-sm {{ $h['color'] }}"></span>
                                    <span class="fw-bold small">{{ $h['provider'] }}</span>
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

<style>
    .pulse-dot {
        width: 8px; height: 8px; border-radius: 50%;
        animation: pulse-source 2s infinite;
    }
    @keyframes pulse-source {
        0% { transform: scale(0.9); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.5; }
        100% { transform: scale(0.9); opacity: 1; }
    }
    .custom-table-admin { font-size: 13px; }
    .custom-table-admin th { padding: 15px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--admin-text-light); }
    .custom-table-admin td { padding: 18px 15px; border-bottom-color: #f1f5f9; }
    .price-pill-admin {
        background: rgba(59, 130, 246, 0.1); color: #3b82f6;
        padding: 5px 12px; border-radius: 30px; font-weight: 800; font-size: 13px;
    }
    .price-pill-admin.orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }
    .dot-sm { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .link-orange { color: #f97316; }
    .link-orange:hover { color: #c2410c; }
</style>
@endsection

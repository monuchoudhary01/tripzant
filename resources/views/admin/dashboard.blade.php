@extends('layouts.admin')

@section('title', 'Master Dashboard | Trip Zant')

@section('admin_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Row 0: Quick Service Links -->
    <div class="row mb-5 text-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-4 px-3 py-4 bg-white rounded-4 shadow-sm border border-light">
                <a href="/admin/flights" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-primary mb-2"><i class="bx bxs-plane-alt fs-3"></i></div>
                    <span class="fw-bold text-dark small">Flights ({{ $stats['flight_bookings'] }})</span>
                </a>

                <a href="/admin/hotels" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-warning mb-2"><i class="bx bxs-hotel fs-3"></i></div>
                    <span class="fw-bold text-dark small">Hotels ({{ $stats['hotel_bookings'] }})</span>
                </a>

                <a href="/admin/tours" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-success mb-2"><i class="bx bxs-package fs-3"></i></div>
                    <span class="fw-bold text-dark small">Holidays ({{ $stats['tour_bookings'] }})</span>
                </a>

                <a href="/admin/homestays" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-info mb-2"><i class="bx bxs-home fs-3"></i></div>
                    <span class="fw-bold text-dark small">Homestays ({{ $stats['homestays'] }})</span>
                </a>

                <a href="/admin/trains" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-danger mb-2"><i class="bx bxs-train fs-3"></i></div>
                    <span class="fw-bold text-dark small">Trains ({{ $stats['trains'] }})</span>
                </a>

                <a href="/admin/visa" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-secondary mb-2"><i class="bx bxs-id-card fs-3"></i></div>
                    <span class="fw-bold text-dark small">Visa ({{ $stats['visa_requests'] }})</span>
                </a>

                <a href="/admin/insurance" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-primary mb-2" style="filter: hue-rotate(45deg);"><i class="bx bxs-shield-alt-2 fs-3"></i></div>
                    <span class="fw-bold text-dark small">Insurance ({{ $stats['insurance_plans'] }})</span>
                </a>

                <a href="/admin/esim" class="service-link text-decoration-none">
                    <div class="service-icon bg-label-info mb-2" style="background-color: #e0f7fa; color: #00bcd4;"><i class="bx bxs-chip fs-3"></i></div>
                    <span class="fw-bold text-dark small">eSIM ({{ $stats['esim_plans'] }})</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Row 1: Gradient Stats Cards -->
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 mb-5">
        <div class="col">
            <div class="card-gradient card-gradient-purple">
                <div class="card-gradient-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-circle-sm"><i class="bx bx-calendar"></i></div>
                        <div class="badge-trend-sm">16%</div>
                    </div>
                    <div class="card-info">
                        <span class="d-block x-small opacity-75">Total Booking</span>
                        <h4 class="mb-0 text-white fw-bold">{{ number_format($stats['total_bookings']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-gradient card-gradient-green">
                <div class="card-gradient-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-circle-sm"><i class="bx bx-trending-up"></i></div>
                        <div class="badge-trend-sm">35%</div>
                    </div>
                    <div class="card-info">
                        <span class="d-block x-small opacity-75">Total Revenue</span>
                        <h4 class="mb-0 text-white fw-bold">₹{{ number_format($stats['total_revenue'] / 1000, 1) }}k</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-gradient card-gradient-blue">
                <div class="card-gradient-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-circle-sm"><i class="bx bx-paper-plane"></i></div>
                        <div class="badge-trend-sm">10%</div>
                    </div>
                    <div class="card-info">
                        <span class="d-block x-small opacity-75">Active Flights</span>
                        <h4 class="mb-0 text-white fw-bold">{{ $stats['flight_bookings'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-gradient card-gradient-yellow">
                <div class="card-gradient-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-circle-sm"><i class="bx bx-wallet"></i></div>
                        <div class="badge-trend-sm">11%</div>
                    </div>
                    <div class="card-info">
                        <span class="d-block x-small opacity-75">Wallet Pool</span>
                        <h4 class="mb-0 text-white fw-bold">₹{{ number_format($stats['wallet_balance'], 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-gradient card-gradient-info" style="background: linear-gradient(230deg, #1cb5e0, #000851);">
                <div class="card-gradient-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-circle-sm"><i class="bx bx-group"></i></div>
                        <div class="badge-trend-sm">NEW</div>
                    </div>
                    <div class="card-info">
                        <span class="d-block x-small opacity-75">Total Partners</span>
                        <h4 class="mb-0 text-white fw-bold">{{ $stats['total_partners'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Portal Cards Grid -->
    <h5 class="fw-bold mb-4">System Access Directory</h5>
    <div class="row g-4 mb-5">
    @php
        $portals = [
            ['slug' => 'user', 'title' => 'Individual (B2C) User Dashboard', 'icon' => 'bx-user', 'color' => '#71dd37'],
            ['slug' => 'agent', 'title' => 'Standard B2B Agent Dashboard', 'icon' => 'bx-briefcase-alt-2', 'color' => '#8592a3'],
            ['slug' => 'iata', 'title' => 'IATA Agent Dashboard', 'icon' => 'bx-globe', 'color' => '#ffab00'],
            ['slug' => 'corporate', 'title' => 'Corporate Dashboard', 'icon' => 'bx-building', 'color' => '#03c3ec'],
            ['slug' => 'investor', 'title' => 'Investor Panel', 'icon' => 'bx-trending-up', 'color' => '#ff3e1d'],
            ['slug' => 'hotel-partner', 'title' => 'Hotel Dashboard (Standalone)', 'icon' => 'bx-hotel', 'color' => '#20c997'],
            ['slug' => 'amadeus-partner', 'title' => 'Amadeus GDS Partner Dashboard', 'icon' => 'bx-chip', 'color' => '#007bff'],
            ['slug' => 'tour-builder', 'title' => 'Tour Builder Dashboard', 'icon' => 'bx-package', 'color' => '#fd7e14'],
            ['slug' => 'supplier', 'title' => 'Tour Supplier Dashboard', 'icon' => 'bx-package', 'color' => '#fd7e14'],
            ['slug' => 'local-provider', 'title' => 'Local Service Provider Module', 'icon' => 'bx-map-pin', 'color' => '#6f42c1'],
            ['slug' => 'accounting', 'title' => 'Dedicated Accounting Panel', 'icon' => 'bx-calculator', 'color' => '#e83e8c'],
            ['slug' => 'cargo', 'title' => 'Cargo System Panels', 'icon' => 'bxs-truck', 'color' => '#17a2b8'],
            ['slug' => 'affiliate', 'title' => 'Affiliate Dashboard', 'icon' => 'bx-share-alt', 'color' => '#d63384'],
            ['slug' => 'partner', 'title' => 'Partner B2B Portal', 'icon' => 'bx-handshake', 'color' => '#00d2ff'],
            ['slug' => 'visa-provider', 'title' => 'Visa Services Panel', 'icon' => 'bx-id-card', 'color' => '#ff4b2b'],
            ['slug' => 'iata-network', 'title' => 'Agent Global Partner Network', 'icon' => 'bx-group', 'color' => '#28a745'],
            ['slug' => 'explorer', 'title' => 'Smart Travel Explorer', 'icon' => 'bx-world', 'color' => '#6610f2'],
        ];
    @endphp

    <div class="row g-4 mb-5">
        @foreach($portals as $portal)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card-portal position-relative h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="portal-icon-wrap me-3" style="color: {{ $portal['color'] }}; background-color: {{ $portal['color'] }}15;">
                        <i class="bx {{ $portal['icon'] }} fs-2"></i>
                    </div>
                    <div class="portal-content">
                        <h6 class="mb-2 fw-bold text-dark portal-title">{{ $portal['title'] }}</h6>
                        <div class="count-box-premium d-inline-flex align-items-center">
                            <span class="fw-bold text-dark">{{ number_format($roleCounts[$portal['slug']] ?? 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Row 3: Analytics Lists -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card-sneat h-100">
                <div class="card-header pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Sales by Countries</h5>
                    <i class="bx bx-dots-vertical-rounded"></i>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-3 align-items-center">
                            <div class="avatar flex-shrink-0 me-3"><span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-flag"></i></span></div>
                            <div class="d-flex w-100 flex-wrap justify-content-between"><div><h6 class="mb-0">India</h6><small class="text-muted">Primary</small></div><h6 class="mb-0">₹{{ number_format($stats['total_revenue'] * 0.7, 0) }}</h6></div>
                        </li>
                        <li class="d-flex mb-3 align-items-center">
                            <div class="avatar flex-shrink-0 me-3"><span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-flag"></i></span></div>
                            <div class="d-flex w-100 flex-wrap justify-content-between"><div><h6 class="mb-0">UAE</h6><small class="text-muted">GCC</small></div><h6 class="mb-0">₹{{ number_format($stats['total_revenue'] * 0.3, 0) }}</h6></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card-sneat h-100">
                <div class="card-header pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Top Flight Routes</h5>
                    <i class="bx bx-dots-vertical-rounded"></i>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1"><span class="small fw-semibold">DEL - BOM</span><span class="small text-muted">80%</span></div>
                        <div class="progress" style="height: 6px;"><div class="progress-bar bg-primary" style="width: 80%"></div></div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1"><span class="small fw-semibold">DXB - LHR</span><span class="small text-muted">45%</span></div>
                        <div class="progress" style="height: 6px;"><div class="progress-bar bg-info" style="width: 45%"></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card-sneat h-100">
                <div class="card-header pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Revenue Split</h5>
                    <i class="bx bx-dots-vertical-rounded"></i>
                </div>
                <div class="card-body">
                    @foreach($serviceSplit['labels'] as $index => $label)
                    <div class="d-flex align-items-center mb-3">
                        <div class="badge bg-label-{{ ['primary', 'success', 'warning', 'info'][$index % 4] }} p-2 rounded me-3"><i class="bx bx-{{ ['paper-plane', 'hotel', 'package', 'box'][$index % 4] }} fs-6"></i></div>
                        <div class="d-flex w-100 flex-wrap justify-content-between"><div><h6 class="mb-0 text-capitalize small">{{ $label }}</h6></div><small class="fw-semibold">₹{{ number_format($serviceSplit['data'][$index], 0) }}</small></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Service Links */
    .service-link { display: flex; flex-direction: column; align-items: center; transition: 0.2s; width: 80px; }
    .service-link:hover { transform: translateY(-3px); }
    .service-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

    /* Gradient Stats */
    .card-gradient { position: relative; padding: 1.25rem; border-radius: 1rem; color: #fff; overflow: hidden; border: none; box-shadow: 0 8px 15px rgba(0,0,0,0.1); transition: 0.3s; height: 100%; }
    .card-gradient-purple { background: linear-gradient(230deg, #759bff, #843cf6); }
    .card-gradient-green { background: linear-gradient(230deg, #5fe3a1, #13ca7e); }
    .card-gradient-blue { background: linear-gradient(230deg, #4481eb, #04befe); }
    .card-gradient-yellow { background: linear-gradient(230deg, #f7d95a, #f1a21a); }
    .icon-circle-sm { width: 32px; height: 32px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .badge-trend-sm { padding: 0.15rem 0.5rem; border-radius: 20px; font-size: 0.65rem; font-weight: 700; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); }
    .card-info h4 { font-size: 1.25rem; letter-spacing: -0.5px; margin-top: 0.25rem; }
    .x-small { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }

    /* Portal Cards */
    .card-portal { background: #fff; border-radius: 12px; border: 1px solid #edf2f9; box-shadow: 0 2px 10px rgba(0,0,0,0.03); transition: all 0.2s ease; }
    .card-portal:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.08); border-color: #696cff; }
    .portal-icon-wrap { width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .portal-title { font-size: 14px; line-height: 1.2; letter-spacing: -0.2px; }
    .count-box-premium { background: #f8f9fa; padding: 4px 15px; border-radius: 8px; border: 1px solid #f1f3f5; min-width: 60px; justify-content: center; }
    .x-small { font-size: 10px; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
</style>
@endsection

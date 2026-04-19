@extends('layouts.app')

@section('title', 'Detailed Travel Trends | Trip\'Stay Explorer')

@section('styles')
<style>
    .trends-hero {
        background: linear-gradient(135deg, var(--navy) 0%, #001f3f 100%);
        padding: 80px 0;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .chart-box {
        background: #fff;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }
    .bar-wrap {
        height: 200px;
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }
    .bar {
        flex: 1;
        background: #e2e8f0;
        border-radius: 6px 6px 0 0;
        transition: all 0.3s;
        position: relative;
        cursor: pointer;
    }
    .bar:hover { background: var(--primary); }
    .bar.active { background: var(--primary); }
    .bar-label { font-size: 10px; font-weight: 800; text-align: center; margin-top: 5px; color: #64748b; }
    .price-tag { 
        position: absolute; top: -25px; left: 50%; transform: translateX(-50%);
        font-size: 9px; font-weight: 900; color: var(--navy); opacity: 0; transition: 0.3s;
    }
    .bar:hover .price-tag { opacity: 1; }
</style>
@endsection

@section('content')
<div class="trends-hero">
    <div class="container position-relative" style="z-index: 2;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 small">Home</a></li>
                <li class="breadcrumb-item active text-white small" aria-current="page">Travel Trends</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-900 mb-3">Price Trends for 2026</h1>
        <p class="text-white-50 fs-5">Identify the perfect moment to book your next journey.</p>
    </div>
</div>

<div class="container py-5" style="margin-top: -50px; position: relative; z-index: 5;">
    <div class="row g-4 text-decoration-none">
        <!-- Main Chart -->
        <div class="col-lg-8">
            <div class="chart-box">
                <div class="d-flex justify-content-between align-items-center mb-5 text-decoration-none">
                    <h5 class="fw-900 text-navy mb-0">Monthly Average Fares (Flights)</h5>
                    <select class="form-select w-auto border-0 bg-light fw-bold small rounded-pill px-3">
                        <option>Delhi → Dubai</option>
                        <option>Mumbai → London</option>
                        <option>Bangalore → Singapore</option>
                    </select>
                </div>

                <div class="bar-wrap mb-2">
                    @php
                    $data = [
                        ['m' => 'Jan', 'h' => 60, 'p' => '4.2k'], ['m' => 'Feb', 'h' => 50, 'p' => '3.9k'],
                        ['m' => 'Mar', 'h' => 65, 'p' => '4.5k'], ['m' => 'Apr', 'h' => 75, 'p' => '5.1k'],
                        ['m' => 'May', 'h' => 85, 'p' => '5.8k'], ['m' => 'Jun', 'h' => 95, 'p' => '6.2k'],
                        ['m' => 'Jul', 'h' => 70, 'p' => '4.8k'], ['m' => 'Aug', 'h' => 62, 'p' => '4.3k'],
                        ['m' => 'Sep', 'h' => 40, 'p' => '3.2k', 'active' => true], ['m' => 'Oct', 'h' => 80, 'p' => '5.4k'],
                        ['m' => 'Nov', 'h' => 58, 'p' => '4.1k'], ['m' => 'Dec', 'h' => 100, 'p' => '7.5k']
                    ];
                    @endphp
                    @foreach($data as $d)
                    <div class="bar {{ isset($d['active']) ? 'active' : '' }}" style="height: {{ $d['h'] }}%;">
                        <div class="price-tag">₹{{ $d['p'] }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex gap-2">
                    @foreach($data as $d)
                    <div class="flex-1 text-center" style="flex: 1;"><div class="bar-label">{{ $d['m'] }}</div></div>
                    @endforeach
                </div>

                <div class="mt-5 p-4 bg-primary-light rounded-4 border border-primary border-opacity-10">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-2 text-primary"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">Trip Zant Insider Tip</h6>
                            <p class="text-muted small mb-0 fw-bold">Booking 45 days in advance for September travel can save you an additional 15% on current fares.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="chart-box h-100">
                <h5 class="fw-900 text-navy mb-4">Why Book Now?</h5>
                <ul class="list-unstyled d-flex flex-column gap-4">
                    <li class="d-flex gap-3">
                        <div class="text-success"><i class="fas fa-circle-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 small text-navy">Lowest Annual Fare</h6>
                            <p class="x-small text-muted mb-0">September shows the historical low for Dubai routes.</p>
                        </div>
                    </li>
                    <li class="d-flex gap-3">
                        <div class="text-primary"><i class="fas fa-hotel"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 small text-navy">Hotel Inventory Up</h6>
                            <p class="x-small text-muted mb-0">40% more rooms available than in October peak.</p>
                        </div>
                    </li>
                    <li class="d-flex gap-3">
                        <div class="text-warning"><i class="fas fa-bolt"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 small text-navy">Instant Confirmation</h6>
                            <p class="x-small text-muted mb-0">99.2% success rate on instant bookings today.</p>
                        </div>
                    </li>
                </ul>
                <hr class="my-4">
                <button class="btn btn-navy w-100 rounded-pill py-3 fw-bold shadow-sm">SEARCH SEPTEMBER FLIGHTS</button>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', "Global IATA Partner Network | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .agent-network-card {
        background: #fff; border-radius: 20px; transition: 0.3s; border: 1px solid #edf2f7; overflow: hidden;
    }
    .agent-network-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.05); }
    .country-badge { background: #f7fafc; border: 1px solid #edf2f7; color: #4a5568; font-weight: 900; font-size: 10px; padding: 4px 10px; border-radius: 8px; }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f7fafc; min-height: 95vh;">
    <div class="container">
        <!-- Header -->
        <div class="mb-5 text-center">
            <h2 class="fw-900 text-dark mb-1">Global IATA Partner Network</h2>
            <p class="text-muted small fw-bold">Connect with certified travel agents worldwide for shared inventory and profit splitting.</p>
        </div>

        <!-- Search & Filter Bar -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-900 text-dark uppercase">Search Agent / IATA Code</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-0 bg-light py-2" placeholder="e.g. Dubai Express">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-900 text-dark uppercase">Region / Country</label>
                    <select class="form-select border-0 bg-light py-2 small fw-bold">
                        <option>ALL REGIONS</option>
                        <option>India 🇮🇳</option>
                        <option>UAE 🇦🇪</option>
                        <option>USA 🇺🇸</option>
                        <option>UK 🇬🇧</option>
                        <option>Europe 🇪🇺</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-900 text-dark uppercase">Airline Specialization</label>
                    <select class="form-select border-0 bg-light py-2 small fw-bold">
                        <option>ALL AIRLINES</option>
                        <option>Emirates</option>
                        <option>Air India</option>
                        <option>Qatar Airways</option>
                        <option>British Airways</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-900">FILTER</button>
                </div>
            </div>
        </div>

        <!-- Global Agents List -->
        <div class="row g-4">
            @php
            $globalAgents = [
                ['name' => 'Dubai Skyline Travel', 'city' => 'Dubai, UAE', 'iata' => '882045', 'rating' => 4.9, 'special' => 'Emirates', 'trust' => 98],
                ['name' => 'London Tube Flights', 'city' => 'London, UK', 'iata' => '120224', 'rating' => 4.8, 'special' => 'BA, Qatar', 'trust' => 95],
                ['name' => 'NYC Global Agency', 'city' => 'New York, USA', 'iata' => '994882', 'rating' => 5.0, 'special' => 'Delta, United', 'trust' => 99],
                ['name' => 'Singapore Wings', 'city' => 'Singapore, SG', 'iata' => '332115', 'rating' => 4.7, 'special' => 'SIA, Scoot', 'trust' => 92],
                ['name' => 'Torus Sydney', 'city' => 'Sydney, AU', 'iata' => '445990', 'rating' => 4.8, 'special' => 'Qantas', 'trust' => 96],
                ['name' => 'EuroLink Paris', 'city' => 'Paris, FR', 'iata' => '229118', 'rating' => 4.9, 'special' => 'Air France', 'trust' => 97],
            ];
            @endphp
            @foreach($globalAgents as $ga)
            <div class="col-lg-4 col-md-6">
                <div class="agent-network-card h-100 d-flex flex-column">
                    <div class="p-4 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-dark rounded-pill x-small px-3 fw-900 border"><i class="fas fa-certificate text-primary me-1"></i> IATA {{ $ga['iata'] }}</span>
                            <div class="small fw-900 text-warning">⭐ {{ $ga['rating'] }}</div>
                        </div>
                        <h5 class="fw-900 text-dark mb-1">{{ $ga['name'] }}</h5>
                        <div class="x-small fw-bold text-muted mb-4"><i class="fas fa-location-dot me-1"></i> {{ $ga['city'] }}</div>
                        
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <div class="x-small fw-900 text-muted uppercase" style="font-size: 8px;">Specialization</div>
                                <div class="small fw-bold text-dark">{{ $ga['special'] }}</div>
                            </div>
                            <div class="col-6 text-end">
                                <div class="x-small fw-900 text-muted uppercase" style="font-size: 8px;">Trust Score</div>
                                <div class="small fw-900 text-success">{{ $ga['trust'] }}%</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 mt-auto">
                        <div class="d-grid gap-2">
                            <button class="btn btn-navy py-3 rounded-pill fw-900 shadow-sm" style="background:#1a202c; color:#fff;" onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin me-2\'></i> SENDING...'; this.classList.add('disabled');">
                                <i class="fas fa-link me-2"></i> CONNECT AS PARTNER
                            </button>
                            <a href="{{ route('agent.profile', ['id' => $ga['iata']]) }}" class="btn btn-light py-2 rounded-pill fw-900 small shadow-sm text-decoration-none">VIEW PROFILE</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Global Metrics Footer -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mt-5 bg-navy text-white text-center" style="background: linear-gradient(135deg, #1a202c, #2d3748);">
            <div class="row g-4">
                <div class="col-md-4 border-end border-light">
                    <h5 class="fw-900 mb-1">50K+</h5>
                    <div class="x-small fw-bold text-white opacity-75 uppercase">GLOBAL AGENTS</div>
                </div>
                <div class="col-md-4 border-end border-light">
                    <h5 class="fw-900 mb-1">190+</h5>
                    <div class="x-small fw-bold text-white opacity-75 uppercase">COUNTRIES COVERED</div>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-900 mb-1">₹42 Crore</h5>
                    <div class="x-small fw-bold text-white opacity-75 uppercase">MONTHLY SHARED PROFIT</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

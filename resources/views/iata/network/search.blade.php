@extends('layouts.iata_panel')

@section('title', 'Search Agents | Multi-Agent Collaboration')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-800 text-navy mb-1 outfit">Global IATA Network</h4>
            <p class="text-muted small fw-700 uppercase">Connect with other agents to share bookings and profits.</p>
        </div>
        <a href="{{ route('iata.network.requests') }}" class="btn btn-light border fw-800 rounded-pill px-4">
            <i class="fas fa-paper-plane me-2"></i> Track My Requests
        </a>
    </div>

    <!-- Search Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-5 border border-light">
        <form class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-0 bg-light py-2 fw-700" placeholder="Search by Agent Name, IATA ID, or City...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select border-0 bg-light py-2 fw-700">
                    <option>Select City</option>
                    <option>New Delhi</option>
                    <option>Mumbai</option>
                    <option>Dubai</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select border-0 bg-light py-2 fw-700">
                    <option>Rating 4+</option>
                    <option>Verified Only</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-iata w-100 fw-800">Search Agents</button>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div class="row g-4">
        @php
        $agents = [
            ['name' => 'Global Fly Travels', 'id' => 'IATA-882045', 'city' => 'New York, USA', 'special' => 'International Specialist', 'rating' => '4.9', 'status' => 'Connect'],
            ['name' => 'Middle East Expeditions', 'id' => 'IATA-120224', 'city' => 'Dubai, UAE', 'special' => 'Middle East GSA', 'rating' => '4.8', 'status' => 'Pending'],
            ['name' => 'London Express Travel', 'id' => 'IATA-994882', 'city' => 'London, UK', 'special' => 'Corporate Travel', 'rating' => '5.0', 'status' => 'Connect'],
            ['name' => 'Singapore High-Flyers', 'id' => 'IATA-110022', 'city' => 'Singapore', 'special' => 'Asia Consolidator', 'rating' => '4.7', 'status' => 'Connect'],
        ];
        @endphp

        @foreach($agents as $a)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100 agent-card-search">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="avatar bg-blue-soft rounded-4 d-flex align-items-center justify-content-center fw-900 outfit" style="width: 54px; height: 54px; font-size: 1.5rem;">
                        {{ substr($a['name'], 0, 1) }}
                    </div>
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-1 x-small fw-800 shadow-sm text-dark">⭐ {{ $a['rating'] }}</span>
                </div>
                
                <h6 class="fw-800 text-navy outfit mb-1">{{ $a['name'] }}</h6>
                <div class="text-primary small fw-800 mb-2">{{ $a['id'] }}</div>
                
                <div class="d-flex align-items-center gap-2 text-muted x-small fw-700 mb-3">
                    <i class="fas fa-location-dot text-danger"></i> {{ $a['city'] }}
                </div>
                
                <div class="bg-light p-2 rounded-3 mb-4">
                    <div class="x-small fw-800 text-muted uppercase mb-1" style="font-size: 9px;">Specialization</div>
                    <div class="small fw-700 text-navy">{{ $a['special'] }}</div>
                </div>

                <div class="mt-auto">
                    @if($a['status'] == 'Pending')
                        <button class="btn btn-light w-100 fw-800 rounded-pill py-2 border disabled" style="opacity: 0.7;">
                            <i class="fas fa-clock me-2"></i> REQUEST SENT
                        </button>
                    @else
                        <button class="btn btn-iata w-100 fw-800 rounded-pill py-2" onclick="sendRequest(this)">
                            CONNECT <i class="fas fa-plus ms-2"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function sendRequest(btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i> SENDING...';
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-check me-2"></i> REQUEST SENT';
            btn.className = 'btn btn-light border w-100 fw-800 rounded-pill py-2';
        }, 1500);
    }
</script>
@endsection

@section('styles')
<style>
    .agent-card-search { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .agent-card-search:hover { transform: translateY(-8px); border-color: var(--iata-blue-light) !important; box-shadow: 0 15px 30px rgba(0,0,0,0.05) !important; }
    .bg-blue-soft { background-color: #eff6ff; color: #1e40af; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

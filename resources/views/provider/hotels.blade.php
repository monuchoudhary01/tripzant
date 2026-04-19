@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-6">
            <h4 class="fw-800">Search Hotels</h4>
            <p class="text-muted small">Connect with hotels to receive direct booking requests for your services.</p>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end gap-3 text-end">
             <div class="bg-primary bg-opacity-10 text-primary rounded-pill px-4 py-2 small fw-800">
                <i class="fas fa-link me-1"></i> ACTIVE CONNECTIONS: 42
             </div>
        </div>
    </div>

    <!-- Filters Row -->
    <div class="card border-0 p-3 mb-5 rounded-4 shadow-sm">
        <div class="row g-3 align-items-end">
            <div class="col-lg-3">
                <label class="form-label fw-700 small text-muted">LOCATION</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-location-dot small"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="e.g. New Delhi">
                </div>
            </div>
            <div class="col-lg-3">
                <label class="form-label fw-700 small text-muted">HOTEL TYPE</label>
                <select class="form-select">
                    <option>5 Star Luxury</option>
                    <option>Boutique</option>
                    <option>Resorts</option>
                    <option>Business Hotels</option>
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label fw-700 small text-muted">SEARCH BY NAME</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search small"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search hotels...">
                </div>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary w-100 py-2 rounded-pill fw-800">Apply Filters</button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @php
            $hotels = [
                ['name' => 'The Oberoi New Delhi', 'loc' => 'Dr. Zakir Hussain Marg', 'rating' => '5.0', 'img' => 'https://media-cdn.tripadvisor.com/media/photo-s/11/ad/03/f3/the-oberoi-new-delhi.jpg', 'connected' => true],
                ['name' => 'Taj Palace', 'loc' => 'Sardar Patel Marg', 'rating' => '4.9', 'img' => 'https://lh3.googleusercontent.com/p/AF1QipN3m5x...', 'connected' => false],
                ['name' => 'Roseate House NCR', 'loc' => 'Aerocity, New Delhi', 'rating' => '4.8', 'img' => 'https://lh3.googleusercontent.com/p/AF1QipM...', 'connected' => false],
                ['name' => 'ITC Maurya', 'loc' => 'Chanakyapuri', 'rating' => '4.9', 'img' => 'https://lh3.googleusercontent.com/p/AF1QipP...', 'connected' => true],
            ];
        @endphp

        @foreach($hotels as $h)
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 overflow-hidden h-100">
                <div class="position-relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($h['name']) }}&background=2563eb&color=fff&size=512" class="card-img-top" alt="{{ $h['name'] }}" style="height:180px; object-fit:cover;">
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge bg-white text-dark rounded-pill shadow-sm"><i class="fas fa-star text-warning small"></i> {{ $h['rating'] }}</span>
                    </div>
                    @if($h['connected'])
                        <div class="position-absolute top-0 start-0 p-3">
                            <span class="badge bg-success text-white rounded-pill shadow-sm small fw-800">CONNECTED</span>
                        </div>
                    @endif
                </div>
                <div class="p-3 card-body">
                    <h6 class="fw-800 mb-1 line-clamp-1">{{ $h['name'] }}</h6>
                    <p class="text-muted smaller fw-600 mb-4"><i class="fas fa-map-marker-alt me-1"></i> {{ $h['loc'] }}</p>
                    
                    <div class="d-flex flex-column gap-2 mt-auto">
                        @if($h['connected'])
                            <button class="btn btn-primary w-100 rounded-pill fw-800 py-2" style="font-size:12px;">SEND SERVICE UPDATE</button>
                        @else
                            <button class="btn btn-outline-primary w-100 rounded-pill fw-800 py-2" style="font-size:12px;">SEND CONNECTION REQUEST</button>
                        @endif
                        <button class="btn btn-link text-muted w-100 fw-700 smaller text-decoration-none">View Hotel Details</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .smaller { font-size: 11px; }
</style>
@endsection

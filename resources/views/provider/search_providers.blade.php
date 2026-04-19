@extends('layouts.provider') {{-- Reusing simple layout for demo --}}

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-800">Discover Local Service Providers</h4>
            <p class="text-muted small">Find the best local guides, drivers, and helpers for your guests or tour packages.</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3">
            <div class="card border-0 p-4 sticky-top" style="top: 100px;">
                <h6 class="fw-800 mb-4">Filters</h6>
                
                <div class="mb-4">
                    <label class="form-label fw-800 smaller text-muted uppercase">SERVICE TYPE</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" checked id="st1">
                        <label class="form-check-label small fw-600" for="st1">Tour Guide</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="st2">
                        <label class="form-check-label small fw-600" for="st2">Driver / Transport</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="st3">
                        <label class="form-check-label small fw-600" for="st3">Photography</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-800 smaller text-muted uppercase">LOCATION</label>
                    <select class="form-select small fw-700">
                        <option>New Delhi</option>
                        <option>Mumbai</option>
                        <option>Jaipur</option>
                        <option>Agra</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-800 smaller text-muted uppercase">PRICE RANGE (INR)</label>
                    <input type="range" class="form-range" min="500" max="10000" id="priceRange">
                    <div class="d-flex justify-content-between">
                         <span class="smaller fw-700 text-muted">₹500</span>
                         <span class="smaller fw-700 text-muted">₹10K+</span>
                    </div>
                </div>

                 <div class="mb-4">
                    <label class="form-label fw-800 smaller text-muted uppercase">MINIMUM RATING</label>
                    <div class="d-flex gap-2">
                        @for($i=1; $i<=5; $i++)
                            <button class="btn btn-outline-light border text-muted p-2 rounded-3 flex-grow-1 small fw-800 {{ $i == 4 ? 'bg-primary text-white border-primary' : '' }}">{{ $i }}<i class="fas fa-star ms-1" style="font-size:8px;"></i></button>
                        @endfor
                    </div>
                </div>

                <button class="btn btn-primary w-100 py-2 rounded-pill fw-800 shadow-sm mt-3">Apply Filters</button>
            </div>
        </div>

        <div class="col-lg-9">
             <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-800 text-muted small mb-0">SHOWING 248 PROVIDERS IN NEW DELHI</h6>
                <div class="dropdown">
                    <button class="btn btn-white bg-white border-0 shadow-sm rounded-pill px-4 fw-800 small dropdown-toggle" data-bs-toggle="dropdown">Sort by: Recommended</button>
                </div>
            </div>

            <div class="row g-4">
                @php
                    $providers = [
                        ['name' => 'Rahul Sharma', 'title' => 'Heritage Guide & Driver', 'price' => '1,200', 'rating' => '4.9', 'reviews' => '128', 'services' => 'Tours, Transport, Guide'],
                        ['name' => 'Anjali Gupta', 'title' => 'Culinary Expert & Local Foodie', 'price' => '2,500', 'rating' => '4.8', 'reviews' => '84', 'services' => 'Cooking, Tasting, Markets'],
                        ['name' => 'Vikram Singh', 'title' => 'Professional Desert Guide', 'price' => '3,500', 'rating' => '5.0', 'reviews' => '210', 'services' => 'Camping, Driving, Camel Safari'],
                        ['name' => 'Deepak Verma', 'title' => 'Airport Transfer Specialist', 'price' => '900', 'rating' => '4.7', 'reviews' => '342', 'services' => 'Transport, Meet & Greet'],
                    ];
                @endphp

                @foreach($providers as $p)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 p-4 h-100 shadow-sm provider-card">
                        <div class="text-center mb-3">
                            <div class="position-relative d-inline-block">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($p['name']) }}&background=random" class="rounded-circle mb-3 border p-1" width="80" height="80">
                                <span class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width:16px; height:16px;"></span>
                            </div>
                            <h6 class="fw-800 mb-1">{{ $p['name'] }}</h6>
                            <p class="text-muted smaller fw-700 mb-3">{{ $p['title'] }}</p>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 smaller fw-800"><i class="fas fa-star me-1"></i> {{ $p['rating'] }} ({{ $p['reviews'] }})</span>
                            </div>
                        </div>

                        <div class="bg-light rounded-4 p-3 mb-4">
                            <h6 class="smaller fw-700 text-muted uppercase mb-2">SERVICES OFFERED</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach(explode(', ', $p['services']) as $s)
                                    <span class="badge bg-white text-primary border border-primary border-opacity-10 rounded-pill px-2 py-1" style="font-size:9px; font-weight:800;">{{ $s }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <p class="mb-0 text-muted smaller fw-700 uppercase">STARTING FROM</p>
                                <h5 class="fw-900 mb-0">₹{{ $p['price'] }}</h5>
                            </div>
                            <i class="fas fa-circle-check text-success fs-5"></i>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                             <button class="btn btn-primary flex-grow-1 rounded-pill fw-800 py-2 small shadow-sm">SEND REQUEST</button>
                             <button class="btn btn-outline-custom rounded-circle p-2" style="width:38px; height:38px;"><i class="fas fa-phone-alt small text-primary"></i></button>
                        </div>
                        <button class="btn btn-link text-muted w-100 fw-700 smaller text-decoration-none mt-2">View Full Profile</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .provider-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .provider-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important; }
    .smaller { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .rounded-4 { border-radius: 12px !important; }
    .btn-outline-custom { border-color: var(--border-color); }
</style>
@endsection

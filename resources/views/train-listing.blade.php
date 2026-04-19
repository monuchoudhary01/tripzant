@extends('layouts.app')

@section('title', "Train Booking: $origin → $destination | Tripzant" )
@section('active-trains', 'active')

@section('content')
    <div class="listing-hero">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="breadcrumb-custom mb-1" style="margin-bottom:0;">
                        <a href="/" style="color:rgba(255,255,255,.5);">Home</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <span class="current" style="color:#fff;">Trains</span>
                    </div>
                    <h4 class="mb-0 fw-800" style="font-size:20px;">{{ $origin }} <i class="fas fa-arrow-right mx-2" style="color:var(--primary);font-size:14px;"></i> {{ $destination }}</h4>
                    <p style="font-size:13px;opacity:.7;margin-bottom:0;">{{ date('D, d M Y') }} · All Classes · 1 Passenger</p>
                </div>
                <button class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size:13px;font-weight:600;"><i class="fas fa-pen me-2"></i>Modify</button>
            </div>
        </div>
    </div>

    <!-- Class strip -->
    <div style="background:#fff;border-bottom:1px solid var(--gray-100);">
        <div class="container py-2">
            <div class="d-flex gap-2 overflow-auto">
                <span class="px-3 py-2 rounded-pill" style="font-size:12px;font-weight:600;cursor:pointer;background:var(--navy);color:#fff;">All Classes</span>
                <span class="px-3 py-2 rounded-pill" style="font-size:12px;font-weight:600;cursor:pointer;background:var(--gray-50);">3A</span>
                <span class="px-3 py-2 rounded-pill" style="font-size:12px;font-weight:600;cursor:pointer;background:var(--gray-50);">2A</span>
                <span class="px-3 py-2 rounded-pill" style="font-size:12px;font-weight:600;cursor:pointer;background:var(--gray-50);">1A</span>
                <span class="px-3 py-2 rounded-pill" style="font-size:12px;font-weight:600;cursor:pointer;background:var(--gray-50);">SL</span>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="filter-card sticky-top" style="top:80px;">
                    <div class="filter-title"><i class="fas fa-sliders-h" style="color:var(--secondary);"></i> Filters</div>

                    <div class="filter-group">
                        <div class="filter-group-title">Departure Time</div>
                        <div class="row g-2">
                            <div class="col-6"><div class="text-center p-2 rounded-3 border" style="cursor:pointer;font-size:11px;"><i class="fas fa-sun mb-1 d-block" style="color:var(--primary);"></i>06:00–12:00</div></div>
                            <div class="col-6"><div class="text-center p-2 rounded-3 border" style="cursor:pointer;font-size:11px;"><i class="fas fa-cloud-sun mb-1 d-block" style="color:var(--secondary);"></i>12:00–18:00</div></div>
                            <div class="col-6"><div class="text-center p-2 rounded-3 border" style="cursor:pointer;font-size:11px;"><i class="fas fa-moon mb-1 d-block" style="color:var(--navy);"></i>18:00–00:00</div></div>
                            <div class="col-6"><div class="text-center p-2 rounded-3 border" style="cursor:pointer;font-size:11px;"><i class="fas fa-star-and-crescent mb-1 d-block" style="color:var(--gray-400);"></i>00:00–06:00</div></div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Availability</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="av1" checked><label class="form-check-label small" for="av1">Available</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="av2"><label class="form-check-label small" for="av2">RAC</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="av3"><label class="form-check-label small" for="av3">Waitlist</label></div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Train Type</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="tt1" checked><label class="form-check-label small" for="tt1">Rajdhani</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="tt2"><label class="form-check-label small" for="tt2">Shatabdi</label></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="results-bar">
                    <div>
                        <h5 class="fw-800 mb-0" style="font-size:16px;">{{ $trains->count() }} Trains Found</h5>
                        <span style="font-size:12px;color:var(--gray-300);">{{ $origin }} → {{ $destination }} · {{ date('D, d M Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:12px;color:var(--gray-300);">Sort by:</span>
                        <select class="form-select form-select-sm" style="width:auto;border-radius:8px;font-size:12px;font-weight:600;">
                            <option>Departure Time</option>
                            <option>Duration</option>
                            <option>Price</option>
                        </select>
                    </div>
                </div>

                @foreach($trains as $train)
                <x-listing-card 
                    type="train" 
                    title="{{ $train->train_number }} - {{ $train->train_name }}" 
                    subtitle="{{ $train->origin }} ({{ date('H:i', strtotime($train->departure_time)) }}) → {{ $train->destination }} ({{ date('H:i', strtotime($train->arrival_time)) }})" 
                    price="{{ number_format($train->base_fare) }}" 
                />
                @endforeach
                
                @if($trains->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-train fs-1 text-muted opacity-50 mb-3"></i>
                    <h5 class="fw-800 text-muted">No Trains found for this route</h5>
                    <p class="text-muted small">Try searching for New Delhi to Mumbai</p>
                </div>
                @endif

                <div class="text-center TS-4">
                    <button class="btn btn-outline-custom px-5 py-3"><i class="fas fa-plus me-2"></i> Load More Trains</button>
                </div>
            </div>
        </div>
    </div>
@endsection

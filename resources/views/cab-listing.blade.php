@extends('layouts.app')

@section('title', " Book Cabs — Trip Zant Booking.com " )
@section('active-cabs', 'active')

@section('content')
    <div class="listing-hero">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="breadcrumb-custom mb-1" style="margin-bottom:0;">
                        <a href="/" style="color:rgba(255,255,255,.5);">Home</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <span class="current" style="color:#fff;">Cabs</span>
                    </div>
                    <h4 class="mb-0 fw-800" style="font-size:20px;">Delhi Airport <i class="fas fa-arrow-right mx-2" style="color:var(--primary);font-size:14px;"></i> Noida</h4>
                    <p style="font-size:13px;opacity:.7;margin-bottom:0;">Today, 10:00 PM · One Way · Sedan / Hatchback</p>
                </div>
                <button class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size:13px;font-weight:600;"><i class="fas fa-pen me-2"></i>Modify</button>
            </div>
        </div>
    </div>

    <!-- Trip type strip -->
    <div style="background:#fff;border-bottom:1px solid var(--gray-100);">
        <div class="container py-2">
            <div class="d-flex gap-3">
                <div class="text-center px-4 py-2 rounded-3" style="background:rgba(0,168,225,.06);border:1.5px solid var(--blue);min-width:130px;cursor:pointer;">
                    <i class="fas fa-arrow-right d-block mb-1" style="color:var(--secondary);font-size:14px;"></i>
                    <div class="fw-700" style="font-size:12px;color:var(--navy);">One Way</div>
                </div>
                <div class="text-center px-4 py-2 rounded-3" style="background:var(--gray-50);border:1.5px solid transparent;min-width:130px;cursor:pointer;">
                    <i class="fas fa-exchange-alt d-block mb-1" style="color:var(--gray-400);font-size:14px;"></i>
                    <div class="fw-700" style="font-size:12px;color:var(--gray-400);">Round Trip</div>
                </div>
                <div class="text-center px-4 py-2 rounded-3" style="background:var(--gray-50);border:1.5px solid transparent;min-width:130px;cursor:pointer;">
                    <i class="fas fa-clock d-block mb-1" style="color:var(--gray-400);font-size:14px;"></i>
                    <div class="fw-700" style="font-size:12px;color:var(--gray-400);">Hourly Rental</div>
                </div>
                <div class="text-center px-4 py-2 rounded-3" style="background:var(--gray-50);border:1.5px solid transparent;min-width:130px;cursor:pointer;">
                    <i class="fas fa-plane-arrival d-block mb-1" style="color:var(--gray-400);font-size:14px;"></i>
                    <div class="fw-700" style="font-size:12px;color:var(--gray-400);">Airport Transfer</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="filter-card sticky-top" style="top:80px;">
                    <div class="filter-title"><i class="fas fa-sliders-h" style="color:var(--secondary);"></i> Filters</div>

                    <div class="filter-group">
                        <div class="filter-group-title">Car Type</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="c1" checked><label class="form-check-label small" for="c1">Hatchback <span style="color:var(--gray-200);font-size:11px;">₹899</span></label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="c2" checked><label class="form-check-label small" for="c2">Sedan <span style="color:var(--gray-200);font-size:11px;">₹1,299</span></label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="c3"><label class="form-check-label small" for="c3">SUV <span style="color:var(--gray-200);font-size:11px;">₹1,899</span></label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="c4"><label class="form-check-label small" for="c4">Luxury <span style="color:var(--gray-200);font-size:11px;">₹3,499</span></label></div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Fuel Type</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="f1"><label class="form-check-label small" for="f1">CNG</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="f2"><label class="form-check-label small" for="f2">Electric</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="f3" checked><label class="form-check-label small" for="f3">Petrol / Diesel</label></div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Provider</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="p1" checked><label class="form-check-label small" for="p1">Trip Zant Assured</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="p2"><label class="form-check-label small" for="p2">Savaari</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="p3"><label class="form-check-label small" for="p3">Easyday</label></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="results-bar">
                    <div>
                        <h5 class="fw-800 mb-0" style="font-size:16px;">{{ count($transfers ?? []) }} Transfers Available</h5>
                        <span style="font-size:12px;color:var(--gray-300);">Route: {{ $params['startLocation'] ?? 'Airport' }} <i class="fas fa-arrow-right"></i> {{ $params['endLocation'] ?? 'Destination' }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:12px;color:var(--gray-300);">Sort by:</span>
                        <select class="form-select form-select-sm" style="width:auto;border-radius:8px;font-size:12px;font-weight:600;">
                            <option>Price: Low to High</option>
                            <option>Rating</option>
                        </select>
                    </div>
                </div>

                @if(isset($transfers) && count($transfers) > 0)
                    @foreach($transfers as $cab)
                        <x-listing-card 
                            type="cab" 
                            title="{{ $cab['vehicle'] ?? 'Standard Car' }}" 
                            subtitle="{{ $cab['category'] ?? 'Private' }} · Max {{ $cab['max_pax'] ?? 4 }} Seater · {{ $cab['provider'] ?? 'Local Transfer' }}" 
                            price="{{ $cab['price'] ?? 1000 }}" 
                        />
                    @endforeach
                @else
                    <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
                        <div class="py-5">
                            <i class="fas fa-car text-muted opacity-50 fa-3x mb-3"></i>
                            <h4 class="fw-900 outfit text-navy">No Transfers Found</h4>
                            <p class="text-muted fw-bold">Try adjusting your filters or search destination.</p>
                        </div>
                    </div>
                @endif

                <div class="text-center TS-4">
                    <button class="btn btn-outline-custom px-5 py-3"><i class="fas fa-plus me-2"></i> Load More Options</button>
                </div>
            </div>
        </div>
    </div>
@endsection

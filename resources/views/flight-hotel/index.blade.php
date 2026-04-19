@extends('layouts.app')

@section('title', 'Flight + Hotel Bundle Deals | Tripzant')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #0b3d61 0%, #001f3f 100%); color: #fff; min-height: 400px; display: flex; align-items: center;">
    <div class="container text-center">
        <h1 class="display-4 fw-900 mb-3 animate-up">Flight + Hotel <span class="text-orange">Bundles</span></h1>
        <p class="fs-5 text-white-50 mb-5 animate-up">Save up to 35% by booking your flight and hotel together.</p>
        
        <div class="card border-0 shadow-lg p-4 text-dark rounded-4 animate-up mx-auto" style="max-width: 900px;">
            <form action="{{ route('flight-hotel.search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3 text-start">
                        <label class="small fw-800 text-muted mb-2">FROM</label>
                        <div class="p-2 border rounded-3 d-flex align-items-center gap-2">
                            <i class="fas fa-plane-departure text-primary"></i>
                            <input type="text" name="from" class="form-control border-0 shadow-none fw-bold" value="Delhi">
                        </div>
                    </div>
                    <div class="col-md-3 text-start">
                        <label class="small fw-800 text-muted mb-2">TO</label>
                        <div class="p-2 border rounded-3 d-flex align-items-center gap-2">
                            <i class="fas fa-plane-arrival text-primary"></i>
                            <input type="text" name="to" class="form-control border-0 shadow-none fw-bold" value="Goa">
                        </div>
                    </div>
                    <div class="col-md-3 text-start">
                        <label class="small fw-800 text-muted mb-2">DEPARTURE</label>
                        <div class="p-2 border rounded-3 d-flex align-items-center gap-2">
                            <i class="fas fa-calendar text-primary"></i>
                            <input type="date" name="date" class="form-control border-0 shadow-none fw-bold" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-orange w-100 py-3 fw-900 rounded-pill shadow">SEARCH BUNDLES</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border">
                    <div class="fs-1 text-primary mb-3"><i class="fas fa-tags"></i></div>
                    <h5 class="fw-800">Unbeatable Savings</h5>
                    <p class="text-muted small mb-0">Our algorithms find the best combination of flight and hotel to give you maximum discounts.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border">
                    <div class="fs-1 text-success mb-3"><i class="fas fa-shield-check"></i></div>
                    <h5 class="fw-800">Verified Properties</h5>
                    <p class="text-muted small mb-0">All hotels in our bundles are handpicked and verified for quality and safety.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border">
                    <div class="fs-1 text-warning mb-3"><i class="fas fa-clock"></i></div>
                    <h5 class="fw-800">One-Step Booking</h5>
                    <p class="text-muted small mb-0">Manage your entire trip in one place. One payment, one confirmation, zero hassle.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('content')
<div class="provider-detail py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('marketplace.index') }}">Marketplace</a></li>
                <li class="breadcrumb-item active">{{ $provider->service_category }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Gallery Mockup -->
                <div class="row g-3 mb-5">
                    <div class="col-md-8">
                        <img src="https://source.unsplash.com/featured/?{{ $provider->service_category }},work&sig=1" class="w-100 h-100 rounded-4 shadow-sm" style="min-height: 400px; object-fit: cover;">
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column gap-3 h-100">
                            <img src="https://source.unsplash.com/featured/?{{ $provider->service_category }},work&sig=2" class="w-100 h-50 rounded-4 shadow-sm" style="object-fit: cover;">
                            <img src="https://source.unsplash.com/featured/?{{ $provider->service_category }},work&sig=3" class="w-100 h-50 rounded-4 shadow-sm" style="object-fit: cover;">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">{{ $provider->service_category }} by {{ $provider->name }}</h2>
                        <span class="text-muted">{{ $provider->provider_location }} • 5 years experience</span>
                    </div>
                    <div class="avatar bg-light p-1 rounded-circle">
                        <img src="https://i.pravatar.cc/150?u={{ $provider->id }}" class="rounded-circle" style="width: 60px; height: 60px;">
                    </div>
                </div>

                <hr class="my-5">

                <div class="d-flex gap-4 mb-5">
                    <div class="feature-item p-3 border rounded-4 flex-grow-1 text-center">
                        <div class="text-dark fw-bold mb-1">4.9 ★</div>
                        <div class="text-muted small">Reviews</div>
                    </div>
                    <div class="feature-item p-3 border rounded-4 flex-grow-1 text-center">
                        <div class="text-dark fw-bold mb-1">Top Rated</div>
                        <div class="text-muted small">Category</div>
                    </div>
                    <div class="feature-item p-3 border rounded-4 flex-grow-1 text-center">
                        <div class="text-dark fw-bold mb-1">Verified</div>
                        <div class="text-muted small">ID Check</div>
                    </div>
                </div>

                <h4 class="fw-bold mb-4">About the Service</h4>
                <p class="text-muted fs-5 leading-relaxed">
                    {{ $provider->name }} is a professional {{ $provider->service_category }} based in {{ $provider->provider_location }}. 
                    With over 5 years of experience, they provide high-quality services tailored to your needs. 
                    Whether you need a quick fix or a detailed consultation, {{ $provider->name }} is here to help.
                </p>
                <ul class="text-muted fs-6 mt-4">
                    <li class="mb-2">Highly professional and punctual</li>
                    <li class="mb-2">All equipment provided</li>
                    <li class="mb-2">Available for both home and studio sessions</li>
                </ul>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow rounded-4 p-4 sticky-top" style="top: 100px;">
                    <h4 class="fw-bold mb-4">₹{{ number_format($provider->pricing) }} <span class="fs-6 text-muted fw-normal">/ hour</span></h4>
                    
                    <form action="{{ route('marketplace.book', $provider->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold text-dark d-block mb-2">DATE & TIME</label>
                            <input type="datetime-local" class="form-control rounded-3 p-3 bg-light border-0" required>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold text-dark d-block mb-2">DETAILS</label>
                            <textarea class="form-control rounded-3 p-3 bg-light border-0" placeholder="Add any special requests..." rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-5 mb-3" style="background: #ff385c; border: none;">Book Now</button>
                    </form>
                    
                    <div class="text-center small text-muted">You won't be charged yet</div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <span>₹{{ number_format($provider->pricing) }} x 1 hour</span>
                        <span>₹{{ number_format($provider->pricing) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Service Fee</span>
                        <span>₹99</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>₹{{ number_format($provider->pricing + 99) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

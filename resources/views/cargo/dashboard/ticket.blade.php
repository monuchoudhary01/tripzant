@extends('layouts.user_dashboard')

@section('title', 'Booking Confirmation | TripZant')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 animate__animated animate__zoomIn">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-4 text-center">
                    <div class="icon-circle bg-white text-primary mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i class="fas fa-check fa-2x"></i>
                    </div>
                    <h2 class="fw-bold mb-0">Shipment Booked Successfully!</h2>
                    <p class="mb-0">Your cargo is now scheduled for pickup.</p>
                </div>
                <div class="card-body p-5">
                    <div class="row mb-5">
                        <div class="col-6">
                            <h6 class="text-muted small text-uppercase fw-bold">Booking Reference</h6>
                            <h4 class="fw-bold text-dark">#{{ $booking->booking_ref }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="text-muted small text-uppercase fw-bold">Current Status</h6>
                            <span class="badge bg-soft-info text-info rounded-pill px-3 py-2 fw-bold">{{ $booking->status }}</span>
                        </div>
                    </div>

                    <!-- Cargo Ticket Style -->
                    <div class="p-4 rounded-4 border border-2 border-dashed bg-light mb-5">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <h5 class="fw-bold mb-1">{{ $booking->origin_city }}</h5>
                                <p class="small text-muted mb-0">{{ $booking->origin_country }}</p>
                            </div>
                            <div class="col-md-2 text-center">
                                <i class="fas fa-truck fa-2x text-primary opacity-50"></i>
                            </div>
                            <div class="col-md-5 text-end">
                                <h5 class="fw-bold mb-1">{{ $booking->destination_city }}</h5>
                                <p class="small text-muted mb-0">{{ $booking->destination_country }}</p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-4 text-center">
                                <small class="text-muted d-block small">WEIGHT</small>
                                <span class="fw-bold">{{ $booking->weight }} KG</span>
                            </div>
                            <div class="col-4 text-center border-start border-end">
                                <small class="text-muted d-block small">TYPE</small>
                                <span class="fw-bold">{{ $booking->parcel_type }}</span>
                            </div>
                            <div class="col-4 text-center">
                                <small class="text-muted d-block small">PROVIDER</small>
                                <span class="fw-bold">{{ $booking->provider->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="{{ route('cargo.dashboard.tracking', $booking->booking_ref) }}" class="btn btn-primary btn-lg rounded-pill w-100 py-3 shadow-sm">
                            <i class="fas fa-search-location me-2"></i> Track Live Shipment
                        </a>
                        <button class="btn btn-outline-dark btn-lg rounded-pill px-4 py-3" onclick="window.print()">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('cargo.dashboard.index') }}" class="text-primary fw-bold text-decoration-none small">
                            Return to Dashboard <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background: rgba(54, 185, 204, 0.1); }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

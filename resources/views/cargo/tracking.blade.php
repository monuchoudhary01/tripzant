@extends('layouts.app')

@section('title', 'Track Your Global Shipment | Trip Zant')

@section('content')
<div class="py-5" style="background: #f4f7f9; min-height: 80vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Search Card -->
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 mb-5">
                    <h3 class="fw-bold text-navy mb-4"><i class="fas fa-barcode me-2 text-primary"></i> Track Shipment</h3>
                    <p class="text-muted small mb-4">Enter your TZC reference code to check real-time status and customs clearance progress.</p>
                    
                    <form action="{{ route('cargo.track') }}" method="GET">
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="text" name="ref" value="{{ $ref }}" class="form-control rounded-start-pill py-3 px-4 border-light bg-light" placeholder="e.g. TZC-123456" required>
                            <button class="btn btn-primary px-4 rounded-end-pill fw-bold">LOCATE <i class="fas fa-search ms-2"></i></button>
                        </div>
                    </form>
                </div>

                @if($ref && !$booking)
                <div class="alert alert-danger rounded-4 border-0 shadow-sm p-4 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Tracking ID Not Found</h6>
                            <p class="small mb-0">The reference <b>{{ $ref }}</b> does not exist in our systems. Please check your ticket or scan the QR code again.</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($booking)
                <!-- Tracking Result Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                    <div class="card-header bg-dark text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-1 small">SHIPMENT REFERENCE</h6>
                                <h4 class="fw-bold mb-0">#{{ $booking->booking_ref }}</h4>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold text-uppercase">{{ $booking->status }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row mb-5">
                            <div class="col-6">
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px;">FROM</small>
                                <h6 class="fw-bold text-navy">{{ $booking->origin_city }}, {{ $booking->origin_country }}</h6>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px;">TO</small>
                                <h6 class="fw-bold text-navy">{{ $booking->destination_city }}, {{ $booking->destination_country }}</h6>
                            </div>
                        </div>

                        <!-- Progress Timeline -->
                        <div class="tracking-history ps-3 border-start border-2 border-primary position-relative">
                            @foreach($booking->tracking->sortByDesc('created_at') as $index => $log)
                            <div class="history-item mb-4 position-relative">
                                <div class="dot bg-primary position-absolute rounded-circle shadow-sm" style="width:12px; height:12px; left:-19px; top:6px;"></div>
                                <h6 class="fw-bold mb-1 {{ $index === 0 ? 'text-primary' : 'text-dark' }}">{{ $log->status }}</h6>
                                <p class="small text-muted mb-1">{{ $log->description }}</p>
                                <small class="text-muted x-small italic">{{ $log->created_at->format('M d, Y - H:i A') }}</small>
                            </div>
                            @endforeach
                            
                            <!-- Initial Point -->
                            <div class="history-item position-relative opacity-50">
                                <div class="dot bg-secondary position-absolute rounded-circle" style="width:10px; height:10px; left:-18px; top:6px;"></div>
                                <h6 class="small fw-bold mb-0">Shipment Created</h6>
                                <small class="text-muted x-small">{{ $booking->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 p-4 text-center">
                        <a href="{{ route('cargo.dashboard.book') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fas fa-plus me-1"></i> New Shipment
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #011233; }
    .x-small { font-size: 10px; }
    .italic { font-style: italic; }
</style>
@endsection

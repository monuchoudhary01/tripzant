@extends('layouts.dashboard')

@section('title', 'Fare Monitoring & Price Alerts | Trip\'Stay')

@section('dashboard_content')
<div class="price-alerts-page">
    <div class="row mb-5 justify-content-between align-items-center">
        <div class="col-lg-6">
            <h4 class="fw-900 text-navy mb-1">Fare Monitoring</h4>
            <p class="text-muted small">We are tracking prices for you. Book when the price is right.</p>
        </div>
        <div class="col-lg-auto">
            <button class="btn btn-navy rounded-pill px-4 fw-bold small" data-bs-toggle="modal" data-bs-target="#newAlertModal"><i class="fas fa-plus me-2"></i> Track New Route</button>
        </div>
    </div>

    <div class="row g-4">


        @forelse($alerts as $alert)
            @php
                $isDropped = ($alert->matched_data['price'] ?? 1000000) < $alert->target_price;
                $currentPrice = $alert->matched_data['price'] ?? '--';
                $oldPrice = $alert->matched_data['previous_price'] ?? null;
            @endphp
            <div class="col-12">
                <div class="alert-premium-card p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-3 bg-light rounded-4 text-navy"><i class="fas fa-plane-departure fs-5"></i></div>
                                <div>
                                    <h5 class="city-label text-navy mb-0">{{ $alert->origin }} <i class="fas fa-arrow-right mx-2 opacity-25 fs-6"></i> {{ $alert->destination }}</h5>
                                    <p class="text-muted x-small fw-900 mb-0 opacity-75 text-uppercase letter-spacing-1"><i class="far fa-calendar-alt me-1"></i> {{ $alert->travel_date->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 text-center text-lg-start mt-3 mt-lg-0">
                            <span class="text-muted x-small fw-800 d-block mb-1 opacity-50 text-uppercase">MONITORED PRICE</span>
                            @if($oldPrice)
                                <span class="text-decoration-line-through text-muted small me-2">₹{{ number_format($oldPrice) }}</span>
                                <span class="fw-900 text-success fs-3">₹{{ number_format($currentPrice) }}</span>
                            @else
                                <span class="fw-900 text-navy fs-3">₹{{ $currentPrice != '--' ? number_format($currentPrice) : '--' }}</span>
                            @endif
                        </div>
                        <div class="col-lg-2 text-center text-lg-start mt-3 mt-lg-0">
                            <span class="text-muted x-small fw-800 d-block mb-1 opacity-50 text-uppercase">TRACKER STATUS</span>
                            @if($isDropped)
                                <span class="badge rounded-pill status-badge-dropped px-3 py-2 fw-900 pulse-glow"><i class="fas fa-arrow-down me-1"></i> DROPPED</span>
                            @else
                                <span class="badge rounded-pill status-badge-tracking px-3 py-2 fw-900"><i class="fas fa-satellite-dish me-1"></i> ACTIVE</span>
                            @endif
                        </div>
                        <div class="col-lg-3 text-end d-flex gap-2 justify-content-end mt-4 mt-lg-0">
                             <div class="dropdown">
                                <button class="btn btn-light rounded-pill p-2 px-3 border-0" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v text-muted x-small"></i></button>
                                <ul class="dropdown-menu shadow-lg border-0 rounded-4 p-2 mt-2">
                                    <li><a class="dropdown-item small fw-bold" href="#"><i class="fas fa-edit me-2 text-primary"></i> EDIT ALERT</a></li>
                                    <li><a class="dropdown-item small fw-bold text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> STOP TRACKING</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-navy rounded-pill px-4 fw-900 x-small hvr-shrink">ANALYZE FARES</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 mt-5 p-5 bg-white rounded-5 shadow-sm text-center border-dashed">
                <div class="fs-1 text-muted opacity-25 mb-3"><i class="fas fa-bell-slash"></i></div>
                <h5 class="fw-900 text-navy">No active alerts.</h5>
                <p class="text-muted small">Start tracking flight routes to get real-time price drop notifications.</p>
                <button class="btn btn-navy rounded-pill px-4 mt-3 fw-bold" data-bs-toggle="modal" data-bs-target="#newAlertModal">Set Your First Alert</button>
            </div>
        @endforelse
    </div>


</div>

<!-- Track New Alert Modal -->
<div class="modal fade" id="newAlertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-navy text-white p-4">
                <h5 class="fw-900 mb-0">Set New Fare Monitor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('dashboard.price-alerts.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label x-small fw-bold text-muted">FROM (CITY CODE)</label>
                            <input type="text" name="origin" class="form-control fw-bold" placeholder="e.g. DEL" maxlength="3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label x-small fw-bold text-muted">TO (CITY CODE)</label>
                            <input type="text" name="destination" class="form-control fw-bold" placeholder="e.g. DXB" maxlength="3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label x-small fw-bold text-muted">TRAVEL DATE</label>
                            <input type="date" name="travel_date" class="form-control fw-bold" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label x-small fw-bold text-muted">TARGET PRICE (MAX)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold small">₹</span>
                                <input type="number" name="target_price" class="form-control fw-bold" placeholder="e.g. 20000" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label x-small fw-bold text-muted mb-2 d-block">NOTIFICATION PREFERENCES</label>
                            <div class="d-flex gap-4">
                                <div class="form-check"><input class="form-check-input" type="radio" name="channel" value="email" checked><label class="form-check-label small fw-bold">Email</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="channel" value="whatsapp"><label class="form-check-label small fw-bold">WhatsApp</label></div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-bold shadow-sm">START TRACKING <i class="fas fa-radar ms-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .alert-premium-card {
        background: #fff;
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: var(--user-card-shadow);
    }
    .alert-premium-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--user-card-hover);
    }
    .status-badge-tracking {
        background: rgba(99, 102, 241, 0.1);
        color: var(--user-accent);
        border: 1px solid rgba(99, 102, 241, 0.1);
    }
    .status-badge-dropped {
        background: #f0fdf4;
        color: #22c55e;
        border: 1px solid #dcfce7;
    }
    .city-label {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .pulse-glow {
        animation: pulse-glow 2s infinite;
    }
    @keyframes pulse-glow {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }
    .x-small { font-size: 11px; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 4000,
            showConfirmButton: false
        });
    @endif
    
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ $errors->first() }}",
        });
    @endif
</script>
@endpush
@endsection

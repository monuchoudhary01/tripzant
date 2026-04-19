@extends('layouts.user_dashboard')

@section('title', 'Agent Dashboard | TripZant Cargo')

@section('content')
<div class="container-fluid py-4 min-vh-100" style="background-color: #f4f7f6;">
    <!-- Agent Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="avatar-sm bg-primary text-white p-3 rounded-circle me-3">
                    <i class="fas fa-id-badge fa-lg"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Hello, {{ auth()->user()->name }}</h4>
                    <span class="badge bg-soft-success text-success small">Available for Pickup</span>
                </div>
            </div>
            <div class="text-end">
                <small class="text-muted d-block small">Zone: {{ $agent->current_location ?? 'Not Set' }}</small>
                <div class="fw-bold text-dark">Vehicle: {{ $agent->vehicle_type ?? 'Bike/Van' }}</div>
            </div>
        </div>
    </div>

    <!-- Mobile-Style Stats (Module 6) -->
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <h2 class="fw-bold text-primary mb-0">{{ $activePickups->count() }}</h2>
                <small class="text-muted fw-bold">Requests</small>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <h2 class="fw-bold text-success mb-0">$120</h2>
                <small class="text-muted fw-bold">Earned Today</small>
            </div>
        </div>
    </div>

    <!-- Active Requests (Module 6: Driver app accept pickup) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-bell text-warning me-2"></i> New Pickup Requests</h5>
        </div>
        <div class="list-group list-group-flush">
            @forelse($activePickups as $request)
            <div class="list-group-item p-4 border-bottom bg-light bg-opacity-10">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-soft-primary text-primary mb-2">Ref: {{ $request->booking_ref }}</span>
                        <h6 class="fw-bold mb-1">{{ $request->sender_details['name'] ?? 'Guest Sender' }}</h6>
                        <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i> {{ $request->sender_details['address'] ?? 'No pickup address' }}</p>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-dark">{{ $request->weight }} KG</div>
                        <small class="text-muted">{{ $request->parcel_type }}</small>
                    </div>
                </div>
                <button class="btn btn-primary w-100 rounded-pill py-2 shadow-sm fw-bold" onclick="acceptPickup('{{ $request->booking_ref }}')">
                    Accept Job <i class="fas fa-check-circle ms-2"></i>
                </button>
            </div>
            @empty
            <div class="p-5 text-center text-muted italic small">
                No pickup requests in your current zone.
            </div>
            @endforelse
        </div>
    </div>

    <!-- My Shipments / In-progress -->
    <h5 class="fw-bold mb-3 mt-5">My Active Assignments (Virtual Hub Flow)</h5>
    <div class="row g-4">
        @forelse($myDeliveries as $shipment)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 border-start border-warning border-4">
                <div class="d-flex justify-content-between mb-3 text-wrap">
                    <span class="fw-bold text-dark">{{ $shipment->booking_ref }}</span>
                    <span class="badge bg-soft-warning text-warning rounded-pill px-3">{{ $shipment->status }}</span>
                </div>
                
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="text-uppercase x-small fw-bold text-muted mb-1"><i class="fas fa-truck-loading me-1"></i> Drop-off Destination</div>
                    <div class="fw-bold text-primary">{{ $shipment->pickup_option ?? 'Nearest DHL/AusPost Hub' }}</div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('cargo.dashboard.label.shipping', $shipment->booking_ref) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                        <i class="fas fa-barcode me-1"></i> View Label
                    </a>
                    <button class="btn btn-sm btn-dark rounded-pill px-3" onclick="showNavigation('{{ $shipment->booking_ref }}')">
                        <i class="fas fa-directions me-1"></i> Navigate
                    </button>
                    <button class="btn btn-sm btn-success rounded-pill px-3 ms-auto" onclick="confirmHubDropoff('{{ $shipment->booking_ref }}')">
                        Final Drop ✅
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-4 bg-white rounded-4 border">
            <p class="text-muted mb-0 small">You haven't accepted any jobs yet.</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    function confirmHubDropoff(ref) {
        Swal.fire({
            title: 'Confirm Hub Handover?',
            text: 'Are you handing this parcel to the partner (DHL/AusPost)?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Dropped!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Job Completed!', 'Shipment in transit via Global Hub.', 'success').then(() => location.reload());
            }
        });
    }
    function acceptPickup(ref) {
        Swal.fire({
            title: 'Accept Pickup #'+ref+'?',
            text: 'You will need to arrive at the sender location within 30 mins.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Accept!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('cargo.agent.accept') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ booking_ref: ref })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire('Accepted!', data.message, 'success').then(() => location.reload());
                    }
                });
            }
        });
    }

    function updateMylocation(ref) {
        // Mocking HTML5 Geolocation (Module 3 & 6)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                fetch('{{ route('cargo.agent.location') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ booking_ref: ref, lat: lat, lng: lng })
                })
                .then(res => res.json())
                .then(() => {
                    Toastify({ text: "GPS Location Synced with Server", duration: 3000, backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)" }).showToast();
                });
            });
        }
    }

    function showNavigation(ref) {
        Swal.fire('In-App Navigation', 'Google Maps API loading optimized route to destination...', 'info');
    }
</script>

<style>
    .bg-soft-success { background: rgba(28, 200, 138, 0.1); }
    .bg-soft-primary { background: rgba(78, 115, 223, 0.1); }
    .text-navy { color: #011438; }
</style>
@endsection

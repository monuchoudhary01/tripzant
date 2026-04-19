@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-800">Incoming Requests</h4>
            <p class="text-muted small">Real-time requests from hotels and tour builders that require your immediate action.</p>
        </div>
    </div>

    <div class="row g-4">
        @php
            $requests = [
                ['from' => 'The Oberoi New Delhi', 'type' => 'Hotel', 'service' => 'Airport Pickup', 'date' => 'Today, 2:30 PM', 'price' => '₹1,200', 'status' => 'Urgent', 'badge' => 'bg-danger'],
                ['from' => 'MakeMyTrip Tours', 'type' => 'Tour Builder', 'service' => 'Full Day Guide', 'date' => '10 Apr 2026', 'price' => '₹4,500', 'status' => 'Pending', 'badge' => 'bg-warning'],
                ['from' => 'Taj Palace', 'type' => 'Hotel', 'service' => 'Local Sightseeing', 'date' => '12 Apr 2026', 'price' => '₹2,800', 'status' => 'New', 'badge' => 'bg-primary'],
                ['from' => 'Roseate House', 'type' => 'Hotel', 'service' => 'Luxury Transfer', 'date' => '14 Apr 2026', 'price' => '₹5,000', 'status' => 'New', 'badge' => 'bg-primary'],
            ];
        @endphp

        @foreach($requests as $r)
        <div class="col-12">
            <div class="card border-0 p-4 shadow-sm hover-shadow transition">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded-4 p-3 d-flex align-items-center justify-content-center" style="width:56px; height:56px;">
                                <i class="fas {{ $r['type'] == 'Hotel' ? 'fa-hotel' : 'fa-route' }} text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-800 mb-0">{{ $r['from'] }}</h6>
                                <p class="mb-0 text-muted smaller fw-700 uppercase">{{ $r['type'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-1 text-muted smaller fw-700 uppercase">REQUESTED SERVICE</p>
                        <h6 class="fw-800 mb-0 small">{{ $r['service'] }}</h6>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-1 text-muted smaller fw-700 uppercase">DATE & TIME</p>
                        <h6 class="fw-800 mb-0 small">{{ $r['date'] }}</h6>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-1 text-muted smaller fw-700 uppercase">OFFERED PRICE</p>
                        <h6 class="fw-800 mb-0 text-primary">{{ $r['price'] }}</h6>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-primary rounded-pill px-4 fw-800 btn-sm">Accept</button>
                            <button class="btn btn-outline-custom rounded-pill px-4 fw-800 btn-sm">Call Now</button>
                            <button class="btn btn-link text-danger smaller fw-800 text-decoration-none">Reject</button>
                        </div>
                    </div>
                </div>
                <div class="position-absolute top-0 start-0 h-100 {{ $r['badge'] }}" style="width:4px; border-top-left-radius:16px; border-bottom-left-radius:16px;"></div>
                <div class="position-absolute top-0 end-0 p-3 pt-2">
                    <span class="badge {{ $r['badge'] }} rounded-pill smaller fw-800" style="padding: 4px 10px;">{{ $r['status'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    <div class="row pt-5 d-none">
        <div class="col-12 text-center py-5">
             <div class="bg-light d-inline-block rounded-circle p-5 mb-4">
                <i class="fas fa-inbox fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="fw-800 text-muted">No new requests</h4>
            <p class="text-muted">You're all caught up! New requests from partners will appear here.</p>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 12px !important; }
    .smaller { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .btn-outline-custom { border-color: var(--border-color); color: var(--text-dark); background: #fff; }
    .btn-outline-custom:hover { background: var(--bg-main); }
    .transition { transition: all 0.3s ease; }
    .hover-shadow:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
</style>
@endsection

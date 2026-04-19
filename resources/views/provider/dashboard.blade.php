@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-800">Welcome back, Rahul! 👋</h4>
            <p class="text-muted small">Here's what's happening with your services today.</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 p-4 border-0">
                <div class="stat-icon bg-primary-light text-primary">
                    <i class="fas fa-indian-rupee-sign"></i>
                </div>
                <h6 class="text-muted fw-700 small mb-1">Total Earnings</h6>
                <h3 class="fw-800 mb-0">₹45,200</h3>
                <p class="text-success small fw-700 mt-2 mb-0"><i class="fas fa-arrow-up me-1"></i> 12% vs last month</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 p-4 border-0">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h6 class="text-muted fw-700 small mb-1">Active Bookings</h6>
                <h3 class="fw-800 mb-0">12</h3>
                <p class="text-muted small fw-700 mt-2 mb-0">4 starting today</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 p-4 border-0">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <h6 class="text-muted fw-700 small mb-1">Pending Requests</h6>
                <h3 class="fw-800 mb-0">08</h3>
                <p class="text-danger small fw-700 mt-2 mb-0"><i class="fas fa-circle me-1 blink"></i> Action required</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 p-4 border-0">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-star"></i>
                </div>
                <h6 class="text-muted fw-700 small mb-1">Service Rating</h6>
                <h3 class="fw-800 mb-0">4.9</h3>
                <p class="text-muted small fw-700 mt-2 mb-0">Based on 128 reviews</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Requests -->
        <div class="col-lg-8">
            <div class="card border-0 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-800 mb-0">Recent Incoming Requests</h5>
                    <a href="{{ route('provider.requests') }}" class="btn btn-link text-primary fw-700 small text-decoration-none">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-muted small">
                            <tr>
                                <th class="border-0">CLIENT / SOURCE</th>
                                <th class="border-0">SERVICE TYPE</th>
                                <th class="border-0">DATE & TIME</th>
                                <th class="border-0">PRICE</th>
                                <th class="border-0">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $requests = [
                                    ['source' => 'The Oberoi New Delhi', 'type' => 'Hotel', 'logo' => 'https://ui-avatars.com/api/?name=O+H&background=random', 'service' => 'Airport Pickup', 'date' => 'Today, 02:30 PM', 'price' => '₹1,200'],
                                    ['source' => 'MakeMyTrip Tours', 'type' => 'Tour Builder', 'logo' => 'https://ui-avatars.com/api/?name=MMT&background=random', 'service' => 'Full Day Guide', 'date' => 'Tomorrow, 09:00 AM', 'price' => '₹4,500'],
                                    ['source' => 'Taj Palace', 'type' => 'Hotel', 'logo' => 'https://ui-avatars.com/api/?name=T+P&background=random', 'service' => 'Local Sightseeing', 'date' => '12 Apr, 10:00 AM', 'price' => '₹2,800'],
                                ];
                            @endphp
                            @foreach($requests as $req)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $req['logo'] }}" class="rounded-circle" width="32" height="32">
                                        <div>
                                            <h6 class="mb-0 fw-700 small">{{ $req['source'] }}</h6>
                                            <p class="mb-0 text-muted smaller">{{ $req['type'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark fw-700">{{ $req['service'] }}</span></td>
                                <td class="small fw-600">{{ $req['date'] }}</td>
                                <td class="fw-800 text-primary">{{ $req['price'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary btn-sm px-3 rounded-pill fw-700" style="font-size:11px;">Accept</button>
                                        <button class="btn btn-outline-danger btn-sm px-3 rounded-pill fw-700" style="font-size:11px;">Reject</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Connection Stats -->
        <div class="col-lg-4">
            <div class="card border-0 p-4 mb-4">
                <h5 class="fw-800 mb-4">Operational Status</h5>
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success rounded-circle" style="width:12px; height:12px;"></div>
                        <h6 class="mb-0 fw-700">Online & Ready</h6>
                    </div>
                    <div class="form-check form-switch p-0 m-0" style="min-height:auto;">
                        <input class="form-check-input ms-0" type="checkbox" checked style="width:40px; height:20px;">
                    </div>
                </div>
                
                <h6 class="fw-700 small text-muted mb-3">YOUR NETWORK</h6>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between">
                        <span class="small fw-600 text-muted">Connected Hotels</span>
                        <span class="small fw-800">42</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-600 text-muted">Tour Builders</span>
                        <span class="small fw-800">08</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-600 text-muted">Service Areas</span>
                        <span class="small fw-800">New Delhi, NCR</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 p-4 bg-primary text-white">
                <h6 class="fw-800 mb-2">Pro Tip! 💡</h6>
                <p class="smaller opacity-75 mb-3">Connecting with more Hotels increases your incoming requests by up to 40%.</p>
                <a href="{{ route('provider.hotels') }}" class="btn btn-light btn-sm w-100 fw-800 rounded-pill py-2" style="color:var(--primary);">Grow Network</a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.4; }
        100% { opacity: 1; }
    }
    .blink { animation: blink 1.5s infinite; }
    .smaller { font-size: 11px; }
    .fw-800 { font-weight: 800; }
    .fw-900 { font-weight: 900; }
</style>
@endsection

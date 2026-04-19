@extends('layouts.app')

@section('title', "Manage Hotels — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <!-- Reusable Partner Sidebar -->
    <x-partner-sidebar active="hotels" />

    <!-- Main Content Area -->
    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Your Hotel Listings</h2>
                    <p class="text-muted small mb-0">Optimize room inventory, pricing, and guest reviews.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addHotelModal">
                   <i class="fas fa-plus me-2"></i> Add New Hotel
                </button>
            </div>

            <!-- Existing Listings Grid -->
            <div class="row g-4 mb-5">
                @php
                $hotels = [
                    ['id' => 'HT-1', 'title' => 'Taj Exotica Resort & Spa', 'location' => 'Benaulim, Goa', 'price' => '₹24,500', 'status' => 'Live', 'rooms' => 84, 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500'],
                    ['id' => 'HT-2', 'title' => 'Novotel Goa Resort', 'location' => 'Candolim, Goa', 'price' => '₹12,200', 'status' => 'Verification Pending', 'rooms' => 120, 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500'],
                    ['id' => 'HT-3', 'title' => 'Radisson Blu Resort', 'location' => 'Cavelossim, Goa', 'price' => '₹9,800', 'status' => 'Live', 'rooms' => 45, 'image' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=500'],
                ];
                @endphp

                @foreach($hotels as $hotel)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <img src="{{ $hotel['image'] }}" class="rounded-3 shadow-sm" width="80" height="60" style="object-fit:cover;" alt="">
                            <div class="text-end">
                                <span class="badge {{ $hotel['status'] === 'Live' ? 'bg-green-light text-green' : 'bg-orange-light text-orange' }} border-0 rounded-pill px-3 py-1 mb-2">{{ $hotel['status'] }}</span>
                                <div class="text-muted small fw-bold">{{ $hotel['id'] }}</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">{{ $hotel['title'] }}</h6>
                            <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $hotel['location'] }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="fw-900 text-navy fs-5">{{ $hotel['price'] }} <span style="font-size:10px; color:#aaa;">/night</span></div>
                                <div class="text-muted small fw-bold">Active Rooms: <span class="text-navy">{{ $hotel['rooms'] }}</span></div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold" style="background:#f1f5f9; color:#64748b;"><i class="fas fa-bed me-1"></i> Manage Rooms</button>
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold" style="background:#f1f5f9; color:#ef4444;"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Add Hotel Modal -->
<div class="modal fade" id="addHotelModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 32px;">
            <div class="modal-header border-0 pb-0">
                <h4 class="fw-900 text-navy mb-0">Register New Hotel Property</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-5">
                <form action="/partner/hotels" method="GET">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small text-muted">Legal Property Name</label>
                            <input type="text" class="form-control px-4 py-3 rounded-pill" placeholder="e.g. The Grand Palace Resort" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Base Fare / Night</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light rounded-start-pill border-end-0 px-4">₹</span>
                                <input type="number" class="form-control py-3 border-start-0 rounded-end-pill px-4" placeholder="12500" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Exact Location</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light rounded-start-pill border-end-0 px-4"><i class="fas fa-location-dot"></i></span>
                                <input type="text" class="form-control py-3 border-start-0 rounded-end-pill px-4" placeholder="Goa, India" required>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Main Attraction / Proximity</label>
                            <input type="text" class="form-control px-4 py-3 rounded-pill" placeholder="e.g. 0.5 km from Baga Beach" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Property Rating</label>
                            <select class="form-select px-4 py-3 rounded-pill">
                                <option>5 Star (Ultra Luxury)</option>
                                <option>4 Star (Premium)</option>
                                <option>3 Star (Comfort)</option>
                                <option>Boutique / Homestay</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Daily Room Capacity</label>
                            <input type="number" class="form-control px-4 py-3 rounded-pill" placeholder="20" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Total Active Rooms</label>
                            <input type="number" class="form-control px-4 py-3 rounded-pill" placeholder="140" required>
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-navy w-100 py-3 rounded-pill fw-bold shadow-lg" data-bs-dismiss="modal">Request Live Listing <i class="fas fa-check-circle ms-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Dashboard Navigation Styles for Uniformity */
    .partner-nav-link {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 20px;
        border-radius: 16px;
        color: #64748b;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .partner-nav-link:hover, .partner-nav-link.active {
        background: rgba(11, 61, 97, 0.05);
        color: #0b3d61;
    }
    .partner-nav-link i {
        font-size: 18px;
        width: 24px;
        text-align: center;
    }
    .bg-green-light { background: rgba(34, 197, 94, 0.1); }
    .text-green { color: #22c55e; }
    .bg-orange-light { background: rgba(249, 115, 22, 0.1); }
    .text-orange { color: #f97316; }
</style>
@endsection

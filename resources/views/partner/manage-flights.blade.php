@extends('layouts.app')

@section('title', "Manage Flights — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <!-- Reusable Partner Sidebar -->
    <x-partner-sidebar active="flights" />

    <!-- Main Content Area -->
    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Your Flight Listings</h2>
                    <p class="text-muted small mb-0">Add, edit, or remove flight inventories and dynamic pricing.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addFlightModal">
                   <i class="fas fa-plus me-2"></i> Add New Flight
                </button>
            </div>

            <!-- Existing Listings Grid -->
            <div class="row g-4 mb-5">
                @php
                $flights = [
                    ['id' => 'FL-1', 'title' => 'Delhi (DEL) → Mumbai (BOM)', 'airline' => 'IndiGo · 6E-2134', 'price' => '₹4,250', 'status' => 'Live', 'stock' => 120, 'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109c05e?w=200'],
                    ['id' => 'FL-2', 'title' => 'Bangalore (BLR) → London (LHR)', 'airline' => 'Air India · AI-804', 'price' => '₹48,200', 'status' => 'Pending Review', 'stock' => 240, 'image' => 'https://images.unsplash.com/photo-1544016768-982d1554f0b9?w=200'],
                    ['id' => 'FL-3', 'title' => 'Dubai (DXB) → Goa (GOX)', 'airline' => 'Vistara · UK-945', 'price' => '₹18,100', 'status' => 'Live', 'stock' => 180, 'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=200'],
                ];
                @endphp

                @foreach($flights as $flight)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <img src="{{ $flight['image'] }}" class="rounded-3 shadow-sm" width="80" height="60" style="object-fit:cover;" alt="">
                            <div class="text-end">
                                <span class="badge {{ $flight['status'] === 'Live' ? 'bg-green-light text-green' : 'bg-orange-light text-orange' }} border-0 rounded-pill px-3 py-1 mb-2">{{ $flight['status'] }}</span>
                                <div class="text-muted small fw-bold">{{ $flight['id'] }}</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">{{ $flight['title'] }}</h6>
                            <p class="text-muted small mb-3">{{ $flight['airline'] }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="fw-900 text-navy fs-5">{{ $flight['price'] }}</div>
                                <div class="text-muted small fw-bold">Inventory: <span class="text-navy">{{ $flight['stock'] }} seats</span></div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold" style="background:#f1f5f9; color:#64748b;"><i class="fas fa-edit me-1"></i> Edit</button>
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold" style="background:#f1f5f9; color:#ef4444;"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Add Flight Modal -->
<div class="modal fade" id="addFlightModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 32px;">
            <div class="modal-header border-0 pb-0">
                <h4 class="fw-900 text-navy mb-0">Add New Flight Inventory</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-5">
                <form action="/partner/flights" method="GET">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Flight / Airline Number</label>
                            <input type="text" class="form-control px-4 py-3 rounded-pill" placeholder="e.g. 6E-2134 (IndiGo)" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Base Fare (Adult)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light rounded-start-pill border-end-0 px-4">₹</span>
                                <input type="number" class="form-control py-3 border-start-0 rounded-end-pill px-4" placeholder="4500" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Departure Airport</label>
                            <input type="text" class="form-control px-4 py-3 rounded-pill" placeholder="Delhi (DEL)" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Arrival Airport</label>
                            <input type="text" class="form-control px-4 py-3 rounded-pill" placeholder="London (LHR)" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Departure Time</label>
                            <input type="datetime-local" class="form-control px-4 py-3 rounded-pill" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Arrival Time</label>
                            <input type="datetime-local" class="form-control px-4 py-3 rounded-pill" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Total Available Seats</label>
                            <input type="number" class="form-control px-4 py-3 rounded-pill" placeholder="180" required>
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-navy w-100 py-3 rounded-pill fw-bold shadow-lg" data-bs-dismiss="modal">Confirm Listing <i class="fas fa-check-circle ms-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling copied from dashboard for consistency */
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
    .form-control:focus { border-color: #0b3d61; box-shadow: 0 0 0 4px rgba(11, 61, 97, 0.1); }
</style>
@endsection

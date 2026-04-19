@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h4 class="fw-800">My Services</h4>
            <p class="text-muted small mb-0">List and manage the unique experiences you offer to hotels and travelers.</p>
        </div>
        <button class="btn btn-primary px-4 py-2 rounded-pill fw-800" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="fas fa-plus me-2"></i> Add New Service
        </button>
    </div>

    <div class="row g-4">
        @php
            $services = [
                ['id' => 1, 'name' => 'Premium Airport Pickup', 'price' => '1,200', 'desc' => 'Mercedes E-Class or equivalent Luxury Sedan for airport transfers with meet & greet.', 'cat' => 'Transport', 'icon' => 'fa-car'],
                ['id' => 2, 'name' => 'Old Delhi Heritage Walk', 'desc' => 'A structured 4-hour heritage tour covering Chandni Chowk, Jama Masjid, and hidden spice alleys.', 'price' => '3,500', 'cat' => 'Tour', 'icon' => 'fa-walking'],
                ['id' => 3, 'name' => 'Professional Tour Guide', 'desc' => 'Certified multilingual guide service for full-day city sightseeing in Delhi/Agra.', 'price' => '4,000', 'cat' => 'Guide', 'icon' => 'fa-hiking'],
                ['id' => 4, 'name' => 'Helper/Assistant Service', 'desc' => 'Dedicated helper for shopping, baggage assistance, or light errands for senior travelers.', 'price' => '1,500', 'cat' => 'Other', 'icon' => 'fa-hands-helping'],
            ];
        @endphp

        @foreach($services as $s)
        <div class="col-lg-6">
            <div class="card border-0 p-4 h-100">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-start gap-4">
                        <div class="bg-primary-light text-primary rounded-4 p-4 d-flex align-items-center justify-content-center" style="width:70px; height:70px;">
                            <i class="fas {{ $s['icon'] }} fa-2x"></i>
                        </div>
                        <div>
                            <span class="badge bg-light text-primary fw-800 uppercase mb-2" style="font-size:10px; letter-spacing:1px;">{{ $s['cat'] }}</span>
                            <h5 class="fw-800 mb-2">{{ $s['name'] }}</h5>
                            <p class="text-muted small fw-600 line-clamp-2 mb-0" style="max-width:350px;">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                </div>
                <hr class="my-4 opacity-50">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 text-muted smaller fw-700 uppercase">BASE PRICE</p>
                        <h4 class="fw-900 mb-0">₹{{ $s['price'] }} <small class="fw-600 text-muted" style="font-size:12px;">/ service</small></h4>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-custom p-2 rounded-circle" style="width:38px; height:38px;"><i class="fas fa-edit small"></i></button>
                        <button class="btn btn-outline-danger p-2 rounded-circle" style="width:38px; height:38px;"><i class="fas fa-trash small"></i></button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State (Hidden) -->
    <div class="row d-none">
        <div class="col-12 text-center py-5">
            <div class="bg-light d-inline-block rounded-circle p-5 mb-4">
                <i class="fas fa-briefcase fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="fw-800 text-muted">No services added yet</h4>
            <p class="text-muted">Start adding services to get bookings from hotels and tour builders.</p>
            <button class="btn btn-primary px-5 py-3 rounded-pill fw-800 mt-3">Add My First Service</button>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 p-4 bg-primary text-white">
                <h5 class="modal-title fw-800">Add New Service</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-4">
                        <label class="form-label fw-700 small text-muted">SERVICE NAME</label>
                        <input type="text" class="form-control rounded-4 p-3 border-light bg-light" placeholder="e.g. Airport Pickup">
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label fw-700 small text-muted">CATEGORY</label>
                            <select class="form-select rounded-4 p-3 border-light bg-light">
                                <option>Guide</option>
                                <option>Transport</option>
                                <option>Tour</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-700 small text-muted">PRICE (INR)</label>
                            <input type="number" class="form-control rounded-4 p-3 border-light bg-light" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-700 small text-muted">DESCRIPTION</label>
                        <textarea class="form-control rounded-4 p-3 border-light bg-light" rows="4" placeholder="Briefly describe what's included..."></textarea>
                    </div>
                    <button type="button" class="btn btn-primary w-100 py-3 rounded-pill fw-800 shadow-sm">PUBLISH SERVICE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .smaller { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

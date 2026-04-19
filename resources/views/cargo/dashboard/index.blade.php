@extends('layouts.user_dashboard')

@section('title', 'Cargo Dashboard | TripZant')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-dark mb-1">Cargo & Shipments</h2>
                <p class="text-muted">Manage your international cargo, tracking, and customs declarations.</p>
            </div>
            <a href="{{ route('cargo.dashboard.book') }}" class="btn btn-primary btn-lg shadow-sm rounded-pill px-4">
                <i class="fas fa-plus me-2"></i> Book New Cargo
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4 mb-5 animate__animated animate__fadeInUp">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-gradient-primary text-white">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-white text-primary rounded-3 p-3 me-3">
                        <i class="fas fa-box fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 opacity-8 text-uppercase small">Total Bookings</h6>
                        <h3 class="mb-0 fw-bold">{{ $bookings->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-soft-warning text-warning rounded-3 p-3 me-3">
                        <i class="fas fa-sync-alt fa-spin"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted text-uppercase small">In Transit</h6>
                        <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'In Transit')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-soft-success text-success rounded-3 p-3 me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted text-uppercase small">Delivered</h6>
                        <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'Delivered')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-soft-danger text-danger rounded-3 p-3 me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted text-uppercase small">Customs Hold</h6>
                        <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'Customs')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Shipments Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Recent Shipments</h5>
            <div class="input-group w-auto">
                <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control bg-light border-0" placeholder="Search Shipment ID...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Booking Ref</th>
                        <th>Provider</th>
                        <th>Route</th>
                        <th>Weight</th>
                        <th>Status</th>
                        <th>Estimated Delivery</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark">{{ $booking->booking_ref }}</span><br>
                            <small class="text-muted">{{ $booking->created_at->format('d M, Y') }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $booking->provider->logo_url }}" class="me-2" style="width: 30px; height: auto;" alt="{{ $booking->provider->name }}">
                                <span>{{ $booking->provider->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <span class="fw-semibold">{{ $booking->origin_city }}</span> 
                                <i class="fas fa-arrow-right mx-1 text-muted"></i> 
                                <span class="fw-semibold">{{ $booking->destination_city }}</span>
                            </div>
                        </td>
                        <td>{{ $booking->weight }} kg</td>
                        <td>
                            @php
                                $statusClass = [
                                    'Pending' => 'bg-soft-secondary text-secondary',
                                    'Confirmed' => 'bg-soft-info text-info',
                                    'In Transit' => 'bg-soft-warning text-warning',
                                    'Delivered' => 'bg-soft-success text-success',
                                    'Customs' => 'bg-soft-danger text-danger'
                                ][$booking->status] ?? 'bg-soft-primary text-primary';
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3">{{ $booking->status }}</span>
                        </td>
                        <td>{{ $booking->created_at->addDays(5)->format('d M, Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('cargo.dashboard.tracking', $booking->booking_ref) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1">Track</a>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-icon border-0" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice me-2"></i> Invoice</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i> Customs Form</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-times me-2"></i> Cancel</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-box-open fa-3x text-light mb-3"></i>
                                <h5 class="text-muted">No shipments found</h5>
                                <p class="text-muted small">Ready to send something? Start your first booking today.</p>
                                <a href="{{ route('cargo.dashboard.book') }}" class="btn btn-primary mt-2">Book Now</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary { background: linear-gradient(45deg, #4e73df 0%, #224abe 100%); }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1); }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); }
    .bg-soft-info { background-color: rgba(54, 185, 204, 0.1); }
    .bg-soft-warning { background-color: rgba(246, 194, 62, 0.1); }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.1); }
    .bg-soft-secondary { background-color: rgba(133, 135, 150, 0.1); }
    
    .text-primary { color: #4e73df !important; }
    .text-success { color: #1cc88a !important; }
    .text-info { color: #36b9cc !important; }
    .text-warning { color: #f6c23e !important; }
    .text-danger { color: #e74a59 !important; }
    
    .card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card:hover { transform: translateY(-5px); }
    .table-hover tbody tr:hover { background-color: rgba(0,0,0,0.01); }
</style>
@endsection

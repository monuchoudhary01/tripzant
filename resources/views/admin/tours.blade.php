@extends('layouts.admin')

@section('title', "Tours & Packages Control | Master Admin")

@section('admin_content')
<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h3 class="fw-900 text-navy mb-1">Tours & Packages Management</h3>
        <p class="text-muted small mb-0">Manage global vacation packages, itineraries, and providers.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="/tours/listings" class="btn-admin-primary text-decoration-none d-inline-block">
            <i class="fas fa-eye me-2"></i> PREVIEW TEST LISTINGS
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card-admin shadow-sm border-0 d-flex align-items-center gap-4 py-4 px-4 h-100">
            <div class="bg-primary-light p-3 rounded-4 text-primary"><i class="fas fa-suitcase-rolling fs-3"></i></div>
            <div>
                <h2 class="fw-900 mb-0">124</h2>
                <span class="text-muted small fw-bold">Live Packages</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin shadow-sm border-0 d-flex align-items-center gap-4 py-4 px-4 h-100">
            <div class="bg-success-light p-3 rounded-4 text-success"><i class="fas fa-ticket-alt fs-3"></i></div>
            <div>
                <h2 class="fw-900 mb-0">482</h2>
                <span class="text-muted small fw-bold">Recent Bookings</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin shadow-sm border-0 d-flex align-items-center gap-4 py-4 px-4 h-100">
            <div class="bg-orange-light p-3 rounded-4 text-orange"><i class="fas fa-hand-holding-usd fs-3"></i></div>
            <div>
                <h2 class="fw-900 mb-0">$84.2K</h2>
                <span class="text-muted small fw-bold">Total Revenue</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin shadow-sm border-0 d-flex align-items-center gap-4 py-4 px-4 h-100">
            <div class="bg-blue-light p-3 rounded-4 text-blue"><i class="fas fa-user-check fs-3"></i></div>
            <div>
                <h2 class="fw-900 mb-0">12</h2>
                <span class="text-muted small fw-bold">Top Operators</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card-admin shadow-sm border-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-900 text-navy mb-0">Global Inventory List</h5>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted small"></i></span>
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search by destination or title...">
            </div>
            <button class="btn btn-light border small font-weight-bold"><i class="fas fa-download me-1"></i> Export</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle custom-admin-table mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-0 rounded-start font-weight-bold py-3" style="font-size: 11px; color: #64748b; letter-spacing: 1px;">PACKAGE TITLE</th>
                    <th class="border-0 font-weight-bold py-3" style="font-size: 11px; color: #64748b; letter-spacing: 1px;">DURATION</th>
                    <th class="border-0 font-weight-bold py-3" style="font-size: 11px; color: #64748b; letter-spacing: 1px;">OPERATOR</th>
                    <th class="border-0 font-weight-bold py-3" style="font-size: 11px; color: #64748b; letter-spacing: 1px;">PRICE</th>
                    <th class="border-0 font-weight-bold py-3" style="font-size: 11px; color: #64748b; letter-spacing: 1px;">STATUS</th>
                    <th class="border-0 rounded-end font-weight-bold py-3" style="font-size: 11px; color: #64748b; letter-spacing: 1px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                $tours = [
                    ['title' => 'Taj Mahal and Wildlife with Royal Stay at Castles', 'duration' => '11 Days', 'operator' => 'Swastik Journeys', 'price' => '$710', 'status' => 'Active'],
                    ['title' => 'Kerala Backwaters & Hill Stations Explorer', 'duration' => '7 Days', 'operator' => 'Eden Tours', 'price' => '$450', 'status' => 'Draft'],
                    ['title' => 'Ladakh Monastery & Lake Adventure', 'duration' => '9 Days', 'operator' => 'Mountain Guides', 'price' => '$890', 'status' => 'Active'],
                ];
                @endphp
                @foreach($tours as $t)
                <tr>
                    <td>
                        <a href="/tours/details/1" class="d-flex align-items-center gap-3 text-decoration-none">
                            <div class="bg-light rounded-3" style="width: 40px; height: 40px; background-image: url('https://images.unsplash.com/photo-1548013146-72479768b921?w=100'); background-size: cover; background-position: center;"></div>
                            <div class="fw-800 text-navy small">{{ $t['title'] }}</div>
                        </a>
                    </td>
                    <td><span class="badge-admin-warning" style="background: rgba(11, 61, 97, 0.05); color: #0b3d61;">{{ $t['duration'] }}</span></td>
                    <td class="small fw-bold text-muted">{{ $t['operator'] }}</td>
                    <td class="fw-900 text-navy">{{ $t['price'] }}</td>
                    <td>
                        @if($t['status'] == 'Active')
                        <span class="badge-admin-success">Live & Published</span>
                        @else
                        <span class="badge-admin-warning" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">Draft Mode</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v text-muted"></i></button>
                            <ul class="dropdown-menu shadow border-0 py-2">
                                <li><a class="dropdown-item small py-2 fw-bold" href="/tours/details/1" target="_blank"><i class="fas fa-external-link-alt me-2 text-info"></i> Preview Frontend</a></li>
                                <li><a class="dropdown-item small py-2 fw-bold" href="#"><i class="fas fa-edit me-2 text-primary"></i> Edit Package</a></li>
                                <li><a class="dropdown-item small py-2 fw-bold" href="#"><i class="fas fa-clone me-2 text-info"></i> Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item small py-2 fw-bold text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Archive</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .bg-primary-light { background: rgba(var(--primary-rgb), 0.1) !important; }
    .bg-success-light { background: rgba(34, 197, 94, 0.1) !important; }
    .bg-orange-light { background: rgba(249, 115, 22, 0.1) !important; }
    .bg-blue-light { background: rgba(0, 168, 225, 0.1) !important; }
    .custom-admin-table th, .custom-admin-table td { padding-left: 20px; padding-right: 20px; }
</style>
@endsection

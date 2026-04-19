@extends('layouts.admin')

@section('title', 'Hotel Inventory')
@section('page_title', 'Hotel Inventory Management')
@section('nav-hotels', 'active')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <div class="input-group shadow-sm" style="border-radius:12px; overflow:hidden;">
            <span class="input-group-text bg-white border-0 px-3"><i class="fas fa-search text-muted"></i></span>
            <input type="text" class="form-control border-0 py-3" placeholder="Search by hotel name, city, or ID..." style="font-size:14px; font-weight:500;">
            <button class="btn btn-navy px-4 fw-800" style="background:var(--navy); color:#fff; font-size:13px;">SEARCH</button>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-primary h-100 px-4" style="border-radius:12px; font-weight:900; font-size:13px;"><i class="fas fa-plus me-2"></i> ADD NEW HOTEL</button>
    </div>
</div>

<div class="admin-table-card">
    <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
        <div>
            <h6 class="fw-900 mb-0">Property List</h6>
            <p class="mb-0 text-muted" style="font-size:11px;">Showing 1,240 properties across all regions</p>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm border-0 bg-light" style="font-size:11px; font-weight:700;">
                <option>ALL CITIES</option>
                <option>GOA</option>
                <option>DELHI</option>
                <option>BENGALURU</option>
            </select>
            <select class="form-select form-select-sm border-0 bg-light" style="font-size:11px; font-weight:700;">
                <option>ALL STATUS</option>
                <option>ACTIVE</option>
                <option>PENDING</option>
                <option>DOWN</option>
            </select>
        </div>
    </div>
    <table class="table admin-table mb-0">
        <thead>
            <tr>
                <th><input type="checkbox" class="form-check-input"></th>
                <th>Hotel Name & ID</th>
                <th>Location</th>
                <th>Star</th>
                <th>Status</th>
                <th>Net Rate</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" class="form-check-input"></td>
                <td>
                    <div class="fw-900 text-primary">Taj Exotica Resort & Spa</div>
                    <div style="font-size:10px; color:var(--gray-300);">ID: #HTL-99201</div>
                </td>
                <td>Goa, India</td>
                <td><span class="text-orange"><i class="fas fa-star"></i> 5</span></td>
                <td><span class="badge bg-success-subtle text-success px-3 py-2" style="font-size:10px;font-weight:bold;">PUBLISHED</span></td>
                <td><span class="fw-800">₹24,500</span></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-pill" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></button>
                        <ul class="dropdown-menu border-0 shadow-lg" style="border-radius:12px; font-size:13px;">
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-eye me-2 text-primary"></i> View Detail</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-pencil me-2 text-secondary"></i> Edit Pricing</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-sync-alt me-2 text-info"></i> Re-Sync Images</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fas fa-trash me-2"></i> Deactivate</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" class="form-check-input"></td>
                <td>
                    <div class="fw-900 text-primary">Novotel Goa Resort</div>
                    <div style="font-size:10px; color:var(--gray-300);">ID: #HTL-99205</div>
                </td>
                <td>Goa, India</td>
                <td><span class="text-orange"><i class="fas fa-star"></i> 4</span></td>
                <td><span class="badge bg-success-subtle text-success px-3 py-2" style="font-size:10px;font-weight:bold;">PUBLISHED</span></td>
                <td><span class="fw-800">₹12,200</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-light btn-sm rounded-pill"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" class="form-check-input"></td>
                <td>
                    <div class="fw-900 text-primary">The Leela Palace</div>
                    <div style="font-size:10px; color:var(--gray-300);">ID: #HTL-88210</div>
                </td>
                <td>Bengaluru</td>
                <td><span class="text-orange"><i class="fas fa-star"></i> 5</span></td>
                <td><span class="badge bg-warning-subtle text-warning px-3 py-2" style="font-size:10px;font-weight:bold;">PENDING SYNC</span></td>
                <td><span class="fw-800">₹18,500</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-light btn-sm rounded-pill"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" class="form-check-input"></td>
                <td>
                    <div class="fw-900 text-primary">Radisson Blu Resort</div>
                    <div style="font-size:10px; color:var(--gray-300);">ID: #HTL-77192</div>
                </td>
                <td>Goa, India</td>
                <td><span class="text-orange"><i class="fas fa-star"></i> 4</span></td>
                <td><span class="badge bg-success-subtle text-success px-3 py-2" style="font-size:10px;font-weight:bold;">PUBLISHED</span></td>
                <td><span class="fw-800">₹9,800</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-light btn-sm rounded-pill"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="p-4 bg-light bg-opacity-10 d-flex justify-content-between align-items-center">
        <span style="font-size:12px; color:var(--gray-300); font-weight:700;">Showing 1-10 of 1,240 properties</span>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link border-0" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link border-0" href="#" style="background:var(--primary);">1</a></li>
                <li class="page-item"><a class="page-link border-0 text-dark" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 text-dark" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0 text-dark" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection

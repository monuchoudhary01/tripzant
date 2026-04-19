@extends('layouts.admin')

@section('title', 'Engine Sync')
@section('page_title', 'Core Sync Control')
@section('nav-sync', 'active')

@section('content')
<div class="stat-card mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h5 class="fw-900 mb-2">Inventory Cloud Sync</h5>
            <p style="font-size:13px;color:var(--gray-300);margin-bottom:0;">Automated real-time inventory synchronization with global GDS providers.</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary px-4 py-3 shadow-lg" style="border-radius:12px;font-weight:900;letter-spacing:1px;font-size:13px;"><i class="fas fa-sync me-2"></i> SYNC ENGINE NOW</button>
        </div>
    </div>

    <div class="sync-bar">
        <div class="sync-progress"></div>
    </div>

    <div class="d-flex justify-content-between" style="font-size:12px;font-weight:800;color:var(--gray-300);">
        <span>STATUS: SYNCHRONIZING INVENTORY (PARTIAL)</span>
        <span>65% COMPLETE</span>
    </div>
</div>

<div class="admin-table-card">
    <div class="p-4 bg-light bg-opacity-10">
        <h6 class="fw-900 mb-0">Engine Logs (Last 24 Hours)</h6>
    </div>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Task ID</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-secondary">10:45:22 AM</td>
                    <td class="fw-700">#SYNC-94420</td>
                    <td>Fetched hotel inventory from GDS Hub 4</td>
                    <td><span class="text-success"><i class="fas fa-check-circle me-1"></i> SUCCESS</span></td>
                </tr>
                <tr>
                    <td class="text-secondary">10:12:05 AM</td>
                    <td class="fw-700">#IMAGE-PUSH</td>
                    <td>Uploaded 42 high-res assets for Taj Exotica</td>
                    <td><span class="text-primary"><i class="fas fa-cloud-upload me-1"></i> UPLOADED</span></td>
                </tr>
                <tr>
                    <td class="text-secondary">09:55:00 AM</td>
                    <td class="fw-700">#PRICE-REFRESS</td>
                    <td>Dynamic pricing re-calculation for South Goa</td>
                    <td><span class="text-success"><i class="fas fa-check-circle me-1"></i> DONE</span></td>
                </tr>
                <tr>
                    <td class="text-secondary">09:30:11 AM</td>
                    <td class="fw-700">#API-ERR-34</td>
                    <td>Connection timeout with Booking.com API</td>
                    <td><span class="text-danger"><i class="fas fa-times-circle me-1"></i> RETRYING...</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Admin Dashboard | Command Center')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card-admin stats-card d-flex flex-column justify-content-between h-100 hvr-grow">
            <div class="d-flex justify-content-between mb-4">
                <div class="text-muted small fw-800 text-uppercase">TOTAL PARTNERS</div>
                <div class="stat-icon-admin text-primary"><i class="fas fa-handshake"></i></div>
            </div>
            <div>
                <h2 class="fw-900 text-navy mb-1">{{ number_format($totalPartners) }}</h2>
                <p class="text-success small fw-bold mb-0"><i class="fas fa-caret-up me-1"></i> Active Channels</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-admin stats-card d-flex flex-column justify-content-between h-100 hvr-grow" style="border-left-color: #3b82f6 !important;">
            <div class="d-flex justify-content-between mb-4">
                <div class="text-muted small fw-800 text-uppercase">TOTAL FLIGHTS LISTED</div>
                <div class="stat-icon-admin text-blue"><i class="fas fa-plane"></i></div>
            </div>
            <div>
                <h2 class="fw-900 text-navy mb-1">{{ number_format($totalFlightBookings) }}</h2>
                <p class="text-success small fw-bold mb-0"><i class="fas fa-caret-up me-1"></i> Real-time GDS Data</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-admin stats-card d-flex flex-column justify-content-between h-100 hvr-grow" style="border-left-color: #f97316 !important;">
            <div class="d-flex justify-content-between mb-4">
                <div class="text-muted small fw-800 text-uppercase">TOTAL HOTELS LISTED</div>
                <div class="stat-icon-admin text-orange"><i class="fas fa-hotel"></i></div>
            </div>
            <div>
                <h2 class="fw-900 text-navy mb-1">{{ number_format($totalHotelBookings) }}</h2>
                <p class="text-success small fw-bold mb-0"><i class="fas fa-caret-up me-1"></i> Global Inventory</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-admin stats-card d-flex flex-column justify-content-between h-100 hvr-grow" style="border-left-color: #8b5cf6 !important;">
            <div class="d-flex justify-content-between mb-4">
                <div class="text-muted small fw-800 text-uppercase">TOTAL BOOKINGS</div>
                <div class="stat-icon-admin text-purple"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div>
                <h2 class="fw-900 text-navy mb-1">{{ number_format($totalBookings) }}</h2>
                <p class="text-success small fw-bold mb-0"><i class="fas fa-caret-up me-1"></i> Total Transactions</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Revenue Overview Chart -->
    <div class="col-xl-8">
        <div class="card-admin">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h5 class="fw-900 text-navy mb-0">Platform Revenue Overview</h5>
                <select class="form-select border-0 bg-light rounded-pill px-4 fw-bold small" style="width: 150px;">
                    <option>Last 30 Days</option>
                    <option>Year to Date</option>
                </select>
            </div>
            <div style="height: 300px; display: flex; align-items: flex-end; gap: 20px; padding: 20px 0;">
                @php
                    $maxRev = $monthlyData->max('revenue') ?: 1;
                @endphp
                @foreach($monthlyData as $data)
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 10px;" title="₹{{ number_format($data->revenue) }}">
                    <div style="width: 100%; height: {{ ($data->revenue / $maxRev) * 100 }}%; background: linear-gradient(180deg, #0b3d61 0%, #3b82f6 100%); border-radius: 8px 8px 0 0;"></div>
                    <span class="text-muted fw-bold" style="font-size: 10px;">{{ date('M', strtotime($data->month . '-01')) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-xl-4">
        <div class="card-admin">
            <h5 class="fw-900 text-navy mb-5">Recent Platform Activities</h5>
            <div class="activity-list overflow-auto" style="max-height: 400px;">
                @foreach($activities as $activity)
                    <div class="d-flex gap-4 mb-4 pb-4 border-bottom">
                        <div class="activity-icon-admin bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; flex-shrink: 0;">
                            <i class="fas fa-history fs-5"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-navy fw-700 small">{{ $activity->description }}</p>
                            <span class="text-muted" style="font-size: 11px;">{{ $activity->created_at->diffForHumans() }} · {{ $activity->module }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="#" class="text-navy fw-bold text-decoration-none d-block mt-4 text-center small">VIEW ALL SYSTEM LOGS <i class="fas fa-chevron-right ms-2"></i></a>
        </div>
    </div>
</div>

<style>
    .stat-icon-admin { font-size: 24px; opacity: 0.5; }
    .bg-success-subtle { background: rgba(34, 197, 94, 0.1); }
    .text-success { color: #22c55e; }
    .bg-primary-subtle { background: rgba(11, 61, 97, 0.1); }
    .text-primary { color: #0b3d61; }
    .bg-warning-subtle { background: rgba(249, 115, 22, 0.1); }
    .text-warning { color: #f97316; }
    .bg-danger-subtle { background: rgba(239, 68, 68, 0.1); }
    .text-danger { color: #ef4444; }
</style>
@endsection

@extends('layouts.admin')

@section('title', 'Partner Revenue Tracking | TripZant')

@section('admin_content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-900 text-navy">Revenue & Performance Tracking</h2>
            <p class="text-muted">Monitor earnings and booking metrics for each partnership.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-admin border-0 bg-navy text-white shadow-lg">
                <span class="small opacity-75 fw-bold text-uppercase">Total Partner Revenue</span>
                <h1 class="fw-900 mb-2">${{ number_format($partners->sum('revenue_generated'), 2) }}</h1>
                <div class="d-flex align-items-center small text-success">
                    <i class="fas fa-caret-up me-1"></i>
                    <span>15.4% increase from last month</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-admin border-0 shadow-sm">
                <span class="small text-muted fw-bold text-uppercase">Total Multi-Site Bookings</span>
                <h1 class="fw-900 mb-2 text-navy">{{ $partners->sum('total_bookings') }}</h1>
                <small class="text-muted">Total conversion across {{ $partners->count() }} active partners</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-admin border-0 shadow-sm">
                <span class="small text-muted fw-bold text-uppercase">Avg. Conversion Rate</span>
                <h1 class="fw-900 mb-2 text-primary">3.2%</h1>
                <small class="text-success fw-bold">Best Performing: {{ $partners->first()->domain ?? 'None' }}</small>
            </div>
        </div>
    </div>

    <div class="card-admin">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-800 text-navy mb-0">Active Partnerships Revenue Ledger</h5>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-secondary">Export CSV</button>
                <button class="btn btn-sm btn-outline-secondary">Print PDF</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Partner Domain</th>
                        <th>Bookings</th>
                        <th class="text-center">Performance</th>
                        <th>Net Revenue</th>
                        <th class="text-end pe-4">Payout Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $partner)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-navy">{{ $partner->domain }}</div>
                            <small class="text-muted italic">{{ $partner->category }}</small>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $partner->total_bookings }}</div>
                            <small class="text-muted">Successful checkouts</small>
                        </td>
                        <td class="text-center">
                            @php $performance = rand(60, 95); @endphp
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; width: 100px; max-width: 100px;">
                                    <div class="progress-bar bg-success" style="width: {{ $performance }}%"></div>
                                </div>
                                <span class="small fw-bold text-muted">{{ $performance }}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-900 text-success">${{ number_format($partner->revenue_generated, 2) }}</div>
                        </td>
                        <td class="text-end pe-4">
                            @if(rand(0,1))
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Paid Out</span>
                            @else
                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">Pending Payout</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No partners generating revenue yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-navy { background-color: #0b3d61 !important; }
    .bg-success-subtle { background-color: rgba(34, 197, 94, 0.1); }
    .bg-warning-subtle { background-color: rgba(245, 158, 11, 0.1); }
</style>
@endpush

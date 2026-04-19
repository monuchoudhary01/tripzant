@extends('layouts.admin')

@section('title', 'Partnership Dashboard | Website Traffic System')

@section('admin_content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-900 text-navy">Partnership Hub Overview</h2>
            <p class="text-muted">Discover high-traffic sites and convert them into booking partners.</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-admin border-0 stats-card" style="border-left-color: #3b82f6 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Websites</span>
                        <h2 class="fw-900 mb-0 mt-1">{{ number_format($stats['total_websites']) }}</h2>
                    </div>
                    <div class="icon-box bg-primary-subtle text-primary p-3 rounded-pill">
                        <i class="fas fa-globe fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-admin border-0 stats-card" style="border-left-color: #f59e0b !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">High Traffic (50k+)</span>
                        <h2 class="fw-900 mb-0 mt-1">{{ number_format($stats['high_traffic']) }}</h2>
                    </div>
                    <div class="icon-box bg-warning-subtle text-warning p-3 rounded-pill">
                        <i class="fas fa-bolt fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-admin border-0 stats-card" style="border-left-color: #10b981 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Partnered Sites</span>
                        <h2 class="fw-900 mb-0 mt-1">{{ number_format($stats['partnerships']) }}</h2>
                    </div>
                    <div class="icon-box bg-success-subtle text-success p-3 rounded-pill">
                        <i class="fas fa-handshake fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-admin border-0 stats-card" style="border-left-color: #6366f1 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Revenue</span>
                        <h2 class="fw-900 mb-0 mt-1">${{ number_format($stats['total_revenue'], 2) }}</h2>
                    </div>
                    <div class="icon-box bg-indigo-subtle text-indigo p-3 rounded-pill" style="color: #6366f1;">
                        <i class="fas fa-dollar-sign fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-admin">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-800 text-navy mb-0">Recently Discovered Websites</h5>
                    <a href="{{ route('admin.partnership.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Domain</th>
                                <th>Traffic</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentWebsites as $web)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $web->domain }}</div>
                                    <small class="text-muted">{{ $web->name }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-navy-subtle text-navy">{{ $web->monthly_traffic }}</span>
                                </td>
                                <td>{{ $web->category }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'new' => 'bg-info',
                                            'contacted' => 'bg-warning',
                                            'partnered' => 'bg-success',
                                            'rejected' => 'bg-danger'
                                        ][$web->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ ucfirst($web->status) }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.partnership.show', $web->id) }}" class="btn btn-sm btn-outline-navy rounded-pill">Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No websites discovered yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-admin mb-4">
                <h5 class="fw-800 text-navy mb-4">Quick Analysis</h5>
                <form action="{{ route('admin.partnership.fetch') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">ENTER WEBSITE URL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-link text-muted"></i></span>
                            <input type="url" name="url" class="form-control border-start-0" placeholder="https://example.com" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-navy w-100 rounded-pill py-3">
                        Analyze Traffic <i class="fas fa-search-plus ms-2"></i>
                    </button>
                </form>
            </div>

            <div class="card-admin">
                <h5 class="fw-800 text-navy mb-4">Top Revenue Partners</h5>
                <div class="partner-list">
                    @forelse($topPartners as $partner)
                    <div class="d-flex align-items-center mb-3 p-2 rounded-3 border">
                        <div class="avatar-sm bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">{{ $partner->domain }}</h6>
                            <small class="text-muted">{{ $partner->total_bookings }} Bookings</small>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0 fw-900 text-success">${{ number_format($partner->revenue_generated, 2) }}</h6>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted small text-center italic">No partnerships active yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-navy-subtle { background: rgba(11, 61, 97, 0.1); }
    .text-indigo { color: #6366f1; }
    .bg-indigo-subtle { background: rgba(99, 102, 241, 0.1); }
</style>
@endpush

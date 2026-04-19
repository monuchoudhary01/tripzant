@extends('layouts.admin')

@section('title', 'Website Discovery | Partnership System')

@section('admin_content')
<div class="container-fluid">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-900 text-navy mb-0">Website Discovery</h2>
            <p class="text-muted mb-0">Manage and filter your analyzed leads.</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.partnership.checker') }}" class="btn btn-navy rounded-pill px-4">
                <i class="fas fa-plus me-2"></i> Analyze New Website
            </a>
        </div>
    </div>

    <div class="card-admin border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <!-- Filters -->
            <div class="p-4 border-bottom bg-light bg-opacity-50">
                <form action="{{ route('admin.partnership.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted mb-1">TRAFFIC RANGE</label>
                        <select name="traffic" class="form-select rounded-3">
                            <option value="">All Traffic Levels</option>
                            <option value="10k" {{ request('traffic') == '10k' ? 'selected' : '' }}>10K+ Monthly</option>
                            <option value="50k" {{ request('traffic') == '50k' ? 'selected' : '' }}>50K+ Monthly</option>
                            <option value="100k" {{ request('traffic') == '100k' ? 'selected' : '' }}>100K+ Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted mb-1">PARTNERSHIP STATUS</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="">All Statuses</option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Discovery</option>
                            <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="partnered" {{ request('status') == 'partnered' ? 'selected' : '' }}>Partnered</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted mb-1">SEARCH DOMAIN</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-3" placeholder="Enter keywords..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary rounded-3" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.partnership.index') }}" class="btn btn-link text-muted small px-0">Reset Filters</a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Website / Domain</th>
                            <th>Traffic</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Rev. Impact</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($websites as $web)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-globe text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-navy">{{ $web->domain }}</div>
                                        <small class="text-muted">{{ $web->name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-navy fw-bold">{{ $web->monthly_traffic }}</span>
                                    <div class="progress mt-1" style="height: 4px; width: 60px;">
                                        <div class="progress-bar bg-primary" style="width: {{ min(($web->traffic_count / 500000) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $web->category }}</span></td>
                            <td>
                                @php
                                    $statusClass = [
                                        'new' => 'badge-admin-info',
                                        'contacted' => 'badge-admin-warning',
                                        'partnered' => 'badge-admin-success',
                                        'rejected' => 'badge-admin-danger'
                                    ][$web->status] ?? 'badge-admin-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($web->status) }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-success">${{ number_format($web->revenue_generated, 2) }}</div>
                                <small class="text-muted">{{ $web->total_bookings }} Bookings</small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-light rounded-circle shadow-none" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                        <li><a class="dropdown-item" href="{{ route('admin.partnership.show', $web->id) }}"><i class="fas fa-eye me-2 text-primary"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-paper-plane me-2 text-info"></i> Send Pitch</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Delete Lead</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800505.png" height="150" class="mb-3">
                                <h5 class="text-muted">No websites found match your filters.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-top">
                {{ $websites->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-admin-info { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 11px; }
    .badge-admin-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 11px; }
    .badge-admin-success { background: rgba(34, 197, 94, 0.1); color: #22c55e; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 11px; }
    .badge-admin-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 11px; }
    .badge-admin-secondary { background: rgba(100, 116, 139, 0.1); color: #64748b; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 11px; }
    .btn-icon { width: 36px; height: 36px; padding: 0; line-height: 36px; }
</style>
@endpush

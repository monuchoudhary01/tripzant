@extends('layouts.admin')

@section('title', 'Global Audit Logs | Master Admin')

@section('admin_content')
<div class="card-admin">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-900 text-navy mb-1">Global System Audit Logs</h4>
            <p class="text-muted small mb-0">Track all activities across B2B, Corporate, and Admin modules.</p>
        </div>
        <div>
            <a href="{{ route('admin.audit-logs.analytics') }}" class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm">
                <i class="fas fa-chart-line me-2"></i> System Analytics
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-light p-4 rounded-4 mb-4">
        <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, Email, or Action" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">User Type</label>
                <select name="user_type" class="form-select">
                    <option value="">All Types</option>
                    @foreach($userTypes as $type)
                        <option value="{{ $type }}" {{ request('user_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Module</label>
                <select name="module" class="form-select">
                    <option value="">All Modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>{{ $module }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Start Date</label>
                <input type="date" name="date_start" class="form-control" value="{{ request('date_start') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">End Date</label>
                <input type="date" name="date_end" class="form-control" value="{{ request('date_end') }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="border-0 px-4 py-3 fw-800 text-navy small">USER TYPE</th>
                    <th class="border-0 py-3 fw-800 text-navy small">USER NAME / ID</th>
                    <th class="border-0 py-3 fw-800 text-navy small">MODULE</th>
                    <th class="border-0 py-3 fw-800 text-navy small">ACTION</th>
                    <th class="border-0 py-3 fw-800 text-navy small">DESCRIPTION</th>
                    <th class="border-0 py-3 fw-800 text-navy small">IP ADDRESS</th>
                    <th class="border-0 py-3 fw-800 text-navy small">DATE & TIME</th>
                    <th class="border-0 py-3 fw-800 text-navy small text-end">VIEW</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="px-4">
                        @php
                            $badgeClass = 'bg-secondary-subtle text-secondary';
                            switch($log->user_type) {
                                case 'admin': $badgeClass = 'bg-danger-subtle text-danger'; break;
                                case 'agent': $badgeClass = 'bg-primary-subtle text-primary'; break;
                                case 'corporate': $badgeClass = 'bg-info-subtle text-info'; break;
                                case 'api': $badgeClass = 'bg-warning-subtle text-warning'; break;
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }} fw-bold px-3 py-2 rounded-pill small">
                            {{ strtoupper($log->user_type ?? 'GUEST') }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-700 text-navy">{{ $log->user_name }}</div>
                        <div class="text-muted tiny">ID: {{ $log->user_id ?? 'N/A' }}</div>
                    </td>
                    <td><span class="fw-600">{{ $log->module }}</span></td>
                    <td><span class="text-primary fw-700">{{ $log->action }}</span></td>
                    <td><div class="text-truncate small" style="max-width: 250px;">{{ $log->description }}</div></td>
                    <td><code class="small text-muted">{{ $log->ip_address }}</code></td>
                    <td>
                        <div class="fw-600 small">{{ $log->created_at->format('d M Y') }}</div>
                        <div class="text-muted tiny">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.audit-logs.show', $log->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold">Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">No audit logs found for the selected filters.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

<style>
    .tiny { font-size: 10px; }
    .bg-info-subtle { background: rgba(13, 202, 240, 0.1); }
    .text-info { color: #0dcaf0; }
    .bg-secondary-subtle { background: rgba(108, 117, 125, 0.1); }
</style>
@endsection

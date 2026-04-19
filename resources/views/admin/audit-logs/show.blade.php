@extends('layouts.admin')

@section('title', 'Log Details | Master Admin')

@section('admin_content')
<div class="row g-4">
    <div class="col-12">
        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i> Back to Logs
        </a>
    </div>

    <!-- Main Detail Card -->
    <div class="col-lg-4">
        <div class="card-admin">
            <h5 class="fw-900 text-navy mb-4">Log Information</h5>
            
            <div class="mb-4 pb-4 border-bottom">
                <label class="text-muted tiny text-uppercase fw-800 mb-1 d-block">User Context</label>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle bg-navy-subtle text-navy rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
                        {{ substr($log->user_name ?? 'AU', 0, 2) }}
                    </div>
                    <div>
                        <div class="fw-800 text-navy">{{ $log->user_name }}</div>
                        <div class="text-muted small">User ID: {{ $log->user_id ?? 'N/A' }}</div>
                        <span class="badge bg-primary-subtle text-primary mt-1">{{ strtoupper($log->user_type) }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <label class="text-muted tiny text-uppercase fw-800 mb-1 d-block">Module & Action</label>
                <div class="fw-700 text-navy fs-5">{{ $log->module }}</div>
                <div class="text-primary fw-800">{{ $log->action }}</div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <label class="text-muted tiny text-uppercase fw-800 mb-1 d-block">Network Metadata</label>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted small">IP Address</span>
                    <code class="text-navy fw-bold">{{ $log->ip_address }}</code>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Timestamp</span>
                    <span class="fw-600 small">{{ $log->created_at->format('d M Y, H:i:s') }}</span>
                </div>
            </div>

            <div>
                <label class="text-muted tiny text-uppercase fw-800 mb-1 d-block">Description</label>
                <p class="text-navy fw-600 small mb-0">{{ $log->description }}</p>
            </div>
        </div>
    </div>

    <!-- JSON / Data Card -->
    <div class="col-lg-8">
        <div class="card-admin">
            <ul class="nav nav-pills mb-4" id="logTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-4" id="request-tab" data-bs-toggle="pill" data-bs-target="#request-data" type="button" role="tab">Request Data</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4" id="response-tab" data-bs-toggle="pill" data-bs-target="#response-data" type="button" role="tab">Response Data</button>
                </li>
                @if($log->old_values || $log->new_values)
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4" id="comparison-tab" data-bs-toggle="pill" data-bs-target="#comparison-data" type="button" role="tab">Changes (Old vs New)</button>
                </li>
                @endif
            </ul>

            <div class="tab-content" id="logTabContent">
                <!-- Request Data -->
                <div class="tab-pane fade show active" id="request-data" role="tabpanel">
                    <div class="bg-dark rounded-4 p-4">
                        @if($log->request_data)
                            <pre class="text-info small mb-0"><code>{{ json_encode($log->request_data, JSON_PRETTY_PRINT) }}</code></pre>
                        @else
                            <div class="text-muted italic small text-center py-4">No request data available for this entry.</div>
                        @endif
                    </div>
                </div>

                <!-- Response Data -->
                <div class="tab-pane fade" id="response-data" role="tabpanel">
                    <div class="bg-dark rounded-4 p-4">
                        @if($log->response_data)
                            <pre class="text-success small mb-0"><code>{{ json_encode($log->response_data, JSON_PRETTY_PRINT) }}</code></pre>
                        @else
                            <div class="text-muted italic small text-center py-4">No response data available for this entry.</div>
                        @endif
                    </div>
                </div>

                <!-- Changes Data -->
                @if($log->old_values || $log->new_values)
                <div class="tab-pane fade" id="comparison-data" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-800 text-danger mb-3"><i class="fas fa-history me-2"></i> Old Values</h6>
                            <div class="bg-light rounded-4 p-4 border border-danger-subtle">
                                @if($log->old_values)
                                    <pre class="text-navy small mb-0"><code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</code></pre>
                                @else
                                    <div class="text-muted italic small">No previous state found.</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-800 text-success mb-3"><i class="fas fa-check-circle me-2"></i> New Values</h6>
                            <div class="bg-light rounded-4 p-4 border border-success-subtle">
                                @if($log->new_values)
                                    <pre class="text-navy small mb-0"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</code></pre>
                                @else
                                    <div class="text-muted italic small">No new values found.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy-subtle { background: rgba(11, 61, 97, 0.1); }
    pre { max-height: 500px; overflow-y: auto; }
    .nav-pills .nav-link { color: var(--admin-text-light); border-radius: 10px; margin-right: 10px; }
    .nav-pills .nav-link.active { background-color: var(--admin-primary) !important; color: #fff !important; }
</style>
@endsection

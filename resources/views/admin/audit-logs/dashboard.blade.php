@extends('layouts.admin')

@section('title', 'System Analytics Dashboard | Master Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h3 class="fw-900 text-navy mb-1">Global System Analytics</h3>
        <p class="text-muted small mb-0">Business insights and performance monitoring dashboard.</p>
    </div>
    <div class="d-flex gap-3">
        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-primary fw-bold px-4 rounded-pill">
            <i class="fas fa-list-ol me-2"></i> View Raw Logs
        </a>
        <button class="btn btn-primary fw-bold px-4 rounded-pill">
            <i class="fas fa-download me-2"></i> Export Report
        </button>
    </div>
</div>

<!-- Key Metrics Section -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card-admin text-white hvr-grow" style="background: linear-gradient(135deg, #0b3d61 0%, #3b82f6 100%);">
            <div class="d-flex justify-content-between mb-4">
                <div class="fw-800 text-uppercase small opacity-75">Flight Searches</div>
                <div class="fs-4"><i class="fas fa-search"></i></div>
            </div>
            <h2 class="fw-900 mb-1">{{ number_format($stats['total_searches']) }}</h2>
            <div class="small fw-bold text-success-subtle"><i class="fas fa-arrow-up me-1"></i> +12% activity</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-admin text-white hvr-grow" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
            <div class="d-flex justify-content-between mb-4">
                <div class="fw-800 text-uppercase small opacity-75">PNRs Created</div>
                <div class="fs-4"><i class="fas fa-ticket-alt"></i></div>
            </div>
            <h2 class="fw-900 mb-1">{{ number_format($stats['total_pnrs']) }}</h2>
            <div class="small fw-bold text-success-subtle"><i class="fas fa-check-circle me-1"></i> 82% success rate</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-admin text-white hvr-grow" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="d-flex justify-content-between mb-4">
                <div class="fw-800 text-uppercase small opacity-75">Confirmed Bookings</div>
                <div class="fs-4"><i class="fas fa-shopping-cart"></i></div>
            </div>
            <h2 class="fw-900 mb-1">{{ number_format($stats['total_confirmed']) }}</h2>
            <div class="small fw-bold text-white"><i class="fas fa-coins me-1"></i> Revenue Milestone</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-admin text-white hvr-grow" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);">
            <div class="d-flex justify-content-between mb-4">
                <div class="fw-800 text-uppercase small opacity-75">Failed Bookings</div>
                <div class="fs-4"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <h2 class="fw-900 mb-1">{{ number_format($stats['total_failed']) }}</h2>
            <div class="small fw-bold text-warning-subtle"><i class="fas fa-clock me-1"></i> 2.4% inefficiency</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Visual Trends -->
    <div class="col-xl-8">
        <div class="card-admin">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h5 class="fw-900 text-navy mb-0">System Activity Over Time</h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active">7 Days</button>
                    <button class="btn btn-outline-secondary">30 Days</button>
                </div>
            </div>
            <div class="chart-box" style="height: 300px; padding: 20px; background: #f8fafc; border-radius: 20px; position: relative;">
                <div class="d-flex align-items-end h-100 gap-2">
                    @php $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; @endphp
                    @for($i=0; $i<7; $i++)
                        <div class="flex-grow-1 d-flex flex-column align-items-center gap-3">
                            <div class="w-100 bg-primary opacity-25 rounded-3" style="height: {{ rand(30, 80) }}%"></div>
                            <span class="tiny fw-bold text-muted">{{ $labels[$i] }}</span>
                        </div>
                    @endfor
                </div>
                <!-- Mock Trend Line Overlay (Simple SVG) -->
                <svg class="position-absolute" style="top:40px; left:20px; width:calc(100% - 40px); height:220px;">
                    <path d="M0,150 Q100,50 200,120 T400,80 T600,100 T800,20" fill="none" stroke="#0b3d61" stroke-width="4" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Top Operators -->
    <div class="col-xl-4">
        <div class="card-admin">
            <h5 class="fw-900 text-navy mb-4">Top Performance Operators</h5>
            <div class="performance-list">
                @foreach($operatorPerformance as $op)
                <div class="d-flex align-items-center justify-content-between mb-4 pb-4 border-bottom last-border-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary">
                            {{ substr($op->user_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="fw-700 text-navy small">{{ $op->user_name }}</div>
                            <div class="text-muted tiny">Efficiency: {{ $op->conversion ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-900 text-navy">{{ $op->total }}</div>
                        <div class="tiny text-muted uppercase fw-800">ACTIONS</div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="#" class="btn btn-link text-primary fw-bold w-100 p-0 fs-7 mt-2 text-decoration-none">Full Rankings <i class="fas fa-chevron-right ms-2 scale-8"></i></a>
        </div>
    </div>
</div>

<style>
    .hvr-grow { transition: transform 0.3s ease; }
    .hvr-grow:hover { transform: scale(1.02); }
    .text-success-subtle { color: #86efac; }
    .text-warning-subtle { color: #fde047; }
    .tiny { font-size: 11px; }
    .last-border-0:last-child { border-bottom: 0 !important; }
    .scale-8 { transform: scale(0.8); }
</style>
@endsection

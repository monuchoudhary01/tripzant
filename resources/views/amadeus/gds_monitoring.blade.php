@extends('layouts.b2b_master')

@section('title', 'GDS Performance Monitoring | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">GDS Performance Monitoring</h4>
        <p class="text-muted small mb-0">Track real-time GDS connectivity, API usage and latency metrics.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary btn-sm px-4 fw-700 bg-white"><i class="fas fa-sync-alt me-2"></i> REFRESH STATS</button>
        <button class="btn btn-primary btn-sm px-4 fw-700"><i class="fas fa-download me-2"></i> EXPORT LOGS</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-stat border-start border-primary border-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-700 uppercase">API Status</span>
                <span class="badge bg-success rounded-pill fw-700" style="font-size: 10px;">OPERATIONAL</span>
            </div>
            <h3 class="mb-0 outfit">99.98%</h3>
            <p class="text-muted small mt-2 mb-0">Avg Uptime (Last 30d)</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat border-start border-info border-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-700 uppercase">Latency</span>
                <span class="text-info"><i class="fas fa-bolt"></i></span>
            </div>
            <h3 class="mb-0 outfit">245 ms</h3>
            <p class="text-muted small mt-2 mb-0">Current Response Time</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat border-start border-warning border-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-700 uppercase">Total Hits</span>
                <span class="text-warning"><i class="fas fa-network-wired"></i></span>
            </div>
            <h3 class="mb-0 outfit">1.28 M</h3>
            <p class="text-muted small mt-2 mb-0">API Calls in last 24h</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat border-start border-danger border-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-700 uppercase">Errors</span>
                <span class="badge bg-danger rounded-pill fw-700" style="font-size: 10px;">LOW RISK</span>
            </div>
            <h3 class="mb-0 outfit">0.02%</h3>
            <p class="text-muted small mt-2 mb-0">Failure Rate</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="b2b-table-card p-4">
            <h5 class="mb-4">Traffic Performance Trend</h5>
            <div style="height: 350px;">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="b2b-table-card p-4 h-100">
             <h5 class="mb-4">Recent System Logs</h5>
             <div class="d-flex flex-column gap-3">
                <div class="p-3 bg-light rounded-3 d-flex gap-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px;"><i class="fas fa-info"></i></div>
                    <div>
                        <div class="fw-700" style="font-size: 13px;">GDS Connector Re-established</div>
                        <div class="text-muted tiny">15:20:45 | Amadeus Core - PROD</div>
                    </div>
                </div>
                <div class="p-3 bg-light rounded-3 d-flex gap-3">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px;"><i class="fas fa-check"></i></div>
                    <div>
                        <div class="fw-700" style="font-size: 13px;">Batch Tkt Queue Processed</div>
                        <div class="text-muted tiny">14:10:12 | Success: 42, Failed: 0</div>
                    </div>
                </div>
                 <div class="p-3 bg-light rounded-3 d-flex gap-3">
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px;"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <div class="fw-700" style="font-size: 13px;">High Latency on LH (Air)</div>
                        <div class="text-muted tiny">12:30:10 | Lufthansa Host delayed responses</div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
    new Chart(ctxTraffic, {
        type: 'line',
        data: {
            labels: ['12:00', '13:00', '14:00', '15:00', '16:00', '17:00'],
            datasets: [
                {
                    label: 'API Request Load',
                    data: [1200, 2400, 1800, 3100, 2900, 3500],
                    borderColor: '#0052cc',
                    backgroundColor: 'rgba(0, 82, 204, 0.05)',
                    fill: true,
                    tension: 0.4
                },
                 {
                    label: 'Success Response',
                    data: [1180, 2380, 1795, 3090, 2895, 3498],
                    borderColor: '#36b37e',
                    backgroundColor: 'transparent',
                    borderDash: [5, 5],
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection

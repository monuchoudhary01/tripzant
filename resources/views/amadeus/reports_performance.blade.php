@extends('layouts.b2b_master')

@section('title', 'Agent Performance Report | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Sub-Agent Performance Report</h4>
        <p class="text-muted small mb-0">Evaluate sub-agents based on booking volume, ticket conversion rates and revenue contribution.</p>
    </div>
    <div class="d-flex gap-2">
         <button class="btn btn-outline-primary btn-sm px-4 fw-700 bg-white">REPAIR STATS</button>
        <button class="btn btn-primary btn-sm px-4 fw-700"><i class="fas fa-file-pdf me-2"></i> DOWNLOAD PDF</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="b2b-table-card p-4">
            <h5 class="mb-4">Top Performing Agents (Monthly Revenue)</h5>
            <div style="height: 300px;">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="b2b-table-card p-4 h-100">
             <h5 class="mb-4">Agent Rankings</h5>
             <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center p-2 rounded-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fw-800 text-primary">01.</div>
                        <div class="fw-700">Travel Sphere</div>
                    </div>
                    <div class="text-success fw-700">₹1.2 Cr</div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 rounded-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fw-800 text-secondary">02.</div>
                        <div class="fw-700">Global Holiday</div>
                    </div>
                    <div class="text-success fw-700">₹82.5 L</div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 rounded-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fw-800 text-secondary">03.</div>
                        <div class="fw-700">City Travels</div>
                    </div>
                    <div class="text-success fw-700">₹45.0 L</div>
                </div>
                 <div class="d-flex justify-content-between align-items-center p-2 rounded-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fw-800 text-secondary">04.</div>
                        <div class="fw-700">Skyline Wings</div>
                    </div>
                    <div class="text-success fw-700">₹12.3 L</div>
                </div>
             </div>
             <p class="small text-muted mt-3 mb-0 text-center"><i class="fas fa-info-circle me-1"></i> Ranking based on net revenue contribution.</p>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0">Detailed Performance Metrics</h5>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Agent Name</th>
                    <th>Total Bookings</th>
                    <th>Ticketed</th>
                    <th>Conversion Rate</th>
                    <th>Cancellations</th>
                    <th>Net Revenue</th>
                    <th>Profit Share</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700">Travel Sphere</td>
                    <td>845</td>
                    <td>810</td>
                    <td><span class="text-success fw-700">95.8%</span></td>
                    <td>12</td>
                    <td class="fw-700">₹1.2 Cr</td>
                    <td class="text-primary fw-700">₹2.8 L</td>
                </tr>
                <tr>
                    <td class="fw-700">Global Holiday</td>
                    <td>510</td>
                    <td>460</td>
                    <td><span class="text-warning fw-700">90.2%</span></td>
                    <td>18</td>
                    <td class="fw-700">₹82.5 L</td>
                    <td class="text-primary fw-700">₹1.1 L</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctxPerf = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctxPerf, {
        type: 'bar',
        data: {
            labels: ['Travel Sphere', 'Global Holiday', 'City Travels', 'Skyline Wings', 'Trip Hub'],
            datasets: [{
                label: 'Revenue (₹ Lakhs)',
                data: [120, 82, 45, 12, 5],
                backgroundColor: 'rgba(0, 82, 204, 0.8)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection

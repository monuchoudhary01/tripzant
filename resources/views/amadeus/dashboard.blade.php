@extends('layouts.b2b_master')

@section('title', 'Dashboard | Amadeus Partner Panel')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-primary text-white">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">Total Bookings</div>
            <h3 class="mt-1 mb-0 outfit">1,280</h3>
            <div class="mt-2 text-success small fw-700">
                <i class="fas fa-arrow-up me-1"></i> 12% vs last month
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-success text-white">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">Revenue (Monthly)</div>
            <h3 class="mt-1 mb-0 outfit">₹42.50 L</h3>
            <div class="mt-2 text-success small fw-700">
                <i class="fas fa-arrow-up me-1"></i> 8.4% vs last month
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-warning text-white">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">Wallet Balance</div>
            <h3 class="mt-1 mb-0 outfit">₹14,52,800</h3>
            <div class="mt-2 text-muted small fw-700 text-uppercase">
                Recent Topup: 2h ago
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-danger text-white">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">Used Credit</div>
            <h3 class="mt-1 mb-0 outfit">₹3,20,000</h3>
            <div class="mt-2 text-danger small fw-700">
                80% of Limit Reach
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="b2b-table-card h-100">
            <div class="card-header border-0 pb-0">
                <h5 class="mb-0">Sales Analytics</h5>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Last 30 Days</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                        <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                    </ul>
                </div>
            </div>
            <div class="p-4 pt-1">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="b2b-table-card h-100">
            <div class="card-header">
                <h5 class="mb-0">System Alerts</h5>
            </div>
            <div class="p-3">
                <div class="d-flex gap-3 p-3 rounded-3 mb-3" style="background: #fff8eb;">
                    <div class="text-warning"><i class="fas fa-exclamation-triangle fa-lg"></i></div>
                    <div>
                        <div class="fw-700" style="font-size: 14px;">Low Wallet Balance</div>
                        <div class="text-muted small">Sub-agent 'TravelSphere' (ID: AG-442) has balance below limit.</div>
                        <button class="btn btn-warning btn-sm mt-2 fw-700 py-1" style="font-size: 11px;">SEND ALERT</button>
                    </div>
                </div>
                <div class="d-flex gap-3 p-3 rounded-3 mb-3" style="background: #eef4ff;">
                    <div class="text-primary"><i class="fas fa-plane-arrival fa-lg"></i></div>
                    <div>
                        <div class="fw-700" style="font-size: 14px;">Group Quote Request</div>
                        <div class="text-muted small">New request for 25 Pax (DEL-AMS) received from 'Global Tours'.</div>
                        <button class="btn btn-primary btn-sm mt-2 fw-700 py-1" style="font-size: 11px;">VIEW DETAILS</button>
                    </div>
                </div>
                <div class="d-flex gap-3 p-3 rounded-3" style="background: #fdf2f2;">
                    <div class="text-danger"><i class="fas fa-times-circle fa-lg"></i></div>
                    <div>
                        <div class="fw-700" style="font-size: 14px;">Failed Payment</div>
                        <div class="text-muted small">Transaction #TX99201 failed due to insufficient credit limit.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header">
        <h5 class="mb-0">Recent Bookings</h5>
        <a href="#" class="text-primary text-decoration-none fw-700 small uppercase">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>PNR/Booking ID</th>
                    <th>Sub-Agent</th>
                    <th>Route</th>
                    <th>Airline</th>
                    <th>Travel Date</th>
                    <th>Total Fare</th>
                    <th>Profit</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-700 text-primary">XY78WQ</div>
                        <div class="text-muted small">ID: 2024-0012</div>
                    </td>
                    <td>
                        <div class="fw-600">Travel Sphere</div>
                        <div class="text-muted" style="font-size: 11px;">Sub-Agent</div>
                    </td>
                    <td>
                        <div class="fw-600">DEL <i class="fas fa-arrow-right mx-1 text-muted" style="font-size: 10px;"></i> DXB</div>
                        <div class="text-muted small">One Way</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="https://img.logo.dev/ek.png?token=pk_mX9M9_I_S0q_8p_J2w" width="24" height="24" class="rounded-circle">
                            <span class="fw-600">Emirates</span>
                        </div>
                    </td>
                    <td class="fw-600">12 Apr 2024</td>
                    <td class="fw-700">₹45,280</td>
                    <td class="text-success fw-700">+ ₹1,250</td>
                    <td><span class="b2b-badge badge-success">Ticketed</span></td>
                    <td>
                        <button class="btn btn-light btn-sm"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-light btn-sm"><i class="fas fa-download"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1 Mar', '5 Mar', '10 Mar', '15 Mar', '20 Mar', '25 Mar', '30 Mar'],
            datasets: [{
                label: 'Sales Revenue (₹)',
                data: [420000, 580000, 490000, 720000, 610000, 850000, 920000],
                borderColor: '#0052cc',
                backgroundColor: 'rgba(0, 82, 204, 0.05)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' },
                    ticks: {
                        callback: function(value) { return '₹' + value.toLocaleString(); },
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script>
@endsection

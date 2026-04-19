@extends('layouts.iata_panel')

@section('title', 'Amadeus B2B | Partner Dashboard')

@section('iata_content')
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon bg-blue-soft">
                <i class="fas fa-plane"></i>
            </div>
            <div class="text-muted small fw-700 uppercase mb-1">Total Bookings</div>
            <div class="h3 fw-800 text-navy mb-0 outfit">1,284</div>
            <div class="mt-2 text-success small fw-700">
                <i class="fas fa-arrow-up me-1"></i> 15% <span class="text-muted fw-500">this month</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon bg-green-soft">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="text-muted small fw-700 uppercase mb-1">Total Revenue</div>
            <div class="h3 fw-800 text-navy mb-0 outfit">₹12,85,420</div>
            <div class="mt-2 text-success small fw-700">
                <i class="fas fa-arrow-up me-1"></i> 8.2% <span class="text-muted fw-500">growth</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon bg-orange-soft">
                <i class="fas fa-coins"></i>
            </div>
            <div class="text-muted small fw-700 uppercase mb-1">Wallet Balance</div>
            <div class="h3 fw-800 text-navy mb-0 outfit">₹1,45,280</div>
            <div class="mt-2 text-warning small fw-700">
                <i class="fas fa-plus-circle me-1"></i> Add Balance
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon bg-teal-soft">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="text-muted small fw-700 uppercase mb-1">Credit Usage</div>
            <div class="h3 fw-800 text-navy mb-0 outfit">₹65,000</div>
            <div class="mt-2 text-primary small fw-700">
                <span class="text-muted fw-500">Limit: ₹5.0L</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border border-light">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h6 class="fw-800 text-navy mb-0 outfit">Daily Sales Performance</h6>
                    <p class="text-muted small mb-0 fw-600">Track your daily ticket issuance volume</p>
                </div>
                <div class="btn-group">
                    <button class="btn btn-light btn-sm fw-700 px-3">Weekly</button>
                    <button class="btn btn-white border btn-sm fw-700 px-3 text-muted">Monthly</button>
                </div>
            </div>
            
            <div style="height: 320px; background: #fff; position: relative; display: flex; align-items: flex-end; padding: 20px 10px; gap: 12px; border-bottom: 2px solid #f1f5f9;">
                @php $heights = [45, 60, 40, 85, 70, 55, 90]; @endphp
                @foreach($heights as $day => $h)
                <div class="flex-grow-1 bar-container" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                    <div class="bar-value small fw-800 text-center mb-2" style="font-size: 10px; color: var(--iata-blue);">{{ $h }}k</div>
                    <div class="bg-blue-soft rounded-top transition-all" style="height: {{ $h }}%; border-radius: 6px 6px 0 0; background: linear-gradient(to top, #eff6ff, #3b82f6);"></div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-between mt-3 px-2 text-muted small fw-700 uppercase" style="letter-spacing: 1px;">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border border-light">
            <h6 class="fw-800 text-navy mb-4 outfit">System Alerts</h6>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border border-warning border-opacity-25">
                    <div class="stats-icon bg-orange-soft mt-1" style="width: 32px; height: 32px; font-size: 14px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <div class="fw-800 small text-dark">Low Wallet Balance</div>
                        <p class="mb-0 x-small fw-600 text-muted mt-1">Your balance is below ₹50,000. Top up to avoid booking failures.</p>
                        <a href="#" class="text-primary fw-800 x-small text-decoration-none mt-2 d-inline-block">Add Money →</a>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border border-info border-opacity-25">
                    <div class="stats-icon bg-blue-soft mt-1" style="width: 32px; height: 32px; font-size: 14px;">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div>
                        <div class="fw-800 small text-dark">Pending Ticket Issues</div>
                        <p class="mb-0 x-small fw-600 text-muted mt-1">3 passengers awaiting ticket issuance in PNR AX782S.</p>
                        <a href="#" class="text-primary fw-800 x-small text-decoration-none mt-2 d-inline-block">Action Now →</a>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border border-danger border-opacity-25">
                    <div class="stats-icon bg-danger bg-opacity-10 text-danger mt-1" style="width: 32px; height: 32px; font-size: 14px;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <div class="fw-800 small text-dark">Failed Transactions</div>
                        <p class="mb-0 x-small fw-600 text-muted mt-1">2 bookings failed due to airline API time-out.</p>
                        <a href="#" class="text-danger fw-800 x-small text-decoration-none mt-2 d-inline-block">View Logs →</a>
                    </div>
                </div>
            </div>
            <button class="btn btn-dark w-100 mt-auto fw-800 py-2 rounded-3" style="font-size: 13px;">View All Notifications</button>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white border border-light mb-5">
    <div class="p-4 border-bottom border-light d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-800 text-navy mb-0 outfit">Recent Booking Activity</h6>
            <p class="text-muted small mb-0 fw-600">Overview of your most recent 5 transactions</p>
        </div>
        <a href="#" class="btn btn-light btn-sm fw-800 px-4 py-2 border rounded-3">
            <i class="fas fa-download me-2 text-muted"></i> Export Report
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-premium mb-0">
            <thead>
                <tr>
                    <th>PNR</th>
                    <th>Sub-Agent</th>
                    <th>Passenger</th>
                    <th>Route</th>
                    <th>Booking Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $recent_bookings = [
                    ['pnr' => 'AM72XQ', 'agent' => 'Global Travels', 'pax' => 'Rohan Mehra', 'route' => 'DEL → DXB', 'date' => '07 Apr, 10:20', 'val' => '₹24,500', 'status' => 'Issued'],
                    ['pnr' => 'AX782S', 'agent' => 'Direct', 'pax' => 'Anjali Singh', 'route' => 'BOM → LHR', 'date' => '07 Apr, 09:45', 'val' => '₹68,200', 'status' => 'Pending'],
                    ['pnr' => 'BJ993P', 'agent' => 'Zant Air', 'pax' => 'John Doe', 'route' => 'DEL → BLR', 'date' => '06 Apr, 22:10', 'val' => '₹5,400', 'status' => 'Issued'],
                    ['pnr' => 'CK552Q', 'agent' => 'Global Travels', 'pax' => 'Sara Khan', 'route' => 'MAA → SIN', 'date' => '06 Apr, 18:30', 'val' => '₹18,900', 'status' => 'Cancelled'],
                    ['pnr' => 'DL114T', 'agent' => 'FlyHigh Tours', 'pax' => 'Vikram Goel', 'route' => 'DEL → GOI', 'date' => '06 Apr, 14:15', 'val' => '₹4,100', 'status' => 'Issued'],
                ];
                @endphp
                @foreach($recent_bookings as $b)
                <tr>
                    <td class="fw-800 text-primary">{{ $b['pnr'] }}</td>
                    <td class="fw-700 small">{{ $b['agent'] }}</td>
                    <td class="fw-700 text-navy">{{ $b['pax'] }}</td>
                    <td class="fw-700 text-muted">{{ $b['route'] }}</td>
                    <td class="small fw-600 border-start ps-3">{{ $b['date'] }}</td>
                    <td class="fw-800">{{ $b['val'] }}</td>
                    <td>
                        <span class="badge-status {{ $b['status'] == 'Issued' ? 'badge-success' : ($b['status'] == 'Pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $b['status'] }}
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle border-0" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v text-muted"></i></button>
                            <ul class="dropdown-menu shadow-sm border-0 small">
                                <li><a class="dropdown-item fw-600 py-2" href="#"><i class="fas fa-eye me-2 text-muted"></i> View Details</a></li>
                                <li><a class="dropdown-item fw-600 py-2" href="#"><i class="fas fa-print me-2 text-muted"></i> Print Ticket</a></li>
                                <li><a class="dropdown-item fw-600 py-2 text-danger" href="#"><i class="fas fa-times me-2"></i> Cancel</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    .transition-all { transition: all 0.3s ease; }
    .bar-container:hover .bg-blue-soft {
        filter: brightness(0.9);
        cursor: pointer;
    }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

@endsection

@section('styles')
<style>
    .hover-show {
        transition: 0.2s;
    }
    .flex-grow-1:hover .hover-show {
        opacity: 1 !important;
    }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

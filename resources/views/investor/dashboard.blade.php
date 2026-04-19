@extends('layouts.app')

@section('title', "Investor Command Center | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .investor-stat-card {
        background: #fff; border-radius: 24px; padding: 30px; border: 1px solid #f1f5f9; transition: 0.3s;
    }
    .investor-stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
    
    .nav-link-investor {
        display: flex; align-items: center; gap: 12px; padding: 15px 20px; border-radius: 15px; 
        color: #64748b; text-decoration: none; font-weight: 800; font-size: 14px; transition: 0.3s;
    }
    .nav-link-investor:hover, .nav-link-investor.active { background: rgba(15, 23, 42, 0.05); color: #0f172a; }
    .nav-link-investor.active { border-left: 4px solid #1eccd1; }
    
    .earning-badge { background: #1eccd120; color: #1eccd1; font-weight: 900; font-size: 11px; padding: 5px 12px; border-radius: 10px; }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 95vh;">
    <div class="container">
        <div class="row g-4">
            <!-- Left Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="text-center mb-4 pb-4 border-bottom border-light">
                        <div class="avatar-box bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-900 fs-3 mb-3 mx-auto shadow-lg" style="width: 80px; height: 80px; background: #0f172a;">MV</div>
                        <h5 class="fw-900 text-navy mb-1">Manish Varma</h5>
                        <div class="badge bg-primary-light text-primary rounded-pill x-small px-3 fw-bold">ELITE INVESTOR</div>
                    </div>
                    
                    <div class="sidebar-nav d-flex flex-column gap-2">
                        <a href="{{ route('investor.dashboard') }}" class="nav-link-investor active"><i class="fas fa-th-large"></i> Dashboard View</a>
                        <a href="{{ route('investor.wallet') }}" class="nav-link-investor"><i class="fas fa-wallet text-success"></i> Wallet / Funds</a>
                        <a href="{{ route('investor.segments') }}" class="nav-link-investor"><i class="fas fa-map-marked-alt text-primary"></i> My Segments</a>
                        <a href="{{ route('investor.earnings') }}" class="nav-link-investor"><i class="fas fa-chart-line text-warning"></i> Booking Earnings</a>
                        <a href="{{ route('investor.transactions') }}" class="nav-link-investor"><i class="fas fa-history text-info"></i> Transactions</a>
                        <a href="#" class="nav-link-investor"><i class="fas fa-file-contract text-muted"></i> Reports</a>
                        <a href="#" class="nav-link-investor"><i class="fas fa-cog text-muted"></i> Settings</a>
                        <hr class="opacity-10">
                        <a href="/" class="nav-link-investor text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4" style="background: #0f172a; color: #fff;">
                    <h6 class="fw-900 mb-3 small uppercase opacity-75">Investment Status</h6>
                    <p class="small fw-bold opacity-50 mb-4">Your current liquidity is fueling <span class="text-info fw-900">42%</span> of this month's flight bookings across assigned segments.</p>
                    <button class="btn btn-info w-100 rounded-pill py-3 fw-900 small text-white" style="background: #1eccd1; border: none;">FUND MORE SEGMENTS</button>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <!-- Welcome Section -->
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h2 class="fw-900 text-navy mb-1">Investor Command Center</h2>
                        <p class="text-muted small fw-bold uppercase">Funding Specific Routes & Generating Passive Wealth 🗺️📈</p>
                    </div>
                    <a href="{{ route('investor.wallet') }}" class="btn btn-navy rounded-pill px-5 py-3 fw-900 shadow-lg text-white" style="background: #0f172a;">
                        <i class="fas fa-plus-circle me-2"></i> ADD FUNDS
                    </a>
                </div>

                <!-- Live Metrics Grid -->
                <!-- ... (kept the existing stats) ... -->

                <!-- My Segments Quick View -->
                <h6 class="fw-900 text-navy mb-4"><i class="fas fa-route me-2 text-primary"></i> My Allocated Segments</h6>
                <div class="row g-3 mb-5">
                    @php
                    $segments = [
                        ['route' => 'Mumbai → Delhi', 'invested' => '₹50,000', 'balance' => '₹32,400', 'pax' => 120, 'earn' => '₹12,000', 'color' => '#0f172a'],
                        ['route' => 'Delhi → Dubai', 'invested' => '₹2,00,000', 'balance' => '₹1,45,000', 'pax' => 54, 'earn' => '₹5,400', 'color' => '#1eccd1'],
                        ['route' => 'Kolkata → Jaipur', 'invested' => '₹30,000', 'balance' => '₹12,000', 'pax' => 180, 'earn' => '₹18,000', 'color' => '#f97316'],
                    ];
                    @endphp
                    @foreach($segments as $s)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden" style="border-bottom: 4px solid {{ $s['color'] }} !important;">
                            <div class="x-small fw-900 text-muted uppercase mb-2">ROUTE SEGMENT</div>
                            <h6 class="fw-900 text-navy mb-3">{{ $s['route'] }}</h6>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="x-small fw-bold text-muted">Invested</span>
                                <span class="x-small fw-900 text-navy">{{ $s['invested'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="x-small fw-bold text-muted">Balance</span>
                                <span class="x-small fw-900 text-primary">{{ $s['balance'] }}</span>
                            </div>

                            <div class="p-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="x-small fw-bold text-muted uppercase" style="font-size: 8px;">Tickets Funded</div>
                                    <div class="small fw-900 text-navy">{{ $s['pax'] }} PAX</div>
                                </div>
                                <div class="text-end">
                                    <div class="x-small fw-bold text-muted uppercase" style="font-size: 8px;">Earnings</div>
                                    <div class="small fw-900 text-success">+{{ $s['earn'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Recent Funded Bookings Table -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-900 text-navy mb-0"><i class="fas fa-plane-arrival me-2 text-primary"></i> Live Funding & Earnings (₹100/Ticket)</h6>
                        <span class="x-small fw-900 text-muted uppercase">Real-time update</span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">BOOKING ID</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">TRAVEL ROUTE</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">DEDUCTION</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">EARNINGS</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold small text-navy">TS-FL-1284</td>
                                    <td>
                                        <div class="small fw-900 text-navy">Delhi → London</div>
                                        <div class="x-small text-muted fw-bold uppercase">1 PASSENGER</div>
                                    </td>
                                    <td class="fw-900 text-danger small">-₹48,500</td>
                                    <td><span class="earning-badge">+₹100</span></td>
                                    <td><span class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-bold">FUNDED</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold small text-navy">TS-FL-1290</td>
                                    <td>
                                        <div class="small fw-900 text-navy">Mumbai → Tokyo</div>
                                        <div class="x-small text-muted fw-bold uppercase">4 PASSENGERS</div>
                                    </td>
                                    <td class="fw-900 text-danger small">-₹1,94,200</td>
                                    <td><span class="earning-badge">+₹400</span></td>
                                    <td><span class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-bold">FUNDED</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold small text-navy">TS-FL-1302</td>
                                    <td>
                                        <div class="small fw-900 text-navy">Bangalore → New York</div>
                                        <div class="x-small text-muted fw-bold uppercase">2 PASSENGERS</div>
                                    </td>
                                    <td class="fw-900 text-danger small">-₹1,24,000</td>
                                    <td><span class="earning-badge">+₹200</span></td>
                                    <td><span class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-bold">FUNDED</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ROI Graph Mock -->
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <h6 class="fw-900 text-navy mb-4">Investment Performance (Earnings Growth)</h6>
                    <div style="height: 200px; display: flex; align-items: flex-end; justify-content: space-around; gap: 10px;">
                        @foreach([30, 45, 25, 60, 80, 55, 90] as $h)
                        <div class="bg-primary shadow-sm rounded-top-3" style="width: 100%; height: {{ $h }}%; opacity: 0.8; transition: 0.3s; background: #0f172a;"></div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between mt-3 text-muted x-small fw-bold">
                        <span>MAY</span><span>JUN</span><span>JUL</span><span>AUG</span><span>SEP</span><span>OCT</span><span>NOV</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

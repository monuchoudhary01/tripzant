@extends('layouts.app')

@section('title', "B2B Ticketing Desk | Trip Zant Agent")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .nav-link-agent {
        display: flex; align-items: center; gap: 12px; padding: 15px 20px; border-radius: 12px; 
        color: #4a5568; text-decoration: none; font-weight: 800; font-size: 13px; transition: 0.3s;
    }
    .nav-link-agent:hover, .nav-link-agent.active { background: #3182ce15; color: #3182ce; }
    .nav-link-agent.active { border-left: 4px solid #3182ce; }
    
    .inventory-badge { background: #edf2f7; color: #4a5568; font-weight: 900; font-size: 10px; padding: 4px 10px; border-radius: 8px; border: 1px solid #e2e8f0; }
    .flight-row { background: #fff; border-radius: 20px; border: 1px solid #edf2f7; transition: 0.3s; }
    .flight-row:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f7fafc; min-height: 95vh;">
    <div class="container container-fluid">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="mb-4 pb-4 border-bottom border-light text-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-900 shadow-lg mx-auto mb-3" style="width: 60px; height: 60px;">IA</div>
                        <h6 class="fw-900 text-dark mb-1 small uppercase">Indus Travels</h6>
                        <div class="badge bg-success-subtle text-success rounded-pill x-small fw-bold px-3">IATA VERIFIED</div>
                    </div>
                    
                    <div class="sidebar-nav d-flex flex-column gap-1">
                        <a href="{{ route('agent.dashboard') }}" class="nav-link-agent"><i class="fas fa-th-large"></i> Overview</a>
                        <a href="{{ route('agent.network') }}" class="nav-link-agent"><i class="fas fa-globe-americas"></i> Global Network</a>
                        <a href="{{ route('agent.connections') }}" class="nav-link-agent"><i class="fas fa-users"></i> My Connections</a>
                        <a href="{{ route('agent.ticketing') }}" class="nav-link-agent active"><i class="fas fa-ticket-alt"></i> Ticketing Desk</a>
                        <a href="{{ route('agent.profit-sharing') }}" class="nav-link-agent"><i class="fas fa-hand-holding-usd"></i> Profit Sharing</a>
                        <a href="{{ route('agent.transactions') }}" class="nav-link-agent"><i class="fas fa-file-invoice-dollar"></i> Transactions</a>
                        <hr class="opacity-10 my-3">
                        <a href="/" class="nav-link-agent text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="mb-5">
                    <h2 class="fw-900 text-dark mb-1">Global B2B Ticketing Desk</h2>
                    <p class="text-muted small fw-bold uppercase">Issue Tickets via Verified Partner Inventory 🌐</p>
                </div>

                <!-- B2B Flight Search Widget -->
                <div class="card border-0 shadow-sm rounded-5 p-5 mb-5" style="background:#1a202c; color:#fff;">
                    <form action="#" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label x-small fw-900 text-white opacity-50 uppercase mb-2">FROM CITY</label>
                            <div class="input-group bg-white bg-opacity-10 rounded-pill p-1 border border-white border-opacity-10">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-plane-departure text-primary"></i></span>
                                <input type="text" class="form-control bg-transparent border-0 text-white fw-bold small" value="Delhi (DEL)">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label x-small fw-900 text-white opacity-50 uppercase mb-2">TO CITY</label>
                            <div class="input-group bg-white bg-opacity-10 rounded-pill p-1 border border-white border-opacity-10">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-plane-arrival text-success"></i></span>
                                <input type="text" class="form-control bg-transparent border-0 text-white fw-bold small" value="Dubai (DXB)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label x-small fw-900 text-white opacity-50 uppercase mb-2">Inventory Source</label>
                            <select class="form-select bg-white bg-opacity-10 border-white border-opacity-10 rounded-pill p-2 text-white small fw-bold">
                                <option>GLOBAL PARTNER NETWORK</option>
                                <option>Dxb Skyline (Connected)</option>
                                <option>London Express (Connected)</option>
                                <option>Own Inventory (Amadeus GDS)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100 rounded-pill py-3 fw-900 shadow-lg px-4">FETCH FARES</button>
                        </div>
                    </form>
                </div>

                <!-- B2B Results List -->
                @php
                $flights = [
                    ['airline' => 'Emirates', 'code' => 'EK-511', 'time' => '10:30 AM', 'duration' => '3h 40m', 'inventory' => 'Dxb Skyline', 'fare' => '₹18,500pp', 'split' => '₹500 Comm'],
                    ['airline' => 'Indigo', 'code' => '6E-481', 'time' => '02:15 PM', 'duration' => '3h 55m', 'inventory' => 'Own Inventory', 'fare' => '₹14,200pp', 'split' => 'Net Fare'],
                    ['airline' => 'Air India', 'code' => 'AI-912', 'time' => '08:45 PM', 'duration' => '4h 10m', 'inventory' => 'Global Network', 'fare' => '₹16,800pp', 'split' => '₹300 Comm'],
                ];
                @endphp
                @foreach($flights as $f)
                <div class="flight-row p-4 mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light text-dark rounded-3 d-flex align-items-center justify-content-center fw-900 shadow-sm" style="width: 40px; height: 40px;">E</div>
                                <div>
                                    <h6 class="fw-900 text-dark mb-0">{{ $f['airline'] }}</h6>
                                    <div class="x-small fw-bold text-muted">{{ $f['code'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="small fw-900 text-dark">{{ $f['time'] }}</div>
                            <div class="x-small fw-bold text-muted uppercase">{{ $f['duration'] }}</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="inventory-badge fw-900 uppercase">INVENTORY: <span class="text-primary">{{ $f['inventory'] }}</span></div>
                        </div>
                        <div class="col-md-2 text-center border-start border-light border-2">
                            <div class="small fw-900 text-navy">{{ $f['fare'] }}</div>
                            <div class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-bold">{{ $f['split'] }}</div>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-navy text-white rounded-pill small fw-900 py-3 shadow-lg w-100" style="background:#1a202c;" onclick="this.innerHTML='<i class=\'fas fa-ticket me-1\'></i> ISSUING...'; this.classList.add('disabled');">ISSUE TICKET</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

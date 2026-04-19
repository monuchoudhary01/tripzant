@extends('layouts.app')

@section('title', "Investor Booking Earnings | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .earning-card {
        background: #fff; border-radius: 20px; padding: 25px; border: 1px solid #f1f5f9; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 95vh;">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <a href="{{ route('investor.dashboard') }}" class="text-decoration-none small fw-bold text-muted uppercase"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
                <h2 class="fw-900 text-navy mt-2">Booking Commissions & Earnings</h2>
            </div>
            <div class="text-end">
                <div class="small fw-bold text-muted mb-1 uppercase">Total Passive Commissions</div>
                <div class="badge bg-success text-white px-4 py-2 rounded-pill fw-900 fs-5 shadow-sm">₹42,840.00</div>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="earning-card">
                    <div class="d-flex justify-content-between mb-3 text-muted x-small fw-900 uppercase">Bookings Funded</div>
                    <div class="h3 fw-900 text-navy">128 Bookings</div>
                    <p class="x-small fw-bold text-success mt-2 mb-0"><i class="fas fa-check-circle me-1"></i> 100% SUCCESS RATIO</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="earning-card border-left-info" style="border-left: 4px solid #1eccd1;">
                    <div class="d-flex justify-content-between mb-3 text-muted x-small fw-900 uppercase">Average Commission</div>
                    <div class="h3 fw-900 text-navy">₹334.68 / Booking</div>
                    <p class="x-small fw-bold text-muted mt-2 mb-0">BASED ON PASSENGER QUANTITY</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="earning-card border-left-warning" style="border-left: 4px solid #f97316;">
                    <div class="d-flex justify-content-between mb-3 text-muted x-small fw-900 uppercase">Next Expected Credit</div>
                    <div class="h3 fw-900 text-navy">₹1,200.00</div>
                    <p class="x-small fw-bold text-warning mt-2 mb-0"><i class="fas fa-clock me-1"></i> FROM PENDING GROUP BOOKINGS</p>
                </div>
            </div>
        </div>

        <!-- Commission Breakdown -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-900 text-navy mb-0">Earnings Per Passenger Coordination (₹100/Ticket)</h6>
                <button class="btn btn-navy rounded-pill small fw-900 px-4 py-2 shadow-sm" style="background:#0f172a; color:#fff;">EXPORT EARNINGS REPORT</button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 x-small fw-900 py-3 text-navy">BOOKING ID</th>
                            <th class="border-0 x-small fw-900 py-3 text-navy">ROUTE & AIRLINE</th>
                            <th class="border-0 x-small fw-900 py-3 text-navy">QUANTITY (PAX)</th>
                            <th class="border-0 x-small fw-900 py-3 text-navy">COMMISSION</th>
                            <th class="border-0 x-small fw-900 py-3 text-navy">SETTLEMENT DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $earnings = [
                            ['id' => 'TS-FL-1302', 'route' => 'BLR → JFK', 'airline' => 'Air India', 'pax' => '2 Passengers', 'comm' => '₹200.00'],
                            ['id' => 'TS-FL-1290', 'route' => 'BOM → HND', 'airline' => 'Japan Airlines', 'pax' => '4 Passengers', 'comm' => '₹400.00'],
                            ['id' => 'TS-FL-1284', 'route' => 'DEL → DXB', 'airline' => 'Emirates', 'pax' => '1 Passenger', 'comm' => '₹100.00'],
                            ['id' => 'TS-FL-1150', 'route' => 'PNQ → LHR', 'airline' => 'British Airways', 'pax' => '12 Passengers', 'comm' => '₹1,200.00'],
                        ];
                        @endphp
                        @foreach($earnings as $e)
                        <tr>
                            <td class="small fw-900 text-navy">{{ $e['id'] }}</td>
                            <td>
                                <div class="small fw-900 text-navy">{{ $e['route'] }}</div>
                                <div class="x-small text-muted fw-bold">{{ $e['airline'] }}</div>
                            </td>
                            <td><span class="badge bg-navy rounded-pill fw-bold">{{ $e['pax'] }}</span></td>
                            <td><h6 class="fw-900 text-success mb-0">+{{ $e['comm'] }}</h6></td>
                            <td class="small fw-bold">Instant Credit</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

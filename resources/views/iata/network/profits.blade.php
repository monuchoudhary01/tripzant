@extends('layouts.iata_panel')

@section('title', 'Profit Sharing Dashboard | IATA Collaboration')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-800 text-navy mb-0 outfit">Collaboration & Partner Profits</h4>
            <p class="text-muted small fw-700 uppercase mb-0">Tracking earnings from tickets issued via collaborative partner network.</p>
        </div>
        <div class="d-flex gap-3">
             <button class="btn btn-light border fw-800"><i class="fas fa-calendar-alt me-2"></i> This Month</button>
             <button class="btn btn-light border fw-800"><i class="fas fa-download me-2"></i> Report</button>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100">
                <div class="text-muted small fw-800 uppercase mb-1">Total Share Earned</div>
                <div class="h3 fw-900 text-success outfit mb-0">₹1,84,500</div>
                <div class="mt-2 text-muted x-small fw-700">From 142 shared bookings</div>
             </div>
        </div>
        <div class="col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100">
                <div class="text-muted small fw-800 uppercase mb-1">Commission Disbursed</div>
                <div class="h3 fw-900 text-navy outfit mb-0">₹62,400</div>
                <div class="mt-2 text-muted x-small fw-700">Paid to partner agents</div>
             </div>
        </div>
        <div class="col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100">
                <div class="text-muted small fw-800 uppercase mb-1">Pending Settlements</div>
                <div class="h3 fw-900 text-warning outfit mb-0">₹12,800</div>
                <div class="mt-2 text-warning x-small fw-800 uppercase tracking-wider">Settlement in 48h</div>
             </div>
        </div>
        <div class="col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 bg-navy text-white p-4 border border-light h-100">
                <div class="text-white-50 small fw-800 uppercase mb-1">System Efficiency</div>
                <div class="h3 fw-900 outfit mb-0">98.2%</div>
                <div class="mt-2 text-white-50 x-small fw-700">Booking success rate</div>
             </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white border border-light mb-5">
        <div class="p-4 border-bottom border-light">
            <h6 class="fw-800 text-navy mb-0 outfit uppercase">Recent Profit Split Entries</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0">
                <thead>
                    <tr>
                        <th>Transaction</th>
                        <th>Booked By</th>
                        <th>Total Profit</th>
                        <th>Your Share (60%)</th>
                        <th>Partner Share (40%)</th>
                        <th>Status</th>
                        <th class="text-end">Wallet Entry</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $splits = [
                        ['id' => 'SPL-88220', 'by' => 'Swift Wings India', 'profit' => '₹1,500', 'me' => '₹900', 'partner' => '₹600', 'status' => 'Distributed'],
                        ['id' => 'SPL-88219', 'by' => 'Royal Emirates', 'profit' => '₹2,200', 'me' => '₹1,320', 'partner' => '₹880', 'status' => 'Distributed'],
                        ['id' => 'SPL-88218', 'by' => 'Swift Wings India', 'profit' => '₹850', 'me' => '₹510', 'partner' => '₹340', 'status' => 'Pending'],
                        ['id' => 'SPL-88217', 'by' => 'Singapore Flyers', 'profit' => '₹4,000', 'me' => '₹2,400', 'partner' => '₹1,600', 'status' => 'Distributed'],
                    ];
                    @endphp
                    @foreach($splits as $s)
                    <tr>
                        <td class="fw-800 font-monospace text-navy">{{ $s['id'] }}</td>
                        <td class="fw-700">{{ $s['by'] }}</td>
                        <td class="fw-800">{{ $s['profit'] }}</td>
                        <td class="fw-900 text-success">{{ $s['me'] }}</td>
                        <td class="fw-800 text-primary">{{ $s['partner'] }}</td>
                        <td>
                            <span class="badge-status {{ $s['status'] == 'Distributed' ? 'badge-success' : 'badge-warning' }}">
                                {{ $s['status'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-light btn-sm fw-800 border-0 rounded-pill px-3"><i class="fas fa-file-invoice me-1"></i> Ledger</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-navy { background-color: var(--iata-navy); }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

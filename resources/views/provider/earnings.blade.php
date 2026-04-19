@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-6">
            <h4 class="fw-800">Earnings & Payouts</h4>
            <p class="text-muted small">Monitor your revenue and track your upcoming payouts.</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary px-4 py-2 rounded-pill fw-800 shadow-sm">
                <i class="fas fa-download me-2"></i> Download Report
            </button>
        </div>
    </div>

    <!-- Stats summary -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
             <div class="card border-0 p-4 bg-primary text-white h-100 shadow-lg">
                <h6 class="fw-700 small opacity-75 uppercase mb-2">AVAILABLE FOR PAYOUT</h6>
                <h2 class="fw-900 mb-4">₹12,450.00</h2>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="smaller fw-700 text-white-50 uppercase">NEXT SETTLEMENT: 15 APR</span>
                    <button class="btn btn-light btn-sm px-4 rounded-pill fw-800" style="color:var(--primary);">Withdraw Now</button>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 p-4 h-100">
                        <h6 class="text-muted fw-700 small uppercase mb-3">TOTAL REVENUE (LIFETIME)</h6>
                        <h3 class="fw-900 mb-2">₹1,85,200</h3>
                        <p class="text-muted small mb-0 fw-600">Across 142 completed bookings</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 p-4 h-100">
                         <h6 class="text-muted fw-700 small uppercase mb-3">PENDING CLEARANCE</h6>
                        <h3 class="fw-900 mb-2 text-warning">₹2,800</h3>
                        <p class="text-muted small mb-0 fw-600">Locked in 2 active bookings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="card border-0 p-4 rounded-4 shadow-sm">
        <h5 class="fw-800 mb-4">Transactions History</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="text-muted small">
                    <tr>
                        <th class="border-0">DATE</th>
                        <th class="border-0">DESCRIPTION</th>
                        <th class="border-0">PAYMENT METHOD</th>
                        <th class="border-0">AMOUNT</th>
                        <th class="border-0">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $txns = [
                            ['date' => '05 Apr 2026', 'desc' => 'Service Fee: Airport Pickup (BK-9921)', 'method' => 'Bank Transfer', 'amount' => '+ ₹1,200', 'status' => 'Settled'],
                            ['date' => '03 Apr 2026', 'desc' => 'Service Fee: Old Delhi Walk (BK-9918)', 'method' => 'Wallet Payout', 'amount' => '+ ₹3,500', 'status' => 'Settled'],
                            ['date' => '01 Apr 2026', 'desc' => 'Withdrawal Request', 'method' => 'UPI (rahul@okaxis)', 'amount' => '- ₹5,000', 'status' => 'Processing'],
                            ['date' => '28 Mar 2026', 'desc' => 'Service Fee: Hotel Transfer', 'method' => 'Bank Transfer', 'amount' => '+ ₹2,800', 'status' => 'Settled'],
                        ];
                    @endphp
                    @foreach($txns as $t)
                    <tr>
                        <td class="small fw-700 text-muted">{{ $t['date'] }}</td>
                        <td class="small fw-800">{{ $t['desc'] }}</td>
                        <td class="small text-muted fw-600">{{ $t['method'] }}</td>
                        <td class="small fw-900 {{ str_contains($t['amount'], '+') ? 'text-success' : 'text-danger' }}">{{ $t['amount'] }}</td>
                        <td>
                            <span class="badge {{ $t['status'] == 'Settled' ? 'bg-success' : 'bg-warning' }} bg-opacity-10 {{ $t['status'] == 'Settled' ? 'text-success' : 'text-warning' }} rounded-pill px-3 py-1 smaller fw-800 uppercase">
                                {{ $t['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .smaller { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .rounded-4 { border-radius: 12px !important; }
</style>
@endsection

@extends('layouts.accounting')

@section('acc_content')
<div class="row g-4">
    <!-- Summary Header -->
    <div class="col-12">
        <div class="glass-card d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-black mb-1">Financial Analysis</h2>
                <p class="text-muted mb-0">Performance breakdown by service category</p>
            </div>
            <div class="text-end">
                <span class="text-muted small">Net Operating Profit</span>
                <h1 class="fw-black text-accent m-0">₹{{ number_format($flightProfit + $hotelProfit - $expenseAccounts->whereNotIn('code', ['5001', '5002'])->sum('balance'), 2) }}</h1>
            </div>
        </div>
    </div>

    <!-- Profit breakdown by category -->
    <div class="col-md-6">
        <div class="glass-card h-100 border-start border-primary border-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0"><i class="fas fa-plane-departure text-accent me-2"></i> Flight Bookings</h4>
                <span class="badge bg-accent bg-opacity-25 text-accent px-3 py-2 rounded-pill">Total Margin: ₹{{ number_format($flightProfit, 2) }}</span>
            </div>
            
            <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10 mb-2">
                <span class="text-muted">Total Revenue Collected</span>
                <span class="fw-bold">₹{{ number_format($flightRev, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10 mb-2">
                <span class="text-muted">GDS / Supplier Cost (Net)</span>
                <span class="text-danger">₹{{ number_format($flightCost, 2) }}</span>
            </div>
            <div class="mt-4 pt-3 bg-white bg-opacity-5 rounded-4 p-3 border border-white border-opacity-10">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold small">Direct Flight Profit</span>
                    <h4 class="m-0 fw-black text-success">₹{{ number_format($flightProfit, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="glass-card h-100 border-start border-info border-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0"><i class="fas fa-hotel text-info me-2"></i> Hotel Bookings</h4>
                <span class="badge bg-info bg-opacity-25 text-info px-3 py-2 rounded-pill">Total Margin: ₹{{ number_format($hotelProfit, 2) }}</span>
            </div>
            
            <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10 mb-2">
                <span class="text-muted">Total Revenue Collected</span>
                <span class="fw-bold">₹{{ number_format($hotelRev, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10 mb-2">
                <span class="text-muted">HotelBeds / Supplier Cost</span>
                <span class="text-danger">₹{{ number_format($hotelCost, 2) }}</span>
            </div>
            <div class="mt-4 pt-3 bg-white bg-opacity-5 rounded-4 p-3 border border-white border-opacity-10">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold small">Direct Hotel Profit</span>
                    <h4 class="m-0 fw-black text-success">₹{{ number_format($hotelProfit, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Operating Expenses Table -->
    <div class="col-md-8">
        <div class="glass-card">
            <h4 class="fw-bold mb-4">Operational Overhead</h4>
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>Account Name</th>
                        <th class="text-end">Current Balance</th>
                        <th class="text-end">MTD Change</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenseAccounts->whereNotIn('code', ['5001', '5002']) as $acc)
                    <tr>
                        <td>{{ $acc->name }}</td>
                        <td class="text-end fw-bold">₹{{ number_format($acc->balance, 2) }}</td>
                        <td class="text-end text-danger"><i class="fas fa-arrow-up small"></i> {{ rand(2, 8) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class="glass-card bg-accent bg-opacity-10 border border-accent border-opacity-25 h-100 text-center d-flex flex-column justify-content-center">
            <span class="text-accent small fw-bold text-uppercase d-block mb-2">Total Service Efficiency</span>
            <h1 class="fw-black mb-2" style="font-size: 3.5rem;">
                @php
                    $totalRev = $flightRev + $hotelRev;
                    $totalProfit = $flightProfit + $hotelProfit;
                    $margin = $totalRev > 0 ? ($totalProfit / $totalRev) * 100 : 0;
                @endphp
                {{ number_format($margin, 1) }}%
            </h1>
            <p class="text-muted small">Profitability per booking rupee</p>
            <div class="mt-4">
                <button class="btn btn-acc-primary w-100">Monthly Deep-Dive</button>
            </div>
        </div>
    </div>
</div>

<style>
.fw-black { font-weight: 800; }
.text-accent { color: #3b82f6; }
</style>
@endsection

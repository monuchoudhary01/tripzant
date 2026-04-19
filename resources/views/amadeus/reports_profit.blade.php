@extends('layouts.b2b_master')

@section('title', 'Profit Report | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Profit & Earnings Report</h4>
        <p class="text-muted small mb-0">Track your markups, commissions and net profit across all bookings.</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select btn btn-light btn-sm px-4 fw-700 bg-white border border-secondary border-opacity-10 shadow-none">
            <option>Last 30 Days</option>
            <option>This Quarter</option>
            <option>Entire Year</option>
            <option>Custom Range</option>
        </select>
        <button class="btn btn-primary btn-sm px-4 fw-700"><i class="fas fa-file-excel me-2"></i> EXCEL</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="b2b-table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted small fw-700 uppercase">Gross Booking Revenue</span>
                <span class="text-success"><i class="fas fa-chart-line"></i></span>
            </div>
            <h3 class="mb-0 outfit">₹1.42 Cr</h3>
            <p class="text-muted small mt-2 mb-0">Revenue from 1,280 ticketed bookings.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="b2b-table-card p-4">
             <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted small fw-700 uppercase">Total Net Profit</span>
                <span class="text-primary"><i class="fas fa-wallet"></i></span>
            </div>
            <h3 class="mb-0 outfit">₹3.85 L</h3>
            <p class="text-muted small mt-2 mb-0">Total commission + markups earned.</p>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0">Booking-wise Profit Details</h5>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Booking Date</th>
                    <th>Sub-Agent</th>
                    <th>Total Fare</th>
                    <th>Net Fare</th>
                    <th>Commission</th>
                    <th>Markup</th>
                    <th>Net Profit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700 text-primary">XY78WQ</td>
                    <td>10 Apr 2024</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td class="fw-700">₹45,280</td>
                    <td>₹43,800</td>
                    <td class="text-success">₹1,250</td>
                    <td class="text-success">₹230</td>
                    <td class="text-success fw-700">₹1,480</td>
                </tr>
                <tr>
                    <td class="fw-700 text-primary">KL1122</td>
                    <td>08 Apr 2024</td>
                    <td class="fw-600">Global Holiday</td>
                    <td class="fw-700">₹12,450</td>
                    <td>₹11,900</td>
                    <td class="text-success">₹420</td>
                    <td class="text-success">₹130</td>
                    <td class="text-success fw-700">₹550</td>
                </tr>
                <tr>
                    <td class="fw-700 text-primary">PR4021</td>
                    <td>05 Apr 2024</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td class="fw-700">₹22,100</td>
                    <td>₹21,150</td>
                    <td class="text-success">₹780</td>
                    <td class="text-success">₹170</td>
                    <td class="text-success fw-700">₹950</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

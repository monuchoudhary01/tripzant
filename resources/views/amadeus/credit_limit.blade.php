@extends('layouts.b2b_master')

@section('title', 'Credit Limit Management | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Credit Limit Management</h4>
        <p class="text-muted small mb-0">Monitor and manage your credit limit usage and settlement cycle.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Credit Limit</li>
        </ol>
    </nav>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-stat p-4 border-0 shadow-sm text-center">
            <div class="text-muted small fw-700 uppercase mb-2">Total Approved Limit</div>
            <h2 class="outfit fw-800 text-primary">₹5,00,000</h2>
            <div class="mt-2 text-muted fw-700" style="font-size: 11px;">Cycle Type: 7 Days</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat p-4 border-0 shadow-sm text-center">
            <div class="text-muted small fw-700 uppercase mb-2">Used Credit Amount</div>
            <h2 class="outfit fw-800 text-danger">₹3,20,000</h2>
             <div class="mt-2 text-danger fw-700" style="font-size: 11px;">Next Due: 15 Apr 2024</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat p-4 border-0 shadow-sm text-center">
            <div class="text-muted small fw-700 uppercase mb-2">Remaining Credit</div>
            <h2 class="outfit fw-800 text-success">₹1,80,000</h2>
             <div class="mt-2 text-success fw-700" style="font-size: 11px;">Current Ticketing Capacity</div>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Credit Settlements</h5>
        <button class="btn btn-outline-primary btn-sm px-4 fw-700 bg-white">PAY SETTLEMENT</button>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Settlement Date</th>
                    <th>Amount Paid</th>
                    <th>Remaining Dues</th>
                    <th>Payment Mode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700">CS-9901</td>
                    <td>07 Apr 2024</td>
                    <td class="fw-700 text-success">₹1,50,000</td>
                    <td>₹3,20,000</td>
                    <td>IMPS Transfer</td>
                    <td><span class="b2b-badge badge-success">COMPLETED</span></td>
                </tr>
                <tr>
                    <td class="fw-700">CS-9844</td>
                    <td>01 Apr 2024</td>
                    <td class="fw-700 text-success">₹2,00,000</td>
                    <td>₹4,70,000</td>
                    <td>NEFT Transfer</td>
                    <td><span class="b2b-badge badge-success">COMPLETED</span></td>
                </tr>
                 <tr>
                    <td class="fw-700">CS-9721</td>
                    <td>25 Mar 2024</td>
                    <td class="fw-700 text-success">₹3,00,000</td>
                    <td>₹6,70,000</td>
                    <td>UPI</td>
                    <td><span class="b2b-badge badge-success">COMPLETED</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

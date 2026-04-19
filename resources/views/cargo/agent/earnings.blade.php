@extends('layouts.user_dashboard')

@section('title', 'My Earnings')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="h1 fw-bold text-success mb-1">${{ number_format($earnings['total'], 2) }}</div>
            <div class="text-muted small text-uppercase fw-bold">Life-time Earnings</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center" style="background: rgba(11, 61, 97, 0.03);">
            <div class="h1 fw-bold text-primary mb-1">${{ number_format($earnings['this_month'], 2) }}</div>
            <div class="text-muted small text-uppercase fw-bold">This Month</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="h1 fw-bold text-warning mb-1">${{ number_format($earnings['pending'], 2) }}</div>
            <div class="text-muted small text-uppercase fw-bold">Pending Clearance</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0 fw-bold">Commission History</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light small text-muted">
                <tr>
                    <th class="ps-4">Date</th>
                    <th>Reference</th>
                    <th>Job Type</th>
                    <th>Commission</th>
                    <th class="text-end pe-4">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ps-4">12 Apr, 2026</td>
                    <td class="fw-bold">TZC-48521</td>
                    <td>Delivery Pickup</td>
                    <td class="text-success fw-bold">+$15.50</td>
                    <td class="text-end pe-4"><span class="badge bg-soft-success text-success rounded-pill px-3">Paid</span></td>
                </tr>
                <tr>
                    <td class="ps-4">11 Apr, 2026</td>
                    <td class="fw-bold">TZC-48510</td>
                    <td>Delivery Pickup</td>
                    <td class="text-success fw-bold">+$12.00</td>
                    <td class="text-end pe-4"><span class="badge bg-soft-success text-success rounded-pill px-3">Paid</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

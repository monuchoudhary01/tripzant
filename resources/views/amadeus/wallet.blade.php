@extends('layouts.b2b_master')

@section('title', 'Wallet & Credit | Amadeus Partner Panel')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #0052cc 0%, #0747a6 100%); border-radius: 16px; color: #fff;">
            <div class="p-4">
                <span class="fw-700 uppercase" style="letter-spacing: 1px; font-size: 11px; opacity: 0.8;">CURRENT WALLET BALANCE</span>
                <h1 class="outfit mb-2">₹14,52,800.00</h1>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-white w-100 fw-700" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff;">TOP UP</button>
                    <button class="btn btn-white w-100 fw-700" style="background: #fff; color: #0052cc;">WITHDRAW</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header">
        <h5 class="mb-0">Recent Transactions</h5>
    </div>
    <div class="table-responsive">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>07 Apr 2024</td>
                    <td class="fw-700 text-primary">TX-99201</td>
                    <td><span class="b2b-badge badge-danger">Debit</span></td>
                    <td class="fw-800 text-danger">- ₹14,250</td>
                    <td><span class="b2b-badge badge-success">Completed</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.b2b_master')

@section('title', 'Agent Management | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 outfit">Sub-Agent Network</h4>
    <button class="btn btn-b2b-primary btn-sm px-3">ADD NEW AGENT</button>
</div>

<div class="b2b-table-card">
    <div class="table-responsive">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Agency Details</th>
                    <th>Location</th>
                    <th>Credit / Wallet</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-700">Travel Sphere Pvt Ltd</div>
                        <div class="text-muted small">ID: AG-442 | <span class="text-primary fw-600">Gold</span></div>
                    </td>
                    <td>New Delhi, IN</td>
                    <td>
                        <div class="small fw-600">W: ₹12,450</div>
                    </td>
                    <td><span class="b2b-badge badge-success">Active</span></td>
                    <td><button class="btn btn-light btn-sm"><i class="fas fa-edit"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

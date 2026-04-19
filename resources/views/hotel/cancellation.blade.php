@extends('layouts.hotel_master')

@section('title', 'Cancellation & Refund | B2B Travel Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Cancellation & Refund Management</h4>
        <p class="text-muted small mb-0">Initiate cancellations and track refund status for your hotel bookings.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="b2b-table-card p-4">
            <h6 class="fw-800 mb-4 border-bottom pb-2">Request Cancellation</h6>
            <div class="mb-3">
                <label class="form-label-b2b">Enter Booking ID (BID)</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-b2b" placeholder="e.g. AMH-892412">
                    <button class="btn btn-primary px-3 fw-700" style="background:#0052cc">FIND</button>
                </div>
            </div>
            <p class="tiny text-muted fw-600"><i class="fas fa-info-circle me-1"></i> Refund will be calculated based on the hotel's cancellation policy at the time of request.</p>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="b2b-table-card">
            <div class="card-header">
                <h6 class="mb-0">Recent Refund History</h6>
            </div>
            <div class="table-responsive">
                <table class="table b2b-table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>BID / Date</th>
                            <th>Guest</th>
                            <th>Refund Amount</th>
                            <th>Ref. ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-700">AMH-892410</div>
                                <div class="tiny text-muted">01 Apr 2026</div>
                            </td>
                            <td>Amit Sharma</td>
                            <td class="fw-800">₹12,400</td>
                            <td class="small">RF-102941</td>
                            <td><span class="b2b-badge badge-success">Processed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-700">AMH-892398</div>
                                <div class="tiny text-muted">28 Mar 2026</div>
                            </td>
                            <td>Neha Gupta</td>
                            <td class="fw-800">₹8,500</td>
                            <td class="small">RF-102942</td>
                            <td><span class="b2b-badge badge-warning">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

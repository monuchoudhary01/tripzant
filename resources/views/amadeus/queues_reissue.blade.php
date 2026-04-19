@extends('layouts.b2b_master')

@section('title', 'Reissue & Reschedule Queue | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Reissue & Reschedule Queue</h4>
        <p class="text-muted small mb-0">Track ticket modification requests and fare differences from sub-agents.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Reissue & Reschedule</li>
        </ol>
    </nav>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0">Modification Requests (2)</h5>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Sub-Agent</th>
                    <th>Old PNR</th>
                    <th>New PNR/Seg</th>
                    <th>Fare Diff.</th>
                    <th>Fees</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700">RI-4401</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td class="fw-700 text-primary">XY78WQ</td>
                    <td class="fw-600">XY78WQ (1 Seg)</td>
                    <td class="text-success fw-700">+ ₹2,450</td>
                    <td class="fw-700">₹500</td>
                    <td><span class="b2b-badge badge-warning">QUOTED</span></td>
                    <td><button class="btn btn-b2b-primary btn-sm px-3">RESOLVE</button></td>
                </tr>
                <tr>
                    <td class="fw-700">RI-4392</td>
                    <td class="fw-600">Global Holidays</td>
                    <td class="fw-700 text-primary">KL1122</td>
                    <td class="fw-600">New PNR: MN551</td>
                    <td class="text-success fw-700">+ ₹5,100</td>
                    <td class="fw-700">₹1,200</td>
                    <td><span class="b2b-badge badge-info">PENDING REVIEW</span></td>
                    <td><button class="btn btn-outline-secondary btn-sm px-3">DETAILS</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

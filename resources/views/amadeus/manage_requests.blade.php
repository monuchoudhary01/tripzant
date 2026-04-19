@extends('layouts.b2b_master')

@section('title', 'Manage Group Requests | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Manage Group Requests</h4>
        <p class="text-muted small mb-0">Track and respond to submitted group booking quotes.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Requests</li>
        </ol>
    </nav>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <div class="d-flex gap-3">
            <button class="btn btn-outline-primary btn-sm px-4">ALL REQUESTS</button>
            <button class="btn btn-light btn-sm px-4 text-muted">PENDING (2)</button>
            <button class="btn btn-light btn-sm px-4 text-muted">QUOTED (5)</button>
            <button class="btn btn-light btn-sm px-4 text-muted">CONFIRMED (1)</button>
        </div>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Origin - Destination</th>
                    <th>Date</th>
                    <th>Pax Count</th>
                    <th>Preferred Airline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700">GR-99201</td>
                    <td class="fw-600">DEL <i class="fas fa-arrow-right mx-1 small text-muted"></i> DXB</td>
                    <td>10 May 2024</td>
                    <td>25 Adults</td>
                    <td>Emirates / Indigo</td>
                    <td><span class="b2b-badge badge-info">PENDING</span></td>
                    <td><button class="btn btn-light btn-sm"><i class="fas fa-eye me-1"></i> VIEW</button></td>
                </tr>
                <tr>
                    <td class="fw-700">GR-98104</td>
                    <td class="fw-600">BOM <i class="fas fa-arrow-right mx-1 small text-muted"></i> SIN</td>
                    <td>15 Jun 2024</td>
                    <td>18 Adults</td>
                    <td>Singapore Airlines</td>
                    <td><span class="b2b-badge badge-warning">QUOTED</span></td>
                    <td><button class="btn btn-light btn-sm"><i class="fas fa-eye me-1"></i> VIEW QUOTE</button></td>
                </tr>
                 <tr>
                    <td class="fw-700">GR-97210</td>
                    <td class="fw-600">DEL <i class="fas fa-arrow-right mx-1 small text-muted"></i> LHR</td>
                    <td>20 Jul 2024</td>
                    <td>40 Adults</td>
                    <td>Virgin Atlantic</td>
                    <td><span class="b2b-badge badge-success">CONFIRMED</span></td>
                    <td><button class="btn btn-light btn-sm"><i class="fas fa-eye me-1"></i> VIEW DETAILS</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

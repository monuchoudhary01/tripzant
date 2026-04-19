@extends('layouts.b2b_master')

@section('title', 'Pending Tickets Queue | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Pending Tickets Queue</h4>
        <p class="text-muted small mb-0">Control and manage bookings waiting for ticket issuance (TP - Ticket Pending).</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pending Tickets</li>
        </ol>
    </nav>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0">Queue Items (5)</h5>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>PNR</th>
                    <th>Sub-Agent</th>
                    <th>Route</th>
                    <th>Time Remaining</th>
                    <th>Total Fare</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700 text-primary">KL9921</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td class="fw-600">DEL <i class="fas fa-arrow-right mx-1 small text-muted"></i> CDG</td>
                    <td class="text-danger fw-700"><i class="far fa-clock me-1"></i> 02:45:10</td>
                    <td class="fw-700">₹45,280</td>
                    <td><span class="b2b-badge badge-warning">TP-RESERVED</span></td>
                    <td>
                        <button class="btn btn-b2b-primary btn-sm px-3">ISSUE</button>
                        <button class="btn btn-light btn-sm px-3">HOLD</button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-700 text-primary">AB4420</td>
                    <td class="fw-600">Global Holidays</td>
                    <td class="fw-600">BOM <i class="fas fa-arrow-right mx-1 small text-muted"></i> SIN</td>
                    <td class="text-muted fw-700"><i class="far fa-clock me-1"></i> 12:30:15</td>
                    <td class="fw-700">₹32,100</td>
                    <td><span class="b2b-badge badge-warning">TP-REVIEW</span></td>
                    <td>
                        <button class="btn btn-b2b-primary btn-sm px-3">ISSUE</button>
                        <button class="btn btn-light btn-sm px-3">CANCEL</button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-700 text-primary">XY1029</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td class="fw-600">DEL <i class="fas fa-arrow-right mx-1 small text-muted"></i> DXB</td>
                    <td class="text-danger fw-700"><i class="far fa-clock me-1"></i> 00:15:45</td>
                    <td class="fw-700">₹12,450</td>
                    <td><span class="b2b-badge badge-danger">EXPIRES SOON</span></td>
                    <td>
                        <button class="btn btn-b2b-primary btn-sm px-3">ISSUE</button>
                        <button class="btn btn-light btn-sm px-3">REFRESH</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

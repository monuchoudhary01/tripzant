@extends('layouts.b2b_master')

@section('title', 'Cancellations Queue | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Cancellations Queue</h4>
        <p class="text-muted small mb-0">Manage and process ticket cancellation and refund requests from sub-agents.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Cancellations</li>
        </ol>
    </nav>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0">Requests (3)</h5>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>PNR</th>
                    <th>Sub-Agent</th>
                    <th>Airline</th>
                    <th>Ticket Fare</th>
                    <th>Refund Est.</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700">CN-9012</td>
                    <td class="fw-700 text-primary">XY78WQ</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td>Emirates</td>
                    <td>₹45,280</td>
                    <td class="text-success fw-700">₹38,000</td>
                    <td><span class="b2b-badge badge-warning">PENDING</span></td>
                    <td><button class="btn btn-b2b-primary btn-sm px-3">PROCESS</button></td>
                </tr>
                <tr>
                    <td class="fw-700">CN-8944</td>
                    <td class="fw-700 text-primary">KL1122</td>
                    <td class="fw-600">Global Holiday</td>
                    <td>Indigo</td>
                    <td>₹12,450</td>
                    <td class="text-success fw-700">₹8,500</td>
                    <td><span class="b2b-badge badge-info">VERIFYING</span></td>
                    <td><button class="btn btn-outline-secondary btn-sm px-3">DETAILS</button></td>
                </tr>
                 <tr>
                    <td class="fw-700">CN-8812</td>
                    <td class="fw-700 text-primary">PR4021</td>
                    <td class="fw-600">Travel Sphere</td>
                    <td>Vistara</td>
                    <td>₹22,100</td>
                    <td class="text-danger fw-700">₹0</td>
                    <td><span class="b2b-badge badge-danger">REJECTED</span></td>
                    <td><button class="btn btn-light btn-sm px-3" disabled>CLOSED</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

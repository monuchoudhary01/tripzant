@extends('layouts.b2b_master')

@section('title', 'Manage Bookings | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 outfit">Booking Management Suite</h4>
    <div class="d-flex gap-2">
        <div class="btn-group">
            <button class="btn btn-outline-primary btn-sm active">All</button>
            <button class="btn btn-outline-primary btn-sm">Ticketed</button>
            <button class="btn btn-outline-primary btn-sm">Pending</button>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="table-responsive">
        <table class="table b2b-table mb-0">
            <thead>
                <tr>
                    <th>Booking Info</th>
                    <th>Sub-Agent</th>
                    <th>Passenger(s)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-700 text-primary">AM-XY78WQ</div>
                        <div class="text-muted" style="font-size: 11px;">07 Apr 2024, 10:45</div>
                    </td>
                    <td>
                        <div class="fw-700">Travel Sphere</div>
                    </td>
                    <td>
                        <div class="fw-600">Mr. John Doe</div>
                    </td>
                    <td><span class="b2b-badge badge-success">Ticketed</span></td>
                    <td><button class="btn btn-light btn-sm"><i class="fas fa-eye"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

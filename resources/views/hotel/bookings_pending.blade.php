@extends('layouts.hotel_master')

@section('title', 'Pending Bookings | B2B Travel Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Pending Hotel Bookings</h4>
        <p class="text-muted small mb-0">Management for bookings that are awaiting voucher generation or payment confirmation.</p>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <div class="d-flex gap-3">
             <a href="{{ route('hotel.management.all') }}" class="small fw-700 text-decoration-none text-muted pb-2">All Bookings</a>
             <a href="{{ route('hotel.management.confirmed') }}" class="small fw-700 text-decoration-none text-muted pb-2">Confirmed</a>
             <a href="{{ route('hotel.management.pending') }}" class="small fw-700 text-decoration-none border-bottom border-primary pb-2 text-primary">Pending</a>
             <a href="{{ route('hotel.management.cancelled') }}" class="small fw-700 text-decoration-none text-muted pb-2">Cancelled</a>
        </div>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th>BID / Date</th>
                    <th>Hotel / City</th>
                    <th>Booking Period</th>
                    <th>Guest Details</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-800">AMH-892413</div>
                        <div class="tiny text-muted">06 Apr 2026</div>
                    </td>
                    <td>
                        <div class="fw-700">Radisson Blu</div>
                        <div class="tiny text-muted">Dubai, UAE</div>
                    </td>
                    <td>
                        <div class="small fw-600">12 May - 15 May</div>
                        <div class="tiny text-muted">3 Nights, 2 Rooms</div>
                    </td>
                    <td>
                        <div class="small fw-700">Sarah Khan</div>
                        <div class="tiny text-muted">4 Adults, 2 Child</div>
                    </td>
                    <td class="fw-800">₹52,000</td>
                    <td><span class="b2b-badge badge-warning">Pending</span></td>
                    <td>
                        <button class="btn btn-light btn-sm px-2" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-light btn-sm px-2 text-primary" title="Refresh Status"><i class="fas fa-sync-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

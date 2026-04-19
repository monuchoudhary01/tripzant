@extends('layouts.hotel_master')

@section('title', 'Cancelled Bookings | B2B Travel Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Cancelled Hotel Bookings</h4>
        <p class="text-muted small mb-0">Review previously cancelled reservations and their refund status.</p>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <div class="d-flex gap-3">
             <a href="{{ route('hotel.management.all') }}" class="small fw-700 text-decoration-none text-muted pb-2">All Bookings</a>
             <a href="{{ route('hotel.management.confirmed') }}" class="small fw-700 text-decoration-none text-muted pb-2">Confirmed</a>
             <a href="{{ route('hotel.management.pending') }}" class="small fw-700 text-decoration-none text-muted pb-2">Pending</a>
             <a href="{{ route('hotel.management.cancelled') }}" class="small fw-700 text-decoration-none border-bottom border-primary pb-2 text-primary">Cancelled</a>
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
                        <div class="fw-800">AMH-892414</div>
                        <div class="tiny text-muted">05 Apr 2026</div>
                    </td>
                    <td>
                        <div class="fw-700">The Ritz-Carlton</div>
                        <div class="tiny text-muted">Singapore</div>
                    </td>
                    <td>
                        <div class="small fw-600">01 Jun - 05 Jun</div>
                        <div class="tiny text-muted">4 Nights, 1 Room</div>
                    </td>
                    <td>
                        <div class="small fw-700">David Miller</div>
                        <div class="tiny text-muted">2 Adults, 0 Child</div>
                    </td>
                    <td class="fw-800">₹1,12,000</td>
                    <td><span class="b2b-badge badge-danger">Cancelled</span></td>
                    <td>
                        <button class="btn btn-light btn-sm px-2" title="View History"><i class="fas fa-history"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

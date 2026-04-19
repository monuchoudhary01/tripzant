@extends('layouts.hotel_master')

@section('title', 'Confirmed Bookings | B2B Travel Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Confirmed Hotel Bookings</h4>
        <p class="text-muted small mb-0">Management for all confirmed reservations and issued hotel vouchers.</p>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <div class="d-flex gap-3">
             <a href="{{ route('hotel.management.all') }}" class="small fw-700 text-decoration-none text-muted pb-2">All Bookings</a>
             <a href="{{ route('hotel.management.confirmed') }}" class="small fw-700 text-decoration-none border-bottom border-primary pb-2 text-primary">Confirmed</a>
             <a href="{{ route('hotel.management.pending') }}" class="small fw-700 text-decoration-none text-muted pb-2">Pending</a>
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
                        <div class="fw-800">AMH-892412</div>
                        <div class="tiny text-muted">07 Apr 2026</div>
                    </td>
                    <td>
                        <div class="fw-700">Taj Mahal Palace</div>
                        <div class="tiny text-muted">Mumbai, India</div>
                    </td>
                    <td>
                        <div class="small fw-600">25 Apr - 28 Apr</div>
                        <div class="tiny text-muted">3 Nights, 1 Room</div>
                    </td>
                    <td>
                        <div class="small fw-700">John Doe</div>
                        <div class="tiny text-muted">2 Adults, 0 Child</div>
                    </td>
                    <td class="fw-800">₹85,350</td>
                    <td><span class="b2b-badge badge-success">Confirmed</span></td>
                    <td>
                        <button class="btn btn-light btn-sm px-2" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-light btn-sm px-2 text-primary" title="Download Voucher"><i class="fas fa-file-download"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

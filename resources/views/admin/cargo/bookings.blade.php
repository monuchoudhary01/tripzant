@extends('layouts.admin')

@section('title', 'All Cargo Bookings')

@section('admin_content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">All Cargo Bookings</h2>
            <p class="text-muted">Monitor and manage every international shipment in the ecosystem.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Ref / Date</th>
                        <th>User</th>
                        <th>Provider</th>
                        <th>Route</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold">{{ $booking->booking_ref }}</span><br>
                            <small class="text-muted">{{ $booking->created_at->format('d M, Y') }}</small>
                        </td>
                        <td>{{ $booking->user->name ?? 'Guest' }}</td>
                        <td>{{ $booking->provider->name }}</td>
                        <td>{{ $booking->origin_city }} <i class="fas fa-arrow-right mx-1 small text-muted"></i> {{ $booking->destination_city }}</td>
                        <td>
                            <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $booking->status }}</span>
                        </td>
                        <td><span class="fw-bold">${{ number_format($booking->total_price, 2) }}</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary rounded-pill btn-update-status" data-id="{{ $booking->id }}">Update Status</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection

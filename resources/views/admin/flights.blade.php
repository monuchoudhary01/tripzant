@extends('layouts.admin')

@section('title', 'Flight Booking History | TripZant Admin')

@section('admin_content')
<div class="container-fluid p-0">
    <!-- Breadcrumbs -->
    <div class="mb-3">
        <h4 class="fw-bold text-navy mb-1">Flight Booking History</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 smaller fw-bold">
                <li class="breadcrumb-item"><a href="/admin-dashboard" class="text-primary text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/flights" class="text-primary text-decoration-none">Flights Control</a></li>
                <li class="breadcrumb-item active text-muted">Flight Booking History</li>
            </ol>
        </nav>
    </div>

    <!-- Top Stats Row -->
    <div class="row g-3 mb-4 align-items-stretch">
        <div class="col">
            <div class="card card-sneat h-100 border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar bg-label-primary rounded p-2"><i class="bx bxs-plane-alt fs-3"></i></div>
                    <div>
                        <div class="text-muted smaller fw-bold">Total Bookings</div>
                        <h4 class="fw-bold mb-0">{{ number_format($stats['total'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-sneat h-100 border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar bg-label-success rounded p-2"><i class="bx bx-check-circle fs-3"></i></div>
                    <div>
                        <div class="text-muted smaller fw-bold">Confirmed</div>
                        <h4 class="fw-bold mb-0">{{ number_format($stats['confirmed'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-sneat h-100 border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar bg-label-warning rounded p-2"><i class="bx bx-time fs-3"></i></div>
                    <div>
                        <div class="text-muted smaller fw-bold">Pending</div>
                        <h4 class="fw-bold mb-0">{{ number_format($stats['pending'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-sneat h-100 border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar bg-label-danger rounded p-2"><i class="bx bx-x-circle fs-3"></i></div>
                    <div>
                        <div class="text-muted smaller fw-bold">Cancelled</div>
                        <h4 class="fw-bold mb-0">{{ number_format($stats['cancelled'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-sneat h-100 border-0 shadow-sm bg-label-primary">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar bg-white rounded p-2"><i class="bx bx-money fs-3 text-primary"></i></div>
                        <div>
                            <div class="text-primary smaller fw-bold">Total Revenue</div>
                            <h4 class="fw-bold mb-0 text-primary">₹ {{ number_format($stats['revenue'] ?? 0) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('admin.flights.export') }}" class="btn btn-success btn-xs px-2 py-1 smaller fw-bold text-white"><i class="bx bx-export me-1"></i> Export CSV</a>
                        <a href="{{ route('admin.flights.export') }}" class="btn btn-primary btn-xs px-2 py-1 smaller fw-bold text-white"><i class="bx bxs-file-export me-1"></i> Export Excel</a>
                        <a href="{{ route('admin.flights') }}" class="btn btn-outline-secondary btn-xs px-2 py-1 bg-white smaller fw-bold"><i class="bx bx-reset me-1"></i> Reset Filter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters Section -->
    <div class="card card-sneat border-0 shadow-sm mb-4">
        <div class="card-header py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Search & Filters</h6>
            <i class="bx bx-chevron-up cursor-pointer"></i>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.flights') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label smaller fw-bold text-muted">Booking ID</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Enter Booking ID" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label smaller fw-bold text-muted">PNR</label>
                    <input type="text" name="pnr" class="form-control form-control-sm" placeholder="Enter PNR" value="{{ request('pnr') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label smaller fw-bold text-muted">User Name</label>
                    <input type="text" name="user_name" class="form-control form-control-sm" placeholder="Enter User Name" value="{{ request('user_name') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label smaller fw-bold text-muted">Journey Date</label>
                    <input type="date" name="journey_date" class="form-control form-control-sm" value="{{ request('journey_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label smaller fw-bold text-muted">Booking Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Select Status</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill fw-bold shadow-sm w-100">Apply</button>
                    <a href="{{ route('admin.flights') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill fw-bold bg-white w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Listing Table -->
    <div class="card card-sneat border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase smaller fw-bold text-muted">
                            <th class="ps-4">Booking ID</th>
                            <th>User</th>
                            <th>Airline / Flight</th>
                            <th>Route</th>
                            <th>Journey Date</th>
                            <th>PNR</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Booking Date</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($bookings as $booking)
                        @php
                            $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
                            $details = $details ?? [];
                            $fb = $booking->flightBooking;
                            
                            $itineraries = $details['flight']['itineraries'] ?? [];
                            $segments = $itineraries[0]['segments'] ?? [];
                            $lastSegment = !empty($segments) ? end($segments) : null;
                            
                            $pnr = $fb->pnr ?? ($details['pnr'] ?? 'N/A');
                            $airlineCode = $fb->airline_code ?? ($details['airline_code'] ?? ($details['flight']['airline_code'] ?? 'XX'));
                            $flightNum = $fb->flight_number ?? ($details['flight_number'] ?? ($details['flight']['flight_number'] ?? '0000'));
                            $origin = $fb->origin ?? ($details['origin'] ?? ($segments[0]['departure']['iataCode'] ?? 'N/A'));
                            $destination = $fb->destination ?? ($details['destination'] ?? ($lastSegment['arrival']['iataCode'] ?? 'N/A'));
                            $departureAt = $fb->departure_at ?? ($details['departure_at'] ?? ($segments[0]['departure']['at'] ?? null));
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-navy small">#{{ $booking->booking_reference }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark smaller">{{ $booking->user->name ?? 'User' }}</div>
                                <div class="smaller text-muted">{{ $booking->user->phone ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light p-1 rounded" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bxs-plane text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-navy smaller">{{ $airlineCode }} {{ $flightNum }}</div>
                                        <div class="smaller text-muted">{{ $fb->cabin_class ?? 'Economy' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="smaller fw-bold text-dark">{{ $origin }} <i class="bx bx-right-arrow-alt mx-1"></i> {{ $destination }}</div>
                            </td>
                            <td>
                                <div class="smaller fw-bold text-dark">{{ $departureAt ? \Carbon\Carbon::parse($departureAt)->format('d M Y') : 'N/A' }}</div>
                                <div class="smaller text-muted">{{ $departureAt ? \Carbon\Carbon::parse($departureAt)->format('H:i A') : 'N/A' }}</div>
                            </td>
                            <td><span class="badge bg-label-dark smaller fw-bold">{{ $pnr }}</span></td>
                            <td><div class="fw-bold text-navy smaller">₹ {{ number_format($booking->total_amount, 2) }}</div></td>
                            <td><span class="badge bg-label-success smaller fw-bold">Paid</span></td>
                            <td>
                                @php
                                    $statusClass = 'bg-label-info';
                                    if($booking->status == 'confirmed') $statusClass = 'bg-label-success';
                                    if($booking->status == 'cancelled') $statusClass = 'bg-label-danger';
                                    if($booking->status == 'pending') $statusClass = 'bg-label-warning';
                                @endphp
                                <span class="badge {{ $statusClass }} smaller fw-bold text-uppercase">{{ $booking->status }}</span>
                            </td>
                            <td>
                                <div class="smaller fw-bold text-dark">{{ $booking->created_at->format('d M Y') }}</div>
                                <div class="smaller text-muted">{{ $booking->created_at->format('H:i A') }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.bookings.detail', $booking->id) }}" class="btn btn-outline-primary btn-xs px-2 rounded-pill fw-bold">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center py-5 text-muted">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination Footer -->
            <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                <div class="smaller text-muted fw-bold">Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() ?? 0 }} results</div>
                <div>{{ $bookings->links() }}</div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }
    .bg-label-warning { background-color: #fff2d6 !important; color: #ffab00 !important; }
    .bg-label-danger { background-color: #ffe5e0 !important; color: #ff3e1d !important; }
    .bg-label-dark { background-color: #ebedef !important; color: #435971 !important; }
    .btn-xs { padding: 0.2rem 0.5rem; font-size: 0.7rem; }
    .smaller { font-size: 0.7rem; }
</style>
@endsection

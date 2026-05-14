@extends('layouts.admin')

@section('title', 'Hotel Booking Detail | TripZant Admin')

@section('admin_content')
<div class="container-fluid p-0">
    <!-- Header with Actions -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="fw-bold text-navy mb-0">Hotel Booking Detail</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="/admin-dashboard" class="text-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/admin/hotels" class="text-primary">Hotels Control</a></li>
                    <li class="breadcrumb-item active">Hotel Booking Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-send me-1"></i> Send Voucher</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-download me-1"></i> Download Voucher</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-printer me-1"></i> Print Invoice</button>
            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-x-circle me-1"></i> Cancel Booking</button>
        </div>
    </div>

    @php
        $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
        $details = $details ?? [];
        
        $checkIn = $booking->hotelBooking->check_in ?? ($details['check_in'] ?? ($details['checkIn'] ?? null));
        $checkOut = $booking->hotelBooking->check_out ?? ($details['check_out'] ?? ($details['checkOut'] ?? null));
        $hotelName = $booking->hotelBooking->hotel_name ?? ($details['hotel_name'] ?? ($details['name'] ?? 'Premium Hotel'));
        $confirmation = $booking->hotelBooking->confirmation_number ?? ($booking->booking_reference);
        $roomsCount = $booking->hotelBooking->rooms ?? ($details['rooms'] ?? 1);
        $roomType = $booking->hotelBooking->room_type ?? ($details['room_name'] ?? ($details['room_type'] ?? 'Standard Room'));
        $city = $booking->hotelBooking->city ?? ($details['city_name'] ?? ($details['location'] ?? 'India'));
        
        $nights = 0;
        if($checkIn && $checkOut) {
            $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut));
        }
    @endphp

    <!-- Booking Summary Row -->
    <div class="card card-sneat border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row text-center align-items-center">
                <div class="col-md-2 border-end">
                    <div class="text-muted smaller fw-bold text-uppercase mb-1">Booking ID</div>
                    <div class="fw-bold text-navy small">#{{ $booking->booking_reference }}</div>
                </div>
                <div class="col-md-2 border-end">
                    <div class="text-muted smaller fw-bold text-uppercase mb-1">Confirmation ID</div>
                    <div class="fw-bold text-dark small">{{ $confirmation ?? 'N/A' }}</div>
                </div>
                <div class="col-md-2 border-end">
                    <div class="text-muted smaller fw-bold text-uppercase mb-1">Status</div>
                    @php
                        $statusClass = 'bg-label-info';
                        if($booking->status == 'confirmed') $statusClass = 'bg-label-success';
                        if($booking->status == 'cancelled') $statusClass = 'bg-label-danger';
                    @endphp
                    <span class="badge {{ $statusClass }} text-uppercase fw-bold">{{ $booking->status }}</span>
                </div>
                <div class="col-md-2 border-end">
                    <div class="text-muted smaller fw-bold text-uppercase mb-1">Payment</div>
                    <span class="badge bg-label-primary text-uppercase fw-bold">PAID</span>
                </div>
                <div class="col-md-2 border-end">
                    <div class="text-muted smaller fw-bold text-uppercase mb-1">Booking Date</div>
                    <div class="fw-bold text-dark small">{{ $booking->created_at->format('d M Y') }}</div>
                </div>
                <div class="col-md-2">
                    <div class="text-muted smaller fw-bold text-uppercase mb-1">Guests</div>
                    <div class="fw-bold text-dark small">{{ $booking->passengers->count() }} Pax</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Column -->
        <div class="col-xl-9">
            <!-- Hotel Info & Map Section -->
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="card card-sneat border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-6 h-100">
                                    <div class="hotel-gallery h-100 position-relative">
                                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Hotel Main">
                                    </div>
                                </div>
                                <div class="col-md-6 p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-navy rounded px-2 py-1 text-white fw-bold small">H</div>
                                        <h5 class="fw-bold mb-0 text-navy">{{ $hotelName }}</h5>
                                    </div>
                                    <div class="text-warning small mb-2">
                                        <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                                    </div>
                                    <p class="text-muted small mb-3"><i class="bx bx-map me-1"></i> {{ $city }}</p>
                                    
                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <span class="badge bg-label-secondary smaller"><i class="bx bx-building me-1"></i> Hotel</span>
                                        <span class="badge bg-label-secondary smaller"><i class="bx bx-time me-1"></i> {{ $nights }} Nights Stay</span>
                                    </div>
                                    
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="smaller text-muted"><i class="bx bx-wifi me-1"></i> Free Wifi</div>
                                        <div class="smaller text-muted"><i class="bx bx-restaurant me-1"></i> Breakfast</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100 overflow-hidden">
                        <div class="position-relative h-100">
                            <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&w=400&q=80" class="w-100 h-100 object-fit-cover opacity-50" style="filter: grayscale(0.5);">
                            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                                <div class="bg-white rounded-circle p-2 shadow-sm d-inline-block mb-2">
                                    <i class="bx bx-map-pin text-danger fs-3"></i>
                                </div>
                                <div><button class="btn btn-primary btn-sm rounded-pill px-3">View Location</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Cards Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100">
                        <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold"><i class="bx bx-calendar me-2 text-primary"></i> Stay Details</h6></div>
                        <div class="card-body p-4">
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="smaller text-muted fw-bold">Check-in</div>
                                <div class="small fw-bold">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('d M Y') : 'N/A' }}</div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="smaller text-muted fw-bold">Check-out</div>
                                <div class="small fw-bold">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('d M Y') : 'N/A' }}</div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="smaller text-muted fw-bold">Total Nights</div>
                                <div class="small fw-bold">{{ $nights }} Night(s)</div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="smaller text-muted fw-bold">Rooms</div>
                                <div class="small fw-bold">{{ $roomsCount }} Room(s)</div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="smaller text-muted fw-bold">Guests</div>
                                <div class="small fw-bold">{{ $booking->passengers->count() }} Pax</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100">
                        <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold"><i class="bx bx-bed me-2 text-primary"></i> Room Details</h6></div>
                        <div class="card-body p-4">
                            <div class="bg-light rounded p-3 mb-4">
                                <div class="fw-bold small mb-2 d-flex justify-content-between">
                                    <span>Room 1</span>
                                    <span class="badge bg-label-success smaller">Booked</span>
                                </div>
                                <div class="small fw-bold text-navy mb-1">{{ $roomType }}</div>
                                <div class="smaller text-muted"><i class="bx bx-group me-1"></i> {{ $booking->passengers->count() }} Pax</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100">
                        <div class="card-header py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><i class="bx bx-user me-2 text-primary"></i> Guest Details</h6>
                        </div>
                        <div class="card-body p-4">
                            @forelse($booking->passengers as $passenger)
                            @php
                                $pDetails = is_string($passenger->extra_details) ? json_decode($passenger->extra_details, true) : $passenger->extra_details;
                                if (empty($pDetails) && !empty($details['travelers'])) {
                                    foreach($details['travelers'] as $t) {
                                        if (strtoupper($t['first_name'] ?? '') == strtoupper($passenger->first_name) && 
                                            strtoupper($t['last_name'] ?? '') == strtoupper($passenger->last_name)) {
                                            $pDetails = $t;
                                            break;
                                        }
                                    }
                                }
                                $gender = $passenger->gender ?? ($pDetails['gender'] ?? 'N/A');
                                $dob = $passenger->dob ?? ($pDetails['dob'] ?? null);
                            @endphp
                            <div class="mb-4 d-flex gap-3 align-items-start">
                                <div class="avatar avatar-sm"><div class="bg-label-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">{{ substr($passenger->first_name, 0, 1) }}</div></div>
                                <div>
                                    <div class="smaller text-muted fw-bold text-uppercase">Guest Name</div>
                                    <div class="small fw-bold text-navy mb-1">{{ $passenger->first_name }} {{ $passenger->last_name }}</div>
                                    <div class="smaller text-muted">
                                        <span class="me-2"><i class="bx bx-user me-1"></i> {{ strtoupper($gender) }}</span>
                                        <span><i class="bx bx-calendar me-1"></i> {{ $dob ? \Carbon\Carbon::parse($dob)->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                    @if($passenger->passport_number || !empty($pDetails['passport']))
                                    <div class="smaller text-muted mt-1">
                                        <i class="bx bx-id-card me-1"></i> {{ $passenger->passport_number ?? ($pDetails['passport'] ?? '') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-muted smaller">No guest information.</div>
                            @endforelse
                            <div class="mt-4 pt-3 border-top">
                                <div class="smaller text-muted fw-bold">Contact</div>
                                <div class="small fw-bold">{{ $booking->user->email ?? 'N/A' }}</div>
                                <div class="small fw-bold">{{ $booking->user->phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Timeline Section -->
            <div class="card card-sneat border-0 shadow-sm mb-4">
                <div class="card-header py-3"><h6 class="mb-0 fw-bold">Booking Timeline</h6></div>
                <div class="card-body p-4">
                    <div class="horizontal-timeline py-3">
                        <div class="d-flex justify-content-between position-relative">
                            <div class="timeline-line position-absolute top-0 start-0 w-100 border-top border-2 border-dashed mt-2" style="z-index: 1;"></div>
                            <div class="timeline-step text-center position-relative" style="z-index: 2; width: 25%;">
                                <div class="bg-success rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 20px; height: 20px;"><i class="bx bx-check smaller"></i></div>
                                <div class="smaller fw-bold">Booking Created</div>
                                <div class="smaller text-muted">{{ $booking->created_at->format('d M Y, H:i A') }}</div>
                            </div>
                            @if($booking->status == 'confirmed')
                            <div class="timeline-step text-center position-relative" style="z-index: 2; width: 25%;">
                                <div class="bg-success rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 20px; height: 20px;"><i class="bx bx-check smaller"></i></div>
                                <div class="smaller fw-bold">Payment Success</div>
                                <div class="smaller text-muted">{{ $booking->updated_at->format('d M Y') }}</div>
                            </div>
                            <div class="timeline-step text-center position-relative" style="z-index: 2; width: 25%;">
                                <div class="bg-success rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 20px; height: 20px;"><i class="bx bx-check smaller"></i></div>
                                <div class="smaller fw-bold">Voucher Generated</div>
                                <div class="smaller text-muted">{{ $booking->updated_at->format('d M Y') }}</div>
                            </div>
                            <div class="timeline-step text-center position-relative" style="z-index: 2; width: 25%;">
                                <div class="bg-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 20px; height: 20px;"><i class="bx bx-time smaller"></i></div>
                                <div class="smaller fw-bold">Check-in</div>
                                <div class="smaller text-muted">Upcoming</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Bookings Table -->
            <div class="card card-sneat border-0 shadow-sm mb-4">
                <div class="card-header py-3"><h5 class="mb-0 fw-bold">Other Bookings by this User</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light text-uppercase smaller fw-bold text-muted">
                                <tr>
                                    <th class="ps-4">Booking ID</th>
                                    <th>Type</th>
                                    <th>Details</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($otherBookings as $other)
                                <tr>
                                    <td class="ps-4 small fw-bold">#{{ $other->booking_reference }}</td>
                                    <td class="small text-uppercase">{{ $other->type }}</td>
                                    <td class="small">
                                        @if($other->type == 'hotel')
                                            {{ $other->hotelBooking->hotel_name ?? 'Hotel' }}
                                        @else
                                            {{ $other->flightBooking->origin ?? 'N/A' }} <i class="bx bx-right-arrow-alt mx-1"></i> {{ $other->flightBooking->destination ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="small">{{ $other->created_at->format('d M Y') }}</td>
                                    <td class="small fw-bold">₹ {{ number_format($other->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $other->status == 'confirmed' ? 'bg-label-success' : 'bg-label-info' }} smaller text-uppercase">{{ $other->status }}</span>
                                    </td>
                                    <td class="pe-4 text-end"><a href="{{ route('admin.bookings.detail', $other->id) }}" class="btn btn-outline-primary btn-xs px-3">View</a></td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-3 text-muted smaller">No other bookings found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (Right) -->
        <div class="col-xl-3">
            <!-- Price Breakdown -->
            <div class="card card-sneat border-0 shadow-sm mb-4">
                <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold">Price Breakdown</h6></div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="small text-muted">Base Amount</span>
                        <span class="small fw-bold">₹ {{ number_format($booking->total_amount * 0.88, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="small text-muted">Taxes (12%)</span>
                        <span class="small fw-bold">₹ {{ number_format($booking->total_amount * 0.12, 2) }}</span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0 fw-bold">Total Amount</h6>
                        <h5 class="mb-0 fw-bold text-primary">₹ {{ number_format($booking->total_amount, 2) }}</h5>
                    </div>
                    
                    <div class="payment-info-box bg-light rounded p-3 mb-3">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="smaller text-muted">Payment Status</span>
                            <span class="smaller fw-bold">SUCCESSFUL</span>
                        </div>
                    </div>
                    <div class="bg-label-success text-center py-2 rounded fw-bold text-uppercase smaller">PAID</div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="card card-sneat border-0 shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Notes</h6>
                    <button class="btn btn-link btn-xs text-primary p-0">Add Note</button>
                </div>
                <div class="card-body p-4">
                    <div class="note-item mb-2">
                        <div class="smaller text-muted">No internal notes for this booking.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #001f3f !important; }
    .object-fit-cover { object-fit: cover; }
    .btn-xs { padding: 0.2rem 0.5rem; font-size: 0.7rem; }
    .smaller { font-size: 0.7rem; }
    .horizontal-timeline .timeline-line { z-index: 1; }
    .horizontal-timeline .timeline-step { z-index: 2; }
</style>
@endsection

@extends('layouts.admin')

@section('title', 'Flight Booking Detail | TripZant Admin')

@section('admin_content')
<div class="container-fluid p-0">
    <!-- Header with Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold text-navy mb-0">Flight Booking Detail</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 smaller fw-bold">
                    <li class="breadcrumb-item"><a href="/admin-dashboard" class="text-primary text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/admin/flights" class="text-primary text-decoration-none">Flights Control</a></li>
                    <li class="breadcrumb-item active text-muted">Flight Booking Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-send me-1"></i> Send Ticket</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-printer me-1"></i> Print Ticket</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-download me-1"></i> Download Invoice</button>
            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm bg-white"><i class="bx bx-x-circle me-1"></i> Cancel Booking</button>
        </div>
    </div>

    <!-- Booking Summary Row -->
    @php
        $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
        $details = $details ?? [];
        
        $itineraries = $details['flight']['itineraries'] ?? [];
        $segments = $itineraries[0]['segments'] ?? [];
        $lastSegment = !empty($segments) ? end($segments) : null;
        
        $fb = $booking->flightBooking;
        $airlineName = $fb->airline_name ?? ($details['airline_name'] ?? ($details['flight']['airline_name'] ?? 'Airline'));
        $airlineCode = $fb->airline_code ?? ($details['airline_code'] ?? ($details['flight']['airline_code'] ?? 'XX'));
        $flightNum = $fb->flight_number ?? ($details['flight_number'] ?? ($details['flight']['flight_number'] ?? '0000'));
        $cabin = $fb->cabin_class ?? ($details['cabin_class'] ?? ($details['flight']['cabin_class'] ?? 'Economy'));
        
        $origin = $fb->origin ?? ($details['origin'] ?? ($segments[0]['departure']['iataCode'] ?? 'N/A'));
        $destination = $fb->destination ?? ($details['destination'] ?? ($lastSegment['arrival']['iataCode'] ?? 'N/A'));
        
        $departureAt = $fb->departure_at ?? ($details['departure_at'] ?? ($segments[0]['departure']['at'] ?? null));
        $arrivalAt = $fb->arrival_at ?? ($details['arrival_at'] ?? ($lastSegment['arrival']['at'] ?? null));
        
        $pnr = $fb->pnr ?? ($details['pnr'] ?? 'N/A');
    @endphp
    <div class="card card-sneat border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col border-end text-center">
                    <div class="text-muted smaller fw-bold mb-1">Booking ID</div>
                    <div class="fw-bold text-navy small">#{{ $booking->booking_reference }}</div>
                </div>
                <div class="col border-end text-center">
                    <div class="text-muted smaller fw-bold mb-1">PNR</div>
                    <div class="fw-bold text-dark small">{{ $pnr }}</div>
                </div>
                <div class="col border-end text-center">
                    <div class="text-muted smaller fw-bold mb-1">Booking Status</div>
                    @php
                        $statusClass = 'bg-label-info';
                        if($booking->status == 'confirmed') $statusClass = 'bg-label-success';
                        if($booking->status == 'cancelled') $statusClass = 'bg-label-danger';
                        if($booking->status == 'pending') $statusClass = 'bg-label-warning';
                    @endphp
                    <span class="badge {{ $statusClass }} text-uppercase fw-bold smaller px-2">{{ $booking->status }}</span>
                </div>
                <div class="col border-end text-center">
                    <div class="text-muted smaller fw-bold mb-1">Payment Status</div>
                    <span class="badge bg-label-primary text-uppercase fw-bold smaller px-2">PAID</span>
                </div>
                <div class="col border-end text-center">
                    <div class="text-muted smaller fw-bold mb-1">Booking Date</div>
                    <div class="fw-bold text-dark smaller">{{ $booking->created_at->format('d M Y, H:i A') }}</div>
                </div>
                <div class="col text-center">
                    <div class="text-muted smaller fw-bold mb-1">Last Updated</div>
                    <div class="fw-bold text-dark smaller">{{ $booking->updated_at->format('d M Y, H:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Column -->
        <div class="col-xl-9">
            <!-- Flight Route Info Card -->
            <div class="card card-sneat border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-navy rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                    <i class="bx bxs-plane-alt text-white fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-navy">{{ $airlineName }}</h6>
                                    <div class="small fw-bold text-dark">{{ $airlineCode }} {{ $flightNum }}</div>
                                    <div class="smaller text-muted">{{ $cabin }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-start border-end px-4">
                            <div class="row align-items-center">
                                <div class="col-4 text-center">
                                    <h3 class="fw-bold mb-0 text-navy">{{ $origin }}</h3>
                                    <div class="smaller text-muted mb-2">{{ $fb->origin_city ?? 'Origin' }}</div>
                                    <div class="smaller fw-bold text-dark">{{ $departureAt ? \Carbon\Carbon::parse($departureAt)->format('d M Y') : 'N/A' }}</div>
                                    <div class="text-primary fw-bold small">{{ $departureAt ? \Carbon\Carbon::parse($departureAt)->format('H:i A') : 'N/A' }}</div>
                                </div>
                                <div class="col-4 text-center px-0">
                                    <div class="smaller text-muted mb-1">Duration: {{ $booking->flightBooking->duration ?? 'N/A' }}</div>
                                    <div class="position-relative d-flex align-items-center justify-content-center py-2">
                                        <div class="w-100 border-top border-2 border-primary border-dashed position-absolute" style="z-index: 1;"></div>
                                        <i class="bx bxs-plane fs-5 text-primary position-relative bg-white px-2" style="z-index: 2;"></i>
                                    </div>
                                    <div class="smaller text-muted mt-1">Non Stop</div>
                                </div>
                                <div class="col-4 text-center">
                                    <h3 class="fw-bold mb-0 text-navy">{{ $destination }}</h3>
                                    <div class="smaller text-muted mb-2">{{ $fb->destination_city ?? 'Destination' }}</div>
                                    <div class="smaller fw-bold text-dark">{{ $arrivalAt ? \Carbon\Carbon::parse($arrivalAt)->format('d M Y') : 'N/A' }}</div>
                                    <div class="text-primary fw-bold small">{{ $arrivalAt ? \Carbon\Carbon::parse($arrivalAt)->format('H:i A') : 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ps-4">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="smaller text-muted fw-bold text-uppercase">Aircraft</div>
                                    <div class="small fw-bold">{{ $booking->flightBooking->aircraft ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="smaller text-muted fw-bold text-uppercase">Terminal</div>
                                    <div class="small fw-bold">{{ $booking->flightBooking->terminal ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="smaller text-muted fw-bold text-uppercase">Booking Class</div>
                                    <div class="small fw-bold">{{ $booking->flightBooking->cabin_class ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="smaller text-muted fw-bold text-uppercase">Fare Type</div>
                                    <div class="small fw-bold">{{ $booking->flightBooking->fare_type ?? 'Regular' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passenger Details Table -->
            <div class="card card-sneat border-0 shadow-sm mb-4">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="mb-0 fw-bold">Passenger Details</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase smaller fw-bold text-muted">
                                    <th class="ps-4">#</th>
                                    <th>Passenger Name</th>
                                    <th>Gender</th>
                                    <th>Age/DOB</th>
                                    <th>Passport</th>
                                    <th>Ticket Number</th>
                                    <th>Seat</th>
                                    <th>Class</th>
                                    <th>Meal</th>
                                    <th class="pe-4">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($booking->passengers as $key => $passenger)
                                @php
                                    $pDetails = is_string($passenger->extra_details) ? json_decode($passenger->extra_details, true) : $passenger->extra_details;
                                    
                                    // If extra_details is empty (old record), try finding in main booking details
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
                                    $passport = $passenger->passport_number ?? ($pDetails['passport'] ?? ($pDetails['passport_number'] ?? 'N/A'));
                                @endphp
                                <tr>
                                    <td class="ps-4 smaller">{{ $key + 1 }}</td>
                                    <td><div class="fw-bold small">{{ $passenger->first_name }} {{ $passenger->last_name }}</div></td>
                                    <td class="small text-uppercase">{{ $gender }}</td>
                                    <td class="small">{{ $dob ? \Carbon\Carbon::parse($dob)->format('d M Y') : 'N/A' }}</td>
                                    <td class="small">{{ $passport }}</td>
                                    <td class="smaller text-muted">{{ $passenger->ticket_number ?? 'N/A' }}</td>
                                    <td><span class="badge bg-label-info fw-bold smaller">{{ $passenger->seat_number ?? 'Auto' }}</span></td>
                                    <td class="smaller">{{ $cabin }}</td>
                                    <td class="smaller">{{ $passenger->meal_preference ?? 'N/A' }}</td>
                                    <td class="pe-4 smaller text-muted">{{ $passenger->extra_details ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="10" class="text-center py-3 text-muted">No passenger records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Three Cards Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100">
                        <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold"><i class="bx bx-chair me-2 text-primary"></i> Seat & Baggage Details</h6></div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="smaller fw-bold text-muted"><i class="bx bx-chair me-1"></i> Seat Info</span>
                                <span class="smaller fw-bold">{{ $booking->passengers->pluck('seat_number')->filter()->implode(', ') ?: 'Auto-assigned' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="smaller fw-bold text-muted"><i class="bx bx-briefcase me-1"></i> Cabin Baggage</span>
                                <span class="smaller fw-bold">7 Kg per Pax</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="smaller fw-bold text-muted"><i class="bx bx-shopping-bag me-1"></i> Check-in Baggage</span>
                                <span class="smaller fw-bold">15 Kg per Pax</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100">
                        <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold"><i class="bx bx-user me-2 text-primary"></i> Contact Details</h6></div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class="smaller text-muted fw-bold mb-1"><i class="bx bx-envelope me-1"></i> Email</div>
                                <div class="small fw-bold">{{ $booking->user->email ?? 'N/A' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="smaller text-muted fw-bold mb-1"><i class="bx bx-phone me-1"></i> Mobile</div>
                                <div class="small fw-bold">{{ $booking->user->phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sneat border-0 shadow-sm h-100">
                        <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold"><i class="bx bx-receipt me-2 text-primary"></i> Fare Breakdown</h6></div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="smaller text-muted">Base Fare</span>
                                <span class="smaller fw-bold">₹ {{ number_format($booking->total_amount * 0.85, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="smaller text-muted">Taxes & Fees</span>
                                <span class="smaller fw-bold">₹ {{ number_format($booking->total_amount * 0.15, 2) }}</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-navy">Total Amount</h6>
                                <h5 class="mb-0 fw-bold text-primary">₹ {{ number_format($booking->total_amount, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Bookings Table -->
            <div class="card card-sneat border-0 shadow-sm">
                <div class="card-header py-3 border-bottom bg-light">
                    <h6 class="mb-0 fw-bold">Other Bookings by this User</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light text-uppercase smaller fw-bold text-muted">
                                <tr>
                                    <th class="ps-4">Booking ID</th>
                                    <th>Type</th>
                                    <th>Details</th>
                                    <th>Journey Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($otherBookings as $other)
                                <tr>
                                    <td class="ps-4 small fw-bold text-navy">#{{ $other->booking_reference }}</td>
                                    <td class="smaller text-uppercase">{{ $other->type }}</td>
                                    <td class="smaller">
                                        @if($other->type == 'flight')
                                            {{ $other->flightBooking->origin ?? 'N/A' }} <i class="bx bx-right-arrow-alt mx-1"></i> {{ $other->flightBooking->destination ?? 'N/A' }}
                                        @else
                                            {{ $other->hotelBooking->hotel_name ?? 'Hotel' }}
                                        @endif
                                    </td>
                                    <td class="smaller">
                                        @if($other->type == 'flight')
                                            {{ $other->flightBooking ? \Carbon\Carbon::parse($other->flightBooking->departure_at)->format('d M Y') : 'N/A' }}
                                        @else
                                            {{ $other->hotelBooking ? \Carbon\Carbon::parse($other->hotelBooking->check_in)->format('d M Y') : 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $otherStatusClass = 'bg-label-info';
                                            if($other->status == 'confirmed') $otherStatusClass = 'bg-label-success';
                                            if($other->status == 'cancelled') $otherStatusClass = 'bg-label-danger';
                                        @endphp
                                        <span class="badge {{ $otherStatusClass }} smaller text-uppercase">{{ $other->status }}</span>
                                    </td>
                                    <td class="smaller fw-bold">₹ {{ number_format($other->total_amount, 2) }}</td>
                                    <td class="pe-4 text-end"><a href="{{ route('admin.bookings.detail', $other->id) }}" class="btn btn-outline-primary btn-xs px-3 rounded-pill">View</a></td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-3 text-muted smaller">No other bookings found for this user.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-xl-3">
            <!-- Booking Timeline -->
            <div class="card card-sneat border-0 shadow-sm mb-4">
                <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold">Booking Timeline</h6></div>
                <div class="card-body p-4 pt-0">
                    <ul class="timeline-v2 list-unstyled ps-4 position-relative mt-4">
                        <li class="timeline-item-v2 mb-4">
                            <div class="timeline-point bg-success"><i class="bx bx-check text-white smaller"></i></div>
                            <div class="fw-bold smaller text-navy">Booking Created</div>
                            <div class="smaller text-muted">{{ $booking->created_at->format('d M Y, H:i A') }}</div>
                        </li>
                        @if($booking->status == 'confirmed')
                        <li class="timeline-item-v2">
                            <div class="timeline-point bg-success"><i class="bx bx-check text-white smaller"></i></div>
                            <div class="fw-bold smaller text-navy">Booking Confirmed</div>
                            <div class="smaller text-muted">{{ $booking->updated_at->format('d M Y, H:i A') }}</div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card card-sneat border-0 shadow-sm">
                <div class="card-header py-3 border-bottom"><h6 class="mb-0 fw-bold">Payment Information</h6></div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="smaller text-muted fw-bold">Status</span>
                        <span class="smaller fw-bold text-navy">PAID</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="smaller text-muted fw-bold">Amount Paid</span>
                        <span class="smaller fw-bold text-navy">₹ {{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                    <div class="bg-label-success text-center py-2 rounded fw-bold text-uppercase smaller px-4">SUCCESSFUL</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #001f3f !important; }
    .timeline-v2 { border-left: 2px dashed #e2e8f0; }
    .timeline-item-v2 { position: relative; padding-left: 15px; }
    .timeline-point {
        position: absolute;
        left: -26px;
        top: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }
    .smaller { font-size: 0.7rem; }
    .btn-xs { padding: 0.2rem 0.5rem; font-size: 0.7rem; }
</style>
@endsection

@extends('layouts.dashboard')

@section('title', 'My Trips | Tripzant')

@section('styles')
<style>
    .trip-card {
        background: #fff;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: var(--user-card-shadow);
        transition: all 0.4s ease;
        margin-bottom: 24px;
    }
    .trip-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--user-card-hover);
    }
    .pnr-tag {
        background: rgba(99, 102, 241, 0.1);
        color: var(--user-accent);
        padding: 6px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .status-pill {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }
    .city-code { font-size: 28px; letter-spacing: -0.5px; }
    .airline-info { font-size: 12px; color: #64748b; font-weight: 600; }
</style>
@endsection

@section('dashboard_content')
<div class="user-bookings-wrap">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-900 text-navy mb-1">My Bookings</h3>
            <p class="text-muted small">View, manage, and download tickets for your upcoming trips.</p>
        </div>
        <div class="small fw-bold">Showing Latest 5</div>
    </div>

    <div id="bookingList">
        @forelse($bookings as $booking)
            @php
                $fb = $booking->flightBooking;
                $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
                // Fallback for older data or other types
                $details = $details ?? (is_string($booking->booking_details) ? json_decode($booking->booking_details, true) : $booking->booking_details);
                
                $type = $booking->booking_type ?? ($booking->type ?? 'flight');
                
                if($type == 'hotel') {
                    $origin = $details['hotel_name'] ?? 'Hotel';
                    $destination = $details['room_name'] ?? 'Room';
                    $airline = $details['board_name'] ?? 'Hotel Stay';
                    $duration = (isset($details['check_in']) && isset($details['check_out'])) ? (strtotime($details['check_out']) - strtotime($details['check_in'])) / 86400 : 0;
                    $durationText = $duration . ' Night(s)';
                    $displayOrigin = $details['check_in'] ?? '--';
                    $displayDest = $details['check_out'] ?? '--';
                } else {
                    $origin = $fb->origin ?? $details['origin'] ?? $details['flight']['itineraries'][0]['segments'][0]['departure']['iataCode'] ?? 'TRZ';
                    $destination = $fb->destination ?? $details['destination'] ?? 'LOC';
                    $airline = $fb->airline_code ?? $details['flight']['airline'] ?? ($type == 'flight' ? 'Flt-'.$booking->id : ucfirst($type));
                    $durationText = $details['duration'] ?? '--';
                    $displayOrigin = $fb->origin_city ?? 'Origin';
                    $displayDest = $fb->destination_city ?? 'Destination';
                }
                
                $statusColor = '#f97316';
                $statusBg = '#fff7ed';
                if($booking->status == 'confirmed' || $booking->status == 'successful' || $booking->status == 'paid') {
                    $statusColor = '#10b981';
                    $statusBg = '#f0fdf4';
                }
            @endphp
            <!-- Trip Card -->
            <div class="trip-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <span class="pnr-tag">{{ $fb->pnr ?? $booking->api_reference ?? ($booking->booking_reference ?? 'REF-'.$booking->id) }}</span>
                        <span class="status-pill" style="background: {{ $statusBg }}; color: {{ $statusColor }};">
                            {{ strtoupper($booking->status) }}
                        </span>
                        <span class="badge bg-light text-navy border rounded-pill x-small px-3 py-1 fw-800 opacity-75">
                            <i class="fas {{ $type == 'hotel' ? 'fa-hotel' : 'fa-plane' }} me-1"></i> {{ strtoupper($type) }}
                        </span>
                    </div>
                    <div class="text-muted x-small fw-bold opacity-75">
                        <i class="far fa-calendar-alt me-1"></i> {{ $booking->created_at->format('d M, Y') }}
                    </div>
                </div>
                
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="city-code fw-900 text-navy mb-0" style="{{ $type == 'hotel' ? 'font-size: 18px;' : '' }}">{{ $origin }}</div>
                        <div class="x-small fw-bold text-muted text-uppercase letter-spacing-1">{{ $displayOrigin }}</div>
                    </div>
                    <div class="col-md-5 text-center px-4">
                        <div class="airline-info mb-2">
                             <span class="text-accent">{{ $airline }}</span> • {{ $fb->cabin_class ?? 'Standard' }}
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-grow-1 border-top border-2 border-dashed opacity-25"></div>
                            <div class="p-2 rounded-circle bg-light">
                                <i class="fas {{ $type == 'hotel' ? 'fa-hotel' : 'fa-plane' }} text-navy fs-6"></i>
                            </div>
                            <div class="flex-grow-1 border-top border-2 border-dashed opacity-25"></div>
                        </div>
                        <div class="x-small fw-800 text-muted mt-2">{{ $durationText }}</div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="city-code fw-900 text-navy mb-0" style="{{ $type == 'hotel' ? 'font-size: 18px;' : '' }}">{{ $destination }}</div>
                        <div class="x-small fw-bold text-muted text-uppercase letter-spacing-1">{{ $displayDest }}</div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="fw-900 fs-4 text-navy">₹{{ number_format($booking->total_amount ?? $booking->selling_price ?? 0, 2) }}</div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-navy rounded-pill px-4 fw-800 py-2 x-small hvr-shrink" onclick="viewTicket('{{ $fb->pnr ?? $booking->booking_reference }}')">
                            <i class="fas fa-file-invoice me-1"></i> MANAGE
                        </button>
                        <button class="btn btn-outline-light text-muted border rounded-pill px-4 fw-800 py-2 x-small hvr-shrink">
                            <i class="fas fa-download me-1"></i> TICKET
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                <div class="mb-4">
                    <i class="fas fa-suitcase-rolling display-4 text-muted opacity-25"></i>
                </div>
                <h5 class="fw-900 text-navy">No Trips Found</h5>
                <p class="text-muted small px-5">It looks like you haven't booked any trips yet. Exploring new destinations is just a click away!</p>
                <a href="/" class="btn btn-navy rounded-pill px-5 py-2 mt-3 fw-bold">Plan a Trip</a>
            </div>
        @endforelse

        @if($bookings->count() > 0)
        <div class="text-center py-4">
            <p class="text-muted small">Only upcoming trips are shown. For past trips, please check your email archive.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function viewTicket(pnr) {
        Swal.fire({
            title: 'Generating E-Ticket...',
            text: `Allocating seat manifest for PNR: ${pnr}`,
            timer: 1500,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        }).then(() => {
            window.location.href = '/booking-confirmation';
        });
    }
</script>
@endsection

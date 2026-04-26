@extends('layouts.dashboard')

@section('title', 'My Itineraries | Tripzant')

@section('styles')
<style>
    :root {
        --trip-navy: #0f172a;
        --trip-blue: #0077ff;
        --trip-bg: #f8fafc;
        --trip-border: #e2e8f0;
    }

    .user-bookings-wrap { 
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 10px;
    }

    /* Ticket Strip (Patti Style) */
    .luxury-ticket {
        background: #fff;
        border-radius: 20px;
        margin-bottom: 20px;
        border: 1px solid var(--trip-border);
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01);
    }
    .luxury-ticket:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.05);
        border-color: var(--trip-blue);
    }

    /* Side cutouts for patti */
    .luxury-ticket::before, .luxury-ticket::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 16px;
        height: 16px;
        background: var(--trip-bg);
        border: 1px solid var(--trip-border);
        border-radius: 50%;
        z-index: 5;
    }
    .luxury-ticket::before { left: -9px; transform: translateY(-50%); }
    .luxury-ticket::after { right: -9px; transform: translateY(-50%); }

    /* Compact Layout Sections */
    .ticket-left {
        padding: 20px 30px;
        border-right: 1px dashed var(--trip-border);
        min-width: 250px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .h-icon-sm {
        width: 50px;
        height: 50px;
        background: #eff6ff;
        color: var(--trip-blue);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .t-main-txt { font-size: 16px; font-weight: 800; color: var(--trip-navy); margin-bottom: 2px; line-height: 1.2; }
    .t-sub-txt { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }

    .ticket-mid {
        flex: 1;
        padding: 0 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .p-node { text-align: center; }
    .p-code { font-size: 28px; font-weight: 900; color: var(--trip-navy); margin-bottom: 0; }
    .p-city { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
    
    .p-path {
        flex: 1;
        margin: 0 30px;
        position: relative;
        text-align: center;
    }
    .p-line {
        width: 100%;
        height: 1px;
        border-top: 2px dashed #e2e8f0;
        position: absolute;
        top: 50%;
        left: 0;
    }
    .p-icon {
        position: relative;
        z-index: 2;
        background: #fff;
        padding: 0 15px;
        color: var(--trip-blue);
        font-size: 18px;
    }

    .ticket-right {
        padding: 20px 30px;
        border-left: 1px dashed var(--trip-border);
        text-align: right;
        min-width: 320px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
    .t-price { font-size: 18px; font-weight: 900; color: var(--trip-navy); }
    .t-price small { display: block; font-size: 9px; color: #94a3b8; text-transform: uppercase; margin-bottom: 2px; }

    .btn-compact {
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        border: none;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-c-blue { background: var(--trip-blue); color: #fff; }
    .btn-c-outline { background: #f8fafc; color: var(--trip-navy); border: 1px solid #e2e8f0; }
    .btn-c-outline:hover { background: #eff6ff; border-color: var(--trip-blue); }

    /* Modal Adjustments */
    .modal-content-p { border-radius: 25px; border: none; }
</style>
@endsection

@section('dashboard_content')
<div class="user-bookings-wrap">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-900 text-navy mb-0">My Journeys</h3>
        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-800" style="font-size: 11px;">
            TOTAL {{ $bookings->count() }} BOOKINGS
        </div>
    </div>

    <div id="bookingList">
        @forelse($bookings as $booking)
            @php
                $fb = $booking->flightBooking;
                $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
                $details = $details ?? (is_string($booking->booking_details) ? json_decode($booking->booking_details, true) : $booking->booking_details);
                $type = $booking->booking_type ?? ($booking->type ?? 'flight');
            @endphp

            <div class="luxury-ticket">
                {{-- Left Section --}}
                <div class="ticket-left">
                    <div class="h-icon-sm">
                        <i class="fas {{ $type == 'hotel' ? 'fa-hotel' : 'fa-plane' }}"></i>
                    </div>
                    <div>
                        <div class="t-main-txt">{{ $type == 'hotel' ? ($details['hotel_name'] ?? 'Premium Stay') : ($fb->airline_code ?? 'AI') . ' Airways' }}</div>
                        <div class="t-sub-txt">{{ $booking->booking_reference ?? 'REF-'.$booking->id }}</div>
                    </div>
                </div>

                {{-- Mid Section --}}
                <div class="ticket-mid">
                    @if($type == 'hotel')
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <div class="p-city">CHECK-IN</div>
                                <div class="fw-900 text-navy">{{ isset($details['check_in']) ? date('d M', strtotime($details['check_in'])) : '--' }}</div>
                            </div>
                            <div class="text-muted fw-bold">➔</div>
                            <div>
                                <div class="p-city">CHECK-OUT</div>
                                <div class="fw-900 text-navy">{{ isset($details['check_out']) ? date('d M Y', strtotime($details['check_out'])) : '--' }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="p-city">STATUS</div>
                            <div class="fw-900 text-success small">{{ strtoupper($booking->status) }}</div>
                        </div>
                    @else
                        <div class="p-node">
                            <div class="p-code">{{ $fb->origin ?? $details['flight']['itineraries'][0]['segments'][0]['departure']['iataCode'] ?? 'DEL' }}</div>
                            <div class="p-city">{{ $fb->origin_city ?? 'Origin' }}</div>
                        </div>
                        <div class="p-path">
                            <div class="p-line"></div>
                            <div class="p-icon"><i class="fas fa-plane"></i></div>
                        </div>
                        <div class="p-node">
                            <div class="p-code">{{ $fb->destination ?? $details['flight']['itineraries'][0]['segments'][0]['arrival']['iataCode'] ?? 'BOM' }}</div>
                            <div class="p-city">{{ $fb->destination_city ?? 'Destination' }}</div>
                        </div>
                    @endif
                </div>

                {{-- Right Section --}}
                <div class="ticket-right">
                    <div class="t-price">
                        <small>Paid Amount</small>
                        ₹{{ number_format($booking->total_amount ?? 0, 0) }}
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button class="btn-compact btn-c-outline" onclick='showDetails(@json($booking), @json($details))'>
                            <i class="fas fa-eye"></i> Details
                        </button>
                        <a href="#" class="btn-compact btn-c-blue">
                            <i class="fas fa-ticket-alt"></i> Ticket
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-box-open display-4 text-muted opacity-25"></i>
                <h5 class="fw-900 text-navy mt-3">No Bookings Yet</h5>
            </div>
        @endforelse
    </div>
</div>

{{-- Details Modal --}}
<div class="modal fade" id="itineraryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-p">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title fw-900">Itinerary Overview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3" id="modalGrid"></div>
                <div class="mt-4 pt-4 border-top">
                    <h6 class="fw-900 mb-3">Traveler Details</h6>
                    <div id="modalPax" class="row g-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showDetails(booking, details) {
        const type = booking.booking_type || booking.type || 'flight';
        const modal = new bootstrap.Modal(document.getElementById('itineraryModal'));
        const grid = document.getElementById('modalGrid');
        const paxList = document.getElementById('modalPax');
        
        let gridHtml = `
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <label class="x-small fw-800 text-muted uppercase d-block mb-1">REFERENCE</label>
                    <span class="fw-800 text-navy">${booking.booking_reference || ('TZ-' + booking.id)}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <label class="x-small fw-800 text-muted uppercase d-block mb-1">STATUS</label>
                    <span class="fw-800 text-success">${booking.status.toUpperCase()}</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="p-3 bg-light rounded-3">
                    <label class="x-small fw-800 text-muted uppercase d-block mb-1">TOTAL FARE</label>
                    <span class="fw-900 text-primary h5 mb-0">₹${Number(booking.total_amount).toLocaleString()}</span>
                </div>
            </div>
        `;

        if (type === 'hotel') {
            gridHtml += `
                <div class="col-md-12">
                    <div class="p-3 bg-light rounded-3">
                        <label class="x-small fw-800 text-muted uppercase d-block mb-1">HOTEL</label>
                        <span class="fw-800 text-navy">${details.hotel_name || 'N/A'}</span>
                    </div>
                </div>
            `;
        }

        grid.innerHTML = gridHtml;

        let paxHtml = '';
        const paxes = details.paxes || [];
        paxes.forEach(p => {
            paxHtml += `
                <div class="col-md-6">
                    <div class="p-2 border rounded-3 small fw-700">
                        <i class="fas fa-user me-2 text-primary opacity-50"></i> ${p.name} ${p.surname}
                    </div>
                </div>
            `;
        });
        paxList.innerHTML = paxHtml || '<p class="text-muted">No manifest found.</p>';

        modal.show();
    }
</script>
@endpush

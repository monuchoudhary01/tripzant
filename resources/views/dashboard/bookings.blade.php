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

    /* Luxury Pagination */
    .pagination { gap: 8px; }
    .pagination .page-item .page-link { 
        border: none; 
        background: #fff; 
        color: var(--trip-navy); 
        font-weight: 800; 
        border-radius: 12px !important; 
        padding: 10px 18px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: 0.2s;
    }
    .pagination .page-item.active .page-link { 
        background: var(--trip-blue); 
        color: #fff; 
        box-shadow: 0 8px 16px rgba(0, 119, 255, 0.2);
    }
    .pagination .page-item:hover .page-link { background: #eff6ff; color: var(--trip-blue); transform: translateY(-2px); }
</style>
@endsection

@section('dashboard_content')
<div class="user-bookings-wrap">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-900 text-navy mb-0">My Journeys</h3>
        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-800" style="font-size: 11px;">
            TOTAL {{ $bookings->total() }} BOOKINGS
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="premium-card p-4 mb-4 border-0 shadow-sm bg-white rounded-4 animate-slide-up">
        <form action="{{ route('dashboard.bookings') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fs-10 fw-900 text-muted uppercase mb-1" style="letter-spacing: 1px;">Search Reference</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted opacity-50"></i></span>
                    <input type="text" name="q" class="form-control border-0 bg-light fw-800 fs-13" placeholder="e.g. TZ-12345" value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fs-10 fw-900 text-muted uppercase mb-1" style="letter-spacing: 1px;">Type</label>
                <select name="type" class="form-select border-0 bg-light fw-800 fs-13">
                    <option value="">All Services</option>
                    <option value="flight" {{ request('type') == 'flight' ? 'selected' : '' }}>Flights</option>
                    <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotels</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fs-10 fw-900 text-muted uppercase mb-1" style="letter-spacing: 1px;">Status</label>
                <select name="status" class="form-select border-0 bg-light fw-800 fs-13">
                    <option value="">Any Status</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fs-10 fw-900 text-muted uppercase mb-1" style="letter-spacing: 1px;">From</label>
                <input type="date" name="from" class="form-control border-0 bg-light fw-800 fs-13" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fs-10 fw-900 text-muted uppercase mb-1" style="letter-spacing: 1px;">To</label>
                <input type="date" name="to" class="form-control border-0 bg-light fw-800 fs-13" value="{{ request('to') }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm"><i class="fas fa-filter"></i></button>
            </div>
        </form>
    </div>

    <div id="bookingList">
        @forelse($bookings as $booking)
            @php
                $fb = $booking->flightBooking;
                $details = is_string($booking->api_booking_details) ? json_decode($booking->api_booking_details, true) : $booking->api_booking_details;
                $details = $details ?? (is_string($booking->booking_details) ? json_decode($booking->booking_details, true) : $booking->booking_details);
                $type = $booking->booking_type ?? ($booking->type ?? 'flight');
            @endphp

            <div class="luxury-ticket animate-slide-up" style="animation-delay: {{ $loop->index * 0.05 }}s">
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
                        <button class="btn-compact btn-c-outline" onclick='showDetails(@json($booking), @json($details), @json($booking->passengers))'>
                            <i class="fas fa-eye"></i> Details
                        </button>
                        @if($type == 'flight')
                        <a href="{{ route('booking.pdf', ['reference' => $booking->booking_reference ?? 'REF-'.$booking->id]) }}" class="btn-compact btn-c-blue">
                            <i class="fas fa-ticket-alt"></i> Ticket
                        </a>
                        @else
                        <a href="{{ route('booking.pdf', ['reference' => $booking->booking_reference ?? 'REF-'.$booking->id]) }}" class="btn-compact btn-c-blue">
                            <i class="fas fa-hotel"></i> Voucher
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-box-open display-4 text-muted opacity-25"></i>
                <h5 class="fw-900 text-navy mt-3">No Bookings Found</h5>
                <p class="text-muted small">Try adjusting your filters to find what you're looking for.</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- Details Modal --}}
<div class="modal fade" id="itineraryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-p overflow-hidden">
            <div class="modal-header bg-navy text-white p-4 border-0">
                <div>
                    <h5 class="modal-title fw-900 mb-1">Itinerary Detailed Overview</h5>
                    <div class="fs-11 fw-700 text-white-50 uppercase letter-spacing-1" id="modalRef">REFERENCE: TZ-123456</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-4 bg-light border-bottom">
                    <div class="row g-3" id="modalGrid"></div>
                </div>
                
                <div class="p-4">
                    <div id="serviceDetails" class="mb-4"></div>

                    <h6 class="fw-900 mb-3 text-navy d-flex align-items-center gap-2">
                        <i class="fas fa-users text-primary"></i> Traveler Manifest
                    </h6>
                    <div id="modalPax" class="row g-2"></div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 p-3">
                <button type="button" class="btn btn-secondary fw-800 rounded-3 px-4" data-bs-dismiss="modal">Close Details</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showDetails(booking, details, dbPassengers) {
        const type = booking.booking_type || booking.type || 'flight';
        const modal = new bootstrap.Modal(document.getElementById('itineraryModal'));
        const grid = document.getElementById('modalGrid');
        const paxList = document.getElementById('modalPax');
        const serviceSection = document.getElementById('serviceDetails');
        
        document.getElementById('modalRef').innerText = `REFERENCE: ${booking.booking_reference || ('TZ-' + booking.id)}`;

        let gridHtml = `
            <div class="col-md-3">
                <label class="fs-10 fw-800 text-muted uppercase d-block mb-1">SERVICE TYPE</label>
                <span class="badge bg-primary text-white fw-800 fs-11 rounded-pill">${type.toUpperCase()}</span>
            </div>
            <div class="col-md-3">
                <label class="fs-10 fw-800 text-muted uppercase d-block mb-1">STATUS</label>
                <span class="fw-800 text-success"><i class="fas fa-check-circle me-1"></i>${booking.status.toUpperCase()}</span>
            </div>
            <div class="col-md-3">
                <label class="fs-10 fw-800 text-muted uppercase d-block mb-1">BOOKED ON</label>
                <span class="fw-800 text-navy">${new Date(booking.created_at).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})}</span>
            </div>
            <div class="col-md-3">
                <label class="fs-10 fw-800 text-muted uppercase d-block mb-1">TOTAL FARE</label>
                <span class="fw-900 text-primary h5 mb-0">₹${Number(booking.total_amount).toLocaleString()}</span>
            </div>
        `;
        grid.innerHTML = gridHtml;

        let serviceHtml = '';
        if (type === 'hotel') {
            const checkIn = new Date(details.check_in);
            const checkOut = new Date(details.check_out);
            const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24)) || 1;

            serviceHtml = `
                <div class="p-3 border rounded-4 mb-4 bg-white">
                    <h6 class="fw-900 text-navy mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-building text-primary"></i> Hotel Accommodation Details
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6 border-end">
                            <label class="fs-10 fw-800 text-muted uppercase mb-1">Hotel Name & Location</label>
                            <div class="fw-800 text-navy fs-15">${details.hotel_name || 'Premium Property'}</div>
                            <div class="fs-11 text-muted mt-2"><i class="fas fa-map-marker-alt me-1 text-danger"></i> ${details.hotel_address || 'Full address available on voucher'}</div>
                        </div>
                        <div class="col-md-3 border-end">
                            <label class="fs-10 fw-800 text-muted uppercase mb-1">Check In</label>
                            <div class="fw-900 text-navy fs-14">${details.check_in || '--'}</div>
                            <div class="fs-10 text-muted fw-bold mt-1 text-uppercase">From 02:00 PM</div>
                        </div>
                        <div class="col-md-3">
                            <label class="fs-10 fw-800 text-muted uppercase mb-1">Check Out</label>
                            <div class="fw-900 text-navy fs-14">${details.check_out || '--'}</div>
                            <div class="fs-10 text-muted fw-bold mt-1 text-uppercase">By 11:00 AM</div>
                        </div>
                        
                        <div class="col-12"><hr class="my-1 opacity-10"></div>

                        <div class="col-md-4">
                            <label class="fs-10 fw-800 text-muted uppercase mb-1">Room Category</label>
                            <div class="fw-800 text-primary">${details.room_name || 'Standard Room'}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="fs-10 fw-800 text-muted uppercase mb-1">Duration of Stay</label>
                            <div class="fw-800 text-navy">${nights} Night(s) Accommodation</div>
                        </div>
                         <div class="col-md-4">
                            <label class="fs-10 fw-800 text-muted uppercase mb-1">Capacity</label>
                            <div class="fw-800 text-navy">${details.adults || 1} Adult, ${details.children || 0} Child</div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Flight Details - Show segments if available
            const segments = details.flight?.itineraries?.[0]?.segments || details.segments || [];
            let segmentHtml = '';
            
            if (segments.length > 0) {
                 segments.forEach((seg, sIdx) => {
                     segmentHtml += `
                        <div class="d-flex align-items-center gap-3 p-3 mb-2 bg-light border-start border-primary border-3 rounded-3 fs-12 shadow-sm">
                            <div class="bg-primary text-white fw-900 px-2 py-1 rounded small" style="font-size:9px;">LEG ${sIdx + 1}</div>
                            <div class="fw-900 text-navy">${seg.departure.iataCode} <i class="fas fa-long-arrow-alt-right mx-2 text-primary"></i> ${seg.arrival.iataCode}</div>
                            <div class="text-muted ms-auto fw-800 d-none d-md-block">${seg.carrierCode || 'AI'}-${seg.number || '000'}</div>
                            <div class="badge bg-white text-navy border-2 border border-primary-subtle fw-900 px-3 py-2 rounded-pill shadow-sm">${seg.cabin || 'Economy'}</div>
                        </div>
                     `;
                 });
            }

            serviceHtml = `
                <div class="p-3 border rounded-4 mb-4 bg-white">
                    <h6 class="fw-900 text-navy mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-plane-departure text-primary"></i> Flight Journey Overview
                    </h6>
                    <div class="d-flex align-items-center justify-content-between bg-navy text-white p-4 rounded-4 mb-4 shadow">
                        <div class="text-center">
                            <div class="fw-900 fs-2 mb-0 lh-1">${booking.flight_booking?.origin || 'DEL'}</div>
                            <div class="fs-10 fw-800 opacity-50 uppercase mt-2">${booking.flight_booking?.origin_city || 'Origin'}</div>
                        </div>
                        <div class="flex-grow-1 px-4 text-center">
                            <div class="position-relative" style="height: 30px;">
                                <div class="border-bottom border-2 border-dashed w-100 position-absolute top-50 start-0 opacity-20"></div>
                                <i class="fas fa-plane text-primary position-absolute top-50 start-50 translate-middle bg-navy px-3 fs-4" style="z-index: 2;"></i>
                            </div>
                            <div class="fs-10 fw-900 text-primary mt-2 letter-spacing-1">${segments.length > 1 ? (segments.length - 1) + ' LAYOVER(S)' : 'NON-STOP FLIGHT'}</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-900 fs-2 mb-0 lh-1">${booking.flight_booking?.destination || 'BOM'}</div>
                            <div class="fs-10 fw-800 opacity-50 uppercase mt-2">${booking.flight_booking?.destination_city || 'Destination'}</div>
                        </div>
                    </div>

                    ${segmentHtml ? `<div class="mb-4 p-2 bg-light-subtle rounded-4 border border-dashed">
                        <label class="fs-10 fw-900 text-muted uppercase mb-3 px-2 d-block" style="letter-spacing:1px;"><i class="fas fa-stream me-2"></i>Flight Segments Breakdown</label>
                        <div class="px-2">${segmentHtml}</div>
                    </div>` : ''}

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <label class="fs-10 fw-800 text-muted uppercase mb-1 d-block">Main Carrier</label>
                                <div class="fw-900 text-navy fs-14">${booking.flight_booking?.airline_code || 'AI'} Airways</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100 border border-primary border-opacity-25">
                                <label class="fs-10 fw-800 text-muted uppercase mb-1 d-block">Booking PNR</label>
                                <div class="fw-900 text-primary fs-16">${booking.flight_booking?.pnr || 'NOT ISSUED'}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <label class="fs-10 fw-800 text-muted uppercase mb-1 d-block">Service Class</label>
                                <div class="fw-900 text-navy fs-14">${booking.flight_booking?.cabin_class || 'Economy'}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        serviceSection.innerHTML = serviceHtml;

        let paxHtml = '';
        // Prioritize DB passengers, fallback to JSON travelers/paxes
        const paxes = (dbPassengers && dbPassengers.length > 0) ? dbPassengers : (details.paxes || details.travelers || []);
        
        paxes.forEach((p, idx) => {
            const firstName = p.first_name || p.name || 'Guest';
            const lastName = p.last_name || p.surname || '';
            const paxType = p.type || 'Adult';
            
            paxHtml += `
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                            <span class="fw-900 fs-10">${idx + 1}</span>
                        </div>
                        <div>
                            <div class="fw-800 text-navy fs-13">${(p.title || 'Mr')}. ${firstName} ${lastName}</div>
                            <div class="fs-10 fw-700 text-muted uppercase">Pax Type: ${paxType}</div>
                        </div>
                    </div>
                </div>
            `;
        });
        paxList.innerHTML = paxHtml || '<div class="col-12"><p class="text-muted p-3 border rounded-3 border-dashed text-center">No passenger manifest found for this reference.</p></div>';

        modal.show();
    }
</script>

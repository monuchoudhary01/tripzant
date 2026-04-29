@extends('layouts.app')

@section('title', 'Booking Confirmed | Tripzant')

@section('styles')
<style>
    :root {
        --trip-success: #10b981;
        --trip-blue: #005eb8;
        --trip-dark: #003366;
    }
    body { background: #f8fafc !important; }
    
    .confirmation-hero {
        background: linear-gradient(135deg, var(--trip-dark) 0%, var(--trip-blue) 100%);
        padding: 80px 0;
        color: white;
        border-radius: 0 0 50px 50px;
        margin-bottom: -50px;
    }
    
    .ticket-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(0,0,0,0.1);
        border: none;
    }
    
    .pnr-box {
        background: #f0f7ff;
        border: 2px dashed var(--trip-blue);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
    }
    
    .pnr-code {
        font-size: 32px;
        font-weight: 900;
        color: var(--trip-blue);
        letter-spacing: 4px;
    }
    
    .status-badge {
        background: #dcfce7;
        color: #15803d;
        padding: 8px 20px;
        border-radius: 100px;
        font-weight: 800;
        font-size: 12px;
        text-transform: uppercase;
    }
    
    .share-btn-wa {
        background: #25d366;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 15px;
        font-weight: 800;
        transition: 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .share-btn-wa:hover {
        background: #128c7e;
        color: white;
        transform: translateY(-2px);
    }
    
    .download-btn {
        background: var(--trip-dark);
        color: white;
        padding: 15px 30px;
        border-radius: 15px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    
    .timeline-dot {
        width: 12px;
        height: 12px;
        background: var(--trip-blue);
        border-radius: 50%;
        position: relative;
        z-index: 2;
    }

    /* Professional Print Override */
    @media print {
        header, footer, nav, 
        .confirmation-hero, 
        .share-btn-wa, 
        .download-btn,
        .btn-link,
        .bg-white.d-inline-flex.p-3.rounded-circle { 
            display: none !important; 
        }
        
        body { background: white !important; padding: 0 !important; margin: 0 !important; }
        .container { max-width: 100% !important; width: 100% !important; padding: 0 !important; }
        .col-lg-8 { width: 100% !important; max-width: 100% !important; }
        
        .ticket-card {
            box-shadow: none !important;
            border: 1px solid #eee !important;
            border-radius: 0 !important;
            margin: 10mm !important;
            padding: 20px !important;
        }

        .pnr-box {
            background: #fff !important;
            border: 2px solid #005eb8 !important;
            -webkit-print-color-adjust: exact;
        }

        .status-badge {
            border: 1px solid #15803d !important;
            background: transparent !important;
            -webkit-print-color-adjust: exact;
        }

        .bg-light {
            background: #f8fafc !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
@endsection

@section('content')
<?php
    // Safety defaults — prevents undefined variable errors if controller omits these
    $apiTravelers = $apiTravelers ?? [];
    $reference    = $reference ?? ($booking->booking_reference ?? '');
    $dbPassengers = $dbPassengers ?? collect();
?>
<div class="confirmation-hero text-center">
    <div class="container">
        <div class="mb-4">
            <div class="bg-white d-inline-flex p-3 rounded-circle shadow-lg mb-4">
                <i class="fas fa-check-circle text-success fs-1"></i>
            </div>
        </div>
        <h1 class="fw-900 mb-2">Booking Confirmed!</h1>
        <p class="opacity-75 fs-5">
            @if(count($legs) > 2)
                Your multi-city journey starting from {{ $flight['departure_city'] ?? '???' }} is confirmed.
            @elseif(count($legs) == 2)
                Your round-trip journey from {{ $flight['departure_city'] ?? '???' }} to {{ $legs[1]['arrival_city'] ?? '???' }} is ready.
            @else
                Your one-way flight from {{ $flight['departure_city'] ?? '???' }} to {{ $flight['arrival_city'] ?? '???' }} is ready.
            @endif
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="ticket-card p-5">
                <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                    <div>
                        <div class="small fw-bold text-muted mb-1">BOOKING STATUS</div>
                        <span class="status-badge">Confirmed & Ticketed</span>
                    </div>
                    <div class="text-end">
                        <div class="small fw-bold text-muted mb-1">TRANSACTION ID</div>
                        <div class="fw-900">#{{ $booking->booking_reference ?? 'N/A' }}</div>
                    </div>
                </div>

                @foreach($legs as $idx => $leg)
                @php 
                    $legDepCity = $leg['departure_city'] ?? ($leg['dep_city'] ?? '???');
                    $legArrCity = $leg['arrival_city'] ?? ($leg['arr_city'] ?? '???');
                    $legDepTime = $leg['departure_at'] ?? ($leg['dep_time'] ?? now());
                    $legArrTime = $leg['arrival_at'] ?? ($leg['arr_time'] ?? now()->addHours(2));
                @endphp
                <div class="row g-5 align-items-center {{ $idx < count($legs) - 1 ? 'mb-4 border-bottom pb-4' : 'mb-5' }}">
                    <div class="col-md-4">
                        <div class="pnr-box">
                            <div class="x-small fw-900 text-muted uppercase mb-2">
                                @if(count($legs) > 2)
                                    SEGMENT {{ $idx + 1 }} PNR
                                @else
                                    {{ $idx === 0 ? 'Airline PNR' : 'Return PNR' }}
                                @endif
                            </div>
                            <div class="pnr-code">{{ $pnrs[$idx] ?? $pnr ?? '------' }}</div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center px-4">
                            <div class="text-start">
                                <h3 class="fw-900 mb-0">{{ $legDepCity }}</h3>
                                <div class="small fw-bold text-muted">{{ date('H:i', strtotime($legDepTime)) }}</div>
                                <div class="x-small text-muted">{{ date('D, d M Y', strtotime($legDepTime)) }}</div>
                            </div>
                            
                            <div class="flex-grow-1 px-4 text-center position-relative">
                                <div style="height: 2px; background: #e2e8f0; width: 100%; position: absolute; top: 50%; left: 0;"></div>
                                <i class="fas fa-plane text-primary bg-white px-2 position-relative z-index-2 {{ $idx > 0 && count($legs) > 1 ? 'fa-flip-horizontal' : '' }}"></i>
                            </div>

                            <div class="text-end">
                                <h3 class="fw-900 mb-0">{{ $legArrCity }}</h3>
                                <div class="small fw-bold text-muted">{{ date('H:i', strtotime($legArrTime)) }}</div>
                                <div class="x-small text-muted">{{ date('D, d M Y', strtotime($legArrTime)) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- ✈️ Flight Details Section --}}
                <div class="bg-light rounded-4 p-4 mb-4">
                    <h6 class="fw-900 text-navy mb-4">
                        <i class="fas fa-plane me-2"></i> Flight Details
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">AIRLINE</div>
                            <div class="fw-900">{{ $flight['airline_name'] ?? ($flight['airline'] ?? 'N/A') }}</div>
                            <div class="x-small text-muted">{{ $flight['airline_code'] ?? '' }} {{ $flight['flight_number'] ?? '' }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">CABIN</div>
                            <div class="fw-900">{{ ucfirst(strtolower($flight['cabin'] ?? 'Economy')) }}</div>
                            <div class="x-small text-muted">{{ $flight['fare_class'] ?? 'E' }} Class</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">DURATION</div>
                            <div class="fw-900">{{ $flight['duration'] ?? 'N/A' }}</div>
                            <div class="x-small text-muted">{{ ($flight['number_of_changes'] ?? 0) == 0 ? 'Non-stop' : ($flight['number_of_changes'].' Stop(s)') }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">BAGGAGE</div>
                            <div class="fw-900">{{ $flight['baggage'] ?? '15' }}{{ $flight['baggage_unit'] ?? 'KG' }}</div>
                            <div class="x-small text-muted">Check-in included</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">FARE TYPE</div>
                            <div class="fw-900 {{ ($flight['is_refundable'] ?? false) ? 'text-success' : 'text-danger' }}">
                                {{ ($flight['is_refundable'] ?? false) ? 'Refundable' : 'Non-Refundable' }}
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">BOOKING DATE</div>
                            <div class="fw-900">{{ $booking->created_at ? date('M d, Y', strtotime($booking->created_at)) : 'N/A' }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">TOTAL PAID</div>
                            <div class="fw-900 text-primary fs-5">₹{{ number_format($booking->total_amount ?? 0) }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="x-small text-muted fw-bold mb-1">CURRENCY</div>
                            <div class="fw-900">{{ $booking->currency ?? 'INR' }}</div>
                        </div>
                    </div>
                </div>

                {{-- 👥 Passenger Manifest --}}
                <div class="bg-light rounded-4 p-4 mb-5">
                    <h6 class="fw-900 text-navy mb-4"><i class="fas fa-users me-2"></i> Passenger Manifest</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="x-small fw-900 text-muted uppercase">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Seat</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dbPassengers ?? [] as $tIdx => $p)
                                <tr>
                                    <td><span class="fw-900 text-muted">{{ $tIdx + 1 }}</span></td>
                                    <td>
                                        <div class="fw-900">{{ $p->first_name ?? 'Guest' }} {{ $p->last_name ?? '' }}</div>
                                        <div class="x-small text-muted fw-bold">{{ $p->title ?? 'Mr' }} · Adult</div>
                                    </td>
                                    <td>
                                        @php
                                            $contact = $apiTravelers[$tIdx] ?? null;
                                            $contactEmail  = $contact['email']  ?? ($booking->user->email ?? '—');
                                            $contactMobile = $contact['mobile'] ?? '—';
                                        @endphp
                                        <div class="x-small fw-bold">{{ $contactEmail }}</div>
                                        <div class="x-small text-muted fw-bold">
                                            <i class="fas fa-phone fa-xs me-1 text-primary"></i>{{ $contactMobile }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-900 text-primary">
                                            @if($p->seat_number)
                                                @php 
                                                    $seatParts = explode(' | ', $p->seat_number);
                                                @endphp
                                                @foreach($seatParts as $sp)
                                                    <span class="badge bg-primary text-white me-1 px-2 py-1 rounded-3" style="font-size: 10px;">{{ $sp }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Auto</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        <span class="x-small fw-900 text-success">ALLOCATED</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted fw-bold py-4">
                                        <i class="fas fa-user-slash me-2"></i>No passenger data found for this booking.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row g-4 pt-4 border-top">
                    <div class="col-md-6">
                        <a href="{{ route('booking.pdf', ['reference' => $reference ?? ($booking->booking_reference ?? '')]) }}" class="download-btn w-100 justify-content-center">
                            <i class="fas fa-file-pdf"></i> DOWNLOAD E-TICKET (PDF)
                        </a>
                    </div>
                    @if(config('services.whatsapp.access'))
                    <div class="col-md-6">
                        <a href="{{ route('booking.whatsapp', ['reference' => $booking->booking_reference]) }}" class="share-btn-wa w-100 justify-content-center">
                            <i class="fab fa-whatsapp"></i> SEND TICKET ON WHATSAPP
                        </a>
                    </div>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-4 rounded-3 fw-bold x-small">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-4 rounded-3 fw-bold x-small">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                @endif
                </div>
            </div>
            
            <div class="mt-5 text-center">
                <a href="/flights" class="btn btn-link text-muted fw-bold text-decoration-none">
                    <i class="fas fa-arrow-left me-2"></i> RETURN TO HOME
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Trigger Confetti
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#005eb8', '#003366', '#10b981']
        });

        // Clear stale localStorage data
        localStorage.removeItem('selected_seats_multi');
        localStorage.removeItem('selected_addons');
    });
</script>
@endsection

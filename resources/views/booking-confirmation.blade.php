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
<div class="confirmation-hero text-center">
    <div class="container">
        <div class="mb-4">
            <div class="bg-white d-inline-flex p-3 rounded-circle shadow-lg mb-4">
                <i class="fas fa-check-circle text-success fs-1"></i>
            </div>
        </div>
        <h1 class="fw-900 mb-2">Booking Confirmed!</h1>
        <p class="opacity-75 fs-5">
            @if(count($legs) > 1)
                Your round-trip journey from {{ $flight['departure_city'] }} to {{ $legs[count($legs)-1]['arrival_city'] ?? $legs[1]['arrival_city'] ?? '???' }} is ready.
            @else
                Your journey from {{ $flight['departure_city'] }} to {{ $flight['arrival_city'] }} is ready.
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
                            <div class="x-small fw-900 text-muted uppercase mb-2">{{ $idx === 0 ? 'Airline PNR' : 'Return PNR' }}</div>
                            <div class="pnr-code">{{ $pnrs[$idx] ?? $pnr ?? '------' }}</div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center px-4">
                            <div class="text-start">
                                <h3 class="fw-900 mb-0">{{ $legDepCity }}</h3>
                                <div class="small fw-bold text-muted">{{ date('H:i', strtotime($legDepTime)) }}</div>
                                <div class="x-small text-muted">{{ date('D, M d', strtotime($legDepTime)) }}</div>
                            </div>
                            
                            <div class="flex-grow-1 px-4 text-center position-relative">
                                <div style="height: 2px; background: #e2e8f0; width: 100%; position: absolute; top: 50%; left: 0;"></div>
                                <i class="fas fa-plane text-primary bg-white px-2 position-relative z-index-2 {{ $idx > 0 && count($legs) > 1 ? 'fa-flip-horizontal' : '' }}"></i>
                            </div>

                            <div class="text-end">
                                <h3 class="fw-900 mb-0">{{ $legArrCity }}</h3>
                                <div class="small fw-bold text-muted">{{ date('H:i', strtotime($legArrTime)) }}</div>
                                <div class="x-small text-muted">{{ date('D, M d', strtotime($legArrTime)) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="bg-light rounded-4 p-4 mb-5">
                    <h6 class="fw-900 text-navy mb-4"><i class="fas fa-users me-2"></i> Passenger Manifest</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="x-small fw-900 text-muted uppercase">
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Seat</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($booking->items))
                                @foreach($booking->items as $item)
                                    @php $details = json_decode($item->details, true); @endphp
                                    @if(is_array($details))
                                    @foreach($details as $p)
                                    <tr>
                                        <td>
                                            <div class="fw-900">{{ $p['first_name'] ?? 'Guest' }} {{ $p['last_name'] ?? '' }}</div>
                                            <div class="x-small text-muted fw-bold">{{ $p['title'] ?? 'Mr' }}</div>
                                        </td>
                                        <td><span class="badge bg-white text-navy border font-monospace x-small">ADT</span></td>
                                        <td><div class="fw-900 text-primary">{{ $p['seat'] ?? 'Auto' }}</div></td>
                                        <td class="text-end"><i class="fas fa-check-circle text-success me-1"></i> <span class="x-small fw-900 text-success">ALLOCATED</span></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row g-4 pt-4 border-top">
                    <div class="col-md-6">
                        <a href="javascript:window.print()" class="download-btn w-100 justify-content-center">
                            <i class="fas fa-file-pdf"></i> DOWNLOAD E-TICKET (PDF)
                        </a>
                    </div>
                    <div class="col-md-6">
                        @php
                            $msgName = $flight['airline_name'] ?? 'Flight';
                            $msgDep = $flight['departure_city'] ?? 'Origin';
                            $msgArr = $flight['arrival_city'] ?? 'Dest';
                            $msg = "Hey! My booking with Tripzant is confirmed. PNR: " . ($pnr ?? '---') . " for $msgName ($msgDep to $msgArr).";
                            $waUrl = "https://wa.me/?text=" . urlencode($msg);
                        @endphp
                        <a href="{{ $waUrl }}" target="_blank" class="share-btn-wa w-100 justify-content-center">
                            <i class="fab fa-whatsapp"></i> SHARE ON WHATSAPP
                        </a>
                    </div>
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

        // Patch Seats from LocalStorage (Since this is a client-side flow demo)
        const seatsMulti = JSON.parse(localStorage.getItem('selected_seats_multi') || '{}');
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach((row, pIdx) => {
            const seatCell = row.querySelector('.text-primary');
            if (seatCell) {
                // Find seat for Leg 0 for this passenger
                const seatData = seatsMulti[0] ? seatsMulti[0][pIdx] : null;
                if (seatData && seatData.seatId) {
                    seatCell.innerText = seatData.seatId;
                }
            }
        });

        // Clear selection to prevent stale data in next booking
        localStorage.removeItem('selected_seats_multi');
        localStorage.removeItem('selected_addons');
    });
</script>
@endsection

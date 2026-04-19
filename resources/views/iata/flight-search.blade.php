@extends('layouts.iata_panel')

@section('title', 'Amadeus B2B | Flight Search')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-800 text-navy mb-1 outfit">Book Individual / Group Flights</h4>
            <p class="text-muted fw-600 mb-0">Search across 700+ airlines worldwide via Amadeus GDS</p>
        </div>
        <div class="bg-white p-2 rounded-pill shadow-sm border d-flex gap-2">
            <button class="btn btn-iata rounded-pill py-2 px-4 small outfit active" id="btnOneWay">ONE WAY</button>
            <button class="btn btn-white rounded-pill py-2 px-4 small outfit text-muted" id="btnRoundTrip">ROUND TRIP</button>
            <button class="btn btn-white rounded-pill py-2 px-4 small outfit text-muted" id="btnMultiCity">MULTI CITY</button>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm rounded-4 bg-white p-5 border border-light position-relative overflow-hidden">
        <!-- Decoration -->
        <div class="position-absolute top-0 end-0 p-4 opacity-10">
            <i class="fas fa-plane-departure" style="font-size: 120px; transform: rotate(15deg);"></i>
        </div>

        <form action="{{ route('iata.flight.availability') }}" method="GET" class="position-relative">
            <div class="row g-4 mb-5">
                <div class="col-xl-6">
                    <div class="row g-0 rounded-4 overflow-hidden border">
                        <div class="col-md-6 border-end">
                            <div class="p-3 bg-white">
                                <label class="form-label small fw-800 text-muted uppercase mb-1">Origin City</label>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <div>
                                        <input type="text" class="form-control border-0 p-0 fw-800 text-navy fs-5" placeholder="From where?" value="New Delhi (DEL)">
                                        <div class="text-muted fw-600" style="font-size: 11px;">Indira Gandhi Intl Airport</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <button type="button" class="btn btn-white border shadow-sm rounded-circle position-absolute top-50 start-0 translate-middle z-3" style="width: 36px; height: 36px; padding: 0;">
                                <i class="fas fa-exchange-alt text-primary"></i>
                            </button>
                            <div class="p-3 bg-white h-100">
                                <label class="form-label small fw-800 text-muted uppercase mb-1">Destination</label>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-plane-arrival text-primary"></i>
                                    <div>
                                        <input type="text" class="form-control border-0 p-0 fw-800 text-navy fs-5" placeholder="To where?" value="Mumbai (BOM)">
                                        <div class="text-muted fw-600" style="font-size: 11px;">Chhatrapati Shivaji Intl</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row g-0 rounded-4 overflow-hidden border">
                        <div class="col-md-6 border-end">
                            <div class="p-3 bg-white">
                                <label class="form-label small fw-800 text-muted uppercase mb-1">Departure Date</label>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-calendar-day text-primary"></i>
                                    <div>
                                        <input type="text" class="form-control border-0 p-0 fw-800 text-navy fs-5" value="12 Apr 2026">
                                        <div class="text-muted fw-600" style="font-size: 11px;">Sunday</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 bg-light" id="returnDateArea">
                            <div class="p-3 h-100 border-start bg-light" style="cursor: pointer;">
                                <label class="form-label small fw-800 text-muted uppercase mb-1">Return Date</label>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-calendar-alt text-muted"></i>
                                    <div class="fw-700 text-muted opacity-50">Select Return</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 align-items-center">
                <div class="col-md-3">
                    <div class="border rounded-4 p-3 bg-white">
                        <label class="form-label small fw-800 text-muted uppercase mb-1">Travellers & Cabin</label>
                        <div class="d-flex align-items-center gap-2">
                             <i class="fas fa-users text-primary"></i>
                             <div class="fw-800 text-navy">01 Adult, Economy</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="directOnly">
                            <label class="form-check-label small fw-700" for="directOnly">Direct Flights Only</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="refundableOnly">
                            <label class="form-check-label small fw-700" for="refundableOnly">Refundable Fares Only</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="nearbyAirports">
                        <label class="form-check-label small fw-700" for="nearbyAirports">Include Nearby</label>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-iata w-100 py-3 rounded-4 outfit fs-5 shadow-sm">
                       <i class="fas fa-search me-2"></i> SEARCH SYSTEM
                    </button>
                    <div class="mt-2 small text-muted fw-600">Showing fares with your agency markup automatically applied.</div>
                </div>
            </div>
        </form>
    </div>

    <!-- Recent Searches -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-800 text-navy outfit uppercase tracking-wider small mb-0">Recent Search Activity</h6>
            <a href="#" class="text-primary fw-800 small text-decoration-none">Clear History</a>
        </div>
        <div class="row g-3">
            @php
            $recents = [
                ['from' => 'DEL', 'from_full' => 'Delhi', 'to' => 'DXB', 'to_full' => 'Dubai', 'date' => '15 Apr', 'pax' => '1 Adult', 'class' => 'Economy', 'icon' => 'fas fa-globe-asia'],
                ['from' => 'BOM', 'from_full' => 'Mumbai', 'to' => 'LHR', 'to_full' => 'London', 'date' => '22 Apr', 'pax' => '2 Adults', 'class' => 'Business', 'icon' => 'fas fa-landmark'],
                ['from' => 'BLR', 'from_full' => 'Bangalore', 'to' => 'SIN', 'to_full' => 'Singapore', 'date' => '10 May', 'pax' => '1 Adult', 'class' => 'Economy', 'icon' => 'fas fa-city'],
            ];
            @endphp
            @foreach($recents as $r)
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 border border-light shadow-sm position-relative overflow-hidden h-100 hover-lift transition-all">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stats-icon bg-blue-soft text-primary" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="{{ $r['icon'] }}"></i>
                        </div>
                        <div class="badge bg-light text-muted border py-2 px-3 fw-800" style="font-size: 10px;">{{ $r['class'] }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="text-center">
                            <div class="fw-800 text-navy h5 mb-0">{{ $r['from'] }}</div>
                            <div class="text-muted small fw-600">{{ $r['from_full'] }}</div>
                        </div>
                        <div class="flex-grow-1 border-bottom border-dashed mx-2 position-relative" style="height: 1px;">
                            <i class="fas fa-plane position-absolute top-50 start-50 translate-middle text-primary opacity-25" style="font-size: 10px;"></i>
                        </div>
                        <div class="text-center">
                            <div class="fw-800 text-navy h5 mb-0">{{ $r['to'] }}</div>
                            <div class="text-muted small fw-600">{{ $r['to_full'] }}</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <div class="text-muted small fw-700">
                             <i class="fas fa-calendar-alt me-1"></i> {{ $r['date'] }} | {{ $r['pax'] }}
                        </div>
                        <a href="#" class="btn btn-link p-0 text-decoration-none fw-800 small text-primary uppercase" style="font-size: 11px;">Re-Search</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
    .border-dashed { border-style: dashed !important; }
    .tracking-wider { letter-spacing: 1.5px; }
    .fs-xs { font-size: 10px; }
    input:focus { outline: none !important; box-shadow: none !important; }
    .btn-iata.active { background: var(--iata-blue); color: white; }
</style>
@endsection

@endsection

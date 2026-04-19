@extends('layouts.iata_panel')

@section('title', 'Amadeus B2B | Flight Availability')

@section('iata_content')
<div class="mb-5">
    <!-- Top Search Summary -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4 border border-light">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-4">
                    <div class="stats-icon bg-blue-soft text-primary mb-0" style="width: 48px; height: 48px;">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <div>
                        <div class="fw-800 text-navy h4 mb-0 outfit">DEL → BOM <span class="text-muted fw-600 h6 ms-2">(New Delhi to Mumbai)</span></div>
                        <div class="text-muted fw-700 uppercase" style="font-size: 11px;">
                            <i class="fas fa-calendar-alt me-1"></i> 12 Apr 2026 | 01 Adult | Economy Class
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('iata.flight.search') }}" class="btn btn-light rounded-pill px-4 fw-800 border-0 shadow-sm small text-primary">
                    <i class="fas fa-edit me-2"></i> MODIFY SEARCH
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Filters Bar -->
    <div class="row g-3 mb-4">
        @php
        $filters = [
            ['label' => 'Cheapest', 'price' => '₹5,180', 'time' => '11:45 AM', 'icon' => 'fas fa-tag', 'active' => false],
            ['label' => 'Fastest', 'price' => '₹6,450', 'time' => '2h 10m', 'icon' => 'fas fa-bolt', 'active' => true],
            ['label' => 'Earliest', 'price' => '₹7,100', 'time' => '05:30 AM', 'icon' => 'fas fa-sun', 'active' => false],
        ];
        @endphp
        @foreach($filters as $f)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 border {{ $f['active'] ? 'border-primary' : 'border-light' }} bg-white h-100 hover-lift cursor-pointer">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-800 text-navy outfit">{{ $f['label'] }}</div>
                        <div class="h5 fw-800 text-primary mb-0 outfit">{{ $f['price'] }}</div>
                    </div>
                    <div class="stats-icon {{ $f['active'] ? 'bg-primary text-white' : 'bg-light text-muted' }} mb-0" style="width: 34px; height: 34px; font-size: 12px;">
                        <i class="{{ $f['icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100 sticky-top" style="top: 100px; z-index: 100;">
                <h6 class="fw-800 text-navy mb-4 outfit uppercase small tracking-wider">Refine Selection</h6>
                
                <div class="mb-5">
                    <label class="form-label small fw-800 text-muted uppercase mb-3">No. of Stops</label>
                    <div class="d-flex flex-column gap-2">
                        <label class="filter-check d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-center gap-2 fw-700 small text-navy"><input type="checkbox" checked> Non-stop</span>
                            <span class="text-muted small fw-600">₹5,180</span>
                        </label>
                        <label class="filter-check d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-center gap-2 fw-700 small text-navy"><input type="checkbox"> 1 Stop</span>
                            <span class="text-muted small fw-600">₹7,200</span>
                        </label>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label small fw-800 text-muted uppercase mb-3">Departure Time</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-light border w-100 p-2 rounded-3 text-navy small fw-700">
                                 <i class="fas fa-mountain small d-block mb-1"></i> Before 6AM
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-light border w-100 p-2 rounded-3 text-navy small fw-700 active bg-blue-soft border-primary">
                                 <i class="fas fa-sun small d-block mb-1"></i> 6AM - 12PM
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label small fw-800 text-muted uppercase mb-3">Popular Airlines</label>
                    <div class="d-flex flex-column gap-2">
                         <label class="d-flex align-items-center gap-2 fw-700 small text-navy"><input type="checkbox" checked> IndiGo <span class="ms-auto text-muted fw-600">(12)</span></label>
                         <label class="d-flex align-items-center gap-2 fw-700 small text-navy"><input type="checkbox" checked> Air India <span class="ms-auto text-muted fw-600">(8)</span></label>
                         <label class="d-flex align-items-center gap-2 fw-700 small text-navy"><input type="checkbox"> Vistara <span class="ms-auto text-muted fw-600">(4)</span></label>
                    </div>
                </div>

                <div class="mb-0 mt-auto pt-4 border-top">
                    <button class="btn btn-white w-100 fw-800 small border rounded-pill py-2">Reset All</button>
                </div>
            </div>
        </div>

        <!-- Flight Results -->
        <div class="col-xl-9">
            <div class="d-flex flex-column gap-3">
                @php
                $flights = [
                    ['airline' => 'Air India', 'code' => 'AI-102', 'dep' => '07:30', 'arr' => '09:45', 'dur' => '2h 15m', 'price' => '₹6,250', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/d/da/Air_India_Logo.svg', 'bag' => '25kg', 'fare' => 'Refundable'],
                    ['airline' => 'IndiGo', 'code' => '6E-284', 'dep' => '08:45', 'arr' => '11:00', 'dur' => '2h 15m', 'price' => '₹5,180', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/e0/IndiGo_Airlines_logo.svg', 'bag' => '15kg', 'fare' => 'Saver'],
                    ['airline' => 'Vistara', 'code' => 'UK-884', 'dep' => '10:15', 'arr' => '12:30', 'dur' => '2h 15m', 'price' => '₹7,420', 'logo' => 'https://upload.wikimedia.org/wikipedia/en/2/23/Vistara_logo.png', 'bag' => '30kg', 'fare' => 'Flexi'],
                    ['airline' => 'Air India', 'code' => 'AI-208', 'dep' => '13:00', 'arr' => '15:15', 'dur' => '2h 15m', 'price' => '₹6,250', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/d/da/Air_India_Logo.svg', 'bag' => '25kg', 'fare' => 'Refundable'],
                ];
                @endphp

                @foreach($flights as $f)
                <div class="card border-0 shadow-sm rounded-4 bg-white p-0 border border-light overflow-hidden flight-row-premium">
                    <div class="p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stats-icon bg-light rounded-3 p-1" style="width: 50px; height: 50px;">
                                        <img src="{{ $f['logo'] }}" alt="{{ $f['airline'] }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>
                                    <div>
                                        <div class="fw-800 text-navy outfit" style="font-size: 14px;">{{ $f['airline'] }}</div>
                                        <div class="text-muted fw-700 uppercase" style="font-size: 10px;">{{ $f['code'] }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="d-flex align-items-center justify-content-between text-center px-4">
                                    <div class="text-start">
                                        <div class="h4 fw-800 mb-0 outfit text-navy">{{ $f['dep'] }}</div>
                                        <div class="text-muted small fw-700 uppercase">New Delhi</div>
                                    </div>
                                    <div class="flex-grow-1 px-4 text-center position-relative">
                                        <div class="text-primary small fw-800 mb-1" style="font-size: 10px;">{{ $f['dur'] }}</div>
                                        <div style="height: 2px; background: #e2e8f0; width: 100%; position: relative;">
                                            <i class="fas fa-plane position-absolute top-50 start-50 translate-middle text-primary" style="font-size: 14px; background: #fff; padding: 2px;"></i>
                                        </div>
                                        <div class="text-muted uppercase fw-700 mt-1" style="font-size: 9px;">Direct</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="h4 fw-800 mb-0 outfit text-navy">{{ $f['arr'] }}</div>
                                        <div class="text-muted small fw-700 uppercase">Mumbai</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center border-start">
                                <div class="badge bg-green-soft text-success border border-success border-opacity-10 mb-1 px-3 py-2 fw-700 uppercase" style="font-size: 9px;">
                                     <i class="fas fa-briefcase me-1"></i> {{ $f['bag'] }} Check-in
                                </div>
                                <div class="text-muted small fw-700 uppercase" style="font-size: 10px;">{{ $f['fare'] }}</div>
                            </div>
                            <div class="col-md-3 text-end border-start ps-4">
                                <div class="h3 fw-800 mb-0 outfit text-navy">{{ $f['price'] }}</div>
                                <div class="text-muted small fw-700 mb-3" style="font-size: 10px;">Agency Fare Applied</div>
                                <a href="{{ route('iata.flight.create-pnr') }}" class="btn btn-iata rounded-4 w-100 py-2 outfit shadow-sm">BOOK FLIGHT</a>
                            </div>
                        </div>
                    </div>
                    <!-- Detailed Info Bar -->
                    <div class="bg-light px-4 py-2 border-top d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-4">
                            <a href="#" class="text-primary fw-800 x-small text-decoration-none">FLIGHT DETAILS</a>
                            <a href="#" class="text-muted fw-700 x-small text-decoration-none">FARE POLICY</a>
                            <a href="#" class="text-muted fw-700 x-small text-decoration-none">BAGGAGE INFO</a>
                        </div>
                        <div class="text-success small fw-800 outfit">
                             <i class="fas fa-check-circle me-1"></i> 8 Seats Remaining
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-5 text-center">
                 <button class="btn btn-white border px-5 py-3 rounded-pill fw-800 text-muted shadow-sm uppercase small">Load More Results</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .flight-row-premium { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f1f5f9 !important; }
    .flight-row-premium:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(0,0,0,0.06) !important; border-color: var(--iata-blue-light) !important; }
    .bg-blue-soft { background-color: #eff6ff; }
    .cursor-pointer { cursor: pointer; }
    .hover-lift:hover { transform: translateY(-3px); border-color: var(--iata-blue) !important; }
    .x-small { font-size: 11px; }
    .stats-icon { display: flex; align-items: center; justify-content: center; border-radius: 12px; }
</style>
@endsection

@endsection

@section('styles')
<style>
    .flight-row {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .flight-row:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
        border-color: var(--iata-blue-light) !important;
    }
</style>
@endsection

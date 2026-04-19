@extends('layouts.app')

@section('title', "Flight Availability — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f1f5f9; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="search" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Flight Search Summary Bar -->
            <div class="bg-navy text-white rounded-5 p-4 py-3 mb-5 shadow-lg d-flex justify-content-between align-items-center animate-up">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white-subtle rounded-4 p-2 px-3 text-center">
                        <span class="d-block x-small uppercase fw-bold opacity-75">DEL</span>
                        <span class="fw-900 border-bottom border-light">Delhi</span>
                    </div>
                    <i class="fas fa-exchange-alt"></i>
                    <div class="bg-white-subtle rounded-4 p-2 px-3 text-center">
                        <span class="d-block x-small uppercase fw-bold opacity-75">BOM</span>
                        <span class="fw-900 border-bottom border-light">Mumbai</span>
                    </div>
                    <div class="ms-4 border-start border-light border-2 ps-4 py-1">
                        <span class="d-block x-small uppercase fw-bold opacity-75">18 APR, 2026</span>
                        <span class="fw-900">1 Adult, Economy</span>
                    </div>
                </div>
                <button class="btn btn-warning rounded-pill x-small fw-900 px-4 py-2 uppercase shadow-sm" onclick="history.back()">MODES <i class="fas fa-search ms-1"></i></button>
            </div>

            <!-- Main Results Column -->
            <div class="row g-5 mt-4">
                <div class="col-xl-3">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 sticky-top" style="top: 100px; z-index: 10;">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Filters & GDS Yield</h6>
                        <div class="mb-5">
                            <label class="x-small fw-900 text-muted uppercase mb-3">GLOBAL MARGIN CAP (%)</label>
                            <input type="range" class="form-range" value="5" min="0" max="15">
                            <div class="d-flex justify-content-between mt-1"><span class="x-small fw-bold">0%</span><span class="x-small fw-bold">15%</span></div>
                        </div>
                        <div class="d-flex flex-column gap-4">
                            <div class="label-check d-flex align-items-center gap-3">
                                <input type="checkbox" id="direct" checked>
                                <label for="direct" class="small fw-bold text-navy">Non-Stop Flights</label>
                            </div>
                            <div class="label-check d-flex align-items-center gap-3">
                                <input type="checkbox" id="refundable">
                                <label for="refundable" class="small fw-bold text-navy">Refundable only</label>
                            </div>
                            <div class="label-check d-flex align-items-center gap-3">
                                <input type="checkbox" id="amadeus" checked>
                                <label for="amadeus" class="small fw-bold text-navy">Amadeus Real-Time</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="d-flex flex-column gap-4">
                       @php
                       $flights = [
                           ['airline' => 'IndiGo', 'code' => '6E-242', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/af/IndiGo_Airlines_logo.svg', 'dep' => '06:15', 'arr' => '08:30', 'net' => 4250],
                           ['airline' => 'Air India', 'code' => 'AI-805', 'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/30/Air_India_Logo.svg/1200px-Air_India_Logo.svg.png', 'dep' => '09:00', 'arr' => '11:15', 'net' => 5400],
                           ['airline' => 'Vistara', 'code' => 'UK-943', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Vistara_Logo.svg', 'dep' => '14:30', 'arr' => '16:45', 'net' => 6100],
                           ['airline' => 'Akasa Air', 'code' => 'QP-112', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Akasa_Air_Logo.svg', 'dep' => '19:45', 'arr' => '22:00', 'net' => 3850],
                       ];
                       @endphp

                       @foreach($flights as $f)
                       <div class="flight-card bg-white rounded-5 shadow-sm p-5 border-0 hover-up-md transition-all">
                            <div class="row align-items-center g-4">
                                <!-- Airline -->
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <img src="{{ $f['logo'] }}" height="32" class="mb-3 grayscale" alt="">
                                        <h6 class="fw-900 text-navy mb-0 small">{{ $f['airline'] }}</h6>
                                        <span class="x-small text-muted fw-bold opacity-75">{{ $f['code'] }}</span>
                                    </div>
                                </div>
                                
                                <!-- Timeline -->
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between align-items-center text-center px-4">
                                        <div>
                                            <h4 class="fw-900 text-navy mb-1">{{ $f['dep'] }}</h4>
                                            <span class="x-small text-muted fw-bold uppercase">DEL</span>
                                        </div>
                                        <div class="flex-grow-1 px-4 text-center">
                                            <div class="small fw-bold text-muted mb-2 opacity-50">2h 15m</div>
                                            <div class="timeline-line bg-light position-relative" style="height:2px; width:100%;">
                                                <div class="dot bg-navy rounded-circle" style="width:8px; height:8px; top:-3px; left:0; position:absolute;"></div>
                                                <i class="fas fa-plane text-navy" style="position:relative; top:-10px;"></i>
                                                <div class="dot bg-navy rounded-circle" style="width:8px; height:8px; top:-3px; right:0; position:absolute;"></div>
                                            </div>
                                            <div class="x-small text-green fw-bold mt-2 uppercase tracking-wide">Non-Stop</div>
                                        </div>
                                        <div>
                                            <h4 class="fw-900 text-navy mb-1">{{ $f['arr'] }}</h4>
                                            <span class="x-small text-muted fw-bold uppercase">BOM</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- B2B Net Fare + Margin Logic -->
                                <div class="col-md-3 border-start border-light ps-5">
                                    <div class="pricing-box">
                                        <span class="x-small fw-bold text-muted uppercase d-block mb-3">Live B2B Pricing Hub</span>
                                        <div class="mb-3">
                                            <span class="small fw-bold text-navy opacity-50">Net Fare (B2B):</span>
                                            <h5 class="fw-900 text-navy mb-1">₹{{ number_format($f['net']) }}</h5>
                                        </div>
                                        <div class="markup-input-group">
                                            <label class="x-small fw-900 text-primary uppercase mb-2">APPLY YOUR MARGIN (₹)</label>
                                            <div class="input-group border rounded-4 overflow-hidden p-1 bg-light">
                                                <span class="input-group-text bg-transparent border-0 fw-900 text-primary px-3">+</span>
                                                <input type="number" class="form-control bg-transparent border-0 fw-900 text-primary markup-input" data-net="{{ $f['net'] }}" value="500">
                                            </div>
                                            <div class="mt-3 bg-primary-light p-2 rounded-3 text-center border-dashed border-primary border-1">
                                                <span class="x-small fw-bold text-primary">Selling Price: <span class="selling-price-label">₹{{ number_format($f['net'] + 500) }}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action -->
                                <div class="col-md-2 text-end">
                                    <form action="{{ route('agent.b2b.pax-details') }}" method="GET">
                                        <input type="hidden" name="net_fare" value="{{ $f['net'] }}">
                                        <input type="hidden" name="flight_code" value="{{ $f['code'] }}">
                                        <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-sm">BOOK FLIGHT <i class="fas fa-chevron-right ms-1"></i></button>
                                    </form>
                                    <div class="mt-3 text-center">
                                         <a href="#" class="x-small text-muted text-decoration-none border-bottom">Fare Rules</a>
                                    </div>
                                </div>
                            </div>
                       </div>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.querySelectorAll('.markup-input').forEach(input => {
        input.addEventListener('input', function() {
            const net = parseInt(this.dataset.net);
            const margin = parseInt(this.value) || 0;
            const selling = net + margin;
            this.closest('.flight-card').querySelector('.selling-price-label').innerText = '₹' + selling.toLocaleString();
        });
    });
</script>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .bg-primary-light { background: rgba(37, 99, 235, 0.05); }
    .markup-input:focus { box-shadow: none; }
    .flight-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid transparent; }
    .flight-card:hover { transform: translateY(-8px); border-color: #0b3d6110; shadow: 0 20px 40px rgba(11, 61, 97, 0.05); }
    .grayscale { filter: grayscale(1); opacity: 0.8; transition: 0.3s; }
    .flight-card:hover .grayscale { filter: grayscale(0); opacity: 1; }
    .hover-up-md:hover { transform: translateY(-10px); transition: 0.3s; }
    .transition-all { transition: all 0.3s ease; }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

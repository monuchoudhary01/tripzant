@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-6">
            <h4 class="fw-800">Tour Builders & Agents</h4>
            <p class="text-muted small">Discover tour builders who need local experts for their itineraries.</p>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end gap-3 text-end">
             <div class="bg-primary bg-opacity-10 text-primary rounded-pill px-4 py-2 small fw-800">
                <i class="fas fa-handshake me-1"></i> PARTNERS: 08
             </div>
        </div>
    </div>

    <!-- Filters Row -->
    <div class="card border-0 p-3 mb-5 rounded-4 shadow-sm">
        <div class="row g-3 align-items-end">
            <div class="col-lg-3">
                <label class="form-label fw-700 small text-muted">REGION</label>
                <select class="form-select">
                    <option>Global Companies</option>
                    <option>Regional Players</option>
                    <option>Local Operators</option>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label fw-700 small text-muted">FOCUS AREA</label>
                <select class="form-select">
                    <option>Heritage & Culture</option>
                    <option>Adventure Sports</option>
                    <option>Corporate Events</option>
                    <option>Solo Backpacking</option>
                </select>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search small"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search companies...">
                </div>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary w-100 py-2 rounded-pill fw-800">Apply filters</button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @php
            $builders = [
                ['name' => 'TripAdvisor Experiences', 'focus' => 'Global Marketplace', 'rating' => '4.9', 'services' => 'Tours, Cabs, Guides', 'status' => 'Connect'],
                ['name' => 'MakeMyTrip Tours', 'focus' => 'Regional Leader', 'rating' => '4.8', 'services' => 'Full Packages', 'status' => 'Partnered'],
                ['name' => 'Intrepid India', 'focus' => 'Adventure Specialist', 'rating' => '5.0', 'services' => 'Offbeat Trails', 'status' => 'Connect'],
                ['name' => 'Travel Triangle', 'focus' => 'B2B Integrator', 'rating' => '4.7', 'services' => 'Custom Itineraries', 'status' => 'Connect'],
            ];
        @endphp

        @foreach($builders as $b)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 p-4 h-100 position-relative border-bottom border-4 {{ $b['status'] == 'Partnered' ? 'border-success' : 'border-primary' }}">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-light rounded-4 d-flex align-items-center justify-content-center p-3" style="width:60px; height:60px;">
                        <i class="fas fa-briefcase text-primary fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-800 mb-0">{{ $b['name'] }}</h6>
                        <span class="badge bg-light text-muted smaller fw-700">{{ $b['focus'] }}</span>
                    </div>
                    <div class="ms-auto">
                        <span class="small fw-800"><i class="fas fa-star text-warning"></i> {{ $b['rating'] }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="smaller fw-700 text-muted uppercase mb-2">SERVICES THEY NEED</h6>
                    <div class="d-flex flex-wrap gap-2">
                         @foreach(explode(', ', $b['services']) as $s)
                            <span class="badge bg-primary-light text-primary fw-700 smaller" style="font-size:9px;">{{ $s }}</span>
                         @endforeach
                    </div>
                </div>

                <div class="mt-auto pt-3 d-flex gap-2">
                    @if($b['status'] == 'Partnered')
                        <button class="btn btn-success w-100 rounded-pill fw-800 py-2 small"><i class="fas fa-check-circle me-1"></i> PARTNERED</button>
                    @else
                        <button class="btn btn-primary w-100 rounded-pill fw-800 py-2 small">SEND PROPOSAL</button>
                    @endif
                    <button class="btn btn-outline-custom rounded-pill fw-800 py-2 small px-4"><i class="fas fa-expand small"></i></button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .rounded-4 { border-radius: 12px !important; }
    .smaller { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

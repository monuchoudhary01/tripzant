@extends('layouts.app')

@section('title', "Portal Configuration — IATA Dashboard")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-iata-sidebar active="settings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Portal Configuration</h2>
                <p class="text-muted small fw-bold mb-0">Management of GDS nodes, Office IDs, and strategic partnership policies.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-5 fw-900 shadow-sm py-3">SAVE SETTINGS</button>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <h6 class="fw-900 text-navy mb-5 uppercase"><i class="fas fa-server me-3 text-primary"></i> GDS Connectivity Config</h6>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="x-small fw-bold text-muted uppercase mb-2">Primary GDS Node</label>
                            <select class="form-select border-light-subtle bg-light p-3 small fw-bold">
                                <option>Amadeus v3.4 (PROD)</option>
                                <option>Sabre Global (PROD)</option>
                                <option>Travelport Universal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="x-small fw-bold text-muted uppercase mb-2">Office ID (PCC)</label>
                            <input type="text" value="DEL1A21RT" class="form-control border-light-subtle bg-light p-3 small fw-bold" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="x-small fw-bold text-muted uppercase mb-2">Settlement Policy</label>
                        <select class="form-select border-light-subtle bg-light p-3 small fw-bold">
                            <option>Real-time (Hub Escrow Only)</option>
                            <option>Bi-weekly (15th & 30th)</option>
                            <option>Monthly (1st Week)</option>
                        </select>
                    </div>

                    <div class="p-4 bg-light border-start border-primary border-4 rounded-3 d-flex align-items-center gap-3">
                         <i class="fas fa-shield-halved text-primary fs-3"></i>
                         <p class="x-small text-muted mb-0 fw-bold italic">Settlement changes take 24 hours to propagate across global partnership nodes.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-navy text-white h-100 position-relative">
                    <h6 class="fw-900 mb-4 uppercase x-small">Network Visibility</h6>
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-bold opacity-75">Public Network Profile</span>
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                        </div>
                        <hr class="opacity-10 my-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-bold opacity-75">Show Profit Share Stats</span>
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                        </div>
                        <hr class="opacity-10 my-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-bold opacity-75">Auto-Accept Top Partners</span>
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox"></div>
                        </div>
                    </div>

                    <div class="mt-auto pt-5">
                        <div class="p-3 rounded-4 bg-white bg-opacity-10 text-center shadow-lg border border-white border-opacity-10">
                            <h6 class="fw-900 mb-1 small uppercase">IATA VERIFICATION</h6>
                            <p class="x-small opacity-50 mb-0 fw-bold">VALID UNTIL: 31 DEC 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-navy { background: #001f3f; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .form-check-input { background-color: rgba(255,255,255,0.1); border: none; }
    .form-check-input:checked { background-color: #3182ce; }
</style>
@endsection

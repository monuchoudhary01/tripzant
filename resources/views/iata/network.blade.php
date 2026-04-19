@extends('layouts.app')

@section('title', "Global IATA Network Search — Portal")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-iata-sidebar active="network" />

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-900 text-navy mb-1">Global Network Search</h2>
                <p class="text-muted small fw-bold mb-0">Discover and connect with verified IATA agents across 190+ countries.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm bg-white">
                    <i class="fas fa-filter me-2 shadow-sm"></i> Advanced Filters
                </button>
            </div>
        </div>

        <div class="search-bar-wrap mb-5">
            <div class="card border-0 shadow-sm rounded-pill p-2 ps-4 d-flex flex-row align-items-center bg-white">
                 <i class="fas fa-search text-muted me-3"></i>
                 <input type="text" class="form-control border-0 shadow-none flex-grow-1" placeholder="Search by Agency Name, IATA Code, or City (e.g. London, Dubai)...">
                 <button class="btn btn-primary rounded-pill px-5 fw-900">SEARCH AGENTS</button>
            </div>
        </div>

        <div class="row g-4">
            <!-- Agent Results -->
            <div class="col-xl-4 col-md-6">
                <div class="agent-card p-4 rounded-4 bg-white border-0 shadow-sm h-100 text-center animate-up">
                    <div class="agency-logo mb-3 mx-auto">S</div>
                    <h6 class="fw-900 text-navy mb-1">Skybound Travel Co.</h6>
                    <p class="x-small text-muted fw-bold mb-3"><i class="fas fa-location-dot me-1"></i> New York, USA</p>
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 x-small px-3 py-1">IATA: 99201A</span>
                        <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 x-small px-3 py-1">4.9 ★</span>
                    </div>
                    <button class="btn btn-navy w-100 rounded-pill fw-bold py-2">SEND CONNECTION REQUEST</button>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="agent-card p-4 rounded-4 bg-white border-0 shadow-sm h-100 text-center animate-up delay-1">
                    <div class="agency-logo mb-3 mx-auto bg-orange">G</div>
                    <h6 class="fw-900 text-navy mb-1">Global Jet Setters</h6>
                    <p class="x-small text-muted fw-bold mb-3"><i class="fas fa-location-dot me-1"></i> Dubai, UAE</p>
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 x-small px-3 py-1">IATA: 1102A</span>
                        <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 x-small px-3 py-1">4.5 ★</span>
                    </div>
                    <button class="btn btn-navy w-100 rounded-pill fw-bold py-2">SEND CONNECTION REQUEST</button>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="agent-card p-4 rounded-4 bg-white border-0 shadow-sm h-100 text-center animate-up delay-2">
                    <div class="agency-logo mb-3 mx-auto bg-green">E</div>
                    <h6 class="fw-900 text-navy mb-1">Euro Express Travel</h6>
                    <p class="x-small text-muted fw-bold mb-3"><i class="fas fa-location-dot me-1"></i> Paris, France</p>
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 x-small px-3 py-1">IATA: 8820B</span>
                        <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 x-small px-3 py-1">5.0 ★</span>
                    </div>
                    <button class="btn btn-navy w-100 rounded-pill fw-bold py-2">SEND CONNECTION REQUEST</button>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .agency-logo { width: 60px; height: 60px; background: #001f3f; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 900; }
    .bg-orange { background: #f6ad55; }
    .bg-green { background: #48bb78; }
    .agent-card { transition: 0.3s; border: 1px solid transparent !important; }
    .agent-card:hover { border-color: #001f3f !important; transform: translateY(-5px); }
</style>
@endsection

@extends('layouts.app')

@section('title', "Experience Packages — Tour Builder | Trip Zant")

@section('content')
<div class="tour-builder-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-tour-builder-sidebar active="packages" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Package Builder Center</h2>
                    <p class="text-muted small mb-0">Combine multiple experiences and stays into integrated travel packages.</p>
                </div>
                <button class="btn btn-purple rounded-pill px-5 fw-900 shadow-lg py-3 small">CREATE NEW PACKAGE <i class="fas fa-plus ms-2"></i></button>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-900 text-navy mb-0 uppercase tracking-wide">Family Adventure Package</h6>
                            <span class="badge bg-green text-white rounded-pill px-3 py-1 fw-bold">ACTIVE</span>
                        </div>
                        <p class="text-muted small mb-4">3 Experiences + 2 Night Stay in Panjim</p>
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <img src="https://images.unsplash.com/photo-1544551763-47a18411987c?q=80&w=150" class="rounded-circle shadow-sm" width="30" height="30" style="object-fit:cover;">
                            <img src="https://images.unsplash.com/photo-1548013146-72479768bbaa?q=80&w=150" class="rounded-circle shadow-sm" width="30" height="30" style="object-fit:cover;">
                            <img src="https://images.unsplash.com/photo-1544551763-8dd44758c2ae?q=80&w=150" class="rounded-circle shadow-sm" width="30" height="30" style="object-fit:cover;">
                            <span class="text-muted small fw-bold ms-1">+ stay</span>
                        </div>
                        <div class="fw-900 text-navy fs-4 mb-4">₹12,450 <span class="text-muted small fw-normal">per family</span></div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-purple flex-grow-1 rounded-pill fw-bold">Edit Bundle</button>
                            <button class="btn btn-sm btn-purple flex-grow-1 rounded-pill fw-bold">Manage Inventory</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .btn-purple { background: #6b46c1; color: #fff; }
    .btn-outline-purple { border: 1px solid #6b46c1; color: #6b46c1; }
    .bg-green { background: #22c55e !important; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

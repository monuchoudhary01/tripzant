@extends('layouts.app')

@section('title', "Manage Homestays — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <x-partner-sidebar active="homestays" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Villas & Homestays</h2>
                    <p class="text-muted small mb-0">Control your private property listings, seasonal availability, and guest rules.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addHomestayModal">
                   <i class="fas fa-plus me-2"></i> Register New Property
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                @foreach($homestays as $homestay)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <img src="{{ $homestay->image ?: 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400' }}" class="rounded-3 shadow-sm" width="100" height="70" style="object-fit:cover;">
                            <span class="badge {{ $homestay->status == 'Live' ? 'bg-green-light text-green' : 'bg-orange-light text-orange' }} rounded-pill px-3 py-2">{{ $homestay->status ?? 'Live' }}</span>
                        </div>
                        <h6 class="fw-900 text-navy mb-1">{{ $homestay->name }}</h6>
                        <p class="text-muted small mb-3"><i class="fas fa-location-dot me-1"></i> {{ $homestay->city }}, {{ $homestay->address }}</p>
                        <div class="fw-900 text-navy fs-5 mb-4">₹{{ number_format($homestay->price_per_night, 0) }}/night</div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold">Update Calendar</button>
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold text-danger border-0">Unlist</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div class="modal fade" id="addHomestayModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 24px;">
            <h4 class="fw-900 text-navy mb-4">Add Your Home to Trip Zant</h4>
            <form action="{{ route('partner.homestays.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Property Identifier Name</label>
                    <input type="text" name="name" class="form-control rounded-pill px-4" placeholder="e.g. Blue Lagoon Beach House" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Price per Night (Base)</label>
                        <input type="number" name="price_per_night" class="form-control rounded-pill px-4" placeholder="8500" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">City</label>
                        <input type="text" name="city" class="form-control rounded-pill px-4" placeholder="Goa" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Full Address</label>
                    <textarea name="address" class="form-control rounded-4 px-4 py-3" rows="2" placeholder="Street, landmark, etc."></textarea>
                </div>
                <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-bold mt-3">List Property</button>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-green-light { background: rgba(34, 197, 94, 0.1); }
    .text-green { color: #22c55e; }
    .bg-orange-light { background: rgba(249, 115, 22, 0.1); }
    .text-orange { color: #f97316; }
</style>
@endsection

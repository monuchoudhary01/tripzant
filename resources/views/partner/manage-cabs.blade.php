@extends('layouts.app')

@section('title', "Manage Cabs — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <x-partner-sidebar active="cabs" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Cab / Transport Fleet</h2>
                    <p class="text-muted small mb-0">Control your vehicle inventory, driver assignments, and trip pricing.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addCabModal">
                   <i class="fas fa-plus me-2"></i> Add New Vehicle
                </button>
            </div>

            <div class="row g-4">
                @php
                $cabs = [
                    ['model' => 'Toyota Innova Crysta', 'type' => '7 Seater SUV', 'price' => '₹18/km', 'status' => 'Available', 'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400'],
                    ['model' => 'Maruti Suzuki Swift Dzire', 'type' => '4 Seater Sedan', 'price' => '₹12/km', 'status' => 'On Trip', 'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=400'],
                ];
                @endphp

                @foreach($cabs as $cab)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <img src="{{ $cab['image'] }}" class="rounded-3 shadow-sm" width="100" height="70" style="object-fit:cover;">
                            <span class="badge {{ $cab['status'] == 'Available' ? 'bg-green-light text-green' : 'bg-orange-light text-orange' }} rounded-pill px-3 py-2">{{ $cab['status'] }}</span>
                        </div>
                        <h6 class="fw-900 text-navy mb-1">{{ $cab['model'] }}</h6>
                        <p class="text-muted small mb-3">{{ $cab['type'] }}</p>
                        <div class="fw-900 text-navy fs-5 mb-4">{{ $cab['price'] }}</div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold">Maintain</button>
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold text-red">Remove</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div class="modal fade" id="addCabModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 24px;">
            <h4 class="fw-900 text-navy mb-4">Register New Vehicle</h4>
            <form>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Vehicle Model</label>
                    <input type="text" class="form-control rounded-pill px-4" placeholder="e.g. Toyota Camry">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Rate per KM</label>
                    <input type="number" class="form-control rounded-pill px-4" placeholder="15">
                </div>
                <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-bold mt-3">Add to Fleet</button>
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

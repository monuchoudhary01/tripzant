@extends('layouts.app')

@section('title', "Manage Trains — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <x-partner-sidebar active="trains" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Train Ticket Inventory</h2>
                    <p class="text-muted small mb-0">Control your train ticket allocations, quotas, and special rates.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTrainModal">
                   <i class="fas fa-plus me-2"></i> Add Train Quota
                </button>
            </div>

            <div class="row g-4">
                @php
                $trains = [
                    ['number' => '12002', 'name' => 'Bhopal Shatabdi Express', 'class' => 'CC, EC', 'status' => 'Live', 'image' => 'https://images.unsplash.com/photo-1474487585635-9ed31ac993bc?w=400'],
                    ['number' => '22436', 'name' => 'Vande Bharat Express', 'class' => 'EXEC, CC', 'status' => 'Pending Review', 'image' => 'https://images.unsplash.com/photo-1590674867585-8da8b7460c23?w=400'],
                ];
                @endphp

                @foreach($trains as $train)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <img src="{{ $train['image'] }}" class="rounded-3 shadow-sm" width="100" height="70" style="object-fit:cover;">
                            <span class="badge {{ $train['status'] == 'Live' ? 'bg-green-light text-green' : 'bg-orange-light text-orange' }} rounded-pill px-3 py-2">{{ $train['status'] }}</span>
                        </div>
                        <h6 class="fw-900 text-navy mb-1">{{ $train['name'] }}</h6>
                        <p class="text-muted small mb-3">Train No: {{ $train['number'] }} · {{ $train['class'] }}</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold">Update Inventory</button>
                            <button class="btn btn-sm btn-light flex-grow-1 rounded-pill fw-bold text-red">Delete Listing</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div class="modal fade" id="addTrainModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 24px;">
            <h4 class="fw-900 text-navy mb-4">Add Train Subscription Quota</h4>
            <form>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Official Train Number</label>
                    <input type="text" class="form-control rounded-pill px-4" placeholder="e.g. 12046">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Allocated Seat Quota</label>
                    <input type="number" class="form-control rounded-pill px-4" placeholder="50">
                </div>
                <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-bold mt-3">Register Quota</button>
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

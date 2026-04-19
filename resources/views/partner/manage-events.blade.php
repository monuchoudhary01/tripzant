@extends('layouts.app')

@section('title', "Manage Events — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <x-partner-sidebar active="events" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Event Services</h2>
                    <p class="text-muted small mb-0">List concerts, shows, or conferences and manage seating charts.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">
                   <i class="fas fa-plus me-2"></i> Create New Event
                </button>
            </div>

            <div class="row g-4">
                @php
                $events = [
                    ['title' => 'Sunburn Music Festival 2026', 'location' => 'Vagator, Goa', 'date' => '28-30 Dec 2026', 'status' => 'Live', 'image' => 'https://images.unsplash.com/photo-1459749411177-042180ce673c?w=600'],
                    ['title' => 'Digital Nomad Conference', 'location' => 'Cyber Hub, Gurgaon', 'date' => '15 Mar 2026', 'status' => 'Upcoming', 'image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600'],
                ];
                @endphp

                @foreach($events as $event)
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                        <div class="row g-4 align-items-center">
                            <div class="col-md-4">
                                <img src="{{ $event['image'] }}" class="rounded-4 shadow-sm w-100 h-100" style="object-fit:cover; min-height: 150px;">
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="fw-900 text-navy mb-0">{{ $event['title'] }}</h5>
                                    <span class="badge {{ $event['status'] == 'Live' ? 'bg-green-light text-green' : 'bg-blue-light text-blue' }} rounded-pill px-3 py-1">{{ $event['status'] }}</span>
                                </div>
                                <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $event['location'] }} · <i class="fas fa-calendar-alt ms-2 me-1"></i> {{ $event['date'] }}</p>
                                
                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <a href="/partner/event-seating" class="btn btn-sm btn-navy rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-chair me-2"></i> Seating & Prices</a>
                                    <button class="btn btn-sm btn-light rounded-pill px-4 fw-bold"><i class="fas fa-edit me-2"></i> Edit Details</button>
                                    <button class="btn btn-sm btn-light rounded-pill px-4 fw-bold text-red"><i class="fas fa-trash-alt me-2"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div class="modal fade" id="addEventModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-5 shadow-lg" style="border-radius: 32px;">
            <h3 class="fw-900 text-navy mb-5">Launch New Event Service</h3>
            <form>
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Professional Event Title</label>
                        <input type="text" class="form-control rounded-pill px-4 py-3" placeholder="e.g. World Travel Expo 2026">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Venue Location</label>
                        <input type="text" class="form-control rounded-pill px-4 py-3" placeholder="City, Venue Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Event Date</label>
                        <input type="date" class="form-control rounded-pill px-4 py-3">
                    </div>
                     <div class="col-md-12">
                        <p class="text-muted small mb-0"><i class="fas fa-info-circle me-1"></i> After creating the event, you will be prompted to define seat zones and tiered pricing categories.</p>
                    </div>
                </div>
                <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-bold mt-5 shadow-lg">Initialize Event <i class="fas fa-arrow-right ms-2"></i></button>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-green-light { background: rgba(34, 197, 94, 0.1); }
    .text-green { color: #22c55e; }
    .bg-blue-light { background: rgba(37, 99, 235, 0.1); }
    .text-blue { color: #2563eb; }
</style>
@endsection

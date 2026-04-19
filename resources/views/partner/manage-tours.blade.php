@extends('layouts.app')

@section('title', "Manage Tours — Partner Portal | Trip Zant")

@section('content')
<div class="tour-builder-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-tour-builder-sidebar active="tours" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Manage Tours & Activities</h2>
                    <p class="text-muted small mb-0">Control your local experiences, guided tours, and workshop inventories.</p>
                </div>
                <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTourModal">
                   <i class="fas fa-plus me-2"></i> Create New Experience
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                @foreach($tours as $tour)
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden hover-lift transition-base h-100">
                        <div class="position-relative">
                            <img src="{{ $tour->image ?: 'https://images.unsplash.com/photo-1544551763-47a18411987c?q=80&w=600&auto=format&fit=crop' }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $tour->title }}">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge {{ $tour->status == 'Live' ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-3 py-2 fw-bold shadow-sm">
                                    {{ $tour->status }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-900 text-navy mb-0">{{ $tour->title }}</h6>
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <p class="text-muted x-small mb-3 fw-600 line-clamp-2">{{ $tour->description }}</p>
                            
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="bg-purple-subtle text-purple px-2 py-1 rounded small fw-bold">
                                    <i class="far fa-clock me-1"></i> {{ $tour->duration }}
                                </div>
                                <div class="bg-blue-subtle text-blue px-2 py-1 rounded small fw-bold">
                                    <i class="fas fa-user-friends me-1"></i> {{ $tour->location }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <span class="text-muted x-small fw-bold d-block uppercase mb-1">Starting From</span>
                                    <h4 class="fw-900 text-navy mb-0">₹{{ number_format($tour->price, 0) }} <span class="text-muted small fw-normal" style="font-size: 13px;">/person</span></h4>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-icon-only bg-light rounded-circle text-navy shadow-sm" title="Edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-icon-only bg-light rounded-circle text-danger shadow-sm" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
<div class="modal fade" id="addTourModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 24px;">
            <h4 class="fw-900 text-navy mb-4">Publish New Experience</h4>
            <form action="{{ route('partner.tours.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tour / Activity Title</label>
                    <input type="text" name="title" class="form-control rounded-pill px-4" placeholder="e.g. Scuba Diving at Grand Island" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Price per Head</label>
                        <input type="number" name="price" class="form-control rounded-pill px-4" placeholder="2500" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Duration</label>
                        <input type="text" name="duration" class="form-control rounded-pill px-4" placeholder="4 Hours" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Location</label>
                    <input type="text" name="location" class="form-control rounded-pill px-4" placeholder="Goa, India">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description</label>
                    <textarea name="description" class="form-control rounded-4 px-4 py-3" rows="3" placeholder="Tell travelers about this experience..."></textarea>
                </div>
                <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-bold mt-3">List Experience</button>
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

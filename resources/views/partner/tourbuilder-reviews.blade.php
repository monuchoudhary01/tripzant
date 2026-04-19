@extends('layouts.app')

@section('title', "Guest Reviews — Tour Builder | Trip Zant")

@section('content')
<div class="tour-builder-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-tour-builder-sidebar active="reviews" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Guest Reviews & Feedback</h2>
                    <p class="text-muted small mb-0">Manage your business reputation and average rating across all listed tours.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-900 text-navy fs-3">4.8</span>
                    <div class="text-warning fs-5">
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-muted small fw-bold">(1,248 Reviews)</span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                <div class="d-flex justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Arjun+Patel&background=random" class="rounded-pill shadow-sm" width="50" height="50" alt="">
                        <div>
                            <h6 class="fw-900 text-navy mb-0">Arjun Patel</h6>
                            <div class="text-warning x-small"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                    <span class="x-small text-muted fw-bold">12 Mar 2026</span>
                </div>
                <h6 class="fw-900 text-navy small">"Best kayaking experience ever!"</h6>
                <p class="text-muted small mb-4">The sunset kayaking tour through the backwaters was incredible. The guide (Sandeep) was very well-informed and made sure we felt safe. Highly recommended for families.</p>
                <div class="reply-box bg-light p-3 rounded-3 mb-2 border-start border-purple border-4">
                    <p class="x-small text-muted fw-bold mb-1 uppercase tracking-wide">Your Reply</p>
                    <p class="small text-navy mb-0">"Thank you Arjun! Happy to hear you enjoyed the sunset views. We'll pass your feedback to Sandeep!"</p>
                </div>
                <button class="btn btn-sm btn-link text-purple fw-bold p-0 x-small text-decoration-none">EDIT REPLY</button>
            </div>
        </div>
    </main>
</div>

<style>
    .text-purple { color: #6b46c1 !important; }
    .border-purple { border-color: #6b46c1 !important; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

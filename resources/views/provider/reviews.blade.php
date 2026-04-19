@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-800">Reviews & Ratings</h4>
            <p class="text-muted small">Manage your reputation and read what clients say about your services.</p>
        </div>
    </div>

    <!-- Rating Summary -->
    <div class="card border-0 p-4 mb-5 rounded-4 shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-3 text-center border-end">
                <h1 class="fw-900 text-primary mb-0" style="font-size:64px;">4.9</h1>
                <div class="mb-2">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="text-muted fw-700 smaller mb-0">RATING FROM 128 REVIEWS</p>
            </div>
            <div class="col-md-6 px-lg-5">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span class="small fw-800 text-muted" style="width:15px;">5</span>
                        <div class="progress flex-grow-1 rounded-pill" style="height:8px;">
                            <div class="progress-bar bg-primary" style="width: 90%;"></div>
                        </div>
                        <span class="smaller fw-700 text-muted" style="width:30px;">112</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="small fw-800 text-muted" style="width:15px;">4</span>
                        <div class="progress flex-grow-1 rounded-pill" style="height:8px;">
                            <div class="progress-bar bg-primary" style="width: 15%;"></div>
                        </div>
                        <span class="smaller fw-700 text-muted" style="width:30px;">12</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="small fw-800 text-muted" style="width:15px;">3</span>
                        <div class="progress flex-grow-1 rounded-pill" style="height:8px;">
                            <div class="progress-bar bg-primary" style="width: 5%;"></div>
                        </div>
                        <span class="smaller fw-700 text-muted" style="width:30px;">4</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 opacity-25">
                         <span class="small fw-800 text-muted" style="width:15px;">2</span>
                        <div class="progress flex-grow-1 rounded-pill" style="height:8px;">
                            <div class="progress-bar bg-primary" style="width: 0%;"></div>
                        </div>
                        <span class="smaller fw-700 text-muted" style="width:30px;">0</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center border-start d-none d-md-block">
                <div class="bg-primary bg-opacity-10 text-primary d-inline-block rounded-circle p-4 mb-3">
                    <i class="fas fa-medal fa-2x"></i>
                </div>
                <h6 class="fw-800 mb-0">TOP RATED</h6>
                <p class="smaller text-muted fw-700">Top 5% in New Delhi</p>
            </div>
        </div>
    </div>

    <!-- Review List -->
    <div class="row g-4">
        @php
            $reviews = [
                ['name' => 'Michael Scott', 'role' => 'Guest from Taj Palace', 'date' => '2 days ago', 'rating' => 5, 'text' => 'Rahul was absolutely fantastic! His knowledge of the local history in Old Delhi is unmatched. The airport pickup was also very smooth with a clean luxury car.', 'label' => 'Service: Heritage Walk'],
                ['name' => 'Priya Das', 'role' => 'Tour Builder (Incredible India)', 'date' => '1 week ago', 'rating' => 5, 'text' => "Excellent guide service for our VIP clients. Very professional and helpful with senior citizens. Highly recommended for tour operators.", 'label' => 'Service: Guide Service'],
                ['name' => 'Kevin Hart', 'role' => 'Guest from The Oberoi', 'date' => '2 weeks ago', 'rating' => 4, 'text' => 'Great experience, though the traffic in Delhi was crazy but Rahul handled it well. Very informative and polite.', 'label' => 'Service: Airport Pickup'],
            ];
        @endphp

        @foreach($reviews as $r)
        <div class="col-12">
            <div class="card border-0 p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($r['name']) }}&background=random" class="rounded-circle" width="48" height="48">
                        <div>
                            <h6 class="fw-800 mb-0">{{ $r['name'] }}</h6>
                            <p class="mb-0 text-muted smaller fw-600">{{ $r['role'] }}</p>
                        </div>
                    </div>
                    <div class="text-end">
                         <div class="mb-1">
                            @for($i=0; $i<$r['rating']; $i++)
                                <i class="fas fa-star text-warning ms-1" style="font-size:12px;"></i>
                            @endfor
                        </div>
                        <p class="mb-0 text-muted smaller fw-700">{{ $r['date'] }}</p>
                    </div>
                </div>
                <div class="px-md-5">
                    <span class="badge bg-light text-primary fw-800 smaller px-3 py-2 mb-3 rounded-pill">{{ $r['label'] }}</span>
                    <p class="fw-600 text-muted small mb-0">{{ $r['text'] }}</p>
                </div>
                <div class="text-end mt-3">
                    <button class="btn btn-link text-primary fw-800 small text-decoration-none">Reply to Review</button>
                    <button class="btn btn-link text-muted fw-800 small text-decoration-none"><i class="far fa-flag me-1"></i> Report</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .smaller { font-size: 11px; }
    .rounded-4 { border-radius: 12px !important; }
</style>
@endsection

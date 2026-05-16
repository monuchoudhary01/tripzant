@extends('layouts.dashboard')

@section('title', 'Saved Searches | Trip\'Stay')

@section('dashboard_content')
<div class="saved-searches-page">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-900 text-navy mb-1">Your Saved Searches</h4>
            <p class="text-muted small">Relaunch your favorite searches instantly.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($savedSearches as $s)
        <div class="col-lg-6">
            <div class="dashboard-card bg-white border border-light hvr-grow p-4 rounded-4 shadow-sm" style="transition: all 0.3s ease;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge rounded-pill fw-bold" style="background: rgba(11, 61, 97, 0.1); color: #0b3d61; font-size: 11px;">{{ strtoupper($s->item_type) }}</span>
                    <i class="far fa-star text-warning"></i>
                </div>
                <div class="mb-3">
                    <h6 class="fw-900 text-navy mb-0 fs-5">
                        @if($s->item_type == 'flight' && isset($s->search_params['origin']) && isset($s->search_params['destination']))
                            {{ $s->search_params['origin'] }} <i class="fas fa-arrow-right mx-2 text-muted" style="font-size: 14px;"></i> {{ $s->search_params['destination'] }}
                        @else
                            {{ $s->title }}
                        @endif
                    </h6>
                    <p class="text-muted small mt-1 mb-0 fw-bold">
                        <i class="far fa-calendar-alt me-1"></i> 
                        {{ isset($s->search_params['departure_date']) ? \Carbon\Carbon::parse($s->search_params['departure_date'])->format('d M Y') : 'Anytime' }}
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ $s->item_type == 'flight' ? route('flights.search', array_merge($s->search_params, ['locale' => $currentLocale, 'currency' => $currentCurrency])) : '#' }}" class="btn btn-navy rounded-pill px-4 fw-bold small flex-grow-1">Relaunch Search</a>
                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-circle p-2 fs-6 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 bg-white rounded-4 border">
            <div class="mb-4">
                <i class="fas fa-search display-3 text-muted opacity-25"></i>
            </div>
            <h5 class="fw-900 text-navy">No Saved Searches</h5>
            <p class="text-muted small">You haven't saved any searches yet. Quickly relaunch your frequent searches from here.</p>
            <a href="/" class="btn btn-navy rounded-pill px-5 py-2 mt-3 fw-bold">Search Now</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

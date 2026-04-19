@extends('layouts.dashboard')

@section('title', 'My Wishlist | Trip\'Stay')

@section('styles')
<style>
    .cat-pill {
        padding: 10px 24px;
        border-radius: 16px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        transition: all 0.3s;
    }
    .cat-pill:hover, .cat-pill.active {
        background: var(--user-primary);
        color: #fff;
        border-color: var(--user-primary);
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
    }
    .wish-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--user-card-shadow);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.02);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .wish-card:hover { transform: translateY(-8px); box-shadow: var(--user-card-hover); }
    .wish-image-wrap { height: 200px; overflow: hidden; position: relative; }
    .wish-image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .wish-card:hover .wish-image-wrap img { transform: scale(1.1); }
    .x-small { font-size: 11px; }
</style>
@endsection

@section('dashboard_content')
<div class="wishlist-page">
    <div class="row mb-4">
        <div class="col-12 text-center text-lg-start">
            <h4 class="fw-900 text-navy mb-1">My Wishlist</h4>
            <p class="text-muted small">Your saved flights, hotels, and tour packages.</p>
        </div>
    </div>

    <div class="row mb-5 justify-content-center justify-content-lg-start">
        <div class="col-auto">
            <div class="d-flex flex-wrap gap-2">
                <button class="cat-pill active">All Items ({{ $wishlistItems->count() }})</button>
                <button class="cat-pill">Hotels ({{ $wishlistItems->where('item_type', 'Hotel')->count() }})</button>
                <button class="cat-pill">Flights ({{ $wishlistItems->where('item_type', 'Flight')->count() }})</button>
                <button class="cat-pill">Tours ({{ $wishlistItems->where('item_type', 'Tour')->count() }})</button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($wishlistItems as $item)
        <div class="col-lg-4 col-md-6">
            <div class="wish-card">
                <div class="wish-image-wrap">
                    <img src="{{ $item->item_image ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80' }}">
                    <div class="position-absolute top-0 start-0 m-3">
                         <span class="badge bg-white text-navy rounded-pill px-3 py-1 fw-900 x-small shadow-sm text-uppercase">{{ $item->item_type }}</span>
                    </div>
                    <form action="#" method="POST" class="position-absolute top-0 end-0 m-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background:#fff;"><i class="fas fa-heart text-danger"></i></button>
                    </form>
                </div>
                <div class="p-4 flex-grow-1 d-flex flex-column">
                    <h5 class="fw-900 text-navy mb-1" style="font-size: 16px;">{{ $item->item_name }}</h5>
                    <p class="text-muted small fw-bold mb-4 opacity-75"><i class="fas fa-map-marker-alt me-1 text-accent"></i> {{ $item->item_location ?? 'Explore Global' }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                            <span class="text-muted d-block x-small fw-800 opacity-50 text-uppercase">Best Price</span>
                            <span class="fw-900 text-navy fs-5">₹{{ number_format($item->item_price, 0) }}</span>
                        </div>
                        <a href="#" class="btn btn-navy rounded-pill px-4 fw-900 x-small hvr-shrink">BOOK NOW</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 bg-white rounded-5 border border-dashed">
            <div class="mb-4">
                <i class="fas fa-heart-circle-plus display-1 text-muted opacity-10"></i>
            </div>
            <h5 class="fw-900 text-navy">Wishlist is Empty</h5>
            <p class="text-muted small fw-bold opacity-50 px-5">Your dream destinations are waiting to be saved here. Start searching and add your favorites!</p>
            <a href="/" class="btn btn-navy rounded-pill px-5 mt-3 fw-900 x-small">BROWSE PACKAGES</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

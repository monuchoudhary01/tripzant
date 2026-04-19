@extends('layouts.app')

@section('title', " Homestays in Kochi — Trip Zant Booking.com " )
@section('active-homestays', 'active')

@section('content')
    <div class="listing-hero">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="breadcrumb-custom mb-1" style="margin-bottom:0;">
                        <a href="/" style="color:rgba(255,255,255,.5);">Home</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <a href="/homestays" style="color:rgba(255,255,255,.5);">Homestays</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <span class="current" style="color:#fff;">Kochi, Kerala</span>
                    </div>
                    <h4 class="mb-0 fw-800" style="font-size:20px;">Homestays & Villas in {{ $city }}</h4>
                    <p style="font-size:13px;opacity:.7;margin-bottom:0;">{{ $homestays->count() }} Properties Available in Central {{ $city }}</p>
                </div>
                <button class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size:13px;font-weight:600;"><i class="fas fa-pen me-2"></i>Modify Search</button>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="filter-card sticky-top" style="top:80px;">
                    <div class="filter-title"><i class="fas fa-sliders-h" style="color:var(--secondary);"></i> Filters</div>

                    <div class="filter-group">
                        <div class="filter-group-title">Property Type</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="h1" checked><label class="form-check-label small" for="h1">Villa</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="h2"><label class="form-check-label small" for="h2">Apartment</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="h3"><label class="form-check-label small" for="h3">Cottage</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="h4"><label class="form-check-label small" for="h4">Farmhouse</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="h5"><label class="form-check-label small" for="h5">Treehouse</label></div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Price Per Night</div>
                        <input type="range" class="form-range" min="1000" max="30000" step="500" value="15000">
                        <div class="d-flex justify-content-between" style="font-size:11px;color:var(--gray-300);"><span>₹1,000</span><span>₹30,000</span></div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Amenities</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="am1" checked><label class="form-check-label small" for="am1">Swimming Pool</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="am2"><label class="form-check-label small" for="am2">Pet Friendly</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="am3"><label class="form-check-label small" for="am3">Garden / Lawn</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="am4"><label class="form-check-label small" for="am4">Kitchen</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="am5"><label class="form-check-label small" for="am5">BBQ / Bonfire</label></div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Bedrooms</div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="px-3 py-1 rounded-pill border" style="font-size:12px;font-weight:600;cursor:pointer;">1</span>
                            <span class="px-3 py-1 rounded-pill border" style="font-size:12px;font-weight:600;cursor:pointer;">2</span>
                            <span class="px-3 py-1 rounded-pill border" style="font-size:12px;font-weight:600;cursor:pointer;background:var(--navy);color:#fff;">3+</span>
                            <span class="px-3 py-1 rounded-pill border" style="font-size:12px;font-weight:600;cursor:pointer;">4+</span>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-group-title">Host Type</div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="ht1" checked><label class="form-check-label small" for="ht1"><i class="fas fa-award me-1" style="color:var(--primary);"></i> Superhost</label></div>
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="ht2"><label class="form-check-label small" for="ht2">Instant Book</label></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="results-bar">
                    <div>
                        <h5 class="fw-800 mb-0" style="font-size:16px;">{{ $homestays->count() }} Homestays Found</h5>
                        <span style="font-size:12px;color:var(--gray-300);">Showing results for {{ $city }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:12px;color:var(--gray-300);">Sort by:</span>
                        <select class="form-select form-select-sm" style="width:auto;border-radius:8px;font-size:12px;font-weight:600;">
                            <option>Relevance</option>
                            <option>Price: Low to High</option>
                            <option>Guest Rating</option>
                        </select>
                    </div>
                </div>

                @forelse($homestays as $home)
                    <x-listing-card 
                        type="homestay" 
                        :title="$home->title" 
                        :subtitle="$home->subtitle" 
                        :price="number_format($home->price_per_night)" 
                        :rating="$home->rating" 
                        :reviews="$home->reviews_count" 
                        :image="$home->image_url ?? 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500'" 
                        :badges="[
                            $home->is_superhost ? 'Superhost' : null,
                            $home->property_type
                        ]"
                        :f="['id' => $home->id]"
                    />
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                        <h5>No Homestays Found in {{ $city }}</h5>
                        <p class="text-muted">Try searching for a different location or check back later.</p>
                    </div>
                @endforelse

                @if($homestays->count() > 0)
                    <div class="text-center TS-4">
                        <button class="btn btn-outline-custom px-5 py-3"><i class="fas fa-plus me-2"></i> Load More Homestays</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

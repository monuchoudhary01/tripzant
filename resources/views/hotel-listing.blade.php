@extends('layouts.app')

@section('title', " Hotels in Goa — Trip Zant Booking.com " )
@section('active-hotels', 'active')

@section('content')
    <!-- Search Header -->
    <div class="listing-hero" style="background:linear-gradient(135deg, #02234b, #0c3d61); padding: 50px 0; border-bottom: 2px solid var(--primary); position:relative; overflow:hidden;">
        <div class="container text-white position-relative" style="z-index:2;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="breadcrumb-custom mb-1" style="margin-bottom:0; font-size:11px; opacity:.7;">
                        <a href="/" style="color:#fff;">Home</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <a href="/hotels" style="color:#fff;">Hotels</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <span class="current" style="color:var(--secondary-light); font-weight:800;">Goa, India</span>
                    </div>
                    <h2 class="mb-0 fw-900" style="font-size:32px; letter-spacing:-1px;">Perfect Stays in Goa</h2>
                    <p style="font-size:13px;opacity:.8;margin-bottom:0; font-weight:700;"><i class="fas fa-calendar-alt me-2 text-primary"></i> 12 Nov – 15 Nov 2025 · 1 Room · 2 Adults</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="/hotel-map" class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size:13px;font-weight:800; border-width:2px; text-decoration:none;"><i class="fas fa-map-marker-alt me-2"></i>MAP VIEW</a>
                    <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size:13px;font-weight:800; background:var(--primary); border:none;"><i class="fas fa-pen me-2"></i>MODIFY</button>
                </div>
            </div>
        </div>
        <div style="position:absolute; bottom:-50px; right:-50px; width:300px; height:300px; background:var(--primary); opacity:0.1; filter:blur(100px); border-radius:50%;"></div>
    </div>

    <div class="container py-5">
        <div class="row g-4">
            <!-- Filters -->
            <div class="col-lg-3">
                <div class="filter-card-v4 sticky-top shadow-lg" style="top:110px;">
                    <div class="filter-title-v4"><span><i class="fas fa-sliders-h"></i></span> FILTERS</div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Popular Filters</span>
                        <div class="mb-2">
                            <input type="checkbox" id="hp1" checked hidden>
                            <label class="custom-cb" for="hp1">
                                <div class="cb-box"></div>
                                <span class="cb-label">Free Cancellation</span>
                                <span class="cb-count">42</span>
                            </label>
                        </div>
                        <div class="mb-2">
                            <input type="checkbox" id="hp2" hidden>
                            <label class="custom-cb" for="hp2">
                                <div class="cb-box"></div>
                                <span class="cb-label">Breakfast Included</span>
                                <span class="cb-count">28</span>
                            </label>
                        </div>
                        <div class="mb-2">
                            <input type="checkbox" id="hp3" hidden>
                            <label class="custom-cb" for="hp3">
                                <div class="cb-box"></div>
                                <span class="cb-label">Couple Friendly</span>
                                <span class="cb-count">35</span>
                            </label>
                        </div>
                    </div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Star Category</span>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge active py-2 px-3 border" style="font-size:11px;font-weight:900;cursor:pointer;background:var(--navy);color:#fff; border-radius:10px;">5 ★</span>
                            <span class="badge py-2 px-3 border" style="font-size:11px;font-weight:900;cursor:pointer; background:#f8fafc; color:var(--navy); border-radius:10px;">4 ★</span>
                            <span class="badge py-2 px-3 border" style="font-size:11px;font-weight:900;cursor:pointer; background:#f8fafc; color:var(--navy); border-radius:10px;">3 ★</span>
                        </div>
                    </div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Price Per Night</span>
                        <div class="px-2">
                            <input type="range" class="form-range" min="1000" max="50000" step="1000" value="20000">
                            <div class="d-flex justify-content-between TS-2" style="font-size:11px;color:var(--gray-300); font-weight:800;">
                                <span>₹1,000</span><span>₹50,000+</span>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Property Type</span>
                        <div class="mb-2">
                            <input type="checkbox" id="pt1" checked hidden>
                            <label class="custom-cb" for="pt1">
                                <div class="cb-box"></div>
                                <span class="cb-label">Hotels</span>
                                <span class="cb-count">120+</span>
                            </label>
                        </div>
                        <div class="mb-2">
                            <input type="checkbox" id="pt2" hidden>
                            <label class="custom-cb" for="pt2">
                                <div class="cb-box"></div>
                                <span class="cb-label">Resorts & Spas</span>
                                <span class="cb-count">48</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="col-lg-9">
                <!-- Weather Forecast Widget -->
                @include('partials.weather-widget', ['city' => 'Goa, India'])

                <div class="results-bar">
                    <div>
                        <h5 class="fw-800 mb-0" style="font-size:16px;">1,240 Hotels Found</h5>
                        <span style="font-size:12px;color:var(--gray-300);">Showing prices for 3 nights</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:12px;color:var(--gray-300);">Sort by:</span>
                        <select class="form-select form-select-sm" style="width:auto;border-radius:8px;font-size:12px;font-weight:600;">
                            <option>Popularity</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Rating</option>
                        </select>
                    </div>
                </div>

                <!-- Promotional banner -->
                <div class="coupon-strip mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-gift" style="color:var(--primary);font-size:20px;"></i>
                        <div>
                            <span class="fw-700" style="font-size:13px;">Save extra ₹1,200</span>
                            <span style="font-size:12px;color:var(--gray-400);"> with code <strong style="color:var(--primary);">GOAVIBES</strong></span>
                        </div>
                    </div>
                    <button class="btn btn-sm px-3" style="background:var(--primary);color:#fff;border-radius:8px;font-size:12px;font-weight:600;">Copy Code</button>
                </div>

                <x-listing-card type="hotel" title="Taj Exotica Resort & Spa" subtitle="Benaulim, South Goa" price="28,500" rating="4.9" reviews="480" image="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&auto=format&fit=crop&q=80" />
                <x-listing-card type="hotel" title="Novotel Goa Resort & Spa" subtitle="Candolim, North Goa" price="12,200" rating="4.5" reviews="920" image="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&auto=format&fit=crop&q=80" />
                <x-listing-card type="hotel" title="The Leela Goa" subtitle="Cavelossim, South Goa" price="32,900" rating="4.8" reviews="340" image="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500&auto=format&fit=crop&q=80" />
                <x-listing-card type="hotel" title="Radisson Blu Resort" subtitle="Cavelossim, South Goa" price="9,800" rating="4.3" reviews="1240" image="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=500&auto=format&fit=crop&q=80" />
                <x-listing-card type="hotel" title="Hyatt Centric Goa" subtitle="Bambolim, Goa" price="15,400" rating="4.6" reviews="560" image="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=500&auto=format&fit=crop&q=80" />

                <div class="text-center TS-4">
                    <button class="btn btn-outline-custom px-5 py-3"><i class="fas fa-plus me-2"></i> Load More Hotels</button>
                </div>
            </div>
        </div>
    </div>
@endsection

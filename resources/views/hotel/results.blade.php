@extends(auth()->check() && (auth()->user()->role == 'hotel_partner' || auth()->user()->role == 'b2b_agent' || auth()->user()->role == 'iata_agent' || auth()->user()->role == 'amadeus_partner') ? 'layouts.hotel_master' : 'layouts.app')

@section('title', 'Properties in ' . ($params['destinationCode'] ?? 'Global') . ' | QuikHotel Results')

@section('styles')
<style>
    .h-results-bg { background: #f8fafc; min-height: 100vh; }
    .h-filter-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    .h-filter-title {
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1e293b;
        margin-bottom: 16px;
        display: block;
    }
    .h-result-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        display: flex;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .h-result-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
        border-color: #2563eb;
    }
    .h-result-image {
        width: 280px;
        min-width: 280px;
        height: 240px;
        position: relative;
    }
    .h-result-image img { width: 100%; height: 100%; object-fit: cover; }
    .h-result-content { padding: 24px; flex-grow: 1; display: flex; flex-direction: column; }
    .h-price-box {
        padding: 24px;
        background: #f8fafc;
        border-left: 1px solid #e2e8f0;
        width: 240px;
        min-width: 240px;
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .h-star-rating { color: #facc15; font-size: 11px; margin-bottom: 8px; }
    .h-tag {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .h-status-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(16, 24, 40, 0.8);
        backdrop-filter: blur(4px);
        color: #fff;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 10px;
        font-weight: 800;
        z-index: 5;
    }
    .h-search-summary {
        background: #fff;
        border-radius: 100px;
        padding: 12px 24px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    .h-summary-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #475569; }
    .h-summary-item i { color: #2563eb; }
    
    /* Expert Support Styling */
    .h-expert-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 16px;
        padding: 20px;
        color: #fff;
        margin-bottom: 24px;
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .h-expert-card i {
        font-size: 24px;
        color: #60a5fa;
    }
    /* Search Bar Inline */
    .h-inline-search {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .h-input-group {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 12px;
        flex: 1;
    }
    .h-input-group i { color: #2563eb; font-size: 14px; }
    .h-input-group input {
        background: transparent;
        border: none;
        outline: none;
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
        width: 100%;
    }
    .h-input-group label {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('content')
<div class="h-results-bg py-4 pt-5">
    <div class="container">
        {{-- MakeMyTrip Style Edit Search Bar --}}
        <div class="mb-5 animate-in fade-in slide-in-from-top-4 duration-700">
            <x-hotel-search-bar :params="$params" />
        </div>

        @if(isset($error) && !isset($hotels[0]))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex gap-3">
                    <div class="p-2 bg-danger bg-opacity-10 rounded-circle"><i class="fas fa-exclamation-triangle text-danger"></i></div>
                    <div>
                        <h6 class="fw-800 mb-1">API Connection Issue</h6>
                        <p class="mb-0 small fw-bold opacity-75">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Expert Support Hotline -->
                    <div class="h-expert-card animate-up">
                        <i class="fas fa-headset"></i>
                        <div>
                            <p class="mb-0 tiny fw-800 text-blue-200 uppercase ls-1">Need help booking?</p>
                            <h5 class="mb-0 fw-900 outfit"><a href="tel:+919999000000" class="text-white text-decoration-none">+91 9999 000 000</a></h5>
                        </div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ request()->fullUrlWithQuery(['mode' => 'map']) }}" class="btn btn-navy w-100 rounded-pill py-3 fw-800 d-flex align-items-center justify-content-center gap-2 hover-up shadow-sm">
                            <i class="fas fa-map-marked-alt text-warning"></i> EXPLORE ON MAP
                        </a>
                    </div>

                    <div class="h-filter-card">
                        <span class="h-filter-title">Price Per Night (₹ <span id="priceLabel">25,000</span>)</span>
                        <input type="range" class="form-range mb-2 filter-trigger" id="priceRange" min="1000" max="50000" step="500" value="25000">
                        <div class="d-flex justify-content-between text-muted fw-700 tiny">
                            <span>₹1k</span>
                            <span>₹25k</span>
                            <span>₹50k+</span>
                        </div>
                    </div>

                    <div class="h-filter-card">
                        <span class="h-filter-title">Star Rating</span>
                        @foreach([5,4,3] as $s)
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-trigger" type="checkbox" checked id="s{{$s}}" value="{{$s}}">
                            <label class="form-check-label h-star-rating" for="s{{$s}}">
                                @for($i=0; $i<$s; $i++) <i class="fas fa-star"></i> @endfor
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="h-filter-card">
                        <span class="h-filter-title">Popular Amenities</span>
                        @foreach(['Free Cancellation', 'Breakfast Included', 'Swimming Pool', 'Spa & Wellness'] as $a)
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-trigger" type="checkbox" id="{{ Str::slug($a) }}" value="{{ Str::slug($a) }}">
                            <label class="form-check-label small fw-700 text-slate" for="{{ Str::slug($a) }}">{{ $a }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Results area -->
            <div class="col-lg-9">
                @forelse($hotels as $hotel)
                @php 
                    $minRate = 0;
                    if(isset($hotel['rooms'][0]['rates'][0]['sellingRate'])) {
                        $minRate = $hotel['rooms'][0]['rates'][0]['sellingRate'];
                    }

                    $stars = (int)($hotel['categoryCode'][0] ?? 3);

                    $amenitySlugs = [];
                    if(isset($hotel['facilities']) && is_array($hotel['facilities'])) {
                        foreach($hotel['facilities'] as $fac) {
                            $f = is_array($fac) ? ($fac['facilityCode'] ?? '') : $fac;
                            if($f == 70 || $f == 'POOL' || $f == 'SWIMMING_POOL') $amenitySlugs[] = 'swimming-pool';
                            if($f == 220 || $f == 'SPA' || $f == 'SPA_WELLNESS') $amenitySlugs[] = 'spa-wellness';
                            if($f == 30 || $f == 'WIFI' || $f == 'FREE_WIFI') $amenitySlugs[] = 'free-wifi';
                        }
                    }
                    // Add some random ones if none found (for mock data)
                    if(empty($amenitySlugs)) $amenitySlugs = ['free-cancellation', 'breakfast-included'];
                @endphp
                <div class="h-result-card" data-price="{{ $minRate }}" data-stars="{{ $stars }}" data-amenities="{{ implode(',', $amenitySlugs) }}">
                    <div class="h-result-image">
                        <div class="h-status-badge">INSTANT CONFIRMATION</div>
                        @if(isset($hotel['main_image']))
                            <img src="{{ $hotel['main_image'] }}" alt="{{ $hotel['name'] }}" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';">
                        @else
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" alt="{{ $hotel['name'] }}">
                        @endif
                    </div>
                    <div class="h-result-content">
                        <div class="h-star-rating">
                            @for($i=0; $i<$stars; $i++) <i class="fas fa-star"></i> @endfor
                        </div>
                        <h4 class="outfit fw-900 text-navy mb-1" style="font-size: 20px;">{{ $hotel['name'] }}</h4>
                        <p class="text-muted small fw-600 mb-4"><i class="fas fa-map-marker-alt me-1 text-primary"></i> {{ $hotel['destinationName'] ?? $params['destinationCode'] }}, {{ $hotel['zoneName'] ?? 'Main City' }}</p>
                        
                        <div class="mt-auto d-flex flex-wrap gap-2">
                            @if(isset($hotel['facilities']) && is_array($hotel['facilities']))
                                @php 
                                    $facilityMap = [
                                        30 => ['icon' => 'fa-wifi', 'name' => 'WiFi'],
                                        50 => ['icon' => 'fa-parking', 'name' => 'Parking'],
                                        70 => ['icon' => 'fa-swimming-pool', 'name' => 'Pool'],
                                        90 => ['icon' => 'fa-utensils', 'name' => 'Restaurant'],
                                        100 => ['icon' => 'fa-glass-martini-alt', 'name' => 'Bar'],
                                        260 => ['icon' => 'fa-concierge-bell', 'name' => '24h Front Desk'],
                                        40 => ['icon' => 'fa-dumbbell', 'name' => 'Gym/Fitness']
                                    ];
                                    $shown = 0;
                                @endphp
                                @foreach($hotel['facilities'] as $fac)
                                    @php 
                                        $fKey = is_array($fac) ? ($fac['facilityCode'] ?? null) : $fac;
                                        // Case-insensitive check for Amadeus strings
                                        if (!is_numeric($fKey)) { $fKey = strtoupper($fKey); }
                                        
                                        $mapContent = null;
                                        // Map numbers or strings
                                        if (isset($facilityMap[$fKey])) {
                                            $mapContent = $facilityMap[$fKey];
                                        } elseif ($fKey == 'WIFI' || $fKey == 'FREE_WIFI') {
                                            $mapContent = $facilityMap[30];
                                        } elseif ($fKey == 'POOL' || $fKey == 'SWIMMING_POOL') {
                                            $mapContent = $facilityMap[70];
                                        } elseif ($fKey == 'PARKING') {
                                            $mapContent = $facilityMap[50];
                                        }
                                    @endphp

                                    @if($mapContent && $shown < 4)
                                        <span class="h-tag"><i class="fas {{ $mapContent['icon'] }} me-1"></i> {{ $mapContent['name'] }}</span>
                                        @php $shown++; @endphp
                                    @endif
                                @endforeach
                            @endif
                            @if(!isset($hotel['facilities']) || empty($hotel['facilities']))
                                <span class="h-tag"><i class="fas fa-check-circle me-1"></i> Great Location</span>
                            @endif
                        </div>
                    </div>
                    <div class="h-price-box">
                        <div class="text-muted tiny fw-800 mb-1 ls-1 uppercase">Starting from</div>
                        <div class="h2 fw-900 text-navy outfit mb-0">₹{{ number_format($minRate, 0) }}</div>
                        <div class="tiny text-muted mb-4 fw-bold opacity-75">Incl. all taxes</div>
                        
                        <form action="{{ route('hotel.details') }}" method="GET">
                            <input type="hidden" name="hotel_code" value="{{ $hotel['code'] }}">
                            <input type="hidden" name="checkIn" value="{{ $params['checkIn'] }}">
                            <input type="hidden" name="checkOut" value="{{ $params['checkOut'] }}">
                            <input type="hidden" name="adults" value="{{ $params['adults'] }}">
                            <input type="hidden" name="children" value="{{ $params['children'] ?? 0 }}">
                            <input type="hidden" name="rooms" value="{{ $params['rooms'] ?? 1 }}">
                            <button type="submit" class="btn btn-primary fw-800 w-100 py-3 rounded-pill">VIEW ROOMS <i class="fas fa-arrow-right ms-2"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
                    <div class="py-5">
                        <div class="h-logo-icon mx-auto mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-hotel fa-2x text-muted opacity-50"></i>
                        </div>
                        <h4 class="fw-900 outfit text-navy">No Properties Found</h4>
                        <p class="text-muted fw-bold">Try adjusting your filters, dates, or destination city.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-800 mt-3">TRY ANOTHER SEARCH</a>
                    </div>
                </div>
                @endforelse

                <div id="noResults" class="card border-0 shadow-sm rounded-4 py-5 text-center d-none">
                    <div class="py-5">
                        <div class="h-logo-icon mx-auto mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-filter fa-2x text-muted opacity-50"></i>
                        </div>
                        <h4 class="fw-900 outfit text-navy">No Matching Hotels</h4>
                        <p class="text-muted fw-bold">Try increasing your price range or selecting different star ratings.</p>
                        <button onclick="resetFilters()" class="btn btn-primary rounded-pill px-5 py-2 fw-800 mt-3">RESET FILTERS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fpConfig = { dateFormat: "Y-m-d", minDate: "today" };
        flatpickr("#checkIn", fpConfig);
        flatpickr("#checkOut", fpConfig);

        // Simple City Autocomplete Fallback (can be enhanced with the same logic as home)
        const cityInput = document.getElementById('cityInput');
        if (cityInput) {
            cityInput.addEventListener('focus', function() {
                // If we need the full TravelPayouts logic here, we'd copy it.
                // For now, let's keep it simple or use the one from home if available.
            });
        }

        // --- Filtering Logic ---
        const priceRange = document.getElementById('priceRange');
        const priceLabel = document.getElementById('priceLabel');
        const triggers = document.querySelectorAll('.filter-trigger');
        const cards = document.querySelectorAll('.h-result-card');
        const noResults = document.getElementById('noResults');

        function filterHotels() {
            const maxPrice = parseInt(priceRange.value);
            priceLabel.innerText = maxPrice.toLocaleString();

            const selectedStars = Array.from(document.querySelectorAll('.form-check-input.filter-trigger[id^="s"]:checked'))
                                       .map(cb => parseInt(cb.value));
            
            const selectedAmenities = Array.from(document.querySelectorAll('.form-check-input.filter-trigger:not([id^="s"]):checked'))
                                           .map(cb => cb.value);

            let visibleCount = 0;
            cards.forEach(card => {
                const price = parseInt(card.getAttribute('data-price'));
                const stars = parseInt(card.getAttribute('data-stars'));
                const amenities = card.getAttribute('data-amenities').split(',');

                const priceMatch = price <= maxPrice;
                const starMatch = selectedStars.length === 0 || selectedStars.includes(stars);
                const amenityMatch = selectedAmenities.length === 0 || selectedAmenities.every(a => amenities.includes(a));

                if (priceMatch && starMatch && amenityMatch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCount === 0 && cards.length > 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        }

        window.resetFilters = function() {
            priceRange.value = 50000;
            document.querySelectorAll('.form-check-input.filter-trigger[id^="s"]').forEach(cb => cb.checked = true);
            document.querySelectorAll('.form-check-input.filter-trigger:not([id^="s"])').forEach(cb => cb.checked = false);
            filterHotels();
        };

        triggers.forEach(trigger => {
            trigger.addEventListener('change', filterHotels);
            trigger.addEventListener('input', filterHotels); // For real-time slider update
        });

        // Initialize filter on load
        filterHotels();
    });
</script>
@endsection
@endsection

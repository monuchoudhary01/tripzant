@extends('layouts.app')

@section('title', "Trip Zant — Book Flights, Hotels, Homestays & More")

@section('content')
    <x-ai-travel-assistant />

    <!-- ====== HERO ====== -->
    <section class="hero-section">
        <div class="hero-float hero-float-1"></div>
        <div class="hero-float hero-float-2"></div>
        <div class="hero-float hero-float-3"></div>
        <div class="hero-particles">
            @for($i=0; $i<20; $i++)
                <div class="hero-particle" style="left: {{ rand(0, 100) }}%; width: {{ rand(2, 6) }}px; height: {{ rand(2, 6) }}px; animation-duration: {{ rand(5, 15) }}s; animation-delay: {{ rand(0, 10) }}s;"></div>
            @endfor
        </div>
        <div class="container position-relative" style="z-index:2;">
            <h1 class="hero-title animate-up">Discover Your Next <span class="highlight">Adventure</span></h1>
            <p class="hero-subtitle animate-up animate-up-delay-1"><span class="typing-cursor">Search deals on flights, hotels, homestays, and more...</span></p>

            <!-- AI Search Trigger Bar (Image 2 style) -->
            <div class="hero-ai-trigger animate-up animate-up-delay-1" onclick="toggleAISearch(true)">
                <div class="ai-input-placeholder">Ask Myra AI: "Direct flight from Jaipur to Delhi"</div>
                <div class="ai-sparkle-pill">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 18px; height: 18px;">
                        <path d="M12 3L14.5 9L21 11.5L14.5 14L12 20L9.5 14L3 11.5L9.5 9L12 3Z" fill="currentColor"/>
                    </svg>
                    <span>Try AI Search</span>
                </div>
            </div>

            <style>
                .hero-ai-trigger {
                    max-width: 600px;
                    margin: 30px auto 0;
                    background: rgba(255, 255, 255, 0.9);
                    backdrop-filter: blur(10px);
                    padding: 10px 10px 10px 25px;
                    border-radius: 100px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    cursor: pointer;
                    border: 1px solid rgba(255, 255, 255, 0.3);
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s;
                }
                .hero-ai-trigger:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 15px 40px rgba(59, 130, 246, 0.2);
                    background: #ffffff;
                    border-color: #3b82f6;
                }
                .ai-input-placeholder {
                    color: #64748b;
                    font-weight: 500;
                    font-size: 16px;
                }
                .ai-sparkle-pill {
                    background: #3b82f6;
                    color: white;
                    padding: 8px 18px;
                    border-radius: 100px;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-weight: 700;
                    font-size: 14px;
                }
            </style>

            <!-- Service Quick Icons -->
            <div class="hero-services animate-up animate-up-delay-2">
                <a href="/flights" class="hero-service-item">
                    <div class="hero-service-icon flight"><i class="fas fa-plane"></i></div>
                    <span>Flights</span>
                </a>
                <a href="/hotels" class="hero-service-item">
                    <div class="hero-service-icon hotel"><i class="fas fa-hotel"></i></div>
                    <span>Hotels</span>
                </a>
                <a href="/flight-hotel" class="hero-service-item">
                    <div class="hero-service-icon bundle"><i class="fas fa-suitcase-rolling"></i></div>
                    <span>Flight + Hotel</span>
                </a>
                <a href="/homestays" class="hero-service-item">
                    <div class="hero-service-icon homestay"><i class="fas fa-house-chimney"></i></div>
                    <span>Homestays</span>
                </a>
                <a href="/cabs" class="hero-service-item">
                    <div class="hero-service-icon cab"><i class="fas fa-car-side"></i></div>
                    <span>Cabs</span>
                </a>
                <a href="/trains" class="hero-service-item">
                    <div class="hero-service-icon train"><i class="fas fa-train"></i></div>
                    <span>Trains</span>
                </a>
                <a href="#" class="hero-service-item">
                    <div class="hero-service-icon holiday"><i class="fas fa-umbrella-beach"></i></div>
                    <span>Holidays</span>
                </a>
                <a href="{{ route('booking.insurance') }}" class="hero-service-item">
                    <div class="hero-service-icon insurance"><i class="fas fa-shield-alt"></i></div>
                    <span>Insurance</span>
                </a>
                <a href="/esim/listings" class="hero-service-item">
                    <div class="hero-service-icon esim"><i class="fas fa-sim-card"></i></div>
                    <span>eSIM</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ====== SEARCH WIDGET ====== -->
    <div class="container" id="mainSearchContainer" style="margin-top: -65px; position: relative; z-index: 1000;">
        <x-search-widget type="flights" />
    </div>

    <!-- ====== SMART TRAVEL CALENDAR ====== -->
    <section class="py-4 reveal stagger-children" id="smartTravelCalendar">
        <div class="container">
            <div class="section-head mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-4 bg-primary-light text-primary fs-3"><i class="fas fa-calendar-days"></i></div>
                    <div>
                        <h2 class="main-title mb-1">Plan Your Trip <span class="highlight-orange">Smartly</span></h2>
                        <p class="section-subtitle">Find the best time to travel based on prices and global festivals</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select border-0 shadow-sm rounded-pill px-4 fw-bold small" style="width: 180px;">
                        <option>✈️ Flights</option>
                        <option>🏨 Hotels</option>
                        <option>🎒 Packages</option>
                    </select>
                </div>
            </div>

            <div class="calendar-scroll-wrap overflow-auto pb-4">
                <div class="calendar-row d-flex gap-3">
                    @php
                    $months = [
                        ['name' => 'Jan', 'price' => '4,200', 'status' => 'medium', 'festival' => '🎉 New Year', 'desc' => 'Global celebrations and winter peaks.'],
                        ['name' => 'Feb', 'price' => '3,900', 'status' => 'low', 'festival' => '❤️ Valentine', 'desc' => 'Perfect for romantic getaways.'],
                        ['name' => 'Mar', 'price' => '4,500', 'status' => 'medium', 'festival' => '🎨 Holi', 'desc' => 'Festival of colors in India.'],
                        ['name' => 'Apr', 'price' => '5,100', 'status' => 'high', 'festival' => '🐣 Easter', 'desc' => 'Spring peak travel season.'],
                        ['name' => 'May', 'price' => '5,800', 'status' => 'high', 'festival' => '🏖️ Summer Start', 'desc' => 'Beginning of summer vacations.'],
                        ['name' => 'Jun', 'price' => '6,200', 'status' => 'high', 'festival' => '☀️ Mid Summer', 'desc' => 'Highest pricing for many routes.'],
                        ['name' => 'Jul', 'price' => '4,800', 'status' => 'medium', 'festival' => '🎭 Arts Fest', 'desc' => 'Local cultural events.'],
                        ['name' => 'Aug', 'price' => '4,300', 'status' => 'medium', 'festival' => '🇮🇳 Independence', 'desc' => 'Holiday weekend travel.'],
                        ['name' => 'Sep', 'price' => '3,200', 'status' => 'low', 'festival' => '🏔️ Off-Season', 'desc' => 'Best time for budget travelers.'],
                        ['name' => 'Oct', 'price' => '5,400', 'status' => 'high', 'festival' => '🪔 Diwali', 'desc' => 'Major festival peak in India.'],
                        ['name' => 'Nov', 'price' => '4,100', 'status' => 'medium', 'festival' => '🥧 Thanksgiving', 'desc' => 'Global holiday rush.'],
                        ['name' => 'Dec', 'price' => '7,500', 'status' => 'high', 'festival' => '🎄 Christmas', 'desc' => 'Global peak holiday pricing.'],
                    ];
                    @endphp
                    @foreach($months as $m)
                    <a href="{{ route('travel.trends') }}?month={{ $m['name'] }}" class="text-decoration-none">
                        <div class="month-card card-premium flex-shrink-0 text-center p-3 hvr-grow" 
                             style="width: 160px; {{ $m['name'] == 'Sep' ? 'border: 2px solid var(--green);' : '' }}"
                             data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $m['desc'] }}">
                            @if($m['name'] == 'Sep')
                                <div class="badge bg-success position-absolute top-0 start-50 translate-middle rounded-pill x-small px-3" style="z-index: 10;">CHEAPEST</div>
                            @endif
                            <h6 class="fw-900 text-navy mb-1">{{ $m['name'] }}</h6>
                            <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                 <div class="price-dot bg-{{ $m['status'] == 'low' ? 'success' : ($m['status'] == 'medium' ? 'warning' : 'danger') }}" style="width:8px; height:8px; border-radius:50%;"></div>
                                 <span class="fw-800 text-navy small">₹{{ $m['price'] }}</span>
                            </div>
                            <div class="festival-tag py-1 px-2 rounded-pill bg-light text-navy x-small fw-bold border" style="font-size:10px;">{{ $m['festival'] }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 g-3">
                 <div class="d-flex gap-4">
                     <div class="d-flex align-items-center gap-2 small fw-bold text-muted"><div class="price-dot bg-success" style="width:8px; height:8px; border-radius:50%;"></div> Low Fare</div>
                     <div class="d-flex align-items-center gap-2 small fw-bold text-muted"><div class="price-dot bg-warning" style="width:8px; height:8px; border-radius:50%;"></div> Medium</div>
                     <div class="d-flex align-items-center gap-2 small fw-bold text-muted"><div class="price-dot bg-danger" style="width:8px; height:8px; border-radius:50%;"></div> High/Peak</div>
                 </div>
                 <div class="d-flex gap-2">
                     <a href="{{ route('travel.trends') }}" class="btn btn-outline-navy rounded-pill px-4 fw-bold small"><i class="fas fa-chart-line me-2"></i> Detailed Trends</a>
                     <a href="{{ route('travel.festivals') }}" class="btn btn-navy rounded-pill px-4 fw-bold small">Explore Festivals <i class="fas fa-chevron-right ms-2"></i></a>
                 </div>
            </div>
        </div>
    </section>

    <style>
        .calendar-scroll-wrap::-webkit-scrollbar { height: 6px; }
        .calendar-scroll-wrap::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .month-card { background: #fff; transition: all 0.3s; cursor: pointer; position: relative; border-radius: 15px; }
        .month-card:hover { border-color: var(--primary) !important; background: rgba(var(--primary-rgb), 0.02); }
        .bg-primary-light { background: rgba(11,61,97,0.05); }
        .x-small { font-size: 11px; }
    </style>

    <!-- ====== VISA ASSISTANCE ====== -->
    <section class="py-4 position-relative overflow-hidden" style="background: #f1f5f9;">
        <div class="container">
            <div class="card-premium p-0 overflow-hidden border-0 shadow-lg">
                <div class="row g-0">
                    <div class="col-lg-5 p-5 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, var(--navy) 0%, #001f3f 100%); color: #fff;">
                        <span class="badge bg-primary mb-3 align-self-start py-2 px-3 fw-bold"><i class="fas fa-shield-halved me-1"></i> VERIFIED EXPERTS</span>
                        <h2 class="display-6 fw-900 mb-3">Get Your <span class="highlight-orange">Visa</span> Hassle-Free</h2>
                        <p class="text-white-50 mb-4 fw-bold">Fast, secure, and reliable visa services for over 150+ destinations worldwide. 3-day average processing time.</p>
                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="d-flex align-items-center gap-2 small fw-bold text-white-50"><i class="fas fa-circle-check text-success"></i> 99.2% Approval Success Rate</div>
                            <div class="d-flex align-items-center gap-2 small fw-bold text-white-50"><i class="fas fa-circle-check text-success"></i> Express Processing Available</div>
                        </div>
                        <a href="{{ route('visa.index') }}" class="btn btn-orange px-5 py-3 rounded-pill fw-bold" style="width:fit-content;">Search Requirements <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                    <div class="col-lg-7 p-5 bg-white">
                        <h5 class="fw-900 text-navy mb-4">Quick Visa Check</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-700 text-muted mb-2">WHERE ARE YOU GOING?</label>
                                <div class="input-group-mmt p-2 border rounded-3 d-flex align-items-center gap-2">
                                    <i class="fas fa-location-dot text-primary ms-2"></i>
                                    <input type="text" class="form-control border-0 shadow-none fw-bold" placeholder="Select Destination">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-700 text-muted mb-2">VISA TYPE</label>
                                <div class="input-group-mmt p-2 border rounded-3 d-flex align-items-center gap-2">
                                    <i class="fas fa-passport text-primary ms-2"></i>
                                    <select class="form-select border-0 shadow-none fw-bold">
                                        <option>Tourist Visa</option>
                                        <option>Business Visa</option>
                                        <option>Student Visa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="small fw-700 text-muted mb-2">INTENDED TRAVEL DATE</label>
                                <div class="input-group-mmt p-2 border rounded-3 d-flex align-items-center gap-2">
                                    <i class="fas fa-calendar text-primary ms-2"></i>
                                    <input type="date" class="form-control border-0 shadow-none fw-bold" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <a href="{{ route('visa.listing') }}" class="btn btn-navy w-100 py-3 rounded-pill fw-bold shadow">CHECK VISA DETAILS <i class="fas fa-magnifying-glass ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== EXCLUSIVE OFFERS ====== -->
    <section class="py-4 TS-5 reveal stagger-children">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="main-title">Handpicked Offers</h2>
                    <p class="section-subtitle">Curated deals you won't find anywhere else</p>
                </div>
                <a href="#" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
            </div>

            <!-- Offer category tabs -->
            <div class="d-flex gap-2 mb-4 flex-wrap">
                <button class="btn btn-sm px-4 py-2 fw-700 rounded-pill shadow-sm" style="background:linear-gradient(135deg, var(--primary), var(--primary-dark));color:#fff;font-size:12px;">All Offers</button>
                <button class="btn btn-sm px-4 py-2 fw-600 rounded-pill glow-hover" style="background:var(--white);color:var(--gray-400);font-size:12px;border:1px solid var(--gray-100);">Flights</button>
                <button class="btn btn-sm px-4 py-2 fw-600 rounded-pill glow-hover" style="background:var(--white);color:var(--gray-400);font-size:12px;border:1px solid var(--gray-100);">Hotels</button>
                <button class="btn btn-sm px-4 py-2 fw-600 rounded-pill glow-hover" style="background:var(--white);color:var(--gray-400);font-size:12px;border:1px solid var(--gray-100);">Homestays</button>
                <button class="btn btn-sm px-4 py-2 fw-600 rounded-pill glow-hover" style="background:var(--white);color:var(--gray-400);font-size:12px;border:1px solid var(--gray-100);">Bank Offers</button>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <x-offer-card
                        title="Flat 25% Off on Domestic Flights"
                        category="Flights"
                        desc="Save big on your next domestic trip. Use code EASI25 at checkout."
                        image="https://images.unsplash.com/photo-1544016768-982d1554f0b9?w=600&auto=format&fit=crop&q=80"
                        discount="25% OFF"
                    />
                </div>
                <div class="col-lg-4 col-md-6">
                    <x-offer-card
                        title="Luxury Hotel Stays from ₹2,999"
                        category="Hotels"
                        desc="5-star hotels at 3-star prices. Book premium stays across India."
                        image="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&auto=format&fit=crop&q=80"
                        discount="Up to 40% OFF"
                    />
                </div>
                <div class="col-lg-4 col-md-6">
                    <x-offer-card
                        title="Weekend Homestay Special"
                        category="Homestays"
                        desc="Cozy villas and cottages in the hills. Perfect weekend getaway deals."
                        image="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=600&auto=format&fit=crop&q=80"
                        discount="₹999 OFF"
                    />
                </div>
            </div>
        </div>
    </section>

    <!-- ====== EXPLORE ON MAP (NEW) ====== -->
    <section class="py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0b3d61 0%, #001f3f 100%); color: #fff;">
        <div class="map-bg-decoration"></div>
        <div class="container position-relative" style="z-index:2;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="tag-premium mb-3 d-inline-block" style="background: rgba(255,255,255,0.1); color: #fff;">NEW FEATURE</span>
                    <h2 class="main-title text-white mb-4">Visualize Your Next <span class="highlight-orange">Journey</span></h2>
                    <p class="text-white-50 fs-5 mb-5 leading-relaxed">
                        Say goodbye to boring lists. Explore the world through our interactive map interface. Compare flight prices across continents and find the perfect hotel by the beach—all in one visual experience.
                    </p>
                    
                    <div class="d-flex flex-column gap-3 mb-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-glass"><i class="fas fa-plane-departure"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Local & International Routes</h6>
                                <p class="small text-white-50 mb-0">See real-time pricing for 500+ destinations on a global scale.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-glass"><i class="fas fa-map-marked-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Neighborhood Hotspots</h6>
                                <p class="small text-white-50 mb-0">Find hotels near the best attractions and beaches instantly.</p>
                            </div>
                        </div>
                    </div>

                    <a href="/explore-map" class="btn btn-orange px-5 py-3 rounded-pill fw-bold shadow-lg hvr-grow">
                        Launch Interactive Map <i class="fas fa-map-location-dot ms-2"></i>
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="map-preview-card">
                        <div class="map-preview-header d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <div class="dot red"></div>
                                <div class="dot yellow"></div>
                                <div class="dot green"></div>
                            </div>
                            <div class="map-preview-title">Live Booking Map</div>
                        </div>
                        <div class="map-preview-img">
                            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=800&auto=format&fit=crop&q=80" alt="Map Preview">
                            
                            <!-- Fake Price Badges -->
                            <div class="price-badge-preview pb-1 animate-pulse" style="top: 30%; left: 40%;">₹4,250</div>
                            <div class="price-badge-preview pb-2 animate-pulse" style="top: 55%; left: 25%; animation-delay: 0.5s;">₹3,400</div>
                            <div class="price-badge-preview pb-3 animate-pulse" style="top: 45%; left: 70%; animation-delay: 1s;">₹5,100</div>
                            
                            <!-- Fake Path Lines -->
                            <svg class="map-paths" viewBox="0 0 400 300">
                                <path d="M120,180 Q200,100 280,135" stroke="rgba(255,165,0,0.4)" fill="transparent" stroke-width="2" stroke-dasharray="5,5" />
                                <path d="M120,180 Q200,240 280,210" stroke="rgba(255,165,0,0.4)" fill="transparent" stroke-width="2" stroke-dasharray="5,5" />
                            </svg>
                        </div>
                        <div class="map-preview-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="pulse-dot"></div>
                                    <span class="small fw-700">12,482 Travelers exploring right now</span>
                                </div>
                                <div class="d-flex -space-x-2">
                                    <img src="https://ui-avatars.com/api/?name=A&background=random" class="avatar-sm">
                                    <img src="https://ui-avatars.com/api/?name=B&background=random" class="avatar-sm">
                                    <img src="https://ui-avatars.com/api/?name=C&background=random" class="avatar-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<style>
    .map-bg-decoration {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.5;
    }

    .icon-circle-glass {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--primary-light);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .map-preview-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        transform: perspective(1000px) rotateY(-10deg);
        border: 1px solid rgba(255,255,255,0.1);
        transition: transform 0.5s ease;
    }

    .map-preview-card:hover {
        transform: perspective(1000px) rotateY(0deg) scale(1.02);
    }

    .map-preview-header {
        padding: 12px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .dot { width: 10px; height: 10px; border-radius: 50%; }
    .dot.red { background: #ff5f56; }
    .dot.yellow { background: #ffbd2e; }
    .dot.green { background: #27c93f; }

    .map-preview-title { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

    .map-preview-img { position: relative; height: 350px; background: #e2e8f0; overflow: hidden; }
    .map-preview-img img { width: 100%; height: 100%; object-fit: cover; filter: saturate(1.2) contrast(1.1); }

    .price-badge-preview {
        position: absolute;
        background: #fff;
        color: #1e293b;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 900;
        font-size: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        border: 2px solid var(--primary);
    }

    .map-paths { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; }

    .map-preview-footer { padding: 15px 20px; color: #1e293b; }

    .pulse-dot { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: pulse-green 2s infinite; }

    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        100% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
    }

    .avatar-sm { width: 28px; height: 28px; border-radius: 50%; border: 2px solid #fff; margin-left: -10px; }
    .-space-x-2 { margin-left: 10px; }

    .animate-pulse { animation: soft-pulse 3s infinite ease-in-out; }
    @keyframes soft-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .highlight-orange { color: #f97316; }
</style>
    <section class="py-5 tripstay-about-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="misty-about-img-group">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&auto=format&fit=crop&q=80" alt="Misty Mountains" class="img-main">
                        <div class="floating-badge-about">
                            <h4 class="mb-0 fw-900">12+</h4>
                            <span class="small">Years of Trust</span>
                        </div>
                        <img src="https://images.unsplash.com/photo-1542224566-6e85f2e6772f?w=400&auto=format&fit=crop&q=80" alt="Travel Culture" class="img-sub">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ps-lg-5">
                        <span class="tag-premium mb-3 d-inline-block">SINCE 2014</span>
                        <h2 class="main-title mb-4">Who we are at Trip Zant</h2>
                        <p class="text-muted fs-5 mb-4 leading-relaxed">
                            Tripzant.com is not just a portal—it's a collection of travel curators, tech visionaries, and explorers who believe that every mile traveled should tell a story. Dedicated to bringing you the most soul-stirring stays and seamless journeys across the globe.
                        </p>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="icon-circle-about"><i class="fas fa-gem"></i></div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Curated Luxury</h6>
                                        <p class="small text-muted mb-0">Handpicked villas & hotels that offer true character.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="icon-circle-about"><i class="fas fa-shield-alt"></i></div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Absolute Trust</h6>
                                        <p class="small text-muted mb-0">Verified properties with 100% money-back guarantee.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="icon-circle-about"><i class="fas fa-headset"></i></div>
                                    <div>
                                        <h6 class="fw-bold mb-1">24/7 Human Edge</h6>
                                        <p class="small text-muted mb-0">Real travel experts available for you at every mile.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="icon-circle-about"><i class="fas fa-bolt"></i></div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Instant Confirms</h6>
                                        <p class="small text-muted mb-0">Zero wait-time with our revolutionary AI booking engine.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="/about" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-lg">Read Our Story <i class="fas fa-play-circle ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== POPULAR DESTINATIONS ====== -->
    <section class="py-5 reveal">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="main-title">Trending Destinations</h2>
                    <p class="section-subtitle">Most searched places by travellers this month</p>
                </div>
                <a href="#" class="view-all-link">Explore All <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="row g-3">
                <div class="col-lg-5 col-md-6">
                    <div class="dest-card" style="height: 340px;">
                        <img src="https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=700&auto=format&fit=crop&q=80" alt="Goa">
                        <div class="dest-card-overlay">
                            <h5>Goa</h5>
                            <span>Beaches, Nightlife & Culture · Starting ₹5,500</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="dest-card" style="height: 340px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/da/Taj_Mahal%2C_Agra%2C_India_edit2.jpg" alt="Agra">
                        <div class="dest-card-overlay">
                            <h5>Agra</h5>
                            <span>Heritage & Wonder · Starting ₹3,500</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="dest-card" style="height: 340px;">
                        <img src="https://images.unsplash.com/photo-1506038634487-60a69ae4b7b1?w=600&auto=format&fit=crop&q=80" alt="Kerala">
                        <div class="dest-card-overlay">
                            <h5>Kerala</h5>
                            <span>Backwaters & Ayurveda · Starting ₹8,400</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="dest-card">
                        <img src="https://images.unsplash.com/photo-1524230572899-a752b3835840?w=600&auto=format&fit=crop&q=80" alt="Ladakh">
                        <div class="dest-card-overlay">
                            <h5>Ladakh</h5>
                            <span>Mountains & Adventure · Starting ₹12,999</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="dest-card">
                        <img src="https://images.unsplash.com/photo-1585123334904-845d60e97b29?w=600&auto=format&fit=crop&q=80" alt="Delhi">
                        <div class="dest-card-overlay">
                            <h5>Delhi</h5>
                            <span>Capital & History · Starting ₹2,800</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="dest-card">
                        <img src="https://images.unsplash.com/photo-1566552881560-0be862a7c445?w=600&auto=format&fit=crop&q=80" alt="Mumbai">
                        <div class="dest-card-overlay">
                            <h5>Mumbai</h5>
                            <span>City of Dreams · Starting ₹4,200</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== TOUR BUILDER / PACKAGES (NEW SECTION) ====== -->
    <section class="py-5 bg-white reveal">
        <div class="container text-navy">
            <div class="row align-items-end mb-5">
                <div class="col-lg-6">
                    <span class="text-primary fw-900 small mb-2 d-block letter-spacing-1">👉 CURATED JOURNEYS</span>
                    <h2 class="main-title mb-0 text-navy">Tour Builder / Packages</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p class="text-muted small mb-3">Build your own dream itinerary or choose from our best-sellers.</p>
                    <a href="/tours/listings" class="btn btn-outline-navy rounded-pill px-4 fw-bold shadow-sm hvr-grow">Explore All Packages <i class="fas fa-chevron-right ms-2"></i></a>
                </div>
            </div>

            <div class="row g-4">
                @foreach($tours as $pkg)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 tour-package-card hvr-grow shadow-lg border-0 overflow-hidden rounded-4">
                        <div class="position-relative">
                            <img src="{{ $pkg->image ?: 'https://images.unsplash.com/photo-1548013146-72479768b921?w=800&auto=format&fit=crop&q=80' }}" class="w-100" style="height: 250px; object-fit:cover;">
                            <div class="badge bg-white text-navy fw-900 border position-absolute top-0 start-0 m-3 px-3 py-2 shadow-sm rounded-pill" style="font-size: 10px; z-index: 2;">{{ $pkg->location ?: 'FEATURED' }}</div>
                            <div class="tour-duration-badge position-absolute bottom-0 end-0 m-3 px-3 py-1 bg-navy text-white fw-bold rounded-pill shadow-sm" style="font-size:11px; z-index: 2;">{{ $pkg->duration }}</div>
                        </div>
                        <div class="p-4 bg-white border-top border-light">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="text-warning small"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                                <span class="text-muted small fw-bold">4.8 ({{ rand(100, 999) }} reviews)</span>
                            </div>
                            <h5 class="fw-800 text-navy mb-3" style="height: 48px; overflow: hidden; line-height: 1.2;">{{ $pkg->title }}</h5>
                            <hr class="my-3 opacity-10">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="small text-muted fw-bold mb-0">Starting from</div>
                                    <div class="fw-900 text-navy fs-4">₹{{ number_format($pkg->price) }} <span style="font-size:10px; color:#aaa;">per person</span></div>
                                </div>
                                <a href="/tours/details/{{ $pkg->id }}" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm">View Tour</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ====== POPULAR eSIM COUNTRIES (NEW SECTION) ====== -->
    <section class="py-4 bg-white reveal stagger-children" style="border-top:1px solid #f1f5f9;">
        <div class="container text-navy">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="text-primary fw-900 small mb-2 d-block letter-spacing-1">🔥 TRENDING DATA PLANS</span>
                    <h2 class="main-title mb-0 text-navy">Popular eSIM Countries</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="/esim/listings" class="btn btn-outline-navy rounded-pill px-4 fw-bold shadow-sm hvr-grow">All eSIM Plans <i class="fas fa-chevron-right ms-2"></i></a>
                </div>
            </div>

            <div class="row g-4">
                @foreach($esims as $sim)
                <div class="col-lg-4 col-md-6">
                    <div class="esim-pill-card d-flex align-items-center gap-3 p-3 bg-white shadow-sm border border-light hvr-grow rounded-pill mb-1">
                        <div class="esim-flag-wrap flex-shrink-0" style="width: 40px; height: 30px; overflow: hidden; border-radius: 4px;">
                            <img src="https://flagcdn.com/w80/{{ strtolower($sim->country_code ?: 'us') }}.png" style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #f1f5f9;">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-800 text-navy mb-0" style="font-size: 14px;">{{ $sim->region }}</h6>
                            <p class="text-muted small fw-bold mb-0">From ${{ $sim->price }}/GB</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

<style>
    .esim-pill-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .esim-pill-card:hover {
        background: #fff;
        border-color: var(--primary) !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        transform: scale(1.02);
    }
</style>

    <!-- ====== TOP RATED HOTELS ====== -->
    <section class="py-4 reveal" style="background:#f8fafc;">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="main-title">Top Rated Hotels</h2>
                    <p class="section-subtitle">Hand-picked premium hotels loved by guests</p>
                </div>
                <a href="/hotels" class="view-all-link">View All Hotels <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card-premium">
                        <div class="card-img-wrap">
                            <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500&auto=format&fit=crop&q=80" alt="Taj Palace">
                            <span class="card-img-overlay-badge"><i class="fas fa-crown me-1" style="color:var(--primary)"></i> Luxury</span>
                            <div class="card-img-overlay-heart"><i class="far fa-heart"></i></div>
                        </div>
                        <div class="card-body-premium">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="rating-pill"><i class="fas fa-star" style="font-size:10px"></i> 4.9</span>
                                <span style="font-size:12px;color:var(--gray-300)">480 reviews</span>
                            </div>
                            <h6 class="card-title-premium">Taj Palace, New Delhi</h6>
                            <p class="card-location"><i class="fas fa-map-marker-alt"></i> Diplomatic Enclave, Delhi</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="price-tag-crossed">₹32,000</span>
                                    <span class="price-tag">₹24,500</span>
                                    <div class="price-per-night">per night</div>
                                </div>
                                <span class="discount-badge">24% OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-premium">
                        <div class="card-img-wrap">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&auto=format&fit=crop&q=80" alt="The Leela">
                            <span class="card-img-overlay-badge"><i class="fas fa-star me-1" style="color:var(--secondary)"></i> 5 Star</span>
                            <div class="card-img-overlay-heart"><i class="far fa-heart"></i></div>
                        </div>
                        <div class="card-body-premium">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="rating-pill"><i class="fas fa-star" style="font-size:10px"></i> 4.8</span>
                                <span style="font-size:12px;color:var(--gray-300)">320 reviews</span>
                            </div>
                            <h6 class="card-title-premium">The Leela Goa</h6>
                            <p class="card-location"><i class="fas fa-map-marker-alt"></i> Cavelossim, South Goa</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="price-tag-crossed">₹38,000</span>
                                    <span class="price-tag">₹28,500</span>
                                    <div class="price-per-night">per night</div>
                                </div>
                                <span class="discount-badge">25% OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-premium">
                        <div class="card-img-wrap">
                            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&auto=format&fit=crop&q=80" alt="Oberoi Udaivilas">
                            <span class="card-img-overlay-badge"><i class="fas fa-gem me-1" style="color:var(--secondary)"></i> Premium</span>
                            <div class="card-img-overlay-heart"><i class="far fa-heart"></i></div>
                        </div>
                        <div class="card-body-premium">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="rating-pill"><i class="fas fa-star" style="font-size:10px"></i> 4.9</span>
                                <span style="font-size:12px;color:var(--gray-300)">265 reviews</span>
                            </div>
                            <h6 class="card-title-premium">Oberoi Udaivilas, Udaipur</h6>
                            <p class="card-location"><i class="fas fa-map-marker-alt"></i> Pichola, Udaipur</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="price-tag-crossed">₹55,000</span>
                                    <span class="price-tag">₹42,000</span>
                                    <div class="price-per-night">per night</div>
                                </div>
                                <span class="discount-badge">23% OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-premium">
                        <div class="card-img-wrap">
                            <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=500&auto=format&fit=crop&q=80" alt="ITC Grand">
                            <span class="card-img-overlay-badge"><i class="fas fa-fire me-1" style="color:var(--red)"></i> Trending</span>
                            <div class="card-img-overlay-heart"><i class="far fa-heart"></i></div>
                        </div>
                        <div class="card-body-premium">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="rating-pill"><i class="fas fa-star" style="font-size:10px"></i> 4.7</span>
                                <span style="font-size:12px;color:var(--gray-300)">580 reviews</span>
                            </div>
                            <h6 class="card-title-premium">ITC Grand Chola, Chennai</h6>
                            <p class="card-location"><i class="fas fa-map-marker-alt"></i> Guindy, Chennai</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="price-tag-crossed">₹18,000</span>
                                    <span class="price-tag">₹13,500</span>
                                    <div class="price-per-night">per night</div>
                                </div>
                                <span class="discount-badge">25% OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== HOMESTAYS & VILLAS ====== -->
    <section class="py-4 reveal stagger-children" style="background:#fff;">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="main-title">Homestays & Villas</h2>
                    <p class="section-subtitle">Escape to cozy homes in nature's lap</p>
                </div>
                <a href="/homestays" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="row g-4">
                @foreach($homestays as $home)
                <div class="col-lg-4 col-md-6">
                    <div class="card-premium h-100">
                        <div class="card-img-wrap" style="height:220px;">
                            <img src="{{ $home->image_url ?: 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=600&auto=format&fit=crop&q=80' }}" alt="{{ $home->title }}">
                            <span class="card-img-overlay-badge"><i class="fas fa-leaf me-1" style="color:#22c55e"></i> Verified</span>
                            <div class="card-img-overlay-heart"><i class="far fa-heart"></i></div>
                        </div>
                        <div class="card-body-premium">
                            <span class="tag-green">ENTIRE PROPERTY · {{ $home->city }}</span>
                            <h6 class="card-title-premium">{{ $home->title }}</h6>
                            <p class="card-location"><i class="fas fa-map-marker-alt"></i> {{ $home->city }}</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div>
                                    <span class="price-tag">₹{{ number_format($home->price_per_night) }}</span>
                                    <div class="price-per-night">per night</div>
                                </div>
                                <a href="/homestays/details/{{ $home->id }}" class="btn btn-sm btn-navy rounded-pill px-3 fw-bold">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ====== PARTNER SHOWCASE (DYNAMIC PREVIEW) ====== -->
    <section class="py-5 reveal" style="background:#fff;">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="main-title">Partner Showcase</h2>
                    <p class="section-subtitle">Premium listings verified and managed by our trusted partners</p>
                </div>
                <div class="badge bg-navy text-white rounded-pill px-3 py-1 fw-bold" style="font-size:10px;">PARTNER EMPOWERED</div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="partner-featured-card d-flex align-items-center gap-4 p-4 rounded-4 shadow-sm border hvr-grow" style="background: linear-gradient(to right, #ffffff, #f8fafc);">
                        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109c05e?w=300" class="rounded-3 shadow-sm" width="150" height="110" style="object-fit:cover;">
                        <div>
                            <span class="badge bg-blue-light text-blue mb-2">PARTNER: SKYBOUND TRAVEL</span>
                            <h5 class="fw-900 text-navy mb-1">Direct Flights: Delhi to Dubai</h5>
                            <p class="text-muted small mb-3">Managed by our aviation partners for the best dynamic rates.</p>
                            <div class="fw-900 text-navy fs-5">Starting ₹14,200</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="partner-featured-card d-flex align-items-center gap-4 p-4 rounded-4 shadow-sm border hvr-grow" style="background: linear-gradient(to right, #ffffff, #f8fafc);">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=300" class="rounded-3 shadow-sm" width="150" height="110" style="object-fit:cover;">
                        <div>
                            <span class="badge bg-orange-light text-orange mb-2">PARTNER: ELITE STAYS</span>
                            <h5 class="fw-900 text-navy mb-1">The Grand Heritage Palace</h5>
                            <p class="text-muted small mb-3">Exclusive luxury inventory managed directly by hotel owners.</p>
                            <div class="fw-900 text-navy fs-5">Starting ₹18,500 <span style="font-size:10px; color:#aaa;">/night</span></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="text-muted small">Are you a travel service provider? <a href="/partner/signup" class="text-navy fw-bold text-decoration-none border-bottom border-navy pb-1">Become a Trip Zant Partner</a></p>
            </div>
        </div>
    </section>

    <!-- ====== WHY CHOOSE US ====== -->
    <section class="py-5 reveal" style="background:var(--white);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="main-title">Why Book with Trip Zant?</h2>
                <p class="section-subtitle">Join millions of happy travellers who trust us</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="why-card">
                        <div class="why-icon"><i class="fas fa-shield-halved"></i></div>
                        <h5 class="fw-800 mb-2" style="font-size:16px;">Secure Payments</h5>
                        <p style="font-size:13px;color:var(--gray-300);">Transactions protected with 256-bit encryption technology.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="why-card">
                        <div class="why-icon" style="background:rgba(37,99,235,.1);"><i class="fas fa-headset" style="color:var(--primary)"></i></div>
                        <h5 class="fw-800 mb-2" style="font-size:16px;">24/7 Support</h5>
                        <p style="font-size:13px;color:var(--gray-300);">Our travel experts are always here to help, day or night.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="why-card">
                        <div class="why-icon" style="background:rgba(39,174,96,.1);"><i class="fas fa-tags" style="color:var(--green)"></i></div>
                        <h5 class="fw-800 mb-2" style="font-size:16px;">Best Price Guarantee</h5>
                        <p style="font-size:13px;color:var(--gray-300);">Found a lower price? We'll match it and give you extra cashback.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="why-card">
                        <div class="why-icon" style="background:rgba(11,61,97,.1);"><i class="fas fa-bolt" style="color:var(--navy)"></i></div>
                        <h5 class="fw-800 mb-2" style="font-size:16px;">Instant Confirmation</h5>
                        <p style="font-size:13px;color:var(--gray-300);">Get real-time booking confirmations and e-tickets instantly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== TESTIMONIALS ====== -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="main-title">What Travellers Say</h2>
                <p class="section-subtitle">Real reviews from real customers</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="quote">"Tripzant.com made our Goa vacation planning effortless. The hotel suggestions were spot on and we saved over ₹8,000 compared to booking directly!"</div>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Priya+Sharma&background=0b3d61&color=fff&size=64" class="testimonial-avatar" alt="">
                            <div>
                                <h6 class="fw-700 mb-0" style="font-size:14px;">Priya Sharma</h6>
                                <span style="font-size:12px;color:var(--gray-300);">Mumbai · 5 trips booked</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="quote">"The 24/7 support saved our trip when our flight got delayed. They rebooked us within minutes. Absolutely impressed with the service quality."</div>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Arjun+Patel&background=2563eb&color=fff&size=64" class="testimonial-avatar" alt="">
                            <div>
                                <h6 class="fw-700 mb-0" style="font-size:14px;">Arjun Patel</h6>
                                <span style="font-size:12px;color:var(--gray-300);">Delhi · 12 trips booked</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="quote">"I've been using Tripzant.com for 2 years now. The loyalty points and exclusive member discounts are genuinely amazing. Highly recommended!"</div>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Sneha+Reddy&background=00a8e1&color=fff&size=64" class="testimonial-avatar" alt="">
                            <div>
                                <h6 class="fw-700 mb-0" style="font-size:14px;">Sneha Reddy</h6>
                                <span style="font-size:12px;color:var(--gray-300);">Hyderabad · 8 trips booked</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CTA BANNER ====== -->
    <section class="py-4">
        <div class="container">
            <div class="cta-banner">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h3>Download the Tripzant.com App</h3>
                        <p style="opacity:.7;font-size:15px;margin-bottom:0;">Exclusive app-only deals, real-time alerts, and seamless travel management on the go.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end TS-3 TS-lg-0">
                        <a href="#" class="btn" style="background:var(--primary);color:#fff;padding:14px 36px;border-radius:999px;font-weight:700;font-size:15px;">Get the App <i class="fas fa-mobile-alt ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== POPULAR ROUTES ====== -->
    <section class="py-5" style="background:var(--white);">
        <div class="container">
            <h2 class="main-title mb-4">Popular Flight Routes</h2>
            <div class="row g-3">
                @php
                $routes = [
                    ['from' => 'Delhi', 'to' => 'Mumbai', 'price' => '4,250'],
                    ['from' => 'Bangalore', 'to' => 'Delhi', 'price' => '5,100'],
                    ['from' => 'Mumbai', 'to' => 'Goa', 'price' => '3,400'],
                    ['from' => 'Delhi', 'to' => 'Kolkata', 'price' => '4,800'],
                    ['from' => 'Chennai', 'to' => 'Hyderabad', 'price' => '3,200'],
                    ['from' => 'Mumbai', 'to' => 'Delhi', 'price' => '4,500'],
                    ['from' => 'Bangalore', 'to' => 'Mumbai', 'price' => '3,900'],
                    ['from' => 'Delhi', 'to' => 'Jaipur', 'price' => '2,800'],
                ];
                @endphp
                @foreach($routes as $route)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="/flights" class="d-block p-3 rounded-3 border" style="border-color:var(--gray-100)!important;transition:var(--transition-fast);" onmouseover="this.style.borderColor='var(--blue)'" onmouseout="this.style.borderColor='var(--gray-100)'">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;border-radius:50%;background:rgba(0,168,225,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-plane text-blue" style="font-size:14px;"></i>
                            </div>
                            <div>
                                <div class="fw-700" style="font-size:13px;">{{ $route['from'] }} → {{ $route['to'] }}</div>
                                <div style="font-size:12px;color:var(--gray-300);">From <span class="fw-700 text-navy">₹{{ $route['price'] }}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

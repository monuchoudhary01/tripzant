@extends('layouts.app')

@section('title', "Explore on Map — Flights & Hotels | Trip Zant")

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --map-sidebar-width: 400px;
        --map-top-bar-height: 80px;
    }

    .explore-map-page {
        height: calc(100vh - 70px); 
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #f8fafc;
    }

    .map-filter-bar {
        height: 50px;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        padding: 0 24px;
        gap: 20px;
        z-index: 998;
    }

    /* Top Search Bar */
    .map-top-nav {
        height: var(--map-top-bar-height);
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        padding: 0 24px;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .map-search-engine {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f1f5f9;
        padding: 8px 16px;
        border-radius: 99px;
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .search-input-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        border-right: 1px solid #cbd5e1;
        padding-right: 12px;
    }

    .search-input-group:last-child {
        border-right: none;
    }

    .search-input-group i {
        color: var(--primary);
    }

    .search-input-group input {
        background: transparent;
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 500;
        width: 100%;
    }

    .btn-map-search {
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-map-search:hover {
        transform: scale(1.1);
        background: var(--primary-dark);
    }

    /* Main Content */
    .map-content-area {
        display: flex;
        flex: 1;
        position: relative;
    }

    /* Responsive Fixes */
    @media (max-width: 768px) {
        :root {
            --map-sidebar-width: 100%;
            --map-top-bar-height: auto;
        }
        
        .map-top-nav {
            padding: 12px;
            flex-direction: column;
        }

        .map-search-engine {
            flex-direction: column;
            border-radius: 16px;
            padding: 12px;
        }

        .search-input-group {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #cbd5e1;
            padding: 8px 0;
        }

        .map-filter-bar {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            gap: 12px;
            -webkit-overflow-scrolling: touch;
        }

        .map-filter-bar::-webkit-scrollbar { display: none; }

        .map-content-area {
            flex-direction: column-reverse;
        }

        .map-sidebar {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 70vh;
            width: 100%;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            border-right: none;
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -15px 40px rgba(0,0,0,0.2);
            z-index: 10001;
            background: #fff;
        }

        .map-sidebar.mobile-open {
            transform: translateY(0);
        }

        .mobile-toggle-btn {
            display: flex !important;
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10002;
            background: #008cff;
            color: #fff;
            padding: 12px 28px;
            border-radius: 99px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(0,140,255,0.4);
            border: none;
            gap: 10px;
            align-items: center;
            transition: all 0.3s ease;
        }

        .sidebar-handle {
            display: block !important;
            width: 40px;
            height: 40px;
            background: #e2e8f0;
            border-radius: 20px;
            margin: 8px auto;
        }
    }

    .mobile-toggle-btn { display: none; }
    .sidebar-handle { display: none; }

    .sidebar-tabs {
        display: flex;
        padding: 16px;
        gap: 12px;
        border-bottom: 1px solid #e2e8f0;
        background: #fff;
    }

    .sidebar-tab {
        flex: 1;
        padding: 12px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #64748b;
    }

    .sidebar-tab.active {
        border-color: var(--primary);
        background: rgba(var(--primary-rgb), 0.05);
        color: var(--primary);
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.1);
    }

    .sidebar-tab i { font-size: 18px; }
    .sidebar-tab span { font-size: 12px; font-weight: 700; }

    .sidebar-scroll-area {
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .listings-container {
        padding: 0 16px 16px 16px;
    }

    .listing-card {
        border: 1.5px solid #f1f5f9;
        border-radius: 16px;
        margin-bottom: 16px;
        padding: 12px;
        display: flex;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .listing-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .listing-card.active {
        border-color: var(--primary);
        background: rgba(var(--primary-rgb), 0.02);
    }

    .listing-card.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary);
    }

    .listing-image {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
    }

    .listing-info {
        flex: 1;
    }

    .listing-title {
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 4px;
        color: #1e293b;
    }

    .listing-meta {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .listing-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .listing-price {
        font-size: 18px;
        font-weight: 900;
        color: var(--primary);
    }

    .listing-rating {
        background: #fefce8;
        color: #854d0e;
        padding: 2px 6px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Map Styles */
    .map-canvas {
        flex: 1;
        background: #cbd5e1;
        position: relative;
    }

    .custom-price-marker {
        background: #1e293b;
        color: #fff;
           border-radius: 99px;
    padding: 3px 4px;
    font-weight: 800;
    font-size: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border: 1.5px solid rgba(255, 255, 255, 0.2);
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 500;
}

    .filter-pill {
        padding: 6px 12px;
        border-radius: 50px;
        border: 1.5px solid #e2e8f0;
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        cursor: pointer;
        transition: 0.2s;
        background: #fff;
    }
    .filter-pill:hover { border-color: #008cff; color: #008cff; background: #f0f7ff; }
    .filter-pill.active { background: #008cff; color: #fff; border-color: #008cff; box-shadow: 0 4px 10px rgba(0,140,255,0.2); }

    .custom-range::-webkit-slider-thumb { background: #008cff; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,140,255,0.3); }
    .custom-range::-moz-range-thumb { background: #008cff; border: 3px solid #fff; }
    }

    .custom-price-marker.active {
        background: var(--primary);
        color: #fff;
        border-color: #fff;
        transform: scale(1.15);
        z-index: 1001 !important;
        box-shadow: 0 8px 25px rgba(var(--primary-rgb), 0.4);
    }

    .marker-icon {
        width: 14px;
        height: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        opacity: 0.8;
    }

    /* Toggle Switches on Map */
    .map-overlay-controls {
        position: absolute;
        top: 24px;
        right: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        z-index: 1000;
    }

    .map-layer-btn {
        background: #fff;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .map-layer-btn:hover {
        color: var(--primary);
    }

    .map-layer-btn.active {
        background: var(--primary);
        color: #fff;
    }

    /* Autocomplete */
    .autocomplete-results { 
        position: absolute; 
        top: 100%; 
        left: 0; 
        width: 350px; 
        max-height: 350px; 
        overflow-y: auto; 
        background: #fff; 
        box-shadow: 0 15px 45px rgba(0,0,0,0.15); 
        border-radius: 12px; 
        z-index: 10000; 
        margin-top: 10px;
    }
    .mmt-ac-item { padding: 12px 15px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: background 0.2s; border-bottom: 1px solid #f1f5f9; }
    .mmt-ac-item:hover { background: #f0f7ff; }
    .mmt-ac-box { background: #eef2f6; color: #1e40af; font-weight: 900; padding: 4px 8px; border-radius: 4px; font-size: 11px; min-width: 45px; text-align: center; }
    .mmt-ac-city { color: #001d3d; font-weight: 800; font-size: 14px; text-align: left; }
    .mmt-ac-airport { color: #64748b; font-size: 11px; text-align: left; }
    .mmt-pills-container { display: flex; flex-wrap: wrap; gap: 8px; }
    .mmt-modern-pill, .mmt-class-pill-lg {
        padding: 10px 18px;
        border-radius: 99px;
        border: 1.5px solid #e2e8f0;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }
    .mmt-modern-pill:hover, .mmt-class-pill-lg:hover { border-color: var(--primary); }
    .mmt-modern-pill.active, .mmt-class-pill-lg.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 4px 15px rgba(var(--primary-rgb), 0.3);
    }
    #mmtTravelerDropdown {
        top: 100%;
        right: 0;
        min-width: 400px;
        z-index: 2000;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    .search-input-group.disabled {
        opacity: 0.3;
        pointer-events: none;
    }
</style>

@section('styles')
<style>
    /* Hide global AI Pill on this specific page */
    .misty-meta-ai-pill { display: none !important; }
</style>
@endsection

<div class="explore-map-page">
    <!-- Top Search Bar -->
    <div class="map-top-nav">
        <form action="{{ route('explore.map') }}" method="GET" class="map-search-engine" style="max-width: 1200px; position: relative;">
            <div class="search-input-group" style="flex: 0.6; min-width: 110px;">
                <select name="trip" id="tripTypeSelect" class="bg-transparent border-0 fw-800 text-navy" style="outline:none; font-size: 13px; cursor: pointer;" onchange="updateTripType()">
                    <option value="one" {{ ($trip ?? 'one') == 'one' ? 'selected' : '' }}>One Way</option>
                    <option value="round" {{ ($trip ?? '') == 'round' ? 'selected' : '' }}>Round Trip</option>
                </select>
            </div>
            <div class="search-input-group" style="position: relative;">
                <i class="fas fa-plane-departure"></i>
                <input type="text" name="origin" id="originInput" placeholder="From" value="{{ $origin ?? 'DEL' }}" autocomplete="off" style="background: transparent; border: none; outline: none; font-size: 14px; font-weight: 700; color: #1e293b; width: 100%;">
                <div id="originResults" class="autocomplete-results d-none"></div>
            </div>
            <div class="search-input-group" style="position: relative;">
                <i class="fas fa-plane-arrival"></i>
                <input type="text" name="destination" id="destinationInput" placeholder="To" value="{{ $destination ?? 'Anywhere' }}" autocomplete="off" style="background: transparent; border: none; outline: none; font-size: 14px; font-weight: 700; color: #1e293b; width: 100%;">
                <div id="destinationResults" class="autocomplete-results d-none"></div>
            </div>
            <div class="search-input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="text" name="departure_date" id="depDateInput" placeholder="Depart" value="{{ $departure_date ?? date('D, d M') }}" readonly style="cursor: pointer;">
            </div>
            <div class="search-input-group" id="returnCol">
                <i class="fas fa-calendar-plus"></i>
                <input type="text" name="return_date" id="retDateInput" placeholder="Return" value="{{ $return_date ?? 'Add Return' }}" readonly style="cursor: pointer;">
            </div>
            <div class="search-input-group" style="cursor: pointer;" onclick="toggleTravelerPicker(event)">
                <i class="fas fa-user-friends"></i>
                <input type="text" id="travelerText" value="{{ $adults ?? 1 }} Adult, {{ $class ?? 'Economy' }}" readonly style="font-size: 12px; cursor: pointer;">
                
                <!-- Travelers Modal -->
                <div id="mmtTravelerDropdown" class="d-none animate-in border-0 rounded-4 p-4 bg-white position-absolute" onclick="event.stopPropagation()">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="fw-900 text-navy mb-0" style="font-size: 14px;">ADULTS (12y+)</label>
                            <span class="badge bg-light text-muted rounded-pill px-3 py-1 fw-700">on the day of travel</span>
                        </div>
                        <div class="mmt-pills-container">
                            @for($i=1;$i<10;$i++)
                                <div class="mmt-modern-pill {{ ($adults ?? 1) == $i ? 'active' : '' }}" onclick="updateMmtAdults({{ $i }}, this)">{{ $i }}</div>
                            @endfor
                            <div class="mmt-modern-pill {{ ($adults ?? 1) >= 10 ? 'active' : '' }}" onclick="updateMmtAdults(10, this)">>9</div>
                        </div>
                    </div>
                    <div class="mb-4 pt-3 border-top">
                        <label class="fw-900 text-navy mb-3 d-block" style="font-size: 14px;">CHOOSE TRAVEL CLASS</label>
                        <div class="mmt-pills-container">
                            <div class="mmt-class-pill-lg {{ ($class ?? 'Economy') == 'Economy' ? 'active' : '' }}" onclick="updateMmtClass('Economy', this)">Economy</div>
                            <div class="mmt-class-pill-lg {{ ($class ?? '') == 'Premium Economy' ? 'active' : '' }}" onclick="updateMmtClass('Premium Economy', this)">Premium Economy</div>
                            <div class="mmt-class-pill-lg {{ ($class ?? '') == 'Business' ? 'active' : '' }}" onclick="updateMmtClass('Business', this)">Business</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end pt-2">
                        <button type="button" class="btn btn-primary rounded-pill px-5 fw-800 py-2" onclick="applyTravelers()">APPLY</button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="adults" id="adultsHidden" value="{{ $adults ?? 1 }}">
            <input type="hidden" name="cabin_class" id="classHidden" value="{{ $class ?? 'Economy' }}">

            <button type="submit" class="btn-map-search">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Horizontal Filter Bar -->
    <div class="map-filter-bar">
        <!-- Sort By -->
        <div class="dropdown">
            <button class="btn btn-sm border fw-bold text-navy dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown" id="sortLabel" style="background:#f8fafc; font-size:12px;">
                Sort: <span class="text-primary">Cheapest</span>
            </button>
            <ul class="dropdown-menu border-0 shadow-lg rounded-4">
                <li><a class="dropdown-item fw-bold small" href="#" onclick="sortByFilter('price', 'Cheapest')">Price (Lowest)</a></li>
                <li><a class="dropdown-item fw-bold small" href="#" onclick="sortByFilter('departure', 'Departure')">Departure Time</a></li>
            </ul>
        </div>

        <!-- Budget Dropdown -->
        <div class="dropdown">
            <button class="btn btn-sm border fw-bold text-navy dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown" id="budgetLabel" style="background:#f8fafc; font-size:12px;" onclick="event.stopPropagation()">
                Budget: <span class="text-primary" id="budgetValue">₹50,000</span>
            </button>
            <div class="dropdown-menu p-4 border-0 shadow-2xl rounded-4" style="min-width: 250px;">
                <label class="x-small fw-900 text-muted mb-3 d-block uppercase">MAX BUDGET</label>
                <input type="range" class="form-range custom-range mb-2" id="budgetRange" min="2000" max="100000" step="500" value="50000" oninput="applyMapFilters()">
                <div class="d-flex justify-content-between small fw-bold text-muted">
                    <span>₹2k</span>
                    <span>₹100k</span>
                </div>
            </div>
        </div>

        <!-- Stops -->
        <div class="d-flex align-items-center gap-2">
            <span class="x-small fw-900 text-muted me-1">STOPS:</span>
            <div class="filter-pill active py-1 px-3" style="font-size:11px;" onclick="toggleStopFilter('all', this)">All</div>
            <div class="filter-pill py-1 px-3" style="font-size:11px;" onclick="toggleStopFilter('0', this)">Non-stop</div>
            <div class="filter-pill py-1 px-3" style="font-size:11px;" onclick="toggleStopFilter('1', this)">1+ Stop</div>
        </div>
        
        <!-- Reset -->
        <button class="btn btn-link btn-sm p-0 ms-auto text-primary fw-bold text-decoration-none" style="font-size:12px;" onclick="resetFilters()">Reset All</button>
    </div>

    <!-- Mobile Toggle -->
    <button class="mobile-toggle-btn" onclick="toggleMobileSidebar()">
        <i class="fas fa-list"></i> <span>View List</span>
    </button>

    <!-- Main Content Area -->
    <div class="map-content-area">
        <!-- Sidebar -->
        <div class="map-sidebar" id="mapSidebar">
            <div class="sidebar-handle" onclick="toggleMobileSidebar()"></div>
            <div class="sidebar-tabs">
                <div class="sidebar-tab active" id="tab-flights" onclick="switchTab('flights')">
                    <i class="fas fa-plane"></i>
                    <span>Flights</span>
                </div>
                <div class="sidebar-tab" id="tab-hotels" onclick="switchTab('hotels')">
                    <i class="fas fa-hotel"></i>
                    <span>Hotels</span>
                </div>
                <div class="sidebar-tab" id="tab-tours" onclick="switchTab('tours')">
                    <i class="fas fa-camera-retro"></i>
                    <span>Tours</span>
                </div>
            </div>

            <div class="sidebar-scroll-area">
                <div class="px-3 pt-3">
                    <h5 class="fw-900 mb-0" id="results-count">{{ count($flights ?? []) }} Flights found</h5>
                    <p class="text-muted small mb-3">Showing real-time results from 100+ sources</p>
                    
                    <!-- Compact Fare Monitoring Banner -->
                    <div class="alert mb-3 p-2 rounded-3 d-flex align-items-center cursor-pointer shadow-sm position-relative overflow-hidden" 
                         style="background: linear-gradient(90deg, #f0f7ff 0%, #ffffff 100%); border: 1px solid #cce3ff !important; min-height: 50px;" 
                         data-bs-toggle="modal" 
                         data-bs-target="#fareMonitorAlarmModal">
                        <i class="fas fa-bell text-primary me-2 ms-1 animate-pulse" style="font-size:14px;"></i>
                        <div class="flex-grow-1">
                            <span class="fw-900 text-navy" style="font-size:11px;">Track Price Drops</span>
                            <p class="mb-0 text-muted" style="font-size:9px; font-weight:700;">Get alerts for cheaper fares!</p>
                        </div>
                        <i class="fas fa-chevron-right text-primary opacity-50 me-1" style="font-size:10px;"></i>
                    </div>
                </div>

                <div class="listings-container" id="listingsContainer">
                    <!-- Listings loaded via JS -->
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="map-canvas" id="exploreMap">
            <!-- Layers / Controls Overlay -->
            <div class="map-overlay-controls">
                <button class="map-layer-btn active" title="Satellite View">
                    <i class="fas fa-layer-group"></i>
                </button>
                <button class="map-layer-btn" title="My Location">
                    <i class="fas fa-location-arrow"></i>
                </button>
                <button class="map-layer-btn" id="toggleWeather" onclick="toggleWeatherLayer()" title="Weather Overlay">
                    <i class="fas fa-cloud-sun text-info"></i>
                </button>
            </div>

            <!-- Weather Global Pill (Map View) -->
            <div id="mapWeatherPill" class="d-none animate-in" style="position: absolute; top: 24px; left: 50%; transform: translateX(-50%); z-index: 1000; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 12px 24px; border-radius: 99px; border: 1.5px solid #0ea5e9; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-sun text-warning fs-5"></i>
                        <span class="fw-900 text-navy" style="font-size: 14px;">25°C - Sunny</span>
                    </div>
                    <div style="width: 1px; height: 20px; background: #e2e8f0;"></div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-center"><div style="font-size: 8px; font-weight: 800;" class="text-muted">SAT</div><i class="fas fa-cloud text-info small"></i></div>
                        <div class="text-center"><div style="font-size: 8px; font-weight: 800;" class="text-muted">SUN</div><i class="fas fa-sun text-warning small"></i></div>
                        <div class="text-center"><div style="font-size: 8px; font-weight: 800;" class="text-muted">MON</div><i class="fas fa-cloud-rain text-primary small"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const flightsData = {!! $dynamicFlights ?? '[]' !!};
    const hotelsData = {!! $dynamicHotels ?? '[]' !!};
    const toursData = {!! $dynamicTours ?? '[]' !!};
    const originCoords = {!! $originCoords ?? '{"lat": 20.5937, "lng": 78.9629}' !!};

    let currentTab = 'flights';
    let map, markers = [], routeLines = [];

    // --- Core Logic ---

    function initMap() {
        // Center on origin or India
        const center = [originCoords.lat, originCoords.lng];
        
        map = L.map('exploreMap', {
            center: center,
            zoom: 5,
            zoomControl: false
        });

        // Premium Dark/Modern Tile Layer
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; TripZant'
        }).addTo(map);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        renderData();
    }

    function switchTab(tab) {
        currentTab = tab;
        document.querySelectorAll('.sidebar-tab').forEach(t => t.classList.remove('active'));
        const tabEl = document.getElementById(`tab-${tab}`);
        if(tabEl) tabEl.classList.add('active');
        
        let countText;
        let data;
        if (tab === 'flights') {
            countText = 'Flights found';
            data = flightsData;
        } else if (tab === 'hotels') {
            countText = 'Hotels found';
            data = hotelsData;
        } else {
            countText = 'Tours found';
            data = toursData;
        }
        
        const countEl = document.getElementById('results-count');
        if(countEl) countEl.innerText = `${data.length} ${countText}`;

        renderData();
    }

    function renderData() {
        const data = currentTab === 'flights' ? flightsData : (currentTab === 'hotels' ? hotelsData : toursData);
        const container = document.getElementById('listingsContainer');
        if(!container) return;
        
        container.innerHTML = '';
        
        // Clear old markers and lines
        markers.forEach(m => map.removeLayer(m));
        routeLines.forEach(l => map.removeLayer(l));
        markers = [];
        routeLines = [];

        const startPoint = [originCoords.lat, originCoords.lng];

        data.forEach((item, index) => {
            // 1. Render Sidebar Card
            const card = document.createElement('div');
            card.className = `listing-card animate-in`;
            card.style.animationDelay = `${index * 0.05}s`;
            card.id = `card-${item.id}`;
            card.onclick = () => focusItem(item.id, true);
            
            const logoUrl = item.airline_code ? `https://imgak.mmtcdn.com/flights/assets/media/dt/common/icons/${item.airline_code}.png` : item.image;
            
            card.innerHTML = `
                <div class="position-relative">
                    <img src="${logoUrl}" class="listing-image" alt="${item.title}" style="width:50px; height:50px; padding:5px; background:#fff; border:1px solid #eee;">
                </div>
                <div class="listing-info">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="listing-title" style="font-size:13px;">${item.title}</h6>
                        <span class="listing-rating"><i class="fas fa-star"></i> ${item.rating}</span>
                    </div>
                    <div class="listing-meta"><i class="fas fa-plane-departure me-1"></i> ${item.meta}</div>
                    <div class="listing-price-row">
                        <div class="listing-price">${item.price}</div>
                        <button class="btn btn-sm btn-navy px-3 rounded-pill fw-bold" style="font-size:10px;" onclick="showFlightDetails('${item.id}', event)">VIEW</button>
                    </div>
                </div>
            `;
            container.appendChild(card);

            // 2. Render Map Marker with slight jitter if many markers at same spot
            const latOffset = (Math.random() - 0.5) * 0.005 * index;
            const lngOffset = (Math.random() - 0.5) * 0.005 * index;
            const markerLat = parseFloat(item.lat) + latOffset;
            const markerLng = parseFloat(item.lng) + lngOffset;

            const markerTypeIcon = {
                'flights': 'plane',
                'hotels': 'hotel',
                'tour': 'camera-retro'
            };
            
            const iconHtml = `
                <div class="custom-price-marker" id="marker-${item.id}">
                    <div class="marker-icon"><i class="fas fa-${markerTypeIcon[currentTab] || 'map-pin'}"></i></div>
                    ${item.price}
                </div>
            `;
 
            const customIcon = L.divIcon({
                className: 'leaflet-data-marker',
                html: iconHtml,
                iconSize: [80, 30],
                iconAnchor: [40, 15]
            });

            const marker = L.marker([markerLat, markerLng], { icon: customIcon }).addTo(map);
            marker.on('click', () => focusItem(item.id, false));
            markers.push(marker);

            // 3. Add Curved Route Lines (Flight Only)
            if (currentTab === 'flights') {
                const endPoint = [item.lat, item.lng];
                
                // Simple Bezier-like curve logic or just polyline with opacity
                const line = L.polyline([startPoint, endPoint], {
                    color: '#1e293b',
                    weight: 1.5,
                    opacity: 0.15,
                    dashArray: '4, 8'
                }).addTo(map);
                routeLines.push(line);
            }
        });

        // Fit bounds to show all markers with a sensible maximum zoom
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.4), { maxZoom: 12 });
        }
    }

    function focusItem(id, fromSidebar) {
        document.querySelectorAll('.listing-card').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.custom-price-marker').forEach(m => m.classList.remove('active'));

        const card = document.getElementById(`card-${id}`);
        const marker = document.getElementById(`marker-${id}`);

        if(card) card.classList.add('active');
        if(marker) marker.classList.add('active');

        if(!fromSidebar && card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        const data = currentTab === 'flights' ? flightsData : (currentTab === 'hotels' ? hotelsData : toursData);
        const item = data.find(i => i.id === id);
        if(item) {
            map.flyTo([item.lat, item.lng], Math.max(map.getZoom(), 8), { duration: 1 });
        }
    }

    function toggleWeatherLayer() {
        const pill = document.getElementById('mapWeatherPill');
        const btn = document.getElementById('toggleWeather');
        pill.classList.toggle('d-none');
        btn.classList.toggle('active');
    }

    // --- UI Interactions ---

    let mmtAdults = {{ $adults ?? 1 }};
    let mmtClass = '{{ $class ?? "Economy" }}';

    function toggleTravelerPicker(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('mmtTravelerDropdown');
        dropdown.classList.toggle('d-none');
    }

    function updateMmtAdults(count, el) {
        mmtAdults = count;
        el.parentElement.querySelectorAll('.mmt-modern-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
    }

    function updateMmtClass(cls, el) {
        mmtClass = cls;
        el.parentElement.querySelectorAll('.mmt-class-pill-lg').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
    }

    function applyTravelers() {
        document.getElementById('adultsHidden').value = mmtAdults;
        document.getElementById('classHidden').value = mmtClass;
        document.getElementById('travelerText').value = `${mmtAdults} Adult, ${mmtClass}`;
        document.getElementById('mmtTravelerDropdown').classList.add('d-none');
    }

    function updateTripType() {
        const type = document.getElementById('tripTypeSelect').value;
        const returnCol = document.getElementById('returnCol');
        if (type === 'one') {
            returnCol.classList.add('disabled');
        } else {
            returnCol.classList.remove('disabled');
        }
    }

    // Initialize Flatpickr
    function initDatePickers() {
        if (typeof flatpickr === 'undefined') {
            // Load dynamically if not present
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css';
            document.head.appendChild(link);
            
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/flatpickr';
            script.onload = () => {
                flatpickr("#depDateInput", { dateFormat: "D, d M", minDate: "today" });
                flatpickr("#retDateInput", { dateFormat: "D, d M", minDate: "today" });
            };
            document.head.appendChild(script);
        } else {
            flatpickr("#depDateInput", { dateFormat: "D, d M", minDate: "today" });
            flatpickr("#retDateInput", { dateFormat: "D, d M", minDate: "today" });
        }
    }

    // --- Autocomplete Logic ---
    function setupMmtAutocomplete(input) {
        const results = input.nextElementSibling;
        if (!results || !results.classList.contains('autocomplete-results')) return;

        input.addEventListener('input', async function() {
            const term = this.value.trim();
            if (term.length < 2) { results.classList.add('d-none'); return; }
            
            try {
                const response = await fetch(`https://autocomplete.travelpayouts.com/places2?locale=en&types[]=city&types[]=airport&term=${term}`);
                const data = await response.json();
                
                if (data && data.length > 0) {
                    results.innerHTML = data.slice(0, 8).map(place => {
                        return `
                            <div class="mmt-ac-item" onclick="selectMmtItemDirect(this, '${place.code}', '${place.name}')">
                                <div class="mmt-ac-box">${place.code}</div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="mmt-ac-city text-truncate">${place.name}, ${place.country_name || ''}</div>
                                    <div class="mmt-ac-airport text-truncate small opacity-75">${place.main_airport_name || place.name}</div>
                                </div>
                            </div>
                        `;
                    }).join('');
                    results.classList.remove('d-none');
                } else {
                    results.classList.add('d-none');
                }
            } catch (err) { results.classList.add('d-none'); }
        });
    }

    window.selectMmtItemDirect = function(el, code, cityName) {
        const results = el.closest('.autocomplete-results');
        const input = results.previousElementSibling;
        input.value = `${cityName} (${code})`;
        input.dataset.code = code;
        results.classList.add('d-none');
    }

    window.toggleMobileSidebar = function() {
        const sidebar = document.getElementById('mapSidebar');
        const btn = document.querySelector('.mobile-toggle-btn');
        sidebar.classList.toggle('mobile-open');
        btn.querySelector('span').innerText = sidebar.classList.contains('mobile-open') ? 'View Map' : 'View List';
        btn.querySelector('i').className = sidebar.classList.contains('mobile-open') ? 'fas fa-map' : 'fas fa-list';
    }

    window.toggleFilterPanel = function() {
        const panel = document.getElementById('filterPanel');
        const chevron = document.getElementById('filterChevron');
        panel.classList.toggle('d-none');
        chevron.style.transform = panel.classList.contains('d-none') ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    let activeStopFilter = 'all';

    window.toggleStopFilter = function(val, el) {
        document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        activeStopFilter = val;
        applyMapFilters();
    }

    window.resetFilters = function() {
        document.getElementById('budgetRange').value = 100000;
        document.getElementById('budgetValue').innerText = '₹1,00,000';
        activeStopFilter = 'all';
        document.querySelectorAll('.filter-pill').forEach(p => {
            p.classList.remove('active');
            if (p.innerText === 'All') p.classList.add('active');
        });
        applyMapFilters();
    }

    window.applyMapFilters = function() {
        const maxBudget = parseInt(document.getElementById('budgetRange').value);
        document.getElementById('budgetValue').innerText = '₹' + maxBudget.toLocaleString();

        const filtered = flightsData.filter(item => {
            // Price Filter
            const price = parseInt(item.price_raw || item.price.replace(/[^0-9]/g, ''));
            if (price > maxBudget) return false;

            // Stop Filter (Mock logic as item.stops might be missing in simple search)
            if (activeStopFilter !== 'all') {
                const stops = item.is_direct ? 0 : 1; // Simplified for now
                if (activeStopFilter === '0' && stops !== 0) return false;
                if (activeStopFilter === '1' && stops === 0) return false;
            }

            return true;
        });

        renderData(filtered);
    }

    window.sortByFilter = function(criteria, label) {
        document.getElementById('sortLabel').innerHTML = `Sort by: <span class="text-primary">${label}</span>`;
        
        if (criteria === 'price') {
            flightsData.sort((a, b) => (a.price_raw || 0) - (b.price_raw || 0));
        } else if (criteria === 'departure') {
            flightsData.sort((a, b) => new Date(a.departure_at) - new Date(b.departure_at));
        }
        
        renderData(flightsData);
    }

    window.showFlightDetails = function(gdsId, event) {
        if (event) event.stopPropagation();

        if (gdsId.startsWith('insp_')) {
            Swal.fire({
                title: '<span class="fw-900">Destination Suggestion</span>',
                html: '<div class="text-center p-3"><i class="fas fa-lightbulb text-warning fa-3x mb-3"></i><p class="text-muted fw-bold">This is a travel inspiration based on popular trends.</p><p class="small">To see exact flight times, carriers, and booking options, please perform a <b>specific search</b> by entering this city in the "To" field.</p></div>',
                confirmButtonText: 'GOT IT',
                confirmButtonColor: '#2563eb',
                customClass: { popup: 'rounded-4 border-0 shadow-lg' }
            });
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('flightDetailsModal'));
        const content = document.getElementById('flightDetailsContent');
        content.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 fw-bold text-muted">Loading itinerary...</p></div>';
        modal.show();

        const getTime = (at) => {
            if (!at || !at.includes('T')) return '--:--';
            return at.split('T')[1].substring(0, 5);
        };

        const getDuration = (dur) => {
            if (!dur) return '';
            return dur.replace('PT', '').replace('H', 'h ').replace('M', 'm').toLowerCase();
        };

        fetch(`/flights/details?id=${gdsId}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) throw new Error(data.error);
                
                const offer = data.data;
                const dict = data.dictionaries || {};
                const itineraries = offer.itineraries || [];
                
                let html = '';
                itineraries.forEach((it, itIdx) => {
                    const segments = it.segments || [];
                    html += `
                        <div class="mb-4">
                            <h6 class="fw-900 text-navy mb-3 border-bottom pb-2">
                                <i class="fas fa-plane-departure me-2 text-primary"></i> ${itIdx === 0 ? 'Onward Journey' : 'Return Journey'}
                            </h6>
                            ${segments.map(s => {
                                const carrier = (dict.carriers && dict.carriers[s.carrierCode]) ? dict.carriers[s.carrierCode] : (s.carrierCode || 'Airline');
                                return `
                                    <div class="itinerary-segment p-3 rounded-4 mb-3" style="background:#f8fafc; border: 1px solid #e2e8f0;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="fw-900 text-navy">${carrier}</div>
                                                <span class="badge bg-light text-muted border">${s.carrierCode || '??'}-${s.number || '000'}</span>
                                            </div>
                                            <div class="text-primary fw-900 small">${getDuration(s.duration || it.duration)}</div>
                                        </div>
                                        <div class="row align-items-center text-center g-0">
                                            <div class="col-4 text-start">
                                                <div class="fw-900 fs-5 text-navy">${getTime(s.departure.at)}</div>
                                                <div class="fw-800 text-muted small">${s.departure.iataCode}</div>
                                            </div>
                                            <div class="col-4 position-relative">
                                                <div style="height:2px; background:linear-gradient(90deg, var(--primary) 0%, #e2e8f0 100%); width:80%; margin:0 auto;"></div>
                                                <i class="fas fa-plane text-primary position-absolute top-50 start-50 translate-middle bg-white px-1" style="font-size:12px;"></i>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="fw-900 fs-5 text-navy">${getTime(s.arrival.at)}</div>
                                                <div class="fw-800 text-muted small">${s.arrival.iataCode}</div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    `;
                });

                if (html === '') html = '<div class="text-center py-4 text-muted fw-bold">Itinerary details not available for this flight.</div>';
                content.innerHTML = html;
            })
            .catch(err => {
                content.innerHTML = `<div class="alert alert-danger rounded-4 fw-bold p-4"><i class="fas fa-exclamation-triangle me-2"></i> ${err.message}</div>`;
            });
    }

    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('mmtTravelerDropdown');
        if (dropdown && !dropdown.contains(e.target)) dropdown.classList.add('d-none');
        document.querySelectorAll('.autocomplete-results').forEach(res => res.classList.add('d-none'));
    });

    document.addEventListener('DOMContentLoaded', () => {
        initMap();
        initDatePickers();
        updateTripType();
        
        // Init Autocomplete
        const oIn = document.getElementById('originInput');
        const dIn = document.getElementById('destinationInput');
        if (oIn) setupMmtAutocomplete(oIn);
        if (dIn) setupMmtAutocomplete(dIn);
    });
</script>

<!-- Flight Details Modal -->
<div class="modal fade" id="flightDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 px-4 pt-4 bg-primary bg-opacity-10">
                <h5 class="fw-900 text-navy mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Flight Itinerary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="flightDetailsContent">
                <!-- Content injected via JS -->
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-navy rounded-pill w-100 fw-900 shadow-sm" data-bs-dismiss="modal">CLOSE DETAILS</button>
            </div>
        </div>
    </div>
</div>

<!-- Fare Monitor Tracker Modal (User requested ID) -->
<div class="modal fade" id="fareMonitorAlarmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 bg-primary bg-opacity-10 px-4 pt-4 pb-3">
                <div>
                    <h5 class="fw-900 text-navy mb-1"><i class="fas fa-bullseye me-2 text-primary"></i> Track Cheaper Fares</h5>
                    <p class="text-muted x-small mb-0">We will monitor the route and notify you</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="exploreFareAlertForm">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="x-small fw-bold text-muted uppercase mb-1">From</label>
                            <input type="text" class="form-control form-control-sm bg-light border-0 fw-bold" value="{{ $origin ?? 'DEL' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="x-small fw-bold text-muted uppercase mb-1">To</label>
                            <input type="text" class="form-control form-control-sm bg-light border-0 fw-bold" value="{{ $destination ?? 'Anywhere' }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="x-small fw-bold text-muted uppercase mb-1">Target Budget (INR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">₹</span>
                            <input type="number" class="form-control bg-light border-0 fw-bold text-navy" placeholder="Enter target price">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="x-small fw-bold text-muted uppercase mb-2">Notify Me Via</label>
                        <input type="text" class="form-control form-control-sm bg-light border-0" placeholder="Enter Email or Phone No.">
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-3 fw-800 rounded-pill shadow-lg" onclick="Swal.fire('Alert Set!', 'We will notify you when price drops.', 'success')">
                        ACTIVATE FARE ALERT
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

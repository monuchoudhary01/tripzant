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
        height: 60px;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        padding: 0 24px;
        gap: 16px;
        z-index: 998;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
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
        overflow: hidden;
    }

    .map-sidebar {
        width: var(--map-sidebar-width);
        background: #fff;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        z-index: 999;
        height: 100%;
        transition: all 0.3s ease;
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
            height: 75vh;
            width: 100%;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            border-right: none !important;
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -15px 40px rgba(0,0,0,0.15);
            z-index: 10001;
            background: #fff;
            display: flex;
            flex-direction: column;
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
        border-radius: 20px;
        margin-bottom: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        background: #fff;
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
        padding: 8px 16px;
        border-radius: 50px;
        border: 1.5px solid #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }
    .filter-pill:hover { 
        border-color: #008cff; 
        color: #008cff; 
        background: #f0f7ff;
        transform: translateY(-1px);
    }
    .filter-pill.active { 
        background: #008cff; 
        color: #fff; 
        border-color: #008cff; 
        box-shadow: 0 4px 12px rgba(0,140,255,0.25); 
    }

    .custom-range::-webkit-slider-thumb { 
        background: #008cff; 
        border: 3px solid #fff; 
        box-shadow: 0 0 10px rgba(0,140,255,0.3);
        width: 18px;
        height: 18px;
        cursor: pointer;
        -webkit-appearance: none;
        border-radius: 50%;
    }
    .custom-range::-moz-range-thumb { 
        background: #008cff; 
        border: 3px solid #fff;
        width: 18px;
        height: 18px;
        cursor: pointer;
        border-radius: 50%;
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
        <div class="me-3">
            @php
                $currentTab = $activeTab ?? 'flights';
                $routeName = 'flights.index';
                if ($currentTab == 'hotels') $routeName = 'hotels.index';
                elseif ($currentTab == 'tours') $routeName = 'tours.index';
            @endphp
            <a href="{{ route($routeName, array_merge(['locale' => $currentLocale, 'currency' => $currentCurrency], request()->except('mode'))) }}" class="btn btn-outline-secondary rounded-pill px-3 fw-800 d-flex align-items-center gap-2" style="border-width: 2px;">
                <i class="fas fa-list"></i> <span class="d-none d-md-inline">List View</span>
            </a>
        </div>
        <form action="{{ route('explore.map', ['locale' => $currentLocale, 'currency' => $currentCurrency]) }}" method="GET" class="map-search-engine" id="mapSearchForm" style="max-width: 1200px; position: relative;">
            <input type="hidden" name="mode" value="map">
            <input type="hidden" name="activeTab" id="activeTabHidden" value="{{ $activeTab ?? 'flights' }}">

            <!-- Flight Only: Trip Type -->
            <div class="search-input-group flight-only" style="flex: 0.6; min-width: 110px; {{ ($activeTab ?? 'flights') !== 'flights' ? 'display:none;' : '' }}">
                <select name="trip" id="tripTypeSelect" class="bg-transparent border-0 fw-800 text-navy" style="outline:none; font-size: 13px; cursor: pointer;" onchange="updateTripType()">
                    <option value="one" {{ ($trip ?? 'one') == 'one' ? 'selected' : '' }}>One Way</option>
                    <option value="round" {{ ($trip ?? '') == 'round' ? 'selected' : '' }}>Round Trip</option>
                </select>
            </div>

            <!-- Flight Only: Origin -->
            <div class="search-input-group flight-only" style="position: relative; {{ ($activeTab ?? 'flights') !== 'flights' ? 'display:none;' : '' }}">
                <i class="fas fa-plane-departure"></i>
                <input type="text" name="origin" id="originInput" placeholder="From" value="{{ $origin ?? '' }}" autocomplete="off" style="background: transparent; border: none; outline: none; font-size: 14px; font-weight: 700; color: #1e293b; width: 100%;">
                <div id="originResults" class="autocomplete-results d-none"></div>
            </div>

            <!-- Shared: Destination (but label/icon might differ) -->
            <div class="search-input-group" style="position: relative;">
                <i class="fas {{ ($activeTab ?? 'flights') === 'hotels' ? 'fa-map-marker-alt' : 'fa-plane-arrival' }}" id="destIcon"></i>
                <input type="text" name="destination" id="destinationInput" placeholder="To" value="{{ $destination ?? '' }}" autocomplete="off" style="background: transparent; border: none; outline: none; font-size: 14px; font-weight: 700; color: #1e293b; width: 100%;">
                <div id="destinationResults" class="autocomplete-results d-none"></div>
            </div>

            <!-- Shared: Dates -->
            <div class="search-input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="text" name="departure_date" id="depDateInput" placeholder="Depart" value="{{ $departure_date ?? date('D, d M') }}" readonly style="cursor: pointer;">
            </div>
            <div class="search-input-group" id="returnCol" style="{{ (($trip ?? 'one') === 'one' && ($activeTab ?? 'flights') === 'flights') ? 'opacity:0.5; pointer-events:none;' : '' }}">
                <i class="fas fa-calendar-plus"></i>
                <input type="text" name="return_date" id="retDateInput" placeholder="Return" value="{{ $return_date ?? 'Add Return' }}" readonly style="cursor: pointer;">
            </div>

            <!-- Shared: Travelers / Guests -->
            <div class="search-input-group" style="cursor: pointer;" onclick="toggleTravelerPicker(event)">
                <i class="fas fa-user-friends"></i>
                <input type="text" id="travelerText" value="{{ $adults ?? 1 }} Adult, {{ ($activeTab ?? 'flights') === 'hotels' ? (($rooms ?? 1) . ' Room') : ($class ?? 'Economy') }}" readonly style="font-size: 12px; cursor: pointer;">
                
                <!-- Travelers Modal -->
                <div id="mmtTravelerDropdown" class="d-none animate-in border-0 rounded-4 p-4 bg-white position-absolute" style="top: 100%; right: 0; z-index: 10000; min-width: 350px; box-shadow: 0 15px 45px rgba(0,0,0,0.1);" onclick="event.stopPropagation()">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="fw-900 text-navy mb-0" style="font-size: 14px;">ADULTS (12y+)</label>
                        </div>
                        <div class="mmt-pills-container d-flex flex-wrap gap-2">
                            @for($i=1;$i<10;$i++)
                                <div class="mmt-modern-pill {{ ($adults ?? 1) == $i ? 'active' : '' }}" onclick="updateMmtAdults({{ $i }}, this)">{{ $i }}</div>
                            @endfor
                        </div>
                    </div>

                    <div class="hotel-only" style="{{ ($activeTab ?? 'flights') !== 'hotels' ? 'display:none;' : '' }}">
                        <div class="mb-4 pt-3 border-top">
                            <label class="fw-900 text-navy mb-3 d-block" style="font-size: 14px;">ROOMS</label>
                            <div class="mmt-pills-container d-flex flex-wrap gap-2">
                                @for($i=1;$i<6;$i++)
                                    <div class="mmt-modern-pill {{ ($rooms ?? 1) == $i ? 'active' : '' }}" onclick="updateMmtRooms({{ $i }}, this)">{{ $i }}</div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="flight-only" style="{{ ($activeTab ?? 'flights') !== 'flights' ? 'display:none;' : '' }}">
                        <div class="mb-4 pt-3 border-top">
                            <label class="fw-900 text-navy mb-3 d-block" style="font-size: 14px;">CHOOSE TRAVEL CLASS</label>
                            <div class="mmt-pills-container d-flex flex-wrap gap-2">
                                <div class="mmt-class-pill-lg {{ ($class ?? 'Economy') == 'Economy' ? 'active' : '' }}" onclick="updateMmtClass('Economy', this)">Economy</div>
                                <div class="mmt-class-pill-lg {{ ($class ?? '') == 'Premium Economy' ? 'active' : '' }}" onclick="updateMmtClass('Premium Economy', this)">Premium Economy</div>
                                <div class="mmt-class-pill-lg {{ ($class ?? '') == 'Business' ? 'active' : '' }}" onclick="updateMmtClass('Business', this)">Business</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end pt-2">
                        <button type="button" class="btn btn-primary rounded-pill px-5 fw-800 py-2" onclick="applyTravelers()">APPLY</button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="adults" id="adultsHidden" value="{{ $adults ?? 1 }}">
            <input type="hidden" name="rooms" id="roomsHidden" value="{{ $rooms ?? 1 }}">
            <input type="hidden" name="cabin_class" id="classHidden" value="{{ $class ?? 'Economy' }}">

            <button type="submit" class="btn-map-search">
                <i class="fas fa-search"></i>
            </button>
        </form>
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
                <div class="sidebar-tab {{ ($activeTab ?? 'flights') == 'flights' ? 'active' : '' }}" id="tab-flights" onclick="switchTab('flights')">
                    <i class="fas fa-plane"></i>
                    <span>Flights</span>
                </div>
                 <div class="sidebar-tab {{ ($activeTab ?? '') == 'hotels' ? 'active' : '' }}" id="tab-hotels" onclick="switchTab('hotels')">
                    <i class="fas fa-hotel"></i>
                    <span>Hotels</span>
                </div>
                <div class="sidebar-tab {{ ($activeTab ?? '') == 'tours' ? 'active' : '' }}" id="tab-tours" onclick="switchTab('tours')">
                    <i class="fas fa-camera-retro"></i>
                    <span>Tours</span>
                </div>
            </div>

            <div class="sidebar-scroll-area">
                <div class="px-3 pt-3">
                    @php
                        $activeCount = count($flights ?? []);
                        $activeLabel = 'Flights';
                        if(($activeTab ?? '') === 'hotels') {
                            $activeCount = count(json_decode($dynamicHotels ?? '[]'));
                            $activeLabel = 'Hotels';
                        }
                    @endphp
                    <h5 class="fw-900 mb-0" id="results-count">{{ $activeCount }} {{ $activeLabel }} found</h5>
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
            </div>

        </div>
    </div>
</div>

<script>
    const flightsData = {!! $dynamicFlights ?? '[]' !!};
    const hotelsData = {!! $dynamicHotels ?? '[]' !!};
    const toursData = {!! $dynamicTours ?? '[]' !!};
    const originCoords = {!! $originCoords ?? '{"lat": 20.5937, "lng": 78.9629}' !!};

    let currentTab = '{!! $activeTab ?? 'flights' !!}';
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

        switchTab(currentTab);
    }

    function switchTab(tab) {
        currentTab = tab;
        document.querySelectorAll('.sidebar-tab').forEach(t => t.classList.remove('active'));
        const tabEl = document.getElementById(`tab-${tab}`);
        if(tabEl) tabEl.classList.add('active');

        // Update Hidden Field
        document.getElementById('activeTabHidden').value = tab;
        
        // Toggle Search Form Visibility
        if (tab === 'hotels') {
            document.querySelectorAll('.flight-only').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.hotel-only').forEach(el => el.style.display = 'block');
            document.getElementById('destIcon').className = 'fas fa-map-marker-alt';
            document.getElementById('returnCol').style.opacity = '1';
            document.getElementById('returnCol').style.pointerEvents = 'auto';
            document.getElementById('travelerText').value = `${mmtAdults} Adult, ${mmtRooms} Room`;
        } else {
            document.querySelectorAll('.flight-only').forEach(el => el.style.display = 'block');
            document.querySelectorAll('.hotel-only').forEach(el => el.style.display = 'none');
            document.getElementById('destIcon').className = 'fas fa-plane-arrival';
            updateTripType(); // restores flight logic
            document.getElementById('travelerText').value = `${mmtAdults} Adult, ${mmtClass}`;
        }
        
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
            
            const title = item.title || item.airline_name || 'Item';
            const subTitle = item.type === 'flight' ? (item.airline_name || 'Flight') : (item.type === 'hotel' ? 'Hotel' : 'Tour');
            const logoUrl = item.airline_code ? `https://imgak.mmtcdn.com/flights/assets/media/dt/common/icons/${item.airline_code}.png` : (item.image || 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=50');
            
            card.innerHTML = `
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width:32px; height:32px; border:1px solid #f1f5f9;">
                                <img src="${logoUrl}" alt="${title}" style="width:20px; height:20px; object-fit:contain;">
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fw-800 text-navy text-truncate" style="font-size:12px; line-height:1.2; max-width: 180px;">${title}</div>
                                <div class="text-muted fw-bold" style="font-size:9px;">${subTitle}</div>
                            </div>
                        </div>
                        <div class="listing-price" style="font-size:18px; letter-spacing:-0.5px;">${item.price}</div>
                    </div>
                    
                    ${item.type === 'flight' ? `
                    <div class="d-flex align-items-center justify-content-between bg-light rounded-4 p-3 mb-3" style="background: #f8fafc !important; border: 1px solid #f1f5f9;">
                        <div class="text-start">
                            <div class="fw-900 text-navy" style="font-size:15px;">${item.departure_time || '--:--'}</div>
                            <div class="text-muted fw-800" style="font-size:10px; letter-spacing:0.5px;">${item.origin_code || 'ORG'}</div>
                        </div>
                        
                        <div class="flex-grow-1 px-3">
                            <div class="position-relative d-flex align-items-center justify-content-center" style="height:20px;">
                                <div style="height:1.5px; background:linear-gradient(90deg, #e2e8f0 0%, #cbd5e1 50%, #e2e8f0 100%); width:100%;"></div>
                                <i class="fas fa-plane text-primary bg-light px-2 position-absolute" style="font-size:11px; background:#f8fafc !important;"></i>
                            </div>
                            <div class="text-center text-muted fw-800 mt-1" style="font-size:9px; letter-spacing:0.3px;">
                                ${item.duration ? item.duration.replace('PT','').replace('H','h ').replace('M','m').toLowerCase() : (item.is_direct ? 'Non-stop' : '1+ Stop')}
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <div class="fw-900 text-navy" style="font-size:15px;">${item.arrival_time || '--:--'}</div>
                            <div class="text-muted fw-800" style="font-size:10px; letter-spacing:0.5px;">${item.dest_code || 'DST'}</div>
                        </div>
                    </div>
                    ` : `
                    <div class="mb-3">
                        <img src="${item.image}" class="rounded-4 w-100" style="height:120px; object-fit:cover;">
                    </div>
                    `}
                    
                    <div class="d-flex justify-content-between align-items-center pt-1">
                        <div class="text-muted fw-bold d-flex align-items-center gap-1" style="font-size:10px;">
                            <i class="fas fa-calendar-check text-primary opacity-50"></i> 
                            ${item.meta ? (item.meta.includes('|') ? item.meta.split('|')[0] : item.meta) : ''}
                        </div>
                        <button class="btn btn-sm btn-navy px-4 rounded-pill fw-900 shadow-sm" style="font-size:10px; background:#1e293b; border:none; height:32px;" onclick="${item.type === 'flight' ? `showFlightDetails('${item.id}', event)` : `showHotelDetails('${item.id}', event)`}">SELECT</button>
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

    document.getElementById('mapSearchForm').addEventListener('submit', function(e) {
        // Change action based on active tab so the correct controller handles the search
        if (currentTab === 'hotels') {
            this.action = "{{ route('hotels.index', ['locale' => $currentLocale, 'currency' => $currentCurrency]) }}";
        } else if (currentTab === 'tours') {
            this.action = "{{ route('tours.index', ['locale' => $currentLocale, 'currency' => $currentCurrency]) }}";
        } else {
            this.action = "{{ route('explore.map', ['locale' => $currentLocale, 'currency' => $currentCurrency]) }}";
        }
    });

    let mmtAdults = {{ $adults ?? 1 }};
    let mmtRooms = {{ $rooms ?? 1 }};
    let mmtClass = '{{ $class ?? "Economy" }}';

    function updateMmtRooms(count, el) {
        mmtRooms = count;
        el.parentElement.querySelectorAll('.mmt-modern-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
    }

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
        document.getElementById('roomsHidden').value = mmtRooms;
        document.getElementById('classHidden').value = mmtClass;
        
        if (currentTab === 'hotels') {
            document.getElementById('travelerText').value = `${mmtAdults} Adult, ${mmtRooms} Room`;
        } else {
            document.getElementById('travelerText').value = `${mmtAdults} Adult, ${mmtClass}`;
        }
        
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

    function showFlightDetails(id, e) {
        if(e) e.stopPropagation();
        const f = flightsData.find(i => i.id === id);
        if(!f) return;
        
        // Use SweetAlert for a premium preview or redirect
        Swal.fire({
            title: `<div class="fw-900 text-navy mt-2" style="font-size:20px;">${f.airline_name}</div>`,
            html: `
                <div class="p-2">
                    <div class="d-flex justify-content-between align-items-center mb-4 bg-light rounded-4 p-3">
                        <div class="text-start">
                            <div class="fw-900 text-navy fs-4">${f.departure_time}</div>
                            <div class="text-muted fw-800 small">${f.origin_code}</div>
                        </div>
                        <i class="fas fa-plane text-primary mx-3"></i>
                        <div class="text-end">
                            <div class="fw-900 text-navy fs-4">${f.arrival_time}</div>
                            <div class="text-muted fw-800 small">${f.dest_code}</div>
                        </div>
                    </div>
                    <div class="text-muted fw-bold small mb-4">Duration: ${f.duration} | ${f.stops} Stops</div>
                    <div class="fw-900 text-primary fs-3 mb-2">${f.price}</div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'BOOK NOW',
            cancelButtonText: 'CLOSE',
            confirmButtonColor: '#008489',
            customClass: {
                popup: 'rounded-5 border-0 shadow-lg',
                confirmButton: 'rounded-pill px-5 fw-800 py-2',
                cancelButton: 'rounded-pill px-5 fw-800 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to booking/details (example URL)
                window.location.href = `/flights/details?id=${id}`;
            }
        });
    }

    function showHotelDetails(id, e) {
        if(e) e.stopPropagation();
        const h = hotelsData.find(i => i.id === id);
        if(!h) return;
        
        Swal.fire({
            title: `<div class="fw-900 text-navy mt-2" style="font-size:20px;">${h.title}</div>`,
            html: `
                <div class="p-2">
                    <img src="${h.image}" class="rounded-4 w-100 mb-3" style="height:180px; object-fit:cover;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-start">
                            <div class="rating-stars mb-1">
                                ${Array(parseInt(h.rating)).fill('<i class="fas fa-star text-warning"></i>').join('')}
                            </div>
                            <div class="text-muted fw-800 small">${h.meta}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-900 text-primary fs-3">${h.price}</div>
                            <div class="text-muted small fw-bold">per night</div>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'VIEW DETAILS',
            cancelButtonText: 'CLOSE',
            confirmButtonColor: '#008489',
            customClass: {
                popup: 'rounded-5 border-0 shadow-lg',
                confirmButton: 'rounded-pill px-5 fw-800 py-2',
                cancelButton: 'rounded-pill px-5 fw-800 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Map current search params to detail page
                const checkIn = document.getElementById('depDateInput').value;
                const checkOut = document.getElementById('retDateInput').value;
                window.location.href = `/hotels/details?hotelCode=${id}&checkIn=${checkIn}&checkOut=${checkOut}&adults=${mmtAdults}&rooms=${mmtRooms}`;
            }
        });
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

        Swal.fire({
            title: 'Fetching Fare Details...',
            didOpen: () => { Swal.showLoading(); }
        });

        fetch(`/flights/details?id=${gdsId}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) throw new Error(data.error);
                
                const offer = data.data;
                const dict = data.dictionaries || {};
                const itineraries = offer.itineraries || [];
                const priceObj = offer.price || { base: 0, total: 0, currency: 'INR' };
                const baseFare = parseFloat(priceObj.base || 0);
                const totalFare = parseFloat(priceObj.total || 0);
                const taxAndFees = totalFare - baseFare;
                const currency = priceObj.currency || 'INR';
                const travelerCount = (offer.travelerPricings ? offer.travelerPricings.length : 1);
                
                // Prepared HTML Sections
                let itineraryHtml = itineraries.map((it, itIdx) => `
                    <div class="journey-leg mb-5 last-child-no-margin">
                        <h6 class="fw-900 x-small text-muted mb-4 uppercase" style="letter-spacing:1.5px;">
                            <i class="fas ${itIdx === 0 ? 'fa-plane-departure' : 'fa-plane-arrival'} me-2"></i>
                            ${itIdx === 0 ? 'Onward Journey' : 'Return Journey'}
                        </h6>
                        ${(it.segments || []).map((s, sIdx) => {
                            const carrier = (dict.carriers && dict.carriers[s.carrierCode]) ? dict.carriers[s.carrierCode] : s.carrierCode;
                            const fare = (offer.travelerPricings && offer.travelerPricings[0] && offer.travelerPricings[0].fareDetailsBySegment) ? 
                                         (offer.travelerPricings[0].fareDetailsBySegment[sIdx] || offer.travelerPricings[0].fareDetailsBySegment[0]) : {};
                            const baggage = fare.includedCheckedBags ? (fare.includedCheckedBags.weight || fare.includedCheckedBags.quantity) + (fare.includedCheckedBags.weightUnit || ' Qty') : '15 KG';
                            const depTime = s.departure && s.departure.at ? (s.departure.at.includes('T') ? s.departure.at.split('T')[1].substring(0,5) : s.departure.at.split(' ')[1].substring(0,5)) : '--:--';
                            const arrTime = s.arrival && s.arrival.at ? (s.arrival.at.includes('T') ? s.arrival.at.split('T')[1].substring(0,5) : s.arrival.at.split(' ')[1].substring(0,5)) : '--:--';

                            return `
                                <div class="segment-card p-3 rounded-4 mb-3" style="background:#f8fafc; border: 1px solid #e2e8f0;">
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <div class="bg-white rounded-3 p-2 shadow-sm border d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                                            <span class="fw-900 text-primary fs-5">${s.carrierCode ? s.carrierCode.substring(0,2) : '??'}</span>
                                        </div>
                                        <div>
                                            <div class="fw-900 text-navy">${carrier || 'Airline'}</div>
                                            <div class="x-small text-muted fw-800">${s.carrierCode || '??'}-${s.number || '000'} <span class="mx-2">•</span> ${fare.cabin || 'ECONOMY'} (${fare.class || 'Y'})</div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <div class="fw-900 fs-4 text-navy lh-1">${depTime}</div>
                                            <div class="x-small text-navy fw-800 mt-2">${(s.departure && s.departure.at) ? new Date(s.departure.at).toLocaleDateString('en-GB', {weekday:'short', day:'2-digit', month:'short'}) : ''}</div>
                                            <div class="x-small text-muted fw-700 mt-1">${s.departure ? (s.departure.iataCode + ', Terminal ' + (s.departure.terminal || '1')) : '???'}</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="x-small text-muted fw-900 mb-2">${it.duration ? it.duration.replace('PT','').toLowerCase() : ''}</div>
                                            <div class="position-relative d-flex align-items-center justify-content-center">
                                                <div style="height:2px; background:#cbd5e1; width:100%;"></div>
                                                <i class="fas fa-plane text-primary position-absolute bg-white px-2" style="font-size:12px;"></i>
                                            </div>
                                            <div class="x-small fw-800 text-success mt-2">Non-Stop</div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="fw-900 fs-4 text-navy lh-1">${arrTime}</div>
                                            <div class="x-small text-navy fw-800 mt-2">${(s.arrival && s.arrival.at) ? new Date(s.arrival.at).toLocaleDateString('en-GB', {weekday:'short', day:'2-digit', month:'short'}) : ''}</div>
                                            <div class="x-small text-muted fw-700 mt-1">${s.arrival ? (s.arrival.iataCode + ', Terminal ' + (s.arrival.terminal || '1')) : '???'}</div>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-4">
                                            <div class="x-small fw-800 text-muted"><i class="fas fa-suitcase me-1 text-success"></i> ${baggage}</div>
                                            <div class="x-small fw-800 text-muted"><i class="fas fa-briefcase me-1 text-primary"></i> 7 KG Cabin</div>
                                        </div>
                                        <div class="x-small fw-900 text-primary">Operated by ${carrier || 'Airline'}</div>
                                    </div>
                                </div>
                            `;
                        }).join('')}
                    </div>
                `).join('');

                const fareHtml = `
                    <div class="p-4">
                        <h5 class="fw-900 text-navy mb-4 fs-6">Fare Details (${travelerCount} Traveler)</h5>
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr><td class="text-muted fw-700">Base Fare</td><td class="text-end fw-900 text-navy">${currency} ${baseFare.toLocaleString()}</td></tr>
                                <tr><td class="text-muted fw-700">Taxes & Surcharges</td><td class="text-end fw-900 text-navy">${currency} ${taxAndFees.toLocaleString()}</td></tr>
                                <tr class="border-top"><td class="fw-900 text-navy fs-5 pt-3">Total Fare</td><td class="text-end fw-900 text-primary fs-3 pt-3">${currency} ${totalFare.toLocaleString()}</td></tr>
                            </tbody>
                        </table>
                    </div>
                `;

                const cancelHtml = `
                    <div class="p-4 text-center">
                        <div class="p-4 rounded-4 bg-danger bg-opacity-10 mb-4" style="border: 2px dashed #ef4444;">
                            <i class="fas fa-times-circle text-danger fs-1 mb-3"></i>
                            <h4 class="fw-900 text-danger mb-2">NON-REFUNDABLE FARE</h4>
                            <p class="text-muted fw-700 small mb-0">Cancellation and Date change penalties apply based on airline policy.</p>
                        </div>
                    </div>
                `;

                Swal.fire({
                    title: '',
                    html: `
                        <div class="text-start mmt-modal-wrapper overflow-hidden pb-4" style="font-family: 'Inter', sans-serif; background: #f4f7f9; min-height: 500px;">
                            <div class="custom-modal-header d-flex align-items-center justify-content-between px-4" style="background: #0a223d; padding-top: 15px;">
                                <div class="d-flex overflow-auto no-scrollbar">
                                    <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab active" id="tab-itinerary" onclick="switchDetailTab('itinerary')">FLIGHT DETAILS</div>
                                    <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab" id="tab-fare" onclick="switchDetailTab('fare')">FARE SUMMARY</div>
                                    <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab" id="tab-cancel" onclick="switchDetailTab('cancel')">CANCELLATION</div>
                                </div>
                            </div>
                            <div class="px-3 mt-4">
                                <div id="content-itinerary" class="detail-content rounded-4 border-0 shadow-sm bg-white overflow-hidden animate__animated animate__fadeIn">
                                    <div class="p-4">${itineraryHtml}</div>
                                </div>
                                <div id="content-fare" class="detail-content d-none rounded-4 bg-white shadow-sm overflow-hidden animate__animated animate__fadeIn">
                                    ${fareHtml}
                                </div>
                                <div id="content-cancel" class="detail-content d-none rounded-4 bg-white shadow-sm overflow-hidden animate__animated animate__fadeIn">
                                    ${cancelHtml}
                                </div>
                            </div>
                            <div class="px-3 mt-4">
                                <a href="/checkout?type=flight&id=${gdsId}" class="btn btn-primary rounded-pill w-100 fw-900 py-3 shadow-lg">
                                    PROCEED TO BOOK THIS FLIGHT <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                        <style>
                            .premium-tab { color: rgba(255,255,255,0.6); border-bottom: 3px solid transparent; white-space: nowrap; transition: 0.3s; }
                            .premium-tab:hover { color: #fff; }
                            .premium-tab.active { color: #fff; border-bottom-color: #2563eb; }
                            .swal2-html-container { padding: 0 !important; margin: 0 !important; }
                            .swal2-close { color: #fff !important; font-size: 24px; top: 10px; right: 10px; transition: 0.3s; }
                            .swal2-close:hover { transform: rotate(90deg); color: #ff6b00 !important; }
                        </style>
                    `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '900px',
                    background: '#f4f7f9',
                });

                window.switchDetailTab = function(tab) {
                    document.querySelectorAll('.premium-tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.detail-content').forEach(c => c.classList.add('d-none'));
                    const targetTab = document.getElementById('tab-' + tab);
                    if (targetTab) targetTab.classList.add('active');
                    const targetContent = document.getElementById('content-' + tab);
                    if (targetContent) targetContent.classList.remove('d-none');
                };
            })
            .catch(err => {
                Swal.fire('Error', err.message || 'Failed to fetch details', 'error');
            });
    };

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

<!-- Flight Details Modal Removed - Now using premium Swal view matching main flights page -->

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

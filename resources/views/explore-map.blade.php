@extends('layouts.app')

@section('title', "Explore on Map — Flights & Hotels | Trip Zant")

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    :root {
        --map-sidebar-width: 400px;
        --map-top-bar-height: 80px;
    }

    .explore-map-page {
        height: calc(100vh - 70px); /* Adjust based on your header height */
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #f8fafc;
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

    .map-sidebar {
        width: var(--map-sidebar-width);
        background: #fff;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        z-index: 999;
        transition: transform 0.3s ease;
    }

    .sidebar-tabs {
        display: flex;
        padding: 16px;
        gap: 12px;
        border-bottom: 1px solid #e2e8f0;
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

    .sidebar-tab i {
        font-size: 18px;
    }

    .sidebar-tab span {
        font-size: 12px;
        font-weight: 700;
    }

    .listings-container {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
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
        background: #fff;
        border-radius: 30px;
        padding: 6px 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        border: 2px solid #fff;
        font-weight: 800;
        font-size: 13px;
        color: #1e293b;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .custom-price-marker.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: scale(1.1);
        z-index: 1000 !important;
    }

    .marker-icon {
        width: 18px;
        height: 18px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 10px;
    }

    .custom-price-marker.active .marker-icon {
        background: #fff;
        color: var(--primary);
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

    /* Animation */
    .animate-in {
        animation: slideIn 0.5s ease-out forwards;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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
        <div class="map-search-engine">
            <div class="search-input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" placeholder="Origin" value="{{ request('origin', 'DEL') }}">
            </div>
            <div class="search-input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="text" placeholder="Date" value="{{ date('d M', strtotime('+3 days')) }}">
            </div>
            <div class="search-input-group">
                <i class="fas fa-user-friends"></i>
                <input type="text" placeholder="Add guests" value="{{ request('guests', '1 Adult') }}">
            </div>
            <button class="btn-map-search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="map-content-area">
        <!-- Sidebar -->
        <div class="map-sidebar">
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

            <div class="px-3 pt-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h5 class="fw-900 mb-0" id="results-count">{{ count($flights ?? []) }} Flights found</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm border-0 fw-bold text-muted" type="button" data-bs-toggle="dropdown">
                           Sort by <i class="fas fa-chevron-down ms-1" style="font-size:10px;"></i>
                        </button>
                    </div>
                </div>
                <p class="text-muted small mb-3">Showing real-time results from 100+ sources</p>
            </div>

            <div class="listings-container" id="listingsContainer">
                <!-- Listings loaded via JS -->
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

    let currentTab = 'flights';
    let map, markers = [], routeLines = [];

    // --- Core Logic ---

    function initMap() {
        // Default to India view
        map = L.map('exploreMap', {
            center: [20.5937, 78.9629],
            zoom: 5,
            zoomControl: false
        });

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; Trip\'Stay'
        }).addTo(map);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        renderData();
    }

    function switchTab(tab) {
        currentTab = tab;
        document.querySelectorAll('.sidebar-tab').forEach(t => t.classList.remove('active'));
        document.getElementById(`tab-${tab}`).classList.add('active');
        
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
        
        document.getElementById('results-count').innerText = `${data.length} ${countText}`;

        renderData();
    }

    function renderData() {
        const data = currentTab === 'flights' ? flightsData : hotelsData;
        const container = document.getElementById('listingsContainer');
        container.innerHTML = '';
        
        // Clear old markers and lines
        markers.forEach(m => map.removeLayer(m));
        routeLines.forEach(l => map.removeLayer(l));
        markers = [];
        routeLines = [];

        // Origin for flight routes (Goa Airport as center for demo)
        const originPoint = [15.3900, 73.8123];

        data.forEach((item, index) => {
            // 1. Render Sidebar Card
            const card = document.createElement('div');
            card.className = `listing-card animate-in`;
            card.style.animationDelay = `${index * 0.1}s`;
            card.id = `card-${item.id}`;
            card.onclick = () => focusItem(item.id, true);
            
            card.innerHTML = `
                <img src="${item.image}" class="listing-image" alt="${item.title}">
                <div class="listing-info">
                    <div class="d-flex justify-content-between">
                        <h6 class="listing-title">${item.title}</h6>
                        <span class="listing-rating"><i class="fas fa-star"></i> ${item.rating}</span>
                    </div>
                    <div class="listing-meta">${item.meta}</div>
                    <div class="listing-price-row">
                        <div class="listing-price">${item.price}</div>
                        <button class="btn btn-sm btn-navy px-3 rounded-pill fw-bold" style="font-size:10px;">SELECT</button>
                    </div>
                </div>
            `;
            container.appendChild(card);

            // 2. Render Map Marker
            const markerTypeIcon = {
                'flights': 'plane',
                'hotels': 'hotel',
                'tour': 'camera-retro'
            };
            
            const iconHtml = `
                <div class="custom-price-marker" id="marker-${item.id}">
                    <div class="marker-icon"><i class="fas fa-${markerTypeIcon[item.type]}"></i></div>
                    ${item.price}
                </div>
            `;

            const customIcon = L.divIcon({
                className: 'leaflet-data-marker',
                html: iconHtml,
                iconSize: [100, 40],
                iconAnchor: [50, 20]
            });

            const marker = L.marker([item.lat, item.lng], { icon: customIcon }).addTo(map);
            marker.on('click', () => focusItem(item.id, false));
            markers.push(marker);

            // 3. Add Route Lines (Flight Only)
            if (currentTab === 'flights') {
                const line = L.polyline([originPoint, [item.lat, item.lng]], {
                    color: '#0b3d61',
                    weight: 2,
                    opacity: 0.3,
                    dashArray: '5, 10'
                }).addTo(map);
                routeLines.push(line);
            }
        });

        // Fit bounds if data exists
        if(data.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.3));
        }
    }

    function focusItem(id, fromSidebar) {
        // Highlight logic
        document.querySelectorAll('.listing-card').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.custom-price-marker').forEach(m => m.classList.remove('active'));

        const card = document.getElementById(`card-${id}`);
        const marker = document.getElementById(`marker-${id}`);

        if(card) card.classList.add('active');
        if(marker) marker.classList.add('active');

        // Scroll sidebar
        if(!fromSidebar && card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Pan map
        let data;
        if (currentTab === 'flights') data = flightsData;
        else if (currentTab === 'hotels') data = hotelsData;
        else data = toursData;
        
        const item = data.find(i => i.id === id);
        if(item) {
            map.flyTo([item.lat, item.lng], 13, { duration: 1.5 });
        }
    }

    function toggleWeatherLayer() {
        const pill = document.getElementById('mapWeatherPill');
        const btn = document.getElementById('toggleWeather');
        pill.classList.toggle('d-none');
        btn.classList.toggle('active');
        
        // Mock effect: adding weather colors to markers
        document.querySelectorAll('.custom-price-marker').forEach(m => {
            if (!pill.classList.contains('d-none')) {
                m.classList.add('weather-active');
                if (Math.random() > 0.5) m.style.boxShadow = '0 0 15px rgba(14, 165, 233, 0.4)';
                else m.style.boxShadow = '0 0 15px rgba(249, 115, 22, 0.4)';
            } else {
                m.classList.remove('weather-active');
                m.style.boxShadow = '';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initMap);
</script>

@endsection

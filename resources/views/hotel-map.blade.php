@extends('layouts.app')

@section('title', " Select Hotel on Map — Trip Zant Booking.com " )
@section('active-hotels', 'active')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="map-view-wrapper">
    <!-- Search / List Sidebar -->
    <div class="map-sidebar">
        <div class="p-3 border-bottom bg-light bg-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-900 mb-0">Hotels in Goa</h6>
                <a href="/hotels" class="btn btn-sm btn-white border rounded-pill px-3 fw-700" style="font-size:11px;">LIST VIEW</a>
            </div>
            <p class="mb-0 text-muted" style="font-size:11px; font-weight:600;"><i class="fas fa-calendar-alt text-primary me-1"></i> 12 Nov – 15 Nov · 2 Adults</p>
        </div>

        <!-- Scrollable List -->
        <div class="hotel-scroller" id="hotelScroller">
            <!-- Hotel 1 -->
            <div class="map-card-compact active" onclick="focusHotel(0)">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&auto=format&fit=crop&q=80" style="width:100px; height:80px; object-fit:cover; border-radius:12px;" alt="">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-900 mb-1" style="font-size:14px; line-height:1.2;">Taj Exotica Resort</h6>
                        <span class="rating-pill px-2 py-1"><i class="fas fa-star" style="font-size:9px;"></i> 4.9</span>
                    </div>
                    <div class="proximity-pill mb-2"><i class="fas fa-umbrella-beach me-1"></i> 0.2 km from Benaulim Beach</div>
                    <div class="fw-900 text-primary" style="font-size:16px;">₹24,500 <span style="font-size:10px; color:#aaa; font-weight:500;">/night</span></div>
                </div>
            </div>

            <!-- Hotel 2 -->
            <div class="map-card-compact" onclick="focusHotel(1)">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&auto=format&fit=crop&q=80" style="width:100px; height:80px; object-fit:cover; border-radius:12px;" alt="">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-900 mb-1" style="font-size:14px; line-height:1.2;">Novotel Goa Resort</h6>
                        <span class="rating-pill px-2 py-1"><i class="fas fa-star" style="font-size:9px;"></i> 4.5</span>
                    </div>
                    <div class="proximity-pill mb-2"><i class="fas fa-walking me-1"></i> 1.5 km from Candolim Beach</div>
                    <div class="fw-900 text-primary" style="font-size:16px;">₹12,200 <span style="font-size:10px; color:#aaa; font-weight:500;">/night</span></div>
                </div>
            </div>

            <!-- Hotel 3 -->
            <div class="map-card-compact" onclick="focusHotel(2)">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500&auto=format&fit=crop&q=80" style="width:100px; height:80px; object-fit:cover; border-radius:12px;" alt="">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-900 mb-1" style="font-size:14px; line-height:1.2;">The Leela Goa</h6>
                        <span class="rating-pill px-2 py-1"><i class="fas fa-star" style="font-size:9px;"></i> 4.8</span>
                    </div>
                    <div class="proximity-pill mb-2"><i class="fas fa-shuttle-van me-1"></i> 45 km from Dabolim Airport</div>
                    <div class="fw-900 text-primary" style="font-size:16px;">₹32,900 <span style="font-size:10px; color:#aaa; font-weight:500;">/night</span></div>
                </div>
            </div>

            <!-- Hotel 4 -->
            <div class="map-card-compact" onclick="focusHotel(3)">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=500&auto=format&fit=crop&q=80" style="width:100px; height:80px; object-fit:cover; border-radius:12px;" alt="">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-900 mb-1" style="font-size:14px; line-height:1.2;">Radisson Blu Goa</h6>
                        <span class="rating-pill px-2 py-1"><i class="fas fa-star" style="font-size:9px;"></i> 4.3</span>
                    </div>
                    <div class="proximity-pill mb-2"><i class="fas fa-car me-1"></i> 3.2 km from Colva Beach</div>
                    <div class="fw-900 text-primary" style="font-size:16px;">₹9,800 <span style="font-size:10px; color:#aaa; font-weight:500;">/night</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Canvas Area -->
    <div class="map-container" id="liveMap">
    </div>
</div>

<script>
    // 1. Hotel Data with Real Coordinates (Goa)
    const hotels = [
        { name: "Taj Exotica Resort", price: "₹24,500", lat: 15.2657, lng: 73.9189 },
        { name: "Novotel Goa Resort", price: "₹12,200", lat: 15.5186, lng: 73.7656 },
        { name: "The Leela Goa", price: "₹32,900", lat: 15.1610, lng: 73.9450 },
        { name: "Radisson Blu Goa", price: "₹9,800", lat: 15.2345, lng: 73.9312 }
    ];

    // 2. Initialize Leaflet Map
    const map = L.map('liveMap', {
        center: [15.35, 73.85],
        zoom: 11,
        zoomControl: false // Custom controls added later
    });

    // 3. Elegant 'Misty' Street View Style
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; Trip Zant Map Hub'
    }).addTo(map);

    // 4. Create Price Markers
    hotels.forEach((hotel, index) => {
        const priceIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="map-badge-price ${index === 0 ? 'active' : ''}" id="marker-${index}">${hotel.price}</div>`,
            iconSize: [80, 40],
            iconAnchor: [40, 20]
        });

        const marker = L.marker([hotel.lat, hotel.lng], { icon: priceIcon }).addTo(map);
        
        marker.on('click', () => focusHotel(index));
    });

    function focusHotel(index) {
        const hotel = hotels[index];
        
        // Update sidebar state
        document.querySelectorAll('.map-card-compact').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.map-card-compact')[index].classList.add('active');

        // Update marker state
        document.querySelectorAll('.map-badge-price').forEach(m => m.classList.remove('active'));
        const markerEl = document.getElementById(`marker-${index}`);
        if(markerEl) markerEl.classList.add('active');

        // Pan map smoothly
        map.flyTo([hotel.lat, hotel.lng], 14, {
            duration: 1.5,
            easeLinearity: 0.25
        });

        // Scroll sidebar to item
        document.querySelectorAll('.map-card-compact')[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Add Zoom Controls
    L.control.zoom({ position: 'bottomright' }).addTo(map);
</script>
@endsection

@extends('layouts.app')

@section('title', "Taj Mahal and Wildlife with Royal Stay at Castles | Trip Zant")

@section('content')
<style>
    :root {
        --tr-accent: #008489;
        --tr-text-navy: #1e293b;
        --tr-gray-light: #f8fafc;
        --tr-border: #e2e8f0;
    }

    .tour-details-page {
        background: #fff;
        padding-top: 20px;
    }

    .breadcrumb-tr {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 20px;
    }

    .breadcrumb-tr a { color: #64748b; text-decoration: none; }
    .breadcrumb-tr span { color: #94a3b8; }

    .tour-header-title {
        font-size: 32px;
        font-weight: 900;
        color: var(--tr-text-navy);
        margin-bottom: 15px;
    }

    .tour-header-stats {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .tr-badge-solid {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 800;
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .stat-pipe { width: 1px; height: 15px; background: #cbd5e1; }

    /* Hero Gallery */
    .tr-hero-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-gap: 12px;
        height: 450px;
        margin-bottom: 40px;
    }

    .hero-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px 0 0 12px;
    }

    .hero-side-grid {
        display: grid;
        grid-template-rows: 1fr 1fr;
        grid-gap: 12px;
    }

    .hero-sub-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-sub-img.top-right { border-radius: 0 12px 0 0; }
    .hero-sub-img.bottom-right { border-radius: 0 0 12px 0; }

    .view-all-overlay {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(255,255,255,0.9);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        color: var(--tr-text-navy);
    }

    /* Content Layout */
    .tour-content-main {
        max-width: 800px;
    }

    .route-map-container {
        background: #f1f5f9;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 40px;
        position: relative;
    }

    .route-map-img { width: 100%; height: 350px; object-fit: cover; }

    .itinerary-section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .itinerary-item-tr {
        padding: 20px;
        border: 1px solid var(--tr-border);
        border-radius: 12px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: background 0.2s;
    }

    .itinerary-item-tr:hover { background: #f8fafc; }

    /* Sidebar Box */
    .tr-booking-card {
        border: 1px solid var(--tr-border);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        position: sticky;
        top: 100px;
    }

    .tr-price-tag {
        font-size: 32px;
        font-weight: 900;
        color: var(--tr-text-navy);
        margin-bottom: 5px;
    }

    .tr-select-group {
        border: 1px solid var(--tr-border);
        border-radius: 12px;
        padding: 12px 15px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .tr-select-group i { color: #64748b; font-size: 18px; }
    .tr-select-group select {
        border: none;
        background: transparent;
        font-weight: 700;
        font-size: 14px;
        width: 100%;
        outline: none;
    }

    .btn-tr-booking {
        background: var(--tr-accent);
        color: #fff;
        border: none;
        width: 100%;
        padding: 18px;
        border-radius: 99px;
        font-weight: 900;
        font-size: 18px;
        margin-top: 10px;
    }

    .tr-side-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--tr-text-navy);
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

</style>

<div class="tour-details-page">
    <div class="container">
        <!-- Breadcrumbs -->
        <div class="breadcrumb-tr">
            Home <span>/</span> Asia Tours <span>/</span> India Tours <span>/</span> Search Results
        </div>

        <h1 class="tour-header-title">{{ $tour['title'] ?? 'Tour Details' }}</h1>

        <div class="tour-header-stats">
            <span class="tr-badge-solid"><i class="fas fa-star text-warning me-1"></i> Best Seller</span>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-900 text-navy">4.8</span>
                <div class="text-warning small"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <a href="#" class="text-muted small fw-bold text-decoration-underline">128 traveler reviews</a>
            </div>
            <div class="stat-pipe"></div>
            <span class="fw-800 text-navy small">{{ $tour['duration'] ?? 'Multiple Days' }}</span>
            <div class="stat-pipe"></div>
            <span class="text-muted small fw-bold">Location: <span class="text-navy">{{ $tour['location'] ?? 'Varies' }}</span></span>
        </div>

        <!-- Hero Gallery -->
        <div class="tr-hero-grid">
            <div class="position-relative">
                <img src="{{ $tour['image'] ?? 'https://images.unsplash.com/photo-1548013146-72479768b921?w=1000' }}" class="hero-main-img">
            </div>
            <div class="hero-side-grid">
                <img src="{{ $tour['image'] ?? 'https://images.unsplash.com/photo-1524492707947-282e7a5c71c4?w=500' }}" class="hero-sub-img top-right">
                <div class="position-relative h-100">
                    <img src="{{ $tour['image'] ?? 'https://images.unsplash.com/photo-1477587458883-47145ed94245?w=500' }}" class="hero-sub-img bottom-right">
                    <div class="view-all-overlay"><i class="fas fa-th me-2"></i> View all</div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-8">
                <div class="mb-5">
                    <h3 class="fw-900 text-navy mb-3">About this Tour</h3>
                    <p class="text-muted">{{ $tour['description'] ?? 'No description available for this tour.' }}</p>
                </div>
                <!-- Itinerary -->
                <div class="itinerary-section-title">
                    <h3 class="fw-900 text-navy mb-0">Itinerary</h3>
                </div>

                <div class="itinerary-list-tr">
                    @if(isset($tour['itinerary']) && is_array($tour['itinerary']))
                        @foreach($tour['itinerary'] as $index => $item)
                        <div class="itinerary-item-tr">
                            <div class="d-flex align-items-center gap-4">
                                <span class="text-muted fw-800 small">Day {{ $index + 1 }}</span>
                                <h6 class="fw-900 text-navy mb-0">{{ $item }}</h6>
                            </div>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted fw-bold">Check with the operator for full itinerary details.</p>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="tr-booking-card">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <div class="text-muted small fw-bold">From <span class="text-decoration-line-through">${{ number_format(($tour['price'] ?? 0) * 1.2, 2) }}</span></div>
                            <div class="tr-price-tag">$<span id="currentPrice">{{ number_format($tour['price'] ?? 0, 2) }}</span> <span style="font-size: 14px; font-weight: 700; color: #64748b;">per person</span></div>
                        </div>
                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-900">-20%</span>
                    </div>

                        <div class="tr-select-group mt-5">
                            <i class="fas fa-calendar-alt"></i>
                            <select id="dateSelect">
                                <option value="0">June 2026</option>
                                <option value="45">July 2026 (+ $45)</option>
                                <option value="90">August 2026 (+ $90)</option>
                            </select>
                        </div>

                        <div class="tr-select-group">
                            <i class="fas fa-user-friends"></i>
                            <select id="travelerSelect">
                                <option value="0">2 Adults, 1 Child</option>
                                <option value="50">1 Adult (+ $50)</option>
                                <option value="-20">2 Adults (- $20)</option>
                            </select>
                        </div>

                    <button class="btn-tr-booking hvr-grow">Check Availability</button>
                    
                    <div class="d-flex align-items-center gap-2 justify-content-center mt-3 mb-5">
                        <i class="fas fa-shield-alt text-success"></i>
                        <span class="x-small fw-bold text-muted">Best price guarantee <a href="#" class="text-primary deco-none">Learn More</a></span>
                    </div>

                    <div class="side-actions mt-4">
                        <a href="#" class="tr-side-link"><i class="fas fa-file-pdf text-danger"></i> Download PDF Brochure</a>
                        <a href="#" class="tr-side-link"><i class="fas fa-comment-dots text-primary"></i> Contact Operator</a>
                        <a href="#" class="tr-side-link border-0"><i class="fas fa-share-alt"></i> Share tour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateSelect = document.getElementById('dateSelect');
        const travelerSelect = document.getElementById('travelerSelect');
        const priceDisplay = document.getElementById('currentPrice');
        const basePrice = 710;

        function updatePrice() {
            const dateSurcharge = parseInt(dateSelect.value);
            const travelerAdjustment = parseInt(travelerSelect.value);
            const finalPrice = basePrice + dateSurcharge + travelerAdjustment;
            
            priceDisplay.style.opacity = '0';
            setTimeout(() => {
                priceDisplay.innerText = finalPrice;
                priceDisplay.style.opacity = '1';
            }, 100);
        }

        dateSelect.addEventListener('change', updatePrice);
        travelerSelect.addEventListener('change', updatePrice);
    });
</script>

<style>
    #currentPrice { transition: opacity 0.15s ease; }
</style>
@endsection

@extends('layouts.app')

@section('title', "Tour Packages & Vacation Deals | Trip Zant")

@section('content')
<style>
    :root {
        --tr-primary: #008489;
        --tr-primary-hover: #006a6e;
        --tr-sidebar-bg: #fff;
        --tr-card-border: #e2e8f0;
        --tr-text-navy: #1e293b;
        --tr-gray: #64748b;
    }

    .tour-listing-page {
        background: #f8fafc;
        min-height: 100vh;
        padding: 40px 0;
    }

    /* Sidebar Filters */
    .tr-filter-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .filter-section-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--tr-text-navy);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .applied-filter-pill {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 99px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .btn-clear-all {
        color: var(--tr-primary);
        font-weight: 800;
        font-size: 14px;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    .filter-accordion-header {
        font-weight: 800;
        font-size: 14px;
        color: var(--tr-text-navy);
        padding: 15px 0;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        cursor: pointer;
    }

    /* Tour Card */
    .tr-tour-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--tr-card-border);
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }

    .tr-tour-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transform: translateY(-4px);
    }

    .tr-card-image-side {
        width: 320px;
        position: relative;
    }

    .tr-card-image-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .map-overlay-btn {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 10;
        white-space: nowrap;
    }

    .tr-card-content {
        flex: 1;
        padding: 24px;
        display: flex;
        flex-direction: column;
    }

    .tr-card-pricing-side {
        width: 240px;
        padding: 24px;
        border-left: 1px solid #f1f5f9;
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .tr-badge {
        font-size: 11px;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tr-badge-primary { background: #f0f9ff; color: var(--tr-primary); }
    .tr-badge-gray { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
    .tr-badge-award { background: #1e293b; color: #fff; }

    .rating-score { font-weight: 800; font-size: 15px; color: var(--tr-text-navy); }
    .rating-stars { color: #f59e0b; font-size: 12px; }

    .tour-meta-table { font-size: 13px; margin-top: 15px; }
    .tour-meta-table td { padding: 4px 0; }
    .tour-meta-label { font-weight: 800; color: #94a3b8; width: 120px; }
    .tour-meta-val { font-weight: 700; color: var(--tr-text-navy); }

    .quote-box {
        background: #fff;
        border-left: 3px solid #e2e8f0;
        padding: 10px 15px;
        margin-top: 20px;
    }

    .discount-ribbon {
        background: #ef4444;
        color: #fff;
        font-weight: 900;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 99px;
        display: inline-block;
        margin-bottom: 15px;
    }

    .btn-tr-primary {
        background: var(--tr-primary);
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 99px;
        font-weight: 800;
        width: 100%;
        transition: all 0.2s ease;
    }

    .btn-tr-primary:hover {
        background: var(--tr-primary-hover);
        color: #fff;
    }

    .btn-tr-outline {
        background: #ecf8f8;
        color: var(--tr-primary);
        border: none;
        padding: 12px 24px;
        border-radius: 99px;
        font-weight: 800;
        width: 100%;
        margin-top: 10px;
    }

</style>

<div class="tour-listing-page">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="tr-filter-card">
                    <div class="filter-section-title">
                        <i class="fas fa-tasks"></i> Applied filters
                    </div>
                    @if(isset($params['destinationCode']))
                    <div class="applied-filter-pill">
                        Destination: {{ strtoupper($params['destinationCode']) }}
                        <i class="fas fa-times-circle text-muted" style="cursor:pointer;"></i>
                    </div>
                    @endif
                    <a href="#" class="btn-clear-all">Clear all</a>

                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-800 text-navy small">Length</span>
                            <i class="fas fa-chevron-up text-muted small"></i>
                        </div>
                        <div class="d-flex justify-content-between x-small fw-bold text-muted mb-2">
                            <span>min. 1 day</span>
                            <span>21+ days</span>
                        </div>
                        <input type="range" class="form-range" min="1" max="21" value="11">
                    </div>

                    <div class="filter-accordion-header">
                        Departure date
                        <i class="fas fa-chevron-down text-muted"></i>
                    </div>
                </div>

                <div class="tr-filter-card bg-light border-0">
                    <h6 class="fw-800 mb-2">Help Center</h6>
                    <p class="x-small text-muted fw-bold mb-3">Speak to an expert and find the perfect tour just for you.</p>
                    <button class="btn btn-sm btn-navy w-100 rounded-pill py-2 fw-bold">Call an Expert</button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rating-stars fs-5"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <h5 class="fw-900 text-navy mb-0">{{ count($tours) }} Results for Your Search</h5>
                </div>

                <!-- Tour Result Cards -->
                @if(isset($tours) && count($tours) > 0)
                    @foreach($tours as $tour)
                <div class="tr-tour-card d-flex flex-column flex-md-row">
                    <div class="tr-card-image-side">
                        <img src="{{ $tour['image'] }}" alt="Tour Image">
                        <button class="map-overlay-btn hvr-grow">
                            <i class="fas fa-project-diagram"></i> View Map
                        </button>
                        <div class="position-absolute top-0 end-0 m-3 btn btn-white btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; z-index: 10;">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                    <div class="tr-card-content">
                        <div class="d-flex gap-2 mb-3">
                            <span class="tr-badge tr-badge-primary">Best Seller</span>
                            <span class="tr-badge tr-badge-gray">Explorer</span>
                        </div>
                        <h5 class="fw-900 text-navy mb-2">{{ $tour['title'] }}</h5>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="rating-score">{{ $tour['rating'] }}</span>
                            <div class="rating-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                            <span class="text-muted small fw-bold">({{ $tour['reviews'] }} traveler reviews)</span>
                            <span class="tr-badge tr-badge-award ms-2">Award Winner</span>
                        </div>
                        
                        <div class="quote-box">
                            <p class="small text-muted italic mb-1">"It was a wonderful tour!!"</p>
                            <span class="x-small fw-bold text-muted">Alexander, traveled in March</span>
                        </div>

                        <table class="tour-meta-table">
                            <tr>
                                <td class="tour-meta-label">Duration</td>
                                <td class="tour-meta-val">{{ $tour['duration'] }}</td>
                            </tr>
                            <tr>
                                <td class="tour-meta-label">Destinations</td>
                                <td class="tour-meta-val">{{ $tour['destinations'] }}</td>
                            </tr>
                            <tr>
                                <td class="tour-meta-label">Age Range</td>
                                <td class="tour-meta-val">Ages 18+</td>
                            </tr>
                            <tr>
                                <td class="tour-meta-label">Operator</td>
                                <td class="tour-meta-val text-primary">Swastik India Journeys <span class="badge bg-light text-muted fw-bold ms-1" style="font-size:8px;">PLATINUM</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="tr-card-pricing-side">
                        <div>
                            <div class="discount-ribbon">{{ $tour['discount'] }}</div>
                            <div class="small fw-bold text-muted">From <span class="text-decoration-line-through">${{ $tour['original_price'] }}</span></div>
                            <div class="fw-900 text-navy fs-2">us ${{ $tour['price'] }}</div>
                            <div class="x-small fw-bold text-muted">per person</div>
                        </div>
                        <div class="mt-4">
                            <div class="x-small fw-bold text-muted mb-2"><i class="fas fa-info-circle me-1"></i> Price based on Private Double Room</div>
                            <a href="/tours/details/{{ $tour['id'] }}" class="btn-tr-primary text-decoration-none d-block text-center">View tour</a>
                            <button class="btn-tr-outline">Download Brochure</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
                    <div class="py-5">
                        <div class="h-logo-icon mx-auto mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-map text-muted opacity-50 fa-2x"></i>
                        </div>
                        <h4 class="fw-900 outfit text-navy">No Tours Found</h4>
                        <p class="text-muted fw-bold">We couldn't find any activities matching your search.</p>
                        <a href="{{ localized_url('/') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-800 mt-3">TRY ANOTHER SEARCH</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .btn-navy { background: #0b3d61; color: #fff; border: none; }
    .btn-navy:hover { background: #001f3f; color: #fff; }
    .x-small { font-size: 11px; }
</style>
@endsection

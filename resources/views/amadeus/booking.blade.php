@extends('layouts.b2b_master')

@section('title', 'Search Flights | Amadeus Partner Panel')

@section('styles')
<style>
    .search-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }
    .search-tab {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: 1px solid #dfe1e6;
        background: #fff;
        color: #172b4d;
    }
    .search-tab.active {
        background: var(--b2b-blue);
        color: #fff;
        border-color: var(--b2b-blue);
    }
    .search-tab i { font-size: 14px; opacity: 0.8; }
    
    .meta-dropdowns {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        justify-content: flex-end;
    }
    .meta-btn {
        background: #fff;
        border: 1px solid #dfe1e6;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #172b4d;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .meta-btn i { color: #6b778c; }
    
    .search-input-group {
        display: flex;
        background: #fff;
        border: 1px solid #4c5e7d;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .search-field {
        flex: 1;
        padding: 12px 20px;
        border-right: 1px solid #dfe1e6;
        position: relative;
    }
    .search-field:last-child { border-right: none; }
    .search-field input {
        border: none;
        width: 100%;
        font-weight: 600;
        font-size: 14px;
        outline: none;
        background: transparent;
        color: #172b4d;
    }
    .search-field label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #6b778c;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .swap-btn {
        position: absolute;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 32px;
        height: 32px;
        background: #fff;
        border: 1px solid #dfe1e6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #0052cc;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .search-result-tabs {
        display: flex;
        gap: 10px;
        margin-top: 40px;
        border-bottom: 2px solid #dfe1e6;
        padding-bottom: 0;
    }
    .result-tab {
        padding: 12px 24px;
        font-weight: 700;
        font-size: 14px;
        color: #6b778c;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        border-radius: 8px 8px 0 0;
    }
    .result-tab.active {
        color: #0052cc;
        background: #ebf2ff;
    }
    .result-tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background: #0052cc;
    }
    
    .btn-search-main {
        background: #00875a;
        color: #fff;
        border: none;
        padding: 0 35px;
        border-radius: 8px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        transition: 0.2s;
    }
    .btn-search-main:hover {
        background: #006644;
        color: #fff;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="search-card p-4">
    <div class="row align-items-end">
        <div class="col-lg-12">
            <div class="search-tabs">
                <div class="search-tab {{ request()->get('type', 'round') == 'round' ? 'active' : '' }}">
                    <i class="fas fa-sync-alt"></i> Round Trip
                </div>
                <div class="search-tab {{ request()->get('type') == 'oneway' ? 'active' : '' }}">
                    <i class="fas fa-arrow-right"></i> One Way
                </div>
                <div class="search-tab">
                    <i class="fas fa-th-large"></i> Multi-City
                </div>
                <div class="search-tab">
                    <i class="far fa-circle"></i> Two One-Ways
                </div>
            </div>

            <div class="meta-dropdowns">
                <div class="dropdown">
                    <button class="meta-btn dropdown-toggle border-0 shadow-none bg-light" data-bs-toggle="dropdown">
                        <i class="fas fa-user-friends"></i> Passengers (1)
                    </button>
                </div>
                <div class="dropdown">
                    <button class="meta-btn dropdown-toggle border-0 shadow-none bg-light" data-bs-toggle="dropdown">
                        <i class="fas fa-chair"></i> Cabin Class (4)
                    </button>
                </div>
                <div class="dropdown">
                    <button class="meta-btn dropdown-toggle border-primary border-opacity-50" data-bs-toggle="dropdown">
                        <i class="fas fa-globe"></i> [AMADEUS-GDS]
                    </button>
                    <div class="dropdown-menu p-3 shadow-lg border-0" style="min-width: 250px; border-radius: 12px;">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked id="pcc1">
                            <label class="form-check-label small fw-600" for="pcc1">BNEA8217Z [AMADEUS-GDS]</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="pcc2">
                            <label class="form-check-label small fw-600" for="pcc2">BNEA8217Z [AMADEUS-NDC]</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pcc3">
                            <label class="form-check-label small fw-600" for="pcc3">Consolidator Pcc -5KGL [SABRE-NDC]</label>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="meta-btn dropdown-toggle border-0 shadow-none bg-light" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="fas fa-cog"></i> Advanced
                    </button>
                    <div class="dropdown-menu p-4 shadow-lg border-0 mt-2" style="width: 400px; border-radius: 12px; z-index: 1100;">
                        <div class="mb-4">
                            <label class="form-label-b2b mb-2">Markup/Service Fee <span class="text-muted fw-400">(Per passenger)</span></label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <select class="form-select border-0 bg-light fw-700" style="font-size: 13px;">
                                        <option>$</option>
                                        <option>₹</option>
                                    </select>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control border-0 bg-light" placeholder="Amount">
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="showAgentPrice" checked>
                                    <label class="form-check-label small fw-600" for="showAgentPrice">Show Agent Price - Search Results</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="showPriceBreakdown" checked>
                                    <label class="form-check-label small fw-600" for="showPriceBreakdown">Show Price Breakdown</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-b2b">Account Code: <span class="text-muted fw-400">(AirlineCode/AccountCode)</span></label>
                            <input type="text" class="form-control border-0 bg-light">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label-b2b">Airline Group:</label>
                                <select class="form-select border-0 bg-light small">
                                    <option>All</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label-b2b">Fare Type:</label>
                                <select class="form-select border-0 bg-light small">
                                    <option>All</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-b2b">Baggage:</label>
                            <select class="form-select border-0 bg-light small">
                                <option>Any</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-b2b">NDC Promotion Code: <span class="text-muted fw-400">(AirlineCode/PromoCode)</span></label>
                            <input type="text" class="form-control border-0 bg-light">
                        </div>

                        <div class="mb-4">
                            <label class="form-label-b2b mb-2">Penalties:</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="p_ref">
                                        <label class="form-check-label tiny fw-600" for="p_ref">Refundable</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="p_cha">
                                        <label class="form-check-label tiny fw-600" for="p_cha">Changeable</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="p_nonc">
                                        <label class="form-check-label tiny fw-600" for="p_nonc">NonChangeable</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="p_unr">
                                        <label class="form-check-label tiny fw-600" for="p_unr">Unrestricted</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="p_unr2">
                                        <label class="form-check-label tiny fw-600" for="p_unr2">Unrestricted</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="p_noadv">
                                        <label class="form-check-label tiny fw-600" for="p_noadv">NoAdvancePurchase</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="p_nopen">
                                        <label class="form-check-label tiny fw-600" for="p_nopen">NoPenalties</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success px-4 py-2 fw-700" style="background: #00875a; border-radius: 6px;">Apply</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3">
                <div class="search-input-group flex-grow-1">
                    <div class="search-field">
                        <label>From</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-plane-departure text-muted small"></i>
                            <input type="text" placeholder="Select an Origin" value="DEL - Delhi, India">
                        </div>
                        <div class="swap-btn"><i class="fas fa-exchange-alt"></i></div>
                    </div>
                    <div class="search-field ps-4">
                        <label>To</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-plane-arrival text-muted small"></i>
                            <input type="text" placeholder="Select a Destination" value="DXB - Dubai, UAE">
                        </div>
                    </div>
                    <div class="search-field" style="flex: 0.8;">
                        <label>Travel Dates</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="far fa-calendar-alt text-muted small"></i>
                            <input type="text" placeholder="Select Dates" value="07 Jul 2026 - 10 Jul 2026">
                        </div>
                    </div>
                    <div class="search-field">
                        <label>Select Airlines</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-plane text-muted small"></i>
                            <input type="text" placeholder="Airline Preference">
                        </div>
                    </div>
                </div>
                <button class="btn-search-main">Search <i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="search-result-tabs">
    <div class="result-tab active">
        <i class="fas fa-search"></i> Recent Searches
    </div>
    <div class="result-tab">
        <i class="far fa-star"></i> Favourites
    </div>
    <div class="result-tab">
        <i class="fas fa-history"></i> Recent Bookings
    </div>
</div>

<div class="p-5 text-center bg-white border border-top-0 rounded-bottom-4 shadow-sm mb-5">
    <div class="opacity-25 mb-3"><i class="fas fa-plane fa-4x"></i></div>
    <h6 class="text-muted fw-700">No Recent Searches Yet</h6>
    <p class="text-muted small">Your recently searched flight routes will appear here for quick access.</p>
</div>

<div class="mt-5">
    <h5 class="fw-800 outfit mb-4">Promotions</h5>
    <div class="promo-banner rounded-4 overflow-hidden position-relative" style="height: 220px; background: linear-gradient(135deg, #091e42 0%, #172b4d 100%);">
        <div class="p-5 h-100 d-flex flex-column justify-content-center text-white position-relative z-1">
            <h3 class="outfit fw-800 mb-2">Your Private Fares</h3>
            <p class="opacity-75 mb-0 max-w-400">Exclusive deals and net-net fares for travel partners. Boost your commission capacity starting today.</p>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-10 mb-n4 me-n4">
            <i class="fas fa-plane fa-10x rotate-12 text-white"></i>
        </div>
    </div>
</div>
@endsection


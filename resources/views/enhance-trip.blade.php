@extends('layouts.app')

@section('title', 'Enhance Your Journey | Tripzant')

@section('styles')
<style>
    :root {
        --mmt-blue: #008cff;
        --mmt-dark: #2d2d2d;
    }

    body {
        background-color: #f2f2f2 !important;
        font-family: 'Inter', sans-serif;
    }

    .enhance-header {
        background: white;
        padding: 40px 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .category-scroll {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    .cat-pill {
        background: white;
        border: 1px solid #ddd;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transition: 0.3s;
    }
    .cat-pill.active {
        background: var(--mmt-blue);
        color: white;
        border-color: var(--mmt-blue);
    }

    .bento-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 25px;
        transition: transform 0.3s;
        border: 1px solid transparent;
    }
    .bento-card:hover {
        transform: translateY(-5px);
        border-color: var(--mmt-blue);
    }
    .card-img-wrap {
        height: 180px;
        overflow: hidden;
        position: relative;
    }
    .card-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .card-badge {
        position: absolute;
        top: 15px; left: 15px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 800;
    }

    .price-tag {
        font-size: 20px;
        font-weight: 900;
        color: #1a1a1a;
    }

    /* Sidebar Summary */
    .enhance-sidebar {
        background: white;
        border-radius: 16px;
        padding: 24px;
        position: sticky;
        top: 20px;
    }

    .btn-book-now {
        background: var(--mmt-blue);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 700;
        width: 100%;
        transition: 0.3s;
    }
    .btn-book-now:hover { background: #0066cc; }

    .sticky-pnr-status {
        background: #eef7ff;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #cce5ff;
    }
</style>
@endsection

@section('content')
<div class="enhance-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-magic text-primary"></i>
                    <span class="fw-bold text-primary small text-uppercase">Exclusive Upsells</span>
                </div>
                <h1 class="fw-900 mb-1">Make your <span id="destName">Mumbai</span> trip special</h1>
                <p class="text-muted mb-0">Exclusive hotel and transfer deals linked to your PNR.</p>
            </div>
            <div class="col-md-5 text-end">
                <div class="d-inline-block text-start bg-light p-3 rounded-4">
                    <div class="small fw-bold opacity-50">LOCKED WITH PNR</div>
                    <div class="fw-900 text-navy" id="pnrStatus">AM92KL</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Main Catalog -->
        <div class="col-lg-8">
            <!-- Filter Pills -->
            <div class="category-scroll mb-4">
                <div class="cat-pill active">Recommended</div>
                <div class="cat-pill">Hotels</div>
                <div class="cat-pill">Airport Cabs</div>
                <div class="cat-pill">Tours & Activities</div>
                <div class="cat-pill">eSIM & Forex</div>
                <div class="cat-pill">Cruise</div>
            </div>

            <!-- Section: Hotels -->
            <div class="mb-5">
                <h4 class="fw-900 mb-4">Top Rated Hotels in <span class="cityName">Mumbai</span></h4>
                <div class="row g-4" id="hotelGrid">
                    <!-- Dynamic Hotel Cards -->
                </div>
            </div>

            <!-- Section: Cabs -->
            <div class="mb-5">
                <h4 class="fw-900 mb-4">Secured Airport Transfers</h4>
                <div class="bento-card p-4">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block">
                                <i class="fas fa-taxi fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h5 class="fw-900 mb-1">Airport Pickup & Drop</h5>
                            <p class="text-muted small">Sanitized cabs from <span class="cityName">Mumbai</span> Airport. Meet & Greet included.</p>
                            <div class="d-flex gap-3">
                                <span class="small fw-bold"><i class="fas fa-gas-pump me-1"></i> Fixed Price</span>
                                <span class="small fw-bold"><i class="fas fa-user-shield me-1"></i> Verified Drivers</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="small text-muted mb-1">Starts at</div>
                            <div class="price-tag mb-3">₹899</div>
                            <button class="btn btn-primary fw-900 rounded-pill px-4" onclick="addUpsell('Airport Transfer', 899)">BOOK CAB</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Essential Services (eSIM / Forex / Visa) -->
            <div class="mb-5">
                <h4 class="fw-900 mb-4">International & Travel Essentials</h4>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="bento-card p-4 text-center">
                            <i class="fas fa-sim-card fa-2x text-primary mb-3"></i>
                            <h6 class="fw-900">Global eSIM</h6>
                            <p class="x-small text-muted">Unlimited data plans for your destination.</p>
                            <button class="btn btn-sm btn-light-outline w-100 fw-bold border" onclick="addUpsell('eSIM Plan', 599)">From ₹599</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bento-card p-4 text-center">
                            <i class="fas fa-money-bill-wave fa-2x text-success mb-3"></i>
                            <h6 class="fw-900">Multi-Currency Forex</h6>
                            <p class="x-small text-muted">Zero-markup rates on Forex cards.</p>
                            <button class="btn btn-sm btn-light-outline w-100 fw-bold border">APPLY NOW</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bento-card p-4 text-center">
                            <i class="fas fa-file-signature fa-2x text-danger mb-3"></i>
                            <h6 class="fw-900">Instant Visa Assistance</h6>
                            <p class="x-small text-muted">Hassle-free visa processing for Indians.</p>
                            <button class="btn btn-sm btn-light-outline w-100 fw-bold border">GET STARTED</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Cruise & Premium -->
            <div class="mb-5">
                <h4 class="fw-900 mb-4">Cruise & Premium Experiences</h4>
                <div class="bento-card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://media.architecturaldigest.com/photos/6312480a402379854746f333/16:9/w_2560%2Cc_limit/The%2520Ritz-Carlton%2520Yacht%2520Collection-Evrima-Exterior.jpg" class="h-100 w-100 object-fit-cover" style="min-height: 150px;">
                        </div>
                        <div class="col-md-8 p-4">
                            <span class="badge bg-navy-light text-navy mb-2" style="background:#e0f2fe; color:#0369a1;">PREMIUM EXCLUSIVE</span>
                            <h5 class="fw-900">Sunset Yacht Cruise - <span class="cityName">Mumbai</span></h5>
                            <p class="text-muted small">Experience the skyline from a private luxury yacht with refreshments.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price-tag">₹4,500 <span class="x-small text-muted fw-normal">/person</span></div>
                                <button class="btn btn-primary fw-900 rounded-pill px-4" onclick="addUpsell('Sunset Yacht Cruise', 4500)">BOOK NOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Tours -->
            <div class="mb-5">
                <h4 class="fw-900 mb-4">Sightseeing & Tours</h4>
                <div class="row g-4" id="tourGrid">
                    <!-- Dynamic Tour Cards -->
                </div>
            </div>
        </div>

        <!-- Right Side: Booking Summary -->
        <div class="col-lg-4">
            <div class="enhance-sidebar">
                <div class="sticky-pnr-status">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small fw-bold">Trip ID: 582910</span>
                        <span class="badge bg-success">Flight Confirmed</span>
                    </div>
                </div>

                <h6 class="fw-900 mb-4">YOUR PLAN SO FAR</h6>
                <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-4">
                    <div class="bg-primary text-white p-2 rounded-3 text-center" style="height: 50px; width: 50px;">
                        <i class="fas fa-plane"></i>
                    </div>
                    <div>
                        <div class="fw-900 small">DEL ✈️ BOM</div>
                        <div class="x-small text-muted">Indigo 6E-2134</div>
                        <div class="x-small fw-bold text-success">Confirmed</div>
                    </div>
                </div>

                <div id="addedUpsells">
                    <p class="text-center text-muted small py-4">No additional services added yet. Select from the left to enhance your trip!</p>
                </div>

                <div class="border-top pt-4 mt-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total Enhanced Value</span>
                        <span class="fw-bold fs-5 text-primary" id="totalEnhance">₹0</span>
                    </div>
                    <button class="btn-book-now" onclick="finishEnhance()">FINISH & GO TO DASHBOARD</button>
                    <p class="text-center mt-3 small opacity-50">You can add these services later from your dashboard as well.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const mockHotels = [
        { name: "Taj Lands End", price: 12500, rating: 4.9, img: "https://images.olx.com.pk/thumbnails/444265584-800x600.webp", badge: "LUXURY" },
        { name: "The Orchid Hotel", price: 6800, rating: 4.2, img: "https://r1imghtlak.mmtcdn.com/f9518d8e19c011e48fd05ef50b1a1380.jfif", badge: "AIRPORT SIDE" }
    ];

    const mockTours = [
        { name: "Elephanta Caves Tour", price: 2900, time: "6 Hours", rating: 4.8, img: "https://media.tacdn.com/media/attractions-splice-spp-674x446/0b/27/7f/0c.jpg" },
        { name: "Mumbai Night Cruise", price: 1500, time: "2 Hours", rating: 4.5, img: "https://www.tripsavvy.com/thmb/hN_t7E6S2-0L5aD0_A0L36_-_0E=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/GettyImages-534960309-5c91834146e0fb0001096a71.jpg" }
    ];

    document.addEventListener('DOMContentLoaded', () => {
        // Mocking destination data from previous step
        const dest = "Mumbai";
        document.getElementById('destName').innerText = dest;
        const cityNames = document.querySelectorAll('.cityName');
        cityNames.forEach(c => c.innerText = dest);

        // Render Hotels
        const hGrid = document.getElementById('hotelGrid');
        hGrid.innerHTML = mockHotels.map(h => `
            <div class="col-md-6">
                <div class="bento-card">
                    <div class="card-img-wrap">
                        <span class="card-badge">${h.badge}</span>
                        <img src="${h.img}" alt="${h.name}">
                    </div>
                    <div class="p-3">
                        <h6 class="fw-900 mb-1">${h.name}</h6>
                        <div class="small mb-2"><i class="fas fa-star text-warning"></i> ${h.rating} / 5</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price-tag">₹${h.price}</div>
                            <button class="btn btn-sm btn-outline-primary fw-bold" onclick="addUpsell('${h.name}', ${h.price})">+ ADD</button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

        // Render Tours
        const tGrid = document.getElementById('tourGrid');
        tGrid.innerHTML = mockTours.map(t => `
            <div class="col-md-6">
                <div class="bento-card">
                    <div class="card-img-wrap">
                        <img src="${t.img}" alt="${t.name}">
                    </div>
                    <div class="p-3">
                        <h6 class="fw-900 mb-1">${t.name}</h6>
                        <div class="small mb-2 text-muted"><i class="fas fa-clock"></i> ${t.time} | <i class="fas fa-star text-warning"></i> ${t.rating}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price-tag">₹${t.price}</div>
                            <button class="btn btn-sm btn-outline-primary fw-bold" onclick="addUpsell('${t.name}', ${t.price})">+ ADD</button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    });

    let upsells = [];
    function addUpsell(name, price) {
        upsells.push({name, price});
        renderSidebar();
        Swal.fire({
            title: 'Added to Trip!',
            text: `${name} has been linked to your itinerary.`,
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    }

    function renderSidebar() {
        const list = document.getElementById('addedUpsells');
        if(upsells.length === 0) return;

        let total = 0;
        list.innerHTML = upsells.map(u => {
            total += u.price;
            return `
                <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded-3 small">
                    <span class="fw-bold">${u.name}</span>
                    <span class="text-primary fw-900">₹${u.price}</span>
                </div>
            `;
        }).join('');
        document.getElementById('totalEnhance').innerText = `₹${total.toLocaleString()}`;
    }

    function finishEnhance() {
        localStorage.setItem('trip_upsells', JSON.stringify(upsells));
        window.location.href = '/dashboard';
    }
</script>
@endsection

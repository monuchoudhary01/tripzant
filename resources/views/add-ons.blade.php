@extends('layouts.app')

@section('title', 'Customize Your Flight | Tripzant')

@section('styles')
<style>
    :root {
        --trip-blue: #005eb8;
        --trip-dark: #003366;
        --trip-light: #f0f7ff;
        --trip-border: #e2e8f0;
    }

    body {
        background-color: #f8fafc !important;
        font-family: 'Outfit', sans-serif;
    }

    /* Fixed Flight Header */
    .flight-shuttle-header {
        background: white;
        border-bottom: 1px solid var(--trip-border);
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .addon-card-premium {
        background: white;
        border: 1px solid var(--trip-border);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
        transition: 0.3s;
    }
    .addon-card-premium:hover {
        box-shadow: 0 15px 50px rgba(0,0,0,0.05);
        border-color: var(--trip-blue);
    }

    .icon-box {
        width: 55px;
        height: 55px;
        background: var(--trip-light);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--trip-blue);
        font-size: 24px;
    }

    /* Modern Selection Tokens */
    .token-group { display: flex; gap: 12px; }
    .token-btn {
        border: 1.5px solid var(--trip-border);
        background: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        transition: 0.2s;
        flex: 1;
        text-align: center;
        font-size: 13px;
    }
    .token-btn:hover { border-color: var(--trip-blue); color: var(--trip-blue); background: var(--trip-light); }
    .token-btn.active {
        background: var(--trip-blue);
        color: white;
        border-color: var(--trip-blue);
        box-shadow: 0 5px 15px rgba(0, 94, 184, 0.3);
    }

    /* Meal Option Visuals */
    .meal-card {
        border: 1.5px solid var(--trip-border);
        border-radius: 15px;
        padding: 20px;
        cursor: pointer;
        transition: 0.3s;
        height: 100%;
        text-align: center;
    }
    .meal-card:hover { border-color: var(--trip-blue); background: var(--trip-light); }
    .meal-card.active {
        border-color: var(--trip-blue);
        background: #eff6ff;
        box-shadow: 0 0 0 1px var(--trip-blue);
    }
    .meal-card i { font-size: 28px; color: var(--trip-blue); margin-bottom: 12px; }

    /* Sticky Cart Sidebar */
    .cart-sidebar-glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid var(--trip-border);
        border-radius: 24px;
        padding: 30px;
        position: sticky;
        top: 100px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    }

    .btn-checkout-pro {
        background: linear-gradient(135deg, var(--trip-blue) 0%, var(--trip-dark) 100%);
        color: white;
        border: none;
        width: 100%;
        padding: 18px;
        border-radius: 15px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 30px rgba(0, 94, 184, 0.3);
        transition: 0.3s;
    }
    .btn-checkout-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 94, 184, 0.4);
    }

    .insurance-protection-box {
        background: #f0fdf4;
        border: 1.5px solid #dcfce7;
        border-radius: 15px;
        padding: 20px;
    }
</style>
@endsection

@section('content')
<!-- Top Flight Shuttle -->
<div class="flight-shuttle-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center gap-2">
                    <img src="https://logowik.com/content/uploads/images/indigo7491.jpg" height="25">
                    <span class="fw-900 text-navy">DEL ✈️ BOM</span>
                </div>
                <div style="width: 1px; height: 20px; background: #ddd;"></div>
                <div class="small fw-bold text-muted"><i class="far fa-calendar me-1"></i> Apr 12 — Economy</div>
            </div>
            <div class="small fw-900 text-primary d-none d-md-block">Step 3/4: Personalize Journey</div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4 justify-content-center">
        <!-- Add-On Selection Catalog -->
        <div class="col-lg-7">
            <!-- 1. Extra Baggage -->
            <div class="addon-card-premium">
                <div class="d-flex gap-3 align-items-center mb-4">
                    <div class="icon-box"><i class="fas fa-suitcase-rolling"></i></div>
                    <div>
                        <h4 class="fw-900 mb-1">Extra Baggage</h4>
                        <p class="text-muted small mb-0">Book extra allowance at discounted online rates.</p>
                    </div>
                </div>
                
                <div id="paxBaggageGrid">
                    <!-- Dynamic Pax List -->
                </div>
            </div>

            <!-- 2. In-Flight Meals -->
            <div class="addon-card-premium">
                <div class="d-flex gap-3 align-items-center mb-4">
                    <div class="icon-box"><i class="fas fa-utensils"></i></div>
                    <div>
                        <h4 class="fw-900 mb-1">In-Flight Meals</h4>
                        <p class="text-muted small mb-0">Selection of premium multi-cuisine hot meals.</p>
                    </div>
                </div>
                <div class="row g-4" id="mealGrid">
                    <div class="col-md-4">
                        <div class="meal-card" onclick="selectMeal('Veg Premium', 350)">
                            <i class="fas fa-leaf"></i>
                            <h6 class="fw-900">Veg Premium</h6>
                            <div class="fw-900 text-primary">₹350</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="meal-card" onclick="selectMeal('Non-Veg', 450)">
                            <i class="fas fa-drumstick-bite"></i>
                            <h6 class="fw-900">Non-Veg</h6>
                            <div class="fw-900 text-primary">₹450</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="meal-card" onclick="selectMeal('Jain Spec', 350)">
                            <i class="fas fa-om"></i>
                            <h6 class="fw-900">Jain Special</h6>
                            <div class="fw-900 text-primary">₹350</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Flexible Trip / Cancellation Protection -->
            <div class="addon-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="icon-box" style="background:#fff7ed; color:#f97316;"><i class="fas fa-undo-alt"></i></div>
                        <div>
                            <h4 class="fw-900 mb-1">Flexible Trip Protection</h4>
                            <p class="text-muted small mb-0">Cancel for ANY reason / Free date change up to 24h.</p>
                        </div>
                    </div>
                    <div class="form-check form-switch fs-4">
                        <input class="form-check-input" type="checkbox" id="flexSwitch" onchange="updateFare()">
                    </div>
                </div>
                <div class="p-3 bg-light rounded-4 x-small fw-bold">
                    <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i> Refund protection included</span> | 
                    <span class="ms-2">Zero change fee at ₹899/Pax</span>
                </div>
            </div>

            <!-- 4. Smart Insurance -->
            <div class="addon-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="icon-box"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h4 class="fw-900 mb-1">Smart Protection</h4>
                            <p class="text-muted small mb-0">Cover for medical emergencies and trip delays.</p>
                        </div>
                    </div>
                    <div class="form-check form-switch fs-4">
                        <input class="form-check-input" type="checkbox" id="insSwitch" onchange="updateFare()">
                    </div>
                </div>
                <div class="insurance-protection-box">
                    <div class="row g-3">
                        <div class="col-md-4"><div class="small fw-700"><i class="fas fa-check text-success me-1"></i> Hospitalization</div></div>
                        <div class="col-md-4"><div class="small fw-700"><i class="fas fa-check text-success me-1"></i> Delay Refund</div></div>
                        <div class="col-md-4"><div class="small fw-700"><i class="fas fa-check text-success me-1"></i> Accidental Cover</div></div>
                    </div>
                    <div class="mt-3 x-small fw-bold text-success">Recommended by travel experts @ ₹499/Pax</div>
                </div>
            </div>

            <!-- 4. Special Assistance -->
            <div class="addon-card-premium">
                <div class="d-flex gap-3 align-items-center mb-4">
                    <div class="icon-box"><i class="fas fa-wheelchair"></i></div>
                    <div>
                        <h4 class="fw-900 mb-1">Special Assistance</h4>
                        <p class="text-muted small mb-0">Request airport or in-flight medical support.</p>
                    </div>
                </div>
                <select class="form-select py-3 rounded-4" id="assistSelect" onchange="updateFare()">
                    <option value="none">No Assistance Required</option>
                    <option value="wheelchair">Wheelchair Required (to Gate)</option>
                    <option value="medical">Medical / Stretcher Support</option>
                </select>
            </div>
        </div>

        <!-- Sticky Summary Bar -->
        <div class="col-lg-4">
            <div class="cart-sidebar-glass">
                <h6 class="fw-900 text-muted mb-4 fs-12 uppercase" style="letter-spacing: 2px;">SETTLEMENT SUMMARY</h6>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">Flight + Assigned Seats</span>
                    <span class="fw-900" id="baseDisplay">₹0</span>
                </div>
                
                <div id="itemizedLog" class="mb-2">
                    <!-- Dynamic Log -->
                </div>

                <div class="text-end mb-3">
                    <a href="javascript:void(0)" onclick="window.showFareRules('Indigo', '6E-2134')" class="x-small text-primary fw-bold text-decoration-none border-bottom border-dashed border-primary">VIEW FARE RULES</a>
                </div>

                <div class="border-top pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-900 text-navy">GRAND TOTAL</span>
                        <h2 class="fw-900 text-primary mb-0" id="totalDisplay">₹0</h2>
                    </div>
                    <button class="btn-checkout-pro" onclick="toConfirmation()">
                        PROCEED & CONFIRM <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <p class="text-center mt-3 text-muted x-small italic fw-bold">Transaction Secured by Tripzant Gateway</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const passengers = JSON.parse(localStorage.getItem('last_booking_passengers') || '[]');
    const seats = JSON.parse(localStorage.getItem('selected_seats') || '{}');
    let baseFlightTotal = 80530;
    let seatTotal = 0;
    
    let state = {
        bags: {}, // index: {weight, price}
        meal: {name: 'none', price: 0},
        ins: false
    };

    function init() {
        Object.values(seats).forEach(s => seatTotal += (s.price || 0));
        renderBaggageGrid();
        updateFare();
    }

    function renderBaggageGrid() {
        const wrap = document.getElementById('paxBaggageGrid');
        wrap.innerHTML = passengers.map((p, i) => `
            <div class="p-3 border-bottom d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <div class="fw-900 text-navy">${p.first_name} ${p.last_name || ''}</div>
                    <div class="x-small text-muted fw-bold">Standard 15KG included</div>
                </div>
                <div class="token-group">
                    <div class="token-btn bag-${i} active" onclick="setBag(${i}, 0, 0)">+0KG</div>
                    <div class="token-btn bag-${i}" onclick="setBag(${i}, 5, 800)">+5KG (₹800)</div>
                    <div class="token-btn bag-${i}" onclick="setBag(${i}, 10, 1500)">+10KG (₹1500)</div>
                </div>
            </div>
        `).join('');
    }

    function setBag(idx, weight, price) {
        state.bags[idx] = {weight, price};
        const btns = document.querySelectorAll(`.bag-${idx}`);
        btns.forEach(b => b.classList.remove('active'));
        const activeIdx = weight === 0 ? 0 : (weight === 5 ? 1 : 2);
        btns[activeIdx].classList.add('active');
        updateFare();
    }

    function selectMeal(name, price) {
        state.meal = {name, price};
        const cards = document.querySelectorAll('.meal-card');
        cards.forEach(c => c.classList.remove('active'));
        if(name === 'Veg Premium') cards[0].classList.add('active');
        else cards[1].classList.add('active');
        updateFare();
    }

    function updateFare() {
        let extraTotal = 0;
        let logHtml = '';

        // Baggage logic
        Object.keys(state.bags).forEach(k => {
            if(state.bags[k].price > 0) {
                extraTotal += state.bags[k].price;
                logHtml += `<div class="d-flex justify-content-between small text-primary mb-1">
                                <span>Bag upgrade (${state.bags[k].weight}KG - ${passengers[k].first_name})</span>
                                <span>+₹${state.bags[k].price}</span>
                            </div>`;
            }
        });

        // Meal logic
        if(state.meal.price > 0) {
            extraTotal += state.meal.price;
            logHtml += `<div class="d-flex justify-content-between small text-primary mb-1">
                            <span>Meal: ${state.meal.name}</span>
                            <span>+₹${state.meal.price}</span>
                        </div>`;
        }

        // Insurance logic
        state.ins = document.getElementById('insSwitch').checked;
        if(state.ins) {
            const cost = passengers.length * 499;
            extraTotal += cost;
            logHtml += `<div class="d-flex justify-content-between small text-success mb-1">
                            <span>Travel Insurance (x${passengers.length})</span>
                            <span>+₹${cost}</span>
                        </div>`;
        }

        document.getElementById('baseDisplay').innerText = `₹${(baseFlightTotal + seatTotal).toLocaleString()}`;
        document.getElementById('itemizedLog').innerHTML = logHtml;
        document.getElementById('totalDisplay').innerText = `₹${(baseFlightTotal + seatTotal + extraTotal).toLocaleString()}`;
    }

    function toConfirmation() {
        localStorage.setItem('selected_addons', JSON.stringify(state));
        Swal.fire({
            title: 'Booking Synchronized!',
            text: 'Your ancillaries have been logged to the PNR.',
            icon: 'success',
            confirmButtonColor: '#005eb8'
        }).then(() => {
            window.location.href = '/payment';
        });
    }

    window.showFareRules = function(airline, flight) {
        Swal.fire({
            title: `<div class="text-start fs-5 fw-900 text-navy">${airline} (${flight}) - Fare Rules & Policies</div>`,
            html: `
                <div class="text-start border rounded-4 bg-light overflow-hidden shadow-sm">
                    <div class="p-3 bg-white border-bottom text-center">
                         <h6 class="fw-900 x-small text-muted mb-3 uppercase" style="letter-spacing:1px;">📜 TRIP CANCELLATION & RESCHEDULING</h6>
                         <div class="row g-2">
                             <div class="col-6"><div class="p-2 border rounded-3 bg-light"><div class="x-small fw-bold">Cancel Fee</div><div class="fw-900 text-danger">₹3,500 <span class="x-small">/pax</span></div></div></div>
                             <div class="col-6"><div class="p-2 border rounded-3 bg-light"><div class="x-small fw-bold">Change Fee</div><div class="fw-900 text-primary">₹3,000 <span class="x-small">/pax</span></div></div></div>
                         </div>
                    </div>
                    <div class="p-4">
                         <div class="row g-3">
                            <div class="col-6">
                                <div class="fw-900 small text-navy"><i class="fas fa-edit me-2 text-primary"></i> Name Change</div>
                                <div class="x-small text-muted fw-bold">₹500 (Minor spelling). Major corrections require rebooking.</div>
                            </div>
                            <div class="col-6">
                                <div class="fw-900 small text-navy"><i class="fas fa-ban me-2 text-warning"></i> No-Show Penalty</div>
                                <div class="x-small text-muted fw-bold">No refund if you fail to board. Only Govt. Taxes refunded.</div>
                            </div>
                            <div class="col-6">
                                <div class="fw-900 small text-navy"><i class="fas fa-suitcase me-2 text-success"></i> Baggage Weight</div>
                                <div class="x-small text-muted fw-bold">Cabin: 7KG | Check-in: 15KG included per adult.</div>
                            </div>
                         </div>
                    </div>
                    <div class="p-2 bg-white border-top x-small text-center fw-bold text-muted italic">
                        *Total = Airline Fee + Tripzant Service Fee (₹350 Conv.)
                    </div>
                </div>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            width: '500px',
            customClass: { popup: 'rounded-4 overflow-hidden border-0 shadow-lg' }
        });
    };

    document.addEventListener('DOMContentLoaded', init);
</script>
@endsection

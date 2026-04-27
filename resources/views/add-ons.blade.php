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
                    <img src="https://img.icons8.com/color/48/airplane-take-off.png" height="25">
                    <span class="fw-900 text-navy">{{ $flight['dep_city'] ?? ($flight['departure_city'] ?? 'DEL') }} ✈️ {{ $flight['arr_city'] ?? ($flight['arrival_city'] ?? 'BOM') }}</span>
                </div>
                <div style="width: 1px; height: 20px; background: #ddd;"></div>
                <div class="small fw-bold text-muted"><i class="far fa-calendar me-1"></i> {{ isset($flight['departure_at']) ? date('M d', strtotime($flight['departure_at'])) : 'Upcoming' }} — {{ $flight['cabin'] ?? 'Economy' }}</div>
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

            <!-- 3. Flexible Trip / Cancellation Protection (Dynamic) -->
            @php
                $isRefundable   = $flight['is_refundable'] ?? false;
                $cabinClass     = strtoupper($flight['cabin'] ?? 'ECONOMY');
                $airlineCode    = $flight['airline_code'] ?? '';
                $airlineName    = $flight['airline'] ?? $flight['airline_name'] ?? 'Airline';
                // Cancel fee varies by cabin
                $flexPriceMap   = ['ECONOMY' => 699, 'BUSINESS' => 1299, 'FIRST' => 1999];
                $flexPrice      = $flexPriceMap[$cabinClass] ?? 699;
                // Change fee varies by cabin
                $changeFeeMap   = ['ECONOMY' => 3500, 'BUSINESS' => 5000, 'FIRST' => 7500];
                $airlineChangeFee = $changeFeeMap[$cabinClass] ?? 3500;
            @endphp
            <div class="addon-card-premium" id="flexCard">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="icon-box" style="background:#fff7ed; color:#f97316;">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <div>
                            <h4 class="fw-900 mb-1">Flexible Trip Protection
                                @if($isRefundable)
                                    <span class="badge bg-success ms-2" style="font-size:10px;">REFUNDABLE FARE</span>
                                @else
                                    <span class="badge bg-danger ms-2" style="font-size:10px;">NON-REFUNDABLE</span>
                                @endif
                            </h4>
                            <p class="text-muted small mb-0">
                                Cancel for ANY reason before departure / Free date change up to 24h before.
                            </p>
                        </div>
                    </div>
                    <div class="form-check form-switch fs-4">
                        <input class="form-check-input" type="checkbox" id="flexSwitch"
                               onchange="updateFare()" data-price="{{ $flexPrice }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center">
                            <div class="x-small text-muted fw-bold mb-1">{{ $airlineName }} Cancel Fee</div>
                            <div class="fw-900 text-danger">₹{{ number_format($airlineChangeFee) }}<span class="x-small">/pax</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center" style="border-color:#22c55e !important; background:#f0fdf4;">
                            <div class="x-small text-muted fw-bold mb-1">With Protection</div>
                            <div class="fw-900 text-success">₹0 <span class="x-small">change fee</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center">
                            <div class="x-small text-muted fw-bold mb-1">Protection Cost</div>
                            <div class="fw-900 text-primary">₹{{ number_format($flexPrice) }}<span class="x-small">/pax</span></div>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-4 x-small fw-bold d-flex gap-3 flex-wrap"
                     style="background:#fff7ed; border:1px solid #fed7aa;">
                    <span><i class="fas fa-check text-orange me-1" style="color:#f97316"></i>Cancel 2h before departure — full refund</span>
                    <span><i class="fas fa-check text-orange me-1" style="color:#f97316"></i>Reschedule once free of charge</span>
                    <span><i class="fas fa-check text-orange me-1" style="color:#f97316"></i>{{ $cabinClass }} class applicable</span>
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

            <!-- 5. Special Assistance (Dynamic per Passenger) -->
            @php
                // Dynamic assistance options based on airline capabilities
                $assistOptions = [
                    ['value' => 'none',       'label' => 'No Assistance Required',         'cost' => 0,   'icon' => 'fa-times-circle', 'color' => 'text-muted'],
                    ['value' => 'wchr',       'label' => 'Wheelchair to Gate (WCHR)',       'cost' => 0,   'icon' => 'fa-wheelchair',    'color' => 'text-primary'],
                    ['value' => 'wchs',       'label' => 'Wheelchair to Seat (WCHS)',       'cost' => 0,   'icon' => 'fa-wheelchair',    'color' => 'text-primary'],
                    ['value' => 'wchc',       'label' => 'Cabin Wheelchair (WCHC)',         'cost' => 0,   'icon' => 'fa-wheelchair',    'color' => 'text-primary'],
                    ['value' => 'blind',      'label' => 'Visually Impaired Assistance',    'cost' => 0,   'icon' => 'fa-eye-slash',     'color' => 'text-warning'],
                    ['value' => 'deaf',       'label' => 'Hearing Impaired Assistance',     'cost' => 0,   'icon' => 'fa-deaf',          'color' => 'text-warning'],
                    ['value' => 'medical',    'label' => 'Medical / Stretcher (MEDA)',      'cost' => 500, 'icon' => 'fa-ambulance',     'color' => 'text-danger'],
                    ['value' => 'unaccomp',   'label' => 'Unaccompanied Minor (UM)',        'cost' => 800, 'icon' => 'fa-child',         'color' => 'text-info'],
                ];
                // Some airlines don't support stretcher on short routes
                $isShortHaul = isset($flight['duration']) && (int)str_replace(['h','m',' '],['','',''],$flight['duration'] ?? '2h') <= 2;
                if ($isShortHaul) {
                    $assistOptions = array_filter($assistOptions, fn($o) => $o['value'] !== 'medical');
                }
                $passengerList = $passengers ?? [];
            @endphp
            <div class="addon-card-premium" id="assistCard">
                <div class="d-flex gap-3 align-items-center mb-4">
                    <div class="icon-box"><i class="fas fa-wheelchair"></i></div>
                    <div>
                        <h4 class="fw-900 mb-1">Special Assistance
                            <span class="badge bg-primary ms-2" style="font-size:10px;">IATA SSR</span>
                        </h4>
                        <p class="text-muted small mb-0">
                            Per-passenger assistance request — notified directly to {{ $airlineName ?? 'the airline' }}.
                        </p>
                    </div>
                </div>

                <div id="assistGrid">
                    @forelse($passengerList as $pIdx => $pax)
                    <div class="d-md-flex gap-3 align-items-center mb-3 p-3 border rounded-4">
                        <div class="mb-3 mb-md-0" style="min-width:160px;">
                            <div class="fw-900 text-navy small">{{ $pax['first_name'] ?? 'Traveler '.($pIdx+1) }} {{ $pax['last_name'] ?? '' }}</div>
                            <div class="x-small text-muted fw-bold">Traveler {{ $pIdx + 1 }}</div>
                        </div>
                        <select class="form-select py-2 rounded-3 fw-bold"
                                id="assist_{{ $pIdx }}"
                                onchange="updateFare()"
                                style="font-size:13px;">
                            @foreach($assistOptions as $opt)
                            <option value="{{ $opt['value'] }}" data-cost="{{ $opt['cost'] }}">
                                {{ $opt['label'] }}{{ $opt['cost'] > 0 ? ' (+₹'.$opt['cost'].')' : ' (Free)' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @empty
                    {{-- Fallback: show single dropdown if no passenger data --}}
                    <div class="d-md-flex gap-3 align-items-center mb-3 p-3 border rounded-4">
                        <div class="mb-3 mb-md-0" style="min-width:160px;">
                            <div class="fw-900 text-navy small">All Passengers</div>
                        </div>
                        <select class="form-select py-2 rounded-3 fw-bold" id="assist_0" onchange="updateFare()">
                            @foreach($assistOptions as $opt)
                            <option value="{{ $opt['value'] }}" data-cost="{{ $opt['cost'] }}">
                                {{ $opt['label'] }}{{ $opt['cost'] > 0 ? ' (+₹'.$opt['cost'].')' : ' (Free)' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endforelse
                </div>

                <div class="mt-3 p-3 rounded-3 x-small fw-bold d-flex gap-3 flex-wrap"
                     style="background:#eff6ff; border:1px solid #bfdbfe;">
                    <span><i class="fas fa-info-circle text-primary me-1"></i>Wheelchair & hearing/visual assistance are always free</span>
                    <span><i class="fas fa-plane text-primary me-1"></i>SSR request sent to {{ $airlineName ?? 'airline' }} at ticket issuance</span>
                </div>
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
                    <button class="btn-checkout-pro" onclick="toPayment()">
                        PAY & CONFIRM BOOKING <i class="fas fa-lock ms-2"></i>
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
    const passengers = @json($passengers);
    // PHP fallback: traveler count even if passengers array is empty (e.g. old bookings)
    const paxCount = {{ max(count($passengers), $booking->items->where('item_type','traveler')->count(), 1) }};
    const seatsMulti = JSON.parse(localStorage.getItem('selected_seats_multi') || '{}');
    const flightData = @json($flight);
    let baseFlightTotal = {{ $booking->total_amount ?? 0 }};
    let seatTotal = 0;
    
    let state = {
        bags: {}, // index: {weight, price}
        meal: {name: 'none', price: 0},
        ins: false
    };

    function init() {
        // Calculate total from multi-leg seats
        Object.values(seatsMulti).forEach(legSeats => {
            Object.values(legSeats).forEach(s => {
                seatTotal += (s.price || 0);
            });
        });

        renderBaggageGrid();
        updateFare();
    }

    // --- Dynamic Baggage Config from Flight API Data ---
    const includedBaggageKg = parseInt(flightData?.baggage || flightData?.checked_bags || 15);
    const baggageUnit       = flightData?.baggage_unit || 'KG';
    const cabinClass        = (flightData?.cabin || 'ECONOMY').toUpperCase();
    const airlineName       = flightData?.airline || flightData?.airline_name || 'Airline';
    const isBusinessOrFirst = cabinClass === 'BUSINESS' || cabinClass === 'FIRST';

    // Dynamic upgrade tiers based on cabin class
    const baggageTiers = isBusinessOrFirst
        ? [ { kg: 0,  price: 0,    label: '+0KG (Included)' },
            { kg: 10, price: 1200, label: `+10${baggageUnit}` },
            { kg: 20, price: 2200, label: `+20${baggageUnit}` },
            { kg: 32, price: 3500, label: `+32${baggageUnit}` } ]
        : [ { kg: 0,  price: 0,    label: '+0KG' },
            { kg: 5,  price: 800,  label: `+5${baggageUnit}` },
            { kg: 10, price: 1500, label: `+10${baggageUnit}` },
            { kg: 15, price: 2400, label: `+15${baggageUnit}` } ];

    function renderBaggageGrid() {
        const wrap = document.getElementById('paxBaggageGrid');
        if (!wrap) return;

        // Show dynamic included info
        const infoBar = `
            <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-4 align-items-center flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-suitcase-rolling text-primary"></i>
                    <span class="fw-900 small text-navy">${airlineName}</span>
                </div>
                <div class="vr"></div>
                <div class="small fw-bold">
                    <span class="badge bg-success me-1"><i class="fas fa-check me-1"></i>Included</span>
                    Cabin: 7${baggageUnit} + Check-in: ${includedBaggageKg}${baggageUnit}
                </div>
                <div class="vr"></div>
                <div class="small fw-bold text-muted">
                    <i class="fas fa-plane me-1"></i>${cabinClass} CLASS
                </div>
            </div>`;

        const paxRows = passengers.map((p, i) => `
            <div class="p-3 border-bottom d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <div class="fw-900 text-navy">${p.first_name || 'Traveler'} ${p.last_name || ''}</div>
                    <div class="x-small text-muted fw-bold">
                        <i class="fas fa-suitcase me-1 text-success"></i>
                        ${includedBaggageKg}${baggageUnit} check-in included
                    </div>
                </div>
                <div class="token-group flex-wrap">
                    ${baggageTiers.map((tier, ti) => `
                        <div class="token-btn bag-${i} ${ti === 0 ? 'active' : ''}" 
                             onclick="setBag(${i}, ${tier.kg}, ${tier.price}, ${ti})">
                            ${tier.label}
                            ${tier.price > 0 ? `<div class="x-small mt-1">₹${tier.price.toLocaleString()}</div>` : ''}
                        </div>`).join('')}
                </div>
            </div>`).join('');

        wrap.innerHTML = infoBar + paxRows;
    }

    function setBag(idx, weight, price, tierIndex) {
        state.bags[idx] = { weight, price };
        // Deactivate all tokens for this passenger
        document.querySelectorAll(`.bag-${idx}`).forEach((b, ti) => {
            b.classList.toggle('active', ti === tierIndex);
        });
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
            if (state.bags[k].price > 0) {
                extraTotal += state.bags[k].price;
                // Safely get passenger name — fallback if array is empty
                const paxName = passengers[k]?.first_name || `Traveler ${parseInt(k) + 1}`;
                logHtml += `<div class="d-flex justify-content-between small text-primary mb-1">
                                <span>Bag upgrade (${state.bags[k].weight}${baggageUnit} - ${paxName})</span>
                                <span>+₹${state.bags[k].price.toLocaleString()}</span>
                            </div>`;
            }
        });

        // Meal logic
        if (state.meal.price > 0) {
            extraTotal += state.meal.price;
            logHtml += `<div class="d-flex justify-content-between small text-primary mb-1">
                            <span>Meal: ${state.meal.name}</span>
                            <span>+₹${state.meal.price}</span>
                        </div>`;
        }

        // Insurance logic — use Math.max to never show x0
        state.ins = document.getElementById('insSwitch').checked;
        if (state.ins) {
            const travelerCount = Math.max(passengers.length, paxCount, 1);
            const insCostPerPax = 499;
            const cost = travelerCount * insCostPerPax;
            extraTotal += cost;
            logHtml += `<div class="d-flex justify-content-between small text-success mb-1">
                            <span><i class="fas fa-shield-alt me-1"></i>Travel Insurance (${travelerCount} pax × ₹${insCostPerPax})</span>
                            <span>+₹${cost.toLocaleString()}</span>
                        </div>`;
        }

        // Flexible protection — price from data-price attribute (set dynamically per cabin)
        const flexEl = document.getElementById('flexSwitch');
        const flexChecked = flexEl?.checked;
        if (flexChecked) {
            const travelerCount = Math.max(passengers.length, paxCount, 1);
            const flexPricePerPax = parseInt(flexEl?.dataset?.price || 699);
            const flexCost = travelerCount * flexPricePerPax;
            extraTotal += flexCost;
            logHtml += `<div class="d-flex justify-content-between small text-warning mb-1">
                            <span><i class="fas fa-undo-alt me-1"></i>Flexible Protection (${travelerCount} pax × ₹${flexPricePerPax})</span>
                            <span>+₹${flexCost.toLocaleString()}</span>
                        </div>`;
        }

        // Special Assistance — per passenger
        // Use getAttribute (more reliable than dataset on <option> elements)
        let assistTotal = 0;
        document.querySelectorAll('[id^="assist_"]').forEach((sel, idx) => {
            const val = sel.value;
            if (!val || val === 'none') return;

            const selectedOpt = sel.options[sel.selectedIndex];
            const cost = parseInt(selectedOpt?.getAttribute('data-cost') ?? 0) || 0;
            const label = selectedOpt?.text?.split(' (')[0] || val;
            const paxName = passengers[idx]?.first_name || `Traveler ${idx + 1}`;

            if (cost > 0) {
                assistTotal += cost;
                logHtml += `<div class="d-flex justify-content-between small text-info mb-1">
                                <span><i class="fas fa-wheelchair me-1"></i>${label} — ${paxName}</span>
                                <span>+₹${cost.toLocaleString()}</span>
                            </div>`;
            } else {
                logHtml += `<div class="d-flex justify-content-between small text-muted mb-1">
                                <span><i class="fas fa-wheelchair me-1"></i>${label} — ${paxName}</span>
                                <span class="text-success fw-bold">FREE</span>
                            </div>`;
            }
        });
        extraTotal += assistTotal;

        document.getElementById('baseDisplay').innerText = `₹${(baseFlightTotal + seatTotal).toLocaleString()}`;
        document.getElementById('itemizedLog').innerHTML = logHtml || '<p class="text-muted x-small fw-bold">No extras added yet</p>';
        document.getElementById('totalDisplay').innerText = `₹${(baseFlightTotal + seatTotal + extraTotal).toLocaleString()}`;
    }

    async function toPayment() {
        localStorage.setItem('selected_addons', JSON.stringify(state));

        const btn = document.querySelector('.btn-checkout-pro');
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Connecting to Payment...';
        btn.disabled = true;

        try {
            const totalText = document.getElementById('totalDisplay').innerText;
            const totalAmount = parseFloat(totalText.replace(/[₹,\s]/g, '')) || 0;

            if (totalAmount <= 0) {
                throw new Error('Total amount could not be calculated. Please go back and try again.');
            }

            const resp = await fetch("{{ route('booking.initiate-payment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    reference: "{{ $reference }}",
                    total_amount: totalAmount,
                    addons: state,
                    seats: seatsMulti
                })
            });

            const data = await resp.json();
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message || 'Payment could not be initiated.');
            }
        } catch(e) {
            Swal.fire({ icon: 'error', title: 'Payment Error', text: e.message, confirmButtonColor: '#005eb8' });
            btn.innerHTML = orig;
            btn.disabled = false;
        }
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

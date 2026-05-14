{{-- Cache Busting: 2026-05-03 04:02 --}}
@extends('layouts.app')

@php
    $isMultiCity = request('multi_city') == '1';
    $isRoundTrip = (request('trip') === 'round') || (!empty(request('return_date')) && !$isMultiCity);
    $isGroupBooking = ((request('adults', 0) + request('children', 0)) > 9) && (request('group_mode') == '1');
    
    $adults = request('adults', 1);
    $children = request('children', 0);
    $infants = request('infants', 0);
    $cabinClass = request('cabin_class', 'Economy');
    
    // Multi-City specific
    $multiCityOrigins = request('origin', []);
    $multiCityDestinations = request('destination', []);
    $multiCityDates = request('departure_date', []);
    $numSegments = is_array($multiCityOrigins) ? count($multiCityOrigins) : 0;
    
    // Fallback for standard modes
    $travelDate = is_array($multiCityDates) ? ($multiCityDates[0] ?? date('Y-m-d')) : (request('departure_date', date('Y-m-d')));
    $returnDate = request('return_date');

    $origin = (is_array($multiCityOrigins) ? ($multiCityOrigins[0] ?? null) : request('origin')) ?: 'DEL';
    $destination = (is_array($multiCityDestinations) ? ($multiCityDestinations[0] ?? null) : request('destination')) ?: 'BOM';

    // Dynamic Filters Logic
    $flights = $flights ?? [];
    $airlinesFilter = [];
    $maxPrice = 0;
    $minPrice = PHP_INT_MAX;
    $stopCounts = ['Non Stop' => 0, '1 Stop' => 0, '2+ Stops' => 0];
    $morningDeparturesCount = 0;
    $refundableCount = 0;

    // Common Airline Codes Mapping
    $airlineNames = [
        '6E' => 'IndiGo',
        'UK' => 'Vistara',
        'AI' => 'Air India',
        'SG' => 'SpiceJet',
        'QP' => 'Akasa Air',
        'IX' => 'Air India Express',
        'I5' => 'AirAsia India',
        'G8' => 'Go First',
        'AA' => 'American Airlines',
        'EK' => 'Emirates',
        'QR' => 'Qatar Airways',
        'EY' => 'Etihad',
        'SQ' => 'Singapore Airlines',
        'WI' => 'Wingie',
        'KW' => 'Kiwi.com',
        'MY' => 'Mytrip',
        'TP' => 'Tripzant Partner'
    ];

    if (!empty($flights) && is_array($flights) && !isset($flights['error'])) {
        foreach ($flights as $f) {
            $price = $f['price'] ?? 0;
            if ($price > $maxPrice) $maxPrice = $price;
            if ($price < $minPrice) $minPrice = $price;

            $airCode = $f['airline_code'] ?? ($f['airline'] ?? 'Unknown');
            $airName = $f['airline'] ?? ($airlineNames[$airCode] ?? $airCode);
            
            if (!isset($airlinesFilter[$airName])) {
                $airlinesFilter[$airName] = ['count' => 0, 'min_price' => $price, 'code' => $airCode];
            }
            $airlinesFilter[$airName]['count']++;
            if ($price < $airlinesFilter[$airName]['min_price']) {
                $airlinesFilter[$airName]['min_price'] = $price;
            }

            // Morning Departures check (6 AM to 12 PM)
            $depTimeRaw = $f['departure_at'] ?? null;
            if ($depTimeRaw) {
                $depTime = \Carbon\Carbon::parse($depTimeRaw);
                if ($depTime->hour >= 6 && $depTime->hour < 12) {
                    $morningDeparturesCount++;
                }
            }
            
            // Real Refundable logic from API
            if ($f['is_refundable'] ?? false) {
                $refundableCount++;
            }

            // Stops check (Dynamic API count)
            $stops = $f['stops'] ?? 0;
            if ($stops == 0) $stopCounts['Non Stop']++;
            elseif ($stops == 1) $stopCounts['1 Stop']++;
            else $stopCounts['2+ Stops']++;
        }
    }
    
    if ($minPrice == PHP_INT_MAX) $minPrice = 0;
    if ($maxPrice == 0) $maxPrice = 50000;
    
    // Ensure max is always at least slightly higher for UI if only one result
    if ($maxPrice == $minPrice && $maxPrice > 0) $maxPrice += 1000;
@endphp

@section('title', " Flights: " . $origin . " → " . $destination . " — Trip Zant Booking.com " )
@section('active-flights', 'active')

@section('content')
<script>
    /** 
     * GLOBAL FARE OPTIONS MODAL LOGIC 
     * Defined at the top to ensure it's available for all flight cards.
     */
    window.currentFareData = null;
    window.selectedFareType = 'regular';
    window.selectedCabinClass = 'ECONOMY';
    window.activeFareFlightId = null;   // tracks which flight the modal is open for

    window.openFareOptions = async function(flightId, price, airline) {
        console.log("Triggered openFareOptions:", flightId);
        window.activeFareFlightId = flightId;   // <-- store for booking step
        
        // 1. Reset Modal UI state
        const airlineEl = document.getElementById('modalAirlineName');
        if(airlineEl) airlineEl.innerText = airline;
        
        window.selectedCabinClass = 'ECONOMY';
        window.selectedFareType = 'regular';
        
        // Show Loader
        const loader = document.getElementById('fareModalLoader');
        if(loader) { loader.classList.remove('d-none'); loader.classList.add('d-flex'); }

        // 2. Open Modal
        const modalEl = document.getElementById('fareOptionsModal');
        if (!modalEl) {
            console.error("Fare Modal missing from DOM");
            return;
        }
        
        if (typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }

        // 3. Fetch Data
        try {
            const res = await fetch(`{{ url('/flights/fare-classes') }}?id=${flightId}&price=${price}`);
            const data = await res.json();
            if (data.success) {
                window.currentFareData = data.fares;
                window.updateFareModalUI();
            }
        } catch (err) {
            console.error("Fare fetch failed:", err);
        } finally {
            if(loader) { loader.classList.add('d-none'); loader.classList.remove('d-flex'); }
        }
    };

    window.updateFareModalUI = function() {
        if (!window.currentFareData) return;
        const activeCabinData = window.currentFareData[window.selectedCabinClass];
        if (activeCabinData) {
            if(document.getElementById('modalPriceRegular')) document.getElementById('modalPriceRegular').innerText = '₹' + activeCabinData.regular.toLocaleString();
            if(document.getElementById('modalPriceStudent')) document.getElementById('modalPriceStudent').innerText = '₹' + activeCabinData.student.toLocaleString();
            if(document.getElementById('modalPriceSenior')) document.getElementById('modalPriceSenior').innerText = '₹' + activeCabinData.senior.toLocaleString();
        }
        
        // Update Cabin Tabs
        Object.keys(window.currentFareData).forEach(cabin => {
            const seatEl = document.getElementById(`seat_${cabin}`);
            if (seatEl) seatEl.innerText = `${window.currentFareData[cabin].seats} Seats Left`;
        });

        // Highlight active tab
        document.querySelectorAll('.cabin-tab').forEach(btn => {
            if (btn.dataset.cabin === window.selectedCabinClass) btn.classList.add('active');
            else btn.classList.remove('active');
        });
    };

    window.updateFareModalClass = function(cabinCode) {
        window.selectedCabinClass = cabinCode;
        if(document.getElementById('modalSelectedClass')) document.getElementById('modalSelectedClass').innerText = cabinCode;
        window.updateFareModalUI();
    };

    window.selectSpecialFare = function(type, element) {
        window.selectedFareType = type;
        document.querySelectorAll('.fare-option-card').forEach(c => c.classList.remove('active'));
        element.classList.add('active');
    };

    window.confirmFareSelection = function() {
        if (!window.currentFareData || !window.activeFareFlightId) {
            Swal.fire('Error', 'Please select a fare option first.', 'error');
            return;
        }

        const activeCabinData = window.currentFareData[window.selectedCabinClass];
        if (!activeCabinData) return;

        const farePrice = activeCabinData[window.selectedFareType];

        // Apply active bank offer discount if any
        let finalPrice = farePrice;
        let bankDiscount = 0;
        const bankOffer = window.activeBankOffer;
        if (bankOffer && farePrice >= (bankOffer.min_amount || 0)) {
            if (bankOffer.discount_type === 'percentage') {
                bankDiscount = Math.floor(farePrice * bankOffer.discount_value / 100);
                if (bankOffer.max_discount) bankDiscount = Math.min(bankDiscount, bankOffer.max_discount);
            } else {
                bankDiscount = bankOffer.discount_value;
            }
            finalPrice = Math.max(0, farePrice - bankDiscount);
        }

        // Show loading
        const btn = document.getElementById('confirmFareBtn');
        if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...'; }

        fetch('{{ url('/flights/select-fare') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                id:          window.activeFareFlightId,
                price:       finalPrice,
                cabin:       window.selectedCabinClass,
                fare_type:   window.selectedFareType,
                bank_offer:  bankOffer ? bankOffer.bank_name : null,
                bank_discount: bankDiscount
            })
        })
        .then(async r => {
            const isJson = r.headers.get('content-type')?.includes('application/json');
            const data = isJson ? await r.json() : null;
            
            if (!r.ok) {
                throw new Error(data?.message || `Server error: ${r.status}`);
            }
            return data;
        })
        .then(data => {
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message || 'Could not proceed to checkout.');
            }
        })
        .catch(err => {
            Swal.fire('Error', err.message, 'error');
            if (btn) { btn.disabled = false; btn.innerHTML = 'CONTINUE BOOKING'; }
        });
    };
</script>

<!-- Fare Options & Seat Class Modal — placed here so it's in DOM before any card renders -->
<div class="modal fade" id="fareOptionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 p-4" style="background: #1e293b;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white rounded-circle p-2 shadow-sm" style="width:45px; height:45px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-ticket-alt text-navy" style="color: #1e293b;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-900 text-white mb-0">Select Your Fare &amp; Class</h5>
                        <p class="text-white-50 mb-0 x-small fw-700 uppercase" id="modalAirlineName">Multiple options available</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Sidebar: Cabin Classes -->
                    <div class="col-md-4 bg-light border-end p-4">
                        <h6 class="fw-800 text-navy mb-3 x-small uppercase">Choose Cabin Class</h6>
                        <div class="d-flex flex-column gap-2" id="cabinClassTabs">
                            <button class="btn btn-outline-navy active text-start fw-800 p-3 rounded-3 cabin-tab" data-cabin="ECONOMY" onclick="updateFareModalClass('ECONOMY')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <span>Economy</span>
                                        <span class="x-small text-muted fw-700" id="seat_ECONOMY">9+ Seats Left</span>
                                    </div>
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </button>
                            <button class="btn btn-outline-navy text-start fw-800 p-3 rounded-3 cabin-tab" data-cabin="PREMIUM_ECONOMY" onclick="updateFareModalClass('PREMIUM_ECONOMY')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <span>Premium Eco</span>
                                        <span class="x-small text-muted fw-700" id="seat_PREMIUM_ECONOMY">Checking...</span>
                                    </div>
                                    <i class="fas fa-circle-notch opacity-25"></i>
                                </div>
                            </button>
                            <button class="btn btn-outline-navy text-start fw-800 p-3 rounded-3 cabin-tab" data-cabin="BUSINESS" onclick="updateFareModalClass('BUSINESS')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <span>Business</span>
                                        <span class="x-small text-muted fw-700" id="seat_BUSINESS">Checking...</span>
                                    </div>
                                    <i class="fas fa-circle-notch opacity-25"></i>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Main Content: Special Fares -->
                    <div class="col-md-8 p-4 position-relative">
                        <!-- Loading Overlay -->
                        <div id="fareModalLoader" class="position-absolute top-0 start-0 w-100 h-100 d-none flex-column align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 10;">
                            <div class="spinner-border text-primary mb-2" role="status"></div>
                            <div class="fw-800 text-navy x-small">Fetching Live Fares...</div>
                        </div>

                        <h6 class="fw-800 text-navy mb-4 x-small uppercase">Select a Fare Type</h6>

                        <div class="fare-option-card mb-3 p-3 rounded-4 border-2 border active" onclick="selectSpecialFare('regular', this)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2" style="width:35px; height:35px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-user"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-800 text-navy">Regular Fares</h6>
                                        <p class="mb-0 text-muted x-small fw-700">Standard booking rules apply</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-900 text-navy h5 mb-0" id="modalPriceRegular">₹0</div>
                                    <span class="badge bg-success bg-opacity-10 text-success fw-800" style="font-size:9px;">AVAILABLE</span>
                                </div>
                            </div>
                        </div>

                        <div class="fare-option-card mb-3 p-3 rounded-4 border-2 border" onclick="selectSpecialFare('student', this)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-2" style="width:35px; height:35px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-user-graduate"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-800 text-navy">Student Fares</h6>
                                        <p class="mb-0 text-muted x-small fw-700">Valid Student ID required</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-900 text-navy h5 mb-0" id="modalPriceStudent">₹0</div>
                                    <span class="badge bg-info bg-opacity-10 text-info fw-800" style="font-size:9px;">5% EXTRA OFF</span>
                                </div>
                            </div>
                        </div>

                        <div class="fare-option-card mb-3 p-3 rounded-4 border-2 border" onclick="selectSpecialFare('senior', this)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2" style="width:35px; height:35px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-user-clock"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-800 text-navy">Senior Citizen</h6>
                                        <p class="mb-0 text-muted x-small fw-700">Age 60+ only</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-900 text-navy h5 mb-0" id="modalPriceSenior">₹0</div>
                                    <span class="badge bg-warning bg-opacity-10 text-warning fw-800" style="font-size:9px;">8% EXTRA OFF</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 p-4 d-flex justify-content-between">
                <div class="text-muted small fw-700">
                    <i class="fas fa-info-circle me-1"></i> Selection will update your booking price
                </div>
                <button type="button" class="btn btn-primary rounded-pill px-5 fw-900 shadow-sm" id="confirmFareBtn" onclick="confirmFareSelection()" style="background: #1e293b; border: none;">
                    CONTINUE BOOKING
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .fare-option-card { cursor: pointer; transition: all 0.2s; border-color: #f1f5f9; background: #fff; }
    .fare-option-card:hover { border-color: #2563eb; transform: translateY(-2px); }
    .fare-option-card.active { border-color: #2563eb; background: #f0f7ff; }
    .cabin-tab.active { background: #1e293b !important; color: #fff !important; border-color: #1e293b !important; }
    .cabin-tab.active .text-muted { color: rgba(255,255,255,0.65) !important; }
    .btn-outline-navy { color: #1e293b; border-color: #1e293b; }
    .btn-outline-navy:hover { background: #1e293b; color: #fff; }
</style>

<div class="multi-city-wrapper {{ $isMultiCity ? 'is-multi-city' : '' }}">
    <!-- MMT-STYLE HEADER & PERMANENT SEARCH RIBBON -->
    <div class="mmt-header-wrapper" style="background:#001d3d; position: sticky; top: 70px; z-index: 999; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div class="container-fluid px-lg-5 py-3">
            <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                <div class="d-flex align-items-center gap-3">
                    <label class="misty-radio-listing">
                        <input type="radio" name="tripType" value="oneway" {{ (!$isRoundTrip && !$isMultiCity) ? 'checked' : '' }} onchange="updateSearchUIMode(this.value)">
                        One Way
                    </label>
                    <label class="misty-radio-listing">
                        <input type="radio" name="tripType" value="roundtrip" {{ $isRoundTrip ? 'checked' : '' }} onchange="updateSearchUIMode(this.value)">
                        Round Trip
                    </label>
                    <label class="misty-radio-listing">
                        <input type="radio" name="tripType" value="multicity" {{ $isMultiCity ? 'checked' : '' }} onchange="updateSearchUIMode(this.value)">
                        Multi City
                    </label>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="m-mode-btn {{ (!request('max_budget') && !request('baggage')) ? 'active' : '' }}" onclick="switchFlightMode('date', this)">
                        <i class="fas fa-calendar-alt"></i> Search by dates
                    </button>
                    <button class="m-mode-btn {{ request('max_budget') ? 'active' : '' }}" onclick="switchFlightMode('budget', this)">
                        <i class="fas fa-money-bill-wave"></i> Search by budget
                    </button>
                    <button class="m-mode-btn {{ request('baggage') ? 'active' : '' }}" onclick="switchFlightMode('baggage', this)">
                        <i class="fas fa-suitcase-rolling"></i> Search by baggage
                    </button>
                </div>
            </div>



            <!-- Permanent MMT Horizontal Search Bar -->
            <div id="modifySearchPanel" class="bg-white rounded-3 shadow-lg p-0 border-0" style="width: 100%; position: relative; overflow: visible;">
                <div class="d-flex align-items-stretch flex-nowrap" style="min-height: 80px;">
                    <!-- STANDARD FIELDS (One Way / Round Trip) -->
                    <div id="mmtStandardFields" class="d-flex flex-grow-1 align-items-stretch {{ $isMultiCity ? 'd-none' : '' }}">
                        <!-- From column -->
                        <div class="search-col border-end px-4 py-2 position-relative d-flex flex-column justify-content-center flex-grow-1" style="min-width: 250px;">
                            <label class="x-small fw-800 text-muted uppercase d-block mb-1" style="font-size:9px; letter-spacing:0.5px;">FROM</label>
                            <input type="text" id="mmtOrigin" class="fw-900 border-0 bg-transparent p-0 shadow-none w-100 fs-4 text-navy autocomplete-input" value="{{ $originCity ?? $origin }}" data-code="{{ $origin }}" autocomplete="off" onfocus="this.select()" style="outline: none;">
                            <div id="mmtOriginResults" class="autocomplete-results d-none shadow-2xl border rounded-3 overflow-hidden bg-white" style="position: absolute; top: 100%; left: 0; width: 450px; z-index: 10000; margin-top: 5px;"></div>
                        </div>

                        <div class="d-flex align-items-center px-1" style="pointer-events: none;">
                            <div class="swap-circle shadow-sm hvr-rotate" onclick="swapMmtLocations()" style="width:34px; height:34px; background:#fff; border:1px solid #ddd; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; margin:0 -17px; position:relative; z-index:50; pointer-events: auto;">
                                <i class="fas fa-right-left text-primary" style="font-size:12px;"></i>
                            </div>
                        </div>

                        <!-- To column -->
                        <div class="search-col border-end px-4 py-2 position-relative d-flex flex-column justify-content-center flex-grow-1" style="min-width: 250px;">
                            <label class="x-small fw-800 text-muted uppercase d-block mb-1" style="font-size:9px; letter-spacing:0.5px;">TO</label>
                            <input type="text" id="mmtDestination" class="fw-900 border-0 bg-transparent p-0 shadow-none w-100 fs-4 text-navy autocomplete-input" value="{{ $destinationCity ?? $destination }}" data-code="{{ $destination }}" autocomplete="off" onfocus="this.select()" style="outline: none;">
                            <div id="mmtDestinationResults" class="autocomplete-results d-none shadow-2xl border rounded-3 overflow-hidden bg-white" style="position: absolute; top: 100%; left: 0; width: 450px; z-index: 10000; margin-top: 5px;"></div>
                        </div>

                        <!-- Depart column -->
                        <div class="search-col border-end px-3 py-2 d-flex flex-column justify-content-center flex-shrink-0" style="width: 180px;">
                            <label class="x-small fw-800 text-muted uppercase d-block mb-1" style="font-size:9px; letter-spacing:0.5px;">DEPART</label>
                            <input type="text" id="mmtDeparture" class="fw-900 border-0 bg-transparent p-0 shadow-none w-100 text-navy cursor-pointer" value="{{ \Carbon\Carbon::parse($travelDate)->format('D, d M Y') }}" readonly style="outline: none; font-size: 15px;">
                        </div>

                        <!-- Return column -->
                        <div class="search-col border-end px-3 py-2 d-flex flex-column justify-content-center flex-shrink-0" id="mmtReturnCol" style="width: 180px; {{ !$isRoundTrip ? 'opacity:0.3;' : '' }}">
                            <label class="x-small fw-800 text-muted uppercase d-block mb-1" style="font-size:9px; letter-spacing:0.5px;">RETURN</label>
                            <input type="text" id="mmtReturn" class="fw-900 border-0 bg-transparent p-0 shadow-none w-100 text-navy cursor-pointer" value="{{ $returnDate ? \Carbon\Carbon::parse($returnDate)->format('D, d M Y') : 'Select Date' }}" readonly {{ !$isRoundTrip ? 'disabled' : '' }} style="outline: none; font-size: 15px;">
                        </div>
                    </div>

                    <!-- MULTI CITY FIELDS -->
                    <div id="mmtMultiCityFields" class="flex-grow-1 {{ !$isMultiCity ? 'd-none' : 'd-flex' }} flex-column p-2" style="overflow: visible;">
                        <div id="mmtMultiCityRows" class="w-100">
                            @if($isMultiCity)
                                @for($i = 0; $i < max(2, $numSegments); $i++)
                                    @php
                                        $oCode = $multiCityOrigins[$i] ?? '';
                                        $dCode = $multiCityDestinations[$i] ?? '';
                                        $date = $multiCityDates[$i] ?? '';
                                    @endphp
                                    <div class="mmt-mc-row d-flex gap-2 mb-2 align-items-center">
                                        <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                                            <i class="fas fa-plane-departure text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                            <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-origin autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="From" value="{{ $oCode }}" data-code="{{ $oCode }}" style="font-size: 14px; outline: none;">
                                            <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
                                        </div>
                                        <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                                            <i class="fas fa-plane-arrival text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                            <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-destination autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="To" value="{{ $dCode }}" data-code="{{ $dCode }}" style="font-size: 14px; outline: none;">
                                            <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
                                        </div>
                                        <div class="position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center" style="width: 160px;">
                                            <i class="fas fa-calendar-alt text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                            <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-date cursor-pointer fw-bold shadow-none p-0 text-navy" placeholder="Date" value="{{ $date ? \Carbon\Carbon::parse($date)->format('D, d M Y') : '' }}" readonly style="font-size: 14px; outline: none;">
                                        </div>
                                        <button type="button" class="btn btn-link text-danger p-0 ms-1 remove-mc-btn {{ $numSegments <= 2 ? 'd-none' : '' }}" onclick="removeMmtCityRow(this)"><i class="fas fa-times-circle fs-5"></i></button>
                                    </div>
                                @endfor
                            @else
                                <div class="mmt-mc-row d-flex gap-2 mb-2 align-items-center">
                                    <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                                        <i class="fas fa-plane-departure text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-origin autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="From" value="{{ $originCity ?? $origin }}" data-code="{{ $origin }}" style="font-size: 14px; outline: none;">
                                        <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
                                    </div>
                                    <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                                        <i class="fas fa-plane-arrival text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-destination autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="To" value="{{ $destinationCity ?? $destination }}" data-code="{{ $destination }}" style="font-size: 14px; outline: none;">
                                        <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
                                    </div>
                                    <div class="position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center" style="width: 160px;">
                                        <i class="fas fa-calendar-alt text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-date cursor-pointer fw-bold shadow-none p-0 text-navy" placeholder="Date" value="{{ \Carbon\Carbon::parse($travelDate)->format('D, d M Y') }}" readonly style="font-size: 14px; outline: none;">
                                    </div>
                                    <button type="button" class="btn btn-link text-danger p-0 ms-1 remove-mc-btn d-none" onclick="removeMmtCityRow(this)"><i class="fas fa-times-circle fs-5"></i></button>
                                </div>
                                <div class="mmt-mc-row d-flex gap-2 mb-2 align-items-center">
                                    <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                                        <i class="fas fa-plane-departure text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-origin autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="From" value="" data-code="" style="font-size: 14px; outline: none;">
                                        <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
                                    </div>
                                    <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                                        <i class="fas fa-plane-arrival text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-destination autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="To" value="" data-code="" style="font-size: 14px; outline: none;">
                                        <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
                                    </div>
                                    <div class="position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center" style="width: 160px;">
                                        <i class="fas fa-calendar-alt text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-date cursor-pointer fw-bold shadow-none p-0 text-navy" placeholder="Date" readonly style="font-size: 14px; outline: none;">
                                    </div>
                                    <button type="button" class="btn btn-link text-danger p-0 ms-1 remove-mc-btn d-none" onclick="removeMmtCityRow(this)"><i class="fas fa-times-circle fs-5"></i></button>
                                </div>
                            @endif
                        </div>
                        <div>
                            <button type="button" class="btn btn-link btn-sm p-0 fw-bold text-primary text-decoration-none" onclick="addMmtCityRow()">+ ADD CITY</button>
                        </div>
                    </div>

                    <!-- Traveler column -->
                    <div class="search-col border-end px-4 py-2 cursor-pointer d-flex flex-column justify-content-center flex-shrink-0" style="width: 240px;" onclick="window.toggleTravelerPicker(event)">
                        <label class="x-small fw-800 text-muted uppercase d-block mb-1" style="font-size:9px; letter-spacing:0.5px;">TRAVELLERS & CLASS</label>
                        <div class="fw-900 fs-5 text-navy text-truncate" id="mmtTravelerInfoText">
                            {{ $adults }} Adult, {{ $cabinClass }}
                        </div>
                    </div>

                   

                    <!-- Search Button -->
                    <div class="ms-auto d-flex align-items-center px-4" style="background: #fff; border-top-right-radius: 8px;">
                        <button class="btn btn-primary rounded-pill px-5 fw-900 py-3 shadow-lg hvr-grow" onclick="executeMmtSearch()" style="background: linear-gradient(135deg, #008cff 0%, #0056ff 100%); border:none; height: 55px; min-width: 160px;">
                            SEARCH
                        </button>
                    </div>
                </div>

                <!-- SINGLE Fare row -->
                <div class="d-flex align-items-center px-4 border-top gap-4" style="background: #fbfbfb; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; min-height: 45px; padding: 5px 0;">
                    <div class="x-small fw-800 text-muted text-uppercase" style="font-size: 10px; letter-spacing: 0.5px; min-width: 140px;">Select a Special Fare:</div>
                    <div class="d-flex align-items-center gap-5">
                        <label class="mmt-fare-chip"><input type="radio" name="fare" value="regular" {{ ($fareType ?? 'regular') == 'regular' ? 'checked' : '' }} onchange="executeMmtSearch()"><span>Regular Fares</span></label>
                        <label class="mmt-fare-chip"><input type="radio" name="fare" value="student" {{ ($fareType ?? '') == 'student' ? 'checked' : '' }} onchange="executeMmtSearch()"><span>Student Fares</span></label>
                        <label class="mmt-fare-chip"><input type="radio" name="fare" value="senior" {{ ($fareType ?? '') == 'senior' ? 'checked' : '' }} onchange="executeMmtSearch()"><span>Senior Citizen Fares</span></label>
                    </div>

                    <!-- Budget Input Integrated Here -->
                    <div class="ms-auto d-flex align-items-center gap-3 {{ !request('max_budget') ? 'd-none' : '' }} animate__animated animate__fadeIn" id="budgetModifierRow" style="padding-right: 10px;">
                        <span class="fw-900 text-muted uppercase" style="font-size: 9px; letter-spacing: 1px;">MAX BUDGET:</span>
                        <div class="d-flex align-items-center gap-1 bg-white px-3 py-1 rounded-pill border shadow-sm">
                            <span class="fw-900 text-primary" style="font-size: 14px;">₹</span>
                            <input type="number" id="globalMaxBudget" class="border-0 fw-900 text-navy p-0" value="{{ request('max_budget', 20000) }}" step="500" style="outline: none; width: 80px; font-size: 15px; background: transparent;">
                        </div>
                    </div>

                    <!-- Baggage Input Integrated Here -->
                    <div class="ms-auto d-flex align-items-center gap-3 {{ !request('baggage') ? 'd-none' : '' }} animate__animated animate__fadeIn" id="baggageModifierRow" style="padding-right: 10px;">
                        <span class="fw-900 text-success uppercase" style="font-size: 9px; letter-spacing: 1px;">BAGGAGE ALLOWANCE:</span>
                        <div class="d-flex align-items-center gap-1 bg-white px-3 py-1 rounded-pill border border-success shadow-sm">
                            <select id="globalMaxBaggage" class="border-0 fw-900 text-navy p-0 cursor-pointer" style="outline: none; font-size: 12px; background: transparent;">
                                <option value="" {{ !request('baggage') ? 'selected' : '' }}>Any Baggage</option>
                                <option value="5" {{ request('baggage') == '5' ? 'selected' : '' }}>5 KG</option>
                                <option value="7" {{ request('baggage') == '7' ? 'selected' : '' }}>7 KG</option>
                                <option value="10" {{ request('baggage') == '10' ? 'selected' : '' }}>10 KG</option>
                                <option value="15" {{ request('baggage') == '15' ? 'selected' : '' }}>15 KG</option>
                                <option value="20" {{ request('baggage') == '20' ? 'selected' : '' }}>20 KG</option>
                                <option value="25" {{ request('baggage') == '25' ? 'selected' : '' }}>25 KG</option>
                                <option value="30" {{ request('baggage') == '30' ? 'selected' : '' }}>30 KG (2x15)</option>
                                <option value="35" {{ request('baggage') == '35' ? 'selected' : '' }}>35 KG (2x17.5)</option>
                                <option value="40" {{ request('baggage') == '40' ? 'selected' : '' }}>40 KG (2x20)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SINGLE Traveler Dropdown Picker -->
                <div id="mmtTravelerDropdown" class="d-none animate__animated animate__fadeIn border-0 rounded-4 shadow-2xl p-4 bg-white position-absolute" style="top: calc(100% + 15px); right: 20px; z-index: 100000; min-width: 450px; box-shadow: 0 30px 60px rgba(0,0,0,0.3);" onclick="event.stopPropagation()">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="fw-900 text-navy mb-0" style="font-size: 14px;">ADULTS (12y+)</label>
                            <span class="badge bg-light text-muted rounded-pill px-3 py-1 fw-700">on the day of travel</span>
                        </div>
                        <div class="mmt-pills-container d-flex flex-wrap gap-2">
                            @for($i=1;$i<10;$i++)
                                <div class="mmt-modern-pill {{ $i == $adults ? 'active' : '' }}" onclick="updateMmtAdults({{ $i }}, this)">{{ $i }}</div>
                            @endfor
                            <div class="mmt-modern-pill" onclick="updateMmtAdults(10, this)">>9</div>
                        </div>
                    </div>
                    <div class="mb-4 pt-3 border-top">
                        <label class="fw-900 text-navy mb-3 d-block" style="font-size: 14px;">CHOOSE TRAVEL CLASS</label>
                        <div class="mmt-pills-container d-flex flex-wrap gap-2">
                            <div class="mmt-class-pill-lg {{ $cabinClass == 'Economy' ? 'active' : '' }}" onclick="updateMmtClass('Economy', this)">Economy</div>
                            <div class="mmt-class-pill-lg {{ $cabinClass == 'Premium Economy' ? 'active' : '' }}" onclick="updateMmtClass('Premium Economy', this)">Premium Economy</div>
                            <div class="mmt-class-pill-lg {{ $cabinClass == 'Business' ? 'active' : '' }}" onclick="updateMmtClass('Business', this)">Business</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end pt-2">
                        <button class="btn btn-primary rounded-pill px-5 fw-800 py-2" onclick="document.getElementById('mmtTravelerDropdown').classList.add('d-none'); executeMmtSearch();">APPLY</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container-fluid px-lg-5 mt-4">


    <style>
        .search-col { transition: all 0.2s ease; cursor: text; }
        .search-col:hover { background: #f8faff !important; }
        .search-col input { outline: none !important; border: none !important; box-shadow: none !important; background: transparent !important; cursor: pointer; }
        .search-col input.autocomplete-input { cursor: text; }
        .autocomplete-results { background: #fff; z-index: 10000 !important; box-shadow: 0 15px 40px rgba(0,0,0,0.2) !important; max-height: 400px; overflow-y: auto; }
        .mmt-ac-item { padding: 12px 20px; cursor: pointer; display: flex; align-items: center; gap: 15px; border-bottom: 1px solid #f1f5f9; }
        .mmt-ac-item:hover { background: #f0f7ff; }
        .mmt-ac-box { width: 40px; height: 40px; background: #eef2f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #475569; font-size: 13px; }
        .mmt-ac-city { font-weight: 800; color: #0f172a; font-size: 14px; }
        .mmt-ac-airport { font-size: 11px; color: #64748b; margin-top: 1px; }
        
        .mmt-fare-chip { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 11px; font-weight: 800; color: #4b5563; transition: 0.2s; }
        .mmt-fare-chip input { width: 15px; height: 15px; cursor: pointer; accent-color: #008cff; margin: 0; }
        .mmt-fare-chip:hover { color: #008cff; }

        .container { max-width: 1320px !important; }
        .listing-hero { transition: all 0.3s ease; }
        .listing-hero.scrolled { padding: 10px 0 !important; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .active-summary-card { background: rgba(37, 99, 235, 0.08) !important; border-color: #008cff !important; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.1); }
        .active-summary-card .fw-700 { color: #008cff !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .summary-card:hover { border-color: #008cff !important; background: #fff !important; }

        .cinematic-timeline { position: relative; height: 40px; }
        .timeline-line { position: absolute; top: 50%; left: 0; width: 100%; height: 2px; background: #e2e8f0; transform: translateY(-50%); }
        .timeline-dot { position: absolute; top: 50%; width: 10px; height: 10px; border-radius: 50%; transform: translate(-50%, -50%); z-index: 2; }
        .timeline-dot.origin { left: 0; background: #008cff; }
        .timeline-dot.destination { left: 100%; background: #94a3b8; }
        .timeline-stop { position: absolute; top: 50%; padding: 2px 6px; background: #fff; border: 1.5px solid #008cff; color: #008cff; font-size: 8px; font-weight: 900; border-radius: 50px; transform: translate(-50%, -50%); z-index: 3; }
        
        .bg-success-light { background: rgba(34, 197, 94, 0.1) !important; }
        .bg-danger-light { background: rgba(239, 68, 68, 0.1) !important; }

        .hvr-grow { transition: transform 0.3s; }
        .hvr-grow:hover { transform: scale(1.02); }

        .cinematic-timeline.slim { height:2px; margin: 8px 0; }
        .cinematic-timeline.slim .timeline-dot { width:6px; height:6px; }
        .cinematic-timeline.slim .timeline-line { height:1px; }

        .filter-group-v4 input[disabled] + label { cursor: not-allowed; opacity: 0.6; }

        .mc-stepper-mmt { 
            background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;
            position: sticky; top: 195px !important; z-index: 998 !important; margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .mc-step-tab { cursor: pointer; transition: all 0.3s; background: #fff; border-right: 1px solid #eee; position: relative; }
        .mc-step-tab:last-child { border-right: none; }
        .mc-step-tab:hover { background: #f8faff; }
        .mc-step-tab.active { background: #fff; box-shadow: inset 0 -4px 0 #2563eb; }
        .mc-step-tab.active .mc-leg-route { color: #2563eb; }
        .mc-step-tab.completed { background: #f0f7ff; }
        .mc-status-icon { position: absolute; top: 10px; right: 10px; font-size: 14px; color: #10b981; }

        .mc-bottom-bar-v2 {
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            width: 95%; max-width: 1200px; background: #0b1522;
            border-radius: 12px; box-shadow: 0 15px 40px rgba(0,0,0,0.5);
            z-index: 9999; display: none; padding: 0 20px; height: 85px;
            border: 1px solid rgba(255,255,255,0.1); align-items: center;
        }
        
        .is-multi-city .mc-bottom-bar-v2 { display: flex !important; }
        .multi-city-wrapper.is-multi-city { padding-bottom: 120px !important; }
        
        .mc-bar-item { min-width: 180px; transition: all 0.3s; height: 100%; display: flex; align-items: center; padding: 0 15px; border-radius: 8px; margin: 0 5px; }
        .mc-bar-item.active-leg { background: rgba(37, 99, 235, 0.2); border: 1px solid rgba(37, 99, 235, 0.4); }
        .mc-airline-circle { width: 34px; height: 34px; background: #fff; border-radius: 4px; display: flex; align-items: center; justify-content: center; }
        
        #mcNextBtn { padding: 0 30px; border-radius: 50px; height: 48px; transition: all 0.3s; }
        #mcNextBtn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3); }

        .fare-calendar-v5 { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; position: relative; }
        .cal-nav-btn { width: 44px; height: 100%; min-height: 80px; border: none; background: #fff; color: #008cff; transition: 0.3s; z-index: 5; }
        .cal-nav-btn:hover { background: #f8faff; }
        
        .cal-scroll-wrapper { scrollbar-width: none; -ms-overflow-style: none; }
        .cal-scroll-wrapper::-webkit-scrollbar { display: none; }
        
        .cal-day-card { min-width: 140px; padding: 18px 10px; text-align: center; border-right: 1px solid #f1f5f9; cursor: pointer; transition: 0.2s; }
        .cal-day-card:hover { background: #f8fbff; }
        .cal-day-card.active { background: #fff; box-shadow: inset 0 -3px 0 0 #008cff; }
        .hvr-light-bg:hover { background: #f1f5f9; transition: 0.2s; }
        .cursor-pointer { cursor: pointer; }
        .cal-day-card.active .day-text, .cal-day-card.active .price-text { color: #008cff; font-weight: 800; }
        
        .day-text { font-size: 11px; font-weight: 800; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; }
        .price-text { font-size: 16px; font-weight: 900; color: #1e293b; }
        
        @keyframes pulse-red { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }
        .animate-pulse { animation: pulse-red 2s infinite; }

        .split-booking-bar {
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            width: 100%; max-width: 1100px; background: #fff; border-radius: 16px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.15); z-index: 1060; padding: 15px 25px;
            border: 1px solid #008cff; display: none;
            animation: slideUp 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        @keyframes slideUp { from { transform: translate(-50%, 100%); } to { transform: translate(-50%, 0); } }

        @media (max-width: 991px) {
            .listing-hero { top: 60px; }
            .filter-card-v4 { position: relative !important; top: 0 !important; margin-bottom: 20px; }
        }

        /* Travelers Dropdown Scaling */
        .mmt-modern-pill { 
            width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #4b5563; cursor: pointer; transition: 0.2s;
        }
        .mmt-modern-pill:hover { border-color: #008cff; color: #008cff; background: #f0f7ff; }
        .mmt-modern-pill.active { background: #008cff !important; color: #fff !important; border-color: #008cff !important; box-shadow: 0 4px 10px rgba(0,140,255,0.3); }

        .mmt-class-pill-lg { 
            padding: 8px 16px; border-radius: 50px; border: 1px solid #e2e8f0;
            font-size: 13px; font-weight: 700; color: #4b5563; cursor: pointer; transition: 0.2s;
            white-space: nowrap;
        }
        .mmt-class-pill-lg:hover { border-color: #008cff; color: #008cff; background: #f0f7ff; }
        .mmt-class-pill-lg.active { background: #008cff !important; color: #fff !important; border-color: #008cff !important; box-shadow: 0 4px 10px rgba(0,140,255,0.3); }

        /* Bank Offer Highlighting */
        .flight-row.bank-offer-active .result-card {
            border-color: #f37021 !important;
            box-shadow: 0 0 20px rgba(243, 112, 33, 0.2) !important;
            transform: scale(1.01);
            background: linear-gradient(to right, #fff, #fff9f5) !important;
        }
        .bank-offer-badge {
            position: absolute; top: -10px; right: 20px;
            background: #f37021; color: #fff;
            padding: 4px 12px; border-radius: 50px;
            font-size: 10px; font-weight: 900;
            box-shadow: 0 4px 10px rgba(243, 112, 33, 0.3);
            z-index: 10; display: none;
            animation: pulse-orange 2s infinite;
        }
        .flight-row.bank-offer-active .bank-offer-badge { display: block; }
        @keyframes pulse-orange {
            0% { transform: scale(1); box-shadow: 0 4px 10px rgba(243, 112, 33, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 4px 20px rgba(243, 112, 33, 0.5); }
            100% { transform: scale(1); box-shadow: 0 4px 10px rgba(243, 112, 33, 0.3); }
        }

        /* Bank Selection Bar */
        .bank-selection-banner {
            background: #fff;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .bank-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .bank-pill:hover {
            border-color: #2563eb;
            background: #f8fbff;
        }
        .bank-pill.active {
            background: #eef2ff;
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }
        .bank-pill.active .text-navy {
            color: #2563eb !important;
        }
        .bank-scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 12px;
            padding: 5px;
        }
        .bank-scroll-container::-webkit-scrollbar {
            display: none;
        }
    </style>

    @php
        $cheapest = collect($flights)->sortBy('price')->first();
        
        // Helper to convert duration string (e.g. 2h 30m) to minutes for accurate sorting
        function durToMin($str) {
            preg_match('/(\d+)h/', $str, $h);
            preg_match('/(\d+)m/', $str, $m);
            return (($h[1] ?? 0) * 60) + ($m[1] ?? 0);
        }

        $fastest = collect($flights)->sortBy(fn($f) => durToMin($f['duration'] ?? '99h'))->first();
        $recommended = collect($flights)->where('stops', 0)->sortBy('price')->first() ?? $cheapest;
        
        $hasMultiple = count($flights) > 1;
    @endphp

    <!-- Dynamic Summary Strip -->
    <div style="background:#fff; border-bottom:1px solid #e2e8f0; margin-top:-1px;">
        <div class="container py-3">
            <div class="d-flex gap-3 overflow-auto no-scrollbar">
                <div class="summary-card active-summary-card text-center px-4 py-2 rounded-3 border-2" onclick="sortByFilter('price', this)" style="border:1.5px solid #eee; min-width:160px; cursor:pointer; transition:0.2s;">
                    <div class="fw-700 text-muted" style="font-size:12px;">CHEAPEST</div>
                    <div class="fw-900 text-navy" style="font-size:17px;">{{ $currency }} {{ number_format($cheapest['price'] ?? $minPrice) }}</div>
                    <div class="text-muted" style="font-size:10px; font-weight:700;">BEST PRICE</div>
                </div>
                <div class="summary-card text-center px-4 py-2 rounded-3 border-2" onclick="sortByFilter('duration', this)" style="border:1.5px solid #eee; min-width:160px; cursor:pointer; transition:0.2s; background:#f8fafc;">
                    <div class="fw-700 text-muted" style="font-size:12px;">FASTEST</div>
                    <div class="fw-900 text-navy" style="font-size:17px;">{{ $currency }} {{ number_format($fastest['price'] ?? $minPrice) }}</div>
                    <div class="text-muted" style="font-size:10px; font-weight:700;">{{ $hasMultiple ? 'MIN. DURATION' : 'BEST TIME' }}</div>
                </div>
                <div class="summary-card text-center px-4 py-2 rounded-3 border-2" onclick="sortByFilter('recommended', this)" style="border:1.5px solid #eee; min-width:160px; cursor:pointer; transition:0.2s; background:#f8fafc;">
                    <div class="fw-700 text-muted" style="font-size:12px;">RECOMMENDED</div>
                    <div class="fw-900 text-navy" style="font-size:17px;">{{ $currency }} {{ number_format($recommended['price'] ?? $minPrice) }}</div>
                    <div class="text-muted" style="font-size:10px; font-weight:700;">USER CHOICE</div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-cb { 
            display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 6px 0;
            transition: all 0.2s ease;
        }
        .cb-box { 
            width: 18px; height: 18px; border: 2.5px solid #cbd5e1; border-radius: 4px;
            position: relative; transition: all 0.2s ease; background: #fff;
        }
        input:checked + .custom-cb .cb-box { 
            background: #2563eb; border-color: #2563eb;
        }
        input:checked + .custom-cb .cb-box::after { 
            content: '\f00c'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
            color: #fff; font-size: 10px; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }
        .cb-label { font-size: 13px; font-weight: 700; color: #475569; flex-grow: 1; }
        .cb-count { font-size: 11px; font-weight: 800; color: #94a3b8; }
        .custom-cb:hover .cb-box { border-color: #2563eb; }

        .quick-filters-bar {
            display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
            padding: 12px 15px; background: #fff; border-radius: 12px; border: 1px solid #eef2f6;
        }
        .quick-filter-pill {
            padding: 8px 16px; border-radius: 50px; border: 1.5px solid #e2e8f0;
            font-size: 12px; font-weight: 800; color: #64748b; cursor: pointer;
            transition: 0.3s; display: flex; align-items: center; gap: 8px;
        }
        .quick-filter-pill:hover { border-color: #2563eb; color: #2563eb; background: #f0f7ff; }
        .quick-filter-pill.active { background: #2563eb; color: #fff; border-color: #2563eb; box-shadow: 0 5px 15px rgba(37,99,235,0.3); }
        .quick-filter-pill i { font-size: 11px; }
    </style>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="mb-4">
                    <a href="{{ request()->fullUrlWithQuery(['mode' => 'map']) }}" class="btn rounded-pill py-3 fw-800 d-flex align-items-center justify-content-center gap-2 hover-up shadow-sm" style="background: #001d3d; color: #fff;">
                        <i class="fas fa-map-marked-alt text-warning"></i> EXPLORE ON MAP
                    </a>
                </div>
                <div class="filter-card-v4 sticky-top shadow-sm" style="top:180px; z-index: 900;">
                    <div class="filter-title-v4"><span><i class="fas fa-sliders"></i></span> FILTERS</div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Popular Filters</span>
                        @if($stopCounts['Non Stop'] > 0)
                        <div class="mb-2">
                            <input type="checkbox" id="pf1" hidden>
                            <label class="custom-cb" for="pf1">
                                <div class="cb-box"></div>
                                <span class="cb-label">Non Stop</span>
                                <span class="cb-count">{{ $stopCounts['Non Stop'] }}</span>
                            </label>
                        </div>
                        @endif
                        @if($morningDeparturesCount > 0)
                        <div class="mb-2">
                            <input type="checkbox" id="pf2" hidden>
                            <label class="custom-cb" for="pf2">
                                <div class="cb-box"></div>
                                <span class="cb-label">Morning Departures</span>
                                <span class="cb-count">{{ $morningDeparturesCount }}</span>
                            </label>
                        </div>
                        @endif
                        @if($refundableCount > 0)
                        <div class="mb-2">
                            <input type="checkbox" id="pf3" hidden>
                            <label class="custom-cb" for="pf3">
                                <div class="cb-box"></div>
                                <span class="cb-label">Refundable</span>
                                <span class="cb-count">{{ $refundableCount }}</span>
                            </label>
                        </div>
                        @endif
                    </div>

                    @if($stopCounts['Non Stop'] > 0 || $stopCounts['1 Stop'] > 0 || $stopCounts['2+ Stops'] > 0)
                    <div class="filter-group-v4">
                        <span class="filter-group-label">Stops</span>
                        @if($stopCounts['Non Stop'] > 0)
                        <div class="mb-2">
                            <input type="checkbox" id="s0" class="filter-stops" value="0" hidden onchange="applyFilters()">
                            <label class="custom-cb" for="s0">
                                <div class="cb-box"></div>
                                <span class="cb-label">Non Stop</span>
                                <span class="cb-count badge bg-light text-dark">{{ $currency }} {{ number_format($minPrice ?: 0) }}</span>
                            </label>
                        </div>
                        @endif
                        @if($stopCounts['1 Stop'] > 0)
                        <div class="mb-2">
                            <input type="checkbox" id="s1" class="filter-stops" value="1" hidden onchange="applyFilters()">
                            <label class="custom-cb" for="s1">
                                <div class="cb-box"></div>
                                <span class="cb-label">1 Stop</span>
                                <span class="cb-count badge bg-light text-dark">{{ $currency }} {{ number_format($minPrice > 0 ? $minPrice + 1200 : 0) }}</span>
                            </label>
                        </div>
                        @endif
                        @if($stopCounts['2+ Stops'] > 0)
                        <div class="mb-2">
                            <input type="checkbox" id="s2" class="filter-stops" value="2" hidden onchange="applyFilters()">
                            <label class="custom-cb" for="s2">
                                <div class="cb-box"></div>
                                <span class="cb-label">2+ Stops</span>
                                <span class="cb-count badge bg-light text-dark">{{ $currency }} {{ number_format($minPrice > 0 ? $minPrice + 2400 : 0) }}</span>
                            </label>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Price Range</span>
                        <div class="px-2">
                            <input type="range" class="form-range custom-range" min="{{ $minPrice }}" max="{{ max($maxPrice, $initialMaxBudget ?? 0) }}" step="500" value="{{ $initialMaxBudget ?? $maxPrice }}">
                            <div class="d-flex justify-content-between TS-2" style="font-size:11px;color:var(--gray-300);font-weight:700;">
                                <span>{{ $currency }} {{ number_format($minPrice) }}</span><span>{{ $currency }} {{ number_format($initialMaxBudget ?? $maxPrice) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Cabin Class</span>
                        @foreach(['ECONOMY', 'PREMIUM_ECONOMY', 'BUSINESS', 'FIRST'] as $class)
                        @php $cCount = $cabinCounts[$class] ?? 0; @endphp
                        <div class="mb-2 {{ $cCount == 0 ? 'opacity-25' : '' }}">
                            <input type="checkbox" id="cc_{{ $class }}" class="filter-cabin" value="{{ $class }}" hidden {{ request('cabin_class') == $class ? 'checked' : '' }} {{ $cCount == 0 ? 'disabled' : '' }}>
                            <label class="custom-cb" for="cc_{{ $class }}">
                                <div class="cb-box"></div>
                                <span class="cb-label">{{ str_replace('_', ' ', $class) }}</span>
                                <span class="cb-count">{{ $cCount }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="filter-group-v4">
                        <span class="filter-group-label">Preferred Airlines</span>
                        @forelse($airlinesFilter as $name => $data)
                        <div class="mb-2">
                            <input type="checkbox" id="a{{ $loop->index }}" 
                                   data-airline-filter="{{ $name }}" 
                                   checked hidden>
                            <label class="custom-cb" for="a{{ $loop->index }}">
                                <div class="cb-box"></div>
                                <span class="cb-label">{{ $name }}</span>
                                <span class="cb-count">{{ $currency }} {{ number_format($data['min_price']) }}</span>
                            </label>
                        </div>
                        @empty
                        <div class="small text-muted p-2">No airlines found</div>
                        @endforelse
                    </div>
                </div>
            </div>

            @php
                $totalPassengers = $adults + $children; 
            @endphp

            <!-- Results -->
            <div class="col-lg-9">
                <!-- Quick Filters Bar (Horizontal) -->
                <div class="quick-filters-bar shadow-sm">
                    <div class="fw-800 text-muted x-small me-2 text-uppercase" style="letter-spacing: 1px;">Quick Filters:</div>
                    <div class="quick-filter-pill" onclick="toggleQuickFilter('pf1', this)">
                        <i class="fas fa-plane-arrival"></i> Non Stop
                    </div>
                    <div class="quick-filter-pill" onclick="toggleQuickFilter('pf2', this)">
                        <i class="fas fa-clock"></i> Morning
                    </div>
                    <div class="quick-filter-pill" onclick="toggleQuickFilter('pf3', this)">
                        <i class="fas fa-undo"></i> Refundable
                    </div>
                    <div class="quick-filter-pill" onclick="toggleQuickFilter('s1', this)">
                        <i class="fas fa-stopwatch"></i> 1 Stop
                    </div>
                </div>

                <!-- Dynamic Fare Calendar (Interactive) -->
                <div class="fare-calendar-v5 mb-4 shadow-sm">
                    <div class="d-flex align-items-center">
                        <button class="cal-nav-btn left" onclick="scrollCalendar(-200)"><i class="fas fa-chevron-left"></i></button>
                        <div class="cal-scroll-wrapper d-flex align-items-center flex-grow-1 overflow-auto no-scrollbar" id="fareCalendarScroll">
                            @php
                                $sliderDaysRaw = $meta['calendar'] ?? [];
                                $sliderDays = [];
                                
                                // Generate 10 days window around travel date
                                for($d = -3; $d <= 6; $d++) {
                                    $dateObj = \Carbon\Carbon::parse($travelDate)->addDays($d);
                                    $dateStr = $dateObj->format('Y-m-d');
                                    $isActive = ($dateStr == \Carbon\Carbon::parse($travelDate)->format('Y-m-d'));
                                    
                                    // Try to get price from calendar meta
                                    $calPrice = 0;
                                    if (isset($sliderDaysRaw[$dateStr])) {
                                        $calPrice = is_array($sliderDaysRaw[$dateStr]) ? ($sliderDaysRaw[$dateStr]['value'] ?? 0) : $sliderDaysRaw[$dateStr];
                                    }

                                    // Apply Markup to calendar price (approx 7-10% to match listing)
                                    if ($calPrice > 0) {
                                        $calPrice = $calPrice * 1.08; 
                                    }

                                    // For ACTIVE day, ALWAYS use the real cheapest price from current results
                                    if ($isActive) {
                                        $price = $cheapest['price'] ?? ($calPrice > 0 ? $calPrice : $minPrice);
                                    } else {
                                        $price = $calPrice > 0 ? $calPrice : (($cheapest['price'] ?? 5000) + rand(-200, 800));
                                    }

                                    $sliderDays[] = [
                                        'date' => $dateStr,
                                        'price' => $price
                                    ];
                                }
                            @endphp

                            @foreach($sliderDays as $day)
                                @php
                                    $dayDate = \Carbon\Carbon::parse($day['date']);
                                    $isActive = ($dayDate->format('Y-m-d') == \Carbon\Carbon::parse($travelDate)->format('Y-m-d'));
                                @endphp
                                <div class="cal-day-card {{ $isActive ? 'active' : '' }}" onclick="updateSearchDate('{{ $day['date'] }}')" style="min-width:105px; cursor:pointer;">
                                    <div class="day-text">{{ $dayDate->format('D, M d') }}</div>
                                    <div class="price-text">{{ $currency }} {{ number_format($day['price']) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <button class="cal-nav-btn right" onclick="scrollCalendar(200)"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="bank-selection-banner mb-2 shadow-sm rounded-4 overflow-hidden" style="background:#fff; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center">
                        <button class="cal-nav-btn left border-end" onclick="scrollBankOffers(-200)" style="min-height:50px; width:35px;"><i class="fas fa-chevron-left"></i></button>
                        
                        <div class="bank-scroll-container d-flex align-items-center gap-2 overflow-auto no-scrollbar px-2 py-2 flex-grow-1" id="bankOfferScroll">
                            <div class="bank-pill active" onclick="applyBankFilter('all', this)" id="bankAll" data-bank="all">
                                <div class="fw-800 x-small">ALL FLIGHTS</div>
                            </div>
                            @foreach($bankOffers as $offer)
                            <div class="bank-pill" onclick="applyBankFilter('{{ $offer->bank_name }}', this)" data-bank="{{ $offer->bank_name }}">
                                @if($offer->logo)
                                    <img src="{{ $offer->logo }}" style="width:20px; height:20px; object-fit:contain;" onerror="this.style.display='none'">
                                @else
                                    <div class="bg-light rounded p-1" style="width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:900;color:{{ $offer->color_code }};">{{ substr($offer->bank_name, 0, 1) }}</div>
                                @endif
                                <div class="d-flex flex-column">
                                    <span class="fw-800 x-small text-navy" style="line-height:1;">{{ $offer->display_name }}</span>
                                    <span class="text-muted fw-700 mt-1" style="font-size:8px; line-height:1;">{{ $offer->tagline }}</span>
                                </div>
                                <div class="offer-dot animate-pulse" style="width:5px; height:5px; background:{{ $offer->color_code }}; border-radius:50%; margin-left:5px;"></div>
                            </div>
                            @endforeach
                        </div>

                        <button class="cal-nav-btn right border-start" onclick="scrollBankOffers(200)" style="min-height:50px; width:35px;"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <!-- Descriptive Bank Promo Banner (Appears on Selection) -->
                <div id="bankPromoBanner" class="alert alert-info border-0 rounded-4 p-3 mb-4 d-none" style="background: #eef2ff; border: 1px solid #e0e7ff !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div id="promoBankLogo" class="bg-white rounded-3 p-2 shadow-sm" style="width:50px; height:50px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-university text-primary"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <span id="promoCodeBadge" class="badge bg-navy fw-900" style="font-size:10px; letter-spacing:1px;">PROMOCODE</span>
                                <h6 id="promoBankTitle" class="mb-0 fw-900 text-navy" style="font-size:14px;">BANK NAME</h6>
                            </div>
                            <p id="promoBankTagline" class="mb-0 text-muted fw-700 mt-1" style="font-size:13px;">Get up to Rs.5000 OFF via Bank Card only.</p>
                        </div>
                    </div>
                </div>

                <!-- Group Booking Notice -->
                @if($isGroupBooking)
                    <div class="alert alert-primary border-0 shadow-sm rounded-4 p-4 mb-4 d-flex align-items-center gap-4" style="background:linear-gradient(135deg, #1e40af, #3b82f6); color:#fff;">
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-users-viewfinder fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="fw-800 mb-1">Group Booking Active ({{ $totalPassengers }} Passengers)</h5>
                            <p class="mb-0 opacity-90 small">Special group fares are not publicly displayed. Select {{ $isRoundTrip ? 'both onward and return flights' : ($isMultiCity ? 'all segments' : 'a flight') }} to request a personalized quote.</p>
                        </div>
                    </div>
                @endif

                @if($isMultiCity || $isRoundTrip)
                    <!-- Segmented Stepper (MMT Style) -->
                    <div class="mc-stepper-mmt shadow-sm">
                        <div class="row g-0">
                            @php
                                $totalSegs = $isMultiCity ? ($numSegments ?? 0) : 2;
                                $origins = $isMultiCity ? ($multiCityOrigins ?? []) : [request('origin'), request('destination')];
                                $dests = $isMultiCity ? ($multiCityDestinations ?? []) : [request('destination'), request('origin')];
                                $dates = $isMultiCity ? ($multiCityDates ?? []) : [$travelDate, $returnDate];
                            @endphp
                            @for($i = 0; $i < $totalSegs; $i++)
                                <div class="col mc-step-tab {{ $i == 0 ? 'active' : '' }}" onclick="switchMultiCityLeg({{ $i }})" id="mc-tab-{{ $i }}">
                                    <div class="p-3 text-center border-end h-100 position-relative">
                                        <div class="mc-leg-route fw-bold">
                                            @if($isRoundTrip)
                                                {{ $i == 0 ? 'Onward' : 'Return' }} ({{ $origins[$i] }} - {{ $dests[$i] }})
                                            @else
                                                {{ $origins[$i] }} - {{ $dests[$i] }}
                                            @endif
                                        </div>
                                        <div class="mc-leg-info small text-muted">{{ \Carbon\Carbon::parse($dates[$i] ?? now())->format('D, d M') }}</div>
                                        <div class="mc-leg-time small fw-bold text-primary mt-1 d-none" id="mc-tab-time-{{ $i }}">--:-- → --:--</div>
                                        <div class="mc-status-icon d-none" id="mc-check-{{ $i }}"><i class="fas fa-check-circle text-success"></i></div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div id="multiCityResults" class="mt-4">
                        @for($i = 0; $i < $totalSegs; $i++)
                            <div class="mc-leg-container {{ $i == 0 ? '' : 'd-none' }}" id="mc-leg-{{ $i }}">
                                <div class="px-2 mb-3">
                                    <h6 class="fw-bold mb-0">
                                        @if($isRoundTrip)
                                            {{ $i == 0 ? 'Select Onward Flight' : 'Select Return Flight' }}
                                        @else
                                            Select Flight for {{ $origins[$i] }} to {{ $dests[$i] }}
                                        @endif
                                    </h6>
                                    <span class="small text-muted">{{ \Carbon\Carbon::parse($dates[$i] ?? now())->format('l, d M Y') }}</span>
                                </div>
                                <div class="leg-results" style="min-height:300px;">
                                    {{-- Multi-city legs will be populated dynamically from API results --}}
                                    @forelse($flights as $idx => $f)
                                        @if(($f['segment_index'] ?? 0) == $i)
                                            @php
                                                $depAtMC = $f['departure_at'] ?? now()->format('Y-m-d\TH:i:00\Z');
                                                $arrAtMC = $f['arrival_at'] ?? now()->addHours(2)->format('Y-m-d\TH:i:00\Z');
                                                $isBestMC = ($idx === 0);
                                            @endphp
                                            <div class="flight-row" 
                                                 data-airline="{{ $f['airline_name'] }}" 
                                                 data-price="{{ $f['price'] ?? 0 }}" 
                                                 data-stops="{{ $f['stops'] ?? 0 }}"
                                                 data-duration-minutes="{{ (\Carbon\Carbon::parse($depAtMC)->diffInMinutes(\Carbon\Carbon::parse($arrAtMC))) }}"
                                                 data-departure-stamp="{{ \Carbon\Carbon::parse($depAtMC)->timestamp }}"
                                                 data-cabin="{{ strtoupper($f['cabin'] ?? 'ECONOMY') }}"
                                                 data-refundable="{{ ($f['is_refundable'] ?? false) ? '1' : '0' }}">
                                                <x-listing-card 
                                                    type="flight" 
                                                    :title="$f['airline_name']" 
                                                    :subtitle="($f['airline_code'] ?? 'UNK') . ' ' . ($f['flight_number'] ?? '001')" 
                                                    :price="($f['price'] ?? 0)" 
                                                    :leg="'mc-'.$i" 
                                                    :currency="$currency" 
                                                    :depCity="$f['departure_city'] ?? '???'"
                                                    :arrCity="$f['arrival_city'] ?? '???'"
                                                    :depTime="\Carbon\Carbon::parse($depAtMC)->format('H:i')"
                                                    :arrTime="\Carbon\Carbon::parse($arrAtMC)->format('H:i')"
                                                    :duration="$f['duration'] ?? '00h 00m'"
                                                    :stops="$f['stops'] ?? 0"
                                                    :baggage="$f['baggage'] . $f['baggage_unit']"
                                                    :f="$f" 
                                                    :is-best="$f['is_cheapest']"
                                                />
                                            </div>
                                        @endif
                                    @empty
                                        <div class="p-5 text-center text-muted">No flights found for this leg.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- Unified Bottom Summary Bar -->
                    <div class="mc-bottom-bar-v2 shadow-lg" id="mcBottomBar">
                        <div class="container h-100">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                <div class="d-flex align-items-center flex-grow-1 overflow-auto h-100 py-2">
                                    @for($i = 0; $i < $totalSegs; $i++)
                                        <div class="mc-bar-item d-flex align-items-center gap-3 px-3 {{ $i == 0 ? 'active-leg' : '' }}" 
                                             id="mc-bar-item-{{ $i }}" 
                                             onclick="switchMultiCityLeg({{ $i }})"
                                             style="cursor:pointer; border-right: 1px solid rgba(255,255,255,0.08); min-width: 200px;">
                                            <div class="mc-airline-circle bg-white p-1 rounded flex-shrink-0" id="mc-bar-logo-{{ $i }}" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                                                <i class="fas fa-plane-departure text-primary" style="font-size:18px;"></i>
                                            </div>
                                            <div class="lh-sm">
                                                <div class="text-white-50 uppercase fw-800" style="font-size: 10px; letter-spacing: 0.5px;">{{ $i == 0 ? 'ONWARD' : 'RETURN' }}</div>
                                                <div class="text-white fw-900" style="font-size: 16px;">{{ $origins[$i] }} <i class="fas fa-long-arrow-alt-right mx-1 opacity-50"></i> {{ $dests[$i] }}</div>
                                                <div class="badge bg-primary bg-opacity-25 text-primary mt-1" id="mc-bar-info-{{ $i }}" style="font-size: 12px; font-weight: 800; background: rgba(37, 99, 235, 0.4) !important; color: #fff !important;">₹ ----</div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                
                                <div class="d-flex align-items-center gap-4 ps-4 border-start border-white-10">
                                    <div class="text-end" style="min-width:140px;">
                                        <div class="text-white-50 small fw-bold" style="font-size:11px; letter-spacing: 0.5px;">{{ $isGroupBooking ? 'Itinerary Selection' : 'Total Trip Cost' }}</div>
                                        <div class="text-white fw-900 fs-3 lh-1" id="mcTotalDisplay">{{ $isGroupBooking ? 'GROUP' : $currency . '0' }}</div>
                                        <div class="mt-1" style="font-size:11px; color:#00a8e1; cursor:pointer; font-weight:700;">Flight Details <i class="fas fa-chevron-up ms-1" style="font-size:9px;"></i></div>
                                    </div>
                                    <button class="btn rounded-pill px-4 fw-900 shadow-sm d-flex align-items-center justify-content-center gap-2" id="mcNextBtn" onclick="proceedToNextLeg()" style="background: linear-gradient(90deg, #3bb2fb 0%, #2563eb 100%); height:52px; font-size:16px; min-width:190px; border:none; color:white; transition: 0.3s;">
                                        <span>{{ $isGroupBooking ? 'SELECT ALL SEGMENTS' : 'NEXT FLIGHT' }}</span>
                                        <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    
                    <!-- Slice Pay Banner (Listing Page) -->
                    <div class="alert mt-0 mb-4 p-3 rounded-4 d-flex align-items-center justify-content-between border-0 shadow-sm" style="background-color: #f7fbff; border-radius: 12px; cursor: pointer; border: 1px solid rgba(86,168,255,0.2) !important;">
                        <div>
                            <div class="fw-bold mb-1 d-flex align-items-center gap-2" style="font-size: 15px; color: #1a202c; letter-spacing: -0.2px;">
                                <img src="/img/slice-logo.svg" alt="Slice Logo" style="height: 24px; object-fit: contain;">
                                <span style="font-size: 15px; font-weight: 700;">Pay in 12 instalments</span>
                            </div>
                            <div class="text-muted" style="font-size: 13px; font-weight: 600;">Lock in today's price. No fees.</div>
                        </div>
                        <div class="ms-auto flex-shrink-0">
                            <img src="/img/slice-logo.svg" alt="Slice Logo" style="height: 30px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                        </div>
                    </div>
                    <div class="results-bar d-flex align-items-center justify-content-between px-4 py-3 rounded-4 mb-4" style="background: #fff; border: 1.5px solid #f1f5f9; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                        <div class="d-flex align-items-baseline gap-2">
                            <h5 class="fw-900 mb-0 text-navy" style="font-size:18px;">{{ count($flights) }} Flights Found</h5>
                            <span style="font-size:11px;color:var(--gray-400);font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">
                                for 
                                @php
                                    $o = request('origin'); if(is_array($o)) $o = $o[0] ?? 'DEL';
                                    $d = request('destination'); if(is_array($d)) $d = $d[0] ?? 'BOM';
                                @endphp
                                {{ $o }} to {{ $d }}
                            </span>
                        </div>
                        <div class="d-none d-md-flex align-items-center gap-3">
                            <span class="badge bg-success bg-opacity-10 text-success fw-800 rounded-pill px-3 py-2" style="font-size:10px;">BEST PRICE GUARANTEE</span>
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm rounded-pill px-3 border-opacity-50 text-navy fw-800" style="font-size:11px;" data-bs-toggle="dropdown">
                                    SORT BY: <span class="text-primary">CHEAPEST</span> <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                                <ul class="dropdown-menu shadow border-0 rounded-4">
                                    <li><a class="dropdown-item fw-700 small" href="#" onclick="event.preventDefault(); sortByFilter('price')">Price (Lowest)</a></li>
                                    <li><a class="dropdown-item fw-700 small" href="#" onclick="event.preventDefault(); sortByFilter('duration')">Duration (Shortest)</a></li>
                                    <li><a class="dropdown-item fw-700 small" href="#" onclick="event.preventDefault(); sortByFilter('departure')">Departure Time</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fare Monitoring Banner (Public / B2C) -->
                    <div class="alert mt-0 mb-4 rounded-4 border border-primary text-navy d-flex align-items-center cursor-pointer shadow-sm position-relative overflow-hidden" 
                         style="background: #f0f7ff;" 
                         data-bs-toggle="modal" 
                         data-bs-target="#fareMonitorAlarmModal">
                         <div class="position-absolute" style="top:-20%; right:-5%; opacity:0.05; transform: rotate(15deg);">
                             <i class="fas fa-bullseye" style="font-size: 15rem;"></i>
                         </div>
                        <div class="bg-white rounded-circle p-2 me-3 shadow-sm d-flex justify-content-center align-items-center flex-shrink-0" id="pulseBellIconTop" style="width: 45px; height: 45px;">
                            <i class="fas fa-bell text-primary fs-5 animate-pulse"></i>
                        </div>
                        <div>
                            <h6 class="fw-900 mb-1" style="font-size:15px;">Fares too high or looking for a specific budget?</h6>
                            <p class="mb-0 small fw-bold text-muted" style="line-height:1.2;">Good news! If you skip this fare, we can keep tracking prices and instantly notify you when a cheaper ticket becomes available due to cancellations or rebookings.</p>
                        </div>
                        <div class="ms-auto ps-4 flex-shrink-0 z-index-1">
                            <button class="btn btn-primary fw-900 rounded-pill px-4 shadow-sm" style="font-size:13px; letter-spacing:0.5px;">TRACK FARE <i class="fas fa-arrow-right ms-1"></i></button>
                        </div>
                    </div>

                    <div class="results-list" id="resultsList" style="min-height: 500px; scroll-margin-top: 100px;">
                        @if($error_message)
                            <div class="col-12 text-center py-5">
                                @if($isBudgetError ?? false)
                                    <div class="bg-white p-4 rounded-4 shadow-sm border mx-auto" style="max-width: 500px;">
                                        <i class="fas fa-wallet fa-3x mb-3 text-primary opacity-50"></i>
                                        <h5 class="fw-800 text-navy">Budget Constraint</h5>
                                        <p class="text-muted small mb-4">{{ $error_message }}</p>
                                        <button class="btn btn-outline-primary rounded-pill px-4 fw-800" onclick="switchFlightMode('date', document.querySelector('.m-mode-btn'))">
                                            VIEW ALL FLIGHTS
                                        </button>
                                    </div>
                                @else
                                    <i class="fas fa-search fa-3x mb-3 text-muted opacity-25"></i>
                                    <h5 class="fw-800 text-navy">No Flights Found</h5>
                                    <p class="text-muted small px-5">{{ $error_message }}</p>
                                @endif
                                <hr class="mx-auto my-4 opacity-10" style="width:200px;">
                                <p class="small fw-700 text-primary cursor-pointer" onclick="location.reload()"><i class="fas fa-sync-alt me-1"></i> TRY SEARCH AGAIN</p>
                            </div>
                        @else
                            @forelse($flights as $index => $f)
                            @php
                                $airCode = $f['airline_code'] ?? ($f['airline'] ?? '6E');
                                $airName = $f['airline'] ?? ($airlineNames[$airCode] ?? $airCode);
                                $depAt = $f['departure_at'] ?? now()->addDays(7)->format('Y-m-d\TH:i:00\Z');
                                $arrAt = $f['arrival_at'] ?? now()->addDays(7)->addHours(2)->format('Y-m-d\TH:i:00\Z');
                                
                                $depTime = \Carbon\Carbon::parse($depAt)->format('H:i');
                                $arrTime = \Carbon\Carbon::parse($arrAt)->format('H:i');
                                
                                $formatDur = $f['duration'] ?? '2h 0m';

                                $logoUrl = "https://imgak.mmtcdn.com/flights/assets/media/dt/common/icons/{$airCode}.png";
                            @endphp
                            @php $isBest = ($index === 0); @endphp
                            <div class="flight-row {{ $isBest ? 'best-price-flight' : '' }}" 
                                 data-airline="{{ $f['airline_name'] }}" 
                                 data-price="{{ $f['price'] }}" 
                                 data-is-best="{{ $f['is_cheapest'] ? '1' : '0' }}"
                                 data-stops="{{ $f['stops'] ?? 0 }}"
                                 data-duration-minutes="{{ (\Carbon\Carbon::parse($depAt)->diffInMinutes(\Carbon\Carbon::parse($arrAt))) }}"
                                 data-departure-stamp="{{ \Carbon\Carbon::parse($depAt)->timestamp }}"
                                 data-cabin="{{ strtoupper($f['cabin'] ?? 'ECONOMY') }}"
                                 data-refundable="{{ ($f['is_refundable'] ?? false) ? '1' : '0' }}">
                                
                                <x-listing-card 
                                    type="flight" 
                                    :title="$f['airline_name']" 
                                    subtitle="{{ $f['airline_code'] }}-{{ $f['flight_number'] }}" 
                                    price="{{ number_format($f['price']) }}" 
                                    leg="onward" 
                                    :dep-city="$f['departure_city']" 
                                    :arr-city="$f['arrival_city']"
                                    :dep-time="$depTime"
                                    :arr-time="$arrTime"
                                    :duration="$f['duration']"
                                    :stops="$f['stops'] ?? 0"
                                    :image="$logoUrl"
                                    :baggage="$f['baggage'] . $f['baggage_unit']"
                                    :terminal="$f['terminal']"
                                    :is-refundable="$f['is_refundable'] ?? false"
                                    :currency="$currency"
                                    :f="$f"
                                    :is-best="$f['is_cheapest']"
                                />
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <div class="p-4 rounded-circle bg-light d-inline-flex mb-4 opacity-50">
                                    <i class="fas fa-plane-slash fa-3x text-muted"></i>
                                </div>
                                <h5 class="fw-800 text-muted">No Flights Found</h5>
                                <p class="text-muted small px-5">We couldn't find any flights for the selected route or date on Amadeus Sandbox. Try searching for major routes like <strong>DEL → BOM</strong> or <strong>DEL → BLR</strong> on closer dates.</p>
                                <button class="btn btn-primary rounded-pill px-4 fw-800 mt-3 shadow-lg" onclick="location.href='/flights'">
                                    <i class="fas fa-search me-2"></i> NEW SEARCH
                                </button>
                            </div>
                            @endforelse
                        @endif
                    </div>

                    <div id="loadMoreContainer" class="text-center mt-4" style="display: none;">
                        <button class="btn btn-outline-primary rounded-pill px-5 fw-900 shadow-sm" onclick="loadMoreFlights()" style="border-width:2px; height:50px; font-size:14px;">
                            <i class="fas fa-plus-circle me-2"></i> LOAD MORE FLIGHTS
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Group Booking Sidebar -->
    <div id="groupBookingSidebar" class="group-booking-sidebar">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-800 text-white">Group Booking Request</h5>
                <button type="button" class="btn-close btn-close-white" onclick="closeGroupBookingSidebar()"></button>
            </div>
            <p class="mb-0 text-white opacity-75 small mt-2">Special rates for 10+ passengers</p>
        </div>
        
        <div class="sidebar-content">
            <div id="selectedFlightsContainer" class="mb-4">
                <!-- Flight details will be injected here by JS -->
            </div>

            <div id="noFlightSelected" class="text-center py-4 text-muted">
                <i class="fas fa-plane-departure fa-3x mb-3 opacity-20"></i>
                <p>Select your flight(s) to continue</p>
            </div>

            <form id="groupBookingForm">
                @csrf
                <input type="hidden" name="airline" id="form-airline">
                <input type="hidden" name="flight_number" id="form-flight-number">
                <input type="hidden" name="departure" id="form-departure">
                <input type="hidden" name="arrival" id="form-arrival">
                <input type="hidden" name="date" id="form-date" value="{{ $travelDate }}">
                <input type="hidden" name="class" id="form-class" value="{{ $cabinClass }}">

                <div class="mb-3">
                    <label class="form-label fw-700 small text-navy">Full Name</label>
                    <input type="text" name="name" class="form-control rounded-3" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-700 small text-navy">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-3" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-700 small text-navy">Phone Number</label>
                    <input type="tel" name="phone" class="form-control rounded-3" placeholder="Enter your phone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-700 small text-navy">Number of Passengers</label>
                    <input type="number" name="passengers" class="form-control rounded-3" value="{{ $totalPassengers }}" min="10" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-700 small text-navy">Remarks (Optional)</label>
                    <textarea name="remarks" class="form-control rounded-3" rows="3" placeholder="Any special requests?"></textarea>
                </div>

                <div class="alert alert-info py-2 px-3 small border-0 mb-4" style="background:rgba(var(--primary-rgb), 0.05); color:var(--primary);">
                    <i class="fas fa-info-circle me-2"></i> Our team will contact you within 24 hours with best fares.
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-800 rounded-pill shadow-lg" id="submitBtn">
                    SUBMIT GROUP REQUEST
                </button>
            </form>
        </div>
    </div>
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeGroupBookingSidebar()"></div>

    <!-- Multiple Flight Selection Badge -->
    <div id="selectionBadge" class="selection-badge-floating d-none">
        <div class="d-flex align-items-center gap-3">
            <div class="selection-count-circle">0</div>
            <div class="fw-800 text-white">Flights Selected</div>
            <button class="btn btn-light btn-sm rounded-pill fw-800 px-3" onclick="openGroupBookingSidebar()">REQUEST ALL</button>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .bank-selection-banner {
        background: #fff; border-radius: 20px; border: 1.5px solid #f1f5f9; padding: 25px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    .bank-scroll-container::-webkit-scrollbar { height: 4px; }
    .bank-scroll-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    
    .bank-pill {
        display: flex; align-items: center; gap: 10px; padding: 12px 20px;
        background: #fff; border: 1.5px solid #f1f5f9; border-radius: 50px;
        white-space: nowrap; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 140px; justify-content: center;
    }
    .bank-pill:hover { border-color: var(--primary); transform: translateY(-2px); }
    .bank-pill.active { border-color: var(--primary); background: rgba(var(--primary-rgb), 0.05); box-shadow: 0 8px 20px rgba(var(--primary-rgb), 0.1); }
    
    .bank-dot { width: 8px; height: 8px; background: var(--primary); border-radius: 10px; display: inline-block; }
    
    .price-display { transition: all 0.4s ease; display: inline-block; }

    /* Group Booking Sidebar Styles */
    .group-booking-sidebar {
        position: fixed; top: 0; left: -450px; width: 450px; height: 100%;
        background: #fff; z-index: 2000; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 20px 0 50px rgba(0,0,0,0.15); display: flex; flex-direction: column;
    }
    .group-booking-sidebar.active { left: 0; }
    
    .sidebar-header { background: #1e40af; padding: 25px; }
    .sidebar-content { padding: 25px; overflow-y: auto; flex: 1; }
    
    .sidebar-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); z-index: 1999; display: none; backdrop-filter: blur(4px);
    }
    .sidebar-overlay.active { display: block; }

    /* Selection Radio Styles */
    .selection-control { display:flex; align-items:center; justify-content:flex-end; height:100%; }
    .selection-radio { 
        width: 22px; height: 22px; border: 2px solid #cbd5e1; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .group-booking-selectable.active .selection-radio { border-color: var(--primary); }
    .radio-inner { width: 12px; height: 12px; border-radius: 50%; background: var(--primary); transform: scale(0); transition: all 0.2s; }
    .group-booking-selectable.active .radio-inner { transform: scale(1); }
    .group-booking-selectable.active { border-color: var(--primary); background: rgba(37,99,235,0.02); }

    .cinematic-timeline.slim { height:2px; margin: 8px 0; }
    .cinematic-timeline.slim .timeline-dot { width:6px; height:6px; }
    .cinematic-timeline.slim .timeline-line { height:1px; }

    /* Disable filter cursor */
    .filter-group-v4 input[disabled] + label { cursor: not-allowed; opacity: 0.6; }

    /* Authentic MMT Floating Bottom Bar & Stepper Replica */
    .mc-stepper-mmt { 
        background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;
        position: sticky; top: 90px; z-index: 999; margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .mc-step-tab { cursor: pointer; transition: all 0.3s; background: #fff; border-right: 1px solid #eee; position: relative; }
    .mc-step-tab:last-child { border-right: none; }
    .mc-step-tab:hover { background: #f8faff; }
    .mc-step-tab.active { background: #fff; box-shadow: inset 0 -4px 0 #2563eb; }
    .mc-step-tab.active .mc-leg-route { color: #2563eb; }
    .mc-step-tab.completed { background: #f0f7ff; }
    .mc-status-icon { position: absolute; top: 10px; right: 10px; font-size: 14px; color: #10b981; }

    .mc-bottom-bar-v2 {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        max-width: 1100px;
        background: #0b1522;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        z-index: 9999;
        display: none;
        padding: 0 30px;
        height: 90px;
        border: 1px solid rgba(255,255,255,0.1);
        align-items: center;
        backdrop-filter: blur(10px);
    }
    
    .is-multi-city .mc-bottom-bar-v2 { display: flex !important; }
    .multi-city-wrapper { padding-bottom: 140px !important; }
    
    .mc-bar-item { min-width: 220px; transition: all 0.3s; height: 100%; display: flex; align-items: center; padding: 0 20px; border-radius: 12px; margin: 0 8px; }
    .mc-bar-item.active-leg { background: rgba(37, 99, 235, 0.25); border: 1.5px solid rgba(37, 99, 235, 0.5); }
    .mc-airline-circle { width: 40px; height: 40px; background: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; }
    .border-white-10 { border-color: rgba(255,255,255,0.1) !important; }
    
    #mcNextBtn { padding: 0 35px; border-radius: 50px; height: 55px; font-weight: 900; }
    #mcNextBtn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3); }

    .mc-selected-time-badge { background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 800; display: inline-block; margin-top: 4px; }

    /* Fare Calendar V5 */
    .fare-calendar-v5 { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; position: relative; }
    .cal-nav-btn { width: 44px; height: 100%; min-height: 80px; border: none; background: #fff; color: var(--primary); transition: 0.3s; z-index: 5; }
    .cal-nav-btn:hover { background: #f8faff; }
    .cal-nav-btn.left { border-right: 1px solid #eee; }
    .cal-nav-btn.right { border-left: 1px solid #eee; }
    
    .cal-scroll-wrapper { scrollbar-width: none; -ms-overflow-style: none; }
    .cal-scroll-wrapper::-webkit-scrollbar { display: none; }
    
    .cal-day-card { 
        min-width: 140px; padding: 18px 10px; text-align: center; border-right: 1px solid #f1f5f9;
        cursor: pointer; transition: all 0.2s ease;
    }
    .cal-day-card:hover { background: #f8fbff; }
    .cal-day-card.active { background: #fff; box-shadow: inset 0 -3px 0 0 #2563eb; }
    .cal-day-card.active .day-text { color: #2563eb; font-weight: 800; }
    .cal-day-card.active .price-text { color: #2563eb; font-weight: 900; }
    
    .day-text { font-size: 11px; font-weight: 800; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .price-text { font-size: 16px; font-weight: 900; color: #1e293b; }
    
    .modify-search-btn:hover { background: rgba(255,255,255,0.15) !important; transform: translateY(-1px); }
    
    /* Animation for low seat count */
    @keyframes pulse-red {
        0% { opacity: 1; }
        50% { opacity: 0.6; }
        100% { opacity: 1; }
    }
    .animate-pulse { animation: pulse-red 2s infinite; }

    /* GDS Style Dropdown */
    .gds-menu {
        border-radius: 4px !important;
        overflow: hidden;
        animation: gdsFadeIn 0.2s ease-out;
    }
    @keyframes gdsFadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .gds-item {
        color: #000 !important;
        transition: none !important;
    }
    .gds-item:hover {
        background-color: #ffeb3b !important; /* Authentic GDS Yellow */
        color: #000 !important;
    }

    /* Show Dropdown on Hover */
    .dropdown:hover > .dropdown-menu {
        display: block !important;
        margin-top: 0;
    }
    .dropdown > .dropdown-menu {
        margin-top: 10px; /* Offset to bridge gap */
        display: none;
    }
    /* Multi-Class Selected Bar */
    .split-booking-bar {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 900px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        z-index: 1060;
        padding: 15px 25px;
        border: 1px solid var(--primary);
        display: none;
        animation: slideUp 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .split-cart-item {
        background: #f8fafc;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
    }
    .gds-grid-item {
        transition: all 0.2s ease;
    }
    .gds-grid-item:hover {
        background: #fef9c3; /* GDS Yellow */
        border-color: #fde047 !important;
        transform: scale(1.05);
        z-index: 2;
    }
    .gds-grid-item.selected {
        background: #2563eb !important;
        color: #fff !important;
        border-color: #1d4ed8 !important;
    }

    /* Fix Overflows for Dropdowns */
    .result-card, .listing-card-v4 {
        overflow: visible !important;
        position: relative !important;
    }
    .col-lg-9, .col-lg-3 {
        overflow: visible !important;
    }
    .row.g-4 {
        overflow: visible !important;
    }
    .result-card:hover {
        z-index: 1050 !important;
    }

    /* Auto-Dropup for Last Cards */
    .result-card:nth-last-child(-n+3) .dropdown-menu {
        bottom: 110% !important;
        top: auto !important;
    }

    .bank-offer-active {
        border: 2px solid #22c55e !important;
        position: relative;
    }
    .result-card.active {
        border-color: #2563eb !important;
        background: #f0f7ff !important;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1) !important;
    }
    .result-card.active::after {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 20px;
        right: 20px;
        color: #2563eb;
        font-size: 24px;
        background: #fff;
        border-radius: 50%;
        line-height: 1;
    }

    /* Multi-City Specific UI */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .mmt-mc-row { animation: fadeInDown 0.3s ease-out; }
    .remove-mc-btn { transition: all 0.2s ease; cursor: pointer; color: #64748b; }
    .remove-mc-btn:hover { color: #dc3545 !important; transform: scale(1.2); }
    
    .autocomplete-results { max-height: 350px; overflow-y: auto; box-shadow: 0 15px 45px rgba(0,0,0,0.15) !important; z-index: 100000 !important; }
    .mmt-ac-item { padding: 12px 15px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: background 0.2s; border-bottom: 1px solid #f1f5f9; }
    .mmt-ac-item:hover { background: #f0f7ff; }
    .mmt-ac-box { background: #eef2f6; color: #1e40af; font-weight: 900; padding: 4px 8px; border-radius: 4px; font-size: 11px; min-width: 45px; text-align: center; }
    .mmt-ac-city { color: #001d3d; font-weight: 800; font-size: 14px; }
    .mmt-ac-airport { color: #64748b; font-size: 11px; }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate__fadeInDown { animation: fadeInDown 0.4s ease-out; }

    /* Tab-Style Navigation Overrides */
    .misty-radio-listing, .m-mode-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 700;
        font-size: 13px;
        color: rgba(255,255,255,0.7);
        padding: 8px 20px;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
        border: none !important;
        white-space: nowrap;
    }
    .misty-radio-listing:hover, .m-mode-btn:hover { 
        color: #fff; 
        background: rgba(255,255,255,0.05);
    }
    .misty-radio-listing input { display: none; }
    
    .misty-radio-listing:has(input:checked), .m-mode-btn.active {
        background: #fff !important;
        color: #0056ff !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transform: none !important;
    }
    .m-mode-btn.active i { color: #0056ff; opacity: 1; }
    .misty-radio-listing .m-radio-dot { display: none; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const isRoundTrip = {{ $isRoundTrip ? 'true' : 'false' }};
    const isMultiCity = {{ $isMultiCity ? 'true' : 'false' }};
    const isGroupBooking = {{ $isGroupBooking ? 'true' : 'false' }};
    let currentFlightMode = '{{ request('max_budget') ? 'budget' : 'date' }}';
    const mcNumSegments = isMultiCity ? {{ $numSegments ?? 0 }} : (isRoundTrip ? 2 : 0);
    const totalTravelers = {{ $adults + $children }};
    let splitCart = JSON.parse(localStorage.getItem('splitCart')) || [];
    let selectedMCFlights = [];
    let selectedOnward = null;
    let selectedReturn = null;

    // Reset splitCart if it's a fresh search (optional logic)
    if(window.location.search.includes('reset_cart=1')) {
        splitCart = [];
        localStorage.removeItem('splitCart');
    }

    window.startSplitBooking = function(classCode, seats, leg, price, airline) {
        // Calculate currently selected
        const currentlySelectedCount = splitCart.reduce((sum, item) => sum + item.seats, 0);
        
        if (currentlySelectedCount + seats > totalTravelers) {
            Swal.fire({
                title: 'Exceeds Travelers',
                text: `You only need seats for ${totalTravelers - currentlySelectedCount} more passengers.`,
                icon: 'warning'
            });
            return;
        }

        // Add to cart
        splitCart.push({
            id: Date.now(),
            class: classCode,
            seats: seats,
            leg: leg,
            price: parseFloat(price.replace(/[^0-9.]/g, '')),
            airline: airline
        });

        localStorage.setItem('splitCart', JSON.stringify(splitCart));
        updateSplitUI();
        updateGDSGridHighlights();
        
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: `Added ${seats} seats in ${classCode} class`,
            showConfirmButton: false,
            timer: 2000
        });
    }

    function updateSplitUI() {
        const bar = document.getElementById('splitBookingBar');
        if(!bar) return;

        const count = splitCart.reduce((sum, item) => sum + item.seats, 0);
        const totalPrice = splitCart.reduce((sum, item) => sum + (item.price * item.seats), 0);
        const remaining = totalTravelers - count;

        if (splitCart.length > 0) {
            bar.style.display = 'block';
            document.getElementById('splitCartItems').innerHTML = splitCart.map(item => `
                <div class="split-cart-item d-flex align-items-center gap-2">
                    <span class="text-primary">${item.airline}</span>
                    <span class="badge bg-navy px-2">${item.seats}${item.class}</span>
                    <i class="fas fa-times text-danger ms-1 cursor-pointer" onclick="removeFromSplit(${item.id})"></i>
                </div>
            `).join('');

            document.getElementById('splitRemainingCount').innerText = remaining;
            document.getElementById('splitTotalPrice').innerText = '₹' + totalPrice.toLocaleString('en-IN');

            const btn = document.getElementById('splitBookBtn');
            if (remaining === 0) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-primary');
                btn.innerHTML = 'BOOK ALL PASSENGERS <i class="fas fa-arrow-right ms-2"></i>';
            } else {
                btn.classList.add('btn-outline-primary');
                btn.classList.remove('btn-primary');
                btn.innerHTML = `NEXT: SELECT ${remaining} MORE`;
            }
        } else {
            bar.style.display = 'none';
        }
    }

    function updateGDSGridHighlights() {
        document.querySelectorAll('.gds-grid-item').forEach(item => {
            const onclickText = item.getAttribute('onclick');
            // Extract params from onclick="startSplitBooking('Y', 9, 'onward', '4250', 'Indigo')"
            const match = onclickText.match(/'([^']+)',\s*(\d+),\s*'([^']+)'/);
            if (match) {
                const classCode = match[1];
                const seats = parseInt(match[2]);
                const leg = match[3];

                const isSelected = splitCart.some(c => c.class === classCode && c.seats === seats && c.leg === leg);
                if (isSelected) item.classList.add('selected');
                else item.classList.remove('selected');
            }
        });
    }

    window.removeFromSplit = function(id) {
        splitCart = splitCart.filter(item => item.id !== id);
        localStorage.setItem('splitCart', JSON.stringify(splitCart));
        updateSplitUI();
        updateGDSGridHighlights();
    }

    window.proceedToDetails = function() {
        const remaining = totalTravelers - splitCart.reduce((sum, item) => sum + item.seats, 0);
        if (remaining > 0) {
            Swal.fire({
                title: 'Remaining Passengers',
                text: `Please select seats for the remaining ${remaining} travelers first.`,
                icon: 'info'
            });
            return;
        }

        // Redirect to booking page with full cart
        console.log("Proceeding with:", splitCart);
        window.location.href = '/checkout?mode=multi-class&cart=' + encodeURIComponent(JSON.stringify(splitCart));
    }

    // Initial UI check
    document.addEventListener('DOMContentLoaded', () => {
        updateSplitUI();
        updateGDSGridHighlights();
        
        // --- Comparison Feature Onboarding ---
        setTimeout(() => {
            const firstResult = document.querySelector('.custom-checkbox-compare');
            if (firstResult) {
                // Add a pulse effect to the first checkbox
                firstResult.classList.add('feature-pulse-spotlight');
                
                // Show a floating intro message near the first checkbox
                const introTip = document.createElement('div');
                introTip.className = 'compare-intro-tip animate__animated animate__fadeInRight';
                introTip.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <div class="tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <div class="fw-900 fs-12 mb-0">NEW: FLIGHT COMPARISON</div>
                            <div class="fs-10 opacity-75 fw-700">Select any 2-3 flights to compare Wine, WiFi & Meals!</div>
                        </div>
                        <button class="btn-close btn-close-white ms-2" style="font-size:8px;" onclick="this.parentElement.parentElement.remove()"></button>
                    </div>
                `;
                firstResult.appendChild(introTip);
                
                // Auto-remove pulse after first interaction
                firstResult.addEventListener('click', () => {
                    firstResult.classList.remove('feature-pulse-spotlight');
                    introTip.remove();
                }, { once: true });
                
                // Auto-remove intro tip after 8 seconds
                setTimeout(() => introTip.remove(), 8000);
            }
        }, 1500);
    });

    function switchMultiCityLeg(index) {
        console.log("Switching to Segment:", index + 1);
        
        // Update Top Stepper Tabs
        document.querySelectorAll('.mc-step-tab').forEach(t => t.classList.remove('active'));
        const activeTab = document.getElementById(`mc-tab-${index}`);
        if(activeTab) activeTab.classList.add('active');
        
        // Update Results Legend Containers
        document.querySelectorAll('.mc-leg-container').forEach(c => c.classList.add('d-none'));
        const activeLeg = document.getElementById(`mc-leg-${index}`);
        if(activeLeg) activeLeg.classList.remove('d-none');

        // Update Bottom Bar Item Highlight (MMT Style)
        document.querySelectorAll('.mc-bar-item').forEach(i => i.classList.remove('active-leg'));
        const activeBarItem = document.getElementById(`mc-bar-item-${index}`);
        if(activeBarItem) activeBarItem.classList.add('active-leg');

        // Initial UI Update for existing segments
        updateMCTotal();
        
        // Refresh filters for the new active leg
        if(typeof runMasterFilters === 'function') runMasterFilters();
        if(typeof showInitialBatch === 'function') showInitialBatch();

        // Scroll to results start for the selected leg
        const listingHero = document.querySelector('.listing-hero');
        const scrollTarget = (listingHero ? listingHero.offsetHeight : 200) + 50;
        window.scrollTo({ top: scrollTarget, behavior: 'smooth' });
    }

    window.selectGroupFlight = function(el, leg, isManualSelect = true) {
        if (leg.startsWith('mc-')) {
            const index = parseInt(leg.split('-')[1]);
            
            // Extract data from attributes for reliability
            const price = parseInt(el.getAttribute('data-price')) || 0;
            const airline = el.getAttribute('data-airline') || 'Airline';
            const depTime = el.querySelector('.dep-time') ? el.querySelector('.dep-time').innerText : '10:00';
            const arrTime = el.querySelector('.arr-time') ? el.querySelector('.arr-time').innerText : '12:00';
            
            selectedMCFlights[index] = {
                airline: airline,
                price: price,
                details: {
                    airline: airline,
                    flight_number: el.querySelector('.text-muted.fw-700.uppercase') ? el.querySelector('.text-muted.fw-700.uppercase').innerText : '000',
                    dep_time: depTime,
                    dep_city: el.getAttribute('data-dep-city') || '???',
                    arr_time: arrTime,
                    arr_city: el.getAttribute('data-arr-city') || '???',
                    price: price,
                    duration: el.getAttribute('data-duration') || '0h 0m',
                    date: el.getAttribute('data-date') || (index == 0 ? '{{ $travelDate }}' : '{{ $returnDate }}')
                }
            };
            
            // 1. Update Top Stepper Tab Visuals
            const tab = document.getElementById(`mc-tab-${index}`);
            if(tab) {
                tab.classList.add('completed');
                const check = document.getElementById(`mc-check-${index}`);
                if(check) check.classList.remove('d-none');
                const timeEl = document.getElementById(`mc-tab-time-${index}`);
                if(timeEl) {
                    timeEl.innerText = `${depTime} → ${arrTime}`;
                    timeEl.classList.remove('d-none');
                    timeEl.classList.add('mc-selected-time-badge');
                }
            }

            // 2. Update Bottom Bar Segment
            const infoEl = document.getElementById(`mc-bar-info-${index}`);
            if(infoEl) {
                if (isGroupBooking) {
                    infoEl.innerText = "SELECTED";
                    infoEl.classList.replace('text-white-50', 'text-white');
                } else {
                    infoEl.innerText = `₹${price.toLocaleString()}`;
                    infoEl.classList.replace('text-white-50', 'text-white');
                }
            }
            const logoEl = document.getElementById(`mc-bar-logo-${index}`);
            if(logoEl) logoEl.innerHTML = `<i class="fas fa-plane text-navy"></i>`;

            // 3. Toggle Selection & Highlight Results Card
            const legCtx = document.getElementById(`mc-leg-${index}`);
            if(legCtx) {
                const alreadyActive = el.classList.contains('active');
                legCtx.querySelectorAll('.result-card').forEach(card => card.classList.remove('active'));
                
                if (alreadyActive) {
                    selectedMCFlights[index] = null;
                    // Reset Top Stepper Tab Visuals
                    const tab = document.getElementById(`mc-tab-${index}`);
                    if(tab) {
                        tab.classList.remove('completed');
                        const check = document.getElementById(`mc-check-${index}`);
                        if(check) check.classList.add('d-none');
                        const timeEl = document.getElementById(`mc-tab-time-${index}`);
                        if(timeEl) {
                            timeEl.innerText = "--:-- → --:--";
                            timeEl.classList.remove('mc-selected-time-badge');
                        }
                    }
                    // Reset Bottom Bar Segment
                    const infoEl = document.getElementById(`mc-bar-info-${index}`);
                    if(infoEl) {
                        infoEl.innerText = "₹ ----";
                        infoEl.classList.replace('text-white', 'text-white-50');
                    }
                } else {
                    el.classList.add('active');
                    // Selection data handled above...
                }
            }

            updateMCTotal();
            updateSidebarUI();
            openSidebarOnFirstSelect();

            if (isManualSelect && !alreadyActive && index < mcNumSegments - 1) {
                // Only auto-advance if we are picking a flight for an empty segment
                const wasEmpty = !selectedMCFlights[index] || (typeof selectedMCFlights[index] === 'object' && Object.keys(selectedMCFlights[index]).length === 0);
                if (wasEmpty || isManualSelect) {
                    setTimeout(() => switchMultiCityLeg(index + 1), 800);
                }
            }
        } else {
            // Standard flow for One-Way or Round-Trip
            const containerSelector = (leg === 'onward') ? '.onward-results-container' : '.return-results-container';
            const ctx = el.closest(containerSelector) || el.parentElement;
            
            ctx.querySelectorAll('.result-card').forEach(card => card.classList.remove('active'));
            el.classList.add('active');

            const flightData = {
                airline: el.querySelector('.airline-name').innerText,
                flight_number: el.querySelector('.flight-number').innerText,
                dep_time: el.querySelector('.dep-time').innerText,
                dep_city: el.querySelector('.dep-city').innerText,
                arr_time: el.querySelector('.arr-time').innerText,
                arr_city: el.querySelector('.arr-city').innerText,
                duration: el.querySelector('.duration').innerText,
                date: leg === 'onward' ? '{{ $travelDate }}' : '{{ $returnDate }}'
            };

            if (leg === 'onward') selectedOnward = flightData;
            else selectedReturn = flightData;

            updateSidebarUI();
            
            // Handle Selection Badge Feedback
            const badge = document.getElementById('selectionBadge');
            if (badge) {
                let selectedCount = 0;
                if (selectedOnward) selectedCount++;
                if (selectedReturn) selectedCount++;

                const countCircle = badge.querySelector('.selection-count-circle');
                const textLabel = badge.querySelector('.fw-800.text-white');
                const actionBtn = badge.querySelector('button');

                if (countCircle) countCircle.innerText = selectedCount;
                
                if (isRoundTrip) {
                    if (selectedCount === 1) {
                        textLabel.innerText = "1 flight selected. Select your return flight.";
                        actionBtn.classList.add('d-none');
                    } else if (selectedCount === 2) {
                        textLabel.innerText = "Both flights selected!";
                        actionBtn.innerText = "PROCEED TO REQUEST";
                        actionBtn.classList.remove('d-none');
                    }
                } else {
                    textLabel.innerText = "Flight selected!";
                    actionBtn.innerText = "PROCEED TO REQUEST";
                    actionBtn.classList.remove('d-none');
                }
                
                badge.classList.remove('d-none');
            }

            // Auto-open only when fully complete
            let shouldOpen = false;
            if (isRoundTrip) {
                if (selectedOnward && selectedReturn) shouldOpen = true;
            } else {
                shouldOpen = true;
            }

            if(shouldOpen && isManualSelect) {
                setTimeout(() => openGroupBookingSidebar(), 500);
            }
        }
    }

    // Auto-open sidebar on first selection for Multi-City or Round-Trip
    function openSidebarOnFirstSelect() {
        if (!isGroupBooking) return;
        if (isMultiCity || isRoundTrip) {
            openGroupBookingSidebar();
        }
    }

    function autoSelectFirstFlights() {
        if (!(isMultiCity || isRoundTrip) || isGroupBooking) return;
        console.log("Auto-selecting first flights for split view...");
        for(let i=0; i<mcNumSegments; i++) {
            const legEl = document.getElementById(`mc-leg-${i}`);
            if (legEl) {
                const firstCard = legEl.querySelector('.result-card');
                if (firstCard) {
                    window.selectGroupFlight(firstCard, `mc-${i}`, false);
                }
            }
        }
        // Always start with Onward leg (index 0)
        switchMultiCityLeg(0);
    }

    function updateMCTotal() {
        let total = 0;
        let count = 0;
        selectedMCFlights.forEach(f => { if(f) { total += f.price; count++; } });
        const totalDisplay = document.getElementById('mcTotalDisplay');
        if(totalDisplay) {
            if (isGroupBooking) {
                totalDisplay.innerText = `${count}/${mcNumSegments} DONE`;
                totalDisplay.style.fontSize = '22px';
            } else {
                totalDisplay.innerText = `₹${total.toLocaleString()}`;
            }
        }
        
        const nextBtn = document.getElementById('mcNextBtn');
        if (count === mcNumSegments) {
            if(nextBtn) {
                nextBtn.classList.add('btn-success');
                nextBtn.innerHTML = isGroupBooking ? 'PROCEED TO REQUEST <i class="fas fa-check-circle"></i>' : 'PROCEED TO BOOKING <i class="fas fa-arrow-right"></i>';
            }
        } else {
            if(nextBtn) {
                nextBtn.innerHTML = isGroupBooking ? `NEXT SEGMENT (${count}/${mcNumSegments}) <i class="fas fa-arrow-right"></i>` : 'NEXT FLIGHT <i class="fas fa-chevron-right"></i>';
            }
        }
    }

    function proceedToNextLeg() {
        console.log("Proceeding to Next Leg...");
        
        let currentActive = 0;
        document.querySelectorAll('.mc-leg-container').forEach((c, idx) => {
            if(!c.classList.contains('d-none')) currentActive = idx;
        });

        if (currentActive < mcNumSegments - 1) {
            switchMultiCityLeg(currentActive + 1);
            return;
        }

        let nextIncomplete = -1;
        for(let i=0; i<mcNumSegments; i++) {
            if(!selectedMCFlights[i]) {
                nextIncomplete = i;
                break;
            }
        }

        if (nextIncomplete !== -1) {
            switchMultiCityLeg(nextIncomplete);
        } else {
            // All segments completed
            if (isGroupBooking) {
                openGroupBookingSidebar();
            } else {
                Swal.fire({
                    title: 'Processing Itinerary...',
                    text: 'Preparing your booking...',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const flightsData = selectedMCFlights.map(f => f.details);
                
                fetch('/checkout/init-split', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ flights: JSON.stringify(flightsData) })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        Swal.fire('Error', data.message || 'Failed to initialize checkout', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                });
            }
        }
    }

    function toggleFlightDetails() {
        // Expand bottom bar details or trigger sidebar
        openGroupBookingSidebar();
    }

    function updateSidebarUI() {
        const container = document.getElementById('selectedFlightsContainer');
        const noSelection = document.getElementById('noFlightSelected');
        if (!container) return;
        container.innerHTML = '';
        
        if (isMultiCity || isRoundTrip) {
            let hasAny = false;
            // Check if any flight is selected
            for(let i=0; i<mcNumSegments; i++) {
                if(selectedMCFlights[i]) { hasAny = true; break; }
            }

            if (hasAny) {
                if(noSelection) noSelection.classList.add('d-none');
                // Always show all segments if at least one is selected
                for (let i = 0; i < mcNumSegments; i++) {
                    const flight = selectedMCFlights[i];
                    if (flight) {
                        container.innerHTML += createFlightSummaryHTML(flight.details, `FLIGHT ${i+1}`);
                    } else {
                        // Show placeholder for unselected segments
                        container.innerHTML += `
                            <div class="mb-3 p-3 rounded-3 bg-light border shadow-sm" style="border-left: 4px solid #cbd5e1 !important; opacity: 0.6;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-secondary text-white x-small">FLIGHT ${i+1}</span>
                                    <span class="x-small fw-700 text-muted italic">NOT SELECTED</span>
                                </div>
                                <div class="text-center py-1">
                                    <i class="fas fa-plane-arrival opacity-20 me-2"></i>
                                    <span class="small fw-800 text-muted">Awaiting Selection...</span>
                                </div>
                            </div>
                        `;
                    }
                }
            } else {
                if(noSelection) noSelection.classList.remove('d-none');
            }
        } else {
            if (!selectedOnward && !selectedReturn) {
                if(noSelection) noSelection.classList.remove('d-none');
                return;
            }
            if(noSelection) noSelection.classList.add('d-none');
            if (selectedOnward) container.innerHTML += createFlightSummaryHTML(selectedOnward, 'ONWARD');
            if (selectedReturn) container.innerHTML += createFlightSummaryHTML(selectedReturn, 'RETURN');
        }
    }

    function createFlightSummaryHTML(data, label) {
        return `
            <div class="mb-3 p-3 rounded-3 bg-white border shadow-sm" style="border-left: 4px solid #2563eb !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary text-white x-small">${label}</span>
                    <span class="fw-800 text-navy small">${data.airline}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center px-1">
                    <div class="text-center">
                        <div class="fw-900 fs-5">${data.dep_time}</div>
                        <div class="x-small fw-700 text-muted">${data.dep_city}</div>
                    </div>
                    <div class="flex-grow-1 mx-3 border-top border-dashed opacity-25"></div>
                    <div class="text-center">
                        <div class="fw-900 fs-5">${data.arr_time}</div>
                        <div class="x-small fw-700 text-muted">${data.arr_city}</div>
                    </div>
                </div>
            </div>
        `;
    }

    function openGroupBookingSidebar() {
        document.getElementById('groupBookingSidebar').classList.add('active');
        document.getElementById('sidebarOverlay').classList.add('active');
    }

    function closeGroupBookingSidebar() {
        document.getElementById('groupBookingSidebar').classList.remove('active');
        document.getElementById('sidebarOverlay').classList.remove('active');
    }

    const groupForm = document.getElementById('groupBookingForm');
    if (groupForm) {
        groupForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';

            const formData = new FormData(this);
            if (isMultiCity || isRoundTrip) formData.append('multi_city_details', JSON.stringify(selectedMCFlights));
            else {
                formData.append('onward_details', JSON.stringify(selectedOnward));
            }

            try {
                const response = await fetch('/flights/group-booking', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    closeGroupBookingSidebar();
                    Swal.fire({ title: 'Request Sent!', text: 'Our experts will contact you with group discounts.', icon: 'success' });
                    this.reset();
                    updateSidebarUI();
                }
            } catch (error) {
                Swal.fire('Error', 'Submission failed.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'SUBMIT GROUP REQUEST';
            }
        });
    }
    // Bank Offer Filter Logic
    function applyBankFilter(bank, el) {
        // Update UI Visuals
        document.querySelectorAll('.bank-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');

        console.log("Filtering by Bank:", bank);
        
        // In a real app, this would refresh results or filter DOM
        // For visual demo, we'll pulse the listing cards
        const results = document.querySelectorAll('.result-card');
        results.forEach(res => {
            res.style.opacity = '0.3';
            setTimeout(() => {
                res.style.opacity = '1';
                // Randomly highlight some as 'Best for this bank'
                if(Math.random() > 0.6 && bank !== 'all') {
                    res.classList.add('border-primary');
                } else {
                    res.classList.remove('border-primary');
                }
            }, 300);
        });
    }

    // Fare Calendar Logic
    window.selectCalendarDate = function(el, date) {
        document.querySelectorAll('.cal-day-card').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        
        const url = new URL(window.location.href);
        url.searchParams.set('departure_date', date);
        
        Swal.fire({
            title: 'Searching...',
            text: 'Fetching flights for ' + date,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        window.location.href = url.toString();
    }

    // Global scroll calendar logic removed in favor of inline onclick attributes
    if (isMultiCity || isRoundTrip) {
        document.body.classList.add('is-multi-city');
        const bar = document.getElementById('mcBottomBar');
        if(bar) bar.style.display = 'flex';
        // Auto-select only if it's NOT a group booking
        if (!isGroupBooking) {
            setTimeout(() => autoSelectFirstFlights(), 500);
        }
    }

    // Master Flight Filter Controller
    document.addEventListener('DOMContentLoaded', () => {
        const filterSidebar = document.querySelector('.filter-card-v4');
        if (!filterSidebar) return;

        // Quick Filter Syncing Logic
        window.toggleQuickFilter = function(sidebarId, pillEl) {
            const sidebarCb = document.getElementById(sidebarId);
            if (sidebarCb) {
                sidebarCb.checked = !sidebarCb.checked;
                // Trigger change event to fire runMasterFilters
                sidebarCb.dispatchEvent(new Event('change', { bubbles: true }));
                
                // Sync pill UI
                if (sidebarCb.checked) pillEl.classList.add('active');
                else pillEl.classList.remove('active');
            }
        };

        // Sync Sidebar to Pills on load or change
        function syncSidebarToPills() {
            const mapping = { 'pf1': 'Non Stop', 'pf2': 'Morning', 'pf3': 'Refundable', 's1': '1 Stop' };
            Object.keys(mapping).forEach(id => {
                const cb = document.getElementById(id);
                const pills = document.querySelectorAll('.quick-filter-pill');
                pills.forEach(p => {
                    if (p.innerText.includes(mapping[id])) {
                        if (cb && cb.checked) p.classList.add('active');
                        else p.classList.remove('active');
                    }
                });
            });
        }
        
        // Add to runMasterFilters or as separate observer
        const originalRunMasterFilters = window.runMasterFilters;
        window.runMasterFilters = function() {
            if (typeof originalRunMasterFilters === 'function') originalRunMasterFilters();
            syncSidebarToPills();
        };

        const mainPriceRange = document.querySelector('.custom-range');
        const countDisplay = document.querySelector('.results-bar h5');
        
        // Checkbox Mirroring (Non-Stop sync)
        const pf1 = document.getElementById('pf1');
        const s0 = document.getElementById('s0');
        
        const syncCheckboxes = (el1, el2) => {
            if (!el1 || !el2) return;
            el1.addEventListener('change', () => { el2.checked = el1.checked; runMasterFilters(); });
            el2.addEventListener('change', () => { el1.checked = el2.checked; runMasterFilters(); });
        };
        syncCheckboxes(pf1, s0);

        // Bind events to remaining filters
        if (mainPriceRange) {
            mainPriceRange.addEventListener('input', runMasterFilters);
            mainPriceRange.addEventListener('change', runMasterFilters);
        }
        
        const filtersToBind = [
            'pf2', 'pf3', 's1'
        ];
        filtersToBind.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', runMasterFilters);
        });

        document.querySelectorAll('input[data-airline-filter]').forEach(el => {
            el.addEventListener('change', runMasterFilters);
        });
        
        document.querySelectorAll('.filter-cabin').forEach(el => {
            el.addEventListener('change', runMasterFilters);
        });

        // Master Filter Execution (100% Dynamic - Step 4)
        function runMasterFilters() {
            console.log("Running Master Filters...");
            const maxPrice = parseInt(mainPriceRange ? mainPriceRange.value : 999999);
            
            const selectedAirlineCbs = document.querySelectorAll('input[data-airline-filter]:checked');
            const totalAirlineCbs = document.querySelectorAll('input[data-airline-filter]');
            
            // If some airline selected, filter. If none or all, show all.
            const filteringAirlines = (selectedAirlineCbs.length > 0 && selectedAirlineCbs.length < totalAirlineCbs.length);
            const selectedAirlineKeys = Array.from(selectedAirlineCbs).map(cb => cb.getAttribute('data-airline-filter').trim());

            console.log("Filtering Airlines?", filteringAirlines, "Keys:", selectedAirlineKeys);

            const selectedCabins = Array.from(document.querySelectorAll('.filter-cabin:checked'))
                .map(cb => cb.value.trim());

            const isNonStopChecked = (pf1 && pf1.checked) || (s0 && s0.checked);
            const isOneStopChecked = document.getElementById('s1') ? document.getElementById('s1').checked : false;
            const hasStopFilter = isNonStopChecked || isOneStopChecked;

            const morningOnly = document.getElementById('pf2') ? document.getElementById('pf2').checked : false;
            const refundableOnly = document.getElementById('pf3') ? document.getElementById('pf3').checked : false;

            const activeBank = document.querySelector('.bank-pill.active')?.innerText.split(' ')[0] || 'all';

            let displayedCount = 0;
            // IMPORTANT: Only count rows in the current active context (One-Way list or Active Leg)
            let flightRows = [];
            if (!isMultiCity && !isRoundTrip) {
                flightRows = document.querySelectorAll('#resultsList .flight-row');
            } else {
                // Find visible leg container
                const activeLeg = document.querySelector('.mc-leg-container:not(.d-none)');
                if (activeLeg) {
                    flightRows = activeLeg.querySelectorAll('.flight-row');
                } else {
                    flightRows = document.querySelectorAll('.flight-row');
                }
            }

            console.log("Master Filter - Rows to check:", flightRows.length);

            flightRows.forEach(row => {
                const rowPrice = parseInt(row.getAttribute('data-price')) || 0;
                const rowAirline = (row.getAttribute('data-airline') || "").trim();
                const rowStops = parseInt(row.getAttribute('data-stops')) || 0;
                const rowCabin = (row.getAttribute('data-cabin') || "").trim();
                const isRefundable = row.getAttribute('data-refundable') === '1';
                
                const rawTime = (row.querySelector('.dep-time')?.textContent || "00:00").trim();
                const rowHour = parseInt(rawTime.split(':')[0], 10);

                let visible = true;

                if (rowPrice > maxPrice) visible = false;
                
                if (filteringAirlines && !selectedAirlineKeys.includes(rowAirline)) {
                    visible = false;
                }

                if (selectedCabins.length > 0 && !selectedCabins.includes(rowCabin)) {
                    visible = false;
                }
                if (hasStopFilter) {
                    let stopOk = false;
                    if (isNonStopChecked && rowStops === 0) stopOk = true;
                    if (isOneStopChecked && rowStops === 1) stopOk = true;
                    if (!stopOk) visible = false;
                }
                // Safe parsing of rowHour
                if (morningOnly) {
                    const safeHour = parseInt(rowHour, 10);
                    if (isNaN(safeHour) || safeHour < 6 || safeHour >= 12) {
                        visible = false;
                    }
                }
                if (refundableOnly && !isRefundable) visible = false;

                // Bank filter visual integration
                if (activeBank !== 'all' && activeBank !== 'ALL' && visible) {
                    // Simulate that some flights have bank offers
                    const hasOffer = (rowAirline.length + rowPrice) % 3 === 0;
                    if (hasOffer) {
                        row.classList.add('bank-offer-active');
                    } else {
                        row.classList.remove('bank-offer-active');
                    }
                } else {
                    row.classList.remove('bank-offer-active');
                }

                row.style.display = visible ? 'block' : 'none';
                if (visible) displayedCount++;
            });

            if (countDisplay) countDisplay.textContent = `${displayedCount} Flights Found`;
            
            // Re-apply pagination logic
            showInitialBatch();
        }

        window.sortByFilter = function(criteria) {
            const resultsList = document.getElementById('resultsList');
            const rows = Array.from(resultsList.querySelectorAll('.flight-row'));
            
            rows.sort((a, b) => {
                let valA, valB;
                if (criteria === 'price') {
                    valA = parseInt(a.getAttribute('data-price'));
                    valB = parseInt(b.getAttribute('data-price'));
                } else if (criteria === 'duration') {
                    valA = parseInt(a.getAttribute('data-duration-minutes'));
                    valB = parseInt(b.getAttribute('data-duration-minutes'));
                } else if (criteria === 'departure') {
                    valA = parseInt(a.getAttribute('data-departure-stamp'));
                    valB = parseInt(b.getAttribute('data-departure-stamp'));
                }
                return valA - valB;
            });

            // Re-append sorted rows
            rows.forEach(row => resultsList.appendChild(row));
            
            // Update Sort Label
            const sortSpan = document.querySelector('.dropdown .text-primary');
            if (sortSpan) {
                sortSpan.textContent = criteria.toUpperCase();
            }

            // Reset Load More pagination
            currentVisibleCount = initialBatchSize;
            if(typeof showInitialBatch === 'function') {
                showInitialBatch();
            }
        };

        // Price Range Update Logic
        if (mainPriceRange) {
            mainPriceRange.addEventListener('input', function() {
                const label = document.getElementById('priceRangeLabel');
                if (label) label.textContent = `INR ${this.value}`;
            });
        }

        let currentVisibleCount = 15;
        const initialBatchSize = 15;

        function showInitialBatch() {
            // Get the specific list based on mode
            let rows;
            if (!isMultiCity && !isRoundTrip) {
                rows = document.querySelectorAll('#resultsList .flight-row');
            } else {
                const activeLeg = document.querySelector('.mc-leg-container:not(.d-none)');
                rows = activeLeg ? activeLeg.querySelectorAll('.flight-row') : document.querySelectorAll('.flight-row');
            }
            
            let shownInBatch = 0;
            
            rows.forEach((row, index) => {
                // If it's already hidden by filters, skip
                if (row.style.display === 'none') return;
                
                if (shownInBatch < currentVisibleCount) {
                    row.classList.remove('d-none');
                    shownInBatch++;
                } else {
                    row.classList.add('d-none');
                }
            });

            // Toggle Load More visibility
            const loadMoreBtn = document.getElementById('loadMoreContainer');
            if (loadMoreBtn) {
                const totalVisibleAfterFilter = Array.from(rows).filter(r => r.style.display !== 'none').length;
                loadMoreBtn.style.display = totalVisibleAfterFilter > currentVisibleCount ? 'block' : 'none';
            }
        }

        window.loadMoreFlights = function() {
            currentVisibleCount += initialBatchSize;
            showInitialBatch();
        };

        // Initialize Batching and Tooltips on load
        document.addEventListener('DOMContentLoaded', () => {
            runMasterFilters();
            showInitialBatch();
            
            // Init Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Sidebar Event Handlers (Step 4 - No Refresh)
        filterSidebar.addEventListener('input', (e) => {
            e.preventDefault();
            runMasterFilters();
        });
        filterSidebar.addEventListener('change', (e) => {
            e.preventDefault();
            runMasterFilters();
        });
        
        // Label Support with Event Capture Prevention
        document.querySelectorAll('.custom-cb').forEach(label => {
            label.addEventListener('click', (e) => {
                const target = e.target;
                if (target.tagName !== 'INPUT') {
                    // Logic already handled by checkbox change, just sync counts
                    setTimeout(runMasterFilters, 50);
                }
            });
        });

        // Date Slider Update Logic (Full Search)
        window.updateSearchDate = function(date) {
            Swal.fire({
                title: 'Searching...',
                text: 'Fetching best fares for ' + new Date(date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'}),
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            const url = new URL(window.location.href);
            url.searchParams.set('departure_date', date);
            window.location.href = url.toString();
        }

        // Bank Filter Logic — applies real discounts from DB-driven offers
        window.activeBankOffer = null;
        window.originalPrices  = {}; // store original prices keyed by flight-row id

        window.applyBankFilter = function(bank, el) {
            document.querySelectorAll('.bank-pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');

            // Find the offer object from server-injected bankOffers
            const offers = window.bankOffers || [];
            const offer  = bank === 'all' ? null : offers.find(o => o.bank_name === bank);
            window.activeBankOffer = offer || null;

            // Update promo banner
            const banner = document.getElementById('bankPromoBanner');
            if (offer && banner) {
                document.getElementById('promoBankTitle').innerText  = offer.display_name;
                document.getElementById('promoCodeBadge').innerText  = offer.promo_code || offer.bank_name;
                document.getElementById('promoBankTagline').innerText = offer.tagline || '';
                const logoEl = document.getElementById('promoBankLogo');
                if (offer.logo) {
                    logoEl.innerHTML = `<img src="${offer.logo}" style="width:36px;height:36px;object-fit:contain;">`;
                } else {
                    logoEl.innerHTML = `<span style="font-weight:900;font-size:16px;color:${offer.color_code}">${offer.bank_name.substring(0,2)}</span>`;
                }
                banner.style.border = `1px solid ${offer.color_code}50 !important`;
                banner.classList.remove('d-none');
            } else if (banner) {
                banner.classList.add('d-none');
            }

            // Apply / remove discount on all visible flight price elements
            const resultsList = document.getElementById('resultsList');
            if (!resultsList) return;

            resultsList.querySelectorAll('.flight-row').forEach(row => {
                const rowId = row.dataset.id || row.id;
                const rawPrice = parseInt(row.dataset.price) || 0;

                // Save original price once
                if (!window.originalPrices[rowId]) {
                    window.originalPrices[rowId] = rawPrice;
                }
                const base = window.originalPrices[rowId];

                // Calculate discounted price
                let discounted = base;
                if (offer && base >= (offer.min_amount || 0)) {
                    if (offer.discount_type === 'percentage') {
                        let disc = Math.floor(base * offer.discount_value / 100);
                        if (offer.max_discount) disc = Math.min(disc, offer.max_discount);
                        discounted = base - disc;
                    } else {
                        discounted = Math.max(0, base - offer.discount_value);
                    }
                }

                // Update the displayed price element inside the card
                const priceEl = row.querySelector('.flight-price-display, [data-price-display]');
                if (priceEl) {
                    if (discounted < base) {
                        priceEl.innerHTML = `
                            <span class="text-muted text-decoration-line-through small">₹${base.toLocaleString()}</span>
                            <span class="fw-900 text-success"> ₹${discounted.toLocaleString()}</span>
                            <span class="badge bg-success bg-opacity-10 text-success ms-1" style="font-size:9px;">${offer.discount_type === 'percentage' ? offer.discount_value + '% OFF' : '₹' + (base-discounted).toLocaleString() + ' OFF'}</span>`;
                    } else {
                        priceEl.innerHTML = `<span class="fw-900">₹${base.toLocaleString()}</span>`;
                    }
                }

                row.style.display = 'block';
                row.classList.remove('d-none');
            });
        };

        // Sort Logic (Dynamic Reordering)
        window.sortByFilter = function(criteria, el) {
            if(el) {
                document.querySelectorAll('.summary-card').forEach(c => c.classList.remove('active-summary-card'));
                el.classList.add('active-summary-card');
            }

            const resultsList = document.getElementById('resultsList');
            if (!resultsList) return;

            const items = Array.from(resultsList.querySelectorAll('.flight-row'));
            
            items.sort((a, b) => {
                let valA, valB;
                if (criteria === 'price' || criteria === 'cheapest' || criteria === 'recommended') {
                    valA = parseInt(a.getAttribute('data-price')) || 0;
                    valB = parseInt(b.getAttribute('data-price')) || 0;
                } else if (criteria === 'duration') {
                    valA = parseInt(a.getAttribute('data-duration-minutes')) || 0;
                    valB = parseInt(b.getAttribute('data-duration-minutes')) || 0;
                } else if (criteria === 'departure') {
                    valA = parseInt(a.getAttribute('data-departure-stamp')) || 0;
                    valB = parseInt(b.getAttribute('data-departure-stamp')) || 0;
                }
                return valA - valB;
            });

            // Append sorted items back
            items.forEach(item => resultsList.appendChild(item));

            // Update Label
            const sortLabel = document.querySelector('.results-bar .text-primary');
            if (sortLabel) {
                sortLabel.textContent = criteria.toUpperCase();
            }

            // Scroll to results top nicely
            resultsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Calendar Scrolling
        window.scrollCalendar = function(amount) {
            document.getElementById('fareCalendarScroll').scrollBy({ left: amount, behavior: 'smooth' });
        }

        window.scrollBankOffers = function(amount) {
            const container = document.getElementById('bankOfferScroll');
            if(container) {
                container.scrollBy({ left: amount, behavior: 'smooth' });
            }
        };

        window.selectCalendarDate = function(el, date) {
            const url = new URL(window.location.href);
            url.searchParams.set('departure_date', date);
            window.location.href = url.toString();
        }

        window.showFlightDetails = function(gdsId) {
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
                    
                    // 1. Prepare Itinerary (Journey) HTML
                    let itineraryHtml = '';
                    itineraries.forEach((it, itIdx) => {
                        const segments = it.segments || [];
                        if (segments.length === 0) return;

                        const firstSeg = segments[0];
                        const lastSeg = segments[segments.length - 1];
                        const depCity = (dict.locations && firstSeg.departure && dict.locations[firstSeg.departure.iataCode]) ? dict.locations[firstSeg.departure.iataCode].cityCode : (firstSeg.departure ? firstSeg.departure.iataCode : '???');
                        const arrCity = (dict.locations && lastSeg.arrival && dict.locations[lastSeg.arrival.iataCode]) ? dict.locations[lastSeg.arrival.iataCode].cityCode : (lastSeg.arrival ? lastSeg.arrival.iataCode : '???');
                        
                        itineraryHtml += `
                            <div class="p-3 border-bottom bg-light bg-opacity-25">
                                <div class="fw-900 text-navy mb-3" style="font-size:15px;">${depCity} to ${arrCity}, ${firstSeg.departure ? new Date(firstSeg.departure.at).toLocaleDateString('en-GB', {day:'2-digit', month:'short'}) : ''}</div>
                                ${segments.map((s, sIdx) => {
                                    const carrier = (dict.carriers && dict.carriers[s.carrierCode]) ? dict.carriers[s.carrierCode] : s.carrierCode;
                                    const depDate = s.departure ? new Date(s.departure.at) : null;
                                    const arrDate = s.arrival ? new Date(s.arrival.at) : null;
                                    
                                    const fare = (offer.travelerPricings && offer.travelerPricings[0] && offer.travelerPricings[0].fareDetailsBySegment) ? 
                                                 (offer.travelerPricings[0].fareDetailsBySegment[sIdx] || offer.travelerPricings[0].fareDetailsBySegment[0]) : {};
                                    
                                    const baggage = fare.includedCheckedBags ? (fare.includedCheckedBags.weight || fare.includedCheckedBags.quantity) + (fare.includedCheckedBags.weightUnit || ' Qty') : '15 KG';

                                    return `
                                        <div class="segment-row mb-4">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <div class="airline-dot" style="width:32px; height:32px; background:#fff; border:1px solid #eee; display:flex; align-items:center; justify-content:center; border-radius:6px; font-weight:900; color:#ff6b00; font-size:10px;">${s.carrierCode}</div>
                                                <div>
                                                    <div class="fw-900 text-navy small">${carrier} <span class="text-muted fw-700 mx-1">|</span> ${s.carrierCode}-${s.number}</div>
                                                    <div class="x-small text-muted fw-700">${fare.cabin || 'ECONOMY'} (${fare.class || 'Y'})</div>
                                                </div>
                                            </div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-3">
                                                    <div class="fw-900 fs-4 text-navy">${s.departure && s.departure.at ? (s.departure.at.includes('T') ? s.departure.at.split('T')[1].substring(0,5) : s.departure.at.split(' ')[1].substring(0,5)) : '--:--'}</div>
                                                    <div class="x-small fw-800 text-navy mt-1">${depDate ? depDate.toLocaleDateString('en-GB', {weekday:'short', day:'2-digit', month:'short', year:'2-digit'}) : ''}</div>
                                                    <div class="x-small text-muted mt-1 fw-700">Terminal ${s.departure ? (s.departure.terminal || 'T1') : 'T1'}</div>
                                                    <div class="x-small text-muted fw-800">${(dict.locations && s.departure) ? (dict.locations[s.departure.iataCode]?.cityCode || s.departure.iataCode) : (s.departure ? s.departure.iataCode : '???')}, India</div>
                                                </div>
                                                <div class="col-3 text-center px-2">
                                                    <div class="x-small text-muted fw-900 mb-1">${it.duration ? it.duration.replace('PT','').toLowerCase() : ''}</div>
                                                    <div style="height:2px; background:#26debd; position:relative; width:60%; margin:0 auto;"></div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="fw-900 fs-4 text-navy">${s.arrival && s.arrival.at ? (s.arrival.at.includes('T') ? s.arrival.at.split('T')[1].substring(0,5) : s.arrival.at.split(' ')[1].substring(0,5)) : '--:--'}</div>
                                                    <div class="x-small fw-800 text-navy mt-1">${arrDate ? arrDate.toLocaleDateString('en-GB', {weekday:'short', day:'2-digit', month:'short', year:'2-digit'}) : ''}</div>
                                                    <div class="x-small text-muted mt-1 fw-700">Terminal ${s.arrival ? (s.arrival.terminal || 'T1') : 'T1'}</div>
                                                    <div class="x-small text-muted fw-800">${(dict.locations && s.arrival) ? (dict.locations[s.arrival.iataCode]?.cityCode || s.arrival.iataCode) : (s.arrival ? s.arrival.iataCode : '???')}, India</div>
                                                </div>
                                                <div class="col-3 border-start ps-3">
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div class="fw-900" style="font-size:10px; color:#4a5568;">CHECK-IN BAGGAGE</div>
                                                            <div class="x-small fw-700 text-muted">${baggage}</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="fw-900" style="font-size:10px; color:#4a5568;">CABIN BAGGAGE</div>
                                                            <div class="x-small fw-700 text-muted">7 KG (1 PC)</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }).join('<hr class="my-4 opacity-10">')}
                            </div>
                        `;
                    });

                    // 2. Prepare Fare Summary HTML
                    const priceObj = offer.price || { base: 0, total: 0, currency: 'INR' };
                    const baseFare = parseFloat(priceObj.base || 0);
                    const totalFare = parseFloat(priceObj.total || 0);
                    const taxAndFees = totalFare - baseFare;
                    const currency = priceObj.currency;
                    const travelerCount = (offer.travelerPricings ? offer.travelerPricings.length : 1);

                    let fareSummaryHtml = `
                        <div class="p-3">
                            <h6 class="fw-900 text-navy mb-4">Fare Breakdown (${travelerCount} Traveler)</h6>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-muted fw-700">Base Fare</div>
                                <div class="fw-900 text-navy">${currency} ${baseFare.toLocaleString()}</div>
                            </div>
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <div class="text-muted fw-700">Surcharges & Taxes</div>
                                <div class="fw-900 text-navy">${currency} ${taxAndFees.toLocaleString()}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="fw-900 text-navy fs-5">Total Amount</div>
                                <div class="fw-900 text-primary fs-3">${currency} ${totalFare.toLocaleString()}</div>
                            </div>
                            <div class="mt-4 p-3 bg-light rounded-3">
                                <div class="x-small text-muted fw-700 italic"><i class="fas fa-info-circle me-1"></i> Note: All prices are in ${currency}. Final amount may include convenience fees at checkout.</div>
                            </div>
                        </div>
                    `;

                    // 3. Prepare Cancellation HTML
                    const refundable = (offer.pricingOptions && offer.pricingOptions.noRestrictionFare);
                    const firstFareBasis = (offer.travelerPricings && offer.travelerPricings[0] && offer.travelerPricings[0].fareDetailsBySegment && offer.travelerPricings[0].fareDetailsBySegment[0]) ? 
                                           offer.travelerPricings[0].fareDetailsBySegment[0].fareBasis : 'N/A';

                    let cancelHtml = `
                        <div class="p-4">
                            <div class="p-4 rounded-4 text-center ${refundable ? 'bg-success' : 'bg-danger'} bg-opacity-10 mb-4" style="border: 2px dashed ${refundable ? '#22c55e' : '#ef4444'};">
                                <i class="fas ${refundable ? 'fa-check-circle text-success' : 'fa-times-circle text-danger'} fs-1 mb-3"></i>
                                <h4 class="fw-900 ${refundable ? 'text-success' : 'text-danger'} mb-2">${refundable ? 'REFUNDABLE FARE' : 'NON-REFUNDABLE'}</h4>
                                <p class="text-muted fw-700 small mb-0">Fare Rules Basis: <strong>${firstFareBasis}</strong></p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3">
                                        <div class="fw-900 text-navy small mb-1">Cancellation Policy</div>
                                        <div class="x-small text-muted fw-700">${refundable ? 'Cancellation fees apply after booking. Refund processed within 7-10 working days.' : 'No refund of base fare on cancellation. Only taxes may be partially refundable.'}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3">
                                        <div class="fw-900 text-navy small mb-1">Date Change</div>
                                        <div class="x-small text-muted fw-700">Date changes allowed subject to airline penalty + fare difference. Corporate fee may apply.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    Swal.fire({
                        title: '',
                        html: `
                            <div class="text-start mmt-modal-wrapper overflow-hidden pb-4" style="font-family: 'Inter', sans-serif; background: #f4f7f9;">
                                <!-- Premium MMT Header Tabs -->
                                <div class="custom-modal-header d-flex align-items-center justify-content-between px-4" style="background: #0a223d; padding-top: 15px;">
                                    <div class="d-flex overflow-auto no-scrollbar">
                                        <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab active" id="tab-itinerary" onclick="switchDetailTab('itinerary')">FLIGHT DETAILS</div>
                                        <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab" id="tab-fare" onclick="switchDetailTab('fare')">FARE SUMMARY</div>
                                        <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab" id="tab-cancel" onclick="switchDetailTab('cancel')">CANCELLATION</div>
                                        <div class="px-4 py-3 fw-900 small cursor-pointer premium-tab" id="tab-date" onclick="switchDetailTab('date')">DATE CHANGE</div>
                                    </div>
                                </div>

                                <div class="px-3 mt-4" style="min-height:400px;">
                                    <!-- Itinerary Content -->
                                    <div id="content-itinerary" class="detail-content rounded-4 border-0 shadow-sm bg-white overflow-hidden animate__animated animate__fadeIn">
                                        <div class="p-3 border-bottom bg-light">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fw-900 text-navy fs-6">${(itineraries[0] && itineraries[0].segments && itineraries[0].segments[0]) ? itineraries[0].segments[0].departure.iataCode : '???'} → ${(itineraries[0] && itineraries[0].segments) ? itineraries[0].segments[itineraries[0].segments.length-1].arrival.iataCode : '???'}</div>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="x-small text-muted fw-bold font-monospace bg-white border px-2 py-1 rounded">ID: ${offer.id ? offer.id.substring(0,8) : 'N/A'}...</span>
                                                    <div class="badge bg-primary bg-opacity-10 text-primary fw-800">${itineraries.length > 1 ? 'Round Trip' : 'One Way'}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            ${itineraries.map((it, itIdx) => `
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
                                                                        <div class="fw-900 fs-4 text-navy lh-1">${(s.departure && s.departure.at) ? (s.departure.at.includes('T') ? s.departure.at.split('T')[1].substring(0,5) : s.departure.at.split(' ')[1].substring(0,5)) : '--:--'}</div>
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
                                                                        <div class="fw-900 fs-4 text-navy lh-1">${(s.arrival && s.arrival.at) ? (s.arrival.at.includes('T') ? s.arrival.at.split('T')[1].substring(0,5) : s.arrival.at.split(' ')[1].substring(0,5)) : '--:--'}</div>
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
                                            `).join('')}
                                        </div>
                                    </div>

                                    <!-- Fare Summary Content -->
                                    <div id="content-fare" class="detail-content d-none rounded-4 bg-white shadow-sm overflow-hidden animate__animated animate__fadeIn">
                                        <div class="p-4">
                                            <h5 class="fw-900 text-navy mb-4 fs-6">Fare Details</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted fw-700">Base Fare</td>
                                                            <td class="text-end fw-900 text-navy">${currency} ${baseFare.toLocaleString()}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-700">Taxes & Surcharges</td>
                                                            <td class="text-end fw-900 text-navy">${currency} ${taxAndFees.toLocaleString()}</td>
                                                        </tr>
                                                        <tr class="border-top">
                                                            <td class="fw-900 text-navy fs-5 pt-3">Total Fare</td>
                                                            <td class="text-end fw-900 text-primary fs-3 pt-3">${currency} ${totalFare.toLocaleString()}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="bg-warning bg-opacity-10 rounded-4 p-3 mt-4">
                                                <div class="small fw-800 text-warning-emphasis"><i class="fas fa-lightbulb me-2"></i> Traveler Hint</div>
                                                <div class="x-small text-muted fw-700 mt-1">This price includes all mandatory taxes. Final charges might slightly vary depending on selected payment gateway.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Policies Content -->
                                    <div id="content-cancel" class="detail-content d-none rounded-4 bg-white shadow-sm p-4 text-center animate__animated animate__fadeIn">
                                        <div class="p-4 rounded-circle bg-danger bg-opacity-10 d-inline-flex mb-3">
                                            <i class="fas fa-shield-alt text-danger fs-2"></i>
                                        </div>
                                        <h4 class="fw-900 text-navy fs-5">Cancellation Policy</h4>
                                        <p class="text-muted fw-700 mx-4 px-2 mb-3 x-small">Rules for fare basis <strong>${firstFareBasis}</strong></p>
                                        <div class="badge ${refundable ? 'bg-success' : 'bg-danger'} py-2 px-4 fs-6 rounded-pill mb-4">${refundable ? 'Refundable' : 'Non-Refundable'}</div>
                                        <hr class="my-4 mx-5 opacity-10">
                                        <div class="row text-start g-3">
                                            <div class="col-md-6 border-end">
                                                <div class="fw-900 x-small text-muted uppercase mb-2">TIME UNTIL DEPARTURE</div>
                                                <div class="fw-800 small">More than 72 hours</div>
                                                <div class="fw-800 small text-danger mt-1">Standard airline fee applies.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fw-900 x-small text-muted uppercase mb-2">TIME UNTIL DEPARTURE</div>
                                                <div class="fw-800 small">Less than 72 hours</div>
                                                <div class="fw-800 small text-danger mt-1">Non-Refundable (Taxes only).</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="content-date" class="detail-content d-none rounded-4 bg-white shadow-sm p-4 text-center animate__animated animate__fadeIn">
                                        <div class="p-4 rounded-circle bg-primary bg-opacity-10 d-inline-flex mb-3">
                                            <i class="fas fa-history text-primary fs-2"></i>
                                        </div>
                                        <h4 class="fw-900 text-navy fs-5">Date Change Policy</h4>
                                        <p class="text-muted fw-700 mx-4 px-2 mb-3 x-small">Modify your travel dates for flight <strong>${(itineraries[0] && itineraries[0].segments && itineraries[0].segments[0]) ? (itineraries[0].segments[0].carrierCode + '-' + itineraries[0].segments[0].number) : 'N/A'}</strong></p>
                                        <div class="bg-primary bg-opacity-5 p-3 px-5 rounded-pill d-inline-block border border-primary border-opacity-25 mb-4">
                                            <span class="fw-900 text-white"><i class="fas fa-check-circle me-2"></i> CHANGES ALLOWED</span>
                                        </div>
                                        <div class="small text-muted fw-700 px-5 mt-2">Subject to airline penalty and any difference in fare at the time of re-issuance.</div>
                                    </div>
                                </div>
                            </div>
                            <style>
                                .premium-tab { color: #8a99af; transition: 0.3s; border-bottom: 4px solid transparent; letter-spacing:0.8px; opacity: 0.8; white-space: nowrap; font-size: 11.5px !important; }
                                .premium-tab.active { color: #fff; border-bottom-color: #008cff; opacity: 1; }
                                .premium-tab:hover:not(.active) { color: #fff; opacity: 1; }
                                .last-child-no-margin:last-child { margin-bottom: 0 !important; }
                                .animate__animated { animation-duration: 0.4s; }
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

        window.selectFlightForCheckout = function(data) {
            console.log("Selecting flight for checkout:", data);
            
            if (window.activeBankOffer) {
                data.bankOffer = window.activeBankOffer;
            }
            
            // If it's a multi-segment itinerary (Round Trip or MC)
            if (isMultiCity || isRoundTrip) {
                const legIndex = data.leg.includes('-') ? data.leg.split('-')[1] : (data.leg === 'onward' ? 0 : 1);
                const container = document.getElementById(`mc-leg-${legIndex}`);
                
                // Try to find the physical card to trigger visual highlights
                let targetCard = null;
                if (container) {
                    const cards = container.querySelectorAll('.result-card');
                    cards.forEach(c => {
                        // More flexible matching for price and airline
                        const cPrice = c.getAttribute('data-price');
                        const cAirline = c.getAttribute('data-airline');
                        if (cPrice == data.price && (cAirline == data.airline || data.airline.includes(cAirline))) {
                            targetCard = c;
                        }
                    });
                }
                
                // If we found the card, use the existing selectGroupFlight for visuals
                if (targetCard) {
                    window.selectGroupFlight(targetCard, `mc-${legIndex}`);
                } else {
                    // Fallback: Manually update the state if card lookup failed
                    console.warn("Card lookup failed, updating state manually");
                    selectedMCFlights[legIndex] = {
                        airline: data.airline,
                        price: parseInt(data.price),
                        details: data
                    };
                    const infoEl = document.getElementById(`mc-bar-info-${legIndex}`);
                    if(infoEl) {
                        infoEl.innerText = `₹${parseInt(data.price).toLocaleString()}`;
                        infoEl.classList.replace('text-white-50', 'text-white');
                    }
                }
                
                // Auto-move to next leg for better UX
                setTimeout(() => proceedToNextLeg(), 300);
                return;
            }

            localStorage.setItem('selectedFlight', JSON.stringify(data));
            window.location.href = `/checkout?type=flight&id=${data.id}`;
        };

        // Run immediately on page load
        runMasterFilters();
    });
</script>

    @if(($adults + $children) > 9)
    <!-- Multi-Class Booking Summary Bar -->
    <div id="splitBookingBar" class="split-booking-bar" style="min-height: 80px; height: auto; max-width: 1100px;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
            <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width: 300px;">
                <div class="d-flex flex-column flex-grow-1">
                    <span class="text-uppercase fw-800 text-muted mb-1" style="font-size:10px; letter-spacing:1px;">Multi-Class Selection</span>
                    <div class="d-flex align-items-center gap-2 flex-wrap" id="splitCartItems">
                        <!-- Items will be injected here -->
                    </div>
                </div>
                <div class="border-start ps-3 d-flex flex-column" style="flex-shrink: 0; min-width: 90px;">
                    <span class="text-uppercase fw-800 text-muted" style="font-size:10px; letter-spacing:1px;">Remaining</span>
                    <div class="fw-900 text-danger" style="font-size:16px;"><span id="splitRemainingCount">0</span> <small style="font-size:9px;">Left</small></div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4 border-start ps-4" style="flex-shrink: 0;">
                <div class="text-end">
                    <span class="text-uppercase fw-800 text-muted" style="font-size:10px; letter-spacing:1px;">Total Fare</span>
                    <div class="fw-900 text-navy" style="font-size:22px;" id="splitTotalPrice">₹0</div>
                </div>
                <button id="splitBookBtn" class="btn btn-outline-primary rounded-pill px-4 fw-800 py-3 transition hvr-grow" style="min-width: 180px;" onclick="proceedToDetails()">
                    NEXT: SELECT MORE
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    // Header Scroll Effect
    window.addEventListener('scroll', function() {
        const hero = document.querySelector('.listing-hero');
        if (hero) {
            if (window.scrollY > 50) hero.classList.add('scrolled');
            else hero.classList.remove('scrolled');
        }
    });

    let mmtAdults = {{ $adults }};
    let mmtClass = '{{ $cabinClass }}';

    document.addEventListener('DOMContentLoaded', function() {
        console.log("MMT Ribbon Loaded. Initializing...");
        initMmtAutocomplete();
        initMmtDates();
        
        // Sync UI based on initial trip type
        const tripEl = document.getElementById('mmtTripType');
        if (tripEl) {
            updateSearchUIMode(tripEl.value);
            tripEl.addEventListener('change', (e) => updateSearchUIMode(e.target.value));
        }

        // Focus input on search-col click
        document.querySelectorAll('.search-col').forEach(col => {
            col.addEventListener('click', function(e) {
                const input = this.querySelector('input, select');
                if (input && e.target !== input && !e.target.closest('.autocomplete-results')) {
                    if (input.id === 'mmtDeparture' || input.id === 'mmtReturn') {
                        if (input._flatpickr) input._flatpickr.open();
                    } else {
                        input.focus();
                        if (input.classList.contains('autocomplete-input')) input.select();
                    }
                }
            });
        });
    });

    function updateSearchUIMode(value) {
        const standard = document.getElementById('mmtStandardFields');
        const multi = document.getElementById('mmtMultiCityFields');
        const returnCol = document.getElementById('mmtReturnCol');
        const returnInput = document.getElementById('mmtReturn');

        if (value === 'multicity') {
            if (standard) standard.classList.add('d-none');
            if (multi) {
                multi.classList.remove('d-none');
                multi.classList.add('d-flex');
                initMmtMultiCityDates();
                initMmtMultiCityAutocomplete();
            }
        } else {
            if (standard) standard.classList.remove('d-none');
            if (multi) {
                multi.classList.add('d-none');
                multi.classList.remove('d-flex');
            }
            if (returnCol && returnInput) {
                if (value === 'roundtrip') {
                    returnCol.style.opacity = '1';
                    returnInput.disabled = false;
                    returnCol.style.cursor = 'pointer';
                } else {
                    returnCol.style.opacity = '0.3';
                    returnInput.disabled = true;
                    returnCol.style.cursor = 'default';
                }
            }
        }
    }

    window.switchFlightMode = function(mode, el) {
        currentFlightMode = mode;
        document.querySelectorAll('.m-mode-btn').forEach(btn => btn.classList.remove('active'));
        el.classList.add('active');

        const budgetRow = document.getElementById('budgetModifierRow');
        const baggageRow = document.getElementById('baggageModifierRow');
        
        if (budgetRow) budgetRow.classList.add('d-none');
        if (baggageRow) baggageRow.classList.add('d-none');

        if (mode === 'budget' && budgetRow) {
            budgetRow.classList.remove('d-none');
        } else if (mode === 'baggage' && baggageRow) {
            baggageRow.classList.remove('d-none');
        }
    }

    function initMmtDates() {
        if (typeof flatpickr === 'undefined') return;
        
        const depPicker = flatpickr("#mmtDeparture", {
            dateFormat: "D, d M Y", 
            minDate: "today", 
            theme: "dark",
            disableMobile: "true",
            static: true,
            onChange: function(selectedDates, dateStr, instance) {
                const retPicker = document.getElementById('mmtReturn')._flatpickr;
                if (retPicker) {
                    // Update minDate for return to be same or after departure
                    retPicker.set('minDate', dateStr);
                    
                    // If return date is now before departure, auto-adjust to +1 day
                    const currentRet = retPicker.selectedDates[0];
                    if (currentRet && currentRet < selectedDates[0]) {
                        const newRet = new Date(selectedDates[0]);
                        newRet.setDate(newRet.getDate() + 1);
                        retPicker.setDate(newRet);
                    }
                }
            }
        });

        const retPicker = flatpickr("#mmtReturn", {
            dateFormat: "D, d M Y", 
            minDate: "{{ $travelDate ?: 'today' }}", 
            theme: "dark",
            disableMobile: "true",
            static: true
        });
    }

    function initMmtAutocomplete() {
        ['mmtOrigin', 'mmtDestination'].forEach(id => {
            const input = document.getElementById(id);
            if (!input) return;
            setupMmtAutocomplete(input);
        });
    }

    function initMmtMultiCityAutocomplete() {
        document.querySelectorAll('.mmt-mc-origin, .mmt-mc-destination').forEach(input => {
            if (!input.dataset.acInit) {
                setupMmtAutocomplete(input);
                input.dataset.acInit = 'true';
            }
        });
    }

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

    window.toggleModifySearch = function() {
        console.log("Modify Search clicked. Ribbon is permanent.");
    };

    window.selectMmtItem = function(id, code, cityName) {
        const input = document.getElementById(id);
        input.value = `${cityName} (${code})`;
        input.dataset.code = code;
        document.getElementById(id + 'Results').classList.add('d-none');
        console.log(`Selected ${id}: ${cityName} [${code}]`);
    }

    window.toggleTravelerPicker = function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('mmtTravelerDropdown');
        if (dropdown) dropdown.classList.toggle('d-none');
    }

    window.updateMmtAdults = function(count, el) {
        mmtAdults = count;
        document.querySelectorAll('.mmt-modern-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        updateMmtTravelerText();
    }

    window.updateMmtClass = function(cls, el) {
        mmtClass = cls;
        document.querySelectorAll('.mmt-class-pill-lg').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        updateMmtTravelerText();
    }

    function updateMmtTravelerText() {
        const textEl = document.getElementById('mmtTravelerInfoText');
        if (textEl) textEl.innerText = mmtAdults + " Adult, " + mmtClass;
    }

    function executeMmtSearch() {
        const trip = document.querySelector('input[name="tripType"]:checked').value;
        const url = new URL(window.location.origin + '/flights');
        
        const formatDate = (date) => {
            if (!date) return '';
            let dt = new Date(date), month = '' + (dt.getMonth() + 1), day = '' + dt.getDate(), year = dt.getFullYear();
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            return [year, month, day].join('-');
        };

        if (trip === 'multicity') {
            url.searchParams.set('multi_city', '1');
            const rows = document.querySelectorAll('.mmt-mc-row');
            let hasError = false;
            
            rows.forEach(row => {
                const oInput = row.querySelector('.mmt-mc-origin');
                const dInput = row.querySelector('.mmt-mc-destination');
                const dateInput = row.querySelector('.mmt-mc-date');
                
                const o = oInput.dataset.code || oInput.value.match(/\((.*?)\)/)?.[1] || oInput.value.trim().toUpperCase().substring(0,3);
                const d = dInput.dataset.code || dInput.value.match(/\((.*?)\)/)?.[1] || dInput.value.trim().toUpperCase().substring(0,3);
                const date = dateInput._flatpickr ? dateInput._flatpickr.selectedDates[0] : null;

                if (!o || !d || !date || o.length < 3 || d.length < 3) {
                    hasError = true;
                } else {
                    url.searchParams.append('origin[]', o.toUpperCase().substring(0,3));
                    url.searchParams.append('destination[]', d.toUpperCase().substring(0,3));
                    url.searchParams.append('departure_date[]', formatDate(date));
                }
            });

            if (hasError) {
                Swal.fire({ title: 'Missing Information', text: 'All city and date fields are required for multi-city search.', icon: 'warning' });
                return;
            }
        } else {
            const oInput = document.getElementById('mmtOrigin');
            const dInput = document.getElementById('mmtDestination');
            const oRaw = oInput.value;
            const dRaw = dInput.value;
            
            const o = oInput.dataset.code || oRaw.match(/\((.*?)\)/)?.[1] || oRaw.trim().toUpperCase().substring(0,3);
            const d = dInput.dataset.code || dRaw.match(/\((.*?)\)/)?.[1] || dRaw.trim().toUpperCase().substring(0,3);
            
            const depPicker = document.getElementById('mmtDeparture')?._flatpickr;
            const retPicker = document.getElementById('mmtReturn')?._flatpickr;
            
            let depDate = depPicker && depPicker.selectedDates && depPicker.selectedDates[0];
            if (!depDate && document.getElementById('mmtDeparture')?.value) {
                depDate = new Date(document.getElementById('mmtDeparture').value);
            }
            
            let retDate = retPicker && retPicker.selectedDates && retPicker.selectedDates[0];
            if (!retDate && document.getElementById('mmtReturn')?.value && document.getElementById('mmtReturn').value !== 'Select Date') {
                retDate = new Date(document.getElementById('mmtReturn').value);
            }

            if (!o || !d || !depDate || isNaN(depDate) || o.length < 3 || d.length < 3) {
                Swal.fire({ title: 'Missing Information', text: 'Origin, destination and departure date are required.', icon: 'warning' });
                return;
            }

            if (trip === 'roundtrip' && retDate && retDate < depDate) {
                Swal.fire({ title: 'Invalid Date', text: 'Return date cannot be before departure date.', icon: 'warning' });
                return;
            }

            url.searchParams.set('origin', o.toUpperCase().substring(0,3));
            url.searchParams.set('destination', d.toUpperCase().substring(0,3));
            url.searchParams.set('departure_date', formatDate(depDate));
            
            if (trip === 'roundtrip' && retDate) {
                url.searchParams.set('return_date', formatDate(retDate));
                url.searchParams.set('trip', 'round');
            }
        }
        
        const activeModeBtn = document.querySelector('.m-mode-btn.active');
        const modeText = activeModeBtn ? activeModeBtn.innerText.toLowerCase() : '';
        
        if (modeText.includes('budget')) {
            const maxBudget = document.getElementById('globalMaxBudget').value;
            url.searchParams.set('max_budget', maxBudget);
        } else if (modeText.includes('baggage')) {
            const baggage = document.getElementById('globalMaxBaggage').value;
            if (baggage) url.searchParams.set('baggage', baggage);
        }
        
        const fareType = document.querySelector('input[name="fare"]:checked')?.value || 'regular';
        if (fareType !== 'regular') {
            url.searchParams.set('fare_type', fareType);
        }
        
        url.searchParams.set('adults', mmtAdults);
        url.searchParams.set('cabin_class', mmtClass);

        Swal.fire({ title: 'Searching...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        window.location.href = url.toString();
    }

    window.addMmtCityRow = function() {
        const container = document.getElementById('mmtMultiCityRows');
        const rows = container.querySelectorAll('.mmt-mc-row');
        if (rows.length >= 6) return;
        
        const lastRow = rows[rows.length - 1];
        const lastTo = lastRow.querySelector('.mmt-mc-destination').value;
        const lastToCode = lastRow.querySelector('.mmt-mc-destination').dataset.code || '';
        
        const newRow = document.createElement('div');
        newRow.className = 'mmt-mc-row d-flex gap-2 mb-2 align-items-center animate__animated animate__fadeInDown';
        newRow.innerHTML = `
            <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                <i class="fas fa-plane-departure text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-origin autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="From" value="${lastTo}" data-code="${lastToCode}" style="font-size: 14px; outline: none;">
                <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
            </div>
            <div class="flex-grow-1 position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center">
                <i class="fas fa-plane-arrival text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-destination autocomplete-input fw-bold shadow-none p-0 text-navy" placeholder="To" value="" data-code="" style="font-size: 14px; outline: none;">
                <div class="autocomplete-results d-none shadow-lg border rounded-3 bg-white" style="position: absolute; top: 100%; left: 0; width: 300px; z-index: 10000;"></div>
            </div>
            <div class="position-relative bg-light rounded-pill px-3 py-2 border d-flex align-items-center" style="width: 160px;">
                <i class="fas fa-calendar-alt text-primary opacity-50 me-2" style="font-size: 12px;"></i>
                <input type="text" class="form-control form-control-sm border-0 bg-transparent mmt-mc-date cursor-pointer fw-bold shadow-none p-0 text-navy" placeholder="Date" readonly style="font-size: 14px; outline: none;">
            </div>
            <button type="button" class="btn btn-link text-danger p-0 ms-1 remove-mc-btn" onclick="removeMmtCityRow(this)"><i class="fas fa-times-circle fs-5"></i></button>
        `;
        container.appendChild(newRow);
        
        initMmtMultiCityDates();
        initMmtMultiCityAutocomplete();
        updateMmtRemoveButtons();
    };

    window.removeMmtCityRow = function(btn) {
        btn.closest('.mmt-mc-row').remove();
        updateMmtRemoveButtons();
    };

    function updateMmtRemoveButtons() {
        const rows = document.querySelectorAll('.mmt-mc-row');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-mc-btn');
            if (btn) {
                if (rows.length <= 2) btn.classList.add('d-none');
                else btn.classList.remove('d-none');
            }
        });
    }

    function initMmtMultiCityDates() {
        if (typeof flatpickr === 'undefined') return;
        document.querySelectorAll('.mmt-mc-date').forEach(el => {
            if (!el._flatpickr) {
                flatpickr(el, {
                    dateFormat: "D, d M Y", 
                    minDate: "today", 
                    theme: "dark",
                    disableMobile: "true"
                });
            }
        });
    }

    function swapMmtLocations() {
        const oIn = document.getElementById('mmtOrigin');
        const dIn = document.getElementById('mmtDestination');
        const tempVal = oIn.value, tempCode = oIn.dataset.code;
        oIn.value = dIn.value; oIn.dataset.code = dIn.dataset.code;
        dIn.value = tempVal; dIn.dataset.code = tempCode;
    }

    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('mmtTravelerDropdown');
        if (dropdown && !dropdown.contains(e.target)) dropdown.classList.add('d-none');
        document.querySelectorAll('.autocomplete-results').forEach(res => res.classList.add('d-none'));
    });
</script>

<!-- =========================================================
     MODERN COMPARISON PANEL (BOTTOM DRAWER) 
     ========================================================= -->
<div id="compareBar" class="compare-bar shadow-2xl animate__animated animate__slideInUp d-none">
    <div class="container-fluid h-100 px-lg-5">
        <div class="d-flex align-items-center justify-content-between h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="compare-count-circle fw-900 fs-5" id="compareCount">0</div>
                <div class="d-flex flex-column">
                    <span class="text-white fw-900 fs-5 lh-1 mb-1">Flights Selected for Comparison</span>
                    <span class="text-white-50 small fw-bold">Select 2-3 flights to compare fares, duration, and amenities.</span>
                </div>
                <div class="d-flex gap-2 ms-4" id="compareThumbnails">
                    <!-- Selected flight logos will appear here -->
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-light rounded-pill px-4 fw-800" onclick="clearComparison()">CLEAR ALL</button>
                <button class="btn btn-primary rounded-pill px-5 fw-900 py-3 shadow-lg" id="compareBtn" onclick="openComparisonPanel()" style="background: linear-gradient(135deg, #008cff 0%, #0056ff 100%); border:none; min-width: 180px;">
                    COMPARE NOW
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Detailed Modal -->
<div class="modal fade" id="comparisonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-navy p-4 d-flex align-items-center justify-content-between">
                <h4 class="modal-title fw-900 text-white mb-0">Flight Comparison Detail</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 compare-table">
                        <thead class="bg-light">
                            <tr id="compareTableHead">
                                <th class="p-4 fw-800 text-muted" style="width: 200px; font-size: 11px;">FEATURES</th>
                                <!-- Headers injected here -->
                            </tr>
                        </thead>
                        <tbody id="compareTableBody">
                            <!-- Feature rows injected here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 p-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-800" data-bs-dismiss="modal">Close Comparison</button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background: #001d3d; }
    .compare-bar {
        position: fixed; bottom: 0; left: 0; width: 100%; height: 95px;
        background: #0b1522; z-index: 1070; padding: 0;
        border-top: 2px solid var(--primary);
    }
    .compare-count-circle {
        width: 48px; height: 48px; background: var(--primary);
        color: #fff; border-radius: 50%; display: flex;
        align-items: center; justify-content: center;
        border: 4px solid rgba(255,255,255,0.1);
    }
    .compare-thumb {
        width: 40px; height: 40px; background: #fff; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        padding: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .compare-table th { border: none !important; }
    .compare-table td { padding: 20px 25px; border-bottom: 1px solid #f1f5f9; }
    .feature-row-label { font-weight: 800; color: #64748b; font-size: 11px; text-transform: uppercase; background: #fbfcfd; }
    .compare-value { font-weight: 900; color: #0f172a; font-size: 15px; }
    .amenity-icon { font-size: 18px; color: #10b981; }
    .best-value-highlight { border: 2px solid #008cff; border-radius: 12px; background: #f0f7ff; }

    /* Comparison Onboarding Spotlight */
    .feature-pulse-spotlight {
        position: relative;
        z-index: 10;
    }
    .feature-pulse-spotlight::before {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        width: 40px; height: 40px;
        background: rgba(37, 99, 235, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: pulseFeature 2s infinite;
        pointer-events: none;
    }
    @keyframes pulseFeature {
        0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.8; }
        100% { transform: translate(-50%, -50%) scale(1.8); opacity: 0; }
    }
    .compare-intro-tip {
        position: absolute;
        left: 45px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #0b1522 0%, #1e293b 100%);
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 100;
        white-space: nowrap;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .compare-intro-tip::before {
        content: '';
        position: absolute;
        left: -8px; top: 50%;
        transform: translateY(-50%);
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-right: 8px solid #0b1522;
    }
    .tip-icon {
        width: 24px; height: 24px; background: var(--primary);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 10px; color: white; flex-shrink: 0;
    }
    .fs-12 { font-size: 12px !important; }
    .fs-10 { font-size: 10px !important; }
</style>

<script>
    let selectedForCompare = [];

    window.handleCompareSelection = function(checkbox) {
        const flightId = checkbox.dataset.flightId;
        if (checkbox.checked) {
            if (selectedForCompare.length >= 3) {
                checkbox.checked = false;
                Swal.fire({ title: 'Comparison Limit', text: 'You can compare up to 3 flights at a time.', icon: 'info' });
                return;
            }
            selectedForCompare.push({
                id: flightId,
                airline: checkbox.dataset.airline,
                price: checkbox.dataset.price,
                duration: checkbox.dataset.duration,
                baggage: checkbox.dataset.baggage,
                meal: checkbox.dataset.meal,
                meal_detail: checkbox.dataset.mealDetail,
                seat: checkbox.dataset.seat,
                refund: checkbox.dataset.refund,
                wifi: checkbox.dataset.wifi,
                wifi_detail: checkbox.dataset.wifiDetail,
                entertainment: checkbox.dataset.entertainment,
                wine: checkbox.dataset.wine,
                amenities: checkbox.dataset.amenities,
                boarding: checkbox.dataset.boarding,
                logo: checkbox.closest('.result-card').querySelector('img')?.src || ''
            });
        } else {
            selectedForCompare = selectedForCompare.filter(f => f.id !== flightId);
        }
        updateCompareBar();
    };

    function updateCompareBar() {
        const bar = document.getElementById('compareBar');
        const countEl = document.getElementById('compareCount');
        const thumbEl = document.getElementById('compareThumbnails');

        if (selectedForCompare.length > 0) {
            bar.classList.remove('d-none');
            countEl.innerText = selectedForCompare.length;
            thumbEl.innerHTML = selectedForCompare.map(f => `
                <div class="compare-thumb animate__animated animate__zoomIn">
                    ${f.logo ? `<img src="${f.logo}" style="width:100%; height:100%; object-fit:contain;">` : '<i class="fas fa-plane text-primary"></i>'}
                </div>
            `).join('');
            document.getElementById('compareBtn').disabled = selectedForCompare.length < 2;
        } else {
            bar.classList.add('d-none');
        }
    }

    window.clearComparison = function() {
        selectedForCompare = [];
        document.querySelectorAll('.compare-checkbox').forEach(cb => cb.checked = false);
        updateCompareBar();
    };

    window.openComparisonPanel = function() {
        const head = document.getElementById('compareTableHead');
        const body = document.getElementById('compareTableBody');
        
        // Initial header setup
        head.innerHTML = '<th class="p-4 fw-800 text-muted" style="width: 200px; font-size: 11px;">FEATURES</th>';
        selectedForCompare.forEach(f => {
            head.innerHTML += `
                <th class="p-4 text-center">
                    <div class="mb-2 compare-thumb mx-auto" style="width:60px; height:60px; padding:10px;">
                        ${f.logo ? `<img src="${f.logo}" style="width:100%; height:100%; object-fit:contain;">` : '<i class="fas fa-plane text-primary fa-lg"></i>'}
                    </div>
                    <div class="fw-900 text-navy fs-5">${f.airline}</div>
                    <div class="fw-900 text-primary fs-4 mt-1">${f.price}</div>
                </th>
            `;
        });

        // Feature rows
        const features = [
            { label: 'Duration', key: 'duration' },
            { label: 'Baggage', key: 'baggage', icon: '🧳' },
            { label: 'Meal Type', key: 'meal', icon: '🍱' },
            { label: 'Meal Description', key: 'meal_detail', icon: '🍪' },
            { label: 'Seat Type', key: 'seat', icon: '💺' },
            { label: 'Refund Policy', key: 'refund' },
            { label: 'WiFi Availability', key: 'wifi', icon: '📶' },
            { label: 'WiFi Details', key: 'wifi_detail', icon: '📡' },
            { label: 'Wine/Alcohol', key: 'wine', icon: '🥂' },
            { label: 'Entertainment', key: 'entertainment', icon: '📺' },
            { label: 'Additional Amenities', key: 'amenities', icon: '✨' },
            { label: 'Priority Boarding', key: 'boarding' }
        ];

        body.innerHTML = features.map(feat => `
            <tr>
                <td class="feature-row-label">${feat.icon || ''} ${feat.label}</td>
                ${selectedForCompare.map(f => `
                    <td class="text-center compare-value">${f[feat.key]}</td>
                `).join('')}
            </tr>
        `).join('');

        new bootstrap.Modal('#comparisonModal').show();
    };

    // Sorting Logic
    window.sortByFilter = function(criteria, el) {
        document.querySelectorAll('.sort-pill').forEach(p => p.classList.remove('active'));
        if (el) el.classList.add('active');

        const resultsList = document.getElementById('resultsList');
        if (!resultsList) return;

        const items = Array.from(resultsList.querySelectorAll('.flight-row'));
        items.sort((a, b) => {
            if (criteria === 'price' || criteria === 'cheapest' || criteria === 'recommended') {
                return (parseInt(a.dataset.price) || 0) - (parseInt(b.dataset.price) || 0);
            } else if (criteria === 'duration') {
                return (parseInt(a.dataset.durationMinutes) || 0) - (parseInt(b.dataset.durationMinutes) || 0);
            } else if (criteria === 'departure') {
                return (parseInt(a.dataset.departureStamp) || 0) - (parseInt(b.dataset.departureStamp) || 0);
            }
            return 0;
        });
        items.forEach(item => resultsList.appendChild(item));
    };
</script>

<!-- Fare Monitor Tracker Modal -->
<div class="modal fade" id="fareMonitorAlarmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 bg-primary bg-opacity-10 px-4 pt-4 pb-3">
                <div>
                    <h5 class="fw-900 text-navy mb-1"><i class="fas fa-bullseye me-2 text-primary"></i> Track Cheaper Fares</h5>
                    <p class="text-muted x-small mb-0">We will monitor <strong>{{ $origin }} → {{ $destination }}</strong> and notify you</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('agent.b2b.fare-alerts.store') }}" method="POST" id="searchPageFareAlertForm">
                    @csrf
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
$append
                        <div class="col-6">
                            <label class="x-small fw-bold text-muted uppercase mb-1">From</label>
                            <input type="text" name="origin" class="form-control form-control-sm bg-light border-0 fw-bold" value="{{ $origin }}" required onkeyup="this.value = this.value.toUpperCase()" maxlength="3">
                        </div>
                        <div class="col-6">
                            <label class="x-small fw-bold text-muted uppercase mb-1">To</label>
                            <input type="text" name="destination" class="form-control form-control-sm bg-light border-0 fw-bold" value="{{ $destination }}" required onkeyup="this.value = this.value.toUpperCase()" maxlength="3">
                        </div>
                        <div class="col-6">
                            <label class="x-small fw-bold text-muted uppercase mb-1">Travel Date</label>
                            <input type="date" name="travel_date" class="form-control form-control-sm bg-light border-0 fw-bold" value="{{ \Carbon\Carbon::parse($travelDate)->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="x-small fw-bold text-muted uppercase mb-1">Passengers</label>
                            <input type="number" name="pax" class="form-control form-control-sm bg-light border-0 fw-bold" value="{{ $adults }}" min="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="x-small fw-bold text-muted uppercase mb-1">Target Budget (INR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">?</span>
                            <input type="number" name="target_price" class="form-control bg-light border-0 fw-bold text-navy" placeholder="e.g. {{ number_format(max(2000, ($minPrice ?? 10000) - 1500)) }}" required>
                        </div>
                        <span class="x-small text-muted">A realistic drop is usually 10-15% of current fare.</span>
                    </div>

                    <div class="mb-3">
                        <label class="x-small fw-bold text-muted uppercase mb-2">Notify Me Via</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="notification_channel[]" value="email" id="modalChanEmail" checked>
                                <label class="form-check-label x-small fw-bold text-navy" for="modalChanEmail">Email</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="notification_channel[]" value="whatsapp" id="modalChanWA" checked>
                                <label class="form-check-label x-small fw-bold text-navy" for="modalChanWA">WhatsApp</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="text" name="contact" class="form-control form-control-sm bg-light border-0" placeholder="Enter Email or Phone No." required>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-3">
                        <h6 class="fw-bold text-navy mb-2 small uppercase" style="font-size: 10px;">Passenger Details (For Fast Booking)</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="passenger_details[first_name]" class="form-control form-control-sm bg-white border-0 shadow-sm" placeholder="First Name" required>
                            </div>
                            <div class="col-6">
                                <input type="text" name="passenger_details[last_name]" class="form-control form-control-sm bg-white border-0 shadow-sm" placeholder="Last Name" required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="passenger_details[passport]" class="form-control form-control-sm bg-white border-0 shadow-sm" placeholder="Passport Number (Optional)">
                            </div>
                            <div class="col-12">
                                <input type="date" name="passenger_details[dob]" class="form-control form-control-sm bg-white border-0 shadow-sm" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="fareAlertSubmitBtn" class="btn btn-navy rounded-pill px-4 py-2 w-100 fw-900 shadow-sm">
                        START TRACKING <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                </form>
                
                <div id="fareMonitorSuccess" style="display: none;" class="text-center py-4">
                    <div class="d-inline-flex justify-content-center align-items-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h5 class="fw-900 text-navy">Thank You!</h5>
                    <p class="text-muted small px-3">Your Fare Tracker is now active. We will continuously monitor this route and notify you immediately when prices drop to your expectations.</p>
                    <button type="button" class="btn btn-outline-navy rounded-pill px-4 mt-2 fw-800" data-bs-dismiss="modal">CONTINUE SURFING</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/css/flights/listing.css">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="/js/flights/listing.js?v={{ time() }}"></script>
    <script>
        window.isRoundTrip = {{ $isRoundTrip ? 'true' : 'false' }};
        window.isMultiCity = {{ $isMultiCity ? 'true' : 'false' }};
        window.travelDate = "{{ $travelDate }}";
        window.returnDate = "{{ $returnDate ?? '' }}";
        window.mcNumSegments = {{ $isMultiCity ? count($params['origin']) : 0 }};
        window.fareType = "{{ $fareType }}";
        window.bankOffers = @json($bankOffers);

        document.addEventListener('DOMContentLoaded', () => {
            @if(isset($initialMaxBudget))
                const range = document.querySelector('.custom-range');
                if (range) {
                    range.value = {{ $initialMaxBudget }};
                    if (window.runMasterFilters) runMasterFilters(false);
                }
            @endif
            
            setTimeout(() => {
                const modalEl = document.getElementById('fareMonitorAlarmModal');
                if(modalEl && !modalEl.classList.contains('show')){
                    const modal = new bootstrap.Modal(modalEl);
                    // modal.show();
                }
            }, 12000);

            const fareForm = document.getElementById('searchPageFareAlertForm');
            if (fareForm) {
                fareForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const btn = document.getElementById('fareAlertSubmitBtn');
                    const form = this;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Activating...';
                    btn.disabled = true;
                    fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(() => {
                        form.style.display = 'none';
                        document.getElementById('fareMonitorSuccess').style.display = 'block';
                    })
                    .catch(() => {
                        btn.innerHTML = 'START TRACKING <i class="fas fa-arrow-right ms-1"></i>';
                        btn.disabled = false;
                    });
                });
            }
        });
    </script>
@endsection

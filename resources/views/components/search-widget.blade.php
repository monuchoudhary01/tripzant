@props(['type' => 'flights'])

<!-- SweetAlert2 for Premium Popups -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="misty-search-v3" id="searchWidget">

    <!-- Sophisticated Segmented Control -->
    <div class="misty-search-nav">
        <div class="nav-glow-pill"></div>
        <div class="misty-tab active" onclick="switchSearch('flights', this)">
            <div class="misty-tab-icon"><i class="fas fa-plane"></i></div>
            <span>Flights</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('hotels', this)">
            <div class="misty-tab-icon"><i class="fas fa-hotel"></i></div>
            <span>Hotels</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('homestays', this)">
            <div class="misty-tab-icon"><i class="fas fa-home"></i></div>
            <span>Homestays</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('combos', this)">
            <div class="misty-tab-icon"><i class="fas fa-gem"></i></div>
            <span>Packages</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('trains', this)">
            <div class="misty-tab-icon"><i class="fas fa-train"></i></div>
            <span>Trains</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('cabs', this)">
            <div class="misty-tab-icon"><i class="fas fa-car-side"></i></div>
            <span>Cabs</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('esim', this)">
            <div class="misty-tab-icon"><i class="fas fa-sim-card"></i></div>
            <span>eSIM</span>
        </div>
        <div class="misty-tab" onclick="switchSearch('insurance', this)">
            <div class="misty-tab-icon"><i class="fas fa-shield-alt"></i></div>
            <span>Insurance</span>
        </div>
    </div>

    <div class="misty-search-glass-card">
        <!-- Dual Search Modes (By Date vs By Budget) -->
        <div class="misty-mode-row d-flex align-items-center justify-content-between" id="flightsModeSwitcher">
            <div class="d-flex gap-2">
                <button class="m-mode-btn active" onclick="switchFlightMode('date', this)">
                    <i class="fas fa-calendar-alt"></i> Search by dates
                </button>
                <button class="m-mode-btn" onclick="switchFlightMode('budget', this)">
                    <i class="fas fa-money-bill-wave"></i> Search by budget
                </button>
                <!-- Slice Pay Info -->
                <div class="d-flex align-items-center ms-2 bg-light rounded-pill px-3 py-1 border border-primary border-opacity-25" style="height: 38px;">
                    <img src="/img/slice-logo.svg" alt="Slice" style="height: 20px; object-fit: contain; margin-right: 8px;">
                    <span class="text-navy fw-800" style="font-size: 11px;">Pay in 12 installments</span>
                    <i class="fas fa-info-circle ms-2 text-primary cursor-pointer" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<div class='text-start p-1'><ul class='ps-3 mb-0' style='font-size:12px; line-height:1.6;'><li class='mb-2 fw-bold text-white'>Lock in today’s prices for just a small deposit</li><li class='mb-2'>Pay off the remaining amount before you depart so you can travel guilt free!</li><li>No late fees and no credit checks means Slice Pay is easily available to all!</li></ul></div>" style="font-size: 14px;"></i>
                </div>
            </div>
            
            <a href="/explore-map" class="map-view-toggle-btn hvr-grow">
                <i class="fas fa-map-location-dot"></i> EXPLORE ON MAP
            </a>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>

<style>
    .misty-search-glass-card {
        position: relative;
        z-index: 10;
        overflow: visible !important;
        min-height: 480px; /* Ensure button visibility even on short tabs */
    }
    .misty-grid-container {
        overflow: visible !important;
    }
    .misty-fields-grid {
        overflow: visible !important;
    }
    .misty-field-block {
        overflow: visible !important;
    }
    .map-view-toggle-btn {
        background: rgba(var(--primary-rgb), 0.1);
        color: var(--primary);
        border: 1px solid rgba(var(--primary-rgb), 0.2);
        padding: 8px 16px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .map-view-toggle-btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2);
    }
</style>

        <!-- Modern Radio Selection Row -->
        <div class="misty-opt-row d-flex align-items-center justify-content-between mb-4" id="flightsTypeRow">
            <div class="d-flex align-items-center gap-4">
                <label class="misty-radio">
                    <input type="radio" name="tripType" value="oneway" checked>
                    <span class="m-radio-dot"></span>
                    One Way
                </label>
                <label class="misty-radio">
                    <input type="radio" name="tripType" value="roundtrip">
                    <span class="m-radio-dot"></span>
                    Round Trip
                </label>
                <label class="misty-radio">
                    <input type="radio" name="tripType" value="multicity">
                    <span class="m-radio-dot"></span>
                    Multi City
                </label>
            </div>
            <div class="ms-auto misty-badge-pro">
                <i class="fas fa-info-circle me-1"></i> Best Price Guaranteed
            </div>
        </div>

        <div class="position-relative" style="overflow:visible;">
            <!-- Flights (DATE MODE) -->
            <div id="searchFields" class="misty-grid-container position-relative mb-3">
            <!-- Flights (DATE MODE) CONTENT -->
            <div class="misty-fields-grid" id="flightsFields">
                <div class="misty-field-block">
                    <label><i class="fas fa-plane-departure me-2 icon-dim"></i> FROM</label>
                    <input type="text" class="m-val-input-text autocomplete-input" id="flightOriginInput" value="DEL" placeholder="City or Airport" autocomplete="off">
                    <div id="flightOriginResults" class="autocomplete-results d-none"></div>
                    <div class="m-sub" id="flightOriginSub">Delhi, Indira Gandhi Intl Airport</div>
                </div>
                
                <div class="misty-swap-btn">
                    <i class="fas fa-sync-alt"></i>
                </div>

                <div class="misty-field-block">
                    <label><i class="fas fa-plane-arrival me-2 icon-dim"></i> TO</label>
                    <input type="text" class="m-val-input-text autocomplete-input" id="flightDestinationInput" value="BLR" placeholder="City or Airport" autocomplete="off">
                    <div id="flightDestinationResults" class="autocomplete-results d-none"></div>
                    <div class="m-sub" id="flightDestinationSub">Bengaluru, Kempegowda Intl Airport</div>
                </div>
                
                <div class="misty-field-block">
                    <label><i class="fas fa-calendar-day me-2 icon-dim"></i> DEPARTURE</label>
                    <div class="m-val-group">
                        <input type="date" id="flightDate" class="m-val-input-styled" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                </div>

                <div class="misty-field-block" id="returnFieldBlock">
                    <label><i class="fas fa-calendar-plus me-2 icon-dim"></i> RETURN</label>
                    <div class="m-val-group">
                        <input type="date" id="flightReturnDate" class="m-val-input-styled" disabled value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                    </div>
                    <div class="m-msg" id="returnMsg">Add return for savings</div>
                </div>

                <div class="misty-field-block traveller-picker-trigger" onclick="toggleTravellerPicker(event)">
                    <label><i class="fas fa-users me-2 icon-dim"></i> TRAVELLERS & CLASS</label>
                    <div class="m-val-group">
                        <span class="v-big" id="travellerDisplayCount">1</span>
                        <span class="v-mid ms-1" id="travellerDisplayText">Traveller</span>
                    </div>
                    <div class="m-sub" id="tripClassDisplay">Economy</div>
                </div>
            </div>
        </div>

        <!-- Flights (MULTI CITY MODE) -->
        <div class="misty-fields-grid-mc d-none transition" id="multiCityFields">
            <div id="multiCityRows">
                <!-- Default 1st segment -->
                <div class="multi-city-row mb-2">
                    <div class="misty-fields-grid">
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-departure me-2 icon-dim"></i> FROM</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-from" value="DEL" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                            <div class="m-sub">Delhi, India</div>
                        </div>
                        <div class="misty-swap-btn disabled"><i class="fas fa-sync-alt"></i></div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-arrival me-2 icon-dim"></i> TO</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-to" value="BLR" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                            <div class="m-sub">Bengaluru, India</div>
                        </div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-calendar-day me-2 icon-dim"></i> DEPARTURE</label>
                            <input type="date" class="m-val-input-styled city-date" value="{{ date('Y-m-d', strtotime('+3 days')) }}">
                        </div>
                        <div class="misty-field-block traveller-picker-trigger" onclick="toggleTravellerPicker(event)">
                            <label><i class="fas fa-users me-2 icon-dim"></i> TRAVELLERS & CLASS</label>
                            <div class="m-val-group d-flex align-items-baseline">
                                <span class="v-big traveler-mc-count">1</span>
                                <span class="v-mid ms-1 traveler-mc-text">Traveller</span>
                            </div>
                            <div class="m-sub traveler-mc-class mt-1 fw-700" style="color: #666;">Economy</div>
                        </div>
                    </div>
                </div>
                <!-- Default 2nd segment -->
                <div class="multi-city-row mb-2 position-relative">
                    <div class="misty-fields-grid">
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-departure me-2 icon-dim"></i> FROM</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-from" value="BLR" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                            <div class="m-sub">Bengaluru, India</div>
                        </div>
                        <div class="misty-swap-btn disabled"><i class="fas fa-sync-alt"></i></div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-arrival me-2 icon-dim"></i> TO</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-to" value="BOM" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                            <div class="m-sub">Mumbai, India</div>
                        </div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-calendar-day me-2 icon-dim"></i> DEPARTURE</label>
                            <input type="date" class="m-val-input-styled city-date" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                        </div>
                        <div class="misty-field-block bg-transparent border-0 opacity-0 pointer-none" style="flex:1;"></div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute end-0 top-50 translate-middle-y me-n2 remove-city-btn d-none" onclick="removeCityRow(this)" style="z-index:10;"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-800" onclick="addCityRow()">+ ADD ANOTHER CITY</button>
                <div class="text-white-50 small fw-700 bg-dark bg-opacity-25 px-3 py-1 rounded-pill"><i class="fas fa-info-circle me-1"></i> Multi-city allows up to 6 flight segments</div>
            </div>
        </div>

        <!-- Global State - Hidden Inputs -->
        <input type="hidden" id="roomCount" value="1">
        <input type="hidden" id="adultCount" value="1">
        <input type="hidden" id="childCount" value="0">
        <input type="hidden" id="infantCount" value="0">
        <input type="hidden" id="passengerCount" value="1">
        <input type="hidden" id="cabinClass" value="Economy">

        <!-- Global Shared Dropdown -->
        <div class="traveller-dropdown-misty d-none shadow-lg" id="travellerDropdown" style="position:absolute; top:200px; right:40px; z-index:9999; min-width:420px; background:#fff; border-radius:24px; padding:30px;" onclick="event.stopPropagation()">
            
            <!-- Room Section (Hotels Only) -->
            <div class="picker-section hotel-only d-none mb-4" id="roomPickerSection">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fw-800 text-navy fs-5">Room</div>
                    <div class="counter-control">
                        <button type="button" onclick="changeCount('room', -1)">-</button>
                        <span id="roomCountDisplay">1</span>
                        <button type="button" onclick="changeCount('room', 1)">+</button>
                    </div>
                </div>
            </div>

            <!-- Adults Section -->
            <div class="picker-section mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-800 text-navy fs-5">Adults</div>
                        <div class="small text-muted" style="font-size: 11px;">12y + on day of travel</div>
                    </div>
                    <div class="counter-control">
                        <button type="button" onclick="changeCount('adult', -1)">-</button>
                        <span id="adultCountDisplay">1</span>
                        <button type="button" onclick="changeCount('adult', 1)">+</button>
                    </div>
                </div>
            </div>

            <!-- Children Section -->
            <div class="picker-section mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-800 text-navy fs-5">Children</div>
                        <div class="small text-muted" style="font-size: 11px;">0 - 17 Years Old</div>
                    </div>
                    <div class="counter-control">
                        <button type="button" onclick="changeCount('child', -1)">-</button>
                        <span id="childCountDisplay">0</span>
                        <button type="button" onclick="changeCount('child', 1)">+</button>
                    </div>
                </div>
                <div class="hotel-only d-none mt-2 p-2 rounded-3" style="background: #f8fafc; border-left: 3px solid #2563eb;">
                    <p class="small text-muted mb-0" style="font-size: 11px; line-height: 1.4;">Please provide right number of children along with their right age for best options and prices.</p>
                </div>
            </div>

            <!-- Travel Class (Flights Only) -->
            <div class="picker-section border-top pt-4 flight-only" id="classPickerSection">
                <label class="picker-label">CHOOSE TRAVEL CLASS</label>
                <div class="class-pills-row mt-2">
                    <div class="class-pill active" onclick="selectClass('Economy', this)">Economy</div>
                    <div class="class-pill" onclick="selectClass('Premium Economy', this)">Premium</div>
                    <div class="class-pill" onclick="selectClass('Business', this)">Business</div>
                    <div class="class-pill" onclick="selectClass('First Class', this)">First Class</div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-primary px-5 rounded-pill fw-800 py-2 shadow-sm" onclick="toggleTravellerPicker(event)">APPLY</button>
            </div>
        </div>

            <!-- Flights (BUDGET MODE) -->
            <div class="misty-fields-grid d-none" id="flightsBudgetFields">
                <div class="misty-field-block" style="flex:1.2;">
                    <label><i class="fas fa-plane-departure me-2 icon-dim"></i> TRAVEL FROM</label>
                    <div class="m-val">Colombo</div>
                    <div class="m-sub">CMB, Bandaranaike Intl Airport</div>
                </div>
                <div class="misty-field-block" style="flex:1.2;">
                    <label><i class="fas fa-plane-arrival me-2 icon-dim"></i> TRAVEL TO</label>
                    <div class="m-val">Dubai</div>
                    <div class="m-sub">DXB, Dubai Intl Airport</div>
                </div>
                <div class="misty-field-block">
                    <label><i class="fas fa-calendar-alt me-2 icon-dim"></i> DATE RANGE</label>
                    <div class="m-val-group">
                        <span class="v-big">1</span>
                        <span class="v-mid">Jun - Aug'26</span>
                    </div>
                    <div class="m-sub">Flexible Months</div>
                </div>
                <div class="misty-field-block">
                    <label><i class="fas fa-credit-card me-2 icon-dim"></i> MAX BUDGET</label>
                    <div class="budget-val">
                        <div class="budget-icon"><i class="fas fa-wallet"></i></div>
                        <span>$1,200</span>
                    </div>
                    <div class="m-sub">Total Trip Budget</div>
                </div>
                <div class="misty-field-block">
                    <label>PASSENGERS</label>
                    <div class="m-val-group">
                        <span class="v-big">2</span>
                        <span class="v-mid">Adults</span>
                    </div>
                    <div class="m-sub">Economy</div>
                </div>
            </div>

            <!-- Hotels -->
            <div class="misty-fields-grid d-none" id="hotelsFields">
                <div class="misty-field-block" style="flex:1.5;">
                    <label><i class="fas fa-map-marker-alt me-2 icon-dim"></i> DESTINATION</label>
                    <input type="text" class="m-val-input-text autocomplete-input" id="hotelDestinationInput" value="Goa" placeholder="City" autocomplete="off">
                    <div id="hotelDestinationResults" class="autocomplete-results d-none"></div>
                    <div class="m-sub" id="hotelDestinationSub">Goa, India</div>
                </div>
                <div class="misty-field-block">
                    <label><i class="fas fa-calendar-check me-2 icon-dim"></i> CHECK-IN</label>
                    <div class="m-val-group">
                        <input type="date" id="hotelCheckIn" class="m-val-input-styled" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="misty-field-block">
                    <label><i class="fas fa-calendar-times me-2 icon-dim"></i> CHECK-OUT</label>
                    <div class="m-val-group">
                        <input type="date" id="hotelCheckOut" class="m-val-input-styled" value="{{ date('Y-m-d', strtotime('+3 days')) }}">
                    </div>
                </div>
                <div class="misty-field-block traveller-picker-trigger" onclick="toggleTravellerPicker(event)">
                    <label><i class="fas fa-bed me-2 icon-dim"></i> ROOMS & GUESTS</label>
                    <div class="m-val-group d-flex align-items-center">
                        <span class="v-big" id="hotelRoomDisplayCount">1</span>
                        <span class="v-mid ms-1">Rooms</span>
                        <span class="v-big ms-3" id="hotelAdultDisplayCount">2</span>
                        <span class="v-mid ms-1">Adults</span>
                    </div>
                    <div class="m-sub" id="hotelSubText">1 Room • 2 Adults</div>
                </div>
            </div>

            <!-- Homestays -->
            <div class="misty-fields-grid d-none" id="homestaysFields">
                <div class="misty-field-block" style="flex:1.5;">
                    <label><i class="fas fa-house-user me-2 icon-dim"></i> STAY LOCALITY</label>
                    <div class="m-val">Manali, HP</div>
                    <div class="m-sub">Old Manali, Mall Road, Solang...</div>
                </div>
                <div class="misty-field-block">
                    <label>CHECK-IN</label>
                    <div class="m-val-group">
                        <span class="v-big">20</span>
                        <span class="v-mid">Dec'25</span>
                    </div>
                    <div class="m-sub">Saturday</div>
                </div>
                <div class="misty-field-block">
                    <label>GUESTS</label>
                    <div class="m-val-group">
                        <span class="v-big">2</span>
                        <span class="v-mid">Adults</span>
                    </div>
                    <div class="m-sub">Boutique Cottage</div>
                </div>
            </div>

            <!-- Packages -->
            <div class="misty-fields-grid d-none" id="combosFields">
                <div class="misty-field-block" style="flex:1.5;">
                    <label>EXPLORE</label>
                    <div class="m-val">Maldives</div>
                    <div class="m-sub">Private Island Resorts</div>
                </div>
                <div class="misty-field-block">
                    <label>DEPARTURE</label>
                    <div class="m-val-group">
                        <span class="v-big">10</span>
                        <span class="v-mid">Jan'26</span>
                    </div>
                    <div class="m-sub">Saturday</div>
                </div>
                <div class="misty-field-block">
                    <label>DURATION</label>
                    <div class="m-val-group">
                        <span class="v-big">5</span>
                        <span class="v-mid">Nights</span>
                    </div>
                    <div class="m-sub">All-inclusive Luxury</div>
                </div>
            </div>

            <!-- Trains -->
            <div class="misty-fields-grid d-none" id="trainsFields">
                <div class="misty-field-block">
                    <label><i class="fas fa-train me-2 icon-dim"></i> FROM STATION</label>
                    <div class="m-val">NDLS</div>
                    <div class="m-sub">New Delhi Station</div>
                </div>
                <div class="misty-field-block">
                    <label><i class="fas fa-train me-2 icon-dim"></i> TO STATION</label>
                    <div class="m-val">HWH</div>
                    <div class="m-sub">Howrah Junction</div>
                </div>
                <div class="misty-field-block">
                    <label><i class="fas fa-calendar-alt me-2 icon-dim"></i> TRAVEL DATE</label>
                    <div class="m-val-group">
                        <span class="v-big">1</span>
                        <span class="v-mid">Jan'26</span>
                    </div>
                    <div class="m-sub">Thursday</div>
                </div>
            </div>

            <!-- Cabs -->
            <div class="misty-fields-grid d-none" id="cabsFields">
                <div class="misty-field-block">
                    <label>FROM</label>
                    <div class="m-val">Airport</div>
                    <div class="m-sub">Delhi Terminal 3</div>
                </div>
                <div class="misty-field-block">
                    <label>TO</label>
                    <div class="m-val">Noida</div>
                    <div class="m-sub">Sector 62, Electronic City</div>
                </div>
                <div class="misty-field-block">
                    <label>PICKUP</label>
                    <div class="m-val">Today</div>
                    <div class="m-sub">9:30 PM</div>
                </div>
            </div>

            <!-- Tours -->
            <div class="misty-fields-grid d-none" id="toursFields">
                <div class="misty-field-block" style="flex:1.5;">
                    <label>DESTINATION</label>
                    <div class="m-val">India, Uttarakhand</div>
                    <div class="m-sub">Enter Country or City</div>
                </div>
                <div class="misty-field-block">
                    <label>TRAVEL DATE</label>
                    <div class="m-val-group">
                        <span class="v-big">Jun</span>
                        <span class="v-mid">'26</span>
                    </div>
                    <div class="m-sub">Select Month / Date</div>
                </div>
                <div class="misty-field-block">
                    <label>TRAVELERS</label>
                    <div class="m-val-group">
                        <span class="v-big">3</span>
                        <span class="v-mid">People</span>
                    </div>
                    <div class="m-sub">Adults & Children</div>
                </div>
            </div>

            <!-- eSIM -->
            <div class="misty-fields-grid d-none" id="esimFields">
                <div class="misty-field-block" style="flex:1.5;">
                    <label>DESTINATION</label>
                    <div class="m-val">Thailand</div>
                    <div class="m-sub">Asia Travel SIM Card</div>
                </div>
                <div class="misty-field-block">
                    <label>DATA PLAN</label>
                    <div class="m-val-group">
                        <span class="v-big">10</span>
                        <span class="v-mid">GB</span>
                    </div>
                    <div class="m-sub">High Speed 4G/5G</div>
                </div>
                <div class="misty-field-block">
                    <label>VALIDITY</label>
                    <div class="m-val-group">
                        <span class="v-big">30</span>
                        <span class="v-mid">Days</span>
                    </div>
                    <div class="m-sub">Global Roaming</div>
                </div>
            </div>

            <!-- Insurance -->
            <div class="misty-fields-grid d-none" id="insuranceFields">
                <div class="misty-field-block" style="flex:1.5;">
                    <label>DESTINATION</label>
                    <div class="m-val">Thailand</div>
                    <div class="m-sub">International Travel Insurance</div>
                </div>
                <div class="misty-field-block">
                    <label>TRAVEL DATES</label>
                    <div class="m-val-group">
                        <span class="v-big">3</span>
                        <span class="v-mid">Apr'26 - 7 Apr</span>
                    </div>
                    <div class="m-sub">4 Nights Coverage</div>
                </div>
                <div class="misty-field-block">
                    <label>TRAVELLERS</label>
                    <div class="m-val-group">
                        <span class="v-big">1</span>
                        <span class="v-mid">Adult</span>
                    </div>
                    <div class="m-sub">Single Trip Policy</div>
                </div>
            </div>
        </div>

        <!-- Unique Fare Badges -->
        <div class="misty-fares-section TS-5" id="faresSection">
            <h6 class="fares-title">SPECIAL FARES <span><i class="fas fa-sparkles"></i></span></h6>
            <div class="misty-fare-row" id="flightSpecialFares">
                <div class="m-fare-item active">
                    <div class="m-fare-name">Regular</div>
                    <div class="m-fare-info">Best current dynamic rates</div>
                </div>
                <div class="m-fare-item">
                    <div class="m-fare-name">Student <span class="m-pop">POPULAR</span></div>
                    <div class="m-fare-info">Extra baggage + Student discount</div>
                </div>
                <div class="m-fare-item">
                    <div class="m-fare-name">Senior Citizens</div>
                    <div class="m-fare-info">Special assistance + Flat discounts</div>
                </div>
                <div class="m-fare-item">
                    <div class="m-fare-name">Armed Forces</div>
                    <div class="m-fare-info">Flat off for our heroes</div>
                </div>
            </div>

            <!-- Hotel Special Features -->
            <div id="hotelSpecials" class="mt-4 animate-up d-none">
                <p class="text-white-50 small fw-900 mb-2 letter-spacing-1">HOTEL SPECIALS</p>
                <div class="d-flex gap-2 flex-wrap">
                    <div class="m-fare-item active">
                        <div class="m-fare-name">Regular</div>
                        <div class="m-fare-info">Best current dynamic rates</div>
                    </div>
                    <div class="m-fare-item">
                        <div class="m-fare-name">Corporate</div>
                        <div class="m-fare-info">GST Invoice + Low Fares</div>
                    </div>
                    <div class="m-fare-item">
                        <div class="m-fare-name">Couples</div>
                        <div class="m-fare-info">Romantic & Safe Stays</div>
                    </div>
                    <div class="m-fare-item">
                        <div class="m-fare-name">Refundable</div>
                        <div class="m-fare-info">Free cancellation deals</div>
                    </div>
                </div>
                
                <!-- Hotline Info -->
                <div class="mt-4 p-3 rounded-4 d-flex align-items-center gap-3 animate-up" style="background: rgba(var(--primary-rgb), 0.05); border: 1px dashed rgba(var(--primary-rgb), 0.2);">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-headset fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-800 text-navy mb-0">Need help with your Jaipur booking?</div>
                        <div class="small fw-700 text-primary">Call our Hotel Expert: <a href="tel:+919999000000" class="text-decoration-none">+91 9999 000 000</a></div>
                    </div>
                </div>
            </div>
        </div>

<style>
    .misty-field-block {
        position: relative !important;
        background: rgba(0,0,0,0.03);
        border-radius: 14px;
        padding: 14px 18px;
        border: 1px solid rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        min-height: 110px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .misty-field-block:hover, .misty-field-block:focus-within {
        background: rgba(var(--primary-rgb), 0.04);
        border-color: rgba(var(--primary-rgb), 0.6);
        box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.08);
    }
    .m-val-input-text {
        background: transparent !important;
        border: none !important;
        color: #1a1a2e !important;
        font-size: 30px;
        font-weight: 800;
        width: 100%;
        outline: none;
        padding: 0;
        text-transform: uppercase;
        position: relative;
        z-index: 5;
        letter-spacing: -1px;
    }
    .m-val-input-text::placeholder { color: rgba(0,0,0,0.2); }
    
    .m-val-input-styled {
        background: rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.08);
        color: #1a1a2e;
        border-radius: 10px;
        padding: 10px 14px;
        font-weight: 700;
        outline: none;
        width: 100%;
        cursor: pointer;
        display: block;
        font-size: 15px;
        transition: all 0.3s;
    }
    .m-val-input-styled:hover { background: rgba(0,0,0,0.08); border-color: var(--primary); }
    .m-val-input-styled:disabled { opacity: 0.3; cursor: not-allowed; }

    .autocomplete-results {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid rgba(var(--primary-rgb), 0.3);
        border-radius: 16px;
        z-index: 9999999;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        padding: 8px 0;
    }
    .autocomplete-item {
        padding: 14px 20px;
        cursor: pointer;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
    }
    .autocomplete-item:hover { 
        background: rgba(var(--primary-rgb), 0.05);
        padding-left: 26px;
    }
    .autocomplete-item .code { font-weight: 800; color: #fff; background: var(--primary); padding: 4px 10px; border-radius: 6px; font-size: 14px; }
    .autocomplete-item .details { font-size: 13px; color: #666; text-align: right; }
    
    .flatpickr-calendar {
        background: #fff !important;
        border: 1px solid #eee !important;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1) !important;
        border-radius: 20px !important;
    }
    .flatpickr-day.selected { background: var(--primary) !important; border-color: var(--primary) !important; color: #fff !important; }
    
    .m-val-input-count {
        background: transparent;
        border: none;
        color: #1a1a2e;
        font-size: 28px;
        font-weight: 800;
        width: 70px;
        outline: none;
    }
    .m-sub { margin-top: 4px; font-size: 12px; color: #777; transition: opacity 0.3s; }
    .misty-field-block label { color: #555 !important; font-weight: 700 !important; font-size: 11px !important; margin-bottom: 5px !important; display: flex; align-items: center; }
    .icon-dim { color: var(--primary); opacity: 0.8; }

    /* Traveller Picker Styles */
    .traveller-picker-trigger { cursor: pointer; position: relative !important; width: 280px; }
    .v-big { font-size: 32px; font-weight: 800; color: #1a1a2e; line-height: 1; }
    .v-mid { font-size: 18px; font-weight: 700; color: #1a1a2e; }

    .traveller-dropdown-misty {
        position: absolute; top: calc(100% + 15px); right: 0; min-width: 600px;
        background: #fff; border-radius: 24px; box-shadow: 0 25px 60px rgba(0,0,0,0.18);
        padding: 30px; z-index: 1000; border: 1px solid rgba(0,0,0,0.05);
        animation: mistyFadeIn 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    @keyframes mistyFadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .picker-label { font-size: 11px; font-weight: 800; color: #555; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
    .picker-subtitle { font-size: 11px; color: #888; font-weight: 600; margin-bottom: 12px; }
    
    .pill-selector { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 25px; }
    .pill-item {
        width: 38px; height: 38px; border-radius: 8px; background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px; color: #4b5563;
        cursor: pointer; transition: all 0.2s; border: 1px solid transparent;
    }
    .pill-item:hover { background: #e2e8f0; }
    .pill-item.active { background: #2563eb; color: #fff; box-shadow: 0 5px 15px rgba(37,99,235,0.3); }

    .class-pills-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .class-pill {
        padding: 10px 18px; background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 12px; font-size: 13px; font-weight: 700; color: #475569;
        cursor: pointer; transition: all 0.2s;
    }
    .class-pill:hover { border-color: #2563eb; color: #2563eb; }
    .class-pill.active { background: #2563eb; color: #fff; border-color: #2563eb; }

    .class-pill.active { background: #2563eb; color: #fff; border-color: #2563eb; }

    .border-top { border-color: #f1f5f9 !important; }

    /* Counter Controls */
    .counter-control {
        display: flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }
    .counter-control button {
        width: 38px;
        height: 38px;
        background: #fff;
        border: none;
        color: #2563eb;
        font-size: 20px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .counter-control button:hover { background: #f1f5f9; }
    .counter-control button:active { transform: scale(0.9); }
    .counter-control span {
        padding: 0 10px;
        font-weight: 800;
        font-size: 16px;
        color: #1e293b;
        border-left: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        min-width: 45px;
        text-align: center;
        line-height: 38px;
    }
    .text-navy { color: #1a1a2e; }
    .fw-800 { font-weight: 800; }

    /* Multi City Restored Misty Styles */
    .misty-fields-grid-mc {
        display: block;
        margin-top: 10px;
    }
    .multi-city-row .misty-fields-grid {
        background: rgba(var(--primary-rgb), 0.02);
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        gap: 10px;
        padding: 5px;
    }
    .multi-city-row .misty-field-block {
        flex: 1;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        min-height: 100px;
    }
    .remove-city-btn {
        width: 32px;
        height: 32px;
        background: #ef4444 !important;
        border: none !important;
        box-shadow: 0 4px 10px rgba(239,68,68,0.3);
    }
    .misty-swap-btn.disabled {
        opacity: 0.2;
        cursor: default;
    }
    .remove-city-btn {
        width: 34px;
        height: 34px;
        background: #ef4444 !important;
        border: none !important;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        transition: all 0.3s;
    }
    .remove-city-btn:hover {
        transform: scale(1.1) rotate(90deg);
        background: #dc2626 !important;
    }
</style>

<!-- Load Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- World-Class Floating Search Button -->
    <div class="misty-search-glow-wrap">
            <button class="misty-search-btn-v3" id="mainSearchBtn">
                <span>SEARCH</span>
                <i class="fas fa-search ms-2"></i>
            </button>
        </div>
    </div>

    <!-- Dynamic Results Container -->
    <div id="searchResults" class="misty-search-results d-none container py-4">
        <h4 class="mb-4 text-white">Search Results</h4>
        <div id="resultsList" class="row g-4 d-flex flex-wrap">
            <!-- Results will be injected here -->
        </div>
    </div>
</div>

<script>
function switchSearch(type, el) {
    const pill = document.querySelector('.nav-glow-pill');
    pill.style.left = el.offsetLeft + 'px';
    pill.style.width = el.offsetWidth + 'px';

    document.querySelectorAll('.misty-tab').forEach(tab => tab.classList.remove('active'));
    el.classList.add('active');

    // Show/Hide Flight-specific mode switcher
    const flightModeSwitcher = document.getElementById('flightsModeSwitcher');
    const faresSection = document.getElementById('faresSection');
    const flightsTypeRow = document.getElementById('flightsTypeRow');
    const specialFares = document.getElementById('flightSpecialFares');
    const hotelSpecials = document.getElementById('hotelSpecials');
    
    const roomSection = document.getElementById('roomPickerSection');
    const classSection = document.getElementById('classPickerSection');
    const hotelOnlyTips = document.querySelectorAll('.hotel-only');
    const flightOnlyTips = document.querySelectorAll('.flight-only');
    
    if (type === 'flights') {
        flightModeSwitcher.classList.remove('d-none');
        faresSection.classList.remove('d-none');
        flightsTypeRow.classList.remove('d-none');
        specialFares?.classList.remove('d-none');
        hotelSpecials?.classList.add('d-none');
        
        roomSection?.classList.add('d-none');
        classSection?.classList.remove('d-none');
        hotelOnlyTips.forEach(el => el.classList.add('d-none'));
        flightOnlyTips.forEach(el => el.classList.remove('d-none'));
    } else if (type === 'hotels') {
        flightModeSwitcher.classList.add('d-none');
        faresSection.classList.remove('d-none');
        flightsTypeRow.classList.add('d-none');
        specialFares?.classList.add('d-none');
        hotelSpecials?.classList.remove('d-none');
        
        roomSection?.classList.remove('d-none');
        classSection?.classList.add('d-none');
        hotelOnlyTips.forEach(el => el.classList.remove('d-none'));
        flightOnlyTips.forEach(el => el.classList.add('d-none'));
    } else {
        flightModeSwitcher.classList.add('d-none');
        faresSection.classList.add('d-none');
        flightsTypeRow.classList.add('d-none');
        specialFares?.classList.add('d-none');
        hotelSpecials?.classList.add('d-none');
    }

    const fieldsContainer = document.getElementById('searchFields');
    fieldsContainer.style.opacity = '0';
    fieldsContainer.style.transform = 'scale(0.98)';
    
    setTimeout(() => {
        document.querySelectorAll('.misty-fields-grid').forEach(g => g.classList.add('d-none'));
        
        // If switching to flight, default to 'date' mode fields
        if (type === 'flights') {
            const activeMode = document.querySelector('.m-mode-btn.active').innerText.toLowerCase();
            if (activeMode.includes('budget')) {
                document.getElementById('flightsBudgetFields').classList.remove('d-none');
            } else {
                document.getElementById('flightsFields').classList.remove('d-none');
            }
        } else {
            const targetGrid = document.getElementById(type + 'Fields');
            if (targetGrid) targetGrid.classList.remove('d-none');
        }
        
        fieldsContainer.style.opacity = '1';
        fieldsContainer.style.transform = 'scale(1)';
    }, 400);
}

function switchFlightMode(mode, el) {
    document.querySelectorAll('.m-mode-btn').forEach(btn => btn.classList.remove('active'));
    el.classList.add('active');

    const fieldsContainer = document.getElementById('searchFields');
    fieldsContainer.style.opacity = '0';
    
    setTimeout(() => {
        document.getElementById('flightsFields').classList.add('d-none');
        document.getElementById('flightsBudgetFields').classList.add('d-none');

        if (mode === 'date') {
            document.getElementById('flightsFields').classList.remove('d-none');
        } else {
            document.getElementById('flightsBudgetFields').classList.remove('d-none');
        }
        
        fieldsContainer.style.opacity = '1';
    }, 300);
}

// Traveller Picker Logic
function toggleTravellerPicker(event) {
    if (event) event.stopPropagation();
    const dropdown = document.getElementById('travellerDropdown');
    if(dropdown) {
        dropdown.classList.toggle('d-none');
    }
}

function changeCount(type, delta) {
    const input = document.getElementById(type + 'Count');
    const display = document.getElementById(type + 'CountDisplay');
    if (!input || !display) return;

    let val = parseInt(input.value) || 0;
    val += delta;

    // Minimum constraints
    if (type === 'room' && val < 1) val = 1;
    if (type === 'adult' && val < 1) val = 1;
    if (type === 'child' && val < 0) val = 0;
    if (type === 'infant' && val < 0) val = 0;
    
    // Maximum constraints (example)
    if (val > 12) val = 12;

    input.value = val;
    display.innerText = val;

    updateTotalPassengers();
}

function selectClass(className, el) {
    el.parentNode.querySelectorAll('.class-pill').forEach(item => item.classList.remove('active'));
    el.classList.add('active');

    document.getElementById('cabinClass').value = className;
    
    // Standard Display
    const standardDisplay = document.getElementById('tripClassDisplay');
    if (standardDisplay) standardDisplay.innerText = className;
    
    // Multi-City Display
    const mcDisplay = document.querySelector('.traveler-mc-class');
    if (mcDisplay) mcDisplay.innerText = className;
}

function updateTotalPassengers() {
    const rooms = parseInt(document.getElementById('roomCount').value) || 1;
    const adults = parseInt(document.getElementById('adultCount').value) || 1;
    const children = parseInt(document.getElementById('childCount').value) || 0;
    const infants = parseInt(document.getElementById('infantCount').value) || 0;
    
    const total = adults + children + infants;
    const travellers = adults + children;

    const mainInput = document.getElementById('passengerCount');
    if (mainInput) mainInput.value = total;

    const displayCount = document.getElementById('travellerDisplayCount');
    if (displayCount) displayCount.innerText = travellers;

    const displayText = document.getElementById('travellerDisplayText');
    if (displayText) displayText.innerText = travellers > 1 ? 'Travellers' : 'Traveller';
    
    // Multi-City Update
    const mcDisplayCount = document.querySelector('.traveler-mc-count');
    if (mcDisplayCount) mcDisplayCount.innerText = travellers;

    const mcDisplayText = document.querySelector('.traveler-mc-text');
    if (mcDisplayText) mcDisplayText.innerText = travellers > 1 ? 'Travellers' : 'Traveller';

    // Hotel Display Update (Enhanced for Screenshot Match)
    const hRoomCount = document.getElementById('hotelRoomDisplayCount');
    if (hRoomCount) hRoomCount.innerText = rooms;

    const hAdultCount = document.getElementById('hotelAdultDisplayCount');
    if (hAdultCount) hAdultCount.innerText = adults;

    const hSubText = document.getElementById('hotelSubText');
    if (hSubText) {
        let txt = `${rooms} ${rooms > 1 ? 'Rooms' : 'Room'} • ${adults} ${adults > 1 ? 'Adults' : 'Adult'}`;
        if (children > 0) txt += `, ${children} ${children > 1 ? 'Children' : 'Child'}`;
        hSubText.innerText = txt;
    }
}

// Close dropdown clicking outside
document.addEventListener('click', (e) => {
    const triggers = document.querySelectorAll('.traveller-picker-trigger');
    const dropdown = document.getElementById('travellerDropdown');
    
    if (!dropdown || dropdown.classList.contains('d-none')) return;

    let clickedOnTrigger = false;
    triggers.forEach(trigger => {
        if (trigger.contains(e.target)) clickedOnTrigger = true;
    });

    if (!clickedOnTrigger && !dropdown.contains(e.target)) {
        dropdown.classList.add('d-none');
    }
});

    window.addEventListener('scroll', () => {
        const searchWidget = document.getElementById('searchWidget');
        if (window.scrollY > 300) {
            searchWidget.classList.add('stuck');
        } else {
            searchWidget.classList.remove('stuck');
        }
    });

        window.addEventListener('DOMContentLoaded', () => {
            // --- Initialize Flatpickr ---
            const fpConfig = {
                dateFormat: "Y-m-d",
                minDate: "today",
                theme: "dark",
                disableMobile: "true"
            };
            
            flatpickr("#flightDate", fpConfig);
            flatpickr("#flightReturnDate", fpConfig);
            flatpickr("#hotelCheckIn", fpConfig);
            flatpickr("#hotelCheckOut", fpConfig);

            // --- Auto-complete Logic ---
            const setupAutocomplete = (inputId, resultsId, subId) => {
                const input = document.getElementById(inputId);
                const results = document.getElementById(resultsId);
                const sub = document.getElementById(subId);

                if (!input) return;

                input.addEventListener('input', async (e) => {
                    const term = e.target.value.trim();
                    if (term.length < 2) {
                        results.classList.add('d-none');
                        return;
                    }

                    try {
                        const isHotel = inputId.toLowerCase().includes('hotel');
                        const typesParam = isHotel ? 'types[]=city' : 'types[]=city&types[]=airport';
                        const response = await fetch(`https://autocomplete.travelpayouts.com/places2?locale=en&${typesParam}&term=${term}`);
                        const data = await response.json();
                        
                        if (data && data.length > 0) {
                            results.innerHTML = data.slice(0, 6).map(place => {
                                const detail = place.country_name || place.main_airport_name || place.name;
                                const icon = place.type === 'city' ? 'fa-city' : 'fa-plane';
                                return `
                                    <div class="autocomplete-item" onmousedown="window.selectPlace('${inputId}', '${resultsId}', '${subId}', '${place.code}', '${place.name}', '${detail.replace(/'/g, "\\'")}', '${place.type}')">
                                        <div class="code"><i class="fas ${icon} opacity-50 small me-2"></i> ${place.code}</div>
                                        <div class="details">
                                            <div class="fw-bold">${place.name}</div>
                                            <div class="small opacity-50">${detail}</div>
                                        </div>
                                    </div>
                                `;
                            }).join('');
                            results.classList.remove('d-none');
                        } else {
                            results.classList.add('d-none');
                        }
                    } catch (err) {
                        console.error('Autocomplete failed', err);
                    }
                });

                // Close results when clicking outside
                document.addEventListener('click', (e) => {
                    if (!input.contains(e.target) && !results.contains(e.target)) {
                        results.classList.add('d-none');
                    }
                });

                // Clear sub-text when typing to avoid overlap
                input.addEventListener('focus', () => {
                    sub.style.opacity = '0.3';
                });
                input.addEventListener('blur', () => {
                    sub.style.opacity = '1';
                });
            };

            window.selectPlace = (inputId, resultsId, subId, code, name, detail) => {
                const input = document.getElementById(inputId);
                const results = document.getElementById(resultsId);
                const sub = document.getElementById(subId);

                if (input) {
                    input.value = code;
                    input.dataset.selected = "true";
                    input.blur(); // Remove focus after selection
                }
                if (sub) {
                    sub.innerText = `${name}, ${detail}`;
                    sub.style.opacity = '1';
                }
                if (results) {
                    results.classList.add('d-none');
                }
                console.log(`Selected: ${code} for ${inputId}`);
            };

            setupAutocomplete('flightOriginInput', 'flightOriginResults', 'flightOriginSub');
            setupAutocomplete('flightDestinationInput', 'flightDestinationResults', 'flightDestinationSub');
            setupAutocomplete('hotelDestinationInput', 'hotelDestinationResults', 'hotelDestinationSub');

            // Initialize display
            updateTotalPassengers();

            // --- Trip Type Switcher ---
            const tripTypeRadios = document.querySelectorAll('input[name="tripType"]');
            const returnDateInput = document.getElementById('flightReturnDate');
            const returnMsg = document.getElementById('returnMsg');
            const returnFieldBlock = document.getElementById('returnFieldBlock');

            tripTypeRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    const type = e.target.value;
                    const flightsFields = document.getElementById('flightsFields');
                    const multiCityFields = document.getElementById('multiCityFields');
                    
                    if (type === 'multicity') {
                        if (flightsFields) flightsFields.classList.add('d-none');
                        if (multiCityFields) {
                            multiCityFields.classList.remove('d-none');
                            // Re-init Flatpickr for MC rows
                            multiCityFields.querySelectorAll('.city-date').forEach(el => {
                                if (!el._flatpickr) {
                                    flatpickr(el, { dateFormat: "Y-m-d", minDate: "today", theme: "dark" });
                                }
                            });
                        }
                    } else {
                        if (flightsFields) flightsFields.classList.remove('d-none');
                        if (multiCityFields) multiCityFields.classList.add('d-none');
                        
                        if (type === 'roundtrip') {
                            if (returnDateInput) {
                                returnDateInput.disabled = false;
                                returnDateInput.parentElement.parentElement.style.opacity = '1';
                                if (returnMsg) returnMsg.innerText = 'Return journey date';
                            }
                        } else {
                            if (returnDateInput) {
                                returnDateInput.disabled = true;
                                returnDateInput.parentElement.parentElement.style.opacity = '0.3';
                                if (returnMsg) returnMsg.innerText = 'Add return for savings';
                                returnDateInput.value = '';
                            }
                        }
                    }
                });
            });

            // --- Multi City Logic ---
            window.addCityRow = () => {
                const container = document.getElementById('multiCityRows');
                if (!container) return;
                const rowCount = container.querySelectorAll('.multi-city-row').length;
                if (rowCount >= 6) return;
                
                const lastRow = container.lastElementChild;
                const lastTo = lastRow.querySelector('.city-to').value;
                
                const newRow = document.createElement('div');
                newRow.className = 'multi-city-row mb-2 position-relative';
                newRow.innerHTML = `
                    <div class="misty-fields-grid">
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-departure me-2 icon-dim"></i> FROM</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-from" value="${lastTo}" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                        </div>
                        <div class="misty-swap-btn disabled"><i class="fas fa-sync-alt"></i></div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-arrival me-2 icon-dim"></i> TO</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-to" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                        </div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-calendar-day me-2 icon-dim"></i> DEPARTURE</label>
                            <input type="date" class="m-val-input-styled city-date">
                        </div>
                        <div class="misty-field-block bg-transparent border-0 opacity-0 d-none d-md-block" style="flex:1;"></div>
                        <div class="misty-field-block bg-transparent border-0 opacity-0 d-none d-md-block" style="flex:1;"></div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute end-0 top-50 translate-middle-y me-n2 remove-city-btn" onclick="removeCityRow(this)" style="z-index:10;"><i class="fas fa-times"></i></button>
                `;
                container.appendChild(newRow);
                
                const newDateInput = newRow.querySelector('.city-date');
                if (window.flatpickr) {
                    flatpickr(newDateInput, { dateFormat: "Y-m-d", minDate: "today", theme: "dark" });
                }
                
                updateRemoveButtons();
            };

            window.removeCityRow = (btn) => {
                btn.closest('.multi-city-row').remove();
                updateRemoveButtons();
            };

            function updateRemoveButtons() {
                const container = document.getElementById('multiCityRows');
                if (!container) return;
                const rows = container.querySelectorAll('.multi-city-row');
                rows.forEach((row, index) => {
                    const removeBtn = row.querySelector('.remove-city-btn');
                    if (removeBtn) {
                        if (rows.length > 2) removeBtn.classList.remove('d-none');
                        else removeBtn.classList.add('d-none');
                    }
                });
            }

            window.handleMultiCityInput = async (input) => {
                const term = input.value.trim();
                const results = input.nextElementSibling;
                if (term.length < 2) {
                    results.classList.add('d-none');
                    return;
                }
                try {
                    const response = await fetch(`https://autocomplete.travelpayouts.com/places2?locale=en&types[]=city&types[]=airport&term=${term}`);
                    const data = await response.json();
                    if (data && data.length > 0) {
                        results.innerHTML = data.slice(0, 6).map(place => `
                            <div class="autocomplete-item" onmousedown="selectMultiCityPlace(this, '${place.code}')">
                                <div class="code">${place.code}</div>
                                <div class="details">
                                    <div class="fw-bold">${place.name}</div>
                                    <div class="small opacity-50">${place.country_name}</div>
                                </div>
                            </div>
                        `).join('');
                        results.classList.remove('d-none');
                    }
                } catch (e) {}
            };

            window.selectMultiCityPlace = (item, code) => {
                const input = item.closest('.misty-field-block').querySelector('.autocomplete-input');
                const sub = item.closest('.misty-field-block').querySelector('.m-sub');
                if (input) {
                    input.value = code;
                    input.blur();
                }
                if (sub) {
                    const name = item.querySelector('.fw-bold').innerText;
                    const country = item.querySelector('.opacity-50').innerText;
                    sub.innerText = `${name}, ${country}`;
                }
                const results = item.closest('.autocomplete-results');
                if (results) results.classList.add('d-none');
            };

            // --- Search Logic ---
            const searchBtn = document.getElementById('mainSearchBtn');
            const resultsContainer = document.getElementById('searchResults');
            const resultsList = document.getElementById('resultsList');

            if (searchBtn) {
                searchBtn.addEventListener('click', async () => {
                    const activeTab = document.querySelector('.misty-tab.active');
                    let searchType = 'flights';
                    if (activeTab) {
                        const spanValue = activeTab.querySelector('span').innerText.toLowerCase();
                        if (spanValue.includes('hotel')) searchType = 'hotels';
                    }
                    
                    searchBtn.innerHTML = '<span>SEARCHING...</span><i class="fas fa-spinner fa-spin ms-2"></i>';
                    
                    if (searchType === 'hotels') {
                        const cityCode = document.getElementById('hotelDestinationInput').value.trim();
                        const checkIn = document.getElementById('hotelCheckIn').value;
                        const checkOut = document.getElementById('hotelCheckOut').value;
                        
                        if (!cityCode || !checkIn || !checkOut) {
                            searchBtn.innerHTML = '<span>SEARCH</span><i class="fas fa-search ms-2"></i>';
                            Swal.fire({
                                title: 'Missing Information',
                                text: 'Please enter a destination and stay dates.',
                                icon: 'warning',
                                confirmButtonColor: '#2563eb'
                            });
                            return;
                        }

                        const url = new URL(window.location.origin + '/hotels');
                        url.searchParams.append('city_code', cityCode);
                        url.searchParams.append('checkin', checkIn);
                        url.searchParams.append('checkout', checkOut);
                        url.searchParams.append('rooms', document.getElementById('roomCount').value || 1);
                        url.searchParams.append('adults', document.getElementById('adultCount').value || 2);
                        url.searchParams.append('children', document.getElementById('childCount').value || 0);

                        window.location.href = url.toString();
                        return;
                    }

                    if (searchType === 'flights') {
                        const adults = parseInt(document.getElementById('adultCount').value) || 0;
                        const children = parseInt(document.getElementById('childCount').value) || 0;
                        const infants = parseInt(document.getElementById('infantCount').value) || 0;
                        const totalPassengers = adults + children;
                        const cabinClass = document.getElementById('cabinClass').value;
                        
                        const tripType = document.querySelector('input[name="tripType"]:checked').value;
                        const url = new URL(window.location.origin + '/flights');
                        
                        url.searchParams.append('adults', adults);
                        url.searchParams.append('children', children);
                        url.searchParams.append('infants', infants);
                        url.searchParams.append('cabin_class', cabinClass);

                        // Trigger Group Booking Notice for > 9 passengers
                        if (totalPassengers > 9) {
                            searchBtn.innerHTML = '<span>SEARCH</span><i class="fas fa-search ms-2"></i>'; // Reset button state
                            
                            Swal.fire({
                                title: '<div class="text-navy fw-800">Group Booking Notice</div>',
                                html: `
                                    <div class="text-start p-2" style="font-size:14px; color:#4a5568; line-height:1.6;">
                                        <p class="fw-bold mb-3">Dear Traveler,</p>
                                        <p class="mb-3">In the airline industry, a maximum of 9 passengers can be booked in the same booking class within a single reservation.</p>
                                        <p class="mb-3">If your search includes more than 9 passengers, the remaining seats may be available in different booking classes with higher fares.</p>
                                        <p class="mb-2 fw-bold">You have the following options:</p>
                                        <ul class="ps-3 mb-0">
                                            <li class="mb-2">Select available seats across different classes at varying prices, or</li>
                                            <li>Submit a Group Booking Request to receive a uniform fare for all travelers</li>
                                        </ul>
                                    </div>
                                `,
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Continue with Available Options',
                                cancelButtonText: 'Request Group Booking',
                                confirmButtonColor: '#2563eb',
                                cancelButtonColor: '#1e40af',
                                reverseButtons: true,
                                background: '#fff',
                                customClass: {
                                    popup: 'rounded-4 shadow-lg border-0',
                                    title: 'fs-4',
                                    confirmButton: 'rounded-pill px-4 fw-700 py-2',
                                    cancelButton: 'rounded-pill px-4 fw-700 py-2'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // User wants to see available options (Instant Booking)
                                    finalizeFlightSearch(url, tripType, false);
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    // User wants to request group booking (Inquiry Form)
                                    finalizeFlightSearch(url, tripType, true);
                                }
                            });
                            return;
                        }

                        finalizeFlightSearch(url, tripType);
                        return;
                    }

                    // Helper to finalize and redirect
                    function finalizeFlightSearch(url, tripType, isGroupMode = false) {
                        if (isGroupMode) url.searchParams.append('group_mode', '1');
                        
                        if (tripType === 'multicity') {
                            url.searchParams.append('multi_city', '1');
                            const rows = document.querySelectorAll('.multi-city-row');
                            rows.forEach(row => {
                                const fromInput = row.querySelector('.city-from');
                                const toInput = row.querySelector('.city-to');
                                const dateInput = row.querySelector('.city-date');
                                
                                if (fromInput && toInput && dateInput) {
                                    url.searchParams.append('origin[]', fromInput.value);
                                    url.searchParams.append('destination[]', toInput.value);
                                    url.searchParams.append('departure_date[]', dateInput.value);
                                }
                            });
                        } else {
                            if (tripType === 'roundtrip') url.searchParams.append('trip', 'round');
                            
                            const originInput = document.getElementById('flightOriginInput');
                            const destinationInput = document.getElementById('flightDestinationInput');
                            const dateInput = document.getElementById('flightDate');
                            const returnDateInput = document.getElementById('flightReturnDate');

                            if (originInput) url.searchParams.append('origin', originInput.value);
                            if (destinationInput) url.searchParams.append('destination', destinationInput.value);
                            if (dateInput) url.searchParams.append('departure_date', dateInput.value);
                            
                            if (tripType === 'roundtrip' && returnDateInput && returnDateInput.value) {
                                url.searchParams.append('return_date', returnDateInput.value);
                            }
                        }
                        window.location.href = url.toString();
                    }

                    try {
                        let endpoint = '/api/flights';
                        let params = {};

                        if (searchType === 'flights') {
                            const origin = document.getElementById('flightOriginInput').value.trim().toUpperCase();
                            const destination = document.getElementById('flightDestinationInput').value.trim().toUpperCase();
                            const date = document.getElementById('flightDate').value;
                            const passengers = document.getElementById('passengerCount').value;

                            if (origin.length !== 3 || destination.length !== 3) {
                                throw new Error('Please select a city from the dropdown (need 3-letter IATA code).');
                            }

                            if (!origin || !destination || !date) {
                                throw new Error('Please fill in From, To and Departure Date.');
                            }

                            params = { origin, destination, departure_date: date, passengers };
                            endpoint = '/api/flights';
                        } else if (searchType === 'hotels') {
                            const city = document.getElementById('hotelDestinationInput').value.trim();
                            const checkIn = document.getElementById('hotelCheckIn').value;
                            const checkOut = document.getElementById('hotelCheckOut').value;
                            
                            if (!city || !checkIn || !checkOut) {
                                throw new Error('Please fill in Destination and Dates.');
                            }

                            params = { city, check_in: checkIn, check_out: checkOut };
                            endpoint = '/api/hotels';
                        }

                        const query = new URLSearchParams(params).toString();
                        const response = await fetch(`${endpoint}?${query}`, {
                            headers: { 'Accept': 'application/json' }
                        });
                        
                        const data = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(data.error || data.message || 'Search failed');
                        }

                        renderResults(searchType, data, params);
                        resultsContainer.classList.remove('d-none');
                        resultsContainer.scrollIntoView({ behavior: 'smooth' });

                    } catch (error) {
                        console.error('Search failed:', error);
                        alert(`Oops! ${error.message}`);
                    } finally {
                        searchBtn.innerHTML = '<span>SEARCH</span><i class="fas fa-search ms-2"></i>';
                    }
                });
            }

        function renderResults(type, data, params) {
            resultsList.innerHTML = '';
            
            if (!data || (Object.keys(data).length === 0 && !Array.isArray(data))) {
                resultsList.innerHTML = '<div class="col-12 text-center text-white-50 py-5"><i class="fas fa-exclamation-circle mb-3 d-block fs-1"></i>No flights found for this route and date.<br><small>Try changing the date or locations.</small></div>';
                return;
            }

            if (type === 'flights') {
                const flights = Object.values(data);
                flights.forEach(flightData => {
                    const items = Array.isArray(flightData) ? flightData : Object.values(flightData);
                    items.forEach(flight => {
                        const card = `
                            <div class="col-md-4 mb-4">
                                <div class="misty-glass-card p-4 h-100 d-flex flex-column border-primary-hover transition">
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <span class="badge bg-primary px-3 rounded-pill">Flight</span>
                                        <span class="text-white-50 fw-bold">#${flight.flight_number || 'N/A'}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <div class="code-box">${params.origin}</div>
                                        <div class="flex-grow-1 border-bottom border-dashed opacity-25"></div>
                                        <i class="fas fa-plane text-primary"></i>
                                        <div class="flex-grow-1 border-bottom border-dashed opacity-25"></div>
                                        <div class="code-box">${params.destination}</div>
                                    </div>
                                    <p class="text-white-50 small mb-4"><i class="far fa-calendar-alt me-2"></i>Departure: ${new Date(flight.departure_at || params.departure_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })}</p>
                                    <div class="mt-auto border-top border-white-10 pt-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-white-50">Price from</span>
                                            <div class="fs-3 fw-800 text-primary">$${flight.price}</div>
                                        </div>
                                        <button class="btn btn-primary w-100 py-3 rounded-pill fw-800 hvr-grow" onclick="book('flight', '${params.origin}', '${params.destination}', '${params.departure_date}')">
                                            SELECT FLIGHT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsList.innerHTML += card;
                    });
                });
            } else if (type === 'hotels') {
                if (data.error) {
                    resultsList.innerHTML = `<div class="col-12 text-center text-white-50 py-5">${data.error}</div>`;
                    return;
                }
                data.forEach(hotel => {
                    const card = `
                        <div class="col-md-4 mb-4">
                            <div class="misty-glass-card p-4 h-100 d-flex flex-column border-info-hover transition">
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <span class="badge bg-info text-white px-3 rounded-pill">Hotel</span>
                                    <div class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                </div>
                                <h5 class="text-white mb-2 fw-800">${hotel.hotelName || hotel.name}</h5>
                                <p class="text-white-50 small mb-4"><i class="fas fa-map-marker-alt me-2"></i>${hotel.locationName || params.city}</p>
                                <div class="mt-auto border-top border-white-10 pt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-white-50">Total price</span>
                                        <div class="fs-3 fw-800 text-info">$${hotel.price || 'Check Deal'}</div>
                                    </div>
                                    <button class="btn btn-info w-100 py-3 rounded-pill text-white fw-800 hvr-grow" onclick="book('hotel', '${hotel.locationName || params.city}', '', '', '${params.check_in}', '${params.check_out}')">
                                        VIEW DEAL
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    resultsList.innerHTML += card;
                });
            }
        }

        window.book = async (type, origin, destination, departureDate, checkIn, checkOut) => {
            const params = { type, origin, destination, departure_date: departureDate, city: origin, check_in: checkIn, check_out: checkOut };
            const query = new URLSearchParams(params).toString();
            const response = await fetch(`/api/booking-url?${query}`);
            const data = await response.json();
            if (data.booking_url) {
                window.open(data.booking_url, '_blank');
            }
        };

        // Custom style for code-box in JS injected cards
        const style = document.createElement('style');
        style.innerHTML = `
            .code-box { background: rgba(255,255,255,0.05); padding: 8px 12px; border-radius: 8px; font-weight: 800; font-size: 18px; color: #fff; border: 1px solid rgba(255,255,255,0.1); }
            .border-primary-hover:hover { border-color: var(--primary) !important; box-shadow: 0 0 20px rgba(var(--primary-rgb), 0.2); }
            .border-info-hover:hover { border-color: var(--info) !important; box-shadow: 0 0 20px rgba(var(--info-rgb), 0.2); }
            .transition { transition: all 0.3s ease; }
            .border-dashed { border-style: dashed !important; }
            .border-white-10 { border-color: rgba(255,255,255,0.1) !important; }
        `;
        document.head.appendChild(style);
    });
</script>

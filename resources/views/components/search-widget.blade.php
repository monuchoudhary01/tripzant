@props(['type' => 'flights'])

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{ asset('css/components/search-widget.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/components/search-widget.js') }}" defer></script>

<div class="misty-search-v3" id="searchWidget">

    <!-- Sophisticated Segmented Control -->
    <div class="misty-search-nav">
        <div class="nav-glow-pill"></div>
        @php
            $tabs = [
                ['id' => 'flights', 'label' => 'Flights', 'icon' => 'plane', 'type' => 'flights'],
                ['id' => 'hotels', 'label' => 'Hotels', 'icon' => 'hotel', 'type' => 'hotels'],
                ['id' => 'homestays', 'label' => 'Homestays', 'icon' => 'home', 'type' => 'homestays'],
                ['id' => 'holidays', 'label' => 'Packages', 'icon' => 'gem', 'type' => 'combos'],
                ['id' => 'trains', 'label' => 'Trains', 'icon' => 'train', 'type' => 'trains'],
                ['id' => 'cabs', 'label' => 'Cabs', 'icon' => 'car-side', 'type' => 'cabs'],
                ['id' => 'esim', 'label' => 'eSIM', 'icon' => 'sim-card', 'type' => 'esim'],
                ['id' => 'insurance', 'label' => 'Insurance', 'icon' => 'shield-alt', 'type' => 'insurance'],
            ];
            $firstActiveFound = false;
        @endphp

        @foreach($tabs as $tab)
            @php 
                $isEnabled = \App\Models\GlobalSetting::get("service_{$tab['id']}_enabled", '1') == '1';
                $isActive = !$firstActiveFound && $isEnabled;
                if ($isActive) $firstActiveFound = true;
            @endphp
            <div class="misty-tab {{ $isActive ? 'active' : '' }} {{ !$isEnabled ? 'disabled-service' : '' }}" 
                 onclick="{{ $isEnabled ? "switchSearch('{$tab['type']}', this)" : "" }}"
                 @if(!$isEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif>
                <div class="misty-tab-icon"><i class="fas fa-{{ $tab['icon'] }}"></i></div>
                <span>{{ $tab['label'] }}</span>
            </div>
        @endforeach
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
                <button class="m-mode-btn" onclick="switchFlightMode('baggage', this)">
                    <i class="fas fa-suitcase-rolling"></i> Search by baggage
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

         <!-- Unified Budget Modifier (Visible only in Budget Mode) -->
        <div class="misty-budget-row d-none animate__animated animate__fadeInDown mb-4" id="budgetModifierRow">
            <div class="d-flex align-items-center justify-content-left">
                <div class="misty-budget-card-unified">
                    <div class="">
                        <div class="budget-label-group">
                            <i class="fas fa-wallet me-2 text-primary"></i>
                            <span class="fw-900 text-navy uppercase" style="font-size: 11px; letter-spacing: 1px;">MAX BUDGET (PER PERSON)</span>
                        </div>
                        <div class="budget-input-box d-flex align-items-center gap-2">
                            <span class="fs-4 fw-900 text-primary">₹</span>
                            <input type="number" id="globalMaxBudget" class="m-budget-unified-input" value="20000" step="500">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Baggage Modifier (Visible only in Baggage Mode) -->
        <div class="misty-budget-row d-none animate__animated animate__fadeInDown mb-4" id="baggageModifierRow">
            <div class="d-flex align-items-center justify-content-left w-50">
                <div class="misty-budget-card-unified w-100" style="border: 1px dashed #10b981; min-height: auto; padding: 12px 18px; background: rgba(16, 185, 129, 0.05); border-radius: 12px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="budget-label-group d-flex align-items-center mb-0">
                            <i class="fas fa-suitcase-rolling me-2" style="color: #10b981 !important; font-size: 14px;"></i>
                            <span class="fw-900 text-navy uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #10b981 !important;">AIRLINE BAGGAGE ALLOWANCE</span>
                        </div>
                        <div class="budget-input-box position-relative" style="width: auto; min-width: 140px;">
                            <select id="globalMaxBaggage" class="form-select border-0 shadow-none fw-800 text-navy p-0 cursor-pointer text-end pe-3" style="outline: none; background: transparent; box-shadow: none; font-size: 14px;">
                                <option value="">Any Baggage</option>
                                <option value="5">5 KG Baggage</option>
                                <option value="7">7 KG Baggage</option>
                                <option value="10">10 KG Baggage</option>
                                <option value="15">15 KG Baggage</option>
                                <option value="20">20 KG Baggage</option>
                                <option value="25">25 KG Baggage</option>
                                <option value="30">30 KG (2x15 KG)</option>
                                <option value="35">35 KG (2x17.5)</option>
                                <option value="40">40 KG (2x20 KG)</option>
                            </select>
                        </div>
                    </div>
                </div>
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
                    <button type="button" class="btn btn-danger rounded-circle position-absolute top-50 translate-middle-y remove-city-btn d-none" onclick="removeCityRow(this)" style="z-index:10;"><i class="fas fa-times"></i></button>
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

        <!-- Unique Fare Badges -->
        <div class="misty-fares-section TS-5 mt-3" id="faresSection">
            <div class="d-flex align-items-center gap-3 w-100" id="flightSpecialFares">
                <h6 class="fares-title text-nowrap mb-0 border-end pe-3 border-2 border-primary border-opacity-25" style="letter-spacing: 1px;">SPECIAL FARES <span><i class="fas fa-sparkles"></i></span></h6>
                <div class="misty-fare-row flex-grow-1">
                    <div class="m-fare-item active" onclick="selectFareType('regular', this)" data-fare="regular">
                        <div class="m-fare-name">Regular</div>
                        <div class="m-fare-info">Best dynamic rates</div>
                    </div>
                    <div class="m-fare-item" onclick="selectFareType('student', this)" data-fare="student">
                        <div class="m-fare-name">Student <span class="m-pop">POP</span></div>
                        <div class="m-fare-info">Extra bag + discounts</div>
                    </div>
                    <div class="m-fare-item" onclick="selectFareType('senior', this)" data-fare="senior">
                        <div class="m-fare-name">Senior</div>
                        <div class="m-fare-info">Assistance + flat off</div>
                    </div>
                    <div class="m-fare-item" onclick="selectFareType('armed_forces', this)" data-fare="armed_forces">
                        <div class="m-fare-name">Armed Forces</div>
                        <div class="m-fare-info">Flat off for heroes</div>
                    </div>
                </div>
            </div>

            <!-- Hotel Special Features -->
            <div id="hotelSpecials" class="animate-up d-none">
                <div class="d-flex align-items-center gap-3 w-100">
                    <p class="fares-title text-nowrap mb-0 border-end pe-3 border-2 border-primary border-opacity-25" style="letter-spacing: 1px;">HOTEL SPECIALS</p>
                    <div class="misty-fare-row flex-grow-1">
                        <div class="m-fare-item active" onclick="selectFareType('regular', this)" data-fare="regular">
                            <div class="m-fare-name">Regular</div>
                            <div class="m-fare-info">Best dynamic rates</div>
                        </div>
                        <div class="m-fare-item" onclick="selectFareType('corporate', this)" data-fare="corporate">
                            <div class="m-fare-name">Corporate</div>
                            <div class="m-fare-info">GST Invoice + Low Fares</div>
                        </div>
                        <div class="m-fare-item" onclick="selectFareType('couples', this)" data-fare="couples">
                            <div class="m-fare-name">Couples</div>
                            <div class="m-fare-info">Romantic &amp; Safe Stays</div>
                        </div>
                        <div class="m-fare-item" onclick="selectFareType('refundable', this)" data-fare="refundable">
                            <div class="m-fare-name">Refundable</div>
                            <div class="m-fare-info">Free cancellation deals</div>
                        </div>
                    </div>
                </div>
                
              
            </div>
        </div>

        <!-- World-Class Floating Search Button -->
        <div class="misty-search-glow-wrap">
            <button class="misty-search-btn-v3" id="mainSearchBtn">
                <span>SEARCH</span>
                <i class="fas fa-search ms-2"></i>
            </button>
        </div>

        </div>



 </div>
<!-- Load Flatpickr -->



   
    </div>

    <!-- Dynamic Results Container -->
    <div id="searchResults" class="misty-search-results d-none container py-4">
        <h4 class="mb-4 text-white">Search Results</h4>
        <div id="resultsList" class="row g-4 d-flex flex-wrap">
            <!-- Results will be injected here -->
        </div>
    </div>
</div>


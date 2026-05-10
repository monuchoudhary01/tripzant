
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        


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

        document.getElementById('budgetModifierRow')?.classList.add('d-none');
        document.getElementById('baggageModifierRow')?.classList.add('d-none');
    } else {
        flightModeSwitcher.classList.add('d-none');
        faresSection.classList.add('d-none');
        flightsTypeRow.classList.add('d-none');
        specialFares?.classList.add('d-none');
        hotelSpecials?.classList.add('d-none');

        document.getElementById('budgetModifierRow')?.classList.add('d-none');
        document.getElementById('baggageModifierRow')?.classList.add('d-none');
    }

    const fieldsContainer = document.getElementById('searchFields');
    fieldsContainer.style.opacity = '0';
    fieldsContainer.style.transform = 'scale(0.98)';
    
    setTimeout(() => {
        ['flightsFields', 'hotelsFields', 'homestaysFields', 'combosFields', 'trainsFields', 'cabsFields', 'esimFields', 'insuranceFields'].forEach(id => {
            const grid = document.getElementById(id);
            if (grid) grid.classList.add('d-none');
        });
        
        // If switching to flight, handle Multi-City specifically
        if (type === 'flights') {
            const tripType = document.querySelector('input[name="tripType"]:checked')?.value;
            const multiCityFields = document.getElementById('multiCityFields');
            const flightsFields = document.getElementById('flightsFields');
            const budgetModifierRow = document.getElementById('budgetModifierRow');
            
            const modeBtn = document.querySelector('.m-mode-btn.active');
            const isBudget = modeBtn ? modeBtn.innerText.toLowerCase().includes('budget') : false;
            const isBaggage = modeBtn ? modeBtn.innerText.toLowerCase().includes('baggage') : false;

            const baggageModifierRow = document.getElementById('baggageModifierRow');

            if (tripType === 'multicity') {
                if (flightsFields) flightsFields.classList.add('d-none');
                if (multiCityFields) multiCityFields.classList.remove('d-none');
                if (budgetModifierRow) budgetModifierRow.classList.add('d-none'); // Multi-city doesn't support budget mode usually
                if (baggageModifierRow) baggageModifierRow.classList.add('d-none');
            } else {
                if (multiCityFields) multiCityFields.classList.add('d-none');
                if (flightsFields) flightsFields.classList.remove('d-none');
                
                if (isBudget) {
                    if (budgetModifierRow) budgetModifierRow.classList.remove('d-none');
                    if (baggageModifierRow) baggageModifierRow.classList.add('d-none');
                } else if (isBaggage) {
                    if (budgetModifierRow) budgetModifierRow.classList.add('d-none');
                    if (baggageModifierRow) baggageModifierRow.classList.remove('d-none');
                } else {
                    if (budgetModifierRow) budgetModifierRow.classList.add('d-none');
                    if (baggageModifierRow) baggageModifierRow.classList.add('d-none');
                }
            }
        } else {
            const targetGrid = document.getElementById(type + 'Fields');
            if (targetGrid) targetGrid.classList.remove('d-none');
            const multiCityFields = document.getElementById('multiCityFields');
            if (multiCityFields) multiCityFields.classList.add('d-none');
        }
        
        fieldsContainer.style.opacity = '1';
        fieldsContainer.style.transform = 'scale(1)';
    }, 400);
}

function switchFlightMode(mode, el) {
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

    // Budget Mode Update
    const budgetTripClassDisplay = document.getElementById('budgetTripClass');
    if (budgetTripClassDisplay) budgetTripClassDisplay.innerText = className;
}

function selectFareType(type, el) {
    const parent = el.closest('.misty-fare-row') || el.closest('.d-flex');
    if (parent) {
        parent.querySelectorAll('.m-fare-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');
    }
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
    
    // Budget Mode Update
    const budgetDisplayCount = document.getElementById('budgetTravellerCount');
    if (budgetDisplayCount) budgetDisplayCount.innerText = travellers;
    
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
            flatpickr("#flightBudgetDate", fpConfig);
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
            setupAutocomplete('flightBudgetOriginInput', 'flightBudgetOriginResults', 'flightBudgetOriginSub');
            setupAutocomplete('flightBudgetDestinationInput', 'flightBudgetDestinationResults', 'flightBudgetDestinationSub');
            setupAutocomplete('hotelDestinationInput', 'hotelDestinationResults', 'hotelDestinationSub');

            // --- Initialize Display & First Active Tab ---
            updateTotalPassengers();
            
            const activeTabOnLoad = document.querySelector('.misty-tab.active');
            if (activeTabOnLoad) {
                // Determine the type from the onclick attribute or just call switchSearch
                // The cleanest way is to trigger the click
                activeTabOnLoad.click();
            }

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

            window.swapBudgetLocations = () => {
                const fromInput = document.getElementById('flightBudgetOriginInput');
                const toInput = document.getElementById('flightBudgetDestinationInput');
                const fromSub = document.getElementById('flightBudgetOriginSub');
                const toSub = document.getElementById('flightBudgetDestinationSub');

                if (fromInput && toInput) {
                    const tempVal = fromInput.value;
                    fromInput.value = toInput.value;
                    toInput.value = tempVal;

                    const tempSub = fromSub.innerText;
                    fromSub.innerText = toSub.innerText;
                    toSub.innerText = tempSub;
                }
            };

            // --- Multi City Logic ---
            window.addCityRow = () => {
                const container = document.getElementById('multiCityRows');
                if (!container) return;
                const rowCount = container.querySelectorAll('.multi-city-row').length;
                if (rowCount >= 6) return;
                
                const lastRow = container.lastElementChild;
                const lastToInput = lastRow.querySelector('.city-to');
                const lastTo = lastToInput.value;
                const lastToSub = lastToInput.closest('.misty-field-block').querySelector('.m-sub')?.innerText || "";
                
                const lastDateVal = lastRow.querySelector('.city-date').value;
                let nextDateStr = "";
                if (lastDateVal) {
                    let nextDate = new Date(lastDateVal);
                    nextDate.setDate(nextDate.getDate() + 2);
                    nextDateStr = nextDate.toISOString().split('T')[0];
                }

                const newRow = document.createElement('div');
                newRow.className = 'multi-city-row mb-2 position-relative animate__animated animate__fadeInUp';
                newRow.innerHTML = `
                    <div class="misty-fields-grid">
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-departure me-2 icon-dim"></i> FROM</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-from" value="${lastTo}" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                            <div class="m-sub">${lastToSub}</div>
                        </div>
                        <div class="misty-swap-btn disabled"><i class="fas fa-sync-alt"></i></div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-plane-arrival me-2 icon-dim"></i> TO</label>
                            <input type="text" class="m-val-input-text autocomplete-input city-to" placeholder="City" autocomplete="off" oninput="handleMultiCityInput(this)">
                            <div class="autocomplete-results d-none"></div>
                            <div class="m-sub">Select City</div>
                        </div>
                        <div class="misty-field-block">
                            <label><i class="fas fa-calendar-day me-2 icon-dim"></i> DEPARTURE</label>
                            <input type="date" class="m-val-input-styled city-date" value="${nextDateStr}">
                        </div>
                        <div class="misty-field-block bg-transparent border-0 opacity-0 d-none d-md-block" style="flex:1;"></div>
                        <div class="misty-field-block bg-transparent border-0 opacity-0 d-none d-md-block" style="flex:1;"></div>
                    </div>
                    <button type="button" class="btn btn-danger rounded-circle position-absolute top-50 translate-middle-y remove-city-btn" onclick="removeCityRow(this)" style="z-index:10;"><i class="fas fa-times"></i></button>
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
                        const activeModeBtn = document.querySelector('.m-mode-btn.active');
                        const modeText = activeModeBtn ? activeModeBtn.innerText.toLowerCase() : 'date';
                        const isBudgetMode = modeText.includes('budget');
                        const isBaggageMode = modeText.includes('baggage');
                        
                        const url = new URL(window.location.origin + '/flights');
                        
                        url.searchParams.append('adults', adults);
                        url.searchParams.append('children', children);
                        url.searchParams.append('infants', infants);
                        url.searchParams.append('cabin_class', cabinClass);

                        if (isBudgetMode) {
                            const maxBudget = document.getElementById('globalMaxBudget').value;
                            url.searchParams.append('max_budget', maxBudget);
                        }

                        if (isBaggageMode) {
                            const baggage = document.getElementById('globalMaxBaggage').value;
                            if (baggage) {
                                url.searchParams.append('baggage', baggage);
                            }
                        }

                        const activeFare = document.querySelector('#flightSpecialFares .m-fare-item.active');
                        if (activeFare && activeFare.getAttribute('data-fare') !== 'regular') {
                            url.searchParams.append('fare_type', activeFare.getAttribute('data-fare'));
                        }

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



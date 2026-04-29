@extends('layouts.app')

@section('title', 'Select Your Seats | Amadeus Altea')

@section('styles')
<style>
    :root {
        --amadeus-bg: #f5f7fa;
        --amadeus-blue: #005eb8;
        --amadeus-blue-light: #e6f0f8;
        --amadeus-text: #333333;
        --amadeus-gray: #7b8e9b;
        --amadeus-border: #d1d9e0;
        --seat-standard: #ffffff;
        --seat-preferred: #fff8e1;
        --seat-occupied: #e0e6ed;
        --seat-selected: #16a34a;
    }

    /* Force the Altea Background */
    body {
        background-color: var(--amadeus-bg) !important;
        color: var(--amadeus-text) !important;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .amadeus-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Pro Airplane Canvas */
    .aircraft-canvas {
        background: white;
        border: 1px solid var(--amadeus-border);
        border-radius: 120px 120px 40px 40px;
        max-width: 440px;
        margin: 0 auto;
        padding: 80px 40px 60px 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        position: relative;
    }

    .aircraft-nose {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 140px;
        height: 60px;
        border: 2px solid var(--amadeus-border);
        border-radius: 60px 60px 10px 10px;
        background: #fafafa;
    }

    /* Amadeus Grid */
    .seat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr) 30px repeat(3, 1fr);
        gap: 10px;
        margin-top: 30px;
    }

    .seat {
        width: 36px;
        height: 36px;
        background: var(--seat-standard);
        border: 1.5px solid var(--amadeus-gray);
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        font-weight: 700;
        transition: all 0.2s;
        color: var(--amadeus-text);
        position: relative;
    }

    .seat:hover:not(.occupied) {
        border-color: var(--amadeus-blue);
        background: var(--amadeus-blue-light);
    }

    .seat.occupied {
        background: var(--seat-occupied);
        border-color: #cbd5e0;
        cursor: not-allowed;
        color: #a0aec0;
    }
    .seat.occupied::after {
        content: '×';
        position: absolute;
        font-size: 14px;
        font-weight: 400;
    }

    .seat.selected {
        background: var(--seat-selected) !important;
        border-color: #111827 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
    }

    .seat.extra-legroom { 
        border-color: var(--amadeus-blue); 
        border-style: dashed;
        background: #fdfdfd;
    }
    .seat.front-row { 
        border-color: #f97316; 
        background: var(--seat-preferred);
    }

    .row-label {
        grid-column: 4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 800;
        color: var(--amadeus-gray);
    }

    /* Pro Sidebar Summary */
    .altea-sidebar {
        background: white;
        border: 1px solid var(--amadeus-border);
        border-radius: 12px;
        padding: 25px;
        height: min-content;
        position: sticky;
        top: 90px;
    }

    .pax-row {
        padding: 12px 15px;
        border: 1px solid var(--amadeus-border);
        border-radius: 8px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fcfcfc;
    }
    .pax-row.active {
        border-color: var(--amadeus-blue);
        border-width: 2px;
        background: var(--amadeus-blue-light);
        box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.1);
    }
    .pax-row.assigned {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .btn-finalize {
        background: var(--amadeus-blue);
        color: white;
        border: none;
        width: 100%;
        padding: 16px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 20px;
        transition: 0.3s;
    }
    .btn-finalize:hover:not(:disabled) {
        background: #004d99;
        transform: translateY(-1px);
    }
    .btn-finalize:disabled {
        background: #aab8c2;
        cursor: not-allowed;
    }

    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; color: var(--amadeus-gray); }
    .legend-box { width: 14px; height: 14px; border-radius: 3px; border: 1px solid var(--amadeus-gray); }
</style>
@endsection

@section('content')
<div class="amadeus-wrapper">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold text-navy mb-1">Passenger Seating</h2>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary">AMADEUS ALTEA</span>
                <span class="text-muted small fw-bold" id="flightInfoLabel">Flight Allocation HK1</span>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <p class="text-muted small fw-bold mb-0">Total Travelers: <span id="paxCount">0</span></p>
        </div>
    </div>

    <div class="row g-5">
        <!-- Aircraft Layout -->
        <div class="col-lg-7">
            <div class="d-flex justify-content-center gap-4 mb-4">
                <div class="legend-item"><div class="legend-box" style="background:#fff"></div> Standard</div>
                <div class="legend-item"><div class="legend-box" style="border-style:dashed; border-color:var(--amadeus-blue)"></div> Premium</div>
                <div class="legend-item"><div class="legend-box" style="background:var(--seat-occupied)"></div> Taken</div>
            </div>

            <div class="aircraft-canvas">
                <div class="aircraft-nose"></div>
                <div class="seat-grid" id="seatMap">
                    <!-- JS Render -->
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-5">
            <div class="altea-sidebar">
                <h6 class="fw-bold text-uppercase mb-4 text-primary" style="font-size: 13px; letter-spacing: 1px;">Passenger Manifest</h6>
                
                <div id="passengerList">
                    <!-- Dynamic List -->
                </div>

                <div class="mt-5 border-top pt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small fw-bold">Total Flight Fare</span>
                        <span id="baseFareText" class="fw-bold">₹0</span>
                    </div>
                    <div id="seatExtrasText">
                        <!-- Extra seat costs -->
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                        <span class="fw-bold">TOTAL PAYABLE</span>
                        <span id="finalPriceText" class="fs-4 fw-bold text-primary">₹0</span>
                    </div>
                </div>

                <button class="btn-finalize" id="proceedBtn" onclick="saveSeatsAndProceed()" disabled>
                    CONFIRM SELECTION <i class="fas fa-check-circle ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const passengers = @json($passengers);
    const flightData = @json($flight);
    const legs = @json($legs);
    
    let currentLegIndex = 0;
    let currentPassengerIndex = 0;
    
    // Structure: { legIndex: { paxIndex: { seatId, price, type } } }
    let selectionsByLeg = {}; 
    
    let baseFare = {{ $booking->total_amount ?? 0 }}; 

    // Dynamic Seat pricing and config
    const seatTypes = {
        legroom: { label: 'Premium', price: 1500, class: 'extra-legroom' },
        front: { label: 'Preferred', price: 800, class: 'front-row' },
        regular: { label: 'Standard', price: 0, class: '' }
    };

    function init() {
        if (!passengers || !passengers.length) {
            // Fallback: try to recover travelers from api_booking_details stored in booking
            @if($booking && $booking->api_booking_details)
            const apiDetails = @json(json_decode($booking->api_booking_details, true));
            const recoveredTravelers = apiDetails?.travelers || [];
            if (recoveredTravelers.length > 0) {
                // Inject recovered travelers into the passengers array
                recoveredTravelers.forEach(t => passengers.push(t));
                console.log('Recovered ' + passengers.length + ' travelers from api_booking_details');
            }
            @endif

            if (!passengers || !passengers.length) {
                Swal.fire({
                    title: 'Traveler Data Not Found',
                    html: `<p class="text-muted">Traveler details is booking ke liye load nahi ho saki.</p>
                           <p class="small text-muted mb-0">Aap seat selection skip karke <b>My Bookings</b> page pe ja sakte hain.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'My Bookings',
                    cancelButtonText: 'Stay Here',
                    confirmButtonColor: '#005eb8'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = '/dashboard/bookings';
                });
                return;
            }
        }

        // Initialize selections for all legs
        legs.forEach((leg, idx) => {
            selectionsByLeg[idx] = {};
        });

        renderLegSwitcher();
        updateFlightHeader();
        document.getElementById('paxCount').innerText = passengers.length;
        renderPaxList();
        renderSeatMap();
        updateSummary();
    }

    function renderLegSwitcher() {
        if (legs.length <= 1) return; // Don't show switcher if only one leg

        const switcherContainer = document.createElement('div');
        switcherContainer.id = 'legSwitcher';
        switcherContainer.className = 'd-flex gap-2 mb-4 p-2 bg-white rounded-4 shadow-sm border overflow-auto w-100 justify-content-center';
        
        switcherContainer.innerHTML = legs.map((leg, idx) => `
            <button class="btn rounded-3 px-3 py-2 fw-800 transition-all ${idx === currentLegIndex ? 'btn-primary' : 'btn-light text-muted'}" 
                    style="font-size: 12px; min-width: 140px; white-space: nowrap;"
                    onclick="switchLeg(${idx})">
                <div class="x-small opacity-75 mb-1">FLIGHT ${idx+1}</div>
                <i class="fas fa-plane me-1"></i>
                ${leg.dep_city} → ${leg.arr_city}
            </button>
        `).join('');

        // Prepend to the wrapper so it's always at the top
        const wrapper = document.querySelector('.amadeus-wrapper');
        if (wrapper) wrapper.prepend(switcherContainer);
    }

    function updateFlightHeader() {
        const leg = legs[currentLegIndex];
        if (leg) {
            document.getElementById('flightInfoLabel').innerText = `${leg.airline} | Flight ${leg.flight_number} | ${leg.dep_city} → ${leg.arr_city}`;
        }
    }

    function switchLeg(index) {
        if (index === currentLegIndex) return;
        
        currentLegIndex = index;
        currentPassengerIndex = 0; // Reset pax focus on leg change? Or keep same? Let's reset for clarity.
        
        // Update Switcher UI
        const buttons = document.querySelectorAll('#legSwitcher button');
        buttons.forEach((btn, idx) => {
            if (idx === currentLegIndex) {
                btn.classList.replace('btn-light', 'btn-primary');
                btn.classList.add('shadow-sm');
                btn.classList.remove('text-muted');
            } else {
                btn.classList.replace('btn-primary', 'btn-light');
                btn.classList.remove('shadow-sm');
                btn.classList.add('text-muted');
            }
        });

        updateFlightHeader();
        renderPaxList();
        renderSeatMap();
        updateSummary();
    }

    function renderPaxList() {
        const container = document.getElementById('passengerList');
        const currentLegSelections = selectionsByLeg[currentLegIndex];

        container.innerHTML = passengers.map((p, index) => {
            const isAssigned = currentLegSelections[index];
            return `
                <div class="pax-row ${index === currentPassengerIndex ? 'active animate__animated animate__pulse' : ''} ${isAssigned ? 'assigned' : ''}" 
                     onclick="switchPassenger(${index})">
                    <div>
                        <div class="small fw-bold opacity-50">TRAVELER ${index+1}</div>
                        <div class="fw-bold">${p.first_name || 'Manifest'} ${p.last_name || 'Entry'}</div>
                    </div>
                    <div class="text-end">
                        ${isAssigned ? `<span class="badge bg-success">${isAssigned.seatId}</span>` : '<span class="text-muted x-small">No Seat Selected</span>'}
                    </div>
                </div>`;
        }).join('');
    }

    function switchPassenger(index) {
        currentPassengerIndex = index;
        renderPaxList();
    }

    function renderSeatMap() {
        const grid = document.getElementById('seatMap');
        grid.innerHTML = '';
        grid.className = 'seat-grid animate__animated animate__fadeIn';
        
        const leg = legs[currentLegIndex];
        const currentLegSelections = selectionsByLeg[currentLegIndex];

        // Dynamic Columns based on Cabin/Airline
        let columns = ['A', 'B', 'C', 'D', 'E', 'F'];
        const isBusiness = (leg && (leg.cabin === 'BUSINESS' || leg.cabin === 'FIRST'));
        
        if (isBusiness) {
            columns = ['A', 'C', 'D', 'F']; // 2+2 layout for Business
        }

        const maxRows = isBusiness ? 5 : 30; // Fewer rows for Business
        
        for (let row = 1; row <= maxRows; row++) {
            grid.innerHTML += `<div class="row-label">${row}</div>`;

            columns.forEach((letter, i) => {
                const seatId = `${row}${letter}`;
                
                // Deterministic "Taken" seats based on flight number + leg index to feel dynamic
                const seed = (leg ? leg.flight_number.toString().length : 0) + row + i + currentLegIndex;
                const isOccupied = (seed % 7 === 0) || (seed % 11 === 0);
                
                let type = 'regular';
                if (row === 1 || row === 11) type = 'legroom';
                else if (row <= 4) type = 'front';

                const typeData = seatTypes[type];
                const isSelected = Object.values(currentLegSelections).some(s => s.seatId === seatId);

                // Grid column positioning logic
                let gridCol = i + 1;
                if (columns.length === 6) {
                    gridCol = (i < 3) ? i + 1 : i + 2; 
                } else {
                    gridCol = (i < 2) ? i + 1 : i + 2;
                }

                const seatHtml = `
                    <div class="seat ${isOccupied ? 'occupied' : ''} ${typeData.class} ${isSelected ? 'selected' : ''}" 
                         style="grid-column: ${gridCol}"
                         onclick="selectSeat('${seatId}', '${type}', ${isOccupied})">
                        ${letter}
                    </div>
                `;
                grid.innerHTML += seatHtml;
            });
        }
    }

    function selectSeat(seatId, type, isOccupied) {
        if (isOccupied) return;

        const currentLegSelections = selectionsByLeg[currentLegIndex];

        // Prevent picking same seat for different passengers on the SAME leg
        for (let pIdx in currentLegSelections) {
            if (currentLegSelections[pIdx].seatId === seatId && parseInt(pIdx) !== currentPassengerIndex) {
                Swal.fire({
                    title: 'Allocated',
                    text: 'This seat has already been assigned to another traveler for this flight.',
                    icon: 'info',
                    confirmButtonColor: '#005eb8'
                });
                return;
            }
        }

        const typeData = seatTypes[type];
        currentLegSelections[currentPassengerIndex] = {
            seatId: seatId,
            price: typeData.price,
            type: typeData.label
        };

        // Auto-advance to next passenger if not at end
        if (currentPassengerIndex < passengers.length - 1) {
            currentPassengerIndex++;
        }

        renderSeatMap();
        renderPaxList();
        updateSummary();
    }

    function updateSummary() {
        const seatExtrasText = document.getElementById('seatExtrasText');
        const baseFareText = document.getElementById('baseFareText');
        let seatTotal = 0;
        
        baseFareText.innerText = `₹${baseFare.toLocaleString()}`;

        let html = '';
        let totalAssignedAllLegs = 0;

        legs.forEach((leg, legIdx) => {
            const legSelections = selectionsByLeg[legIdx];
            const legTotal = Object.values(legSelections).length;
            totalAssignedAllLegs += legTotal;

            Object.keys(legSelections).forEach(pIdx => {
                const seat = legSelections[pIdx];
                if (seat && seat.price > 0) {
                    seatTotal += seat.price;
                    html += `
                        <div class="d-flex justify-content-between mb-1 small text-muted">
                            <span>Leg ${legIdx+1}: Seat ${seat.seatId}</span>
                            <span>+₹${seat.price.toLocaleString()}</span>
                        </div>
                    `;
                }
            });
        });

        seatExtrasText.innerHTML = html;
        const total = baseFare + seatTotal;
        document.getElementById('finalPriceText').innerText = `₹${total.toLocaleString()}`;

        const btn = document.getElementById('proceedBtn');
        // Button only enables when ALL passengers have a seat on ALL legs
        const totalRequired = passengers.length * legs.length;
        const allAssigned = (totalAssignedAllLegs === totalRequired);
        
        btn.disabled = !allAssigned;
        
        if (allAssigned) {
            btn.classList.add('animate__animated', 'animate__pulse', 'animate__infinite');
        } else {
            btn.classList.remove('animate__animated', 'animate__pulse', 'animate__infinite');
        }
    }

    function saveSeatsAndProceed() {
        // Re-validate before proceeding
        const totalRequired = passengers.length * legs.length;
        let totalAssigned = 0;
        legs.forEach((leg, legIdx) => {
            totalAssigned += Object.values(selectionsByLeg[legIdx] || {}).length;
        });
        if (totalAssigned < totalRequired) {
            const remaining = totalRequired - totalAssigned;
            Swal.fire({
                title: 'Seat Selection Incomplete',
                html: `<p class="mb-1">Please select a seat for <b>${remaining}</b> more traveler(s).</p>
                       <p class="text-muted small mb-0">Click on any available seat in the map.</p>`,
                icon: 'warning',
                confirmButtonColor: '#005eb8',
                confirmButtonText: 'Select Seats'
            });
            return;
        }
        localStorage.setItem('selected_seats_multi', JSON.stringify(selectionsByLeg));
        
        // Log SSR seat assignments (safely guard against null legs)
        console.group("🚀 Amadeus Multi-Leg Seat Assignment Logs (SSR SEAT)");
        legs.forEach((leg, legIdx) => {
            const legSelections = selectionsByLeg[legIdx];
            const legLabel = leg ? `${leg.dep_city || leg.departure_city || 'DEP'} → ${leg.arr_city || leg.arrival_city || 'ARR'}` : `Segment ${legIdx + 1}`;
            console.log(`%cLEG ${legIdx+1}: ${legLabel}`, "color: #0b3d61; font-weight: 900; background: #e6f0f8; padding: 2px 10px; border-radius: 4px;");
            
            passengers.forEach((p, pIdx) => {
                const seat = legSelections?.[pIdx];
                if (seat) {
                    const ssrLine = `SSR SEAT HK1 /${seat.seatId}/P${pIdx + 1}/SEG${legIdx + 1}`;
                    console.log(`%c  Traveler ${pIdx+1} (${p.first_name || 'PAX'}): ${ssrLine}`, "color: #005eb8; font-weight: bold;");
                }
            });
        });
        console.groupEnd();

        const totalSeats = passengers.length * Math.max(legs.length, 1);
        const bookingRef = "{{ $reference ?? '' }}";

        Swal.fire({
            title: '✅ Seats Confirmed!',
            html: `<p class="mb-1">Successfully assigned <b>${totalSeats}</b> seat(s).</p>
                   <p class="text-muted small mb-0">Proceeding to add-ons & extras...</p>`,
            icon: 'success',
            confirmButtonColor: '#005eb8',
            confirmButtonText: 'Continue →',
            timer: 3000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = '/add-ons' + (bookingRef ? '?reference=' + bookingRef : '');
        });
    }

    document.addEventListener('DOMContentLoaded', init);
</script>
@endsection

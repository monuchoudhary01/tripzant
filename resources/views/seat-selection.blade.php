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
        top: 20px;
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
                <span class="text-muted small fw-bold">Flight Allocation HK1</span>
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
    const passengers = JSON.parse(localStorage.getItem('last_booking_passengers') || '[]');
    let currentPassengerIndex = 0;
    let selectedSeatsByPassenger = {}; 
    let baseFare = 80530; 

    const seatTypes = {
        legroom: { label: 'Premium', price: 1500, class: 'extra-legroom' },
        front: { label: 'Preferred', price: 800, class: 'front-row' },
        regular: { label: 'Standard', price: 0, class: '' }
    };

    function init() {
        if (!passengers.length) {
            Swal.fire('Error', 'Manifest not found. Please re-enter traveler details.', 'error');
            return;
        }

        document.getElementById('paxCount').innerText = passengers.length;
        renderPaxList();
        renderSeatMap();
        updateSummary();
    }

    function renderPaxList() {
        const container = document.getElementById('passengerList');
        container.innerHTML = passengers.map((p, index) => {
            const isAssigned = selectedSeatsByPassenger[index];
            return `
                <div class="pax-row ${index === currentPassengerIndex ? 'active' : ''} ${isAssigned ? 'assigned' : ''}" 
                     onclick="switchPassenger(${index})">
                    <div>
                        <div class="small fw-bold opacity-50">TRAVELER ${index+1}</div>
                        <div class="fw-bold">${p.first_name || 'Manifest'} ${p.last_name || 'Entry'}</div>
                    </div>
                    <div class="text-end">
                        ${isAssigned ? `<span class="badge bg-success">${isAssigned.seatId}</span>` : '<span class="text-muted x-small">No Seat</span>'}
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
        
        for (let row = 1; row <= 25; row++) {
            grid.innerHTML += `<div class="row-label">${row}</div>`;

            ['A', 'B', 'C', 'D', 'E', 'F'].forEach((letter, i) => {
                const seatId = `${row}${letter}`;
                const isOccupied = (row === 3 && letter === 'A') || (row === 5 && letter === 'F') || (Math.random() < 0.1 && row > 10);
                
                let type = 'regular';
                if (row === 1 || row === 12) type = 'legroom';
                else if (row <= 4) type = 'front';

                const typeData = seatTypes[type];
                const isSelected = Object.values(selectedSeatsByPassenger).some(s => s.seatId === seatId);

                const seatHtml = `
                    <div class="seat ${isOccupied ? 'occupied' : ''} ${typeData.class} ${isSelected ? 'selected' : ''}" 
                         style="grid-column: ${i < 3 ? i + 1 : i + 2}"
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

        for (let pIdx in selectedSeatsByPassenger) {
            if (selectedSeatsByPassenger[pIdx].seatId === seatId && parseInt(pIdx) !== currentPassengerIndex) {
                Swal.fire({
                    title: 'Allocated',
                    text: 'This seat has already been assigned to another traveler in your manifest.',
                    icon: 'info',
                    confirmButtonColor: '#005eb8'
                });
                return;
            }
        }

        const typeData = seatTypes[type];
        selectedSeatsByPassenger[currentPassengerIndex] = {
            seatId: seatId,
            price: typeData.price,
            type: typeData.label
        };

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
        Object.keys(selectedSeatsByPassenger).forEach(index => {
            const seat = selectedSeatsByPassenger[index];
            const p = passengers[index];
            if (seat && seat.price > 0) {
                seatTotal += seat.price;
                html += `
                    <div class="d-flex justify-content-between mb-1 small text-muted">
                        <span>Seat ${seat.seatId} (${seat.type})</span>
                        <span>+₹${seat.price.toLocaleString()}</span>
                    </div>
                `;
            }
        });

        seatExtrasText.innerHTML = html;
        const total = baseFare + seatTotal;
        document.getElementById('finalPriceText').innerText = `₹${total.toLocaleString()}`;

        const btn = document.getElementById('proceedBtn');
        const assignedCount = Object.keys(selectedSeatsByPassenger).length;
        btn.disabled = (assignedCount !== passengers.length);
    }

    function saveSeatsAndProceed() {
        localStorage.setItem('selected_seats', JSON.stringify(selectedSeatsByPassenger));
        
        console.group("🚀 Amadeus Seat Assignment Logs (SSR SEAT)");
        passengers.forEach((p, index) => {
            const seat = selectedSeatsByPassenger[index];
            if (seat) {
                const ssrLine = `SSR SEAT HK1 /${seat.seatId}/P${index + 1}`;
                console.log(`%cTraveler ${index+1} (${p.first_name}): ${ssrLine}`, "color: #005eb8; font-weight: bold;");
            }
        });
        console.groupEnd();

        Swal.fire({
            title: 'Inventory Booked',
            text: 'Passenger seats have been successfully synchronized with the airline manifest.',
            icon: 'success',
            confirmButtonColor: '#005eb8'
        }).then(() => {
            window.location.href = '/add-ons';
        });
    }

    document.addEventListener('DOMContentLoaded', init);
</script>
@endsection

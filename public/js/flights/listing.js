/**
 * Flight Listing - Filters & Comparison Logic
 * Note: Fare Modal logic is inlined in the blade file for stability.
 */

console.log("TripZant Listing Extras Loading...");

// 1. Global State
let selectedForCompare = [];
let visibleLimit = 15;

window.scrollCalendar = function(dist) {
    const el = document.getElementById('fareCalendarScroll');
    if (el) el.scrollBy({ left: dist, behavior: 'smooth' });
};

window.scrollBankOffers = function(dist) {
    const el = document.getElementById('bankOfferScroll');
    if (el) el.scrollBy({ left: dist, behavior: 'smooth' });
};

// Master Filters
window.runMasterFilters = function(shouldScroll = true) {
    const resultsList = document.getElementById('resultsList');
    const mainPriceRange = document.querySelector('.custom-range');
    const countDisplay = document.querySelector('.results-bar h5');
    if (!resultsList && !document.querySelector('.mc-leg-container:not(.d-none)')) return;

    const maxPrice = parseInt(mainPriceRange ? mainPriceRange.value : 999999);
    const selectedStops = Array.from(document.querySelectorAll('.filter-stops:checked')).map(cb => parseInt(cb.value));
    const selectedCabins = Array.from(document.querySelectorAll('.filter-cabin:checked')).map(cb => cb.value);
    const selectedAirlines = Array.from(document.querySelectorAll('[data-airline-filter]:checked')).map(cb => cb.dataset.airlineFilter);
    
    let matchCount = 0;
    let flightRows = Array.from(document.querySelectorAll('.flight-row'));
    flightRows.forEach(row => {
        let matches = true;
        if (selectedStops.length > 0 && !selectedStops.includes(parseInt(row.dataset.stops))) matches = false;
        if (matches && selectedCabins.length > 0 && !selectedCabins.includes(row.dataset.cabin)) matches = false;
        if (matches && selectedAirlines.length > 0 && !selectedAirlines.includes(row.dataset.airline)) matches = false;
        if (matches && parseInt(row.dataset.price) > maxPrice) matches = false;

        if (matches) {
            matchCount++;
            if (matchCount <= visibleLimit) { row.style.display = 'block'; row.classList.remove('d-none'); }
            else { row.style.display = 'none'; row.classList.add('d-none'); }
        } else { row.style.display = 'none'; row.classList.add('d-none'); }
    });
    if (countDisplay) countDisplay.textContent = `${matchCount} Flights Found`;
};

// Initializers
document.addEventListener('DOMContentLoaded', () => {
    if (window.isMultiCity || window.isRoundTrip) {
        document.body.classList.add('is-multi-city');
        if (document.getElementById('mcBottomBar')) document.getElementById('mcBottomBar').style.display = 'flex';
    }
    window.runMasterFilters(false);
});

window.handleCompareSelection = function(checkbox) {
    const flightId = checkbox.dataset.flightId;
    if (checkbox.checked) {
        if (selectedForCompare.length >= 3) {
            checkbox.checked = false;
            Swal.fire('Limit Reached', 'You can compare up to 3 flights at a time.', 'info');
            return;
        }
        selectedForCompare.push({
            id:            flightId,
            airline:       checkbox.dataset.airline,
            price:         checkbox.dataset.price,
            duration:      checkbox.dataset.duration,
            baggage:       checkbox.dataset.baggage,
            meal:          checkbox.dataset.meal,
            meal_detail:   checkbox.dataset.mealDetail,
            seat:          checkbox.dataset.seat,
            refund:        checkbox.dataset.refund,
            wifi:          checkbox.dataset.wifi,
            wifi_detail:   checkbox.dataset.wifiDetail,
            entertainment: checkbox.dataset.entertainment,
            wine:          checkbox.dataset.wine,
            amenities:     checkbox.dataset.amenities,
            boarding:      checkbox.dataset.boarding,
            logo:          checkbox.closest('.result-card')?.querySelector('img')?.src || ''
        });
    } else {
        selectedForCompare = selectedForCompare.filter(f => f.id !== flightId);
    }
    updateCompareBar();
};

function updateCompareBar() {
    const bar = document.getElementById('compareBar');
    if (!bar) return;
    const countEl  = document.getElementById('compareCount');
    const thumbEl  = document.getElementById('compareThumbnails');
    const compareBtn = document.getElementById('compareBtn');

    if (selectedForCompare.length > 0) {
        bar.classList.remove('d-none');
        if (countEl) countEl.innerText = selectedForCompare.length;
        if (thumbEl) thumbEl.innerHTML = selectedForCompare.map(f => `
            <div class="compare-thumb animate__animated animate__zoomIn">
                ${f.logo ? `<img src="${f.logo}" style="width:100%; height:100%; object-fit:contain;">` : '<i class="fas fa-plane text-primary"></i>'}
            </div>
        `).join('');
        if (compareBtn) compareBtn.disabled = selectedForCompare.length < 2;
    } else {
        bar.classList.add('d-none');
    }
}

window.openComparisonPanel = function() {
    if (selectedForCompare.length < 2) { Swal.fire('Select More', 'Select at least 2 flights to compare.', 'info'); return; }
    const head = document.getElementById('compareTableHead');
    const body = document.getElementById('compareTableBody');
    const modalEl = document.getElementById('comparisonModal');
    if (!head || !body || !modalEl) return;

    head.innerHTML = '<th>Features</th>' + selectedForCompare.map(f => `<th class="text-center"><img src="${f.logo}" style="width:30px;"><br>${f.airline}<br>${f.price}</th>`).join('');
    const features = [{ label: 'Duration', key: 'duration' }, { label: 'Baggage', key: 'baggage' }];
    body.innerHTML = features.map(feat => `<tr><td class="fw-bold">${feat.label}</td>${selectedForCompare.map(f => `<td class="text-center">${f[feat.key] || 'N/A'}</td>`).join('')}</tr>`).join('');
    
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
};

window.loadMoreFlights = function() { visibleLimit += 15; runMasterFilters(false); };

window.applyBankFilter = function(bank, el) {
    document.querySelectorAll('.bank-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    visibleLimit = 15;
    runMasterFilters(false);
};

console.log("TripZant Listing Extras Loaded Successfully");

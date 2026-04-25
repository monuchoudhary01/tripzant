@props(['params' => []])

<!-- Search Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="h-search-bar-v2 shadow-lg">
    <form action="{{ route('hotels.search') }}" method="POST" id="compactSearchForm">
        @csrf
        <div class="h-bar-container">
            <!-- Location -->
            <div class="h-bar-item location position-relative">
                <label class="h-bar-label">CITY, AREA OR PROPERTY</label>
                <div class="h-bar-input-wrapper">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="city" id="compactCityInput" class="h-bar-input" value="{{ $params['destinationName'] ?? 'New Delhi' }}" placeholder="Where are you going?" autocomplete="off">
                    <input type="hidden" name="city_code" id="compactCityCode" value="{{ $params['destinationCode'] ?? 'DEL' }}">
                </div>
                <div id="compactCityResults" class="h-autocomplete-results d-none"></div>
            </div>

            <!-- Dates -->
            <div class="h-bar-item dates">
                <label class="h-bar-label">CHECK-IN / CHECK-OUT</label>
                <div class="h-bar-input-wrapper">
                    <i class="fas fa-calendar-day"></i>
                    <input type="text" id="compactDateRange" class="h-bar-input" readonly 
                        value="{{ date('D, d M', strtotime($params['checkIn'] ?? 'today')) }} - {{ date('D, d M', strtotime($params['checkOut'] ?? 'tomorrow')) }}">
                    <input type="hidden" name="checkin" id="compactCheckIn" value="{{ $params['checkIn'] ?? date('Y-m-d') }}">
                    <input type="hidden" name="checkout" id="compactCheckOut" value="{{ $params['checkOut'] ?? date('Y-m-d', strtotime('+1 day')) }}">
                </div>
            </div>

            <!-- Rooms & Guests -->
            <div class="h-bar-item guests dropdown">
                <label class="h-bar-label">ROOMS & GUESTS</label>
                <div class="h-bar-input-wrapper" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="fas fa-user-friends"></i>
                    <div class="h-bar-display" id="compactGuestDisplay">
                        {{ $params['rooms'] ?? 1 }} Room, {{ ($params['adults'] ?? 2) + ($params['children'] ?? 0) }} Guests
                    </div>
                </div>
                
                <div class="dropdown-menu p-4 shadow-xl border-0 rounded-4" style="min-width: 300px;">
                    <div class="d-flex flex-column gap-3">
                        <!-- Rooms -->
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-900 text-navy">Rooms</div>
                                <div class="tiny text-muted">Total rooms required</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn-counter" onclick="updateCompactCount('rooms', -1)">-</button>
                                <span id="compactRoomsCount" class="fw-900">{{ $params['rooms'] ?? 1 }}</span>
                                <button type="button" class="btn-counter" onclick="updateCompactCount('rooms', 1)">+</button>
                            </div>
                        </div>
                        <hr class="my-1 opacity-10">
                        <!-- Adults -->
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-900 text-navy">Adults</div>
                                <div class="tiny text-muted">Above 12 years</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn-counter" onclick="updateCompactCount('adults', -1)">-</button>
                                <span id="compactAdultsCount" class="fw-900">{{ $params['adults'] ?? 2 }}</span>
                                <button type="button" class="btn-counter" onclick="updateCompactCount('adults', 1)">+</button>
                            </div>
                        </div>
                        <hr class="my-1 opacity-10">
                        <!-- Children -->
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-900 text-navy">Children</div>
                                <div class="tiny text-muted">Age 0 - 12</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn-counter" onclick="updateCompactCount('children', -1)">-</button>
                                <span id="compactChildrenCount" class="fw-900">{{ $params['children'] ?? 0 }}</span>
                                <button type="button" class="btn-counter" onclick="updateCompactCount('children', 1)">+</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rooms" id="cInputRooms" value="{{ $params['rooms'] ?? 1 }}">
                    <input type="hidden" name="adults" id="cInputAdults" value="{{ $params['adults'] ?? 2 }}">
                    <input type="hidden" name="children" id="cInputChildren" value="{{ $params['children'] ?? 0 }}">
                </div>
            </div>

            <!-- Search Button -->
            <button type="submit" class="h-bar-btn">
                <span>SEARCH</span>
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </form>
</div>

<style>
    .h-search-bar-v2 {
        background: #fff;
        border-radius: 20px;
        padding: 5px;
        border: 1px solid #e2e8f0;
    }
    .h-bar-container {
        display: grid;
        grid-template-columns: 2.5fr 2fr 2fr 1fr;
        align-items: center;
    }
    .h-bar-item {
        padding: 12px 25px;
        border-right: 1.5px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.2s;
    }
    .h-bar-item:hover {
        background: #f8fafc;
    }
    .h-bar-item.location { border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
    .h-bar-label {
        display: block;
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .h-bar-input-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
    }
    .h-bar-input-wrapper i { color: #2563eb; font-size: 16px; }
    .h-bar-input {
        border: none;
        background: transparent;
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 16px;
        width: 100%;
        color: inherit;
        outline: none;
        padding: 0;
    }
    .h-bar-display {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 16px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .h-bar-btn {
        height: 100%;
        border: none;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        font-weight: 900;
        font-size: 15px;
        letter-spacing: 1px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 0 30px;
        transition: all 0.3s;
        margin-left: 10px;
        margin-right: 5px;
    }
    .h-bar-btn:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(37,99,235,0.3);
    }
    .btn-counter {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        transition: all 0.2s;
    }
    .btn-counter:hover { border-color: #2563eb; color: #2563eb; background: #f0f7ff; }

    .h-autocomplete-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        z-index: 1000;
        margin-top: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .h-autocomplete-item {
        padding: 12px 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s;
        border-bottom: 1px solid #f1f5f9;
    }
    .h-autocomplete-item:last-child { border-bottom: none; }
    .h-autocomplete-item:hover { background: #f8fafc; }
    .h-autocomplete-item .icon { color: #94a3b8; font-size: 14px; width: 20px; }
    .h-autocomplete-item .code { font-weight: 800; color: #2563eb; font-size: 12px; background: #eff6ff; padding: 2px 6px; border-radius: 4px; }
    .h-autocomplete-item .name { font-weight: 700; color: #0f172a; font-size: 14px; }
    .h-autocomplete-item .sub { font-size: 11px; color: #64748b; }

    @media (max-width: 992px) {
        .h-bar-container { grid-template-columns: 1fr; }
        .h-bar-item { border-right: none; border-bottom: 1.5px solid #f1f5f9; }
        .h-bar-btn { margin: 15px 10px; padding: 15px; }
    }
</style>

<script>
    function updateCompactCount(type, delta) {
        const span = document.getElementById(`compact${type.charAt(0).toUpperCase() + type.slice(1)}Count`);
        const input = document.getElementById(`cInput${type.charAt(0).toUpperCase() + type.slice(1)}`);
        let val = parseInt(span.innerText);
        val = Math.max(type === 'rooms' || type === 'adults' ? 1 : 0, val + delta);
        span.innerText = val;
        input.value = val;

        // Update display
        const rooms = document.getElementById('cInputRooms').value;
        const adults = document.getElementById('cInputAdults').value;
        const children = document.getElementById('cInputChildren').value;
        const totalGuests = parseInt(adults) + parseInt(children);
        document.getElementById('compactGuestDisplay').innerText = `${rooms} Room, ${totalGuests} Guests`;
    }

    // Date Range Picker Initialization
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined' && $.fn.daterangepicker) {
            $('#compactDateRange').daterangepicker({
                startDate: moment($('#compactCheckIn').val()),
                endDate: moment($('#compactCheckOut').val()),
                minDate: moment(),
                opens: 'center',
                autoApply: true,
                locale: { format: 'ddd, DD MMM' }
            }, function(start, end) {
                $('#compactDateRange').val(start.format('ddd, DD MMM') + ' - ' + end.format('ddd, DD MMM'));
                $('#compactCheckIn').val(start.format('YYYY-MM-DD'));
                $('#compactCheckOut').val(end.format('YYYY-MM-DD'));
            });
        }

        // Auto-complete Logic
        const cityInput = document.getElementById('compactCityInput');
        const resultsBox = document.getElementById('compactCityResults');

        if (cityInput) {
            cityInput.addEventListener('input', async (e) => {
                const term = e.target.value.trim();
                if (term.length < 2) {
                    resultsBox.classList.add('d-none');
                    return;
                }

                try {
                    const response = await fetch(`https://autocomplete.travelpayouts.com/places2?locale=en&types[]=city&term=${term}`);
                    const data = await response.json();
                    
                    if (data && data.length > 0) {
                        resultsBox.innerHTML = data.slice(0, 5).map(place => `
                            <div class="h-autocomplete-item" onclick="selectCompactCity('${place.code}', '${place.name}', '${place.country_name}')">
                                <div class="icon"><i class="fas fa-city"></i></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="name">${place.name}</span>
                                        <span class="code">${place.code}</span>
                                    </div>
                                    <div class="sub">${place.country_name}</div>
                                </div>
                            </div>
                        `).join('');
                        resultsBox.classList.remove('d-none');
                    } else {
                        resultsBox.classList.add('d-none');
                    }
                } catch (err) {
                    console.error('Autocomplete failed', err);
                }
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!cityInput.contains(e.target) && !resultsBox.contains(e.target)) {
                    resultsBox.classList.add('d-none');
                }
            });
        }
    });

    function selectCompactCity(code, name, country) {
        document.getElementById('compactCityInput').value = name;
        document.getElementById('compactCityCode').value = code;
        document.getElementById('compactCityResults').classList.add('d-none');
    }
</script>

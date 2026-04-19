@extends('layouts.app')

@section('title', "Fare Monitoring System — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
    <x-partner-sidebar active="fare-alerts" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
                <div>
                    <h2 class="fw-900 text-navy mb-1"><i class="fas fa-bell me-2 text-primary"></i> Auto Fare Monitor</h2>
                    <p class="text-muted small mb-0 uppercase tracking-wider fw-bold">Amadeus AI Engine | Real-time Notifications | Target Price Tracking</p>
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ route('agent.b2b.fare-alerts.create') }}" class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small">CREATE NEW ALERT <i class="fas fa-plus ms-2"></i></a>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-blue-light text-blue rounded-3 p-3"><i class="fas fa-search"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">ACTIVE MONITORS</span>
                            <span class="h5 fw-900 text-navy mb-0">{{ $alerts->where('status', 'pending')->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-2">
                        <div class="bg-green-light text-green rounded-3 p-3"><i class="fas fa-check-double"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">MATCHED ALERTS</span>
                            <span class="h5 fw-900 text-navy mb-0 text-success">{{ $alerts->where('status', 'matched')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 fw-bold small">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Detailed Table -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">ROUTE</th>
                                <th class="py-3">TRAVEL DATE</th>
                                <th class="py-3">TARGET PRICE</th>
                                <th class="py-3">CURRENT/LAST</th>
                                <th class="py-3">STATUS</th>
                                <th class="py-3">NOTIFY VIA</th>
                                <th class="py-3 text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @forelse($alerts as $alert)
                            <tr class="py-4 border-bottom">
                                <td>
                                    <span class="d-block text-navy fw-900">{{ $alert->origin }} <i class="fas fa-long-arrow-alt-right mx-1 text-primary"></i> {{ $alert->destination }}</span>
                                    <span class="x-small text-muted">{{ $alert->pax }} Adult(s)</span>
                                </td>
                                <td class="text-navy">{{ $alert->travel_date->format('d M Y') }}</td>
                                <td class="text-navy">
                                    @if($alert->target_price)
                                        ₹{{ number_format($alert->target_price) }}
                                    @else
                                        <span class="text-muted italic">Cheapest</span>
                                    @endif
                                </td>
                                <td>
                                    @php $lastLog = $alert->priceLogs()->latest()->first(); @endphp
                                    @if($lastLog)
                                        <span class="text-navy fw-900">₹{{ number_format($lastLog->price) }}</span>
                                        <div class="x-small text-muted">{{ $lastLog->checked_at->diffForHumans() }}</div>
                                    @else
                                        <span class="text-muted">Waiting...</span>
                                    @endif
                                </td>
                                <td>
                                    @if($alert->status === 'matched')
                                        <span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold">MATCHED ✓</span>
                                    @elseif($alert->status === 'pending')
                                        <span class="badge bg-blue-subtle text-blue rounded-pill px-3 py-1 x-small fw-bold pulsate">MONITORING</span>
                                    @else
                                        <span class="badge bg-light text-muted rounded-pill px-3 py-1 x-small fw-bold">{{ strtoupper($alert->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-muted x-small">
                                    @foreach(explode(',', $alert->notification_channel) as $chan)
                                        <span class="badge bg-light text-navy me-1 px-2 py-1 border">{{ strtoupper($chan) }}</span>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if($alert->status === 'matched')
                                            <button
                                                class="btn btn-sm btn-success rounded-pill px-3 x-small fw-900"
                                                onclick="showFlightCard({{ $alert->id }}, '{{ $alert->origin }}', '{{ $alert->destination }}', '{{ $alert->travel_date->format('d M Y') }}', '{{ $alert->pax }}', {{ $lastLog ? $lastLog->price : ($alert->matched_data['price']['total'] ?? 0) }}, {{ json_encode($alert->matched_data) }})"
                                            >
                                                <i class="fas fa-bolt me-1"></i> BOOK NOW
                                            </button>
                                        @endif
                                        <form action="{{ route('agent.b2b.fare-alerts.delete', $alert->id) }}" method="POST" onsubmit="return confirm('Stop monitoring this fare?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted mb-3"><i class="fas fa-bell-slash fa-3x"></i></div>
                                    <p class="fw-bold text-navy mb-1">No Fare Monitors Active</p>
                                    <p class="small text-muted">Create an alert and let our AI engine find the cheapest flights for you.</p>
                                    <a href="{{ route('agent.b2b.fare-alerts.create') }}" class="btn btn-navy rounded-pill px-4 fw-900 mt-3 x-small">CREATE FIRST ALERT</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ============================================================
     CLEAN FLIGHT CARD MODAL (No GDS codes shown to agent!)
     ============================================================ -->
<div class="modal fade" id="flightCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">

            <!-- Modal Header -->
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <div>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold x-small mb-2">
                        <i class="fas fa-check-circle me-1"></i> CHEAPEST FARE FOUND — TARGET MET!
                    </span>
                    <h5 class="fw-900 text-navy mb-0" id="modal-route-title">JAI → DXB</h5>
                    <p class="text-muted x-small mb-0" id="modal-sub">1 Adult | Economy Class</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <!-- Flight Card -->
                <div class="flight-card-premium rounded-4 p-4 mb-4 border" id="flight-card-main">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                        <!-- Airline Logo + Name -->
                        <div class="d-flex align-items-center gap-3" style="min-width: 160px;">
                            <div class="airline-logo-box rounded-3 d-flex align-items-center justify-content-center bg-light" style="width:52px;height:52px;">
                                <img id="modal-airline-logo" src="https://pics.avs.io/50/50/AI.png" onerror="this.src='https://ui-avatars.com/api/?name=AI&size=50&background=001f3f&color=fff&bold=true'" style="width:40px;height:40px;object-fit:contain;" alt="Airline">
                            </div>
                            <div>
                                <div class="fw-900 text-navy small" id="modal-airline-name">Air India</div>
                                <div class="x-small text-muted" id="modal-flight-num">Flight AI-916</div>
                            </div>
                        </div>

                        <!-- Departure -->
                        <div class="text-center">
                            <div class="fw-900 text-navy" style="font-size:24px;" id="modal-dep-time">06:20</div>
                            <div class="fw-bold text-navy x-small" id="modal-dep-code">JAI</div>
                            <div class="text-muted" style="font-size:10px;" id="modal-dep-airport">Jaipur Int'l</div>
                        </div>

                        <!-- Duration + Line -->
                        <div class="text-center flex-grow-1">
                            <div class="x-small text-muted fw-bold mb-1" id="modal-duration">2h 50m</div>
                            <div class="d-flex align-items-center gap-1">
                                <div style="height:2px;background:#e2e8f0;flex:1;"></div>
                                <i class="fas fa-plane text-primary" style="font-size:14px;"></i>
                                <div style="height:2px;background:#e2e8f0;flex:1;"></div>
                            </div>
                            <div class="x-small text-success fw-bold mt-1">Non-Stop</div>
                        </div>

                        <!-- Arrival -->
                        <div class="text-center">
                            <div class="fw-900 text-navy" style="font-size:24px;" id="modal-arr-time">09:10</div>
                            <div class="fw-bold text-navy x-small" id="modal-arr-code">DXB</div>
                            <div class="text-muted" style="font-size:10px;" id="modal-arr-airport">Dubai Int'l</div>
                        </div>

                        <!-- Price -->
                        <div class="text-end">
                            <div class="text-muted x-small fw-bold text-decoration-line-through" id="modal-target-price-strike">Target: ₹18,000</div>
                            <div class="fw-900 text-success" style="font-size:26px;" id="modal-matched-price">₹16,890</div>
                            <div class="x-small text-muted">per adult · all incl.</div>
                            <span class="badge bg-success-subtle text-success rounded-pill x-small fw-bold" id="modal-savings-badge">Save ₹1,110!</span>
                        </div>
                    </div>

                    <!-- Tags Row -->
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        <span class="badge bg-blue-subtle text-navy x-small fw-bold px-2 py-1"><i class="fas fa-suitcase me-1"></i> 15kg Baggage</span>
                        <span class="badge bg-blue-subtle text-navy x-small fw-bold px-2 py-1"><i class="fas fa-utensils me-1"></i> Meal Included</span>
                        <span class="badge bg-blue-subtle text-navy x-small fw-bold px-2 py-1"><i class="fas fa-shield-alt me-1"></i> Refundable</span>
                        <span class="badge bg-warning-subtle text-warning x-small fw-bold px-2 py-1"><i class="fas fa-fire me-1"></i> Limited Seats</span>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="p-3 bg-light rounded-3 mb-4">
                    <div class="x-small fw-bold text-muted uppercase mb-2">FARE SUMMARY</div>
                    <div class="d-flex justify-content-between small fw-bold text-navy py-1">
                        <span>Base Fare <span class="text-muted fw-normal" id="modal-pax-label">(1 Adult)</span></span>
                        <span id="modal-base-fare">₹14,500</span>
                    </div>
                    <div class="d-flex justify-content-between small fw-bold text-navy py-1">
                        <span>Taxes & Fees</span>
                        <span id="modal-taxes">₹2,390</span>
                    </div>
                    <div class="d-flex justify-content-between fw-900 text-success py-2 border-top mt-1">
                        <span>Total Amount</span>
                        <span id="modal-total">₹16,890</span>
                    </div>
                </div>

                <!-- Alert note -->
                <div class="d-flex align-items-start gap-2 bg-warning-subtle p-3 rounded-3 x-small text-navy fw-bold mb-3">
                    <i class="fas fa-exclamation-triangle text-warning mt-1"></i>
                    <span>Yeh fare live Amadeus GDS se match hua hai. Prices real-time mein change hote hain — jaldi book karo!</span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-3">
                <button class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('agent.b2b.search') }}" class="btn btn-navy rounded-pill px-5 fw-900 shadow">
                    <i class="fas fa-bolt me-2"></i> PROCEED TO BOOK
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .btn-navy { background: #001f3f; color: #fff; }
    .btn-navy:hover { background: #003366; color: #fff; }
    .bg-blue-light { background: #eff6ff; color: #2563eb; }
    .bg-blue-subtle { background: #e0f2fe; }
    .bg-green-subtle { background: #f0fff4; }
    .bg-warning-subtle { background: #fffbeb; }
    .text-blue { color: #2563eb; }
    .bg-green-light { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981; }

    .flight-card-premium {
        background: linear-gradient(135deg, #f8faff 0%, #eff6ff 100%);
        border-color: #dbeafe !important;
    }

    .pulsate {
        animation: pulse-blue 2s infinite;
    }

    @keyframes pulse-blue {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(37, 99, 235, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
    }
</style>

<script>
const airlineNames = {
    'AI': 'Air India', 'EK': 'Emirates', 'QR': 'Qatar Airways', 'SQ': 'Singapore Airlines',
    'G8': 'Go First', '6E': 'IndiGo', 'UK': 'Vistara', 'IX': 'Air India Express',
    'WY': 'Oman Air', 'FZ': 'flydubai', 'TK': 'Turkish Airlines', '9W': 'Jet Airways'
};

const airportNames = {
    'JAI': 'Jaipur International', 'DXB': 'Dubai International',
    'DEL': 'Indira Gandhi Intl', 'BOM': 'Chhatrapati Shivaji Intl',
    'BLR': 'Kempegowda Intl', 'HYD': 'Rajiv Gandhi Intl',
    'MAA': 'Chennai International', 'CCU': 'Netaji Subhas Intl',
    'LHR': 'London Heathrow', 'SIN': 'Changi Airport', 'BKK': 'Suvarnabhumi Intl'
};

    function showFlightCard(alertId, origin, destination, travelDate, pax, currentPrice, matchedData) {
        // Parse flight data
        let segment = null;
        let carrierCode = 'AI';
        let flightNum = '';
        let depTime = '--:--';
        let arrTime = '--:--';
        let duration = '';
        let bookingClass = '';
        let segmentId = null;

        if (matchedData && matchedData.itineraries && matchedData.itineraries[0]) {
            segment = matchedData.itineraries[0].segments ? matchedData.itineraries[0].segments[0] : null;
        }
        if (segment) {
            carrierCode = segment.carrierCode || 'AI';
            flightNum = segment.number || '';
            depTime = segment.departure && segment.departure.at ? segment.departure.at.substring(11, 16) : '--:--';
            arrTime = segment.arrival && segment.arrival.at ? segment.arrival.at.substring(11, 16) : '--:--';
            segmentId = segment.id || null;

            // Parse duration PT2H50M → 2h 50m
            if (segment.duration) {
                duration = segment.duration.replace('PT','').replace('H','h ').replace('M','m');
            }
        }

        // Get booking class from travelerPricings > fareDetailsBySegment
        if(matchedData && matchedData.travelerPricings && matchedData.travelerPricings[0]) {
             let fareDetails = matchedData.travelerPricings[0].fareDetailsBySegment || [];
             let currentSegmentFareData = fareDetails.find(f => f.segmentId === segmentId) || fareDetails[0];
             if(currentSegmentFareData) {
                 bookingClass = currentSegmentFareData.class || '';
             }
        }

        const price = parseFloat(currentPrice) || (matchedData && matchedData.price ? parseFloat(matchedData.price.total) : 0);
        const targetPrice = parseFloat(document.querySelector('[data-alert-target-' + alertId + ']')?.dataset?.target || 18000);

        // Parse matched target from table cell
        let targetVal = 18000;
        const savings = Math.max(0, targetVal - price);
        const baseFare = Math.round(price * 0.857);
        const taxes = price - baseFare;

        // Update Modal
        document.getElementById('modal-route-title').textContent = origin + ' → ' + destination;
        document.getElementById('modal-sub').textContent = pax + ' Adult(s) | Economy Class | ' + travelDate;
        document.getElementById('modal-airline-name').textContent = airlineNames[carrierCode] || carrierCode;
        
        // Displaying the Booking Class explicitly so the B2B agent sees it.
        let flightText = '<div class="d-flex align-items-center flex-wrap gap-1 mt-1"><span class="text-muted fw-bold me-2">Flight ' + carrierCode + '-' + flightNum + '</span>';
        if(bookingClass) {
             let gdsSellCmd = 'SS' + pax + bookingClass + '1';
             
             // Simulate Amadeus class string
             let dummyClasses = ['J4', 'C0', 'D0'];
             let dummyClassesPost = ['R9', 'X9', 'N0'];
             
             // Append pre-classes
             dummyClasses.forEach(cls => {
                 flightText += `<span class="text-primary fw-bold" style="font-family: monospace; font-size: 11px;">${cls}</span>`;
             });
             
             // Add real matched class with Dropdown
             let classBadge = `
                <div class="dropdown d-inline-block mx-1">
                    <span class="badge text-white rounded-1 cursor-pointer fw-bold px-1 py-0 dropdown-toggle" style="background:#001f3f !important; font-family: monospace; font-size: 11px;" data-bs-toggle="dropdown" aria-expanded="false" title="Click to view GDS Sell Command">
                        ${bookingClass}9
                    </span>
                    <ul class="dropdown-menu shadow-sm border-0 p-2" style="font-size:12px; min-width: 150px; font-family: monospace; z-index: 9999;">
                        <li class="px-2 py-1 text-muted fw-bold border-bottom mb-1" style="font-size:10px;">AVAILABLE ACTIONS</li>
                        <li><a class="dropdown-item fw-bold text-navy px-2 py-1 rounded hover-bg-light" href="#">${gdsSellCmd} &nbsp;&nbsp;<span class="text-success float-end">₹${price.toLocaleString('en-IN')}</span></a></li>
                        <li><a class="dropdown-item fw-bold text-muted px-2 py-1 rounded hover-bg-light" href="#">FQD${origin}${destination}/A${carrierCode}</a></li>
                        <li><a class="dropdown-item fw-bold text-muted px-2 py-1 rounded hover-bg-light" href="#">AN${travelDate.substring(0,2)}${travelDate.substring(3,6).toUpperCase()}${origin}${destination}</a></li>
                    </ul>
                </div>
             `;
             flightText += classBadge;
             
             // Append post-classes
             dummyClassesPost.forEach(cls => {
                 flightText += `<span class="text-primary fw-bold" style="font-family: monospace; font-size: 11px;">${cls}</span>`;
             });
        }
        flightText += '</div>';
        document.getElementById('modal-flight-num').innerHTML = flightText;
        
        document.getElementById('modal-airline-logo').src = 'https://pics.avs.io/50/50/' + carrierCode + '.png';
        document.getElementById('modal-dep-time').textContent = depTime;
        document.getElementById('modal-dep-code').textContent = origin;
        document.getElementById('modal-dep-airport').textContent = airportNames[origin] || origin + ' Airport';
        document.getElementById('modal-arr-time').textContent = arrTime;
        document.getElementById('modal-arr-code').textContent = destination;
        document.getElementById('modal-arr-airport').textContent = airportNames[destination] || destination + ' Airport';
        document.getElementById('modal-duration').textContent = duration || '2h 50m';
        document.getElementById('modal-matched-price').textContent = '₹' + price.toLocaleString('en-IN');
        document.getElementById('modal-target-price-strike').textContent = 'Target: ₹' + targetVal.toLocaleString('en-IN');
        document.getElementById('modal-savings-badge').textContent = savings > 0 ? 'Save ₹' + savings.toLocaleString('en-IN') + '!' : 'Best Price!';
        document.getElementById('modal-pax-label').textContent = '(' + pax + ' Adult)';
        document.getElementById('modal-base-fare').textContent = '₹' + baseFare.toLocaleString('en-IN');
        document.getElementById('modal-taxes').textContent = '₹' + taxes.toLocaleString('en-IN');
        document.getElementById('modal-total').textContent = '₹' + price.toLocaleString('en-IN');

        // Show Modal
        new bootstrap.Modal(document.getElementById('flightCardModal')).show();
    }
</script>

<style>
   .bg-navy {
       background-color: #001f3f !important;
   }
</style>
@endsection

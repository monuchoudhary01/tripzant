@extends('layouts.app')

@section('title', "Create Fare Alert — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
    <x-partner-sidebar active="fare-alerts" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
                <div>
                    <h2 class="fw-900 text-navy mb-1"><i class="fas fa-plus-circle me-2 text-primary"></i> Setup Fare Monitor</h2>
                    <p class="text-muted small mb-0 uppercase tracking-wider fw-bold">Set your target price and let our system do the hunting for you.</p>
                </div>
                <a href="{{ route('agent.b2b.fare-alerts') }}" class="btn btn-outline-navy rounded-pill px-4 fw-900 x-small"><i class="fas fa-arrow-left me-2"></i> BACK TO LIST</a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-5">
                        <form action="{{ route('agent.b2b.fare-alerts.store') }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="x-small fw-bold text-muted uppercase mb-2 d-block">Origin (City/Airport Code)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-plane-departure text-muted"></i></span>
                                        <input type="text" name="origin" class="form-control form-control-lg bg-light border-0 fw-bold text-navy" placeholder="e.g. JAI" required maxlength="3" onkeyup="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="x-small fw-bold text-muted uppercase mb-2 d-block">Destination (City/Airport Code)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-plane-arrival text-muted"></i></span>
                                        <input type="text" name="destination" class="form-control form-control-lg bg-light border-0 fw-bold text-navy" placeholder="e.g. DXB" required maxlength="3" onkeyup="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="x-small fw-bold text-muted uppercase mb-2 d-block">Travel Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                                        <input type="date" name="travel_date" class="form-control form-control-lg bg-light border-0 fw-bold text-navy" required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="x-small fw-bold text-muted uppercase mb-2 d-block">Passengers (Adults)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-users text-muted"></i></span>
                                        <input type="number" name="pax" class="form-control form-control-lg bg-light border-0 fw-bold text-navy" value="1" min="1" max="9" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="p-4 bg-blue-subtle rounded-4 border-0 mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label class="x-small fw-bold text-navy uppercase mb-0"><i class="fas fa-bullseye me-2"></i> Target Price Condition</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onchange="toggleBudget(this)">
                                                <label class="form-check-label x-small fw-bold text-navy ms-2" for="flexSwitchCheckDefault">ANY CHEAPEST</label>
                                            </div>
                                        </div>
                                        <div id="budgetWrapper">
                                            <label class="x-small fw-bold text-muted uppercase mb-2 d-block">Target Budget (INR)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-0">₹</span>
                                                <input type="number" name="target_price" id="targetPriceInput" class="form-control form-control-lg bg-white border-0 fw-bold text-navy" placeholder="e.g. 18000">
                                            </div>
                                            <p class="x-small text-muted mt-2 mb-0"><i class="fas fa-info-circle me-1"></i> We'll notify you when the fare drops below this price.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="x-small fw-bold text-muted uppercase mb-3 d-block">Notification Preferences</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="notification_channel[]" value="email" id="chanEmail" checked>
                                            <label class="form-check-label small fw-bold text-navy" for="chanEmail">
                                                <i class="fas fa-envelope me-1 text-primary"></i> Email Alerts
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="notification_channel[]" value="whatsapp" id="chanWA">
                                            <label class="form-check-label small fw-bold text-navy" for="chanWA">
                                                <i class="fab fa-whatsapp me-1 text-success"></i> WhatsApp Alerts
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="p-4 bg-success-subtle rounded-4 border border-success border-opacity-25 mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-0">
                                            <div>
                                                <label class="small fw-900 text-success uppercase mb-0"><i class="fas fa-robot me-2"></i> Auto-Book (Zero-Touch)</label>
                                                <div class="x-small text-muted mt-1">If enabled, system will automatically deduct from B2B wallet and generate PNR instantly.</div>
                                            </div>
                                            <div class="form-check form-switch form-switch-lg">
                                                <input class="form-check-input" type="checkbox" name="auto_book" id="autoBookSwitch" onchange="toggleAutoBook(this)">
                                            </div>
                                        </div>
                                        
                                        <div id="passengerDetailsWrapper" class="mt-4 pt-3 border-top border-success border-opacity-25" style="display: none;">
                                            <h6 class="fw-bold text-success mb-3 small uppercase">Lead Passenger Detail (For PNR)</h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="passenger_details[first_name]" class="form-control form-control-sm bg-white" placeholder="First Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="passenger_details[last_name]" class="form-control form-control-sm bg-white" placeholder="Last Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="date" name="passenger_details[dob]" class="form-control form-control-sm bg-white" placeholder="DOB">
                                                </div>
                                            </div>
                                            <div class="alert alert-warning x-small py-2 mt-3 mb-0 border-0">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Ensure your B2B wallet has sufficient funds (>= target price). Auto-booking will silently bypass if balance is low.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-navy btn-lg rounded-pill px-5 fw-900 w-100 shadow">
                                        ACTIVATE AUTO-MONITOR <i class="fas fa-bolt ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-navy text-white p-5 h-100 gradient-navy">
                        <h4 class="fw-900 mb-4">Why use Auto-Fare Monitor?</h4>
                        <ul class="list-unstyled space-y-4">
                            <li class="d-flex gap-3 mb-4">
                                <div class="text-primary"><i class="fas fa-robot fa-lg"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Mistifly-grade AI</h6>
                                    <p class="x-small opacity-75 mb-0">System polls Amadeus every 15 mins to catch flash sales and cancellations.</p>
                                </div>
                            </li>
                            <li class="d-flex gap-3 mb-4">
                                <div class="text-primary"><i class="fas fa-plane-arrival fa-lg"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Zero-Touch Booking</h6>
                                    <p class="x-small opacity-75 mb-0">Enable Auto-Book to let the platform instantly secure cheap inventory and issue PNR before competitors.</p>
                                </div>
                            </li>
                            <li class="d-flex gap-3 mb-4">
                                <div class="text-primary"><i class="fas fa-percentage fa-lg"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Best Margins</h6>
                                    <p class="x-small opacity-75 mb-0">Book when the fare is at its lowest to maximize your B2B markup profit.</p>
                                </div>
                            </li>
                        </ul>
                        
                        <div class="mt-auto pt-4 border-top border-secondary border-opacity-25">
                            <p class="x-small fw-bold uppercase tracking-widest text-primary mb-1">Pro Tip</p>
                            <p class="x-small opacity-75 mb-0">For popular routes like Dubai or London, set your target 10% lower than current market price.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function toggleBudget(checkbox) {
        const wrapper = document.getElementById('budgetWrapper');
        const input = document.getElementById('targetPriceInput');
        if (checkbox.checked) {
            wrapper.style.opacity = '0.5';
            input.disabled = true;
            input.value = '';
        } else {
            wrapper.style.opacity = '1';
            input.disabled = false;
        }
    }

    function toggleAutoBook(checkbox) {
        const wrapper = document.getElementById('passengerDetailsWrapper');
        const inputs = wrapper.querySelectorAll('input');
        if (checkbox.checked) {
            wrapper.style.display = 'block';
            inputs.forEach(i => i.required = true);
        } else {
            wrapper.style.display = 'none';
            inputs.forEach(i => i.required = false);
        }
    }
</script>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f; }
    .gradient-navy {
        background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
    }
    .bg-blue-subtle { background: #eff6ff; }
</style>
@endsection

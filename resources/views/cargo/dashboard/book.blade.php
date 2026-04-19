@extends('layouts.user_dashboard')

@section('title', 'Universal Cargo Booking | TripZant')

@section('content')
<div class="container-fluid py-4 min-vh-100" style="background-color: #f8f9fc;">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            <!-- Stepper Progress (Aligned to Universal Flow) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between text-center position-relative">
                        <div class="position-absolute translate-middle top-50 start-50 w-75 bg-light h-1" style="z-index: 0;"></div>
                        <div class="step-item active" id="step-1-nav" style="z-index: 1;">
                            <div class="step-circle bg-primary text-white border-0">1</div>
                            <div class="step-label mt-2 small fw-bold">Search</div>
                        </div>
                        <div class="step-item" id="step-2-nav" style="z-index: 1;">
                            <div class="step-circle bg-light text-muted border-0">2</div>
                            <div class="step-label mt-2 small fw-bold">Provider</div>
                        </div>
                        <div class="step-item" id="step-3-nav" style="z-index: 1;">
                            <div class="step-circle bg-light text-muted border-0">3</div>
                            <div class="step-label mt-2 small fw-bold">Customs</div>
                        </div>
                        <div class="step-item" id="step-4-nav" style="z-index: 1;">
                            <div class="step-circle bg-light text-muted border-0">4</div>
                            <div class="step-label mt-2 small fw-bold">Logistics</div>
                        </div>
                        <div class="step-item" id="step-5-nav" style="z-index: 1;">
                            <div class="step-circle bg-light text-muted border-0">5</div>
                            <div class="step-label mt-2 small fw-bold">Review</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Multi-Step Form -->
            <form id="cargo-booking-form">
                @csrf
                <!-- STEP 1 & 2 Handling (Search & Provider Selection) -->
                <div class="step-pane active" id="step-1">
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                        <h3 class="fw-bold mb-4">Step 1: Universal Cargo Search</h3>
                        <div class="row g-4 text-start">
                            <div class="col-md-6">
                                <label class="small fw-bold uppercase">From (Country/City)</label>
                                <input type="text" name="origin_city" class="form-control bg-light border-0" placeholder="e.g. Melbourne, Victoria, Australia" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold uppercase">To (Country/City)</label>
                                <input type="text" name="destination_city" class="form-control bg-light border-0" placeholder="e.g. New Delhi, India" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold uppercase">Parcel Type</label>
                                <select name="parcel_type" class="form-select bg-light border-0">
                                    <option value="Box">Standard Box</option>
                                    <option value="Fragile">Fragile Goods</option>
                                    <option value="Documents">Legal Documents</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold uppercase">Weight (kg)</label>
                                <input type="number" name="weight" id="parcel_weight" class="form-control bg-light border-0" value="5">
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold uppercase">Urgency</label>
                                <select name="urgency" class="form-select bg-light border-0">
                                    <option value="Standard">Standard (3-7 Days)</option>
                                    <option value="Express">Express (1-2 Days)</option>
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="button" class="btn btn-primary btn-lg w-100 rounded-pill" onclick="searchProviders()">Search Global Carriers <i class="fas fa-search ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step-pane d-none" id="step-2">
                    <h5 class="fw-bold mb-4">Step 2: Cargo Provider Selection</h5>
                    <div id="recommendations-container" class="row g-3 mb-4"></div>
                    <div id="providers-list" class="row g-3"></div>
                    <button type="button" class="btn btn-light rounded-pill mt-4" onclick="prevStep(1)">Back</button>
                </div>

                <!-- STEP 3: UNIVERSAL CUSTOMS DECLARATION (RULES-DRIVEN) -->
                <div class="step-pane d-none" id="step-3">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-navy text-white py-3 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 small uppercase ls-1"><i class="fas fa-microchip me-2 text-info"></i> Dynamic Declaration Engine</h5>
                            <div class="badge bg-soft-info text-white border border-info border-opacity-25 px-3">Regulated by IATA Flow</div>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <!-- Country Rules Banner (Step 3: Rules Engine) -->
                            <div id="country-rules-alert" class="alert bg-soft-primary border-0 rounded-4 mb-4 d-flex align-items-center">
                                <div class="icon-circle bg-primary text-white me-3 p-2 rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-globe-americas"></i>
                                </div>
                                <div class="small">
                                    <div class="fw-bold text-primary">Destination Rules Loaded: <span id="target-country-name">GLOBAL</span></div>
                                    <div class="text-muted" id="country-rule-desc">Applying Standard International Customs Protocol.</div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <!-- 1. Product Details Segment (Step 1) -->
                                <div class="col-lg-8">
                                    <div class="p-4 border rounded-4 bg-light bg-opacity-50 h-100">
                                        <h6 class="fw-bold mb-4 uppercase text-muted small ls-1"><i class="fas fa-box-open me-2"></i> 1. Product Details</h6>
                                        <div class="row g-3">
                                            <div class="col-md-9">
                                                <label class="form-label x-small fw-bold">Item Description (Strict Validation)</label>
                                                <input type="text" name="item_description" id="item_desc" class="form-control border-0 shadow-sm" placeholder="Search item or type..." onkeyup="checkProhibited(this.value)">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label x-small fw-bold">Qty</label>
                                                <input type="number" name="quantity" class="form-control border-0 shadow-sm text-center" value="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label x-small fw-bold">Category (Step 2: HS Hub)</label>
                                                <select name="item_category" id="item_category" class="form-select border-0 shadow-sm" onchange="mapHSCode(this.value)">
                                                    <option value="Documents">Legal Documents</option>
                                                    <option value="Textiles">Textiles & Apparel</option>
                                                    <option value="Electronics">Electronics / IT</option>
                                                    <option value="Food">Packaged Food</option>
                                                    <option value="Others">General Merchandise</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label x-small fw-bold">Item Weight (kg)</label>
                                                <div class="input-group shadow-sm">
                                                    <input type="number" name="item_weight" class="form-control border-0" value="1.0" step="0.1">
                                                    <span class="input-group-text border-0 bg-white small fw-bold">KG</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- HS Code Badge (Step 2) -->
                                        <div class="mt-4 p-3 border border-dashed rounded-3 bg-white d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="d-block text-muted uppercase fw-bold" style="font-size: 9px;">Verified HS Code</small>
                                                <div class="h5 mb-0 fw-800 text-primary" id="hs-display">4901.10.00</div>
                                            </div>
                                            <button type="button" class="btn btn-link btn-sm text-decoration-none" onclick="Swal.fire('HS Code Manual Override', 'Admin privilege required.', 'info')">Manual Override</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Financials (Step 1 & 7) -->
                                <div class="col-lg-4">
                                    <div class="p-4 border rounded-4 h-100 shadow-sm bg-white">
                                        <h6 class="fw-bold mb-4 uppercase text-muted small ls-1"><i class="fas fa-coins me-2"></i> 2. Financials</h6>
                                        <div class="mb-4">
                                            <label class="form-label x-small fw-bold">Item Value</label>
                                            <div class="input-group shadow-sm mb-2">
                                                <input type="number" name="item_value" id="dec_val" class="form-control border-0 bg-light" value="150" onkeyup="toggleDocs(this.value)">
                                                <select name="currency" class="form-select border-0 bg-navy text-white px-2" style="max-width: 80px;">
                                                    <option value="AUD">AUD</option>
                                                    <option value="USD">USD</option>
                                                </select>
                                            </div>
                                            <small class="text-muted"><i class="fas fa-sync-alt me-1"></i> Auto-Conversion Enabled</small>
                                        </div>

                                        <!-- Document Upload Trigger (Step 7) -->
                                        <div id="high-value-docs" class="mt-4 d-none">
                                            <div class="p-3 border rounded-3 bg-soft-warning border-warning border-opacity-25">
                                                <label class="form-label x-small fw-bold text-dark"><i class="fas fa-upload me-1"></i> Upload Commercial Invoice</label>
                                                <input type="file" name="invoice_doc" class="form-control form-control-sm bg-white border-0">
                                                <div class="x-small text-muted mt-1">Value over $1,000 requries proof.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Compliance & Signature (Step 5 & 6) -->
                                <div class="col-12 mt-2">
                                    <div id="warning-box" class="alert alert-danger border-0 rounded-4 d-none mb-4">
                                        <i class="fas fa-ban me-2"></i> <strong>BLOCK DETECTED:</strong> <span id="warning-msg">Prohibited Item detected in description.</span>
                                    </div>

                                    <div class="p-4 border rounded-4 bg-navy text-white">
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" id="legal-check" onchange="document.getElementById('step-3-next').disabled = !this.checked">
                                            <label class="form-check-label small fw-bold" for="legal-check">
                                                I confirm this shipment is 100% legal. I accept full responsibility for any customs hold. (IP & Logged Verified)
                                            </label>
                                        </div>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-7">
                                                <label class="form-label x-small fw-bold uppercase opacity-75">Electronic Signature</label>
                                                <input type="text" name="digital_signature" class="form-control bg-white bg-opacity-10 border-0 text-white font-monospace" placeholder="Type Full Name as Signature">
                                            </div>
                                            <div class="col-md-5 pt-3">
                                                <button type="button" class="btn btn-primary btn-lg w-100 rounded-pill shadow-lg border-0" id="step-3-next" onclick="nextStep(4)" disabled>
                                                    Initialize Logistics <i class="fas fa-fingerprint ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: LOGISTICS (PICKUP/DROP) & INSURANCE -->
                <div class="step-pane d-none" id="step-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <h4 class="fw-bold mb-4">Logistics & Contact Details</h4>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Sender Contact</label>
                                    <input type="text" name="sender_name" class="form-control bg-light border-0 mb-2" value="{{ auth()->user()->name }}">
                                    <textarea name="sender_address" class="form-control bg-light border-0" rows="2" placeholder="Sender Full Address"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Receiver Contact</label>
                                    <input type="text" name="receiver_name" class="form-control bg-light border-0 mb-2" placeholder="Receiver Contact Person">
                                    <input type="text" name="receiver_phone" class="form-control bg-light border-0 mb-2" placeholder="Receiver Phone Number">
                                    <textarea name="receiver_address" class="form-control bg-light border-0" rows="2" placeholder="Destination Full Address"></textarea>
                                </div>
                                <div class="border-top pt-3 text-center">
                                    <div class="btn-group w-100 shadow-sm rounded-pill overflow-hidden">
                                        <input type="radio" class="btn-check" name="pickup_option" id="p-home" value="Home Pickup" checked>
                                        <label class="btn btn-outline-primary py-2" for="p-home"><i class="fas fa-home me-2"></i> Home Pickup</label>
                                        <input type="radio" class="btn-check" name="pickup_option" id="p-drop" value="Drop-off">
                                        <label class="btn btn-outline-primary py-2" for="p-drop"><i class="fas fa-store me-2"></i> Shop Drop-off</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-dark text-white p-4">
                                <h4 class="fw-bold mb-4">Step 6: Insurance Selection</h4>
                                <div class="d-flex flex-column gap-3">
                                    <input type="radio" class="btn-check" name="insurance_plan" id="ins-none" value="None" checked>
                                    <label class="btn btn-outline-light text-start p-3" for="ins-none">
                                        <div class="fw-bold">Standard No Cover (Free)</div>
                                        <p class="x-small opacity-75 mb-0">Basic carrier liability.</p>
                                    </label>
                                    <input type="radio" class="btn-check" name="insurance_plan" id="ins-prem" value="Premium">
                                    <label class="btn btn-outline-light text-start p-3" for="ins-prem">
                                        <div class="fw-bold">Premium Protect (+5% Value)</div>
                                        <p class="x-small opacity-75 mb-0">Global transit protection.</p>
                                    </label>
                                </div>
                                <div class="mt-auto pt-4 text-center">
                                    <i class="fas fa-shield-alt fa-3x opacity-25"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" onclick="prevStep(3)">Back</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="prepareCheckout()">Step 7: Review & Pay <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- STEP 5: REVIEW & PAYMENT -->
                <div class="step-pane d-none" id="step-5">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                                <h3 class="fw-bold mb-4">Final Review & Checkout</h3>
                                <div class="row g-3">
                                    <div class="col-6 bg-light p-3 rounded-4">
                                        <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px;">Shipment ID (Step 9 Preview)</small>
                                        <span class="fw-bold text-primary">TZC-GENERATING...</span>
                                    </div>
                                    <div class="col-6 bg-light p-3 rounded-4">
                                        <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px;">Customs Declaration</small>
                                        <span class="text-success fw-bold"><i class="fas fa-check-circle"></i> AUTO-GENERATED HS Code</span>
                                    </div>
                                </div>
                                
                                <div class="input-group mb-4 mt-4 w-75 mx-auto">
                                    <input type="text" name="promo_code" class="form-control bg-light border-0" placeholder="Promo Code">
                                    <button class="btn btn-dark px-4" type="button">Apply</button>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-4 border rounded-4 cursor-pointer hover-shadow text-center payment-opt active" data-gateway="Stripe">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" style="height: 30px;">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-4 border rounded-4 cursor-pointer hover-shadow text-center payment-opt" data-gateway="Razorpay">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Razorpay_logo.svg?20201018223610" style="height: 30px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top bg-white" style="top: 2rem;">
                                <h5 class="fw-bold mb-4">Price Breakdown</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Transport Base</small>
                                    <span class="fw-bold" id="summary-base">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Insurance Fee</small>
                                    <span class="fw-bold text-success" id="summary-ins">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4 border-bottom pb-2">
                                    <small class="text-muted">International Tax</small>
                                    <span class="fw-bold" id="summary-tax">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="fw-bold">Total (AUD)</h5>
                                    <h4 class="fw-bold text-primary" id="summary-total">$0.00</h4>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 shadow-lg fw-bold" id="final-submit">PAY & BOOK SHIPMENT <i class="fas fa-lock ms-2"></i></button>
                                <p class="x-small text-muted text-center mt-3 mb-0">128-bit Encrypted Transaction</p>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="provider_id" id="selected-provider-id">
                <input type="hidden" name="hs_code" id="hidden-hs-code" value="6105.10.00">
            </form>
        </div>
    </div>
</div>

<template id="provider-card-template">
    <div class="col-md-6">
        <div class="card provider-card border-0 shadow-sm rounded-4 h-100 cursor-pointer p-4 hover-shadow transition-all" onclick="selectProvider(ID)">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <img src="LOGO_URL" height="30" class="object-fit-contain p-1 bg-light rounded">
                <div class="badge bg-soft-success text-success fw-bold rounded-pill px-3">RATING <i class="fas fa-star ms-1 small"></i></div>
            </div>
            <h5 class="fw-bold mb-1">NAME</h5>
            <div class="text-muted small mb-3">Global Routing: ETA Delivery</div>
            <div class="d-flex justify-content-between align-items-center mt-auto">
                <h4 class="fw-bold text-primary mb-0">$PRICE <small class="text-muted fs-6">AUD</small></h4>
                <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">Select Option</button>
            </div>
        </div>
    </div>
</template>

<template id="recommendation-card-template">
    <div class="col-md-4">
        <div class="card recom-card border-0 shadow rounded-4 text-white p-3 h-100 bg-gradient-TYPE cursor-pointer" onclick="selectProvider(ID)">
            <div class="badge bg-white text-dark small fw-bold mb-3 d-inline-block px-3 py-1 rounded-pill">TYPE_LABEL</div>
            <div class="d-flex align-items-center mb-3">
                <img src="LOGO_URL" height="25" class="bg-white rounded p-1 me-2 object-fit-contain" style="width: 35px;">
                <h6 class="mb-0 fw-bold">NAME</h6>
            </div>
            <h4 class="fw-bold mb-1">$PRICE</h4>
            <div class="small opacity-75">ETA: ETA Days</div>
        </div>
    </div>
</template>

<style>
    .step-item .step-circle { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; margin: 0 auto; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .step-item.active .step-circle { transform: scale(1.25); box-shadow: 0 0 20px rgba(13, 110, 253, 0.4); border: 2px solid white; }
    .step-item.completed .step-circle { background-color: #198754 !important; }
    .bg-navy { background-color: #001f3f !important; }
    .text-navy { color: #001f3f !important; }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-gradient-dark { background: linear-gradient(135deg, #1e293b, #000000); }
    .bg-gradient-blue { background: linear-gradient(135deg, #0d6efd, #004dc7); }
    .bg-gradient-green { background: linear-gradient(135deg, #198754, #105e3a); }
    .bg-gradient-orange { background: linear-gradient(145deg, #f59e0b, #d97706); }
    .transition-all { transition: all 0.3s ease; }
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
    .payment-opt.active { border: 3px solid #0d6efd !important; background: #f0f7ff; }
    .max-w-100 { max-width: 100px; }
</style>

<script>
    let currentStep = 1;
    let selectedProviderData = null;

    const hsCodeMap = {
        'Documents': '4901.10.00',
        'Textiles': '6105.10.00',
        'Electronics': '8517.13.00',
        'Food': '1905.90.00',
        'Others': '0000.00.00'
    };

    const countryRules = {
        'India': { desc: 'Strict KYC required. No satellite phones.', prohibited: ['Drone', 'Currency'] },
        'USA': { desc: 'FDA approval for food. High security screening.', prohibited: ['Chemicals'] },
        'UK': { desc: 'Brexit trade rules apply. VAT required.', prohibited: ['Liquid'] },
        'Australia': { desc: 'Biosecurity check on wood/dirt.', prohibited: ['Seeds', 'Plants'] }
    };

    function mapHSCode(cat) {
        const code = hsCodeMap[cat] || '0000.00.00';
        document.getElementById('hs-display').innerText = code;
        document.getElementById('hidden-hs-code').value = code;
    }

    function checkProhibited(val) {
        const forbidden = ['battery', 'liquid', 'drug', 'weapon', 'gun', 'powder', 'chemical', 'gas'];
        const box = document.getElementById('warning-box');
        const msg = document.getElementById('warning-msg');
        let detected = forbidden.filter(word => val.toLowerCase().includes(word));
        
        if (detected.length > 0) {
            box.classList.remove('d-none');
            msg.innerText = `Restricted item detected: "${detected[0]}". This will be blocked at Customs.`;
            document.getElementById('step-3-next').disabled = true;
        } else {
            box.classList.add('d-none');
            // Re-enable based on checkbox
            document.getElementById('step-3-next').disabled = !document.getElementById('legal-check').checked;
        }
    }

    function toggleDocs(val) {
        const docBox = document.getElementById('high-value-docs');
        if (parseFloat(val) >= 1000) {
            docBox.classList.remove('d-none');
        } else {
            docBox.classList.add('d-none');
        }
    }

    function nextStep(step) {
        if (step === 3) {
            // Load Country Rules based on Destination Input in Step 1
            const destination = document.querySelector('input[name="destination_city"]').value;
            const banner = document.getElementById('country-rules-alert');
            const name = document.getElementById('target-country-name');
            const desc = document.getElementById('country-rule-desc');
            
            let found = false;
            Object.keys(countryRules).forEach(c => {
                if (destination.includes(c)) {
                    name.innerText = c.toUpperCase();
                    desc.innerText = countryRules[c].desc;
                    found = true;
                }
            });
            if(!found) { name.innerText = 'GLOBAL'; desc.innerText = 'Applying Standard International Customs Protocol.'; }
        }

        document.querySelectorAll('.step-pane').forEach(p => p.classList.add('d-none'));
        document.getElementById('step-' + step).classList.remove('d-none');
        
        document.querySelectorAll('.step-item').forEach((item, index) => {
            if (index + 1 < step) { item.classList.add('completed'); item.classList.remove('active'); }
            else if (index + 1 == step) { item.classList.add('active'); item.classList.remove('completed'); }
            else item.classList.remove('active', 'completed');
        });
        currentStep = step;
        window.scrollTo(0, 0);
    }

    function prevStep(step) { nextStep(step); }

    function searchProviders() {
        const formData = new FormData(document.getElementById('cargo-booking-form'));
        const btn = event.target;
        const oldHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-satellite fa-spin"></i> Analyzing Global Routes...';
        btn.disabled = true;

        fetch('{{ route('cargo.dashboard.search.providers') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(r => r.json()).then(data => {
            if (data.success) {
                renderProviders(data.providers, data.recommendations);
                nextStep(2);
            }
        }).finally(() => { btn.innerHTML = oldHtml; btn.disabled = false; });
    }

    function renderProviders(providers, recs) {
        const container = document.getElementById('providers-list');
        const recContainer = document.getElementById('recommendations-container');
        container.innerHTML = ''; recContainer.innerHTML = '';

        Object.keys(recs).forEach(key => {
            const p = recs[key]; if (!p) return;
            let type = key === 'cheapest' ? 'green' : (key === 'fastest' ? 'blue' : 'orange');
            let label = key.replace('_', ' ').toUpperCase();
            let html = document.getElementById('recommendation-card-template').innerHTML;
            html = html.replace(/ID/g, p.id).replace(/TYPE/g, type).replace(/TYPE_LABEL/g, label)
                       .replace(/NAME/g, p.name).replace(/LOGO_URL/g, p.logo)
                       .replace(/PRICE/g, p.price).replace(/ETA/g, p.eta);
            recContainer.innerHTML += html;
        });

        providers.forEach(p => {
            let html = document.getElementById('provider-card-template').innerHTML;
            html = html.replace(/ID/g, p.id).replace(/NAME/g, p.name).replace(/LOGO_URL/g, p.logo)
                       .replace(/PRICE/g, p.price).replace(/ETA/g, p.eta).replace(/RATING/g, p.rating);
            container.innerHTML += html;
        });
    }

    function selectProvider(id) {
        document.getElementById('selected-provider-id').value = id;
        nextStep(3);
    }

    function prepareCheckout() {
        // Fix: Use correct IDs from the updated form
        const weightInput = document.getElementById('parcel_weight');
        const valInput = document.getElementById('dec_val');
        
        const weight = weightInput ? parseFloat(weightInput.value) : 1;
        const val = valInput ? parseFloat(valInput.value) : 150;
        const insCheck = document.querySelector('input[name="insurance_plan"]:checked');
        const ins = insCheck ? insCheck.value : 'None';
        
        let base = weight * 42.50; // Standard Global Rate
        let insFee = ins === 'Premium' ? (val * 0.05) : 0;
        let tax = (base + insFee) * 0.10;
        let total = base + insFee + tax;

        // Update Summary UI
        const baseEl = document.getElementById('summary-base');
        const insEl = document.getElementById('summary-ins');
        const taxEl = document.getElementById('summary-tax');
        const totalEl = document.getElementById('summary-total');

        if(baseEl) baseEl.innerText = '$' + base.toFixed(2);
        if(insEl) insEl.innerText = '$' + insFee.toFixed(2);
        if(taxEl) taxEl.innerText = '$' + tax.toFixed(2);
        if(totalEl) totalEl.innerText = '$' + total.toFixed(2);
        
        nextStep(5);
    }

    document.getElementById('cargo-booking-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('final-submit');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...'; btn.disabled = true;

        fetch('{{ route('cargo.dashboard.store') }}', {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(r => r.json()).then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Shipment Created!',
                    text: 'Universal Customs ID Generated: TZC-' + Math.random().toString(36).substr(2, 6).toUpperCase(),
                    icon: 'success',
                    confirmButtonText: 'Go to Tracking <i class="fas fa-arrow-right ms-1"></i>',
                    confirmButtonColor: '#001f3f'
                }).then(() => window.location.href = data.redirect);
            } else {
                Swal.fire('Booking Failed', data.message || 'Check form data', 'error');
                btn.innerHTML = 'PAY & BOOK SHIPMENT <i class="fas fa-lock ms-2"></i>';
                btn.disabled = false;
            }
        }).catch(err => {
            Swal.fire('System Error', 'Could not connect to secure server.', 'error');
            btn.innerHTML = 'PAY & BOOK SHIPMENT <i class="fas fa-lock ms-2"></i>';
            btn.disabled = false;
        });
    });
</script>
@endsection

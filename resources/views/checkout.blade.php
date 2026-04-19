@extends('layouts.app')

@section('title', 'Secure Checkout | Trip\'Stay')

@section('styles')
<style>
    :root {
        --checkout-bg: #f4f7fa;
        --navy: #0b3d61;
        --orange: #f97316;
        --green: #22c55e;
    }

    body { background-color: var(--checkout-bg); }

    .checkout-header-steps {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 70px;
        z-index: 100;
        padding: 15px 0;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .step-item.active { color: var(--navy); }
    .step-item.completed { color: var(--green); }

    .step-number {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
        color: #64748b;
        font-size: 11px;
    }

    .step-item.active .step-number { background: var(--navy); color: #fff; }
    .step-item.completed .step-number { background: var(--green); color: #fff; }

    .price-lock-banner {
        background: var(--navy);
        color: #fff;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
    }

    .checkout-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .form-label-premium {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .custom-input {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        color: var(--navy);
        font-size: 14px;
        transition: all 0.2s;
    }

    .custom-input:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 4px rgba(11, 61, 97, 0.05);
        outline: none;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .pay-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 15px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .pay-card.active {
        border-color: var(--navy);
        background: rgba(11, 61, 97, 0.02);
    }

    .pay-card .check-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: var(--navy);
        display: none;
    }

    .pay-card.active .check-icon { display: block; }

    .fare-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
    }

    .total-row {
        border-top: 1.5px dashed #e2e8f0;
        margin-top: 20px;
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-confirm {
        background: var(--navy);
        color: #fff;
        border: none;
        border-radius: 15px;
        padding: 18px;
        font-weight: 800;
        width: 100%;
        margin-top: 20px;
        transition: all 0.3s;
    }

    .btn-confirm:hover {
        background: #001f3f;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(11, 61, 97, 0.2);
    }
    .bg-primary-light { background: rgba(11, 61, 97, 0.05); }
    .border-dashed { border-style: dashed !important; }

    /* Passport Expiry Warning */
    .passport-warning {
        display: none;
        align-items: flex-start;
        gap: 10px;
        background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        border: 1.5px solid #fb923c;
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 8px;
        animation: slideInWarning 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .passport-warning.show { display: flex; }
    @keyframes slideInWarning {
        from { opacity: 0; transform: translateY(-8px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0)  scale(1); }
    }
    .passport-warning-icon {
        width: 32px; height: 32px; min-width: 32px;
        background: #fb923c;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 15px;
    }
    .passport-warning-title {
        font-size: 12px; font-weight: 900;
        color: #9a3412; text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .passport-warning-body {
        font-size: 12px; font-weight: 600; color: #c2410c; line-height: 1.5;
    }
    .passport-expiry-input.is-invalid-passport {
        border-color: #fb923c !important;
        box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.12) !important;
    }

    /* FFN Styling */
    .ffn-toggle:checked {
        background-color: #f97316;
        border-color: #f97316;
    }
    .ffn-fields {
        animation: fadeInDown 0.3s ease;
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="checkout-header-steps">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-4">
            <div class="step-item completed">
                <div class="step-number"><i class="fas fa-check"></i></div>
                <span>Search</span>
            </div>
            <div style="width:30px; height:2px; background:#e2e8f0;"></div>
            <div class="step-item completed">
                <div class="step-number"><i class="fas fa-check"></i></div>
                <span>Select</span>
            </div>
            <div style="width:30px; height:2px; background:#e2e8f0;"></div>
            <div class="step-item active">
                <div class="step-number">3</div>
                <span>Payment</span>
            </div>
        </div>
        <div class="price-lock-banner">
            <i class="fas fa-bolt-lightning text-warning"></i>
            <span>PRICE LOCKED FOR <span id="timer" class="font-monospace ms-2">09:59</span></span>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-lg-8">
            @if(auth()->check() && (auth()->user()->name == 'New User' || !auth()->user()->phone))
                <!-- Mandatory Profile Update -->
                <div id="compulsory-profile-section" class="card border-0 shadow-sm mb-4 reveal p-4" style="border-radius:24px; border: 2.5px solid #0076f7 !important; background: #f0f9ff;">
                    <h5 class="fw-900 text-navy mb-1 d-flex align-items-center gap-3">
                         <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:40px; height:40px; font-size: 16px;"><i class="fas fa-user-edit"></i></span>
                         Completing Your Secure Profile
                         <span class="badge bg-danger rounded-pill x-small px-3 py-2" style="font-size: 10px; letter-spacing: 1px;">ACTION REQUIRED</span>
                    </h5>
                    <p class="text-muted small fw-bold mb-4 ps-5">We need your official details to issue your booking tickets and send SMS updates.</p>
                    
                    <div class="row g-3 ps-md-5">
                        <div class="col-md-6">
                            <label class="form-label small fw-900 text-navy mb-2" style="font-size: 11px; letter-spacing: 0.5px;">YOUR FULL NAME (AS PER ID)</label>
                            <div class="input-group border rounded-pill overflow-hidden bg-white shadow-sm">
                                <span class="input-group-text bg-white border-0 px-3"><i class="fas fa-user opacity-50"></i></span>
                                <input type="text" id="profile_name_update" class="form-control border-0 py-2 px-1 fw-bold" value="{{ auth()->user()->name != 'New User' ? auth()->user()->name : '' }}" placeholder="e.g. Rahul Sharma" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-900 text-navy mb-2" style="font-size: 11px; letter-spacing: 0.5px;">VERIFIED CONTACT NUMBER</label>
                            <div class="input-group border rounded-pill overflow-hidden bg-white shadow-sm">
                                <span class="input-group-text bg-white border-0 px-3"><i class="fas fa-phone opacity-50"></i></span>
                                <input type="text" id="profile_phone_update" class="form-control border-0 py-2 px-1 fw-bold" value="{{ auth()->user()->phone }}" placeholder="10-Digit Mobile Number" required>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Travelers Section -->
            <div id="booking-main-form">
            <!-- Bulk Upload Options -->
            <div class="checkout-card mb-4 border-dashed bg-light bg-opacity-50">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-900 text-navy mb-1"><i class="fas fa-file-export me-2 text-primary"></i> Upload Passenger Manifest</h6>
                        <p class="text-muted small fw-bold mb-0">Booking for a group? Upload DOC, CSV or EXCEL list instead of manual entry.</p>
                    </div>
                    <div>
                        <input type="file" id="bulkTravelerFile" class="d-none">
                        <button class="btn btn-navy rounded-pill px-4 fw-800" onclick="document.getElementById('bulkTravelerFile').click()">
                            UPLOAD FILE
                        </button>
                    </div>
                </div>
            </div>

            <div id="travelersContainer">
                <!-- Single Traveler Block -->
                <div class="checkout-card traveler-block shadow-sm mb-4" id="traveler-1">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <h5 class="fw-900 text-navy mb-0">Traveler #1 <span class="badge bg-primary-light text-navy fw-800 x-small ms-2 primary-tag">PRIMARY</span></h5>
                            <div class="class-selector-area d-flex align-items-center gap-2">
                                <span class="text-muted fw-bold" style="font-size: 10px;">CABIN:</span>
                                <select class="form-select border-navy text-navy fw-800 cabin-class-dropdown" style="font-size: 11px; padding: 4px 12px; border-radius: 50px; width: auto;">
                                    <option value="Y">ECONOMY (Y)</option>
                                    <option value="J">BUSINESS (J)</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger border-0 d-none remove-traveler" onclick="this.closest('.traveler-block').remove(); reorderTravelers();"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label-premium">Title</label>
                            <select class="form-select custom-input"><option>Mr</option><option>Mrs</option><option>Ms</option></select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label-premium">First Name</label>
                            <input type="text" class="form-control custom-input" placeholder="e.g. Rahul" value="">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label-premium">Last Name</label>
                            <input type="text" class="form-control custom-input" placeholder="e.g. Sharma" value="">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label-premium">Date of Birth</label>
                            <input type="date" class="form-control custom-input">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-premium">Gender</label>
                            <select class="form-select custom-input">
                                <option disabled selected>Select</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Non-binary</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-premium">Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 custom-input px-2" style="border-radius: 12px 0 0 12px; font-size:12px;">+91</span>
                                <input type="tel" class="form-control custom-input border-start-0" value="" style="border-radius: 0 12px 12px 0;" placeholder="Mobile Number">
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <label class="form-label-premium">Email Address</label>
                            <input type="email" class="form-control custom-input" placeholder="your@email.com" value="{{ auth()->user()->email ?? '' }}">
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top border-light">
                            <h6 class="fw-800 text-navy small mb-3">
                                <i class="fas fa-id-card me-2 text-primary"></i> Identification Details
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-premium">ID Type</label>
                            <select class="form-select custom-input">
                                <option>Aadhar Card</option>
                                <option>Passport</option>
                                <option>Driving License</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-premium">ID Number / Passport Number</label>
                            <input type="text" class="form-control custom-input" placeholder="Enter number">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Traveler Button -->
            <button class="btn btn-outline-navy w-100 rounded-pill py-3 mb-4 fw-900 border-dashed" id="addTravelerBtn" style="border: 2px dashed #cbd5e1; background: #fff;">
                <i class="fas fa-plus-circle me-2"></i> ADD ANOTHER TRAVELER
            </button>

            <!-- Payment -->
            <div class="checkout-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <h5 class="fw-900 text-navy mb-4">Secure Payment Gateway</h5>
                
                <div class="alert bg-white border rounded-4 p-3 mb-4 d-flex align-items-center gap-4 shadow-sm border-primary border-opacity-25">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="28">
                    <div class="vr opacity-10" style="height: 30px;"></div>
                    <div>
                        <div class="fw-900 text-navy" style="font-size: 13px;">PCI-DSS COMPLIANT ENCRYPTION</div>
                        <div class="fw-bold small text-muted">Your card details are never stored on our servers.</div>
                    </div>
                </div>

                <div class="p-4 bg-white border border-light rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label-premium mb-0">Credit / Debit Card Details</label>
                        <div class="d-flex gap-2 payment-icons">
                            <img src="https://img.icons8.com/color/48/visa.png" width="28">
                            <img src="https://img.icons8.com/color/48/mastercard.png" width="28">
                            <img src="https://img.icons8.com/color/48/amex.png" width="28">
                        </div>
                    </div>
                    <div id="card-element" class="form-control custom-input bg-light bg-opacity-25 py-3" style="min-height: 52px; display: flex; align-items: center;">
                        <!-- Stripe Element will be injected here -->
                    </div>
                    <div id="card-errors" role="alert" class="text-danger small mt-2 fw-bold"></div>
                </div>
                
                <div class="mt-4 p-3 rounded-4 bg-success bg-opacity-5 d-flex align-items-center gap-3 border border-success border-opacity-10">
                    <i class="fas fa-shield-check text-success fs-4"></i>
                    <div class="small fw-bold text-success opacity-75">Your payment is protected by multi-layer bank security protocols.</div>
                </div>
            </div>
            </div>
        </div>

        <!-- Price Summary Column -->
        <div class="col-lg-4">
            <div class="checkout-card sticky-top" style="top: 150px;">
                <h5 class="fw-900 text-navy mb-4">Price Summary</h5>
                <div class="fare-summary-row border-bottom pb-2 mb-2">
                    <span class="text-muted fw-bold small">Base Fare</span>
                    <span id="summaryBaseFare" class="text-navy fw-800">₹0</span>
                </div>
                <div class="fare-summary-row border-bottom pb-2 mb-2">
                    <span class="text-muted fw-bold small">Taxes & Service Fee</span>
                    <span id="summaryTaxes" class="text-navy fw-800">₹0</span>
                </div>
                <div id="discountRow" class="fare-summary-row text-success border-bottom pb-2 mb-2 d-none">
                    <span class="fw-bold small">Promotional Discount</span>
                    <span id="summaryDiscount" class="fw-800">-₹0</span>
                </div>

                <div class="total-row mt-4 p-3 bg-primary-light rounded-4">
                    <div>
                        <div class="form-label-premium mb-0 fw-900 text-primary" style="font-size: 10px;">TOTAL AMOUNT PAYABLE</div>
                        <div id="summaryTotal" class="display-6 fw-900 text-navy" style="font-size: 1.8rem;">₹0</div>
                    </div>
                </div>

                <button onclick="confirmBooking()" class="btn-confirm btn btn-primary w-100 py-3 rounded-pill fw-900 shadow-lg mt-4" style="font-size: 15px; background: linear-gradient(135deg, #002f55 0%, #0076f7 100%); border:none;">
                    CONFIRM BOOKING <i class="fas fa-arrow-right ms-2"></i>
                </button>
                
                <div class="text-center mt-3 d-flex align-items-center justify-content-center gap-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="15" style="opacity:0.5;">
                    <span class="text-muted fw-bold" style="font-size: 11px;"><i class="fas fa-lock me-1"></i> End-to-End Encrypted</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    const stripeKey = "{{ $stripeKey }}";
    const stripe = Stripe(stripeKey);
    const elements = stripe.elements();

    // Style for Stripe Element
    const style = {
        base: {
            color: '#0b3d61',
            fontFamily: '"Outfit", sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '14px',
            '::placeholder': { color: '#94a3b8' }
        },
        invalid: { color: '#ef4444', iconColor: '#ef4444' }
    };

    const card = elements.create('card', { style: style });
    card.mount('#card-element');

    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) displayError.textContent = event.error.message;
        else displayError.textContent = '';
    });

    document.addEventListener('DOMContentLoaded', function() {
        const type = "{{ $type }}";
        @if(isset($item))
        const itemData = @json($item);
        console.log("Item Data Initialized:", itemData);

        if (itemData) {
            // Restore Flight Header Details
            if (type === 'flight') {
                let dep = '???', arr = '???';
                if (itemData.itineraries && itemData.itineraries[0]) {
                    const segs = itemData.itineraries[0].segments;
                    dep = segs[0].departure.iataCode;
                    arr = segs[segs.length-1].arrival.iataCode;
                } else if (itemData.departure_city && itemData.arrival_city) {
                    dep = itemData.departure_city;
                    arr = itemData.arrival_city;
                }
                const summaryTitle = document.querySelector('.sticky-top h5');
                if (summaryTitle) {
                    const detailEl = document.createElement('div');
                    detailEl.className = 'x-small fw-800 text-muted text-uppercase mb-3';
                    detailEl.innerHTML = `<i class="fas fa-plane me-1"></i> ${dep} → ${arr}`;
                    summaryTitle.after(detailEl);
                }
            }

            // Resolve Price logic for both Amadeus (raw) and UnifiedFlight (internal)
            let basePrice = 0;
            if (type === 'flight') {
                if (itemData.price && typeof itemData.price === 'object') {
                    basePrice = itemData.price.total || 0;
                } else if (itemData.price) {
                    basePrice = itemData.price;
                }
            } else {
                basePrice = itemData.price || 0;
            }

            const baseFare = parseFloat(basePrice) || 0;
            const taxes = Math.round(baseFare * 0.12); 
            const total = baseFare + taxes; 

            document.getElementById('summaryBaseFare').innerText = '₹' + baseFare.toLocaleString('en-IN');
            document.getElementById('summaryTaxes').innerText = '₹' + taxes.toLocaleString('en-IN');
            document.getElementById('summaryTotal').innerText = '₹' + total.toLocaleString('en-IN');
        }
        @endif
    });

    window.confirmBooking = async function() {
        if (!isLoggedIn) {
            // Trigger Website Login Modal instead of Info Alert
            const modalEl = document.getElementById('loginModal');
            if (modalEl) {
                const loginModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                loginModal.show();
            } else {
                Swal.fire('Login Required', 'Please login to continue booking.', 'info');
            }
            return;
        }

        const btn = document.querySelector('.btn-confirm');
        const originalText = btn.innerHTML;

        try {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> AUTHORIZING...';
            btn.classList.add('disabled');

            // 1. Create Stripe Token
            const {token, error} = await stripe.createToken(card);
            if (error) {
                throw new Error(error.message);
            }

            // 2. Collect Traveler Data
            const travelers = [];
            document.querySelectorAll('.traveler-block').forEach((block, idx) => {
                const fname = block.querySelector('input[placeholder*="Rahul"]')?.value || block.querySelector('input[placeholder*="First"]')?.value;
                const lname = block.querySelector('input[placeholder*="Sharma"]')?.value || block.querySelector('input[placeholder*="Last"]')?.value;
                if (!fname || !lname) throw new Error(`Please enter full name for Traveler #${idx + 1}`);

                travelers.push({
                    first_name: fname,
                    last_name: lname,
                    dob: block.querySelector('input[type="date"]')?.value || '1995-01-01',
                    id_number: block.querySelector('input[placeholder*="number"]')?.value || '',
                    email: block.querySelector('input[type="email"]')?.value || '',
                    mobile: block.querySelector('input[type="tel"]')?.value || ''
                });
            });

            const payload = {
                _token: "{{ csrf_token() }}",
                stripeToken: token.id,
                type: "{{ $type }}",
                travelers: travelers,
                item_id: "{{ $item['id'] ?? '' }}",
                total_amount: document.getElementById('summaryTotal').innerText.replace(/[₹,]/g, '').trim()
            };

            const response = await fetch("{{ route('checkout.process') }}", {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            if (data.success) {
                Swal.fire({ 
                    title: '<span class="text-navy fw-900">Booking Confirmed!</span>', 
                    text: data.message, 
                    icon: 'success',
                    confirmButtonColor: '#002f55'
                }).then(() => window.location.href = data.redirect);
            } else {
                throw new Error(data.message || "Payment processing failed.");
            }

        } catch (e) {
            Swal.fire({
                title: '<span class="text-danger fw-900">Payment Failed</span>',
                text: e.message,
                icon: 'error',
                confirmButtonColor: '#0b3d61'
            });
            btn.innerHTML = originalText;
            btn.classList.remove('disabled');
        }
    }

    // Add Traveler Logic
    document.getElementById('addTravelerBtn').onclick = function() {
        const container = document.getElementById('travelersContainer');
        const original = document.querySelector('.traveler-block');
        const newBlock = original.cloneNode(true);
        
        const count = document.querySelectorAll('.traveler-block').length + 1;
        newBlock.id = `traveler-${count}`;
        
        // Fix header text
        const h5 = newBlock.querySelector('h5');
        if(h5) h5.innerHTML = `Traveler #${count}`;
        
        // Remove primary tag if exists in clone
        newBlock.querySelector('.primary-tag')?.remove();
        
        // Show and configure remove button
        const removeBtn = newBlock.querySelector('.remove-traveler');
        if(removeBtn) {
            removeBtn.classList.remove('d-none');
            removeBtn.onclick = function() {
                newBlock.remove();
                reorderTravelers();
            };
        }

        // Clear all inputs
        newBlock.querySelectorAll('input').forEach(i => i.value = '');
        newBlock.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        
        container.appendChild(newBlock);
        reorderTravelers();
    };

    function reorderTravelers() {
        document.querySelectorAll('.traveler-block').forEach((block, idx) => {
            const h5 = block.querySelector('h5');
            const primaryTag = block.querySelector('.primary-tag') ? ' <span class="badge bg-primary-light text-navy fw-800 x-small ms-2 primary-tag">PRIMARY</span>' : '';
            if(h5) h5.innerHTML = `Traveler #${idx + 1}${primaryTag}`;
        });
    }

    window.toggleFFN = function(checkbox) {
        const fields = checkbox.closest('.col-12').querySelector('.ffn-fields');
        if (checkbox.checked) {
            fields.style.display = 'flex';
        } else {
            fields.style.display = 'none';
        }
    }

    // Initial Start
    document.addEventListener('DOMContentLoaded', () => {
        // Ready to process
    });
</script>
@endsection

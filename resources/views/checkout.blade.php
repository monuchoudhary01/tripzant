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
                <span>Select Flight</span>
            </div>
            <div style="width:30px; height:2px; background:#e2e8f0;"></div>
            <div class="step-item active">
                <div class="step-number">3</div>
                <span>Traveler Details</span>
            </div>
            <div style="width:30px; height:2px; background:#e2e8f0;"></div>
            <div class="step-item">
                <div class="step-number">4</div>
                <span>Seat</span>
            </div>
            <div style="width:30px; height:2px; background:#e2e8f0;"></div>
            <div class="step-item">
                <div class="step-number">5</div>
                <span>Add-ons</span>
            </div>
            <div style="width:30px; height:2px; background:#e2e8f0;"></div>
            <div class="step-item">
                <div class="step-number">6</div>
                <span>Payment</span>
            </div>
        </div>
        <div class="price-lock-banner">
            <i class="fas fa-bolt-lightning text-warning"></i>
            <span>PRICE LOCKED FOR <span id="timer" class="font-monospace ms-2">09:59</span></span>
        </div>
    </div>
</div>

@php
    $userName = auth()->check() ? auth()->user()->name : '';
    $nameParts = explode(' ', $userName);
    $firstName = $nameParts[0] ?? '';
    if ($firstName === 'New') $firstName = ''; // Handle default "New User"
    $lastName = (count($nameParts) > 1) ? implode(' ', array_slice($nameParts, 1)) : '';
    if ($lastName === 'User') $lastName = '';
@endphp

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
                            <input type="text" class="form-control custom-input traveler-fname" placeholder="e.g. Rahul" value="{{ $firstName }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label-premium">Last Name</label>
                            <input type="text" class="form-control custom-input traveler-lname" placeholder="e.g. Sharma" value="{{ $lastName }}">
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
                                <input type="tel" class="form-control custom-input border-start-0 traveler-mobile" value="{{ auth()->user()->mobile ?? auth()->user()->phone ?? '' }}" style="border-radius: 0 12px 12px 0;" placeholder="Mobile Number">
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <label class="form-label-premium">Email Address</label>
                            <input type="email" class="form-control custom-input traveler-email" placeholder="your@email.com" value="{{ auth()->user()->email ?? '' }}">
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

            <!-- NEW: Customize Your Journey (MMT Style Flow) -->
            <div class="checkout-card mb-4" id="customizeSection">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-900 text-navy mb-0"><i class="fas fa-magic me-2 text-primary"></i> Personalize Your Journey</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-800 rounded-pill px-3 py-1" style="font-size: 10px;">OPTIONAL</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-4 d-flex align-items-center gap-3 hvr-grow bg-white shadow-sm" onclick="openSeatModal()" style="cursor:pointer; transition: 0.3s; border: 1.5px solid #f1f5f9 !important;">
                            <div class="icon-box-customize bg-primary-light text-primary"><i class="fas fa-chair"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-900 text-navy mb-0" style="font-size:14px;">Select Preferred Seat</div>
                                <div class="small text-muted fw-bold">Windows, Aisle or Extra Legroom</div>
                                <div id="selectedSeatBadge" class="d-none mt-1"><span class="badge bg-success bg-opacity-10 text-success fw-800" style="font-size:9px;">SEAT SELECTED</span></div>
                            </div>
                            <i class="fas fa-chevron-right text-muted opacity-30"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-4 d-flex align-items-center gap-3 hvr-grow bg-white shadow-sm" onclick="openAddonsModal()" style="cursor:pointer; transition: 0.3s; border: 1.5px solid #f1f5f9 !important;">
                            <div class="icon-box-customize bg-orange-light text-warning"><i class="fas fa-suitcase-rolling"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-900 text-navy mb-0" style="font-size:14px;">Baggage & Meals</div>
                                <div class="small text-muted fw-bold">Pre-book & save up to 40%</div>
                                <div id="selectedAddonBadge" class="d-none mt-1"><span class="badge bg-primary bg-opacity-10 text-primary fw-800" style="font-size:9px;">ADD-ONS ADDED</span></div>
                            </div>
                            <i class="fas fa-chevron-right text-muted opacity-30"></i>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .icon-box-customize {
                    width: 45px;
                    height: 45px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 18px;
                }
                .bg-primary-light { background: #eff6ff; }
                .bg-orange-light { background: #fff7ed; }
                .bg-success-light { background: #f0fdf4; }
            </style>

            </div>
        </div>

        <!-- Price Summary Column -->
        <div class="col-lg-4">
            <div class="checkout-card sticky-top" style="top: 150px;">
                <h5 class="fw-900 text-navy mb-1">Price Summary</h5>
                <div id="itineraryBreakdown" class="mb-4">
                    <!-- Dynamic segments will be injected here -->
                </div>
                
                <div class="fare-summary-row border-bottom pb-2 mb-2">
                    <span class="text-muted fw-bold small">Base Fare</span>
                    <span id="summaryBaseFare" class="text-navy fw-800">₹0</span>
                </div>
                <div class="fare-summary-row border-bottom pb-2 mb-2" id="paxMultiplyRow">
                    <span class="text-muted fw-bold small">Travelers</span>
                    <span id="summaryPaxCount" class="text-navy fw-800">× 1</span>
                </div>
                <div class="fare-summary-row border-bottom pb-2 mb-2">
                    <span class="text-muted fw-bold small">Taxes &amp; Service Fee</span>
                    <span id="summaryTaxes" class="text-navy fw-800">₹0</span>
                </div>
                <!-- Dynamic Add-ons -->
                <div id="seatChargeRow" class="fare-summary-row border-bottom pb-2 mb-2 d-none">
                    <div class="d-flex justify-content-between w-100">
                        <span class="text-muted fw-bold small">Assigned Seats</span>
                        <span id="summarySeatFare" class="text-navy fw-800">₹0</span>
                    </div>
                </div>
                <div id="addonChargeRow" class="fare-summary-row border-bottom pb-2 mb-2 d-none">
                    <div class="d-flex justify-content-between w-100">
                        <span class="text-muted fw-bold small">Extra Baggage & Meals</span>
                        <span id="summaryAddonFare" class="text-navy fw-800">₹0</span>
                    </div>
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
                    PROCEED TO SEAT SELECTION <i class="fas fa-arrow-right ms-2"></i>
                </button>
                
                <div class="text-center mt-3">
                    <span class="text-muted fw-bold" style="font-size: 11px;"><i class="fas fa-info-circle me-1"></i> Payment will be collected at the end after selecting seats &amp; add-ons</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seat Modal -->
<div class="modal fade" id="seatModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0"><h5 class="modal-title fw-900">Select Your Seat</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    @foreach(['1A','1B','1C','2A','2B','2C'] as $seat)
                        <div class="m-seat" onclick="selectSeatInModal('{{$seat}}', 500)">{{$seat}}</div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-primary w-100 rounded-pill" data-bs-dismiss="modal">Save Selection</button></div>
        </div>
    </div>
</div>

<!-- Addons Modal -->
<div class="modal fade" id="addonsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0"><h5 class="modal-title fw-900">Baggage & Meals</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="meal-card-m mb-3" onclick="selectMealInModal(300, 'Veg Meal')">Veg Meal (+₹300)</div>
                        <div class="meal-card-m" onclick="selectMealInModal(400, 'Non-Veg Meal')">Non-Veg Meal (+₹400)</div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-primary w-100 rounded-pill" data-bs-dismiss="modal">Save Selection</button></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // MMT Style State Management
    let globalCheckoutData = null;
    let extraCharges = {
        seats: 0,
        baggage: 0,
        meals: 0,
        details: { seats: [], baggage: null, meal: null }
    };

    function refreshTotal() {
        const itemData = globalCheckoutData || @json($item);
        let basePrice = parseFloat("{{ $totalPrice ?? 0 }}");
        
        if (basePrice <= 0 && itemData) {
            if (Array.isArray(itemData)) {
                basePrice = itemData.reduce((sum, f) => sum + parseFloat(f.price || 0), 0);
            } else if (itemData.price && typeof itemData.price === 'object') {
                basePrice = parseFloat(itemData.price.total || 0);
            } else if (itemData.price) {
                basePrice = parseFloat(itemData.price);
            }
        }

        const paxCount = document.querySelectorAll('.traveler-block').length;
        const paxTotal = basePrice * paxCount;
        const seatFare = extraCharges.seats;
        const addonFare = extraCharges.baggage + extraCharges.meals;
        const tax = (paxTotal + seatFare + addonFare) * 0.12;
        
        let preDiscountTotal = paxTotal + seatFare + addonFare + tax;
        let bankDiscount = 0;
        
        if (itemData && itemData.bankOffer) {
            const offer = itemData.bankOffer;
            if (preDiscountTotal >= (offer.min_amount || 0)) {
                if (offer.discount_type === 'percentage') {
                    bankDiscount = Math.floor(preDiscountTotal * offer.discount_value / 100);
                    if (offer.max_discount) bankDiscount = Math.min(bankDiscount, offer.max_discount);
                } else {
                    bankDiscount = offer.discount_value;
                }
            }
        }
        
        const total = Math.max(0, preDiscountTotal - bankDiscount);

        document.getElementById('summaryBaseFare').innerText = '₹' + Math.round(basePrice).toLocaleString();
        document.getElementById('summaryPaxCount').innerText = '× ' + paxCount;
        document.getElementById('summaryTaxes').innerText = '₹' + Math.round(tax).toLocaleString();
        
        if (seatFare > 0) {
            document.getElementById('seatChargeRow').classList.remove('d-none');
            document.getElementById('seatChargeRow').classList.add('d-flex');
            document.getElementById('summarySeatFare').innerText = '₹' + Math.round(seatFare).toLocaleString();
            document.getElementById('selectedSeatBadge')?.classList.remove('d-none');
        }

        if (addonFare > 0) {
            document.getElementById('addonChargeRow').classList.remove('d-none');
            document.getElementById('addonChargeRow').classList.add('d-flex');
            document.getElementById('summaryAddonFare').innerText = '₹' + Math.round(addonFare).toLocaleString();
            document.getElementById('selectedAddonBadge')?.classList.remove('d-none');
        }

        const discountRow = document.getElementById('discountRow');
        if (bankDiscount > 0 && discountRow) {
            discountRow.classList.remove('d-none');
            discountRow.classList.add('d-flex');
            document.getElementById('summaryDiscount').innerText = '-₹' + Math.round(bankDiscount).toLocaleString();
            
            if (!document.getElementById('appliedBankOfferBox')) {
                const offerBox = document.createElement('div');
                offerBox.id = 'appliedBankOfferBox';
                offerBox.className = 'alert alert-success border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3';
                offerBox.style.background = '#f0fdf4';
                offerBox.innerHTML = `
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:40px; height:40px;"><i class="fas fa-tags"></i></div>
                    <div>
                        <div class="fw-900 text-success mb-0" style="font-size:14px;">${itemData.bankOffer.display_name} Applied!</div>
                        <div class="small fw-bold text-success opacity-75">You saved ₹${Math.round(bankDiscount).toLocaleString()} on this booking</div>
                    </div>
                `;
                const summaryContainer = document.getElementById('itineraryBreakdown');
                if (summaryContainer) summaryContainer.insertAdjacentElement('afterend', offerBox);
            } else {
                document.querySelector('#appliedBankOfferBox .small').innerText = `You saved ₹${Math.round(bankDiscount).toLocaleString()} on this booking`;
            }
        } else if (discountRow) {
            discountRow.classList.add('d-none');
            discountRow.classList.remove('d-flex');
            if (document.getElementById('appliedBankOfferBox')) document.getElementById('appliedBankOfferBox').remove();
        }

        document.getElementById('summaryTotal').innerText = '₹' + Math.round(total).toLocaleString();
    }

    window.openSeatModal = () => new bootstrap.Modal(document.getElementById('seatModal')).show();
    window.openAddonsModal = () => new bootstrap.Modal(document.getElementById('addonsModal')).show();

    window.selectSeatInModal = function(num, p) {
        extraCharges.seats = p;
        extraCharges.details.seats = [num];
        refreshTotal();
    };

    window.selectMealInModal = function(p, name) {
        extraCharges.meals = p;
        extraCharges.details.meal = name;
        refreshTotal();
    };

    window.confirmBooking = async function() {
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal')).show();
            return;
        }

        const btn = document.querySelector('.btn-confirm');
        const originalText = btn.innerHTML;

        try {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> SAVING...';
            btn.classList.add('disabled');

            const travelers = [];
            let hasError = false;
            document.querySelectorAll('.traveler-block').forEach((block, idx) => {
                const fname = block.querySelector('.traveler-fname')?.value?.trim();
                const lname = block.querySelector('.traveler-lname')?.value?.trim();
                const email = block.querySelector('.traveler-email')?.value?.trim();
                const mobile = block.querySelector('.traveler-mobile')?.value?.trim();

                if (!fname || !lname || !email || !mobile) {
                    hasError = true;
                    throw new Error(`Traveler #${idx + 1} ki details incomplete hain. Sabhi required fields fill karein.`);
                }

                travelers.push({
                    first_name: fname,
                    last_name: lname,
                    email: email,
                    mobile: mobile,
                    dob: block.querySelector('input[type="date"]')?.value || '1990-01-01'
                });
            });

            const rawTotal = document.getElementById('summaryTotal')?.innerText || '';
            let parsedAmount = parseFloat(rawTotal.replace(/[₹,\s]/g, '')) || 0;

            if (parsedAmount <= 0) {
                parsedAmount = parseFloat("{{ $totalPrice ?? 0 }}") * travelers.length || 0;
            }

            if (parsedAmount <= 0) {
                throw new Error('Booking amount calculate nahi ho saka. Page reload karein.');
            }

            const payload = {
                _token: "{{ csrf_token() }}",
                type: "{{ $type }}",
                travelers: travelers,
                total_amount: parsedAmount,
                item_data: @json($item)
            };

            const resp = await fetch("{{ route('checkout.save-travelers') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                body: JSON.stringify(payload)
            });

            const contentType = resp.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) {
                const text = await resp.text();
                throw new Error('Server error: ' + resp.status + '. Please try again.');
            }

            const data = await resp.json();
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message || 'Could not proceed. Please try again.');
            }
        } catch (e) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: e.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#002f55'
            });
            btn.innerHTML = originalText;
            btn.classList.remove('disabled');
        }
    };

    document.getElementById('addTravelerBtn').onclick = function() {
        const container = document.getElementById('travelersContainer');
        const blocks = document.querySelectorAll('.traveler-block');
        const original = blocks[0];
        const newBlock = original.cloneNode(true);
        
        const count = blocks.length + 1;
        
        const h5 = newBlock.querySelector('h5');
        if(h5) h5.innerHTML = `Traveler #${count}`;
        
        newBlock.querySelector('.primary-tag')?.remove();
        
        const removeBtn = newBlock.querySelector('.remove-traveler');
        if(removeBtn) {
            removeBtn.classList.remove('d-none');
            removeBtn.onclick = function() {
                newBlock.remove();
                reorderTravelers();
                refreshTotal();
            };
        }

        newBlock.querySelectorAll('input').forEach(i => i.value = '');
        newBlock.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        
        container.appendChild(newBlock);
        reorderTravelers();
        refreshTotal();
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

    function initItinerary() {
        const urlParams = new URLSearchParams(window.location.search);
        const urlId = urlParams.get('id');

        let itemData = @json($item);
        const storedFlight = localStorage.getItem('selectedFlight');

        // Robust recovery from localStorage if server data is missing
        if ((!itemData || (Array.isArray(itemData) && itemData.length === 0)) && storedFlight) {
            const parsed = JSON.parse(storedFlight);
            if (parsed.id == urlId) {
                console.log("Recovered itinerary from localStorage");
                itemData = parsed;
            }
        }
        
        globalCheckoutData = itemData;

        if (!itemData || (Array.isArray(itemData) && itemData.length === 0)) return;

        const container = document.getElementById('itineraryBreakdown');
        if (!container) return;

        let html = '';
        const flights = Array.isArray(itemData) ? itemData : [itemData];

        flights.forEach(f => {
            html += `
                <div class="p-3 bg-light rounded-4 mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-navy text-white fw-800">${f.airline || 'Flight'}</span>
                        <span class="text-muted small fw-bold">${f.flight_number || ''}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-center">
                            <div class="fw-900 text-navy fs-5">${f.dep_city || f.departure_city || f.from || '---'}</div>
                            <div class="small text-muted fw-bold">${f.dep_time || (f.departure_at ? new Date(f.departure_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '')}</div>
                        </div>
                        <div class="flex-grow-1 px-3 position-relative text-center">
                            <div class="border-top w-100 position-absolute top-50 start-0 opacity-10"></div>
                            <i class="fas fa-plane text-navy opacity-20 position-relative bg-light px-2" style="z-index: 1;"></i>
                        </div>
                        <div class="text-center">
                            <div class="fw-900 text-navy fs-5">${f.arr_city || f.arrival_city || f.to || '---'}</div>
                            <div class="small text-muted fw-bold">${f.arr_time || (f.arrival_at ? new Date(f.arrival_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '')}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    // State Persistence (Survives login refresh)
    function saveCheckoutFormState() {
        const travelers = [];
        document.querySelectorAll('.traveler-block').forEach(block => {
            const data = {};
            block.querySelectorAll('input, select').forEach(input => {
                const label = input.closest('div')?.querySelector('.form-label-premium')?.innerText || 'field';
                data[label] = input.value;
            });
            travelers.push(data);
        });
        sessionStorage.setItem('checkout_form_state', JSON.stringify(travelers));
    }

    function loadCheckoutFormState() {
        const saved = sessionStorage.getItem('checkout_form_state');
        if (!saved) return;
        const travelers = JSON.parse(saved);
        
        // Match traveler count
        for (let i = 1; i < travelers.length; i++) {
            const addBtn = document.getElementById('addTravelerBtn');
            if (addBtn) addBtn.click();
        }

        document.querySelectorAll('.traveler-block').forEach((block, idx) => {
            if (travelers[idx]) {
                block.querySelectorAll('input, select').forEach(input => {
                    const label = input.closest('div')?.querySelector('.form-label-premium')?.innerText || 'field';
                    if (travelers[idx][label] !== undefined) {
                        input.value = travelers[idx][label];
                    }
                });
            }
        });
    }

    // Initial Start
    document.addEventListener('DOMContentLoaded', () => {
        try {
            loadCheckoutFormState();
            initItinerary();
            refreshTotal();
            
            // Attach auto-save
            const mainForm = document.getElementById('booking-main-form');
            if (mainForm) {
                mainForm.addEventListener('input', saveCheckoutFormState);
                mainForm.addEventListener('change', saveCheckoutFormState);
            }
        } catch (e) {
            console.error("Initialization Error:", e);
        }
    });
</script>
@endsection

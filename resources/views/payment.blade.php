@extends('layouts.app')

@section('title', 'Secure Payment | Tripzant')

@section('styles')
<style>
    :root {
        --trip-blue: #005eb8;
        --trip-dark: #003366;
        --trip-border: #e2e8f0;
    }

    body {
        background-color: #f1f5f9 !important;
        font-family: 'Outfit', sans-serif;
    }

    .payment-method-card {
        background: white;
        border: 1.5px solid var(--trip-border);
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .method-tab {
        padding: 20px;
        cursor: pointer;
        border-bottom: 1px solid var(--trip-border);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: 0.2s;
    }
    .method-tab:last-child { border-bottom: none; }
    .method-tab:hover { background: #f8fafc; }
    .method-tab.active {
        background: #eff6ff;
        border-left: 4px solid var(--trip-blue);
    }

    .method-content {
        padding: 30px;
        background: white;
        border: 1.5px solid var(--trip-border);
        border-radius: 20px;
        display: none;
    }
    .method-content.active { display: block; }

    .qr-box {
        width: 200px;
        height: 200px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fare-summary-glass {
        background: white;
        border-radius: 20px;
        padding: 25px;
        position: sticky;
        top: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Payment Methods -->
        <div class="col-lg-8">
            <h4 class="fw-900 mb-4 text-navy">Payment Options</h4>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="payment-method-card">
                        <div class="method-tab active" onclick="switchMethod('upi', this)">
                            <i class="fas fa-qrcode text-primary"></i>
                            <div>
                                <div class="fw-900 small">UPI / QR Code</div>
                                <div class="x-small text-muted">GPay, PhonePe, Paytm</div>
                            </div>
                        </div>
                        <div class="method-tab" onclick="switchMethod('card', this)">
                            <i class="fas fa-credit-card text-success"></i>
                            <div>
                                <div class="fw-900 small">Credit / Debit Card</div>
                                <div class="x-small text-muted">Visa, MC, Amex, Rupay</div>
                            </div>
                        </div>
                        <div class="method-tab" onclick="switchMethod('net', this)">
                            <i class="fas fa-university text-danger"></i>
                            <div>
                                <div class="fw-900 small">Net Banking</div>
                                <div class="x-small text-muted">All Indian Banks</div>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code Box -->
                    <div class="p-4 bg-white border rounded-4 mt-4">
                        <h6 class="fw-900 small mb-3">Apply Coupon Code</h6>
                        <div class="input-group">
                            <input type="text" id="couponCode" class="form-control border-end-0 rounded-start-pill" placeholder="e.g. FLYBIG">
                            <button class="btn btn-navy rounded-end-pill px-4 fw-900" style="font-size: 11px;" onclick="applyPromo()">APPLY</button>
                        </div>
                        <div id="promoError" class="x-small fw-bold text-danger mt-2 d-none">Invalid Code</div>
                        <div id="promoSuccess" class="x-small fw-bold text-success mt-2 d-none">Coupon Applied!</div>
                    </div>
                </div>

                <div class="col-md-8">
                    <!-- UPI CONTENT -->
                    <div id="upi-content" class="method-content active">
                        <h5 class="fw-900 mb-3">Scan UPI QR Code</h5>
                        <p class="small text-muted mb-4">Pay using any UPI app like Google Pay, PhonePe, or BHIM.</p>
                        
                        <div class="qr-box mb-4">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=tripzant-payment" alt="QR Code">
                        </div>
                        
                        <div class="text-center">
                            <div class="small fw-bold opacity-50 mb-1">OR ENTER UPI ID</div>
                            <div class="input-group w-75 mx-auto mb-4">
                                <input type="text" class="form-control text-center rounded-pill" placeholder="username@upi">
                            </div>
                            <button class="btn btn-primary w-100 py-3 rounded-pill fw-900" onclick="processPayment()">VERIFY & PAY</button>
                        </div>
                    </div>

                    <!-- CARD CONTENT -->
                    <div id="card-content" class="method-content">
                        <h5 class="fw-900 mb-3">Enter Card Details</h5>
                        <form id="cardForm">
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Card Number</label>
                                <input type="text" class="form-control py-3" placeholder="XXXX XXXX XXXX XXXX">
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <label class="small fw-bold mb-1">Expiry Date</label>
                                    <input type="text" class="form-control py-3" placeholder="MM / YY">
                                </div>
                                <div class="col-6">
                                    <label class="small fw-bold mb-1">CVV</label>
                                    <input type="password" class="form-control py-3" placeholder="***">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary w-100 py-3 rounded-pill fw-900" onclick="processPayment()">SECURE PAY</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Order Summary -->
        <div class="col-lg-4">
            <div class="fare-summary-glass">
                <h6 class="fw-900 text-muted mb-4 fs-12" style="letter-spacing:1px;">BOOKING SUMMARY</h6>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Route & Assigned Seats</span>
                    <span class="fw-900" id="baseTotal">₹0</span>
                </div>
                <div id="extraCharges"></div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Taxes & GST (12%)</span>
                    <span class="fw-900" id="gstAmountLine">+₹0</span>
                </div>
                
                <!-- GST Summary Logic -->
                <div id="gstSummaryBlock" class="d-none mt-3 p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-900 x-small text-primary"><i class="fas fa-file-invoice me-1"></i> GST BILLING</span>
                        <span class="badge bg-primary x-small">CORPORATE</span>
                    </div>
                    <div class="x-small fw-bold text-navy opacity-50" id="gstCompanyName">COMPANY NAME</div>
                    <div class="x-small fw-900 text-primary" id="gstNumberDisplay">GSTIN: 07AAAAA0000A1Z5</div>
                </div>

                <div id="discountBlock" class="d-none">
                    <div class="d-flex justify-content-between my-2 text-success fw-bold">
                        <span>Coupon Discount</span>
                        <span id="discPrice">-₹1,000</span>
                    </div>
                </div>
                
                <div class="text-end mt-3 mb-3">
                    <a href="javascript:void(0)" onclick="window.showFareRules('Indigo', '6E-2134')" class="x-small text-primary fw-bold text-decoration-none border-bottom border-dashed border-primary">VIEW FARE RULES</a>
                </div>
                
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-900 text-navy">TOTAL PAYABLE</span>
                    <h3 class="fw-900 text-primary mb-0" id="grandTotal">₹0</h3>
                </div>

                <div class="p-3 bg-light rounded-4 x-small italic fw-bold text-center">
                    <i class="fas fa-lock me-1 text-success"></i> 256-bit SSL Encrypted Secure Checkout
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const passengers = JSON.parse(localStorage.getItem('last_booking_passengers') || '[]');
    const seats = JSON.parse(localStorage.getItem('selected_seats') || '{}');
    const addons = JSON.parse(localStorage.getItem('selected_addons') || '{"bags":{},"meal":{"price":0},"ins":false}');
    
    let base = 80530;
    let extras = 0;
    let taxes = 0;
    let promoDisc = 0;

    function init() {
        Object.values(seats).forEach(s => base += (s.price || 0));
        
        let extraHtml = '';
        Object.values(addons.bags).forEach(b => {
             if(b.price > 0) {
                 extras += b.price;
             }
        });
        if(addons.meal.price > 0) extras += addons.meal.price;
        if(addons.ins) extras += (passengers.length * 499);
        if(addons.flex) extras += (passengers.length * 899);

        document.getElementById('baseTotal').innerText = `₹${base.toLocaleString()}`;
        if(extras > 0) {
            document.getElementById('extraCharges').innerHTML = `
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Service Add-ons</span>
                    <span class="fw-900">+₹${extras.toLocaleString()}</span>
                </div>
            `;
        }

        // TAX CALCULATION
        taxes = Math.round(base * 0.12);
        document.getElementById('gstAmountLine').innerText = `+₹${taxes.toLocaleString()}`;

        // --- GST Inclusion logic ---
        const gstData = JSON.parse(localStorage.getItem('booking_gst') || 'null');
        if (gstData && gstData.gstin) {
            document.getElementById('gstSummaryBlock').classList.remove('d-none');
            document.getElementById('gstCompanyName').innerText = gstData.company || 'Corporate Booking';
            document.getElementById('gstNumberDisplay').innerText = `GSTIN: ${gstData.gstin}`;
        }

        renderTotal();
    }

    function renderTotal() {
        const final = base + extras + taxes - promoDisc;
        document.getElementById('grandTotal').innerText = `₹${final.toLocaleString()}`;
    }

    function switchMethod(type, el) {
        document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.method-content').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        document.getElementById(`${type}-content`).classList.add('active');
    }

    function applyPromo() {
        const code = document.getElementById('couponCode').value.toUpperCase();
        if(code === 'FLYBIG' || code === 'FIRSTTRIP') {
            promoDisc = 1500;
            document.getElementById('discPrice').innerText = `-₹${promoDisc.toLocaleString()}`;
            document.getElementById('discountBlock').classList.remove('d-none');
            document.getElementById('promoSuccess').classList.remove('d-none');
            document.getElementById('promoError').classList.add('d-none');
            renderTotal();
        } else {
            document.getElementById('promoError').classList.remove('d-none');
            document.getElementById('promoSuccess').classList.add('d-none');
        }
    }

    function processPayment() {
        Swal.fire({
            title: 'Verifying Transaction...',
            html: 'Communicating with bank gateway...',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => { Swal.showLoading(); }
        }).then(() => {
            Swal.fire({
                title: 'Payment Confirmed!',
                text: 'Your flight PNR is being allocated.',
                icon: 'success',
                confirmButtonColor: '#005eb8'
            }).then(() => {
                window.location.href = '/booking-confirmation';
            });
        });
    }

    window.showFareRules = function(airline, flight) {
        Swal.fire({
            title: `<div class="text-start fs-5 fw-900 text-navy">${airline} (${flight}) - Fare Rules & Policies</div>`,
            html: `
                <div class="text-start border rounded-4 bg-light overflow-hidden">
                    <div class="p-3 bg-white border-bottom">
                         <h6 class="fw-900 x-small text-muted mb-2 uppercase" style="letter-spacing:1px;">📜 CANCELLATION & CHANGE</h6>
                         <div class="row g-2">
                             <div class="col-6"><div class="p-2 border rounded-3 bg-light"><div class="x-small fw-bold">Cancel Fee</div><div class="fw-900 text-danger">₹3,500 <span class="x-small">/pax</span></div></div></div>
                             <div class="col-6"><div class="p-2 border rounded-3 bg-light"><div class="x-small fw-bold">Change Fee</div><div class="fw-900 text-primary">₹3,000 <span class="x-small">/pax</span></div></div></div>
                         </div>
                    </div>
                    <div class="p-4">
                         <div class="mb-4">
                            <div class="fw-900 small text-navy"><i class="fas fa-id-card me-2 text-primary"></i> Name Correction Charges</div>
                            <div class="x-small text-muted fw-bold">₹500 per passenger for minor spelling corrections. Major name changes/transfers are treated as cancellations.</div>
                         </div>
                         <div class="mb-4">
                            <div class="fw-900 small text-navy"><i class="fas fa-walking me-2 text-warning"></i> No-Show Policy</div>
                            <div class="x-small text-muted fw-bold">Tickets are non-refundable in case of a No-Show. Only statutory Govt. taxes are refundable.</div>
                         </div>
                         <div class="mb-0">
                            <div class="fw-900 small text-navy"><i class="fas fa-suitcase me-2 text-success"></i> Standard Baggage Policy</div>
                            <div class="x-small text-muted fw-bold">Cabin: 7KG (1 pc) | Check-in: 15KG (1 pc) included per adult.</div>
                         </div>
                    </div>
                    <div class="p-3 bg-white border-top x-small text-center fw-bold text-muted italic">
                        *Charges are per passenger per sector. Total = Airline Fee + Tripzant Service Fee.
                    </div>
                </div>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            width: '500px',
            customClass: { popup: 'rounded-4 overflow-hidden border-0 shadow-lg' }
        });
    };

    document.addEventListener('DOMContentLoaded', init);
</script>
@endsection

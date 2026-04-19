@extends('layouts.app')

@section('title', "Complete Your Booking — Tripzant BNB")

@section('content')
<div class="py-5" style="background: #f0f4f8; min-height: 100vh;">
    <div class="container">
        <!-- Progress Steps -->
        <div class="row justify-content-center mb-5 animate-up">
            <div class="col-lg-6">
                <div class="d-flex justify-content-between position-relative">
                    <div class="step-line border-top border-primary border-2 position-absolute w-100 top-50 start-0 z-0"></div>
                    <div class="step-point bg-primary text-white rounded-circle d-flex align-items-center justify-content-center position-relative z-1" style="width: 32px; height: 32px; font-size: 14px; font-weight: 800;">1</div>
                    <div class="step-point bg-primary text-white rounded-circle d-flex align-items-center justify-content-center position-relative z-1" style="width: 32px; height: 32px; font-size: 14px; font-weight: 800;">2</div>
                    <div class="step-point bg-white text-navy border-2 border-navy rounded-circle d-flex align-items-center justify-content-center position-relative z-1" style="width: 32px; height: 32px; font-size: 14px; font-weight: 800;">3</div>
                </div>
                <div class="d-flex justify-content-between mt-2 x-small fw-900 text-uppercase text-navy letter-spacing-1">
                    <span>SELECT ROOM</span>
                    <span>GUEST INFO</span>
                    <span>PAYMENT</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Side: Guest Info Form -->
            <div class="col-lg-8 animate-up" style="animation-delay:0.1s;">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center gap-3">
                         <div class="p-3 bg-navy text-white rounded-4 shadow-sm"><i class="fas fa-user-friends"></i></div>
                         <div>
                            <h5 class="fw-900 text-navy mb-0">Guest Details</h5>
                            <p class="text-muted small mb-0">Please enter guest details as per government ID.</p>
                         </div>
                    </div>
                    <div class="card-body p-4">
                        <form id="hotelGuestForm">
                            <div class="row row-cols-1 row-cols-md-2 g-4 h5">
                                <div class="col">
                                    <label class="form-label x-small fw-900 text-muted text-uppercase mb-2">First Name</label>
                                    <input type="text" class="form-control rounded-3 border-light-subtle py-2 fw-bold text-navy" placeholder="e.g. Rahul">
                                </div>
                                <div class="col">
                                    <label class="form-label x-small fw-900 text-muted text-uppercase mb-2">Last Name</label>
                                    <input type="text" class="form-control rounded-3 border-light-subtle py-2 fw-bold text-navy" placeholder="e.g. Sharma">
                                </div>
                                <div class="col">
                                    <label class="form-label x-small fw-900 text-muted text-uppercase mb-2">Email Address</label>
                                    <input type="email" class="form-control rounded-3 border-light-subtle py-2 fw-bold text-navy" placeholder="e.g. rahul@example.com">
                                </div>
                                <div class="col">
                                    <label class="form-label x-small fw-900 text-muted text-uppercase mb-2">Mobile Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 fw-bold">+91</span>
                                        <input type="text" class="form-control rounded-end-3 border-light-subtle py-2 fw-bold text-navy" placeholder="9876543210">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5 opacity-10">

                            <h5 class="fw-900 text-navy mb-4"><i class="fas fa-plus-circle me-2 text-primary"></i> Guest 2 (Adult)</h5>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                <div class="col">
                                    <label class="form-label x-small fw-900 text-muted text-uppercase mb-2">First Name</label>
                                    <input type="text" class="form-control rounded-3 border-light-subtle py-2 fw-bold text-navy" placeholder="e.g. Priya">
                                </div>
                                <div class="col">
                                    <label class="form-label x-small fw-900 text-muted text-uppercase mb-2">Last Name</label>
                                    <input type="text" class="form-control rounded-3 border-light-subtle py-2 fw-bold text-navy" placeholder="e.g. Sharma">
                                </div>
                            </div>

                            <!-- Special Requests -->
                            <div class="mt-5">
                                <h5 class="fw-900 text-navy mb-4"><i class="fas fa-comment-dots me-2 text-warning"></i> Special Requests (Optional)</h5>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="form-check p-0">
                                            <input type="checkbox" class="btn-check" id="req1" autocomplete="off">
                                            <label class="btn btn-outline-navy w-100 fw-bold x-small py-2 px-3 rounded-pill" for="req1">Twin Beds</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check p-0">
                                            <input type="checkbox" class="btn-check" id="req2" autocomplete="off">
                                            <label class="btn btn-outline-navy w-100 fw-bold x-small py-2 px-3 rounded-pill" for="req2">Smoking Room</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check p-0">
                                            <input type="checkbox" class="btn-check" id="req3" autocomplete="off">
                                            <label class="btn btn-outline-navy w-100 fw-bold x-small py-2 px-3 rounded-pill" for="req3">Late Check-in</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <textarea class="form-control rounded-4 border-light-subtle py-3 fw-bold x-small" rows="2" placeholder="Any other specific requests?"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('hotel.details') }}" class="btn btn-link text-muted fw-bold text-decoration-none"><i class="fas fa-arrow-left me-2"></i> BACK TO DETAILS</a>
                    <button type="button" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-lg hover-glow animate-pulse" onclick="window.location.href='{{ route('hotel.payment') }}'">
                        PROCEED TO PAYMENT <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Right Side: Order Review Sticker -->
            <div class="col-lg-4 animate-up" style="animation-delay:0.2s;">
                <div class="sticky-top" style="top:90px;">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                        <div class="card-body p-0 card-glass">
                            <div class="p-4 bg-navy text-white d-flex align-items-center gap-3">
                                 <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=80&auto=format&fit=crop&q=80" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                 <div>
                                     <h6 class="fw-900 text-white mb-0">Taj Exotica Resort & Spa</h6>
                                     <span class="x-small text-white-50 fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Benaulim, Goa</span>
                                 </div>
                            </div>
                            <div class="p-4 bg-white">
                                <div class="mb-4">
                                     <span class="x-small text-muted d-block fw-900 text-uppercase mb-1 letter-spacing-1">SELECTED ROOM</span>
                                     <h6 class="fw-800 text-navy mb-2">Garden Villa Room</h6>
                                     <div class="d-flex flex-wrap gap-2">
                                         <span class="badge bg-light border text-navy fw-800 py-1 px-2" style="font-size:9px;"><i class="fas fa-utensils me-1"></i> BREAKFAST INCL.</span>
                                         <span class="badge bg-light border text-success fw-800 py-1 px-2" style="font-size:9px;"><i class="fas fa-check me-1"></i> REFUNDABLE</span>
                                     </div>
                                </div>
                                <div class="row g-2 text-center mb-4 border-top pt-4">
                                     <div class="col-6 border-end">
                                          <span class="x-small text-muted d-block fw-bold">CHECK-IN</span>
                                          <h6 class="fw-900 text-navy mb-0">12 Nov 2025</h6>
                                     </div>
                                     <div class="col-6">
                                          <span class="x-small text-muted d-block fw-bold">CHECK-OUT</span>
                                          <h6 class="fw-900 text-navy mb-0">15 Nov 2025</h6>
                                     </div>
                                </div>
                                <hr class="my-4 opacity-10">
                                <div class="price-breakdown">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small fw-800 text-muted">Base Fare (3 Nights)</span>
                                        <span class="small fw-900 text-navy">₹85,500</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small fw-800 text-muted">GST & Fees</span>
                                        <span class="small fw-900 text-navy">₹8,450</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3 border-top pt-3">
                                        <span class="fw-900 text-navy h5 mb-0">GRAND TOTAL</span>
                                        <span class="fw-900 text-primary h4 mb-0">₹93,950</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-navy { color: #02234b; }
.btn-navy { background: #02234b; color: #fff; }
.btn-navy:hover { background: #001f3f; color: #fff; }
.btn-outline-navy { border-color: #02234b; color: #02234b; }
.btn-outline-navy:hover { background: #02234b; color: #fff; }
.btn-check:checked + label { background-color: var(--primary); color: #fff; border-color: var(--primary); }
.letter-spacing-1 { letter-spacing: 1px; }
.x-small { font-size: 11px; }

.form-control { border-width: 1.5px; transition: all 0.3s; }
.form-control:focus { border-color: var(--primary); box-shadow: 0 0 10px rgba(var(--primary-rgb), 0.1); }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.hover-glow:hover { box-shadow: 0 0 20px rgba(var(--primary-rgb), 0.4) !important; }
.animate-pulse { animation: soft-pulse 2.5s infinite ease-in-out; }
@keyframes soft-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}
</style>
@endsection

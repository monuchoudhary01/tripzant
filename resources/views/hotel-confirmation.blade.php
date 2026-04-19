@extends('layouts.app')

@section('title', "Booking Confirmed! — Tripzant BNB")

@section('content')
<div class="py-5" style="background: #f0f4f8; min-height: 100vh;">
    <div class="container text-center">
        <!-- Success Animation & Title -->
        <div class="mb-5 animate-up">
            <div class="success-checkmark mx-auto">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>
            <h1 class="fw-900 text-navy mt-4 mb-2" style="font-size:42px; letter-spacing:-1.5px;">Booking Confirmed!</h1>
            <p class="text-muted fs-5 fw-600">Your hotel stay has been instantly booked. Booking ID: <span class="text-primary fw-900">#TZ-HB-24101</span></p>
        </div>

        <div class="row justify-content-center g-4 animate-up" style="animation-delay:0.1s;">
            <!-- Main Confirmation Details Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden text-start mb-4">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Left: Summary -->
                            <div class="col-md-5 p-5 bg-navy text-white d-flex flex-column justify-content-between">
                                <div>
                                    <span class="x-small fw-800 opacity-50 text-uppercase letter-spacing-1">SELECTED PROPERTY</span>
                                    <h3 class="fw-900 mb-4 mt-2">Taj Exotica Resort & Spa</h3>
                                    
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="p-2 bg-white bg-opacity-10 rounded-3 text-white"><i class="fas fa-calendar-check"></i></div>
                                            <div>
                                                <span class="x-small d-block opacity-50 fw-bold">CHECK-IN</span>
                                                <span class="small fw-800 text-white">12 Nov 2025 · 12:00 PM</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="p-2 bg-white bg-opacity-10 rounded-3 text-white"><i class="fas fa-calendar-times"></i></div>
                                            <div>
                                                <span class="x-small d-block opacity-50 fw-bold">CHECK-OUT</span>
                                                <span class="small fw-800 text-white">15 Nov 2025 · 11:00 AM</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="p-2 bg-white bg-opacity-10 rounded-3 text-white"><i class="fas fa-hotel"></i></div>
                                            <div>
                                                <span class="x-small d-block opacity-50 fw-bold">ROOM TYPE</span>
                                                <span class="small fw-800 text-white">Garden Villa Room (3 Nights)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 p-4 border border-white border-opacity-10 rounded-4">
                                     <h6 class="fw-900 text-white mb-2 x-small text-uppercase">AMOUNT PAID</h6>
                                     <h2 class="fw-900 text-white mb-0 h1">₹93,950</h2>
                                     <span class="x-small text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Paid via Agent Wallet</span>
                                </div>
                            </div>

                            <!-- Right: Guest Info & Actions -->
                            <div class="col-md-7 p-5 bg-white">
                                <h5 class="fw-900 text-navy mb-4 border-bottom pb-2">Guest Information</h5>
                                <div class="row g-4 mb-5">
                                     <div class="col-md-6 col-12">
                                          <span class="x-small text-muted d-block fw-800 mb-1">PRIMARY GUEST</span>
                                          <h6 class="fw-900 text-navy fs-6 mb-0">MR. RAHUL SHARMA</h6>
                                     </div>
                                     <div class="col-md-6 col-12">
                                          <span class="x-small text-muted d-block fw-800 mb-1">GUEST 2</span>
                                          <h6 class="fw-900 text-navy fs-6 mb-0">MRS. PRIYA SHARMA</h6>
                                     </div>
                                     <div class="col-md-6 col-12">
                                          <span class="x-small text-muted d-block fw-800 mb-1">CONFIRMATION AT</span>
                                          <h6 class="fw-900 text-navy fs-6 mb-0">agent@globaltravel.com</h6>
                                     </div>
                                     <div class="col-md-6 col-12">
                                          <span class="x-small text-muted d-block fw-800 mb-1">MOBILE NUMBER</span>
                                          <h6 class="fw-900 text-navy fs-6 mb-0">+91 98765 43210</h6>
                                     </div>
                                </div>

                                <h5 class="fw-900 text-navy mb-4">Voucher Actions</h5>
                                <div class="row g-3">
                                     <div class="col-md-6">
                                          <button class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2"><i class="fas fa-file-pdf"></i> DOWNLOAD VOUCHER</button>
                                     </div>
                                     <div class="col-md-6">
                                          <button class="btn btn-outline-navy w-100 py-3 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2" onclick="alert('Sent via Email!')"><i class="fas fa-envelope"></i> SEND VIA EMAIL</button>
                                     </div>
                                     <div class="col-12">
                                          <button class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" onclick="alert('Sent via WhatsApp!')"><i class="fab fa-whatsapp fs-5"></i> SEND VIA WHATSAPP</button>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Link -->
                <div class="d-flex justify-content-center gap-3">
                    <a href="/" class="btn btn-link text-navy text-decoration-none fw-bold"><i class="fas fa-home me-2"></i> BACK TO HOME</a>
                    <a href="{{ route('agent.hotel.bookings') }}" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-lg">GO TO MY BOOKINGS</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-navy { color: #02234b; }
.bg-navy { background: #02234b; }
.btn-navy { background: #02234b; color: #fff; }
.btn-navy:hover { background: #001f3f; color: #fff; }
.btn-outline-navy { border-color: #02234b; color: #02234b; }
.btn-outline-navy:hover { background: #02234b; color: #fff; }

.success-checkmark { width: 80px; height: 80px; position: relative; }
.success-checkmark .check-icon { width: 80px; height: 80px; border-radius: 50%; border: 4px solid #4CAF50; position: relative; box-sizing: content-box; background-color: #fff; }
.success-checkmark .check-icon::before { top: 3px; left: -2px; width: 30px; transform-origin: 100% 50%; border-radius: 100px 0 0 100px; }
.success-checkmark .check-icon::after { top: 0; left: 30px; width: 60px; transform-origin: 0 50%; border-radius: 0 100px 100px 0; animation: rotate-circle 4.25s ease-in; }
.success-checkmark .check-icon .icon-line { height: 5px; background-color: #4CAF50; display: block; border-radius: 2px; position: absolute; z-index: 10; }
.success-checkmark .check-icon .icon-line.line-tip { top: 46px; left: 14px; width: 25px; transform: rotate(45deg); animation: icon-line-tip 0.75s; }
.success-checkmark .check-icon .icon-line.line-long { top: 38px; right: 8px; width: 47px; transform: rotate(-45deg); animation: icon-line-long 0.75s; }
.success-checkmark .check-icon .icon-circle { top: -4px; left: -4px; z-index: 10; width: 80px; height: 80px; border-radius: 50%; box-sizing: content-box; }
.success-checkmark .check-icon .icon-fix { top: 8px; width: 5px; left: 26px; z-index: 1; height: 85px; transform: rotate(-45deg); background-color: #fff; }

@keyframes icon-line-tip { 0% { width: 0; left: 1px; top: 19px; } 54% { width: 0; left: 1px; top: 19px; } 70% { width: 50px; left: -8px; top: 37px; } 84% { width: 17px; left: 21px; top: 48px; } 100% { width: 25px; left: 14px; top: 46px; } }
@keyframes icon-line-long { 0% { width: 0; right: 46px; top: 54px; } 65% { width: 0; right: 46px; top: 54px; } 84% { width: 55px; right: 0px; top: 35px; } 100% { width: 47px; right: 8px; top: 38px; } }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.x-small { font-size: 11px; }
.letter-spacing-1 { letter-spacing: 1px; }
</style>
@endsection

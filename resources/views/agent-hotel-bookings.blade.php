@extends('layouts.app')

@section('title', "My Hotel Bookings — Tripzant B2B")

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 100vh;">
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-end mb-4 animate-up">
            <div>
                <h2 class="fw-900 text-navy mb-1" style="font-size:32px; letter-spacing:-1px;">My Hotel Bookings</h2>
                <p class="text-muted mb-0 fw-600">Review and manage all your confirmed hotel reservations.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/hotels" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-search me-2"></i> NEW BOOKING</a>
                <button class="btn btn-white border rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-filter me-2"></i> FILTER</button>
            </div>
        </div>

        <div class="row g-4 animate-up" style="animation-delay: 0.1s;">
            <!-- Booking Card 1 (Taj Exotica - Confirmed) -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 booking-list-card transition-03">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 p-4 text-center border-end">
                                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold mb-3 d-inline-block border border-success border-opacity-25" style="font-size:10px;"><i class="fas fa-check-circle me-1"></i> CONFIRMED</div>
                                <h6 class="x-small text-muted fw-bold mb-1">BOOKING ID</h6>
                                <span class="fw-900 text-navy fs-5">#TZ-HB-24101</span>
                            </div>
                            <div class="col-md-4 p-4 border-end">
                                <div class="d-flex align-items-center gap-3">
                                   <div class="hotel-sq-img rounded-3 overflow-hidden shadow-sm" style="width: 70px; height: 70px;">
                                       <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=100&auto=format&fit=crop&q=80" class="h-100 w-100" style="object-fit:cover;">
                                   </div>
                                   <div>
                                       <h6 class="fw-900 text-navy mb-1" style="font-size:16px;">Taj Exotica Resort & Spa</h6>
                                       <p class="x-small text-muted mb-0 fw-600"><i class="fas fa-map-marker-alt text-danger me-1"></i> Benaulim, Goa</p>
                                       <span class="badge bg-light text-navy x-small mt-2 border">Garden Villa · 3 Nights</span>
                                   </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-4 border-end">
                                <div class="mb-3">
                                     <span class="x-small text-muted d-block fw-bold text-uppercase letter-spacing-1 mb-1">STAY DATES</span>
                                     <h6 class="fw-900 text-navy mb-0">12 Nov – 15 Nov, 2025</h6>
                                </div>
                                <div class="mb-0">
                                     <span class="x-small text-muted d-block fw-bold text-uppercase letter-spacing-1 mb-1">PRIMARY GUEST</span>
                                     <h6 class="fw-900 text-navy mb-0">MR. RAHUL SHARMA</h6>
                                </div>
                            </div>
                            <div class="col-md-3 p-4 text-center">
                                <div class="mb-3">
                                   <span class="badge bg-navy text-white fw-900 fs-5 px-3 py-2 rounded-4">₹93,950</span>
                                   <p class="x-small text-muted fw-bold mt-1 mb-0">TOTAL PAID (INC. TAXES)</p>
                                </div>
                                <div class="d-flex gap-2 justify-content-center">
                                   <button class="btn btn-navy rounded-pill x-small fw-900" title="Download Voucher"><i class="fas fa-file-pdf"></i></button>
                                   <button class="btn btn-outline-navy rounded-pill x-small fw-900 px-3">MANAGE</button>
                                   <button class="btn btn-link text-danger text-decoration-none x-small fw-900" title="Cancel Booking">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Card 2 (Radisson - Confirmed) -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 booking-list-card transition-03 opacity-90">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 p-4 text-center border-end">
                                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold mb-3 d-inline-block border border-success border-opacity-25" style="font-size:10px;"><i class="fas fa-check-circle me-1"></i> CONFIRMED</div>
                                <h6 class="x-small text-muted fw-bold mb-1">BOOKING ID</h6>
                                <span class="fw-900 text-navy fs-5">#TZ-HB-24088</span>
                            </div>
                            <div class="col-md-4 p-4 border-end">
                                <div class="d-flex align-items-center gap-3">
                                   <div class="hotel-sq-img rounded-3 overflow-hidden shadow-sm" style="width: 70px; height: 70px;">
                                       <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=100&auto=format&fit=crop&q=80" class="h-100 w-100" style="object-fit:cover;">
                                   </div>
                                   <div>
                                       <h6 class="fw-900 text-navy mb-1" style="font-size:16px;">Radisson Blu Resort</h6>
                                       <p class="x-small text-muted mb-0 fw-600"><i class="fas fa-map-marker-alt text-danger me-1"></i> Cavelossim, South Goa</p>
                                       <span class="badge bg-light text-navy x-small mt-2 border">Superior Room · 2 Nights</span>
                                   </div>
                                </div>
                            </div>
                            <div class="col-md-3 p-4 border-end">
                                <div class="mb-3">
                                     <span class="x-small text-muted d-block fw-bold text-uppercase letter-spacing-1 mb-1">STAY DATES</span>
                                     <h6 class="fw-900 text-navy mb-0">20 Oct – 22 Oct, 2025</h6>
                                </div>
                                <div class="mb-0">
                                     <span class="x-small text-muted d-block fw-bold text-uppercase letter-spacing-1 mb-1">PRIMARY GUEST</span>
                                     <h6 class="fw-900 text-navy mb-0">MR. AMIT VARMA</h6>
                                </div>
                            </div>
                            <div class="col-md-3 p-4 text-center">
                                <div class="mb-3">
                                   <span class="badge bg-navy text-white fw-900 fs-5 px-3 py-2 rounded-4">₹22,450</span>
                                   <p class="x-small text-muted fw-bold mt-1 mb-0">TOTAL PAID (INC. TAXES)</p>
                                </div>
                                <div class="d-flex gap-2 justify-content-center">
                                   <button class="btn btn-navy rounded-pill x-small fw-900"><i class="fas fa-file-pdf"></i></button>
                                   <button class="btn btn-outline-navy rounded-pill x-small fw-900 px-3">MANAGE</button>
                                   <button class="btn btn-link text-danger text-decoration-none x-small fw-900">CANCEL</button>
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

.booking-list-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important; z-index: 2; }
.transition-03 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.x-small { font-size: 11px; }
.letter-spacing-1 { letter-spacing: 1px; }
</style>
@endsection

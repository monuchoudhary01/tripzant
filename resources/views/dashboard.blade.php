@extends('layouts.app')

@section('title', " My Dashboard — Trip Zant Booking.com " )

@section('content')
    <!-- Dashboard Hero -->
    <div class="listing-hero" style="padding:28px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Monu+Choudhary&background=eb8d2f&color=fff&size=128&bold=true" class="rounded-circle border border-3" style="border-color:rgba(255,255,255,.3)!important;" width="64" alt="Profile">
                        <div>
                            <h3 class="fw-900 mb-0">Hi, Monu Choudhary! <span class="badge ms-2" style="background:rgba(37,99,235,.2);color:var(--primary);font-size:11px;padding:5px 12px;border-radius:999px;">✨ Elite Traveller</span></h3>
                            <p style="opacity:.6;margin-bottom:0;font-size:14px;">Manage your trips, rewards, and settings from here.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end TS-3 TS-md-0">
                    <a href="#" class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size:13px;font-weight:600;"><i class="fas fa-cog me-2"></i> Settings</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="dash-sidebar">
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Monu+Choudhary&background=0b3d61&color=fff&size=128&bold=true" class="rounded-circle mb-3" width="80" alt="Profile">
                        <h6 class="fw-800 mb-0">Monu Choudhary</h6>
                        <p style="font-size:12px;color:var(--gray-300);margin-bottom:0;">monuchoudhary.96@gmail.com</p>
                    </div>
                    <hr style="border-color:var(--gray-50);">
                    <nav class="TS-3">
                        <a href="#" class="dash-nav-link active"><i class="fas fa-suitcase-rolling" style="width:20px;"></i> My Bookings</a>
                        <a href="#" class="dash-nav-link"><i class="fas fa-heart" style="width:20px;"></i> Wishlist</a>
                        <a href="#" class="dash-nav-link"><i class="fas fa-wallet" style="width:20px;"></i> Trip Zant Wallet</a>
                        <a href="#" class="dash-nav-link"><i class="fas fa-gift" style="width:20px;"></i> Rewards & Points</a>
                        <a href="#" class="dash-nav-link"><i class="fas fa-star" style="width:20px;"></i> My Reviews</a>
                        <a href="#" class="dash-nav-link"><i class="fas fa-users" style="width:20px;"></i> Co-Travellers</a>
                        <a href="#" class="dash-nav-link"><i class="fas fa-user-cog" style="width:20px;"></i> Profile Settings</a>
                        <hr style="border-color:var(--gray-50);">
                        <a href="#" class="dash-nav-link" style="color:var(--red);"><i class="fas fa-sign-out-alt" style="width:20px;"></i> Logout</a>
                    </nav>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9">
                <!-- Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number" style="color:var(--navy);">12</div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray-300);">Trips Completed</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number" style="color:var(--primary);">2,450</div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray-300);">Trip Points</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number" style="color:var(--green);">₹5,400</div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray-300);">Wallet Balance</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number" style="color:var(--secondary);">3</div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray-300);">Upcoming Trips</div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Trip -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-800 mb-0" style="color:var(--navy);font-size:18px;">Upcoming Trips</h5>
                    <a href="#" class="view-all-link" style="font-size:13px;">View All <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="booking-detail-card" style="border-left:3px solid var(--green);">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <img src="https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=500&auto=format&fit=crop&q=80" class="w-100 rounded-3" alt="Goa" style="height:140px;object-fit:cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="pulse-dot"></span>
                                    <span style="font-size:12px;font-weight:700;color:var(--green);">Confirmed</span>
                                </div>
                                <span style="font-size:12px;color:var(--gray-300);">ID: TS-2025-8473921</span>
                            </div>
                            <h5 class="fw-800 mb-2">3 Nights in South Goa</h5>
                            <p style="font-size:13px;color:var(--gray-300);margin-bottom:6px;"><i class="fas fa-hotel me-1"></i> Taj Exotica Resort & Spa, Benaulim</p>
                            <div class="row">
                                <div class="col-4">
                                    <span style="font-size:11px;color:var(--gray-300);font-weight:600;">DATES</span>
                                    <div class="fw-700" style="font-size:13px;">12 Nov – 15 Nov</div>
                                </div>
                                <div class="col-4">
                                    <span style="font-size:11px;color:var(--gray-300);font-weight:600;">GUESTS</span>
                                    <div class="fw-700" style="font-size:13px;">2 Adults</div>
                                </div>
                                <div class="col-4">
                                    <span style="font-size:11px;color:var(--gray-300);font-weight:600;">AMOUNT</span>
                                    <div class="fw-700" style="font-size:13px;color:var(--navy);">₹80,530</div>
                                </div>
                            </div>
                            <div class="TS-3 pt-3 d-flex gap-2" style="border-top:1px solid var(--gray-50);">
                                <a href="/booking-details" class="btn btn-primary-custom btn-sm px-4" style="font-size:12px;">View Booking</a>
                                <a href="#" class="btn btn-outline-custom btn-sm px-3" style="font-size:12px;">Get Help</a>
                                <a href="#" class="btn btn-outline-custom btn-sm px-3" style="font-size:12px;"><i class="fas fa-download me-1"></i> Invoice</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Past Trip -->
                <div class="booking-detail-card" style="border-left:3px solid var(--gray-200);">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=500&auto=format&fit=crop&q=80" class="w-100 rounded-3" alt="Delhi" style="height:140px;object-fit:cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-size:12px;font-weight:700;color:var(--gray-300);">Completed</span>
                                <span style="font-size:12px;color:var(--gray-300);">ID: TS-2025-6328401</span>
                            </div>
                            <h5 class="fw-800 mb-2">Delhi → Mumbai Flight</h5>
                            <p style="font-size:13px;color:var(--gray-300);margin-bottom:6px;"><i class="fas fa-plane me-1"></i> IndiGo 6E-2432 · Economy</p>
                            <div class="row">
                                <div class="col-4">
                                    <span style="font-size:11px;color:var(--gray-300);font-weight:600;">DATE</span>
                                    <div class="fw-700" style="font-size:13px;">25 Oct 2025</div>
                                </div>
                                <div class="col-4">
                                    <span style="font-size:11px;color:var(--gray-300);font-weight:600;">PASSENGERS</span>
                                    <div class="fw-700" style="font-size:13px;">1 Adult</div>
                                </div>
                                <div class="col-4">
                                    <span style="font-size:11px;color:var(--gray-300);font-weight:600;">AMOUNT</span>
                                    <div class="fw-700" style="font-size:13px;color:var(--navy);">₹4,250</div>
                                </div>
                            </div>
                            <div class="TS-3 pt-3 d-flex gap-2" style="border-top:1px solid var(--gray-50);">
                                <a href="#" class="btn btn-outline-custom btn-sm px-3" style="font-size:12px;">View Details</a>
                                <a href="#" class="btn btn-outline-custom btn-sm px-3" style="font-size:12px;"><i class="fas fa-star me-1" style="color:var(--primary);"></i> Write Review</a>
                                <a href="/flights" class="btn btn-outline-custom btn-sm px-3" style="font-size:12px;"><i class="fas fa-redo me-1"></i> Book Again</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="TS-4">
                    <h5 class="fw-800 mb-3" style="color:var(--navy);font-size:18px;">Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="/flights" class="booking-detail-card d-block text-center" style="text-decoration:none;cursor:pointer;">
                                <i class="fas fa-plane" style="font-size:24px;color:var(--secondary);margin-bottom:8px;"></i>
                                <div class="fw-700" style="font-size:14px;color:var(--navy);">Book a Flight</div>
                                <div style="font-size:12px;color:var(--gray-300);">Search & compare prices</div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/hotels" class="booking-detail-card d-block text-center" style="text-decoration:none;cursor:pointer;">
                                <i class="fas fa-hotel" style="font-size:24px;color:var(--primary);margin-bottom:8px;"></i>
                                <div class="fw-700" style="font-size:14px;color:var(--navy);">Find Hotels</div>
                                <div style="font-size:12px;color:var(--gray-300);">Best deals near you</div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="booking-detail-card d-block text-center" style="text-decoration:none;cursor:pointer;">
                                <i class="fas fa-headset" style="font-size:24px;color:var(--green);margin-bottom:8px;"></i>
                                <div class="fw-700" style="font-size:14px;color:var(--navy);">Get Support</div>
                                <div style="font-size:12px;color:var(--gray-300);">24/7 assistance</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

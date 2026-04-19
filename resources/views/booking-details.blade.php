@extends('layouts.app')

@section('title', " Booking Details — Trip Zant Booking.com " )

@section('content')
    <div class="listing-hero" style="padding:28px 0;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="breadcrumb-custom mb-1" style="margin-bottom:0;">
                        <a href="/" style="color:rgba(255,255,255,.5);">Home</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <a href="/dashboard" style="color:rgba(255,255,255,.5);">Dashboard</a>
                        <span class="separator" style="color:rgba(255,255,255,.3);">/</span>
                        <span class="current" style="color:#fff;">Booking Details</span>
                    </div>
                    <h3 class="fw-900 mb-0">Taj Exotica Resort & Spa <span class="badge ms-2" style="background:rgba(39,174,96,.2);color:var(--green);font-size:12px;padding:6px 14px;border-radius:999px;"><i class="fas fa-check-circle me-1"></i> Confirmed</span></h3>
                    <p style="opacity:.6;font-size:13px;margin-bottom:0;">Booking ID: TS-2025-8473921 · Booked on Oct 1, 2025</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light rounded-pill px-3 py-2" style="font-size:12px;font-weight:600;"><i class="fas fa-print me-2"></i>Print</button>
                    <button class="btn btn-outline-light rounded-pill px-3 py-2" style="font-size:12px;font-weight:600;"><i class="fas fa-share-alt me-2"></i>Share</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Check-in/out -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-calendar-alt me-2" style="color:var(--secondary);"></i> Stay Details</h5>
                    <div class="row text-center align-items-center">
                        <div class="col-4">
                            <div style="font-size:11px;color:var(--gray-300);font-weight:700;text-transform:uppercase;">CHECK-IN</div>
                            <h4 class="fw-900 TS-1 mb-1" style="color:var(--navy);">12 Nov' 25</h4>
                            <div style="font-size:13px;color:var(--gray-400);">Wednesday, 2:00 PM</div>
                        </div>
                        <div class="col-4">
                            <div style="background:var(--gray-50);padding:10px 20px;border-radius:12px;display:inline-block;">
                                <i class="fas fa-moon d-block mb-1" style="color:var(--navy);"></i>
                                <span class="fw-800" style="font-size:14px;">3 Nights</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div style="font-size:11px;color:var(--gray-300);font-weight:700;text-transform:uppercase;">CHECK-OUT</div>
                            <h4 class="fw-900 TS-1 mb-1" style="color:var(--navy);">15 Nov' 25</h4>
                            <div style="font-size:13px;color:var(--gray-400);">Saturday, 11:00 AM</div>
                        </div>
                    </div>
                </div>

                <!-- Guest Details -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-users me-2" style="color:var(--secondary);"></i> Guest Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:44px;height:44px;border-radius:50%;background:rgba(0,168,225,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-user" style="color:var(--secondary);"></i>
                                </div>
                                <div>
                                    <div class="fw-800" style="font-size:14px;">Monu Choudhary</div>
                                    <span style="font-size:12px;color:var(--gray-300);">Primary Guest · monu@example.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:44px;height:44px;border-radius:50%;background:rgba(37,99,235,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-user" style="color:var(--primary);"></i>
                                </div>
                                <div>
                                    <div class="fw-800" style="font-size:14px;">Sumit Choudhary</div>
                                    <span style="font-size:12px;color:var(--gray-300);">Guest 2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-bed me-2" style="color:var(--secondary);"></i> Room & Inclusions</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400&auto=format&fit=crop&q=80" class="w-100 rounded-3" alt="Room" style="height:120px;object-fit:cover;">
                        </div>
                        <div class="col-md-9">
                            <h6 class="fw-800 mb-1">Deluxe Sea View Room (Twin Bed)</h6>
                            <p style="font-size:12px;color:var(--gray-300);margin-bottom:10px;">A premium experience with panoramic ocean views, private balcony, and customized mini-bar.</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="amenity-chip" style="padding:4px 12px;font-size:11px;"><i class="fas fa-coffee"></i> Breakfast Included</span>
                                <span class="amenity-chip" style="padding:4px 12px;font-size:11px;"><i class="fas fa-wifi"></i> Free WiFi</span>
                                <span class="amenity-chip" style="padding:4px 12px;font-size:11px;"><i class="fas fa-parking"></i> Free Parking</span>
                                <span class="amenity-chip" style="padding:4px 12px;font-size:11px;"><i class="fas fa-spa"></i> Spa Access</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotel Location -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-map-marker-alt me-2" style="color:var(--secondary);"></i> Hotel Location</h5>
                    <div class="rounded-3 overflow-hidden" style="height:200px;background:var(--gray-50);display:flex;align-items:center;justify-content:center;">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt" style="font-size:40px;color:var(--gray-200);margin-bottom:10px;"></i>
                            <p style="font-size:13px;color:var(--gray-300);margin-bottom:0;">Taj Exotica Resort & Spa, Benaulim, South Goa, Goa 403716</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Sidebar -->
            <div class="col-lg-4">
                <div class="booking-detail-card sticky-top" style="top:80px;">
                    <h5><i class="fas fa-receipt me-2" style="color:var(--secondary);"></i> Payment Summary</h5>

                    <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                        <span style="color:var(--gray-400);">Room Charges (3 Nights)</span>
                        <span class="fw-700">₹73,500</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                        <span style="color:var(--gray-400);">Service Charges & GST</span>
                        <span class="fw-700">₹13,230</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                        <span style="color:var(--green);">Trip Zant Discount</span>
                        <span class="fw-700" style="color:var(--green);">- ₹5,000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                        <span style="color:var(--green);">Coupon (GOAVIBES)</span>
                        <span class="fw-700" style="color:var(--green);">- ₹1,200</span>
                    </div>

                    <hr style="border-color:var(--gray-50);">

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-800 mb-0">Total Paid</h5>
                        <h4 class="fw-900 mb-0" style="color:var(--navy);">₹80,530</h4>
                    </div>

                    <div class="p-3 rounded-3 mb-4" style="background:rgba(39,174,96,.06);border:1px solid rgba(39,174,96,.1);">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle" style="color:var(--green);font-size:24px;"></i>
                            <div>
                                <div class="fw-800" style="font-size:13px;color:var(--green);">Payment Confirmed</div>
                                <span style="font-size:11px;color:var(--gray-300);">Credit Card ending in 4023</span>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary-custom w-100 py-3 mb-2"><i class="fas fa-download me-2"></i> Download Invoice</a>
                    <a href="#" class="btn btn-outline-custom w-100 py-3 mb-2"><i class="fas fa-envelope me-2"></i> Resend Voucher</a>

                    <div class="text-center TS-3">
                        <p style="font-size:12px;color:var(--red);font-weight:700;"><i class="fas fa-info-circle me-1"></i> Cancellation policies apply.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

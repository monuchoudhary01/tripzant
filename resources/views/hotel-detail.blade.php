@extends('layouts.app')

@section('title', " Taj Exotica Resort & Spa, Goa — Trip Zant Booking.com " )
@section('active-hotels', 'active')

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb -->
        <div class="breadcrumb-custom">
            <a href="/">Home</a> <span class="separator">/</span>
            <a href="/hotels">Hotels</a> <span class="separator">/</span>
            <a href="/hotels">Goa Hotels</a> <span class="separator">/</span>
            <span class="current">Taj Exotica Resort & Spa</span>
        </div>

        <!-- Photo Gallery -->
        <div class="detail-gallery mb-4">
            <div class="main-img">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop&q=80" alt="Main View">
            </div>
            <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=500&auto=format&fit=crop&q=80" alt="Pool">
            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=500&auto=format&fit=crop&q=80" alt="Room">
            <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=500&auto=format&fit=crop&q=80" alt="Lobby">
            <div class="gallery-more position-relative">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500&auto=format&fit=crop&q=80" alt="More">
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Title Block -->
                <div class="booking-detail-card">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="tag-premium">5 STAR LUXURY</span>
                                <span class="rating-pill"><i class="fas fa-star" style="font-size:10px"></i> 4.9</span>
                                <span style="font-size:12px;color:var(--gray-300);">480 Reviews</span>
                            </div>
                            <h2 class="fw-900 mb-1" style="font-size:26px;">Taj Exotica Resort & Spa</h2>
                            <p style="font-size:14px;color:var(--gray-300);margin-bottom:0;"><i class="fas fa-map-marker-alt me-1" style="color:var(--secondary);"></i> Benaulim, South Goa, Goa 403716</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-custom btn-sm px-3"><i class="far fa-heart me-1"></i> Save</button>
                            <button class="btn btn-outline-custom btn-sm px-3"><i class="fas fa-share-alt me-1"></i> Share</button>
                        </div>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-concierge-bell me-2" style="color:var(--secondary);"></i> Hotel Amenities</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="amenity-chip"><i class="fas fa-swimming-pool"></i> Infinity Pool</span>
                        <span class="amenity-chip"><i class="fas fa-spa"></i> Luxury Spa</span>
                        <span class="amenity-chip"><i class="fas fa-wifi"></i> Free WiFi</span>
                        <span class="amenity-chip"><i class="fas fa-utensils"></i> 3 Restaurants</span>
                        <span class="amenity-chip"><i class="fas fa-dumbbell"></i> Fitness Center</span>
                        <span class="amenity-chip"><i class="fas fa-parking"></i> Free Parking</span>
                        <span class="amenity-chip"><i class="fas fa-cocktail"></i> Bar & Lounge</span>
                        <span class="amenity-chip"><i class="fas fa-umbrella-beach"></i> Private Beach</span>
                        <span class="amenity-chip"><i class="fas fa-baby"></i> Kids Club</span>
                        <span class="amenity-chip"><i class="fas fa-concierge-bell"></i> Room Service</span>
                        <span class="amenity-chip"><i class="fas fa-shuttle-van"></i> Airport Transfer</span>
                        <span class="amenity-chip"><i class="fas fa-snowflake"></i> Air Conditioning</span>
                    </div>
                </div>

                <!-- Room Types -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-bed me-2" style="color:var(--secondary);"></i> Available Room Types</h5>

                    <!-- Room 1 -->
                    <div class="room-card mb-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400&auto=format&fit=crop&q=80" class="w-100 rounded-3" alt="Deluxe Room" style="height:120px;object-fit:cover;">
                            </div>
                            <div class="col-md-5">
                                <h6 class="fw-800 mb-1">Deluxe Sea View Room</h6>
                                <p style="font-size:12px;color:var(--gray-300);margin-bottom:6px;">King Bed · 45 sqm · Garden & Sea View</p>
                                <div class="d-flex flex-wrap gap-1">
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(39,174,96,.08);color:var(--green);border-radius:4px;font-weight:600;">Free Breakfast</span>
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(0,168,225,.08);color:var(--secondary);border-radius:4px;font-weight:600;">Free WiFi</span>
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(39,174,96,.08);color:var(--green);border-radius:4px;font-weight:600;">Free Cancel</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="price-tag-crossed">₹32,000</span>
                                <div class="price-tag">₹24,500</div>
                                <p style="font-size:11px;color:var(--gray-300);margin-bottom:8px;">per night + ₹4,410 taxes</p>
                                <a href="/checkout" class="btn btn-orange btn-sm px-4" style="font-size:12px;">Select Room</a>
                            </div>
                        </div>
                    </div>

                    <!-- Room 2 -->
                    <div class="room-card mb-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&auto=format&fit=crop&q=80" class="w-100 rounded-3" alt="Premium Suite" style="height:120px;object-fit:cover;">
                            </div>
                            <div class="col-md-5">
                                <h6 class="fw-800 mb-1">Premium Suite</h6>
                                <p style="font-size:12px;color:var(--gray-300);margin-bottom:6px;">King Bed · 72 sqm · Ocean View · Private Balcony</p>
                                <div class="d-flex flex-wrap gap-1">
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(39,174,96,.08);color:var(--green);border-radius:4px;font-weight:600;">All Meals</span>
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(0,168,225,.08);color:var(--secondary);border-radius:4px;font-weight:600;">Lounge Access</span>
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(37,99,235,.08);color:var(--primary);border-radius:4px;font-weight:600;">Spa Credits</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="price-tag-crossed">₹55,000</span>
                                <div class="price-tag">₹42,000</div>
                                <p style="font-size:11px;color:var(--gray-300);margin-bottom:8px;">per night + ₹7,560 taxes</p>
                                <a href="/checkout" class="btn btn-orange btn-sm px-4" style="font-size:12px;">Select Room</a>
                            </div>
                        </div>
                    </div>

                    <!-- Room 3 -->
                    <div class="room-card">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400&auto=format&fit=crop&q=80" class="w-100 rounded-3" alt="Villa" style="height:120px;object-fit:cover;">
                            </div>
                            <div class="col-md-5">
                                <h6 class="fw-800 mb-1">Presidential Villa with Pool</h6>
                                <p style="font-size:12px;color:var(--gray-300);margin-bottom:6px;">2 King Beds · 150 sqm · Private Pool & Garden</p>
                                <div class="d-flex flex-wrap gap-1">
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(39,174,96,.08);color:var(--green);border-radius:4px;font-weight:600;">All Inclusive</span>
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(37,99,235,.08);color:var(--primary);border-radius:4px;font-weight:600;">Butler Service</span>
                                    <span style="font-size:10px;padding:2px 8px;background:rgba(0,168,225,.08);color:var(--secondary);border-radius:4px;font-weight:600;">Airport Pickup</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="price-tag-crossed">₹95,000</span>
                                <div class="price-tag">₹78,000</div>
                                <p style="font-size:11px;color:var(--gray-300);margin-bottom:8px;">per night + ₹14,040 taxes</p>
                                <a href="/checkout" class="btn btn-orange btn-sm px-4" style="font-size:12px;">Select Room</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-info-circle me-2" style="color:var(--secondary);"></i> About This Hotel</h5>
                    <p style="font-size:14px;color:var(--gray-400);line-height:1.8;">
                        Nestled amidst 56 acres of landscaped gardens along the pristine shores of Benaulim Beach in South Goa, Taj Exotica Resort & Spa is a luxury beach resort that epitomizes Goan grandeur. The Mediterranean-Portuguese architecture, lush tropical gardens, and the azure Arabian Sea create an idyllic setting for a luxurious tropical getaway.
                    </p>
                    <p style="font-size:14px;color:var(--gray-400);line-height:1.8;">
                        The resort offers world-class dining experiences, an award-winning Jiva Spa, a championship golf course nearby, and a host of curated experiences that celebrate the rich Goan culture and heritage.
                    </p>
                </div>

                <!-- Reviews -->
                <div class="booking-detail-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fas fa-star me-2" style="color:var(--primary);"></i> Guest Reviews</h5>
                        <a href="#" class="view-all-link" style="font-size:13px;">All 480 Reviews <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <!-- Rating overview -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 text-center">
                            <div style="width:70px;height:70px;border-radius:16px;background:var(--green);color:#fff;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:900;margin:0 auto 8px;">4.9</div>
                            <div class="fw-700" style="font-size:13px;">Excellent</div>
                            <div style="font-size:11px;color:var(--gray-300);">480 reviews</div>
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span style="font-size:12px;font-weight:600;width:100px;">Cleanliness</span>
                                <div class="progress flex-grow-1" style="height:6px;border-radius:3px;"><div class="progress-bar" style="width:96%;background:var(--green);border-radius:3px;"></div></div>
                                <span style="font-size:12px;font-weight:700;">4.8</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span style="font-size:12px;font-weight:600;width:100px;">Service</span>
                                <div class="progress flex-grow-1" style="height:6px;border-radius:3px;"><div class="progress-bar" style="width:98%;background:var(--green);border-radius:3px;"></div></div>
                                <span style="font-size:12px;font-weight:700;">4.9</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span style="font-size:12px;font-weight:600;width:100px;">Location</span>
                                <div class="progress flex-grow-1" style="height:6px;border-radius:3px;"><div class="progress-bar" style="width:94%;background:var(--green);border-radius:3px;"></div></div>
                                <span style="font-size:12px;font-weight:700;">4.7</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span style="font-size:12px;font-weight:600;width:100px;">Value</span>
                                <div class="progress flex-grow-1" style="height:6px;border-radius:3px;"><div class="progress-bar" style="width:90%;background:var(--blue);border-radius:3px;"></div></div>
                                <span style="font-size:12px;font-weight:700;">4.5</span>
                            </div>
                        </div>
                    </div>

                    <!-- Individual reviews -->
                    <div class="review-card mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Rohit+Verma&background=0b3d61&color=fff&size=40" class="rounded-circle" width="36" alt="">
                                <div>
                                    <div class="fw-700" style="font-size:13px;">Rohit Verma</div>
                                    <div style="font-size:11px;color:var(--gray-300);">Stayed in Nov 2025 · Couple</div>
                                </div>
                            </div>
                            <span class="rating-pill" style="height:fit-content;"><i class="fas fa-star" style="font-size:9px"></i> 5.0</span>
                        </div>
                        <p style="font-size:13px;color:var(--gray-400);margin-bottom:0;">"An unforgettable experience! The room was immaculate, the beach was pristine, and the staff went above and beyond. The Jiva Spa treatment was the highlight of our trip."</p>
                    </div>
                    <div class="review-card">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Ananya+Das&background=2563eb&color=fff&size=40" class="rounded-circle" width="36" alt="">
                                <div>
                                    <div class="fw-700" style="font-size:13px;">Ananya Das</div>
                                    <div style="font-size:11px;color:var(--gray-300);">Stayed in Oct 2025 · Family</div>
                                </div>
                            </div>
                            <span class="rating-pill" style="height:fit-content;"><i class="fas fa-star" style="font-size:9px"></i> 4.8</span>
                        </div>
                        <p style="font-size:13px;color:var(--gray-400);margin-bottom:0;">"Perfect family getaway. Kids absolutely loved the pool and the kids club. The breakfast buffet had amazing variety. Location is quiet and peaceful compared to North Goa."</p>
                    </div>
                </div>

                <!-- Policies -->
                <div class="booking-detail-card">
                    <h5><i class="fas fa-clipboard-list me-2" style="color:var(--secondary);"></i> Hotel Policies</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-clock" style="color:var(--secondary);font-size:14px;"></i>
                                <span class="fw-700" style="font-size:13px;">Check-in</span>
                            </div>
                            <p style="font-size:13px;color:var(--gray-400);margin-bottom:0;">From 2:00 PM</p>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-clock" style="color:var(--primary);font-size:14px;"></i>
                                <span class="fw-700" style="font-size:13px;">Check-out</span>
                            </div>
                            <p style="font-size:13px;color:var(--gray-400);margin-bottom:0;">Until 11:00 AM</p>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-ban" style="color:var(--red);font-size:14px;"></i>
                                <span class="fw-700" style="font-size:13px;">Cancellation</span>
                            </div>
                            <p style="font-size:13px;color:var(--gray-400);margin-bottom:0;">Free until 48h before</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="booking-detail-card sticky-top" style="top:80px;">
                    <div class="text-center mb-3">
                        <span class="price-tag-crossed" style="font-size:16px;">₹32,000</span>
                        <div class="price-tag" style="font-size:30px;">₹24,500</div>
                        <p style="font-size:12px;color:var(--gray-300);margin-bottom:0;">per night + taxes</p>
                        <span class="discount-badge TS-2 d-inline-block">Save ₹7,500 (24% OFF)</span>
                    </div>

                    <hr style="border-color:var(--gray-50);">

                    <div class="mb-3">
                        <label style="font-size:11px;font-weight:700;color:var(--gray-300);text-transform:uppercase;letter-spacing:.5px;" class="mb-1">Check-in</label>
                        <input type="date" class="form-control form-control-lg" value="2025-11-12">
                    </div>
                    <div class="mb-3">
                        <label style="font-size:11px;font-weight:700;color:var(--gray-300);text-transform:uppercase;letter-spacing:.5px;" class="mb-1">Check-out</label>
                        <input type="date" class="form-control form-control-lg" value="2025-11-15">
                    </div>
                    <div class="mb-4">
                        <label style="font-size:11px;font-weight:700;color:var(--gray-300);text-transform:uppercase;letter-spacing:.5px;" class="mb-1">Rooms & Guests</label>
                        <select class="form-select form-control-lg">
                            <option>1 Room, 2 Adults</option>
                            <option>1 Room, 3 Adults</option>
                            <option>2 Rooms, 4 Adults</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                        <span style="color:var(--gray-400);">Room (3 Nights)</span>
                        <span class="fw-700">₹73,500</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                        <span style="color:var(--gray-400);">Taxes & Fees</span>
                        <span class="fw-700">₹13,230</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3" style="font-size:13px;">
                        <span style="color:var(--green);">Trip Zant Discount</span>
                        <span class="fw-700" style="color:var(--green);">- ₹5,000</span>
                    </div>
                    <hr style="border-color:var(--gray-50);">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-800 mb-0">Total</h5>
                        <h4 class="fw-900 mb-0" style="color:var(--navy);">₹81,730</h4>
                    </div>

                    <a href="/checkout" class="btn btn-primary-custom w-100 py-3 mb-2" style="font-size:15px;"><i class="fas fa-lock me-2"></i> Book Now</a>
                    <p class="text-center" style="font-size:11px;color:var(--gray-300);">No payment charged now · Free cancellation</p>
                </div>

                <!-- Similar Hotels -->
                <div class="booking-detail-card TS-3">
                    <h6 class="fw-800" style="font-size:14px;">Similar Hotels Nearby</h6>
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--gray-50);">
                        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=200&auto=format&fit=crop&q=80" class="rounded-3" style="width:60px;height:50px;object-fit:cover;" alt="">
                        <div class="flex-grow-1">
                            <div class="fw-700" style="font-size:13px;">Novotel Goa Resort</div>
                            <div style="font-size:11px;color:var(--gray-300);">Candolim · <span class="fw-700" style="color:var(--navy);">₹12,200</span>/night</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=200&auto=format&fit=crop&q=80" class="rounded-3" style="width:60px;height:50px;object-fit:cover;" alt="">
                        <div class="flex-grow-1">
                            <div class="fw-700" style="font-size:13px;">ITC Grand Goa</div>
                            <div style="font-size:11px;color:var(--gray-300);">Arossim · <span class="fw-700" style="color:var(--navy);">₹18,800</span>/night</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

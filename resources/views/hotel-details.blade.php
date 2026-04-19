@extends('layouts.app')

@section('title', "Taj Exotica Resort & Spa — Tripzant BNB")

@section('content')
<div class="py-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="container">
        <!-- Breadcrumb & Title -->
        <nav aria-label="breadcrumb" class="mb-3 animate-up">
            <ol class="breadcrumb mb-1" style="font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="/hotels" class="text-decoration-none text-muted">Hotels in Goa</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Taj Exotica Resort</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 animate-up" style="animation-delay:0.1s;">
            <div>
                <h1 class="fw-900 text-navy mb-1" style="font-size:32px; letter-spacing:-1px;">Taj Exotica Resort & Spa <span class="ms-2" style="font-size:16px; color:#f1c40f;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></h1>
                <p class="text-muted fw-600 mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i>Calvaddo, Benaulim, Salcete, Goa, 403716 India</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-lg-0">
                <button class="btn btn-outline-navy rounded-pill px-4 fw-bold shadow-sm py-2"><i class="fas fa-share-alt me-2"></i>SHARE</button>
                <button class="btn btn-outline-navy rounded-pill px-4 fw-bold shadow-sm py-2"><i class="far fa-heart me-2"></i>SAVE</button>
            </div>
        </div>

        <!-- Image Gallery Grid -->
        <div class="row g-2 mb-5 overflow-hidden rounded-4 shadow-sm animate-up" style="height: 450px; animation-delay:0.2s;">
            <div class="col-md-8 h-100">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop&q=80" class="h-100 w-100 image-zoom" style="object-fit: cover;">
            </div>
            <div class="col-md-4 h-100">
                <div class="row g-2 h-100">
                    <div class="col-12 h-50">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&auto=format&fit=crop&q=80" class="h-100 w-100 image-zoom" style="object-fit: cover;">
                    </div>
                    <div class="col-12 h-50 position-relative">
                        <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=500&auto=format&fit=crop&q=80" class="h-100 w-100 image-zoom" style="object-fit: cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white fw-bold cursor-pointer transition-03" style="font-size:18px;">+24 PHOTOS</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- Left Side: Details & Rooms -->
            <div class="col-lg-8 animate-up" style="animation-delay:0.3s;">
                <!-- About Description -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-900 text-navy mb-3">About the Property</h5>
                    <p class="text-muted leading-relaxed mb-4">
                        Spread across 56 acres of lush gardens, Taj Exotica Resort & Spa, Goa is the epitome of luxurious beachfront hospitality. This Mediterranean-style resort offers 140 spacious rooms and suites, each with a private balcony or veranda. Enjoy a private stretch of the pristine Benaulim Beach or indulge in world-class wellness at Jiva Spa.
                    </p>
                    <div class="row g-4">
                        <div class="col-md-3 col-6 text-center">
                            <div class="p-3 bg-light rounded-4 mb-2"><i class="fas fa-swimmer fs-4 text-primary"></i></div>
                            <span class="x-small fw-800 text-navy">OUTDOOR POOL</span>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <div class="p-3 bg-light rounded-4 mb-2"><i class="fas fa-spa fs-4 text-primary"></i></div>
                            <span class="x-small fw-800 text-navy">JIVA SPA</span>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <div class="p-3 bg-light rounded-4 mb-2"><i class="fas fa-utensils fs-4 text-primary"></i></div>
                            <span class="x-small fw-800 text-navy">6 RESTAURANTS</span>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <div class="p-3 bg-light rounded-4 mb-2"><i class="fas fa-child fs-4 text-primary"></i></div>
                            <span class="x-small fw-800 text-navy">KIDS ZONE</span>
                        </div>
                    </div>
                </div>

                <!-- Room Selection List -->
                <h4 class="fw-900 text-navy mb-4 mt-5 d-flex align-items-center gap-3">Available Room Types <span class="badge bg-green-light text-success rounded-pill x-small px-3">BEST RATES GUARANTEED</span></h4>
                
                @php
                $rooms = [
                    ['name' => 'Garden Villa Room', 'size' => '612 sq ft', 'bed' => '1 Double Bed', 'price' => '28,500', 'tag' => 'MOST POPULAR'],
                    ['name' => 'Luxury Sea View Room', 'size' => '735 sq ft', 'bed' => '1 King Bed', 'price' => '36,200', 'tag' => 'BEST VIEW'],
                    ['name' => 'Executive Suite', 'size' => '1250 sq ft', 'bed' => '1 King Bed + Living Area', 'price' => '52,400', 'tag' => 'ULTRA LUXURY'],
                ];
                @endphp

                @foreach($rooms as $room)
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 room-card transition-03">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400&auto=format&fit=crop&q=80" class="h-100 w-100" style="object-fit:cover;">
                        </div>
                        <div class="col-md-8 p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-900 text-navy mb-1">{{ $room['name'] }}</h5>
                                    <div class="d-flex gap-3 text-muted x-small fw-700">
                                        <span><i class="fas fa-expand me-1"></i> {{ $room['size'] }}</span>
                                        <span><i class="fas fa-bed me-1"></i> {{ $room['bed'] }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-navy text-white x-small fw-900 px-3 py-2 rounded-pill">{{ $room['tag'] }}</span>
                            </div>
                            <hr class="my-3 opacity-10">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <h6 class="small text-navy fw-900 mb-2">INCLUSIONS:</h6>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="x-small text-success fw-800"><i class="fas fa-check-circle me-1"></i> FREE Buffet Breakfast & Dinner</div>
                                        <div class="x-small text-success fw-800"><i class="fas fa-check-circle me-1"></i> FREE Cancellation until 24 hrs before</div>
                                        <div class="x-small text-primary fw-800"><i class="fas fa-bolt me-1"></i> Instant Confirmation</div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-end border-start">
                                    <div class="text-muted text-decoration-line-through x-small fw-bold">₹{{ number_format(intval(str_replace(',','',$room['price'])) * 1.3) }}</div>
                                    <div class="fw-900 text-navy mb-0" style="font-size:24px;">₹{{ $room['price'] }}</div>
                                    <div class="x-small text-muted fw-bold mb-3">+ ₹4,250 Taxes & Fees</div>
                                    <a href="{{ route('hotel.checkout') }}" class="btn btn-navy rounded-pill w-100 fw-bold shadow-sm">SELECT ROOM <i class="fas fa-chevron-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Right Side: Booking Summary Sticker -->
            <div class="col-lg-4 animate-up" style="animation-delay:0.4s;">
                <div class="sticky-top" style="top:90px;">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-navy text-white p-4">
                            <h5 class="fw-900 mb-0">Booking Summary</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="p-3 bg-light rounded-4 text-navy"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <h6 class="x-small text-muted fw-bold text-uppercase mb-0">Stay Dates</h6>
                                    <span class="small fw-800 text-navy">12 Nov – 15 Nov (3 Nights)</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="p-3 bg-light rounded-4 text-navy"><i class="fas fa-user-friends"></i></div>
                                <div>
                                    <h6 class="x-small text-muted fw-bold text-uppercase mb-0">Stay Configuration</h6>
                                    <span class="small fw-800 text-navy">1 Room · 2 Adults</span>
                                </div>
                            </div>
                            <hr class="my-4 opacity-10">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-muted">Room Subtotal</span>
                                <span class="small fw-800 text-navy">₹85,500</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-muted">Estimated Taxes</span>
                                <span class="small fw-800 text-navy">₹8,450</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-900 text-navy h5 mb-0">Total Pay</span>
                                <span class="fw-900 text-primary h4 mb-0">₹93,950</span>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 p-3 text-center">
                            <p class="x-small text-muted mb-0 fw-bold"><i class="fas fa-shield-halved me-1 text-success"></i> Price Protected by Tripzant B2B Secure</p>
                        </div>
                    </div>

                    <!-- Trust Bar -->
                    <div class="p-4 rounded-4 bg-white shadow-sm border border-light d-flex align-items-center gap-3">
                        <div class="text-orange"><i class="fas fa-bolt fs-3"></i></div>
                        <div>
                            <h6 class="fw-900 text-navy mb-0">Instant BNB Flow</h6>
                            <p class="x-small text-muted mb-0 fw-bold">Skip the wait, book instantly using wallet</p>
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
.bg-orange-light { background: rgba(235, 141, 47, 0.1); }
.text-orange { color: #f97316; }
.bg-green-light { background: rgba(39, 174, 96, 0.1); }
.leading-relaxed { line-height: 1.8; }
.x-small { font-size: 11px; }

.image-zoom { transition: transform 0.5s; cursor: pointer; }
.image-zoom:hover { transform: scale(1.05); }

.room-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
.transition-03 { transition: all 0.3s; }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

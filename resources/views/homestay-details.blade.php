@extends('layouts.app')

@section('title', $homestay->title . " — Trip Zant Details")

@section('content')
<div class="py-5 bg-light">
    <div class="container">
        <!-- Hero Gallery -->
        <div class="row g-3 mb-5">
            <div class="col-md-8">
                <img src="{{ $homestay->image_url }}" class="w-100 rounded-4 shadow-sm" style="height: 500px; object-fit: cover;">
            </div>
            <div class="col-md-4">
                <div class="d-flex flex-column gap-3 h-100">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500" class="w-100 rounded-4 shadow-sm flex-grow-1" style="object-fit: cover;">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500" class="w-100 rounded-4 shadow-sm flex-grow-1" style="object-fit: cover;">
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <span class="badge bg-primary-light text-primary px-3 py-2 rounded-pill mb-2 fw-bold text-uppercase">{{ $homestay->property_type }} · {{ $homestay->city }}</span>
                        <h1 class="fw-900 text-navy mb-1">{{ $homestay->title }}</h1>
                        <p class="text-muted fw-bold"><i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $homestay->subtitle }}</p>
                    </div>
                    <div class="text-end">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-success px-2 py-1"><i class="fas fa-star me-1"></i> {{ $homestay->rating }}</span>
                            <span class="small fw-bold text-navy">Exceptional</span>
                        </div>
                        <p class="small text-muted mb-0">{{ $homestay->reviews_count }} reviews</p>
                    </div>
                </div>

                <div class="row g-4 mb-5 border-top border-bottom py-4">
                    <div class="col-3 text-center border-end">
                        <div class="text-primary mb-1"><i class="fas fa-bed fs-4"></i></div>
                        <div class="small fw-800 text-navy">2 Bedrooms</div>
                    </div>
                    <div class="col-3 text-center border-end">
                        <div class="text-primary mb-1"><i class="fas fa-bath fs-4"></i></div>
                        <div class="small fw-800 text-navy">2 Bathrooms</div>
                    </div>
                    <div class="col-3 text-center border-end">
                        <div class="text-primary mb-1"><i class="fas fa-users fs-4"></i></div>
                        <div class="small fw-800 text-navy">Up to 4 Guests</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-primary mb-1"><i class="fas fa-wifi fs-4"></i></div>
                        <div class="small fw-800 text-navy">Free High-Speed WiFi</div>
                    </div>
                </div>

                <h4 class="fw-900 text-navy mb-4">About this property</h4>
                <p class="text-muted leading-relaxed mb-5">
                    {{ $homestay->description ?: "Experience luxury and comfort in the heart of {$homestay->city}. This property offers stunning views and modern amenities to make your stay unforgettable. Perfect for families or couples looking for a serene getaway." }}
                </p>

                <h4 class="fw-900 text-navy mb-4">What this place offers</h4>
                <div class="row g-3 mb-5">
                    <div class="col-md-6"><i class="fas fa-check-circle text-success me-2"></i> Fully Equipped Kitchen</div>
                    <div class="col-md-6"><i class="fas fa-check-circle text-success me-2"></i> Free Parking on Premises</div>
                    <div class="col-md-6"><i class="fas fa-check-circle text-success me-2"></i> Private Balcony with View</div>
                    <div class="col-md-6"><i class="fas fa-check-circle text-success me-2"></i> Dedicated Workspace</div>
                    <div class="col-md-6"><i class="fas fa-check-circle text-success me-2"></i> Smart TV with Netflix</div>
                    <div class="col-md-6"><i class="fas fa-check-circle text-success me-2"></i> Power Backup / Generator</div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="card border-0 shadow-lg rounded-4 p-4 overflow-hidden">
                        <div class="bg-navy p-3 mb-4 rounded-3 text-white text-center">
                            <span class="small opacity-75 d-block">Starting from</span>
                            <h3 class="fw-900 mb-0">₹{{ number_format($homestay->price_per_night) }} <span class="fs-6 opacity-75">/ night</span></h3>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">Check-in / Check-out</label>
                            <input type="text" class="form-control rounded-3 py-2 fw-bold" value="Jan 15 - Jan 20, 2026" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">Guests</label>
                            <select class="form-select rounded-3 py-2 fw-bold">
                                <option>2 Adults, 0 Children</option>
                                <option>4 Adults, 2 Children</option>
                            </select>
                        </div>

                        <ul class="list-unstyled mb-4 p-0">
                            <li class="d-flex justify-content-between mb-2 small fw-bold text-muted">
                                <span>₹{{ number_format($homestay->price_per_night) }} x 5 nights</span>
                                <span>₹{{ number_format($homestay->price_per_night * 5) }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2 small fw-bold text-muted">
                                <span>Service Fee</span>
                                <span>₹850</span>
                            </li>
                            <li class="d-flex justify-content-between pt-3 border-top mt-3 text-navy fw-900 fs-5">
                                <span>Total</span>
                                <span>₹{{ number_format($homestay->price_per_night * 5 + 850) }}</span>
                            </li>
                        </ul>

                        <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 shadow-lg" onclick="bookNow()">RESERVE NOW <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>

                    <div class="mt-4 p-3 bg-white border rounded-4 d-flex align-items-center gap-3">
                        <div class="p-3 bg-light rounded-circle text-primary"><i class="fas fa-shield-heart fs-4"></i></div>
                        <div>
                            <h6 class="fw-900 mb-0">Trip Zant Guarantee</h6>
                            <p class="small text-muted mb-0">Full refund if you cancel up to 48 hours before stay.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function bookNow() {
        Swal.fire({
            title: 'Confirm Booking?',
            text: "Redirecting you to checkout...",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#0b3d61',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                // For now, redirect to main checkout with type
                window.location.href = "{{ route('checkout', ['type' => 'homestay', 'id' => $homestay->id]) }}";
            }
        })
    }
</script>
@endsection

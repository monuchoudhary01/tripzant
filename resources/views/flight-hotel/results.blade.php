@extends('layouts.app')

@section('title', 'Bundled Deals for ' . $to)

@section('content')
<section class="py-4 bg-navy text-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-900 mb-1">{{ $from }} <i class="fas fa-arrow-right mx-2 small text-white-50"></i> {{ $to }}</h4>
                <p class="mb-0 small text-white-50"><i class="fas fa-calendar me-2"></i> {{ date('D, d M Y', strtotime($date)) }} · 2 Travelers</p>
            </div>
            <a href="{{ route('flight-hotel.index') }}" class="btn btn-outline-light rounded-pill px-4 btn-sm fw-bold">Modify Search</a>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Filters -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-900 mb-3">Sort By</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sort" id="s1" checked>
                        <label class="form-check-label small fw-bold" for="s1">Highest Savings</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sort" id="s2">
                        <label class="form-check-label small fw-bold" for="s2">Lowest Price</label>
                    </div>
                    
                    <hr class="my-4 opacity-10">
                    
                    <h6 class="fw-900 mb-3">Hotel Rating</h6>
                    @foreach([5,4,3] as $star)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label small fw-bold">{{ $star }} Star & Above</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Results -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-900 text-navy mb-0">{{ count($bundles) }} Bundle Deals Found</h5>
                    <div class="badge bg-success py-2 px-3 rounded-pill fw-bold"><i class="fas fa-percent me-2"></i> SAVING UP TO 35% TODAY</div>
                </div>

                @foreach($bundles as $b)
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 hvr-grow-subtle">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $b['image'] }}" class="w-100 h-100" style="object-fit: cover; min-height: 250px;">
                        </div>
                        <div class="col-md-8 p-4 bg-white">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-primary-light text-primary mb-2 px-3 py-2 rounded-pill fw-bold x-small">{{ strtoupper($b['location']) }}</span>
                                    <h5 class="fw-900 text-navy">{{ $b['title'] }}</h5>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success rounded-pill px-3 py-2 fw-bold x-small">SAVE ₹{{ number_format($b['original_price'] - $b['price']) }}</span>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="p-2 rounded-circle bg-light"><i class="fas fa-plane text-muted"></i></div>
                                        <div>
                                            <div class="small fw-800">{{ $b['airline'] }}</div>
                                            <div class="x-small text-muted">{{ $b['flight_type'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="p-2 rounded-circle bg-light"><i class="fas fa-hotel text-muted"></i></div>
                                        <div>
                                            <div class="small fw-800">{{ $b['hotel_name'] }}</div>
                                            <div class="x-small text-muted">{{ $b['duration'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                @foreach($b['features'] as $f)
                                <span class="badge border text-muted py-1 px-3 rounded-pill x-small fw-bold"><i class="fas fa-check text-success me-1"></i> {{ $f }}</span>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                <div>
                                    <span class="text-muted small text-decoration-line-through">₹{{ number_format($b['original_price']) }}</span>
                                    <div class="fw-900 fs-3 text-navy">₹{{ number_format($b['price']) }}</div>
                                    <div class="x-small text-muted fw-bold">Per Person (Incl. Taxes)</div>
                                </div>
                                <button onclick="bookBundle('{{ $b['title'] }}', '{{ $b['price'] }}')" class="btn btn-navy px-5 py-3 rounded-pill fw-900 shadow">Book Bundle <i class="fas fa-chevron-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    function bookBundle(title, price) {
        Swal.fire({
            title: 'Initialize Booking?',
            html: `You are booking <b>${title}</b> for <b>₹${price}</b>.<br><br>Preparing secure checkout...`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Proceed to Payment',
            confirmButtonColor: '#002f55',
            cancelButtonText: 'Review Deal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Bundle Reserved!',
                    text: 'Redirecting to secure gateway...',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }
</script>

<style>
    .bg-primary-light { background: rgba(0, 118, 247, 0.1); }
    .x-small { font-size: 11px; }
    .hvr-grow-subtle { transition: transform 0.2s; }
    .hvr-grow-subtle:hover { transform: translateY(-5px); }
</style>
@endsection

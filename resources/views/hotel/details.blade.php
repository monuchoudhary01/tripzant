@extends(auth()->check() && (auth()->user()->role == 'hotel_partner' || auth()->user()->role == 'b2b_agent' || auth()->user()->role == 'iata_agent' || auth()->user()->role == 'amadeus_partner') ? 'layouts.hotel_master' : 'layouts.app')

@section('title', ($hotelContent['name'] ?? 'Hotel Details') . ' — Tripzant')

@section('styles')
<style>
    .h-detail-bg { background: #f8fafc; min-height: 100vh; }
    .gallery-main { height: 500px; border-radius: 24px; overflow: hidden; }
    .gallery-side { height: 245px; border-radius: 24px; overflow: hidden; }
    .h-badge-gold { background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%); color: #fff; padding: 4px 12px; border-radius: 99px; font-size: 10px; font-weight: 800; }
    .h-feature-icon { width: 48px; height: 48px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 18px; margin-bottom: 12px; }
    .room-card { background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.3s ease; }
    .room-card:hover { border-color: #2563eb; box-shadow: 0 10px 30px rgba(37,99,235,0.05); }
    .sticky-summary { top: 100px; }
    .divider-dashed { border-top: 1px dashed #e2e8f0; margin: 20px 0; }
    .p-stat { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endsection

@section('content')
<div class="h-detail-bg py-4 pt-5">
    <div class="container">
        <!-- Header Section -->
        <div class="d-flex flex-wrap justify-content-between align-items-start mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2" style="font-size: 11px; font-weight: 800; text-transform: uppercase;">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}" class="text-decoration-none text-muted">Hotels</a></li>
                        <li class="breadcrumb-item active text-primary">{{ $hotelContent['name'] ?? 'Property' }}</li>
                    </ol>
                </nav>
                <h1 class="outfit fw-900 text-navy mb-1" style="font-size: 36px;">{{ $hotelContent['name'] ?? 'Property' }}</h1>
                <p class="text-muted fw-600 mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $hotelContent['address']['content'] ?? ($hotelContent['destinationCode'] ?? 'City Center') }}, {{ $hotelContent['postalCode'] ?? '' }}</p>
            </div>
            <div class="text-end">
                <div class="h-badge-gold mb-2">MOST POPULAR IN DUBAI</div>
                <div class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            </div>
        </div>

        <!-- Visual Gallery -->
        <div class="row g-2 mb-5">
            <div class="col-lg-8">
                <div class="gallery-main shadow-sm" style="background:#e2e8f0;">
                    @php $mainImg = $hotelContent['main_image'] ?? 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2070&auto=format&fit=crop'; @endphp
                    <img src="{{ $mainImg }}" onerror="this.src='https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2070&auto=format&fit=crop';" class="w-100 h-100 object-fit-cover" alt="Main Image">
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                @php 
                    $sideImg1 = isset($hotelContent['images'][1]['path']) ? "http://photos.hotelbeds.com/giata/" . $hotelContent['images'][1]['path'] : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';
                    $sideImg2 = isset($hotelContent['images'][2]['path']) ? "http://photos.hotelbeds.com/giata/" . $hotelContent['images'][2]['path'] : 'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=2070&auto=format&fit=crop';
                @endphp
                <div class="gallery-side mb-2 shadow-sm" style="background:#e2e8f0;">
                    <img src="{{ $sideImg1 }}" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';" class="w-100 h-100 object-fit-cover" alt="Gallery 1">
                </div>
                <div class="gallery-side shadow-sm" style="background:#e2e8f0;">
                    <img src="{{ $sideImg2 }}" onerror="this.src='https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=2070&auto=format&fit=crop';" class="w-100 h-100 object-fit-cover" alt="Gallery 2">
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Highlights -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
                    <h5 class="fw-900 text-navy mb-4">Facilities & Highlights</h5>
                    <div class="row g-4">
                        @if(isset($hotelContent['facilities']) && is_array($hotelContent['facilities']))
                            @php 
                                $fMap = [
                                    30 => ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
                                    50 => ['icon' => 'fa-parking', 'name' => 'Parking'],
                                    70 => ['icon' => 'fa-swimming-pool', 'name' => 'Swimming Pool'],
                                    90 => ['icon' => 'fa-utensils', 'name' => 'Restaurant'],
                                    100 => ['icon' => 'fa-glass-martini-alt', 'name' => 'Bar'],
                                    260 => ['icon' => 'fa-concierge-bell', 'name' => '24h Front Desk'],
                                    40 => ['icon' => 'fa-dumbbell', 'name' => 'Gym/Fitness'],
                                    220 => ['icon' => 'fa-spa', 'name' => 'Spa & Wellness']
                                ];
                                $renderedFacs = 0;
                            @endphp
                            @foreach($hotelContent['facilities'] as $fac)
                                @php 
                                    $fKey = is_array($fac) ? ($fac['facilityCode'] ?? null) : $fac;
                                    if (!is_numeric($fKey)) { $fKey = strtoupper($fKey); }
                                    
                                    $mapContent = null;
                                    if (isset($fMap[$fKey])) {
                                        $mapContent = $fMap[$fKey];
                                    } elseif ($fKey == 'WIFI' || $fKey == 'FREE_WIFI') {
                                        $mapContent = $fMap[30];
                                    } elseif ($fKey == 'POOL' || $fKey == 'SWIMMING_POOL') {
                                        $mapContent = $fMap[70];
                                    } elseif ($fKey == 'PARKING') {
                                        $mapContent = $fMap[50];
                                    }
                                @endphp

                                @if($mapContent && $renderedFacs < 8)
                                    <div class="col-md-3 col-6 text-center">
                                        <div class="h-feature-icon mx-auto"><i class="fas {{ $mapContent['icon'] }}"></i></div>
                                        <span class="small fw-800 text-navy">{{ $mapContent['name'] }}</span>
                                    </div>
                                    @php $renderedFacs++; @endphp
                                @endif
                            @endforeach
                            @if($renderedFacs == 0)
                                <div class="col-12"><p class="text-muted small">Standard hotel facilities available.</p></div>
                            @endif
                        @else
                            @foreach(['Excellent Fitness Center', 'Prime Location', 'High Cleansiness', 'Luxury Spa'] as $f)
                            <div class="col-md-3 text-center">
                                <div class="h-feature-icon mx-auto"><i class="fas fa-check"></i></div>
                                <span class="small fw-800 text-navy">{{ $f }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="divider-dashed"></div>
                    @php
                        $desc = 'Located in the heart of the city, this world-class property offers unparalleled luxury and service. With premium rooms, fine dining options, and a state-of-the-art spa, it is the perfect choice for both business and leisure travelers.';
                        if (isset($hotelContent['description']['content'])) {
                            $desc = $hotelContent['description']['content'];
                        }
                    @endphp
                    <p class="text-muted small fw-600 mb-0" style="line-height: 1.8;">
                        {{ $desc }}
                    </p>
                </div>

                <!-- Room Categories -->
                <h3 class="outfit fw-900 text-navy mb-4">Choose Your Room</h3>
                
                @if(isset($hotelAvail['rooms']))
                    @foreach($hotelAvail['rooms'] as $room)
                    @php
                        $rImg = 'https://images.unsplash.com/photo-1505691938895-1758d7eaa511?q=80&w=400&auto=format&fit=crop';
                        if(isset($hotelContent['images'])) {
                            foreach($hotelContent['images'] as $img) {
                                if(isset($img['roomCode']) && strpos($room['code'], $img['roomCode']) !== false) {
                                    $rImg = "http://photos.hotelbeds.com/giata/" . $img['path'];
                                    break;
                                }
                            }
                        }
                    @endphp
                    <div class="room-card mb-4">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ $rImg }}" onerror="this.src='https://images.unsplash.com/photo-1505691938895-1758d7eaa511?q=80&w=400&auto=format&fit=crop';" class="h-100 w-100 object-fit-cover" alt="Room">
                            </div>
                            <div class="col-md-8 p-4">
                                <h5 class="fw-900 text-navy mb-1">{{ $room['name'] }}</h5>
                                <div class="d-flex gap-2 mb-4">
                                    <span class="h-tag small fw-700 text-muted border px-2 rounded"><i class="fas fa-user-friends me-1"></i> {{ $params['adults'] ?? 2 }} Adults</span>
                                    <span class="h-tag small fw-700 text-muted border px-2 rounded"><i class="fas fa-bed me-1"></i> {{ $room['name'] }}</span>
                                </div>
                                
                                @foreach($room['rates'] as $rate)
                                <div class="p-3 bg-light rounded-4 mb-3 border">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <div class="badge bg-primary text-white tiny px-2 py-1 mb-2">{{ $rate['boardName'] ?? 'Room Only' }}</div>
                                            <div class="text-success small fw-700"><i class="fas fa-shield-check me-1"></i> Free Cancellation</div>
                                            <div class="text-muted tiny fw-600 mt-1">Full refund if cancelled before tomorrow</div>
                                        </div>
                                        <div class="col-md-5 text-end border-start">
                                            <div class="text-muted tiny fw-700 uppercase mb-1">Stay Total</div>
                                            <div class="h3 fw-900 text-navy outfit mb-1">₹{{ number_format($rate['sellingRate'] ?? 0, 0) }}</div>
                                            <form action="{{ route('hotel.checkout') }}" method="GET">
                                                <input type="hidden" name="rate_key" value="{{ $rate['rateKey'] }}">
                                                <input type="hidden" name="adults" value="{{ $params['adults'] ?? 2 }}">
                                                <input type="hidden" name="checkIn" value="{{ $params['checkIn'] }}">
                                                <input type="hidden" name="checkOut" value="{{ $params['checkOut'] }}">
                                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-800">BOOK ROOM</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-warning rounded-4 border-0 p-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> No rooms available for these dates. Try another search.
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="sticky-top sticky-summary">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                        <div class="bg-navy p-4 text-white">
                            <h5 class="outfit fw-900 mb-0">Booking Details</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <div class="p-stat mb-1">Stay Dates</div>
                                <div class="fw-800 text-navy d-flex align-items-center gap-2">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                    {{ date('D, d M', strtotime($params['checkIn'])) }} – {{ date('D, d M', strtotime($params['checkOut'])) }}
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="p-stat mb-1">Occupancy</div>
                                <div class="fw-800 text-navy d-flex align-items-center gap-2">
                                    <i class="fas fa-user-friends text-primary"></i>
                                    {{ $params['adults'] ?? 2 }} Adults • 1 Room
                                </div>
                            </div>
                            <div class="divider-dashed"></div>
                            <div class="alert alert-info border-0 rounded-3 small fw-700 mb-0">
                                <i class="fas fa-lock me-2"></i> Secure booking with instant confirmation.
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                        <p class="small text-muted fw-700 mb-3">Need help with your booking?</p>
                        <a href="#" class="btn btn-outline-primary w-100 rounded-pill fw-800"><i class="fas fa-comment-dots me-2"></i> 24/7 SUPPORT</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

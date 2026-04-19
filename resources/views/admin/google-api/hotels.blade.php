@extends('layouts.admin')

@section('title', 'Global Hotel Comparison | Google API')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-5 mr-3">
    <div>
        <h2 class="fw-900 text-navy mb-1"><i class="fas fa-hotel text-orange me-3"></i> Global Hotel Price Comparison</h2>
        <p class="text-muted small mb-0 font-weight-bold">Tracking lowest nightly rates across Google Hotels, B2C, and B2B Networks.</p>
    </div>
    <div class="d-flex gap-2">
        <div class="input-group" style="width: 350px;">
            <span class="input-group-text bg-white border-end-0 border-0 shadow-sm rounded-start-pill ps-4"><i class="fas fa-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0 border-0 shadow-sm rounded-end-pill py-2 fw-bold" placeholder="Search City or Hotel..." style="font-size: 13px;">
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card-admin mb-5 border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
    <div class="bg-orange p-4 d-flex align-items-center justify-content-between text-white">
        <h6 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i> Hotel Comparison Filters</h6>
        <button class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 small border-0 fw-800" style="background: rgba(255,255,255,0.2);"><i class="fas fa-undo me-2"></i> Reset</button>
    </div>
    <div class="p-4 bg-white border-bottom border-light">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">CHECK-IN / OUT</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-days text-orange"></i></span>
                    <input type="text" class="form-control bg-light border-0 fw-bold py-2" value="20 Apr - 25 Apr" style="font-size: 13px;">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">STAR RATING</label>
                <select class="form-select bg-light border-0 fw-bold py-2" style="font-size: 13px;">
                    <option>All Ratings</option>
                    <option>5 Star Only</option>
                    <option>4 Star & Above</option>
                    <option>3 Star & Above</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">GUESTS & ROOMS</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-users text-orange"></i></span>
                    <input type="text" class="form-control bg-light border-0 fw-bold py-2" value="2 Adults, 1 Room" style="font-size: 13px;">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">COMPARISON SOURCE</label>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-orange rounded-pill px-3 py-2 cursor-pointer">Google Hotels</span>
                    <span class="badge bg-secondary rounded-pill px-3 py-2 cursor-pointer opacity-50">B2C</span>
                    <span class="badge bg-purple rounded-pill px-3 py-2 cursor-pointer">B2C CAU</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Table -->
<div class="card-admin p-0 overflow-hidden border-0 shadow-sm" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="hotelComparisonTable">
            <thead class="bg-orange text-white">
                <tr>
                    <th class="ps-4 border-0 py-3 small fw-900">HOTEL & LOCATION</th>
                    <th class="border-0 py-3 small fw-900">GOOGLE HOTELS</th>
                    <th class="border-0 py-3 small fw-900">B2C PRICE</th>
                    <th class="border-0 py-3 small fw-900">B2C CAU PRICE</th>
                    <th class="border-0 py-3 small fw-900">B2B PRICE</th>
                    <th class="border-0 py-3 small fw-900 pe-4">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                $hotels = [
                    [
                        'name' => 'Taj Exotica Resort & Spa',
                        'location' => 'Benaulim, Goa',
                        'stars' => 5,
                        'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=50&h=50&fit=crop',
                        'google' => ['p' => '₹18,500', 'best' => true, 'link' => '#'],
                        'b2c' => ['p' => '₹19,200', 'best' => false],
                        'b2ccau' => ['p' => '₹18,700', 'best' => false],
                        'b2b' => ['p' => '₹18,900', 'best' => false],
                    ],
                    [
                        'name' => 'Burj Al Arab Jumeirah',
                        'location' => 'Umm Suqeim, Dubai',
                        'stars' => 7,
                        'img' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=50&h=50&fit=crop',
                        'google' => ['p' => '₹1,42,400', 'best' => false],
                        'b2c' => ['p' => '₹1,45,000', 'best' => false],
                        'b2ccau' => ['p' => '₹1,38,000', 'best' => true, 'link' => '#'],
                        'b2b' => ['p' => '₹1,40,200', 'best' => false],
                    ],
                    [
                        'name' => 'The Plaza Hotel',
                        'location' => 'Fifth Avenue, New York',
                        'stars' => 5,
                        'img' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=50&h=50&fit=crop',
                        'google' => ['p' => '₹45,200', 'best' => true, 'link' => '#'],
                        'b2c' => ['p' => '₹48,500', 'best' => false],
                        'b2ccau' => ['p' => '₹46,100', 'best' => false],
                        'b2b' => ['p' => '₹44,800', 'best' => false],
                    ],
                    [
                        'name' => 'JW Marriott Bengaluru',
                        'location' => 'Vittal Mallya Rd, Bangalore',
                        'stars' => 5,
                        'img' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=50&h=50&fit=crop',
                        'google' => ['p' => '₹11,450', 'best' => false],
                        'b2c' => ['p' => '₹12,200', 'best' => false],
                        'b2ccau' => ['p' => '₹11,800', 'best' => false],
                        'b2b' => ['p' => '₹10,950', 'best' => true, 'link' => '#'],
                    ],
                    [
                        'name' => 'Novotel Paris Centre',
                        'location' => 'Tour Eiffel, Paris',
                        'stars' => 4,
                        'img' => 'https://images.unsplash.com/photo-1551882547-ff43c5904cf3?w=50&h=50&fit=crop',
                        'google' => ['p' => '₹14,200', 'best' => true, 'link' => '#'],
                        'b2c' => ['p' => '₹15,500', 'best' => false],
                        'b2ccau' => ['p' => '₹14,900', 'best' => false],
                        'b2b' => ['p' => '₹14,800', 'best' => false],
                    ],
                ];
                @endphp
                @foreach($hotels as $hotel)
                <tr class="comparison-row">
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3 py-2">
                            <img src="{{ $hotel['img'] }}" width="50" height="50" class="rounded-3 shadow-sm border" style="object-fit: cover;">
                            <div>
                                <span class="d-block fw-900 text-navy mb-0" style="font-size: 14px;">{{ $hotel['name'] }}</span>
                                <div class="text-warning small mb-1">
                                    @for($i=1; $i<=$hotel['stars']; $i++) <i class="fas fa-star"></i> @endfor
                                    @if($hotel['stars'] > 5) <span class="badge bg-warning text-dark ms-1">ICONIC</span> @endif
                                </div>
                                <span class="d-block text-muted small fw-bold"><i class="fas fa-map-marker-alt me-1 opacity-50"></i> {{ $hotel['location'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="price-cell-hotel {{ $hotel['google']['best'] ? 'best' : '' }}">{{ $hotel['google']['p'] }}</td>
                    <td class="price-cell-hotel {{ $hotel['b2c']['best'] ? 'best' : '' }}">{{ $hotel['b2c']['p'] }}</td>
                    <td class="price-cell-hotel {{ $hotel['b2ccau']['best'] ? 'best' : '' }}">{{ $hotel['b2ccau']['p'] }}</td>
                    <td class="price-cell-hotel {{ $hotel['b2b']['best'] ? 'best' : '' }}">{{ $hotel['b2b']['p'] }}</td>
                    <td class="pe-4 text-end">
                         @php
                            $bestSource = '';
                            $bookingLink = '#';
                            if($hotel['google']['best']) { $bestSource = 'Google'; $bookingLink = $hotel['google']['link']; }
                            elseif($hotel['b2c']['best']) { $bestSource = 'B2C'; $bookingLink = $hotel['b2c']['link']; }
                            elseif($hotel['b2ccau']['best']) { $bestSource = 'B2C CAU'; $bookingLink = $hotel['b2ccau']['link']; }
                            elseif($hotel['b2b']['best']) { $bestSource = 'B2B'; $bookingLink = $hotel['b2b']['link']; }
                        @endphp
                        <div class="d-inline-flex flex-column align-items-end pe-2">
                             <span class="text-muted small fw-bold mb-1" style="font-size: 9px;">via {{ $bestSource }}</span>
                             <a href="{{ $bookingLink }}" class="btn btn-orange-pill-sm px-4 py-1 text-white text-decoration-none shadow-sm hvr-grow">Check Deal</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .bg-orange { background-color: #f97316; }
    .text-orange { color: #f97316; }
    .price-cell-hotel { font-weight: 800; font-size: 14px; position: relative; }
    .price-cell-hotel.best { color: #f97316; background: rgba(249, 115, 22, 0.05); }
    .price-cell-hotel.best::after {
        content: 'Best Deal'; position: absolute; top: 0px; left: 50%; transform: translateX(-50%);
        font-size: 8px; color: #f97316; font-weight: 900; text-transform: uppercase;
    }
    .comparison-row:hover { background: rgba(249, 115, 22, 0.02); }
    .btn-orange-pill-sm { background: #f97316; border-radius: 50px; font-weight: 800; font-size: 12px; transition: all 0.2s; }
    .btn-orange-pill-sm:hover { background: #ea580c; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3); }
</style>
@endsection

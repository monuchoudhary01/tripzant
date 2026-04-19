@extends('layouts.admin')

@section('title', 'Global Flight Comparison | Google API')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-5 mr-3">
    <div>
        <h2 class="fw-900 text-navy mb-1"><i class="fas fa-plane-departure text-primary me-3"></i> Global Flight Price Comparison</h2>
        <p class="text-muted small mb-0 font-weight-bold">Comparing prices from Google API, B2C, B2C CAU, and B2B Networks.</p>
    </div>
    <div class="d-flex gap-2">
        <div class="input-group" style="width: 350px;">
            <span class="input-group-text bg-white border-end-0 border-0 shadow-sm rounded-start-pill ps-4"><i class="fas fa-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0 border-0 shadow-sm rounded-end-pill py-2 fw-bold" placeholder="Search Route (e.g. DEL-MUM)..." style="font-size: 13px;">
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card-admin mb-5 border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
    <div class="bg-navy p-4 d-flex align-items-center justify-content-between">
        <h6 class="text-white mb-0 fw-bold"><i class="fas fa-filter me-2 text-warning"></i> Advanced Comparison Filters</h6>
        <button class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 small border-0 fw-800" style="background: rgba(255,255,255,0.1);"><i class="fas fa-undo me-2"></i> Reset</button>
    </div>
    <div class="p-4 bg-white border-bottom border-light">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">DEPARTURE DATE</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                    <input type="date" class="form-control bg-light border-0 fw-bold py-2" value="2026-04-15" style="font-size: 13px;">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">PREFERRED CARRIER</label>
                <select class="form-select bg-light border-0 fw-bold py-2" style="font-size: 13px;">
                    <option>All Airlines</option>
                    <option>Indigo</option>
                    <option>Air India</option>
                    <option>Emirates</option>
                    <option>Qatar Airways</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">TRIP TYPE</label>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary w-100 border-0 bg-light rounded-2 py-2 fw-800 small active">One Way</button>
                    <button class="btn btn-outline-secondary w-100 border-0 bg-light rounded-2 py-2 fw-800 small">Round Trip</button>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted fw-800 small mb-2 ms-2">SOURCE PLATFORM</label>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-primary rounded-pill px-3 py-2 cursor-pointer">Google API</span>
                    <span class="badge bg-secondary rounded-pill px-3 py-2 cursor-pointer opacity-50">B2C</span>
                    <span class="badge bg-success rounded-pill px-3 py-2 cursor-pointer">B2B</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Table -->
<div class="card-admin p-0 overflow-hidden border-0 shadow-sm" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="comparisonTable">
            <thead class="bg-navy text-white">
                <tr>
                    <th class="ps-4 border-0 py-3 small fw-900">FLIGHT DETAILS</th>
                    <th class="border-0 py-3 small fw-900">GOOGLE PRICE</th>
                    <th class="border-0 py-3 small fw-900">B2C PRICE</th>
                    <th class="border-0 py-3 small fw-900">B2C CAU PRICE</th>
                    <th class="border-0 py-3 small fw-900">B2B PRICE</th>
                    <th class="border-0 py-3 small fw-900 pe-4">BEST OPTION</th>
                </tr>
            </thead>
            <tbody>
                @php
                $flights = [
                    [
                        'airline' => 'IndiGo (6E-2015)',
                        'logo' => 'https://img.icons8.com/color/48/plane.png',
                        'route' => 'New Delhi (DEL) → Mumbai (BOM)',
                        'time' => '08:00 AM - 10:15 AM (Non-stop)',
                        'google' => ['p' => '₹4,850', 'best' => false],
                        'b2c' => ['p' => '₹5,200', 'best' => false],
                        'b2ccau' => ['p' => '₹4,950', 'best' => false],
                        'b2b' => ['p' => '₹4,750', 'best' => true, 'link' => '#'],
                    ],
                    [
                        'airline' => 'Air India (AI-101)',
                        'logo' => 'https://img.icons8.com/color/48/plane.png',
                        'route' => 'New Delhi (DEL) → New York (JFK)',
                        'time' => '02:30 AM - 08:30 AM (+1 Day)',
                        'google' => ['p' => '₹82,400', 'best' => true, 'link' => '#'],
                        'b2c' => ['p' => '₹85,000', 'best' => false],
                        'b2ccau' => ['p' => '₹83,100', 'best' => false],
                        'b2b' => ['p' => '₹84,200', 'best' => false],
                    ],
                    [
                        'airline' => 'Vistara (UK-944)',
                        'logo' => 'https://img.icons8.com/color/48/plane.png',
                        'route' => 'Bangalore (BLR) → Singapore (SIN)',
                        'time' => '11:45 PM - 06:15 AM (+1 Day)',
                        'google' => ['p' => '₹18,200', 'best' => false],
                        'b2c' => ['p' => '₹17,800', 'best' => true, 'link' => '#'],
                        'b2ccau' => ['p' => '₹18,500', 'best' => false],
                        'b2b' => ['p' => '₹17,950', 'best' => false],
                    ],
                    [
                        'airline' => 'Akasa Air (QP-1122)',
                        'logo' => 'https://img.icons8.com/color/48/plane.png',
                        'route' => 'Hyderabad (HYD) → Jaipur (JAI)',
                        'time' => '04:20 PM - 06:05 PM',
                        'google' => ['p' => '₹3,450', 'best' => false],
                        'b2c' => ['p' => '₹3,600', 'best' => false],
                        'b2ccau' => ['p' => '₹3,250', 'best' => true, 'link' => '#'],
                        'b2b' => ['p' => '₹3,300', 'best' => false],
                    ],
                    [
                        'airline' => 'Emirates (EK-511)',
                        'logo' => 'https://img.icons8.com/color/48/plane.png',
                        'route' => 'Dubai (DXB) → London (LHR)',
                        'time' => '09:30 AM - 02:15 PM',
                        'google' => ['p' => '₹42,000', 'best' => true, 'link' => '#'],
                        'b2c' => ['p' => '₹44,500', 'best' => false],
                        'b2ccau' => ['p' => '₹43,100', 'best' => false],
                        'b2b' => ['p' => '₹42,800', 'best' => false],
                    ],
                ];
                @endphp
                @foreach($flights as $flight)
                <tr class="comparison-row">
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3 py-2">
                            <div class="bg-light rounded p-2"><img src="{{ $flight['logo'] }}" width="24" alt=""></div>
                            <div>
                                <span class="d-block fw-900 text-navy mb-0" style="font-size: 14px;">{{ $flight['airline'] }}</span>
                                <span class="d-block text-muted small fw-bold mt-1">{{ $flight['route'] }}</span>
                                <span class="d-inline-block bg-light-subtle text-primary border rounded-pill px-2 mt-2" style="font-size: 10px; font-weight: 800;">{{ $flight['time'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="price-cell {{ $flight['google']['best'] ? 'best' : '' }}">{{ $flight['google']['p'] }}</td>
                    <td class="price-cell {{ $flight['b2c']['best'] ? 'best' : '' }}">{{ $flight['b2c']['p'] }}</td>
                    <td class="price-cell {{ $flight['b2ccau']['best'] ? 'best' : '' }}">{{ $flight['b2ccau']['p'] }}</td>
                    <td class="price-cell {{ $flight['b2b']['best'] ? 'best' : '' }} text-secondary-info">{{ $flight['b2b']['p'] }}</td>
                    <td class="pe-4 text-end">
                        @php
                            $bestSource = '';
                            $bookingLink = '#';
                            if($flight['google']['best']) { $bestSource = 'Google API'; $bookingLink = $flight['google']['link']; }
                            elseif($flight['b2c']['best']) { $bestSource = 'B2C Platform'; $bookingLink = $flight['b2c']['link']; }
                            elseif($flight['b2ccau']['best']) { $bestSource = 'B2C CAU'; $bookingLink = $flight['b2ccau']['link']; }
                            elseif($flight['b2b']['best']) { $bestSource = 'B2B Network'; $bookingLink = $flight['b2b']['link']; }
                        @endphp
                        <div class="d-inline-flex flex-column align-items-end pe-2">
                            <span class="badge fw-900 mb-1 px-3 py-2" style="background: var(--admin-primary); font-size: 10px; letter-spacing: 0.5px;">{{ strtoupper($bestSource) }}</span>
                            <a href="{{ $bookingLink }}" class="btn btn-navy-pill-sm px-4 py-1 text-white text-decoration-none shadow-sm hvr-grow">Book Now <i class="fas fa-chevron-right ms-2 fs-7 opacity-75"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .bg-navy { background-color: #0b3d61; }
    .text-navy { color: #0b3d61; }
    .price-cell { font-weight: 800; font-size: 14px; position: relative; transition: all 0.2s ease; }
    .price-cell.best { color: #10b981; background: rgba(16, 185, 129, 0.05); }
    .price-cell.best::after {
        content: 'Lowest'; position: absolute; top: 0px; left: 50%; transform: translateX(-50%);
        font-size: 8px; color: #10b981; font-weight: 900; text-transform: uppercase;
    }
    .comparison-row:hover { background: rgba(59, 130, 246, 0.02); }
    .btn-navy-pill-sm { background: #0b3d61; border-radius: 50px; font-weight: 800; font-size: 12px; }
    .text-secondary-info { color: #f97316; }
    .fs-7 { font-size: 10px; }
    .bg-light-subtle { background: rgba(11, 61, 97, 0.05); }
</style>
@endsection

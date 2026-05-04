@props([
    'type' => 'flight', 'title', 'subtitle', 'price', 'currency' => '₹', 'rating' => 4.5, 'reviews' => 120, 'image' => '', 
    'leg' => 'onward', 'depCity' => 'DEL', 'arrCity' => 'BOM', 'depTime' => '10:50', 'arrTime' => '13:05', 
    'duration' => '02h 15m', 'stops' => 0, 'baggage' => '15KG', 'terminal' => 'T1', 'isRefundable' => true, 'f' => []
])

@php
    $isBest = $f['is_cheapest'] ?? false;
    $source = $f['source'] ?? 'amadeus';
    $netPrice = $f['net_price'] ?? $price;
    $markup = ($f['price'] ?? 0) - $netPrice;
@endphp

<div class="result-card mb-4" 
     style="background: #fff; border-radius: 20px; border: 1.5px solid {{ $isBest ? '#fbbf24' : '#f1f5f9' }}; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); overflow: visible; position: relative;"
     onmouseover="this.style.boxShadow='0 20px 40px rgba(0,0,0,0.06)'; this.style.borderColor='{{ $isBest ? '#fbbf24' : 'var(--primary)' }}';"
     onmouseout="this.style.boxShadow='none'; this.style.borderColor='{{ $isBest ? '#fbbf24' : '#f1f5f9' }}';"
     data-leg="{{ $leg }}"
     data-airline="{{ $title }}"
     data-price="{{ str_replace(',','',$price) }}"
     data-stops="{{ $stops }}"
     data-refundable="{{ $isRefundable ? '1' : '0' }}"
     data-cabin="{{ strtoupper($f['cabin'] ?? 'ECONOMY') }}"
     data-source="{{ $source }}"
     data-seats="{{ $f['seats'] ?? 9 }}"
     data-dep-city="{{ $depCity }}"
     data-arr-city="{{ $arrCity }}">
     
    @if($isBest)
        <div class="position-absolute top-0 start-0 m-0 translate-middle-y" style="z-index: 5; left: 30px !important;">
            <span class="badge bg-warning text-dark fw-900 shadow-sm px-3 py-2 animate__animated animate__pulse animate__infinite" style="font-size: 10px; border-radius: 50px; border: 2px solid #fff;">
                <i class="fas fa-crown me-1"></i> BEST DEAL / LOWEST FARE
            </span>
        </div>
    @endif

    <div class="bank-offer-badge" id="bankBadge_{{ $f['id'] ?? uniqid() }}">
        <i class="fas fa-percentage me-1"></i> BANK OFFER APPLIED
    </div>

    <!-- Main Result Content -->
    <div class="p-4">
        @if($type == 'flight')
            <div class="row align-items-center">
                <!-- Select for Compare -->
                <div class="col-auto pe-0">
                    <div class="form-check custom-checkbox-compare" title="Add to Compare">
                        <input class="form-check-input compare-checkbox" type="checkbox" 
                               data-flight-id="{{ $f['id'] ?? uniqid() }}"
                               data-airline="{{ $title }}"
                               data-price="{{ $currency }} {{ $price }}"
                               data-duration="{{ $duration }}"
                               data-baggage="{{ $baggage }} (Check-in) + 7KG (Cabin)"
                               data-meal="{{ $f['meal_info'] ?? 'Free Meals' }}"
                               data-meal-detail="{{ $f['meal_detail'] ?? '' }}"
                               data-seat="{{ $f['cabin'] ?? 'Economy' }}"
                               data-refund="{{ $isRefundable ? 'Refundable' : 'Non-refundable' }}"
                               data-wifi="{{ $f['has_wifi'] ?? 'Yes' }}"
                               data-wifi-detail="{{ $f['wifi_detail'] ?? 'Available' }}"
                               data-entertainment="{{ $f['has_entertainment'] ?? 'Yes' }}"
                               data-wine="{{ $f['wine_available'] ?? 'No' }}"
                               data-amenities="{{ $f['extra_amenities'] ?? '' }}"
                               data-boarding="{{ $f['boarding'] ?? 'Regular' }}"
                               onclick="handleCompareSelection(this)">
                    </div>
                </div>

                <!-- Airline Info -->
                <div class="col-lg-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="airline-logo-wrapper shadow-sm" style="width:52px; height:52px; background:#fff; border-radius:12px; display:flex; align-items:center; justify-content:center; border:1px solid #f1f5f9;">
                            @if($image)
                                <img src="{{ $image }}" alt="{{ $title }}" style="width:38px; height:38px; object-fit:contain;">
                            @else
                                <i class="fas fa-plane text-primary fa-lg"></i>
                            @endif
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-900 text-navy" style="font-size:16px; letter-spacing:-0.3px;">{{ $title }}</h6>
                                <span class="badge {{ $source == 'amadeus' ? 'bg-primary' : ($source == 'rapidapi' ? 'bg-info' : 'bg-secondary') }} bg-opacity-10 text-{{ $source == 'amadeus' ? 'primary' : ($source == 'rapidapi' ? 'info' : 'secondary') }} rounded-pill" style="font-size:8px; font-weight:900;">
                                    {{ strtoupper($source) }}
                                </span>
                            </div>
                            <div class="d-flex flex-column gap-1 mt-1">
                                <span class="text-muted fw-700 uppercase" style="font-size:10px;">{{ $subtitle }}</span>
                                <div class="d-flex align-items-center gap-1 cursor-pointer hvr-light-bg p-1 rounded fare-options-trigger" 
                                     style="cursor: pointer;" 
                                     onclick="window.openFareOptions('{{ $f['id'] ?? '' }}', '{{ str_replace(',','',$price) }}', '{{ $title }}')"
                                     data-flight-id="{{ $f['id'] ?? '' }}" 
                                     data-price="{{ str_replace(',','',$price) }}" 
                                     data-airline="{{ $title }}">
                                    <span class="badge bg-navy text-white" style="font-size:9px; font-weight:900; border: 1px solid rgba(0,0,128,0.1);">
                                        <i class="fas fa-chair me-1" style="font-size:8px;"></i> {{ $f['booking_class'] ?? 'Y' }}{{ $f['seats_available'] ?? '9' }}+
                                    </span>
                                    <span class="text-muted fw-800" style="font-size:9px;">{{ strtoupper($f['cabin'] ?? 'ECONOMY') }} <i class="fas fa-chevron-down ms-1 opacity-50" style="font-size:7px;"></i></span>
                                </div>
                                @if(Auth::check() && Auth::user()->role === 'b2b')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mt-1" style="font-size:9px; font-weight:800; width: fit-content;" title="B2B Hub Code">NODE: {{ strtoupper(substr($source, 0, 3)) }}-{{ rand(100,999) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Itinerary -->
                <div class="col-lg-6">
                    <div class="row align-items-center text-center">
                        <div class="col-4">
                            <div class="fw-900 text-navy dep-time" style="font-size:24px; line-height:1;">{{ $depTime }}</div>
                            <div class="text-muted fw-800 uppercase mt-1 dep-city" style="font-size:11px;">{{ $depCity }} <span class="opacity-50">({{ $terminal }})</span></div>
                        </div>
                        <div class="col-4 position-relative px-0">
                            <div class="text-muted fw-800 uppercase mb-2" style="font-size:10px; letter-spacing:0.5px;">{{ $duration }}</div>
                            <div class="d-flex align-items-center justify-content-center px-3">
                                <div style="width:8px; height:8px; background:var(--primary); border-radius:50%; flex-shrink:0;"></div>
                                <div style="flex-grow:1; height:2px; background:linear-gradient(90deg, var(--primary) 0%, #e2e8f0 100%); margin: 0 4px;"></div>
                                @if($stops > 0)
                                    <div class="position-absolute translate-middle-y" style="top:50%; background:#fff; padding:0 8px; border:1.5px solid #2563eb; border-radius:50px; font-size:9px; font-weight:900; color:var(--primary);">{{ $stops }} STOP</div>
                                @endif
                                <div style="width:8px; height:8px; background:#e2e8f0; border-radius:50%; flex-shrink:0;"></div>
                            </div>
                            <div class="mt-2">
                                <span class="badge {{ $isRefundable ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }} rounded-pill" style="font-size:9px; font-weight:900; background:rgba({{ $isRefundable ? '34,197,94' : '239,68,68' }}, 0.1);">
                                    {{ $isRefundable ? 'REFUNDABLE' : 'NON-REFUNDABLE' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="fw-900 text-navy arr-time" style="font-size:24px; line-height:1;">{{ $arrTime }}</div>
                            <div class="text-muted fw-800 uppercase mt-1 arr-city" style="font-size:11px;">{{ $arrCity }}</div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & CTA -->
                <div class="col-lg-2 text-end border-start px-4">
                    <div class="mb-3">
                        @if(isset($f['fare_type_applied']))
                            <div class="mb-1 text-end">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mb-1" style="font-size: 8px;">
                                    <i class="fas {{ $f['fare_type_applied'] == 'student' ? 'fa-user-graduate' : 'fa-user-clock' }} me-1"></i>
                                    {{ strtoupper($f['fare_type_applied']) }} FARE
                                </span>
                                <div class="text-muted text-decoration-line-through me-1" style="font-size: 11px;">{{ $currency }} {{ number_format($f['original_price'] ?? 0) }}</div>
                            </div>
                        @endif
                        <span class="fw-900 text-navy flight-price-display" style="font-size:22px;">{{ $currency }} {{ $price }}</span>
                        <span class="text-muted fw-800" style="font-size:10px; display:block; margin-top:-5px;">per adult</span>
                        
                        @if(!$isBest)
                            <div class="mt-2 text-danger fw-800" style="font-size: 9px;">
                                <i class="fas fa-arrow-up me-1"></i> +{{ $currency }}{{ number_format(rand(500, 1500)) }} vs Best Deal
                            </div>
                        @else
                            <div class="mt-2 text-success fw-800" style="font-size: 9px;">
                                <i class="fas fa-check-circle me-1"></i> CHEAPEST SOURCE
                            </div>
                        @endif
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill fw-900 shadow-sm transition hvr-grow" 
                            style="padding: 10px; font-size:13px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border:none;"
                            onclick="selectFlightForCheckout({
                                id: '{{ $f['id'] ?? '' }}',
                                type: 'flight',
                                airline: '{{ $title }}',
                                flight_no: '{{ $subtitle }}',
                                price: '{{ str_replace(',','',$price) }}',
                                dep_city: '{{ $depCity }}',
                                arr_city: '{{ $arrCity }}',
                                dep_time: '{{ $depTime }}',
                                arr_time: '{{ $arrTime }}',
                                leg: '{{ $leg }}',
                                currency: '{{ $currency }}'
                            })">
                        BOOK
                    </button>
                </div>
            </div>
        @elseif($type == 'hotel' || $type == 'homestay')
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="position-relative h-100">
                        <img src="{{ $image }}" alt="{{ $title }}" style="width:100%; height:100%; object-fit:cover; border-top-left-radius:18px; border-bottom-left-radius:18px; min-height:220px;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-white text-navy fw-800 shadow-sm" style="font-size:11px; border-radius:6px; padding:6px 10px;">
                                <i class="fas fa-star text-warning me-1"></i> {{ $rating }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="fw-900 text-navy mb-1" style="font-size:20px;">{{ $title }}</h5>
                                <p class="text-muted fw-700 mb-0" style="font-size:12px;"><i class="fas fa-map-marker-alt me-1 text-primary"></i> {{ $subtitle }}</p>
                            </div>
                            <div class="text-end">
                                <span class="text-muted fw-700 block mb-1" style="font-size:11px; opacity:0.6;">Starting from</span>
                                <h4 class="fw-900 text-navy mb-0 flight-price-display" style="font-size:24px;">{{ $currency }} {{ $price }}</h4>
                                <span class="text-muted fw-700" style="font-size:10px; display:block;">per night</span>
                            </div>
                        </div>

                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-3">
                                @if($type == 'homestay')
                                    <span class="text-muted fs-11 fw-700"><i class="fas fa-home me-1 text-secondary"></i> Entire Home</span>
                                    <span class="text-muted fs-11 fw-700"><i class="fas fa-users me-1 text-secondary"></i> 4 Guests</span>
                                @else
                                    <span class="text-muted fs-11 fw-700"><i class="fas fa-wifi me-1 text-secondary"></i> Free WiFi</span>
                                    <span class="text-muted fs-11 fw-700"><i class="fas fa-swimming-pool me-1 text-secondary"></i> Pool</span>
                                @endif
                            </div>
                            <button class="btn btn-primary rounded-pill fw-900 px-4 py-2" style="font-size:13px;" onclick="window.location.href='/{{ $type }}/details/{{ $f['id'] ?? '1' }}'">
                                VIEW DETAILS
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($type == 'train')
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="airline-logo-wrapper shadow-sm" style="width:52px; height:52px; background:#fff; border-radius:12px; display:flex; align-items:center; justify-content:center; border:1px solid #f1f5f9;">
                            <i class="fas fa-train text-navy fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-900 text-navy" style="font-size:16px;">{{ $title }}</h6>
                            <span class="text-muted fw-700 uppercase" style="font-size:10px;">{{ $subtitle }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="d-flex align-items-center justify-content-center gap-4">
                        <div class="text-muted small fw-800"><i class="fas fa-calendar-check me-1 text-success"></i> Running Daily</div>
                        <div class="text-muted small fw-800"><i class="fas fa-shield-alt me-1 text-primary"></i> Confirmed Ticket</div>
                    </div>
                </div>
                <div class="col-lg-3 text-end border-start px-4">
                    <div class="mb-2">
                        <span class="fw-900 text-navy flight-price-display" style="font-size:26px;">{{ $currency }} {{ $price }}</span>
                    </div>
                    <button class="btn btn-navy w-100 rounded-pill fw-900 shadow-sm" style="padding: 10px; font-size:14px;">
                        BOOK NOW
                    </button>
                </div>
            </div>
        @endif
    </div>

    @if($type == 'flight')
    <!-- Enhanced Action Bar -->
    <div class="px-4 py-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center" style="border-top:1px solid #f1f5f9; border-bottom-left-radius:20px; border-bottom-right-radius:20px;">
        <div class="d-flex gap-4">
            <div class="d-flex align-items-center gap-2 small fw-800 text-navy uppercase" style="font-size:10.5px; letter-spacing:0.3px;">
                <i class="fas fa-suitcase-rolling text-primary"></i> <span class="text-muted">CABIN:</span> 7KG
            </div>
            <div class="d-flex align-items-center gap-2 small fw-800 text-navy uppercase" style="font-size:10.5px; letter-spacing:0.3px;">
                <i class="fas fa-luggage-cart text-primary"></i> <span class="text-muted">CHECK-IN:</span> {{ $baggage }}
            </div>
            <div class="d-flex align-items-center gap-2 small fw-800 text-navy uppercase" style="font-size:10.5px; letter-spacing:0.3px;">
                <i class="fas fa-bowl-food text-primary"></i> <span class="text-muted">MEALS:</span> {{ $f['meal_info'] ?? 'FREE MEALS' }}
            </div>
            <div class="d-flex align-items-center gap-2 small fw-800 text-navy uppercase" style="font-size:10.5px; letter-spacing:0.3px;">
                <i class="fas fa-chair text-primary"></i> <span class="text-muted">SEAT:</span> {{ $f['booking_class'] ?? 'Y' }}{{ $f['seats_available'] ?? '9' }}+ ({{ $f['cabin'] ?? 'ECONOMY' }})
            </div>
            @if(request('fare_type') && request('fare_type') !== 'regular')
                @php
                    $ft = request('fare_type');
                    $fareLabel = $ft == 'senior' ? 'SeniorCitizen' : ($ft == 'student' ? 'Student' : ($ft == 'armed_forces' ? 'ArmedForces' : ucfirst($ft)));
                @endphp
                <div class="d-flex align-items-center ms-2">
                    <span style="background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 800; letter-spacing: 0.3px;">
                        {{ $fareLabel }}
                    </span>
                </div>
            @endif
        </div>
        <div class="d-flex gap-3 align-items-center">
            <button onclick="showFlightDetails('{{ $f['id'] ?? '' }}')" class="btn btn-link text-primary text-decoration-none fw-900 p-0" style="font-size:11px;">
                FLIGHT DETAILS <i class="fas fa-arrow-right ms-1"></i>
            </button>
        </div>
    </div>
    @endif
</div>

<style>
    .custom-checkbox-compare .form-check-input {
        width: 22px;
        height: 22px;
        margin-top: 0;
        cursor: pointer;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
    }
    .custom-checkbox-compare .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .result-card {
        border-width: 1.5px !important;
    }
    .result-card:hover {
        transform: translateY(-2px);
    }
</style>

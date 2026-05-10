@extends('layouts.app')

@section('title', 'Finalize Your Journey — Tripzant')

@section('styles')
<style>
    :root {
        --glass: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.5);
        --premium-blue: #0077ff;
        --deep-navy: #002244;
    }
    
    .checkout-bg { 
        background: radial-gradient(circle at top right, #f0f7ff, #ffffff);
        min-height: 100vh; 
        font-family: 'Outfit', sans-serif;
        padding-bottom: 100px;
    }

    .page-header {
        background: linear-gradient(135deg, var(--deep-navy), #004488);
        padding: 60px 0 100px;
        margin-bottom: -60px;
        color: #fff;
    }

    .premium-card {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    .premium-card:hover { transform: translateY(-5px); }

    /* Unique Hotel Header */
    .hotel-hero {
        display: flex;
        gap: 30px;
        padding: 30px;
        align-items: center;
    }
    .hotel-img-wrapper {
        width: 140px;
        height: 140px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }
    .hotel-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    
    .hotel-title-area h2 { font-weight: 900; font-size: 32px; color: var(--deep-navy); margin-bottom: 8px; }
    .stars-row { color: #ffb800; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 5px; }
    .loc-tag { background: #f0f7ff; color: var(--premium-blue); padding: 5px 15px; border-radius: 99px; font-size: 12px; font-weight: 800; }

    /* Timeline Stay Info */
    .stay-timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 40px;
        background: #fff;
        border-radius: 0 0 24px 24px;
        border-top: 1px dashed #e2e8f0;
    }
    .time-node { text-align: center; flex: 1; }
    .time-node.center { flex: 0.5; position: relative; }
    .time-node.center::before {
        content: '';
        position: absolute;
        top: 50%;
        left: -20%;
        right: -20%;
        height: 2px;
        background: repeating-linear-gradient(90deg, #cbd5e1, #cbd5e1 5px, transparent 5px, transparent 10px);
        z-index: 1;
    }
    .nights-pill {
        background: var(--deep-navy);
        color: #fff;
        padding: 6px 18px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 900;
        position: relative;
        z-index: 2;
        letter-spacing: 1px;
    }
    .t-label { font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px; }
    .t-date { font-size: 20px; font-weight: 900; color: var(--deep-navy); }
    .t-sub { font-size: 14px; font-weight: 600; color: #64748b; }

    /* Room Config */
    .room-config-bar {
        background: #f8fafc;
        padding: 15px 40px;
        display: flex;
        gap: 30px;
        font-size: 14px;
        font-weight: 700;
        color: #475569;
        border-top: 1px solid #f1f5f9;
    }
    .room-config-bar span i { color: var(--premium-blue); margin-right: 8px; }

    /* Guest Form UI */
    .section-label { 
        font-size: 18px; 
        font-weight: 900; 
        color: var(--deep-navy); 
        margin-bottom: 25px; 
        display: flex; 
        align-items: center; 
        gap: 15px; 
    }
    .section-label span { 
        width: 32px; 
        height: 32px; 
        background: var(--premium-blue); 
        color: #fff; 
        border-radius: 10px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 16px; 
    }

    .form-group-custom { margin-bottom: 25px; }
    .form-label-custom { font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px; display: block; letter-spacing: 0.5px; }
    .input-custom { 
        width: 100%; 
        padding: 15px 20px; 
        border-radius: 16px; 
        border: 2px solid #f1f5f9; 
        background: #fff; 
        font-weight: 700; 
        transition: all 0.3s; 
    }
    .input-custom:focus { border-color: var(--premium-blue); outline: none; box-shadow: 0 10px 20px rgba(0,119,255,0.05); }

    /* Sidebar Price Display */
    .sidebar-sticky { position: sticky; top: 100px; }
    .price-display-unique {
        background: linear-gradient(135deg, var(--deep-navy), #004488);
        color: #fff;
        padding: 35px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,34,68,0.2);
    }
    .p-unique-row { display: flex; justify-content: space-between; margin-bottom: 15px; opacity: 0.8; font-weight: 600; }
    .p-unique-total { 
        border-top: 1px solid rgba(255,255,255,0.1); 
        padding-top: 25px; 
        margin-top: 20px; 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-end; 
    }
    .p-total-val { font-size: 36px; font-weight: 900; line-height: 1; }

    /* Coupon Unique */
    .coupon-unique {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        margin-top: 30px;
        border: 1px solid #f1f5f9;
    }
    .coupon-tag-unique {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        background: #f0fdf4;
        border: 1px dashed #22c55e;
        border-radius: 12px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .coupon-tag-unique:hover { transform: scale(1.02); }
    .coupon-code-unique { font-weight: 900; color: #166534; font-size: 16px; }

    .btn-pay-unique {
        width: 100%;
        background: #fff;
        color: var(--deep-navy);
        border: none;
        padding: 20px;
        border-radius: 18px;
        font-weight: 900;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 30px;
        box-shadow: 0 10px 30px rgba(255,255,255,0.2);
        transition: all 0.3s;
    }
    .btn-pay-unique:hover { transform: scale(1.02); background: var(--premium-blue); color: #fff; }

    /* Animations */
    .animate-slide-up { animation: slideUp 0.6s ease forwards; opacity: 0; }
    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="outfit fw-900 mb-0">Confirm Your Stay</h1>
        <p class="opacity-75">Securely book your premium stay at {{ $booking['name'] ?? 'Hotel' }}</p>
    </div>
</div>

<div class="checkout-bg">
    <div class="container">
        <form action="{{ route('hotel.book') }}" method="POST">
            @csrf
            {{-- Hidden fields for booking --}}
            <input type="hidden" name="rate_key"      value="{{ $rate['rateKey'] ?? '' }}">
            <input type="hidden" name="total_fare"    value="{{ $rate['sellingRate'] ?? 0 }}">
            <input type="hidden" name="hotel_name"    value="{{ $booking['name'] ?? '' }}">
            <input type="hidden" name="hotel_code"    value="{{ $rate['hotelCode'] ?? '' }}">
            <input type="hidden" name="room_name"     value="{{ $booking['rooms'][0]['name'] ?? '' }}">
            <input type="hidden" name="board_name"    value="{{ $rate['boardName'] ?? 'Room Only' }}">
            <input type="hidden" name="checkIn"       value="{{ $params['checkIn'] ?? '' }}">
            <input type="hidden" name="checkOut"      value="{{ $params['checkOut'] ?? '' }}">
            <input type="hidden" name="adults"        value="{{ $params['adults'] ?? 2 }}">
            <input type="hidden" name="children"      value="{{ $params['children'] ?? 0 }}">
            <input type="hidden" name="rooms"         value="{{ $params['rooms'] ?? 1 }}">
            <input type="hidden" name="discount"      id="hiddenDiscount" value="0">
            <input type="hidden" name="final_total"   id="hiddenFinalTotal" value="{{ $rate['sellingRate'] ?? 0 }}">

            <div class="row g-5">
                <div class="col-lg-8 animate-slide-up">
                    
                    {{-- Unique Hotel Experience Card --}}
                    <div class="premium-card">
                        <div class="hotel-hero">
                            <div class="hotel-img-wrapper">
                                @php 
                                    $hotelImg = isset($booking['images'][0]['path']) ? "https://photos.hotelbeds.com/giata/" . $booking['images'][0]['path'] : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';
                                @endphp
                                <img src="{{ $hotelImg }}" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';" alt="Hotel">
                            </div>
                            <div class="hotel-title-area">
                                <div class="stars-row">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <span class="ms-3 loc-tag">{{ $booking['address'] ?? 'City Center' }}</span>
                                </div>
                                <h2 class="outfit">{{ $booking['name'] ?? 'Hotel Name' }}</h2>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-800">CANCELLABLE</span>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-800">{{ strtoupper($booking['rooms'][0]['name'] ?? 'Superior Room') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="stay-timeline">
                            <div class="time-node">
                                <div class="t-label">CHECK-IN</div>
                                <div class="t-date">{{ date('d M Y', strtotime($params['checkIn'])) }}</div>
                                <div class="t-sub">{{ date('l', strtotime($params['checkIn'])) }} • 2 PM</div>
                            </div>
                            <div class="time-node center">
                                @php
                                    $nights = max(1, (strtotime($params['checkOut']) - strtotime($params['checkIn'])) / 86400);
                                @endphp
                                <div class="nights-pill">{{ $nights }} NIGHTS</div>
                            </div>
                            <div class="time-node">
                                <div class="t-label">CHECK-OUT</div>
                                <div class="t-date">{{ date('d M Y', strtotime($params['checkOut'])) }}</div>
                                <div class="t-sub">{{ date('l', strtotime($params['checkOut'])) }} • 11 AM</div>
                            </div>
                        </div>

                        <div class="room-config-bar">
                            <span><i class="fas fa-bed"></i> {{ $params['rooms'] }} Rooms</span>
                            <span><i class="fas fa-user-friends"></i> {{ $params['adults'] }} Adults</span>
                            <span><i class="fas fa-child"></i> {{ $params['children'] }} Children</span>
                            <span><i class="fas fa-utensils"></i> {{ $rate['boardName'] ?? 'Room Only' }}</span>
                        </div>
                    </div>

                    {{-- Guest Information --}}
                    <div class="section-label">
                        <span>1</span>
                        Guest Details
                    </div>

                    <div class="premium-card p-5">
                        <h5 class="fw-900 mb-4 text-navy"><i class="fas fa-user-circle me-2 text-primary"></i> Primary Guest (Lead Traveler)</h5>
                        <div class="row g-4">
                            <div class="col-md-2">
                                <label class="form-label-custom">Title</label>
                                <select name="title" class="input-custom">
                                    <option>Mr</option><option>Ms</option><option>Mrs</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label-custom">First Name</label>
                                <input type="text" name="pax_name[0]" class="input-custom" required placeholder="Gaurav" value="{{ old('pax_name.0', explode(' ', auth()->user()->name ?? '')[0]) }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label-custom">Last Name</label>
                                <input type="text" name="pax_surname[0]" class="input-custom" required placeholder="Sharma">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Email for Confirmation</label>
                                <input type="email" name="email" class="input-custom" required value="{{ old('email', auth()->user()->email ?? '') }}">
                            </div>
                        </div>

                        {{-- Dynamic Guests --}}
                        @php $totalGuests = (int)($params['adults'] ?? 2) + (int)($params['children'] ?? 0); @endphp
                        @for($i = 1; $i < $totalGuests; $i++)
                            <hr class="my-5 opacity-5">
                            <h5 class="fw-900 mb-4 text-navy">
                                <i class="fas fa-user-plus me-2 text-primary"></i> 
                                Guest {{ $i + 1 }} {{ $i >= ($params['adults'] ?? 2) ? '(Child)' : '' }}
                                <span class="badge bg-light text-muted fw-800 ms-3" style="font-size:10px;">ROOM {{ ceil(($i + 1) / ceil($totalGuests / $params['rooms'])) }}</span>
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-custom">First Name</label>
                                    <input type="text" name="pax_name[{{ $i }}]" class="input-custom" required placeholder="Enter name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Last Name</label>
                                    <input type="text" name="pax_surname[{{ $i }}]" class="input-custom" required placeholder="Enter surname">
                                </div>
                            </div>
                        @endfor
                    </div>

                    {{-- Payment Method Selection --}}
                    <div class="section-label">
                        <span>2</span>
                        Payment Method
                    </div>
                    <div class="premium-card p-4">
                        <div class="mb-0">
                            <h6 class="fw-900 text-muted mb-3 fs-11 uppercase" style="letter-spacing: 2px;">SELECT PAYMENT GATEWAY</h6>
                            <div class="d-flex flex-column gap-2">
                                @if($enabledGateways['stripe'])
                                <label class="payment-method-card p-3 border rounded-4 d-flex align-items-center gap-3 bg-white cursor-pointer w-100 mb-0" id="gw-stripe">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="gateway" value="stripe" checked>
                                    </div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="20">
                                    <span class="fw-900 small text-navy ms-auto">STRIPE SECURE</span>
                                </label>
                                @endif

                                @if($enabledGateways['mpgs'])
                                <label class="payment-method-card p-3 border rounded-4 d-flex align-items-center gap-3 bg-white cursor-pointer w-100 mb-0" id="gw-mpgs">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="gateway" value="mpgs" {{ !$enabledGateways['stripe'] ? 'checked' : '' }}>
                                    </div>
                                    <img src="{{ asset('assets/img/payment/commercial_bank.png') }}" height="25">
                                    <span class="fw-900 small text-navy ms-auto">COMMERCIAL BANK</span>
                                </label>
                                @endif

                                @if(!$enabledGateways['stripe'] && !$enabledGateways['mpgs'])
                                    <div class="alert alert-warning py-2 small fw-bold mb-0">No payment gateway enabled. Contact admin.</div>
                                @endif
                                
                                <input type="hidden" name="payment_method" value="online">
                            </div>
                        </div>
                    </div>

                    <style>
                        .payment-method-card { transition: 0.2s; border: 1.5px solid #e2e8f0 !important; cursor: pointer; }
                        .payment-method-card:hover { border-color: #2563eb !important; background: #f8fafc; }
                        .payment-method-card:has(input:checked) { border-color: #2563eb !important; background: #eff6ff; box-shadow: 0 0 0 1px #2563eb; }
                    </style>

                </div>

                <div class="col-lg-4">
                    <div class="sidebar-sticky animate-slide-up" style="animation-delay: 0.2s;">
                        
                        {{-- Premium Price Summary --}}
                        <div class="price-display-unique">
                            <h4 class="outfit fw-900 mb-4">Fare Summary</h4>
                            @php
                                $total = (float)($rate['sellingRate'] ?? 0);
                                $tax = round($total * 0.12, 0);
                                $base = $total - $tax;
                            @endphp
                            <div class="p-unique-row">
                                <span>Base Price</span>
                                <span>₹{{ number_format($base, 0) }}</span>
                            </div>
                            <div class="p-unique-row">
                                <span>Taxes & Fees</span>
                                <span>₹{{ number_format($tax, 0) }}</span>
                            </div>
                            <div id="discountRowUnique" class="p-unique-row text-info" style="display:none; opacity: 1;">
                                <span class="fw-900">Coupon Discount</span>
                                <span class="fw-900">- ₹<span id="discountValUnique">0</span></span>
                            </div>
                            
                            <div class="p-unique-total">
                                <div>
                                    <div class="small opacity-75 fw-800">Total Payable</div>
                                    <div class="fw-600 tiny">Inc. all taxes</div>
                                </div>
                                <div class="p-total-val">₹<span id="totalDisplayUnique">{{ number_format($total, 0) }}</span></div>
                            </div>

                            <button type="submit" class="btn-pay-unique">COMPLETE BOOKING <i class="fas fa-chevron-right ms-2"></i></button>
                        </div>

                        {{-- Premium Coupon Unique --}}
                        @if($coupons->count() > 0)
                        <div class="coupon-unique shadow-sm">
                            <h6 class="fw-900 mb-3 text-navy">Special Offers Available</h6>
                            <div class="d-flex gap-2 mb-4">
                                <input type="text" class="input-custom py-2" id="couponInput" placeholder="PROMO CODE">
                                <button type="button" class="btn btn-primary fw-900 px-4 rounded-4" onclick="applyCoupon()">APPLY</button>
                            </div>
                            <div id="couponMessage" class="small fw-800 mb-3 d-none text-center"></div>

                            @foreach($coupons as $coupon)
                            <div class="coupon-tag-unique" onclick="setCoupon('{{ $coupon->code }}')">
                                <div>
                                    <div class="coupon-code-unique">{{ $coupon->code }}</div>
                                    <div class="small text-muted fw-600 mt-1">{{ $coupon->description }}</div>
                                </div>
                                <i class="fas fa-plus-circle text-primary"></i>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="text-center mt-5">
                            <p class="text-muted small fw-600"><i class="fas fa-shield-alt text-success me-2"></i> 256-bit SSL Secure Checkout</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let baseAmount = {{ $rate['sellingRate'] ?? 0 }};
    
    function setCoupon(code) {
        document.getElementById('couponInput').value = code;
        applyCoupon();
    }

    async function applyCoupon() {
        const code = document.getElementById('couponInput').value;
        const msg = document.getElementById('couponMessage');
        
        if(!code) return;

        try {
            const response = await fetch('{{ route("hotel.coupon.apply") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            });
            const data = await response.json();

            msg.classList.remove('d-none', 'text-success', 'text-danger');
            msg.innerText = data.message;
            msg.classList.add(data.success ? 'text-success' : 'text-danger');

            if (data.success) {
                let discount = 0;
                if (data.discount_type === 'percentage') {
                    discount = (baseAmount * data.discount_amount) / 100;
                } else {
                    discount = data.discount_amount;
                }

                const finalTotal = baseAmount - discount;

                // Update UI
                document.getElementById('discountRowUnique').style.display = 'flex';
                document.getElementById('discountValUnique').innerText = Math.round(discount).toLocaleString();
                document.getElementById('totalDisplayUnique').innerText = Math.round(finalTotal).toLocaleString();

                // Update Hidden Inputs
                document.getElementById('hiddenDiscount').value = discount;
                document.getElementById('hiddenFinalTotal').value = finalTotal;
            }
        } catch (err) {
            console.error('Coupon apply error', err);
        }
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Finalize Your Stay — Tripzant')

@section('styles')
<style>
    .checkout-bg { background: #f8fafc; min-height: 100vh; }
    .c-field { border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 12px 18px; font-weight: 600; font-size: 15px; transition: all 0.3s; }
    .c-field:focus { border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); outline: none; }
    .c-label { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; }
    .price-card { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff; border-radius: 24px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .p-item { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; font-weight: 600; opacity: 0.8; }
    .p-total { border-top: 1px dashed rgba(255,255,255,0.2); margin-top: 20px; padding-top: 20px; font-size: 18px; font-weight: 800; opacity: 1; }
    .h-summary-card { border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0; background: #fff; }
    .h-thumb { width: 100%; height: 160px; object-fit: cover; }
    .trust-badge { display: flex; align-items: center; gap: 10px; color: #16a34a; font-size: 13px; font-weight: 700; background: #f0fdf4; padding: 10px 15px; border-radius: 12px; }
    .step-bubble { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 900; font-size: 18px; }
    .btn-confirm { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border: none; width: 100%; padding: 18px; border-radius: 99px; font-weight: 900; font-size: 17px; letter-spacing: 1px; transition: all 0.3s; cursor: pointer; }
    .btn-confirm:hover { background: linear-gradient(135deg, #1d4ed8, #1e3a8a); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(37,99,235,0.4); }
    .btn-confirm:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
</style>
@endsection

@section('content')
<div class="checkout-bg py-5">
    <div class="container">

        {{-- Error Alert --}}
        @if(session('error'))
        <div class="alert alert-danger rounded-4 mb-4 fw-700 shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="alert alert-warning rounded-4 mb-4 shadow-sm">
            <ul class="mb-0 fw-700">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row g-5">
            {{-- LEFT: FORM --}}
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="step-bubble bg-primary text-white shadow">1</div>
                    <h2 class="outfit fw-900 text-navy mb-0">Guest Details</h2>
                </div>

                <form id="bookingForm" action="{{ route('hotel.book') }}" method="POST">
                    @csrf
                    {{-- Hidden fields --}}
                    <input type="hidden" name="rate_key"      value="{{ $rate['rateKey'] ?? '' }}">
                    <input type="hidden" name="total_fare"    value="{{ $rate['sellingRate'] ?? 0 }}">
                    <input type="hidden" name="hotel_name"    value="{{ $booking['name'] ?? '' }}">
                    <input type="hidden" name="hotel_code"    value="{{ $rate['hotelCode'] ?? '' }}">
                    <input type="hidden" name="room_name"     value="{{ $booking['rooms'][0]['name'] ?? '' }}">
                    <input type="hidden" name="board_name"    value="{{ $rate['boardName'] ?? 'Room Only' }}">
                    <input type="hidden" name="checkIn"       value="{{ $params['checkIn'] ?? '' }}">
                    <input type="hidden" name="checkOut"      value="{{ $params['checkOut'] ?? '' }}">
                    <input type="hidden" name="adults"        value="{{ $params['adults'] ?? 2 }}">

                    {{-- Primary Guest --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-900 text-navy mb-0">Primary Guest</h5>
                            <span class="badge bg-light text-primary border px-3 py-2 rounded-pill small fw-800">ROOM 1</span>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-2">
                                <label class="c-label">Title</label>
                                <select name="title" class="form-select c-field">
                                    <option>Mr.</option>
                                    <option>Ms.</option>
                                    <option>Mrs.</option>
                                    <option>Dr.</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="c-label">First Name</label>
                                <input type="text" name="pax_name[0]" class="form-control c-field" required
                                    placeholder="e.g. Gaurav" value="{{ old('pax_name.0', auth()->user()->name ? explode(' ', auth()->user()->name)[0] : '') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="c-label">Surname</label>
                                <input type="text" name="pax_surname[0]" class="form-control c-field" required
                                    placeholder="e.g. Sharma" value="{{ old('pax_surname.0') }}">
                            </div>
                            <div class="col-md-12">
                                <label class="c-label">Email Address <span class="text-danger">*</span> (Voucher will be sent here)</label>
                                <input type="email" name="email" class="form-control c-field" required
                                    placeholder="your@email.com" value="{{ old('email', auth()->user()->email ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="c-label">Phone (Optional)</label>
                                <input type="tel" name="contact_phone" class="form-control c-field"
                                    placeholder="+91 9999 000 000" value="{{ old('contact_phone') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Additional Guests --}}
                    @for($i = 1; $i < ($params['adults'] ?? 2); $i++)
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4">
                        <h5 class="fw-900 text-navy mb-4">Guest {{ $i + 1 }}</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="c-label">First Name</label>
                                <input type="text" name="pax_name[{{ $i }}]" class="form-control c-field" required
                                    value="{{ old("pax_name.{$i}") }}">
                            </div>
                            <div class="col-md-6">
                                <label class="c-label">Surname</label>
                                <input type="text" name="pax_surname[{{ $i }}]" class="form-control c-field" required
                                    value="{{ old("pax_surname.{$i}") }}">
                            </div>
                        </div>
                    </div>
                    @endfor

                    {{-- Trust Badges --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="trust-badge"><i class="fas fa-shield-alt"></i><span>Encrypted & Secure</span></div>
                        </div>
                        <div class="col-md-4">
                            <div class="trust-badge"><i class="fas fa-tag"></i><span>Best Price Guarantee</span></div>
                        </div>
                        <div class="col-md-4">
                            <div class="trust-badge"><i class="fas fa-headset"></i><span>24/7 Support</span></div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="confirmBtn" class="btn-confirm">
                        <span id="confirmBtnText">
                            <i class="fas fa-lock me-2"></i>CONFIRM BOOKING &rarr;
                        </span>
                        <span id="confirmBtnLoader" class="d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>Processing your booking...
                        </span>
                    </button>
                    <p class="text-center text-muted small fw-600 mt-3">
                        By confirming, you agree to our <a href="#" class="text-primary">Terms & Conditions</a>
                    </p>
                </form>
            </div>

            {{-- RIGHT: SUMMARY --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top:100px;">
                    {{-- Hotel Card --}}
                    <div class="h-summary-card shadow-sm mb-4">
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=600&auto=format&fit=crop"
                             class="h-thumb" alt="{{ $booking['name'] ?? 'Hotel' }}">
                        <div class="p-4">
                            <h5 class="fw-900 text-navy mb-1">{{ $booking['name'] ?? 'Selected Hotel' }}</h5>
                            <p class="text-muted small fw-700 mb-4">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                {{ $booking['address'] ?? 'Hotel Location' }}
                            </p>

                            <div class="d-flex align-items-start gap-3 mb-4 p-3 bg-light rounded-4">
                                <div class="text-primary mt-1"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <h6 class="tiny fw-800 text-muted text-uppercase mb-1">Check-in / Check-out</h6>
                                    <div class="small fw-800 text-navy">
                                        {{ date('D, M d Y', strtotime($params['checkIn'] ?? 'today')) }}
                                    </div>
                                    <div class="tiny text-muted fw-700">to</div>
                                    <div class="small fw-800 text-navy">
                                        {{ date('D, M d Y', strtotime($params['checkOut'] ?? 'tomorrow')) }}
                                    </div>
                                    @php
                                        $nights = (strtotime($params['checkOut'] ?? 'tomorrow') - strtotime($params['checkIn'] ?? 'today')) / 86400;
                                    @endphp
                                    <div class="tiny text-muted fw-700 mt-1">{{ max(1, $nights) }} Night(s) · {{ $params['adults'] ?? 2 }} Adult(s)</div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <h6 class="tiny fw-800 text-muted text-uppercase mb-2">Room Details</h6>
                                <div class="p-3 border rounded-4">
                                    <div class="small fw-900 text-navy mb-1">{{ $booking['rooms'][0]['name'] ?? 'Deluxe Room' }}</div>
                                    <div class="badge bg-dark text-white tiny px-2 py-1 rounded">{{ $rate['boardName'] ?? 'Room Only' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Price Card --}}
                    <div class="price-card">
                        <h5 class="outfit fw-900 mb-4">Price Breakdown</h5>
                        @php
                            $total   = (float) ($rate['sellingRate'] ?? 0);
                            $base    = round($total / 1.12, 0);
                            $tax     = $total - $base;
                        @endphp
                        <div class="p-item"><span>Base Fare</span><span>₹{{ number_format($base, 0) }}</span></div>
                        <div class="p-item"><span>Taxes & Fees (12%)</span><span>₹{{ number_format($tax, 0) }}</span></div>
                        <div class="p-item p-total outfit">
                            <span>Total Payable</span>
                            <span class="fs-4">₹{{ number_format($total, 0) }}</span>
                        </div>
                        <div class="mt-3 text-center" style="opacity:0.5; font-size:11px;">
                            <i class="fas fa-info-circle me-1"></i>Price per room per night
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const btn    = document.getElementById('confirmBtn');
    const text   = document.getElementById('confirmBtnText');
    const loader = document.getElementById('confirmBtnLoader');

    // Basic client-side validation
    const name    = document.querySelector('[name="pax_name[0]"]').value.trim();
    const surname = document.querySelector('[name="pax_surname[0]"]').value.trim();
    const email   = document.querySelector('[name="email"]').value.trim();

    if (!name || !surname || !email) {
        e.preventDefault();
        alert('Please fill in all required guest details before confirming your booking.');
        return;
    }

    // Visual loading state
    btn.disabled = true;
    text.classList.add('d-none');
    loader.classList.remove('d-none');
});
</script>
@endsection

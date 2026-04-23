@extends('layouts.app')

@section('title', 'Booking Confirmed — Tripzant')

@section('styles')
<style>
    .confirm-bg { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); min-height: 100vh; padding: 60px 0; }
    .confirm-card { background: #fff; border-radius: 28px; padding: 50px; box-shadow: 0 30px 80px rgba(0,0,0,0.08); max-width: 820px; margin: 0 auto; }
    .success-icon { width: 110px; height: 110px; background: linear-gradient(135deg, #16a34a, #15803d); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; box-shadow: 0 15px 40px rgba(22,163,74,0.3); animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    @keyframes popIn { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    .ref-badge { background: linear-gradient(135deg, #1e3a8a, #1d4ed8); color: #fff; padding: 20px 30px; border-radius: 18px; display: inline-block; }
    .detail-row { display: flex; align-items: center; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f1f5f9; }
    .detail-row:last-child { border-bottom: none; }
    .detail-icon { width: 44px; height: 44px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #2563eb; }
    .detail-label { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
    .detail-value { font-size: 15px; font-weight: 700; color: #1e293b; }
    .action-btn { padding: 14px 32px; border-radius: 99px; font-weight: 800; font-size: 14px; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 10px; }
    .action-btn-primary { background: #1e3a8a; color: #fff; border: 2px solid #1e3a8a; }
    .action-btn-primary:hover { background: #1d4ed8; border-color: #1d4ed8; color: #fff; }
    .action-btn-outline { background: transparent; color: #1e3a8a; border: 2px solid #1e3a8a; }
    .action-btn-outline:hover { background: #1e3a8a; color: #fff; }
    .mock-notice { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 12px; padding: 12px 18px; margin-bottom: 20px; font-size: 13px; font-weight: 700; color: #92400e; }
</style>
@endsection

@section('content')
<div class="confirm-bg">
    <div class="container">
        <div class="confirm-card">

            {{-- Success Icon --}}
            <div class="text-center mb-4">
                <div class="success-icon">
                    <i class="fas fa-check fa-3x text-white"></i>
                </div>
                <h1 class="fw-900 outfit mb-2" style="font-size:42px; color:#0f172a;">Booking Confirmed!</h1>
                <p class="text-muted fw-700 h5 opacity-75 mb-0">Your reservation has been successfully processed.</p>
            </div>

            {{-- Mock Notice (test mode) --}}
            @if(session('is_mock'))
            <div class="mock-notice">
                <i class="fas fa-flask me-2"></i>
                <strong>Test Mode:</strong> This is a simulated booking — HotelBeds API is in test/sandbox mode. All details are valid within Trip Zant's system.
            </div>
            @endif

            {{-- Reference + Status --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="ref-badge text-center w-100">
                        <div style="font-size: 11px; font-weight: 800; opacity: 0.6; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">Booking Reference</div>
                        <div style="font-size: 24px; font-weight: 900; letter-spacing: 2px; font-family: 'Courier New', monospace;">{{ session('reference', 'TZ-' . strtoupper(uniqid())) }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded-4 border text-center h-100 d-flex flex-column justify-content-center" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                        <div style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">Status</div>
                        <div style="font-size: 22px; font-weight: 900; color: #16a34a;">
                            <i class="fas fa-check-circle me-2"></i>CONFIRMED
                        </div>
                        <div class="small fw-600 text-muted mt-2">{{ now()->format('D, M d Y · h:i A') }}</div>
                    </div>
                </div>
            </div>

            {{-- Booking Details --}}
            <div class="p-4 rounded-4 border mb-4" style="background: #fafafa;">
                <h5 class="fw-900 text-navy mb-3" style="font-size: 16px;">
                    <i class="fas fa-hotel me-2 text-primary"></i>Booking Summary
                </h5>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-hotel"></i></div>
                    <div>
                        <div class="detail-label">Hotel</div>
                        <div class="detail-value">{{ session('hotel_name', 'Your Selected Hotel') }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-bed"></i></div>
                    <div>
                        <div class="detail-label">Room Type</div>
                        <div class="detail-value">{{ session('room_name', 'Deluxe Room') }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div class="detail-label">Check-in</div>
                        <div class="detail-value">{{ session('check_in') ? date('D, M d Y', strtotime(session('check_in'))) : '—' }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-calendar-times"></i></div>
                    <div>
                        <div class="detail-label">Check-out</div>
                        <div class="detail-value">{{ session('check_out') ? date('D, M d Y', strtotime(session('check_out'))) : '—' }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="detail-label">Primary Guest</div>
                        <div class="detail-value">{{ session('guest_name', auth()->user()->name ?? '—') }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="detail-label">Voucher Sent To</div>
                        <div class="detail-value">{{ session('contact_email', auth()->user()->email ?? '—') }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-rupee-sign"></i></div>
                    <div>
                        <div class="detail-label">Total Paid</div>
                        <div class="detail-value fw-900 text-primary" style="font-size: 20px;">₹{{ number_format((float) session('total_fare', 0), 2) }}</div>
                    </div>
                </div>
            </div>

            {{-- Info Banner --}}
            <div class="d-flex align-items-center gap-3 p-3 rounded-4 mb-5" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                <i class="fas fa-envelope-open-text text-primary fa-lg flex-shrink-0"></i>
                <div class="small fw-700 text-primary">
                    A confirmation email &amp; booking voucher have been sent to <strong>{{ session('contact_email', auth()->user()->email ?? 'your email') }}</strong>.
                    Keep your reference number handy for check-in.
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('home') }}" class="action-btn action-btn-primary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="{{ route('hotels.index') }}" class="action-btn action-btn-outline">
                    <i class="fas fa-search"></i> Search More Hotels
                </a>
                <a href="{{ route('dashboard.bookings') }}" class="action-btn action-btn-outline">
                    <i class="fas fa-list-alt"></i> My Bookings
                </a>
                <button onclick="shareOnWhatsApp()" class="action-btn" style="background: #25d366; color: #fff; border: 2px solid #25d366;">
                    <i class="fab fa-whatsapp"></i> Share on WhatsApp
                </button>
                <button onclick="window.print()" class="action-btn action-btn-outline">
                    <i class="fas fa-print"></i> Print Voucher
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function shareOnWhatsApp() {
        const hotel = "{{ session('hotel_name') }}";
        const ref = "{{ session('reference') }}";
        const checkIn = "{{ session('check_in') }}";
        
        const text = `*Booking Confirmed!* \uD83C\uDFE8\n\n*Hotel:* ${hotel}\n*Check-in:* ${checkIn}\n*Ref:* ${ref}\n\nBooked via *Tripzant.com*`;
        const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
        window.open(url, '_blank');
    }
</script>
@endsection

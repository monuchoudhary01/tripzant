@extends('layouts.app')

@section('title', 'Booking Successful — Tripzant')

@section('styles')
<style>
    :root {
        --glass: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.5);
        --premium-blue: #0077ff;
        --deep-navy: #002244;
    }

    .confirm-bg { 
        background: radial-gradient(circle at top right, #f0f7ff, #ffffff);
        min-height: 100vh; 
        font-family: 'Outfit', sans-serif;
        padding-bottom: 100px;
    }

    .page-header {
        background: linear-gradient(135deg, var(--deep-navy), #004488);
        padding: 60px 0 120px;
        margin-bottom: -80px;
        color: #fff;
        text-align: center;
    }

    .premium-card {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 32px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.1);
        max-width: 900px;
        margin: 0 auto;
        overflow: hidden;
        animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .success-hero {
        padding: 60px 40px;
        text-align: center;
        background: #fff;
    }

    .success-icon-wrap {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 40px;
        box-shadow: 0 20px 40px rgba(34, 197, 94, 0.3);
        animation: heartBeat 1.5s infinite;
    }

    @keyframes heartBeat {
        0% { transform: scale(1); }
        14% { transform: scale(1.1); }
        28% { transform: scale(1); }
        42% { transform: scale(1.1); }
        70% { transform: scale(1); }
    }

    .ref-container {
        display: flex;
        gap: 20px;
        margin: 40px 0;
    }
    .ref-box {
        flex: 1;
        background: #f8fafc;
        padding: 25px;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        text-align: center;
    }
    .ref-label { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
    .ref-val { font-size: 22px; font-weight: 900; color: var(--deep-navy); letter-spacing: 1px; }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1px;
        background: #f1f5f9;
        border-top: 1px solid #f1f5f9;
    }
    .summary-item {
        background: #fff;
        padding: 30px 40px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .s-icon {
        width: 50px;
        height: 50px;
        background: #f0f7ff;
        color: var(--premium-blue);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .s-label { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
    .s-val { font-size: 16px; font-weight: 800; color: var(--deep-navy); }

    .action-footer {
        padding: 40px;
        background: var(--deep-navy);
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .btn-action {
        padding: 15px 30px;
        border-radius: 99px;
        font-weight: 800;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-action-light { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); }
    .btn-action-light:hover { background: #fff; color: var(--deep-navy); }
    .btn-action-primary { background: var(--premium-blue); color: #fff; box-shadow: 0 10px 20px rgba(0,119,255,0.2); }
    .btn-action-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,119,255,0.3); color: #fff; }

    @media (max-width: 768px) {
        .summary-grid { grid-template-columns: 1fr; }
        .ref-container { flex-direction: column; }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h4 class="outfit fw-800 mb-2 opacity-75">SUCCESSFUL TRANSACTION</h4>
        <h1 class="outfit fw-900">Your trip is officially booked!</h1>
    </div>
</div>

<div class="confirm-bg">
    <div class="container">
        <div class="premium-card">
            
            {{-- Success Hero --}}
            <div class="success-hero">
                <div class="success-icon-wrap">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="outfit fw-900 mb-2" style="font-size: 36px; color: var(--deep-navy);">Booking Confirmed</h2>
                <p class="text-muted fw-600 mb-0">We've sent the confirmation voucher to your email address.</p>

                <div class="ref-container">
                    <div class="ref-box">
                        <div class="ref-label">Booking Reference</div>
                        <div class="ref-val">{{ session('reference', 'TZ-' . strtoupper(uniqid())) }}</div>
                    </div>
                    <div class="ref-box">
                        <div class="ref-label">Payment Status</div>
                        <div class="ref-val text-success"><i class="fas fa-shield-check me-2"></i>SUCCESS</div>
                    </div>
                </div>
            </div>

            {{-- Summary Grid --}}
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="s-icon"><i class="fas fa-hotel"></i></div>
                    <div>
                        <div class="s-label">Hotel Name</div>
                        <div class="s-val">{{ session('hotel_name', 'Svenska Design Hotel') }}</div>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="s-icon"><i class="fas fa-door-open"></i></div>
                    <div>
                        <div class="s-label">Room Category</div>
                        <div class="s-val text-capitalize">{{ session('room_name', 'Superior Room') }}</div>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="s-icon"><i class="fas fa-calendar-day"></i></div>
                    <div>
                        <div class="s-label">Stay Duration</div>
                        <div class="s-val">
                            {{ session('check_in') ? date('d M', strtotime(session('check_in'))) : '—' }} to 
                            {{ session('check_out') ? date('d M Y', strtotime(session('check_out'))) : '—' }}
                        </div>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="s-icon"><i class="fas fa-user-circle"></i></div>
                    <div>
                        <div class="s-label">Primary Guest</div>
                        <div class="s-val">{{ session('guest_name', auth()->user()->name ?? '—') }}</div>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="s-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <div class="s-label">Total Amount Paid</div>
                        <div class="s-val text-primary" style="font-size: 20px;">₹{{ number_format((float) session('total_fare', 0), 2) }}</div>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="s-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-print"></i></div>
                    <div>
                        <div class="s-label">E-Voucher</div>
                        <div class="s-val">Sent via Email</div>
                    </div>
                </div>
            </div>

            {{-- Action Footer --}}
            <div class="action-footer">
                <a href="{{ localized_url('/') }}" class="btn-action btn-action-primary">
                    <i class="fas fa-house"></i> Home
                </a>
                <a href="{{ route('dashboard.bookings') }}" class="btn-action btn-action-light">
                    <i class="fas fa-list-alt"></i> My Bookings
                </a>
                <button onclick="window.print()" class="btn-action btn-action-light">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </button>
                <button onclick="shareOnWhatsApp()" class="btn-action" style="background: #25d366; color: #fff;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </button>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-muted small fw-600">Need help? Contact us at <a href="mailto:support@tripzant.com" class="text-decoration-none">support@tripzant.com</a></p>
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

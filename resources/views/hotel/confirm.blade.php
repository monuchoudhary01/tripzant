@extends('layouts.hotel_master')

@section('title', 'Booking Concluded | Voucher Generation')

@section('styles')
<style>
    .v-hero { padding: 60px; background: #fff; border-radius: 32px; border: 1px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02); max-width: 900px; margin: 0 auto; }
    .v-check { width: 80px; height: 80px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 38px; margin: 0 auto 30px; }
    .v-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; text-align: left; background: #f8fafc; padding: 30px; border-radius: 20px; margin: 40px 0; }
    .btn-download { flex: 1; padding: 18px; border-radius: 16px; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.2s; }
</style>
@endsection

@section('content')
<div class="v-hero">
    <div class="v-check"><i class="fas fa-check"></i></div>
    <div class="text-center">
        <h2 class="outfit fw-900 text-navy mb-2" style="font-size: 44px; letter-spacing: -2px;">Deal Successfully Finalized</h2>
        <p class="text-muted fw-600 mb-0">Booking Reference: <span class="text-primary">#HTL-AU-98122</span> • All payments confirmed from agency wallet.</p>
    </div>

    <div class="v-grid">
        <div>
            <div class="tiny fw-800 text-muted uppercase mb-1">Accommodation</div>
            <div class="fw-800 text-navy">Radisson Blu Plaza</div>
            <div class="tiny text-muted fw-700">Mahipalpur, New Delhi</div>
        </div>
        <div>
            <div class="tiny fw-800 text-muted uppercase mb-1">Stay Period</div>
            <div class="fw-800 text-navy">May 25 - Jun 02</div>
            <div class="tiny text-muted fw-700">8 Nights • 10 Guests</div>
        </div>
        <div>
            <div class="tiny fw-800 text-muted uppercase mb-1">Total Transaction</div>
            <div class="fw-800 text-navy">₹5,00,000.00</div>
            <div class="tiny text-success fw-900">NET PAID <i class="fas fa-check-circle"></i></div>
        </div>
    </div>

    <h6 class="outfit fw-900 text-navy mb-4 text-start">Operation Documents</h6>
    <div class="d-flex gap-3">
        <button class="btn-download btn btn-primary border-0" style="background:#2563eb;" onclick="location.href='{{ route('hotel.voucher') }}'">
            <i class="fas fa-file-pdf"></i> GENERATE HOTEL VOUCHER
        </button>
        <button class="btn-download btn btn-outline-secondary py-3 border-2">
            <i class="fas fa-file-invoice"></i> DOWNLOAD TAX INVOICE
        </button>
    </div>

    <div class="mt-5 text-center">
        <button class="btn btn-link text-muted fw-800 text-decoration-none small" onclick="location.href='{{ route('hotel.dashboard') }}'">
            <i class="fas fa-home me-2"></i> BACK TO DASHBOARD TERMINAL
        </button>
    </div>
</div>
@endsection

@extends('layouts.hotel_master')

@section('title', 'Automation Business Logic | Hotel Partner')

@section('styles')
<style>
    .ps-rule-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 32px; margin-bottom: 25px; display: flex; align-items: flex-start; gap: 24px; transition: 0.2s; }
    .ps-rule-card:hover { border-color: var(--ps-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .ps-rule-icon { width: 56px; height: 56px; border-radius: 14px; background: #f8fafc; color: #101828; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .ps-rule-content { flex-grow: 1; }
    .ps-rule-title { font-size: 16px; font-weight: 800; color: #101828; margin-bottom: 8px; }
    .ps-rule-desc { font-size: 13px; font-weight: 600; color: #667085; line-height: 1.6; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Business Logic Automation</h2>
        <p class="text-muted fw-600 mb-0">Configure rules for automatic booking processing and guest communication.</p>
    </div>
    <button class="ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm">SAVE AUTOMATION SETTINGS</button>
</div>

<div class="row g-4">
    <!-- Rule 1 -->
    <div class="col-md-6">
        <div class="ps-rule-card">
             <div class="ps-rule-icon" style="background:#eef2ff; color:#6366f1;"><i class="fas fa-magic"></i></div>
             <div class="ps-rule-content">
                  <div class="ps-rule-title">Auto-Inventory Adjustment</div>
                  <p class="ps-rule-desc">Instantly decrease total room availability when a confirmed OTA booking is received via Webhook. Also triggers sync to all other channels.</p>
                  <div class="form-check form-switch mt-3"><input class="form-check-input h5" type="checkbox" checked></div>
             </div>
        </div>
    </div>

    <!-- Rule 2 -->
    <div class="col-md-6">
        <div class="ps-rule-card">
             <div class="ps-rule-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-id-card"></i></div>
             <div class="ps-rule-content">
                  <div class="ps-rule-title">Auto-Voucher PDFs</div>
                  <p class="ps-rule-desc">Generate a professional service voucher PDF as soon as a booking is saved in the database. Can be used for internal and external guest records.</p>
                  <div class="form-check form-switch mt-3"><input class="form-check-input h5" type="checkbox" checked></div>
             </div>
        </div>
    </div>

    <!-- Rule 3 -->
    <div class="col-md-6">
        <div class="ps-rule-card">
             <div class="ps-rule-icon" style="background:#dcfce7; color:#22c55e;"><i class="fab fa-whatsapp"></i></div>
             <div class="ps-rule-content">
                  <div class="ps-rule-title">WhatsApp Smart Notifier</div>
                  <p class="ps-rule-desc">Trigger an automated WhatsApp message to the guest's provided number with their Voucher link and Check-in instructions.</p>
                  <div class="form-check form-switch mt-3"><input class="form-check-input h5" type="checkbox" checked></div>
             </div>
        </div>
    </div>

    <!-- Rule 4 -->
    <div class="col-md-6">
        <div class="ps-rule-card">
             <div class="ps-rule-icon" style="background:#e0f2fe; color:#0ea5e9;"><i class="fas fa-envelope-open-text"></i></div>
             <div class="ps-rule-content">
                  <div class="ps-rule-title">Email Confirmation Engine</div>
                  <p class="ps-rule-desc">Send official confirmation emails to both the guest and the property manager with the PDF voucher attached for easy printing.</p>
                  <div class="form-check form-switch mt-3"><input class="form-check-input h5" type="checkbox" checked></div>
             </div>
        </div>
    </div>
</div>
@endsection

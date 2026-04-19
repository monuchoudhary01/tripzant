@extends('layouts.hotel_master')

@section('title', 'Notification & Messaging Templates | Hotel Automation')

@section('styles')
<style>
    .ps-template-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 32px; margin-bottom: 25px; }
    .ps-template-preview { background: #f8fafc; border-radius: 12px; padding: 20px; font-weight: 600; font-size: 13px; color: #1e293b; border: 1px solid #e2e8f0; }
    .ps-template-tag { background: #eef2ff; color: #6366f1; font-weight: 800; font-size: 10px; padding: 4px 10px; border-radius: 6px; margin-right: 5px; cursor: pointer; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Intelligent Messaging Templates</h2>
        <p class="text-muted fw-600 mb-0">Customize automated Email & WhatsApp messages with dynamic guest and booking placeholders.</p>
    </div>
    <div class="d-flex gap-2">
         <button class="btn btn-outline-dark px-4 py-2 small fw-800 border-2 rounded-pill"><i class="fas fa-eye me-2"></i> PREVIEW TEST</button>
         <button class="ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm">PUBLISH TEMPLATES</button>
    </div>
</div>

<div class="row g-5">
    <!-- WhatsApp Template -->
    <div class="col-lg-6">
        <div class="ps-template-card">
             <div class="d-flex items-center gap-3 mb-4">
                  <div style="width: 40px; height: 40px; background:#dcfce7; color:#22c55e; border-radius: 10px; display:flex; align-items:center; justify-content:center; font-size: 20px;"><i class="fab fa-whatsapp"></i></div>
                  <h5 class="outfit fw-900 text-navy mb-0 pt-2">WhatsApp: Confirmation</h5>
             </div>
             
             <div class="mb-4">
                  <label class="small fw-800 text-muted uppercase mb-2">Message Content</label>
                  <textarea rows="6" class="form-control py-3 fw-700 bg-light border-0">Hi @{{guest_name}}, greetings from @{{hotel_name}}! 🌴 Your booking for @{{check_in}} to @{{check_out}} is confirmed. Ref: #@{{booking_id}}. View your voucher here: @{{voucher_url}}. We look forward to welcoming you!</textarea>
             </div>

             <div class="mb-4">
                  <label class="small fw-800 text-muted uppercase mb-2">Dynamic Tags (Double-click to insert)</label>
                  <div class="d-flex flex-wrap gap-2">
                       <span class="ps-template-tag" title="Name of Guest">guest_name</span>
                       <span class="ps-template-tag" title="Hotel Identity">hotel_name</span>
                       <span class="ps-template-tag" title="Check-in Date">check_in</span>
                       <span class="ps-template-tag" title="Check-out Date">check_out</span>
                       <span class="ps-template-tag" title="Unique Booking Ref">booking_id</span>
                       <span class="ps-template-tag" title="Link to PDF Voucher">voucher_url</span>
                  </div>
             </div>
        </div>
    </div>

    <!-- Email Template -->
    <div class="col-lg-6">
        <div class="ps-template-card">
             <div class="d-flex items-center gap-3 mb-4">
                  <div style="width: 40px; height: 40px; background:#e0f2fe; color:#0ea5e9; border-radius: 10px; display:flex; align-items:center; justify-content:center; font-size: 20px;"><i class="fas fa-envelope"></i></div>
                  <h5 class="outfit fw-900 text-navy mb-0 pt-2">Email: Post-Booking Invoice</h5>
             </div>

             <div class="mb-4">
                  <label class="small fw-800 text-muted uppercase mb-2">Email Subject</label>
                  <input type="text" class="form-control py-3 fw-700 bg-light border-0" value="Booking Confirmation - @{{hotel_name}} [#@{{booking_id}}]">
             </div>

             <div class="mb-4">
                  <label class="small fw-800 text-muted uppercase mb-2">Email Body (HTML Editor)</label>
                  <div class="ps-template-preview">
                       <div class="fw-900 mb-3" style="font-size: 18px;">Booking Confirmed!</div>
                       <p class="mb-0">Dear Mr./Ms. @{{guest_name}}, your stay at @{{hotel_name}} is successfully scheduled. Your PDF invoice and voucher is attached to this email for your reference.</p>
                  </div>
             </div>
        </div>
    </div>
</div>
@endsection

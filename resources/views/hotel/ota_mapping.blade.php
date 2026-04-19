@extends('layouts.hotel_master')

@section('title', 'OTA Room Mapping | Hotel Channel Manager')

@section('styles')
<style>
    .ps-mapping-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 32px; margin-bottom: 25px; }
    .ps-mapping-row { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding: 25px 0; }
    .ps-mapping-row:last-child { border-bottom: 0; }
    .ps-mapping-tag { font-size: 10px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 15px; }
    .ps-mapping-label { font-size: 15px; font-weight: 800; color: #1e293b; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">OTA Inventory Mapping</h2>
        <p class="text-muted fw-600 mb-0">Map your CRS room categories at 2-way API level to individual OTA room types.</p>
    </div>
    <select class="form-select border-0 px-4 py-2 rounded-pill fw-800 small ps-3" style="width: 250px;">
        <option>Select OTA: Booking.com</option>
        <option>Select OTA: Agoda</option>
    </select>
</div>

<div class="row g-4 mb-5">
    <!-- Mapping Item 1 -->
    <div class="col-12 ps-mapping-card">
         <div class="ps-mapping-tag">Internal Property Rooms <i class="fas fa-exchange-alt mx-2"></i> Mapping</div>
         
         <div class="ps-mapping-row">
              <div style="flex: 1;">
                   <div class="ps-mapping-label">Superior Twin Room</div>
                   <div class="tiny fw-700 text-muted">ID: #INT-RM-405</div>
              </div>
              <div class="text-center" style="flex: 1;">
                   <i class="fas fa-link text-primary h4 mb-0 opacity-50"></i>
              </div>
              <div style="flex: 1;">
                   <select class="form-select border-0 bg-light rounded-pill fw-800 py-3 small ps-4">
                       <option>Booking.com: Superior King (Non-Smoking)</option>
                       <option>Booking.com: Twin Deluxe (Standard)</option>
                   </select>
                   <div class="tiny fw-800 text-success mt-2 text-end">ACTIVE LINK • <i class="fas fa-check-circle"></i></div>
              </div>
         </div>

         <div class="ps-mapping-row">
              <div style="flex: 1;">
                   <div class="ps-mapping-label">Executive Club Suite</div>
                   <div class="tiny fw-700 text-muted">ID: #INT-RM-9012</div>
              </div>
              <div class="text-center" style="flex: 1;">
                   <i class="fas fa-link text-primary h4 mb-0 opacity-50"></i>
              </div>
              <div style="flex: 1;">
                   <select class="form-select border-0 bg-light rounded-pill fw-800 py-3 small ps-4">
                       <option>Booking.com: Executive Loft Suite (MMT)</option>
                       <option>Booking.com: Presidential Suite (B2B)</option>
                   </select>
                   <div class="tiny fw-800 text-success mt-2 text-end">ACTIVE LINK • <i class="fas fa-check-circle"></i></div>
              </div>
         </div>
    </div>
</div>

<div class="alert alert-warning border-0 rounded-4 p-5 d-flex gap-4 align-items-center shadow-sm">
     <div style="width: 60px; height: 60px; border-radius: 12px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 24px;"><i class="fas fa-exclamation-triangle"></i></div>
     <div>
          <h5 class="outfit fw-900 text-navy mb-1">Unmapped Internal Rooms Detected</h5>
          <p class="small fw-700 text-muted mb-0">"Corporate Twin (Basic)" room is not mapped to any OTA. Bookings from OTAs will not reduce inventory for this room type. Please map or stop sale manually.</p>
     </div>
     <button class="btn btn-warning ms-auto px-5 py-3 rounded-pill fw-900 text-white border-0">START AUTOMAPPING</button>
</div>
@endsection

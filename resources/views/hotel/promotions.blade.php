@extends('layouts.hotel_master')

@section('title', 'Offers & Promotion Engine | Hotel Partner')

@section('styles')
<style>
    .ps-offer-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 30px; margin-bottom: 25px; transition: 0.23s; position: relative; }
    .ps-offer-card:hover { border-color: #6366f1; box-shadow: 0 10px 40px rgba(99,102,241,0.05); transform: translateY(-3px); }
    .ps-offer-type { background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 800; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; margin-bottom: 12px; display: inline-block; }
    .ps-offer-content h4 { font-size: 18px; font-weight: 900; color: #101828; margin-bottom: 8px; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Promotion & Yield Engine</h2>
        <p class="text-muted fw-600 mb-0">Create and distribute specialized offers (Off-season, Early Bird, Last Minute) to boost occupancy.</p>
    </div>
    <button class="ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#createOfferModal"><i class="fas fa-plus me-2"></i> CREATE NEW PROMOTION</button>
</div>

<div class="row g-4 mb-5">
    <!-- Offer 1 -->
    <div class="col-md-6">
        <div class="ps-offer-card h-100">
             <div class="ps-offer-type" style="background:#eef2ff; color:#6366f1;">OFF-SEASON (MONSOON SPECIAL)</div>
             <div class="ps-offer-content">
                  <h4>Monsoon Getaway - 25% Flat Discount</h4>
                  <p class="text-muted small fw-600 mb-4">Applicable on all 5-Star Deluxe properties. Valid for stays between July and September.</p>
                  
                  <div class="row g-3 mb-4 border-top border-bottom py-3">
                       <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Distribution</div><div class="small fw-800 text-navy">All OTA Channels + Direct</div></div>
                       <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Room Constraint</div><div class="small fw-800 text-navy">Superior Twin Categories</div></div>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                       <div class="small fw-800 text-navy">Validity: Till 30 Sep 2024</div>
                       <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                  </div>
             </div>
        </div>
    </div>

    <!-- Offer 2 -->
    <div class="col-md-6">
        <div class="ps-offer-card h-100">
             <div class="ps-offer-type" style="background:#fef9c3; color:#a16207;">LAST MINUTE FLASH</div>
             <div class="ps-offer-content">
                  <h4>48h Flash Sale - Early Bird Fix (Flat ₹1000)</h4>
                  <p class="text-muted small fw-600 mb-4">Book within 48h of check-in. Boost occupancy for unallocated internal inventory.</p>
                  
                  <div class="row g-3 mb-4 border-top border-bottom py-3">
                       <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Distribution</div><div class="small fw-800 text-navy">B2C Website Only</div></div>
                       <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Min Length</div><div class="small fw-800 text-navy">Single Night Stays</div></div>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                       <div class="small fw-800 text-navy">Validity: Lifetime (Active)</div>
                       <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                  </div>
             </div>
        </div>
    </div>
</div>

<!-- CREATE OFFER MODAL -->
<div class="modal fade" id="createOfferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:28px;">
            <div class="modal-header border-0 p-5 pb-0">
                 <h4 class="modal-title outfit fw-900 text-navy">Create New Targeted Promotion</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5 pt-4">
                 <div class="row g-4 mb-4">
                      <div class="col-md-8">
                           <label class="tiny fw-900 uppercase text-muted mb-2">Offer Name (Internal)</label>
                           <input type="text" class="form-control py-3 fw-700 bg-light border-0" placeholder="e.g. Winter Holiday Bonus">
                      </div>
                      <div class="col-md-4">
                           <label class="tiny fw-900 uppercase text-muted mb-2">Promotion Type</label>
                           <select class="form-select py-3 fw-700 bg-light border-0">
                               <option>Off-Season Discount</option>
                               <option>Early Bird Offering</option>
                               <option>Last Minute Flash</option>
                               <option>Extended Stay (3+ Nights)</option>
                           </select>
                      </div>
                      <div class="col-md-6">
                           <label class="tiny fw-900 uppercase text-muted mb-2">Discount Value</label>
                           <div class="input-group">
                                <input type="number" class="form-control py-3 fw-700 bg-light border-0" value="20">
                                <select class="input-group-text bg-light border-0 fw-800">
                                     <option>% OFF</option>
                                     <option>FLAT OFF (₹)</option>
                                </select>
                           </div>
                      </div>
                      <div class="col-md-6">
                           <label class="tiny fw-900 uppercase text-muted mb-2">Validity Date Range</label>
                           <input type="text" class="form-control py-3 fw-700 bg-light border-0" placeholder="Pick start & end date">
                      </div>
                      <div class="col-12">
                           <label class="tiny fw-900 uppercase text-muted mb-2">Available Channels</label>
                           <div class="d-flex gap-3">
                                <div class="form-check p-3 border rounded-3"><input class="form-check-input" type="checkbox" checked><label class="form-check-label small fw-700 ms-2">Booking.com</label></div>
                                <div class="form-check p-3 border rounded-3"><input class="form-check-input" type="checkbox" checked><label class="form-check-label small fw-700 ms-2">Agoda</label></div>
                                <div class="form-check p-3 border rounded-3"><input class="form-check-input" type="checkbox" checked><label class="form-check-label small fw-700 ms-2">Direct B2C</label></div>
                           </div>
                      </div>
                 </div>
                 <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 border-0 mt-3 shadow-sm" style="background:#2563eb;" data-bs-dismiss="modal" onclick="alert('Offer Created & Pushed to Channels Effectively!')">CAMPAIGN GO-LIVE</button>
            </div>
        </div>
    </div>
</div>
@endsection

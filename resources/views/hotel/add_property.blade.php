@extends('layouts.hotel_master')

@section('title', 'Property Onboarding | Hotel Super Panel')

@section('styles')
<style>
    .ps-setup-card { background: #fff; border-radius: 24px; border: 1px solid var(--ps-border); padding: 40px; margin-bottom: 30px; }
    .ps-setup-title { font-size: 20px; font-weight: 900; color: #101828; margin-bottom: 25px; border-bottom: 1px solid #f2f4f7; padding-bottom: 15px; }
    .ps-form-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; margin-bottom: 10px; display: block; }
    .ps-form-control { background: #f9fafb; border: 1px solid #eaecf0; border-radius: 12px; padding: 15px; font-weight: 700; color: #1d2939; font-size: 14px; transition: 0.2s; }
    .ps-form-control:focus { background: #fff; border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); outline: none; }
    
    .ps-add-btn { background: #eef2ff; color: #4338ca; border: 0; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 13px; transition: 0.2s; }
    .ps-add-btn:hover { background: #e0f2fe; color: #0ea5e9; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Onboard New Property</h2>
        <p class="text-muted fw-600 mb-0">Register your hotel and setup its inventory for global OTA and Direct distributions.</p>
    </div>
    <div class="d-flex gap-3">
         <button class="btn btn-outline-dark px-4 py-3 rounded-pill fw-800 border-2" data-bs-toggle="modal" data-bs-target="#bulkImportModal"><i class="fas fa-file-import me-2"></i> BULK IMPORT</button>
         <button class="btn btn-light px-5 py-3 rounded-pill fw-800 border-0">SAVE AS DRAFT</button>
         <button class="ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm" onclick="alert('Property Provisioned Successfully! Redirecting to Inventory Calendar...')">PUBLISH PROPERTY</button>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- 1. Property Identity -->
        <div class="ps-setup-card border-0 shadow-sm">
             <div class="ps-setup-title">1. Essential Identity & Branding</div>
             <div class="row g-4 mb-4 text-center">
                   <div class="col-12">
                        <div class="ratio ratio-21x9 bg-light rounded-4 border-2 border-dashed d-flex align-items-center justify-content-center cursor-pointer" style="overflow: hidden; border-color: #d0d5dd;">
                             <div class="text-center p-5">
                                  <i class="fas fa-image text-muted h1 mb-2 opacity-25"></i>
                                  <div class="fw-800 text-muted small">Upload Property Main Cover (Banner)</div>
                             </div>
                        </div>
                   </div>
             </div>
             <div class="row g-4">
                  <div class="col-md-8">
                       <label class="ps-form-label">Commercial Property Name</label>
                       <input type="text" class="ps-form-control w-100" placeholder="e.g. Radisson Blu Plaza Hub">
                  </div>
                  <div class="col-md-4">
                       <label class="ps-form-label">Classification (Stars)</label>
                       <select class="ps-form-control w-100">
                           <option>5 Star (Luxury)</option>
                           <option>4 Star (Premium)</option>
                           <option>3 Star (Standard)</option>
                           <option>Boutique / Heritage</option>
                       </select>
                  </div>
                  <div class="col-12">
                       <label class="ps-form-label">Operational Address</label>
                       <textarea rows="3" class="ps-form-control w-100" placeholder="Full street address with GPS landmarks..."></textarea>
                  </div>
             </div>
        </div>

        <!-- 2. Room Inventory Setup -->
        <div class="ps-setup-card border-0 shadow-sm">
             <div class="ps-setup-title d-flex justify-content-between align-items-center">
                  <span>2. Room Categories & Inventory</span>
                  <button class="ps-add-btn">+ ADD NEW ROOM TYPE</button>
             </div>
             <div class="table-responsive">
                  <table class="table align-middle">
                       <thead>
                            <tr class="ps-form-label">
                                 <th>Category Name</th>
                                 <th>Total Units</th>
                                 <th>Base Price / Night</th>
                                 <th>Max Pax</th>
                                 <th></th>
                            </tr>
                       </thead>
                       <tbody class="fw-700">
                            <tr>
                                 <td><input type="text" class="ps-form-control ps-2 py-2" value="Deluxe Twin Suite"></td>
                                 <td style="width: 120px;"><input type="number" class="ps-form-control ps-2 py-2" value="10"></td>
                                 <td style="width: 180px;">
                                      <div class="input-group">
                                           <span class="input-group-text bg-transparent border-0 pe-1">₹</span>
                                           <input type="text" class="ps-form-control border-0 bg-transparent ps-0 py-2" value="8,500">
                                      </div>
                                 </td>
                                 <td style="width: 100px;"><input type="number" class="ps-form-control ps-2 py-2" value="2"></td>
                                 <td class="text-end"><button class="btn btn-link text-danger"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                       </tbody>
                  </table>
             </div>
        </div>

        <!-- 3. Amenities & Facilities -->
        <div class="ps-setup-card border-0 shadow-sm">
             <div class="ps-setup-title">3. Curated Amenities</div>
             <div class="row g-3">
                  @foreach(['Ultra High-Speed WiFi', 'Infinity Pool', '24h Concierge', 'Business Hub', 'Gym & Spa', 'Airport Lounge Access', 'Mini Bar included'] as $amenity)
                  <div class="col-md-4">
                       <div class="form-check p-3 rounded-3 border bg-light bg-opacity-10 d-flex align-items-center gap-2">
                           <input class="form-check-input ms-0" type="checkbox" checked>
                           <label class="form-check-label small fw-800 text-navy">{{ $amenity }}</label>
                       </div>
                  </div>
                  @endforeach
             </div>
        </div>
    </div>

    <!-- Right Sidebar Configuration -->
    <div class="col-lg-4">
        <!-- Meal Plans -->
        <div class="ps-setup-card border-0 shadow-sm">
             <div class="ps-setup-title">Meal Plans (Standard)</div>
             <div class="d-flex flex-column gap-3">
                  <div class="form-check p-3 border rounded-4 bg-light">
                       <input class="form-check-input ms-0" type="checkbox" checked>
                       <label class="form-check-label fw-800 text-navy ms-2">CP (Breakfast Included)</label>
                  </div>
                  <div class="form-check p-3 border rounded-4">
                       <input class="form-check-input ms-0" type="checkbox">
                       <label class="form-check-label fw-800 text-navy ms-2">MAP (Half Board - Dinner)</label>
                  </div>
                  <div class="form-check p-3 border rounded-4 opacity-50">
                       <input class="form-check-input ms-0" type="checkbox">
                       <label class="form-check-label fw-800 text-navy ms-2">AP (Full Board - All Meals)</label>
                  </div>
             </div>
        </div>

        <!-- Distribution Network -->
        <div class="ps-setup-card border-0 shadow-sm">
             <div class="ps-setup-title">Activation Channels</div>
             <p class="tiny fw-700 text-muted mb-4">Select which platforms will receive this property's live data instantly.</p>
             <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                  <div class="d-flex align-items-center gap-3">
                       <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Booking.com_logo.svg" width="30">
                       <span class="fw-900 text-navy">Booking.com</span>
                  </div>
                  <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
             </div>
             <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                  <div class="d-flex align-items-center gap-3">
                       <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Agoda_logo.svg/2560px-Agoda_logo.svg.png" width="30">
                       <span class="fw-900 text-navy">Agoda</span>
                  </div>
                  <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
             </div>
             <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-3">
                       <div class="bg-primary rounded p-1" style="width: 30px; height: 30px;"><i class="fas fa-globe text-white small"></i></div>
                       <span class="fw-900 text-navy">Direct Website (B2C)</span>
                  </div>
                  <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
             </div>
        </div>
    </div>
</div>

<!-- BULK IMPORT MODAL -->
<div class="modal fade" id="bulkImportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:28px;">
            <div class="modal-header border-0 p-5 pb-0">
                 <h4 class="modal-title outfit fw-900 text-navy">Bulk Property Onboarding</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5">
                 <div class="alert alert-primary border-0 rounded-4 p-4 mb-4" style="background:#eef2ff;">
                      <h6 class="tiny fw-900 uppercase text-navy mb-2"><i class="fas fa-download me-1"></i> Step 1: Download Sample Format</h6>
                      <p class="small fw-700 text-muted mb-3">Download our pre-formatted spreadsheet to list multiple properties with inventory and meal plans.</p>
                      <div class="d-flex gap-2">
                           <button class="btn btn-white btn-sm px-3 rounded-pill fw-800 border-0 shadow-sm"><i class="fas fa-file-excel text-success me-1"></i> EXCEL SAMPLE</button>
                           <button class="btn btn-white btn-sm px-3 rounded-pill fw-800 border-0 shadow-sm"><i class="fas fa-file-csv text-muted me-1"></i> CSV SAMPLE</button>
                           <button class="btn btn-white btn-sm px-3 rounded-pill fw-800 border-0 shadow-sm"><i class="fas fa-file-pdf text-danger me-1"></i> MANUAL PDF</button>
                      </div>
                 </div>

                 <h6 class="tiny fw-900 uppercase text-navy mb-3"><i class="fas fa-upload me-1"></i> Step 2: Upload Your File</h6>
                 <div class="border-2 border-dashed rounded-4 p-5 text-center bg-light cursor-pointer" style="border-color: #d0d5dd;">
                      <i class="fas fa-cloud-upload-alt h2 text-muted opacity-25 mb-3"></i>
                      <div class="fw-800 text-navy mb-1">Drag & Drop or Click to Browse</div>
                      <div class="tiny fw-700 text-muted">Supports .xlsx, .csv, and batch .pdf uploads</div>
                 </div>

                 <div class="mt-5">
                      <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 border-0 shadow-sm" style="background:#2563eb;" onclick="alert('Bulk validation started! Your 10 properties will be imported shortly.')">START BATCH IMPORT</button>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection

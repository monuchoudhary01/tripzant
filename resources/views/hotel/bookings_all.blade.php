@extends('layouts.hotel_master')

@section('title', 'Master Reservation Terminal | Hotel Hub')

@section('styles')
<style>
    .ps-booking-table-card { background: #fff; border-radius: 24px; border: 1px solid var(--ps-border); padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.01); }
    .ps-booking-table th { background: #f9fafb; border-bottom: 2px solid var(--ps-border); padding: 20px 15px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.8px; }
    .ps-booking-table td { padding: 25px 15px; border-bottom: 1px solid #f2f4f7; font-weight: 700; color: #1d2939; vertical-align: middle; }
    
    .source-ic { width: 24px; height: 24px; border-radius: 4px; object-fit: contain; }
    .ps-action-btn { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; border: 1px solid #e2e8f0; background: #fff; color: #64748b; transition: 0.2s; text-decoration: none; }
    .ps-action-btn:hover { background: #f8fafc; color: var(--ps-accent); border-color: var(--ps-accent); }
    .ps-action-btn.btn-wa:hover { background: #dcfce7; color: #22c55e; border-color: #22c55e; }
    .ps-action-btn.btn-mail:hover { background: #e0f2fe; color: #0ea5e9; border-color: #0ea5e9; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Reservation Management Terminal</h2>
        <p class="text-muted fw-600 mb-0">Master control for all reservations coming from OTAs, Corporate partners, or Direct walk-ins.</p>
    </div>
    <div class="d-flex gap-2">
         <div class="input-group" style="width: 250px;">
              <span class="input-group-text bg-light border-0"><i class="fas fa-filter small text-muted"></i></span>
              <select class="form-select border-0 bg-light fw-800 small py-2">
                  <option>STATUS: ALL BOOKINGS</option>
                  <option>OTA: BOOKING.COM</option>
                  <option>OTA: AGODA</option>
              </select>
         </div>
         <button class="ps-btn-primary px-4 py-2 small fw-800 border-0 rounded-pill"><i class="fas fa-file-excel me-1"></i> EXPORT REPORT</button>
    </div>
</div>

<!-- Automation Notice Banner -->
<div class="alert alert-primary border-0 shadow-sm d-flex align-items-center gap-3 p-4 mb-5" style="border-radius: 20px; background: linear-gradient(135deg, #eef2ff, #f9fafb); border-left: 5px solid #6366f1 !important;">
     <div style="background: #fff; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #6366f1; box-shadow: 0 4px 10px rgba(0,0,0,0.05);"><i class="fas fa-robot"></i></div>
     <div>
          <h6 class="outfit fw-900 text-navy mb-1">Your Automation Engine is Active</h6>
          <p class="small fw-700 text-muted mb-0">All bookings and leads shown below are being processed in real-time by your **Automation Business Rules**. Inventory reduction and voucher generation are now fully automated.</p>
     </div>
     <a href="{{ route('hotel.automation-rules') }}" class="btn btn-outline-primary ms-auto px-4 py-2 rounded-pill small fw-800 border-2">REVIEW RULES</a>
</div>

<div class="ps-booking-table-card">
    <div class="table-responsive">
        <table class="table ps-booking-table w-100 mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 300px;">Guest & Source</th>
                    <th>Stay Details</th>
                    <th>Total Valuation</th>
                    <th>Automation Status</th>
                    <th class="text-end">Service Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Booking Item 1 -->
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                             <img src="https://ui-avatars.com/api/?name=Mark+Sydney&background=eef2ff&color=4338ca&bold=true" class="rounded-pill" width="45">
                             <div>
                                  <div class="fw-900 text-navy">Mark Sydney (Australia)</div>
                                  <div class="d-flex align-items-center gap-2 mt-1">
                                       <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Booking.com_logo.svg" class="source-ic">
                                       <span class="tiny fw-800 text-muted uppercase">Ref: #BK-1022</span>
                                  </div>
                             </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-800 text-navy">25 May - 02 Jun (8 Nights)</div>
                        <div class="tiny text-muted fw-700">Superior Twin (Room 405)</div>
                    </td>
                    <td>
                        <div class="fw-900 text-navy">₹5,00,000.00</div>
                        <span class="badge bg-success px-2 py-1 rounded-pill fw-900" style="font-size: 9px;">PREPAID</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                             <span class="badge bg-light text-primary p-2 rounded fw-800" style="font-size: 9px;"><i class="fas fa-check-circle me-1"></i> VOUCHER GENERATED</span>
                             <span class="badge bg-light text-success p-2 rounded fw-800" style="font-size: 9px;"><i class="fab fa-whatsapp me-1"></i> SENT ON WA</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end gap-2">
                             <a href="{{ route('hotel.voucher') }}" class="ps-action-btn" title="View/Download Voucher"><i class="fas fa-file-pdf"></i></a>
                             <a href="javascript:void(0)" class="ps-action-btn btn-wa" title="Resend WhatsApp Confirmation" data-bs-toggle="modal" data-bs-target="#notifModal"><i class="fab fa-whatsapp"></i></a>
                             <a href="javascript:void(0)" class="ps-action-btn btn-mail" title="Email Invoice/Receipt" data-bs-toggle="modal" data-bs-target="#notifModal"><i class="far fa-envelope"></i></a>
                             <a href="{{ route('hotel.details') }}" class="ps-action-btn" title="Open Chat Negotiation"><i class="fas fa-comments"></i></a>
                        </div>
                    </td>
                </tr>

                <!-- Booking Item 2 -->
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                             <img src="https://ui-avatars.com/api/?name=Sarah+Jones&background=f0fdf4&color=16a34a&bold=true" class="rounded-pill" width="45">
                             <div>
                                  <div class="fw-900 text-navy">Sarah Jones (United States)</div>
                                  <div class="d-flex align-items-center gap-2 mt-1">
                                       <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Agoda_logo.svg/2560px-Agoda_logo.svg.png" class="source-ic">
                                       <span class="tiny fw-800 text-muted uppercase">Ref: #AG-988</span>
                                  </div>
                             </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-800 text-navy">12 Jun - 14 Jun (2 Nights)</div>
                        <div class="tiny text-muted fw-700">Executive Suite (Room 901)</div>
                    </td>
                    <td>
                        <div class="fw-900 text-navy">₹24,500.00</div>
                        <span class="badge bg-warning text-dark px-2 py-1 rounded-pill fw-900" style="font-size: 9px;">PAY AT HOTEL</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                             <span class="badge bg-light text-muted p-2 rounded fw-800" style="font-size: 9px;"><i class="fas fa-envelope me-1"></i> PENDING MAIL</span>
                             <span class="badge bg-light text-danger p-2 rounded fw-800" style="font-size: 9px;"><i class="fas fa-exclamation-circle me-1"></i> LACKING WA REF.</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end gap-2">
                             <a href="javascript:void(0)" class="ps-action-btn" title="View Booking Summary" data-bs-toggle="modal" data-bs-target="#viewBookingModal"><i class="fas fa-eye"></i></a>
                             <a href="javascript:void(0)" class="ps-action-btn btn-wa opacity-25" style="pointer-events: none;" title="WhatsApp (Disabled)"><i class="fab fa-whatsapp"></i></a>
                             <a href="javascript:void(0)" class="ps-action-btn btn-mail" title="Try Resending Email" data-bs-toggle="modal" data-bs-target="#notifModal"><i class="far fa-envelope"></i></a>
                             <button class="btn btn-sm btn-dark fw-900 px-4 rounded-pill border-0 small" data-bs-toggle="modal" data-bs-target="#checkInModal">START CHECK-IN</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- NOTIFICATION MODAL -->
<div class="modal fade" id="notifModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;">
            <div class="modal-body p-5 text-center">
                 <div style="width: 70px; height: 70px; background: #eef2ff; color: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 24px;"><i class="fas fa-paper-plane"></i></div>
                 <h4 class="outfit fw-900 text-navy mb-2">Resend Notification?</h4>
                 <p class="text-muted fw-600 mb-4">Are you sure you want to trigger a manual resend of the automated voucher and confirmation details to this guest?</p>
                 <div class="d-flex gap-3">
                      <button class="btn btn-light w-100 py-3 rounded-pill fw-800 border-0" data-bs-dismiss="modal">CANCEL</button>
                      <button class="btn btn-primary w-100 py-3 rounded-pill fw-800 border-0 shadow-sm" style="background:#2563eb;" data-bs-dismiss="modal" onclick="alert('Notification Triggered Successfully!')">CONFIRM SEND</button>
                 </div>
            </div>
        </div>
    </div>
</div>

<!-- CHECK IN MODAL -->
<div class="modal fade" id="checkInModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:28px;">
            <div class="modal-header border-0 p-5 pb-0">
                 <h4 class="modal-title outfit fw-900 text-navy">Digital Check-in Terminal</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5">
                 <div class="row g-4 overflow-auto" style="max-height: 400px;">
                      <div class="col-md-6">
                           <label class="form-label small fw-800 text-muted uppercase">ID Type</label>
                           <select class="form-select border-0 bg-light py-3 fw-700">
                               <option>Passport / International ID</option>
                               <option>Aadhar Card (India)</option>
                           </select>
                      </div>
                      <div class="col-md-6">
                           <label class="form-label small fw-800 text-muted uppercase">Document No.</label>
                           <input type="text" class="form-control border-0 bg-light py-3 fw-700" placeholder="Enter ID number">
                      </div>
                      <div class="col-12">
                           <label class="form-label small fw-800 text-muted uppercase">Assign Room Number</label>
                           <select class="form-select border-0 bg-light py-3 fw-700">
                               <option>Room 405 (Superior Twin)</option>
                               <option>Room 406 (Superior Twin)</option>
                               <option>Room 901 (Executive Suite)</option>
                           </select>
                      </div>
                      <div class="col-12">
                            <div class="alert alert-info border-0 rounded-4 fw-700 small py-3">
                                <i class="fas fa-info-circle me-1"></i> Guest has already paid the total booking value (₹24,500.00). Keep ID copy for house records.
                            </div>
                      </div>
                 </div>
                 <button class="btn btn-dark w-100 py-3 rounded-pill fw-900 border-0 mt-5" data-bs-dismiss="modal" onclick="alert('Guest Checked-in Successfully! Room Key Assigned.')">COMPLETE CHECK-IN & ACTIVATE KEY</button>
            </div>
        </div>
    </div>
</div>

<!-- VIEW BOOKING SUMMARY MODAL -->
<div class="modal fade" id="viewBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:28px;">
            <div class="modal-header border-0 p-5 pb-0">
                 <h4 class="modal-title outfit fw-900 text-navy">Reservation Detail Monitor</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5 pt-4">
                 <div class="row g-4 mb-4">
                      <div class="col-md-7">
                           <div class="bg-light p-4 rounded-4 border-0">
                                <h6 class="tiny fw-900 uppercase text-muted mb-3">Guest Contact Details</h6>
                                <div class="fw-800 text-navy mb-1" style="font-size: 16px;">Sarah Jones</div>
                                <div class="small fw-700 text-muted mb-1"><i class="fas fa-envelope me-1"></i> s.jones@example.com</div>
                                <div class="small fw-700 text-muted"><i class="fas fa-phone me-1"></i> +1 202-555-0144</div>
                           </div>
                      </div>
                      <div class="col-md-5">
                           <div class="bg-light p-4 rounded-4 border-0 text-center">
                                <h6 class="tiny fw-900 uppercase text-muted mb-2">Booking Origin</h6>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Agoda_logo.svg/2560px-Agoda_logo.svg.png" width="80" class="mb-2">
                                <div class="tiny fw-800 text-navy mb-0">AGODA XML DIRECT</div>
                           </div>
                      </div>
                 </div>

                 <div class="row g-4 mb-5">
                      <div class="col-6">
                           <div class="border-bottom pb-3 mb-3">
                                <div class="tiny fw-900 uppercase text-muted">Stay Period</div>
                                <div class="fw-800 text-navy">12 Jun 2024 - 14 Jun 2024</div>
                           </div>
                           <div>
                                <div class="tiny fw-900 uppercase text-muted">Room Category</div>
                                <div class="fw-800 text-navy">Executive Suite (Room 901)</div>
                           </div>
                      </div>
                      <div class="col-6">
                           <div class="border-bottom pb-3 mb-3">
                                <div class="tiny fw-900 uppercase text-muted">Financial Breakdown</div>
                                <div class="d-flex justify-content-between small fw-700">
                                     <span class="text-muted">Room Cost x 2N</span>
                                     <span class="text-navy">₹21,000.00</span>
                                </div>
                                <div class="d-flex justify-content-between small fw-700">
                                     <span class="text-muted">Taxes (GST 12%)</span>
                                     <span class="text-navy">₹3,500.00</span>
                                </div>
                           </div>
                           <div class="d-flex justify-content-between fw-900 outfit h5 text-navy mb-0">
                                <span>TOTAL VALUATION</span>
                                <span>₹24,500.00</span>
                           </div>
                      </div>
                 </div>

                 <h6 class="tiny fw-900 uppercase text-muted mb-3">Activity Timeline (Automated Logs)</h6>
                 <div class="ps-timeline p-3 bg-light rounded-4">
                      <div class="small fw-700 mb-2 border-start border-primary border-4 ps-3">
                           <span class="text-muted">10:45 AM:</span> Booking confirmed via Agoda Webhook.
                      </div>
                      <div class="small fw-700 mb-0 border-start border-secondary border-4 ps-3 opacity-50">
                           <span class="text-muted">10:46 AM:</span> Inventory updated for Executive Suite category.
                      </div>
                 </div>
            </div>
            <div class="modal-footer border-0 p-5 pt-0 d-flex gap-3">
                 <button class="btn btn-light px-5 py-3 rounded-pill fw-800 border-0" data-bs-dismiss="modal">CLOSE SUMMARY</button>
                 <button class="btn btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm" style="background:#1e293b;" onclick="window.open('{{ route('hotel.voucher') }}', '_blank')">PRINT SERVICE VOUCHER</button>
            </div>
        </div>
    </div>
</div>
@endsection

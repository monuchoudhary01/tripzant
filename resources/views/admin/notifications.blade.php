@extends('layouts.admin')

@section('title', 'Global Notification Gateway | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-8">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <h4 class="fw-900 text-navy mb-5 border-bottom pb-4">SMTP & Email Gateway Gateway</h4>
            
            <form>
                <div class="row g-5">
                    <div class="col-md-9">
                        <label class="form-label fw-800 small text-uppercase opacity-75">SMTP Host Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-server"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="smtp.tripstay.com">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Mail Port</label>
                            <input type="number" class="form-control px-4 py-3 rounded-pill border-light bg-light" value="587">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Default Sender Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="noreply@tripstay.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">SMTP Authentication Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="••••••••••••••••">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Encryption Protocol</label>
                        <select class="form-select border-light bg-light px-4 py-3 rounded-pill fw-bold">
                            <option>TLS (Recommended)</option>
                            <option>SSL (Legacy)</option>
                            <option>None (Insecure)</option>
                        </select>
                    </div>

                    <div class="col-12 mt-5 text-end pt-5 border-top d-flex gap-3 justify-content-end">
                         <button type="button" class="btn btn-outline-navy px-5 py-3 rounded-pill fw-bold shadow-sm"><i class="fas fa-paper-plane me-2"></i> Send Test Email</button>
                        <button class="btn btn-admin-primary px-5 py-3 shadow-lg fs-6 rounded-pill"><i class="fas fa-save me-2"></i> Update SMTP Config <i class="fas fa-check-circle ms-2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-4 text-center">
        <div class="card-admin shadow-sm border-0 p-5 mb-4 bg-white">
             <i class="fas fa-bell text-navy fs-1 mb-4"></i>
             <h4 class="fw-900 text-navy mb-5">Bulk Notification Preferences</h4>
             
             <div class="row g-4 text-start">
                 <div class="col-12">
                     <div class="d-flex justify-content-between align-items-center p-4 bg-light rounded-4">
                         <div>
                             <h6 class="fw-bold mb-0">Email Broadcasts</h6>
                             <p class="text-muted small mb-0">Global notification emails.</p>
                         </div>
                         <div class="form-check form-switch fs-4">
                             <input class="form-check-input" type="checkbox" checked>
                         </div>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="d-flex justify-content-between align-items-center p-4 bg-light rounded-4">
                         <div>
                             <h6 class="fw-bold mb-0">SMS Alerts (OTP)</h6>
                             <p class="text-muted small mb-0">Partner & Customer SMS.</p>
                         </div>
                         <div class="form-check form-switch fs-4">
                             <input class="form-check-input" type="checkbox">
                         </div>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="d-flex justify-content-between align-items-center p-4 bg-light rounded-4 border-dashed border-primary">
                         <div>
                             <h6 class="fw-bold mb-0">Push Notifications</h6>
                             <p class="text-muted small mb-0">Mobile App realtime.</p>
                         </div>
                         <div class="form-check form-switch fs-4">
                             <input class="form-check-input" type="checkbox" checked>
                         </div>
                     </div>
                 </div>
             </div>
        </div>
    </div>
</div>
@endsection

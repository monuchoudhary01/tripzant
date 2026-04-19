@extends('layouts.admin')

@section('title', 'Master Admin Profile | Command Center')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-4 text-center">
        <div class="card-admin shadow-sm border-0 p-5 mb-4 bg-white">
            <div class="admin-avatar-xl mb-4 position-relative mx-auto" style="width:150px;height:150px;">
                <div class="rounded-circle shadow-lg bg-navy text-white d-flex align-items-center justify-content-center fw-900 fs-1 h-100 w-100">MA</div>
                <button class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute bottom-0 end-0 p-2" style="width:40px;height:40px;"><i class="fas fa-camera"></i></button>
            </div>
            <h4 class="fw-900 text-navy mb-1">Master Admin</h4>
            <span class="badge bg-navy text-white rounded-pill px-4 py-2 border-0 fw-bold fs-6 shadow-sm"><i class="fas fa-shield-alt me-2"></i> SUPER USER</span>
            <p class="text-muted small mt-4 fw-bold">Active since 2024 · Trip Zant Corporate HQ</p>
        </div>

        <div class="card-admin shadow-sm border-0 p-5 mb-4 text-start">
             <h6 class="fw-900 text-navy mb-4">Account Metadata</h6>
             <div class="d-flex flex-column gap-3">
                 <div class="d-flex justify-content-between border-bottom pb-2">
                     <span class="text-muted small fw-bold">Last Login</span>
                     <span class="text-navy fw-800" style="font-size:12px;">Apr 02, 2026, 09:12 AM</span>
                 </div>
                 <div class="d-flex justify-content-between border-bottom pb-2">
                     <span class="text-muted small fw-bold">Session IP</span>
                     <span class="text-navy fw-800" style="font-size:12px;">192.168.1.104</span>
                 </div>
                 <div class="d-flex justify-content-between mb-0">
                     <span class="text-muted small fw-bold">Permissions</span>
                     <span class="text-success fw-800" style="font-size:12px;">FULL ACCESS</span>
                 </div>
             </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card-admin shadow-sm border-0 p-5 mb-4">
            <h5 class="fw-900 text-navy mb-5 border-bottom pb-4">Personal Master Settings</h5>
            <form>
                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Admin Full Name</label>
                        <input type="text" class="form-control px-4 py-3 rounded-pill border-light bg-light" value="Master Admin User">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Primary Admin Email</label>
                        <input type="email" class="form-control px-4 py-3 rounded-pill border-light bg-light" value="admin@tripstay.com">
                    </div>

                    <div class="col-12 mt-5 text-end pt-5 border-top">
                        <button class="btn btn-admin-primary px-5 py-3 shadow-lg fs-6 rounded-pill"><i class="fas fa-save me-2"></i> Update Admin Identity <i class="fas fa-check-circle ms-2"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-admin shadow-sm border-0 p-5">
             <h5 class="fw-900 text-navy mb-5 border-bottom pb-4">Security & Authentication</h5>
             <form>
                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Update Password</label>
                        <input type="password" class="form-control px-4 py-3 rounded-pill border-light bg-light" placeholder="New Secure Password">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Confirm New Password</label>
                        <input type="password" class="form-control px-4 py-3 rounded-pill border-light bg-light" placeholder="Confirm Secure Passord">
                    </div>
                    <div class="col-12 mt-5 text-end pt-5 border-top">
                        <button class="btn btn-admin-primary px-5 py-3 shadow-lg fs-6 rounded-pill"><i class="fas fa-lock me-2"></i> Re-secure Primary Account <i class="fas fa-check-circle ms-2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

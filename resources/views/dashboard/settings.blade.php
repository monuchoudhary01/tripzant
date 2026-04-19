@extends('layouts.dashboard')

@section('title', 'Settings | Trip\'Stay')

@section('dashboard_content')
<div class="settings-page">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-900 text-navy mb-1">Account Settings</h4>
            <p class="text-muted small">Manage your account security and preferences.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="dashboard-card shadow-sm border-0 p-4 rounded-4 mb-4 bg-white">
                <h5 class="fw-900 text-navy mb-4"><i class="fas fa-lock me-2 text-primary"></i> Change Password</h5>
                <form action="{{ route('dashboard.settings.password') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label x-small fw-bold text-muted">CURRENT PASSWORD</label>
                        <input type="password" name="current_password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label x-small fw-bold text-muted">NEW PASSWORD</label>
                        <input type="password" name="new_password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label x-small fw-bold text-muted">CONFIRM NEW PASSWORD</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-navy rounded-pill px-5 fw-bold">Update Password</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="dashboard-card shadow-sm border-0 p-4 rounded-4 bg-white">
                <h5 class="fw-900 text-navy mb-4"><i class="fas fa-toggle-on me-2 text-orange"></i> Notification Preferences</h5>
                <form action="{{ route('dashboard.settings.preferences') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
                        <div>
                            <h6 class="fw-800 text-navy mb-1">Email Promotions</h6>
                            <p class="text-muted mb-0 x-small fw-bold">Receive travel deals and curated guides to your email inbox.</p>
                        </div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="email_promo" checked></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
                        <div>
                            <h6 class="fw-800 text-navy mb-1">Trip Alerts</h6>
                            <p class="text-muted mb-0 x-small fw-bold">Get instant SMS and Push alerts for flight and hotel updates.</p>
                        </div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="trip_alerts" checked></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
                        <div>
                            <h6 class="fw-800 text-navy mb-1">B2C Marketing Analysis</h6>
                            <p class="text-muted mb-0 x-small fw-bold">Optimized profiling based on your past search data.</p>
                        </div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="marketing"></div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-navy rounded-pill px-5 fw-bold">Save Preferences</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-lg-12 mt-5 p-4 rounded-5 text-center border-dashed" style="border: 2px dashed #fecaca; background: #fffafb;">
            <h6 class="fw-900 text-danger mb-2">Danger Zone</h6>
            <p class="text-muted x-small fw-bold mb-3">Deleting your account is permanent. All your TripPoints and history will be wiped.</p>
            <form id="deactivateForm" action="{{ route('dashboard.settings.deactivate') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDeactivation()" class="btn btn-outline-danger rounded-pill px-4 fw-bold x-small">Deactivate My Account Permanently</button>
            </form>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 11px; }
    .btn-navy { background: #0b3d61; color:#fff; border-radius: 12px; }
    .btn-navy:hover { background: #001f3f; color:#fff; }
</style>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: "{{ $errors->first() }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    function confirmDeactivation() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action is permanent and cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete My Account',
            cancelButtonText: 'Keep My Account'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deactivateForm').submit();
            }
        });
    }
</script>
@endpush
@endsection

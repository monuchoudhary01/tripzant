@extends('layouts.dashboard')

@section('title', 'My Profile | Trip\'Stay')

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .profile-card { border-radius: 24px !important; border: none !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; }
    .form-control-lg-custom { border-radius: 12px; padding: 12px 18px; border: 1px solid #e2e8f0; font-weight: 600; font-size: 14px; }
    .form-control-lg-custom:focus { border-color: var(--user-primary); box-shadow: 0 0 0 4px rgba(11, 61, 97, 0.05); }
    .premium-gradient-card { 
        background: linear-gradient(135deg, #0b3d61 0%, #001f3f 100%); 
        border-radius: 24px; 
        position: relative; 
        overflow: hidden; 
    }
    .premium-gradient-card::after {
        content: ''; position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; 
        background: rgba(255,255,255,0.05); border-radius: 50%;
    }
</style>
@endsection

@section('dashboard_content')
@php
   $fields = [$user->name, $user->email, $user->phone, $user->address];
   $filled = count(array_filter($fields));
   $completion = round(($filled / count($fields)) * 100);
@endphp

<div class="row mb-5 align-items-center">
    <div class="col-md-8">
        <h4 class="fw-900 text-navy mb-1 ls-1">Account Management</h4>
        <p class="text-muted small mb-0 fw-bold op-7">Seamlessly manage your identity and preferences.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Main Profile Card -->
    <div class="col-lg-8">
        <div class="card profile-card p-4 mb-4 bg-white">
            <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom border-light">
                <div class="position-relative">
                    <div class="avatar-box bg-navy text-white rounded-circle d-flex align-items-center justify-content-center fw-900 fs-2 shadow-lg hvr-grow" style="width: 90px; height: 90px; border: 4px solid #fff;">
                        {{ trim($user->name) ? strtoupper(substr($user->name, 0, 1)) : 'U' }}
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle" style="width: 20px; height: 20px;"></div>
                </div>
                <div>
                    <h5 class="fw-900 text-navy mb-1 fs-4">{{ trim($user->name) ? $user->name : 'Explorer' }}</h5>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="x-small fw-bold text-muted"><i class="fas fa-envelope me-1 text-primary"></i> {{ $user->email }}</span>
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-10 rounded-pill px-3 py-2 fw-900"><i class="fas fa-check-circle me-1"></i> VERIFIED MEMBER</span>
                    </div>
                </div>
            </div>

            <h6 class="fw-900 text-navy mb-4 d-flex align-items-center"><i class="fas fa-user-pen me-2 text-primary fs-5"></i> Personal Information</h6>
            <form class="row g-4" method="POST" action="{{ route('dashboard.profile.update') }}">
                @csrf
                <div class="col-12">
                    <label class="form-label x-small fw-bold text-muted text-uppercase mb-2">Display Name</label>
                    <input type="text" name="name" class="form-control form-control-lg-custom" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label x-small fw-bold text-muted text-uppercase mb-2">Primary Email</label>
                    <input type="email" class="form-control form-control-lg-custom bg-light" value="{{ $user->email }}" disabled readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label x-small fw-bold text-muted text-uppercase mb-2">Mobile Number</label>
                    <input type="text" name="phone" class="form-control form-control-lg-custom" value="{{ old('phone', $user->phone) }}" placeholder="+91 00000 00000">
                </div>
                <div class="col-12">
                    <label class="form-label x-small fw-bold text-muted text-uppercase mb-2">Residential Address</label>
                    <textarea name="address" class="form-control form-control-lg-custom" rows="3" placeholder="Flat No, Street, City, State, Country">{{ old('address', $user->address) }}</textarea>
                </div>
                
                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-navy py-3 px-5 rounded-pill fw-900 shadow-lg hvr-shrink">Update Profile Details</button>
                    <span class="ms-3 text-muted x-small fw-bold"><i class="fas fa-shield-alt me-1 text-success"></i> Data encryption active</span>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Sidebar Stat Card -->
    <div class="col-lg-4">
        <div class="card premium-gradient-card p-4 mb-4 text-white shadow-lg border-0">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-900 mb-0 opacity-75 letter-spacing-1">PROFILE STRENGTH</h6>
                <div class="p-2 bg-white bg-opacity-10 rounded-3"><i class="fas fa-bolt text-warning"></i></div>
            </div>
            <div class="text-center py-3">
                <div class="h1 display-4 fw-900 mb-0 ls-1">{{ $completion }}%</div>
                <div class="x-small opacity-50 fw-900 text-uppercase letter-spacing-1 mt-1">Complete</div>
            </div>
            <div class="mt-4">
                <div class="progress bg-white bg-opacity-10 rounded-pill mb-3" style="height: 10px;">
                    <div class="progress-bar bg-warning shadow-sm" style="width: {{ $completion }}%; box-shadow: 0 0 15px rgba(255,193,7,0.5);"></div>
                </div>
                @if($completion < 100)
                <div class="bg-white bg-opacity-10 p-3 rounded-4 border border-white border-opacity-10">
                    <p class="x-small fw-900 mb-0 text-center opacity-75"><i class="fas fa-unlock-alt me-2 text-warning"></i> Complete info to unlock 1-click booking.</p>
                </div>
                @else
                <div class="bg-success bg-opacity-20 p-3 rounded-4 border border-success border-opacity-20">
                    <p class="x-small fw-900 mb-0 text-center text-success"><i class="fas fa-check-double me-2"></i> Your identity is verified & ready.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Tips Card -->
        <div class="card profile-card p-4 border-0 bg-white shadow-sm mt-4">
            <h6 class="fw-900 text-navy mb-3">Quick Navigation</h6>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('dashboard.bookings') }}" class="btn btn-light border-0 text-start p-3 rounded-4 fw-bold x-small text-navy hvr-forward">
                    <i class="fas fa-suitcase me-2 text-primary"></i> Explore Recent Trips
                </a>
                <a href="{{ route('dashboard.wallet') }}" class="btn btn-light border-0 text-start p-3 rounded-4 fw-bold x-small text-navy hvr-forward">
                    <i class="fas fa-wallet me-2 text-orange"></i> Check Wallet Balance
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Updated!',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false,
        background: '#fff',
        color: '#0b3d61'
    });
    @endif
</script>
@endpush
@endsection

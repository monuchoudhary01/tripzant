@extends('layouts.app')

@section('content')
<div class="pending-area py-5 d-flex align-items-center justify-content-center" style="min-height: 80vh; background: #f8fafc;">
    <div class="container text-center">
        <div class="card border-0 shadow-sm rounded-4 p-5 mx-auto" style="max-width: 600px;">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <h2 class="fw-bold text-dark mb-3">Application Under Review</h2>
            <p class="text-muted fs-5 mb-4">
                Thank you for joining Trip Zant as a Service Provider. Our team is currently reviewing your profile and services.
            </p>
            <div class="bg-light p-4 rounded-3 text-start mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Account Status:</span>
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3">Pending Verification</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Email:</span>
                    <span class="fw-bold text-dark">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <p class="small text-muted mb-4">You will receive an email once your account is approved. After approval, you will get your unique Affiliate Code.</p>
            <a href="{{ route('logout') }}" class="btn btn-outline-secondary px-5 rounded-pill">Logout & Exit</a>
        </div>
    </div>
</div>
@endsection

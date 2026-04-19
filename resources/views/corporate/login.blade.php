@extends('layouts.app')

@section('title', "Corporate Login - Business Travel | Trip Zant")

@section('content')
<div class="corporate-login-bg py-5" style="background: #f8fafc; min-height: 90vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Side: Branding/Info -->
                        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 text-white" style="background: linear-gradient(135deg, var(--navy), #001f3f);">
                            <h2 class="fw-900 mb-4 lh-base text-white">Elevate Your Corporate Travel with Trip Zant</h2>
                            <ul class="list-unstyled d-flex flex-column gap-4">
                                <li class="d-flex gap-3 align-items-center">
                                    <div class="icon-box-sm bg-white bg-opacity-10 rounded-3 p-3"><i class="fas fa-users-gear fs-4 text-warning"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Group Booking Portal</div>
                                        <small class="opacity-75">Coordinate travel for 9+ passengers seamlessly.</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center">
                                    <div class="icon-box-sm bg-white bg-opacity-10 rounded-3 p-3"><i class="fas fa-file-invoice-dollar fs-4 text-success"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Centralized Billing</div>
                                        <small class="opacity-75">GST-ready invoices and automated expense tracking.</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center">
                                    <div class="icon-box-sm bg-white bg-opacity-10 rounded-3 p-3"><i class="fas fa-headset fs-4 text-info"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">24/7 HR Assistance</div>
                                        <small class="opacity-75">Dedicated account managers for emergency support.</small>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Right Side: Login Form -->
                        <div class="col-lg-6 p-5 bg-white">
                            <div class="text-center mb-5">
                                <img src="/img/logo.svg" height="60" alt="Trip Zant Corporate" class="mb-3">
                                <h4 class="fw-900 text-navy mb-1">Corporate Login</h4>
                                <p class="small text-muted fw-bold">Sign in to your business account</p>
                            </div>

                            <form action="{{ route('corporate.dashboard') }}" method="GET">
                                <div class="mb-4">
                                    <label class="form-label small fw-800 text-navy">CORPORATE EMAIL / ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" class="form-control bg-light border-0 py-3" placeholder="hr@yourcompany.com" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-800 text-navy">PASSWORD</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label x-small fw-bold text-muted" for="remember">Remember Company</label>
                                    </div>
                                    <a href="#" class="x-small fw-bold text-primary text-decoration-none">Forgot Password?</a>
                                </div>

                                <button type="submit" class="btn btn-navy w-100 py-3 rounded-pill fw-900 shadow-sm mb-4">ACCESS BUSINESS PORTAL</button>
                                
                                <div class="text-center">
                                    <p class="x-small text-muted fw-bold mb-0">Not a corporate partner yet?</p>
                                    <a href="#" class="small fw-900 text-navy text-decoration-none">Register Your Business <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 11px; }
    .btn-navy { background: var(--navy); color: #fff; border: none; }
    .btn-navy:hover { background: #001f3f; color: #fff; }
</style>
@endsection

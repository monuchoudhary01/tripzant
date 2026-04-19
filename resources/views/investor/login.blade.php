@extends('layouts.app')

@section('title', "Investor Login - Profit Sharing | Trip Zant")

@section('content')
<div class="investor-login-bg py-5" style="background: #f1f5f9; min-height: 90vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Side: Investor Benefits -->
                        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 text-white" style="background: linear-gradient(135deg, #0f172a, #1eccd1);">
                            <h2 class="fw-900 mb-4 lh-base text-white">Join the Global Travel Economy as an Investor.</h2>
                            <p class="opacity-75 mb-5 fw-bold text-white">Earn passive income on every seat booked through your funded wallet. Smart, automated, and high-yield.</p>
                            
                            <ul class="list-unstyled d-flex flex-column gap-4 text-white">
                                <li class="d-flex gap-3 align-items-center">
                                    <div class="icon-box-sm bg-white bg-opacity-10 rounded-3 p-3"><i class="fas fa-hand-holding-dollar fs-4 text-warning"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">₹100 Per Ticket Earning</div>
                                        <small class="opacity-75">Guaranteed referral income for every booking funded.</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center">
                                    <div class="icon-box-sm bg-white bg-opacity-10 rounded-3 p-3"><i class="fas fa-chart-line fs-4 text-info"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Real-Time ROI Tracking</div>
                                        <small class="opacity-75">Watch your investments grow with live analytics.</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center">
                                    <div class="icon-box-sm bg-white bg-opacity-10 rounded-3 p-3"><i class="fas fa-shield-halved fs-4 text-success"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Secure Wallet Protocol</div>
                                        <small class="opacity-75">100% transparent fund deduction and credit cycles.</small>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Right Side: Investor Login Form -->
                        <div class="col-lg-6 p-5 bg-white">
                            <div class="text-center mb-5">
                                <img src="/img/logo.svg" height="60" alt="Trip Zant Investor" class="mb-3">
                                <h4 class="fw-900 text-navy mb-1">Investor Access</h4>
                                <p class="small text-muted fw-bold uppercase">Funding Travel, Generating Wealth</p>
                            </div>

                            <form action="{{ route('investor.dashboard') }}" method="GET">
                                <div class="mb-4">
                                    <label class="form-label small fw-800 text-navy uppercase">Investor ID / Email</label>
                                    <div class="input-group border border-light rounded-4 overflow-hidden">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-id-badge text-muted"></i></span>
                                        <input type="email" class="form-control border-0 py-3" placeholder="investor@tripstay.com" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-800 text-navy uppercase">Private Access Key (PIN)</label>
                                    <div class="input-group border border-light rounded-4 overflow-hidden">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="password" class="form-control border-0 py-3" placeholder="••••••••" required>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-900 shadow-sm mb-4" style="background: #0f172a;">AUTHENTICATE & ENTER</button>
                                
                                <div class="text-center">
                                    <p class="x-small text-muted fw-bold mb-0">Interested in joining our pool?</p>
                                    <a href="#" class="small fw-900 text-primary text-decoration-none">Inquiry Form <i class="fas fa-external-link-alt ms-1"></i></a>
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
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

@extends('layouts.app')

@section('title', "IATA Agent Login - Global Partner Network | Trip Zant")

@section('content')
<div class="agent-login-bg py-5" style="background: #edf2f7; min-height: 90vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden border-top border-5 border-primary">
                    <div class="row g-0">
                        <!-- Left Side: IATA Network Info -->
                        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 text-white" style="background: #1a202c;">
                            <h2 class="fw-900 mb-4 lh-base text-white">Join the Global IATA Partner Ecosystem.</h2>
                            <p class="opacity-75 mb-5 fw-bold text-white small">Bridge the gap with international travel agencies. Issue tickets globally and share profits securely.</p>
                            
                            <ul class="list-unstyled d-flex flex-column gap-3">
                                <li class="d-flex gap-3 align-items-center mb-3">
                                    <div class="icon-box-sm bg-primary rounded-circle p-2"><i class="fas fa-globe fs-5 text-white"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Global IATA Network</div>
                                        <small class="opacity-75">Connect with 50,000+ verified agents worldwide.</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center mb-3">
                                    <div class="icon-box-sm bg-success rounded-circle p-2"><i class="fas fa-handshake fs-5 text-white"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Profit Sharing (B2B)</div>
                                        <small class="opacity-75">Define commission splits per ticketing deal.</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center mb-3">
                                    <div class="icon-box-sm bg-warning rounded-circle p-2"><i class="fas fa-ticket-alt fs-5 text-dark"></i></div>
                                    <div>
                                        <div class="fw-900 mb-0">Cross-Agent Ticketing</div>
                                        <small class="opacity-75">Use partner inventory for direct issuance.</small>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Right Side: Agent Login Form -->
                        <div class="col-lg-6 p-5 bg-white">
                            <div class="text-center mb-5">
                                <img src="/img/logo.svg" height="50" alt="Trip Zant Agent" class="mb-3">
                                <h4 class="fw-900 text-dark mb-1">IATA Partner Login</h4>
                                <p class="small text-muted fw-bold uppercase ls-1">Enterprise Access Only</p>
                            </div>

                            <form action="{{ route('agent.dashboard') }}" method="GET">
                                <div class="mb-4">
                                    <label class="form-label small fw-800 text-dark uppercase ls-1">IATA AGENT ID / EMAIL</label>
                                    <div class="input-group border rounded-4 overflow-hidden shadow-sm">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-user-shield text-muted"></i></span>
                                        <input type="email" class="form-control border-0 py-3 small fw-bold" placeholder="agent881@iataglobal.com" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-800 text-dark uppercase ls-1">PASSWORD / SECURITY TOKEN</label>
                                    <div class="input-group border rounded-4 overflow-hidden shadow-sm">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="password" class="form-control border-0 py-3 small fw-bold" placeholder="••••••••" required>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="iataremember">
                                        <label class="form-check-label x-small fw-bold text-muted" for="iataremember">IATA-Verified Login</label>
                                    </div>
                                    <a href="#" class="x-small fw-bold text-primary text-decoration-none">Reset Access</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-900 shadow-sm mb-4">AUTHENTICATE PARTNERSHIP</button>
                                
                                <div class="text-center">
                                    <p class="x-small text-muted fw-bold mb-0">Need IATA Verification?</p>
                                    <a href="#" class="small fw-900 text-dark text-decoration-none">Partner Inquiry <i class="fas fa-external-link-alt ms-1"></i></a>
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
    .uppercase { text-transform: uppercase; }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection

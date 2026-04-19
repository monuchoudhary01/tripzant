@extends('layouts.app')

@section('title', "BSP Risk Control Hub - IATA Operations")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f0f2f5; min-height: 100vh; font-family: 'Inter', sans-serif;">
    <x-iata-sidebar active="risk-control" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom">
            <div>
                <h2 class="fw-900 text-navy mb-1"><i class="fas fa-shield-virus me-2 text-primary"></i> Automated BSP Risk Hub</h2>
                <p class="text-muted small fw-bold mb-0 uppercase tracking-wider">Real-time Credit Exposure & Remittance Cycle Logic</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="status-indicator">
                    <span class="pulse-green"></span>
                    <span class="small fw-900 text-success">GDS CONNECTED (ACTIVE)</span>
                </div>
            </div>
        </div>

        <!-- BSP Core Metrics -->
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="risk-card p-4 h-100 shadow-sm border-0">
                    <div class="d-flex justify-content-between mb-3 align-items-start">
                        <div class="icon-box bg-primary-subtle text-primary rounded-3 p-2"><i class="fas fa-landmark fs-5"></i></div>
                        <span class="x-small fw-bold text-muted uppercase">Fixed Deposit</span>
                    </div>
                    <h3 class="fw-900 mb-1">₹{{ number_format($stats['deposit']) }}</h3>
                    <p class="x-small text-muted mb-0">IATA Baseline Security</p>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="risk-card p-4 h-100 shadow-sm border-0 bg-navy text-white">
                    <div class="d-flex justify-content-between mb-3 align-items-start">
                        <div class="icon-box bg-white-subtle text-white rounded-3 p-2"><i class="fas fa-chart-line fs-5"></i></div>
                        <span class="x-small fw-bold text-white-50 uppercase">Credit Limit</span>
                    </div>
                    <h3 class="fw-900 mb-1">₹{{ number_format($stats['credit_limit']) }}</h3>
                    <p class="x-small text-white-50 mb-0">Based on History & Trust</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="risk-card p-4 h-100 shadow-sm border-0">
                    <div class="d-flex justify-content-between mb-3 align-items-start">
                        <div class="icon-box bg-warning-subtle text-warning rounded-3 p-2"><i class="fas fa-exclamation-triangle fs-5"></i></div>
                        <span class="x-small fw-bold text-muted uppercase">Sales at Risk</span>
                    </div>
                    <h3 class="fw-900 mb-1 text-navy">₹{{ number_format($stats['sales_at_risk']) }}</h3>
                    @php 
                      $percent = ($stats['sales_at_risk'] / $stats['credit_limit']) * 100;
                    @endphp
                    <div class="progress rounded-pill bg-light mt-2" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: {{ $percent }}%" role="progressbar"></div>
                    </div>
                    <p class="x-small text-muted mt-2 mb-0">{{ round($percent, 1) }}% Exposure Level</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="risk-card p-4 h-100 shadow-sm border-0">
                    <div class="d-flex justify-content-between mb-3 align-items-start">
                        <div class="icon-box bg-danger-subtle text-danger rounded-3 p-2"><i class="fas fa-clock fs-5"></i></div>
                        <span class="x-small fw-bold text-muted uppercase">Next Remittance</span>
                    </div>
                    <h3 class="fw-900 mb-1 text-danger">{{ $stats['days_until_remittance'] }} Days</h3>
                    <p class="x-small text-muted mb-0">Due Date: 10th Apr 2026</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Automated Flow Visualization -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-5 h-100">
                    <h5 class="fw-900 text-navy mb-5 uppercase tracking-wide d-flex align-items-center">
                        <i class="fas fa-cogs me-3 text-primary"></i> Real-time Automation Engine
                        <span class="ms-auto badge bg-primary-subtle text-primary x-small rounded-pill">V.2.0 ACTIVE</span>
                    </h5>

                    <div class="automation-timeline">
                        <div class="timeline-step active">
                            <div class="step-icon"><i class="fas fa-ticket-alt"></i></div>
                            <div class="step-details">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-900 text-navy mb-1 small">Step 1: Ticket Booking & Issuance</h6>
                                    <span class="x-small text-success fw-bold">TRIGGERED <i class="fas fa-check-circle"></i></span>
                                </div>
                                <p class="text-muted small mb-0">Booking via Amadeus → PNR: <strong>RT2W9V</strong> issued. E-Ticket generated instantly.</p>
                                <div class="mt-2 x-small bg-light p-2 rounded">
                                    <code class="text-navy">LOG: [16:40] Ticket #001-92884122 Issued via AI Control Node.</code>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-step">
                            <div class="step-icon bg-warning"><i class="fas fa-balance-scale"></i></div>
                            <div class="step-details">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-900 text-navy mb-1 small">Step 2: Credit Exposure Monitor</h6>
                                    <span class="x-small text-primary fw-bold">VERIFYING <i class="fas fa-spinner fa-spin"></i></span>
                                </div>
                                <p class="text-muted small mb-0">Calculating dynamic impact on Credit Limit (₹10.5 Cr). System verifies "Sales at Risk" vs Deposit.</p>
                            </div>
                        </div>

                        <div class="timeline-step">
                            <div class="step-icon bg-info"><i class="fas fa-file-invoice"></i></div>
                            <div class="step-details">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-900 text-navy mb-1 small">Step 3: BSP Weekly Cycle Sync</h6>
                                    <span class="x-small text-muted fw-bold">PENDING CYCLE</span>
                                </div>
                                <p class="text-muted small mb-0">All tickets issued during Period 14 recorded. BSP Report Auto-Generation scheduled for next Sunday.</p>
                            </div>
                        </div>

                        <div class="timeline-step">
                            <div class="step-icon bg-success"><div class="text-white">₹</div></div>
                            <div class="step-details">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-900 text-navy mb-1 small">Step 4: Auto-Remittance System</h6>
                                    <span class="x-small text-muted fw-bold">IDLE</span>
                                </div>
                                <p class="text-muted small mb-0">System rotation: Using collected customer funds to prep IATA payment buffer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Risk Control Penalties / Rules -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                    <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide text-danger"><i class="fas fa-exclamation-circle me-2"></i> IATA Risk Rules</h6>
                    <div class="risk-rule-box p-3 bg-danger-subtle rounded-3 mb-3 border-start border-danger border-4">
                        <h6 class="fw-900 text-danger mb-1 x-small uppercase">Rule 1: Payment Default</h6>
                        <p class="x-small text-muted mb-0">If weekly settlement fails, all ADM rights and ticketing will be <strong>IMMEDIATELY BLOCKED</strong>.</p>
                    </div>
                    <div class="risk-rule-box p-3 bg-warning-subtle rounded-3 mb-4 border-start border-warning border-4">
                        <h6 class="fw-900 text-warning mb-1 x-small uppercase">Rule 2: Credit Overflow</h6>
                        <p class="x-small text-muted mb-0">If Sales at Risk exceeds ₹10.5 Cr, GDS issuance will be auto-suspended until next payment.</p>
                    </div>

                    <h6 class="fw-900 text-navy mb-3 uppercase tracking-wide x-small">Sub-Agent Wallet Control</h6>
                    <div class="sub-agent-wallet p-3 border rounded-4 d-flex align-items-center gap-3 mb-2">
                        <div class="bg-primary-subtle text-primary rounded-circle p-2 fw-900 x-small" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">B2B</div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-900 small">Main B2B Wallet</h6>
                            <span class="x-small text-muted">Auto-Credit Enabled</span>
                        </div>
                        <h6 class="mb-0 fw-900 text-navy small">₹18.4L</h6>
                    </div>
                    <button class="btn btn-outline-primary w-100 rounded-pill small fw-900 py-3 mt-3 shadow-hover border-2 uppercase tracking-wider">Configure Wallet Thresholds</button>
                    
                    <div class="mt-5 text-center px-3">
                        <div class="p-4 bg-light rounded-4">
                            <span class="d-block x-small fw-bold text-muted uppercase mb-2">Security Hash</span>
                            <code class="x-small text-primary">SHA-256 IATA-BSPV3-99XR41</code>
                            <div class="mt-2 text-muted x-small italic fw-bold"><i class="fas fa-lock me-1"></i> End-to-End Encrypted Settlement</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Automation Logs -->
        <div class="card border-0 shadow-sm rounded-4 mt-5 bg-white p-5 overflow-hidden">
             <div class="d-flex justify-content-between align-items-center mb-5">
                <h6 class="fw-900 text-navy mb-0 uppercase tracking-wide"><i class="fas fa-stream me-3 text-primary"></i> Live Automation Logs</h6>
                <button class="btn btn-navy rounded-pill px-4 x-small fw-900 uppercase">Clear Logs</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">TIMESTAMP</th>
                            <th class="py-3">EVENT</th>
                            <th class="py-3">ACTION TAKEN</th>
                            <th class="py-3">RISK SCORE</th>
                            <th class="py-3 text-end">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td class="text-muted">16:40:12</td>
                            <td class="text-navy fw-900">Ticket Issue Request</td>
                            <td>PNR DEL-2248-X Issued (Amadeus)</td>
                            <td><span class="badge bg-green-subtle text-green">1.2 (SAFE)</span></td>
                            <td class="text-end text-success">SUCCESS <i class="fas fa-check ms-1"></i></td>
                        </tr>
                        <tr class="py-4">
                            <td class="text-muted">16:38:05</td>
                            <td class="text-navy fw-900">Wallet Sweep</td>
                            <td>Aggregated ₹4.2L from Sub-agents</td>
                            <td><span class="badge bg-green-subtle text-green">0.0 (SAFE)</span></td>
                            <td class="text-end text-success">EXECUTED <i class="fas fa-check ms-1"></i></td>
                        </tr>
                        <tr class="py-4">
                             <td class="text-muted">16:35:22</td>
                            <td class="text-navy fw-900">Risk Audit</td>
                            <td>Credit Limit Sweep: 40% Utilized</td>
                            <td><span class="badge bg-warning-subtle text-warning">4.8 (MODERATE)</span></td>
                            <td class="text-end text-primary">COMPLETED <i class="fas fa-search ms-1"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .risk-card { background: #fff; border-radius: 24px; transition: 0.3s; }
    .risk-card:hover { transform: translateY(-5px); }
    .bg-navy { background: #001f3f !important; }
    .text-navy { color: #001f3f !important; }
    .white-subtle { color: rgba(255,255,255,0.7); }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    
    .status-indicator { display: flex; align-items: center; gap: 10px; background: #fff; padding: 10px 20px; border-radius: 50px; border: 1px solid #e2e8f0; }
    .pulse-green { width: 10px; height: 10px; background: #10b981; border-radius: 50%; box-shadow: 0 0 0 rgba(16, 185, 129, 0.4); animation: pulse 2s infinite; }
    
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .automation-timeline { position: relative; padding-left: 50px; }
    .automation-timeline::before { content: ''; position: absolute; left: 19px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; }
    .timeline-step { position: relative; margin-bottom: 40px; }
    .timeline-step .step-icon { 
        position: absolute; left: -50px; width: 40px; height: 40px; background: #3182ce; 
        color: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; 
        z-index: 2; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .timeline-step.active::before { content: ''; position: absolute; left: -50px; width: 40px; height: 40px; background: rgba(49, 130, 206, 0.2); border-radius: 12px; animation: pulse-blue 2s infinite; }
    @keyframes pulse-blue {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.5); opacity: 0; }
    }
    .timeline-step .step-details { background: #f8fafc; padding: 25px; border-radius: 20px; border: 1px solid #edf2f7; transition: 0.3s; }
    .timeline-step:hover .step-details { background: #fff; box-shadow: 0 15px 35px rgba(0,0,0,0.03); transform: translateX(10px); }

    .btn-navy { background: #001f3f; color: #fff; }
    .btn-navy:hover { background: #003366; color: #fff; }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.timeline-step');
        let currentStep = 0;

        function runAutoFlow() {
            if (currentStep >= steps.length) {
                currentStep = 0;
                steps.forEach(s => s.classList.remove('active'));
            }
            
            steps.forEach(s => s.classList.remove('active'));
            steps[currentStep].classList.add('active');
            
            currentStep++;
            setTimeout(runAutoFlow, 5000); // 5 sec intervals
        }

        runAutoFlow();
    });
</script>
@endsection

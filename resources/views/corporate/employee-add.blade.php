@extends('layouts.app')

@section('title', "Add New Employee — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="employee-add" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Onboard New Traveler</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Create an employee profile and assign travel budget permissions.</p>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-xl-8">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 h-100 animate-up">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-user-plus me-2 text-primary"></i> Profile Information Hub</h6>
                        <form action="{{ route('corporate.employees.store') }}" method="POST">
                             @csrf
                             <div class="row g-4 mb-5">
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">FULL NAME (AS PER PASSPORT)</label>
                                     <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Ex: Rahul Khanna">
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">OFFICIAL EMAIL HUB</label>
                                     <input type="email" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="rahul.k@infosys.com">
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">DEPARTMENT UNIT</label>
                                     <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                         <option value="sales">Sales & Marketing</option>
                                         <option value="eng">Product Engineering</option>
                                         <option value="fin">Finance & Ops</option>
                                     </select>
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">ACCESS ROLE ROLE</label>
                                     <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                         <option value="gen">GENERAL TRAVELER</option>
                                         <option value="plus">VIP TRAVELER (PLUS)</option>
                                         <option value="admin">DEPARTMENT ADMIN</option>
                                     </select>
                                 </div>
                             </div>

                             <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-coins me-2 text-warning"></i> Budget & Policy Governance</h6>
                             <div class="row g-4 mb-5">
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">MONTHLY BUDGET CAP (INR)</label>
                                     <input type="number" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Ex: 50,000">
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">KYC DOCUMENT TYPE</label>
                                     <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Ex: PAN / Aadhaar / Passport">
                                 </div>
                             </div>

                             <button type="button" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase mt-4 shadow-lg">FINALIZE ONBOARDING <i class="fas fa-check-circle ms-2"></i></button>
                        </form>
                    </div>
                </div>

                <div class="col-xl-4 sticky-top" style="top: 100px; height: fit-content;">
                     <div class="card border-0 shadow-sm rounded-5 bg-light p-5 h-100 border-dashed border-primary animate-up delay-1">
                         <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide opacity-50 small pe-5">Onboarding Guidelines Hub</h6>
                         <ul class="d-flex flex-column gap-4 small fw-bold text-muted p-0 m-0" style="list-style: none;">
                             <li class="d-flex gap-3"><i class="fas fa-check-circle text-primary mt-1"></i> <span>Employee will receive a secure login link via email.</span></li>
                             <li class="d-flex gap-3"><i class="fas fa-check-circle text-primary mt-1"></i> <span>Auto-approval rules will only apply if budget caps are not exceeded.</span></li>
                             <li class="d-flex gap-3"><i class="fas fa-shield-alt text-primary mt-1"></i> <span>Travel Profile (Passport/FFN) will be auto-synced with GDS inventory.</span></li>
                         </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .bg-light { background: #f1f5f9 !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

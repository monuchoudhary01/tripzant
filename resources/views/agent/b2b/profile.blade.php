@extends('layouts.app')

@section('title', "Agent Profile — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="profile" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Agent Profile Settings</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">KYC Verified Credentials | GDS Mapping Node</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">SAVE PROFILE UPDATES <i class="fas fa-save ms-2"></i></button>
                </div>
            </div>

            <div class="row g-5">
                <!-- Profile Avatar Card -->
                <div class="col-xl-4 text-center">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100">
                        <div class="avatar px-4 py-3 bg-navy text-white rounded-circle shadow-lg mx-auto mb-4 d-flex align-items-center justify-content-center fw-900" style="width:120px; height:120px; font-size: 42px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <h4 class="fw-900 text-navy mb-1">{{ Auth::user()->name }}</h4>
                        <span class="badge bg-green-subtle text-green px-3 py-2 rounded-pill x-small fw-bold uppercase mb-4 tracking-tighter">B2B VERIFIED STATUS Hub</span>
                        <div class="d-flex flex-column gap-3 text-start mt-4 border-top pt-4">
                             <div class="d-flex justify-content-between x-small fw-bold text-muted"><span>AGENT ID:</span><span class="text-navy">#B2B-{{ Auth::user()->id + 5000 }}</span></div>
                             <div class="d-flex justify-content-between x-small fw-bold text-muted"><span>JOINED ON:</span><span class="text-navy">{{ Auth::user()->created_at->format('d M, Y') }}</span></div>
                             <div class="d-flex justify-content-between x-small fw-bold text-muted"><span>PORTAL TYPE:</span><span class="text-navy">PREPAID GDS</span></div>
                        </div>
                    </div>
                </div>

                <!-- KYC & Credentials -->
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mb-5 border-start border-primary border-5">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">KYC Verification & GDS Mapping</h6>
                         <div class="row g-4 mb-4">
                              <div class="col-md-6 text-start">
                                  <label class="x-small fw-900 text-muted uppercase mb-2">AGENCY NAME</label>
                                  <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" value="{{ Auth::user()->name }} Travel Hub" readonly>
                              </div>
                              <div class="col-md-6 text-start">
                                  <label class="x-small fw-900 text-muted uppercase mb-2">EMAIL ADDRESS (PRIMARY)</label>
                                  <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" value="{{ Auth::user()->email }}" readonly>
                              </div>
                         </div>
                         <div class="row g-4 mb-4">
                             <div class="col-md-6 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">IATA CODE (NODE)</label>
                                 <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Not Mapped" value="AMADEUS-A1-{{ Auth::user()->id + 9284 }}" readonly>
                             </div>
                             <div class="col-md-6 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">GST NUMBER</label>
                                 <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="07AABCT1234F1Z1" value="07AABCT1234F1Z1">
                             </div>
                         </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 position-relative overflow-hidden">
                         <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide">Financial Disclosure Policy</h6>
                         <p class="small text-muted mb-0 italic">All wallet balances and transactions are audit-ready for monthly GST filing. Please ensure your GST Number is accurate for Input Tax Credit claims. Change requests require KYC verification from Admin.</p>
                         <div style="position:absolute; right:-20px; top:-20px; width:150px; height:150px; background:radial-gradient(circle, rgba(16,185,129,0.02) 0%, transparent 70%); border-radius:50%;"></div>
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
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
</style>
@endsection

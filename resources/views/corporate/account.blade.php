@extends('layouts.app')

@section('title', "Organization Profile — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="account" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Organization Identity Hub</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Verified Corporate Identity | GDS Accords | Fiscal Hub.</p>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-xl-9">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 h-100 animate-up">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-building me-2 text-primary"></i> Organizational Profile Manifest</h6>
                        <form action="#" method="POST">
                             <div class="row g-4 mb-5">
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">CONSOLIDATED ENTITY NAME</label>
                                     <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" value="INFOSYS LIMITED" disabled>
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">PAN-INDIA GST HUB</label>
                                     <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" value="07AAACI12345Z1">
                                 </div>
                                 <div class="col-md-12 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">FISCAL RESIDENCE OFFICE</label>
                                     <textarea class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" rows="3">Plot No. 44, Electronic City, Hosur Road, Bengaluru, Karnataka 560100</textarea>
                                 </div>
                             </div>

                             <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-key me-2 text-warning"></i> Administrative Access Security</h6>
                             <div class="row g-4 mb-5">
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">DESIGNATED ADMIN EMAIL</label>
                                     <input type="email" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" value="admin-travel@infosys.com">
                                 </div>
                                 <div class="col-md-6 text-start">
                                     <label class="x-small fw-900 text-muted uppercase mb-3">SECURE UPDATE PASSWORD</label>
                                     <input type="password" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="••••••••">
                                 </div>
                             </div>

                             <button type="button" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase mt-4 shadow-lg">UPDATE CORPORATE IDENTITY <i class="fas fa-check-circle ms-2"></i></button>
                        </form>
                    </div>
                </div>

                <div class="col-xl-3 sticky-top" style="top: 100px; height: fit-content;">
                     <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 animate-up delay-1 overflow-hidden position-relative">
                         <div class="position-relative" style="z-index: 2;">
                            <h6 class="fw-900 uppercase opacity-50 x-small mb-4">Verification Artifacts</h6>
                            <div class="d-flex flex-column gap-4">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white rounded-circle p-2 px-3 text-navy"><i class="fas fa-file-pdf"></i></div>
                                     <div class="x-small fw-bold">GSTIN Certificate.pdf</div>
                                 </div>
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white rounded-circle p-2 px-3 text-navy"><i class="fas fa-file-contract"></i></div>
                                     <div class="x-small fw-bold">Organization Acuerdo.pdf</div>
                                 </div>
                            </div>
                            <div class="mt-5 border-top border-white-subtle pt-4 text-center">
                                 <span class="badge bg-green text-white rounded-pill px-3 py-1 fw-bold x-small uppercase shadow-sm">VERIFIED ENTITY <i class="fas fa-shield-alt ms-1"></i></span>
                            </div>
                         </div>
                         <div style="position:absolute; right:-50px; bottom:-50px; width:150px; height:150px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
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
    .bg-green { background: #10b981 !important; }
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .border-white-subtle { border-color: rgba(255,255,255,0.1) !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .delay-1 { animation-delay: 0.1s; }
</style>
@endsection

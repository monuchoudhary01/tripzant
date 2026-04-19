@extends('layouts.app')

@section('title', "Security Settings — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="password" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Agent Account Security</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Update Password | Security Logs | Session Control</p>
                </div>
            </div>

            <div class="row g-5">
                <!-- Change Password Form -->
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-lock me-2 text-primary"></i> Multi-Factor Security Update</h6>
                        <form action="#" method="POST">
                             <div class="mb-4 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">CURRENT PASSWORD</label>
                                 <input type="password" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="••••••••">
                             </div>
                             <div class="mb-4 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">NEW SECURE PASSWORD</label>
                                 <input type="password" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="••••••••">
                             </div>
                             <div class="mb-5 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">CONFIRM NEW PASSWORD</label>
                                 <input type="password" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="••••••••">
                             </div>
                             <button type="button" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-lg">UPDATE SECURITY KEY <i class="fas fa-key ms-2 text-warning"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Security History -->
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 h-100 position-relative overflow-hidden border-start border-warning border-5">
                         <div class="position-relative" style="z-index: 2;">
                             <h6 class="fw-900 mb-5 uppercase tracking-wide opacity-75 text-warning">Recent Login Manifest</h6>
                             <div class="d-flex flex-column gap-4 text-start">
                                  <div class="bg-white-subtle p-3 rounded-4 d-flex justify-content-between align-items-center">
                                      <div class="d-flex align-items-center gap-3">
                                          <div class="icon bg-white text-navy rounded-circle p-2 px-3 fw-900">1</div>
                                          <div>
                                              <h6 class="fw-bold mb-0 small">Chrome via MacOS (Current)</h6>
                                              <span class="x-small opacity-50 fw-bold">LOC: DELHI | IP: 192.168.1.1</span>
                                          </div>
                                      </div>
                                      <span class="badge bg-green text-white x-small fw-bold rounded-pill">ACTIVE</span>
                                  </div>
                                  <div class="bg-white-subtle p-3 rounded-4 d-flex justify-content-between align-items-center opacity-50">
                                      <div class="d-flex align-items-center gap-3">
                                          <div class="icon bg-white text-navy rounded-circle p-2 px-3 fw-900 opacity-50">2</div>
                                          <div>
                                              <h6 class="fw-bold mb-0 small">Safari via iPhone 15</h6>
                                              <span class="x-small opacity-50 fw-bold">LOC: MUMBAI | IP: 192.168.4.2</span>
                                          </div>
                                      </div>
                                      <span class="x-small fw-bold opacity-50">2 HOURS AGO</span>
                                  </div>
                             </div>
                             <div class="mt-5 border-top border-white-subtle pt-4">
                                 <button class="btn btn-link text-warning p-0 x-small fw-900 uppercase text-decoration-none">SIGN OUT FROM ALL DEVICES?</button>
                             </div>
                         </div>
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
    .bg-white-subtle { background: rgba(255,255,255,0.1); }
    .bg-green { background: #10b981 !important; }
    .border-white-subtle { border-color: rgba(255,255,255,0.1) !important; }
</style>
@endsection

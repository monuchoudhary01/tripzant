@extends('layouts.app')

@section('title', "System Settings — Corporate Portal")

@section('content')
<div class="corporate-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-corporate-sidebar active="settings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">System Settings & Configuration</h2>
                <p class="text-muted mb-0 fw-600 small">Manage your corporate profile, API keys, and notification preferences.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-navy rounded-pill px-5 fw-900 shadow-sm py-3 small">SAVE ALL CHANGES <i class="fas fa-save ms-2"></i></button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-city me-3 text-primary"></i> Enterprise Profile Configuration</h6>
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label x-small fw-900 text-muted uppercase">OFFICIAL REGISTERED COMPANY NAME</label>
                            <input type="text" class="form-control rounded-3 py-3 fw-bold x-small border-light-subtle" value="Google India Pvt Ltd">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label x-small fw-900 text-muted uppercase">PRIMARY GSTIN ID</label>
                            <input type="text" class="form-control rounded-3 py-3 fw-bold x-small border-light-subtle" value="27AAACE556V1Z3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label x-small fw-900 text-muted uppercase">FISCAL CONTACT PERSON</label>
                            <input type="text" class="form-control rounded-3 py-3 fw-bold x-small border-light-subtle" value="Sameer Khanna">
                        </div>
                        <div class="col-12">
                            <label class="form-label x-small fw-900 text-muted uppercase">BILLING ADDRESS</label>
                            <textarea class="form-control rounded-3 py-3 fw-bold x-small border-light-subtle" rows="3">Signature Towers, Sector 15 Part 2, Gurugram, Haryana 122001</textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-5 bg-navy text-white">
                    <h6 class="fw-900 text-white mb-5 uppercase tracking-wide opacity-75"><i class="fas fa-key me-3 text-warning"></i> Developer & API Integration</h6>
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-10 mb-4">
                        <label class="x-small fw-bold uppercase opacity-50 mb-2">PRODUCTION API KEY</label>
                        <div class="input-group">
                            <input type="password" class="form-control bg-transparent border-0 text-white fw-bold shadow-none" value="live_sk_8841_corporate_xxxx" readonly>
                            <button class="btn btn-link text-white py-0"><i class="fas fa-copy"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-bell me-3 text-primary"></i> Notification Rules</h6>
                    <div class="d-flex flex-column gap-4">
                        <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 border-bottom pb-4">
                             <label class="x-small fw-bold text-navy" for="whatsappSwitch">WhatsApp Approval Alerts</label>
                             <input class="form-check-input ms-0" type="checkbox" id="whatsappSwitch" checked>
                        </div>
                        <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 border-bottom pb-4">
                             <label class="x-small fw-bold text-navy" for="emailSwitch">Weekly Expenditure Audit Email</label>
                             <input class="form-check-input ms-0" type="checkbox" id="emailSwitch" checked>
                        </div>
                        <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                             <label class="x-small fw-bold text-navy" for="smsSwitch">SMS Booking Confirmations</label>
                             <input class="form-check-input ms-0" type="checkbox" id="smsSwitch">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-navy { background: #02234b !important; }
    .text-navy { color: #02234b; }
    .form-control:focus { box-shadow: 0 0 0 2px rgba(2, 35, 75, 0.1); border-color: #02234b; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
</style>
@endsection

@extends('layouts.app')

@section('title', "Partner Profile — Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <x-partner-sidebar active="profile" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <h2 class="fw-900 text-navy mb-5">Business Account Settings</h2>

            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-white p-5 rounded-4 shadow-sm border-0 mb-4">
                        <h5 class="fw-900 text-navy mb-4">Company Profile Details</h5>
                        <form>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Company Name</label>
                                    <input type="text" class="form-control rounded-pill px-4 py-3" value="Skybound Travel Co.">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">VAT / GST Identification</label>
                                    <input type="text" class="form-control rounded-pill px-4 py-3" value="GSTIN-948271635">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Office Headquarters</label>
                                    <input type="text" class="form-control rounded-pill px-4 py-3" value="Level 4, Skyview Tower, Cyber City, Gurgaon">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Primary Support Email</label>
                                    <input type="email" class="form-control rounded-pill px-4 py-3" value="admin@skyboundtravel.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Direct Business Phone</label>
                                    <input type="tel" class="form-control rounded-pill px-4 py-3" value="+91-9876543210">
                                </div>
                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-sm">Save Profiles Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white p-5 rounded-4 shadow-sm border-0">
                        <h5 class="fw-900 text-navy mb-4">Security & Access</h5>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="fw-bold mb-1">Two-Factor Authentication</h6>
                                <p class="text-muted small mb-0">Use Authenticator App to secure your partner portal.</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-navy p-5 rounded-4 shadow-lg text-white mb-4">
                        <h5 class="fw-900 mb-4">Verification Level</h5>
                        <div class="mb-4 d-flex align-items-center gap-3">
                            <div class="stat-icon bg-green text-white rounded-pill" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-check"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Identity Verified</h6>
                                <p class="small opacity-75 mb-0">Verified on 12 Jan 2026</p>
                            </div>
                        </div>
                         <div class="mb-4 d-flex align-items-center gap-3">
                            <div class="stat-icon bg-green text-white rounded-pill" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-check"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Tax Documents Linked</h6>
                                <p class="small opacity-75 mb-0">Verified on 14 Jan 2026</p>
                            </div>
                        </div>
                        <div class="mb-0 d-flex align-items-center gap-3 opacity-50">
                            <div class="stat-icon bg-white text-navy rounded-pill" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-exclamation"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Premium Badge Active</h6>
                                <p class="small opacity-75 mb-0">Renew on Jan 2027</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-4 shadow-sm border-0 text-center">
                        <p class="text-muted small mb-4">Need help updating your business legal name?</p>
                        <a href="#" class="btn btn-outline-navy w-100 rounded-pill py-3 fw-bold">Contact Support Agent</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

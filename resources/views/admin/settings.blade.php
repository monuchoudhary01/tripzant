@extends('layouts.admin')

@section('title', 'Global Branding Settings | Master Admin')

@section('admin_content')
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <h4 class="fw-900 text-navy mb-5 border-bottom pb-4">Branding & Identity Control</h4>

            <form>
                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Platform Display Name</label>
                        <input type="text" class="form-control px-4 py-3 rounded-pill border-light bg-light" value="Trip Zant Booking.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Slogan / Tagline</label>
                        <input type="text" class="form-control px-4 py-3 rounded-pill border-light bg-light" value="Discover Your Next Adventure">
                    </div>

                    <div class="col-md-6">
                        <div class="mb-5">
                            <label class="form-label fw-800 small text-uppercase opacity-75 d-block mb-3">Header Logo (Light Mode)</label>
                            <div class="p-5 border rounded-4 text-center bg-light position-relative">
                                <img src="/img/logo.svg" height="100" class="mb-3 opacity-75" alt="Logo preview">
                                <div class="mt-4">
                                    <button class="btn btn-sm btn-admin-primary px-4 shadow-sm fw-bold rounded-pill"><i class="fas fa-upload me-2"></i> RE-UPLOAD SVG</button>
                                </div>
                                <span class="position-absolute top-10 start-90 translate-middle badge rounded-pill bg-success p-2"><i class="fas fa-check"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-5">
                            <label class="form-label fw-800 small text-uppercase opacity-75 d-block mb-3">Footer Logo (Inverted)</label>
                            <div class="p-5 border rounded-4 text-center bg-navy position-relative border-0 shadow-lg">
                                <img src="/img/logo.svg" height="100" class="mb-3" style="filter: brightness(0) invert(1); opacity: 0.8;" alt="Logo preview">
                                <div class="mt-4">
                                    <button class="btn btn-sm btn-light px-4 shadow-sm fw-bold rounded-pill"><i class="fas fa-upload me-2 text-navy"></i> RE-UPLOAD SVG</button>
                                </div>
                                <span class="position-absolute top-10 start-90 translate-middle badge rounded-pill bg-success p-2"><i class="fas fa-check"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Primary Brand Color</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><div style="width:20px;height:20px;background:#0b3d61;border-radius:4px;"></div></span>
                            <input type="text" class="form-control border-light bg-light px-4 py-3 rounded-end-pill" value="#0b3d61">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Secondary Brand Color</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><div style="width:20px;height:20px;background:#f97316;border-radius:4px;"></div></span>
                            <input type="text" class="form-control border-light bg-light px-4 py-3 rounded-end-pill" value="#f97316">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Button Hover Effect</label>
                        <select class="form-select border-light bg-light px-4 py-3 rounded-pill fw-bold">
                            <option>Premium Glassmorphism</option>
                            <option>Solid Grow</option>
                            <option>Gradient Shift</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Global Footer Copyright Notice</label>
                        <input type="text" class="form-control px-4 py-3 rounded-pill border-light bg-light" value="© 2026 Trip Zant Private Limited. All rights reserved.">
                    </div>

                    <div class="col-12 mt-5 text-end pt-5 border-top">
                        <button class="btn btn-admin-primary px-5 py-3 shadow-lg fs-6 rounded-pill"><i class="fas fa-save me-2"></i> Commit Global Changes <i class="fas fa-check-circle ms-2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card-admin shadow-sm border-0 mb-4 p-5 bg-navy text-white position-relative overflow-hidden">
            <h5 class="fw-900 mb-4 z-2 position-relative">System Health</h5>
            <p class="small opacity-75 mb-5 z-2 position-relative font-monospace leading-relaxed">All CSS variables are synchronized. Changes here reflect globally across Header, Footer, and Landing sections instantly.</p>
            <div class="d-flex align-items-center gap-3 z-2 position-relative">
                <div class="badge bg-success rounded-pill px-4 py-2 border-0 fw-bold fs-6 shadow-sm"><i class="fas fa-check-circle me-2"></i> SYSTEM ACTIVE</div>
            </div>
            <div style="position:absolute; bottom:-30px; right: -30px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%; blur: 20px;"></div>
        </div>

        <div class="card-admin shadow-sm border-0 p-5">
            <h6 class="fw-900 text-navy mb-4">Site Favicon Settings</h6>
            <div class="d-flex align-items-center gap-5 p-4 bg-light rounded-4 border-dashed border-2 text-center flex-column">
                <div class="bg-white p-3 shadow-sm rounded-3 border-navy" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                    <img src="/img/logo.svg" width="32" class="opacity-75">
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-navy rounded-pill px-4 fw-bold">BROWSE / ICO</button>
                    <p class="text-muted smaller mb-0 mt-3 fw-bold">REC: 32x32px .ico or .png</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

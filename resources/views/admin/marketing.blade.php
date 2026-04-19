@extends('layouts.admin')

@section('title', 'Marketing & Social Media Control | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-9">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <h4 class="fw-900 text-navy mb-5 border-bottom pb-4">Social Media & Public Relations</h4>
            
            <form>
                <div class="row g-5 align-items-center">
                    <!-- Facebook -->
                    <div class="col-md-2">
                        <div class="social-icon-admin bg-blue text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:60px;height:60px;background:#1877f2;"><i class="fab fa-facebook-f fs-4"></i></div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Facebook Page URL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-link"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="facebook.com/tripstaybooking">
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="col-md-2">
                        <div class="social-icon-admin bg-pink text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:60px;height:60px;background:linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);"><i class="fab fa-instagram fs-4"></i></div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Instagram Handle URL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-link"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="instagram.com/tripstay.official">
                        </div>
                    </div>

                    <!-- X / Twitter -->
                    <div class="col-md-2">
                        <div class="social-icon-admin bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:60px;height:60px;background:#000;"><i class="fab fa-x-twitter fs-4"></i></div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label fw-800 small text-uppercase opacity-75">X (Twitter) Official Account</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-link"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="x.com/tripstay_booking">
                        </div>
                    </div>

                    <!-- LinkedIn -->
                    <div class="col-md-2">
                         <div class="social-icon-admin bg-blue text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:60px;height:60px;background:#0077b5;"><i class="fab fa-linkedin-in fs-4"></i></div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label fw-800 small text-uppercase opacity-75">LinkedIn Company Page</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-link"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="linkedin.com/company/tripstay">
                        </div>
                    </div>

                     <!-- WhatsApp Business -->
                     <div class="col-md-2">
                         <div class="social-icon-admin bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:60px;height:60px;"><i class="fab fa-whatsapp fs-4"></i></div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label fw-800 small text-uppercase opacity-75">WhatsApp Official Business No.</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="+91 9172839405">
                        </div>
                    </div>

                     <!-- Telegram -->
                     <div class="col-md-2">
                         <div class="social-icon-admin text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:60px;height:60px;background:#0088cc;"><i class="fab fa-telegram-plane fs-4"></i></div>
                    </div>
                    <div class="col-md-10">
                        <label class="form-label fw-800 small text-uppercase opacity-75">Telegram News Channel</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-4 rounded-start-pill"><i class="fas fa-link"></i></span>
                            <input type="text" class="form-control px-4 py-3 rounded-end-pill border-light bg-light" value="t.me/tripstay_alerts">
                        </div>
                    </div>

                    <div class="col-12 mt-5 text-end pt-5 border-top">
                        <button class="btn btn-admin-primary px-5 py-3 shadow-lg fs-6 rounded-pill"><i class="fas fa-sync me-2"></i> Update Marketing Footprint <i class="fas fa-check-circle ms-2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card-admin shadow-sm border-0 p-5 mb-4 text-center">
             <i class="fas fa-share-nodes text-navy fs-1 mb-4 opacity-50"></i>
             <h6 class="fw-900 text-navy mb-3">Live Feed Status</h6>
             <p class="text-muted smaller mb-0 fw-bold">Connecting all links to footer and landing page components automatically.</p>
        </div>
        <div class="card-admin shadow-sm border-0 p-5 text-center bg-light">
             <i class="fas fa-chart-line text-navy fs-2 mb-4"></i>
             <h6 class="fw-900 text-navy mb-1 leading-relaxed">Marketing Insights</h6>
             <p class="text-navy small opacity-50 mt-1 mb-0 font-monospace">API Key: Active</p>
        </div>
    </div>
</div>
@endsection

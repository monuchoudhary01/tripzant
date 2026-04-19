@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-800">My Profile</h4>
            <p class="text-muted small">Manage your professional presence on the Tripzant marketplace.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile info -->
        <div class="col-lg-4">
            <div class="card border-0 p-4 text-center">
                <div class="position-relative d-inline-block mx-auto mb-4">
                    <img src="https://i.pravatar.cc/150?u=rahul" class="rounded-circle border p-1" width="120" height="120">
                    <button class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-2 shadow-sm" style="width:36px; height:36px;"><i class="fas fa-camera"></i></button>
                </div>
                <h5 class="fw-800 mb-1">Rahul Sharma</h5>
                <p class="text-muted fw-700 small mb-4"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New Delhi, India</p>
                
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-800" style="font-size:10px;">ID VERIFIED</span>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 fw-800" style="font-size:10px;">TOP PROVIDER</span>
                </div>

                <div class="p-3 bg-light rounded-4 text-start mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 fw-800 small">Availability</h6>
                            <p class="mb-0 text-muted smaller">Show as online to take requests</p>
                        </div>
                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0" type="checkbox" checked style="width:40px; height:20px;">
                        </div>
                    </div>
                </div>

                <div class="text-start">
                    <h6 class="fw-800 small text-muted mb-3 uppercase">CONTACT DETAILS</h6>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded-3 p-2 text-muted"><i class="fas fa-phone small"></i></div>
                            <span class="small fw-700">+91 99887 76655</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded-3 p-2 text-muted"><i class="fas fa-envelope small"></i></div>
                            <span class="small fw-700">rahul.guide@example.com</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded-3 p-2 text-muted"><i class="fas fa-globe small"></i></div>
                            <span class="small fw-700">www.guide-rahul.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile -->
        <div class="col-lg-8">
            <div class="card border-0 p-4 mb-4">
                <h5 class="fw-800 mb-4">Professional Information</h5>
                <form>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-700 small text-muted">ABOUT YOU</label>
                            <textarea class="form-control rounded-4 p-3 border-light bg-light fw-600" rows="5" placeholder="Tell hotels and tour builders about your expertise...">Professional travel guide with 8+ years of experience in North India. Specialized in cultural tours, local street food trails, and luxury airport transfers. Fluent in English, Hindi, and German.</textarea>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label class="form-label fw-700 small text-muted">SERVICE AREAS (CITIES)</label>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-white border text-dark fw-700 px-3 py-2 rounded-pill shadow-sm">New Delhi <i class="fas fa-times ms-2 text-muted"></i></span>
                                <span class="badge bg-white border text-dark fw-700 px-3 py-2 rounded-pill shadow-sm">Noida <i class="fas fa-times ms-2 text-muted"></i></span>
                                <span class="badge bg-white border text-dark fw-700 px-3 py-2 rounded-pill shadow-sm">Gurgaon <i class="fas fa-times ms-2 text-muted"></i></span>
                                <span class="badge bg-white border text-dark fw-700 px-3 py-2 rounded-pill shadow-sm">Agra (Day Trips) <i class="fas fa-times ms-2 text-muted"></i></span>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-700">+ Add City</button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label fw-700 small text-muted">PRIMARY LANGUAGE</label>
                            <select class="form-select rounded-4 p-3 border-light bg-light fw-600">
                                <option>English</option>
                                <option>Hindi</option>
                                <option>German</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label fw-700 small text-muted">EXPERIENCE LEVEL</label>
                            <select class="form-select rounded-4 p-3 border-light bg-light fw-600">
                                <option>Expert (5+ Years)</option>
                                <option>Intermediate (2-5 Years)</option>
                                <option>Entry Level</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card border-0 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-800 mb-0">Identity & Certifications</h5>
                    <button class="btn btn-primary btn-sm px-4 rounded-pill fw-700">Upload New</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 border rounded-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3"><i class="fas fa-id-card-clip fa-lg"></i></div>
                            <div>
                                <h6 class="mb-0 fw-700 small">IATA Guide License.pdf</h6>
                                <p class="mb-0 text-muted smaller">Verified on 12 Jan 2026</p>
                            </div>
                            <i class="fas fa-check-circle ms-auto text-success"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 border rounded-4 border-dashed">
                            <div class="bg-light text-muted rounded-3 p-3"><i class="fas fa-file-invoice fa-lg"></i></div>
                            <div>
                                <h6 class="mb-0 fw-700 small">Driver License Front.jpg</h6>
                                <p class="mb-0 text-muted smaller">Expires in 1.5 Years</p>
                            </div>
                            <i class="fas fa-check-circle ms-auto text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-outline-custom px-5 py-3 fw-800 rounded-pill me-2">Discard Changes</button>
                <button class="btn btn-primary px-5 py-3 fw-800 rounded-pill">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .smaller { font-size: 11px; }
</style>
@endsection

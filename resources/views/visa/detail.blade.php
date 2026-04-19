@extends('layouts.app')

@section('title', "Apply for " . ucfirst($country) . " Visa | Trip Zant")

@section('styles')
<style>
    .visa-header-d {
        background: url('https://images.unsplash.com/photo-1549417229-aa67d3263c09?w=1600&auto=format&fit=crop&q=80') center/cover;
        padding: 80px 0;
        color: #fff;
        position: relative;
    }
    .visa-header-d::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(0deg, rgba(var(--navy-rgb), 0.95), rgba(var(--navy-rgb), 0.6));
    }
    .checklist-item {
        display: flex; gap: 15px; padding: 15px; border-radius: 12px; background: #fff;
        border: 1px solid #f1f5f9; margin-bottom: 10px; transition: 0.3s;
    }
    .checklist-item:hover { border-color: var(--primary); }
    .upload-zone { 
        border: 2px dashed #e2e8f0; border-radius: 15px; padding: 30px; text-align: center;
        background: #f8fafc; cursor: pointer; transition: 0.3s;
    }
    .upload-zone:hover { border-color: var(--primary); background: rgba(var(--primary-rgb), 0.02); }
</style>
@endsection

@section('content')
<div class="visa-header-d">
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-6 fw-900 mb-0">{{ strtoupper($country) }} VISA APPLICATION</h1>
        <div class="d-flex align-items-center gap-3 mt-3">
            <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill"><i class="fas fa-id-badge me-1"></i> TOURIST VISA</span>
            <span class="small fw-700 opacity-75"><i class="fas fa-clock me-1"></i> 3–5 Working Days Processing</span>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-5 mb-5">
                <h4 class="fw-900 text-navy mb-4">Personal Details</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-700 text-muted">FIRST NAME (AS PER PASSPORT)</label>
                        <input type="text" class="form-control p-3 border rounded-3 fw-bold shadow-none" placeholder="First Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-700 text-muted">LAST NAME (AS PER PASSPORT)</label>
                        <input type="text" class="form-control p-3 border rounded-3 fw-bold shadow-none" placeholder="Last Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-700 text-muted">DATE OF BIRTH</label>
                        <input type="date" class="form-control p-3 border rounded-3 fw-bold shadow-none">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-700 text-muted">PASSPORT NUMBER</label>
                        <input type="text" class="form-control p-3 border rounded-3 fw-bold shadow-none" placeholder="L1234567">
                    </div>
                </div>

                <h4 class="fw-900 text-navy mt-5 mb-4">Required Documents</h4>
                <div class="d-flex flex-column gap-3 mb-5">
                    <div class="checklist-item">
                        <i class="fas fa-camera text-primary mt-1 fs-5"></i>
                        <div>
                            <h6 class="fw-900 text-navy mb-1 small">Passport Size Photo</h6>
                            <p class="x-small text-muted mb-3 fw-bold">Recent color photo with white background (35x45mm).</p>
                            <label for="upload-1" class="upload-zone d-block hvr-grow-small">
                                <i class="fas fa-cloud-arrow-up text-primary fs-3 mb-2"></i>
                                <div class="small fw-800 text-navy">Click to upload photo</div>
                                <div class="x-small text-muted mt-1 fw-bold">JPG, PNG allowed (Max 5MB)</div>
                                <input type="file" id="upload-1" class="d-none">
                            </label>
                        </div>
                    </div>
                    <div class="checklist-item">
                        <i class="fas fa-address-book text-primary mt-1 fs-5"></i>
                        <div>
                            <h6 class="fw-900 text-navy mb-1 small">Passport Copy (Front & Back)</h6>
                            <p class="x-small text-muted mb-3 fw-bold">Scan of first and last page with at least 6 months validity.</p>
                            <label for="upload-2" class="upload-zone d-block hvr-grow-small">
                                <i class="fas fa-file-pdf text-danger fs-3 mb-2"></i>
                                <div class="small fw-800 text-navy">Click to upload passport scan</div>
                                <div class="x-small text-muted mt-1 fw-bold">Combine both pages into one PDF</div>
                                <input type="file" id="upload-2" class="d-none">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning border-0 p-4 rounded-4 shadow-sm">
                    <div class="d-flex gap-3">
                        <i class="fas fa-circle-exclamation text-warning fs-3"></i>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">Important Note</h6>
                            <p class="small text-muted mb-0 fw-bold">Please ensure all uploaded documents are clear and legible. Blurred photos may delay the process.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn btn-navy py-4 px-5 rounded-pill fw-900 shadow-lg w-100 fs-5 hvr-grow">PAY & SUBMIT APPLICATION <i class="fas fa-arrow-right ms-2"></i></button>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top mb-5" style="top: 100px;">
                <h6 class="fw-900 text-navy mb-4 border-bottom pb-2 uppercase tracking-wide">Fee Breakdown</h6>
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <span class="small fw-700 text-muted">Visa Fee (Govt)</span>
                        <span class="small fw-900 text-navy">₹4,950</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-700 text-muted">Service Fee</span>
                        <span class="small fw-900 text-navy">₹1,200</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-700 text-muted">Taxes (GST)</span>
                        <span class="small fw-900 text-navy">₹216</span>
                    </div>
                    <hr class="my-2 border-dashed">
                    <div class="d-flex justify-content-between">
                        <span class="fw-900 text-navy">TOTAL AMOUNT</span>
                        <span class="fw-900 text-primary fs-4">₹6,366</span>
                    </div>
                </div>

                <h6 class="fw-900 text-navy mb-4 border-bottom pb-2 uppercase tracking-wide mt-4">Why Trip Zant?</h6>
                <ul class="list-unstyled d-flex flex-column gap-3">
                    <li class="d-flex gap-2 small fw-800 text-muted"><i class="fas fa-check-circle text-success fs-x-small mt-1"></i> Expert Document Review</li>
                    <li class="d-flex gap-2 small fw-800 text-muted"><i class="fas fa-check-circle text-success fs-x-small mt-1"></i> Faster Approval Times</li>
                    <li class="d-flex gap-2 small fw-800 text-muted"><i class="fas fa-check-circle text-success fs-x-small mt-1"></i> 24/7 Application Support</li>
                    <li class="d-flex gap-2 small fw-800 text-muted"><i class="fas fa-check-circle text-success fs-x-small mt-1"></i> Secure Payment Gateway</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

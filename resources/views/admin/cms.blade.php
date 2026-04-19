@extends('layouts.admin')

@section('title', 'CMS Content Management | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <!-- CMS Sidebar -->
    <div class="col-xl-4">
        <div class="card-admin shadow-sm border-0 p-5">
            <h5 class="fw-900 text-navy mb-4 border-bottom pb-4">Static Pages Controller</h5>
            <div class="d-flex flex-column gap-3">
                <a href="#" class="cms-nav-link active p-4 rounded-4 bg-navy text-white d-flex justify-content-between align-items-center text-decoration-none shadow-lg">
                    <span><i class="fas fa-shield-halved me-3"></i> Privacy Policy</span>
                    <i class="fas fa-chevron-right fs-6"></i>
                </a>
                <a href="#" class="cms-nav-link p-4 rounded-4 bg-light text-navy d-flex justify-content-between align-items-center text-decoration-none border shadow-sm">
                    <span><i class="fas fa-file-contract me-3"></i> Terms & Conditions</span>
                    <i class="fas fa-chevron-right fs-6 opacity-25"></i>
                </a>
                <a href="#" class="cms-nav-link p-4 rounded-4 bg-light text-navy d-flex justify-content-between align-items-center text-decoration-none border shadow-sm">
                    <span><i class="fas fa-circle-info me-3"></i> About Our Mission</span>
                    <i class="fas fa-chevron-right fs-6 opacity-25"></i>
                </a>
                <a href="#" class="cms-nav-link p-4 rounded-4 bg-light text-navy d-flex justify-content-between align-items-center text-decoration-none border shadow-sm">
                    <span><i class="fas fa-headset me-3"></i> Support & Contact</span>
                    <i class="fas fa-chevron-right fs-6 opacity-25"></i>
                </a>
                <button class="btn btn-navy w-100 rounded-pill py-3 fw-bold mt-5"><i class="fas fa-plus me-2"></i> Create New Page</button>
            </div>
        </div>
    </div>

    <!-- Rich Text Editor (UI ONLY) -->
    <div class="col-xl-8">
        <div class="card-admin shadow-sm border-0 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="fw-900 text-navy mb-0">Editing: Privacy Policy</h4>
                <div class="badge bg-green text-white rounded-pill px-4 py-2 shadow-sm fw-bold">LAST SAVED: 12 JAN 2026</div>
            </div>

            <!-- Toolbar Mockup -->
            <div class="cms-toolbar-mock d-flex flex-wrap gap-4 p-4 bg-light rounded-4 border-bottom-0 mb-n5 position-relative z-2">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-bold"></i></button>
                    <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-italic"></i></button>
                    <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-underline"></i></button>
                </div>
                <div class="d-flex gap-2 border-start ps-4">
                     <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-align-left"></i></button>
                     <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-align-center"></i></button>
                     <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-align-right"></i></button>
                </div>
                <div class="d-flex gap-2 border-start ps-4">
                     <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-link"></i> Link</button>
                     <button class="btn btn-sm btn-white shadow-sm fw-bold border"><i class="fas fa-image"></i> Media</button>
                </div>
                <div class="flex-grow-1 text-end">
                    <select class="form-select-sm border-0 bg-transparent fw-800 text-navy font-monospace">
                         <option>Normal Text</option>
                         <option>Heading 1</option>
                         <option>Heading 2</option>
                    </select>
                </div>
            </div>

            <!-- Editor Input -->
            <div class="mt-5">
                <div class="form-control bg-light border-light p-5 rounded-4 font-monospace min-height-400 leading-relaxed text-muted mt-5" style="min-height: 400px; font-size: 14px; border: 2px dashed var(--admin-border) !important;">
                    <p class="mb-4">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p>
                    <p class="mb-4 text-navy fw-900 fs-5 mt-5">1. Interpretation and Definitions</p>
                    <p class="mb-4">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>
                    <p class="mb-4 text-navy fw-900 fs-5 mt-5">2. Gathering Personal Information</p>
                    <p class="mb-4">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to: Email address, First name and last name, Phone number, Usage Data.</p>
                </div>
            </div>

            <div class="text-end mt-5 pt-5 border-top">
                <button class="btn btn-admin-primary px-5 py-3 shadow-lg fs-6 rounded-pill"><i class="fas fa-upload me-2"></i> Deploy Policy Live <i class="fas fa-check-circle ms-2"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection

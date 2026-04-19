@extends('layouts.b2b_master')

@section('title', 'Agency Settings | Amadeus Partner Panel')

@section('styles')
<style>
    .setting-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    .setting-box {
        background: #fff;
        border: 1px solid #dfe1e6;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    .setting-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #0052cc;
    }
    .setting-icon {
        font-size: 32px;
        color: #6b778c;
    }
    .setting-box:hover .setting-icon { color: #0052cc; }
    .setting-box h6 {
        font-weight: 700;
        margin-bottom: 5px;
        color: #172b4d;
    }
    .setting-box p {
        font-size: 11px;
        color: #6b778c;
        margin-bottom: 0;
        line-height: 1.4;
    }
    .agency-logo-container {
        text-align: center;
        padding-right: 40px;
        border-right: 1px solid #dfe1e6;
    }
    .info-label {
        font-size: 11px;
        font-weight: 700;
        color: #6b778c;
        text-transform: uppercase;
        width: 120px;
        display: inline-block;
    }
    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #172b4d;
    }
    .reg-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        margin-bottom: 8px;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Agency Settings</h4>
        <p class="text-muted small mb-0">Manage your agency profile, registrations, and system configurations.</p>
    </div>
</div>

<div class="b2b-table-card p-5">
    <div class="row">
        <!-- Logo Section -->
        <div class="col-lg-3">
            <div class="agency-logo-container">
                <div class="mb-4">
                    <img src="https://img.logo.dev/amadeus.com?token=pk_mX9M9_I_S0q_8p_J2w" class="img-fluid rounded-3 mb-3" style="max-width: 180px;">
                    <div class="h4 outfit fw-800 text-primary mb-0">AMADEUS GLOBAL CONNECT</div>
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-outline-danger btn-sm px-3 fw-700 border-0 bg-light-danger text-danger">Remove Logo</button>
                    <button class="btn btn-primary btn-sm px-3 fw-700 border-0 shadow-sm" style="background: #0052cc;">Edit Logo</button>
                </div>
            </div>
        </div>

        <!-- Agency Details -->
        <div class="col-lg-9 ps-lg-5">
            <div class="row mb-5">
                <div class="col-md-6 border-end">
                    <div class="mb-2"><span class="info-label">Agency Name</span> <span class="info-value">Amadeus Partner One (Global)</span></div>
                    <div class="mb-2"><span class="info-label">ABN</span> <span class="info-value">75676401586</span></div>
                    <div class="mb-4"><span class="info-label">Address</span> <span class="info-value">Level 24, Amadeus Hub,<br>New Delhi 110001, INDIA</span></div>
                    <div><span class="info-label">Base Currency</span> <span class="info-value">INDIAN RUPEE (INR)</span></div>
                </div>
                <div class="col-md-6 ps-md-4">
                    <div class="mb-2"><span class="info-label">Phone</span> <span class="info-value">+91 11 4982 8200</span></div>
                    <div class="mb-2"><span class="info-label">Fax</span> <span class="info-value">--</span></div>
                    <div class="mb-2"><span class="info-label">Email</span> <span class="info-value">support@amadeus-global.com</span></div>
                    <div class="mb-2"><span class="info-label">Agency Code</span> <span class="info-value">AM-GLOB-821</span></div>
                    <div class="mb-2"><span class="info-label">Account Code</span> <span class="info-value">DEL501579</span></div>
                    <div><span class="info-label">Tids/IATA Code</span> <span class="info-value">1439201</span></div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-top">
                <h6 class="fw-800 text-muted uppercase small mb-3 ls-1">Agent Registrations</h6>
                <div class="reg-item">
                    <i class="fas fa-shopping-cart text-muted"></i>
                    <span><strong class="text-dark">Register for Shopping</strong> <span class="text-muted mx-2">03 Nov 2025 10:42 AM</span> by <span class="text-primary fw-600">Amadeus Global Admin</span></span>
                </div>
                <div class="reg-item">
                    <i class="fas fa-network-wired text-muted"></i>
                    <span><strong class="text-dark">Register for NDC</strong> <span class="text-muted mx-4">06 Feb 2026 03:47 PM</span> by <span class="text-primary fw-600">Amadeus Global Admin</span></span>
                </div>
            </div>

            <div class="mt-5 p-3 bg-light rounded-3 text-muted" style="font-size: 11px;">
                <strong>NOTE:</strong> Are these details incorrect? If so, please contact your regional Amadeus office or email <a href="mailto:support@amadeus-global.com" class="text-primary text-decoration-none fw-600">support@amadeus-global.com</a>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Utility Grid -->
<div class="setting-card-grid">
    <div class="setting-box" onclick="location.href='{{ route('amadeus.settings-spm') }}'">
        <i class="fas fa-file-invoice setting-icon"></i>
        <div>
            <h6>SPM Default Settings</h6>
            <p>Set defaults for SPM configuration</p>
        </div>
    </div>
    <div class="setting-box" onclick="location.href='{{ route('amadeus.settings-email') }}'">
        <i class="fas fa-envelope-open-text setting-icon"></i>
        <div>
            <h6>Email & SMS Settings</h6>
            <p>Email/SMS addresses for invoices and alerts</p>
        </div>
    </div>
    <div class="setting-box" onclick="location.href='{{ route('amadeus.wallet-credit') }}'">
        <i class="fas fa-university setting-icon"></i>
        <div>
            <h6>Credit Balance</h6>
            <p>View agency credit limit, owing and available</p>
        </div>
    </div>
    <div class="setting-box" onclick="location.href='{{ route('amadeus.settings-staff') }}'">
        <i class="fas fa-users-cog setting-icon"></i>
        <div>
            <h6>Staff Management</h6>
            <p>Add and update staff and their access roles</p>
        </div>
    </div>
    <div class="setting-box" onclick="location.href='{{ route('amadeus.gds') }}'">
        <i class="fas fa-shopping-basket setting-icon"></i>
        <div>
            <h6>Shopping Setup</h6>
            <p>Setup GDS PCC and NDC Shopping Credentials</p>
        </div>
    </div>
</div>
@endsection


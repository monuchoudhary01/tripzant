@extends('layouts.hotel_master')

@section('title', 'Hotel Settings | B2B Travel Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Hotel System Settings</h4>
        <p class="text-muted small mb-0">Configure your hotel API providers and booking markups.</p>
    </div>
</div>

<div class="row g-4">
    <!-- API Integration -->
    <div class="col-lg-6">
        <div class="b2b-table-card p-4">
            <h6 class="fw-800 outfit mb-4 text-primary"><i class="fas fa-plug me-2"></i> API PROVIDER INTEGRATION</h6>
            
            <div class="p-3 border rounded-3 mb-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img src="https://logowik.com/content/uploads/images/hotelbeds4223.jpg" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-800 mb-0">Hotelbeds API</h6>
                        <p class="text-muted tiny mb-0">Global inventory, 180k+ hotels</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" checked id="hbAPI">
                    <label class="form-check-label fw-600 small" for="hbAPI">ACTIVE</label>
                </div>
            </div>

            <div class="p-3 border rounded-3 mb-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img src="https://media.licdn.com/dms/image/C4E0BAQE8vJzY3_5_2Q/company-logo_200_200/0/1630132103522?e=2147483647&v=beta&t=4m7l_-y_z7U_8p_J2w" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-800 mb-0">TBO Holidays API</h6>
                        <p class="text-muted tiny mb-0">Middle East & Asian focus</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" checked id="tboAPI">
                    <label class="form-check-label fw-600 small" for="tboAPI">ACTIVE</label>
                </div>
            </div>

            <button class="btn btn-outline-primary btn-sm px-4 fw-700 w-100 py-3 mt-3">CONFIGURE API KEYS</button>
        </div>
    </div>

    <!-- Markup Settings -->
    <div class="col-lg-6">
        <div class="b2b-table-card p-4">
            <h6 class="fw-800 outfit mb-4 text-primary"><i class="fas fa-percentage me-2"></i> DYNAMIC MARKUP SETTINGS</h6>
            
            <div class="mb-4">
                <label class="form-label-b2b">Global Hotel Markup (%)</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-b2b" value="5.50">
                    <span class="input-group-text bg-light fw-700 border-0 opacity-75">%</span>
                </div>
                <p class="tiny text-muted mt-2 fw-600">This markup will be added automatically to all net rates fetched from providers.</p>
            </div>

            <div class="mb-4 pt-4 border-top">
                <label class="form-label-b2b">Domestic Hotel Markup (%)</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-b2b" value="3.00">
                    <span class="input-group-text bg-light fw-700 border-0 opacity-75">%</span>
                </div>
            </div>

            <button class="btn btn-primary btn-sm px-4 fw-700 w-100 py-3 mt-3 shadow-lg">SAVE MARKUP SETTINGS</button>
        </div>
    </div>
</div>
@endsection

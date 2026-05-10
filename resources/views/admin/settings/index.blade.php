@extends('layouts.admin')

@section('title', 'System Settings | Command Center')

@section('admin_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings /</span> Global Configuration</h4>
            
            @if(session('success'))
            <div class="alert alert-primary alert-dismissible shadow-sm border-0 mb-4" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3 gap-2">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-services">
                                <i class="bx bx-grid-alt me-1"></i> Services
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-markup">
                                <i class="bx bx-trending-up me-1"></i> Markups
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-api">
                                <i class="bx bx-chip me-1"></i> API Management
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-payments">
                                <i class="bx bx-credit-card me-1"></i> Payments
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-smtp">
                                <i class="bx bx-envelope me-1"></i> SMTP
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-general">
                                <i class="bx bx-cog me-1"></i> General
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-0 bg-transparent border-0 shadow-none">
                        <!-- Tab 1: Services -->
                        <div class="tab-pane fade show active" id="tab-services">
                            <div class="card mb-4 shadow-sm border-0 rounded-4">
                                <h5 class="card-header fw-bold border-bottom py-3">Modular Service Visibility</h5>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.services.update') }}" method="POST">
                                        @csrf
                                        <div class="row g-4">
                                            @php
                                                $services = [
                                                    ['key' => 'service_flights_enabled', 'label' => 'Flights', 'icon' => 'bx-paper-plane'],
                                                    ['key' => 'service_hotels_enabled', 'label' => 'Hotels', 'icon' => 'bx-hotel'],
                                                    ['key' => 'service_flight_hotel_enabled', 'label' => 'Flight + Hotel', 'icon' => 'bx-briefcase'],
                                                    ['key' => 'service_homestays_enabled', 'label' => 'Homestays', 'icon' => 'bx-home-heart'],
                                                    ['key' => 'service_cabs_enabled', 'label' => 'Cabs', 'icon' => 'bx-car'],
                                                    ['key' => 'service_trains_enabled', 'label' => 'Trains', 'icon' => 'bx-train'],
                                                    ['key' => 'service_holidays_enabled', 'label' => 'Holidays (Tours)', 'icon' => 'bx-package'],
                                                    ['key' => 'service_visa_enabled', 'label' => 'Visa Services', 'icon' => 'bx-id-card'],
                                                    ['key' => 'service_insurance_enabled', 'label' => 'Travel Insurance', 'icon' => 'bx-shield-quarter'],
                                                    ['key' => 'service_esim_enabled', 'label' => 'eSIM Global', 'icon' => 'bx-chip'],
                                                    ['key' => 'service_cargo_enabled', 'label' => 'Cargo Logistics', 'icon' => 'bxs-truck'],
                                                    ['key' => 'service_event_qr_enabled', 'label' => 'Event QR System', 'icon' => 'bx-qr-scan'],
                                                ];
                                            @endphp
                                            @foreach($services as $service)
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center justify-content-between p-3 border rounded-3 bg-white hover-shadow transition">
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge bg-label-primary p-2 rounded me-3">
                                                            <i class="bx {{ $service['icon'] }} fs-4"></i>
                                                        </div>
                                                        <span class="fw-bold">{{ $service['label'] }}</span>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="{{ $service['key'] }}" value="1" {{ ($globalSettings->get('services', collect())->where('key', $service['key'])->first()->value ?? '1') == '1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">Save Visibility Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Markups -->
                        <div class="tab-pane fade" id="tab-markup">
                            <!-- Global Markup Defaults (The ones user asked for in .env) -->
                            <div class="card mb-4 shadow-sm border-0 rounded-4">
                                <h5 class="card-header fw-bold border-bottom py-3">Global Markup Defaults (%)</h5>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.markups.update') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold">B2C MARKUP (%)</label>
                                                <input type="number" step="0.1" name="default_b2c_markup" value="{{ $globalSettings->get('markup', collect())->where('key', 'default_b2c_markup')->first()->value ?? '10' }}" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold">B2B MARKUP (%)</label>
                                                <input type="number" step="0.1" name="default_b2b_markup" value="{{ $globalSettings->get('markup', collect())->where('key', 'default_b2b_markup')->first()->value ?? '5' }}" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold">CORPORATE MARKUP (%)</label>
                                                <input type="number" step="0.1" name="default_corporate_markup" value="{{ $globalSettings->get('markup', collect())->where('key', 'default_corporate_markup')->first()->value ?? '7' }}" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold">IATA MARKUP (%)</label>
                                                <input type="number" step="0.1" name="default_iata_markup" value="{{ $globalSettings->get('markup', collect())->where('key', 'default_iata_markup')->first()->value ?? '3' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold rounded-pill shadow">Update Defaults</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Detailed Markup Table -->
                            <div class="card shadow-sm border-0 rounded-4">
                                <h5 class="card-header fw-bold border-bottom py-3">Detailed Revenue Markups (Agent Roles)</h5>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.markup.update') }}" method="POST">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Module</th>
                                                        <th>Agent Role</th>
                                                        <th>Type</th>
                                                        <th>Value</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($markupSettings as $markup)
                                                    <input type="hidden" name="markups[{{$markup->id}}][id]" value="{{$markup->id}}">
                                                    <tr>
                                                        <td><span class="badge bg-label-info text-capitalize">{{ $markup->module }}</span></td>
                                                        <td><span class="fw-semibold">{{ strtoupper($markup->user_role) }}</span></td>
                                                        <td>
                                                            <select name="markups[{{$markup->id}}][type]" class="form-select form-select-sm">
                                                                <option value="fixed" {{ $markup->markup_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                                                <option value="percent" {{ $markup->markup_type == 'percent' ? 'selected' : '' }}>Percentage %</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="markups[{{$markup->id}}][value]" value="{{ $markup->markup_value }}" class="form-control form-control-sm" style="width: 100px;">
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" name="markups[{{$markup->id}}][active]" {{ $markup->is_active ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">Save Table Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: API Management -->
                        <div class="tab-pane fade" id="tab-api">
                            <!-- Provider Priority Table -->
                            <div class="card mb-4 shadow-sm border-0 rounded-4">
                                <div class="card-header d-flex justify-content-between align-items-center border-bottom py-3">
                                    <h5 class="fw-bold mb-0">Internal API Controls (Priorities)</h5>
                                    <form action="{{ route('admin.settings.swagger.regenerate') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-dark btn-sm fw-bold px-3 rounded-pill"><i class="bx bx-refresh"></i> Regenerate Swagger</button>
                                    </form>
                                </div>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.api-configs.update') }}" method="POST">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Provider</th>
                                                        <th>Type</th>
                                                        <th>Priority</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($apiConfigs as $config)
                                                    <tr>
                                                        <td><span class="fw-bold">{{ strtoupper($config->provider_name) }}</span></td>
                                                        <td><span class="badge bg-label-primary">{{ strtoupper($config->api_type) }}</span></td>
                                                        <td>
                                                            <select name="configs[{{$config->id}}][priority]" class="form-select form-select-sm">
                                                                <option value="primary" {{ $config->priority == 'primary' ? 'selected' : '' }}>Primary</option>
                                                                <option value="secondary" {{ $config->priority == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" name="configs[{{$config->id}}][active]" {{ $config->is_active ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">Save Priorities</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Third-Party Credentials (The ones user asked for keys) -->
                            <form action="{{ route('admin.settings.api-credentials.update') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <!-- Amadeus -->
                                    <div class="col-md-6">
                                        <div class="card h-100 shadow-sm border-0 rounded-4">
                                            <div class="card-header bg-primary bg-opacity-10 py-3 d-flex justify-content-between align-items-center">
                                                <h6 class="fw-bold mb-0 text-primary">Amadeus GDS Credentials</h6>
                                                <span class="badge bg-primary">Flights</span>
                                            </div>
                                            <div class="card-body pt-3">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">ENVIRONMENT</label>
                                                    <select name="amadeus_api_env" class="form-select">
                                                        <option value="test" {{ ($globalSettings->get('api_credentials', collect())->where('key', 'amadeus_api_env')->first()->value ?? '') == 'test' ? 'selected' : '' }}>Sandbox</option>
                                                        <option value="live" {{ ($globalSettings->get('api_credentials', collect())->where('key', 'amadeus_api_env')->first()->value ?? '') == 'live' ? 'selected' : '' }}>Production</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">API KEY</label>
                                                    <input type="text" name="amadeus_api_key" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'amadeus_api_key')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">API SECRET</label>
                                                    <input type="password" name="amadeus_api_secret" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'amadeus_api_secret')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">PCC (OFFICE ID)</label>
                                                    <input type="text" name="amadeus_pcc_in" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'amadeus_pcc_in')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="col-md-6">
                                        <div class="card h-100 shadow-sm border-0 rounded-4">
                                            <div class="card-header bg-success bg-opacity-10 py-3 d-flex justify-content-between align-items-center">
                                                <h6 class="fw-bold mb-0 text-success">WhatsApp Business API</h6>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="whatsapp_access" value="1" {{ ($globalSettings->get('api_credentials', collect())->where('key', 'whatsapp_access')->first()->value ?? '0') == '1' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="card-body pt-3">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">ACCESS TOKEN</label>
                                                    <textarea name="whatsapp_access_token" rows="3" class="form-control">{{ $globalSettings->get('api_credentials', collect())->where('key', 'whatsapp_access_token')->first()->value ?? '' }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">PHONE NUMBER ID / APP ID</label>
                                                    <input type="text" name="whatsapp_app_id" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'whatsapp_app_id')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- HotelBeds & TravelPayouts -->
                                    <div class="col-md-6">
                                        <div class="card h-100 shadow-sm border-0 rounded-4">
                                            <div class="card-header bg-info bg-opacity-10 py-3">
                                                <h6 class="fw-bold mb-0 text-info">HotelBeds Configuration</h6>
                                            </div>
                                            <div class="card-body pt-3">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">API KEY</label>
                                                    <input type="text" name="hotelbeds_api_key" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'hotelbeds_api_key')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">API SECRET</label>
                                                    <input type="password" name="hotelbeds_api_secret" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'hotelbeds_api_secret')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card h-100 shadow-sm border-0 rounded-4">
                                            <div class="card-header bg-warning bg-opacity-10 py-3">
                                                <h6 class="fw-bold mb-0 text-warning">TravelPayouts Configuration</h6>
                                            </div>
                                            <div class="card-body pt-3">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">API TOKEN</label>
                                                    <input type="text" name="travelpayouts_token" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'travelpayouts_token')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">MARKER ID</label>
                                                    <input type="text" name="travelpayouts_marker" value="{{ $globalSettings->get('api_credentials', collect())->where('key', 'travelpayouts_marker')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-4 mb-5">
                                        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow-lg">Save API Credentials</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 4: Payments -->
                        <div class="tab-pane fade" id="tab-payments">
                            <div class="card shadow-sm border-0 rounded-4 mb-4">
                                <h5 class="card-header fw-bold border-bottom py-3">Payment Gateway Configurations</h5>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.payments.update') }}" method="POST">
                                        @csrf
                                        
                                        <!-- MPGS Card -->
                                        <div class="payment-card p-4 border rounded-4 mb-4 bg-white shadow-sm border-start border-primary border-4">
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/img/payment/commercial_bank.png') }}" height="40" class="me-3">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Commercial Bank of Sri Lanka (MPGS)</h6>
                                                        <small class="text-muted">Mastercard Gateway Services</small>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="payment_mpgs_enabled" value="1" {{ ($globalSettings->get('payments', collect())->where('key', 'payment_mpgs_enabled')->first()->value ?? '0') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold">Enabled</label>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label small fw-bold">MERCHANT ID</label>
                                                    <input type="text" name="payment_mpgs_merchant_id" value="{{ $globalSettings->get('payments', collect())->where('key', 'payment_mpgs_merchant_id')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label small fw-bold">API PASSWORD</label>
                                                    <input type="password" name="payment_mpgs_api_password" value="{{ $globalSettings->get('payments', collect())->where('key', 'payment_mpgs_api_password')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">API BASE URL</label>
                                                    <input type="text" name="payment_mpgs_api_base_url" value="{{ $globalSettings->get('payments', collect())->where('key', 'payment_mpgs_api_base_url')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label small fw-bold">CURRENCY</label>
                                                    <input type="text" name="payment_mpgs_currency" value="{{ $globalSettings->get('payments', collect())->where('key', 'payment_mpgs_currency')->first()->value ?? 'LKR' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Stripe Card -->
                                        <div class="payment-card p-4 border rounded-4 mb-4 bg-white shadow-sm border-start border-dark border-4">
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="30" class="me-3">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Stripe Payments</h6>
                                                        <small class="text-muted">Global card processing</small>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="payment_stripe_enabled" value="1" {{ ($globalSettings->get('payments', collect())->where('key', 'payment_stripe_enabled')->first()->value ?? '0') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold">Enabled</label>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">STRIPE PUBLISHABLE KEY</label>
                                                    <input type="text" name="payment_stripe_publishable_key" value="{{ $globalSettings->get('payments', collect())->where('key', 'payment_stripe_publishable_key')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">STRIPE SECRET KEY</label>
                                                    <input type="password" name="payment_stripe_secret_key" value="{{ $globalSettings->get('payments', collect())->where('key', 'payment_stripe_secret_key')->first()->value ?? '' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">Save All Payments</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 5: SMTP -->
                        <div class="tab-pane fade" id="tab-smtp">
                            <div class="card shadow-sm border-0 rounded-4">
                                <h5 class="card-header fw-bold border-bottom py-3">SMTP Mail Server Settings</h5>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.smtp.update') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">MAIL HOST</label>
                                                <input type="text" name="mail_host" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_host')->first()->value ?? '' }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">MAIL PORT</label>
                                                <input type="text" name="mail_port" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_port')->first()->value ?? '587' }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">MAIL ENCRYPTION</label>
                                                <input type="text" name="mail_encryption" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_encryption')->first()->value ?? 'tls' }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">MAIL USERNAME</label>
                                                <input type="text" name="mail_username" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_username')->first()->value ?? '' }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">MAIL PASSWORD</label>
                                                <input type="password" name="mail_password" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_password')->first()->value ?? '' }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">MAIL FROM ADDRESS</label>
                                                <input type="text" name="mail_from_address" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_from_address')->first()->value ?? '' }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">MAIL FROM NAME</label>
                                                <input type="text" name="mail_from_name" value="{{ $globalSettings->get('smtp', collect())->where('key', 'mail_from_name')->first()->value ?? '' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">Save Mail Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 6: General -->
                        <div class="tab-pane fade" id="tab-general">
                            <div class="card shadow-sm border-0 rounded-4">
                                <h5 class="card-header fw-bold border-bottom py-3">General Key-Value Configurations</h5>
                                <div class="card-body pt-4">
                                    <form action="{{ route('admin.settings.global.update') }}" method="POST">
                                        @csrf
                                        <div class="row g-4">
                                            @foreach($globalSettings as $group => $items)
                                                @if(!in_array($group, ['services', 'payments', 'smtp', 'api_credentials', 'markup']))
                                                    @php $filteredItems = $items->filter(fn($i) => !str_starts_with($i->key, 'payment_') && !str_starts_with($i->key, 'stripe_')); @endphp
                                                    @if($filteredItems->isNotEmpty())
                                                    <div class="col-12 mt-4"><h6 class="text-uppercase text-navy small fw-bold mb-3 border-bottom pb-2">{{ $group }} Settings</h6></div>
                                                    @foreach($filteredItems as $item)
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">{{ strtoupper(str_replace('_', ' ', $item->key)) }}</label>
                                                            <input type="text" name="settings[{{ $item->key }}]" value="{{ $item->value }}" class="form-control">
                                                        </div>
                                                    @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">Save General Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-color: #696cff !important; }
    .transition { transition: all 0.3s ease; }
    .text-navy { color: #2c3e50; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
</style>
@endsection

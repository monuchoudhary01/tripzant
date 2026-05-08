@extends('layouts.admin')

@section('title', 'System Settings | Command Center')

@section('admin_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings /</span> Global Configuration</h4>
            
            @if(session('success'))
            <div class="alert alert-primary alert-dismissible shadow-sm border-0 mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-services">
                                <i class="bx bx-grid-alt me-1"></i> Service Visibility
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-markup">
                                <i class="bx bx-trending-up me-1"></i> Markup Settings
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-api">
                                <i class="bx bx-chip me-1"></i> API Configs
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-general">
                                <i class="bx bx-cog me-1"></i> General Settings
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-0 bg-transparent border-0 shadow-none">
                        <!-- Tab 1: Service Visibility -->
                        <div class="tab-pane fade show active" id="tab-services">
                            <div class="card mb-4">
                                <h5 class="card-header fw-bold">Modular Service Control</h5>
                                <div class="card-body">
                                    <p class="text-muted small mb-4">Toggle these switches to enable or disable specific travel modules across the entire platform.</p>
                                    
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
                                            <div class="col-md-4 col-sm-6">
                                                <div class="d-flex align-items-center justify-content-between p-3 border rounded-3 bg-white hover-shadow transition">
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge bg-label-primary p-2 rounded me-3">
                                                            <i class="bx {{ $service['icon'] }} fs-4"></i>
                                                        </div>
                                                        <span class="fw-semibold text-dark">{{ $service['label'] }}</span>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        @php
                                                            $isEnabled = $globalSettings->get('services', collect())->where('key', $service['key'])->first()->value ?? '1';
                                                        @endphp
                                                        <input class="form-check-input" type="checkbox" name="{{ $service['key'] }}" value="1" {{ $isEnabled == '1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="mt-5">
                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Save Service Status</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Markup Settings -->
                        <div class="tab-pane fade" id="tab-markup">
                            <div class="card mb-4">
                                <h5 class="card-header fw-bold">Standard Revenue Markups</h5>
                                <div class="card-body">
                                    <form action="{{ route('admin.settings.markup.update') }}" method="POST">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Service Module</th>
                                                        <th>Agent Role</th>
                                                        <th>Markup Type</th>
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
                                            <button type="submit" class="btn btn-primary px-5">Update Markups</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: API Configs -->
                        <div class="tab-pane fade" id="tab-api">
                            <div class="card mb-4">
                                <h5 class="card-header fw-bold">Internal API Controls</h5>
                                <div class="card-body">
                                    <form action="{{ route('admin.settings.api-configs.update') }}" method="POST">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Provider Name</th>
                                                        <th>Environment</th>
                                                        <th>Priority</th>
                                                        <th>Active Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($apiConfigs as $config)
                                                    <tr>
                                                        <td><div class="fw-bold">{{ strtoupper($config->provider) }}</div><small class="text-muted">{{ $config->service_type }}</small></td>
                                                        <td><span class="badge bg-label-{{ $config->environment == 'production' ? 'success' : 'warning' }}">{{ strtoupper($config->environment) }}</span></td>
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
                                            <button type="submit" class="btn btn-primary px-5">Save API Priorities</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 4: General Settings -->
                        <div class="tab-pane fade" id="tab-general">
                            <div class="card mb-4">
                                <h5 class="card-header fw-bold">Platform Key-Value Configurations</h5>
                                <div class="card-body">
                                    <form action="{{ route('admin.settings.global.update') }}" method="POST">
                                        @csrf
                                        <div class="row g-4">
                                            @foreach($globalSettings as $group => $items)
                                                @if($group != 'services')
                                                    <div class="col-12"><h6 class="text-uppercase text-muted small fw-bold mb-3 border-bottom pb-2">{{ $group }} Settings</h6></div>
                                                    @foreach($items as $item)
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small">{{ strtoupper(str_replace('_', ' ', $item->key)) }}</label>
                                                            <input type="text" name="settings[{{$item->key}}]" value="{{ $item->value }}" class="form-control">
                                                            @if($item->description)
                                                                <div class="form-text x-small text-muted">{{ $item->description }}</div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            
                                            <div class="col-12 mt-4">
                                                <button type="submit" class="btn btn-primary px-5">Update Global Settings</button>
                                            </div>
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
    .hover-shadow:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-color: #696cff !important; }
    .transition { transition: all 0.2s ease; }
    .x-small { font-size: 11px; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
</style>
@endsection

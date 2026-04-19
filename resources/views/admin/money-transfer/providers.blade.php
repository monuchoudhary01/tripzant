@extends('layouts.admin')

@section('title', 'Manage Transfer Providers | Admin')

@section('admin_content')
<div class="row mb-5">
    <div class="col-md-8">
        <h2 class="fw-900 text-navy mb-1">Transfer Providers & Logic</h2>
        <p class="text-muted">Configure external API integrations and set commission rules for international transfers.</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('admin.money-transfer.index') }}" class="btn btn-light shadow-sm border rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> All Transfers
        </a>
    </div>
</div>

<div class="row g-4">
    @foreach($providers as $provider)
    <div class="col-md-6 mb-4">
        <div class="card-admin">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-navy text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; background-color: {{ $provider->slug == 'wallet' ? '#0b3d61' : '#ff6e00' }}">
                        {{ strtoupper(substr($provider->slug, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="fw-900 mb-0 text-navy">{{ $provider->name }}</h5>
                        <span class="badge border text-muted small">{{ strtoupper($provider->type) }}</span>
                    </div>
                </div>
                <div class="form-check form-switch p-0 m-0">
                    <input class="form-check-input ms-0 me-2" type="checkbox" style="width: 40px; height: 20px;" {{ $provider->is_active ? 'checked' : '' }} disabled>
                    <span class="small fw-bold text-{{ $provider->is_active ? 'success' : 'danger' }}">{{ $provider->is_active ? 'Active' : 'Offline' }}</span>
                </div>
            </div>

            <form action="{{ route('admin.money-transfer.providers.update', $provider->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold text-muted">BASE FEE (FIXED)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">A$</span>
                            <input type="number" name="base_fee" step="0.01" class="form-control border-0 bg-light" value="{{ $provider->base_fee }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold text-muted">OUR COMMISSION (%)</label>
                        <div class="input-group">
                            <input type="number" name="fee_percentage" step="0.01" class="form-control border-0 bg-light" value="{{ $provider->fee_percentage }}">
                            <span class="input-group-text bg-light border-0 px-3">%</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">ESTIMATED DELIVERY (MINUTES)</label>
                        <input type="number" name="estimated_delivery_minutes" class="form-control border-0 bg-light" value="{{ $provider->estimated_delivery_minutes }}">
                    </div>

                    <!-- API CONFIG SECTION -->
                    <div class="col-12 mt-3">
                        <div class="bg-light p-3 rounded-3 border">
                            <h6 class="fw-bold small mb-3 text-uppercase"><i class="fas fa-key me-2"></i> Advanced API Settings</h6>
                            @php
                                $config = $provider->config ?? [];
                            @endphp
                            
                            @if($provider->slug == 'wise')
                                <div class="mb-2">
                                    <label class="small text-muted">WISE API TOKEN</label>
                                    <input type="password" name="config[api_token]" class="form-control form-control-sm" value="{{ $config['api_token'] ?? '' }}" placeholder="w_live_...">
                                </div>
                                <div class="mb-2">
                                    <label class="small text-muted">PROFILE ID</label>
                                    <input type="text" name="config[profile_id]" class="form-control form-control-sm" value="{{ $config['profile_id'] ?? '' }}">
                                </div>
                            @elseif($provider->slug == 'stripe')
                                <div class="mb-2">
                                    <label class="small text-muted">STRIPE SECRET KEY</label>
                                    <input type="password" name="config[secret_key]" class="form-control form-control-sm" value="{{ $config['secret_key'] ?? '' }}" placeholder="sk_live_...">
                                </div>
                                <div class="mb-2">
                                    <label class="small text-muted">WEBHOOK SECRET</label>
                                    <input type="password" name="config[webhook_secret]" class="form-control form-control-sm" value="{{ $config['webhook_secret'] ?? '' }}" placeholder="whsec_...">
                                </div>
                            @elseif($provider->slug == 'razorpay')
                                <div class="mb-2">
                                    <label class="small text-muted">KEY ID</label>
                                    <input type="text" name="config[key_id]" class="form-control form-control-sm" value="{{ $config['key_id'] ?? '' }}" placeholder="rzp_live_...">
                                </div>
                                <div class="mb-2">
                                    <label class="small text-muted">KEY SECRET</label>
                                    <input type="password" name="config[key_secret]" class="form-control form-control-sm" value="{{ $config['key_secret'] ?? '' }}">
                                </div>
                            @else
                                <p class="small text-muted mb-0">No external API configuration needed for internal wallet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-admin-primary w-100 py-3 rounded-3 shadow">
                            Save Configuration Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

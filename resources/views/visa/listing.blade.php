@extends('layouts.app')

@section('title', "Visa Requirements for Your Destination | Trip Zant")

@section('styles')
<style>
    .visa-list-header {
        background: var(--navy); padding: 60px 0; color: #fff;
    }
    .visa-card-p {
        background: #fff; border-radius: 20px; border: 1px solid #f1f5f9;
        transition: 0.3s; height: 100%;
    }
    .visa-card-p:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); border-color: var(--primary); }
    .visa-fee-badge { font-size: 24px; font-weight: 900; color: var(--navy); }
</style>
@endsection

@section('content')
<div class="visa-list-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 text-white-50 small">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('visa.index') }}" class="text-white-50">Visa</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Listings</li>
                </ol>
            </nav>
            <h2 class="fw-900 mb-0">94 Visa Options Found</h2>
        </div>
        <button class="btn btn-outline-light rounded-pill px-4 fw-bold small"><i class="fas fa-pen me-2"></i>Modify Search</button>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h6 class="fw-900 text-navy mb-4">Filters</h6>
                <div class="mb-4">
                    <label class="small fw-700 text-muted mb-2">REGION</label>
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check"><input class="form-check-input" type="checkbox" checked><label class="form-check-label fw-bold small">Middle East</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label fw-bold small">Asia</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label fw-bold small">Europe</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label fw-bold small">Africa</label></div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="small fw-700 text-muted mb-2">PROCESSING TIME</label>
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label fw-bold small">Instant / 1 Day</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label fw-bold small">3-5 Days</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label fw-bold small">10+ Days</label></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="col-lg-9">
            <div class="row g-4">
                @php
                $visas = [
                    ['country' => 'United Arab Emirates', 'flag' => '🇦🇪', 'type' => 'Tourist (30 Days)', 'time' => '3–5 days', 'fee' => '₹6,450', 'approval' => '99.5%'],
                    ['country' => 'Thailand', 'flag' => '🇹🇭', 'type' => 'E-Visa (30 Days)', 'time' => '1–3 days', 'fee' => '₹2,500', 'approval' => '99.8%'],
                    ['country' => 'Vietnam', 'flag' => '🇻🇳', 'type' => 'Tourist E-Visa', 'time' => '3 days', 'fee' => '₹2,100', 'approval' => '99.1%'],
                    ['country' => 'Singapore', 'flag' => '🇸🇬', 'type' => 'Tourist Visa', 'time' => '4–5 days', 'fee' => '₹2,600', 'approval' => '98.5%'],
                    ['country' => 'Sri Lanka', 'flag' => '🇱🇰', 'type' => 'ETA (30 Days)', 'time' => 'Instant', 'fee' => '₹3,200', 'approval' => '99.9%'],
                    ['country' => 'Saudi Arabia', 'flag' => '🇸🇦', 'type' => 'Family Visit', 'time' => '3 days', 'fee' => '₹8,500', 'approval' => '97.2%'],
                ];
                @endphp
                @foreach($visas as $v)
                <div class="col-md-6 mb-4">
                    <div class="visa-card-p p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-900 text-navy mb-0">{{ $v['country'] }} <span class="ms-2 fs-5">{{ $v['flag'] }}</span></h4>
                            <span class="badge bg-success-light text-success fw-bold x-small rounded-pill px-3">{{ $v['approval'] }} Approval Rate</span>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded-3">
                                <i class="fas fa-id-card text-primary opacity-50 small"></i>
                                <span class="small fw-700 text-navy">{{ $v['type'] }}</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2 border rounded-3 text-center">
                                        <div class="x-small text-muted fw-bold">PROCESSING</div>
                                        <div class="small fw-900 text-navy">{{ $v['time'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded-3 text-center">
                                        <div class="x-small text-muted fw-bold">DOCUMENTS</div>
                                        <div class="small fw-900 text-navy">View Checklist</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                             <div>
                                 <div class="x-small text-muted fw-bold">TOTAL FEE</div>
                                 <div class="visa-fee-badge">{{ $v['fee'] }}</div>
                             </div>
                             <a href="{{ route('visa.detail', ['country' => strtolower($v['country'])]) }}" class="btn btn-navy px-4 rounded-pill fw-bold hvr-grow">Apply Now <i class="fas fa-arrow-right ms-2 fs-x-small"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

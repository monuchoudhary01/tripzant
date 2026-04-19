@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background-color: #f0f2f5; min-height: 100vh;">
    <div class="container">
        <!-- Search Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white p-4 rounded-4 shadow-sm d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">Comparing {{ count($providers) }} providers</h4>
                        <p class="mb-0 text-muted">Sending <span class="fw-bold">{{ number_format($amount, 2) }} {{ $from }}</span> to <span class="fw-bold">{{ $toCountry }}</span> in <span class="fw-bold">{{ $to }}</span></p>
                    </div>
                    <div class="d-flex align-items-center bg-light p-3 rounded-3">
                        <div class="me-3">
                            <small class="d-block text-muted fw-bold">Current Rate</small>
                            <span class="fw-bold">1 {{ $from }} = {{ $rate }} {{ $to }}</span>
                        </div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Graph_icon.svg/512px-Graph_icon.svg.png" style="width: 40px; height: 30px; opacity: 0.5;">
                    </div>
                    <a href="{{ route('money-transfer.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Change</a>
                </div>
            </div>
        </div>

        <!-- Transfer Type Tabs (Mobile, Bank, Cash) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <div class="bg-white border-bottom border-3 border-primary p-3 rounded-top-3 shadow-sm text-center" style="min-width: 150px;">
                        <i class="fas fa-university d-block mb-2 text-primary"></i>
                        <span class="small fw-bold">Bank Account</span>
                        <div class="fw-bold text-navy">{{ number_format($amount * $rate, 0) }} {{ $to }}</div>
                    </div>
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center opacity-50" style="min-width: 150px;">
                        <i class="fas fa-money-bill-wave d-block mb-2"></i>
                        <span class="small fw-bold">Cash Pickup</span>
                        <div class="fw-bold text-navy">{{ number_format($amount * $rate * 0.99, 0) }} {{ $to }}</div>
                    </div>
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center opacity-50" style="min-width: 150px;">
                        <i class="fas fa-mobile-alt d-block mb-2"></i>
                        <span class="small fw-bold">Mobile Wallet</span>
                        <div class="fw-bold text-navy">{{ number_format($amount * $rate * 0.985, 0) }} {{ $to }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Providers List -->
        <div class="row">
            <div class="col-12">
                @foreach($providers as $provider)
                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden {{ $provider['best_deal'] ? 'border-start border-5 border-success' : '' }}">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <!-- Provider Score & Logo -->
                            <div class="col-md-2 p-4 text-center border-end">
                                <div class="position-relative d-inline-block mb-3">
                                    <svg viewBox="0 0 36 36" style="width: 60px; height: 60px;">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#eee" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{{ $provider['best_deal'] ? '#28a745' : '#00b9ff' }}" stroke-width="3" stroke-dasharray="{{ $provider['score'] * 10 }}, 100" />
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle fw-bold small">{{ $provider['score'] }}</div>
                                </div>
                                <div class="fw-bold mb-1">{{ $provider['name'] }}</div>
                                @if($provider['best_deal'])
                                <span class="badge bg-success small">Best deal</span>
                                @endif
                                <div class="small text-muted mt-2">Our score</div>
                            </div>

                            <!-- Transfer Details -->
                            <div class="col-md-3 p-4 border-end">
                                <div class="mb-3">
                                    <small class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem">Transfer Time</small>
                                    <div class="fw-bold fs-5">{{ $provider['delivery'] }}</div>
                                    <small class="text-muted">Pay by Wallet/Bank</small>
                                </div>
                                <a href="#" class="small text-primary text-decoration-none fw-bold">+ More payment options</a>
                            </div>

                            <!-- Fees & Rates -->
                            <div class="col-md-3 p-4 border-end">
                                <div class="mb-3">
                                    <small class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem">Fee & Rates</small>
                                    <div class="fw-bold">Fee: <span class="text-{{ $provider['fee'] == 0 ? 'success' : 'dark' }}">{{ $provider['fee'] == 0 ? 'FREE' : number_format($provider['fee'], 2) . ' ' . $from }}</span></div>
                                    <div class="small mt-1">Exchange rate: <span class="fw-bold">{{ $provider['rate'] }}</span></div>
                                    @php 
                                        $diff = (($provider['rate'] - $rate) / $rate) * 100;
                                    @endphp
                                    <small class="{{ $diff >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                        {{ abs(round($diff, 2)) }}% {{ $diff >= 0 ? 'better' : 'worse' }} 
                                        <span class="text-muted fw-normal">than mid-market rate</span>
                                    </small>
                                </div>
                            </div>

                            <!-- Receiver Stats -->
                            <div class="col-md-4 p-4 d-flex justify-content-between align-items-center">
                                <div class="text-end flex-grow-1 me-4">
                                    <small class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem">Recipient gets</small>
                                    <div class="fw-bold fs-3 text-navy">{{ number_format(($amount - $provider['fee']) * $provider['rate'], 0) }} {{ $to }}</div>
                                    <div class="text-muted small text-decoration-line-through">{{ number_format($amount * $rate, 0) }} {{ $to }}</div>
                                </div>
                                <a href="{{ route('money-transfer.form', $provider['slug']) }}" class="btn btn-primary btn-lg shadow rounded-3 px-4 fw-bold">
                                    Go to {{ $provider['name'] }} <i class="fas fa-chevron-right ms-2" style="font-size: 0.8rem"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #0d1b3e; }
    .btn-primary { background-color: #ff6e00; border-color: #ff6e00; }
    .btn-primary:hover { background-color: #e66300; border-color: #e66300; }
    .border-navy { border-color: #0d1b3e !important; }
</style>
@endsection

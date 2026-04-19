@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header {{ $status == 'Authentic' ? 'bg-success' : 'bg-danger' }} text-white text-center py-4">
                    @if($status == 'Authentic')
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h2 class="fw-bold mb-0">SHIPMENT VERIFIED</h2>
                        <small class="text-uppercase ls-1">Tax Exemption Certified by TripZant Global</small>
                    @else
                        <i class="fas fa-times-circle fa-4x mb-3"></i>
                        <h2 class="fw-bold mb-0">INVALID RECORD</h2>
                        <small class="text-uppercase ls-1">Verification failed</small>
                    @endif
                </div>
                <div class="card-body p-5">
                    @if($status == 'Authentic')
                        <div class="row g-4">
                            <div class="col-md-6 border-end">
                                <h6 class="text-muted small fw-bold uppercase mb-3">Logistics Details</h6>
                                <p class="mb-1"><span class="text-muted">Tracking ID:</span> <span class="fw-bold">{{ $letter->tracking_id }}</span></p>
                                <p class="mb-1"><span class="text-muted">Status:</span> <span class="badge bg-success">CERTIFIED</span></p>
                                <p class="mb-1"><span class="text-muted">Issue Date:</span> {{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted small fw-bold uppercase mb-3">Shipment Purpose</h6>
                                <div class="p-3 bg-light rounded-3">
                                    <h5 class="fw-bold mb-1 text-primary">{{ $item->cat }}</h5>
                                    <p class="small text-muted mb-0">Exemption Scope: Personal / Gift / Non-Commercial</p>
                                </div>
                            </div>

                            <div class="col-12 border-top pt-4 mt-4">
                                <h6 class="text-muted small fw-bold uppercase mb-3">Itemized Declaration</h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td class="text-muted">Description:</td><td class="fw-bold">{{ $item->desc }}</td></tr>
                                    <tr><td class="text-muted">Declared Value:</td><td class="fw-bold text-success">${{ number_format($item->val, 2) }} AUD</td></tr>
                                    <tr><td class="text-muted">Consignor:</td><td class="fw-bold">{{ $sender->name }} ({{ $sender->origin }})</td></tr>
                                    <tr><td class="text-muted">Consignee:</td><td class="fw-bold">{{ $receiver->name }} ({{ $receiver->dest }})</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <p class="small text-muted mb-0 font-monospace">DIGITAL_ID: {{ hash('sha256', $letter->tracking_id) }}</p>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(url('/cargo/verify/'.$letter->tracking_id)) }}" class="mt-3">
                        </div>
                    @else
                        <div class="text-center py-4">
                            <h4 class="text-muted mb-3">{{ $msg }}</h4>
                            <p>If you believe this is an error, contact help@tripzant.com</p>
                            <a href="/" class="btn btn-outline-primary rounded-pill px-4 mt-3">Back to Home</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

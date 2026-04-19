@extends('layouts.b2b_master')

@section('title', 'Email & SMS Settings | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Email & SMS Settings</h4>
        <p class="text-muted small mb-0">Manage communication addresses for invoices, alerts, and ticketing notifications.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.settings') }}">Agency Settings</a></li>
            <li class="breadcrumb-item active">Email & SMS</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="b2b-table-card p-4">
            <h6 class="mb-4">Email Notifications Configuration</h6>
            <div class="mb-3">
                <label class="form-label-b2b">Primary Invoicing Email</label>
                <input type="email" class="form-control form-control-b2b" value="accounts@amadeus-global.com">
            </div>
            <div class="mb-3">
                <label class="form-label-b2b">Ticketing Alert Email</label>
                <input type="email" class="form-control form-control-b2b" value="ops@amadeus-global.com">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" checked id="sendInvoice">
                <label class="form-check-label small fw-600" for="sendInvoice">Automatically send copy of invoice to agent</label>
            </div>
            <button class="btn btn-primary btn-sm px-4 fw-700 w-100 py-3 mt-3">UPDATE EMAIL SETTINGS</button>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="b2b-table-card p-4 h-100 d-flex flex-column">
            <h6 class="mb-4">SMS Alert Configuration</h6>
            <div class="mb-3">
                <label class="form-label-b2b">Default SMS Recipient Number</label>
                <input type="text" class="form-control form-control-b2b" value="+91 1234567890">
            </div>
             <div class="mb-3 mt-auto">
                 <div class="alert alert-info py-2" style="font-size: 13px;">
                    <i class="fas fa-info-circle me-1"></i> SMS alerts are sent for high-priority events only (e.g. Credit Exhausted, Refund Processed).
                 </div>
             </div>
            <button class="btn btn-outline-info btn-sm px-4 fw-700 w-100 py-3">SAVE SMS SETTINGS</button>
        </div>
    </div>
</div>
@endsection

@extends('layouts.b2b_master')

@section('title', 'Group Booking Request | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Group Booking Request</h4>
        <p class="text-muted small mb-0">Submit new group booking requests (10+ passengers) for manual quotes.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Group Request</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="b2b-table-card p-4 mx-auto" style="max-width: 900px;">
            <h5 class="mb-4">Submit New Group Query</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label-b2b">Origin <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-b2b" placeholder="e.g. DEL (Delhi, India)">
                </div>
                <div class="col-md-6">
                    <label class="form-label-b2b">Destination <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-b2b" placeholder="e.g. DXB (Dubai, UAE)">
                </div>
                <div class="col-md-6">
                    <label class="form-label-b2b">Travel Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-b2b">
                </div>
                <div class="col-md-3">
                    <label class="form-label-b2b">No. of Adults <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-b2b" min="10" placeholder="Min 10">
                </div>
                <div class="col-md-3">
                    <label class="form-label-b2b">No. of Children/Infants</label>
                    <input type="number" class="form-control form-control-b2b" min="0" placeholder="Optional">
                </div>
                <div class="col-md-12">
                    <label class="form-label-b2b">Additional Requirements / Notes</label>
                    <textarea class="form-control form-control-b2b" rows="4" placeholder="Mention preferred airlines, flex dates or special requests..."></textarea>
                </div>
                <div class="col-md-12">
                     <div class="p-3 mb-4 rounded-3 text-muted border border-warning-subtle bg-warning-subtle" style="font-size: 13px;">
                        <i class="fas fa-info-circle me-2 text-warning"></i>
                        Group quotes typically take 2-6 business hours during operation times.
                    </div>
                    <button class="btn btn-b2b-primary w-100 py-3">SUBMIT QUOTE REQUEST</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

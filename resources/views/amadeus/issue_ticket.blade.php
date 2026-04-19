@extends('layouts.b2b_master')

@section('title', 'Issue Ticket | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Issue Ticket</h4>
        <p class="text-muted small mb-0">Review PNR details and issue ticket from your balance/credit.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Issue Ticket</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="b2b-table-card p-4">
            <h5 class="mb-4">PNR Lookup</h5>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label-b2b">Enter Amadeus PNR / Booking Reference</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control form-control-b2b border-start-0" placeholder="e.g. AB12CD">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-b2b-primary w-100 py-2">RETRIEVE DETAILS</button>
                </div>
            </div>
            
            <div class="mt-5 p-5 text-center bg-light rounded-4 border border-dashed">
                <div class="mb-3 text-muted">
                    <i class="fas fa-ticket-alt fa-3x opacity-25"></i>
                </div>
                <h6 class="fw-700">No PNR Retrieved Yet</h6>
                <p class="text-muted small">Enter a valid Amadeus PNR above to fetch passenger and fare details for ticketing.</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="b2b-table-card p-4 bg-primary text-white">
            <h5 class="mb-3">Ticketing Policy</h5>
            <ul class="list-unstyled small mb-0">
                <li class="mb-3 d-flex gap-2">
                    <i class="fas fa-check-circle mt-1"></i>
                    <span>Tkt issuance is subject to available wallet balance or credit limit.</span>
                </li>
                <li class="mb-3 d-flex gap-2">
                    <i class="fas fa-check-circle mt-1"></i>
                    <span>Ensure passenger names exactly match passport/ID before issuance.</span>
                </li>
                <li class="mb-3 d-flex gap-2">
                    <i class="fas fa-check-circle mt-1"></i>
                    <span>Voiding options depend on airline rules (usually within 24hrs).</span>
                </li>
            </ul>
        </div>
        
        <div class="b2b-table-card p-4 mt-4">
            <h6 class="fw-700 mb-3">Recent Ticketed PNRs</h6>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-700 text-primary">XY78WQ</div>
                        <div class="text-muted" style="font-size: 11px;">10 Apr 2024, 14:20</div>
                    </div>
                    <span class="badge bg-success-subtle text-success small">SUCCESS</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-700 text-primary">PR992K</div>
                        <div class="text-muted" style="font-size: 11px;">09 Apr 2024, 11:05</div>
                    </div>
                    <span class="badge bg-success-subtle text-success small">SUCCESS</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.b2b_master')

@section('title', 'Add Balance Request | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Wallet Top-up Request</h4>
        <p class="text-muted small mb-0">Submit a top-up request via Bank Transfer or Online PG to increase your ticketing balance.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Wallet Top-up</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="b2b-table-card p-4">
            <h5 class="mb-4">Submit Top-up Request</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label-b2b">Amount to Add (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-b2b" placeholder="e.g. 50,000">
                </div>
                <div class="col-md-6">
                    <label class="form-label-b2b">Payment Mode <span class="text-danger">*</span></label>
                    <select class="form-select form-control-b2b">
                        <option value="">Select Mode</option>
                        <option value="NEFT">NEFT / RTGS</option>
                        <option value="IMPS">IMPS Transfer</option>
                        <option value="UPI">UPI Transaction</option>
                        <option value="CASH">Cash Deposit</option>
                    </select>
                </div>
                 <div class="col-md-6">
                    <label class="form-label-b2b">Transaction Reference ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-b2b" placeholder="UTR Number or UPI Ref">
                </div>
                <div class="col-md-6">
                    <label class="form-label-b2b">Upload Receipt (Optional)</label>
                    <input type="file" class="form-control form-control-b2b">
                </div>
                <div class="col-md-12">
                    <label class="form-label-b2b">Remarks</label>
                    <textarea class="form-control form-control-b2b" rows="3" placeholder="Optional notes for accounts team..."></textarea>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-b2b-primary w-100 py-3 mt-2">SUBMIT TOP-UP REQUEST</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="b2b-table-card p-4 bg-light border">
            <h6 class="fw-700 mb-3">Our Bank Details</h6>
            <div class="small mb-4">
                <div class="text-muted fw-700 uppercase" style="font-size: 10px;">Bank Name</div>
                <div class="fw-700 mb-2">HDFC Bank Ltd.</div>
                
                <div class="text-muted fw-700 uppercase" style="font-size: 10px;">Account Holder</div>
                <div class="fw-700 mb-2">TRIPZANT TRAVELS PVT LTD</div>
                
                <div class="text-muted fw-700 uppercase" style="font-size: 10px;">Account Number</div>
                <div class="fw-700 mb-2 font-monospace">50201192837462</div>
                
                <div class="text-muted fw-700 uppercase" style="font-size: 10px;">IFSC Code</div>
                <div class="fw-700 mb-2 font-monospace">HDFC0001029</div>
            </div>
            
            <div class="alert alert-warning border-0 small mb-0 py-2">
                <i class="fas fa-info-circle me-1"></i> Ensure to share the UTR/Ref ID for faster approvals.
            </div>
        </div>
    </div>
</div>
@endsection

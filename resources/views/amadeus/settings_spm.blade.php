@extends('layouts.b2b_master')

@section('title', 'SPM Default Settings | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">SPM Default Settings</h4>
        <p class="text-muted small mb-0">Define global default parameters for Service Portfolio Management.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('amadeus.settings') }}">Agency Settings</a></li>
            <li class="breadcrumb-item active">SPM Defaults</li>
        </ol>
    </nav>
</div>

<div class="b2b-table-card p-4">
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label-b2b">Default Markup Type</label>
            <select class="form-select form-control-b2b">
                <option>Percentage (%)</option>
                <option>Fixed Amount (Flat)</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label-b2b">Default Service Fee</label>
            <input type="text" class="form-control form-control-b2b" value="0.00">
        </div>
        <div class="col-md-12">
            <div class="form-check form-switch mt-3">
                <input class="form-check-input" type="checkbox" id="autoApply" checked>
                <label class="form-check-label fw-600" for="autoApply">Auto-apply default markup to all new sub-agents</label>
            </div>
        </div>
        <div class="col-md-12 pt-4 border-top">
            <button class="btn btn-b2b-primary px-5 py-2">SAVE SPM DEFAULTS</button>
        </div>
    </div>
</div>
@endsection

@extends('layouts.hotel_master')

@section('title', 'Sent Proposals | QuikHotel Terminal')

@section('styles')
<style>
    .h-quote-row { background: #fff; border-radius: 16px; border: 1px solid var(--h-border); padding: 22px 30px; display: flex; align-items: center; margin-bottom: 15px; position: relative; }
    .h-quote-row:hover { border-color: var(--h-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }
    .dot-pending { background: #facc15; }
    .dot-active { background: #3b82f6; }
    .dot-won { background: #22c55e; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-end">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px;">Quotation Pipeline</h2>
        <p class="text-muted fw-600 mb-0">Track all active proposals sent to agents and direct customers.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="h-glass-card border-0 shadow-sm p-4 text-center">
            <h4 class="outfit fw-900 text-primary mb-1">₹1.42Cr</h4>
            <div class="tiny fw-700 text-muted uppercase">Proposal Volume</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="h-glass-card border-0 shadow-sm p-4 text-center">
            <h4 class="outfit fw-900 text-warning mb-1">12</h4>
            <div class="tiny fw-700 text-muted uppercase">Awaiting Response</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="h-glass-card border-0 shadow-sm p-4 text-center">
             <h4 class="outfit fw-900 text-success mb-1">68.5%</h4>
             <div class="tiny fw-700 text-muted uppercase">Acceptance Ratio</div>
        </div>
    </div>
</div>

<!-- List of Proposals -->
<div class="h-quote-row">
    <div style="width: 120px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Quote ID</div>
        <div class="fw-800 text-navy">#PRO-8812</div>
    </div>
    <div class="flex-grow-1 px-4">
        <div class="tiny fw-800 text-muted uppercase mb-1">Destination & Lead</div>
        <div class="fw-800 text-navy">Australia Group (Sydney) • Mark Agency</div>
    </div>
    <div style="width: 180px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Proposed Value</div>
        <div class="fw-900 text-primary outfit" style="font-size: 16px;">₹5,00,000</div>
    </div>
    <div style="width: 200px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Status</div>
        <div class="fw-800 text-navy small"><span class="status-dot dot-active"></span> Negotiating (Chat)</div>
    </div>
    <div class="text-end">
        <button class="btn btn-outline-primary btn-sm px-4 fw-800 rounded-pill" onclick="location.href='{{ route('hotel.details') }}'">REOPEN CHAT</button>
    </div>
</div>

<div class="h-quote-row">
    <div style="width: 120px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Quote ID</div>
        <div class="fw-800 text-navy">#PRO-8815</div>
    </div>
    <div class="flex-grow-1 px-4">
        <div class="tiny fw-800 text-muted uppercase mb-1">Destination & Lead</div>
        <div class="fw-800 text-navy">London Solo • Individual</div>
    </div>
    <div style="width: 180px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Proposed Value</div>
        <div class="fw-900 text-primary outfit" style="font-size: 16px;">₹14,500</div>
    </div>
    <div style="width: 200px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Status</div>
        <div class="fw-800 text-navy small"><span class="status-dot dot-pending"></span> Awaiting Approval</div>
    </div>
    <div class="text-end">
        <button class="btn btn-outline-primary btn-sm px-4 fw-800 rounded-pill">VIEW PROPOSAL</button>
    </div>
</div>

<div class="h-quote-row">
    <div style="width: 120px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Quote ID</div>
        <div class="fw-800 text-navy">#PRO-8805</div>
    </div>
    <div class="flex-grow-1 px-4">
        <div class="tiny fw-800 text-muted uppercase mb-1">Destination & Lead</div>
        <div class="fw-800 text-navy">MICE Group • Singapore Agents</div>
    </div>
    <div style="width: 180px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Proposed Value</div>
        <div class="fw-900 text-primary outfit" style="font-size: 16px;">₹12,40,000</div>
    </div>
    <div style="width: 200px;">
        <div class="tiny fw-800 text-muted uppercase mb-1">Status</div>
        <div class="fw-800 text-success small"><span class="status-dot dot-won"></span> Proposal Accepted</div>
    </div>
    <div class="text-end">
        <button class="btn btn-outline-success btn-sm px-4 fw-800 rounded-pill" onclick="location.href='{{ route('hotel.deals') }}'">VIEW DEAL</button>
    </div>
</div>
@endsection

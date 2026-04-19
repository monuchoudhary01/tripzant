@extends('layouts.dashboard')

@section('title', "Tripzant Wallet - My Balance | Trip Zant")

@section('styles')
<style>
    .wallet-premium-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 32px;
        color: #fff;
        padding: 45px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
    }
    .wallet-premium-card::after {
        content: ''; position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; 
        background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%); border-radius: 50%;
    }
    .txn-card {
        padding: 20px; border-radius: 20px; transition: all 0.3s ease;
        border: 1px solid #f1f5f9; background: #fff;
    }
    .txn-card:hover { transform: translateX(5px); border-color: var(--user-accent); box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
    .x-small { font-size: 11px; }
</style>
@endsection

@section('dashboard_content')
<div class="row g-4 justify-content-center">
    <div class="col-lg-12">
        <div class="wallet-premium-card mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-10 p-2 rounded-3"><i class="fas fa-wallet text-accent fs-5"></i></div>
                    <h6 class="fw-800 opacity-75 mb-0 letter-spacing-1">TRIPZANT CASH BALANCE</h6>
                </div>
                <div class="x-small fw-900 bg-success bg-opacity-20 text-success px-3 py-1 rounded-pill border border-success border-opacity-20">ACTIVE</div>
            </div>
            <div class="row align-items-end">
                <div class="col-md-7">
                    <h1 class="display-3 fw-900 mb-2 ls-1">₹{{ number_format($wallet->balance ?? 0, 2) }}</h1>
                    @if(($wallet->balance ?? 0) <= 0)
                        <p class="x-small fw-bold text-white-50 mb-0 opacity-75"><i class="fas fa-info-circle me-1"></i> Your wallet is empty. Credits will appear here when you receive refunds or bonuses.</p>
                    @endif
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <button class="btn btn-outline-light rounded-pill px-4 fw-800 x-small border-opacity-25 hvr-shrink"><i class="fas fa-plus me-1"></i> ADD MONEY</button>
                    <button class="btn btn-accent rounded-pill px-4 fw-800 x-small ms-2 hvr-shrink">REDEEM POINTS</button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-900 text-navy mb-0">Transaction Ledger</h5>
            <button class="btn btn-light btn-sm rounded-pill fw-bold x-small border"><i class="fas fa-download me-1"></i> Statement</button>
        </div>

        <div class="d-flex flex-column gap-3">
            @forelse($transactions as $t)
            <div class="txn-card d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box-sm rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px; background: {{ $t->type == 'credit' ? 'rgba(34, 197, 94, 0.08)' : 'rgba(239, 68, 68, 0.08)' }}; color: {{ $t->type == 'credit' ? '#22c55e' : '#ef4444' }};">
                        <i class="fas {{ $t->type == 'credit' ? 'fa-arrow-down' : 'fa-arrow-up' }} fs-6"></i>
                    </div>
                    <div>
                        <h6 class="fw-800 text-navy mb-1 fs-6">{{ $t->description ?? $t->remark ?? 'Wallet Activity' }}</h6>
                        <div class="d-flex align-items-center gap-2">
                             <span class="x-small text-muted fw-bold"><i class="far fa-calendar-alt me-1"></i> {{ $t->created_at->format('d M, Y') }}</span>
                             <span class="x-small text-muted fw-bold">•</span>
                             <span class="x-small text-muted fw-bold">ID: #{{ $t->id }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="fw-900 mb-1 {{ $t->type == 'credit' ? 'text-success' : 'text-danger' }} fs-5">
                        {{ $t->type == 'credit' ? '+' : '-' }}₹{{ number_format($t->amount, 2) }}
                    </h6>
                    <span class="badge {{ $t->status == 'completed' ? 'bg-success-subtle text-success' : 'bg-light text-muted' }} x-small fw-900 rounded-pill px-3">{{ strtoupper($t->status) }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-5 bg-white rounded-5 border border-dashed">
                <i class="fas fa-receipt fa-3x text-muted opacity-10 mb-3"></i>
                <p class="text-muted small fw-900 opacity-50">NO TRANSACTIONS RECORDED YET</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

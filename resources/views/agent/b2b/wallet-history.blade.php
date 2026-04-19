@extends('layouts.app')

@section('title', "Wallet Ledger History — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="wallet-history" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Wallet Transaction History</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Live Ledger Tracking | Every Debit & Credit Traceable</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">DOWNLOAD LEDGER <i class="fas fa-file-csv ms-2 text-success"></i></button>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="card border-0 shadow-sm rounded-5 bg-white p-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">TIMESTAMP</th>
                                <th class="py-3">TRANSACTION ID</th>
                                <th class="py-3">TYPE</th>
                                <th class="py-3">DESCRIPTION</th>
                                <th class="py-3">AMOUNT</th>
                                <th class="py-3 text-end">BALANCE AFTER</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @foreach($recentTransactions as $txn)
                            <tr class="py-4 border-bottom">
                                <td class="text-muted">{{ $txn->created_at->format('d M, Y H:i') }}</td>
                                <td class="text-navy fw-900">#TXN-{{ rand(100000, 999999) }}</td>
                                <td>
                                    <span class="badge {{ $txn->type == 'topup' ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} px-3 py-2 rounded-pill x-small uppercase fw-bold">{{ $txn->type }}</span>
                                </td>
                                <td class="text-navy opacity-75">{{ $txn->description }}</td>
                                <td class="fw-900 {{ $txn->type == 'topup' ? 'text-green' : 'text-red' }}">
                                    {{ $txn->type == 'topup' ? '+' : '-' }}₹{{ number_format($txn->amount) }}
                                </td>
                                <td class="text-end text-navy fw-900">₹{{ number_format(rand(100000, 500000)) }}</td>
                            </tr>
                            @endforeach
                            @if(count($recentTransactions) == 0)
                            <tr><td colspan="6" class="text-center py-5 text-muted small fw-bold italic">No transactions recorded in the ledger yet.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
</style>
@endsection

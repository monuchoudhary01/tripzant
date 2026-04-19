@extends('layouts.app')

@section('title', "Transaction Report — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="report-transactions" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Consolidated Transaction Manifest</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Full Reconciliation Hub | Every Debit & Credit Audited</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">EXPORT FULL XLS <i class="fas fa-file-excel ms-2 text-success"></i></button>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Historical Financial Audit Logs</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3 ps-0">TXN DATE / ID</th>
                                <th class="py-3">TRANSACTION TYPE</th>
                                <th class="py-3">DETAILS / REMARKS</th>
                                <th class="py-3">AMOUNT (DEBIT/CREDIT)</th>
                                <th class="py-3 text-end">STATUS HUB</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $txnReports = [
                                ['id' => '#TXN-92842', 'date' => '04 APR, 12:30', 'type' => 'WALLET_TOPUP', 'details' => 'Recharge via Razorpay Gateway Node A1', 'amount' => '+ ₹50,000'],
                                ['id' => '#TXN-92841', 'date' => '05 APR, 09:15', 'type' => 'FLIGHT_BOOKING', 'details' => 'PNR: RT24W8 | IndiGo (DEL→BOM)', 'amount' => '- ₹4,850'],
                                ['id' => '#TXN-92840', 'date' => '05 APR, 14:22', 'type' => 'FLIGHT_BOOKING', 'details' => 'PNR: XP19B2 | Emirates (BOM→DXB)', 'amount' => '- ₹18,200'],
                                ['id' => '#TXN-92839', 'date' => '06 APR, 08:30', 'type' => 'REFUND_CREDIT', 'details' => 'Refund for PNR: KL009M (Cancelled)', 'amount' => '+ ₹42,850'],
                            ];
                            @endphp
                            @foreach($txnReports as $tr)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex flex-column">
                                         <span class="text-navy fw-900">{{ $tr['id'] }}</span>
                                         <span class="x-small text-muted fw-bold">{{ $tr['date'] }}</span>
                                     </div>
                                </td>
                                <td>
                                     <span class="badge {{ str_contains($tr['type'], 'TOPUP') || str_contains($tr['type'], 'REFUND') ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} x-small px-3 py-1 rounded-pill fw-900 border">
                                          {{ str_replace('_', ' ', $tr['type']) }}
                                     </span>
                                </td>
                                <td class="text-muted small fw-bold">{{ $tr['details'] }}</td>
                                <td class="fw-900 {{ str_contains($tr['amount'], '+') ? 'text-green' : 'text-red' }}" style="font-size: 15px;">{{ $tr['amount'] }}</td>
                                <td class="text-end">
                                     <span class="badge bg-light text-navy border px-3 py-1 rounded-pill x-small fw-bold">PROCESSED</span>
                                </td>
                            </tr>
                            @endforeach
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
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
</style>
@endsection

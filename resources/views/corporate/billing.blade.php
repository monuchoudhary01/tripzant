@extends('layouts.app')

@section('title', "Billing & Invoices — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="billing-invoices" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Corporate Billing & Settlements</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Manage Central Billing, Monthly Invoices & Payment Logs.</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">PAY OUTSTANDING <i class="fas fa-university ms-2 text-success"></i></button>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                     <div class="p-5 bg-white shadow-sm rounded-5 border-0 h-100 animate-up">
                         <span class="x-small fw-bold text-muted uppercase tracking-widest d-block mb-3 opacity-75">Outstanding Balance</span>
                         <h2 class="fw-900 text-navy mb-2">₹4,28,450.00</h2>
                         <span class="badge bg-red-subtle text-red fw-bold px-3 py-1 rounded-pill uppercase x-small">DUE IN 5 DAYS</span>
                     </div>
                </div>
                <div class="col-md-4">
                     <div class="p-5 bg-white shadow-sm rounded-5 border-0 h-100 animate-up delay-1">
                         <span class="x-small fw-bold text-muted uppercase tracking-widest d-block mb-3 opacity-75">Last Paid Amount</span>
                         <h2 class="fw-900 text-navy mb-2">₹12,45,000</h2>
                         <span class="x-small fw-bold text-muted mt-2 opacity-50 uppercase tracking-tighter">Settled on 01 APR, 2026</span>
                     </div>
                </div>
                <div class="col-md-4 text-center d-flex align-items-center justify-content-center">
                    <div class="p-5 bg-navy text-white rounded-5 shadow-lg h-100 w-100 position-relative overflow-hidden">
                        <div class="position-relative" style="z-index: 2;">
                             <h6 class="fw-900 mb-3 opacity-75 uppercase x-small tracking-widest">Active Payment Model</h6>
                             <h3 class="fw-900 mb-1">CENTRAL BILLING</h3>
                             <p class="x-small opacity-75 mb-0">Consolidated Monthly Invoice Cycle (T+30)</p>
                        </div>
                        <div style="position:absolute; right:-30px; bottom:-30px; width:150px; height:150px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                    </div>
                </div>
            </div>

            <!-- Invoice Table -->
            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> Historical Corporate Invoices</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-4 ps-0">INVOICE ID / BATCH</th>
                                <th class="py-4">BILLING CYCLE</th>
                                <th class="py-4">TOTAL TAX (GST)</th>
                                <th class="py-4">NET PAYABLE</th>
                                <th class="py-4 text-end">SETTLEMENT</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $invoices = [
                                ['id' => '#CORP-INV-928', 'cycle' => 'MAR 2026', 'gst' => '₹2.12L', 'net' => '₹12,45,000', 'status' => 'SETTLED'],
                                ['id' => '#CORP-INV-929', 'cycle' => 'APR 2026', 'gst' => '₹72,450', 'net' => '₹4,28,450', 'status' => 'PENDING'],
                            ];
                            @endphp
                            @foreach($invoices as $inv)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex flex-column">
                                         <span class="text-navy fw-900 h6 mb-1">{{ $inv['id'] }}</span>
                                         <span class="x-small text-muted fw-bold">{{ $inv['cycle'] }}</span>
                                     </div>
                                </td>
                                <td>Consolidated Batch Billing</td>
                                <td class="text-navy">{{ $inv['gst'] }}</td>
                                <td class="text-navy fw-900">{{ $inv['net'] }}</td>
                                <td class="text-end">
                                     <span class="badge {{ $inv['status'] == 'SETTLED' ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} px-3 py-1 rounded-pill x-small fw-bold border">{{ $inv['status'] }}</span>
                                     <button class="btn btn-light rounded-circle shadow-none ms-3"><i class="fas fa-download text-muted"></i></button>
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
    .bg-navy { background: #001f3f !important; }
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .delay-1 { animation-delay: 0.1s; }
</style>
@endsection

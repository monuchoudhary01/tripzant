@extends('layouts.app')

@section('title', "Payout Ledger — Tour Builder | Trip Zant")

@section('content')
<div class="tour-builder-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-tour-builder-sidebar active="earnings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Financial Earnings Control</h2>
                    <p class="text-muted small mb-0">Track your settlements, upcoming payouts, and commission structures.</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-purple rounded-pill px-5 fw-900 shadow-lg py-3 small">REQUEST SETTLEMENT <i class="fas fa-file-invoice-dollar ms-2"></i></button>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-5 bg-purple text-white text-center h-100">
                        <span class="x-small fw-bold text-white uppercase opacity-75 letter-spacing-1">Next Settlement (15th Apr)</span>
                        <h1 class="fw-900 text-white mt-1">₹1,24,000</h1>
                        <p class="x-small text-white fw-bold mt-2 opacity-50">PROCESSED FOR BANK: 14 APR 2026</p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center h-100">
                         <span class="x-small fw-bold text-muted uppercase">Gross Revenue (MAR)</span>
                         <h1 class="fw-900 text-navy mt-1">₹4,25,800</h1>
                         <div class="progress mt-4 bg-purple-subtle" style="height: 6px;">
                            <div class="progress-bar bg-purple" style="width: 75%;"></div>
                         </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center h-100">
                         <span class="x-small fw-bold text-muted uppercase">Pending Balance (Current)</span>
                         <h1 class="fw-900 text-purple mt-1">₹2,14,000</h1>
                         <p class="x-small text-muted fw-bold mt-2">DUE FROM COMPLETED TOURS</p>
                    </div>
                </div>
            </div>

            <!-- Recent Settlements Table -->
            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Payout Settlement History</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">TRANSACTION ID</th>
                                <th class="py-3">PERIOD</th>
                                <th class="py-3">AMOUNT SETTLED</th>
                                <th class="py-3">STATUS</th>
                                <th class="py-3 text-end">INVOICE</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            <tr class="py-4 border-bottom border-light">
                                <td><span class="text-navy fw-900">#TR-8841-TS</span></td>
                                <td>
                                    <div class="text-navy">01 Mar - 15 Mar 2026</div>
                                    <div class="x-small text-muted">COMPLETED</div>
                                </td>
                                <td><h6 class="mb-0 fw-900 text-navy small">₹2,14,250</h6></td>
                                <td><span class="badge bg-green text-white rounded-pill px-3 py-1 fw-bold">PAID</span></td>
                                <td class="text-end text-purple">
                                    <i class="fas fa-file-pdf fs-4"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-purple { background: #6b46c1 !important; }
    .btn-purple { background: #6b46c1; color: #fff; }
    .text-purple { color: #6b46c1 !important; }
    .bg-green { background: #22c55e !important; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

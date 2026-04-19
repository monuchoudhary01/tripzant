@extends('layouts.app')

@section('title', "Profit Sharing Dashboard — IATA Portal")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-iata-sidebar active="profit-sharing" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Profit Sharing Deals</h2>
                <p class="text-muted small fw-bold mb-0">Transparent tracking of commissions and net profit shared with global partners.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-primary rounded-pill px-4 fw-900 shadow-sm bg-white x-small">SETTLEMENT POLICY</button>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <span class="x-small fw-bold text-muted uppercase">Monthly Shared Profit</span>
                    <h2 class="fw-900 text-navy mt-2 h3">₹42,850</h2>
                    <p class="x-small text-green fw-bold mb-0"><i class="fas fa-arrow-up"></i> 14% vs FEB</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-primary text-white">
                    <span class="x-small fw-bold text-white uppercase opacity-75">Payable to Partners</span>
                    <h2 class="fw-900 text-white mt-2 h3">₹2,10,240</h2>
                    <p class="x-small fw-bold mb-0 opacity-50">DUE BY 15TH APR</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <span class="x-small fw-bold text-muted uppercase">Receivable Profit</span>
                    <h2 class="fw-900 text-navy mt-2 h3">₹1,15,400</h2>
                    <p class="x-small text-muted fw-bold mb-0 italic">Net After TDS</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                 <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <span class="x-small fw-bold text-muted uppercase">Hub Escrow Balance</span>
                    <h2 class="fw-900 text-primary mt-2 h3">₹12,45,000</h2>
                    <p class="x-small text-muted fw-bold mb-0 italic">Locked for Security</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
            <h6 class="fw-900 text-navy mb-5 uppercase"><i class="fas fa-chart-pie me-3 text-primary"></i> Deal Performance Analysis</h6>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">DEAL ID / AGENT</th>
                            <th class="py-3">TICKETS SHARED</th>
                            <th class="py-3">NET PROFIT (LIFETIME)</th>
                            <th class="py-3">MY SHARE %</th>
                            <th class="py-3 text-end">SETTLEMENT STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-blue-light text-blue rounded-circle p-2 px-3 fw-900">S</div>
                                    <div>
                                        <h6 class="mb-0 fw-900 text-dark small">Skybound Travel Co.</h6>
                                        <span class="x-small text-muted">ID: #DX-9901</span>
                                    </div>
                                </div>
                            </td>
                            <td>124 Tickets</td>
                            <td class="text-navy fw-900">₹8,40,250</td>
                            <td>12.0%</td>
                            <td class="text-end">
                                <span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold">UP TO DATE</span>
                            </td>
                        </tr>
                        <tr class="py-4">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-orange-light text-orange rounded-circle p-2 px-3 fw-900">G</div>
                                    <div>
                                        <h6 class="mb-0 fw-900 text-dark small">Global Jet Hub</h6>
                                        <span class="x-small text-muted">ID: #DX-1144</span>
                                    </div>
                                </div>
                            </td>
                            <td>42 Tickets</td>
                            <td class="text-navy fw-900">₹1,98,400</td>
                            <td>08.5%</td>
                            <td class="text-end">
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-1 x-small fw-bold">PARTIAL PAID</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-blue-light { background: #ebf8ff; color: #3182ce; }
    .bg-orange-light { background: #fffaf0; color: #f6ad55; }
    .text-green { color: #10b981; }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .bg-warning-subtle { background: #fffaf0; color: #f59e0b; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
</style>
@endsection

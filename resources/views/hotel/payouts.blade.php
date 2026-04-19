@extends('layouts.app')

@section('title', "Payouts & Financial Reports — Partner Portal")

@section('content')
<div class="hotel-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-hotel-sidebar active="payouts" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Financial Settlements</h2>
                <p class="text-muted small fw-bold mb-0">Complete audit trail of all monthly payouts and reservation settlements.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-navy rounded-pill px-4 fw-900 shadow-sm bg-white x-small">SETTLEMENT POLICY</button>
                <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small">DOWNLOAD REPORTS</button>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <span class="x-small fw-bold text-muted uppercase">Monthly Revenue</span>
                    <h2 class="fw-900 text-navy mt-2 h3">₹4,84,250</h2>
                    <p class="x-small text-green fw-bold mb-0">PAID TILL 31 MAR</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white">
                    <span class="x-small fw-bold text-white uppercase opacity-75">Payable Now</span>
                    <h2 class="fw-900 text-white mt-2 h3">₹1,12,000</h2>
                    <p class="x-small fw-bold mb-0 opacity-50">DUE BY 15 APR</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <span class="x-small fw-bold text-muted uppercase">Reservation Deposits</span>
                    <h2 class="fw-900 text-navy mt-2 h3">₹12,45,000</h2>
                    <p class="x-small text-muted fw-bold mb-0 italic">Net After TDS</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 text-center">
                 <div class="card border-0 shadow-sm rounded-4 p-4 bg-warning">
                    <span class="x-small fw-bold text-dark uppercase">Pending Refunds</span>
                    <h2 class="fw-900 text-dark mt-2 h3">₹14,500</h2>
                    <p class="x-small text-dark fw-bold mb-0 italic">Awaiting Approval</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
            <h6 class="fw-900 text-navy mb-5 uppercase"><i class="fas fa-file-invoice-dollar me-3 text-primary"></i> Monthly Settlement Logs</h6>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">SETTLEMENT ID</th>
                            <th class="py-3">PAYMENT PERIOD</th>
                            <th class="py-3">TOTAL RESERVATIONS</th>
                            <th class="py-3 text-end">AMOUNT PAID</th>
                            <th class="py-3 text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td>
                                <span class="badge bg-light text-navy fw-900 border px-3">#ST-99120A</span>
                            </td>
                            <td>01 MAR – 31 MAR (31D)</td>
                            <td>42 Stays Issued</td>
                            <td class="text-navy fw-900 text-end">₹4,84,250.50</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-navy rounded-circle"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                        <tr class="py-4">
                             <td><span class="badge bg-light text-navy fw-900 border px-3">#ST-88220M</span></td>
                            <td>01 FEB – 28 FEB (28D)</td>
                            <td>28 Stays Issued</td>
                             <td class="text-navy fw-900 text-end">₹3,42,240.25</td>
                            <td class="text-end"><button class="btn btn-sm btn-outline-navy rounded-circle"><i class="fas fa-download"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .btn-navy { background: #001f3f; color: #fff; }
    .btn-outline-navy { border-color: #001f3f; color: #001f3f; }
    .btn-outline-navy:hover { background: #001f3f; color: #fff; }
    .text-green { color: #10b981; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
</style>
@endsection

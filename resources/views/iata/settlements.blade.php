@extends('layouts.app')

@section('title', "Settlement History — IATA Portal")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-iata-sidebar active="settlements" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Settlement History</h2>
                <p class="text-muted small fw-bold mb-0">Complete audit trail of all financial settlements between IATA partners.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-primary rounded-pill px-4 fw-900 shadow-sm bg-white x-small">FILTER BY DATE</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
            <h6 class="fw-900 text-navy mb-5 uppercase"><i class="fas fa-file-invoice-dollar me-3 text-primary"></i> GDS Node Settlement Logs</h6>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">SETTLEMENT ID</th>
                            <th class="py-3">AGENCY PARTNER</th>
                            <th class="py-3">TOTAL TICKETS</th>
                            <th class="py-3">SETTLED AMOUNT</th>
                            <th class="py-3">DATE / TIME</th>
                            <th class="py-3 text-end">INVOICE</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td>
                                <span class="badge bg-light text-navy fw-900 border px-3">#ST-99201A</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-blue-light text-blue rounded-circle p-2 px-3 fw-900">S</div>
                                    <h6 class="mb-0 fw-900 text-dark small">Skybound Travel Co.</h6>
                                </div>
                            </td>
                            <td>12 Tickets</td>
                            <td class="text-navy fw-900">₹42,850.50</td>
                            <td class="text-muted small">01 APR (10:14)</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-navy rounded-circle"><i class="fas fa-download"></i></button>
                            </td>
                        </tr>
                        <tr class="py-4">
                             <td><span class="badge bg-light text-navy fw-900 border px-3">#ST-88220M</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-orange-light text-orange rounded-circle p-2 px-3 fw-900">G</div>
                                    <h6 class="mb-0 fw-900 text-dark small">Global Jet Hub</h6>
                                </div>
                            </td>
                            <td>08 Tickets</td>
                            <td class="text-navy fw-900">₹1,12,240.25</td>
                            <td class="text-muted small">28 MAR (14:32)</td>
                            <td class="text-end"><button class="btn btn-sm btn-outline-navy rounded-circle"><i class="fas fa-download"></i></button></td>
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
    .btn-outline-navy { border-color: #001f3f; color: #001f3f; }
    .btn-outline-navy:hover { background: #001f3f; color: #fff; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
</style>
@endsection

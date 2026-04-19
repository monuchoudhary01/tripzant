@extends('layouts.app')

@section('title', "Financial Audit — Corporate Portal")

@section('content')
<div class="corporate-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-corporate-sidebar active="audit" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Financial Audit Center</h2>
                <p class="text-muted mb-0 fw-600 small">Track GST invoices, credit line utilization, and departmental travel spends.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-navy rounded-pill px-5 fw-900 shadow-lg py-3 small">DOWNLOAD EXPENDITURE REPORT <i class="fas fa-file-export ms-2"></i></button>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-navy text-white text-center">
                    <span class="x-small fw-bold text-white uppercase opacity-75 letter-spacing-1">Corporate Credit Limit</span>
                    <h1 class="fw-900 text-white mt-1">₹1,24,000</h1>
                    <div class="progress mt-4 bg-white bg-opacity-10" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 75%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                 <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <span class="x-small fw-bold text-muted uppercase">Monthly Spends</span>
                    <h1 class="fw-900 text-navy mt-2">₹14.8L</h1>
                    <p class="x-small text-muted fw-bold mb-0 italic">MARCH 2026 Audit Period</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                 <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <span class="x-small fw-bold text-muted uppercase text-danger">Pending Settlement</span>
                    <h2 class="fw-900 text-danger mt-2">₹2,14,000</h2>
                    <p class="x-small text-muted fw-bold mb-0">DUE IN 04 DAYS</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
            <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-file-invoice-dollar me-3 text-primary"></i> GST Invoice Registry (Recent)</h6>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">INVOICE ID</th>
                            <th class="py-3">DESCRIPTION</th>
                            <th class="py-3">GSTIN ID</th>
                            <th class="py-3">NET AMOUNT</th>
                            <th class="py-3 text-end">INVOICE</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td><span class="text-navy fw-900">#INV-8841-TS</span></td>
                            <td>
                                <h6 class="mb-0 fw-900 text-dark small">Group Travel Coordination (DXB)</h6>
                                <span class="x-small text-muted">DATE: 20 MAR 2026</span>
                            </td>
                            <td><span class="badge bg-light text-navy px-3 fw-bold border">27AAACE556V1Z3</span></td>
                            <td><h6 class="mb-0 fw-900 text-navy small">₹2,14,250</h6></td>
                            <td class="text-end text-primary">
                                <i class="fas fa-file-pdf fs-4"></i>
                            </td>
                        </tr>
                        <tr class="py-4">
                            <td><span class="text-navy fw-900">#INV-8839-TS</span></td>
                            <td>
                                <h6 class="mb-0 fw-900 text-dark small">Single Booking (Sameer Khanna)</h6>
                                <span class="x-small text-muted">DATE: 18 MAR 2026</span>
                            </td>
                            <td><span class="badge bg-light text-navy px-3 fw-bold border">27AAACE556V1Z3</span></td>
                            <td><h6 class="mb-0 fw-900 text-navy small">₹14,500</h6></td>
                            <td class="text-end text-primary">
                                <i class="fas fa-file-pdf fs-4"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-navy { background: #02234b !important; }
    .text-navy { color: #02234b; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
    .letter-spacing-1 { letter-spacing: 1.5px; }
    .italic { font-style: italic; }
</style>
@endsection

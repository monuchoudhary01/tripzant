@extends('layouts.app')

@section('title', "Group Coordination Hub — Corporate Portal")

@section('content')
<div class="corporate-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-corporate-sidebar active="groups" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Group Coordination Control</h2>
                <p class="text-muted mb-0 fw-600 small">Manage large volume travel requests (9+ PAX) across all departments.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-primary rounded-pill px-5 fw-900 shadow-lg py-3 small">CREATE NEW GROUP <i class="fas fa-plus ms-2"></i></button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
            <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-users-viewfinder me-3 text-primary"></i> Active Group Workflows</h6>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">GROUP ID</th>
                            <th class="py-3">TRAVEL ROUTE</th>
                            <th class="py-3">PAX</th>
                            <th class="py-3">COORDINATION STAGE</th>
                            <th class="py-3 text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td><span class="badge bg-light text-navy fw-900 border px-3">GRP-5541</span></td>
                            <td>
                                <h6 class="mb-0 fw-900 text-dark small">Delhi (DEL) <i class="fas fa-arrow-right mx-2 text-muted x-small"></i> Dubai (DXB)</h6>
                                <span class="x-small text-muted">DEPARTURE: 02 MAY 2026</span>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary px-3 fw-bold">42 PAX</span></td>
                            <td><span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill border border-warning border-opacity-10 x-small fw-bold">HR APPROVAL</span></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-navy px-4 rounded-pill fw-bold x-small">MANAGE</button>
                            </td>
                        </tr>
                        <tr class="py-4">
                             <td><span class="badge bg-light text-navy fw-900 border px-3">GRP-9920</span></td>
                            <td>
                                <h6 class="mb-0 fw-900 text-dark small">Mumbai (BOM) <i class="fas fa-arrow-right mx-2 text-muted x-small"></i> London (LHR)</h6>
                                <span class="x-small text-muted">DEPARTURE: 15 MAY 2026</span>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary px-3 fw-bold">15 PAX</span></td>
                            <td><span class="badge bg-blue-subtle text-blue px-3 py-1 rounded-pill border border-blue border-opacity-10 x-small fw-bold">QUOTATION</span></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-navy px-4 rounded-pill fw-bold x-small">VIEW QUOTE</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-primary-subtle { background: #e0e7ff; color: #4338ca; }
    .bg-warning-subtle { background: #fffbeb; color: #b45309; }
    .bg-blue-subtle { background: #eff6ff; color: #1d4ed8; }
    .text-navy { color: #02234b; }
    .btn-navy { background: #02234b; color: #fff; }
    .btn-outline-navy { border: 1px solid #02234b; color: #02234b; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
</style>
@endsection

@extends('layouts.app')

@section('title', "IATA Ticketing Desk — GDS Node Portal")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-iata-sidebar active="ticketing" />

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Ticketing Desk</h2>
                <p class="text-muted small fw-bold mb-0">Issuance, Re-bookings, and Modifications via Global GDS Ticketing nodes.</p>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <div class="pcc-badge bg-white px-4 py-2 rounded-4 fw-900 shadow-sm border border-secondary border-opacity-10" style="font-size: 11px;">
                    GDS: DEL1A21RT
                </div>
                <button class="btn btn-primary rounded-pill px-4 fw-900 shadow-sm x-small"><i class="fas fa-ticket me-2"></i> QUICK ISSUE</button>
            </div>
        </div>

        <div class="row g-4">
            <!-- Active Tickets -->
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <h5 class="fw-900 text-navy mb-4"><i class="fas fa-list me-3 text-primary"></i> Recently Issued Tickets</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="x-small text-muted fw-bold uppercase border-bottom">
                                <tr>
                                    <th class="py-3">TICKET # / PNR</th>
                                    <th class="py-3">PASSENGER</th>
                                    <th class="py-3">ROUTE</th>
                                    <th class="py-3">ISSUED FOR</th>
                                    <th class="py-3 text-end">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="small fw-bold">
                                    <td class="py-4">
                                        <h6 class="mb-0 fw-900 text-dark small">098-2938475512</h6>
                                        <span class="x-small text-primary">PNR: ZX8921A</span>
                                    </td>
                                    <td>John Smith</td>
                                    <td>DEL <i class="fas fa-arrow-right mx-1 opacity-25"></i> LHR</td>
                                    <td>Skybound Travel</td>
                                    <td class="text-end"><span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold">TICKETED</span></td>
                                </tr>
                                <tr class="small fw-bold">
                                    <td class="py-4">
                                        <h6 class="mb-0 fw-900 text-dark small">125-9920184410</h6>
                                        <span class="x-small text-primary">PNR: TY1102S</span>
                                    </td>
                                    <td>Sarah Connor</td>
                                    <td>BOM <i class="fas fa-arrow-right mx-1 opacity-25"></i> SIN</td>
                                    <td>Global Jet Hub</td>
                                    <td class="text-end"><span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold">TICKETED</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- GDS Health & Tools -->
            <div class="col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <h6 class="fw-900 text-navy mb-4 uppercase x-small">GDS Connectivity Node</h6>
                    <div class="tech-box p-4 rounded-4 bg-light mb-4 text-center border-0">
                        <i class="fas fa-server text-green fs-2 mb-3"></i>
                        <h6 class="fw-900 mb-1 text-dark small uppercase letter-spacing-1">Amadeus Node 02</h6>
                        <span class="x-small text-muted fw-bold">CONNECTED · 99.9% Uptime</span>
                    </div>

                    <div class="d-flex flex-column gap-2 mb-5">
                        <label class="x-small text-muted fw-bold uppercase">Ticketing Tools</label>
                        <button class="btn btn-light-mmt w-100 rounded-3 text-start px-3 py-2 small fw-bold"><i class="fas fa-exchange-alt me-2"></i> PNR Import / Claim</button>
                        <button class="btn btn-light-mmt w-100 rounded-3 text-start px-3 py-2 small fw-bold"><i class="fas fa-undo-alt me-2"></i> Void Ticket (24h)</button>
                        <button class="btn btn-light-mmt w-100 rounded-3 text-start px-3 py-2 small fw-bold"><i class="fas fa-file-invoice me-2"></i> GDS Sales Report</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .letter-spacing-1 { letter-spacing: 1.5px; }
    .btn-light-mmt { background: #f1f5f9; color: #475569; border: none; }
    .btn-light-mmt:hover { background: #e2e8f0; color: #02234b; }
</style>
@endsection

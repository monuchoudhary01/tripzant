@extends('layouts.app')

@section('title', "Strategic Partnerships — IATA Portal")

@section('content')
<div class="iota-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-iata-sidebar active="connections" />

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Strategic Connections</h2>
                <p class="text-muted small fw-bold mb-0">Manage active partnerships and pending connection requests from global agents.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small"><i class="fas fa-plus me-2"></i> NEW DEAL PROPOSAL</button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h5 class="fw-900 text-navy mb-0"><i class="fas fa-link me-3 text-primary"></i> Active Partnerships</h5>
                        <div class="badge bg-light text-navy border px-3 py-2 rounded-pill x-small fw-bold">TOTAL: 42 CONNECTIONS</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="x-small text-muted fw-bold uppercase border-bottom">
                                <tr>
                                    <th class="py-3">AGENCY PARTNER</th>
                                    <th class="py-3">REGION</th>
                                    <th class="py-3">PROFIT SHARE</th>
                                    <th class="py-3">DEAL STATUS</th>
                                    <th class="py-3 text-end">INTERVENTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="small fw-bold">
                                    <td class="py-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-blue-light text-blue rounded-circle p-2 px-3 fw-900">S</div>
                                            <div>
                                                <h6 class="mb-0 fw-900 text-dark small">Skybound Travel Co.</h6>
                                                <span class="x-small text-muted">IATA: 99120A</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>New York, USA</td>
                                    <td class="text-primary fw-900">12% Net</td>
                                    <td><span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold border border-green border-opacity-25">ACTIVE DEAL</span></td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="small fw-bold">
                                    <td class="py-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-orange-light text-orange rounded-circle p-2 px-3 fw-900">G</div>
                                            <div>
                                                <h6 class="mb-0 fw-900 text-dark small">Global Jet Setters</h6>
                                                <span class="x-small text-muted">IATA: 1102A</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dubai, UAE</td>
                                    <td class="text-primary fw-900">08% Net</td>
                                    <td><span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold border border-green border-opacity-25">ACTIVE DEAL</span></td>
                                    <td class="text-end">
                                        <div class="dropdown"><button class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fas fa-ellipsis-v"></i></button></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-navy text-white position-relative overflow-hidden mb-4">
                    <h6 class="fw-900 mb-4 uppercase x-small">Strategic Request Queue</h6>
                    <div class="alert bg-white bg-opacity-10 border-0 rounded-4 p-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="pcc-orb-sm shadow-sm">K</div>
                            <div>
                                <h6 class="fw-900 mb-0 small">Knights Travel Hub</h6>
                                <p class="x-small fw-bold opacity-50 mb-0">Johannesburg, ZA</p>
                            </div>
                        </div>
                        <p class="x-small fw-bold opacity-75 mb-4 italic">"Interested in a 5% profit-share partnership for luxury group bookings to Cape Town."</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary flex-grow-1 rounded-pill fw-bold py-2 x-small">APPROVE</button>
                            <button class="btn btn-sm btn-outline-light flex-grow-1 rounded-pill fw-bold py-2 x-small">DECLINE</button>
                        </div>
                    </div>
                    <div class="bg-blur-orb-sm"></div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white h-auto">
                    <h6 class="fw-900 text-navy mb-4 uppercase x-small">Partnership Guidelines</h6>
                    <ul class="list-unstyled x-small text-muted fw-bold d-flex flex-column gap-3">
                        <li class="d-flex gap-2"><i class="fas fa-circle-check text-green"></i> 100% Secure profit distribution via Hub Escrow.</li>
                        <li class="d-flex gap-2"><i class="fas fa-circle-check text-green"></i> Real-time ticketing authorization between GDS nodes.</li>
                        <li class="d-flex gap-2"><i class="fas fa-circle-check text-green"></i> Verified partner status required for settlement.</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-blue-light { background: #ebf8ff; color: #3182ce; }
    .bg-orange-light { background: #fffaf0; color: #f6ad55; }
    .text-green { color: #10b981; }
    .bg-navy { background: #001f3f; }
    .pcc-orb-sm { width: 40px; height: 40px; background: #3182ce; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; }
    .bg-blur-orb-sm { position: absolute; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -40px; right: -40px; filter: blur(20px); }
</style>
@endsection

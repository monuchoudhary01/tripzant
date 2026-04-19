@extends('layouts.b2b_master')

@section('title', 'IATA Agent Dashboard | Global Ticketing')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-navy text-white">
                <i class="fas fa-passport"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">BSP Exposure</div>
            <h3 class="mt-1 mb-0 outfit">₹42.50 Cr</h3>
            <div class="mt-2 text-warning small fw-700">
                <i class="fas fa-exclamation-triangle me-1"></i> 82% of Limit
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-success text-white">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">Tickets Issued (Today)</div>
            <h3 class="mt-1 mb-0 outfit">1,248</h3>
            <div class="mt-2 text-success small fw-700">
                <i class="fas fa-arrow-up me-1"></i> 15% vs yesterday
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-primary text-white">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">IATA Status</div>
            <h3 class="mt-1 mb-0 outfit text-success">VERIFIED</h3>
            <div class="mt-2 text-muted small fw-700 text-uppercase">
                Code: {{ $profile?->iata_code ?? '7788990' }}
                @if(!$profile)
                    <span class="badge bg-danger small ms-2" style="font-size: 8px;">UNLINKED</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-warning text-white">
                <i class="fas fa-coins"></i>
            </div>
            <div class="text-muted fw-700 uppercase" style="font-size: 11px;">Commission Earned</div>
            <h3 class="mt-1 mb-0 outfit">₹8.42 L</h3>
            <div class="mt-2 text-primary small fw-700">
                Pending Settlement: ₹1.2L
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="b2b-table-card">
            <div class="card-header">
                <h5 class="mb-0">Global Network Tickets</h5>
            </div>
            <div class="table-responsive">
                <table class="table b2b-table mb-0">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Agent</th>
                            <th>PNR</th>
                            <th>Airline</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TRX-99201</td>
                            <td class="fw-700">GoAir Travels</td>
                            <td class="text-primary fw-900">XY78WQ</td>
                            <td><span class="badge bg-light text-navy border">British Airways</span></td>
                            <td><span class="b2b-badge badge-success">Ticketing Success</span></td>
                            <td><button class="btn btn-light btn-sm"><i class="fas fa-download"></i></button></td>
                        </tr>
                        <tr>
                            <td>#TRX-99202</td>
                            <td class="fw-700">SkyLink B2B</td>
                            <td class="text-primary fw-900">AB92LK</td>
                            <td><span class="badge bg-light text-navy border">Qantas</span></td>
                            <td><span class="b2b-badge badge-warning">ADM Pending</span></td>
                            <td><button class="btn btn-light btn-sm"><i class="fas fa-eye"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="b2b-table-card">
            <div class="card-header">
                <h5 class="mb-0">Risk Monitoring</h5>
            </div>
            <div class="p-4">
                <div class="text-center mb-4">
                    <div class="display-4 fw-900 text-navy mb-1">0.05%</div>
                    <div class="text-muted small fw-bold">Fraud Error Rate</div>
                </div>
                <div class="progress mb-4" style="height: 10px; border-radius: 5px;">
                    <div class="progress-bar bg-success" style="width: 95%;"></div>
                    <div class="progress-bar bg-warning" style="width: 4%;"></div>
                    <div class="progress-bar bg-danger" style="width: 1%;"></div>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-muted">Auto-Ticketing</span>
                        <span class="badge bg-success-subtle text-success">ENABLED</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-muted">Void Window</span>
                        <span class="fw-900 text-navy">24 Hours</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-muted">Post-Ticketing Audit</span>
                        <span class="badge bg-primary-subtle text-primary">RUNNING</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

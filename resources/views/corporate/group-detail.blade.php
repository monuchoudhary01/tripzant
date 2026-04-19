@extends('layouts.app')

@section('title', "Group Coordination - $id | Trip Zant Corporate")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    
    /* Stepper Styling */
    .stepper-mmt { display: flex; justify-content: space-between; position: relative; margin-bottom: 40px; }
    .stepper-mmt::before {
        content: ''; position: absolute; top: 15px; left: 0; 
        width: 100%; height: 2px; background: #e2e8f0; z-index: 1;
    }
    .step-node {
        position: relative; z-index: 2; background: #fff; text-align: center; width: 120px;
    }
    .step-circle {
        width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; border: 4px solid #fff;
        margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;
        color: #94a3b8; font-size: 12px; font-weight: 900; transition: 0.3s;
    }
    .step-node.active .step-circle { background: var(--navy); color: #fff; }
    .step-node.completed .step-circle { background: #22c55e; color: #fff; }
    .step-label { font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; }
    .step-node.active .step-label { color: var(--navy); }

    .quotation-card { border-left: 4px solid var(--primary); background: rgba(var(--primary-rgb), 0.02); }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 90vh;">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item small fw-bold"><a href="{{ route('corporate.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item small fw-bold active">{{ $id }}</li>
                    </ol>
                </nav>
                <h2 class="fw-900 text-navy mb-0">Group Coordination: {{ $id }}</h2>
                <div class="badge bg-navy-subtle text-navy mt-2 px-3 py-2 rounded-pill x-small fw-900 shadow-sm">
                    <i class="fas fa-plane-departure me-1"></i> DELHI (DEL) ✈ DUBAI (DXB)
                </div>
            </div>
            <div class="text-end">
                <div class="small fw-bold text-muted mb-1 uppercase">Current Status</div>
                <div class="badge bg-warning text-dark px-4 py-2 rounded-pill small fw-900 shadow-sm">PENDING HR APPROVAL</div>
            </div>
        </div>

        <!-- Status Stepper -->
        <div class="card border-0 shadow-sm rounded-4 p-5 mb-4">
            <div class="stepper-mmt">
                <div class="step-node completed">
                    <div class="step-circle"><i class="fas fa-check"></i></div>
                    <div class="step-label">Request Created</div>
                </div>
                <div class="step-node active">
                    <div class="step-circle">2</div>
                    <div class="step-label">HR Approval</div>
                </div>
                <div class="step-node">
                    <div class="step-circle">3</div>
                    <div class="step-label">Airline Quote</div>
                </div>
                <div class="step-node">
                    <div class="step-circle">4</div>
                    <div class="step-label">Quote Approval</div>
                </div>
                <div class="step-node">
                    <div class="step-circle">5</div>
                    <div class="step-label">Confirmed</div>
                </div>
            </div>
            
            <div class="p-4 rounded-4 bg-light text-center">
                <p class="small fw-bold text-muted mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i> 
                    Currently waiting for <span class="text-navy fw-900">Corporate HR (TCS Administration)</span> to review passenger details and estimated costs.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Side: Pax List & Details -->
            <div class="col-lg-8">
                <!-- Group Details -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-900 text-navy mb-4">Travel Information</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="x-small fw-bold text-muted uppercase">Trip Purpose</div>
                            <div class="small fw-900 text-navy">Annual Tech Conference 2026</div>
                        </div>
                        <div class="col-md-4">
                            <div class="x-small fw-bold text-muted uppercase">Preferred Date</div>
                            <div class="small fw-900 text-navy">12 June 2026</div>
                        </div>
                        <div class="col-md-4">
                            <div class="x-small fw-bold text-muted uppercase">Requested By</div>
                            <div class="small fw-900 text-navy">Rohan Sharma (Lead HR)</div>
                        </div>
                    </div>
                </div>

                <!-- Passenger List -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-900 text-navy mb-0">Passenger Manifest (42 Travelers)</h6>
                        <button class="btn btn-navy btn-sm rounded-pill px-3 fw-bold small"><i class="fas fa-download me-1"></i> EXPORT CSV</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 x-small fw-900 text-muted">TRAVELLER</th>
                                    <th class="border-0 x-small fw-900 text-muted">PASSPORT</th>
                                    <th class="border-0 x-small fw-900 text-muted">DOCS STATUS</th>
                                    <th class="border-0 x-small fw-900 text-muted">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=1; $i<=5; $i++)
                                <tr>
                                    <td>
                                        <div class="small fw-900 text-navy">Traveler #{{ $i }} (Employee ID: EX102{{ $i }})</div>
                                        <div class="x-small text-muted fw-bold">Senior Software Engineer</div>
                                    </td>
                                    <td class="small fw-bold">Z12933{{ $i }}X</td>
                                    <td><span class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-900">VERIFIED</span></td>
                                    <td><button class="btn btn-link py-0 small fw-bold text-navy text-decoration-none">View Details</button></td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <div class="text-center p-3">
                            <button class="btn btn-link text-navy fw-900 small text-decoration-none">SHOW ALL 42 PASSENGERS</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Approvals & Quote -->
            <div class="col-lg-4">
                <!-- Action Card (HR Approval) -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-900 text-navy mb-3">Coordination Actions</h6>
                    <p class="small text-muted fw-bold mb-4">Review the request and initiate airline coordination.</p>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-navy py-3 rounded-pill fw-900 shadow-sm">✅ APPROVE REQUEST</button>
                        <button class="btn btn-outline-danger py-3 rounded-pill fw-900">❌ REJECT / CANCEL</button>
                        <button class="btn btn-link text-muted small fw-bold text-decoration-none">REQUEST CHANGES</button>
                    </div>
                    
                    <hr class="my-4 opacity-10">
                    
                    <div class="p-3 bg-warning-subtle rounded-3">
                        <div class="d-flex gap-3">
                            <i class="fas fa-triangle-exclamation text-warning mt-1"></i>
                            <div>
                                <div class="x-small fw-900 text-navy mb-1 uppercase">System Note</div>
                                <p class="x-small text-navy fw-bold mb-0">Approved requests will be shared with the Airline Coordination Desk for manual quotation.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Chat / Updates -->
                <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden" style="height: 400px; display: flex; flex-direction: column;">
                    <h6 class="fw-900 text-navy mb-4">Coordination Log</h6>
                    <div class="flex-grow-1 overflow-auto pe-2" style="font-size: 12px;">
                        <div class="mb-3">
                            <div class="fw-900 text-navy">Admin Desk <span class="text-muted fw-normal x-small ms-2">10:15 AM</span></div>
                            <div class="p-2 bg-light rounded-3 mt-1 fw-bold text-muted">Request received. Validating passenger passport numbers.</div>
                        </div>
                        <div class="mb-3">
                            <div class="fw-900 text-navy text-primary">System Alert <span class="text-muted fw-normal x-small ms-2">10:30 AM</span></div>
                            <div class="p-2 bg-primary-light rounded-3 mt-1 fw-bold text-primary">Notification sent to HR Department for approval.</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm border-0 bg-light" placeholder="Send a note to Admin...">
                            <button class="btn btn-navy btn-sm px-3"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

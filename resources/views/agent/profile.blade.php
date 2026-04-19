@extends('layouts.app')

@section('title', "Agent Profile - Global IATA Partner | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .trust-badge-large {
        width: 100px; height: 100px; border-radius: 50%; border: 6px solid #ebf4ff;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: #fff;
    }
    .profile-sidebar-card { background: #fff; border-radius: 30px; padding: 40px; border: 1px solid #edf2f7; }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f7fafc; min-height: 95vh;">
    <div class="container">
        <div class="row g-4">
            <!-- Left: Profile Header & Sidebar -->
            <div class="col-lg-4">
                <div class="profile-sidebar-card shadow-sm text-center mb-4">
                    <div class="avatar-large mx-auto mb-4 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-900 fs-1 shadow-lg" style="width: 120px; height: 120px;">DT</div>
                    <h3 class="fw-900 text-dark mb-1">Dubai Skyline Travel</h3>
                    <div class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-900 mb-4 ls-1">IATA VERIFIED</div>
                    
                    <div class="d-flex justify-content-center gap-4 mb-5 pb-4 border-bottom border-light">
                        <div>
                            <div class="h4 fw-900 text-dark mb-0">98%</div>
                            <div class="x-small fw-bold text-muted uppercase">Trust Score</div>
                        </div>
                        <div class="border-start border-light ps-4">
                            <div class="h4 fw-900 text-dark mb-0">4.9/5</div>
                            <div class="x-small fw-bold text-muted uppercase">Rating</div>
                        </div>
                    </div>

                    <div class="text-start mb-4">
                        <h6 class="fw-900 text-dark small mb-3 uppercase ls-1">Contact Intelligence</h6>
                        <div class="d-grid gap-2">
                            <a href="tel:+971551234567" class="btn btn-navy py-3 rounded-pill fw-900 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background:#1a202c; color:#fff;">
                                <i class="fas fa-phone-alt text-primary"></i> <span class="ls-1">+971-55-123-4567</span>
                            </a>
                            <a href="mailto:dxb@skylinetravel.com" class="btn btn-light py-3 rounded-pill fw-900 shadow-sm d-flex align-items-center justify-content-center gap-2 border">
                                <i class="fas fa-envelope text-primary"></i> <span class="ls-1">dxb@partner.com</span>
                            </a>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('agent.chat', ['id' => $id]) }}" class="btn btn-primary py-3 rounded-pill fw-900 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-comments fs-5"></i> START PARTNER CHAT
                        </a>
                        <button class="btn btn-dark py-3 rounded-pill fw-900 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background:#2d3748;" data-bs-toggle="modal" data-bs-target="#startDealModal">
                            <i class="fas fa-handshake-angle text-info fs-5"></i> START B2B DEAL
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Details & Capabilities -->
            <div class="col-lg-8">
                <!-- Agency Overview -->
                <div class="card border-0 shadow-sm rounded-5 p-5 mb-4">
                    <h5 class="fw-900 text-dark mb-4 ls-1">Business Capabilities</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="x-small fw-900 text-muted uppercase mb-3">Partner IATA Registration</h6>
                            <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-3">
                                <i class="fas fa-id-card fs-4 text-primary opacity-50"></i>
                                <div>
                                    <div class="fw-900 text-dark">IATA CODE: {{ $id }}</div>
                                    <div class="x-small fw-bold text-muted">Licensed Global Sub-Agent</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="x-small fw-900 text-muted uppercase mb-3">Region Focus Area</h6>
                            <div class="p-4 bg-light rounded-4 d-flex align-items-center gap-3">
                                <i class="fas fa-map-marked-alt fs-4 text-success opacity-50"></i>
                                <div>
                                    <div class="fw-900 text-dark">GCC & Middle East</div>
                                    <div class="x-small fw-bold text-muted">Direct GDS Access Dubai Hub</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="x-small fw-900 text-muted uppercase mt-5 mb-4">Airlines Specialization</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['Emirates', 'Etihad Airways', 'FlyDubai', 'Indigo', 'Air India Express', 'Qatar Airways'] as $airline)
                        <span class="badge bg-white border text-dark px-3 py-2 rounded-pill x-small fw-bold">{{ $airline }}</span>
                        @endforeach
                    </div>

                    <div class="mt-5 p-4 border-start border-4 border-primary bg-primary-light">
                        <h6 class="fw-900 text-dark small mb-2 uppercase">Preferred Partnership Deal Model</h6>
                        <p class="small text-muted fw-bold mb-0">Indus Travels prefers <span class="text-primary">Split Commission Model (60/40)</span> for group bookings and <span class="text-primary">Flat ₹500/Ticket</span> for single corporate bookings.</p>
                    </div>
                </div>

                <!-- Past Business Intelligence (Mock) -->
                <div class="card border-0 shadow-sm rounded-5 p-5">
                    <h6 class="fw-900 text-dark mb-4 ls-1">Global Partnership History</h6>
                    <div class="row text-center g-3">
                        <div class="col-4">
                            <div class="h3 fw-900 text-primary mb-1">1,250+</div>
                            <div class="x-small fw-900 text-muted uppercase">Deals Closed</div>
                        </div>
                        <div class="col-4 border-start border-end">
                            <div class="h3 fw-900 text-dark mb-1">₹12.5Cr</div>
                            <div class="x-small fw-900 text-muted uppercase">Trade Volume</div>
                        </div>
                        <div class="col-4">
                            <div class="h3 fw-900 text-success mb-1">99.8%</div>
                            <div class="x-small fw-900 text-muted uppercase">SLA Adherence</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start B2B Deal Modal -->
<div class="modal fade" id="startDealModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-5 shadow-lg">
            <div class="modal-body p-5">
                <h4 class="fw-900 text-dark mb-4">Initiate New B2B Deal</h4>
                <form action="{{ route('agent.deals') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label x-small fw-900 text-muted uppercase">Select Route Segment</label>
                        <select class="form-select rounded-4 py-3 fw-bold text-navy small">
                            <option>Delhi (DEL) → Dubai (DXB)</option>
                            <option>Mumbai (BOM) → London (LHR)</option>
                            <option>Bangalore (BLR) → Singapore (SIN)</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label x-small fw-900 text-muted uppercase">Passenger Count</label>
                            <input type="number" class="form-control rounded-4 py-3 fw-bold" value="12">
                        </div>
                        <div class="col-6">
                            <label class="form-label x-small fw-900 text-muted uppercase">Proposed Split</label>
                            <select class="form-select rounded-4 py-3 fw-bold small"><option>60/40 Split</option><option>50/50 Split</option><option>70/30 Split</option></select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-900 shadow-sm">CREATE DEAL REQUEST</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

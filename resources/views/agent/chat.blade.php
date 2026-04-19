@extends('layouts.app')

@section('title', "Partner Chat - Dubai Skyline Travel | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    
    /* B2B Chat Interface */
    .chat-container {
        height: calc(90vh - 100px); background: #fff; border-radius: 30px; overflow: hidden;
        display: flex; box-shadow: 0 40px 60px rgba(0,0,0,0.05); border: 1px solid #edf2f7;
    }
    .chat-sidebar { width: 320px; border-right: 1px solid #edf2f7; display: flex; flex-direction: column; background: #fff; }
    .chat-main { flex-grow: 1; display: flex; flex-direction: column; background: #f8fafc; }
    
    .msg-partner { background: #fff; border-radius: 15px 15px 15px 5px; padding: 15px; margin-bottom: 20px; max-width: 70%; border: 1px solid #edf2f7; }
    .msg-self { background: #1a202c; color: #fff; border-radius: 15px 15px 5px 15px; padding: 15px; margin-bottom: 20px; max-width: 70%; align-self: flex-end; }
    
    .partner-item { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; transition: 0.3s; cursor: pointer; }
    .partner-item:hover, .partner-item.active { background: #3182ce10; border-left: 4px solid #3182ce; }
</style>
@endsection

@section('content')
<div class="py-4" style="background: #f1f5f9; min-height: 95vh;">
    <div class="container container-fluid">
        <div class="chat-container">
            <!-- Chat Sidebar: Connected Partners -->
            <div class="chat-sidebar d-none d-md-flex">
                <div class="p-4 border-bottom">
                    <h6 class="fw-900 text-dark uppercase mb-0">Partner Directs</h6>
                </div>
                <div class="flex-grow-1 overflow-auto">
                    <div class="partner-item active">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-900 shadow-sm" style="width: 40px; height: 40px;">DS</div>
                            <div class="flex-grow-1">
                                <div class="small fw-900 text-dark">Dubai Skyline</div>
                                <div class="x-small fw-bold text-success"><i class="fas fa-circle ms-1 fs-5" style="font-size: 8px;"></i> ONLINE</div>
                            </div>
                        </div>
                    </div>
                    @for($i=1; $i<=5; $i++)
                    <div class="partner-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center fw-900" style="width: 40px; height: 40px;">P</div>
                            <div class="flex-grow-1">
                                <div class="small fw-900 text-muted">Global Partner {{ $i }}</div>
                                <div class="x-small fw-bold text-muted uppercase">IATA: 8849{{ $i }}</div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Chat Main Window -->
            <div class="chat-main">
                <!-- Header -->
                <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('agent.profile', ['id' => $id]) }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left text-muted me-2"></i>
                        </a>
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-900" style="width: 40px; height: 40px;">DS</div>
                        <div>
                            <div class="small fw-900 text-dark">Dubai Skyline Travel (IATA: {{ $id }})</div>
                            <div class="x-small fw-bold text-muted uppercase ls-1">TRUST: 98% ⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-dark btn-sm rounded-pill fw-900 px-3" data-bs-toggle="modal" data-bs-target="#passengerModal">
                            <i class="fas fa-users-medical me-1"></i> SHARE PAX DATA
                        </button>
                        <button class="btn btn-primary btn-sm rounded-pill fw-900 px-3 shadow-sm">
                            <i class="fas fa-file-contract me-1"></i> CREATE B2B DEAL
                        </button>
                    </div>
                </div>

                <!-- Messages Feed -->
                <div class="flex-grow-1 p-4 d-flex flex-column overflow-auto">
                    <div class="msg-partner">
                        <div class="small fw-900 mb-1">Dubai Skyline Admin</div>
                        <div class="fw-bold">Hi Indus Travels! We have group fares for Delhi - Dubai for 15th June. Are you interested?</div>
                        <div class="x-small text-muted mt-2 fw-bold">10:15 AM <i class="fas fa-check-double text-primary ms-2"></i></div>
                    </div>

                    <div class="msg-self">
                        <div class="small fw-900 mb-1">Me (Indus Travels)</div>
                        <div class="fw-bold">Yes! Please share the per-pax fare and commission split.</div>
                        <div class="x-small text-white opacity-50 mt-2 fw-bold">10:16 AM</div>
                    </div>
                    
                    <div class="msg-partner">
                        <div class="small fw-900 mb-1">Dubai Skyline Admin</div>
                        <div class="p-3 bg-primary-light rounded-3 mb-2 border">
                            <div class="small fw-900 text-dark"><i class="fas fa-file-pdf text-danger me-2"></i> Group_Fare_DXB_1506.pdf</div>
                            <div class="x-small text-muted fw-bold">Fare: ₹18,500pp (Net)</div>
                        </div>
                        <div class="fw-bold">Check the attached PDF for full flight details.</div>
                        <div class="x-small text-muted mt-2 fw-bold">10:20 AM</div>
                    </div>
                </div>

                <!-- Input Footer -->
                <div class="p-4 bg-white border-top">
                    <div class="input-group bg-light rounded-pill p-1 shadow-sm overflow-hidden border">
                        <button class="btn btn-link text-muted px-3"><i class="fas fa-paperclip"></i></button>
                        <input type="text" class="form-control border-0 bg-light py-3 small fw-bold" placeholder="Type a message or share passenger records...">
                        <button class="btn btn-dark text-white rounded-pill px-4" style="background:#1a202c;"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Passenger Sharing Modal -->
<div class="modal fade" id="passengerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-5 shadow-lg">
            <div class="modal-body p-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-900 text-dark mb-0">Share Passenger Data for Coordination</h5>
                    <button class="btn btn-outline-primary btn-sm rounded-pill fw-900 px-3"><i class="fas fa-file-csv me-1"></i> IMPORT CSV / EXCEL</button>
                </div>
                
                <form class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label x-small fw-900 text-muted uppercase">Passenger Name</label>
                        <input type="text" class="form-control rounded-3" placeholder="e.g. Rahul Singh">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label x-small fw-900 text-muted uppercase">Passport Number</label>
                        <input type="text" class="form-control rounded-3" placeholder="Z1234567">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label x-small fw-900 text-muted uppercase">Date of Birth</label>
                        <input type="date" class="form-control rounded-3">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label x-small fw-900 text-muted uppercase">Gender</label>
                        <select class="form-select rounded-3 text-muted fw-bold small"><option>MALE</option><option>FEMALE</option></select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label x-small fw-900 text-muted uppercase">Nationality</label>
                        <input type="text" class="form-control rounded-3" placeholder="Indian">
                    </div>
                    <div class="col-12 mt-4">
                        <button type="button" class="btn btn-primary w-100 py-3 rounded-pill fw-900 shadow-sm" data-bs-dismiss="modal">SEND DATA TO PARTNER CHANNEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

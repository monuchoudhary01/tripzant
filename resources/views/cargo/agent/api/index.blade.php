@extends('layouts.user_dashboard')

@section('title', 'B2B Developer Portal')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="p-5 mb-4 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #0b3d61, #1e293b); color: white;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-3">TripZant B2B API Builder</h1>
                    <p class="lead opacity-75">Connect your local cargo business directly with our global logistics engine. Request custom API endpoints and start automating today.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-microchip fa-6x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    @if(!$requestData)
        <!-- 1. Request Form -->
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-4 text-navy">Request API Integration Access</h4>
                    <form action="{{ route('cargo.agent.api.request') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Company Name</label>
                                <input type="text" name="company_name" class="form-control" placeholder="e.g. FastTrack Logistics" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Contact Person</label>
                                <input type="text" name="contact_person" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="+1..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Current Tech Stack</label>
                                <select name="tech_stack" class="form-select">
                                    <option value="Manual">Manual (No System)</option>
                                    <option value="Basic">Basic System (Excel/Local)</option>
                                    <option value="Ready">API Ready (PHP/Node/Python)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Special Requirements / Message</label>
                                <textarea name="requirements" class="form-control" rows="3" placeholder="Explain your integration needs..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow">Initialize API Request <i class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($requestData->status == 'Pending')
        <!-- 2. Pending Status -->
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                <i class="fas fa-clock fa-4x text-warning mb-4"></i>
                <h3 class="fw-bold">API Request Under Review</h3>
                <p class="text-muted">Our engineering team is analyzing your request for <strong>{{ $requestData->company_name }}</strong>. Once approved, your custom API Keys will appear here.</p>
                <div class="mt-4">
                    <span class="badge bg-soft-warning text-warning px-4 py-2 border rounded-pill">Status: PENDING VALIDATION</span>
                </div>
                <!-- Mock Approve for Demo -->
                <form action="{{ route('cargo.agent.api.generate') }}" method="POST" class="mt-5 pt-5 border-top">
                    @csrf
                    <small class="text-muted d-block mb-3">Demo: Click below to simulate admin approval</small>
                    <button type="submit" class="btn btn-outline-success btn-sm rounded-pill">Admin Approval (Demo)</button>
                </form>
            </div>
        </div>
    @elseif($credentials)
        <!-- 3. Approved: Credentials & Documentation -->
        <div class="col-md-12">
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="fw-bold mb-0">Your Integration Credentials</h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="p-4 bg-light rounded-4">
                                <div class="mb-4">
                                    <label class="x-small fw-bold text-muted uppercase">API KEY (LIVE)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control border-0 font-monospace bg-white" value="{{ $credentials->api_key }}" readonly>
                                        <button class="btn btn-navy text-white px-3" onclick="navigator.clipboard.writeText('{{ $credentials->api_key }}')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label class="x-small fw-bold text-muted uppercase">API SECRET</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control border-0 font-monospace bg-white" value="{{ $credentials->api_secret }}" readonly>
                                        <button class="btn btn-navy text-white px-3" onclick="navigator.clipboard.writeText('{{ $credentials->api_secret }}')"><i class="fas fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 alert alert-info border-0 rounded-4 x-small">
                                <i class="fas fa-shield-alt me-2"></i> These keys grant full access to your cargo dashboard. Never share them publicly.
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="fw-bold mb-0">Global API Endpoints</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Action</th>
                                            <th>Method</th>
                                            <th>Endpoint</th>
                                            <th class="pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-4 fw-bold">Create Booking</td>
                                            <td><span class="badge bg-success">POST</span></td>
                                            <td><code>/api/v1/cargo/book</code></td>
                                            <td class="pe-4"><span class="badge bg-soft-success text-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 fw-bold">Update Tracking</td>
                                            <td><span class="badge bg-primary">POST</span></td>
                                            <td><code>/api/v1/cargo/track</code></td>
                                            <td class="pe-4"><span class="badge bg-soft-success text-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 fw-bold">Shipment List</td>
                                            <td><span class="badge bg-info">GET</span></td>
                                            <td><code>/api/v1/cargo/list</code></td>
                                            <td class="pe-4"><span class="badge bg-soft-success text-success">Active</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-navy text-white mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><i class="fas fa-book me-2"></i> Integration Guide</h5>
                            <p class="small opacity-75">Follow our 3-step guide to connect your local system.</p>
                            <ol class="small mb-0">
                                <li class="mb-2">Add <code>x-api-key</code> to your request headers.</li>
                                <li class="mb-2">Send payload in JSON format.</li>
                                <li class="mb-2">Listen for Webhook events for real-time updates.</li>
                            </ol>
                            <button class="btn btn-outline-light btn-sm w-100 mt-4 rounded-pill">Download SDK (.zip)</button>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">API Logs (Last 24h)</h6>
                            <div class="text-center py-5">
                                <i class="fas fa-chart-line fa-3x text-light mb-3"></i>
                                <p class="text-muted small">No API calls detected yet. Send your first request to see logs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .bg-navy { background-color: #0b3d61; }
    .text-navy { color: #0b3d61; }
    .btn-navy { background-color: #0b3d61; border: none; }
    .btn-navy:hover { background-color: #092d48; }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
</style>
@endsection

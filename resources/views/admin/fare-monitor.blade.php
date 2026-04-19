@extends('layouts.admin')

@section('title', 'Fare Monitor Control | Master Admin')

@section('admin_content')
<div class="admin-fare-monitor">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="fw-900 text-navy mb-1">Fare Monitoring Control Center</h4>
            <p class="text-muted small">Manage global price alerts, scheduling, and API sync for user tracking.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-navy rounded-pill px-4 fw-bold small" id="triggerSync"><i class="fas fa-sync-alt me-2"></i> Trigger Global Sync</button>
            <button class="btn btn-admin-primary rounded-pill px-4 fw-bold small"><i class="fas fa-cog me-2"></i> Settings</button>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card-admin border-start border-5 border-primary">
                <h6 class="text-muted x-small fw-bold text-uppercase mb-2">Active Alerts</h6>
                <div class="display-6 fw-900 text-navy">1,248</div>
                <div class="mt-2 text-primary x-small fw-bold"><i class="fas fa-arrow-up"></i> +12% this week</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card-admin border-start border-5 border-success">
                <h6 class="text-muted x-small fw-bold text-uppercase mb-2">Price Drops Found</h6>
                <div class="display-6 fw-900 text-navy">342</div>
                <div class="mt-2 text-success x-small fw-bold"><i class="fas fa-check"></i> Alerts sent via WhatsApp/Email</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card-admin border-start border-5 border-warning">
                <h6 class="text-muted x-small fw-bold text-uppercase mb-2">API Sync Status</h6>
                <div class="display-6 fw-900 text-navy">LIVE</div>
                <div class="mt-2 text-warning x-small fw-bold"><i class="fas fa-satellite-dish"></i> Next sync in 12m</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card-admin border-start border-5 border-navy">
                <h6 class="text-muted x-small fw-bold text-uppercase mb-2">Success Rate</h6>
                <div class="display-6 fw-900 text-navy">99.4%</div>
                <div class="mt-2 text-muted x-small fw-bold">Last error 1h ago</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Live Alert Monitoring Table -->
        <div class="col-lg-8">
            <div class="card-admin h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-900 text-navy mb-0">Live Active Alerts (Global)</h5>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm border shadow-none" placeholder="Search route or ID..." style="width: 200px;">
                        <button class="btn btn-light btn-sm"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="x-small text-muted fw-bold border-bottom">
                                <th>USER ID</th>
                                <th>ROUTE</th>
                                <th>TARGET</th>
                                <th>CURRENT</th>
                                <th>LAST CHECK</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="fareMonitorTable">
                            <tr>
                                <td><span class="user-pill">AR-921</span> Aditya Roy</td>
                                <td>DEL → DXB</td>
                                <td class="fw-bold">₹22,000</td>
                                <td class="text-success fw-bold">₹21,000 <i class="fas fa-long-arrow-alt-down"></i></td>
                                <td class="small text-muted">2m ago</td>
                                <td><button class="btn btn-sm btn-light text-navy"><i class="far fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td><span class="user-pill text-orange" style="background:#fff3e0; color:#ef6c00;">VK-551</span> Virat Kohli</td>
                                <td>BOM → JFK</td>
                                <td class="fw-bold">₹75,000</td>
                                <td class="text-navy fw-bold">₹82,000</td>
                                <td class="small text-muted">15m ago</td>
                                <td><button class="btn btn-sm btn-light text-navy"><i class="far fa-edit"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sync Logs -->
        <div class="col-lg-4">
            <div class="card-admin h-100">
                <h5 class="fw-900 text-navy mb-4">API Response Terminal</h5>
                <div class="api-terminal p-3 rounded-4 bg-dark text-white-50 small mb-3" style="min-height: 300px; font-family: monospace;" id="apiTerminal">
                    <p class="text-success mb-1">> Service initialized.</p>
                    <p class="mb-1">> System monitoring active alerts...</p>
                </div>
                <div class="p-3 bg-light rounded-4">
                    <h6 class="fw-800 text-navy x-small mb-2">PROVIDER PERFORMANCE</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="x-small fw-bold">Amadeus GDS</span>
                        <span class="x-small text-success">98% UP</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="x-small fw-bold">Robotic API</span>
                        <span class="x-small text-success">100% UP</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 11px; }
    .user-pill { padding: 4px 8px; background: rgba(11,61,97,0.1); color: #0b3d61; border-radius: 4px; font-weight: 800; font-size: 10px; margin-right: 5px; }
    .api-terminal { height: 320px; overflow-y: auto; background: #0f172a !important; color: #10b981 !important; border: 1px solid #1e293b; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trigger = document.getElementById('triggerSync');
        const terminal = document.getElementById('apiTerminal');

        trigger.addEventListener('click', function() {
            trigger.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> SYNCING...';
            trigger.disabled = true;

            const time = new Date().toLocaleTimeString();
            terminal.innerHTML += `<p class="mb-1 text-info">> [${time}] Global Sync started...</p>`;
            terminal.innerHTML += `<p class="mb-1 text-info">> [${time}] Requesting prices for 1,248 active alerts...</p>`;

            setTimeout(() => {
                terminal.innerHTML += `<p class="mb-1 text-success">> [SUCCESS] Handshake with Amadeus complete.</p>`;
                terminal.innerHTML += `<p class="mb-1 text-success">> [ALERT] 12 price drops detected. Queuing WhatsApp notifications.</p>`;
                trigger.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Trigger Global Sync';
                trigger.disabled = false;
            }, 2000);
        });
    });
</script>
@endsection

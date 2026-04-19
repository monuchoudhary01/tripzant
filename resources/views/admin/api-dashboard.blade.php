@extends('layouts.admin')

@section('title', 'API Integration Dashboard | Master Admin')

@section('admin_content')
<div class="admin-dashboard-api">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-900 text-navy mb-1">API Integration Command Center</h4>
            <p class="text-muted small">Manage and monitor third-party global distribution systems (GDS) and robotic fare optimizers.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-navy rounded-pill px-4 fw-bold small"><i class="fas fa-sync-alt me-2"></i> Refresh All States</button>
            <button class="btn btn-admin-primary rounded-pill px-4 fw-bold small"><i class="fas fa-plus me-2"></i> Add New API</button>
        </div>
    </div>

    <!-- API Comparison Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card-admin border-top border-5 border-primary">
                <div class="d-flex justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 bg-primary-light rounded-4 text-primary fs-4"><i class="fas fa-plane-up"></i></div>
                        <div>
                            <h5 class="fw-900 text-navy mb-0">Amadeus GDS</h5>
                            <span class="badge bg-success small">CONNECTED</span>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-toggle" type="checkbox" checked style="width: 40px; height: 20px;">
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-6">
                        <label class="x-small fw-bold text-muted d-block">ENVIRONMENT</label>
                        <select class="form-select form-select-sm border-0 bg-light fw-bold mt-1">
                            <option>Sandbox</option>
                            <option selected>Production</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="x-small fw-bold text-muted d-block">LATENCY</label>
                        <span class="fw-900 text-navy mt-1 d-block">240ms</span>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bg-light p-3 rounded-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="x-small text-muted fw-bold">API KEY</span>
                                <span class="x-small fw-900 text-navy">AMD_****_X92</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="x-small text-muted fw-bold">BASE URL</span>
                                <span class="x-small fw-900 text-navy">api.amadeus.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-admin border-top border-5 border-success">
                <div class="d-flex justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 bg-success-light rounded-4 text-success fs-4"><i class="fas fa-robot"></i></div>
                        <div>
                            <h5 class="fw-900 text-navy mb-0">Fare Maximizer Robotic</h5>
                            <span class="badge bg-success small">ACTIVE</span>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-toggle" type="checkbox" checked style="width: 40px; height: 20px;">
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-6">
                        <label class="x-small fw-bold text-muted d-block">ENVIRONMENT</label>
                        <select class="form-select form-select-sm border-0 bg-light fw-bold mt-1">
                            <option selected>Universal Sandbox</option>
                            <option>Mainframe Pro</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="x-small fw-bold text-muted d-block">AUTO-OPTIMIZE</label>
                        <span class="badge bg-success small mt-1 d-inline-block">ENABLED</span>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bg-light p-3 rounded-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="x-small text-muted fw-bold">ROBOTIC ID</span>
                                <span class="x-small fw-900 text-navy">FM_ROBO_99X1</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="x-small text-muted fw-bold">LAST SYNC</span>
                                <span class="x-small fw-900 text-navy">Just now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- API Testing Panel -->
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-admin h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-900 text-navy mb-0"><i class="fas fa-terminal me-2"></i> API Testing Console</h5>
                    <span class="badge-admin-warning fw-bold">MOCK DATA MODE</span>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="x-small fw-bold text-muted d-block mb-1">SELECT PROVIDER</label>
                        <select class="form-select border shadow-none" id="testProvider">
                            <option value="amadeus">Amadeus GDS</option>
                            <option value="faremaximizer">Fare Maximizer</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="x-small fw-bold text-muted d-block mb-1">CALL TYPE</label>
                        <select class="form-select border shadow-none" id="testCall">
                            <option value="flight_search">Flight Search</option>
                            <option value="hotel_details">Hotel Details</option>
                            <option value="fare_validate">Fare Validation</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-navy w-100 fw-bold" id="triggerApiCall">Run Search Mock</button>
                    </div>
                </div>

                <div class="api-output-view bg-dark rounded-4 p-4 mt-3" style="min-height: 300px; font-family: 'Courier New', Courier, monospace; color: #10b981; overflow-y: auto;">
                    <div id="consoleOutput">
                        <p class="mb-0 text-muted">// System ready. Select a provider and run a mock call.</p>
                        <p class="mb-0 text-muted">// Output will appear here in normalized JSON format.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card-admin h-100">
                <h5 class="fw-900 text-navy mb-4"><i class="fas fa-history me-2"></i> Activity Logs</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="x-small fw-bold text-muted">
                                <th>API Provider</th>
                                <th>MTD</th>
                                <th>Status</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody id="apiLogsTable">
                            <tr>
                                <td><span class="fw-bold text-navy small">Amadeus</span></td>
                                <td><span class="badge bg-light text-navy fw-800">GET</span></td>
                                <td><span class="badge-admin-success">200 OK</span></td>
                                <td><span class="text-muted x-small">10:45 AM</span></td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-navy small">Fare Maximizer</span></td>
                                <td><span class="badge bg-light text-navy fw-800">POST</span></td>
                                <td><span class="badge-admin-success">201 OK</span></td>
                                <td><span class="text-muted x-small">09:30 AM</span></td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-navy small">Amadeus GDS</span></td>
                                <td><span class="badge bg-light text-navy fw-800">GET</span></td>
                                <td><span class="badge-admin-warning">TIMEOUT</span></td>
                                <td><span class="text-muted x-small">Yesterday</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-link text-navy fw-bold small text-decoration-none">View All Network Logs</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-light { background: rgba(11, 61, 97, 0.1); }
    .bg-success-light { background: rgba(34, 197, 94, 0.1); }
    .x-small { font-size: 10px; }
    .badge-admin-warning { 
        background: rgba(249, 115, 22, 0.1); 
        color: #f97316; 
        border-radius: 30px; 
        padding: 4px 12px; 
        font-weight: 700; 
        font-size: 10px;
    }
    .form-check-toggle {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const triggerBtn = document.getElementById('triggerApiCall');
        const consoleOutput = document.getElementById('consoleOutput');
        const logsTable = document.getElementById('apiLogsTable');

        const mockData = {
            amadeus: {
                flight_search: {
                    status: "200 OK",
                    data: {
                        origin: "DEL",
                        destination: "DXB",
                        flights: [
                            { carrier: "Emirates", price: 420.50, currency: "USD" },
                            { carrier: "IndiGo", price: 215.00, currency: "USD" }
                        ]
                    }
                }
            },
            faremaximizer: {
                fare_validate: {
                    status: "200 Success",
                    optimization_result: {
                        original_price: 500,
                        optimized_price: 492,
                        saving_robot: "FM_ROBO_99X1",
                        confidence: "98%"
                    }
                }
            }
        };

        triggerBtn.addEventListener('click', function() {
            const provider = document.getElementById('testProvider').value;
            const call = document.getElementById('testCall').value;

            consoleOutput.innerHTML = `
                <p class="mb-1 text-info">> [System] Initializing ${provider.toUpperCase()} handshake...</p>
                <p class="mb-1 text-info">> [System] Sending Request to https://api.${provider}.com/v2/...</p>
            `;
            triggerBtn.disabled = true;

            setTimeout(() => {
                const response = mockData[provider] ? mockData[provider][call] || { status: "404 Not Found", message: "Mock data not defined for this call type." } : { status: "Error", message: "Provider not found" };
                
                consoleOutput.innerHTML += `
                    <p class="mb-2 text-success">> [Response] Received ${response.status}</p>
                    <pre class="bg-navy p-3 rounded-3 text-white-50" style="font-size: 12px;">${JSON.stringify(response, null, 4)}</pre>
                `;
                triggerBtn.disabled = false;
                
                // Add to logs
                const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><span class="fw-bold text-navy small">${provider.charAt(0).toUpperCase() + provider.slice(1)}</span></td>
                    <td><span class="badge bg-light text-navy fw-800">POST</span></td>
                    <td><span class="badge-admin-success">SEARCH</span></td>
                    <td><span class="text-muted x-small">${time}</span></td>
                `;
                logsTable.prepend(row);
                if(logsTable.rows.length > 8) logsTable.deleteRow(8);
            }, 1200);
        });
    });
</script>
@endsection

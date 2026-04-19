@extends('layouts.iata_panel')

@section('title', 'Connection Requests | IATA Collaboration')

@section('iata_content')
<div class="mb-5">
    <h4 class="fw-800 text-navy mb-4 outfit">Network Collaboration Requests</h4>

    <div class="row g-4">
        <!-- Incoming Requests -->
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white border border-light h-100">
                <div class="p-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-800 text-navy mb-0 outfit uppercase"><i class="fas fa-inbox me-2 text-primary"></i> Incoming Requests</h6>
                    <span class="badge bg-blue-soft text-primary rounded-pill px-3 fw-800">2 Pending</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th>Agent Details</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $incoming = [
                                    ['name' => 'Swift Wings India', 'id' => 'IATA-440292', 'city' => 'Mumbai, IN', 'date' => 'Today'],
                                    ['name' => 'Royal Emirates Travel', 'id' => 'IATA-880112', 'city' => 'Sharjah, UAE', 'date' => 'Yesterday'],
                                ];
                                @endphp
                                @foreach($incoming as $inc)
                                <tr>
                                    <td>
                                        <div class="fw-800 text-navy">{{ $inc['name'] }}</div>
                                        <div class="x-small fw-700 text-primary">{{ $inc['id'] }}</div>
                                    </td>
                                    <td>
                                        <div class="small fw-700 text-muted">{{ $inc['city'] }}</div>
                                    </td>
                                    <td>
                                        <div class="small fw-700 text-muted">{{ $inc['date'] }}</div>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-success btn-sm rounded-pill px-3 fw-800 me-2" onclick="handleAction(this, 'Approved')">Approve</button>
                                        <button class="btn btn-light btn-sm rounded-pill px-3 fw-800 border" onclick="handleAction(this, 'Rejected')">Reject</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outgoing / Statistics -->
        <div class="col-xl-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light mb-4">
                <h6 class="fw-800 text-navy mb-4 outfit uppercase">Collaboration Health</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="bg-light p-3 rounded-4 border">
                            <div class="h4 fw-900 text-navy outfit mb-0">14</div>
                            <div class="x-small fw-800 text-muted uppercase">Active Partners</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-3 rounded-4 border">
                            <div class="h4 fw-900 text-primary outfit mb-0">₹45k</div>
                            <div class="x-small fw-800 text-muted uppercase">Shared Profit (MTD)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-white border border-light overflow-hidden">
                <div class="p-4 border-bottom border-light">
                    <h6 class="fw-800 text-navy mb-0 outfit uppercase">Outgoing Requests Status</h6>
                </div>
                <div class="p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-4 border-light d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-800 text-navy">Global Fly Travels</div>
                                <div class="x-small fw-700 text-muted uppercase">Sent on 06 Apr</div>
                            </div>
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-1 x-small fw-800">PENDING</span>
                        </li>
                        <li class="list-group-item p-4 border-light d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-800 text-navy">Singapore High-Flyers</div>
                                <div class="x-small fw-700 text-muted uppercase">Sent on 05 Apr</div>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 x-small fw-800">APPROVED</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleAction(btn, status) {
        const row = btn.closest('tr');
        row.style.transition = '0.5s';
        row.style.opacity = '0';
        row.style.transform = 'translateX(20px)';
        setTimeout(() => row.remove(), 500);
    }
</script>
@endsection

@section('styles')
<style>
    .bg-blue-soft { background-color: #eff6ff; color: #1e40af; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection

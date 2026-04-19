@extends('layouts.app')

@section('title', "Staff & Sub-Agents — Tripzant B2B Agent Portal")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
    <x-partner-sidebar active="staff" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
                <div>
                    <h2 class="fw-900 text-navy mb-1"><i class="fas fa-users-cog me-2 text-primary"></i> Staff & Sub-Agents</h2>
                    <p class="text-muted small mb-0 uppercase tracking-wider fw-bold">Manage Roles | Wallet Caps | Activity Monitor</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small uppercase">INVITE SUB-AGENT <i class="fas fa-user-plus ms-2 text-warning"></i></button>
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-900 shadow-sm bg-white x-small uppercase">DOWNLOAD TEAM LOGS <i class="fas fa-download ms-2"></i></button>
                </div>
            </div>

            <!-- Team Stats -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-blue-light text-blue rounded-3 p-3"><i class="fas fa-user-friends"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">ACTIVE TEAM</span>
                            <span class="h5 fw-900 text-navy mb-0">12 Agents</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-green-light text-green rounded-3 p-3"><i class="fas fa-chart-pie"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">TEAM TURNOVER</span>
                            <span class="h5 fw-900 text-navy mb-0">₹4.2 Cr</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-orange-light text-orange rounded-3 p-3"><i class="fas fa-user-shield"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">PENDING APPROVAL</span>
                            <span class="h5 fw-900 text-navy mb-0">2 Users</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-items-center justify-content-center">
                    <div class="p-4 border-2 border-dashed rounded-4 w-100">
                        <div class="icon-circle bg-light text-muted mx-auto mb-2" style="width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:50%; font-size: 10px;"><i class="fas fa-sync"></i></div>
                        <p class="x-small text-muted fw-bold mb-0">Refresh Sync</p>
                    </div>
                </div>
            </div>

            <!-- Agent List -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5">
                <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Verified Sub-Agent Network</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">AGENT NAME / ID</th>
                                <th class="py-3">ROLE</th>
                                <th class="py-3">WALLET CAP</th>
                                <th class="py-3">CURRENT UTILIZATION</th>
                                <th class="py-3">YIELD (MTD)</th>
                                <th class="py-3">STATUS</th>
                                <th class="py-3 text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $agents = [
                                ['name' => 'Karan Malhotra', 'id' => 'SA-224', 'role' => 'Senior Exec', 'cap' => '₹50,000', 'util' => '₹12,450', 'yield' => '+₹2,425', 'status' => 'ACTIVE'],
                                ['name' => 'Prisha Roy', 'id' => 'SA-225', 'role' => 'Junior Booking Agent', 'cap' => '₹10,000', 'util' => '₹8,200', 'yield' => '+₹850', 'status' => 'ACTIVE'],
                                ['name' => 'Sameer Khan', 'id' => 'SA-228', 'role' => 'Contractor', 'cap' => '₹5,000', 'util' => '₹0', 'yield' => '₹0', 'status' => 'FROZEN'],
                                ['name' => 'Aisha Fatima', 'id' => 'SA-230', 'role' => 'Support Desk', 'cap' => '₹25,000', 'util' => '₹18,400', 'yield' => '+₹1,120', 'status' => 'ACTIVE'],
                            ];
                            @endphp
                            @foreach($agents as $a)
                            <tr class="py-4 border-bottom">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-box bg-light text-navy rounded-circle px-3 py-2 fw-900 border">{{ substr($a['name'], 0, 1) }}</div>
                                        <div>
                                            <span class="d-block text-navy fw-900">{{ $a['name'] }}</span>
                                            <span class="x-small text-muted">{{ $a['id'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-navy px-3 py-1 x-small rounded-pill">{{ $a['role'] }}</span></td>
                                <td class="text-navy fw-900">{{ $a['cap'] }}</td>
                                <td>
                                    @php $util_p = (intval(str_replace(['₹',','],'',$a['util'])) / intval(str_replace(['₹',','],'',$a['cap']))) * 100 @endphp
                                    <div class="progress rounded-pill bg-light" style="height: 6px; width: 100px;">
                                        <div class="progress-bar bg-primary" style="width:{{ $util_p }}%"></div>
                                    </div>
                                    <span class="x-small text-muted mt-1 d-block">{{ $a['util'] }} occupied</span>
                                </td>
                                <td class="text-success">{{ $a['yield'] }}</td>
                                <td>
                                    <span class="badge {{ $a['status'] == 'ACTIVE' ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} rounded-pill px-3 py-1 x-small fw-bold">{{ $a['status'] }}</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-navy rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle ms-2"><i class="fas fa-user-slash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .btn-outline-navy { border-color: #001f3f; color: #001f3f; }
    .btn-outline-navy:hover { background: #001f3f; color: #fff; }
    .bg-blue-light { background: #eff6ff; color: #2563eb; }
    .bg-green-light { background: #ecfdf5; color: #10b981; }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981; }
    .bg-orange-light { background: #fff7ed; color: #f97316; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444; }
</style>
@endsection

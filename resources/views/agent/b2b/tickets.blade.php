@extends('layouts.app')

@section('title', "Agent Support Center — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="support-tickets" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Agent Support & Help Center</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Instant GDS Ticketing Support | Wallet Discrepancies | 24/7 Desk</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-warning rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-lg text-navy">RAISE NEW TICKET <i class="fas fa-plus-circle ms-2"></i></button>
                </div>
            </div>

            <div class="row g-5">
                <!-- Support Topics -->
                <div class="col-xl-4">
                    <div class="d-flex flex-column gap-4">
                        <div class="card border-0 shadow-sm rounded-5 bg-white p-5 hover-up-sm transition-all border-start border-primary border-4">
                            <i class="fas fa-ticket-alt h3 mb-4 text-primary opacity-50"></i>
                            <h6 class="fw-900 text-navy mb-2">Ticketing Issues</h6>
                            <p class="x-small text-muted mb-0">PNR not generated, seat selection errors or amendment requests.</p>
                        </div>
                        <div class="card border-0 shadow-sm rounded-5 bg-white p-5 hover-up-sm transition-all">
                            <i class="fas fa-wallet h3 mb-4 text-orange opacity-50"></i>
                            <h6 class="fw-900 text-navy mb-2">Wallet & Billing</h6>
                            <p class="x-small text-muted mb-0">Recharge not credited, GST invoice queries or balance refunds.</p>
                        </div>
                         <div class="card border-0 shadow-sm rounded-5 bg-white p-5 hover-up-sm transition-all">
                            <i class="fas fa-user-shield h3 mb-4 text-green opacity-50"></i>
                            <h6 class="fw-900 text-navy mb-2">Profile & Access</h6>
                            <p class="x-small text-muted mb-0">Sub-agent permissions, KYC verification and account security.</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Tickets -->
                <div class="col-xl-8">
                    <div class="bg-white rounded-5 shadow-sm p-5 border-0">
                         <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4">Ongoing Investigation Logs</h6>
                         <div class="table-responsive">
                            <table class="table table-hover align-middle border-0">
                                <thead class="x-small text-muted fw-bold uppercase border-bottom">
                                    <tr>
                                        <th class="py-3 ps-0">TICKET ID</th>
                                        <th class="py-3">SUBJECT</th>
                                        <th class="py-3">PRIORITY</th>
                                        <th class="py-3">LAST ACTION</th>
                                        <th class="py-3 text-end">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="small fw-bold">
                                    @foreach([
                                        ['id' => 'SUP-4282', 'subject' => 'PNR RT24W8 Amendment', 'priority' => 'HIGH', 'action' => '2 hrs ago', 'status' => 'OPEN'],
                                        ['id' => 'SUP-4281', 'subject' => 'GST Invoice #INV-92', 'priority' => 'NORMAL', 'action' => '5 hrs ago', 'status' => 'PENDING'],
                                        ['id' => 'SUP-4275', 'subject' => 'Wallet Recharge Lag', 'priority' => 'URGENT', 'action' => '1 day ago', 'status' => 'RESOLVED'],
                                    ] as $t)
                                    <tr class="py-4 border-bottom border-light">
                                        <td class="ps-0 py-4 text-navy fw-900">#{{ $t['id'] }}</td>
                                        <td>{{ $t['subject'] }}</td>
                                        <td><span class="badge {{ $t['priority'] == 'URGENT' ? 'bg-red-subtle text-red' : 'bg-blue-subtle text-blue' }} x-small px-3 py-1 rounded-pill fw-900">{{ $t['priority'] }}</span></td>
                                        <td class="text-muted opacity-50">{{ $t['action'] }}</td>
                                        <td class="text-end">
                                             <span class="badge {{ $t['status'] == 'OPEN' ? 'bg-orange-subtle text-orange' : ($t['status'] == 'RESOLVED' ? 'bg-green-subtle text-green' : 'bg-light text-muted') }} rounded-pill px-3 py-1 x-small fw-bold">{{ $t['status'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         </div>
                    </div>

                    <!-- FAQ Quick Links -->
                    <div class="card border-0 shadow-sm rounded-5 bg-navy text-white p-5 mt-5 position-relative overflow-hidden">
                        <div class="position-relative" style="z-index: 2;">
                             <h6 class="fw-900 mb-4 uppercase tracking-wide opacity-75 text-warning">Automated Help Desk</h6>
                             <div class="row g-4">
                                 <div class="col-md-6 border-end border-white-subtle">
                                     <a href="#" class="text-white text-decoration-none d-block mb-3 small fw-bold"><i class="fas fa-chevron-right me-2 text-warning"></i> How to calculate B2B Margin correctly?</a>
                                     <a href="#" class="text-white text-decoration-none d-block small fw-bold"><i class="fas fa-chevron-right me-2 text-warning"></i> What happened if IATA GDS goes down?</a>
                                 </div>
                                 <div class="col-md-6">
                                     <a href="#" class="text-white text-decoration-none d-block mb-3 small fw-bold"><i class="fas fa-chevron-right me-2 text-warning"></i> Refund cycle for cancelled tickets?</a>
                                     <a href="#" class="text-white text-decoration-none d-block small fw-bold"><i class="fas fa-chevron-right me-2 text-warning"></i> Sub-agent wallet permission setup?</a>
                                 </div>
                             </div>
                        </div>
                        <div style="position:absolute; right:-20px; top:-20px; width:150px; height:150px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                    </div>
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
    .bg-navy { background: #001f3f !important; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
    .bg-blue-subtle { background: #eff6ff; color: #2563eb; }
    .text-blue { color: #2563eb !important; }
    .bg-orange-subtle { background: #fff7ed; color: #f97316; }
    .text-orange { color: #f97316 !important; }
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .hover-up-sm:hover { transform: translateY(-5px); transition: 0.3s; }
    .transition-all { transition: all 0.3s ease; }
    .border-white-subtle { border-color: rgba(255,255,255,0.1) !important; }
</style>
@endsection

@extends('layouts.app')

@section('title', "Tax & Reports — Tripzant B2B Agent Portal")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
    <x-partner-sidebar active="reports" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
                <div>
                    <h2 class="fw-900 text-navy mb-1"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> Tax & Financial Reports</h2>
                    <p class="text-muted small mb-0 uppercase tracking-wider fw-bold">GST Reports | Sales Summaries | Commission Statements</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small uppercase">DOWNLOAD ALL GST RECO <i class="fas fa-file-pdf ms-2 text-danger"></i></button>
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-900 shadow-sm bg-white x-small uppercase">EXPORT CSV <i class="fas fa-file-csv ms-2 text-success"></i></button>
                </div>
            </div>

            <!-- Report Center Cards -->
            <div class="row g-4 mb-5 text-center">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100 hover-up-sm transition-all">
                        <div class="bg-blue-light text-blue rounded-circle p-3 mx-auto mb-4" style="width:70px; height:70px; display:flex; align-items:center; justify-content:center; font-size:24px;"><i class="fas fa-receipt"></i></div>
                        <h6 class="fw-900 text-navy mb-2">Net Fare Statements</h6>
                        <p class="x-small text-muted mb-4 opacity-75">Monthly breakdown of all GDS issued fares and wallet deductions.</p>
                        <button class="btn btn-navy-light rounded-pill w-100 small fw-bold py-2 mt-auto">GENERATE REPORT</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100 hover-up-sm transition-all">
                        <div class="bg-green-light text-green rounded-circle p-3 mx-auto mb-4" style="width:70px; height:70px; display:flex; align-items:center; justify-content:center; font-size:24px;"><i class="fas fa-calculator"></i></div>
                        <h6 class="fw-900 text-navy mb-2">GST B2B Reports</h6>
                        <p class="x-small text-muted mb-4 opacity-75">Detailed GSTR-1 & GSTR-3B compliant reports for agent tax input claim.</p>
                        <button class="btn btn-navy-light rounded-pill w-100 small fw-bold py-2 mt-auto">GENERATE REPORT</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100 hover-up-sm transition-all">
                        <div class="bg-purple-light text-purple rounded-circle p-3 mx-auto mb-4" style="width:70px; height:70px; display:flex; align-items:center; justify-content:center; font-size:24px;"><i class="fas fa-piggy-bank"></i></div>
                        <h6 class="fw-900 text-navy mb-2">Commission Ledger</h6>
                        <p class="x-small text-muted mb-4 opacity-75">Tracking of all incentive payouts and referral bonuses for sub-agents.</p>
                        <button class="btn btn-navy-light rounded-pill w-100 small fw-bold py-2 mt-auto">GENERATE REPORT</button>
                    </div>
                </div>
            </div>

            <!-- Detailed Monthly Ledger Preview -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-history me-3 text-primary"></i> Last 3 Months Performance Overview</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">MONTH</th>
                                <th class="py-3">TOTAL SALES</th>
                                <th class="py-3">NET FARE COST</th>
                                <th class="py-3">AGENT MARGIN</th>
                                <th class="py-3">TOTAL GST COLLECTED</th>
                                <th class="py-3 text-end">SETTLEMENT STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $reports = [
                                ['month' => 'MARCH 2026', 'sales' => '₹1,42,80,000', 'cost' => '₹1,32,00,000', 'margin' => '₹10,80,000', 'gst' => '₹4,85,000', 'status' => 'SETTLED'],
                                ['month' => 'FEBRUARY 2026', 'sales' => '₹1,18,40,000', 'cost' => '₹1,09,10,000', 'margin' => '₹9,30,000', 'gst' => '₹3,92,000', 'status' => 'SETTLED'],
                                ['month' => 'JANUARY 2026', 'sales' => '₹98,54,000', 'cost' => '₹91,22,000', 'margin' => '₹7,32,000', 'gst' => '₹2,68,000', 'status' => 'DISPUTED'],
                            ];
                            @endphp
                            @foreach($reports as $r)
                            <tr class="py-4 border-bottom">
                                <td class="text-navy fw-900">{{ $r['month'] }}</td>
                                <td class="text-navy">{{ $r['sales'] }}</td>
                                <td class="text-muted">{{ $r['cost'] }}</td>
                                <td class="text-success">{{ $r['margin'] }}</td>
                                <td class="text-navy">{{ $r['gst'] }}</td>
                                <td class="text-end">
                                    <span class="badge {{ $r['status'] == 'SETTLED' ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} rounded-pill px-3 py-1 x-small fw-bold uppercase">{{ $r['status'] }}</span>
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
    .btn-navy-light { background: #f0f7ff; color: #001f3f; border: none; }
    .btn-navy-light:hover { background: #001f3f; color: #fff; }
    .bg-blue-light { background: #eff6ff; color: #2563eb; }
    .bg-green-light { background: #ecfdf5; color: #10b981; }
    .bg-purple-light { background: #f5f3ff; color: #8b5cf6; }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444; }
    .hover-up-sm:hover { transform: translateY(-5px); transition: 0.3s; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endsection

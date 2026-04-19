@extends('layouts.app')

@section('title', "Expense Analytics — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="report-expense" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Expense Yield & Analysis</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Visualizing organizational spend trends, department yield, and savings.</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">EXPORT FULL XLS <i class="fas fa-file-excel ms-2 text-success"></i></button>
                </div>
            </div>

            <!-- Analytics Dashboard Stats -->
            <div class="row g-5 mb-5 animate-up">
                 <div class="col-xl-3 col-md-6">
                      <div class="p-5 bg-white shadow-sm rounded-5 border-0 h-100">
                          <span class="x-small fw-bold text-muted uppercase tracking-widest d-block mb-3 opacity-75">Current MTD Spend</span>
                          <h2 class="fw-900 text-navy mb-2">₹12,45,800</h2>
                          <div class="mt-3 text-red x-small fw-bold">↑ 12.5% VS PREVIOUS (FY TREND)</div>
                      </div>
                 </div>
                 <div class="col-xl-3 col-md-6">
                      <div class="p-5 bg-white shadow-sm rounded-5 border-0 h-100">
                          <span class="x-small fw-bold text-muted uppercase tracking-widest d-block mb-3 opacity-75">Negotiated Savings</span>
                          <h2 class="fw-900 text-green mb-2">₹2,12,000</h2>
                          <div class="mt-3 x-small fw-bold text-muted opacity-50">VIA CORPORATE ACCORDS HUB</div>
                      </div>
                 </div>
                 <div class="col-xl-6 col-md-12">
                      <div class="p-5 bg-navy text-white shadow-lg rounded-5 border-0 h-100 position-relative overflow-hidden">
                           <div class="position-relative" style="z-index: 2;">
                                <h6 class="fw-900 mb-4 uppercase tracking-widest opacity-50 x-small">Spend Breakdown by Department</h6>
                                <div class="d-flex gap-4 p-0 m-0" style="list-style: none;">
                                     @foreach([
                                         ['label' => 'SALES', 'val' => 45, 'col' => 'bg-warning'],
                                         ['label' => 'ENG', 'val' => 30, 'col' => 'bg-blue'],
                                         ['label' => 'FIN', 'val' => 15, 'col' => 'bg-green'],
                                         ['label' => 'OTH', 'val' => 10, 'col' => 'bg-light opacity-30'],
                                     ] as $bar)
                                     <div class="flex-grow-1 text-center">
                                          <div class="progress rounded-pill mb-2 bg-white bg-opacity-10" style="height: 10px;">
                                               <div class="progress-bar {{ $bar['col'] }} rounded-pill" style="width: {{ $bar['val'] }}%"></div>
                                          </div>
                                          <span class="x-small fw-900 uppercase opacity-75">{{ $bar['label'] }}</span>
                                     </div>
                                     @endforeach
                                </div>
                           </div>
                           <div style="position:absolute; right:-50px; bottom:-50px; width:200px; height:200px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                      </div>
                 </div>
            </div>

            <!-- Detailed Expense Records Manifest -->
            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-chart-pie me-2 text-primary"></i> Monthly Line-Item Registry</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-4 ps-0">BILLING DATE / ID</th>
                                <th class="py-4">DEPARTMENT UNIT</th>
                                <th class="py-4">EMPLOYEE TRAVELER</th>
                                <th class="py-4">FARE TYPE / SECTOR</th>
                                <th class="py-4 text-end">YIELD AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $expenses = [
                                ['id' => '#EXP-9028', 'date' => '05 APR, 2026', 'dept' => 'ENGINEERING', 'emp' => 'Sneha Roy', 'fare' => 'CORP_NEG', 'sector' => 'BOM → DXB', 'amt' => '₹18,200'],
                                ['id' => '#EXP-9027', 'date' => '04 APR, 2026', 'dept' => 'SALES & MKTG', 'emp' => 'Rahul Khanna', 'fare' => 'SAVER_FLX', 'sector' => 'DEL → BOM', 'amt' => '₹4,820'],
                                ['id' => '#EXP-9026', 'date' => '02 APR, 2026', 'dept' => 'FINANCE', 'emp' => 'Amit Shah', 'fare' => 'CORP_PREM', 'sector' => 'MAA → SIN', 'amt' => '₹42,850'],
                            ];
                            @endphp
                            @foreach($expenses as $ex)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex flex-column">
                                         <span class="text-navy fw-900 h6 mb-1">{{ $ex['id'] }}</span>
                                         <span class="x-small text-muted fw-bold">{{ $ex['date'] }}</span>
                                     </div>
                                </td>
                                <td>
                                     <span class="badge bg-light text-navy border px-3 py-1 rounded-pill x-small fw-bold">{{ $ex['dept'] }}</span>
                                </td>
                                <td class="text-navy fw-900 h6 mb-0">{{ $ex['emp'] }}</td>
                                <td>
                                     <span class="d-block text-navy">{{ $ex['sector'] }}</span>
                                     <span class="badge bg-blue-subtle text-blue x-small px-2 border mt-1">{{ str_replace('_', ' ', $ex['fare']) }}</span>
                                </td>
                                <td class="text-end text-navy fw-900 h6 mb-0">{{ $ex['amt'] }}</td>
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
    .bg-navy { background: #001f3f !important; }
    .bg-blue { background: #3b82f6 !important; }
    .bg-blue-subtle { background: #eff6ff; color: #2563eb; }
    .text-blue { color: #2563eb !important; }
    .bg-green { background: #10b981 !important; }
    .text-green { color: #10b981 !important; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
@endsection

@extends('layouts.app')

@section('title', "Profit & Margin Analysis — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="report-profit" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Profit / Margin Report Dashboard</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Visual Earnings Tracking | Airline Yield Performance</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">DOWNLOAD EARNINGS PDF <i class="fas fa-file-pdf ms-2 text-danger"></i></button>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="p-5 bg-white shadow-sm rounded-5 border-0 h-100 animate-up">
                        <span class="x-small fw-bold text-muted uppercase tracking-widest d-block mb-3 opacity-75">Net Earnings (MTD)</span>
                        <h2 class="fw-900 text-navy mb-2">₹1,24,450.00</h2>
                        <span class="badge bg-green-subtle text-green fw-bold px-3 py-1 rounded-pill uppercase x-small">+18% growth</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-5 bg-white shadow-sm rounded-5 border-0 h-100 animate-up delay-1">
                        <span class="x-small fw-bold text-muted uppercase tracking-widest d-block mb-3 opacity-75">Avg Margin / Ticket</span>
                        <h2 class="fw-900 text-navy mb-2">₹842.50</h2>
                        <span class="x-small fw-bold text-muted mt-2 opacity-50 uppercase tracking-tighter">Across all 1,248 Bookings</span>
                    </div>
                </div>
                <div class="col-md-4 text-center d-flex align-items-center justify-content-center">
                    <div class="p-5 bg-navy text-white rounded-5 shadow-lg h-100 w-100 position-relative overflow-hidden">
                        <div class="position-relative" style="z-index: 2;">
                             <h6 class="fw-900 mb-3 opacity-75 uppercase x-small">Top Earning Sector</h6>
                             <h3 class="fw-900 mb-1">DEL ⇌ DXB</h3>
                             <p class="x-small opacity-75 mb-0">Yielding ₹1,200 avg margin per Pax.</p>
                        </div>
                        <div style="position:absolute; right:-30px; bottom:-30px; width:150px; height:150px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-chart-line me-2 text-primary"></i> Earnings Breakdown by Airline Node</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3 ps-0">AIRLINE / GDS ID</th>
                                <th class="py-3">TICKETS ISSUED</th>
                                <th class="py-3">GROSS TURNOVER</th>
                                <th class="py-3">NET PROFIT</th>
                                <th class="py-3 text-end">YIELD %</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $profitReports = [
                                ['airline' => 'IndiGo (6E)', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/af/IndiGo_Airlines_logo.svg', 'count' => '412', 'turnover' => '₹42.8L', 'profit' => '₹51,450', 'yield' => '1.2%'],
                                ['airline' => 'Air India (AI)', 'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/30/Air_India_Logo.svg/1200px-Air_India_Logo.svg.png', 'count' => '256', 'turnover' => '₹58.2L', 'profit' => '₹32,200', 'yield' => '0.55%'],
                                ['airline' => 'Vistara (UK)', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Vistara_Logo.svg', 'count' => '184', 'turnover' => '₹36.8L', 'profit' => '₹24,500', 'yield' => '0.67%'],
                                ['airline' => 'Emirates (EK)', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Emirates_logo.svg', 'count' => '92', 'turnover' => '₹82.5L', 'profit' => '₹18,200', 'yield' => '0.22%'],
                            ];
                            @endphp
                            @foreach($profitReports as $pr)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex align-items-center gap-3">
                                         <img src="{{ $pr['airline'] == 'Emirates (EK)' ? 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Emirates_logo.svg' : $pr['logo'] }}" height="18" class="opacity-50" alt="">
                                         <span class="text-navy fw-900 h6 mb-0">{{ $pr['airline'] }}</span>
                                     </div>
                                </td>
                                <td>{{ $pr['count'] }} ISSUED</td>
                                <td class="text-navy">{{ $pr['turnover'] }}</td>
                                <td class="text-green fw-900">{{ $pr['profit'] }}</td>
                                <td class="text-end opacity-75">
                                    <div class="badge bg-light text-navy rounded-pill px-3 py-1 x-small fw-bold">{{ $pr['yield'] }}</div>
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
    .bg-navy { background: #001f3f !important; }
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .delay-1 { animation-delay: 0.1s; }
</style>
@endsection

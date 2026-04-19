@extends('layouts.app')

@section('title', "Booking Report — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="report-bookings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Booking Analytics Report</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Full Manifest Tracking | Date Range Filtering | Airline Volume Analysis</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">EXPORT FULL XLS <i class="fas fa-file-excel ms-2 text-success"></i></button>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Historical Flight Manifest Hub</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3 ps-0">BOOKING ID / DATE</th>
                                <th class="py-3">PNR</th>
                                <th class="py-3">AIRLINE NODE</th>
                                <th class="py-3">COMMISSION HUB</th>
                                <th class="py-3">NET COST PAID</th>
                                <th class="py-3 text-end">SETTLEMENT</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $bookReports = [
                                ['id' => '#BK-9284', 'pnr' => 'RT24W8', 'airline' => 'IndiGo (6E)', 'comm' => '₹425 (Fixed)', 'net' => '₹4,425'],
                                ['id' => '#BK-9283', 'pnr' => 'XP19B2', 'airline' => 'Emirates (EK)', 'comm' => '₹1,240 (Yield)', 'net' => '₹16,960'],
                                ['id' => '#BK-9282', 'pnr' => 'KL009M', 'airline' => 'Vistara (UK)', 'comm' => '₹850 (Markup)', 'net' => '₹41,200'],
                            ];
                            @endphp
                            @foreach($bookReports as $br)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex flex-column">
                                         <span class="text-navy fw-900">{{ $br['id'] }}</span>
                                         <span class="x-small text-muted fw-bold">{{ now()->subDays(rand(1,10))->format('d M, Y') }}</span>
                                     </div>
                                </td>
                                <td><span class="badge bg-light text-navy px-3 py-1 rounded-pill fw-900 x-small">{{ $br['pnr'] }}</span></td>
                                <td class="text-navy opacity-75">{{ $br['airline'] }}</td>
                                <td class="text-green">{{ $br['comm'] }}</td>
                                <td class="text-navy fw-900">{{ $br['net'] }}</td>
                                <td class="text-end">
                                     <span class="badge bg-green-subtle text-green px-3 py-1 rounded-pill x-small fw-bold">SETTLED</span>
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
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
</style>
@endsection

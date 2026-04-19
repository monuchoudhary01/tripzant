@extends('layouts.app')

@section('title', "Booking Manifest — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="report-bookings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Corporate Booking History HUB</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Full Manifest Tracking | Date Range Filtering | Airline Volume Analysis</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">EXPORT FULL XLS <i class="fas fa-file-excel ms-2 text-success"></i></button>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide border-bottom pb-4"><i class="fas fa-plane-departure me-2 text-primary"></i> Historical Organization Flight Manifest Hub</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-4 ps-0">PNR / ID / DATE</th>
                                <th class="py-4">TRAVELER NAME</th>
                                <th class="py-4">DEPARTMENT UNIT</th>
                                <th class="py-4">AIRLINE & SECTOR</th>
                                <th class="py-4">NET FARE</th>
                                <th class="py-4 text-end">SETTLEMENT STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $bookReports = [
                                ['id' => '#BK-90282', 'pnr' => 'RT24W8', 'name' => 'Rahul Khanna', 'dept' => 'Sales', 'airline' => 'IndiGo (DEL→BOM)', 'net' => '₹4,425'],
                                ['id' => '#BK-90281', 'pnr' => 'XP19B2', 'name' => 'Sneha Roy', 'dept' => 'Engineering', 'airline' => 'Emirates (BOM→DXB)', 'net' => '₹16,960'],
                                ['id' => '#BK-90280', 'pnr' => 'KL009M', 'name' => 'Amit Shah', 'dept' => 'Finance', 'airline' => 'Vistara (MAA→SIN)', 'net' => '₹41,200'],
                            ];
                            @endphp
                            @foreach($bookReports as $br)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex flex-column">
                                         <span class="text-navy fw-900">{{ $br['pnr'] }}</span>
                                         <span class="x-small text-muted fw-bold opacity-30">{{ $br['id'] }} | {{ now()->subDays(rand(1,10))->format('d M') }}</span>
                                     </div>
                                </td>
                                <td class="text-navy fw-900 h6 mb-0">{{ $br['name'] }}</td>
                                <td>
                                     <span class="badge bg-light text-navy border px-3 py-1 rounded-pill x-small fw-bold">{{ $br['dept'] }}</span>
                                </td>
                                <td class="text-navy opacity-75 fw-bold">{{ $br['airline'] }}</td>
                                <td class="text-navy fw-900 text-end">{{ $br['net'] }}</td>
                                <td class="text-end">
                                     <span class="badge bg-green-subtle text-green px-3 py-1 rounded-pill x-small fw-bold border">SETTLED</span>
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

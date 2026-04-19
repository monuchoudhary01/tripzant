@extends('layouts.app')

@section('title', "All Bookings — Tripzant B2B Agent Portal")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
    <x-partner-sidebar active="bookings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
                <div>
                    <h2 class="fw-900 text-navy mb-1"><i class="fas fa-suitcase me-2 text-primary"></i> Agent Booking Manifest</h2>
                    <p class="text-muted small mb-0 uppercase tracking-wider fw-bold">Live Booking Feed | PNR Tracking | E-Ticket Download</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-900 shadow-sm bg-white x-small">GENERATE REPORT <i class="fas fa-file-csv ms-2"></i></button>
                    <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small">FILTER BY DATE <i class="fas fa-calendar-alt ms-2"></i></button>
                </div>
            </div>

            <!-- Booking Stats Strip -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-blue-light text-blue rounded-3 p-3"><i class="fas fa-ticket-alt"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">TOTAL BOOKINGS</span>
                            <span class="h5 fw-900 text-navy mb-0">1,248</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-green-light text-green rounded-3 p-3"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">CONFIRMED</span>
                            <span class="h5 fw-900 text-navy mb-0">1,180</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-orange-light text-orange rounded-3 p-3"><i class="fas fa-spinner"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">IN QUEUE</span>
                            <span class="h5 fw-900 text-navy mb-0">42</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 d-flex align-items-center gap-3">
                        <div class="bg-red-light text-red rounded-3 p-3"><i class="fas fa-times-circle"></i></div>
                        <div>
                            <span class="x-small fw-bold text-muted uppercase d-block">CANCELLED</span>
                            <span class="h5 fw-900 text-navy mb-0">26</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">PNR / BOOKING ID</th>
                                <th class="py-3">CUSTOMER / PAX</th>
                                <th class="py-3">SECTOR</th>
                                <th class="py-3">AIRLINE</th>
                                <th class="py-3">NET FARE</th>
                                <th class="py-3">MARGIN</th>
                                <th class="py-3">STATUS</th>
                                <th class="py-3 text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $bookings = [
                                ['id' => 'TZ-B2B-9284', 'pnr' => 'RT24W8', 'pax' => 'Rohit Sharma + 1', 'sector' => 'DEL ⇌ BOM', 'airline' => 'IndiGo (6E)', 'fare' => '₹8,450', 'margin' => '+₹500', 'status' => 'CONFIRMED'],
                                ['id' => 'TZ-B2B-9283', 'pnr' => 'XP19B2', 'pax' => 'Anjali Gupta', 'sector' => 'BOM → DXB', 'airline' => 'Emirates (EK)', 'fare' => '₹18,200', 'margin' => '+₹1,200', 'status' => 'CONFIRMED'],
                                ['id' => 'TZ-B2B-9282', 'pnr' => 'PNR_PENDING', 'pax' => 'Vikram Singh', 'sector' => 'DEL → LHR', 'airline' => 'Air India (AI)', 'fare' => '₹56,400', 'margin' => '+₹2,500', 'status' => 'IN_QUEUE'],
                                ['id' => 'TZ-B2B-9281', 'pnr' => 'KL009M', 'pax' => 'Sneha Verma', 'sector' => 'MAA ⇌ SIN', 'airline' => 'Singapore (SQ)', 'fare' => '₹42,850', 'margin' => '+₹1,800', 'status' => 'CONFIRMED'],
                            ];
                            @endphp
                            @foreach($bookings as $b)
                            <tr class="py-4 border-bottom">
                                <td>
                                    <span class="d-block text-navy fw-900">{{ $b['pnr'] }}</span>
                                    <span class="x-small text-muted">{{ $b['id'] }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm bg-light text-navy rounded-circle d-flex align-items-center justify-content-center x-small px-2 py-1">{{ substr($b['pax'], 0, 1) }}</div>
                                        <span>{{ $b['pax'] }}</span>
                                    </div>
                                </td>
                                <td class="text-navy">{{ $b['sector'] }}</td>
                                <td class="text-muted x-small">{{ $b['airline'] }}</td>
                                <td class="text-navy fw-900">{{ $b['fare'] }}</td>
                                <td class="text-success">+{{ $b['margin'] }}</td>
                                <td>
                                    <span class="badge {{ $b['status'] == 'CONFIRMED' ? 'bg-green-subtle text-green' : 'bg-orange-subtle text-orange' }} rounded-pill px-3 py-1 x-small fw-bold">{{ $b['status'] }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 x-small fw-bold">
                                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-download me-2 text-primary"></i> Download Ticket</a></li>
                                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-file-invoice me-2 text-primary"></i> View Invoice</a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fas fa-times me-2"></i> Cancel Booking</a></li>
                                        </ul>
                                    </div>
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
    .avatar-sm { width: 24px; height: 24px; }
    
    .bg-blue-light { background: #eff6ff; color: #2563eb; }
    .bg-green-light { background: #ecfdf5; color: #10b981; }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981; }
    .bg-orange-light { background: #fff7ed; color: #f97316; }
    .bg-orange-subtle { background: #fffaf0; color: #f6ad55; }
    .text-orange { color: #f97316; }
    .bg-red-light { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444; }
</style>
@endsection

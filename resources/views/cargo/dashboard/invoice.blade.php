@extends('layouts.dashboard')

@section('dashboard_content')
<div class="user-cargo-wrap p-4">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden invoice-card bg-white">
                <!-- Invoice Header -->
                <div class="bg-navy p-5 text-white position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="fw-900 mb-1">Tripzant.com</h2>
                            <h4 class="fw-bold opacity-75 mb-0 text-uppercase ls-1">INVOICE</h4>
                            <p class="x-small mb-0 opacity-50">Easitrip Air Logistics Worldwide</p>
                        </div>
                        <div class="col-md-6 text-md-end mt-4 mt-md-0">
                            <h5 class="fw-bold mb-1">Invoice #INV-{{ $booking->shipment_id }}</h5>
                            <p class="mb-2 x-small opacity-75">Date: {{ $booking->created_at->format('M d, Y') }}</p>
                            <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold">PAID (COMMISSION)</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Billing Info -->
                    <div class="row mb-5">
                        <div class="col-sm-6">
                            <h6 class="text-muted x-small fw-900 text-uppercase ls-1 mb-3">BILL TO</h6>
                            <h5 class="fw-900 text-navy mb-1">{{ $booking->sender_details['name'] }}</h5>
                            <p class="text-muted x-small mb-1">{{ Auth::user()->email }}</p>
                            <p class="text-muted x-small mb-0">{{ $booking->sender_details['address'] }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                            <h6 class="text-muted x-small fw-900 text-uppercase ls-1 mb-3">SHIPMENT INFO</h6>
                            <p class="mb-1 fw-bold text-navy x-small">ID: {{ $booking->shipment_id }}</p>
                            <p class="mb-1 text-muted x-small">Origin: {{ $booking->pickup_city }}</p>
                            <p class="mb-0 text-muted x-small">Destination: {{ $booking->delivery_city }}</p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive mb-5">
                        <table class="table table-borderless">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 x-small fw-900 text-navy text-uppercase ls-1">Description</th>
                                    <th class="py-3 x-small fw-900 text-navy text-uppercase ls-1 text-center">Weight</th>
                                    <th class="pe-4 py-3 x-small fw-900 text-navy text-uppercase ls-1 text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="ps-4 py-4">
                                        <h6 class="fw-bold text-navy mb-1">Global Cargo Shipment</h6>
                                        <p class="text-muted x-small mb-0">Express air freight with auto-assigned carrier ({{ $booking->flight_id }}).</p>
                                    </td>
                                    <td class="py-4 text-center fw-bold text-navy">{{ $booking->weight }} KG</td>
                                    <td class="pe-4 py-4 text-end fw-bold text-navy">₹{{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                                <tr class="border-bottom text-success">
                                    <td class="ps-4 py-4">
                                        <h6 class="fw-bold mb-1">Promotional Discount</h6>
                                        <p class="x-small mb-0 opacity-75">Complimentary delivery by Tripzant for demo.</p>
                                    </td>
                                    <td class="py-4 text-center">--</td>
                                    <td class="pe-4 py-4 text-end fw-bold">-₹{{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row justify-content-end mb-4">
                        <div class="col-md-5">
                            <div class="bg-light p-4 rounded-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="x-small fw-bold text-muted">Subtotal (Client)</span>
                                    <span class="x-small fw-bold text-navy">₹{{ number_format($booking->total_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="x-small fw-bold text-muted">Tax (GST 18%)</span>
                                    <span class="x-small fw-bold text-navy">₹0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-900 text-navy">GRAND TOTAL</span>
                                    <h4 class="fw-900 text-primary mb-0">₹0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- B2B Insight (Internal Only) -->
                    <div class="p-4 border border-primary border-opacity-10 rounded-4 bg-primary bg-opacity-5">
                        <h6 class="fw-900 text-primary x-small text-uppercase ls-1 mb-3"><i class="fas fa-network-wired me-2"></i> B2B Logistics Insights (Internal)</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <span class="d-block x-small text-muted fw-bold">AMADEUS TICKET COST</span>
                                <h6 class="fw-900 text-navy mb-0">₹{{ number_format($booking->flight->cost ?? 12000, 2) }} {{ $booking->flight->currency ?? 'INR' }}</h6>
                            </div>
                            <div class="col-md-4">
                                <span class="d-block x-small text-muted fw-bold">ASSIGNED AIRLINE</span>
                                <h6 class="fw-900 text-navy mb-0">{{ $booking->flight->flight_number ?? 'Pending' }}</h6>
                            </div>
                            <div class="col-md-4">
                                <span class="d-block x-small text-muted fw-bold">SYSTEM STATUS</span>
                                <span class="badge bg-primary text-white x-small">API CONNECTED</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top text-center">
                        <button onclick="window.print()" class="btn btn-navy rounded-pill px-5 fw-bold btn-lg shadow-lg me-3 d-print-none">
                            <i class="fas fa-print me-2"></i> PRINT INVOICE
                        </a>
                        <a href="{{ route('cargo.dashboard.index') }}" class="btn btn-light border rounded-pill px-5 fw-bold btn-lg d-print-none">
                             BACK TO LIST
                        </a>
                        <p class="text-muted x-small mt-4 mb-0">This is a computer-generated invoice and requires no signature.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #0f172a; }
    .text-navy { color: #0f172a; }
    .btn-navy { background-color: #0f172a; color: white; border: none; }
    .btn-navy:hover { background-color: #1e293b; color: white; }
    .fw-900 { font-weight: 900; }
    .ls-1 { letter-spacing: 1px; }
    .x-small { font-size: 11px; }
    @media print {
        .d-print-none { display: none !important; }
        .sidebar, .user-top-bar { display: none !important; }
        .dashboard-main { padding: 0 !important; margin: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>
@endsection

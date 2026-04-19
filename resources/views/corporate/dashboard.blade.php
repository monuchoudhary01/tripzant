@extends('layouts.app')

@section('title', "Corporate Dashboard — Tripzant")

@section('content')
@php
    // In a real app, this comes from $user->role. Simulating for demo.
    $is_admin = true; 
@endphp
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar :role="$is_admin ? 'admin' : 'employee'" active="index" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <div>
                    <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Hello, Admin!</h2>
                    <p class="text-muted small fw-bold mb-0 opacity-75">Organization Command: Managing Corporate Travel Governance</p>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <div class="bg-primary-subtle text-primary rounded-pill px-4 py-2 x-small fw-900 shadow-sm border border-primary border-opacity-10">
                        <i class="fas fa-building me-2"></i> INFOSYS LTD (CORP-ID: 9028)
                    </div>
                </div>
            </div>            @if($is_admin)
            <!-- ADMIN DASHBOARD STATS -->
            <div class="row g-4 mb-5 animate-up">
                <div class="col-xl-3 col-md-6">
                    <div class="p-4 rounded-5 bg-white shadow-sm h-100 border-0">
                        <div class="bg-blue-light text-blue rounded-4 mb-4 d-flex align-items-center justify-content-center" style="width:50px; height:50px; font-size:20px;"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span class="x-small fw-bold text-muted uppercase tracking-widest">Monthly Spend</span>
                        <h3 class="fw-900 text-navy mb-0 mt-2">₹{{ number_format($totalSpend, 2) }}</h3>
                        <div class="mt-3 text-green x-small fw-bold">↑ 8.2% FROM LAST MONTH</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="p-4 rounded-5 bg-white shadow-sm h-100 border-0">
                        <div class="bg-orange-light text-orange rounded-4 mb-4 d-flex align-items-center justify-content-center" style="width:50px; height:50px; font-size:20px;"><i class="fas fa-hourglass-half"></i></div>
                        <span class="x-small fw-bold text-muted uppercase tracking-widest">Pending Approvals</span>
                        <h3 class="fw-900 text-navy mb-0 mt-2">{{ str_pad($pendingCount, 2, '0', STR_PAD_LEFT) }} Requests</h3>
                        <div class="mt-3">
                             <a href="{{ route('corporate.approvals') }}" class="text-orange x-small fw-900 text-decoration-none">REVIEW NOW <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="p-4 rounded-5 bg-white shadow-sm h-100 border-0">
                        <div class="bg-green-light text-green rounded-4 mb-4 d-flex align-items-center justify-content-center" style="width:50px; height:50px; font-size:20px;"><i class="fas fa-check-circle"></i></div>
                        <span class="x-small fw-bold text-muted uppercase tracking-widest">Total Bookings (MTD)</span>
                        <h3 class="fw-900 text-navy mb-0 mt-2">{{ $totalBookings }} ISSUED</h3>
                        <div class="mt-3 x-small fw-bold opacity-50">98.5% APPROVAL RATE</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="p-4 rounded-5 bg-navy text-white shadow-lg h-100 border-0">
                        <h6 class="fw-900 mb-3 opacity-75 small uppercase">Policy Compliance</h6>
                        <div class="progress bg-white bg-opacity-10 rounded-pill mb-3" style="height: 10px;">
                            <div class="progress-bar bg-warning rounded-pill" style="width: 82%;"></div>
                        </div>
                        <p class="x-small opacity-75 mb-0">82% of all employee travel is within defined budget limits.</p>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals Feed -->
            <div class="row g-5">
                <div class="col-xl-8">
                    <div class="bg-white rounded-5 shadow-sm p-5 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h5 class="fw-900 text-navy mb-0">Pending Travel Requests</h5>
                            <span class="badge bg-danger rounded-pill x-small px-3 py-2 fw-bold">ACTION REQUIRED</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border-0">
                                <tbody class="small fw-bold">
                                    @foreach($pendingRequests as $req)
                                    @php $details = json_decode($req->booking_details, true); @endphp
                                    <tr class="py-4 border-bottom border-light">
                                        <td class="py-4 ps-0">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar p-2 bg-light text-navy rounded-circle fw-900" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">{{ substr($req->contact_email, 0, 1) }}</div>
                                                <div>
                                                    <h6 class="text-navy fw-900 mb-0 small">{{ $req->contact_email }}</h6>
                                                    <span class="x-small text-muted fw-bold">{{ $req->booking_type }} - {{ $details['sector'] ?? 'Generic' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="d-block">₹{{ number_format($req->selling_price, 2) }}</span>
                                            <span class="badge bg-green-subtle text-green x-small px-3 py-1 rounded-pill mt-1">IN POLICY</span>
                                        </td>
                                        <td class="text-muted opacity-50">{{ $req->created_at->format('d M') }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('corporate.approve', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-navy btn-sm rounded-pill px-3 fw-900 x-small py-2 uppercase me-2 shadow-sm">APPROVE</button>
                                            </form>
                                            <button class="btn btn-light btn-sm rounded-pill px-3 fw-900 x-small py-2 uppercase border">REJECT</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($pendingRequests->isEmpty())
                                        <tr><td colspan="4" class="text-center py-5 text-muted">No pending requests found.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>            </div>

                <div class="col-xl-4">
                     <div class="card border-0 shadow-sm rounded-5 bg-white p-5 h-100">
                         <h5 class="fw-900 text-navy mb-5 border-bottom pb-4">Corporate Savings Analytics</h5>
                         <div class="d-flex flex-column gap-5 mt-4">
                             <div class="saving-item d-flex gap-4">
                                  <div class="bg-blue-light text-blue rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-hand-holding-usd h4 mb-0"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">Negotiated Fares</h6>
                                       <p class="x-small text-muted mb-0">Saved ₹42,500 this month using Direct Corporate Accords.</p>
                                  </div>
                             </div>
                             <div class="saving-item d-flex gap-4">
                                  <div class="bg-green-light text-green rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-percentage h4 mb-0"></i></div>
                                  <div>
                                       <h6 class="fw-900 text-navy mb-1 small uppercase">GST Input Tax Credit</h6>
                                       <p class="x-small text-muted mb-0">₹1.2L potential ITC generated for current billing cycle.</p>
                                  </div>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
            @endif

        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .bg-blue-light { background: #eff6ff; color: #3b82f6; }
    .bg-orange-light { background: #fffcf0; color: #f59e0b; }
    .bg-green-light { background: #ecfdf5; color: #10b981; }
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .text-blue { color: #2563eb !important; }
    .text-orange { color: #f97316 !important; }
    .text-green { color: #10b981 !important; }
    .text-red { color: #ef4444 !important; }
</style>
@endsection

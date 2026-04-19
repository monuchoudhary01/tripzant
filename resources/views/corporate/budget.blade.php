@extends('layouts.app')

@section('title', "Budget Limits — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="budget" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Departmental Budget Manifest</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Assign and monitor travel budget allocations by business unit.</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">REFRESH FISCAL CAPS <i class="fas fa-sync-alt ms-2 text-warning"></i></button>
                </div>
            </div>

            <!-- Budget Grid -->
            <div class="row g-5">
                 @foreach([
                     ['dept' => 'SALES & MARKETING', 'color' => 'bg-primary', 'total' => '₹12,00,000', 'used' => '₹8,45,000', 'rem' => '₹3,55,000', 'prog' => 70],
                     ['dept' => 'PRODUCT ENGINEERING', 'color' => 'bg-green', 'total' => '₹5,00,000', 'used' => '₹1,20,000', 'rem' => '₹3,80,000', 'prog' => 24],
                     ['dept' => 'FINANCE & OPERATIONS', 'color' => 'bg-warning', 'total' => '₹3,00,000', 'used' => '₹2,85,000', 'rem' => '₹15,000', 'prog' => 95],
                     ['dept' => 'GENERAL / OVERHEAD', 'color' => 'bg-navy', 'total' => '₹1,50,000', 'used' => '₹12,400', 'rem' => '₹1,37,600', 'prog' => 8],
                 ] as $b)
                 <div class="col-xl-6">
                      <div class="card border-0 shadow-sm rounded-5 bg-white p-5 animate-up">
                           <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom border-light">
                                <h6 class="fw-900 text-navy uppercase tracking-widest small mb-0">{{ $b['dept'] }} Hub</h6>
                                <span class="badge {{ $b['prog'] > 90 ? 'bg-red-subtle text-red' : ($b['prog'] > 50 ? 'bg-blue-subtle text-blue' : 'bg-green-subtle text-green') }} x-small px-3 py-1 rounded-pill fw-bold border">
                                     FISCAL FY26
                                </span>
                           </div>

                           <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-end mb-3">
                                     <span class="x-small fw-bold text-muted uppercase">Organization Allocation</span>
                                     <h3 class="fw-900 text-navy mb-0">{{ $b['total'] }}</h3>
                                </div>
                                <div class="progress rounded-pill bg-light" style="height: 12px;">
                                     <div class="progress-bar {{ $b['color'] }} rounded-pill transition-all" style="width: {{ $b['prog'] }}%"></div>
                                </div>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                     <span class="x-small fw-bold text-muted">{{ $b['prog'] }}% CONSUMED</span>
                                     <span class="x-small fw-900 text-navy">{{ $b['used'] }} USED</span>
                                </div>
                           </div>

                           <div class="p-4 rounded-4 bg-light d-flex justify-content-between align-items-center border-dashed border-2 border-primary border-opacity-10">
                                <div>
                                     <span class="d-block x-small text-muted fw-bold uppercase">REMAINING HEADROOM</span>
                                     <h5 class="fw-900 mb-0 {{ $b['prog'] > 90 ? 'text-red' : 'text-navy' }}">{{ $b['rem'] }}</h5>
                                </div>
                                <button class="btn btn-navy btn-sm rounded-pill px-4 fw-900 x-small py-2 uppercase shadow-sm">RECHARGE LIMIT</button>
                           </div>
                      </div>
                 </div>
                 @endforeach
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
    .bg-green { background: #10b981 !important; }
    .bg-primary { background: #1a73e8 !important; }
    .bg-warning { background: #f59e0b !important; }
    .bg-blue-subtle { background: #eff6ff; color: #2563eb; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
    .text-green { color: #10b981 !important; }
    .text-blue { color: #2563eb !important; }
    .border-dashed { border-style: dashed !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .transition-all { transition: all 0.5s ease-in-out; }
</style>
@endsection

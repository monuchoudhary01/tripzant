@extends('layouts.app')

@section('title', "Request Approvals — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="approvals" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Pending Travel Approvals</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Review and authorize employee travel requests within policy.</p>
                </div>
            </div>

            <div class="d-flex flex-column gap-5">
                @foreach([
                    ['name' => 'Rahul Khanna', 'sector' => 'DEL → BOM', 'price' => '₹4,820', 'policy' => 'IN_POLICY', 'airline' => 'IndiGo 6E-242', 'dept' => 'Sales & Mktg'],
                    ['name' => 'Sneha Roy', 'sector' => 'BOM → DXB', 'price' => '₹18,200', 'policy' => 'OUT_POLICY', 'airline' => 'Air India AI-805', 'dept' => 'Product Engineering'],
                    ['name' => 'Amit Shah', 'sector' => 'MAA → SIN', 'price' => '₹42,850', 'policy' => 'IN_POLICY', 'airline' => 'Vistara UK-943', 'dept' => 'Finance'],
                ] as $req)
                <div class="approval-card bg-white rounded-5 shadow-sm p-4 border-start border-5 {{ $req['policy'] == 'IN_POLICY' ? 'border-primary' : 'border-danger' }} animate-up">
                    <div class="row align-items-center g-4">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar p-3 bg-light text-navy rounded-circle fw-900 border" style="width: 50px; height: 50px; display:flex; align-items:center; justify-content:center;">{{ substr($req['name'], 0, 1) }}</div>
                                <div>
                                    <h6 class="text-navy fw-900 mb-0 small">{{ $req['name'] }}</h6>
                                    <span class="x-small text-muted fw-bold uppercase opacity-50">{{ $req['dept'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="d-flex align-items-center gap-4 text-center justify-content-center">
                                  <div>
                                       <span class="h6 fw-900 text-navy mb-1">{{ substr($req['sector'], 0, 3) }}</span>
                                       <span class="x-small text-muted fw-bold d-block">06:15</span>
                                  </div>
                                  <div class="flex-grow-1 px-3">
                                       <div class="small fw-bold text-muted mb-1 opacity-50">{{ $req['airline'] }}</div>
                                       <div class="line bg-light h-1 w-100"></div>
                                  </div>
                                  <div>
                                       <span class="h6 fw-900 text-navy mb-1">{{ substr($req['sector'], -3) }}</span>
                                       <span class="x-small text-muted fw-bold d-block">08:30</span>
                                  </div>
                             </div>
                        </div>
                        <div class="col-md-2 text-center border-start border-light">
                             <h5 class="fw-900 text-navy mb-1">{{ $req['price'] }}</h5>
                             <span class="badge {{ $req['policy'] == 'IN_POLICY' ? 'bg-green-subtle text-green' : 'bg-red-subtle text-red' }} x-small px-3 py-1 rounded-pill fw-bold border">
                                  {{ str_replace('_', ' ', $req['policy']) }}
                             </span>
                        </div>
                        <div class="col-md-3 text-end">
                             <div class="d-flex gap-2 justify-content-end">
                                 <form action="{{ route('corporate.admin.approve', ['id' => rand(1,99)]) }}" method="POST">
                                     @csrf
                                     <button type="submit" class="btn btn-navy rounded-pill px-4 fw-900 x-small py-3 uppercase shadow-sm">APPROVE ✅</button>
                                 </form>
                                 <form action="{{ route('corporate.admin.reject', ['id' => rand(1,99)]) }}" method="POST">
                                     @csrf
                                     <button type="submit" class="btn btn-light rounded-pill px-4 fw-900 x-small py-3 uppercase border">REJECT ❌</button>
                                 </form>
                             </div>
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
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
    .line { height: 1px; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
@endsection

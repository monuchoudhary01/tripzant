@extends('layouts.app')

@section('title', "Manage Employees — Tripzant Corporate")

@section('content')
<div class="corporate-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-corporate-sidebar role="admin" active="employee-manage" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Corporate Employee Manifest</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Directory of authorized travelers within your organization.</p>
                </div>
                <div class="d-flex gap-3">
                     <a href="{{ route('corporate.employees.add') }}" class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">ADD NEW EMPLOYEE <i class="fas fa-plus ms-2"></i></a>
                </div>
            </div>

            <!-- List Section -->
            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Authorized Corporate Travelers Hub</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-4 ps-0">EMPLOYEE NAME / DEPT</th>
                                <th class="py-4">ACCESS ROLE</th>
                                <th class="py-4">MONTHLY BUDGET CAP</th>
                                <th class="py-4">KYC PROFILE</th>
                                <th class="py-4 text-end">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $employees = [
                                ['name' => 'Rahul Khanna', 'dept' => 'Sales', 'role' => 'EMPLOY_GEN', 'cap' => '₹45,000', 'kyc' => 'VERIFIED'],
                                ['name' => 'Sneha Roy', 'dept' => 'Engineering', 'role' => 'EMPLOY_PLUS', 'cap' => '₹1,20,000', 'kyc' => 'VERIFIED'],
                                ['name' => 'Amit Shah', 'dept' => 'Finance', 'role' => 'DEPT_ADMIN', 'cap' => 'UNLIMITED', 'kyc' => 'VERIFIED'],
                                ['name' => 'Priya Sharma', 'dept' => 'HR', 'role' => 'EMPLOY_GEN', 'cap' => '₹25,000', 'kyc' => 'PENDING'],
                            ];
                            @endphp
                            @foreach($employees as $e)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex align-items-center gap-3">
                                         <div class="avatar p-3 bg-light text-navy rounded-circle fw-900" style="width: 45px; height: 45px; display:flex; align-items:center; justify-content:center;">{{ substr($e['name'], 0, 1) }}</div>
                                         <div>
                                             <h6 class="text-navy fw-900 mb-0 small">{{ $e['name'] }}</h6>
                                             <span class="x-small text-muted fw-bold uppercase opacity-50">{{ $e['dept'] }} Division</span>
                                         </div>
                                     </div>
                                </td>
                                <td>
                                     <span class="badge bg-blue-subtle text-blue x-small px-3 py-1 rounded-pill fw-bold border">{{ str_replace('_', ' ', $e['role']) }}</span>
                                </td>
                                <td class="text-navy fw-900">{{ $e['cap'] }}</td>
                                <td>
                                     <span class="badge {{ $e['kyc'] == 'VERIFIED' ? 'bg-green-subtle text-green' : 'bg-orange-subtle text-orange' }} x-small px-3 py-1 rounded-pill fw-bold">{{ $e['kyc'] }}</span>
                                </td>
                                <td class="text-end">
                                     <button class="btn btn-light rounded-circle shadow-none ms-3"><i class="fas fa-edit text-muted"></i></button>
                                     <button class="btn btn-light rounded-circle shadow-none ms-2"><i class="fas fa-trash text-red"></i></button>
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
    .bg-blue-subtle { background: #eff6ff; color: #2563eb; }
    .text-blue { color: #2563eb !important; }
    .bg-green-subtle { background: #ecfdf5; color: #10b981; }
    .text-green { color: #10b981 !important; }
    .bg-orange-subtle { background: #fffcf0; color: #f59e0b; }
    .text-orange { color: #f59e0b !important; }
    .text-red { color: #ef4444 !important; }
</style>
@endsection

@extends('layouts.app')

@section('title', "Passengers List — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="manage-pax" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Saved Passengers Manifest</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Quick Auto-Fill Data | Frequent Flyer Repository</p>
                </div>
                <div class="d-flex gap-3">
                     <button class="btn btn-navy rounded-pill px-5 fw-900 x-small py-3 uppercase shadow-sm">ADD NEW PASSENGER <i class="fas fa-plus ms-2 text-warning"></i></button>
                </div>
            </div>

            <!-- List Section -->
            <div class="card border-0 shadow-sm rounded-5 bg-white p-5 mt-5">
                 <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Verified Frequent Travelers</h6>
                 <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3 ps-0">PASSENGER NAME</th>
                                <th class="py-3">GENDER / DOB</th>
                                <th class="py-3">FFN / LOYALTY</th>
                                <th class="py-3">DOCUMENTS</th>
                                <th class="py-3 text-end">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @php
                            $paxList = [
                                ['name' => 'Arjun Malhotra', 'gender' => 'Male', 'dob' => '12 Mar 1988', 'ffn' => '6E-4482J (IndiGo)', 'docs' => 'Passport Verified'],
                                ['name' => 'Sneha Gupta', 'gender' => 'Female', 'dob' => '24 Nov 1995', 'ffn' => 'AI-LP33B (Air India)', 'docs' => 'Aadhar Attached'],
                                ['name' => 'Vikram Roy', 'gender' => 'Male', 'dob' => '05 Jan 1982', 'ffn' => 'EK-PK92M (Emirates)', 'docs' => 'Passport Expired'],
                                ['name' => 'Priya Sharma', 'gender' => 'Female', 'dob' => '18 Jun 1992', 'ffn' => 'NONE', 'docs' => 'No Docs'],
                            ];
                            @endphp
                            @foreach($paxList as $p)
                            <tr class="py-4 border-bottom border-light">
                                <td class="ps-0 py-4">
                                     <div class="d-flex align-items-center gap-3">
                                         <div class="avatar px-3 py-2 bg-light text-navy rounded-circle fw-900">{{ substr($p['name'], 0, 1) }}</div>
                                         <div>
                                             <h6 class="text-navy fw-900 mb-0 small">{{ $p['name'] }}</h6>
                                             <span class="x-small text-muted fw-bold opacity-50 uppercase">Individual Account</span>
                                         </div>
                                     </div>
                                </td>
                                <td>
                                    <span class="d-block">{{ $p['gender'] }}</span>
                                    <span class="x-small text-muted fw-bold opacity-50">{{ $p['dob'] }}</span>
                                </td>
                                <td class="text-navy fw-900 uppercase x-small">{{ $p['ffn'] }}</td>
                                <td>
                                    @php $isExpired = str_contains($p['docs'], 'Expired'); @endphp
                                    <span class="badge {{ $isExpired ? 'bg-red-subtle text-red' : 'bg-green-subtle text-green' }} px-3 py-1 rounded-pill x-small fw-bold">{{ $p['docs'] }}</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-none"><i class="fas fa-edit text-muted"></i></button>
                                    <button class="btn btn-sm btn-light rounded-circle shadow-none mx-2"><i class="fas fa-trash text-red"></i></button>
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
    .bg-red-subtle { background: #fef2f2; color: #ef4444; }
    .text-red { color: #ef4444 !important; }
</style>
@endsection

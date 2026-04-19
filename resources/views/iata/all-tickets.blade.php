@extends('layouts.iata_panel')

@section('title', 'Ticket Inventory | IATA Agent Panel')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-800 text-navy mb-0 outfit">All Issued Tickets</h4>
        <div class="d-flex gap-3">
             <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0 fw-600" placeholder="Search Ticket Number...">
            </div>
            <button class="btn btn-light border fw-800"><i class="fas fa-download me-2"></i> Bulk Export</button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 d-flex flex-row align-items-center gap-4 border border-light">
                <div class="bg-blue-soft p-3 rounded-3"><i class="fas fa-ticket-alt fs-4"></i></div>
                <div>
                    <div class="text-muted small fw-800 uppercase">Total Tickets</div>
                    <div class="h4 fw-900 text-navy mb-0 outfit">4,284</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 d-flex flex-row align-items-center gap-4 border border-light">
                <div class="bg-green-soft p-3 rounded-3"><i class="fas fa-check-circle fs-4"></i></div>
                <div>
                    <div class="text-muted small fw-800 uppercase">Live (Valid)</div>
                    <div class="h4 fw-900 text-navy mb-0 outfit">4,190</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 d-flex flex-row align-items-center gap-4 border border-light">
                <div class="bg-orange-soft p-3 rounded-3"><i class="fas fa-undo-alt fs-4"></i></div>
                <div>
                    <div class="text-muted small fw-800 uppercase">Cancelled / Void</div>
                    <div class="h4 fw-900 text-navy mb-0 outfit">94</div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-premium mb-0">
            <thead>
                <tr>
                    <th>Ticket Number</th>
                    <th>PNR</th>
                    <th>Passenger</th>
                    <th>Airline</th>
                    <th>Issue Date</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $tickets = [
                    ['tkt' => '098-9920485123', 'pnr' => 'AX782S', 'pax' => 'Rahul Sharma', 'airline' => 'Air India', 'date' => '07 Apr 2024', 'status' => 'Live'],
                    ['tkt' => '532-1140992834', 'pnr' => 'BJ993P', 'pax' => 'Priya Patel', 'airline' => 'IndiGo', 'date' => '06 Apr 2024', 'status' => 'Live'],
                    ['tkt' => '228-5520114882', 'pnr' => 'CK552Q', 'pax' => 'Amit Shah', 'airline' => 'Vistara', 'date' => '05 Apr 2024', 'status' => 'Void'],
                    ['tkt' => '098-2231145521', 'pnr' => 'DR994L', 'pax' => 'Sneha Kapoor', 'airline' => 'Air India', 'date' => '05 Apr 2024', 'status' => 'Live'],
                    ['tkt' => '532-8842210993', 'pnr' => 'ET110K', 'pax' => 'Rajesh Kumar', 'airline' => 'IndiGo', 'date' => '04 Apr 2024', 'status' => 'Refunded'],
                ];
                @endphp
                @foreach($tickets as $t)
                <tr>
                    <td class="fw-800 font-monospace text-navy">{{ $t['tkt'] }}</td>
                    <td class="fw-800 text-primary">{{ $t['pnr'] }}</td>
                    <td class="fw-700">{{ $t['pax'] }}</td>
                    <td class="fw-800">{{ $t['airline'] }}</td>
                    <td class="fw-600 text-muted">{{ $t['date'] }}</td>
                    <td>
                        <span class="badge-status {{ $t['status'] == 'Live' ? 'badge-success' : ($t['status'] == 'Void' ? 'badge-danger' : 'badge-warning') }}">
                            {{ $t['status'] }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm fw-800 rounded-pill px-3 border">Manage</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

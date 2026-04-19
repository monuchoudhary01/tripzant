@extends('layouts.iata_panel')

@section('title', 'PNR List | IATA Agent Panel')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-800 text-navy mb-0 outfit">PNR Management</h4>
        <div class="d-flex gap-3">
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0 fw-600" placeholder="Search PNR or Passenger...">
            </div>
            <button class="btn btn-light border fw-800"><i class="fas fa-filter me-2"></i> Filter</button>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-premium mb-0">
            <thead>
                <tr>
                    <th>PNR</th>
                    <th>Booking Date</th>
                    <th>Lead Passenger</th>
                    <th>Itinerary</th>
                    <th>Flight</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $pnrs = [
                    ['pnr' => 'AX782S', 'date' => '07 Apr 2024', 'pax' => 'Rahul Sharma', 'route' => 'DEL → BOM', 'flight' => 'AI-102', 'status' => 'Pending', 'color' => 'warning'],
                    ['pnr' => 'XP992L', 'date' => '07 Apr 2024', 'pax' => 'Anita Desai', 'route' => 'BOM → DXB', 'flight' => 'EK-501', 'status' => 'Pending', 'color' => 'warning'],
                    ['pnr' => 'QT114M', 'date' => '07 Apr 2024', 'pax' => 'Suresh Raina', 'route' => 'DEL → SIN', 'flight' => 'SQ-403', 'status' => 'Pending', 'color' => 'warning'],
                    ['pnr' => 'CK552Q', 'date' => '06 Apr 2024', 'pax' => 'Priya Patel', 'route' => 'BLR → GOA', 'flight' => '6E-284', 'status' => 'Issued', 'color' => 'success'],
                ];
                @endphp
                @foreach($pnrs as $p)
                <tr>
                    <td class="fw-800 text-primary">{{ $p['pnr'] }}</td>
                    <td class="fw-600 text-muted">{{ $p['date'] }}</td>
                    <td class="fw-800">{{ $p['pax'] }}</td>
                    <td class="fw-700">{{ $p['route'] }}</td>
                    <td class="fw-600"><span class="badge bg-light text-navy border font-monospace">{{ $p['flight'] }}</span></td>
                    <td>
                        <span class="badge-status {{ 'badge-'.$p['color'] }}">
                            {{ $p['status'] }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            @if($p['status'] == 'Pending')
                                <a href="{{ route('iata.network.issue-partner', ['pnr' => $p['pnr']]) }}" class="btn btn-success btn-sm fw-800 px-3 border-0 rounded-start-pill">
                                    <i class="fas fa-handshake me-1"></i> Issue via Partner
                                </a>
                            @else
                                <button class="btn btn-light btn-sm fw-800 px-3 border-0 rounded-start-pill">View</button>
                            @endif
                            <button class="btn btn-light btn-sm border-start rounded-end-pill" data-bs-toggle="dropdown"><i class="fas fa-chevron-down"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 p-2" style="z-index: 1001;">
                                <li><a class="dropdown-item rounded-2 fw-700 py-2" href="#"><i class="fas fa-file-pdf me-2 text-danger"></i> Download E-ticket</a></li>
                                <li><a class="dropdown-item rounded-2 fw-700 py-2" href="#"><i class="fas fa-sync-alt me-2 text-primary"></i> Request Reissue</a></li>
                                <li><a class="dropdown-item rounded-2 fw-700 py-2" href="#"><i class="fas fa-undo-alt me-2 text-warning"></i> Cancel & Refund</a></li>
                                <li><hr class="dropdown-divider opacity-10"></li>
                                <li><a class="dropdown-item rounded-2 fw-700 py-2 text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Delete Records</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 px-3">
        <div class="text-muted small fw-700">Showing 1 to 4 of 24 results</div>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link border-0 fw-800 bg-light rounded-pill px-3 me-2" href="#">Prev</a></li>
                <li class="page-item active"><a class="page-link border-0 fw-800 rounded-pill px-3 me-2" href="#">1</a></li>
                <li class="page-item"><a class="page-link border-0 fw-800 rounded-pill px-3 me-2" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 fw-800 bg-light rounded-pill px-3" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection

@section('styles')
<style>
    .badge-info { background: #e0f2fe; color: #0369a1; }
    .page-link:hover { background: var(--iata-blue); color: white; }
    .pagination .active .page-link { background: var(--iata-blue); }
</style>
@endsection

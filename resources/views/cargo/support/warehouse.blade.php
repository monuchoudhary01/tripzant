@extends('layouts.user_dashboard')

@section('title', 'Warehouse Management | TripZant Cargo')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-5">
        <div class="col-12 text-center bg-white p-5 rounded-4 shadow-sm border-top border-primary border-5">
            <h2 class="fw-bold mb-3"><i class="fas fa-barcode text-primary me-2"></i> Cargo Scan & Relay Center</h2>
            <p class="text-muted">Module 4: Global Hub Logistics - Update Shipment Status from Facility</p>
            <div class="input-group w-50 mx-auto mt-4 mb-2">
                <input type="text" id="scan_ref" class="form-control bg-light border-0 py-3 rounded-pill ps-4" placeholder="Scan Barcode or Type Booking Ref...">
                <button class="btn btn-primary px-5 rounded-pill ms-2 fw-bold" onclick="scanParcel()">Locate Parcel</button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Dashboard Inventory List -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold">Hub Inventory (Processing)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small fw-bold text-uppercase">
                            <tr>
                                <th class="ps-4">Ref ID</th>
                                <th>Route</th>
                                <th>Client Details</th>
                                <th>Zone Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parcels as $p)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-primary">{{ $p->booking_ref }}</span><br>
                                    <small class="badge bg-soft-info text-info rounded-pill x-small">TYPE: {{ $p->parcel_type }}</small>
                                </td>
                                <td class="small">{{ $p->origin_city }} <i class="fas fa-arrow-right mx-1 opacity-50"></i> {{ $p->destination_city }}</td>
                                <td>
                                    <h6 class="mb-0 small fw-bold">{{ $p->sender_details['name'] }}</h6>
                                    <small class="text-muted">{{ $p->sender_details['phone'] }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-soft-warning text-warning fw-bold">{{ $p->status }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-dark rounded-pill px-3" data-bs-toggle="dropdown">
                                            Update Hub <i class="fas fa-chevron-down ms-1"></i>
                                        </button>
                                        <ul class="dropdown-menu border-0 shadow-sm rounded-3">
                                            <li><a class="dropdown-item" href="#" onclick="updateRelay('{{ $p->booking_ref }}', 'Warehouse')">Move to Sorting</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateRelay('{{ $p->booking_ref }}', 'Customs')">Move to Customs</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-success" href="#" onclick="updateRelay('{{ $p->booking_ref }}', 'In Transit')"><i class="fas fa-plane-departure me-1"></i> Final Dispatch</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted small italic">Regional hub currently clear. No pending parcels found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Relay Center Insights -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Facility Insight</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-soft-primary p-3 rounded-3 me-3">
                            <i class="fas fa-th fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $parcels->count() }}</h4>
                            <small class="text-muted">Parcels Stored In Facility</small>
                        </div>
                    </div>
                    <div class="progress rounded-pill mb-3" style="height: 10px;">
                        <div class="progress-bar bg-primary" style="width: 65%;"></div>
                    </div>
                    <small class="text-muted d-block mb-4">Hub Capacity: 240 / 500 SQM</small>
                    
                    <button class="btn btn-navy w-100 rounded-pill py-3 fw-bold mb-2">Print Hub Labels</button>
                    <button class="btn btn-outline-dark w-100 rounded-pill py-3 fw-bold">Global Inventory Sync</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateRelay(ref, status) {
        Swal.fire({
            title: 'Update Hub Status: ' + status,
            text: 'Relaying shipment ' + ref + ' to ' + status + ' section.',
            icon: 'info',
            showCancelButton: true
        }).then(result => {
            if(result.isConfirmed) {
                fetch('{{ route('cargo.support.status') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ booking_ref: ref, status: status })
                })
                .then(res => res.json())
                .then(() => location.reload());
            }
        });
    }

    function scanParcel() {
        const ref = document.getElementById('scan_ref').value;
        if(ref) Swal.fire('Parcel Located', 'Located in Section B, Row 4. Type: Box.', 'success');
    }
</script>

<style>
    .bg-soft-primary { background: rgba(78, 115, 223, 0.1); }
    .bg-soft-warning { background: rgba(246, 194, 62, 0.1); }
    .bg-soft-info { background: rgba(54, 185, 204, 0.1); }
    .btn-navy { background: #011233; color: white; transition: all 0.3s; }
    .btn-navy:hover { background: #000a1c; color: white; transform: translateY(-2px); }
    .x-small { font-size: 10px; }
</style>
@endsection

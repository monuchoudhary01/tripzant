@extends('layouts.admin')

@section('title', 'Global Cargo Management')

@section('admin_content')
    <div class="container-fluid">
        <!-- Dashboard Header & Stats (Module 5) -->
        <div class="row mb-5 g-4 animate__animated animate__fadeIn">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-soft-primary text-primary rounded-3 p-3 me-3">
                            <i class="fas fa-money-bill-wave fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted text-uppercase small font-weight-bold">Total Revenue</h6>
                            <h3 class="mb-0 fw-bold">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-soft-success text-success rounded-3 p-3 me-3">
                            <i class="fas fa-hand-holding-usd fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted text-uppercase small font-weight-bold">TripZant Commission</h6>
                            <h3 class="mb-0 fw-bold">${{ number_format($totalCommission, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-soft-warning text-warning rounded-3 p-3 me-3">
                            <i class="fas fa-warehouse fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted text-uppercase small font-weight-bold">Pending Logistics</h6>
                            <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'Pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-soft-danger text-danger rounded-3 p-3 me-3">
                            <i class="fas fa-shield-alt fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted text-uppercase small font-weight-bold">Customs Issues</h6>
                            <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'Customs')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Shipments & Activity Log (Module 5) -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Global Cargo Shipments</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.cargo.providers') }}" class="btn btn-navy btn-sm rounded-pill px-3">Manage Providers</a>
                        <a href="{{ route('admin.cargo.promo-codes') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Promo Campaigns</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted x-small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4">Booking Ref</th>
                                <th>Customer / Role</th>
                                <th>Cargo Provider</th>
                                <th>Shipment Route</th>
                                <th>Pricing & Revenue</th>
                                <th>Dispatch Status</th>
                                <th class="text-end pe-4">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-primary">{{ $booking->booking_ref }}</span><br>
                                    <span class="badge bg-soft-secondary text-muted x-small">{{ $booking->parcel_type }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold d-block">{{ $booking->sender_details['name'] ?? 'John Doe' }}</span>
                                    <span class="text-muted x-small text-uppercase">{{ $booking->user->role ?? 'User' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $booking->provider->logo_url ?? 'https://cdn-icons-png.flaticon.com/512/726/726466.png' }}" class="rounded me-2" height="20">
                                        <span>{{ $booking->provider->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="x-small fw-bold">{{ $booking->origin_city }} <i class="fas fa-long-arrow-alt-right mx-1 text-muted"></i> {{ $booking->destination_city }}</div>
                                    <div class="text-muted x-small">{{ $booking->weight }} KG | Status: {{ $booking->status }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold d-block text-navy">${{ number_format($booking->total_price, 2) }}</span>
                                    <span class="text-success x-small fw-bold">Earned: ${{ number_format($booking->total_price * ($booking->provider->commission_percentage / 100), 2) }}</span>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm rounded-pill bg-light border-0 status-select" data-id="{{ $booking->id }}" onchange="updateStatus({{ $booking->id }}, this.value, '{{ $booking->origin_city }}')">
                                        @foreach(['Pickup scheduled', 'Picked up', 'Warehouse received', 'Customs clearance', 'In Transit', 'Out for delivery', 'Delivered', 'Cancelled'] as $st)
                                            <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>{{ strtoupper($st) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-none me-1" title="View Documents"><i class="fas fa-file-invoice text-info"></i></button>
                                        <button class="btn btn-sm btn-light rounded-circle shadow-none" title="Manual Override"><i class="fas fa-edit text-primary"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Live Activity Feed</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                        @forelse($logs as $log)
                        <div class="list-group-item border-0 py-3 ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-indicator {{ $log->status == 'Delivered' ? 'bg-success' : 'bg-primary' }} rounded-circle" style="width: 10px; height: 10px;"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="fw-bold text-navy">{{ $log->booking->booking_ref }}</small>
                                        <small class="text-muted x-small">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 x-small text-muted">{{ $log->description }}</p>
                                    <span class="badge bg-soft-primary text-primary x-small rounded-pill mt-1">{{ $log->status }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                                <h5 class="text-muted fw-bold">No cargo bookings found.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top bg-white">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(id, status, city) {
        Swal.fire({
            title: 'Update Status to ' + status + '?',
            text: 'This will automatically log a tracking event for the user.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Confirm Update',
            inputType: 'text',
            inputPlaceholder: 'Add a detail (Optional log description)',
            inputAttributes: {
                autocapitalize: 'off'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const description = result.value || 'Shipment status updated to ' + status + '.';
                fetch("{{ route('admin.cargo.update.status') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        booking_id: id, 
                        status: status, 
                        location: city,
                        description: description
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }
                });
            }
        });
    }
</script>

<style>
    .bg-navy { background: #0f172a; }
    .btn-navy { background: #0f172a; color: white; transition: all 0.3s; }
    .btn-navy:hover { background: #1e293b; color: white; transform: translateY(-2px); }
    .text-navy { color: #0f172a; }
    .bg-soft-primary { background: rgba(78, 115, 223, 0.1); }
    .bg-soft-success { background: rgba(28, 200, 138, 0.1); }
    .bg-soft-warning { background: rgba(246, 194, 62, 0.1); }
    .bg-soft-danger { background: rgba(231, 74, 59, 0.1); }
    .bg-soft-secondary { background: rgba(133, 135, 150, 0.1); }
    .x-small { font-size: 11px; }
</style>
@endsection

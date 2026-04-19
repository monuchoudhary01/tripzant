@extends('layouts.admin')

@section('title', 'Global Booking Operations | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-12">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <h4 class="fw-900 text-navy mb-0">Master Bookings Controller</h4>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-bold bg-white shadow-sm"><i class="fas fa-file-excel me-2"></i> Monthly Report</button>
                    <button class="btn btn-admin-primary rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-search-dollar me-2"></i> Audit Transactions</button>
                </div>
            </div>

            <!-- Header Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-purple-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-purple mb-1 leading-relaxed">{{ number_format($totalBookings / 1000, 1) }}K</h2>
                         <p class="text-muted smaller mb-0 fw-bold">TOTAL BOOKINGS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-purple-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-purple mb-1 leading-relaxed">₹{{ number_format($totalGmv / 1000000, 1) }}M</h2>
                         <p class="text-muted smaller mb-0 fw-bold">TOTAL GMV</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-purple-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-purple mb-1 leading-relaxed">{{ number_format($cancelRate, 1) }}%</h2>
                         <p class="text-muted smaller mb-0 fw-bold">CANCEL RATE</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-purple-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-purple mb-1 leading-relaxed">₹{{ number_format($totalCommission / 1000000, 1) }}M</h2>
                         <p class="text-muted smaller mb-0 fw-bold">NET COMMISSION</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless align-middle custom-admin-table">
                     <thead class="text-muted small fw-800 text-uppercase">
                         <tr>
                             <th class="ps-0 border-bottom pb-4">Booking ID / Ref</th>
                             <th class="border-bottom pb-4">Service Category</th>
                             <th class="border-bottom pb-4">Net Price</th>
                             <th class="border-bottom pb-4">Markup</th>
                             <th class="border-bottom pb-4">Grand Total</th>
                             <th class="border-bottom pb-4">Status</th>
                             <th class="border-bottom pb-4 text-end pe-0">Action Hub</th>
                         </tr>
                     </thead>
                     <tbody class="text-navy">
                         @foreach($bookings as $b)
                         <tr class="border-bottom">
                             <td class="ps-0 py-4">
                                 <div>
                                     <h6 class="fw-900 mb-0">#{{ $b->api_reference ?: ($b->id + 1000) }}</h6>
                                     <p class="text-muted small mb-0">User: {{ $b->user->name ?? 'Guest' }}</p>
                                 </div>
                             </td>
                             <td>
                                <span class="badge bg-light text-navy rounded-pill px-3 py-1 fw-bold text-uppercase">
                                    <i class="fas fa-{{ $b->booking_type == 'flight' ? 'plane' : ($b->booking_type == 'hotel' ? 'hotel' : 'tag') }} me-2"></i> 
                                    {{ $b->booking_type }}
                                </span>
                             </td>
                             <td class="fw-bold text-muted small">₹{{ number_format($b->net_price, 2) }}</td>
                             <td class="fw-bold text-success" style="font-size:13px;">₹{{ number_format($b->markup, 2) }}</td>
                             <td class="fw-900 fs-6">₹{{ number_format($b->selling_price, 2) }}</td>
                             <td><span class="badge {{ $b->status == 'confirmed' ? 'badge-admin-success' : 'badge-admin-warning' }} px-4 py-2 border-0 fw-bold text-uppercase">{{ $b->status }}</span></td>
                             <td class="text-end pe-0">
                                 <div class="dropdown">
                                     <button class="btn btn-sm btn-light border-0 px-3 py-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown">
                                         <i class="fas fa-ellipsis-h text-navy"></i>
                                     </button>
                                     <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-receipt me-2 opacity-50"></i> Show Voucher</a></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-search me-2 opacity-50"></i> Track API Log</a></li>
                                         <li><hr class="dropdown-divider"></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-danger small" href="#"><i class="fas fa-undo me-2 opacity-50"></i> Process Refund</a></li>
                                     </ul>
                                 </div>
                             </td>
                         </tr>
                         @endforeach
                     </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                 <button class="btn btn-navy rounded-pill px-5 fw-bold shadow-lg">View Full Ledger <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-purple-subtle { background: rgba(139, 92, 246, 0.1); }
    .text-purple { color: #8b5cf6; }
</style>
@endsection

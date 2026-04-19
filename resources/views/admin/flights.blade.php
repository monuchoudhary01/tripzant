@extends('layouts.admin')

@section('title', 'Global Flight Inventory | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-12">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <h4 class="fw-900 text-navy mb-0">Master Flights Controller</h4>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-bold bg-white shadow-sm"><i class="fas fa-plus me-2"></i> Add Global Route</button>
                    <button class="btn btn-admin-primary rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-sync me-2"></i> Sync API Inventory</button>
                </div>
            </div>

            <!-- Header Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-light rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-navy mb-1 leading-relaxed">8,420</h2>
                         <p class="text-muted smaller mb-0 fw-bold">ACTIVE FLIGHTS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-light rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-navy mb-1 leading-relaxed">42</h2>
                         <p class="text-muted smaller mb-0 fw-bold">CARRIER PARTNERS</p>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="p-4 bg-light rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-navy mb-1 leading-relaxed">1,248</h2>
                         <p class="text-muted smaller mb-0 fw-bold">DAILY BOOKINGS</p>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="p-4 bg-light rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-navy mb-1 leading-relaxed">12,420</h2>
                         <p class="text-muted smaller mb-0 fw-bold">PENDING SEATS</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless align-middle custom-admin-table">
                     <thead class="text-muted small fw-800 text-uppercase">
                         <tr>
                             <th class="ps-0 border-bottom pb-4">Carrier / Flight ID</th>
                             <th class="border-bottom pb-4">Source / Destination</th>
                             <th class="border-bottom pb-4">Schedule Date</th>
                             <th class="border-bottom pb-4">Price</th>
                             <th class="border-bottom pb-4">Status</th>
                             <th class="border-bottom pb-4 text-end pe-0">Action Hub</th>
                         </tr>
                     </thead>
                     <tbody class="text-navy">
                         @for($i=1; $i<=8; $i++)
                         <tr class="border-bottom">
                             <td class="ps-0 py-4">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="avatar-sm bg-blue-subtle text-blue rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:45px;height:45px;"><i class="fas fa-plane"></i></div>
                                     <div>
                                         <h6 class="fw-800 mb-0">IndiGo · 6E-2{{$i}}42</h6>
                                         <p class="text-muted smaller mb-0">Partner ID: #P-91827</p>
                                     </div>
                                 </div>
                             </td>
                             <td><span class="fw-900 small text-navy">DEL → BOM</span></td>
                             <td class="text-muted fw-bold small">12 Jan 2026, 11:20 AM</td>
                             <td class="fw-900 fs-6">₹4,250</td>
                             <td><span class="badge {{ $i%3==0 ? 'badge-admin-warning' : 'badge-admin-success' }} px-4 py-2 border-0 fw-bold">{{ $i%3==0 ? 'PENDING' : 'LIVE' }}</span></td>
                             <td class="text-end pe-0">
                                 <div class="dropdown">
                                     <button class="btn btn-sm btn-light border-0 px-3 py-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown">
                                         <i class="fas fa-ellipsis-h text-navy"></i>
                                     </button>
                                     <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-edit me-2 opacity-50"></i> Modify Route</a></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-ticket-alt me-2 opacity-50"></i> View Seats</a></li>
                                         <li><hr class="dropdown-divider"></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-danger small" href="#"><i class="fas fa-power-off me-2 opacity-50"></i> Halt Listing</a></li>
                                     </ul>
                                 </div>
                             </td>
                         </tr>
                         @endfor
                     </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                 <button class="btn btn-outline-navy rounded-pill px-5 fw-bold bg-white shadow-sm">Load More Routes <i class="fas fa-arrow-down ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-blue-subtle { background: rgba(59, 130, 246, 0.1); }
    .text-blue { color: #3b82f6; }
</style>
@endsection

@extends('layouts.admin')

@section('title', 'Global Hotel Inventory | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-12">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <h4 class="fw-900 text-navy mb-0">Master Hotels Controller</h4>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-bold bg-white shadow-sm"><i class="fas fa-plus me-2"></i> Register New Property</button>
                    <button class="btn btn-admin-primary rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-sync me-2"></i> Sync OTA Inventory</button>
                </div>
            </div>

            <!-- Header Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="p-4 bg-orange-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-orange mb-1 leading-relaxed">24,150</h2>
                         <p class="text-muted smaller mb-0 fw-bold">ACTIVE HOTELS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-orange-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-orange mb-1 leading-relaxed">84</h2>
                         <p class="text-muted smaller mb-0 fw-bold">HOTEL PARTNERS</p>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="p-4 bg-orange-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-orange mb-1 leading-relaxed">4.82/5</h2>
                         <p class="text-muted smaller mb-0 fw-bold">AVG. RATING</p>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="p-4 bg-orange-subtle rounded-4 text-center hvr-grow shadow-sm">
                         <h2 class="fw-900 text-orange mb-1 leading-relaxed">₹14M+</h2>
                         <p class="text-muted smaller mb-0 fw-bold">PENDING PAYOUTS</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless align-middle custom-admin-table">
                     <thead class="text-muted small fw-800 text-uppercase">
                         <tr>
                             <th class="ps-0 border-bottom pb-4">Property / Location</th>
                             <th class="border-bottom pb-4">Rating</th>
                             <th class="border-bottom pb-4">Avg. Price / Night</th>
                             <th class="border-bottom pb-4">Status</th>
                             <th class="border-bottom pb-4">Partner Control</th>
                             <th class="border-bottom pb-4 text-end pe-0">Action Hub</th>
                         </tr>
                     </thead>
                     <tbody class="text-navy">
                         @for($i=1; $i<=8; $i++)
                         <tr class="border-bottom">
                             <td class="ps-0 py-4">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="avatar-sm bg-orange-subtle text-orange rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:45px;height:45px;"><i class="fas fa-hotel"></i></div>
                                     <div>
                                         <h6 class="fw-800 mb-0">Taj Exotica Spa {{$i}}</h6>
                                         <p class="text-muted smaller mb-0">Benaulim, Goa</p>
                                     </div>
                                 </div>
                             </td>
                             <td><span class="badge bg-navy text-white rounded-pill px-3 py-1 fw-bold fs-6 shadow-sm"><i class="fas fa-star me-2 text-warning"></i> 4.9</span></td>
                             <td class="fw-900 fs-6">₹24,500</td>
                             <td><span class="badge {{ $i%3==0 ? 'badge-admin-warning' : 'badge-admin-success' }} px-4 py-2 border-0 fw-bold">{{ $i%3==0 ? 'MAINTENANCE' : 'LIVE' }}</span></td>
                             <td><span class="text-muted fw-bold small">Enterprise Partner {{$i}}</span></td>
                             <td class="text-end pe-0">
                                 <div class="dropdown">
                                     <button class="btn btn-sm btn-light border-0 px-3 py-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown">
                                         <i class="fas fa-ellipsis-h text-navy"></i>
                                     </button>
                                     <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-eye me-2 opacity-50"></i> View Listing</a></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-bed me-2 opacity-50"></i> Manage Rooms</a></li>
                                         <li><hr class="dropdown-divider"></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-danger small" href="#"><i class="fas fa-ban me-2 opacity-50"></i> Suspend Property</a></li>
                                     </ul>
                                 </div>
                             </td>
                         </tr>
                         @endfor
                     </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                 <button class="btn btn-outline-navy rounded-pill px-5 fw-bold bg-white shadow-sm">Explore More Properties <i class="fas fa-arrow-down ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-orange-subtle { background: rgba(249, 115, 22, 0.1); }
    .text-orange { color: #f97316; }
</style>
@endsection

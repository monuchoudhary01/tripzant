@extends('layouts.admin')

@section('title', 'All Partners Management | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-12">
        <div class="card-admin shadow-sm border-0 mb-4 p-5">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <h4 class="fw-900 text-navy mb-0">Master Partner Management</h4>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-bold bg-white shadow-sm"><i class="fas fa-download me-2"></i> Export Data</button>
                    <button class="btn btn-admin-primary rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-plus me-2"></i> Invit New Partner</button>
                </div>
            </div>

            <!-- Table Filters -->
            <div class="d-flex flex-wrap gap-3 mb-5 p-4 bg-light rounded-4">
                 <div class="flex-grow-1">
                    <input type="text" class="form-control border-0 bg-white rounded-pill px-4" placeholder="Search partners by business name or email...">
                 </div>
                 <select class="form-select border-0 bg-white rounded-pill px-4 fw-bold text-navy" style="width: 180px;">
                     <option>Active Status</option>
                     <option>Pending Verification</option>
                     <option>Suspended</option>
                 </select>
                 <select class="form-select border-0 bg-white rounded-pill px-4 fw-bold text-navy" style="width: 180px;">
                     <option>All Services</option>
                     <option>Hotels Only</option>
                     <option>Flights Only</option>
                 </select>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless align-middle custom-admin-table">
                     <thead class="text-muted small fw-800 text-uppercase">
                         <tr>
                             <th class="ps-0 border-bottom pb-4">Partner Identity</th>
                             <th class="border-bottom pb-4">Corporate Role</th>
                             <th class="border-bottom pb-4">Joined Date</th>
                             <th class="border-bottom pb-4">Status</th>
                             <th class="border-bottom pb-4">Revenue Gen</th>
                             <th class="border-bottom pb-4 text-end pe-0">Action Hub</th>
                         </tr>
                     </thead>
                     <tbody class="text-navy">
                         @for($i=1; $i<=8; $i++)
                         <tr class="border-bottom">
                             <td class="ps-0 py-4">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="avatar-sm bg-navy text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:45px;height:45px;">P{{$i}}</div>
                                     <div>
                                         <h6 class="fw-800 mb-0">Elite Travel Group {{$i}}</h6>
                                         <p class="text-muted smaller mb-0">partner{{$i}}@corporate.com</p>
                                     </div>
                                 </div>
                             </td>
                             <td><span class="badge bg-primary-subtle text-primary border-0 rounded-pill px-3 py-2 fw-bold small">PREMIUM PARTNER</span></td>
                             <td class="text-muted fw-bold small">12 Jan 2026</td>
                             <td><span class="badge {{ $i%3==0 ? 'badge-admin-warning' : 'badge-admin-success' }} px-4 py-2 border-0 fw-bold">{{ $i%3==0 ? 'PENDING' : 'VERIFIED' }}</span></td>
                             <td class="fw-900 fs-6">₹{{number_format(rand(100000, 900000))}}</td>
                             <td class="text-end pe-0">
                                 <div class="dropdown">
                                     <button class="btn btn-sm btn-light border-0 px-3 py-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown">
                                         <i class="fas fa-ellipsis-h text-navy"></i>
                                     </button>
                                     <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-eye me-2 opacity-50"></i> View Portfolio</a></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-edit me-2 opacity-50"></i> Edit Permissions</a></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-navy small" href="#"><i class="fas fa-wallet me-2 opacity-50"></i> Wallet History</a></li>
                                         <li><hr class="dropdown-divider"></li>
                                         <li><a class="dropdown-item py-2 fw-bold text-danger small" href="#"><i class="fas fa-ban me-2 opacity-50"></i> Suspend Account</a></li>
                                     </ul>
                                 </div>
                             </td>
                         </tr>
                         @endfor
                     </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5">
                 <p class="text-muted small mb-0 fw-bold">Showing 8 of 1,248 active partners</p>
                 <nav>
                     <ul class="pagination mb-0 gap-2">
                         <li class="page-item"><a class="page-link border-0 text-navy rounded-pill fw-bold px-3 active" href="#">1</a></li>
                         <li class="page-item"><a class="page-link border-0 text-navy rounded-pill fw-bold px-3" href="#">2</a></li>
                         <li class="page-item"><a class="page-link border-0 text-navy rounded-pill fw-bold px-3" href="#">3</a></li>
                         <li class="page-item"><a class="page-link border-0 text-navy rounded-pill fw-bold px-4" href="#">Next</a></li>
                     </ul>
                 </nav>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background: rgba(11, 61, 97, 0.1); }
    .page-link.active { background: var(--admin-primary) !important; color: #fff !important; }
    .custom-admin-table td { font-size: 14px; }
</style>
@endsection

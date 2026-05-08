@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">User / View /</span> Details
    </h4>

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4 card-sneat">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <div class="avatar avatar-xl mb-3" style="width: 120px; height: 120px;">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span class="avatar-initial rounded bg-label-primary" style="font-size: 3rem;">{{ substr($user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $user->name }}</h4>
                                <span class="badge bg-label-secondary">{{ strtoupper($user->role) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                        <div class="d-flex align-items-start me-4 mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-check bx-sm"></i></span>
                            <div>
                                <h5 class="mb-0">1.23k</h5>
                                <span class="small">Tasks Done</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-customize bx-sm"></i></span>
                            <div>
                                <h5 class="mb-0">568</h5>
                                <span class="small">Projects Done</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">Username:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Status:</span>
                                <span class="badge {{ $user->status === 'active' ? 'bg-label-success' : 'bg-label-warning' }}">{{ ucfirst($user->status) }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Role:</span>
                                <span>{{ ucfirst($user->role) }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Contact:</span>
                                <span>{{ $user->phone ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Country:</span>
                                <span>{{ $user->country ?? 'India' }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center pt-3">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary me-3">Edit Details</a>
                            <button class="btn btn-label-danger suspend-user">Delete User</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Tabs -->
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="bx bx-lock-alt me-1"></i>Security</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="bx bx-detail me-1"></i>Billing & Plans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="bx bx-bell me-1"></i>Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="bx bx-link-alt me-1"></i>Connections</a>
                </li>
            </ul>
            <!--/ User Tabs -->

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card card-sneat h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="card-info">
                                    <p class="card-text">Account Balance</p>
                                    <div class="d-flex align-items-end mb-2">
                                        <h4 class="card-title mb-0 me-2">₹{{ number_format($user->wallet_balance ?? 0, 2) }}</h4>
                                        <small class="text-success">(+2.5%)</small>
                                    </div>
                                    <small>Current wallet credit</small>
                                </div>
                                <div class="card-icon">
                                    <span class="badge bg-label-primary p-2">
                                        <i class='bx bx-wallet bx-sm'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card card-sneat h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="card-info">
                                    <p class="card-text">Total Bookings</p>
                                    <div class="d-flex align-items-end mb-2">
                                        <h4 class="card-title mb-0 me-2">24</h4>
                                        <small class="text-danger">(-1.2%)</small>
                                    </div>
                                    <small>Lifetime bookings made</small>
                                </div>
                                <div class="card-icon">
                                    <span class="badge bg-label-success p-2">
                                        <i class='bx bx-shopping-bag bx-sm'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="card card-sneat mb-4">
                <h5 class="card-header">User Activity Timeline</h5>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-primary"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Logged In</h6>
                                    <small class="text-muted">12 min ago</small>
                                </div>
                                <p class="mb-2">User logged in from Mumbai, India via Chrome browser.</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-success"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Flight Booked</h6>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <p class="mb-2">Booked flight from DEL to BOM (PNR: TZ89231)</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Activity Timeline -->

            <!-- Invoice table -->
            <div class="card card-sneat">
                <div class="table-responsive">
                    <table class="table border-top">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#BK-9231</td>
                                <td>12 May 2026</td>
                                <td>₹12,450.00</td>
                                <td><span class="badge bg-label-success">Completed</span></td>
                                <td><i class="bx bx-dots-vertical-rounded"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Invoice table -->
        </div>
        <!--/ User Content -->
    </div>
</div>

<style>
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }
    .bg-label-warning { background-color: #fff2d6 !important; color: #ffab00 !important; }
    .bg-label-secondary { background-color: #ebeef0 !important; color: #8592a3 !important; }
    
    .timeline { position: relative; list-style: none; padding: 0; margin: 0; }
    .timeline-item { position: relative; padding-left: 3rem; margin-bottom: 1.5rem; }
    .timeline-point-wrapper { position: absolute; left: 1rem; top: 0; bottom: -1.5rem; }
    .timeline-point { position: absolute; left: 0; top: 0.5rem; width: 0.75rem; height: 0.75rem; border-radius: 50%; }
    .timeline-point-primary { background-color: #696cff; }
    .timeline-point-success { background-color: #71dd37; }
    .timeline-item-transparent::before { content: ""; position: absolute; left: 1.35rem; top: 1.5rem; bottom: -0.5rem; width: 1px; background-color: #dbdade; }
    .timeline-item:last-child::before { display: none; }
</style>
@endsection

@extends('layouts.dashboard')

@section('title', 'My Dashboard | Trip\'Stay')

@section('dashboard_content')
<div class="user-dashboard-index">
    <!-- Welcome Section -->
    <div class="row mb-5 align-items-center">
        <div class="col-lg-8">
            <h1 class="fw-900 text-navy display-6 mb-2">Welcome back, <span class="text-orange">{{ trim(Auth::user()->name) ? Auth::user()->name : 'User' }}!</span></h1>
            <p class="text-muted small fw-bold mb-0">It's a perfect day to plan your next adventure.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
             <div class="d-flex align-items-center justify-content-lg-end gap-3 mt-3 mt-lg-0">
                 <div class="text-end">
                     <h6 class="fw-800 text-navy mb-0">{{ trim(Auth::user()->name) ? Auth::user()->name : 'User' }}</h6>
                     <span class="badge bg-primary rounded-pill small">Member</span>
                 </div>
                 <div class="avatar bg-navy text-white rounded-4 fs-4 d-flex align-items-center justify-content-center fw-bold" style="width: 55px; height: 55px;">
                     {{ trim(Auth::user()->name) ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'U' }}
                 </div>
             </div>
        </div>
    </div>

    <!-- Stats Summary Cards -->
    <div class="row g-4 mb-5">
        <!-- Total Bookings -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card shadow-sm border-0 hvr-float h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-badge" style="background: rgba(11, 61, 97, 0.1); color: #0b3d61; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-suitcase"></i></div>
                    <span class="text-muted x-small fw-bold">BOOKINGS</span>
                </div>
                <h2 class="fw-900 text-navy mb-1">{{ $stats['bookings'] }}</h2>
                <p class="text-muted x-small fw-bold mb-0">Total travel records</p>
                <div class="mt-3">
                    <a href="{{ route('dashboard.bookings') }}" class="text-primary x-small fw-bold text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Wallet Balance -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card shadow-sm border-0 hvr-float h-100 border-top border-4 border-orange" style="border-top-color: #f97316 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-badge" style="background: rgba(249, 115, 22, 0.1); color: #f97316; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-wallet"></i></div>
                    <span class="text-muted x-small fw-bold">WALLET</span>
                </div>
                <h2 class="fw-900 text-navy mb-1">₹{{ number_format($stats['wallet'], 2) }}</h2>
                <p class="text-muted x-small fw-bold mb-0">Available credits</p>
                <div class="mt-3">
                    <a href="{{ route('dashboard.wallet') }}" class="text-orange x-small fw-bold text-decoration-none" style="color:#f97316 !important;">Manage Wallet <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Wishlist -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card shadow-sm border-0 hvr-float h-100 border-top border-4 border-danger" style="border-top-color: #ef4444 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-heart"></i></div>
                    <span class="text-muted x-small fw-bold">WISHLIST</span>
                </div>
                <h2 class="fw-900 text-navy mb-1">{{ $stats['wishlist'] }}</h2>
                <p class="text-muted x-small fw-bold mb-0">Saved for later</p>
                <div class="mt-3">
                    <a href="{{ route('dashboard.wishlist') }}" class="text-danger x-small fw-bold text-decoration-none">View Favourites <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Saved Searches -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card shadow-sm border-0 hvr-float h-100 border-top border-4 border-info" style="border-top-color: #0ea5e9 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-badge" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-search"></i></div>
                    <span class="text-muted x-small fw-bold">SEARCHES</span>
                </div>
                <h2 class="fw-900 text-navy mb-1">{{ $stats['searches'] }}</h2>
                <p class="text-muted x-small fw-bold mb-0">Quick relaunch ready</p>
                <div class="mt-3">
                    <a href="{{ route('dashboard.searches') }}" class="text-info x-small fw-bold text-decoration-none">Open Searches <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Upcoming Trips -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-900 text-navy mb-0">Upcoming Bookings</h5>
                    <a href="/dashboard/bookings" class="text-navy small fw-bold text-decoration-none">View All <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
                
                <div class="table-responsive">
                    @if(isset($recentBookings) && count($recentBookings) > 0)
                        <table class="table table-borderless align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="small text-muted fw-bold">Booking ID</th>
                                    <th class="small text-muted fw-bold">Service</th>
                                    <th class="small text-muted fw-bold">Date</th>
                                    <th class="small text-muted fw-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <div class="fw-900 text-navy mb-0">#{{ $booking->flightBooking->pnr ?? $booking->booking_reference ?? 'BKG-'.$booking->id }}</div>
                                        <span class="x-small text-muted fw-bold">REF: {{ $booking->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if(($booking->type ?? $booking->booking_type) == 'Flight')
                                                <i class="fas fa-plane text-primary"></i>
                                            @else
                                                <i class="fas fa-hotel text-warning"></i>
                                            @endif
                                            <span class="fw-bold text-navy">{{ ucfirst($booking->type ?? $booking->booking_type ?? 'Flight') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-navy">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</div>
                                        <span class="x-small text-muted fw-bold">{{ \Carbon\Carbon::parse($booking->created_at)->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'warning';
                                            $bg = '#fff7ed'; $color = '#f97316';
                                            if($booking->status == 'confirmed' || $booking->status == 'successful') { $bg = '#f0fdf4'; $color = '#22c55e'; }
                                            if($booking->status == 'cancelled' || $booking->status == 'failed') { $bg = '#fef2f2'; $color = '#ef4444'; }
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 fw-900" style="background: {{ $bg }}; color: {{ $color }};">{{ strtoupper($booking->status) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4 text-muted opacity-25">
                                <i class="fas fa-calendar-times display-2"></i>
                            </div>
                            @if(Auth::user()->role === 'personal_account' || Auth::user()->role === 'personal')
                                <p class="text-navy small fw-900 mb-3">You haven't made any bookings yet.</p>
                                <a href="{{ route('cargo.dashboard.book') }}" class="btn btn-outline-navy btn-sm rounded-pill px-4 fw-bold">Send New Parcel</a>
                            @else
                                <p class="text-navy small fw-900 mb-3">You haven't made any bookings yet.</p>
                                <a href="/flights" class="btn btn-outline-navy btn-sm rounded-pill px-4 fw-bold">Find Flights</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-card text-center bg-navy" style="background: var(--user-primary) !important; color: #fff;">
                <h5 class="fw-900 mb-3 text-white">Unlock Premium Deals</h5>
                <p class="text-white-50 x-small fw-bold mb-4">Complete your explorer profile to get access to member-only flight discounts and luxury hotel upgrades.</p>
                <div class="profile-progress mx-auto mb-4" style="width: 100px; height: 100px; border: 8px solid rgba(255,255,255,0.1); border-top-color: #f97316; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <span class="fw-900 fs-4">65%</span>
                </div>
                <button class="btn btn-orange w-100 rounded-pill fw-bold" style="background: #f97316; color: #fff; border: none; padding: 12px;">Complete Profile</button>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 11px; }
    .bg-primary-light { background: rgba(11, 61, 97, 0.1); }
</style>
@endsection

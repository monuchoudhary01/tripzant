@extends('layouts.app')

@section('title', "Recent Bookings — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <!-- Reusable Partner Sidebar -->
    <x-partner-sidebar active="bookings" />

    <!-- Main Content Area -->
    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Recent Bookings Console</h2>
                    <p class="text-muted small mb-0">Detailed history of all transactions and customer bookings.</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-download me-2"></i> Export CSV</button>
                    <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-filter me-2"></i> Filter</button>
                </div>
            </div>

            <!-- Detailed Bookings Table -->
            <div class="bg-white p-5 rounded-4 shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle custom-dashboard-table">
                        <thead class="text-muted small fw-bold text-uppercase">
                            <tr>
                                <th class="ps-0 border-bottom">ID</th>
                                <th class="border-bottom">Customer / Guest</th>
                                <th class="border-bottom">Service</th>
                                <th class="border-bottom">Booking Date</th>
                                <th class="border-bottom">Status</th>
                                <th class="border-bottom">Revenue Share</th>
                                <th class="border-bottom text-end pe-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1; $i<=8; $i++)
                            <tr class="border-bottom">
                                <td class="ps-0 fw-bold text-navy">#BK-948{{$i}}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=User+{{$i}}&background=random" class="rounded-pill" width="32" alt="">
                                        <div>
                                            <span class="fw-bold d-block">Traveler {{$i}}</span>
                                            <span class="text-muted" style="font-size:11px;">traveler{{$i}}@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-navy rounded-pill px-3 py-1 fw-bold"><i class="fas fa-plane me-1"></i> Flight</span></td>
                                <td class="text-muted small">02 Apr 2026, 11:20 AM</td>
                                <td><span class="badge bg-green-light text-green rounded-pill px-3 py-1 fw-bold">SUCCESS</span></td>
                                <td class="fw-bold text-navy">₹{{number_format(rand(5000, 25000))}}</td>
                                <td class="text-end pe-0">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 px-2" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                            <li><a class="dropdown-item py-2 fw-bold small" href="#"><i class="fas fa-eye me-2 text-navy"></i> View Details</a></li>
                                            <li><a class="dropdown-item py-2 fw-bold small" href="#"><i class="fas fa-file-invoice me-2 text-navy"></i> Get Invoice</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item py-2 fw-bold small text-red" href="#"><i class="fas fa-ban me-2"></i> Cancel Booking</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    /* Styling consistency */
    .partner-nav-link { display: flex; align-items: center; gap: 16px; padding: 14px 20px; border-radius: 16px; color: #64748b; text-decoration: none; font-weight: 700; transition: all 0.2s ease; }
    .partner-nav-link:hover, .partner-nav-link.active { background: rgba(11, 61, 97, 0.05); color: #0b3d61; }
    .partner-nav-link i { font-size: 18px; width: 24px; text-align: center; }
    .bg-green-light { background: rgba(34, 197, 94, 0.1); }
    .text-green { color: #22c55e; }
    .custom-dashboard-table td { padding: 20px 0; }
</style>
@endsection

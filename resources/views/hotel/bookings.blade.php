@extends('layouts.app')

@section('title', "Hotel Reservations — Partner Portal")

@section('content')
<div class="hotel-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-hotel-sidebar active="bookings" />

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">My Reservations</h2>
                <p class="text-muted small fw-bold mb-0">Track and manage all stay-bookings confirmed by agents.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-navy rounded-pill px-4 fw-900 shadow-sm bg-white x-small">FILTER BY DATE</button>
                <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small">EXPORT REVENUE</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
            <h5 class="fw-900 text-navy mb-5"><i class="fas fa-calendar-check me-3 text-warning"></i> Recent Bookings</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="x-small text-muted fw-bold uppercase border-bottom">
                        <tr>
                            <th class="py-3">BOOKING ID</th>
                            <th class="py-3">GUEST NAME</th>
                            <th class="py-3">ROOM TYPE</th>
                            <th class="py-3">STAY DATES</th>
                            <th class="py-3">AMOUNT</th>
                            <th class="py-3 text-end">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="small fw-bold">
                        <tr class="py-4">
                            <td><span class="text-primary">#BK-991204</span></td>
                            <td>Rohan Sharma</td>
                            <td>Deluxe Pool View</td>
                            <td>12 Nov – 15 Nov (3N)</td>
                            <td class="text-navy fw-900">₹42,000</td>
                            <td class="text-end"><span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold">CONFIRMED</span></td>
                        </tr>
                        <tr class="py-4">
                            <td><span class="text-primary">#BK-88201A</span></td>
                            <td>Sneha Patil</td>
                            <td>Executive Suite</td>
                            <td>20 Nov – 22 Nov (2N)</td>
                            <td class="text-navy fw-900">₹72,500</td>
                            <td class="text-end"><span class="badge bg-green-subtle text-green rounded-pill px-3 py-1 x-small fw-bold">CHECKED-IN</span></td>
                        </tr>
                        <tr class="py-4">
                            <td><span class="text-primary">#BK-1102P</span></td>
                            <td>Amitabh Roy</td>
                            <td>Luxury Villa</td>
                            <td>05 Dec – 10 Dec (5N)</td>
                            <td class="text-navy fw-900">₹1,12,000</td>
                            <td class="text-end"><span class="badge bg-orange-subtle text-orange rounded-pill px-3 py-1 x-small fw-bold">UPCOMING</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-green-subtle { background: #f0fff4; color: #10b981; }
    .bg-orange-subtle { background: #fffaf0; color: #f59e0b; }
    .text-green { color: #10b981; }
    .text-orange { color: #f59e0b; }
    .btn-navy { background: #001f3f; color: #fff; }
    .btn-outline-navy { border-color: #001f3f; color: #001f3f; }
    .uppercase { text-transform: uppercase; }
    .x-small { font-size: 11px; }
</style>
@endsection

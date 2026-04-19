@extends('layouts.app')

@section('title', "Experience Bookings — Tour Builder | Trip Zant")

@section('content')
<div class="tour-builder-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-tour-builder-sidebar active="bookings" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
                <div>
                    <h2 class="fw-900 text-navy mb-1">Guest Bookings</h2>
                    <p class="text-muted small mb-0">Track all incoming reservations and participant details for your tours.</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-purple rounded-pill px-4 fw-bold">Download manifest <i class="fas fa-file-download ms-2"></i></button>
                    <button class="btn btn-purple rounded-pill px-4 fw-bold shadow-sm">Sync Calendars <i class="fas fa-sync ms-2"></i></button>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="x-small text-muted fw-bold uppercase border-bottom">
                            <tr>
                                <th class="py-3">BOOKING ID</th>
                                <th class="py-3">EXPERIENCE</th>
                                <th class="py-3">GUEST</th>
                                <th class="py-3">DATE / TIME</th>
                                <th class="py-3">STATUS</th>
                                <th class="py-3 text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            <tr class="py-4 border-bottom border-light">
                                <td><span class="text-navy fw-900">#TB-5541</span></td>
                                <td>
                                    <div class="fw-900 text-navy">Goa Backwater Kayaking</div>
                                    <div class="x-small text-muted">2 Adults, 1 Child</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm bg-purple-subtle text-purple rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:30px;height:30px;font-size:11px;">RK</div>
                                        <span>Rahul Kapoor</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-navy">15 Apr 2026</div>
                                    <div class="x-small text-muted">05:30 PM</div>
                                </td>
                                <td><span class="badge bg-green text-white rounded-pill px-3 py-1 fw-bold">CONFIRMED</span></td>
                                <td class="text-end"><button class="btn btn-sm btn-light rounded-pill px-4 fw-bold x-small">VIEW</button></td>
                            </tr>
                            <tr class="py-4 border-bottom border-light">
                                <td><span class="text-navy fw-900">#TB-5539</span></td>
                                <td>
                                    <div class="fw-900 text-navy">Scuba Diving at Grand Island</div>
                                    <div class="x-small text-muted">1 Adult</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm bg-purple-subtle text-purple rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:30px;height:30px;font-size:11px;">SM</div>
                                        <span>Sara Miller</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-navy">16 Apr 2026</div>
                                    <div class="x-small text-muted">08:00 AM</div>
                                </td>
                                <td><span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold">PENDING</span></td>
                                <td class="text-end"><button class="btn btn-sm btn-light rounded-pill px-4 fw-bold x-small">APPROVE</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .btn-purple { background: #6b46c1; color: #fff; }
    .btn-outline-purple { border: 1px solid #6b46c1; color: #6b46c1; }
    .bg-green { background: #22c55e !important; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

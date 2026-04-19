@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h4 class="fw-800">My Bookings</h4>
            <p class="text-muted small mb-0">Track and manage your scheduled services and booking history.</p>
        </div>
        <div class="nav nav-pills bg-white p-1 rounded-pill shadow-sm" id="booking-tabs" role="tablist">
            <button class="nav-link active rounded-pill px-4 fw-800" id="active-tab" data-bs-toggle="pill" data-bs-target="#active-bookings" type="button" role="tab" style="font-size:13px;">Active</button>
            <button class="nav-link rounded-pill px-4 fw-800" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed-bookings" type="button" role="tab" style="font-size:13px;">Completed</button>
        </div>
    </div>

    <div class="tab-content" id="booking-tabContent">
        <!-- Active Bookings -->
        <div class="tab-pane fade show active" id="active-bookings" role="tabpanel">
            <div class="row g-4">
                @php
                    $active = [
                        ['client' => 'Rajesh Kumar (Oberoi Guest)', 'source' => 'The Oberoi New Delhi', 'service' => 'Airport Pickup', 'date' => 'Today, 2:30 PM', 'status' => 'Ongoing', 'badge' => 'bg-info'],
                        ['client' => 'John Doe (Group of 4)', 'source' => 'MakeMyTrip Tours', 'service' => 'Old Delhi Heritage Walk', 'date' => 'Tomorrow, 09:00 AM', 'status' => 'Confirmed', 'badge' => 'bg-success'],
                        ['client' => 'Sarah Mitchell', 'source' => 'Direct Connection', 'service' => 'Guide Service', 'date' => '12 Apr 2026', 'status' => 'Confirmed', 'badge' => 'bg-success'],
                    ];
                @endphp

                @foreach($active as $a)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <span class="badge {{ $a['badge'] }} rounded-pill smaller fw-800 px-3 py-2 uppercase">{{ $a['status'] }}</span>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle p-0" style="width:32px; height:32px;" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v small text-muted"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    <li><a class="dropdown-item fw-700 small" href="#">Reschedule</a></li>
                                    <li><a class="dropdown-item fw-700 small text-danger" href="#">Cancel Booking</a></li>
                                </ul>
                            </div>
                        </div>

                        <h6 class="fw-800 text-primary mb-1">{{ $a['service'] }}</h6>
                        <h5 class="fw-900 mb-3">{{ $a['client'] }}</h5>
                        
                        <div class="p-3 bg-light rounded-4 mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <i class="far fa-calendar text-muted small"></i>
                                <span class="small fw-700">{{ $a['date'] }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-building text-muted small"></i>
                                <span class="small fw-700">{{ $a['source'] }}</span>
                            </div>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-primary w-100 rounded-pill fw-800 py-2 small">VIEW DETAILS</button>
                            <button class="btn btn-outline-custom p-2 rounded-circle" style="width:40px; height:40px;"><i class="fas fa-phone-alt small text-primary"></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Completed Bookings -->
        <div class="tab-pane fade" id="completed-bookings" role="tabpanel">
             <div class="table-responsive bg-white rounded-4 p-4 shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted small">
                         <tr>
                            <th class="border-0">#ID</th>
                            <th class="border-0">CLIENT</th>
                            <th class="border-0">SERVICE</th>
                            <th class="border-0">COMPLETED ON</th>
                            <th class="border-0">AMOUNT</th>
                            <th class="border-0">STATUS</th>
                            <th class="border-0">REVIEW</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $completed = [
                                ['id' => '#BK-9921', 'client' => 'Amit Shah', 'service' => 'Airport Drop', 'date' => '05 Apr 2026', 'amount' => '₹1,200', 'rating' => 5],
                                ['id' => '#BK-9920', 'client' => 'Kevin Hart', 'service' => 'Full Day Guide', 'date' => '04 Apr 2026', 'amount' => '₹4,500', 'rating' => 4],
                                ['id' => '#BK-9918', 'client' => 'Sunil Gupta', 'service' => 'Local Sightseeing', 'date' => '02 Apr 2026', 'amount' => '₹2,800', 'rating' => 5],
                            ];
                        @endphp
                        @foreach($completed as $c)
                        <tr>
                            <td class="small fw-700 text-muted">{{ $c['id'] }}</td>
                            <td class="small fw-800">{{ $c['client'] }}</td>
                            <td class="small fw-700">{{ $c['service'] }}</td>
                            <td class="small text-muted">{{ $c['date'] }}</td>
                            <td class="small fw-800 text-primary">{{ $c['amount'] }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 smaller fw-800 uppercase">COMPLETED</span></td>
                            <td>
                                @for($i=0; $i<$c['rating']; $i++)
                                    <i class="fas fa-star text-warning me-1" style="font-size:10px;"></i>
                                @endfor
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
             </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link { color: var(--text-muted); }
    .nav-pills .nav-link.active { background: var(--primary); color: #fff; }
    .smaller { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .rounded-4 { border-radius: 12px !important; }
    .btn-outline-custom { border-color: var(--border-color); }
</style>
@endsection

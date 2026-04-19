@extends('layouts.app')

@section('title', "Live Room Availability — Partner Portal")

@section('content')
<div class="hotel-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-hotel-sidebar active="availability" />

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Live Room Availability</h2>
                <p class="text-muted small fw-bold mb-0">Manage daily inventory and close-out dates for agent searches.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small">SAVE INVENTORY</button>
            </div>
        </div>

        <div class="row g-4">
            <!-- Availability Calendar View (Visual representation) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                    <h5 class="fw-900 text-navy mb-5 uppercase small tracking-1">Inventory Calendar (APR 2026)</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered border-light border-opacity-10 text-center align-middle">
                            <thead class="x-small fw-bold text-muted uppercase">
                                <tr>
                                    <th>ROOM TYPE</th>
                                    <th>01 APR</th>
                                    <th>02 APR</th>
                                    <th>03 APR</th>
                                    <th>04 APR</th>
                                    <th>05 APR</th>
                                    <th class="bg-light text-primary">06 APR (TODAY)</th>
                                </tr>
                            </thead>
                            <tbody class="small fw-bold">
                                <tr>
                                    <td class="text-start py-4 ps-4">Deluxe Pool Room</td>
                                    <td>08</td><td>05</td><td>02</td><td>01</td><td>00</td><td class="bg-light text-navy">12 LEFT</td>
                                </tr>
                                <tr>
                                    <td class="text-start py-4 ps-4">Executive Suite</td>
                                    <td>04</td><td>04</td><td>02</td><td>01</td><td>02</td><td class="bg-light text-navy">04 LEFT</td>
                                </tr>
                                <tr>
                                    <td class="text-start py-4 ps-4">Luxury Villa</td>
                                    <td class="text-danger">00</td><td class="text-danger">00</td><td>01</td><td>01</td><td class="text-danger">00</td><td class="bg-light text-danger">SOLD OUT</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white h-auto mb-4">
                    <h6 class="fw-900 text-navy mb-4 uppercase x-small">Quick Close-Out</h6>
                    <div class="form-group mb-4">
                        <label class="x-small fw-bold text-muted mb-2">Select Dates to Close</label>
                        <input type="text" class="form-control border-light-subtle bg-light small p-3 rounded-3" placeholder="06 APR - 10 APR">
                    </div>
                    <div class="form-group mb-5">
                       <label class="x-small fw-bold text-muted mb-2">Select Room Types</label>
                       <div class="d-flex flex-column gap-2 mt-2">
                           <div class="form-check small"><input type="checkbox" class="form-check-input" id="r1"><label for="r1" class="ms-2 fw-bold opacity-75">All Categories</label></div>
                           <div class="form-check small"><input type="checkbox" class="form-check-input" id="r2" checked><label for="r2" class="ms-2 fw-bold opacity-75">Luxury Villa</label></div>
                       </div>
                    </div>
                    <button class="btn btn-danger w-100 rounded-pill fw-bold py-3 uppercase x-small">Stop Sales for selected</button>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .tracking-1 { letter-spacing: 1px; }
    .btn-navy { background: #001f3f; color: #fff; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

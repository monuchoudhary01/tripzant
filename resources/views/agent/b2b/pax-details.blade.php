@extends('layouts.app')

@section('title', "Passenger Manifest — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="search" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Step 3: Passenger Details & Manifest</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">GDS Ready Node: Validating Passenger Information</p>
                </div>
                <div class="d-flex gap-2 align-items-center bg-white p-3 rounded-pill border shadow-sm">
                    <span class="x-small fw-bold text-muted uppercase px-3">Selected: <span class="text-navy fw-900">DEL → BOM</span></span>
                    <span class="x-small fw-bold text-muted uppercase border-start ps-3 py-1">Code: <span class="text-navy fw-900">6E-242</span></span>
                </div>
            </div>

            <div class="row g-5">
                <!-- Passenger Form -->
                <div class="col-xl-8">
                    <div class="bg-white rounded-5 shadow-sm p-5 border-0">
                         <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide"><i class="fas fa-user-friends me-2 text-primary"></i> ADULT (12+ YEARS)</h6>
                         <form action="{{ route('agent.b2b.review') }}" method="GET">
                            <input type="hidden" name="net_fare" value="{{ request('net_fare', 5000) }}">
                            <input type="hidden" name="flight_code" value="{{ request('flight_code', '6E-242') }}">
                            
                            <!-- Basic Details -->
                            <div class="row g-4 mb-5">
                                <div class="col-md-3">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">TITLE</label>
                                    <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none" required>
                                        <option value="Mr">Mr</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mrs">Mrs</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">FIRST NAME</label>
                                    <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Ex: Arjun" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">LAST NAME</label>
                                    <input type="text" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Ex: Malhotra" required>
                                </div>
                            </div>

                            <div class="row g-4 mb-5 border-top pt-5">
                                <div class="col-md-6">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">DATE OF BIRTH (OPTIONAL)</label>
                                    <input type="date" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                </div>
                                <div class="col-md-6">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">GENDER</label>
                                    <div class="d-flex gap-4 p-2 bg-light rounded-4">
                                        <div class="flex-grow-1">
                                            <input type="radio" class="btn-check" name="gender" id="male" checked>
                                            <label class="btn btn-outline-navy w-100 border-0 rounded-4 py-2 small fw-bold shadow-none" for="male">MALE</label>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="radio" class="btn-check" name="gender" id="female">
                                            <label class="btn btn-outline-navy w-100 border-0 rounded-4 py-2 small fw-bold shadow-none" for="female">FEMALE</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Optional Services -->
                            <h6 class="fw-900 text-navy mb-4 border-bottom pb-4"><i class="fas fa-magic me-2 text-primary"></i> Optional GDS Services</h6>
                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">FREQUENT FLYER NO (FFN)</label>
                                    <div class="input-group bg-light rounded-4 overflow-hidden p-1 shadow-none border-0">
                                        <span class="input-group-text bg-transparent border-0"><i class="fas fa-medal text-muted"></i></span>
                                        <input type="text" class="form-control border-0 bg-transparent py-2 fw-bold shadow-none" placeholder="Ex: 6E-12345678">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="x-small fw-900 text-muted uppercase mb-2">MEAL PREFERENCE</label>
                                    <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                        <option value="none">No Preference</option>
                                        <option value="veg">Vegetarian Meal</option>
                                        <option value="jain">Jain Meal</option>
                                        <option value="nonveg">Non-Vegetarian Meal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-12">
                                     <div class="p-4 bg-orange-light rounded-4 border-dashed border-orange border-1 d-flex align-items-center gap-4">
                                         <div class="bg-white rounded-circle p-2 px-3"><i class="fas fa-chair text-orange"></i></div>
                                         <div class="flex-grow-1 text-orange">
                                             <h6 class="fw-900 mb-1 small">Advance Seat Selection</h6>
                                             <p class="x-small mb-0 opacity-75">Click here to pick preferred seat for this passenger (+₹250 approx)</p>
                                         </div>
                                         <button type="button" class="btn btn-orange rounded-pill x-small fw-900 py-3 uppercase shadow-sm">OPEN SEAT MAP</button>
                                     </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-5 border-top d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-navy rounded-pill px-5 fw-900 uppercase x-small py-3" onclick="history.back()">PREVIOUS STEP</button>
                                <button type="submit" class="btn btn-navy rounded-pill px-5 fw-900 uppercase x-small py-3 shadow-sm">REVIEW BOOKING <i class="fas fa-chevron-right ms-2"></i></button>
                            </div>
                         </form>
                    </div>
                </div>

                <!-- Price/Summary Panel -->
                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm rounded-5 bg-white p-5 sticky-top" style="top: 100px;">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Live Price Summary</h6>
                        <div class="d-flex flex-column gap-4 border-bottom pb-5 mb-5">
                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold text-muted">Net Fare (Agent)</span>
                                <span class="small fw-900 text-navy">₹{{ number_format(request('net_fare', 5000)) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold text-muted">GST & Taxes</span>
                                <span class="small fw-900 text-green">INCLUDED</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold text-muted">Agent Margin Hub</span>
                                <span class="small fw-900 text-primary">+ ₹{{ number_format(request('margin', 500)) }} AUTO-FILL</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-5 mb-5">
                            <span class="fw-900 text-navy uppercase h6 mb-0">Selling Price</span>
                            <span class="fw-900 text-navy h5 mb-0">₹{{ number_format(intval(request('net_fare', 5000)) + intval(request('margin', 500))) }}</span>
                        </div>
                        <div class="text-center">
                            <div class="bg-light p-3 rounded-4 mb-0 border border-transparent">
                                 <p class="x-small text-muted mb-0 italic">By clicking Review Booking, you confirm the passenger information is as per Passport/ID. <span class="fw-900 text-navy">PNR creation happens in the next step.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .btn-outline-navy { border: 1px solid #001f3f; color: #001f3f; }
    .btn-outline-navy:hover { background: #001f3f; color: #fff; }
    .bg-orange-light { background: #fff7ed; color: #f97316; }
    .border-orange { border-color: #f97316 !important; }
    .text-orange { color: #f97316; }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

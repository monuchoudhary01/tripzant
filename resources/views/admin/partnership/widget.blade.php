@extends('layouts.admin')

@section('title', 'Widget Integration | Partnership System')

@section('admin_content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-900 text-navy">Widget Integration Hub</h2>
            <p class="text-muted">Generate and preview the booking widget for your partners.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Preview Column -->
        <div class="col-lg-7">
            <div class="card-admin border-0 shadow-sm bg-light">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-800 text-navy mb-0">Live Widget Preview</h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-navy active">Flight Engine</button>
                        <button class="btn btn-outline-navy">Hotel Engine</button>
                    </div>
                </div>
                
                <!-- Mock Widget Preview -->
                <div class="widget-preview-box rounded-4 overflow-hidden border bg-white shadow-lg mx-auto" style="max-width: 500px;">
                    <div class="p-3 bg-navy text-white d-flex justify-content-between align-items-center">
                        <div class="fw-bold"><i class="fas fa-plane-departure me-2 text-warning"></i> TripZant Booking</div>
                        <small class="opacity-75">Partner Integration</small>
                    </div>
                    <div class="p-4">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted d-block mb-1">FROM</label>
                                <div class="p-2 border rounded-3 bg-light bg-opacity-50 fw-bold">London (LHR)</div>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted d-block mb-1">TO</label>
                                <div class="p-2 border rounded-3 bg-light bg-opacity-50 fw-bold">New York (JFK)</div>
                            </div>
                        </div>
                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="small fw-bold text-muted d-block mb-1">DEPART</label>
                                <div class="p-2 border rounded-3 bg-light bg-opacity-50 small">15 Apr 2026</div>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted d-block mb-1">PASSENGERS</label>
                                <div class="p-2 border rounded-3 bg-light bg-opacity-50 small">1 Adult, Economy</div>
                            </div>
                        </div>
                        <button class="btn btn-warning w-100 fw-900 text-navy rounded-3 py-3 shadow-sm">
                            SEARCH FLIGHTS <i class="fas fa-search ms-2"></i>
                        </button>
                    </div>
                    <div class="p-2 bg-light border-top text-center">
                        <small class="text-muted" style="font-size: 10px;">Powered by <strong>Trip'Stay Global Network</strong></small>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-white rounded-3 border">
                    <h6 class="fw-bold small mb-2 text-primary">CUSTOMIZATION OPTIONS</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="small text-muted">Theme Color</label>
                            <input type="color" class="form-control form-control-color w-100 rounded-3" value="#0b3d61">
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted">Border Radius</label>
                            <select class="form-select form-select-sm">
                                <option>Rounded (12px)</option>
                                <option>Sharp (0px)</option>
                                <option>Full (30px)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted">Widget Size</label>
                            <select class="form-select form-select-sm">
                                <option>Standard (500px)</option>
                                <option>Compact (350px)</option>
                                <option>Full Width</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Code Column -->
        <div class="col-lg-5">
            <div class="card-admin mb-4">
                <h5 class="fw-800 text-navy mb-4"><i class="fas fa-terminal me-2 text-primary"></i> Integration Script</h5>
                <p class="text-muted small">Provide this code to your partner to embed the widget on their website.</p>
                
                <div class="bg-navy p-3 rounded-4 shadow-sm position-relative">
                    <code class="text-warning-subtle d-block mb-2" style="font-family: 'Consolas', monospace; font-size: 13px;">
                        &lt;!-- TripZant Booking Widget --&gt;<br>
                        &lt;div id="tripzant-booking-widget"&gt;&lt;/div&gt;<br>
                        &lt;script src="https://tripzant.com/js/widget.js"&gt;&lt;/script&gt;<br>
                        &lt;script&gt;<br>
                        &nbsp;&nbsp;TripZant.init({<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;partnerId: "TZ-9982X",<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;theme: "dark",<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;primaryColor: "#0b3d61"<br>
                        &nbsp;&nbsp;});<br>
                        &lt;/script&gt;
                    </code>
                    <button class="btn btn-sm btn-light rounded-pill position-absolute top-0 end-0 mt-2 me-2" onclick="alert('Code copied!')">
                        <i class="fas fa-copy me-1"></i> Copy
                    </button>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold text-navy">Instructions:</h6>
                    <ul class="text-muted small ps-3">
                        <li class="mb-2">Copy the script above and paste it before the <code>&lt;/body&gt;</code> tag.</li>
                        <li class="mb-2">Place the <code>&lt;div id="tripzant-booking-widget"&gt;</code> where you want the widget to appear.</li>
                        <li class="mb-2">Bookings are automatically tracked via the <code>partnerId</code>.</li>
                    </ul>
                </div>
            </div>

            <div class="card-admin bg-navy text-white shadow-lg border-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-white text-navy p-2 rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h5 class="fw-800 mb-0">Partner Rules</h5>
                </div>
                <ul class="list-unstyled small opacity-75">
                    <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i> 5% Commission on Flights</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i> 10% Commission on Hotels</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i> Monthly Payout (Min. $50)</li>
                    <li><i class="fas fa-clock me-2 text-warning"></i> Real-time Conversion Tracking</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-warning-subtle { color: #fdf2f2; }
    .bg-navy { background-color: #0b3d61 !important; }
</style>
@endpush

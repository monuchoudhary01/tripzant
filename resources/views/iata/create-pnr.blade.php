@extends('layouts.iata_panel')

@section('title', 'Amadeus B2B | Passenger Details')

@section('iata_content')
<div class="row g-4 mb-5">
    <div class="col-xl-8">
        <div class="d-flex align-items-center gap-3 mb-4">
             <a href="{{ route('iata.flight.availability') }}" class="btn btn-light rounded-circle" style="width: 40px; height: 40px;"><i class="fas fa-arrow-left"></i></a>
             <h4 class="fw-800 text-navy mb-0 outfit">Passenger Information</h4>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 border border-light mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h6 class="fw-800 text-navy mb-0 outfit uppercase"><i class="fas fa-user-circle me-2 text-primary"></i> ADULT 1 (Lead Traveller)</h6>
                <div class="badge bg-blue-soft text-primary px-3 py-2 fw-700">PRIMARY CONTACT</div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-2">
                    <label class="form-label small fw-800 text-muted uppercase">Title</label>
                    <select class="form-select border-0 bg-light py-3 fs-6 fw-700 rounded-3">
                        <option>Mr</option>
                        <option>Mrs</option>
                        <option>Ms</option>
                        <option>Dr</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-800 text-muted uppercase">First & Middle Name</label>
                    <input type="text" class="form-control border-0 bg-light py-3 fs-6 fw-700 rounded-3" placeholder="As per passport/Aadhar">
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-800 text-muted uppercase">Last Name</label>
                    <input type="text" class="form-control border-0 bg-light py-3 fs-6 fw-700 rounded-3" placeholder="Surname">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-800 text-muted uppercase">Gender</label>
                    <div class="d-flex gap-2">
                        <input type="radio" class="btn-check" name="gender" id="male" checked>
                        <label class="btn btn-outline-light border text-navy fw-700 px-4 py-2 w-100" for="male">Male</label>
                        <input type="radio" class="btn-check" name="gender" id="female">
                        <label class="btn btn-outline-light border text-navy fw-700 px-4 py-2 w-100" for="female">Female</label>
                    </div>
                </div>
                <div class="col-md-8">
                    <label class="form-label small fw-800 text-muted uppercase">Date of Birth</label>
                    <div class="row g-2">
                        <div class="col-4">
                            <select class="form-select border-0 bg-light py-3 fs-6 fw-700 rounded-3"><option>Day</option>@for($i=1;$i<=31;$i++)<option>{{$i}}</option>@endfor</select>
                        </div>
                        <div class="col-4">
                            <select class="form-select border-0 bg-light py-3 fs-6 fw-700 rounded-3"><option>Month</option>@foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $m)<option>{{$m}}</option>@endforeach</select>
                        </div>
                        <div class="col-4">
                            <select class="form-select border-0 bg-light py-3 fs-6 fw-700 rounded-3"><option>Year</option>@for($i=date('Y')-12;$i>=1920;$i--)<option>{{$i}}</option>@endfor</select>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5 opacity-10">

            <h6 class="fw-800 text-navy mb-4 outfit uppercase border-bottom pb-3"><i class="fas fa-passport me-2 text-primary"></i> Passport Details <span class="text-muted fw-600 lowercase ms-2" style="font-size: 11px;">(Required for International flights)</span></h6>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label small fw-800 text-muted uppercase">Passport Number</label>
                    <input type="text" class="form-control border-0 bg-light py-3 fs-6 fw-700 rounded-3" placeholder="Enter Passport No.">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-800 text-muted uppercase">Issuing Country</label>
                    <select class="form-select border-0 bg-light py-3 fs-6 fw-700 rounded-3">
                        <option>India</option>
                        <option>United Arab Emirates</option>
                        <option>United Kingdom</option>
                        <option>USA</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-800 text-muted uppercase">Passport Expiry</label>
                    <input type="date" class="form-control border-0 bg-light py-3 fs-6 fw-700 rounded-3">
                </div>
            </div>

            <hr class="my-5 opacity-10">

            <div class="rounded-4 bg-light p-4 border border-dashed border-primary border-opacity-25">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" id="gstToggle">
                    <label class="form-check-label fw-800 text-navy outfit ms-2" for="gstToggle">Add GST Details for Corporate Billing</label>
                </div>
                <div class="row g-4 mt-2" id="gstSection" style="display: none;">
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted uppercase">GST Number</label>
                        <input type="text" class="form-control border-white bg-white py-3 fs-6 fw-700 rounded-3" placeholder="07XXXXX...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted uppercase">Company Name</label>
                        <input type="text" class="form-control border-white bg-white py-3 fs-6 fw-700 rounded-3" placeholder="Legal Entity Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted uppercase">Email ID</label>
                        <input type="email" class="form-control border-white bg-white py-3 fs-6 fw-700 rounded-3" placeholder="Billing Email">
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 rounded-4 p-4 d-flex gap-3 mb-4">
             <i class="fas fa-info-circle fs-4 mt-1"></i>
             <div>
                 <div class="fw-800 text-navy mb-1 outfit">Important Booking Policy</div>
                 <p class="mb-0 text-muted small fw-600">Please ensure the names match exactly with government-issued ID. Name changes after PNR creation may incur heavy airline charges or cancellation fees.</p>
             </div>
        </div>

        <div class="text-end">
            <a href="{{ route('iata.flight.issue-ticket') }}" class="btn btn-iata rounded-4 px-5 py-3 outfit fs-5 shadow-lg">
                CONFIRM & PROCEED TO PAYMENT <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-0 border border-light sticky-top" style="top: 100px;">
            <div class="p-4 bg-navy rounded-top-4">
                <h6 class="fw-800 text-white mb-0 outfit uppercase tracking-wider">Itinerary Details</h6>
            </div>
            
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-light p-2 rounded-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/da/Air_India_Logo.svg" style="width: 32px; height: 32px; object-fit: contain;">
                    </div>
                    <div>
                        <div class="fw-800 text-navy outfit">Air India <span class="text-primary fs-xs ms-2">AI-102</span></div>
                        <div class="text-muted fw-700 uppercase" style="font-size: 10px;">Economy | Refundable</div>
                    </div>
                </div>
                
                <div class="row g-2 mb-4">
                    <div class="col-5">
                        <div class="fw-900 text-navy h4 mb-0">07:30</div>
                        <div class="text-muted fw-700" style="font-size: 11px;">DEL - New Delhi</div>
                    </div>
                    <div class="col-2 text-center align-self-center">
                        <i class="fas fa-plane text-muted opacity-50"></i>
                    </div>
                    <div class="col-5 text-end">
                        <div class="fw-900 text-navy h4 mb-0">09:45</div>
                        <div class="text-muted fw-700" style="font-size: 11px;">BOM - Mumbai</div>
                    </div>
                </div>

                <div class="bg-light p-3 rounded-3 mb-4">
                     <div class="d-flex justify-content-between small fw-700 text-muted mb-1">
                         <span>Date</span>
                         <span class="text-navy">12 Apr 2026</span>
                     </div>
                     <div class="d-flex justify-content-between small fw-700 text-muted">
                         <span>Baggage</span>
                         <span class="text-navy">Check-in: 25kg</span>
                     </div>
                </div>

                <hr class="my-4 border-dashed">

                <h6 class="fw-800 text-navy mb-4 outfit uppercase tracking-wider small">Payment Breakdown</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted fw-700 small">Base Fare (01 Adult)</span>
                    <span class="fw-800 text-navy">₹4,800.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted fw-700 small">Fees & Surcharges</span>
                    <span class="fw-800 text-navy">₹1,250.00</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-success">
                    <span class="fw-700 small">Applied Markup/Comm.</span>
                    <span class="fw-800">+₹200.00</span>
                </div>
                
                <div class="border-top border-2 border-navy mt-4 pt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted uppercase fw-800" style="font-size: 9px;">Total Amount</div>
                        <div class="h3 fw-900 text-navy mb-0 outfit">₹6,250.00</div>
                    </div>
                    <div class="text-end">
                         <div class="text-success uppercase fw-800" style="font-size: 9px;">Net Payable</div>
                         <div class="h5 fw-800 text-success mb-0 outfit">₹6,050.00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('gstToggle').addEventListener('change', function() {
        document.getElementById('gstSection').style.display = this.checked ? 'flex' : 'none';
    });
</script>
@endsection

@section('styles')
<style>
    .bg-navy { background-color: #0f172a; }
    .border-dashed { border-style: dashed !important; }
    .fs-xs { font-size: 10px; }
    .rounded-top-4 { border-top-left-radius: 1.5rem !important; border-top-right-radius: 1.5rem !important; }
</style>
@endsection

@endsection

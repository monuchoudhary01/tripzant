@extends('layouts.b2b_master')

@section('title', 'Commissions & Fees | Amadeus Partner Panel')

@section('content')
@php
    $hasAirline = request()->has('airline');
    $airline = strtoupper(request()->get('airline', ''));
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Commissions & Fees</h4>
        <p class="text-muted small mb-0">Search airline-specific commission rules and service fees.</p>
    </div>
    @if($hasAirline)
    <a href="{{ route('amadeus.commissions') }}" class="btn btn-outline-primary btn-sm px-4 fw-700 bg-white shadow-sm border-0"><i class="fas fa-search me-2"></i> NEW SEARCH</a>
    @endif
</div>

@if(!$hasAirline)
<!-- Search View -->
<div class="b2b-table-card p-5">
    <div class="row align-items-center">
        <div class="col-md-7">
            <form action="{{ route('amadeus.commissions') }}" method="GET">
                <label class="form-label-b2b">Airlines</label>
                <div class="input-group mb-4 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 px-3"><i class="fas fa-plane text-muted"></i></span>
                    <input type="text" name="airline" class="form-control form-control-b2b border-start-0 py-3" placeholder="Enter Airline Code (e.g. AI, EK, QR)" required>
                </div>
                <button type="submit" class="btn btn-success px-5 py-2 fw-700 shadow-sm" style="background: #00875a; border-radius: 6px;">Search</button>
            </form>
        </div>
        <div class="col-md-5 mt-4 mt-md-0">
            <div class="p-4 rounded-3 border bg-light" style="font-size: 13px; line-height: 1.6;">
                <p class="text-muted mb-2">Carriers not listed are non-commissionable and a service fee of $20.00 (ex GST) will apply.</p>
                <p class="text-muted mb-0">Please check with your ticketing office for fare and plate application.</p>
            </div>
        </div>
    </div>
</div>
@else
<!-- Results View -->
<div class="b2b-table-card mb-4">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0 text-uppercase ls-1">AIRLINES :{{ $airline }}</h5>
    </div>
    
    <div class="p-4 pt-1">
        <!-- Airline Notes -->
        <h6 class="fw-800 text-primary mt-4 mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
            AIRLINE NOTES 
            <span class="tiny text-muted fw-400" role="button">Hide</span>
        </h6>
        <div class="p-3 border rounded-3 bg-light mb-5" style="font-size: 13px;">
            <div class="row">
                <div class="col-1 fw-700">{{ $airline }}</div>
                <div class="col-11">16FEB24 - For involuntary reissues bookings, queued to Quiktravel will attract a fee of AUD10 for airline: {{ $airline }}</div>
            </div>
        </div>

        <!-- Commission Table -->
        <h6 class="fw-800 text-primary mt-4 mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
            COMMISSION 
            <span class="tiny text-muted fw-400" role="button">Hide</span>
        </h6>
        
        <div class="table-responsive mb-5 border rounded-3 overflow-hidden shadow-sm">
            <table class="table b2b-table mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Airline</th>
                        <th>Description</th>
                        <th>Cabin</th>
                        <th class="text-end">Commission</th>
                        <th class="text-end">Service Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-700">{{ $airline }}</td>
                        <td>
                            <div class="fw-700">{{ $airline }} ALL FARES</div>
                            <div class="text-muted small">Codeshare permitted</div>
                        </td>
                        <td>Y/J/P</td>
                        <td class="text-end fw-700">1.00%</td>
                        <td class="text-end fw-700">0.00</td>
                    </tr>
                    <tr>
                        <td class="fw-700">{{ $airline }}</td>
                        <td>
                            <div class="fw-700">{{ $airline }} Commission on Fuel Surcharge YQ ONLY</div>
                            <div class="text-muted small">International flights only. Codeshare permitted.</div>
                        </td>
                        <td>Y/J/P</td>
                        <td class="text-end fw-700">as per fare</td>
                        <td class="text-end fw-700">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- General Administration Fees -->
        <h6 class="fw-800 text-primary mt-4 mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
            GENERAL ADMINISTRATION FEES 
            <span class="tiny text-muted fw-400" role="button">Hide</span>
        </h6>
        
        <div class="table-responsive mb-5 border rounded-3 overflow-hidden shadow-sm">
            <table class="table b2b-table mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th class="text-end">Service Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-700">Cancellation</td>
                        <td>Refunds service fee processed by Ticketing Centre</td>
                        <td class="text-end fw-700">AUD 30.00</td>
                    </tr>
                    <tr>
                        <td class="fw-700">Cancellation</td>
                        <td>Refunds service fee processed by agent</td>
                        <td class="text-end fw-700">AUD 30.00</td>
                    </tr>
                    <tr>
                        <td class="fw-700">EMDA</td>
                        <td>EMDA service fee processed by Ticketing Centre</td>
                        <td class="text-end fw-700">AUD 5.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Operating Airlines Section -->
        <h6 class="fw-800 text-primary mt-4 mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
            OPERATING AIRLINES 
            <span class="tiny text-muted fw-400" role="button">Hide</span>
        </h6>
        <div class="table-responsive mb-5 border rounded-3 overflow-hidden shadow-sm">
            <table class="table b2b-table mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Airline</th>
                        <th>Operating Carrier</th>
                        <th>Airline Name</th>
                        <th>Sabre</th>
                        <th>Galileo</th>
                        <th>Amadeus</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ops = [
                            ['3K', 'QF', 'QANTAS AIRWAYS', 'Yes', 'Yes', 'Yes'],
                            ['GK', 'QF', 'QANTAS AIRWAYS', 'Yes', 'Yes', 'Yes'],
                            ['JQ', 'QF', 'QANTAS AIRWAYS', 'Yes', 'Yes', 'Yes'],
                            ['NC', 'QF', 'QANTAS AIRWAYS', 'Yes', 'Yes', 'Yes'],
                        ];
                    @endphp
                    @foreach($ops as $op)
                    <tr>
                        <td class="fw-700">{{ $op[0] }}</td>
                        <td>{{ $op[1] }}</td>
                        <td class="fw-600">{{ $op[2] }}</td>
                        <td><span class="text-success fw-700">{{ $op[3] }}</span></td>
                        <td><span class="text-success fw-700">{{ $op[4] }}</span></td>
                        <td><span class="text-success fw-700">{{ $op[5] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Accepted Credit Cards Section -->
        <h6 class="fw-800 text-primary mt-4 mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
            ACCEPTED CREDIT CARDS 
            <span class="tiny text-muted fw-400" role="button">Hide</span>
        </h6>
        <div class="p-4 border rounded-3 bg-white shadow-sm mb-4">
            <h6 class="fw-800 text-dark mb-4 ls-1">QANTAS AIRWAYS</h6>
            
            <div class="d-flex gap-5 mb-5 align-items-center overflow-auto pb-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/American_Express_logo_%282018%29.svg/1200px-American_Express_logo_%282018%29.svg.png" height="30" alt="Amex">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1200px-Mastercard-logo.svg.png" height="30" alt="Mastercard">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/UATP_logo.svg/2560px-UATP_logo.svg.png" height="20" alt="UATP">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" height="20" alt="Visa">
            </div>

            <div class="table-responsive">
                <table class="table b2b-table table-borderless mb-0">
                    <thead class="bg-white border-bottom border-secondary border-opacity-10">
                        <tr>
                            <th class="text-muted fw-700 tiny uppercase">Card Type</th>
                            <th class="text-muted fw-700 tiny uppercase">Code</th>
                            <th class="text-muted fw-700 tiny uppercase">Amount</th>
                            <th class="text-muted fw-700 tiny uppercase">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-700">AX</td>
                            <td>OB-FCA</td>
                            <td class="fw-700">0.89%</td>
                            <td class="small text-muted">
                                Applies to international itinerary per ticket.<br>
                                <span class="fw-600 text-dark">Fees are capped at AUD 120.00.</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-700">CA</td>
                            <td>OB-FCA</td>
                            <td class="fw-700">0.89%</td>
                            <td class="small text-muted">
                                Applies to international itinerary per ticket.<br>
                                <span class="fw-600 text-dark">Fees are capped at AUD 22.00.</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-700">CA</td>
                            <td>OB-FDA</td>
                            <td class="fw-700">0.30%</td>
                            <td class="small text-muted">
                                Applies to domestic, trans tasman itinerary per ticket.<br>
                                <span class="fw-600 text-dark">Fees are capped at AUD 22.00.</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-700">VI</td>
                            <td>OB-FCA</td>
                            <td class="fw-700">1.01%</td>
                            <td class="small text-muted">
                                Applies to international itinerary per ticket.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .ls-1 { letter-spacing: 1px; }
    .tiny { font-size: 11px !important; }
</style>
@endsection

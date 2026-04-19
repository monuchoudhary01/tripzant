@extends('layouts.hotel_master')

@section('title', 'Earnings Tracker | Partner Super App')

@section('styles')
<style>
    .ps-earning-pill { background: #fff; border-radius: 20px; padding: 25px; border: 1px solid var(--ps-border); display: flex; align-items: center; gap: 15px; }
    .ps-earning-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Partnership Commissions</h2>
        <p class="text-muted fw-600 mb-0">Track all side-earnings and ancillary commissions generated from travel services.</p>
    </div>
    <select class="form-select border-0 px-4 py-2 rounded-pill fw-800 small ps-3" style="width: 200px;">
        <option>This Month: APR</option>
        <option>Last Month: MAR</option>
    </select>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="ps-earning-pill">
             <div class="ps-earning-icon" style="background:#e0f2fe; color:#0ea5e9;"><i class="fas fa-plane"></i></div>
             <div>
                  <div class="tiny fw-800 text-muted uppercase">Flight</div>
                  <div class="h5 fw-900 text-navy mb-0 outfit">₹85,200</div>
             </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ps-earning-pill">
             <div class="ps-earning-icon" style="background:#fef9c3; color:#eab308;"><i class="fas fa-map-marked-alt"></i></div>
             <div>
                  <div class="tiny fw-800 text-muted uppercase">Tours</div>
                  <div class="h5 fw-900 text-navy mb-0 outfit">₹42,500</div>
             </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ps-earning-pill">
             <div class="ps-earning-icon" style="background:#dcfce7; color:#10b981;"><i class="fas fa-car"></i></div>
             <div>
                  <div class="tiny fw-800 text-muted uppercase">Rentals</div>
                  <div class="h5 fw-900 text-navy mb-0 outfit">₹12,400</div>
             </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ps-earning-pill" style="border-color: #6366f1;">
             <div class="ps-earning-icon" style="background:#eef2ff; color:#6366f1;"><i class="fas fa-plus"></i></div>
             <div>
                  <div class="tiny fw-800 text-primary uppercase">Total Ancillary</div>
                  <div class="h5 fw-900 text-primary mb-0 outfit">₹1,40,100</div>
             </div>
        </div>
    </div>
</div>

<div class="ps-transaction-card">
    <h5 class="outfit fw-900 text-navy mb-4">Earnings Breakdown Details</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="tiny fw-800 text-muted uppercase ls-1">
                    <th>Service Ref</th>
                    <th>Guest Name</th>
                    <th>Booking Value</th>
                    <th>Comm. (%)</th>
                    <th class="text-end">Earning (Net)</th>
                </tr>
            </thead>
            <tbody class="small fw-700">
                <tr>
                    <td>#FLT-9012 (Air India)</td>
                    <td>Mr. Mark Sydney</td>
                    <td>₹1,42,000</td>
                    <td>5.0%</td>
                    <td class="text-end text-success">+ ₹7,100.00</td>
                </tr>
                <tr>
                    <td>#TOU-8822 (Taj Mahal Private)</td>
                    <td>Ms. Sarah Jones</td>
                    <td>₹12,800</td>
                    <td>Markup</td>
                    <td class="text-end text-success">+ ₹1,200.00</td>
                </tr>
                <tr>
                    <td>#HTL-EXT-112 (Atlantis Dubai)</td>
                    <td>Rahul Sharma</td>
                    <td>₹6,40,000</td>
                    <td>4.5%</td>
                    <td class="text-end text-success">+ ₹28,800.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

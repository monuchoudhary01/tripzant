@extends('layouts.hotel_master')

@section('title', 'Wallet & Funds | Partner Super App')

@section('styles')
<style>
    .wallet-hero { background: linear-gradient(135deg, #101828, #1e293b); border-radius: 24px; padding: 40px; color: #fff; margin-bottom: 40px; }
    .ps-transaction-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 24px; }
    .ps-balance-display { font-size: 38px; font-weight: 900; margin: 10px 0; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Financial Wallet</h2>
        <p class="text-muted fw-600 mb-0">Manage your B2B balance, top-up funds, and review all service transactions.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="wallet-hero shadow-lg">
             <div class="tiny fw-800 opacity-50 uppercase ls-1 mb-2">Available Balance</div>
             <div class="ps-balance-display outfit">₹1,45,280.00</div>
             <div class="small fw-700 opacity-75 mb-5 pb-5 border-bottom border-secondary">Ref: HTL-WAL-99412 • Status: Active</div>
             
             <h6 class="tiny fw-900 uppercase ls-1 mb-3">Recharge Your Wallet</h6>
             <div class="input-group mb-3">
                 <span class="input-group-text bg-transparent border-secondary text-white fw-bold">₹</span>
                 <input type="number" class="form-control bg-transparent border-secondary text-white fw-bold" placeholder="Enter amount to add" value="10000">
                 <button class="btn btn-primary px-4 fw-bold">ADD FUNDS</button>
             </div>
             <div class="tiny fw-700 opacity-50">Secure payment via CC/DC/UPI or Bank Transfer.</div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="ps-transaction-card">
             <h5 class="outfit fw-900 text-navy mb-4">Transaction History</h5>
             <div class="table-responsive">
                 <table class="table align-middle">
                     <thead>
                         <tr class="tiny fw-800 text-muted uppercase ls-1">
                             <th>Date</th>
                             <th>Transaction Details</th>
                             <th>Service</th>
                             <th class="text-end">Amount</th>
                         </tr>
                     </thead>
                     <tbody class="small fw-700">
                         <tr>
                             <td class="text-muted">Apr 07, 2024</td>
                             <td>Flight Booking: #FLT-9001 (Mark A.)</td>
                             <td><span class="badge bg-light text-primary">FLIGHT</span></td>
                             <td class="text-end text-danger">- ₹8,500</td>
                         </tr>
                         <tr>
                             <td class="text-muted">Apr 06, 2024</td>
                             <td>Wallet Recharge: Ref #BANK-123</td>
                             <td><span class="badge bg-light text-success">WALLET</span></td>
                             <td class="text-end text-success">+ ₹50,000</td>
                         </tr>
                         <tr>
                             <td class="text-muted">Apr 05, 2024</td>
                             <td>Sightseeing: Taj Mahal (Sarah J.)</td>
                             <td><span class="badge bg-light text-info">TOUR</span></td>
                             <td class="text-end text-danger">- ₹12,800</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
        </div>
    </div>
</div>
@endsection

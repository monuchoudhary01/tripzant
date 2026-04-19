@extends('layouts.hotel_master')

@section('title', 'Inventory & Pricing | Partner Super App')

@section('styles')
<style>
    .ps-inventory-table { border-collapse: separate; border-spacing: 0; border: 1px solid var(--ps-border); border-radius: 20px; overflow: hidden; width: 100%; border-right: 0 !important; }
    .ps-inventory-table th { background: #101828; color: #fff; text-align: center; border: 1px solid rgba(255,255,255,0.1); padding: 15px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .ps-inventory-table td { background: #fff; border: 1px solid var(--ps-border); padding: 20px 10px; width: 100px; text-align: center; }
    
    .ps-inv-cell { padding: 4px; border-radius: 8px; font-weight: 900; background: #f8fafc; border: 2px solid transparent; width: 60px; height: 35px; outline: none; text-align: center; font-size: 13px; }
    .ps-inv-cell:focus { border-color: var(--ps-accent); background: #fff; }
    
    .ps-inv-tag { font-size: 9px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-top: 5px; display: block; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Inventory & Dynamic Pricing</h2>
        <p class="text-muted fw-600 mb-0">Set room availability and nightly rates for the upcoming week across all connected channels.</p>
    </div>
    <div class="d-flex gap-2">
         <button class="btn btn-outline-dark px-4 py-3 rounded-pill fw-900 small border-2">LAST WEEK</button>
         <button class="btn btn-outline-dark px-4 py-3 rounded-pill fw-900 small border-2 active">NEXT 7 DAYS</button>
         <button class="ps-btn-primary px-5 py-3">SAVE INVENTORY</button>
    </div>
</div>

<div class="table-responsive">
    <table class="ps-inventory-table">
        <thead>
            <tr>
                <th style="text-align: left; background: #1e293b;">Room Category</th>
                <th>Mon, 08 Apr</th>
                <th>Tue, 09 Apr</th>
                <th>Wed, 10 Apr</th>
                <th>Thu, 11 Apr</th>
                <th style="background:#4338ca;">Fri, 12 Apr</th>
                <th style="background:#4338ca;">Sat, 13 Apr</th>
                <th>Sun, 14 Apr</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 20px; text-align: left; width: 250px;">
                    <div class="fw-900 text-navy mb-1">Superior Twin Room</div>
                    <div class="tiny fw-800 text-muted uppercase">10 Total Units</div>
                </td>
                @for($i=0; $i<7; $i++)
                <td>
                    <input type="text" class="ps-inv-cell" value="8,500">
                    <span class="ps-inv-tag">Available: 4</span>
                </td>
                @endfor
            </tr>
            <tr>
                <td style="padding: 20px; text-align: left; width: 250px;">
                    <div class="fw-900 text-navy mb-1">Executive Club Suite</div>
                    <div class="tiny fw-800 text-muted uppercase">4 Total Units</div>
                </td>
                @for($i=0; $i<7; $i++)
                <td>
                    <input type="text" class="ps-inv-cell" value="12,400">
                    <span class="ps-inv-tag text-danger">Sold Out</span>
                </td>
                @endfor
            </tr>
            <tr>
                <td style="padding: 20px; text-align: left; width: 250px;">
                    <div class="fw-900 text-navy mb-1">Corporate Twin (Basic)</div>
                    <div class="tiny fw-800 text-muted uppercase">20 Total Units</div>
                </td>
                @for($i=0; $i<7; $i++)
                <td>
                    <input type="text" class="ps-inv-cell" value="5,500">
                    <span class="ps-inv-tag">Available: 12</span>
                </td>
                @endfor
            </tr>
        </tbody>
    </table>
</div>

<div class="mt-5 bg-white p-5 rounded-4 border border-faint">
     <h5 class="outfit fw-900 text-navy mb-4">Channel Multiplier Settings</h5>
     <div class="row g-4">
          <div class="col-md-3">
               <label class="small fw-800 text-muted uppercase mb-2">OTA Markup (MMT)</label>
               <input type="text" class="form-control py-2 fw-700 bg-light border-0" value="15%">
          </div>
          <div class="col-md-3">
               <label class="small fw-800 text-muted uppercase mb-2">B2B Base Markup</label>
               <input type="text" class="form-control py-2 fw-700 bg-light border-0" value="10%">
          </div>
          <div class="col-md-6">
               <div class="alert alert-info border-0 rounded-4 p-4 mt-3 small fw-700 opacity-75">
                    <i class="fas fa-info-circle me-1"></i> Global inventory updates are synchronized across all connected GDS/OTA platforms in real-time.
               </div>
          </div>
     </div>
</div>
@endsection

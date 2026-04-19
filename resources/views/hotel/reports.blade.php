@extends('layouts.hotel_master')

@section('title', 'Success Analytics | Hotel Deal Terminal')

@section('styles')
<style>
    .h-chart-placeholder { height: 250px; background: #fff; border-radius: 20px; border: 1px solid var(--h-border); position: relative; margin-bottom: 25px; overflow: hidden; }
    .h-chart-bar { position: absolute; bottom: 0; width: 40px; background: var(--h-accent); border-radius: 8px 8px 0 0; }
    .h-kpi-card { background: #fff; border-radius: 16px; border: 1px solid var(--h-border); padding: 25px; display: flex; align-items: center; gap: 15px; }
    .h-kpi-icon { width: 45px; height: 45px; border-radius: 10px; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--h-accent); }
    .text-success { color: #16a34a !important; }
</style>
@endsection

@section('content')
<div class="mb-5">
    <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px;">Negotiation Success Intelligence</h2>
    <p class="text-muted fw-600 mb-0">Actionable insights into your hotel's deal conversion and market responsiveness.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="h-kpi-card shadow-sm">
             <div class="h-kpi-icon"><i class="fas fa-handshake"></i></div>
             <div>
                  <div class="tiny fw-800 text-muted uppercase">Deal Conversion</div>
                  <div class="h5 fw-900 text-navy mb-0">68% Success</div>
             </div>
             <div class="ms-auto text-success fw-900 small">+12%</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="h-kpi-card shadow-sm">
             <div class="h-kpi-icon" style="color: #9333ea;"><i class="fas fa-stopwatch"></i></div>
             <div>
                  <div class="tiny fw-800 text-muted uppercase">Average Response Time</div>
                  <div class="h5 fw-900 text-navy mb-0">12m 45s</div>
             </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="h-kpi-card shadow-sm">
             <div class="h-kpi-icon" style="color: #ea580c;"><i class="fas fa-wallet"></i></div>
             <div>
                  <div class="tiny fw-800 text-muted uppercase">Avg. Deal Value</div>
                  <div class="h5 fw-900 text-navy mb-0">₹45,800</div>
             </div>
        </div>
    </div>
</div>

<div class="row g-5">
    <!-- Chart Column -->
    <div class="col-lg-8">
        <h5 class="outfit fw-900 text-navy mb-4">Market Traction (Last 7 Days)</h5>
        <div class="h-chart-placeholder d-flex align-items-end justify-content-around p-4">
            <div class="h-chart-bar" style="height: 40%;"></div>
            <div class="h-chart-bar" style="height: 60%; opacity: 0.8;"></div>
            <div class="h-chart-bar" style="height: 90%; background: #3b82f6;"></div>
            <div class="h-chart-bar" style="height: 50%;"></div>
            <div class="h-chart-bar" style="height: 75%;"></div>
            <div class="h-chart-bar" style="height: 85%;"></div>
            <div class="h-chart-bar" style="height: 95%; background: #2563eb;"></div>
        </div>
        <div class="d-flex justify-content-around text-muted tiny fw-800 uppercase px-4 ls-1">
            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
        </div>

        <div class="mt-5 h-glass-card p-4">
            <h6 class="outfit fw-900 text-navy mb-3">Top Markets (Source)</h6>
            <div class="mb-3">
                 <div class="d-flex justify-content-between mb-1">
                     <span class="small fw-700">Australia / Oceania</span>
                     <span class="small fw-800">45% Volume</span>
                 </div>
                 <div class="progress" style="height: 8px; border-radius: 10px;">
                      <div class="progress-bar bg-primary" style="width: 45%;"></div>
                 </div>
            </div>
            <div class="mb-3">
                 <div class="d-flex justify-content-between mb-1">
                     <span class="small fw-700">United Kingdom</span>
                     <span class="small fw-800">28% Volume</span>
                 </div>
                 <div class="progress" style="height: 8px; border-radius: 10px;">
                      <div class="progress-bar bg-success" style="width: 28%;"></div>
                 </div>
            </div>
        </div>
    </div>

    <!-- Right Summary -->
    <div class="col-lg-4">
         <h5 class="outfit fw-900 text-navy mb-4">Competitiveness Map</h5>
         <div class="p-4 rounded-4 shadow-sm border border-2 border-primary border-opacity-10 bg-white">
              <p class="text-muted small fw-600 mb-5 lh-lg">Based on your bid success, your property has a <strong>95% Pricing Match</strong> index for the Australian market. To increase UK bookings, consider a 5% bundle discount including airport transfers.</p>
              
              <div class="mb-4">
                   <div class="h-badge h-badge-sent rounded-4 p-4 text-center" style="background:#eff6ff;">
                       <div class="h3 fw-900 text-primary outfit mb-1">Rank #1</div>
                       <div class="small fw-800 text-muted opacity-75">Among Delh Properties</div>
                   </div>
              </div>

              <button class="btn btn-primary w-100 py-3 rounded-pill fw-800 shadow-sm border-0" style="background:#3b82f6;">UPGRADE MARKET ACCESS</button>
         </div>
    </div>
</div>
@endsection

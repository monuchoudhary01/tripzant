@extends('layouts.hotel_master')

@section('title', 'OTA Connectivity | Hotel Channel Manager')

@section('styles')
<style>
    .ps-ota-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; transition: 0.2s; }
    .ps-ota-logo { width: 120px; height: 40px; background-size: contain; background-repeat: no-repeat; filter: grayscale(1); opacity: 0.8; transition: 0.3s; }
    .ps-ota-card:hover .ps-ota-logo { filter: grayscale(0); opacity: 1; }
    .ps-ota-badge { font-size: 10px; font-weight: 800; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; }
    .bg-active { background: #dcfce7; color: #16a34a; }
    .bg-pending { background: #fef9c3; color: #eab308; }
    
    .step-card { background: #fff; border-top: 5px solid #6366f1; border-radius: 12px; padding: 20px; transition: 0.3s; height: 100%; border: 1px solid var(--ps-border); }
    .step-num { width: 32px; height: 32px; border-radius: 50%; background: #6366f1; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px; margin-bottom: 15px; }
    .step-title { font-size: 14px; font-weight: 900; color: #101828; margin-bottom: 8px; }
    .step-desc { font-size: 12px; font-weight: 600; color: #667085; line-height: 1.5; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Distribution Management Hub</h2>
        <p class="text-muted fw-600 mb-0">Manage 2-way API connections with major OTA platforms to sync inventory and bookings.</p>
    </div>
    <div class="d-flex gap-3">
         <button class="btn btn-outline-dark px-4 py-3 rounded-pill fw-900 small border-2" onclick="location.href='{{ route('hotel.sync-status') }}'"><i class="fas fa-history me-2"></i> VIEW SYNC LOG</button>
         <button class="ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 shadow-sm"><i class="fas fa-plus me-2"></i> CONNECT NEW CHANNEL</button>
    </div>
</div>

<!-- Step-by-Step Distribution Process -->
<div class="mb-5">
     <h6 class="tiny fw-900 uppercase ls-1 text-muted mb-4">The 4-Step Distribution Workflow: How it Works</h6>
     <div class="row g-4">
          <div class="col-md-3">
               <div class="step-card shadow-sm">
                    <div class="step-num">1</div>
                    <div class="step-title">Connect OTA</div>
                    <p class="step-desc">Establish secure XML/API link with channels like Booking.com using your credentials.</p>
               </div>
          </div>
          <div class="col-md-3">
               <div class="step-card shadow-sm" style="border-top-color: #0ea5e9;">
                    <div class="step-num" style="background:#0ea5e9;">2</div>
                    <div class="step-title">Room Mapping</div>
                    <p class="step-desc">Link your internal room types to the channel's room types to sync data correctly.</p>
               </div>
          </div>
          <div class="col-md-3">
               <div class="step-card shadow-sm" style="border-top-color: #10b981;">
                    <div class="step-num" style="background:#10b981;">3</div>
                    <div class="step-title">Push Inventory</div>
                    <p class="step-desc">Your nightly rates and availability are sent from CRS to all channels in real-time.</p>
               </div>
          </div>
          <div class="col-md-3">
               <div class="step-card shadow-sm" style="border-top-color: #f59e0b;">
                    <div class="step-num" style="background:#f59e0b;">4</div>
                    <div class="step-title">Stop Overbooking</div>
                    <p class="step-desc">When a booking arrives, inventory automatically reduces on all other channels.</p>
               </div>
          </div>
     </div>
</div>

<div class="row g-4">
    <!-- Channel Item: Booking.com -->
    <div class="col-12 ps-ota-card">
         <div class="d-flex align-items-center gap-5 flex-grow-1">
              <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Booking.com_logo.svg" width="120">
              <div>
                   <h6 class="outfit fw-800 text-navy mb-1">Booking.com</h6>
                   <div class="small fw-700 text-muted"><i class="fas fa-link me-1"></i> API Connection: XML Direct</div>
              </div>
         </div>
         <div class="px-5 border-start border-end text-center d-none d-md-block" style="width: 250px;">
              <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Mapping Status</div>
              <div class="ps-ota-badge bg-active">ACTIVE • 4 ROOMS MAPPED</div>
              <div class="tiny text-muted fw-700 mt-1">Last Sync: 2m ago</div>
         </div>
         <div class="ps-3 d-flex flex-column gap-2" style="width: 200px;">
              <button class="btn btn-light py-2 rounded-pill small fw-800 border-0">CONFIGURE API</button>
              <button class="btn btn-outline-danger py-2 rounded-pill tiny fw-800 border-2">DISCONNECT</button>
         </div>
    </div>

    <!-- Channel Item: Agoda -->
    <div class="col-12 ps-ota-card" style="border-left: 5px solid #eab308;">
         <div class="d-flex align-items-center gap-5 flex-grow-1">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Agoda_logo.svg/2560px-Agoda_logo.svg.png" width="120">
              <div>
                   <h6 class="outfit fw-800 text-navy mb-1">Agoda.com</h6>
                   <div class="small fw-700 text-muted"><i class="fas fa-link me-1"></i> API Connection: PENDING AUTH</div>
              </div>
         </div>
         <div class="px-5 border-start border-end text-center d-none d-md-block" style="width: 250px;">
              <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">Mapping Status</div>
              <div class="ps-ota-badge bg-pending">INCOMPLETE</div>
              <div class="tiny text-muted fw-700 mt-1">Sync: Disabled</div>
         </div>
         <div class="ps-3 d-flex flex-column gap-2" style="width: 200px;">
              <button class="btn btn-warning py-2 rounded-pill small fw-800 border-0 text-white">RETRY ACCESS</button>
         </div>
    </div>
</div>

<div class="mt-5 p-5 bg-white rounded-4 border border-faint">
     <h5 class="outfit fw-900 text-navy mb-4">Master Distribution Strategy</h5>
     <div class="row g-4">
          <div class="col-md-6">
               <div class="ps-card-stat p-4 mb-3 border-secondary border-opacity-10">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                         <h6 class="tiny fw-900 uppercase text-muted">Overbooking Prevention</h6>
                         <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                    </div>
                    <p class="small fw-700 text-navy">Auto-stop sales on all channels when inventory reaches zero in any one channel or direct booking.</p>
               </div>
          </div>
          <div class="col-md-6">
               <div class="ps-card-stat p-4 mb-3 border-secondary border-opacity-10">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                         <h6 class="tiny fw-900 uppercase text-muted">Channel Auto-Markup</h6>
                         <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                    </div>
                    <p class="small fw-700 text-navy">Automatically push 5-10% higher rates to OTAs to recover commission costs.</p>
               </div>
          </div>
     </div>
</div>
@endsection

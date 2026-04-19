@extends('layouts.hotel_master')

@section('title', 'Control Center | Hotel Partner Super Panel')

@section('styles')
<style>
    .ps-pillar-card { background: #fff; border-radius: 28px; border: 1px solid var(--ps-border); padding: 35px; height: 100%; transition: 0.3s; position: relative; overflow: hidden; }
    .ps-pillar-card:hover { transform: translateY(-5px); border-color: #6366f1; box-shadow: 0 15px 45px rgba(99,102,241,0.08); }
    .ps-pillar-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 25px; }
    .ps-cap-tag { font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 8px; background: #f8fafc; color: #64748b; text-transform: uppercase; margin-bottom: 10px; display: inline-block; }
    
    /* Magic Flow Animation Line */
    .ps-flow-line { height: 2px; background: linear-gradient(90deg, #6366f1, transparent); position: relative; margin: 20px 0; }
    .ps-flow-dot { width: 8px; height: 8px; background: #6366f1; border-radius: 50%; position: absolute; top: -3px; left: 0; animation: flowMove 3s infinite linear; }
    @keyframes flowMove { 0% { left: 0; opacity: 0; } 50% { opacity: 1; } 100% { left: 100%; opacity: 0; } }
</style>
@endsection

@section('content')
<div class="mb-5">
    <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -2px; font-size: 42px;">Super Panel Control Center</h2>
    <p class="text-muted fw-700 h5 mb-0" style="opacity: 0.7;">Explore the 4 Pillars of your Autonomous Hotel Operating System.</p>
</div>

<div class="row g-4">
    <!-- Pillar 1: Automation Magic -->
    <div class="col-lg-3 col-md-6">
        <div class="ps-pillar-card p-4">
             <div class="ps-pillar-icon" style="background: #eef2ff; color: #6366f1;"><i class="fas fa-robot"></i></div>
             <div class="ps-cap-tag">Automation Engine</div>
             <h4 class="outfit fw-900 text-navy mb-3">Hands-Free Bookings</h4>
             <p class="small fw-700 text-muted lh-base mb-4">Webhooks listen to OTA signals. Inventory syncs, Vouchers generate & WhatsApp is triggered without human touch.</p>
             <div class="ps-flow-line"><div class="ps-flow-dot"></div></div>
             <a href="{{ route('hotel.webhook-logs') }}" class="tiny fw-900 text-primary text-decoration-none">VIEW LIVE FLOWS <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- Pillar 2: Global Distribution -->
    <div class="col-lg-3 col-md-6">
        <div class="ps-pillar-card p-4">
             <div class="ps-pillar-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-globe-americas"></i></div>
             <div class="ps-cap-tag">Direct XML Distribution</div>
             <h4 class="outfit fw-900 text-navy mb-3">Omni-Channel Live</h4>
             <p class="small fw-700 text-muted lh-base mb-4">Push your rates and inventory to Booking.com, Agoda, and your Direct B2C engine simultaneously via XML API.</p>
             <div class="d-flex gap-2 mb-4">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Booking.com_logo.svg" width="20" class="opacity-50">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Agoda_logo.svg/2560px-Agoda_logo.svg.png" width="20" class="opacity-50">
             </div>
             <a href="{{ route('hotel.channel-manager') }}" class="tiny fw-900 text-primary text-decoration-none">OTA CONNECTIONS <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- Pillar 3: Multi-Property Portfolio -->
    <div class="col-lg-3 col-md-6">
        <div class="ps-pillar-card p-4">
             <div class="ps-pillar-icon" style="background: #fff7ed; color: #f97316;"><i class="fas fa-layer-group"></i></div>
             <div class="ps-cap-tag">Property Super Management</div>
             <h4 class="outfit fw-900 text-navy mb-3">Inventory Portfolio</h4>
             <p class="small fw-700 text-muted lh-base mb-4">Bulk Import 100+ properties via CSV. Manage them as a Group/Aggregator with unified financial reporting.</p>
             <div class="mt-3 mb-4">
                  <span class="badge bg-light text-navy fw-800 p-2 me-1" style="font-size: 9px;">+ BATCH UPLOAD</span>
                  <span class="badge bg-light text-navy fw-800 p-2" style="font-size: 9px;">+ EXCEL SYNC</span>
             </div>
             <a href="{{ route('hotel.my-properties') }}" class="tiny fw-900 text-primary text-decoration-none">MY PROPERTIES <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- Pillar 4: Travel Concierge -->
    <div class="col-lg-3 col-md-6">
        <div class="ps-pillar-card p-4">
             <div class="ps-pillar-icon" style="background: #fdf2f8; color: #db2777;"><i class="fas fa-suitcase-rolling"></i></div>
             <div class="ps-cap-tag">Travel Super Service Hub</div>
             <h4 class="outfit fw-900 text-navy mb-3">Ancillary Commissions</h4>
             <p class="small fw-700 text-muted lh-base mb-4">Book Flights, External Hotels, Managed Transfers, and Local Guides for your guests to earn extra commission.</p>
             <div class="d-flex text-muted gap-2 mb-4" style="font-size: 14px;">
                  <i class="fas fa-plane"></i> <i class="fas fa-car"></i> <i class="fas fa-microphone-lines"></i>
             </div>
             <a href="{{ route('hotel.flight-engine') }}" class="tiny fw-900 text-primary text-decoration-none">EXPLORE SERVICES <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</div>

<!-- Core Dashboard Stats (Sample) -->
<div class="row g-4 mt-5">
     <div class="col-lg-8">
          <div class="bg-white rounded-4 border border-faint p-4">
               <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="outfit fw-900 text-navy mb-0">System Health & Live Monitoring</h5>
                    <span class="badge bg-success-light text-success fw-800 px-3 py-2 rounded-pill border-0" style="font-size: 10px;"><i class="fas fa-circle small me-1"></i> ALL SYSTEMS NOMINAL</span>
               </div>
               <div class="table-responsive">
                    <table class="table align-middle border-0">
                         <tbody class="fw-800 text-muted small">
                              <tr><td class="ps-0 border-0">Booking.com Webhook XML Listener</td><td class="text-end border-0"><span class="text-success">ACTIVE</span> (2ms Latency)</td></tr>
                              <tr><td class="ps-0 border-0">Inventory Auto-Sync Engine</td><td class="text-end border-0"><span class="text-success">ACTIVE</span> (Last sync: Now)</td></tr>
                              <tr><td class="ps-0 border-0">WhatsApp Business Notification Gateway</td><td class="text-end border-0"><span class="text-success">ACTIVE</span> (99.9% Uptime)</td></tr>
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
     <div class="col-lg-4">
          <div class="alert alert-dark border-0 p-5 rounded-5 h-100 mb-0 shadow-lg" style="background-image: linear-gradient(135deg, #1e293b, #0f172a);">
               <h4 class="outfit fw-900 text-white mb-3">Ready to Scale?</h4>
               <p class="text-light fw-700 opacity-50 small mb-4">Your Hotel Partner Super Panel is configured for global scale. Add more properties or activate more channels to increase your yield.</p>
               <button class="btn btn-primary w-100 py-3 rounded-pill fw-800 border-0 shadow-lg" onclick="location.href='{{ route('hotel.add-property') }}'">+ ADD NEW HOTEL NOW</button>
          </div>
     </div>
</div>
@endsection

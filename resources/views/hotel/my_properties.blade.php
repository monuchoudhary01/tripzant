@extends('layouts.hotel_master')

@section('title', 'Properties Portfolio | Hotel Super Panel')

@section('styles')
<style>
    .ps-property-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); display: flex; overflow: hidden; margin-bottom: 25px; transition: 0.2s; position: relative; }
    .ps-property-card:hover { border-color: var(--ps-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .ps-property-img { width: 220px; min-width: 220px; background-size: cover; background-position: center; position: relative; }
    .ps-property-info { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
    .ps-property-status { position: absolute; top: 15px; right: 15px; }
    
    .ps-channel-icon { width: 28px; height: 28px; border-radius: 6px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748b; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Master Property Portfolio</h2>
        <p class="text-muted fw-600 mb-0">Unified dashboard to manage all your registered properties and their global distribution status.</p>
    </div>
    <div class="d-flex gap-2">
         <button class="btn btn-outline-dark px-4 py-3 rounded-pill fw-900 small border-2" onclick="location.href='{{ route('hotel.add-property') }}'"><i class="fas fa-plus me-1"></i> ADD PROPERTY</button>
    </div>
</div>

<div class="row g-4 overflow-auto" style="max-height: 80vh;">
    <!-- Property List Item 1 -->
    <div class="col-12 ps-property-card">
         <div class="ps-property-img" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=400');">
              <div class="ps-property-status">
                   <span class="badge bg-success px-3 py-2 rounded-pill fw-800 outfit border-0">LIVE & SYNCING</span>
              </div>
         </div>
         <div class="ps-property-info">
              <div class="tiny fw-800 text-muted uppercase ls-1 mb-2">DELHI NCR • 5 STAR LUXURY</div>
              <h4 class="outfit fw-900 text-navy mb-2">Radisson Blu Plaza Hotel</h4>
              <p class="text-muted small fw-600 mb-4 lh-base">IGI Airport Area. 120 Units. Currently 85% Occupancy.</p>
              
              <div class="d-flex align-items-center gap-4">
                   <div>
                        <div class="tiny fw-900 uppercase text-muted mb-2">Connected Channels</div>
                        <div class="d-flex gap-2">
                             <div class="ps-channel-icon" title="Booking.com"><i class="fas fa-link"></i></div>
                             <div class="ps-channel-icon" title="Agoda"><i class="fas fa-link"></i></div>
                             <div class="ps-channel-icon" title="Direct"><i class="fas fa-globe"></i></div>
                        </div>
                   </div>
                   <div class="border-start ps-4">
                        <div class="tiny fw-900 uppercase text-muted mb-2">Monthly Revenue</div>
                        <div class="fw-900 text-navy">₹42.5 Lacs</div>
                   </div>
              </div>
         </div>
         <div class="d-flex flex-column justify-content-center p-4 border-start gap-2 bg-light" style="width: 220px;">
              <button class="btn btn-dark py-2 rounded-pill small fw-900 border-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#propertyShowcaseModal">VIEW FULL CAPABILITY</button>
              <button class="btn ps-btn-primary py-2 rounded-pill small fw-800 border-0 shadow-sm" onclick="location.href='{{ route('hotel.inventory') }}'">MANAGE RATES</button>
         </div>
    </div>

    <!-- Property List Item 2 -->
    <div class="col-12 ps-property-card">
         <div class="ps-property-img" style="background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=400');">
              <div class="ps-property-status">
                   <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-800 outfit border-0">AWAITING MAPPING</span>
              </div>
         </div>
         <div class="ps-property-info">
              <div class="tiny fw-800 text-muted uppercase ls-1 mb-2">DUBAI • ULTRA LUXURY</div>
              <h4 class="outfit fw-900 text-navy mb-2">Atlantis The Palm, Dubai</h4>
              <p class="text-muted small fw-600 mb-4 lh-base">Palm Jumeirah. 650 Units. Bulk Import Processed via CSV.</p>
              
              <div class="d-flex align-items-center gap-4">
                   <div>
                        <div class="tiny fw-900 uppercase text-muted mb-2">Connected Channels</div>
                        <div class="d-flex gap-2 opacity-50">
                             <div class="ps-channel-icon"><i class="fas fa-unlink"></i></div>
                             <div class="ps-channel-icon"><i class="fas fa-unlink"></i></div>
                        </div>
                   </div>
                   <div class="border-start ps-4 text-center">
                        <div class="tiny fw-900 uppercase text-muted mb-2">Avg. Yield</div>
                        <div class="fw-900 text-navy">₹65,000 / night</div>
                   </div>
              </div>
         </div>
         <div class="d-flex flex-column justify-content-center p-4 border-start gap-2 bg-light" style="width: 220px;">
              <button class="btn btn-dark py-2 rounded-pill small fw-900 border-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#propertyShowcaseModal">VIEW FULL CAPABILITY</button>
              <button class="btn btn-warning py-2 rounded-pill small fw-800 border-0 text-white shadow-sm" onclick="location.href='{{ route('hotel.ota-mapping') }}'">COMPLETE MAPPING</button>
         </div>
    </div>
</div>

<!-- PROPERTY SHOWCASE & CAPABILITIES MODAL -->
<div class="modal fade" id="propertyShowcaseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:32px; overflow: hidden;">
            <div class="modal-body p-0">
                 <div class="row g-0">
                      <!-- Left Panel: Visual Hero -->
                      <div class="col-lg-4 bg-dark d-flex flex-column" style="background-image: linear-gradient(rgba(15, 23, 42, 0.4), #0f172a), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800'); background-size: cover; background-position: center; min-height: 500px;">
                           <div class="p-5 mt-auto text-white">
                                <div class="badge bg-primary px-3 py-2 rounded-pill mb-3 fw-800 ls-1">PREMIUM PARTNER</div>
                                <h2 class="outfit fw-900 mb-2">Radisson Blu Plaza Hotel</h2>
                                <p class="text-light fw-600 opacity-75 small">IGI Airport, New Delhi • 120 Units Available</p>
                                <div class="d-flex gap-2 mt-4">
                                     <div class="bg-white rounded-pill text-dark px-3 py-1 fw-900 tiny border-0"><i class="fas fa-check-circle text-success me-1"></i> BOOKING.COM LIVE</div>
                                     <div class="bg-white rounded-pill text-dark px-3 py-1 fw-900 tiny border-0"><i class="fas fa-check-circle text-success me-1"></i> AGODA LIVE</div>
                                </div>
                           </div>
                      </div>

                      <!-- Right Panel: Capability Matrix -->
                      <div class="col-lg-8 bg-white p-5">
                           <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
                                <h4 class="outfit fw-900 text-navy mb-0">Operational Capability Matrix</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                           </div>

                           <div class="row g-5">
                                <!-- Room Breakdown -->
                                <div class="col-md-7">
                                     <h6 class="tiny fw-900 text-muted uppercase ls-1 mb-4">Inventory & Pricing Inventory</h6>
                                     <div class="d-flex flex-column gap-3">
                                          <div class="p-3 bg-light rounded-4 d-flex justify-content-between align-items-center">
                                               <div>
                                                    <div class="fw-900 text-navy mb-1">Deluxe Twin Suite</div>
                                                    <div class="tiny fw-700 text-muted">10 Units • Max 2 Adults</div>
                                               </div>
                                               <div class="fw-900 text-primary">₹8,500 <span class="text-muted tiny fw-700">/ night</span></div>
                                          </div>
                                          <div class="p-3 bg-light rounded-4 d-flex justify-content-between align-items-center opacity-75">
                                               <div>
                                                    <div class="fw-900 text-navy mb-1">Executive Glass Suite</div>
                                                    <div class="tiny fw-700 text-muted">20 Units • Max 3 Adults</div>
                                               </div>
                                               <div class="fw-900 text-primary">₹12,400 <span class="text-muted tiny fw-700">/ night</span></div>
                                          </div>
                                     </div>
                                </div>

                                <!-- Meal Plans & Add-ons -->
                                <div class="col-md-5 border-start">
                                     <h6 class="tiny fw-900 text-muted uppercase ls-1 mb-4">Provisioned Meal Plans</h6>
                                     <div class="d-flex gap-2 flex-wrap mb-5">
                                          <span class="badge bg-success-light text-success fw-900 px-3 py-2 rounded-pill border-0"><i class="fas fa-utensils me-2"></i> CP (Breakfast)</span>
                                          <span class="badge bg-primary-light text-primary fw-900 px-3 py-2 rounded-pill border-0"><i class="fas fa-bowl-food me-2"></i> MAP (Dinner)</span>
                                          <span class="badge bg-light text-muted fw-900 px-3 py-2 rounded-pill border-0 opacity-50"><i class="fas fa-kitchen-set me-2"></i> AP (Full Board)</span>
                                     </div>

                                     <h6 class="tiny fw-900 text-muted uppercase ls-1 mb-4">Core Amenities Included</h6>
                                     <div class="row g-2">
                                          @foreach(['High-Speed WiFi', 'Infinity Pool', '24h Spa', 'Gym', 'Business Hub'] as $f)
                                          <div class="col-6"><div class="small fw-700 text-navy"><i class="fas fa-check-circle text-primary me-1" style="font-size: 10px;"></i> {{ $f }}</div></div>
                                          @endforeach
                                     </div>
                                </div>
                           </div>

                           <div class="mt-5 pt-4 border-top d-flex gap-3">
                                <button class="btn btn-light px-5 py-3 rounded-pill fw-800 border-0 w-50" data-bs-dismiss="modal">CLOSE SHOWCASE</button>
                                <button class="btn ps-btn-primary px-5 py-3 rounded-pill fw-800 border-0 w-50 shadow-lg">GO TO PROPERTY DASHBOARD</button>
                           </div>
                      </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection

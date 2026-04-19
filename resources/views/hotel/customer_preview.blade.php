@extends('layouts.hotel_master')

@section('title', 'Public Portal Preview | B2C Experience')

@section('styles')
<style>
    .b2c-portal-card { background: #fff; border-radius: 32px; border: 1px solid var(--ps-border); overflow: hidden; }
    .b2c-hero { height: 400px; background-size: cover; background-position: center; position: relative; }
    .b2c-hero-overlay { position: absolute; bottom: 0; left: 0; right: 0; padding: 50px; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); color: #fff; }
    
    .b2c-service-card { border-radius: 20px; border: 1px solid #f1f5f9; padding: 20px; transition: 0.2s; cursor: pointer; }
    .b2c-service-card:hover { border-color: #6366f1; background: #f8fafc; }
    
    .b2c-price-tag { font-size: 24px; font-weight: 900; color: #1e293b; }
    .b2c-sidebar-bill { position: sticky; top: 100px; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Your Public Facing Portal</h2>
        <p class="text-muted fw-600 mb-0">This is exactly how your property and ancillary services (Guides/Cars) appear to your end-customers.</p>
    </div>
    <div class="badge bg-primary px-3 py-2 rounded-pill fw-800 ls-1 border-0">LIVE B2C VIEW</div>
</div>

<div class="b2c-portal-card border-0 shadow-lg mb-5">
     <!-- 1. Customer Hero Section -->
     <div class="b2c-hero" style="background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&q=80&w=1200');">
          <div class="b2c-hero-overlay">
               <h1 class="outfit fw-900 mb-2">Radisson Blu Plaza New Delhi</h1>
               <p class="fw-700 h5 opacity-75 mb-0">Premium Business Luxury near IGI International Airport</p>
          </div>
     </div>

     <div class="p-5">
          <div class="row g-5">
               <!-- 2. Reservation Choices -->
               <div class="col-lg-8">
                    <h4 class="outfit fw-900 text-navy mb-4">Select Your Room Experience</h4>
                    <div class="d-flex flex-column gap-3 mb-5">
                         <div class="p-4 border rounded-4 d-flex justify-content-between align-items-center">
                              <div>
                                   <div class="fw-900 text-navy mb-1">Deluxe Twin Garden Suite</div>
                                   <div class="small text-muted fw-700">Breakfast Included • Free Cancellation</div>
                              </div>
                              <div class="text-end">
                                   <div class="b2c-price-tag">₹8,500 <span class="small opacity-50" style="font-size: 14px;">/ Night</span></div>
                                   <button class="btn btn-dark opacity-25 px-4 rounded-pill fw-900 small mt-2 disabled">SELECTED</button>
                              </div>
                         </div>
                    </div>

                    <!-- 3. Dynamic Ancillary Marketplace -->
                    <h4 class="outfit fw-900 text-navy mt-5 mb-4">Elevate Your Stay (Direct Add-ons)</h4>
                    <p class="text-muted fw-700 small mb-4">These services are powered by your Super Panel Partners.</p>
                    <div class="row g-4">
                         <!-- Guide Service Add-on -->
                         <div class="col-md-6">
                              <div class="b2c-service-card shadow-sm h-100 d-flex flex-column" data-bs-toggle="modal" data-bs-target="#guideAddonModal">
                                   <div class="d-flex gap-3 align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary"><i class="fas fa-microphone-lines"></i></div>
                                        <div class="fw-900 text-navy">Verified Local Guide</div>
                                   </div>
                                   <p class="tiny fw-700 text-muted mb-4 flex-grow-1">Personalized Heritage & Food Walks led by certified storytellers.</p>
                                   <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light border-opacity-10">
                                        <span class="fw-900 text-primary small">+ ₹3,500 / Day</span>
                                        <span class="tiny fw-800 text-primary uppercase">View Portfolio <i class="fas fa-chevron-right ms-1"></i></span>
                                   </div>
                              </div>
                         </div>
                         <!-- Car Service Add-on -->
                         <div class="col-md-6">
                              <div class="b2c-service-card shadow-sm h-100 d-flex flex-column" data-bs-toggle="modal" data-bs-target="#carAddonModal">
                                   <div class="d-flex gap-3 align-items-center mb-3">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success"><i class="fas fa-car-side"></i></div>
                                        <div class="fw-900 text-navy">Airport Pickup & Drop</div>
                                   </div>
                                   <p class="tiny fw-700 text-muted mb-4 flex-grow-1">Hassle-free 24/7 transfers from IGI airport directly to the hotel lobby.</p>
                                   <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light border-opacity-10">
                                        <span class="fw-900 text-primary small">+ ₹1,200 / Trip</span>
                                        <span class="tiny fw-800 text-success uppercase">View Vehicle <i class="fas fa-chevron-right ms-1"></i></span>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <!-- 4. Dynamic Customer Bill / Summary -->
               <div class="col-lg-4">
                    <div class="b2c-sidebar-bill p-5 bg-light rounded-5 border-0 shadow-sm">
                         <h5 class="outfit fw-900 text-navy mb-4">Reservation Summary</h5>
                         <div class="d-flex justify-content-between mb-3 small fw-700">
                              <span class="text-muted">Room Night x 1</span>
                              <span class="text-navy">₹8,500.00</span>
                         </div>
                         <div class="d-flex justify-content-between mb-3 small fw-700 opaicty-50">
                              <span class="text-muted">Ancillary Services</span>
                              <span class="text-navy">₹0.00</span>
                         </div>
                         <div class="d-flex justify-content-between mb-4 pb-4 border-bottom small fw-700">
                              <span class="text-muted">Taxes & GST (12%)</span>
                              <span class="text-navy">₹1,020.00</span>
                         </div>
                         <div class="d-flex justify-content-between mb-5">
                              <span class="fw-900 text-navy outfit h5 mb-0">Total Payable</span>
                              <span class="fw-900 text-primary outfit h4 mb-0">₹9,520.00</span>
                         </div>
                         <button class="btn btn-dark w-100 py-3 rounded-pill fw-900 border-0 shadow-lg" onclick="alert('Booking Finalized! Our Automation Engine is now generating your vouchers and syncing inventory...')">CONFIRM & BOOK NOW</button>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="alert alert-primary border-0 rounded-4 p-4 mb-4 text-center">
     <h6 class="outfit fw-900 text-navy mb-1"><i class="fas fa-link me-1"></i> Public URL Integration</h6>
     <p class="small fw-700 text-muted mb-0">You can link this portal directly to your "Official Website" book button. Every booking here is 0% commission!</p>
</div>

<!-- B2C GUIDE DETAIL MODAL -->
<div class="modal fade" id="guideAddonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:32px; overflow: hidden;">
            <div class="modal-body p-0">
                 <div class="row g-0">
                      <div class="col-md-5 bg-light d-flex flex-column" style="min-height: 400px; background-image: url('https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=400'); background-size: cover; background-position: center;"></div>
                      <div class="col-md-7 p-5">
                           <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="outfit fw-900 text-navy mb-0">Local Expert Portfolio</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                           </div>
                           <div class="badge bg-warning text-dark tiny fw-900 px-3 py-1 rounded-pill mb-3">MINISTRY CERTIFIED</div>
                           <h5 class="outfit fw-900 text-navy mb-2">Aaliya Khan</h5>
                           <p class="small text-muted fw-700 mb-4 lh-lg">Certified in Heritage conservation, Aaliya offers immersive story-led walks through the Mughal relics of Old Delhi.</p>
                           
                           <div class="row g-3 mb-5">
                                <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Expertise</div><div class="small fw-900 text-navy">Mughal History</div></div>
                                <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Duration</div><div class="small fw-900 text-navy">4-6 Hours</div></div>
                           </div>

                           <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 border-0 shadow-lg" style="background:#2563eb;" data-bs-dismiss="modal" onclick="alert('Guide added to your trip summary!')">ADD TO TRIP (+₹3,500)</button>
                      </div>
                 </div>
            </div>
        </div>
    </div>
</div>

<!-- B2C CAR DETAIL MODAL -->
<div class="modal fade" id="carAddonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:32px; overflow: hidden;">
            <div class="modal-body p-0">
                 <div class="row g-0">
                      <div class="col-md-5 bg-light d-flex flex-column" style="min-height: 400px; background-image: url('https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=400'); background-size: cover; background-position: center;"></div>
                      <div class="col-md-7 p-5">
                           <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="outfit fw-900 text-navy mb-0">Vehicle Specifications</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                           </div>
                           <div class="badge bg-success text-white tiny fw-900 px-3 py-1 rounded-pill mb-3">PREMIUM SEDAN</div>
                           <h5 class="outfit fw-900 text-navy mb-2">Toyota Altis / Similar</h5>
                           <p class="small text-muted fw-700 mb-4 lh-lg">Comfortable air-conditioned sedan with professional chauffeur. Includes fuel, taxes, and luggage handling.</p>
                           
                           <div class="row g-3 mb-5">
                                <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Capacity</div><div class="small fw-900 text-navy">4 Adults + 3 Bags</div></div>
                                <div class="col-6"><div class="tiny fw-800 text-muted uppercase">Service</div><div class="small fw-900 text-navy">Airport (IGI) -> Hotel</div></div>
                           </div>

                           <button class="btn btn-success w-100 py-3 rounded-pill fw-900 border-0 shadow-lg" data-bs-dismiss="modal" onclick="alert('Airport Transfer added to your trip summary!')">ADD TO TRIP (+₹1,200)</button>
                      </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection

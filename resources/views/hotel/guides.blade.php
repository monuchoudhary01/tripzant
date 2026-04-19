@extends('layouts.hotel_master')

@section('title', 'Certified Local Guides | Partner Super Panel')

@section('styles')
<style>
    .ps-guide-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 25px; margin-bottom: 25px; transition: 0.2s; position: relative; }
    .ps-guide-card:hover { border-color: var(--ps-accent); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .ps-guide-avatar { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin-bottom: 15px; border: 3px solid #f1f5f9; position: relative; }
    .ps-star-chip { background: #fffbeb; color: #b45309; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px; border: 1px solid #fef3c7; display: inline-flex; align-items: center; gap: 4px; }
    .ps-tour-tag { font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; margin-right: 5px; margin-bottom: 5px; display: inline-block; }
    
    /* Process Simulation Chat Styles */
    .ps-chat-bubble { max-width: 80%; padding: 12px 18px; border-radius: 12px; margin-bottom: 12px; font-size: 13px; font-weight: 700; line-height: 1.5; }
    .ps-chat-left { background: #f1f5f9; color: #1e293b; align-self: flex-start; border-bottom-left-radius: 0; }
    .ps-chat-right { background: #eef2ff; color: #6366f1; align-self: flex-end; border-bottom-right-radius: 0; margin-left: auto; text-align: right; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Local Guidance & Storytelling</h2>
        <p class="text-muted fw-600 mb-0">Book certified local experts for personalized guest tours and heritage walks.</p>
    </div>
    <div class="d-flex gap-2">
         <select class="form-select border-0 px-4 py-2 rounded-pill fw-800 small ps-3">
             <option>LANGUAGE: ENGLISH</option>
             <option>LANGUAGE: GERMAN</option>
         </select>
    </div>
</div>

<div class="row g-5">
    <div class="col-lg-7">
        <h6 class="tiny fw-900 text-muted uppercase ls-1 mb-4">Certified Local Experts (Available)</h6>
        
        <!-- Guide 1 -->
        <div class="ps-guide-card">
              <div class="d-flex align-items-start gap-4">
                   <div class="text-center">
                        <div class="ps-guide-avatar">
                             <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=200" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="badge bg-warning text-dark tiny fw-900 px-2 py-1 rounded">PLATINUM GUIDE</div>
                   </div>
                   <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                             <div class="d-flex align-items-center gap-3">
                                  <h5 class="outfit fw-900 text-navy mb-0">Aaliya Khan</h5>
                                  <div class="ps-star-chip"><i class="fas fa-star small"></i> 4.9 <span class="text-muted" style="font-size: 9px;">(122 Reviews)</span></div>
                             </div>
                             <div class="fw-900 text-navy outfit">₹3,500 / Day</div>
                        </div>
                        <div class="tiny fw-800 text-primary mb-3">EXPERTISE: HERITAGE & ARCHAEOLOGY • ENG/HIN/FRE</div>
                        <p class="text-muted small fw-600 mb-4">Certified by Ministry of Tourism. Specializes in Mughal history, Chandni Chowk food walks, and Qutub Minar storytelling.</p>
                        
                        <div class="mb-4">
                             <div class="tiny fw-900 uppercase text-muted mb-2 ls-1">Tour Portfolio (Recommended Services)</div>
                             <div class="ps-tour-tag">Old Delhi Night Walk</div>
                             <div class="ps-tour-tag">Chandni Chowk Foodie Trail</div>
                             <div class="ps-tour-tag">Qutub Minar Deep-Dive</div>
                             <div class="ps-tour-tag">UNESCO Site Special</div>
                        </div>

                        <div class="d-flex gap-2">
                             <button class="btn btn-dark rounded-pill px-4 tiny fw-800 border-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#guideProfileModal">VIEW FULL PROFILE</button>
                             <button class="btn btn-outline-dark rounded-pill px-4 tiny fw-800 border-2" data-bs-toggle="modal" data-bs-target="#chatGuideModal">MESSAGE GUIDE</button>
                             <button class="ps-btn-primary rounded-pill px-4 tiny fw-800 border-0 shadow-sm">BOOK FOR GUEST</button>
                        </div>
                   </div>
              </div>
        </div>

        <!-- Guide 2 -->
        <div class="ps-guide-card">
              <div class="d-flex align-items-start gap-4">
                   <div class="text-center">
                        <div class="ps-guide-avatar">
                             <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=200" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="badge bg-info text-white tiny fw-900 px-2 py-1 rounded">GOLD GUIDE</div>
                   </div>
                   <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                             <div class="d-flex align-items-center gap-3">
                                  <h5 class="outfit fw-900 text-navy mb-0">Rajiv Malhotra</h5>
                                  <div class="ps-star-chip"><i class="fas fa-star small"></i> 4.7 <span class="text-muted" style="font-size: 9px;">(85 Reviews)</span></div>
                             </div>
                             <div class="fw-900 text-navy outfit">₹2,800 / Day</div>
                        </div>
                        <div class="tiny fw-800 text-primary mb-3">EXPERTISE: ARCHITECTURE & MODERN DELHI • ENG/GER/ITA</div>
                        <p class="text-muted small fw-600 mb-4">Focuses on Lutyens' Delhi stories, Museum visits, and Art Gallery tours for European tourists.</p>
                        
                        <div class="mb-4">
                             <div class="tiny fw-900 uppercase text-muted mb-2 ls-1">Tour Portfolio (Recommended Services)</div>
                             <div class="ps-tour-tag">Lutyens' Delhi Cycle Tour</div>
                             <div class="ps-tour-tag">National Museum Walk</div>
                             <div class="ps-tour-tag">Contemporary Art Circuit</div>
                        </div>

                        <div class="d-flex gap-2">
                             <button class="btn btn-dark rounded-pill px-4 tiny fw-800 border-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#guideServiceModal">VIEW ALL SERVICES</button>
                             <button class="btn btn-outline-dark rounded-pill px-4 tiny fw-800 border-2">MESSAGE GUIDE</button>
                             <button class="ps-btn-primary rounded-pill px-4 tiny fw-800 border-0 shadow-sm">BOOK FOR GUEST</button>
                        </div>
                   </div>
              </div>
        </div>
    </div>

    <!-- Process Flow Simulation Card -->
    <div class="col-lg-5">
        <div class="bg-white rounded-4 border border-faint p-5 h-100 shadow-sm">
             <h6 class="tiny fw-900 text-navy uppercase ls-1 mb-4 border-bottom pb-3">How the Guide-Hotel Process Works</h6>
             
             <div class="d-flex flex-column mb-5">
                  <div class="ps-chat-bubble ps-chat-left">
                       <div class="tiny uppercase opacity-50 mb-1">Hotel Manager (You)</div>
                       "Hi Aaliya! We have a French couple (Room 405) who want a 4-hour heritage walk tomorrow morning. Is it possible?"
                  </div>
                  <div class="ps-chat-bubble ps-chat-right">
                       <div class="tiny uppercase opacity-50 mb-1">Guide: Aaliya Khan</div>
                       "Hello! Yes, I'm available at 9 AM tomorrow. I can do the Old Delhi walk in French. Should I bring a car or rickshaw?"
                  </div>
                  <div class="ps-chat-bubble ps-chat-left">
                       <div class="tiny uppercase opacity-50 mb-1">Hotel Manager (You)</div>
                       "Great! Rickshaw should be fine. I'll confirm the booking and send the voucher to the guest. Rickshaw charge will be extra, right?"
                  </div>
                  <div class="ps-chat-bubble ps-chat-right">
                       <div class="tiny uppercase opacity-50 mb-1">Guide: Aaliya Khan</div>
                       "Yes, Rickshaws are usually ₹500 extra. I'll meet them in the lobby at 9 AM sharply."
                  </div>
             </div>

             <div class="alert alert-primary border-0 rounded-4 p-4 mb-0">
                  <h6 class="tiny fw-900 uppercase mb-2">Automated Next Step</h6>
                  <p class="small fw-700 text-muted mb-0">Once you click **BOOK**, our system automatically sends the Guide's profile & Phone number to the guest's WhatsApp.</p>
             </div>
        </div>
    </div>
</div>

<!-- CHAT MODAL (SIMULTAION) -->
<div class="modal fade" id="chatGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;">
            <div class="modal-body p-5">
                 <h5 class="outfit fw-900 text-navy mb-4">Start Local Coordination</h5>
                 <textarea class="form-control border-0 bg-light py-3 fw-700 mb-4" rows="4" placeholder="Briefly explain Guest's requirement (Language, Dates, Pickup location)..."></textarea>
                 <button class="btn btn-primary w-100 py-3 rounded-pill fw-900 border-0 shadow-sm" style="background:#2563eb;" data-bs-dismiss="modal" onclick="alert('Message sent to Aaliya! You will receive an instant reply in your Business Terminal.')">TRIGGER COORDINATION CHAT</button>
            </div>
        </div>
    </div>
</div>

<!-- GUIDE EXPERT PROFILE MODAL -->
<div class="modal fade" id="guideProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:32px;">
            <div class="modal-header border-0 p-5 pb-0">
                 <h4 class="modal-title outfit fw-900 text-navy">Expert Profile & Certification</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5 pt-4">
                 <div class="row g-4 mb-5">
                      <div class="col-md-4">
                           <div class="rounded-4 overflow-hidden border-2 border-primary border">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=400" class="w-100 h-100 object-fit-cover" style="aspect-ratio: 1/1;">
                           </div>
                      </div>
                      <div class="col-md-8">
                           <div class="badge bg-warning-light text-warning fw-900 px-3 py-2 rounded-pill mb-3" style="font-size: 10px; border: 1px solid rgba(245, 158, 11, 0.2);"><i class="fas fa-certificate me-2"></i> MINISTRY OF TOURISM CERTIFIED</div>
                           <h3 class="outfit fw-900 text-navy mb-2">Aaliya Khan</h3>
                           <p class="text-muted fw-700 small mb-0 lh-lg">"I believe history is not found in books, but in the streets of Old Delhi. My mission is to tell the untold stories of the Mughal era while exploring the culinary heritage that defines us."</p>
                      </div>
                 </div>

                 <div class="row g-4 mb-5">
                      <div class="col-6">
                           <h6 class="tiny fw-900 uppercase text-muted mb-3 ls-1">Professional Expertise</h6>
                           <div class="d-flex flex-column gap-2">
                                <div class="small fw-800 text-navy"><i class="fas fa-check text-success me-2"></i> Mughal Heritage Storytelling</div>
                                <div class="small fw-800 text-navy"><i class="fas fa-check text-success me-2"></i> Culinary History & Street Food Walks</div>
                                <div class="small fw-800 text-navy"><i class="fas fa-check text-success me-2"></i> Archaeological Site Navigation</div>
                           </div>
                      </div>
                      <div class="col-6">
                           <h6 class="tiny fw-900 uppercase text-muted mb-3 ls-1">Language Proficiency</h6>
                           <div class="d-flex flex-column gap-2">
                                <div class="small fw-800 text-navy"><i class="fas fa-language text-primary me-2"></i> English (Native/Fluent)</div>
                                <div class="small fw-800 text-navy"><i class="fas fa-language text-primary me-2"></i> French (Certified B2 level)</div>
                                <div class="small fw-800 text-navy"><i class="fas fa-language text-primary me-2"></i> Hindi & Urdu (Local Expert)</div>
                           </div>
                      </div>
                 </div>

                 <div class="bg-light p-4 rounded-4 border-0">
                      <h6 class="tiny fw-900 uppercase text-muted mb-3 ls-1 text-center">Guide Accreditation History</h6>
                      <div class="d-flex justify-content-around text-center">
                           <div><div class="h5 fw-900 text-navy mb-0">8+ Years</div><div class="tiny fw-800 text-muted opacity-50 uppercase">Experience</div></div>
                           <div class="border-start ps-4"><div class="h5 fw-900 text-navy mb-0">1,200+</div><div class="tiny fw-800 text-muted opacity-50 uppercase">Guests Served</div></div>
                           <div class="border-start ps-4"><div class="h5 fw-900 text-navy mb-0">4.9/5</div><div class="tiny fw-800 text-muted opacity-50 uppercase">Trust Rating</div></div>
                      </div>
                 </div>
            </div>
            <div class="modal-footer border-0 p-5 pt-0">
                 <button class="btn btn-outline-dark px-4 py-3 rounded-pill fw-800 border-2 w-50" data-bs-dismiss="modal">CLOSE PROFILE</button>
                 <button class="btn ps-btn-primary px-4 py-3 rounded-pill fw-800 border-0 w-50 shadow-lg">BOOK THIS EXPERT</button>
            </div>
        </div>
    </div>
</div>
@endsection

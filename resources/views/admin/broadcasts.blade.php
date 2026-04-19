@extends('layouts.admin')

@section('title', 'System Broadcast & Communications | Master Admin')

@section('admin_content')
<div class="row g-4 mb-5">
    <div class="col-xl-9">
        <div class="card-admin shadow-sm border-0 p-5">
            <h4 class="fw-900 text-navy mb-5 border-bottom pb-4">Create New Communication Broadcast</h4>

            <!-- Tab Switcher -->
            <ul class="nav nav-pills mb-5 bg-light p-2 rounded-pill d-inline-flex gap-2" id="broadcastTabs">
                <li class="nav-item">
                    <button class="nav-link active px-5 py-3 rounded-pill fw-bold" data-bs-toggle="pill" data-bs-target="#emailTabContent" type="button"><i class="fas fa-envelope me-2"></i> SMTP Email Campaign</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link px-5 py-3 rounded-pill fw-bold" data-bs-toggle="pill" data-bs-target="#smsTabContent" type="button"><i class="fas fa-comment-sms me-2"></i> SMS / Push Alerts</button>
                </li>
            </ul>

            <div class="tab-content mt-5">
                <!-- Platform Selection Grid -->
                <div class="row g-4 mb-5" id="platformSelector">
                    <div class="col-md-4">
                        <div class="p-4 bg-white rounded-5 shadow-sm border text-center hvr-grow cursor-pointer platform-card" data-platform="whatsapp">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;"><i class="fab fa-whatsapp fs-4"></i></div>
                            <h6 class="fw-900 text-navy mb-1 leading-relaxed">WhatsApp Business</h6>
                            <p class="text-muted smaller mb-0">98% Open Rate</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 bg-white rounded-5 shadow-sm border text-center hvr-grow cursor-pointer platform-card" data-platform="telegram">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;background:#0088cc !important;"><i class="fab fa-telegram-plane fs-4"></i></div>
                            <h6 class="fw-900 text-navy mb-1 leading-relaxed">Telegram News</h6>
                            <p class="text-muted smaller mb-0">Bot & Channel</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 bg-white rounded-5 shadow-sm border text-center hvr-grow cursor-pointer platform-card" data-platform="email">
                            <div class="bg-navy text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;"><i class="fas fa-envelope fs-4"></i></div>
                            <h6 class="fw-900 text-navy mb-1 leading-relaxed">SMTP Email Hub</h6>
                            <p class="text-muted smaller mb-0">Bulk Campaigns</p>
                        </div>
                    </div>
                </div>

                <!-- DYNAMIC FORMS (Controlled via JS) -->
                <div id="formsContainer">
                    <!-- WHATSAPP FORM -->
                    <div class="broadcast-form d-none" id="whatsappForm">
                         <div class="bg-light p-5 rounded-5 border-start border-5 border-success position-relative">
                             <span class="badge bg-success text-white rounded-pill px-4 py-2 position-absolute top-0 end-0 m-4 fw-bold">WHATSAPP ACTIVE</span>
                             <h4 class="fw-900 text-navy mb-5">Configure WhatsApp Template Message</h4>
                             <form>
                                 <div class="row g-4">
                                     <div class="col-md-12 mb-4">
                                         <label class="form-label fw-800 small text-uppercase opacity-75">Template Selector</label>
                                         <select class="form-select px-4 py-3 rounded-pill border-light bg-white fw-bold shadow-sm">
                                             <option>Trip_Start_Announcement (Approved)</option>
                                             <option>Partner_Signup_Welcome (Approved)</option>
                                         </select>
                                     </div>
                                     <div class="col-md-6 mb-4">
                                          <label class="form-label fw-800 small text-uppercase opacity-75">Phone Number Batch</label>
                                          <input type="text" class="form-control px-4 py-3 rounded-pill bg-white shadow-sm" placeholder="Country Code + No.">
                                     </div>
                                     <div class="col-12 mt-4 pt-4 border-top">
                                          <button type="submit" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-lg"><i class="fab fa-whatsapp me-2"></i> Deploy WhatsApp Template</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                    </div>

                    <!-- TELEGRAM FORM -->
                    <div class="broadcast-form d-none" id="telegramForm">
                         <div class="bg-light p-5 rounded-5 border-start border-5 border-primary position-relative" style="border-left-color: #0088cc !important;">
                             <span class="badge bg-primary text-white rounded-pill px-4 py-2 position-absolute top-0 end-0 m-4 fw-bold" style="background:#0088cc !important;">TELEGRAM BOT</span>
                             <h4 class="fw-900 text-navy mb-5">Broadcast to Telegram Channel</h4>
                             <form>
                                 <div class="row g-4">
                                     <div class="col-12 mb-4">
                                          <label class="form-label fw-800 small text-uppercase opacity-75">Official Bot Message</label>
                                          <textarea class="form-control bg-white border-light p-5 rounded-5 fw-bold" style="min-height: 200px;" placeholder="Markdown supported: *Bold Text*, _Italics_..."></textarea>
                                     </div>
                                     <div class="col-12 mt-4 pt-4 border-top">
                                          <button type="submit" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-lg" style="background:#0088cc !important;"><i class="fab fa-telegram-plane me-2"></i> Send to Misty Bot</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                    </div>

                    <!-- EMAIL FORM -->
                    <div class="broadcast-form d-none" id="emailForm">
                         <div class="bg-light p-5 rounded-5 border-start border-5 border-navy position-relative">
                             <span class="badge bg-navy text-white rounded-pill px-4 py-2 position-absolute top-0 end-0 m-4 fw-bold">SMTP STATUS: READY</span>
                             <h4 class="fw-900 text-navy mb-5">Deploy Super Admin Email Campaign</h4>
                             <form>
                                 <div class="row g-4">
                                     <div class="col-md-12 mb-4">
                                         <label class="form-label fw-800 small text-uppercase opacity-75">Campaign Subject Line</label>
                                         <input type="text" class="form-control px-4 py-3 rounded-pill bg-white shadow-sm" placeholder="e.g. Major Platform Update 2026">
                                     </div>
                                     <div class="col-12 mb-4">
                                          <label class="form-label fw-800 small text-uppercase opacity-75">HTML Body Content</label>
                                          <div class="bg-white p-5 rounded-5 shadow-sm border" style="min-height: 350px;">
                                               <p class="mb-4">Hello Traveler,</p>
                                               <p class="mb-0">Welcome to Trip Zant Booking...</p>
                                          </div>
                                     </div>
                                     <div class="col-12 mt-4 pt-4 border-top">
                                          <button type="submit" class="btn btn-navy px-5 py-3 rounded-pill fw-bold shadow-lg"><i class="fas fa-paper-plane me-2"></i> Execute Mass Mailout</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                    </div>
                </div>

                <div id="emptyFormMessage" class="text-center py-5">
                     <i class="fas fa-mouse-pointer text-navy fs-1 mb-4 opacity-50"></i>
                     <h5 class="fw-900 text-navy">Please select a platform above to start broadcasting</h5>
                     <p class="text-muted small">Each platform has its own unique protocol requirements.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Live Stats -->
    <div class="col-xl-3">
        <div class="card-admin shadow-sm border-0 p-5 mb-4 text-center bg-navy text-white">
             <i class="fas fa-chart-line fs-1 mb-4 opacity-50"></i>
             <h6 class="fw-900 mb-2">Campaign Performance</h6>
             <p class="text-white-50 smaller mb-5">Open rates & CTR across platform communication.</p>
             
             <div class="row g-2 text-center">
                 <div class="col-6 mb-3">
                     <h5 class="fw-900 mb-0">98.2%</h5>
                     <span class="opacity-50 small fw-bold">DELIVERY</span>
                 </div>
                 <div class="col-6 mb-3">
                     <h5 class="fw-900 mb-0">14.5%</h5>
                     <span class="opacity-50 small fw-bold">OPEN RATE</span>
                 </div>
             </div>
        </div>

        <div class="card-admin shadow-sm border-0 p-5">
             <h6 class="fw-900 text-navy mb-4">Latest Logs</h6>
             <div class="d-flex flex-column gap-3">
                 <div class="p-3 bg-light rounded-4 border-start border-4 border-success">
                     <p class="small fw-800 text-navy mb-1 leading-relaxed">WA Template: #BK-91</p>
                     <span class="text-muted smaller">Approved · 2h ago</span>
                 </div>
                 <div class="p-3 bg-light rounded-4 border-start border-4 border-primary" style="border-left-color: #0088cc !important;">
                     <p class="small fw-800 text-navy mb-1 leading-relaxed">TG Alert: Live Now</p>
                     <span class="text-muted smaller">Broadcasting · 5h ago</span>
                 </div>
             </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const platformCards = document.querySelectorAll('.platform-card');
        const forms = {
            whatsapp: document.getElementById('whatsappForm'),
            telegram: document.getElementById('telegramForm'),
            email: document.getElementById('emailForm')
        };
        const emptyMessage = document.getElementById('emptyFormMessage');

        platformCards.forEach(card => {
            card.addEventListener('click', function() {
                const platform = this.getAttribute('data-platform');
                
                // Reset Selection
                platformCards.forEach(pc => pc.classList.remove('bg-navy', 'text-white'));
                platformCards.forEach(pc => pc.classList.add('bg-white', 'text-navy'));
                
                // Set Active Card
                this.classList.remove('bg-white', 'text-navy');
                this.classList.add('bg-navy', 'text-white');
                this.querySelector('h6').classList.remove('text-navy');
                this.querySelector('h6').classList.add('text-white');

                // Toggle Forms
                Object.values(forms).forEach(f => f.classList.add('d-none'));
                forms[platform].classList.remove('d-none');
                emptyMessage.classList.add('d-none');
            });
        });
    });
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    .bg-navy-light { background: rgba(11, 61, 97, 0.05); }
    .nav-pills .nav-link { color: var(--admin-text-light); transition: all 0.2s; }
    .nav-pills .nav-link.active { background: var(--admin-primary) !important; color: #fff !important; box-shadow: 0 4px 6px -1px rgba(11, 61, 97, 0.2); }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

@extends('layouts.app')

@section('title', "My Hotel Requests — Tripzant B2B Portal")

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 100vh;">
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-end mb-4 animate-up">
            <div>
                <h2 class="fw-900 text-navy mb-1" style="font-size:32px; letter-spacing:-1px;">My Hotel Requests</h2>
                <p class="text-muted mb-0 fw-600">Track and manage your hotel quotations here.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/hotels" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-plus me-2"></i> NEW REQUEST</a>
                <button class="btn btn-white border rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-filter me-2"></i> FILTER</button>
            </div>
        </div>

        <!-- Requests Summary Cards -->
        <div class="row g-4 mb-5 animate-up" style="animation-delay: 0.1s;">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4"><i class="fas fa-envelope-open-text fs-4"></i></div>
                    <div>
                        <h3 class="fw-900 mb-0">12</h3>
                        <span class="small text-muted fw-bold">TOTAL REQUESTS</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3">
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-4"><i class="fas fa-clock fs-4"></i></div>
                    <div>
                        <h3 class="fw-900 mb-0">4</h3>
                        <span class="small text-muted fw-bold">PENDING</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3" style="border-bottom: 3px solid #27ae60 !important;">
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-4"><i class="fas fa-check-double fs-4"></i></div>
                    <div>
                        <h3 class="fw-900 mb-0">6</h3>
                        <span class="small text-muted fw-bold">QUOTED</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3">
                    <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-4"><i class="fas fa-ban fs-4"></i></div>
                    <div>
                        <h3 class="fw-900 mb-0">2</h3>
                        <span class="small text-muted fw-bold">REJECTED</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requests List -->
        <div class="row g-4 animate-up" style="animation-delay: 0.2s;">
            <!-- Request Card 1 (Quoted) -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden request-card transition-03">
                    <div class="card-body p-4">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-2 text-center text-lg-start">
                                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold mb-3 d-inline-block border border-success border-opacity-25"><i class="fas fa-check-circle me-1 small"></i> QUOTED</div>
                                <h6 class="small text-muted fw-bold text-uppercase mb-1" style="font-size:10px;">Request ID</h6>
                                <span class="fw-800 text-navy">#HQT-8241</span>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                   <div class="hotel-sq-img rounded-3 overflow-hidden shadow-sm" style="width: 60px; height: 60px;">
                                       <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=100&auto=format&fit=crop&q=80" class="h-100 w-100" style="object-fit:cover;">
                                   </div>
                                   <div>
                                       <h6 class="fw-900 text-navy mb-0">Taj Exotica Resort & Spa</h6>
                                       <p class="small text-muted mb-0 fw-600"><i class="fas fa-map-marker-alt text-danger me-1"></i> South Goa</p>
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-3 border-start ps-lg-4">
                                <div class="d-flex gap-3 align-items-center mb-2">
                                    <div class="text-primary"><i class="fas fa-calendar-alt"></i></div>
                                    <div>
                                        <div class="small fw-800 text-navy">12 Nov – 15 Nov 2025</div>
                                        <div class="x-small text-muted fw-600">3 Nights · 1 Room · 2 Adults</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="text-muted"><i class="fas fa-comment-dots"></i></div>
                                    <div class="x-small text-muted fw-600 italic">"Prefer sea-facing room if available."</div>
                                </div>
                            </div>
                            <div class="col-lg-2 border-start ps-lg-4">
                                <h4 class="fw-900 text-success mb-0" style="font-size:24px;">₹42,500</h4>
                                <span class="badge bg-light text-muted x-small fw-bold px-2 py-1">TOTAL QUOTATION</span>
                            </div>
                            <div class="col-lg-2 text-end">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-navy rounded-pill fw-bold" onclick="showQuoteModal('HQT-8241')">VIEW QUOTE</button>
                                    <button class="btn btn-outline-danger rounded-pill fw-bold py-1 x-small" style="font-size:10px;">REJECT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Card 2 (Pending) -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden request-card transition-03 opacity-75">
                    <div class="card-body p-4">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-2">
                                <div class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 fw-bold mb-3 d-inline-block border border-warning border-opacity-25"><i class="fas fa-clock-o me-1 small"></i> PENDING</div>
                                <h6 class="small text-muted fw-bold text-uppercase mb-1" style="font-size:10px;">Request ID</h6>
                                <span class="fw-800 text-navy">#HQT-8199</span>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                   <div class="hotel-sq-img rounded-3 overflow-hidden shadow-sm" style="width: 60px; height: 60px;">
                                       <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=100&auto=format&fit=crop&q=80" class="h-100 w-100" style="object-fit:cover;">
                                   </div>
                                   <div>
                                       <h6 class="fw-900 text-navy mb-0">Novotel Goa Resort</h6>
                                       <p class="small text-muted mb-0 fw-600"><i class="fas fa-map-marker-alt text-danger me-1"></i> Candolim, Goa</p>
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-3 border-start ps-lg-4">
                                <div class="d-flex gap-3 align-items-center mb-2">
                                    <div class="text-primary"><i class="fas fa-calendar-alt"></i></div>
                                    <div>
                                        <div class="small fw-800 text-navy">20 Dec – 25 Dec 2025</div>
                                        <div class="x-small text-muted fw-600">5 Nights · 2 Rooms · 4 Adults</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 border-start ps-lg-4">
                                <span class="text-muted fw-bold italic small">Waiting for hotel...</span>
                            </div>
                            <div class="col-lg-2 text-end">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-secondary rounded-pill fw-bold disabled">VIEW QUOTE</button>
                                    <button class="btn btn-link text-danger text-decoration-none x-small fw-bold shadow-none p-0 mt-1">CANCEL REQUEST</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quote Viewer Modal -->
<div class="modal fade" id="quoteViewerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 bg-navy text-white p-4">
                <h5 class="modal-title fw-900 mb-0">Quotation #HQT-8241</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="small text-muted fw-bold mb-3 letter-spacing-1">HOTEL QUOTATION DETAILS</h6>
                        <div class="p-3 bg-light rounded-4">
                            <div class="mb-3">
                                <span class="x-small text-muted d-block fw-bold mb-1">ROOM TYPE</span>
                                <span class="fw-800 text-navy fs-6">Premium Garden View (2 Double Beds)</span>
                            </div>
                            <div class="mb-3">
                                <span class="x-small text-muted d-block fw-bold mb-1">INCLUSIONS</span>
                                <div class="d-flex flex-wrap gap-2 mt-1">
                                    <span class="badge bg-white border text-navy x-small fw-bold py-1 px-2"><i class="fas fa-coffee text-warning me-1"></i> Breakfast</span>
                                    <span class="badge bg-white border text-navy x-small fw-bold py-1 px-2"><i class="fas fa-wifi text-primary me-1"></i> High Speed WiFi</span>
                                    <span class="badge bg-white border text-navy x-small fw-bold py-1 px-2"><i class="fas fa-shuttle-van text-success me-1"></i> Airport Transfer</span>
                                </div>
                            </div>
                            <div>
                                <span class="x-small text-muted d-block fw-bold mb-1">HOTEL NOTES</span>
                                <p class="x-small text-navy mb-0 italic">"As requested, we have assigned a high-floor garden view room. Early check-in is subject to availability."</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 border-start">
                        <h6 class="small text-muted fw-bold mb-3 letter-spacing-1">FARE BREAKDOWN</h6>
                        <div class="d-flex justify-content-between mb-2">
                           <span class="small fw-bold text-navy">Base Price (3 Nights)</span>
                           <span class="small fw-800 text-navy">₹36,000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                           <span class="small fw-bold text-navy">GST (18%)</span>
                           <span class="small fw-800 text-navy">₹6,500</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                           <span class="small fw-bold text-navy">Agency Commission</span>
                           <span class="small fw-800 text-success">- ₹3,600 (Net Off)</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                           <span class="fw-900 text-navy h5 mb-0">Total Pay (Net)</span>
                           <span class="fw-900 text-primary h4 mb-0">₹38,900</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-success py-3 rounded-4 fw-bold shadow-sm" onclick="window.location.href='/checkout'">ACCEPT & PAY NOW <i class="fas fa-chevron-right ms-2"></i></button>
                            <button class="btn btn-outline-secondary py-2 rounded-4 fw-bold" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                        <p class="x-small text-center text-muted mt-3 fw-bold"><i class="fas fa-hourglass-start me-1"></i> Quote expires in 24 hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showQuoteModal(id) {
    const modal = new bootstrap.Modal(document.getElementById('quoteViewerModal'));
    modal.show();
}
</script>

<style>
.text-navy { color: #02234b; }
.btn-navy { background: #02234b; color: #fff; }
.btn-navy:hover { background: #001f3f; color: #fff; }
.italic { font-style: italic; }
.request-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
.transition-03 { transition: all 0.3s; }
.letter-spacing-1 { letter-spacing: 1px; }
.x-small { font-size: 11px; }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

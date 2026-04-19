@extends('layouts.b2b_master')

@section('title', 'News & Promos | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">News & Promos</h4>
        <p class="text-muted small mb-0">Stay up-to-date with industry news, special fares, and partner incentives.</p>
    </div>
</div>

<div class="row g-4">
    <!-- General News Section -->
    <div class="col-12">
        <div class="b2b-table-card overflow-hidden">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light" role="button" data-bs-toggle="collapse" href="#generalNews">
                <span class="fw-800 text-primary uppercase fs-13">General News</span>
                <i class="fas fa-chevron-down text-muted tiny"></i>
            </div>
            <div class="collapse show" id="generalNews">
                <div class="card-body p-4 pt-4">
                    <!-- News Item 1 -->
                    <div class="news-item mb-5 pb-5 border-bottom">
                        <h6 class="fw-800 mb-1">Consolidated Travel News 02/04/26</h6>
                        <p class="text-secondary small mb-3">Boost Earnings this April with CZ | Light up your sales with Korean Air</p>
                        <a href="#" class="text-primary fw-700 small text-decoration-none d-block mb-3">Read more</a>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <i class="fas fa-file-pdf text-danger fs-5"></i>
                            <a href="#" class="text-primary small fw-600 text-decoration-none">Consolidated Travel News 02_04_26.pdf</a>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="news-item mb-5 pb-5 border-bottom">
                        <h6 class="fw-800 mb-1">Consolidated Travel News 25/03/26</h6>
                        <p class="text-secondary small mb-3">Register & Ticket via Quiktravel Shopping to get $50<br>Sell Europe & Win Paris with Qantas</p>
                        <a href="#" class="text-primary fw-700 small text-decoration-none d-block mb-3">Read more</a>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <i class="fas fa-file-pdf text-danger fs-5"></i>
                            <a href="#" class="text-primary small fw-600 text-decoration-none">Consolidated Travel News 25_03_26.pdf</a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted mb-2 small">Stay up-to-date with industry news, special fares, CTG incentives, and offers!</p>
                        <a href="#" class="text-primary fw-700 fs-13 text-decoration-none">Sign up now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotions Section -->
    <div class="col-12 mt-4">
        <div class="b2b-table-card overflow-hidden h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light" role="button" data-bs-toggle="collapse" href="#promos">
                <span class="fw-800 text-primary uppercase fs-13">Promotions</span>
                <i class="fas fa-chevron-down text-muted tiny"></i>
            </div>
            <div class="collapse show" id="promos">
                <div class="card-body p-4 pt-4">
                    <div class="promo-banner rounded-4 overflow-hidden position-relative" style="height: 300px; background: linear-gradient(135deg, #091e42 0%, #172b4d 100%);">
                         <div class="p-5 h-100 d-flex flex-column justify-content-center text-white position-relative z-1">
                            <h2 class="outfit fw-800 mb-2">Your Private Fares</h2>
                            <p class="opacity-75 mb-4 max-w-400">Exclusive deals and net-net fares for travel partners. Boost your commission capacity starting today.</p>
                            <div class="d-flex gap-3">
                                <button class="btn btn-primary px-4 fw-800 rounded-pill border-0 shadow-sm">VIEW DEALS</button>
                                <button class="btn btn-outline-light px-4 fw-800 rounded-pill shadow-sm">LEARN MORE</button>
                            </div>
                         </div>
                         <!-- Background Decoration -->
                         <div class="position-absolute end-0 bottom-0 opacity-10 mb-n4 me-n4">
                             <i class="fas fa-plane-departure fa-10x rotate-12"></i>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-13 { font-size: 13px; }
    .max-w-400 { max-width: 400px; }
    .ls-1 { letter-spacing: 1px; }
    .tiny { font-size: 11px !important; }
    .hover-translate-right:hover { transform: translateX(5px); }
</style>
@endsection

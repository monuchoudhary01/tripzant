<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TripZant.com — Book flights, hotels, homestays, cabs & train tickets at best prices. Your complete travel partner.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "TripZant.com — Your Travel Starts Here")</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/main.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --navy: #002f55;
            --primary: #0076f7;
            --orange: #ff8c00;
            --header-height: 85px;
        }
        .btn-navy { background: var(--navy); color: #fff; }
        .btn-navy:hover { background: #001f3a; color: #fff; }
        .text-navy { color: var(--navy) !important; }
        .fw-900 { font-weight: 900 !important; }
        .x-small { font-size: 10px; }
        
        #siteHeader {
            height: var(--header-height);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            align-items: center;
        }
        #siteHeader.scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            height: 75px;
        }
        
        /* Button Fixes */
        .btn-partner {
            height: 42px;
            border: 2px solid var(--primary) !important;
            color: var(--primary) !important;
            font-size: 10.5px !important;
            letter-spacing: 0.5px;
            padding: 0 20px !important;
            transition: all 0.3s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-partner:hover {
            background-color: var(--primary) !important;
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(0, 118, 247, 0.25);
        }
        
        .btn-login-header {
            height: 42px;
            background: linear-gradient(135deg, #0076f7 0%, #0056b3 100%);
            border: none;
            color: #fff !important;
            font-size: 10.5px !important;
            letter-spacing: 0.5px;
            padding: 0 20px !important;
            transition: all 0.3s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-login-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 118, 247, 0.3);
            color: #fff !important;
        }

        main { padding-top: 5px; }

        /* Modal Backdrop Override - WEBSITE NO VISIBLE */
        .modal-backdrop.show {
            opacity: 0.98 !important;
            background-color: #000 !important;
            backdrop-filter: blur(15px);
        }
        .modal-content { box-shadow: 0 0 50px rgba(0,0,0,0.5); }
        .nav-pills .nav-link.active { background-color: var(--navy); color: #fff; }
        .nav-pills .nav-link { color: var(--navy); }

        /* ═══════════════════════════════════════════
           GLOBAL SWEETALERT2 — PREMIUM UI OVERRIDES
           ═══════════════════════════════════════════ */
        .swal2-popup {
            font-family: 'Outfit', 'Inter', sans-serif !important;
            border-radius: 24px !important;
            padding: 36px 32px 28px !important;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.18) !important;
            border: 1px solid rgba(0, 0, 0, 0.06) !important;
            backdrop-filter: blur(20px);
            max-width: 95vw !important;
        }

        /* Icon */
        .swal2-icon {
            margin: 0 auto 16px !important;
            width: 62px !important;
            height: 62px !important;
        }
        .swal2-icon .swal2-icon-content {
            font-size: 32px !important;
        }

        /* Title */
        .swal2-title {
            font-size: 18px !important;
            font-weight: 800 !important;
            color: #002f55 !important;
            letter-spacing: -0.3px !important;
            line-height: 1.3 !important;
            padding: 0 0 8px !important;
            margin: 0 !important;
        }

        /* Body / HTML Container */
        .swal2-html-container {
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #475569 !important;
            line-height: 1.6 !important;
            margin: 4px 0 20px !important;
            padding: 0 4px !important;
            text-align: center !important;
        }

        /* Plain text fallback */
        .swal2-content {
            font-size: 13.5px !important;
            color: #475569 !important;
        }

        /* Confirm Button */
        .swal2-confirm {
            font-family: 'Outfit', 'Inter', sans-serif !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            letter-spacing: 0.5px !important;
            text-transform: uppercase !important;
            padding: 12px 28px !important;
            border-radius: 12px !important;
            box-shadow: 0 6px 20px rgba(0, 94, 184, 0.3) !important;
            transition: all 0.2s ease !important;
        }
        .swal2-confirm:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 10px 28px rgba(0, 94, 184, 0.4) !important;
        }

        /* Cancel Button */
        .swal2-cancel {
            font-family: 'Outfit', 'Inter', sans-serif !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
            padding: 12px 24px !important;
            border-radius: 12px !important;
            background: #f1f5f9 !important;
            color: #64748b !important;
            border: 1px solid #e2e8f0 !important;
            transition: all 0.2s ease !important;
        }
        .swal2-cancel:hover {
            background: #e2e8f0 !important;
            color: #334155 !important;
        }

        /* Close (×) button */
        .swal2-close {
            font-size: 22px !important;
            color: #94a3b8 !important;
            transition: 0.2s !important;
            top: 16px !important;
            right: 16px !important;
        }
        .swal2-close:hover { color: #002f55 !important; transform: rotate(90deg); }

        /* Timer bar */
        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #005eb8, #0076f7) !important;
            height: 3px !important;
        }

        /* Actions row gap */
        .swal2-actions {
            gap: 10px !important;
            margin-top: 4px !important;
        }

        /* Input inside popup (if any) */
        .swal2-input, .swal2-select, .swal2-textarea {
            font-family: 'Outfit', 'Inter', sans-serif !important;
            font-size: 14px !important;
            border-radius: 10px !important;
            border: 1.5px solid #e2e8f0 !important;
            box-shadow: none !important;
        }
        .swal2-input:focus, .swal2-select:focus, .swal2-textarea:focus {
            border-color: #005eb8 !important;
            box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.1) !important;
        }

        .disabled-service {
            opacity: 0.5 !important;
            filter: grayscale(1) !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-light">
    @php
        $isB2BPortal = auth()->check() && request()->is(['agent-dashboard*', 'iata-dashboard*', 'amadeus-dashboard*', 'hotel-dashboard*', 'corporate-dashboard*', 'tourbuilder-dashboard*', 'admin-dashboard*', 'corporate*', 'partner*', 'affiliate-dashboard*']);
    @endphp

    @unless($isB2BPortal)
    <header id="siteHeader" style="background:#fff; border-bottom:1px solid #f1f5f9; position:sticky; top:0; z-index:1000;">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="/" class="navbar-brand py-0 me-4">
                    <img src="/img/logo.svg" alt="Tripzant.com" height="60" style="object-fit: contain;">
                </a>
                
                <nav class="d-none d-lg-flex align-items-center gap-1">
                    @php
                        $navServices = [
                            ['id' => 'flights', 'label' => 'Flights', 'icon' => 'plane', 'url' => '/flights'],
                            ['id' => 'hotels', 'label' => 'Hotels', 'icon' => 'hotel', 'url' => '/hotels'],
                            ['id' => 'flight_hotel', 'label' => 'Flight + Hotel', 'icon' => 'suitcase-rolling', 'url' => '/flight-hotel'],
                            ['id' => 'homestays', 'label' => 'Homestays', 'icon' => 'house-chimney', 'url' => '/homestays'],
                            ['id' => 'cabs', 'label' => 'Cabs', 'icon' => 'car-side', 'url' => '/cabs'],
                            ['id' => 'trains', 'label' => 'Trains', 'icon' => 'train', 'url' => '/trains'],
                            ['id' => 'holidays', 'label' => 'Tours', 'icon' => 'camera-retro', 'url' => route('tours.index')],
                            ['id' => 'cargo', 'label' => 'Cargo', 'icon' => 'boxes-packing', 'url' => '/cargo'],
                        ];
                    @endphp

                    @foreach($navServices as $s)
                        @php $isEnabled = \App\Models\GlobalSetting::get("service_{$s['id']}_enabled", '1') == '1'; @endphp
                        <a href="{{ $isEnabled ? $s['url'] : 'javascript:void(0)' }}" 
                           class="nav-link-mmt {{ !$isEnabled ? 'disabled-service' : '' }} @yield('active-'.$s['id'])"
                           @if(!$isEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif>
                            <i class="fas fa-{{ $s['icon'] }}"></i>
                            <span>{{ $s['label'] }}</span>
                        </a>
                    @endforeach

                    @php $isEventEnabled = \App\Models\GlobalSetting::get('service_event_qr_enabled', '1') == '1'; @endphp
                    <!-- Melbourn Event Button -->
                    <a href="{{ $isEventEnabled ? 'javascript:void(0)' : 'javascript:void(0)' }}" 
                       class="nav-link-mmt festive-nav-btn {{ !$isEventEnabled ? 'disabled-service' : '' }}" 
                       @if($isEventEnabled) data-bs-toggle="modal" data-bs-target="#eventQrModal" @else data-bs-toggle="tooltip" title="Coming Soon" @endif>
                         <div class="festive-icon-wrap animate__animated animate__swing animate__infinite">
                            <i class="fas fa-qrcode"></i>
                         </div>
                        <span class="fw-900">EVENT QR</span>
                    </a>

                    <!-- More Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link-mmt dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                            <span>More</span>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg p-2 mt-2" style="border-radius: 12px; min-width: 200px;">
                            <li><a class="dropdown-item rounded-3 py-2 fw-700 text-navy" href="/explore-map"><i class="fas fa-map-location-dot me-2 text-primary"></i> Explore</a></li>
                            @php $isEsimEnabled = \App\Models\GlobalSetting::get('service_esim_enabled', '1') == '1'; @endphp
                            <li><a class="dropdown-item rounded-3 py-2 fw-700 text-navy {{ !$isEsimEnabled ? 'disabled-service' : '' }}" href="{{ $isEsimEnabled ? '/esim' : 'javascript:void(0)' }}" @if(!$isEsimEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif><i class="fas fa-sim-card me-2 text-primary"></i> eSIM</a></li>
                            
                            @php $isVisaEnabled = \App\Models\GlobalSetting::get('service_visa_enabled', '1') == '1'; @endphp
                            <li><a class="dropdown-item rounded-3 py-2 fw-700 text-navy {{ !$isVisaEnabled ? 'disabled-service' : '' }}" href="{{ $isVisaEnabled ? route('visa.index') : 'javascript:void(0)' }}" @if(!$isVisaEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif><i class="fas fa-id-card me-2 text-primary"></i> Visa</a></li>
                            
                            @php $isInsEnabled = \App\Models\GlobalSetting::get('service_insurance_enabled', '1') == '1'; @endphp
                            <li><a class="dropdown-item rounded-3 py-2 fw-700 text-navy {{ !$isInsEnabled ? 'disabled-service' : '' }}" href="{{ $isInsEnabled ? route('booking.insurance') : 'javascript:void(0)' }}" @if(!$isInsEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif><i class="fas fa-shield-alt me-2 text-primary"></i> Insurance</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-lg-flex align-items-center gap-3">
                    @if(!auth()->check() || auth()->user()->role !== 'user')
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#partnerModal" class="btn btn-partner rounded-pill fw-bold shadow-sm hvr-grow">
                            <i class="fas fa-handshake fs-6"></i>
                            <span>BECOME A PARTNER</span>
                        </a>

                        @if(auth()->check())
                            <!-- If logged in as Partner/Admin, show a small dashboard link instead of Login -->
                            <a href="{{ auth()->user()->getDashboardUrl() }}" class="btn btn-navy rounded-pill px-4 fw-900 d-flex align-items-center gap-2 shadow-sm hover-shadow transition-fast" style="height: 42px;">
                                <i class="fas fa-th-large"></i>
                                <span class="text-uppercase tracking-wider" style="font-size: 11px;">Go to Dashboard</span>
                            </a>
                        @else
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-login-header rounded-pill fw-800 shadow-sm hvr-grow">
                                <i class="fas fa-user-circle fs-5"></i>
                                <span class="text-uppercase tracking-wider">LOGIN / SIGNUP</span>
                            </a>
                        @endif
                    @else
                        <!-- Only for ROLE: user (Customer) -->
                        <div class="dropdown">
                            <div class="d-flex align-items-center gap-2 cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
                                <div class="text-end d-none d-sm-block">
                                    <h6 class="fw-800 text-navy mb-0" style="font-size: 11px;">{{ trim(Auth::user()->name) ? Auth::user()->name : 'User' }}</h6>
                                    <span class="text-orange fw-bold" style="font-size: 9px; text-transform: uppercase;">MY ACCOUNT</span>
                                </div>
                                <div class="avatar bg-navy text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; font-size: 14px;">
                                    {{ trim(Auth::user()->name) ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'U' }}
                                </div>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2" style="border-radius: 12px; width: 220px;">
                                <li>
                                    <a class="dropdown-item rounded-3 py-2 px-3 fw-700 text-navy d-flex align-items-center gap-2" href="/dashboard">
                                        <i class="fas fa-th-large text-primary opacity-50"></i> My Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2 px-3 fw-700 text-navy d-flex align-items-center gap-2" href="/dashboard/profile">
                                        <i class="fas fa-user-edit text-primary opacity-50"></i> My Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    <a class="dropdown-item rounded-3 py-2 px-3 fw-700 text-danger d-flex align-items-center gap-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <button class="btn d-lg-none border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="fas fa-bars text-navy fs-4"></i>
                </button>
            </div>
        </div>
    </header>
    @endunless

    <!-- Partner Signup Modal -->
    <div class="modal fade" id="partnerSignupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg p-4" style="border-radius: 30px;">
                <div class="modal-header auth-modal-header">
                    <h4 class="fw-900 text-navy">Partner With Us</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body auth-modal-body">
                    <p class="text-muted">Join our network of travel partners and grow your business.</p>
                    <a href="{{ route('partner.signup') }}" class="btn btn-navy w-100 py-3 fw-bold">Register as Partner</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Event QR Modal -->
    <div class="modal fade" id="eventQrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 30px; background: linear-gradient(135deg, #ffffff 0%, #fef9c3 100%);">
                <div class="modal-header border-0 pb-0 justify-content-center">
                    <h4 class="fw-900 text-navy mb-0">Symphony in the Stratosphere</h4>
                </div>
                <div class="modal-body py-4">
                    <!-- Very Large QR Code in Middle -->
                    <div class="qr-code-section mb-3 text-center">
                        <div class="bg-white p-3 rounded-5 shadow-lg d-inline-block border border-3 border-navy animate__animated animate__zoomIn">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(route('event')) }}" alt="QR Code" width="200" class="img-fluid">
                            <div class="mt-2 text-navy fw-900 fs-4">SCAN TO WIN</div>
                            <p class="text-muted mb-0 fw-bold fs-6">Scan to enter the Lucky Draw!</p>
                        </div>
                    </div>

                    <div class="flyer-section animate__animated animate__fadeInUp">
                        <p class="text-muted fw-bold mb-3 small text-uppercase letter-spacing-1">Event Flyer</p>
                        <div class="flyer-container bg-white p-2 rounded-4 shadow-sm d-inline-block border border-warning" style="cursor: pointer; max-width: 280px;" onclick="window.location.href='{{ route('event') }}'">
                            <img src="/img/image.jpeg?v={{ time() }}" alt="Event Flyer" class="img-fluid rounded-3 shadow">
                            <div class="mt-2 text-primary x-small fw-bold"><i class="fas fa-mouse-pointer me-1"></i> Click to Open Form</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('event') }}" class="btn btn-navy rounded-pill px-5 py-3 fw-bold w-100 shadow-lg hvr-grow">
                             OPEN REGISTRATION FORM <i class="fas fa-external-link-alt ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0">
                    <p class="small text-muted mb-0">Happy New Year to all Sri Lankans!</p>
                </div>
            </div>
        </div>
    </div>

    @unless($isB2BPortal)
    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <a href="/" class="navbar-brand"><img src="/img/logo.svg" alt="Tripzant.com" height="120"></a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex flex-column gap-1">
                @if(!auth()->check() || auth()->user()->role !== 'user')
                    <a href="/login" class="btn btn-primary w-100 text-center mb-3 py-3 fw-900 rounded-pill">LOGIN / SIGNUP</a>
                    <a href="/partner/signup" class="btn btn-link text-navy text-decoration-none fw-bold small text-center mb-3">Become a Partner</a>
                    
                    @if(auth()->check())
                        <div class="p-3 bg-light rounded-3 mb-3 border border-primary">
                            <h6 class="fw-800 text-navy mb-1">{{ Auth::user()->name }}</h6>
                            <span class="badge bg-primary-subtle text-primary x-small">LOGGED AS {{ strtoupper(str_replace('-', ' ', Auth::user()->role)) }}</span>
                            <a href="{{ auth()->user()->getDashboardUrl() }}" class="btn btn-navy btn-sm w-100 mt-2 fw-bold rounded-pill">Back to Dashboard</a>
                        </div>
                    @endif
                @else
                    <!-- Only for Customers -->
                    <div class="p-3 bg-light rounded-3 mb-3 border border-orange">
                        <h6 class="fw-800 text-navy mb-0">{{ Auth::user()->name }}</h6>
                        <span class="text-orange fw-bold x-small">CUSTOMER ACCOUNT</span>
                    </div>
                    <a href="/dashboard" class="dash-nav-link"><i class="fas fa-th-large"></i> Dashboard Home</a>
                    <a href="/dashboard/profile" class="dash-nav-link"><i class="fas fa-user-circle"></i> My Profile</a>
                    <a href="/dashboard/bookings" class="dash-nav-link"><i class="fas fa-suitcase"></i> My Bookings</a>
                    
                    <form id="logout-form-mobile" action="/logout" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold rounded-pill">Logout</button>
                    </form>
                @endif
                <hr>
                @php
                    $mobileServices = [
                        ['id' => 'flights', 'label' => 'Flights', 'icon' => 'plane-departure', 'url' => '/flights'],
                        ['id' => 'hotels', 'label' => 'Hotels', 'icon' => 'hotel', 'url' => '/hotels'],
                        ['id' => 'homestays', 'label' => 'Homestays', 'icon' => 'house-chimney', 'url' => '/homestays'],
                        ['id' => 'cabs', 'label' => 'Cabs', 'icon' => 'car-side', 'url' => '/cabs'],
                        ['id' => 'trains', 'label' => 'Trains', 'icon' => 'train', 'url' => '/trains'],
                        ['id' => 'holidays', 'label' => 'Tours & Activities', 'icon' => 'camera-retro', 'url' => '/tours/listings'],
                        ['id' => 'esim', 'label' => 'Travel eSIM', 'icon' => 'sim-card', 'url' => '/esim'],
                        ['id' => 'insurance', 'label' => 'Travel Insurance', 'icon' => 'shield-alt', 'url' => route('booking.insurance')],
                    ];
                @endphp

                @foreach($mobileServices as $s)
                    @php $isEnabled = \App\Models\GlobalSetting::get("service_{$s['id']}_enabled", '1') == '1'; @endphp
                    <a href="{{ $isEnabled ? $s['url'] : 'javascript:void(0)' }}" 
                       class="dash-nav-link {{ !$isEnabled ? 'disabled-service' : '' }}"
                       @if(!$isEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif>
                        <i class="fas fa-{{ $s['icon'] }}"></i> {{ $s['label'] }}
                    </a>
                @endforeach
                <a href="/explore-map" class="dash-nav-link text-primary fw-bold"><i class="fas fa-map-location-dot"></i> Explore on Map</a>
            </div>
        </div>
    </div>
    @endunless

    <!-- ====== MAIN CONTENT ====== -->
    <main>
        @yield('content')
    </main>

    @unless($isB2BPortal)
    <!-- ====== PRE-FOOTER DISCOVERY (SEO & LINKS) ====== -->
    <section class="pre-footer-discovery">
        <div class="container">
            <!-- SEO Text Blocks -->
            <div class="row g-4 footer-seo-content mb-5">
                <div class="col-lg-4">
                    <h6 class="footer-title-sm">Why Tripzant.com?</h6>
                    <p class="footer-text-muted">Tripzant.com is India's leading travel brand, providing a wide range of services including flights, hotels, homestays, holiday packages, and activities. Our goal is to make travel accessible, affordable, and enjoyable for everyone through technology and trust.</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="footer-title-sm">Booking Flights & Hotels Online</h6>
                    <p class="footer-text-muted">Book cheapest flight tickets for domestic and international routes with instant confirmation. Choose from a massive inventory of premium hotels, luxury villas, budget stays, and unique homestays with verified reviews and genuine guest photos.</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="footer-title-sm">24/7 Premium Support</h6>
                    <p class="footer-text-muted">Our dedicated travel experts are available around the clock to assist you with bookings, cancellations, and travel advice. We use advanced AI to ensure you get the best rates and real-time updates for your journeys across the globe.</p>
                </div>
            </div>

            <!-- Exhaustive SEO Links (Professional Grid) -->
            <div class="footer-discovery-grid">
                <!-- HOTELS -->
                <div class="grid-card">
                    <div class="grid-head">
                        <i class="fas fa-hotel"></i>
                        <span>Hotels in India</span>
                    </div>
                        <div class="link-col">
                            <a href="{{ route('hotels.index', ['city_code' => 'JAI', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Jaipur</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'GOI', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Goa</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'DEL', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Delhi</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'UDR', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Udaipur</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('hotels.index', ['city_code' => 'BOM', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Mumbai</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'BLR', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Bangalore</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'DED', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Rishikesh</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'AGR', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Agra</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('hotels.index', ['city_code' => 'MAA', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Chennai</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'IXC', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Kasauli</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'CCU', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Kolkata</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'PNQ', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Pune</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('hotels.index', ['city_code' => 'KUU', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Manali</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'PNQ', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Lonavala</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'SLV', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Shimla</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'COK', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Munnar</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('hotels.index', ['city_code' => 'AYJ', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Ayodhya</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'SXR', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Gulmarg</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'IXL', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Leh</a>
                            <a href="{{ route('hotels.index', ['city_code' => 'HYD', 'checkin' => date('Y-m-d', strtotime('+7 days')), 'checkout' => date('Y-m-d', strtotime('+8 days'))]) }}">Hyderabad</a>
                        </div>
                    </div>
                </div>

                <!-- FLIGHTS -->
                <div class="grid-card">
                    <div class="grid-head">
                        <i class="fas fa-plane"></i>
                        <span>Flight Routes</span>
                    </div>
                    <div class="grid-body">
                        <div class="link-col">
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'DEL', 'destination' => 'BOM', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Delhi Mumbai</a>
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'BLR', 'destination' => 'DEL', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Bangalore Delhi</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'BOM', 'destination' => 'GOI', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Mumbai Goa</a>
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'MAA', 'destination' => 'HYD', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Chennai Hyderabad</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'CCU', 'destination' => 'DEL', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Kolkata Delhi</a>
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'DXB', 'destination' => 'BOM', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Dubai Mumbai</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'DEL', 'destination' => 'LHR', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Delhi London</a>
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'BOM', 'destination' => 'JFK', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Mumbai New York</a>
                        </div>
                        <div class="link-col">
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'BLR', 'destination' => 'SIN', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Bangalore Singapore</a>
                            <a href="{{ route('flights.index', ['trip' => 'one', 'origin' => 'DEL', 'destination' => 'DXB', 'departure_date' => date('Y-m-d', strtotime('+7 days')), 'adults' => 1, 'cabin_class' => 'Economy']) }}">Delhi Dubai</a>
                        </div>
                    </div>
                </div>

                <!-- QUICK ACCESS -->
                <div class="grid-card">
                    <div class="grid-head">
                        <i class="fas fa-handshake"></i>
                        <span>Partner Program</span>
                    </div>
                    <div class="grid-body">
                        <div class="link-col">
                            <a href="/payment" class="text-primary fw-bold"><i class="fas fa-credit-card me-1"></i> Payment Test</a>
                            <a href="{{ route('partner.login') }}">Partner Login</a>
                            <a href="/admin/login" class="text-muted">Admin Access</a>
                        </div>
                        <div class="link-col">
                            <a href="/login">User Login</a>
                            <a href="{{ route('partner.signup') }}" class="small text-primary opacity-50">Join as Partner</a>
                        </div>
                    </div>
                </div>

                <!-- IMPORTANT LINKS -->
                <div class="grid-card">
                    <div class="grid-head">
                        <i class="fas fa-star"></i>
                        <span>Important Links</span>
                    </div>
                    <div class="grid-body">
                        <div class="link-col">
                            <a href="#">Cheap Flights</a><a href="#">Flight Status</a>
                        </div>
                        <div class="link-col">
                            <a href="#">Kumbh Mela</a><a href="#">Domestic Airlines</a>
                        </div>
                        <div class="link-col">
                            <a href="#">International Airlines</a><a href="#">Indigo</a>
                        </div>
                        <div class="link-col">
                            <a href="#">Spicejet</a><a href="#">Air Asia</a>
                        </div>
                        <div class="link-col">
                            <a href="#">Air India</a><a href="#">Indian Railways</a>
                        </div>
                        <div class="link-col">
                            <a href="#">Trip Ideas</a><a href="#">Beaches</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== FOOTER ====== -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <img src="/img/logo.svg" height="120" style="filter: brightness(0) invert(1); opacity: 0.9; margin-bottom: 15px;" alt="Tripzant.com">
                    </div>
                    <p style="color:rgba(255,255,255,.5);font-size:13px;line-height:1.7;">Tripzant.com is your ultimate travel partner for booking flights, hotels, homestays and experiences worldwide with unbeatable prices and premium service.</p>
                    <div class="d-flex gap-2 TS-3">
                        <a href="#" class="social-pill"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-pill"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-pill"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-pill"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-pill"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">Products</h6>
                    <ul class="footer-links">
                        @php
                            $footerProducts = [
                                ['id' => 'flights', 'label' => 'Flights', 'url' => '/flights'],
                                ['id' => 'hotels', 'label' => 'Hotels', 'url' => '/hotels'],
                                ['id' => 'homestays', 'label' => 'Homestays & Villas', 'url' => '/homestays'],
                                ['id' => 'cabs', 'label' => 'Cabs', 'url' => '/cabs'],
                                ['id' => 'trains', 'label' => 'Trains', 'url' => '/trains'],
                                ['id' => 'insurance', 'label' => 'Travel Insurance', 'url' => route('booking.insurance')],
                                ['id' => 'holidays', 'label' => 'Holiday Packages', 'url' => '#'],
                            ];
                        @endphp
                        @foreach($footerProducts as $p)
                            @php $isEnabled = \App\Models\GlobalSetting::get("service_{$p['id']}_enabled", '1') == '1'; @endphp
                            <li>
                                <a href="{{ $isEnabled ? $p['url'] : 'javascript:void(0)' }}" 
                                   class="{{ !$isEnabled ? 'disabled-service' : '' }}"
                                   @if(!$isEnabled) data-bs-toggle="tooltip" title="Coming Soon" @endif>
                                    {{ $p['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">Company</h6>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press Room</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Investor Relations</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <h6 class="footer-title">Support</h6>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Cancellation Policy</a></li>
                        <li><a href="#">Refund Status</a></li>
                        <li><a href="#">Report a Bug</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-8 col-6">
                    <h6 class="footer-title">Contact Us</h6>
                    <ul class="footer-links" style="list-style: none; padding: 0;">
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i class="fas fa-phone-alt text-primary mt-1"></i>
                            <div>
                                <a href="tel:0468259656" class="d-block">0468259656</a>
                                <small style="color:rgba(255,255,255,0.4);">Call or WhatsApp</small>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i class="fas fa-envelope text-primary mt-1"></i>
                            <a href="mailto:info@tripzant.com">info@tripzant.com</a>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                            <span style="color:rgba(255,255,255,0.7); font-size:13px;">1151 Wynnum Road, Cannon Hill, 4170, QLD , Australia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr style="border-color:rgba(255,255,255,.1); margin: 40px 0;">

            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p style="color:rgba(255,255,255,.35);font-size:12px;margin:0;">© 2026 Tripzant Private Limited. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex flex-column align-items-md-end gap-4">
                            <!-- IATA Logo (Premium Badge - Major Focus) -->
                            <div class="iata-badge bg-white px-4 py-2 rounded-3 shadow-lg d-inline-flex align-items-center mb-2" style="height: 95px; border: 2px solid #0076f7; transition: 0.3s;">
                                <img src="/img/iata-logo.svg" alt="IATA Accredited Agent" style="height: 70px; object-fit: contain;">
                            </div>
                            
                            <div class="d-flex align-items-center gap-3 justify-content-md-end">
                                <span style="color:rgba(255,255,255,.4); font-size:12px; font-weight: 700;">WE ACCEPT:</span>
                                <div class="payment-icons-footer d-flex align-items-center gap-2 flex-wrap">
                                    <style>
                                        .pay-badge {
                                            background: #fff;
                                            border-radius: 4px;
                                            height: 26px;
                                            padding: 0 8px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-weight: 900;
                                            font-size: 11px;
                                            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                                            letter-spacing: 0.5px;
                                        }
                                    </style>
                                    <!-- Slice Logo First -->
                                    <div class="pay-badge" style="padding: 0 6px;">
                                        <img src="/img/slice-logo.svg" style="height: 16px; object-fit: contain;" alt="Slice">
                                    </div>
                                    <!-- UPI -->
                                    <div class="pay-badge fst-italic" style="color: #ea580c;">
                                        <span style="color: #047857;">U</span>PI
                                    </div>
                                    <!-- COM BANK -->
                                    <div class="pay-badge" style="color: #0f172a;">COM BANK</div>
                                    <!-- MINT BANK -->
                                    <div class="pay-badge" style="color: #10b981;">MINT BANK</div>
                                    <!-- RAZOR PAY -->
                                    <div class="pay-badge" style="color: #0284c7;">RAZORPAY</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </footer>
    @endunless

    <!-- ====== LOCALIZATION MODAL (INR/Country) ====== -->
    <div class="modal fade" id="localizationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-900 text-navy">Country & Language</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="small fw-bold text-muted mb-2">CURRENCY</label>
                            <div class="p-3 border rounded-3 bg-light d-flex align-items-center gap-3 cursor-pointer border-primary">
                                <img src="https://flagcdn.com/w20/in.png" width="20">
                                <span class="fw-bold text-navy">INR (₹)</span>
                                <i class="fas fa-check-circle ms-auto text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold text-muted mb-2">LANGUAGE</label>
                            <div class="p-3 border rounded-3 bg-light d-flex align-items-center gap-3 cursor-pointer">
                                <span class="fw-bold text-navy">English (US)</span>
                                <i class="fas fa-chevron-down ms-auto text-muted small"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-navy w-100 py-3 rounded-pill fw-bold shadow" data-bs-dismiss="modal">Apply & Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (CRITICAL) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ====== SCROLL REVEAL (CRITICAL FIX FOR WHITE SPACE) ====== -->
    <script>
        const scrollReveal = () => {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(el => {
                const windowHeight = window.innerHeight;
                const revealTop = el.getBoundingClientRect().top;
                const revealPoint = 150;
                if (revealTop < windowHeight - revealPoint) el.classList.add('visible');
            });
        };
        window.addEventListener('scroll', scrollReveal);
        window.addEventListener('load', scrollReveal);
    </script>

    <script>
        // Under Construction Popup
        document.addEventListener('DOMContentLoaded', function() {
            if (!sessionStorage.getItem('constructionSeen')) {
                Swal.fire({
                    title: '<span style="color:var(--navy); font-family:Outfit; font-weight:900;">TripZant.com is Under Construction</span>',
                    html: `
                        <div style="text-align: center; padding: 10px;">
                            <div class="d-flex align-items-center justify-content-center gap-5 mb-4">
                                <img src="/img/logo.svg" height="80">
                                <div style="width: 2px; height: 60px; background: #e2e8f0;"></div>
                                <img src="/img/iata-logo.svg" height="80">
                            </div>
                            <p style="color: #64748b; font-size: 16px; line-height: 1.6;">
                                We are currently building a premium travel experience for you. 
                                Our engineers are working hard to integrate live GDS pricing and global hotel networks.
                            </p>
                            <div style="background: #f8fafc; padding: 15px; border-radius: 12px; margin-top: 20px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 8px;">
                                <div>
                                    <strong style="color: var(--navy);">🚀 Official Launch:</strong> 
                                    <span style="color: var(--primary); font-weight: 700;">Coming Live in 1 Month!</span>
                                </div>
                                <div style="border-top: 1px solid #e2e8f0; pt-2; margin-top: 5px; padding-top: 8px;">
                                    <p style="margin:0; font-weight: 600; color: #1e293b; font-size: 14px;">For immediate bookings, please contact:</p>
                                    <h5 style="color: var(--primary); font-weight: 800; margin-top: 5px; letter-spacing: 1px;"><i class="fas fa-phone-alt me-2"></i>0468259656</h5>
                                </div>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    iconColor: '#0076f7',
                    confirmButtonText: 'Explore Preview',
                    confirmButtonColor: '#002f55',
                    width: 700,
                    allowOutsideClick: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    customClass: {
                        popup: 'rounded-4 border-0 shadow-lg',
                        title: 'fs-3',
                    }
                }).then(() => {
                    sessionStorage.setItem('constructionSeen', 'true');
                });
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('siteHeader');
            if (header && window.scrollY > 30) header.classList.add('scrolled');
            else if(header) header.classList.remove('scrolled');
        });
        function openLocalizationModal() {
            const modal = new bootstrap.Modal(document.getElementById('localizationModal'));
            modal.show();
        }

        @if(session('showLoginModal'))
        document.addEventListener('DOMContentLoaded', function() {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal')).show();
        });
        @endif

        @if(session('showSignupModal'))
        document.addEventListener('DOMContentLoaded', function() {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('signupModal')).show();
        });
        @endif
    </script>
    @include('partials.partner-modal')
    @include('partials.login-modal')
    @include('partials.signup-modal')
    @yield('scripts')
</body>
</html>

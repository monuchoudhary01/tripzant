<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Partner Super Panel')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --ps-primary: #101828;
            --ps-accent: #6366f1;
            --ps-bg: #f9fafb;
            --ps-sidebar: #ffffff;
            --ps-border: #f2f4f7;
            --ps-text-main: #1d2939;
            --ps-text-muted: #667085;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--ps-bg); color: var(--ps-text-main); overflow-x: hidden; }
        .outfit { font-family: 'Outfit', sans-serif; }

        .ps-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar Styles */
        .ps-sidebar {
            width: 280px;
            background: var(--ps-sidebar);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            border-right: 1px solid var(--ps-border);
            padding-bottom: 40px;
        }

        .ps-brand { padding: 32px 24px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid var(--ps-border); margin-bottom: 16px; }
        .ps-logo-ic { width: 40px; height: 40px; background: var(--ps-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; }

        .ps-nav-group { padding: 8px 16px; }
        .ps-nav-label { font-size: 11px; font-weight: 800; color: #98a2b3; text-transform: uppercase; letter-spacing: 1px; padding: 16px 12px 8px; }

        .ps-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: var(--ps-text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
            margin-bottom: 2px;
        }

        .ps-nav-link i { font-size: 18px; width: 24px; text-align: center; }
        .ps-nav-link:hover { background: #f9fafb; color: var(--ps-accent); }
        .ps-nav-link.active { background: #eef2ff; color: var(--ps-accent); }

        /* Main Content */
        .ps-main { flex-grow: 1; margin-left: 280px; min-height: 100vh; }
        .ps-header { height: 80px; background: #fff; border-bottom: 1px solid var(--ps-border); padding: 0 40px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 900; }

        .ps-content { padding: 40px; }

        .indicator-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 8px; }
        .bg-online { background: #12b76a; }

        .ps-btn-primary { background: var(--ps-accent); color: #fff; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 700; transition: 0.2s; }
        .ps-btn-primary:hover { opacity: 0.9; }

        /* Wallet Widget in Sidebar */
        .sidebar-wallet { margin: 24px 16px; padding: 20px; background: #f9fafb; border: 1px solid var(--ps-border); border-radius: 16px; }
        
        .nav-badge { background: #fee4e2; color: #d92d20; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px; margin-left: auto; }
        
    </style>
    @yield('styles')
</head>
<body>
    <div class="ps-wrapper">
        <aside class="ps-sidebar">
            <div class="ps-brand">
                <div class="ps-logo-ic"><i class="fas fa-hotel"></i></div>
                <div>
                    <h5 class="outfit fw-900 mb-0" style="letter-spacing: -0.5px; color: var(--ps-primary);">Partner Hub</h5>
                    <div class="small fw-700 text-muted" style="font-size: 10px; text-transform: uppercase;">Super Panel v2.0</div>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="ps-nav-group pb-0">
                <a href="{{ route('hotel_dashboard.dashboard') }}" class="ps-nav-link {{ request()->routeIs('hotel_dashboard.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </div>

            <!-- Property Management -->
            <div class="ps-nav-label">Your Property</div>
            <div class="ps-nav-group">
                <a href="{{ route('hotel.my-properties') }}" class="ps-nav-link {{ request()->routeIs('hotel.my-properties') ? 'active' : '' }}">
                    <i class="fas fa-hotel"></i> My Properties Portfolio
                </a>
                <a href="{{ route('hotel.assets') }}" class="ps-nav-link {{ request()->routeIs('hotel.assets') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> Asset Management
                </a>
                <a href="{{ route('hotel.management.all') }}" class="ps-nav-link {{ request()->routeIs('hotel.management.all') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Hotel Bookings <span class="nav-badge">12</span>
                </a>
                <a href="{{ route('hotel.inventory') }}" class="ps-nav-link {{ request()->routeIs('hotel.inventory') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell"></i> Inventory & Pricing
                </a>
                <a href="{{ route('hotel.promotions') }}" class="ps-nav-link {{ request()->routeIs('hotel.promotions') ? 'active' : '' }}">
                    <i class="fas fa-percent"></i> Offers & Promotions
                </a>
                <a href="{{ route('hotel.guests') }}" class="ps-nav-link {{ request()->routeIs('hotel.guests') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> Guest Relations
                </a>
                <div class="ps-3 pe-3 mt-3">
                     <a href="{{ route('hotel.add-property') }}" class="btn btn-outline-primary w-100 rounded-pill py-2 small fw-800 border-2" style="font-size: 11px;">+ ADD NEW PROPERTY</a>
                </div>
            </div>

            <!-- Travel Super App -->
            <div class="ps-nav-label">Travel Services (Book For Guest)</div>
            <div class="ps-nav-group">
                <a href="{{ route('hotel_dashboard.search') }}" class="ps-nav-link {{ request()->routeIs('hotel_dashboard.search') ? 'active' : '' }}">
                    <i class="fas fa-plane-departure"></i> Flight Engine
                </a>
                <a href="{{ localized_url('/hotels') }}" class="ps-nav-link {{ request()->routeIs('hotels.index') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Marketplace Hotels
                </a>
                <a href="{{ route('hotel.tours') }}" class="ps-nav-link {{ request()->routeIs('hotel.tours') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i> Tours & Activities
                </a>
                <a href="{{ route('hotel.transfers') }}" class="ps-nav-link {{ request()->routeIs('hotel.transfers') ? 'active' : '' }}">
                    <i class="fas fa-shuttle-van"></i> Airport Transfers
                </a>
                <a href="{{ route('hotel.cars') }}" class="ps-nav-link {{ request()->routeIs('hotel.cars') ? 'active' : '' }}">
                    <i class="fas fa-car"></i> Car Rentals
                </a>
                <a href="{{ route('hotel.guides') }}" class="ps-nav-link {{ request()->routeIs('hotel.guides') ? 'active' : '' }}">
                    <i class="fas fa-microphone-lines"></i> Local Guide Service
                </a>
            </div>

            <!-- Channel Manager -->
            <div class="ps-nav-label">Channel Management (CRS)</div>
            <div class="ps-nav-group">
                <a href="{{ route('hotel.channel-manager') }}" class="ps-nav-link {{ request()->routeIs('hotel.channel-manager') ? 'active' : '' }}">
                    <i class="fas fa-network-wired"></i> OTA Connections
                </a>
                <a href="{{ route('hotel.ota-mapping') }}" class="ps-nav-link {{ request()->routeIs('hotel.ota-mapping') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i> Room Mapping
                </a>
                <a href="{{ route('hotel.sync-status') }}" class="ps-nav-link {{ request()->routeIs('hotel.sync-status') ? 'active' : '' }}">
                    <i class="fas fa-sync"></i> Real-time Sync Log
                </a>
                <a href="{{ route('hotel.webhook-logs') }}" class="ps-nav-link {{ request()->routeIs('hotel.webhook-logs') ? 'active' : '' }}">
                    <i class="fas fa-terminal"></i> Webhook Listeners (JSON)
                </a>
            </div>

            <!-- Automation Logic -->
            <div class="ps-nav-label">Automation Magic</div>
            <div class="ps-nav-group">
                <a href="{{ route('hotel.automation-rules') }}" class="ps-nav-link {{ request()->routeIs('hotel.automation-rules') ? 'active' : '' }}">
                    <i class="fas fa-robot"></i> Business Rules
                </a>
                <a href="{{ route('hotel.notification-templates') }}" class="ps-nav-link {{ request()->routeIs('hotel.notification-templates') ? 'active' : '' }}">
                    <i class="fas fa-magic"></i> Notification Templates
                </a>
            </div>

            <!-- Public Portal Preview -->
            <div class="ps-nav-label">Your Public Portal</div>
            <div class="ps-nav-group">
                <a href="{{ route('hotel.customer-preview') }}" class="ps-nav-link {{ request()->routeIs('hotel.customer-preview') ? 'active' : '' }}">
                    <i class="fas fa-eye"></i> View Your B2C Portal
                </a>
                <a href="{{ route('hotel.portal-settings') }}" class="ps-nav-link {{ request()->routeIs('hotel.portal-settings') ? 'active' : '' }}">
                    <i class="fas fa-share-nodes"></i> B2C Distribution Gateway
                </a>
            </div>

            <!-- Financials -->
            <div class="ps-nav-label">Financials</div>
            <div class="ps-nav-group">
                <div class="sidebar-wallet">
                    <div class="tiny fw-700 text-muted uppercase mb-1" style="font-size: 9px;">Wallet Balance</div>
                    <div class="h5 outfit fw-900 text-navy mb-2">₹1,45,280.00</div>
                    <a href="{{ route('hotel.wallet') }}" class="tiny fw-800 text-primary text-decoration-none">+ RECHARGE FUNDS</a>
                </div>
                <a href="{{ route('hotel.earnings') }}" class="ps-nav-link {{ request()->routeIs('hotel.earnings') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i> Earnings & Commission
                </a>
                <a href="{{ route('hotel.reports') }}" class="ps-nav-link {{ request()->routeIs('hotel.reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Detailed Reports
                </a>
            </div>

            <!-- Account -->
            <div class="ps-nav-label">Accounts</div>
            <div class="ps-nav-group">
                <a href="{{ route('hotel.settings') }}" class="ps-nav-link">
                    <i class="fas fa-cog"></i> Panel Settings
                </a>
                <a href="#" class="ps-nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="ps-main">
            <header class="ps-header">
                <div>
                     <span class="indicator-dot bg-online"></span>
                     <span class="fw-800 small text-navy outfit">Radisson Blu Plaza Delhi</span>
                </div>

                <div class="d-flex align-items-center gap-4">
                     <!-- Search Bar -->
                     <div class="d-none d-lg-flex align-items-center bg-light px-3 py-2 rounded-pill" style="width: 300px;">
                         <i class="fas fa-search text-muted small me-2"></i>
                         <input type="text" placeholder="Search Bookings/Guests..." class="bg-transparent border-0 small fw-600 outline-none w-100" style="outline: none;">
                     </div>
                     
                     <div class="position-relative">
                         <i class="far fa-bell h5 mb-0 text-muted"></i>
                         <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px;">5</span>
                     </div>

                     <img src="https://ui-avatars.com/api/?name=Hotel+Manager&background=6366f1&color=fff&bold=true" class="rounded-circle border" width="40" height="40">
                </div>
            </header>

            <div class="ps-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

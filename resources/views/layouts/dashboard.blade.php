<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "My Dashboard | Trip Zant")</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --user-primary: #0f172a;
            --user-sidebar-bg: #1e293b; /* Dark Navy Sidebar */
            --user-accent: #6366f1;
            --user-orange: #f59e0b;
            --user-bg: #f8fafc;
            --user-card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --user-card-hover: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--user-bg);
            color: #334155;
            overflow-x: hidden;
        }

        .dashboard-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar Premium Dark Theme */
        .dashboard-sidebar {
            width: 280px;
            background: var(--user-sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
            color: #fff;
        }

        .sidebar-header {
            padding: 40px 30px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-nav { padding: 30px 15px; }
        
        .nav-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.4);
            padding: 0 20px;
            margin-bottom: 12px;
            margin-top: 30px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            border-radius: 14px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 6px;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: var(--user-accent);
            color: #fff !important;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        
        .sidebar-link i { 
            font-size: 18px; 
            width: 24px; 
            text-align: center; 
            transition: all 0.3s;
            color: inherit;
        }
        .sidebar-link.active i { color: #fff; }

        /* Main Content */
        .dashboard-main {
            flex-grow: 1;
            margin-left: 280px;
            padding: 40px 50px;
            transition: all 0.3s ease;
        }

        .user-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            background: #fff;
            padding: 20px 30px;
            border-radius: 20px;
            box-shadow: var(--user-card-shadow);
        }

        /* Premium Card Design */
        .dashboard-card {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--user-card-shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--user-card-hover);
        }

        .stat-badge {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        
        /* Typography Improvements */
        .fw-900 { font-weight: 900; }
        .text-navy { color: var(--user-primary); }
        .text-accent { color: var(--user-accent); }
        .ls-2 { letter-spacing: 2px; }

        .btn-website {
            background: var(--user-primary);
            color: #fff !important;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .btn-website:hover {
            background: var(--user-accent);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        @media (max-width: 991px) {
            .dashboard-sidebar { left: -280px; }
            .dashboard-sidebar.active { left: 0; }
            .dashboard-main { margin-left: 0; padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <div class="sidebar-header" style="padding: 30px 25px;">
                <h4 class="fw-900 mb-0" style="font-size: 24px; letter-spacing: -1px;">
                    <span style="color: #ffffff;">Trip</span><span style="color: #3b82f6;">zant.com</span>
                </h4>
            </div>
            <div class="sidebar-nav">
                @if(request()->is('user-cargo*') || request()->is('cargo-agent*') || request()->is('cargo-hub*'))
                    <!-- Cargo Specific Sidebar (Module 1-6) -->
                    <a href="{{ route('cargo.dashboard.index') }}" class="sidebar-link {{ request()->routeIs('cargo.dashboard.index') && !request()->has('tab') ? 'active' : '' }}">
                        <i class="fas fa-th-large text-primary"></i> Cargo Home
                    </a>
                    <a href="{{ route('cargo.dashboard.index') }}?tab=all" class="sidebar-link {{ request()->query('tab') === 'all' ? 'active' : '' }}">
                        <i class="fas fa-boxes text-secondary"></i> My Shipments
                    </a>
                    <a href="{{ route('cargo.dashboard.book') }}" class="sidebar-link {{ request()->routeIs('cargo.dashboard.book') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle text-success"></i> Book New Parcel
                    </a>
                    <a href="{{ route('cargo.dashboard.index') }}?tab=tracking" class="sidebar-link {{ request()->query('tab') === 'tracking' ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt text-info"></i> Tracking
                    </a>
                    <a href="{{ route('cargo.dashboard.index') }}?tab=invoices" class="sidebar-link {{ request()->query('tab') === 'invoices' ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar text-warning"></i> Invoice
                    </a>
                    <a href="{{ route('coming-soon') }}" class="sidebar-link">
                        <i class="fas fa-headset text-danger"></i> Support
                    </a>
                    <div class="mt-4 px-3 x-small fw-800 text-muted text-uppercase ls-1 mb-2">Account</div>
                    <a href="{{ route('dashboard.profile') }}" class="sidebar-link {{ request()->is('dashboard/profile') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i> Profile Settings
                    </a>
                @else
                    <!-- Main Travel Sidebar -->
                    <div class="nav-label">Overview</div>
                    <a href="{{ route('dashboard.index') }}" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Dashboard Home
                    </a>
                    <a href="{{ route('dashboard.profile') }}" class="sidebar-link {{ request()->is('dashboard/profile') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i> My Profile
                    </a>

                    <div class="nav-label">Bookings & Finance</div>
                    <a href="{{ route('dashboard.bookings') }}" class="sidebar-link {{ request()->is('dashboard/bookings') ? 'active' : '' }}">
                        <i class="fas fa-suitcase"></i> My Bookings
                    </a>
                    <a href="{{ route('dashboard.wallet') }}" class="sidebar-link {{ request()->is('dashboard/wallet') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i> Tripzant Wallet
                    </a>

                    <div class="nav-label">Travel Tools</div>
                    <a href="{{ route('dashboard.price-alerts') }}" class="sidebar-link {{ request()->is('dashboard/price-alerts') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Price Alerts
                    </a>
                    <a href="{{ route('dashboard.wishlist') }}" class="sidebar-link {{ request()->is('dashboard/wishlist') ? 'active' : '' }}">
                        <i class="fas fa-heart"></i> Wishlist
                    </a>
                    <a href="{{ route('dashboard.searches') }}" class="sidebar-link {{ request()->is('dashboard/searches') ? 'active' : '' }}">
                        <i class="fas fa-search"></i> Saved Searches
                    </a>

                    <div class="nav-label">Preferences</div>
                    <a href="{{ route('dashboard.notifications') }}" class="sidebar-link {{ request()->is('dashboard/notifications') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="sidebar-link {{ request()->is('dashboard/settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                @endif

                <div class="mt-5 px-3">
                    <a href="/logout" class="sidebar-link text-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.1);">
                        <i class="fas fa-power-off"></i> Sign Out
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="dashboard-main">
            <div class="user-top-bar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn d-lg-none border-0 p-0" onclick="toggleSidebar()">
                        <i class="fas fa-bars fs-4"></i>
                    </button>
                </div>
            </div>

            @yield('dashboard_content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('dashboardSidebar').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "Master Admin | Trip Zant")</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --admin-primary: #0b3d61;
            --admin-secondary: #f97316;
            --admin-bg: #f8fafc;
            --admin-text: #1e293b;
            --admin-text-light: #64748b;
            --admin-border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text);
            overflow-x: hidden;
        }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 280px;
            background: #fff;
            border-right: 1px solid var(--admin-border);
            position: fixed;
            height: 100vh;
            left: 0; top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .admin-logo-area {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-nav { padding: 20px; }
        .admin-nav-label {
            font-size: 11px;
            font-weight: 800;
            color: var(--admin-text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 25px 0 10px 15px;
            display: block;
            opacity: 0.6;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 18px;
            border-radius: 12px;
            color: var(--admin-text-light);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.2s ease;
            margin-bottom: 5px;
        }

        .admin-nav-link:hover, .admin-nav-link.active {
            background: rgba(11, 61, 97, 0.05);
            color: var(--admin-primary);
        }
        
        .admin-nav-link i { width: 22px; text-align: center; font-size: 18px; }

        /* Content Area */
        .admin-main {
            flex-grow: 1;
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        .admin-navbar {
            background: #fff;
            padding: 15px 40px;
            border-bottom: 1px solid var(--admin-border);
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-content { padding: 40px; }

        /* UI Components */
        .card-admin {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--admin-border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 30px;
            height: 100%;
        }

        .stats-card {
            border-left: 5px solid var(--admin-primary);
        }

        .btn-admin-primary {
            background: var(--admin-primary);
            color: #fff;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 700;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-admin-primary:hover {
            background: #001f3f;
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-navy {
            background: #0d1b3e;
            color: #fff;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 700;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-navy:hover {
            background: #000;
            color: #fff;
            transform: translateY(-2px);
        }

        .badge-admin-success { background: rgba(34, 197, 94, 0.1); color: #22c55e; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 12px; }
        .badge-admin-warning { background: rgba(249, 115, 22, 0.1); color: #f97316; border-radius: 30px; padding: 6px 15px; font-weight: 700; font-size: 12px; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-logo-area">
                <img src="/img/logo.svg" height="80" alt="Trip Zant Admin">
                <div class="mt-2 text-navy fw-900 small">MASTER COMMAND</div>
            </div>

            <nav class="admin-nav">
                <span class="admin-nav-label">Main Menu</span>
                <a href="/admin-dashboard" class="admin-nav-link {{ request()->is('admin-dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Users Management
                </a>
                <a href="{{ route('admin.users.requests') }}" class="admin-nav-link {{ request()->is('admin/users/requests') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i> Partnership Requests
                </a>
                
                <span class="admin-nav-label">Inventory Control</span>
                <a href="/admin/flights" class="admin-nav-link {{ request()->is('admin/flights') ? 'active' : '' }}">
                    <i class="fas fa-plane"></i> Flights Control
                </a>
                <a href="/admin/hotels" class="admin-nav-link {{ request()->is('admin/hotels') ? 'active' : '' }}">
                    <i class="fas fa-hotel"></i> Hotels Control
                </a>
                <a href="/admin/tours" class="admin-nav-link {{ request()->is('admin/tours') ? 'active' : '' }}">
                    <i class="fas fa-suitcase-rolling"></i> Tours & Packages
                </a>
                <a href="/admin/bookings" class="admin-nav-link {{ request()->is('admin/bookings') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> All Bookings
                </a>
                <a href="{{ route('admin.audit-logs.index') }}" class="admin-nav-link {{ request()->is('admin/audit-logs*') ? 'active' : '' }}">
                    <i class="fas fa-list-ul"></i> Audit Logs
                </a>

                <span class="admin-nav-label">Cargo & Logistics</span>
                <a href="{{ route('admin.cargo.index') }}" class="admin-nav-link {{ request()->is('admin/cargo') ? 'active' : '' }}">
                    <i class="fas fa-boxes-packing"></i> Cargo Dashboard
                </a>
                <div class="ms-4 {{ request()->is('admin/cargo*') ? '' : 'd-none' }}">
                    <a href="{{ route('admin.cargo.providers') }}" class="admin-nav-link small py-2 {{ request()->is('admin/cargo/providers') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-truck-fast fs-6"></i> Manage Providers
                    </a>
                    <a href="{{ route('admin.cargo.bookings') }}" class="admin-nav-link small py-2 {{ request()->is('admin/cargo/bookings') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-list-check fs-6"></i> All Shipments
                    </a>
                </div>

                <span class="admin-nav-label">Affiliate & Partnerships</span>
                <a href="{{ route('admin.partnership.dashboard') }}" class="admin-nav-link {{ request()->is('admin/partnership/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Partnership Dashboard
                </a>
                <a href="{{ route('admin.partnership.checker') }}" class="admin-nav-link {{ request()->is('admin/partnership/checker') ? 'active' : '' }}">
                    <i class="fas fa-globe"></i> Traffic Checker
                </a>
                <a href="{{ route('admin.partnership.index') }}" class="admin-nav-link {{ request()->is('admin/partnership/websites*') ? 'active' : '' }}">
                    <i class="fas fa-list-check"></i> Web Discovery
                </a>
                <a href="{{ route('admin.partnership.widget') }}" class="admin-nav-link {{ request()->is('admin/partnership/widget') ? 'active' : '' }}">
                    <i class="fas fa-code"></i> Integration Widget
                </a>
                <a href="{{ route('admin.partnership.revenue') }}" class="admin-nav-link {{ request()->is('admin/partnership/revenue') ? 'active' : '' }}">
                    <i class="fas fa-sack-dollar"></i> Partner Revenue
                </a>

                <span class="admin-nav-label">Affiliate Master</span>
                <a href="{{ route('admin.affiliates.index') }}" class="admin-nav-link {{ request()->is('admin/affiliates') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i> Manage Affiliates
                </a>
                <a href="{{ route('admin.affiliates.withdrawals') }}" class="admin-nav-link {{ request()->is('admin/affiliates/withdrawals*') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i> Payout Requests
                </a>

                <span class="admin-nav-label">Management & Finance</span>
                <a href="{{ route('admin.money-transfer.index') }}" class="admin-nav-link {{ request()->is('admin/money-transfer*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-transfer"></i> Money Transfer Portal
                </a>
                <a href="{{ route('accounting.dashboard') }}" class="admin-nav-link {{ request()->is('accounting*') ? 'active' : '' }}">
                    <i class="fas fa-calculator"></i> Accounting Terminal
                </a>
                <div class="ms-4 {{ request()->is('accounting*') ? '' : 'd-none' }}">
                    <a href="{{ route('accounting.dashboard') }}" class="admin-nav-link small py-2 {{ request()->is('accounting/dashboard') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-chart-pie fs-6"></i> Dashboard
                    </a>
                    <a href="{{ route('accounting.ledger') }}" class="admin-nav-link small py-2 {{ request()->is('accounting/ledger') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-book fs-6"></i> Ledger
                    </a>
                    <a href="{{ route('accounting.invoices') }}" class="admin-nav-link small py-2 {{ request()->is('accounting/invoices') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-file-invoice-dollar fs-6"></i> Invoices
                    </a>
                    <a href="{{ route('accounting.sync') }}" class="admin-nav-link small py-2 {{ request()->is('accounting/sync') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-cloud-upload-alt fs-6"></i> API Sync
                    </a>
                </div>

                <span class="admin-nav-label">API Integration</span>
                <div class="ms-4 {{ request()->is('admin/api-dashboard*') || request()->is('admin/fare-monitor*') ? '' : 'd-none' }}">
                    <a href="{{ route('admin.api.dashboard') }}" class="admin-nav-link small py-2 {{ request()->is('admin/api-dashboard') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-microchip fs-6"></i> API Control Panel
                    </a>
                    <a href="{{ route('admin.api.fare-monitor') }}" class="admin-nav-link small py-2 {{ request()->is('admin/fare-monitor') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-tower-broadcast fs-6"></i> Fare Monitor Control
                    </a>
                    <a href="#" class="admin-nav-link small py-2">
                        <i class="fas fa-plane-circle-check fs-6 text-primary"></i> Amadeus Gateway
                    </a>
                    <a href="#" class="admin-nav-link small py-2">
                        <i class="fas fa-robot fs-6 text-success"></i> Fare Maximizer
                    </a>
                    <a href="#" class="admin-nav-link small py-2">
                        <i class="fas fa-list-ul fs-6 text-muted"></i> Activity Logs
                    </a>
                </div>

                <span class="admin-nav-label">External Integration</span>
                <a href="{{ route('admin.google-api.dashboard') }}" class="admin-nav-link {{ request()->is('admin/google-api*') ? 'active' : '' }}">
                    <i class="fab fa-google"></i> Google API Dashboard
                </a>
                <div class="ms-4 {{ request()->is('admin/google-api*') ? '' : 'd-none' }}">
                    <a href="{{ route('admin.google-api.flights') }}" class="admin-nav-link small py-2 {{ request()->is('admin/google-api/flights') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-plane-up fs-6"></i> Flights Comparison
                    </a>
                    <a href="{{ route('admin.google-api.hotels') }}" class="admin-nav-link small py-2 {{ request()->is('admin/google-api/hotels') ? 'text-primary fw-bold' : '' }}">
                        <i class="fas fa-bed fs-6"></i> Hotels Comparison
                    </a>
                </div>

                <span class="admin-nav-label">Event Management</span>
                <a href="{{ route('admin.event-leads.index') }}" class="admin-nav-link {{ request()->is('admin/event-leads*') ? 'active' : '' }}">
                    <i class="fas fa-users-viewfinder"></i> Participant Details
                </a>

                <span class="admin-nav-label">Configuration</span>
                <a href="/admin/marketing" class="admin-nav-link {{ request()->is('admin/marketing') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Marketing & Social
                </a>
                <a href="/admin/notifications" class="admin-nav-link {{ request()->is('admin/notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> Email & Notifications
                </a>
                <a href="/admin/broadcasts" class="admin-nav-link {{ request()->is('admin/broadcasts') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i> Send SMS & Email
                </a>
                <a href="/admin/cms" class="admin-nav-link {{ request()->is('admin/cms') ? 'active' : '' }}">
                    <i class="fas fa-file-code"></i> CMS Pages
                </a>
                <a href="/admin/settings" class="admin-nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Branding Settings
                </a>

                <span class="admin-nav-label">Admin Account</span>
                <a href="/admin/profile" class="admin-nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i> Master Profile
                </a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form-admin" class="d-none">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();" class="admin-nav-link text-danger mt-4">
                    <i class="fas fa-power-off"></i> Logout System
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Navbar -->
            <header class="admin-navbar shadow-sm">
                <div class="navbar-left">
                    <h5 class="fw-900 text-navy mb-0">System Control Center</h5>
                </div>
                <div class="navbar-right d-flex align-items-center gap-4">
                    <div class="notify-icon position-relative cursor-pointer">
                        <i class="fas fa-bell fs-5 text-muted"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px;">4</span>
                    </div>
                    <div class="admin-profile-pill d-flex align-items-center gap-3 ps-3 border-start">
                        <div class="text-end">
                            <h6 class="fw-800 text-navy mb-0" style="font-size: 13px;">Master Admin</h6>
                            <span class="text-muted small">Super Control</span>
                        </div>
                        <div class="avatar-circle bg-navy text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">MA</div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="admin-content">
                @yield('admin_content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

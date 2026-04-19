<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Amadeus B2B | Travel Consolidator Panel')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --b2b-blue: #0052cc;
            --b2b-blue-dark: #0747a6;
            --b2b-accent: #00b8d9;
            --b2b-bg: #f4f5f7;
            --b2b-sidebar-width: 260px;
            --b2b-card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --b2b-border: #dfe1e6;
            --b2b-text-main: #172b4d;
            --b2b-text-muted: #6b778c;
            --b2b-success: #36b37e;
            --b2b-warning: #ffab00;
            --b2b-danger: #ff5630;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--b2b-bg);
            color: var(--b2b-text-main);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .outfit {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        .b2b-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .b2b-sidebar {
            width: var(--b2b-sidebar-width);
            background: #0747a6; /* Deep Professional Blue */
            color: #ffffff;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 0, 0, 0.1);
        }

        .brand-logo {
            width: 35px;
            height: 35px;
            background: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--b2b-blue);
            font-weight: 900;
            font-size: 20px;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .sidebar-menu {
            padding: 15px 10px;
        }

        .menu-label {
            padding: 20px 15px 10px;
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .menu-item {
            margin-bottom: 4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .menu-link.active {
            background: var(--b2b-accent);
            color: #ffffff;
            font-weight: 600;
        }

        .menu-link i {
            width: 20px;
            font-size: 16px;
            opacity: 0.8;
        }

        .submenu {
            padding-left: 20px;
            margin-top: 5px;
            display: none;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            margin-left: 25px;
        }

        .menu-item.open .submenu {
            display: block;
        }

        .menu-item.open .chevron {
            transform: rotate(180deg);
        }

        .submenu-link {
            padding: 8px 15px;
            display: block;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: 0.2s;
        }

        .submenu-link:hover {
            color: #ffffff;
        }

        /* Main Content */
        .b2b-main {
            flex-grow: 1;
            margin-left: var(--b2b-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .b2b-header {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid var(--b2b-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .b2b-content {
            padding: 30px;
            flex-grow: 1;
        }

        /* Dashboard Components */
        .card-stat {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            border: none;
            box-shadow: var(--b2b-card-shadow);
            transition: transform 0.2s;
        }

        .card-stat:hover {
            transform: translateY(-4px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
        }

        /* Modern Tables */
        .b2b-table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--b2b-card-shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .b2b-table-card .card-header {
            padding: 20px 25px;
            background: #fff;
            border-bottom: 1px solid var(--b2b-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .b2b-table thead th {
            background: #f8f9fa;
            padding: 15px 20px;
            font-size: 11px;
            font-weight: 700;
            color: var(--b2b-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--b2b-border);
        }

        .b2b-table tbody td {
            padding: 15px 20px;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f1f1;
        }

        /* Badges */
        .b2b-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-success { background: #e3fcef; color: #006644; }
        .badge-warning { background: #fffadc; color: #826a00; }
        .badge-danger { background: #ffebe6; color: #bf2600; }
        .badge-info { background: #e6fcff; color: #008da6; }

        /* Buttons */
        .btn-b2b-primary {
            background: var(--b2b-blue);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-b2b-primary:hover {
            background: var(--b2b-blue-dark);
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 82, 204, 0.2);
        }

        /* Flight Search Card */
        .search-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--b2b-card-shadow);
            margin-bottom: 30px;
        }

        .form-control-b2b {
            background: #fff;
            border: 1px solid var(--b2b-border);
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-label-b2b {
            font-size: 12px;
            font-weight: 700;
            color: var(--b2b-text-muted);
            margin-bottom: 8px;
            display: block;
        }

        @media (max-width: 991px) {
            .b2b-sidebar { transform: translateX(-100%); }
            .b2b-sidebar.active { transform: translateX(0); }
            .b2b-main { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="b2b-wrapper">
        <!-- Sidebar -->
        <aside class="b2b-sidebar" id="b2bSidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">A</div>
                <div>
                    <div class="brand-name">AMADEUS</div>
                    <div style="font-size: 10px; opacity: 0.7; font-weight: 700;">PARTNER PANEL</div>
                </div>
            </div>

            <nav class="sidebar-menu">
                <div class="menu-item">
                    <a href="{{ route('amadeus.dashboard') }}" class="menu-link {{ request()->is('*amadeus-dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </div>

                <div class="menu-label">Booking Center</div>
                
                <div class="menu-item {{ request()->is('*booking*') || request()->is('*requests*') || request()->is('*issue-ticket*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-plane"></i> Flight Booking <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*booking*') || request()->is('*requests*') || request()->is('*issue-ticket*') ? 'display:block' : '' }}">
                        <a href="{{ route('amadeus.booking') }}" class="submenu-link {{ request()->routeIs('amadeus.booking') ? 'active' : '' }}">Search Flight</a>
                        <a href="{{ route('amadeus.requests') }}" class="submenu-link {{ request()->routeIs('amadeus.requests') ? 'active' : '' }}">My Bookings</a>
                        <a href="{{ route('amadeus.issue-ticket') }}" class="submenu-link {{ request()->routeIs('amadeus.issue-ticket') ? 'active' : '' }}">Issue Ticket</a>
                    </div>
                </div>

                <div class="menu-item {{ request()->is('*group*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-users"></i> Group Booking <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*group*') ? 'display:block' : '' }}">
                        <a href="{{ route('amadeus.group-request') }}" class="submenu-link {{ request()->routeIs('amadeus.group-request') ? 'active' : '' }}">Group Request</a>
                        <a href="{{ route('amadeus.manage-requests') }}" class="submenu-link {{ request()->routeIs('amadeus.manage-requests') ? 'active' : '' }}">Manage Requests</a>
                    </div>
                </div>

                <div class="menu-label">GDS Advanced</div>
                <div class="menu-item {{ request()->is('*gds*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-terminal"></i> GDS Operations <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*gds*') ? 'display:block' : '' }}">
                        <a href="{{ route('amadeus.gds') }}" class="submenu-link {{ request()->routeIs('amadeus.gds') ? 'active' : '' }}">GDS Command Center</a>
                        <a href="{{ route('amadeus.gds-monitoring') }}" class="submenu-link {{ request()->routeIs('amadeus.gds-monitoring') ? 'active' : '' }}">GDS Monitoring</a>
                    </div>
                </div>

                <div class="menu-label">Post-Booking</div>
                
                <div class="menu-item {{ request()->is('*queues*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-ticket-alt"></i> Queue Management <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*queues*') ? 'display:block' : '' }}">
                        <a href="{{ route('amadeus.queues-pending') }}" class="submenu-link {{ request()->routeIs('amadeus.queues-pending') ? 'active' : '' }}">Pending Tickets</a>
                        <a href="{{ route('amadeus.queues-cancellations') }}" class="submenu-link {{ request()->routeIs('amadeus.queues-cancellations') ? 'active' : '' }}">Cancellations</a>
                        <a href="{{ route('amadeus.queues-reissue') }}" class="submenu-link {{ request()->routeIs('amadeus.queues-reissue') ? 'active' : '' }}">Reissue & Reschedule</a>
                    </div>
                </div>

                <div class="menu-label">Financials</div>
                
                <div class="menu-item {{ request()->is('*wallet*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-wallet"></i> Wallet & Credit <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*wallet*') ? 'display:block' : '' }}">
                        <a href="{{ route('amadeus.wallet') }}" class="submenu-link {{ request()->routeIs('amadeus.wallet') ? 'active' : '' }}">Wallet Balance</a>
                        <a href="{{ route('amadeus.wallet-add') }}" class="submenu-link {{ request()->routeIs('amadeus.wallet-add') ? 'active' : '' }}">Add Balance Request</a>
                        <a href="{{ route('amadeus.wallet-credit') }}" class="submenu-link {{ request()->routeIs('amadeus.wallet-credit') ? 'active' : '' }}">Credit Limit</a>
                    </div>
                </div>

                <div class="menu-item">
                    <a href="{{ route('amadeus.markup') }}" class="menu-link {{ request()->routeIs('amadeus.markup') ? 'active' : '' }}">
                        <i class="fas fa-percentage"></i> Markup & Commission
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('amadeus.commissions') }}" class="menu-link {{ request()->routeIs('amadeus.commissions') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i> Commissions & Fees
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('amadeus.news') }}" class="menu-link {{ request()->routeIs('amadeus.news') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i> News & Promos
                    </a>
                </div>

                <div class="menu-label">Network</div>
                
                <div class="menu-item {{ request()->is('*cargo*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-boxes-packing"></i> Global Cargo <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*cargo*') ? 'display:block' : '' }}">
                        <a href="{{ route('cargo.dashboard.index') }}" class="submenu-link">User Search View</a>
                        <a href="{{ route('admin.cargo.index') }}" class="submenu-link">Manage Logistics</a>
                        <a href="{{ route('cargo.support.warehouse') }}" class="submenu-link">Hub Processing</a>
                    </div>
                </div>

                <div class="menu-item">
                    <a href="{{ route('amadeus.agents') }}" class="menu-link {{ request()->routeIs('amadeus.agents') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i> Agent Management
                    </a>
                </div>

                <div class="menu-item {{ request()->is('*reports*') ? 'open' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleMenu(this)">
                        <i class="fas fa-chart-line"></i> Reports Center <i class="fas fa-chevron-down ms-auto chevron" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu" style="{{ request()->is('*reports*') ? 'display:block' : '' }}">
                        <a href="{{ route('amadeus.reports') }}" class="submenu-link {{ request()->routeIs('amadeus.reports') ? 'active' : '' }}">Sales Report</a>
                        <a href="{{ route('amadeus.reports-profit') }}" class="submenu-link {{ request()->routeIs('amadeus.reports-profit') ? 'active' : '' }}">Profit Report</a>
                        <a href="{{ route('amadeus.reports-performance') }}" class="submenu-link {{ request()->routeIs('amadeus.reports-performance') ? 'active' : '' }}">Agent Performance</a>
                    </div>
                </div>

                <div class="menu-label">System</div>
                
                <div class="menu-item">
                    <a href="{{ route('amadeus.settings') }}" class="menu-link {{ request()->routeIs('amadeus.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Agency Settings
                    </a>
                </div>

                <div class="menu-item mt-5">
                    <a href="#" class="menu-link text-white-50" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout System
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="b2b-main">
            <header class="b2b-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn d-lg-none" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="d-none d-md-flex flex-column">
                        <span class="text-muted fw-700" style="font-size: 10px; text-transform: uppercase;">Consolidator View</span>
                        <h5 class="mb-0">Partner Dashboard</h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-4">
                    <!-- Global Search -->
                    <div class="position-relative d-none d-lg-block">
                        <i class="fas fa-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control-b2b ps-5" placeholder="Search PNR, Ticket..." style="width: 250px;">
                    </div>

                    <!-- Financial Summary -->
                    <div class="d-flex gap-3 px-4 border-start border-end">
                        <div class="text-end">
                            <div class="text-muted fw-700 uppercase" style="font-size: 9px;">Wallet</div>
                            <div class="fw-800 text-success">₹14,52,800</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted fw-700 uppercase" style="font-size: 9px;">Used Credit</div>
                            <div class="fw-800 text-primary">₹3,20,000</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light rounded-circle position-relative" style="width: 42px; height: 42px;">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px;">12</span>
                        </button>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px;">JC</div>
                            <div class="d-none d-lg-block">
                                <div class="fw-700" style="font-size: 14px;">John Consolidator</div>
                                <div class="text-muted" style="font-size: 11px;">IATA Code: 1234567</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="b2b-content" id="mainContent">
                @yield('content')
            </div>
        </main>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('b2bSidebar').classList.toggle('active');
        }

        function toggleMenu(el) {
            el.parentElement.classList.toggle('open');
            var submenu = el.nextElementSibling;
            if (submenu.style.display === "block") {
                submenu.style.display = "none";
            } else {
                submenu.style.display = "block";
            }
        }
    </script>
    @yield('scripts')
</body>
</html>

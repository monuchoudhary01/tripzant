<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IATA Agent Panel | Enterprise Airline Ticketing')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --iata-blue: #1e40af;
            --iata-blue-light: #3b82f6;
            --iata-navy: #0f172a;
            --iata-bg: #f8fafc;
            --iata-sidebar-width: 280px;
            --iata-card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --iata-border: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--iata-bg);
            color: #1e293b;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .outfit {
            font-family: 'Outfit', sans-serif;
        }

        .iata-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .iata-sidebar {
            width: var(--iata-sidebar-width);
            background: #ffffff;
            border-right: 1px solid var(--iata-border);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 30px 25px;
            border-bottom: 1px solid var(--iata-border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand .brand-logo {
            width: 40px;
            height: 40px;
            background: var(--iata-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 800;
        }

        .sidebar-brand .brand-name {
            font-weight: 800;
            font-size: 20px;
            color: var(--iata-navy);
            letter-spacing: -0.5px;
        }

        .sidebar-brand .brand-tag {
            font-size: 10px;
            font-weight: 700;
            color: var(--iata-blue);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-top: -5px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-section {
            padding: 20px 25px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .menu-item {
            padding: 2px 15px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 10px;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-link:hover {
            background-color: #f1f5f9;
            color: var(--iata-blue);
        }

        .menu-link.active {
            background-color: var(--iata-blue);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        .submenu {
            padding-left: 32px;
            margin-top: 5px;
            display: none;
        }

        .menu-item.active .submenu {
            display: block;
        }

        .submenu-link {
            display: block;
            padding: 8px 15px;
            font-size: 13px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            border-left: 1px solid var(--iata-border);
            transition: all 0.2s;
        }

        .submenu-link:hover, .submenu-link.active {
            color: var(--iata-blue);
            border-left-color: var(--iata-blue);
            font-weight: 700;
        }

        /* Main Content */
        .iata-main {
            flex-grow: 1;
            margin-left: var(--iata-sidebar-width);
            transition: all 0.3s ease;
        }

        .top-navbar {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid var(--iata-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-content {
            padding: 30px 40px;
        }

        /* Stats Cards */
        .stats-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--iata-border);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--iata-card-shadow);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .bg-blue-soft { background-color: #eff6ff; color: #1e40af; }
        .bg-green-soft { background-color: #f0fdf4; color: #166534; }
        .bg-orange-soft { background-color: #fff7ed; color: #9a3412; }
        .bg-teal-soft { background-color: #f0fdfa; color: #0f766e; }

        .btn-iata {
            background-color: var(--iata-blue);
            color: #ffffff;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s;
        }

        .btn-iata:hover {
            background-color: var(--iata-navy);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Tables */
        .table-container {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--iata-border);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .table-premium th {
            background: #f8fafc;
            padding: 16px 24px;
            font-weight: 700;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--iata-border);
        }

        .table-premium td {
            padding: 16px 24px;
            font-size: 14px;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-pending { background: #e0f2fe; color: #0369a1; }
        .badge-danger { background: #fee2e2; color: #991b1b; }

        @media (max-width: 991px) {
            .iata-sidebar { left: -100%; }
            .iata-sidebar.active { left: 0; }
            .iata-main { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="iata-wrapper">
        <!-- Sidebar -->
        <aside class="iata-sidebar" id="iataSidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">I</div>
                <div>
                    <span class="brand-name">TRIP ZANT</span>
                    <span class="brand-tag">IATA Agent Panel</span>
                </div>
            </div>

            <nav class="sidebar-menu">
                <div class="menu-item">
                    <a href="{{ route('iata.dashboard') }}" class="menu-link {{ request()->is('iata-dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </div>

                <div class="menu-section">Booking Operations</div>
                
                <!-- 2. Flight Booking -->
                <div class="menu-item {{ request()->is('*flight*') ? 'active' : '' }}">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-plane-departure"></i> Flight Booking <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('iata.flight.search') }}" class="submenu-link {{ request()->is('*search*') ? 'active' : '' }}">Search Flight</a>
                        <a href="#" class="submenu-link">Flight Results</a>
                        <a href="#" class="submenu-link">Passenger Details</a>
                        <a href="#" class="submenu-link">Issue Ticket</a>
                        <a href="{{ route('iata.flight.pnr-list') }}" class="submenu-link {{ request()->is('*pnr-list*') ? 'active' : '' }}">My Bookings</a>
                    </div>
                </div>

                <!-- 3. Group Booking -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-users-class"></i> Group Booking <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Group Request Form</a>
                        <a href="#" class="submenu-link">Manage Requests</a>
                        <a href="#" class="submenu-link">Quotations</a>
                    </div>
                </div>

                <!-- 4. Booking Management -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-clipboard-list"></i> Booking Management <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">All Bookings</a>
                        <a href="#" class="submenu-link">Pending Bookings</a>
                        <a href="#" class="submenu-link">Cancelled</a>
                        <a href="#" class="submenu-link">Failed</a>
                    </div>
                </div>

                <div class="menu-section">Post-Booking</div>

                <!-- 5. Cancellation & Refund -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-undo-alt"></i> Cancel & Refund <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Cancel Ticket</a>
                        <a href="#" class="submenu-link">Refund Status</a>
                        <a href="#" class="submenu-link">Refund History</a>
                    </div>
                </div>

                <!-- 6. Reissue / Reschedule -->
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-calendar-alt"></i> Reissue / Reschedule
                    </a>
                </div>

                <div class="menu-section">Financials</div>

                <!-- 7. Wallet -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-wallet"></i> Wallet <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Wallet Balance</a>
                        <a href="#" class="submenu-link">Add Balance Request</a>
                        <a href="#" class="submenu-link">Transaction History</a>
                    </div>
                </div>

                <!-- 8. Credit Management -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-credit-card"></i> Credit management <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Credit Limit</a>
                        <a href="#" class="submenu-link">Used Credit</a>
                        <a href="#" class="submenu-link">Remaining Credit</a>
                    </div>
                </div>

                <!-- 9. Commission / Markup -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-percentage"></i> Markup & Commission <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Flight Markup</a>
                        <a href="#" class="submenu-link">Agent-wise Commission</a>
                        <a href="#" class="submenu-link">Dynamic Pricing</a>
                    </div>
                </div>

                <div class="menu-section">Administration</div>

                <!-- 10. Agent Management -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-user-friends"></i> Agent Management <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Add Sub-Agent</a>
                        <a href="#" class="submenu-link">Agent List</a>
                        <a href="#" class="submenu-link">Block / Activate</a>
                    </div>
                </div>

                <!-- 11. Reports -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-chart-pie"></i> Reports Center <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Booking Report</a>
                        <a href="#" class="submenu-link">Sales Report</a>
                        <a href="#" class="submenu-link">Agent Report</a>
                        <a href="#" class="submenu-link">Profit Report</a>
                    </div>
                </div>

                <!-- 12. Accounting -->
                <div class="menu-item">
                    <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                        <i class="fas fa-file-invoice-dollar"></i> Accounting <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
                    </a>
                    <div class="submenu">
                        <a href="#" class="submenu-link">Ledger</a>
                        <a href="#" class="submenu-link">Credit / Debit</a>
                        <a href="#" class="submenu-link">Invoice</a>
                    </div>
                </div>

                <!-- 13. Notifications -->
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-bell"></i> Alerts & Logs
                    </a>
                </div>

                <!-- 14. Settings -->
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-cog"></i> Panel Settings
                    </a>
                </div>

                <div class="menu-item mt-auto pt-4">
                    <a href="#" class="menu-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout System
                    </a>
                </div>

                <div class="mt-4 px-4 pb-5">
                    <div class="bg-blue-soft p-4 rounded-3 border border-primary border-opacity-10">
                        <div class="small fw-800 text-navy mb-1 uppercase" style="font-size: 10px;">Support Status</div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="d-inline-block bg-success rounded-circle" style="width: 8px; height: 8px;"></span>
                            <span class="fw-700 text-success" style="font-size: 11px;">Active Helpdesk</span>
                        </div>
                        <a href="#" class="btn btn-iata w-100 py-2" style="font-size: 12px; background: #000;">Contact Support</a>
                    </div>
                </div>
            </nav>

        </aside>

        <!-- Main Content -->
        <main class="iata-main">
            <header class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn d-lg-none" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="d-none d-md-flex align-items-center gap-4">
                        <h5 class="fw-800 text-navy mb-0 outfit">Partner Panel</h5>
                        
                        <div class="d-flex gap-3 border-start ps-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted fw-700 uppercase" style="font-size: 9px;">Wallet Balance</span>
                                <span class="fw-800 text-success" style="font-size: 14px;">₹1,45,280.00</span>
                            </div>
                            <div class="d-flex flex-column border-start ps-3">
                                <span class="text-muted fw-700 uppercase" style="font-size: 9px;">Credit Limit</span>
                                <span class="fw-800 text-primary" style="font-size: 14px;">₹5,00,000.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex gap-2">
                        <button class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px;"><i class="fas fa-search text-muted"></i></button>
                        <button class="btn btn-light rounded-circle shadow-sm position-relative" style="width: 40px; height: 40px;">
                            <i class="fas fa-bell text-muted"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px;">5</span>
                        </button>
                    </div>
                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-3 ps-3 border-start" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                            <div class="text-end d-none d-sm-block">
                                <div class="fw-800 text-navy mb-0" style="font-size: 14px;">{{ Auth::user()->name ?? 'Sub-Agent' }}</div>
                                <div class="text-muted fw-700 uppercase" style="font-size: 9px;">ID: AT-992042</div>
                            </div>
                            <div class="avatar bg-blue-soft rounded-circle d-flex align-items-center justify-content-center fw-800 outfit" style="width: 42px; height: 42px; border: 2px solid #fff;">
                                {{ substr(Auth::user()->name ?? 'S', 0, 1) }}
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-2" style="border-radius: 12px; min-width: 200px;">
                            <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="fas fa-user-circle me-2 text-muted"></i> Agent Profile</a></li>
                            <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="fas fa-wallet me-2 text-muted"></i> Wallet Topup</a></li>
                            <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="fas fa-cog me-2 text-muted"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item rounded-2 py-2 text-danger fw-600" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>


            <div class="navbar-content">
                @yield('iata_content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('iataSidebar').classList.toggle('active');
        }
        function toggleSubmenu(e, el) {
            e.preventDefault();
            el.closest('.menu-item').classList.toggle('active');
        }
    </script>
    @yield('scripts')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</body>
</html>

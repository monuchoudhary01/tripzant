<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Dashboard - Tripzant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #0076f7;
            --primary-light: #eff6ff;
            --bg-main: #f8fafc;
            --sidebar-bg: #1e293b;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #f1f5f9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 30px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
            font-weight: 800;
            font-size: 22px;
            letter-spacing: -0.5px;
        }

        .sidebar-menu {
            padding: 12px;
            list-style: none;
            margin: 0;
        }

        .menu-label {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 16px 10px;
        }

        .menu-item {
            margin-bottom: 4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .menu-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 8px 15px rgba(0, 118, 247, 0.3);
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            font-size: 18px;
            opacity: 0.8;
        }

        /* Topbar Styles */
        .topbar {
            height: 80px;
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 110px 40px 40px;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="/" class="sidebar-brand">
            <div class="bg-primary p-2 rounded-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-rocket text-white"></i>
            </div>
            <span>AFFILIATE</span>
        </a>
        
        <ul class="sidebar-menu">
            <li class="menu-label">Main Menu</li>
            <li class="menu-item">
                <a href="{{ route('affiliate.dashboard.index') }}" class="menu-link {{ request()->routeIs('affiliate.dashboard.*') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>

            <li class="menu-label">Earnings & Network</li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-users"></i> Referrals
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-wallet"></i> Commissions
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-money-bill-transfer"></i> Withdrawals
                </a>
            </li>

            <li class="menu-label">Management</li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-user-circle"></i> My Profile
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link text-warning">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>
            
            <li class="mt-5">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                <a href="#" class="menu-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Topbar -->
    <header class="topbar">
        <div class="d-flex align-items-center">
            <h5 class="fw-bold mb-0 text-navy">Welcome back, {{ auth()->user()->name }}</h5>
        </div>
        <div class="d-flex align-items-center gap-4">
            <div class="nav-item d-none d-md-block">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold">
                    <i class="fas fa-check-circle me-1"></i> Verified Account
                </span>
            </div>
            <div class="vr mx-2"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-lg-block">
                    <h6 class="mb-0 fw-bold small">{{ auth()->user()->name }}</h6>
                    <p class="mb-0 text-muted smaller">Affiliate Partner</p>
                </div>
                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

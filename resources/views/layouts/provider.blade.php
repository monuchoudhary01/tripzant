<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard - Tripzant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --bg-main: #f8fafc;
            --sidebar-bg: #ffffff;
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
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 800;
            font-size: 20px;
        }

        .sidebar-menu {
            padding: 12px;
            list-style: none;
            margin: 0;
        }

        .menu-item {
            margin-bottom: 4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .menu-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        /* Topbar Styles */
        .topbar {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 100px 32px 40px;
            min-height: 100vh;
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .bg-pending { background: #fef3c7; color: #92400e; }
        .bg-accepted { background: #dcfce7; color: #166534; }
        .bg-completed { background: #d1fae5; color: #065f46; }
        .bg-rejected { background: #fee2e2; color: #991b1b; }

        /* Stats Cards */
        .stat-card {
            padding: 24px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .pulse {
            position: relative;
        }
        .pulse::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 8px; height: 8px;
            background: #ef4444;
            border: 2px solid #fff;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="fas fa-map-location-dot"></i>
            <span>TRIPZANT</span>
        </a>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="{{ route('provider.dashboard') }}" class="menu-link {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}"><i class="fas fa-columns"></i> Dashboard</a></li>
            <li class="menu-item"><a href="{{ route('provider.profile') }}" class="menu-link {{ request()->routeIs('provider.profile') ? 'active' : '' }}"><i class="fas fa-user"></i> My Profile</a></li>
            <li class="menu-item"><a href="{{ route('provider.services') }}" class="menu-link {{ request()->routeIs('provider.services') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> My Services</a></li>
            <li class="menu-item"><a href="{{ route('provider.hotels') }}" class="menu-link {{ request()->routeIs('provider.hotels') ? 'active' : '' }}"><i class="fas fa-hotel"></i> Search Hotels</a></li>
            <li class="menu-item"><a href="{{ route('provider.tour-builders') }}" class="menu-link {{ request()->routeIs('provider.tour-builders') ? 'active' : '' }}"><i class="fas fa-route"></i> Tour Builders</a></li>
            <li class="menu-item"><a href="{{ route('provider.requests') }}" class="menu-link {{ request()->routeIs('provider.requests') ? 'active' : '' }} pulse"><i class="fas fa-bell"></i> Incoming Requests</a></li>
            <li class="menu-item"><a href="{{ route('provider.bookings') }}" class="menu-link {{ request()->routeIs('provider.bookings') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i> My Bookings</a></li>
            <li class="menu-item"><a href="{{ route('provider.earnings') }}" class="menu-link {{ request()->routeIs('provider.earnings') ? 'active' : '' }}"><i class="fas fa-wallet"></i> Earnings</a></li>
            <li class="menu-item"><a href="{{ route('provider.reviews') }}" class="menu-link {{ request()->routeIs('provider.reviews') ? 'active' : '' }}"><i class="fas fa-star"></i> Reviews</a></li>
        </ul>
    </aside>

    <!-- Topbar -->
    <header class="topbar">
        <div class="search-box">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Search anything...">
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="nav-item">
                <a href="#" class="btn btn-light rounded-circle p-2 position-relative">
                    <i class="far fa-comment"></i>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="btn btn-light rounded-circle p-2 position-relative">
                    <i class="far fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger p-1"></span>
                </a>
            </div>
            <div class="vr mx-2"></div>
            <div class="d-flex align-items-center gap-3 ps-2">
                <div class="text-end d-none d-md-block">
                    <h6 class="mb-0 fw-700 small">Rahul Sharma</h6>
                    <p class="mb-0 text-muted smaller">Local Guide</p>
                </div>
                <img src="https://i.pravatar.cc/150?u=rahul" alt="User" class="rounded-circle border" width="40" height="40">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

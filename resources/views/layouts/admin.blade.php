<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    
    <!-- Sneat Style Resources -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --sneat-primary: #696cff;
            --sneat-secondary: #8592a3;
            --sneat-success: #71dd37;
            --sneat-danger: #ff3e1d;
            --sneat-warning: #ffab00;
            --sneat-info: #03c3ec;
            --sneat-light: #f5f5f9;
            --sneat-card-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            --sneat-font: 'Public Sans', sans-serif;
        }

        body {
            font-family: var(--sneat-font);
            background-color: #f5f5f9;
            color: #566a7f;
            overflow-x: hidden;
            font-size: 0.9375rem;
        }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 260px;
            background: #fff;
            position: fixed;
            height: 100vh;
            left: 0; top: 0;
            z-index: 1001;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, 0.4);
        }

        .admin-wrapper.collapsed .admin-sidebar { width: 80px; }
        .admin-wrapper.collapsed .admin-nav-label,
        .admin-wrapper.collapsed .flex-grow-1,
        .admin-wrapper.collapsed .arrow-icon { display: none; }
        .admin-wrapper.collapsed .admin-nav-link { justify-content: center; padding: 0.625rem; }
        .admin-wrapper.collapsed .admin-logo-area { justify-content: center; padding: 1rem 0; }
        .admin-wrapper.collapsed .admin-logo-area img { height: 30px; }

        .admin-logo-area {
            padding: 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f5f5f9;
            margin-bottom: 1rem;
        }

        .admin-nav { padding: 0 0.75rem 2rem 0.75rem; }
        .admin-nav-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #b4bdc6;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 1.5rem 0 0.5rem 1rem;
            display: block;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 1.2rem;
            border-radius: 0.5rem;
            color: #566a7f;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 4px;
        }

        .admin-nav-link:hover {
            background-color: #f5f5f9;
            color: var(--sneat-primary);
            transform: translateX(4px);
        }

        .admin-nav-link.active {
            background: linear-gradient(72.47deg, var(--sneat-primary) 22.16%, rgba(105, 108, 255, 0.7) 76.47%);
            color: #fff !important;
            box-shadow: 0 4px 12px 0 rgba(105, 108, 255, 0.3);
        }
        
        .admin-nav-link i { font-size: 1.4rem; transition: transform 0.2s; }
        .admin-nav-link:hover i { transform: scale(1.1); }
        
        /* Submenu Styling */
        .admin-menu-sub {
            list-style: none;
            padding: 0;
            margin: 0.25rem 0 0.5rem 1rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            border-left: 2px solid #f5f5f9;
        }
        .nav-item-wrapper.open .admin-menu-sub { 
            max-height: 800px;
        }
        .admin-menu-sub .admin-nav-link {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
        }
        .nav-item-wrapper.open .arrow-icon { transform: rotate(90deg); }
        .arrow-icon { transition: transform 0.3s ease; font-size: 1rem !important; }
        .flex-grow-1 { flex-grow: 1; white-space: nowrap; }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }
        .admin-wrapper.collapsed .admin-main { margin-left: 80px; }

        .admin-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            margin: 1rem 1.5rem;
            padding: 0 1.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
            box-shadow: 0 2px 10px 0 rgba(0,0,0,0.05);
            position: sticky;
            top: 1rem;
            z-index: 1000;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .admin-content { 
            padding: 1rem 1.5rem 2.5rem 1.5rem; 
            flex: 1;
        }

        /* Sneat Cards */
        .card-sneat {
            background: #fff;
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            margin-bottom: 1.5rem;
            position: relative;
        }
        .card-sneat .card-header {
            background: transparent;
            border-bottom: none;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-sneat .card-body { padding: 1.5rem; }

        /* Avatars */
        .avatar {
            position: relative;
            width: 2.375rem;
            height: 2.375rem;
            cursor: pointer;
            display: inline-block;
        }
        .avatar-initial {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background-color: #eee;
            font-weight: 500;
        }
        .bg-label-primary { background-color: #e7e7ff; color: #696cff; }
        .bg-label-success { background-color: #e8fadf; color: #71dd37; }
        .bg-label-info { background-color: #d7f5fc; color: #03c3ec; }
        .bg-label-warning { background-color: #fff2d6; color: #ffab00; }
        .bg-label-danger { background-color: #ffe5e0; color: #ff3e1d; }

        /* Buttons */
        .btn-sneat {
            padding: 0.4375rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
        }
        .btn-sneat-primary {
            background-color: var(--sneat-primary);
            border-color: var(--sneat-primary);
            color: #fff;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(105, 108, 255, 0.4);
        }
        .btn-sneat-primary:hover {
            background-color: #5f61e6;
            border-color: #5f61e6;
            color: #fff;
            transform: translateY(-1px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d9dee3; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-logo-area">
                <img src="/img/logo.svg" height="40" alt="Trip Zant Admin">
            </div>

            <nav class="admin-nav">
                <a href="/admin-dashboard" class="admin-nav-link {{ request()->is('admin-dashboard') ? 'active' : '' }}">
                    <i class="bx bx-home-circle"></i> Dashboard
                </a>
                
                <div class="nav-item-wrapper {{ request()->is('admin/users*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="admin-nav-link menu-toggle {{ request()->is('admin/users*') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                        <i class="bx bx-user"></i>
                        <div class="flex-grow-1">Users Management</div>
                        <i class="bx bx-chevron-right arrow-icon"></i>
                    </a>
                    <ul class="admin-menu-sub">
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="admin-nav-link small {{ request()->is('admin/users') && !request()->has('role') ? 'active' : '' }}">
                                <i class="bx bx-list-ul"></i> All Users
                            </a>
                        </li>
                        @php $sidebarRoles = \App\Models\Role::where('slug', '!=', 'admin')->get(); @endphp
                        @foreach($sidebarRoles as $sRole)
                        <li>
                            <a href="{{ route('admin.users.index', ['role' => $sRole->slug]) }}" class="admin-nav-link small {{ request('role') == $sRole->slug ? 'active' : '' }}">
                                <i class="bx bx-circle"></i> {{ $sRole->name }}
                            </a>
                        </li>
                        @endforeach
                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="admin-nav-link small {{ request()->is('admin/roles*') ? 'active' : '' }}">
                                <i class="bx bx-cog"></i> Manage Roles
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('admin.users.requests') }}" class="admin-nav-link {{ request()->is('admin/users/requests') ? 'active' : '' }}">
                    <i class="bx bx-handshake"></i> Requests
                </a>
                
                <span class="admin-nav-label">Inventory Control</span>
                <a href="/admin/flights" class="admin-nav-link {{ request()->is('admin/flights') ? 'active' : '' }}">
                    <i class="bx bx-paper-plane"></i> Flights Control
                </a>
                
                <a href="/admin/hotels" class="admin-nav-link {{ request()->is('admin/hotels') ? 'active' : '' }}">
                    <i class="bx bx-hotel"></i> Hotels Control
                </a>
                
                <a href="/admin/tours" class="admin-nav-link {{ request()->is('admin/tours') ? 'active' : '' }}">
                    <i class="bx bx-package"></i> Tours & Packages
                </a>
                
                <a href="/admin/visa" class="admin-nav-link {{ request()->is('admin/visa*') ? 'active' : '' }}">
                    <i class="bx bx-id-card"></i> Visa Management
                </a>
                <a href="/admin/bookings" class="admin-nav-link {{ request()->is('admin/bookings') ? 'active' : '' }}">
                    <i class="bx bx-calendar-check"></i> All Bookings
                </a>
                <a href="{{ route('admin.audit-logs.index') }}" class="admin-nav-link {{ request()->is('admin/audit-logs*') ? 'active' : '' }}">
                    <i class="bx bx-list-ul"></i> Audit Logs
                </a>

                <span class="admin-nav-label">Cargo & Logistics</span>
                <a href="{{ route('admin.cargo.index') }}" class="admin-nav-link {{ request()->is('admin/cargo') ? 'active' : '' }}">
                    <i class="bx bx-box"></i> Cargo Dashboard
                </a>

                <span class="admin-nav-label">Affiliate & Partnerships</span>
                <a href="{{ route('admin.partnership.dashboard') }}" class="admin-nav-link {{ request()->is('admin/partnership/dashboard') ? 'active' : '' }}">
                    <i class="bx bx-stats"></i> Partner Dashboard
                </a>
                <a href="{{ route('admin.partnership.checker') }}" class="admin-nav-link {{ request()->is('admin/partnership/checker') ? 'active' : '' }}">
                    <i class="bx bx-globe"></i> Traffic Checker
                </a>
                <a href="{{ route('admin.partnership.revenue') }}" class="admin-nav-link {{ request()->is('admin/partnership/revenue') ? 'active' : '' }}">
                    <i class="bx bx-dollar-circle"></i> Partner Revenue
                </a>

                <span class="admin-nav-label">Management & Finance</span>
                <a href="{{ route('admin.money-transfer.index') }}" class="admin-nav-link {{ request()->is('admin/money-transfer*') ? 'active' : '' }}">
                    <i class="bx bx-transfer-alt"></i> Money Transfer
                </a>
                <a href="{{ route('accounting.dashboard') }}" class="admin-nav-link {{ request()->is('accounting*') ? 'active' : '' }}">
                    <i class="bx bx-calculator"></i> Accounting Terminal
                </a>

                <span class="admin-nav-label">Configuration</span>
                <a href="{{ route('admin.offers.index') }}" class="admin-nav-link {{ request()->is('admin/offers*') ? 'active' : '' }}">
                    <i class="bx bx-gift"></i> Offers Management
                </a>
                <a href="/admin/settings" class="admin-nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                    <i class="bx bx-cog"></i> Branding Settings
                </a>

                <span class="admin-nav-label">Admin Account</span>
                <a href="/admin/profile" class="admin-nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
                    <i class="bx bx-user-circle"></i> Master Profile
                </a>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form-admin" class="d-none">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();" class="admin-nav-link text-danger mt-4 mb-5">
                    <i class="bx bx-power-off"></i> Logout System
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Navbar -->
            <header class="admin-navbar">
                <div class="d-flex align-items-center">
                    <i class="bx bx-menu fs-4 me-3 cursor-pointer" onclick="toggleSidebar()"></i>
                    <div class="input-group input-group-merge shadow-none border-0" style="width: 300px;">
                        <span class="input-group-text bg-transparent border-0"><i class="bx bx-search fs-4"></i></span>
                        <input type="text" class="form-control bg-transparent border-0 shadow-none" placeholder="Search (Ctrl+/)">
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-online">
                        <div class="bg-label-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">MA</div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.admin-wrapper').classList.toggle('collapsed');
        }

        function toggleSubmenu(el) {
            const wrapper = el.parentElement;
            wrapper.classList.toggle('open');
        }
    </script>
    @stack('scripts')
</body>
</html>

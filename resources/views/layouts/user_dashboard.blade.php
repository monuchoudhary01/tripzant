<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard | Trip Zant')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root { --primary: #0b3d61; --secondary: #f97316; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); }
        .sidebar { width: 280px; background: white; border-right: 1px solid #e2e8f0; position: fixed; height: 100vh; overflow-y: auto; }
        .main-content { margin-left: 280px; padding: 40px; }
        .nav-item { padding: 5px 20px; }
        .nav-link { 
            display: flex; align-items: center; gap: 15px; padding: 12px 20px; 
            border-radius: 12px; color: #64748b; font-weight: 700; transition: 0.2s;
        }
        .nav-link:hover, .nav-link.active { background: rgba(11, 61, 97, 0.05); color: var(--primary); }
        .nav-link i { width: 24px; text-align: center; }
        .badge-new { background: var(--secondary); color: white; font-size: 10px; padding: 2px 8px; border-radius: 10px; }
        @media (max-width: 991px) { .sidebar { display: none; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar py-4 position-fixed shadow-sm">
            <div class="px-4 mb-4">
                <a href="/"><img src="/img/logo.svg" height="40" alt="Logo"></a>
            </div>
            
            <div class="nav flex-column mt-4">
                @if(request()->is('user-cargo*'))
                    <!-- USER CARGO SIDEBAR -->
                    <div class="px-4 mb-2 text-uppercase x-small fw-800 text-muted ls-1" style="font-size: 11px;">Shipment Portal</div>
                    <a href="{{ route('cargo.dashboard.index') }}" class="nav-link {{ request()->routeIs('cargo.dashboard.index') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Overview
                    </a>
                    <a href="{{ route('cargo.dashboard.book') }}" class="nav-link {{ request()->routeIs('cargo.dashboard.book') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> New Booking <span class="badge bg-success ms-1" style="font-size: 8px;">FAST</span>
                    </a>
                    <a href="{{ route('cargo.dashboard.index') }}?tab=tracking" class="nav-link">
                        <i class="fas fa-map-marker-alt"></i> Live Tracking
                    </a>
                @elseif(request()->is('cargo-agent*'))
                    <!-- AGENT/DRIVER SIDEBAR -->
                    <div class="px-4 mb-2 text-uppercase x-small fw-800 text-muted ls-1" style="font-size: 11px;">Agent Terminal</div>
                    <a href="{{ route('cargo.agent.dashboard') }}" class="nav-link {{ request()->routeIs('cargo.agent.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-route text-primary"></i> Today's Pickups
                    </a>
                    <a href="{{ route('cargo.agent.earnings') }}" class="nav-link {{ request()->routeIs('cargo.agent.earnings') ? 'active' : '' }}">
                        <i class="fas fa-wallet text-success"></i> My Earnings
                    </a>
                    <a href="{{ route('cargo.agent.history') }}" class="nav-link {{ request()->routeIs('cargo.agent.history') ? 'active' : '' }}">
                        <i class="fas fa-history text-secondary"></i> Job History
                    </a>
                    
                    <div class="px-3 mt-4 mb-2 text-uppercase x-small fw-800 text-muted ls-1" style="font-size: 11px;">Partnership</div>
                    <a href="{{ route('cargo.agent.api.index') }}" class="nav-link {{ request()->routeIs('cargo.agent.api.index') ? 'active' : '' }}">
                        <i class="fas fa-code text-info"></i> B2B API Portal <span class="badge bg-danger ms-auto px-2" style="font-size: 9px;">BUILDER</span>
                    </a>
                @endif

                <div class="px-3 mt-4 mb-2 text-uppercase x-small fw-800 text-muted ls-1" style="font-size: 11px;">Financial Services</div>
                <a href="{{ route('money-transfer.index') }}" class="nav-link {{ request()->is('money-transfer*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-transfer text-success"></i> Send & Compare Money
                </a>

                <div class="mt-auto px-4 py-3">
                    <a href="/logout" class="nav-link text-danger border-top pt-3 mt-3">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </aside>

        <main class="main-content w-100">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="fw-bold text-dark">@yield('title')</h4>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end d-none d-md-block">
                            <h6 class="mb-0 fw-700">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ request()->is('cargo-agent*') ? 'Logistic Agent' : 'Premium Member' }}</small>
                        </div>
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 14px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>
            
            @yield('content')
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>

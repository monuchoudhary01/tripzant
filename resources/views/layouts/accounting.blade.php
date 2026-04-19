<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounting Terminal | Easitrip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --acc-bg: #030712;
            --acc-sidebar: #090e1a;
            --acc-card: rgba(17, 24, 39, 0.8);
            --acc-accent: #3b82f6;
            --acc-text: #f3f4f6;
            --acc-muted: #9ca3af;
            --acc-border: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--acc-bg);
            color: var(--acc-text);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .acc-sidebar {
            width: 280px;
            background: var(--acc-sidebar);
            border-right: 1px solid var(--acc-border);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0; top: 0;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 3rem;
            padding-left: 0.5rem;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--acc-accent), #60a5fa);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .brand-name {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--acc-muted);
            margin-bottom: 1rem;
            font-weight: 600;
            opacity: 0.5;
        }

        .acc-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .acc-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--acc-muted);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .acc-nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .acc-nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .acc-nav-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: var(--acc-accent);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Content Area */
        .acc-main {
            flex: 1;
            margin-left: 280px;
            padding: 2rem 3rem;
        }

        .acc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--acc-card);
            padding: 8px 16px;
            border-radius: 100px;
            border: 1px solid var(--acc-border);
        }

        .avatar {
            width: 32px;
            height: 32px;
            background: #4b5563;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
        }

        /* Glass Cards */
        .glass-card {
            background: var(--acc-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--acc-border);
            border-radius: 24px;
            padding: 2rem;
        }

        .btn-acc-primary {
            background: var(--acc-accent);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-acc-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
            color: #fff;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }

        @media (max-width: 1024px) {
            .acc-sidebar { width: 80px; padding: 2rem 1rem; }
            .brand-name, .nav-label, .acc-nav-link span { display: none; }
            .acc-main { margin-left: 80px; }
        }
    </style>
</head>
<body>
    <aside class="acc-sidebar">
        <div class="brand-area">
            <div class="brand-logo">ET</div>
            <div class="brand-name">Acc-Panel</div>
        </div>

        <nav class="acc-nav">
            <span class="nav-label">Core</span>
            <a href="{{ route('accounting.dashboard') }}" class="acc-nav-link {{ request()->routeIs('accounting.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('accounting.ledger') }}" class="acc-nav-link {{ request()->routeIs('accounting.ledger') ? 'active' : '' }}">
                <i class="fas fa-book"></i> <span>Bookings Ledger</span>
            </a>
            <a href="{{ route('accounting.transactions') }}" class="acc-nav-link">
                <i class="fas fa-list-ul"></i> <span>Transactions</span>
            </a>

            <span class="nav-label mt-4">Billing</span>
            <a href="{{ route('accounting.invoices') }}" class="acc-nav-link {{ request()->routeIs('accounting.invoices') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> <span>Invoices</span>
            </a>
            <a href="{{ route('accounting.payments') }}" class="acc-nav-link {{ request()->routeIs('accounting.payments') ? 'active' : '' }}">
                <i class="fas fa-money-check-alt"></i> <span>Payments</span>
            </a>
            <a href="{{ route('accounting.expenses') }}" class="acc-nav-link {{ request()->routeIs('accounting.expenses') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> <span>Expenses</span>
            </a>

            <span class="nav-label mt-4">Reports</span>
            <a href="{{ route('accounting.reports') }}" class="acc-nav-link {{ request()->routeIs('accounting.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> <span>Profit & Loss</span>
            </a>
            <a href="{{ route('accounting.gst') }}" class="acc-nav-link {{ request()->routeIs('accounting.gst') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> <span>GST / Tax</span>
            </a>

            <span class="nav-label mt-4">Integrations</span>
            <a href="{{ route('accounting.sync') }}" class="acc-nav-link {{ request()->routeIs('accounting.sync') ? 'active' : '' }}">
                <i class="fas fa-cloud-upload-alt"></i> <span>API Sync</span>
            </a>

            <div class="mt-auto">
                <a href="{{ route('admin.dashboard') }}" class="acc-nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i> <span>Back to Admin</span>
                </a>
            </div>
        </nav>
    </aside>

    <main class="acc-main">
        <header class="acc-header">
            <div class="header-title">
                <h4 class="mb-0 fw-bold">@yield('page_title', 'Accounting Terminal')</h4>
                <p class="text-muted small mb-0">{{ date('l, d F Y') }}</p>
            </div>
            <div class="header-actions d-flex gap-3">
                <div class="user-profile">
                    <div class="avatar">AC</div>
                    <div class="profile-info small">
                        <div class="fw-bold">Accounts Officer</div>
                        <div class="text-muted">Master Sync Active</div>
                    </div>
                </div>
            </div>
        </header>

        @yield('acc_content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

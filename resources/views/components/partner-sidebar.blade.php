@props(['active' => 'index'])

<aside class="partner-sidebar p-4 bg-white border-end d-none d-lg-block" style="width: 280px; min-width: 280px; position: sticky; top: 0; min-height: 100vh; overflow-y: auto;">
    <div class="partner-user-profile mb-5 text-center border-bottom pb-5">
        <div class="nav-avatar bg-navy text-white rounded-circle mb-4 mx-auto shadow-lg d-flex align-items-center justify-content-center fw-900 border" style="width: 72px; height: 72px; font-size: 26px; border: 4px solid #fff;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <h6 class="fw-900 text-navy mb-1" style="letter-spacing: 0.5px;">{{ Auth::user()->name }}</h6>
        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-2 fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">B2B AGENT VERIFIED</span>
        <div class="small fw-bold text-muted opacity-50" style="font-size: 10px;">ID: #B2B-{{ Auth::user()->id + 5000 }}</div>
    </div>

    <nav class="partner-nav d-flex flex-column gap-1">
        
        <!-- DASHBOARD -->
        <a href="{{ route('agent.b2b.index') }}" class="partner-nav-link {{ $active == 'index' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-th-large"></i></div>
            <span>Dashboard</span>
        </a>

        <!-- FLIGHT BOOKING -->
        <div class="sidebar-info-label mt-4 mb-2">FLIGHT BOOKING</div>
        <a href="{{ route('agent.b2b.search') }}" class="partner-nav-link {{ $active == 'search' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-search"></i></div>
            <span>Search Flights</span>
        </a>
        <a href="{{ route('agent.b2b.bookings') }}" class="partner-nav-link {{ $active == 'bookings' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-suitcase"></i></div>
            <span>My Bookings</span>
        </a>
        <a href="{{ route('agent.b2b.fare-alerts') }}" class="partner-nav-link {{ $active == 'fare-alerts' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-bell"></i></div>
            <span>Fare Monitor</span>
        </a>

        <!-- CARGO & SHIPPING -->
        <div class="sidebar-info-label mt-4 mb-2">CARGO & SHIPPING</div>
        <a href="{{ route('cargo.dashboard.index') }}" class="partner-nav-link {{ request()->is('cargo-dashboard*') ? 'active' : '' }}">
            <div class="nav-icon text-primary"><i class="fas fa-box-open"></i></div>
            <span class="text-primary fw-900">Cargo Dashboard</span>
        </a>
        <a href="{{ route('cargo.dashboard.book') }}" class="partner-nav-link">
            <div class="nav-icon"><i class="fas fa-shipping-fast"></i></div>
            <span>Send New Parcel</span>
        </a>

        <!-- WALLET -->
        <div class="sidebar-info-label mt-4 mb-2">WALLET SYSTEM</div>
        <a href="{{ route('agent.b2b.wallet.add') }}" class="partner-nav-link {{ $active == 'wallet-add' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-plus-circle"></i></div>
            <span>Add Money</span>
        </a>
        <a href="{{ route('agent.b2b.wallet.history') }}" class="partner-nav-link {{ $active == 'wallet-history' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-history"></i></div>
            <span>Wallet History</span>
        </a>
        <a href="{{ route('agent.b2b.wallet.credit-request') }}" class="partner-nav-link {{ $active == 'credit-request' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-hand-holding-usd"></i></div>
            <span>Credit Request</span>
        </a>

        <!-- REPORTS -->
        <div class="sidebar-info-label mt-4 mb-2">REPORTS</div>
        <a href="{{ route('agent.b2b.reports.bookings') }}" class="partner-nav-link {{ $active == 'report-bookings' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-file-invoice"></i></div>
            <span>Booking Reports</span>
        </a>
        <a href="{{ route('agent.b2b.reports.transactions') }}" class="partner-nav-link {{ $active == 'report-transactions' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-list-alt"></i></div>
            <span>Transaction Reports</span>
        </a>
        <button class="partner-nav-link border-0 bg-transparent w-100 text-start {{ $active == 'report-profit' ? 'active' : '' }}" onclick="location.href='{{ route('agent.b2b.reports.profit') }}'">
            <div class="nav-icon"><i class="fas fa-chart-pie"></i></div>
            <span>Profit / Margin Report</span>
        </button>

        <!-- MANAGE -->
        <div class="sidebar-info-label mt-4 mb-2">MANAGE</div>
        <a href="{{ route('agent.b2b.manage.passengers') }}" class="partner-nav-link {{ $active == 'manage-pax' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-users"></i></div>
            <span>Passengers List</span>
        </a>
        <a href="{{ route('agent.b2b.manage.markups') }}" class="partner-nav-link {{ $active == 'markups' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-percent"></i></div>
            <span>Markup Settings</span>
        </a>

        <!-- SUPPORT -->
        <div class="sidebar-info-label mt-4 mb-2">SUPPORT</div>
        <a href="{{ route('agent.b2b.support.tickets') }}" class="partner-nav-link {{ $active == 'support-tickets' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-headset"></i></div>
            <span>Raise Ticket</span>
        </a>
        <a href="{{ route('agent.b2b.support.help') }}" class="partner-nav-link {{ $active == 'support-help' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-question-circle"></i></div>
            <span>Help Center</span>
        </a>

        <!-- ACCOUNT -->
        <div class="sidebar-info-label mt-4 mb-2">ACCOUNT</div>
        <a href="{{ route('agent.b2b.account.profile') }}" class="partner-nav-link {{ $active == 'profile' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-user-circle"></i></div>
            <span>Profile</span>
        </a>
        <a href="{{ route('agent.b2b.account.password') }}" class="partner-nav-link {{ $active == 'password' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-lock"></i></div>
            <span>Change Password</span>
        </a>
        <a href="{{ route('logout') }}" class="partner-nav-link logout-link mt-4" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="nav-icon"><i class="fas fa-power-off"></i></div>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>
</aside>

<style>
    .sidebar-info-label { font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 1.5px; padding-left: 20px; }
    .partner-nav-link {
        display: flex; align-items: center; padding: 10px 16px; border-radius: 12px; 
        color: #64748b; text-decoration: none; font-weight: 700; font-size: 13px; transition: all 0.2s ease;
        margin: 0 4px; gap: 0;
    }
    .partner-nav-link .nav-icon { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; margin-right: 12px; border-radius: 8px; transition: 0.3s; }
    .partner-nav-link i { font-size: 14px; width: auto; text-align: center; color: #94a3b8; }
    .partner-nav-link:hover { background: #f1f5f9; color: #0f172a; }
    .partner-nav-link:hover i { color: #0b3d61; }
    .partner-nav-link.active { background: #0b3d61; color: #fff; box-shadow: 0 4px 12px rgba(11, 61, 97, 0.2); }
    .partner-nav-link.active i { color: #fff !important; }
    .logout-link:hover { background: #fef2f2 !important; color: #ef4444 !important; }
</style>

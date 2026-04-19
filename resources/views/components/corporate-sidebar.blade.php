@props(['active' => 'index', 'role' => 'admin'])

<aside class="corporate-sidebar p-4 bg-white border-end d-none d-lg-block shadow-sm" style="width: 280px; min-width: 280px; position: sticky; top: 0; min-height: 100vh; overflow-y: auto;">
    <div class="corporate-header mb-5 text-center border-bottom pb-5">
        <div class="corporate-avatar bg-primary text-white rounded-circle mb-4 mx-auto shadow-lg d-flex align-items-center justify-content-center fw-900 border" style="width: 72px; height: 72px; font-size: 26px; border: 4px solid #fff;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <h6 class="fw-900 text-navy mb-1" style="letter-spacing: 0.5px;">{{ Auth::user()->name }}</h6>
        <span class="badge {{ $role == 'admin' ? 'bg-primary' : 'bg-success' }} text-white rounded-pill px-3 py-2 mb-2 fw-bold uppercase" style="font-size: 9px; letter-spacing: 0.8px;">CORPORATE {{ strtoupper($role) }}</span>
        <div class="small fw-bold text-muted opacity-50" style="font-size: 10px;">ORG: #CORP-{{ Auth::user()->id + 5000 }}</div>
    </div>

    <nav class="corporate-nav d-flex flex-column gap-1">
        
        <!-- COMMON DASHBOARD -->
        <a href="{{ route('corporate.index') }}" class="corporate-nav-link {{ $active == 'index' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-th-large"></i></div>
            <span>Dashboard</span>
        </a>

        @if($role == 'admin')
            <!-- BOOKINGS -->
            <div class="sidebar-info-label mt-4 mb-2">BOOKINGS</div>
            <a href="{{ route('corporate.admin.all-bookings') }}" class="corporate-nav-link {{ $active == 'all-bookings' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-receipt"></i></div>
                <span>All Bookings</span>
            </a>
            <a href="{{ route('corporate.admin.approvals') }}" class="corporate-nav-link {{ $active == 'approvals' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-check-shield"></i></div>
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <span>Pending Approvals</span>
                    <span class="badge bg-danger rounded-pill x-small px-2">4</span>
                </div>
            </a>

            <!-- EMPLOYEES -->
            <div class="sidebar-info-label mt-4 mb-2">EMPLOYEES</div>
            <a href="{{ route('corporate.employees.add') }}" class="corporate-nav-link {{ $active == 'employee-add' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-user-plus"></i></div>
                <span>Add Employee</span>
            </a>
            <a href="{{ route('corporate.employees.index') }}" class="corporate-nav-link {{ $active == 'employee-manage' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-users-cog"></i></div>
                <span>Manage Users</span>
            </a>

            <!-- POLICIES -->
            <div class="sidebar-info-label mt-4 mb-2">POLICIES</div>
            <a href="{{ route('corporate.policies') }}" class="corporate-nav-link {{ $active == 'policies' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-file-contract"></i></div>
                <span>Travel Policy</span>
            </a>
            <a href="{{ route('corporate.budget') }}" class="corporate-nav-link {{ $active == 'budget' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-layer-group"></i></div>
                <span>Budget Limits</span>
            </a>

            <!-- REPORTS -->
            <div class="sidebar-info-label mt-4 mb-2">REPORTS</div>
            <a href="{{ route('corporate.reports.expense') }}" class="corporate-nav-link {{ $active == 'report-expense' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-chart-bar"></i></div>
                <span>Expense Reports</span>
            </a>
            <a href="{{ route('corporate.reports.bookings') }}" class="corporate-nav-link {{ $active == 'report-bookings' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-file-invoice"></i></div>
                <span>Booking Reports</span>
            </a>

            <!-- BILLING -->
            <div class="sidebar-info-label mt-4 mb-2">BILLING</div>
            <a href="{{ route('corporate.billing.invoices') }}" class="corporate-nav-link {{ $active == 'billing-invoices' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-file-excel"></i></div>
                <span>Invoices</span>
            </a>
            <a href="{{ route('corporate.billing.payments') }}" class="corporate-nav-link {{ $active == 'billing-payments' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-university"></i></div>
                <span>Payments</span>
            </a>
        @else
            <!-- EMPLOYEE SIDEBAR -->
            <div class="sidebar-info-label mt-4 mb-2">FLIGHTS</div>
            <a href="{{ route('corporate.booking.search') }}" class="corporate-nav-link {{ $active == 'search' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-search"></i></div>
                <span>Search Flights</span>
            </a>
            <a href="{{ route('corporate.booking.my-trips') }}" class="corporate-nav-link {{ $active == 'my-trips' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-plane"></i></div>
                <span>My Trips</span>
            </a>
            <a href="{{ route('corporate.booking.status', ['id' => 1]) }}" class="corporate-nav-link {{ $active == 'status' ? 'active' : '' }}">
                <div class="nav-icon"><i class="fas fa-bell"></i></div>
                <span>Travel Requests</span>
            </a>
        @endif

        <!-- COMMON SECTIONS -->
        <div class="sidebar-info-label mt-4 mb-2">SUPPORT & ACCOUNT</div>
        <a href="{{ route('corporate.support') }}" class="corporate-nav-link {{ $active == 'support' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-headset"></i></div>
            <span>Support Hub</span>
        </a>
        <a href="{{ route('corporate.account') }}" class="corporate-nav-link {{ $active == 'account' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-user-circle"></i></div>
            <span>Account Profile</span>
        </a>

        <a href="{{ route('logout') }}" class="corporate-nav-link logout-link mt-4" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="nav-icon"><i class="fas fa-power-off"></i></div>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>
</aside>

<style>
    .sidebar-info-label { font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 1.5px; padding-left: 20px; }
    .corporate-nav-link {
        display: flex; align-items: center; padding: 10px 16px; border-radius: 12px; 
        color: #64748b; text-decoration: none; font-weight: 700; font-size: 13px; transition: all 0.2s ease;
        margin: 0 4px; gap: 0;
    }
    .corporate-nav-link .nav-icon { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; margin-right: 12px; border-radius: 8px; transition: 0.3s; }
    .corporate-nav-link i { font-size: 14px; width: auto; text-align: center; color: #94a3b8; }
    .corporate-nav-link:hover { background: #f1f5f9; color: #0f172a; }
    .corporate-nav-link:hover i { color: #0b3d61; }
    .corporate-nav-link.active { background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
    .corporate-nav-link.active i { color: #fff !important; }
    .logout-link:hover { background: #fef2f2 !important; color: #ef4444 !important; }
</style>

@props(['active' => 'overview'])

<aside class="hotel-sidebar p-4 bg-white border-end shadow-sm" style="width: 300px; min-width: 300px; position: sticky; top: 0; min-height: 100vh;">
    <div class="text-center mb-5 pb-5 border-bottom border-light">
        <div class="avatar-box bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center fw-900 fs-3 mb-4 mx-auto shadow-sm" style="width: 80px; height: 80px; border: 4px solid #fff;">
            <i class="fas fa-hotel"></i>
        </div>
        <h6 class="fw-900 text-navy mb-1 text-uppercase small" style="letter-spacing: 0.5px;">{{ Auth::user()->name }}</h6>
        <div class="badge bg-success-subtle text-success rounded-pill x-small px-3 py-2 fw-bold">VERIFIED HOTEL PARTNER</div>
    </div>
    
    <nav class="sidebar-nav d-flex flex-column gap-2 mt-4">
        <span class="text-muted small fw-bold px-3 mb-2 opacity-50 uppercase letter-spacing-1" style="font-size: 10px;">PARTNER COMMAND DESK</span>
        
        <a href="{{ route('hotel.dashboard') }}" class="nav-link-hotel {{ $active == 'overview' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-inbox"></i></div>
            <span class="flex-grow-1">Quote Requests</span>
            <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 9px; padding: 4px 8px;">04</span>
        </a>
        
        <a href="{{ route('hotel.bookings') }}" class="nav-link-hotel {{ $active == 'bookings' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-calendar-check"></i></div>
            <span class="flex-grow-1">My Bookings</span>
        </a>

        <a href="{{ route('hotel.availability') }}" class="nav-link-hotel {{ $active == 'availability' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-bed"></i></div>
            <span class="flex-grow-1">Live Availability</span>
        </a>

        <a href="{{ route('hotel.rates') }}" class="nav-link-hotel {{ $active == 'rates' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-tag"></i></div>
            <span class="flex-grow-1">Inventory Rates</span>
        </a>

        <a href="{{ route('hotel.payouts') }}" class="nav-link-hotel {{ $active == 'payouts' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <span class="flex-grow-1">Payouts / Reports</span>
        </a>

        <div class="nav-divider my-4 mx-3" style="border-top: 1px solid rgba(0,0,0,0.05);"></div>
        
        <a href="{{ route('hotel.settings') }}" class="nav-link-hotel {{ $active == 'settings' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-cog"></i></div>
            <span class="flex-grow-1">Property Settings</span>
        </a>

        <a href="{{ route('logout') }}" class="nav-link-hotel logout-link mt-4" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="nav-icon"><i class="fas fa-power-off"></i></div>
            <span class="flex-grow-1">Partner Logout</span>
        </a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</aside>

<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .letter-spacing-1 { letter-spacing: 1.5px; }
    
    .hotel-sidebar { background: #fff !important; }

    .nav-link-hotel {
        display: flex; align-items: center; padding: 12px 18px; border-radius: 12px; 
        color: #64748b; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent; margin: 0 4px;
    }
    .nav-link-hotel .nav-icon { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 12px; border-radius: 8px; transition: 0.3s; }
    .nav-link-hotel i { font-size: 16px; }

    .nav-link-hotel:hover { background: #f8fafc; color: #02234b; transform: translateX(4px); }
    .nav-link-hotel.active { 
        background: #02234b; color: #fff; 
        box-shadow: 0 4px 15px rgba(2, 35, 75, 0.15); 
        border-color: rgba(255,255,255,0.1);
    }
    .nav-link-hotel.active .nav-icon { background: rgba(255,255,255,0.1); }
    .logout-link:hover { background: #fef2f2 !important; color: #ef4444 !important; }
</style>

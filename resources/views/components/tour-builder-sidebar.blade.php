@props(['active' => 'overview'])

<aside class="tour-builder-sidebar p-4 bg-white border-end d-none d-lg-block shadow-sm" style="width: 300px; min-width: 300px; position: sticky; top: 0; min-height: 100vh;">
    <div class="text-center mb-5 pb-5 border-bottom border-light">
        <div class="avatar-box bg-purple text-white rounded-circle d-flex align-items-center justify-content-center fw-900 fs-3 mb-4 mx-auto shadow-sm border" style="width: 80px; height: 80px; border: 4px solid #fff;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <h6 class="fw-900 text-navy mb-1 text-uppercase small" style="letter-spacing: 0.5px;">{{ Auth::user()->name }}</h6>
        <div class="badge bg-purple-subtle text-purple rounded-pill x-small px-3 py-2 fw-bold">TOUR BUILDER PRO</div>
    </div>
    
    <nav class="sidebar-nav d-flex flex-column gap-2 mt-4">
        <span class="text-muted small fw-bold px-3 mb-2 opacity-50 uppercase letter-spacing-2" style="font-size: 10px;">INVENTORY COMMAND</span>
        
        <a href="{{ route('tourbuilder.dashboard') }}" class="nav-link-tour {{ $active == 'tours' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-camera-retro text-purple"></i></div>
            <span class="flex-grow-1">Manage Experiences</span>
        </a>
        
        <a href="{{ route('tourbuilder.packages') }}" class="nav-link-tour {{ $active == 'packages' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-box-open text-purple"></i></div>
            <span class="flex-grow-1">Package Builder</span>
        </a>

        <a href="{{ route('tourbuilder.bookings') }}" class="nav-link-tour {{ $active == 'bookings' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-ticket text-purple"></i></div>
            <span class="flex-grow-1">Tour Bookings</span>
        </a>

        <a href="{{ route('tourbuilder.reviews') }}" class="nav-link-tour {{ $active == 'reviews' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-star text-warning"></i></div>
            <span class="flex-grow-1">Guest Reviews</span>
        </a>

        <a href="{{ route('tourbuilder.earnings') }}" class="nav-link-tour {{ $active == 'earnings' ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-money-bill-trend-up text-success"></i></div>
            <span class="flex-grow-1">Payout Ledger</span>
        </a>

        <div class="nav-divider my-4 mx-3" style="border-top: 1px solid rgba(0,0,0,0.05);"></div>
        

        <a href="{{ route('logout') }}" class="nav-link-tour logout-link mt-2" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="nav-icon"><i class="fas fa-power-off"></i></div>
            <span class="flex-grow-1">Secure Logout</span>
        </a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</aside>

<style>
    .bg-purple { background: #6b46c1 !important; }
    .bg-purple-subtle { background: #faf5ff; }
    .text-purple { color: #6b46c1 !important; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .letter-spacing-2 { letter-spacing: 2px; }
    
    .nav-link-tour {
        display: flex; align-items: center; padding: 12px 18px; border-radius: 12px; 
        color: #64748b; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent; margin: 0 4px;
    }
    .nav-link-tour .nav-icon { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 12px; border-radius: 8px; transition: 0.3s; }
    .nav-link-tour i { font-size: 16px; }

    .nav-link-tour:hover { background: #faf5ff; color: #44337a; transform: translateX(5px); }
    .nav-link-tour.active { 
        background: #6b46c1; color: #fff; 
        box-shadow: 0 4px 15px rgba(107, 70, 193, 0.15); 
    }
    .nav-link-tour.active .nav-icon { background: rgba(255,255,255,0.1); }
    .nav-link-tour.active .nav-icon i { color: #fff !important; }
    .logout-link:hover { background: #fef2f2 !important; color: #ef4444 !important; }
</style>

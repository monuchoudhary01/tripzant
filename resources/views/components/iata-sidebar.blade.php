@props(['active' => 'dashboard'])

<aside class="iata-sidebar" id="iataSidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">I</div>
        <div>
            <span class="brand-name">TRIPZANT</span>
            <span class="brand-tag">IATA Agent Panel</span>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-item">
            <a href="{{ route('iata.dashboard') }}" class="menu-link {{ $active == 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-grid-2"></i> Dashboard
            </a>
        </div>

        <div class="menu-section">Booking Hub</div>
        
        <div class="menu-item {{ str_contains($active, 'flight') ? 'active' : '' }}">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-plane"></i> Flight Booking <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="{{ route('iata.flight.search') }}" class="submenu-link {{ $active == 'flight-search' ? 'active' : '' }}">Search Flight</a>
                <a href="{{ route('iata.flight.availability') }}" class="submenu-link {{ $active == 'flight-availability' ? 'active' : '' }}">Availability</a>
                <a href="{{ route('iata.flight.create-pnr') }}" class="submenu-link">Create PNR</a>
                <a href="{{ route('iata.flight.issue-ticket') }}" class="submenu-link">Issue Ticket</a>
                <a href="{{ route('iata.flight.pnr-list') }}" class="submenu-link {{ $active == 'pnr-list' ? 'active' : '' }}">PNR List</a>
            </div>
        </div>

        <div class="menu-item {{ str_contains($active, 'tickets') ? 'active' : '' }}">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-ticket-alt"></i> Ticket Management <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="{{ route('iata.tickets.all') }}" class="submenu-link {{ $active == 'all-tickets' ? 'active' : '' }}">All Tickets</a>
                <a href="#" class="submenu-link">Ticket Details</a>
                <a href="#" class="submenu-link">Void Ticket</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-undo"></i> Refund Management <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="#" class="submenu-link">Refund Request</a>
                <a href="#" class="submenu-link">Refund Status</a>
                <a href="#" class="submenu-link">Refund History</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link">
                <i class="fas fa-sync-alt"></i> Reissue / Reschedule
            </a>
        </div>

        <div class="menu-section">BSP & Finance</div>

        <div class="menu-item {{ str_contains($active, 'bsp') ? 'active' : '' }}">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-file-invoice-dollar"></i> BSP Module <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="{{ route('iata.bsp.sales') }}" class="submenu-link {{ $active == 'bsp-sales' ? 'active' : '' }}">BSP Sales Report</a>
                <a href="#" class="submenu-link">Weekly Billing</a>
                <a href="#" class="submenu-link">Airline Payable</a>
                <a href="{{ route('iata.bsp.ledger') }}" class="submenu-link {{ $active == 'bsp-ledger' ? 'active' : '' }}">Ledger</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-calculator"></i> Accounting <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="{{ route('iata.accounting') }}" class="submenu-link">Sales Ledger</a>
                <a href="#" class="submenu-link">Credit / Debit</a>
                <a href="#" class="submenu-link">Commission Report</a>
            </div>
        </div>

        <div class="menu-section">Collaboration</div>

        <div class="menu-item {{ str_contains($active, 'network') ? 'active' : '' }}">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-users-rays"></i> Agent Network <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="{{ route('iata.network.search') }}" class="submenu-link {{ $active == 'net-search' ? 'active' : '' }}">Search Agents</a>
                <a href="{{ route('iata.network.requests') }}" class="submenu-link {{ $active == 'net-requests' ? 'active' : '' }}">Requests</a>
                <a href="{{ route('iata.network.partners') }}" class="submenu-link {{ $active == 'net-partners' ? 'active' : '' }}">My Partners</a>
                <a href="{{ route('iata.network.profits') }}" class="submenu-link {{ $active == 'net-profits' ? 'active' : '' }}">Profit Sharing</a>
            </div>
        </div>

        <div class="menu-section">Core Modules</div>

        <div class="menu-item">
            <a href="#" class="menu-link" onclick="toggleSubmenu(event, this)">
                <i class="fas fa-chart-bar"></i> Reports <i class="fas fa-chevron-down ms-auto" style="font-size: 10px;"></i>
            </a>
            <div class="submenu">
                <a href="{{ route('iata.reports') }}" class="submenu-link">Ticket Report</a>
                <a href="#" class="submenu-link">Refund Report</a>
                <a href="#" class="submenu-link">Reissue Report</a>
                <a href="#" class="submenu-link">Airline-wise Report</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link">
                <i class="fas fa-user-friends"></i> Passenger Records
            </a>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
    </nav>
</aside>

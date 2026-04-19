@props(['active' => 'overview'])

<aside class="amadeus-sidebar p-4 border-end border-secondary d-none d-lg-block shadow-lg" style="width: 280px; background: #0a0f18; min-height: 100vh; position: sticky; top: 0;">
    <div class="text-center mb-5 pb-4 border-bottom border-secondary">
        <div class="pcc-orb shadow-glow mx-auto mb-3 d-flex align-items-center justify-content-center fw-900" style="width: 60px; height: 60px; background: linear-gradient(135deg, #22d3ee, #0891b2); border-radius: 50%; color: #000; font-size: 24px;">1A</div>
        <h6 class="fw-900 text-white mb-1 uppercase" style="font-size: 10px; letter-spacing: 1px;">Amadeus Hub</h6>
        <span class="badge bg-cyan-glow text-cyan border border-cyan x-small px-3 py-1">OFFICE ID: DEL1A21RT</span>
    </div>

    <nav class="tech-nav d-flex flex-column gap-2">
        <span class="text-muted small fw-bold px-3 mb-2 opacity-50 uppercase letter-spacing-1" style="font-size: 10px;">GDS Operations</span>
        
        <a href="{{ route('amadeus.dashboard') }}" class="tech-link {{ $active == 'overview' ? 'active' : '' }}">
            <i class="fas fa-terminal me-2"></i> Command Center
        </a>
        
        <a href="{{ route('amadeus.logs') }}" class="tech-link {{ $active == 'logs' ? 'active' : '' }}">
            <i class="fas fa-robot me-2"></i> Robotic Logs
        </a>

        <a href="{{ route('amadeus.queues') }}" class="tech-link {{ $active == 'queues' ? 'active' : '' }}">
            <i class="fas fa-layer-group me-2"></i> PNR Queues 
            <span class="badge bg-danger ms-auto rounded-pill" style="font-size: 9px;">14</span>
        </a>

        <a href="{{ route('amadeus.yield') }}" class="tech-link {{ $active == 'yield' ? 'active' : '' }}">
            <i class="fas fa-chart-pie me-2"></i> Yield Maximizer
        </a>

        <a href="{{ route('amadeus.creds') }}" class="tech-link {{ $active == 'api' ? 'active' : '' }}">
            <i class="fas fa-key me-2"></i> Robotic API Creds
        </a>

        <hr class="my-4 opacity-10 border-secondary">
        
        <a href="{{ route('amadeus.settings') }}" class="tech-link {{ $active == 'settings' ? 'active' : '' }}">
            <i class="fas fa-gears me-2"></i> Hub Settings
        </a>

        <a href="{{ route('logout') }}" class="tech-link text-danger mt-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-power-off me-2"></i> Terminate Session
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>
</aside>

<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .letter-spacing-1 { letter-spacing: 1.5px; }
    .bg-cyan-glow { background: rgba(34, 211, 238, 0.1); }
    .text-cyan { color: #22d3ee; }
    .shadow-glow { box-shadow: 0 0 20px rgba(34, 211, 238, 0.4); }
    
    .tech-link {
        display: flex; align-items: center; padding: 14px 20px; border-radius: 12px;
        color: #94a3b8; text-decoration: none; font-weight: 800; font-size: 13px; transition: 0.3s;
    }
    .tech-link:hover { background: rgba(34, 211, 238, 0.05); color: #22d3ee; transform: translateX(5px); }
    .tech-link.active { background: rgba(34, 211, 238, 0.1); color: #22d3ee; border: 1px solid rgba(34, 211, 238, 0.2); }
    .tech-link i { font-size: 18px; width: 24px; text-align: center; }
</style>

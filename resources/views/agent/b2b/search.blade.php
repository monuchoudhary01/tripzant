@extends('layouts.app')

@section('title', "Search & Book — Command Center")

@section('content')
<div class="command-center-wrapper d-flex">
    <x-partner-sidebar active="search" />

    <main class="dashboard-main flex-grow-1">
        <!-- Top Toolbar (Simplified) -->
        <header class="dashboard-header">
            <div class="header-title">
                <i class="fas fa-search me-2 text-accent"></i>
                <h2 class="fw-900 text-navy mb-0" style="font-size: 20px;">Global Inventory Access</h2>
            </div>
            
            <div class="user-actions">
                <div class="status-indicator-pill glass-card-sm">
                    <span class="pulse-green"></span>
                    <span class="x-small fw-900 text-navy uppercase">IATA Node Live</span>
                </div>
                
                <div class="wallet-pill">
                    <i class="fas fa-wallet"></i>
                    <span>₹{{ number_format($wallet->balance) }}</span>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <!-- Search Widget Section -->
            <div class="glass-card search-hero mb-5">
                <div class="search-hero-header mb-4">
                    <h3>Secure <span class="gradient-text">Net Fares</span></h3>
                    <p>Access exclusive B2B inventory with real-time ticketing capabilities.</p>
                </div>
                <x-search-widget />
            </div>

            <!-- Intelligent Insights -->
            <div class="row g-4">
                <div class="col-lg-12">
                    <h5 class="fw-900 text-navy mb-4 uppercase tracking-wider h-label">Top Yield Sectors</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="glass-card yield-card">
                        <div class="yield-badge">DOMESTIC</div>
                        <div class="yield-route">DEL ⇌ BOM</div>
                        <div class="yield-info">
                            <span class="yield-label">Avg Margin</span>
                            <span class="yield-value text-green">₹420/seat</span>
                        </div>
                        <div class="yield-action">
                            <button class="btn-tool-sm">ANALYZE</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="glass-card yield-card">
                        <div class="yield-badge">INTERNATIONAL</div>
                        <div class="yield-route">BOM ⇌ DXB</div>
                        <div class="yield-info">
                            <span class="yield-label">Avg Margin</span>
                            <span class="yield-value text-green">₹1,850/seat</span>
                        </div>
                        <div class="yield-action">
                            <button class="btn-tool-sm">ANALYZE</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="glass-card yield-card highlight">
                        <div class="yield-badge">PREMIUM</div>
                        <div class="yield-route">DEL ⇌ LHR</div>
                        <div class="yield-info">
                            <span class="yield-label text-white op-7">Avg Margin</span>
                            <span class="yield-value text-white">₹5,200/seat</span>
                        </div>
                        <div class="yield-action">
                            <button class="btn-tool-sm bg-white text-primary">ANALYZE</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="glass-card yield-card placeholder">
                        <div class="p-4 d-flex flex-column align-items-center justify-content-center h-100">
                            <i class="fas fa-plus mb-2 opacity-50"></i>
                            <span class="x-small fw-bold opacity-50">Custom Watchlist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Reusing Core Dashboard Styles */
:root {
    --cc-bg: #f0f4f8;
    --cc-primary: #0b3d61;
    --cc-accent: #3b82f6;
    --cc-glass: rgba(255, 255, 255, 0.7);
    --cc-text: #1e293b;
    --cc-muted: #64748b;
    --cc-border: rgba(255, 255, 255, 0.4);
}

.command-center-wrapper { background: var(--cc-bg); min-height: 100vh; font-family: 'Outfit', sans-serif; }
.dashboard-main { 
    background-image: 
        radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0, transparent 50%),
        radial-gradient(at 100% 100%, rgba(11, 61, 97, 0.05) 0, transparent 50%);
}

.dashboard-header {
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--cc-border);
    position: sticky; top: 0; z-index: 100;
}

.header-title { display: flex; align-items: center; }
.text-accent { color: var(--cc-accent); }

.user-actions { display: flex; align-items: center; gap: 20px; }

.glass-card-sm {
    background: var(--cc-glass);
    padding: 8px 16px;
    border-radius: 100px;
    border: 1px solid var(--cc-border);
    display: flex; align-items: center; gap: 10px;
}

.pulse-green { width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 0 rgba(16, 185, 129, 0.4); animation: pulse 2s infinite; }
@keyframes pulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.wallet-pill {
    background: #000; color: #fff; padding: 6px 20px; border-radius: 100px; font-weight: 800; font-size: 14px;
}

.dashboard-content { padding: 40px; }

.glass-card {
    background: var(--cc-glass);
    backdrop-filter: blur(12px);
    border-radius: 30px;
    padding: 40px;
    border: 1px solid var(--cc-border);
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}

.search-hero-header h3 { font-size: 28px; font-weight: 900; color: var(--cc-primary); }
.gradient-text { background: linear-gradient(to right, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.search-hero-header p { color: var(--cc-muted); font-size: 15px; font-weight: 500; }

.h-label { font-size: 14px; letter-spacing: 1px; color: var(--cc-muted) !important; padding-left: 10px; }

.yield-card { padding: 25px; transition: 0.3s; height: 100%; display: flex; flex-direction: column; justify-content: space-between; }
.yield-card:hover { transform: translateY(-5px); }
.yield-card.highlight { background: linear-gradient(135deg, #0b3d61 0%, #1e293b 100%); }
.yield-card.placeholder { background: transparent; border: 2px dashed #cbd5e1; }

.yield-badge { font-size: 9px; font-weight: 800; color: var(--cc-accent); background: #eff6ff; padding: 4px 10px; border-radius: 100px; width: fit-content; margin-bottom: 15px; letter-spacing: 0.5px; }
.yield-card.highlight .yield-badge { background: rgba(255,255,255,0.1); color: #fff; }

.yield-route { font-size: 18px; font-weight: 900; color: var(--cc-primary); margin-bottom: 20px; }
.yield-card.highlight .yield-route { color: #fff; }

.yield-info { display: flex; flex-direction: column; gap: 4px; margin-bottom: 20px; }
.yield-label { font-size: 11px; font-weight: 700; color: var(--cc-muted); text-transform: uppercase; }
.yield-value { font-size: 24px; font-weight: 900; }

.btn-tool-sm {
    width: 100%; padding: 10px; border-radius: 12px; border: none; font-size: 11px; font-weight: 900; background: #f1f5f9; color: var(--cc-primary); cursor: pointer; transition: 0.2s;
}
.btn-tool-sm:hover { background: var(--cc-primary); color: #fff; }

.op-7 { opacity: 0.7; }
</style>
@endsection

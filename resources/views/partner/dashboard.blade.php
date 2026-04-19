@extends('layouts.app')

@section('title', "B2B Command Center — Tripzant")

@section('content')
<div class="command-center-wrapper d-flex">
    <x-partner-sidebar active="index" />

    <main class="dashboard-main flex-grow-1">
        <!-- Top Toolbar -->
        <header class="dashboard-header">
            <div class="search-global">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search bookings, PNRs, or invoices...">
            </div>
            
            <div class="user-actions">
                <div class="wallet-pill">
                    <i class="fas fa-wallet"></i>
                    <span>₹{{ number_format($wallet->balance) }}</span>
                    <a href="{{ route('agent.b2b.wallet.add') }}" class="topup-btn"><i class="fas fa-plus"></i></a>
                </div>
                
                <div class="action-icons">
                    <div class="icon-btn"><i class="fas fa-bell"></i><span class="dot"></span></div>
                    <div class="icon-btn"><i class="fas fa-question-circle"></i></div>
                </div>

                <div class="user-pill">
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">Premium Agent</span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0b3d61&color=fff" class="user-avatar">
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <!-- Hero Section -->
            <div class="welcome-hero">
                <div class="hero-text">
                    <h1>Operational <span class="gradient-text">Intelligence</span></h1>
                    <p>Track your earnings, manage manifests, and scale your business with ease.</p>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <span class="stat-label">Total Volume</span>
                        <span class="stat-value">₹{{ number_format($totalBookingsCount * 5000 + $totalEarnings) }}</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="stat-label">Net Profit</span>
                        <span class="stat-value text-green">₹{{ number_format($totalEarnings) }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid-stats">
                <div class="glass-card stat-card">
                    <div class="card-icon blue"><i class="fas fa-plane-departure"></i></div>
                    <div class="card-info">
                        <span class="label">Total Bookings</span>
                        <h2 class="value">{{ number_format($totalBookingsCount) }}</h2>
                        <span class="trend up"><i class="fas fa-arrow-up"></i> 12%</span>
                    </div>
                    <div class="card-chart">
                        <div class="mini-bar-chart">
                            <div class="bar" style="height: 40%;"></div>
                            <div class="bar" style="height: 60%;"></div>
                            <div class="bar" style="height: 45%;"></div>
                            <div class="bar" style="height: 70%;"></div>
                            <div class="bar" style="height: 55%;"></div>
                        </div>
                    </div>
                </div>

                <div class="glass-card stat-card">
                    <div class="card-icon gold"><i class="fas fa-star"></i></div>
                    <div class="card-info">
                        <span class="label">Agent Rating</span>
                        <h2 class="value">4.9/5</h2>
                        <span class="trend up"><i class="fas fa-check-circle"></i> Elite Tier</span>
                    </div>
                </div>

                <div class="glass-card stat-card">
                    <div class="card-icon green"><i class="fas fa-users-cog"></i></div>
                    <div class="card-info">
                        <span class="label">Sub-Agents</span>
                        <h2 class="value">08</h2>
                        <span class="trend"><i class="fas fa-link"></i> Connected</span>
                    </div>
                </div>

                <div class="glass-card stat-card highlight">
                    <div class="card-info">
                        <span class="label text-white">Credit Limit</span>
                        <h2 class="value text-white">₹1,00,000</h2>
                        <div class="progress mt-2" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 65%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Content -->
            <div class="row g-4 mt-2">
                <div class="col-lg-8">
                    <div class="glass-card main-feed">
                        <div class="card-header-flex">
                            <h3>Real-time Booking Manifest</h3>
                            <div class="actions">
                                <button class="btn-glass-sm active">Today</button>
                                <button class="btn-glass-sm">This Week</button>
                                <button class="btn-icon-sm"><i class="fas fa-download"></i></button>
                            </div>
                        </div>
                        
                        <div class="premium-table-wrap">
                            <table class="premium-table">
                                <thead>
                                    <tr>
                                        <th>Passenger</th>
                                        <th>Sector</th>
                                        <th>Date</th>
                                        <th>Profit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBookings as $rb)
                                    @php 
                                        $details = json_decode($rb->booking_details, true);
                                        $pax = 'N/A';
                                        if($rb->booking_type == 'flight') {
                                            $pax = ($details['travelers'][0]['first_name'] ?? 'Guest') . ' ' . ($details['travelers'][0]['last_name'] ?? '');
                                        } elseif($rb->booking_type == 'hotel') {
                                            $pax = $details['paxes'][0]['name'] ?? 'Guest';
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="pax-cell">
                                                <div class="pax-avatar">{{ substr($pax, 0, 1) }}</div>
                                                <div class="pax-info">
                                                    <span class="name">{{ $pax }}</span>
                                                    <span class="ref">#{{ $rb->api_reference ?: 'REF-'.$rb->id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="sector-tag">{{ strtoupper($rb->booking_type) }}</span></td>
                                        <td><span class="date">{{ $rb->created_at->format('d M, Y') }}</span></td>
                                        <td><span class="profit">+₹{{ number_format($rb->markup) }}</span></td>
                                        <td><span class="status-pill {{ $rb->status }}">{{ strtoupper($rb->status) }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="empty-state">
                                            <i class="fas fa-folder-open"></i>
                                            <p>No transactions found for the selected period.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="glass-card side-panel">
                        <h3>Intelligence Feed</h3>
                        <div class="intelligence-list">
                            <div class="intelligence-item">
                                <div class="intel-icon red"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="intel-body">
                                    <h6>Markup Opportunity</h6>
                                    <p>Dubai sector demand is up 40%. Consider increasing your markup by 2%.</p>
                                    <span class="time">Just now</span>
                                </div>
                            </div>
                            <div class="intelligence-item">
                                <div class="intel-icon blue"><i class="fas fa-info-circle"></i></div>
                                <div class="intel-body">
                                    <h6>System Protocol</h6>
                                    <p>Air India GDS connection has been optimized for faster response.</p>
                                    <span class="time">12m ago</span>
                                </div>
                            </div>
                            <div class="intelligence-item">
                                <div class="intel-icon green"><i class="fas fa-check-circle"></i></div>
                                <div class="intel-body">
                                    <h6>Payout Cleared</h6>
                                    <p>Last week's overrides have been credited to your node.</p>
                                    <span class="time">2h ago</span>
                                </div>
                            </div>
                        </div>

                        <div class="quick-tools mt-5">
                            <h4>Quick Actions</h4>
                            <div class="tools-grid">
                                <a href="{{ route('agent.b2b.search') }}" class="tool-btn"><i class="fas fa-paper-plane"></i> Flights</a>
                                <a href="#" class="tool-btn"><i class="fas fa-hotel"></i> Hotels</a>
                                <a href="#" class="tool-btn"><i class="fas fa-print"></i> Manifest</a>
                                <a href="#" class="tool-btn"><i class="fas fa-chart-line"></i> Analytics</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Modern Command Center Variables */
:root {
    --cc-bg: #f0f4f8;
    --cc-primary: #0b3d61;
    --cc-accent: #3b82f6;
    --cc-glass: rgba(255, 255, 255, 0.7);
    --cc-text: #1e293b;
    --cc-muted: #64748b;
    --cc-border: rgba(255, 255, 255, 0.4);
}

.command-center-wrapper {
    background: var(--cc-bg);
    min-height: 100vh;
    font-family: 'Outfit', sans-serif;
}

.dashboard-main {
    background-image: 
        radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0, transparent 50%),
        radial-gradient(at 100% 100%, rgba(11, 61, 97, 0.05) 0, transparent 50%);
}

/* Header Styles */
.dashboard-header {
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--cc-border);
    position: sticky;
    top: 0;
    z-index: 100;
}

.search-global {
    background: #fff;
    padding: 10px 20px;
    border-radius: 100px;
    display: flex;
    align-items: center;
    gap: 12px;
    width: 350px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.search-global i { color: var(--cc-muted); }
.search-global input { border: none; outline: none; width: 100%; font-size: 14px; background: transparent; }

.user-actions { display: flex; align-items: center; gap: 24px; }

.wallet-pill {
    background: #000;
    color: #fff;
    padding: 6px 6px 6px 20px;
    border-radius: 100px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 800;
    font-size: 14px;
}

.topup-btn {
    background: #3b82f6;
    color: #fff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    text-decoration: none;
}

.action-icons { display: flex; gap: 15px; }

.icon-btn {
    width: 40px;
    height: 40px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cc-primary);
    position: relative;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.icon-btn .dot {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 8px;
    height: 8px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid #fff;
}

.user-pill { display: flex; align-items: center; gap: 15px; padding-left: 15px; border-left: 1px solid #e2e8f0; }
.user-info { text-align: right; }
.user-name { display: block; font-weight: 800; font-size: 14px; color: var(--cc-primary); }
.user-role { font-size: 11px; font-weight: 600; color: var(--cc-accent); text-transform: uppercase; }
.user-avatar { width: 44px; height: 44px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

/* Dashboard Content */
.dashboard-content { padding: 40px; }

.welcome-hero {
    background: linear-gradient(135deg, #0b3d61 0%, #1e293b 100%);
    padding: 40px;
    border-radius: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    margin-bottom: 40px;
    box-shadow: 0 20px 40px rgba(11, 61, 97, 0.2);
}

.hero-text h1 { font-size: 36px; font-weight: 900; margin-bottom: 10px; }
.gradient-text { background: linear-gradient(to right, #60a5fa, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.hero-text p { opacity: 0.7; font-size: 16px; font-weight: 500; }

.hero-stats { display: flex; gap: 40px; }
.hero-stat-item { text-align: right; }
.stat-label { display: block; font-size: 11px; font-weight: 700; opacity: 0.6; text-transform: uppercase; letter-spacing: 1px; }
.stat-value { font-size: 28px; font-weight: 900; }
.text-green { color: #4ade80; }

/* Grid Stats */
.grid-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

.glass-card {
    background: var(--cc-glass);
    backdrop-filter: blur(12px);
    border-radius: 24px;
    padding: 30px;
    border: 1px solid var(--cc-border);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.glass-card:hover { transform: translateY(-5px); box-shadow: 0 20px 30px rgba(0,0,0,0.05); }

.stat-card { display: flex; flex-direction: column; gap: 15px; position: relative; }
.stat-card.highlight { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }

.card-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
.card-icon.blue { background: #eff6ff; color: #3b82f6; }
.card-icon.gold { background: #fffbeb; color: #f59e0b; }
.card-icon.green { background: #ecfdf5; color: #059669; }

.stat-card .label { font-size: 12px; font-weight: 700; color: var(--cc-muted); text-transform: uppercase; letter-spacing: 0.5px; }
.stat-card .value { font-size: 28px; font-weight: 900; color: var(--cc-primary); margin: 0; }

.trend { font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px; }
.trend.up { color: #059669; }

.mini-bar-chart {
    position: absolute;
    bottom: 30px;
    right: 30px;
    display: flex;
    align-items: flex-end;
    gap: 4px;
    height: 40px;
}
.bar { width: 4px; background: #3b82f6; border-radius: 10px; opacity: 0.3; }

/* Main Feed Table */
.main-feed h3 { font-size: 20px; font-weight: 900; color: var(--cc-primary); margin-bottom: 25px; }
.card-header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }

.btn-glass-sm { background: rgba(0,0,0,0.03); border: none; padding: 6px 16px; border-radius: 100px; font-size: 11px; font-weight: 800; color: var(--cc-muted); cursor: pointer; }
.btn-glass-sm.active { background: var(--cc-primary); color: #fff; }
.btn-icon-sm { width: 32px; height: 32px; background: #fff; border: 1px solid #e2e8f0; border-radius: 50%; cursor: pointer; }

.premium-table { width: 100%; border-collapse: collapse; }
.premium-table th { text-align: left; font-size: 11px; font-weight: 800; color: var(--cc-muted); text-transform: uppercase; padding: 15px; border-bottom: 2px solid rgba(0,0,0,0.05); }
.premium-table td { padding: 15px; font-size: 14px; font-weight: 600; border-bottom: 1px solid rgba(0,0,0,0.03); }

.pax-cell { display: flex; align-items: center; gap: 12px; }
.pax-avatar { width: 36px; height: 36px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--cc-primary); font-size: 12px; }
.pax-info .name { display: block; font-weight: 800; color: var(--cc-primary); }
.pax-info .ref { font-size: 11px; color: var(--cc-muted); }

.sector-tag { background: #f8fafc; color: var(--cc-primary); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; border: 1px solid #e2e8f0; }
.profit { color: #059669; font-weight: 800; }

.status-pill { padding: 4px 12px; border-radius: 100px; font-size: 10px; font-weight: 800; }
.status-pill.confirmed { background: #ecfdf5; color: #059669; }
.status-pill.pending { background: #fff7ed; color: #f97316; }

/* Side Panel Feed */
.side-panel h3 { font-size: 20px; font-weight: 900; color: var(--cc-primary); margin-bottom: 25px; }

.intelligence-list { display: flex; flex-direction: column; gap: 20px; }
.intelligence-item { display: flex; gap: 16px; position: relative; }
.intel-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 16px; }
.intel-icon.red { background: #fef2f2; color: #ef4444; }
.intel-icon.blue { background: #eff6ff; color: #3b82f6; }
.intel-icon.green { background: #ecfdf5; color: #059669; }

.intel-body h6 { font-size: 14px; font-weight: 800; color: var(--cc-primary); margin-bottom: 4px; }
.intel-body p { font-size: 12px; color: var(--cc-muted); line-height: 1.5; margin-bottom: 5px; }
.intel-body .time { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }

.quick-tools h4 { font-size: 14px; font-weight: 900; color: var(--cc-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
.tools-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
.tool-btn { background: #fff; padding: 15px; border-radius: 15px; text-decoration: none; color: var(--cc-primary); font-weight: 800; font-size: 13px; display: flex; flex-direction: column; align-items: center; gap: 10px; border: 1px solid #e2e8f0; transition: all 0.2s; }
.tool-btn:hover { background: var(--cc-primary); color: #fff; transform: translateY(-3px); }
.tool-btn i { font-size: 18px; }

</style>
@endsection

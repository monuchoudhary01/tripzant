@extends('layouts.accounting')

@section('acc_content')
<div class="accounting-dashboard">
    <div class="dashboard-header">
        <div class="header-left">
            <h1>Accounting Terminal</h1>
            <p>Real-time booking-based financial insights</p>
        </div>
        <div class="header-right">
            <button class="btn-sync" onclick="location.href='{{ route('accounting.sync') }}'">
                <i class="fas fa-sync"></i> API Cloud Sync
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card revenue">
            <div class="icon-box"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info">
                <span class="label">Total Revenue</span>
                <h2 class="value">₹{{ number_format($totalRevenue, 2) }}</h2>
                <span class="trend up"><i class="fas fa-arrow-up"></i> 12.5%</span>
            </div>
        </div>
        <div class="stat-card expenses">
            <div class="icon-box"><i class="fas fa-wallet"></i></div>
            <div class="stat-info">
                <span class="label">Total Expenses</span>
                <h2 class="value">₹{{ number_format($totalExpenses, 2) }}</h2>
                <span class="trend down"><i class="fas fa-arrow-down"></i> 3.2%</span>
            </div>
        </div>
        <div class="stat-card profit">
            <div class="icon-box"><i class="fas fa-piggy-bank"></i></div>
            <div class="stat-info">
                <span class="label">Net Profit</span>
                <h2 class="value">₹{{ number_format($totalRevenue - $totalExpenses, 2) }}</h2>
                <span class="trend up"><i class="fas fa-check-circle"></i> Healthy</span>
            </div>
        </div>
        <div class="stat-card pending">
            <div class="icon-box"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <span class="label">Receivables</span>
                <h2 class="value">₹{{ number_format($totalReceivable, 2) }}</h2>
                <span class="trend warn">Pending</span>
            </div>
        </div>
    </div>

    <div class="main-content-grid">
        <!-- Recent Transactions -->
        <div class="content-card transactions-card">
            <div class="card-header">
                <h3>Recent Ledger Activity</h3>
                <a href="{{ route('accounting.ledger') }}" class="view-all">View Ledger</a>
            </div>
            <div class="table-container">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Account</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $journal)
                            @foreach($journal->ledgerEntries as $entry)
                            <tr>
                                <td>{{ $journal->entry_date }}</td>
                                <td>
                                    <span class="ref-badge">{{ $journal->reference_type }}</span>
                                    <small>#{{ $journal->reference_id }}</small>
                                </td>
                                <td>{{ $entry->account->name }}</td>
                                <td class="debit-val">{{ $entry->debit > 0 ? '₹'.number_format($entry->debit, 2) : '-' }}</td>
                                <td class="credit-val">{{ $entry->credit > 0 ? '₹'.number_format($entry->credit, 2) : '-' }}</td>
                                <td><span class="status-dot success"></span> Posted</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Financial Summary / API Sync Status -->
        <div class="side-panel">
            <div class="content-card api-status">
                <h3>External Sync</h3>
                <div class="sync-item">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/QuickBooks_Logo.svg" alt="QuickBooks" height="20">
                    <span class="status success">Connected</span>
                    <button class="mini-sync"><i class="fas fa-redo"></i></button>
                </div>
                <div class="sync-item">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Xero_logo.svg" alt="Xero" height="20">
                    <span class="status disconnected">Disconnected</span>
                    <button class="mini-sync"><i class="fas fa-link"></i></button>
                </div>
                <div class="sync-item">
                    <span class="tally-text">TALLY ERP</span>
                    <span class="status standby">Standby</span>
                    <button class="mini-sync"><i class="fas fa-power-off"></i></button>
                </div>
            </div>

            <div class="content-card quick-actions">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <button class="action-btn"><i class="fas fa-plus"></i> Add Expense</button>
                    <button class="action-btn"><i class="fas fa-file-invoice"></i> Create Invoice</button>
                    <button class="action-btn"><i class="fas fa-download"></i> P&L Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --bg-deep: #0f172a;
    --card-bg: rgba(30, 41, 59, 0.7);
    --border-color: rgba(255, 255, 255, 0.1);
    --accent-blue: #38bdf8;
    --accent-green: #4ade80;
    --accent-red: #fb7185;
    --text-primary: #f8fafc;
    --text-secondary: #94a3b8;
}

.accounting-dashboard {
    padding: 2rem;
    background: var(--bg-deep);
    color: var(--text-primary);
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header-left h1 {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(to right, #fff, var(--accent-blue));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
}

.header-left p {
    color: var(--text-secondary);
    margin: 0.5rem 0 0 0;
}

.btn-sync {
    background: var(--accent-blue);
    color: #000;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-sync:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(56, 189, 248, 0.4);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--card-bg);
    backdrop-filter: blur(12px);
    border: 1px solid var(--border-color);
    padding: 1.5rem;
    border-radius: 24px;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: scale(1.02);
}

.icon-box {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.revenue .icon-box { background: rgba(56, 189, 248, 0.1); color: var(--accent-blue); }
.expenses .icon-box { background: rgba(251, 113, 133, 0.1); color: var(--accent-red); }
.profit .icon-box { background: rgba(74, 222, 128, 0.1); color: var(--accent-green); }
.pending .icon-box { background: rgba(251, 191, 36, 0.1); color: #fbce24; }

.stat-info .label {
    display: block;
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.stat-info .value {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.trend {
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.5rem;
}

.trend.up { color: var(--accent-green); }
.trend.down { color: var(--accent-red); }
.trend.warn { color: #fbce24; }

/* Main Grid */
.main-content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.content-card {
    background: var(--card-bg);
    backdrop-filter: blur(12px);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 1.5rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.card-header h3 {
    margin: 0;
    font-size: 1.25rem;
}

.view-all {
    color: var(--accent-blue);
    text-decoration: none;
    font-size: 0.875rem;
}

.premium-table {
    width: 100%;
    border-collapse: collapse;
}

.premium-table th {
    text-align: left;
    color: var(--text-secondary);
    font-weight: 500;
    font-size: 0.875rem;
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.premium-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    font-size: 0.9rem;
}

.ref-badge {
    background: rgba(255, 255, 255, 0.05);
    padding: 2px 8px;
    border-radius: 6px;
    text-transform: capitalize;
    font-size: 0.75rem;
    margin-right: 4px;
}

.debit-val { color: var(--accent-green); font-weight: 600; }
.credit-val { color: var(--accent-red); font-weight: 600; }

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 6px;
}

.status-dot.success { background: var(--accent-green); box-shadow: 0 0 10px var(--accent-green); }

/* Side Panel */
.side-panel {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sync-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(255, 255, 255, 0.03);
    padding: 1rem;
    border-radius: 16px;
    margin-bottom: 0.75rem;
}

.status {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 20px;
}

.status.success { background: rgba(74, 222, 128, 0.1); color: var(--accent-green); }
.status.disconnected { background: rgba(251, 113, 133, 0.1); color: var(--accent-red); }
.status.standby { background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); }

.mini-sync {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-btn {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 1rem;
    border-radius: 12px;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: background 0.2s;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.1);
}

.tally-text {
    font-weight: 900;
    font-size: 0.8rem;
    letter-spacing: 1px;
}
</style>
@endsection

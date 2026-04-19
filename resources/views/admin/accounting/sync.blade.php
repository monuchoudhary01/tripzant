@extends('layouts.accounting')

@section('acc_content')
<div class="accounting-sync">
    <div class="page-header text-center mb-5">
        <h1 class="fw-bold">Cloud Accounting Sync</h1>
        <p class="text-muted">Connect your travel bookings with enterprise accounting software</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="sync-grid">
        <!-- QuickBooks -->
        <div class="sync-card shadow-sm border rounded-4 p-4 bg-white text-center transition-hover">
            <div class="brand-logo mb-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/QuickBooks_Logo.svg" alt="QuickBooks" height="40">
            </div>
            <p class="small text-muted mb-4">Sync Invoices, Payments, and Customer Ledgers directly to QuickBooks Online.</p>
            <div class="d-grid gap-2">
                <button class="btn btn-outline-primary fw-bold" disabled><i class="fas fa-link me-2"></i> Connected</button>
                <form action="{{ route('accounting.sync.now', 'QuickBooks') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fas fa-sync me-2"></i> Sync Now</button>
                </form>
            </div>
        </div>

        <!-- Xero -->
        <div class="sync-card shadow-sm border rounded-4 p-4 bg-white text-center transition-hover">
            <div class="brand-logo mb-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Xero_logo.svg" alt="Xero" height="40">
            </div>
            <p class="small text-muted mb-4">Seamless integration for Australian & Global markets. Manage P&L via Xero API.</p>
            <div class="d-grid gap-2">
                <button class="btn btn-dark fw-bold"><i class="fas fa-plug me-2"></i> Connect Xero</button>
            </div>
        </div>

        <!-- Tally -->
        <div class="sync-card shadow-sm border rounded-4 p-4 bg-white text-center transition-hover">
            <div class="brand-logo mb-4 d-flex justify-content-center align-items-center" style="height: 40px;">
                <span class="fw-black h3 m-0" style="color: #0b3d61;">TALLY <span class="text-secondary">.ERP 9</span></span>
            </div>
            <p class="small text-muted mb-4">Export XML/JSON payloads formatted specifically for Tally Prime and ERP 9.</p>
            <div class="d-grid gap-2">
                <button class="btn btn-secondary fw-bold"><i class="fas fa-file-download me-2"></i> Export for Tally</button>
            </div>
        </div>
    </div>

    <div class="automation-settings mt-5 card rounded-4 border-0 shadow-sm p-4">
        <h4 class="fw-bold mb-4">Sync Configuration</h4>
        <div class="list-group list-group-flush">
            <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                <div>
                    <h6 class="mb-0 fw-bold">Auto-Sync on Booking</h6>
                    <p class="text-muted small mb-0">Push data to cloud immediately when booking is confirmed</p>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" checked>
                </div>
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                <div>
                    <h6 class="mb-0 fw-bold">Sync Inventory as Items</h6>
                    <p class="text-muted small mb-0">Map Flight/Hotel codes to accounting product IDs</p>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sync-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}
.transition-hover:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}
.fw-black { font-weight: 900; }
</style>
@endsection

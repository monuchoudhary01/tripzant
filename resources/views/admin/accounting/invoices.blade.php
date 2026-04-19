@extends('layouts.accounting')

@section('acc_content')
<div class="accounting-invoices">
    <div class="page-header">
        <div>
            <h1>Billing & Invoices</h1>
            <p>Manage customer invoices and payment statuses</p>
        </div>
        <div class="actions">
            <button class="btn btn-primary"><i class="fas fa-file-invoice"></i> Batch Generate</button>
        </div>
    </div>

    <div class="invoice-stats grid-4 mb-4">
        <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
            <span class="text-muted small">Unpaid Invoices</span>
            <h3 class="fw-bold text-danger">₹{{ number_format($invoices->where('status', 'unpaid')->sum('total_amount'), 2) }}</h3>
        </div>
        <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
            <span class="text-muted small">Paid (MTD)</span>
            <h3 class="fw-bold text-success">₹{{ number_format($invoices->where('status', 'paid')->sum('total_amount'), 2) }}</h3>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="content-card p-0 overflow-hidden bg-white rounded-4 border shadow-sm">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <th>Booking</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td class="fw-bold">{{ $invoice->invoice_number }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-light rounded-circle p-2">
                                <i class="fas fa-user-tie text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $invoice->user->name ?? 'Guest' }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $invoice->user->email ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-soft-primary text-primary border border-primary-subtle">
                            {{ $invoice->booking->booking_type ?? 'N/A' }} #{{ $invoice->booking_id }}
                        </span>
                    </td>
                    <td class="small">{{ $invoice->invoice_date->format('d M Y') }}</td>
                    <td class="fw-bold">₹{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>
                        @php
                            $badgeClass = [
                                'paid' => 'bg-success',
                                'unpaid' => 'bg-danger',
                                'partially_paid' => 'bg-warning',
                                'cancelled' => 'bg-secondary'
                            ][$invoice->status] ?? 'bg-info';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ strtoupper($invoice->status) }}</span>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-link p-2 text-dark opacity-50 border-0" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 py-2" style="min-width: 180px;">
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center" href="#">
                                        <i class="far fa-file-pdf me-3 text-secondary opacity-75"></i> <span class="small fw-semibold">View PDF</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center" href="#">
                                        <i class="far fa-envelope me-3 text-secondary opacity-75"></i> <span class="small fw-semibold">Send Email</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center" href="#">
                                        <i class="fas fa-check-circle me-3 text-success"></i> <span class="small fw-semibold">Mark Paid</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider opacity-10"></li>
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center text-danger" href="#">
                                        <i class="fas fa-ban me-3"></i> <span class="small fw-semibold">Cancel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>

<style>
.bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
.grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
.avatar-sm { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
</style>
@endsection

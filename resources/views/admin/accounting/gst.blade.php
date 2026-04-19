@extends('layouts.accounting')

@section('acc_content')
<div class="glass-card">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold m-0">GST & Tax Center</h2>
            <p class="text-muted small">Input and Output Tax breakdown</p>
        </div>
        <div class="btn-group shadow-sm">
            <button class="btn btn-dark border-secondary">Q1</button>
            <button class="btn btn-dark border-secondary">Q2</button>
            <button class="btn btn-dark border-secondary">Q3</button>
            <button class="btn btn-acc-primary">Q4 (Current)</button>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="p-4 bg-white bg-opacity-5 rounded-4 border border-white border-opacity-10">
                <span class="text-muted small d-block mb-1">Output GST (Collected)</span>
                <h3 class="fw-bold text-success">₹0.00</h3>
                <p class="text-muted mb-0" style="font-size: 10px;">Based on 18% Service Charge</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-white bg-opacity-5 rounded-4 border border-white border-opacity-10">
                <span class="text-muted small d-block mb-1">Input GST (Paid)</span>
                <h3 class="fw-bold text-warning">₹0.00</h3>
                <p class="text-muted mb-0" style="font-size: 10px;">Supplier GST Reconciliation</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-accent bg-opacity-10 rounded-4 border border-accent border-opacity-20">
                <span class="text-white text-opacity-75 small d-block mb-1">Net GST Payable</span>
                <h3 class="fw-bold text-white">₹0.00</h3>
                <p class="text-white text-opacity-50 mb-0" style="font-size: 10px;">Estimated for current period</p>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Taxable Invoices</h5>
    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Assessable Value</th>
                    <th>CGST (9%)</th>
                    <th>SGST (9%)</th>
                    <th>Total Tax</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                <tr>
                    <td>{{ $inv->invoice_number }}</td>
                    <td>{{ $inv->invoice_date->format('d M, Y') }}</td>
                    <td>₹{{ number_format($inv->subtotal, 2) }}</td>
                    <td>₹{{ number_format($inv->tax_amount / 2, 2) }}</td>
                    <td>₹{{ number_format($inv->tax_amount / 2, 2) }}</td>
                    <td class="fw-bold">₹{{ number_format($inv->tax_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-file-invoice fs-1 d-block mb-3 opacity-25"></i>
                        No taxable invoices found in this period.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

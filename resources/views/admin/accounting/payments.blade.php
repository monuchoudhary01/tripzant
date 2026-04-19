@extends('layouts.accounting')

@section('acc_content')
<div class="glass-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Payment Transactions</h2>
        <button class="btn-acc-primary"><i class="fas fa-plus me-2"></i> Record Payment</button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Date</th>
                    <th>Invoice / Ref</th>
                    <th>Source</th>
                    <th>Ammount</th>
                    <th>Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->entry_date->format('d M, Y') }}</td>
                    <td><span class="badge bg-secondary">INV-{{ $payment->reference_id }}</span></td>
                    <td>{{ $payment->description }}</td>
                    <td class="text-success fw-bold">₹{{ number_format($payment->ledgerEntries->where('debit', '>', 0)->first()->debit ?? 0, 2) }}</td>
                    <td><i class="fas fa-university me-2 opacity-50"></i> Bank Transfer</td>
                    <td><span class="badge bg-success">Settled</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>
@endsection

@extends('layouts.accounting')

@section('acc_content')
<div class="accounting-ledger">
    <div class="page-header">
        <div>
            <h1>General Ledger</h1>
            <p>Complete transaction history across all accounts</p>
        </div>
        <div class="actions">
            <button class="btn btn-outline-primary"><i class="fas fa-file-export"></i> Export CSV</button>
            <button class="btn btn-primary"><i class="fas fa-plus"></i> New Journal Entry</button>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <select class="form-select">
            <option value="">All Accounts</option>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->code }})</option>
            @endforeach
        </select>
        <input type="date" class="form-control" name="start_date">
        <input type="date" class="form-control" name="end_date">
        <button class="btn btn-dark">Filter</button>
    </div>

    <!-- Ledger Table -->
    <div class="content-card mt-4 p-0 overflow-hidden">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Date</th>
                    <th>Ref ID</th>
                    <th>Account</th>
                    <th>Description</th>
                    <th class="text-end">Debit</th>
                    <th class="text-end">Credit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entries as $entry)
                <tr>
                    <td>{{ $entry->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <span class="badge bg-secondary">{{ $entry->journalEntry->reference_type }}</span>
                        <small class="ms-1">#{{ $entry->journalEntry->reference_id }}</small>
                    </td>
                    <td class="fw-bold">{{ $entry->account->name }}</td>
                    <td class="text-muted small">{{ $entry->description }}</td>
                    <td class="text-end text-success fw-bold">{{ $entry->debit > 0 ? '₹'.number_format($entry->debit, 2) : '-' }}</td>
                    <td class="text-end text-danger fw-bold">{{ $entry->credit > 0 ? '₹'.number_format($entry->credit, 2) : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $entries->links() }}
    </div>
</div>

<style>
.accounting-ledger {
    padding: 1rem;
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}
.page-header h1 {
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0;
}
.filter-bar {
    display: flex;
    gap: 1rem;
    background: #fff;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.content-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.table th {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1.25rem 1rem;
}
.table td {
    padding: 1rem;
    vertical-align: middle;
}
</style>
@endsection

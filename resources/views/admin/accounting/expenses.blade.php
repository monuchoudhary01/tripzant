@extends('layouts.accounting')

@section('acc_content')
<div class="glass-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Business Expenses</h2>
        <button class="btn-acc-primary" data-bs-toggle="modal" data-bs-target="#expenseModal"><i class="fas fa-plus me-2"></i> Add Expense</button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $exp)
                <tr>
                    <td>{{ $exp->expense_date->format('d M, Y') }}</td>
                    <td><span class="badge bg-secondary opacity-75">{{ $exp->account->name }}</span></td>
                    <td>{{ $exp->title }}</td>
                    <td class="text-danger fw-bold">₹{{ number_format($exp->amount, 2) }}</td>
                    <td>{{ $exp->payment_method }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-light border-0"><i class="fas fa-paperclip"></i></button>
                        <button class="btn btn-sm btn-outline-light border-0"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Simple Modal Mockup -->
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary rounded-4 p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Record New Expense</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small text-muted">Expense Title</label>
                    <input type="text" class="form-control bg-secondary bg-opacity-10 border-secondary text-white rounded-3">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label small text-muted">Category</label>
                        <select class="form-select bg-secondary bg-opacity-10 border-secondary text-white rounded-3">
                            <option>Office Rent</option>
                            <option>Marketing</option>
                            <option>API Subscription</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label small text-muted">Amount</label>
                        <input type="number" class="form-control bg-secondary bg-opacity-10 border-secondary text-white rounded-3">
                    </div>
                </div>
                <button class="btn btn-primary w-100 rounded-3 py-2 fw-bold">Save Expense</button>
            </div>
        </div>
    </div>
</div>
@endsection

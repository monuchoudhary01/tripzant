@extends('layouts.admin')

@section('admin_content')
<div class="row mb-5">
    <div class="col-md-7">
        <h2 class="fw-900 text-navy mb-1">Payout Requests</h2>
        <p class="text-muted">Manage and process withdrawal requests from affiliate partners.</p>
    </div>
</div>

<div class="card-admin border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-0 px-4 fw-800 text-uppercase small text-muted">Affiliate User</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Amount</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Method</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Date</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Status</th>
                    <th class="border-0 text-end px-4 fw-800 text-uppercase small text-muted">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $withdrawal)
                <tr>
                    <td class="px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                {{ substr($withdrawal->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-800">{{ $withdrawal->user->name }}</h6>
                                <span class="small text-muted">{{ $withdrawal->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td><h6 class="fw-900 mb-0">₹{{ number_format($withdrawal->amount, 2) }}</h6></td>
                    <td>
                        <span class="badge bg-navy bg-opacity-10 text-navy px-3 py-2 rounded-pill fw-bold">
                            {{ strtoupper($withdrawal->payment_method) }}
                        </span>
                    </td>
                    <td>{{ $withdrawal->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($withdrawal->status === 'pending')
                            <span class="badge-admin-warning">PENDING</span>
                        @else
                            <span class="badge-admin-success">PAID</span>
                        @endif
                    </td>
                    <td class="text-end px-4">
                        @if($withdrawal->status === 'pending')
                            <form action="{{ route('admin.affiliates.pay', $withdrawal->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-navy btn-sm px-4 fw-bold rounded-pill" onclick="return confirm('Mark this withdrawal as paid?')">
                                    <i class="fas fa-check-circle me-1"></i> MARK AS PAID
                                </button>
                            </form>
                        @else
                            <button class="btn btn-outline-success btn-sm px-4 fw-bold rounded-pill" disabled>
                                <i class="fas fa-check"></i> PROCESSED
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-25 mb-3"><i class="fas fa-wallet fa-3x"></i></div>
                        <h6 class="text-muted">No payout requests found at this moment.</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

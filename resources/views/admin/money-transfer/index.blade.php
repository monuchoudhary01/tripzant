@extends('layouts.admin')

@section('title', 'Global Money Transfers | Admin')

@section('admin_content')
<div class="row mb-5">
    <div class="col-md-8">
        <h2 class="fw-900 text-navy mb-1">Global Money Transfer Control</h2>
        <p class="text-muted">Monitor and manage all international and internal fund transfers across the network.</p>
    </div>
    <div class="col-md-4">
        <div class="d-flex justify-content-end gap-2 align-items-center h-100">
            <a href="{{ route('money-transfer.index') }}" class="btn btn-navy shadow-sm">
                <i class="fas fa-paper-plane me-2"></i> Send Money
            </a>
            <a href="{{ route('admin.money-transfer.providers') }}" class="btn btn-admin-primary shadow-sm">
                <i class="fas fa-university me-2"></i> Manage Providers
            </a>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card-admin text-center">
            <div class="text-muted small fw-bold mb-2">TOTAL TRANSFERS</div>
            <h3 class="fw-900 text-navy mb-0">{{ $transfers->total() }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin text-center border-start border-5 border-success">
            <div class="text-muted small fw-bold mb-2">SUCCESSFUL</div>
            <h3 class="fw-900 text-success mb-0">{{ $transfers->where('status', 'success')->count() }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin text-center border-start border-5 border-warning">
            <div class="text-muted small fw-bold mb-2">PROCESSING</div>
            <h3 class="fw-900 text-warning mb-0">{{ $transfers->where('status', 'processing')->count() }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin text-center border-start border-5 border-danger">
            <div class="text-muted small fw-bold mb-2">FAILED</div>
            <h3 class="fw-900 text-danger mb-0">{{ $transfers->where('status', 'failed')->count() }}</h3>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-0 pt-0 pb-3 font-monospace small text-muted">REF ID</th>
                    <th class="pt-0 pb-3 font-monospace small text-muted">USER / SENDER</th>
                    <th class="pt-0 pb-3 font-monospace small text-muted">PROVIDER</th>
                    <th class="pt-0 pb-3 font-monospace small text-muted">AMOUNT</th>
                    <th class="pt-0 pb-3 font-monospace small text-muted">STATUS</th>
                    <th class="pt-0 pb-3 font-monospace small text-muted">DATE</th>
                    <th class="text-end pt-0 pb-3 font-monospace small text-muted pe-0">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transfers as $tx)
                <tr>
                    <td class="ps-0 fw-bold">{{ $tx->transfer_ref }}</td>
                    <td>
                        <div class="fw-bold text-navy">{{ $tx->user->name ?? 'N/A' }}</div>
                        <div class="small text-muted">{{ $tx->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <span class="badge bg-light text-navy border px-3 py-2 rounded-3">
                            {{ $tx->provider->name ?? 'Manual' }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-900">{{ number_format($tx->source_amount, 2) }} {{ $tx->source_currency }}</div>
                        <div class="small text-success">→ {{ number_format($tx->target_amount, 2) }} {{ $tx->target_currency }}</div>
                    </td>
                    <td>
                        <span class="badge-admin-{{ $tx->status === 'success' ? 'success' : ($tx->status === 'failed' ? 'danger' : 'warning') }}">
                            {{ ucfirst($tx->status) }}
                        </span>
                    </td>
                    <td>{{ $tx->created_at->format('M d, Y') }}<br><small class="text-muted">{{ $tx->created_at->format('H:i') }}</small></td>
                    <td class="text-end pe-0">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                <li>
                                    <form action="{{ route('admin.money-transfer.status.update', $tx->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="success">
                                        <button type="submit" class="dropdown-item rounded-3 py-2"><i class="fas fa-check-circle text-success me-2"></i> Mark Success</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.money-transfer.status.update', $tx->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="failed">
                                        <button type="submit" class="dropdown-item rounded-3 py-2 text-danger"><i class="fas fa-times-circle me-2"></i> Mark Failed</button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="fas fa-eye me-2"></i> View Full Metadata</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $transfers->links() }}
    </div>
</div>
@endsection

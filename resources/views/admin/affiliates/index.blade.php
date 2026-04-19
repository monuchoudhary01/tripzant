@extends('layouts.admin')

@section('admin_content')
<div class="row mb-5 align-items-center">
    <div class="col-md-7">
        <h2 class="fw-900 text-navy mb-1">Affiliate & Partner Management</h2>
        <p class="text-muted">Review applications, monitor earnings, and manage service settings.</p>
    </div>
    <div class="col-md-5 text-md-end">
        <a href="{{ route('admin.affiliates.withdrawals') }}" class="btn btn-navy shadow-sm">
            <i class="fas fa-wallet me-2"></i> Payout Requests
        </a>
    </div>
</div>

<div class="card-admin border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="border-0 px-4 fw-800 text-uppercase small text-muted">Affiliate Info</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Service Details</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Affiliate Code</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Earnings</th>
                    <th class="border-0 fw-800 text-uppercase small text-muted">Status</th>
                    <th class="border-0 text-end px-4 fw-800 text-uppercase small text-muted">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($providers as $p)
                <tr>
                    <td class="px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px;">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-800 text-navy">{{ $p->name }}</h6>
                                <span class="small text-muted">{{ $p->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill small fw-bold mb-1">{{ $p->service_category }}</span>
                            <div class="small text-muted fw-bold">₹{{ $p->pricing }}/hr | {{ $p->provider_location }}</div>
                        </div>
                    </td>
                    <td>
                        @if($p->affiliate_code)
                            <code class="fw-bold bg-light p-2 rounded border text-primary">{{ $p->affiliate_code }}</code>
                        @else
                            <span class="text-muted italic small">Not Generated</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-900 text-success">₹{{ number_format(\App\Models\Commission::where('user_id', $p->id)->sum('amount'), 2) }}</div>
                        <div class="x-small text-muted fw-bold">TOTAL EARNED</div>
                    </td>
                    <td>
                        @if($p->is_approved)
                            <span class="badge-admin-success">VERIFIED</span>
                        @else
                            <span class="badge-admin-warning">PENDING REVIEW</span>
                        @endif
                    </td>
                    <td class="text-end px-4">
                        <div class="d-flex justify-content-end gap-2">
                            @if(!$p->is_approved)
                            <form action="{{ route('admin.affiliates.approve', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-navy btn-sm rounded-pill fw-bold px-3">APPROVE</button>
                            </form>
                            @endif
                            <button class="btn btn-sm btn-light border rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-ellipsis-v"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">No affiliates found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Manage Cargo Promo Codes')

@section('admin_content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-navy">Promo Codes & Discounts</h2>
                <p class="text-muted">Create rewards for cargo shipments to be used in Flights/Hotels.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-2"></i> Create New Code
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Min. Spend</th>
                        <th>Expiry</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promoCodes as $promo)
                    <tr>
                        <td class="ps-4"><span class="badge bg-soft-primary text-primary px-3 py-2 fw-bold">{{ $promo->code }}</span></td>
                        <td>{{ ucfirst($promo->type) }}</td>
                        <td class="fw-bold">{{ $promo->type == 'percentage' ? $promo->value.'%' : '$'.$promo->value }}</td>
                        <td>${{ $promo->min_spend }}</td>
                        <td>{{ $promo->expires_at ? $promo->expires_at->format('d M, Y') : 'Never' }}</td>
                        <td>
                            <span class="badge {{ $promo->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                {{ $promo->is_active ? 'Active' : 'Expired' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-icon border-0"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

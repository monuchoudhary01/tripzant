@extends('layouts.admin')

@section('title', 'Offers Management | Trip Zant Admin')

@section('admin_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header & Filters -->
    <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-4">
            <h4 class="fw-bold mb-1">Offers Management</h4>
            <p class="text-muted small mb-0">Manage all promotional deals and bank offers.</p>
        </div>
        <div class="col-lg-5">
            <form action="{{ route('admin.offers.index') }}" method="GET" class="d-flex gap-2">
                <select name="category" class="form-select border-2 shadow-none" style="width: 150px;">
                    <option value="">All Categories</option>
                    @foreach(['Flights', 'Hotels', 'Homestays', 'Cabs', 'Trains', 'Holidays', 'Insurance', 'eSIM', 'Bank Offer'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-2 shadow-none" placeholder="Search title..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="bx bx-search"></i></button>
                    @if(request('category') || request('search'))
                        <a href="{{ route('admin.offers.index') }}" class="btn btn-outline-secondary"><i class="bx bx-reset"></i></a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-lg-3 text-lg-end">
            <a href="{{ route('admin.offers.create') }}" class="btn btn-sneat-primary shadow-sm">
                <i class="bx bx-plus-circle me-1"></i> Create Offer
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bx bxs-check-circle me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Offers Table -->
    <div class="card-sneat border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase x-small fw-bold text-muted">Offer Details</th>
                        <th class="py-3 text-uppercase x-small fw-bold text-muted">Category</th>
                        <th class="py-3 text-uppercase x-small fw-bold text-muted">Promo Info</th>
                        <th class="py-3 text-uppercase x-small fw-bold text-muted">Performance</th>
                        <th class="py-3 text-uppercase x-small fw-bold text-muted">Status</th>
                        <th class="py-3 text-uppercase x-small fw-bold text-muted text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($offers as $offer)
                    <tr class="offer-row">
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="offer-img-container me-3 shadow-sm rounded">
                                    <img src="{{ $offer->image_url }}" alt="" class="offer-thumb">
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $offer->title }}</div>
                                    <div class="text-muted small opacity-75">{{ Str::limit($offer->description, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $categoryColors = [
                                    'Flights' => 'primary',
                                    'Hotels' => 'success',
                                    'Cabs' => 'info',
                                    'Trains' => 'danger',
                                    'Bank Offer' => 'warning',
                                    'Holidays' => 'secondary'
                                ];
                                $color = $categoryColors[$offer->category] ?? 'dark';
                            @endphp
                            <span class="badge bg-label-{{ $color }} rounded-pill px-3">{{ $offer->category }}</span>
                        </td>
                        <td>
                            @if($offer->promo_code)
                                <div class="d-flex flex-column">
                                    <code class="fw-bold mb-1" style="width:fit-content; color:var(--sneat-primary)">{{ $offer->promo_code }}</code>
                                    <span class="text-success small fw-bold">{{ $offer->discount_text }}</span>
                                </div>
                            @else
                                <span class="text-muted small">No code required</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small fw-bold text-dark">{{ rand(50, 500) }} Clicks</span>
                                <div class="progress mt-1" style="height: 4px; width: 60px;">
                                    <div class="progress-bar" style="width: {{ rand(30, 90) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.offers.toggle', $offer->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="status-toggle border-0 bg-transparent p-0" data-bs-toggle="tooltip" title="Click to toggle status">
                                    @if($offer->is_active)
                                        <span class="badge bg-success-light text-success fw-bold">
                                            <i class="bx bxs-circle me-1 small"></i> ACTIVE
                                        </span>
                                    @else
                                        <span class="badge bg-danger-light text-danger fw-bold">
                                            <i class="bx bxs-circle me-1 small"></i> INACTIVE
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-icon btn-label-primary btn-sm rounded-circle" data-bs-toggle="tooltip" title="Edit Offer">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this offer?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-label-danger btn-sm rounded-circle" data-bs-toggle="tooltip" title="Delete Offer">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="bx bx-spreadsheet display-1 text-light mb-3"></i>
                                <h5 class="text-muted">No Offers Found</h5>
                                <p class="text-muted small">Get started by creating your first promotional campaign.</p>
                                <a href="{{ route('admin.offers.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 mt-2">Create Offer</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <div class="text-muted small">Showing {{ $offers->firstItem() }} to {{ $offers->lastItem() }} of {{ $offers->total() }} results</div>
            {{ $offers->links() }}
        </div>
    </div>
</div>

<style>
    /* Premium Table Enhancements */
    .offer-row { transition: all 0.2s ease; cursor: default; }
    .offer-row:hover { background-color: #fcfdff !important; }
    
    .offer-img-container { width: 70px; height: 50px; overflow: hidden; background: #f1f3f5; }
    .offer-thumb { width: 100%; height: 100%; object-fit: cover; }
    
    .status-toggle { cursor: pointer; transition: opacity 0.2s; }
    .status-toggle:hover { opacity: 0.8; }
    
    .bg-success-light { background-color: #e8fadf !important; color: #71dd37 !important; }
    .bg-danger-light { background-color: #ffe5e0 !important; color: #ff3e1d !important; }
    
    .btn-label-primary { background-color: #e7e7ff; color: #696cff; border: none; }
    .btn-label-primary:hover { background-color: #696cff; color: #fff; }
    
    .btn-label-danger { background-color: #ffe5e0; color: #ff3e1d; border: none; }
    .btn-label-danger:hover { background-color: #ff3e1d; color: #fff; }
    
    .x-small { font-size: 11px; letter-spacing: 0.5px; }
    
    /* Pagination Overrides */
    .pagination { margin-bottom: 0; }
    .page-link { border-radius: 6px !important; margin: 0 2px; border: none; background: #f8f9fa; color: #566a7f; }
    .page-item.active .page-link { background-color: var(--sneat-primary); color: #fff; }
</style>
@endsection

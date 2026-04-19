@extends('layouts.admin')

@section('title', 'Partnership Requests — Admin')

@section('admin_content')
<div class="p-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 4px;">Partnership Requests</h2>
            <p style="color: #64748b; font-size: 14px;">Review and approve new partnership applications.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary" style="border-radius: 10px; font-weight: 600;">View All Users</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; background: #dcfce7; color: #166534;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f1f5f9;">
                    <tr>
                        <th class="px-4 py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Partner Info</th>
                        <th class="py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Role / Company</th>
                        <th class="py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Applied Date</th>
                        <th class="py-3 text-end px-4" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-4">
                            <div class="d-flex align-items-center">
                                <div style="width: 40px; height: 40px; border-radius: 12px; background: #6366f1; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 12px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">{{ $user->name }}</h6>
                                    <p class="mb-0 small text-muted">{{ $user->email }} | {{ $user->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 6px; padding: 6px 10px; font-weight: 600;">
                                {{ strtoupper($user->role) }}
                            </span>
                            @if($user->company_name || $user->agency_name)
                                <div class="mt-1 small text-muted">
                                    <i class="fas fa-building me-1"></i> {{ $user->company_name ?? $user->agency_name }}
                                </div>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex justify-content-end gap-2 align-items-center">
                                <!-- View Details Trigger -->
                                <button type="button" class="btn btn-sm btn-light border" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;" data-bs-toggle="modal" data-bs-target="#viewModal-{{ $user->id }}">
                                    <i class="fas fa-eye me-1 text-primary"></i> View
                                </button>
                                
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" style="border-radius: 8px; font-weight: 600; padding: 6px 16px;">Approve</button>
                                </form>
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 8px; font-weight: 600; padding: 6px 16px;">Reject</button>
                                </form>
                            </div>

                            <!-- Application Details Modal -->
                            <div class="modal fade" id="viewModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                        <div class="modal-header border-0 pb-0 px-4 pt-4">
                                            <h5 class="fw-800 text-navy mb-0">Application Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4 text-start">
                                            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                                                <div style="width: 50px; height: 50px; border-radius: 12px; background: #002f55; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 20px; margin-right: 15px;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                                    <p class="mb-0 text-muted small">{{ strtoupper($user->role) }}</p>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Email</label>
                                                    <p class="fw-bold small">{{ $user->email }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Mobile</label>
                                                    <p class="fw-bold small">{{ $user->phone }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Business Name</label>
                                                    <p class="fw-bold small">{{ $user->company_name ?? $user->agency_name ?? 'N/A' }}</p>
                                                </div>
                                            </div>

                                            @if($user->business_metadata)
                                                <hr class="my-4 opacity-10">
                                                <h6 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle me-1"></i> Specialized Information</h6>
                                                <div class="bg-light p-3 rounded-3 border">
                                                    @foreach($user->business_metadata as $key => $value)
                                                        <div class="mb-2 d-flex justify-content-between align-items-center">
                                                            <span class="text-muted x-small fw-bold text-uppercase">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span class="small fw-bold text-navy">{{ $value }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4">
                                            <button type="button" class="btn btn-navy w-100 py-2 fw-bold rounded-3" data-bs-dismiss="modal">Close Review</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <img src="/img/empty.svg" alt="No requests" height="80" class="mb-3 opacity-25">
                            <p style="color: #64748b;">No pending partnership requests found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

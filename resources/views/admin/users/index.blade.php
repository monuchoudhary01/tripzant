@extends('layouts.admin')

@section('title', 'Registered Users — Admin')

@section('admin_content')
<div class="p-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 4px;">User Management</h2>
            <p style="color: #64748b; font-size: 14px;">Manage all registered users and their partnership status.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm" style="border-radius: 10px; font-weight: 700; background: #002f55; border: none;">
                <i class="fas fa-plus me-1"></i> Add New Member
            </a>
            <a href="{{ route('admin.users.requests') }}" class="btn btn-outline-primary" style="border-radius: 10px; font-weight: 600;">View Pending Requests</a>
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
                        <th class="px-4 py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">User Info</th>
                        <th class="py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Role</th>
                        <th class="py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Status</th>
                        <th class="py-3" style="color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">Registration Date</th>
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
                                    <p class="mb-0 small text-muted">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 6px; padding: 6px 10px; font-weight: 600;">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->status == 'active')
                                <span class="badge bg-success" style="border-radius: 6px; font-weight: 600; padding: 6px 10px;">ACTIVE</span>
                            @elseif($user->status == 'pending')
                                <span class="badge bg-warning text-dark" style="border-radius: 6px; font-weight: 600; padding: 6px 10px;">PENDING</span>
                            @else
                                <span class="badge bg-danger" style="border-radius: 6px; font-weight: 600; padding: 6px 10px;">{{ strtoupper($user->status) }}</span>
                            @endif
                        </td>
                        <td style="color: #64748b; font-size: 14px;">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-light border" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;" data-bs-toggle="modal" data-bs-target="#viewModal-{{ $user->id }}">
                                    <i class="fas fa-eye me-1 text-primary"></i> View
                                </button>
                                <button class="btn btn-sm btn-light border" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;">Edit</button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger border-0" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 8px; font-weight: 600;">Delete</button>
                                </form>
                            </div>

                            <!-- User Details Modal -->
                            <div class="modal fade" id="viewModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                                        <div class="modal-header border-0 pb-0 px-4 pt-4">
                                            <h5 class="fw-800 text-navy mb-0">Full Profile Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4 text-start">
                                            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-4">
                                                <div style="width: 54px; height: 54px; border-radius: 14px; background: #002f55; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 22px; margin-right: 15px;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold fs-5 text-navy">{{ $user->name }}</h6>
                                                    <span class="badge bg-primary-subtle text-primary x-small">{{ strtoupper($user->role) }}</span>
                                                </div>
                                            </div>

                                            <div class="row g-4">
                                                <div class="col-6">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Email Address</label>
                                                    <p class="fw-bold small text-navy mb-0">{{ $user->email }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Phone Number</label>
                                                    <p class="fw-bold small text-navy mb-0">{{ $user->phone }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Status</label>
                                                    <p class="mb-0"><span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-warning' }}">{{ strtoupper($user->status) }}</span></p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="x-small fw-bold text-muted text-uppercase mb-1">Joined On</label>
                                                    <p class="fw-bold small text-navy mb-0">{{ $user->created_at->format('d M, Y') }}</p>
                                                </div>
                                            </div>

                                            @if($user->role !== 'user')
                                                <hr class="my-4 opacity-10">
                                                <h6 class="fw-bold text-navy mb-3"><i class="fas fa-building me-2"></i> Business Information</h6>
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="x-small fw-bold text-muted text-uppercase mb-1">Agency/Company Name</label>
                                                        <p class="fw-bold small text-navy">{{ $user->company_name ?? $user->agency_name ?? 'Not Provided' }}</p>
                                                    </div>
                                                    @if($user->gst_number)
                                                    <div class="col-6">
                                                        <label class="x-small fw-bold text-muted text-uppercase mb-1">GST Number</label>
                                                        <p class="fw-bold small text-navy">{{ $user->gst_number }}</p>
                                                    </div>
                                                    @endif
                                                    @if($user->provider_location)
                                                    <div class="col-6">
                                                        <label class="x-small fw-bold text-muted text-uppercase mb-1">Location</label>
                                                        <p class="fw-bold small text-navy">{{ $user->provider_location }}</p>
                                                    </div>
                                                    @endif
                                                </div>

                                                @if($user->business_metadata)
                                                    <div class="mt-4">
                                                        <label class="x-small fw-bold text-muted text-uppercase mb-2">Additional Metadata</label>
                                                        <div class="bg-light p-3 rounded-3 border-0">
                                                            @foreach($user->business_metadata as $key => $value)
                                                                <div class="mb-2 d-flex justify-content-between">
                                                                    <span class="text-muted small fw-600">{{ str_replace(['_', '-'], ' ', ucfirst($key)) }}</span>
                                                                    <span class="small fw-800 text-navy">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4">
                                            <button type="button" class="btn btn-navy w-100 py-2 fw-bold rounded-3" data-bs-dismiss="modal" style="background: #002f55; color: #fff;">Close Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <p style="color: #64748b;">No users found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

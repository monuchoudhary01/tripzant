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

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
        <div class="card-body p-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, email, phone..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>
                <div class="col-md-3">
                    @php $filterRoles = \App\Models\Role::where('slug', '!=', 'admin')->get(); @endphp
                    <select name="role" class="form-select" style="border-radius: 10px;" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        @foreach($filterRoles as $fRole)
                            <option value="{{ $fRole->slug }}" {{ request('role') == $fRole->slug ? 'selected' : '' }}>{{ $fRole->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" style="border-radius: 10px;" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-navy w-100 fw-bold" style="background: #002f55; color: #fff; border-radius: 10px;">Filter</button>
                </div>
            </form>
        </div>
    </div>

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
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-light border" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;">
                                    <i class="fas fa-eye me-1 text-primary"></i> View
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light border" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;">
                                    <i class="fas fa-edit me-1 text-info"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger border-0" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </form>
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

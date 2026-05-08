@extends('layouts.admin')

@section('title', 'Edit User Account — Admin')

@section('admin_content')
<div class="p-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none fw-bold small">
            <i class="fas fa-arrow-left me-1"></i> Back to User List
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 4px;">Edit User Account</h2>
            <p style="color: #64748b; font-size: 14px;">Modify profile details and access permissions for <strong>{{ $user->name }}</strong>.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <ul class="mb-0 small fw-bold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius: 20px;">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <!-- Core Account Section -->
                <div class="col-12">
                    <h5 class="fw-800 text-navy border-bottom pb-2 mb-3">Core Account Information</h5>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">FULL NAME / CONTACT PERSON</label>
                    <input type="text" name="name" class="form-control rounded-3 p-3 shadow-none border @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="e.g. John Smith" required>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">EMAIL ADDRESS (LOGIN ID)</label>
                    <input type="email" name="email" class="form-control rounded-3 p-3 shadow-none border @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="name@domain.com" required>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">PHONE / MOBILE NUMBER</label>
                    <input type="text" name="phone" class="form-control rounded-3 p-3 shadow-none border @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="+91 00000 00000" required>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">UPDATE PASSWORD</label>
                    <input type="text" name="password" class="form-control rounded-3 p-3 shadow-none border @error('password') is-invalid @enderror" placeholder="Leave blank to keep current password">
                    <p class="x-small text-muted mt-1">Only fill this if you want to reset the user's password.</p>
                </div>

                <!-- Role & Business Section -->
                <div class="col-12 mt-5">
                    <h5 class="fw-800 text-navy border-bottom pb-2 mb-3">Access & Business Profile</h5>
                </div>

                <div class="col-md-4">
                    <label class="small fw-800 text-muted mb-2 uppercase">ACCOUNT ROLE / PERMISSION</label>
                    <select name="role" class="form-select rounded-3 p-3 shadow-none border fw-bold @error('role') is-invalid @enderror" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->slug }}" {{ $user->role == $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="small fw-800 text-muted mb-2 uppercase">ACCOUNT STATUS</label>
                    <select name="status" class="form-select rounded-3 p-3 shadow-none border fw-bold @error('status') is-invalid @enderror" required>
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>ACTIVE</option>
                        <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                        <option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>REJECTED</option>
                        <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>SUSPENDED</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="small fw-800 text-muted mb-2 uppercase">BUSINESS / AGENCY NAME</label>
                    <input type="text" name="agency_name" class="form-control rounded-3 p-3 shadow-none border" value="{{ old('agency_name', $user->agency_name ?? $user->company_name) }}" placeholder="e.g. Tripzant Travels Pvt Ltd">
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">GST / TAX REGISTRATION NO</label>
                    <input type="text" name="gst_number" class="form-control rounded-3 p-3 shadow-none border" value="{{ old('gst_number', $user->gst_number) }}" placeholder="GSTIN (Optional)">
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-900 shadow-lg transition-fast hvr-grow">
                        UPDATE USER ACCOUNT <i class="fas fa-save ms-2"></i>
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-5 py-3 rounded-pill fw-800 ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

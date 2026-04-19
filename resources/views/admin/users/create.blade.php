@extends('layouts.admin')

@section('title', 'Add New User/Partner — Admin')

@section('admin_content')
<div class="p-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none fw-bold small">
            <i class="fas fa-arrow-left me-1"></i> Back to User List
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 4px;">Add New Member</h2>
            <p style="color: #64748b; font-size: 14px;">Directly create a new partner, agent, or client account.</p>
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
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="row g-4">
                <!-- Core Account Section -->
                <div class="col-12">
                    <h5 class="fw-800 text-navy border-bottom pb-2 mb-3">Core Account Information</h5>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">FULL NAME / CONTACT PERSON</label>
                    <input type="text" name="name" class="form-control rounded-3 p-3 shadow-none border @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. John Smith" required>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">EMAIL ADDRESS (LOGIN ID)</label>
                    <input type="email" name="email" class="form-control rounded-3 p-3 shadow-none border @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@domain.com" required>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">PHONE / MOBILE NUMBER</label>
                    <input type="text" name="phone" class="form-control rounded-3 p-3 shadow-none border @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+91 00000 00000" required>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">ACCOUNT PASSWORD</label>
                    <input type="text" name="password" class="form-control rounded-3 p-3 shadow-none border @error('password') is-invalid @enderror" placeholder="Default login password" required>
                    <p class="x-small text-muted mt-1">Provide a temporary password for the user.</p>
                </div>

                <!-- Role & Business Section -->
                <div class="col-12 mt-5">
                    <h5 class="fw-800 text-navy border-bottom pb-2 mb-3">Access & Business Profile</h5>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">ACCOUNT ROLE / PERMISSION</label>
                    <select name="role" class="form-select rounded-3 p-3 shadow-none border fw-bold @error('role') is-invalid @enderror" required>
                        <option value="" disabled selected>Select Role</option>
                        <optgroup label="Core Staff">
                            <option value="admin">System Administrator</option>
                            <option value="super-admin">Super Admin</option>
                        </optgroup>
                        <optgroup label="Premium Partners (Direct Only)">
                            <option value="iata">IATA Ticketing Agent</option>
                            <option value="amadeus-partner">Amadeus GDS Partner</option>
                        </optgroup>
                        <optgroup label="Other Partners">
                            <option value="b2b">B2B Travel Agent</option>
                            <option value="hotel-partner">Hotel / Property Partner</option>
                            <option value="cargo">Cargo / Logistics Partner</option>
                            <option value="corporate">Corporate Client</option>
                            <option value="supplier">Tour Supplier</option>
                        </optgroup>
                        <optgroup label="End Users">
                            <option value="user">Individual Customer (B2C)</option>
                        </optgroup>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">BUSINESS / AGENCY NAME</label>
                    <input type="text" name="business_name" class="form-control rounded-3 p-3 shadow-none border" value="{{ old('business_name') }}" placeholder="e.g. Tripzant Travels Pvt Ltd">
                </div>

                <div class="col-md-6">
                    <label class="small fw-800 text-muted mb-2 uppercase">GST / TAX REGISTRATION NO</label>
                    <input type="text" name="gst_number" class="form-control rounded-3 p-3 shadow-none border" value="{{ old('gst_number') }}" placeholder="GSTIN (Optional)">
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-900 shadow-lg transition-fast hvr-grow">
                        CREATE ACCOUNT & GENERATE ACCESS <i class="fas fa-user-plus ms-2"></i>
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-5 py-3 rounded-pill fw-800 ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

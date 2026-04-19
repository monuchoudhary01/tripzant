@extends('layouts.affiliate')

@section('content')
<!-- Header -->
<div class="row align-items-center mb-5">
    <div class="col-md-7">
        <h2 class="fw-800 text-dark mb-1">Dashboard Overview</h2>
        <p class="text-muted">Monitor your performance and affiliate network</p>
    </div>
    <div class="col-md-5 text-md-end">
        <div class="d-inline-flex align-items-center p-3 bg-white shadow-sm rounded-4 border">
            <div class="me-3 text-end">
                <span class="text-muted small d-block fw-bold text-uppercase opacity-50">Your Affiliate Code</span>
                <span class="fw-800 text-primary fs-4">{{ $provider->affiliate_code }}</span>
            </div>
            <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                <i class="fas fa-fingerprint text-primary fs-3"></i>
            </div>
        </div>
    </div>
</div>

<!-- Referral Link Card -->
<div class="card border-0 shadow-lg rounded-4 mb-5 overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
    <div class="row g-0 align-items-center">
        <div class="col-md-8 p-5">
            <h4 class="text-white fw-800 mb-2">Share your Referral Link 🚀</h4>
            <p class="text-white opacity-50 mb-4">Every user who joins via your unique link gets linked to you forever. You earn a commission on every booking they make.</p>
            <div class="input-group mb-0">
                <input type="text" class="form-control bg-white bg-opacity-10 border-0 text-white p-3" value="{{ url('/register') }}?ref={{ $provider->affiliate_code }}" id="refLink" readonly style="border-radius: 12px 0 0 12px;">
                <button class="btn btn-primary px-4 fw-bold" onclick="copyRef()" style="border-radius: 0 12px 12px 0;">Copy Link</button>
            </div>
        </div>
        <div class="col-md-4 text-center d-none d-md-block">
            <div class="p-5">
                <div class="p-4 bg-white bg-opacity-10 rounded-circle d-inline-block animate__animated animate__pulse animate__infinite">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card p-4 border-0">
            <div class="bg-primary bg-opacity-10 p-3 rounded-4 d-inline-block mb-3" style="width: fit-content;">
                <i class="fas fa-users text-primary fs-4"></i>
            </div>
            <h3 class="fw-800 mb-0">{{ $referralsCount }}</h3>
            <p class="text-muted fw-bold small text-uppercase">Total Referrals</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 border-0">
            <div class="bg-success bg-opacity-10 p-3 rounded-4 d-inline-block mb-3" style="width: fit-content;">
                <i class="fas fa-money-bill-wave text-success fs-4"></i>
            </div>
            <h3 class="fw-800 mb-0">₹{{ number_format($totalEarnings) }}</h3>
            <p class="text-muted fw-bold small text-uppercase">Total Earnings</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 border-0">
            <div class="bg-warning bg-opacity-10 p-3 rounded-4 d-inline-block mb-3" style="width: fit-content;">
                <i class="fas fa-clock-rotate-left text-warning fs-4"></i>
            </div>
            <h3 class="fw-800 mb-0">₹{{ number_format($pendingCommission) }}</h3>
            <p class="text-muted fw-bold small text-uppercase">Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 border-0">
            <div class="bg-info bg-opacity-10 p-3 rounded-4 d-inline-block mb-3" style="width: fit-content;">
                <i class="fas fa-credit-card text-info fs-4"></i>
            </div>
            <h3 class="fw-800 mb-0">₹{{ number_format($paidCommission) }}</h3>
            <p class="text-muted fw-bold small text-uppercase">Withdrawn</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Referrals -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-800 mb-0 text-navy">Recent Referrals</h5>
                <a href="#" class="text-primary fw-bold small text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 text-muted small fw-800 text-uppercase">User</th>
                            <th class="border-0 text-muted small fw-800 text-uppercase">Joined Date</th>
                            <th class="border-0 text-muted small fw-800 text-uppercase">Status</th>
                            <th class="border-0 text-end px-4 text-muted small fw-800 text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReferrals as $ref)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar p-2 bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <span class="text-primary fw-bold">{{ substr($ref->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-800">{{ $ref->name }}</h6>
                                        <span class="small text-muted">{{ $ref->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $ref->created_at->format('d M Y') }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success p-2 px-3 rounded-pill fw-bold">Active</span></td>
                            <td class="text-end px-4">
                                <button class="btn btn-sm btn-light rounded-pill px-3">Details</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No referrals yet. Share your link to start earning!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Profile Sidebar -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-800 mb-4 text-navy">Quick Actions</h5>
            <button class="btn btn-primary w-100 py-3 mb-3 rounded-3 fw-800 shadow-sm" onclick="Swal.fire('Coming Soon', 'Withdrawal request feature is being integrated.', 'info')">
                <i class="fas fa-money-bill-transfer me-2"></i> Withdraw Request
            </button>
            <button class="btn btn-outline-secondary w-100 py-3 rounded-3 fw-bold" onclick="location.href='/marketplace/provider/{{ $provider->id }}'">
                <i class="fas fa-eye me-2"></i> View Public Profile
            </button>
        </div>
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-800 mb-4 text-navy">Service Details</h5>
            <div class="d-flex justify-content-between mb-3 p-2 bg-light rounded-3">
                <span class="text-muted small fw-bold">Category:</span>
                <span class="fw-800 text-dark">{{ $provider->service_category }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3 p-2 bg-light rounded-3">
                <span class="text-muted small fw-bold">Pricing:</span>
                <span class="fw-800 text-dark">₹{{ $provider->pricing }}/hr</span>
            </div>
            <div class="d-flex justify-content-between p-2 bg-light rounded-3">
                <span class="text-muted small fw-bold">Location:</span>
                <span class="fw-800 text-dark">{{ $provider->provider_location }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyRef() {
        var copyText = document.getElementById("refLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Referral link copied to clipboard.',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>
@endpush

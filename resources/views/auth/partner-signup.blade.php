@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 bg-light" style="min-height: 100vh;">
    <div class="row g-0">
        <!-- Left Banner -->
        <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-center p-5 text-white position-fixed h-100" 
             style="background: linear-gradient(rgba(0,47,85,0.85), rgba(0,47,85,0.85)), url('https://images.unsplash.com/photo-1436491865332-7a61a109c0f3?auto=format&fit=crop&q=80&w=2000'); background-size: cover; background-position: center;">
            <div class="px-lg-5">
                <h1 class="display-4 fw-900 mb-4 tracking-tight">Grow Your Travel Business with Us</h1>
                <p class="lead opacity-75 mb-5 fw-bold">Join our network of 5,000+ partners and reach millions of travelers across the globe.</p>

                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-white text-navy p-2 rounded-3 shadow-sm"><i class="fas fa-chart-line fs-4"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Increase Revenue</h5>
                            <p class="small opacity-75 mb-0">Gain more bookings through our premium platforms and dynamic map experience.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-white text-navy p-2 rounded-3 shadow-sm"><i class="fas fa-tools fs-4"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Easy Management</h5>
                            <p class="small opacity-75 mb-0">Control your listings with our powerful, intuitive dashboard.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-white text-navy p-2 rounded-3 shadow-sm"><i class="fas fa-shield-check fs-4"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Trusted Brand</h5>
                            <p class="small opacity-75 mb-0">Partner with India's most trusted travel partner for 12+ years.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="col-lg-7 offset-lg-5 bg-white d-flex align-items-center justify-content-center py-5">
            <div class="w-100 px-4 px-md-5" style="max-width: 680px;">
                <div class="text-center mb-5">
                    <h2 class="fw-900 text-navy mb-2">Enterprise Registration</h2>
                    <p class="text-muted fw-bold">Join the world's most innovative B2B travel ecosystem.</p>
                </div>

                <div id="alertMsg" class="d-none alert alert-success border-0 shadow-sm rounded-3 p-3 mb-4"></div>

                <form id="partnerSignupForm" class="row g-4" action="{{ route('partner.register') }}" method="POST">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Legal Entity / Business Name</label>
                        <input type="text" name="business_name" class="form-control rounded-3 p-3 shadow-none border" placeholder="e.g. EasyTrip Global Agency" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Partner Category</label>
                        <select name="role" class="form-select rounded-3 p-3 shadow-none border fw-bold" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="b2b">Standard B2B Agent</option>
                            <option value="corporate">Corporate Client (9+ PAX)</option>
                            <option value="supplier">Tour Builder / Supplier</option>
                            <option value="hotel-partner">Hotel Owner / Partner</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Contact Person Name</label>
                        <input type="text" name="contact_name" class="form-control rounded-3 p-3 shadow-none border" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Mobile Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">+91</span>
                            <input type="text" name="phone" class="form-control rounded-3 p-3 shadow-none border border-start-0" placeholder="9876543210" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Email Address (Business)</label>
                        <input type="email" name="email" class="form-control rounded-3 p-3 shadow-none border" placeholder="name@company.com" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Create Password</label>
                        <input type="password" name="password" class="form-control rounded-3 p-3 shadow-none border" placeholder="••••••••" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3 p-3 shadow-none border" placeholder="••••••••" required>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label small text-muted fw-bold" for="terms">
                                I agree to the <a href="#" class="text-navy">Trip Zant Partner Agreement</a> and <a href="#" class="text-navy">Terms of Service</a>.
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" id="submitBtn" class="btn btn-navy w-100 py-3 rounded-3 fw-900 shadow-lg text-uppercase tracking-wider">
                            Become a Partner Today <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <p class="text-muted small fw-bold mb-0">Already registered? <a href="{{ route('partner.login') }}" class="text-navy">Partner Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-navy { background: #002f55; color: #fff; }
    .btn-navy:hover { background: #001f3a; color: #fff; }
    .text-navy { color: #002f55 !important; }
    .fw-900 { font-weight: 900 !important; }
</style>
@endsection

@section('scripts')
<script>
document.getElementById('partnerSignupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const alert = document.getElementById('alertMsg');
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> PROCESSING...';
    btn.disabled = true;

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert.innerText = data.message;
            alert.className = 'alert alert-success border-0 shadow-sm rounded-3 p-3 mb-4';
            alert.classList.remove('d-none');
            this.reset();
        } else {
            alert.innerText = data.message || 'Error occurred during registration.';
            alert.className = 'alert alert-danger border-0 shadow-sm rounded-3 p-3 mb-4';
            alert.classList.remove('d-none');
        }
        btn.innerHTML = 'Become a Partner Today <i class="fas fa-arrow-right ms-2"></i>';
        btn.disabled = false;
    })
    .catch(err => {
        alert.innerText = 'Server error. Please try again later.';
        alert.className = 'alert alert-danger border-0 shadow-sm rounded-3 p-3 mb-4';
        alert.classList.remove('d-none');
        btn.innerHTML = 'Become a Partner Today <i class="fas fa-arrow-right ms-2"></i>';
        btn.disabled = false;
    });
});
</script>
@endsection

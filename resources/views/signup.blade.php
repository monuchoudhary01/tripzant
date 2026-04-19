@extends('layouts.app')

@section('title', " Signup — Easitrip B2B Portal " )

@section('content')
    <div class="auth-wrapper py-5" style="background: var(--gray-100);">
        <div class="auth-card" style="max-width: 600px; margin: auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="height:4px;background:linear-gradient(90deg,var(--orange),var(--blue),var(--navy));"></div>

            <div class="auth-card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <a href="/"><img src="/img/logo.svg" alt="Easitrip" height="64" class="mb-3"></a>
                    <h3 class="fw-900" style="color:var(--navy);">Partner Registration</h3>
                    <p style="font-size:14px;color:var(--gray-300);">Create your B2B account to access exclusive rates.</p>
                </div>

                <form id="signup-form">
                    @csrf
                    <input type="hidden" name="role" value="customer">
                    
                    <div class="alert alert-info border-0 rounded-4 p-3 small mb-4">
                        <i class="fas fa-info-circle me-2"></i> Professional travel partner? 
                        <a href="/partner/signup" class="fw-bold text-navy text-decoration-none ms-1">Register for B2B Portal <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>

                    <!-- Common Fields -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" value="Traveler One" placeholder="Enter name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Contact Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" value="traveler@easitrip.com" placeholder="email@company.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Mobile Number</label>
                        <input type="text" name="phone" id="phone" class="form-control form-control-lg" value="9000010000" placeholder="98XXXXXXXX" required>
                    </div>

                    <!-- Role Specific Fields -->
                    <div id="fields-iata_agent" class="role-fields d-none mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">IATA Code</label>
                                <input type="text" name="iata_code" class="form-control form-control-lg" placeholder="7-Digit">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Agency Name</label>
                                <input type="text" name="agency_name" class="form-control form-control-lg" placeholder="Trade Name">
                            </div>
                        </div>
                    </div>

                    <div id="fields-amadeus_partner" class="role-fields d-none mb-3">
                        <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Office ID (PCC)</label>
                        <input type="text" name="office_id" class="form-control form-control-lg mb-3" placeholder="DELUA21XX">
                    </div>

                    <div id="fields-corporate" class="role-fields d-none mb-3">
                        <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Company Name</label>
                        <input type="text" name="company_name" class="form-control form-control-lg mb-3" placeholder="LLC/Corp Name">
                    </div>

                    <div id="fields-hotel_partner" class="role-fields d-none mb-3">
                        <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Property Name</label>
                        <input type="text" name="property_name" class="form-control form-control-lg mb-3" placeholder="Hotel Name">
                    </div>

                    <div id="fields-tour_supplier" class="role-fields d-none mb-3">
                        <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Company Name (Tour Agency)</label>
                        <input type="text" name="company_name" class="form-control form-control-lg mb-3" placeholder="e.g. Adventure Tours Pvt Ltd">
                    </div>

                    <!-- Auth Fields -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" value="password123" placeholder="Create password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-700" style="font-size:12px;text-transform:uppercase;color:var(--gray-400);">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" value="password123" placeholder="Repeat password" required>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="btn btn-primary-custom w-100 py-3" style="font-size:15px;font-weight:800; border-radius: 12px; background: var(--navy); color: #fff;">
                        Register Account <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p style="font-size:13px;color:var(--gray-300);">Already a partner? <a href="/login{{ request()->has('redirect') ? '?redirect='.urlencode(request()->get('redirect')) : '' }}" style="color:var(--secondary);font-weight:700;">Login Here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentUserId = null;

        document.getElementById('signup-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = document.getElementById('submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
            btn.disabled = true;

            const urlParams = new URLSearchParams(window.location.search);
            const redirect = urlParams.get('redirect');

            fetch('/signup', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    let verifyUrl = '/verify-otp?user_id=' + data.user_id;
                    if (redirect) verifyUrl += '&redirect=' + encodeURIComponent(redirect);
                    window.location.href = verifyUrl;
                } else {
                    alert('Registration Failed: ' + data.message);
                    btn.innerHTML = 'Register Account <i class="fas fa-arrow-right ms-2"></i>';
                    btn.disabled = false;
                }
            });
        });

        document.getElementById('verify-otp-btn').addEventListener('click', function() {
            const otp = document.getElementById('otp-input').value;
            fetch('/verify-otp', {
                method: 'POST',
                body: JSON.stringify({ user_id: currentUserId, otp: otp }),
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Invalid OTP');
                }
            });
        });
    </script>

    <style>
        .form-control, .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 12px !important;
            padding: 12px 16px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(var(--blue-rgb), 0.1);
        }
        .btn-primary-custom:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
@endsection

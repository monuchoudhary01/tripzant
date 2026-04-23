<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden" style="border-radius: 24px; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.3);">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" data-bs-dismiss="modal" style="z-index: 10;"></button>
                <div class="row g-0">
                    <!-- Left Slide (Promo Image) -->
                    <div class="col-lg-5 d-none d-lg-block overflow-hidden" style="min-height: 600px;">
                        <img src="/img/login_promo.png" class="w-100 h-100 object-fit-cover" alt="Join Trip Zant">
                    </div>

                    <!-- Right Form Column -->
                    <div class="col-lg-7 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                        <div class="mx-auto w-100" style="max-width: 440px;">
                            <div class="text-center mb-4">
                                <h1 class="fw-900 text-navy mb-1" style="font-size: 28px;">User Login</h1>
                                <p class="text-muted small fw-bold">Select your preferred login method.</p>
                            </div>

                            <!-- Tabs for Mobile / Email -->
                            <div class="d-flex justify-content-center mb-5" id="loginMethodTabsContainer">
                                <div class="nav nav-pills bg-light p-1 rounded-pill shadow-sm" id="loginMethodTabs" role="tablist">
                                    <button class="nav-link active rounded-pill px-4 fw-800 tracking-wider" id="mobile-login-tab" data-bs-toggle="pill" data-bs-target="#mobile-panel" type="button" style="font-size: 11px;">MOBILE LOGIN</button>
                                    <button class="nav-link rounded-pill px-4 fw-800 tracking-wider" id="email-login-tab" data-bs-toggle="pill" data-bs-target="#email-panel" type="button" style="font-size: 11px;">EMAIL LOGIN</button>
                                </div>
                            </div>

                            <div class="tab-content">
                                <!-- Mobile Login Panel -->
                                <div class="tab-pane fade show active" id="mobile-panel">
                                    <div id="mobile-entry-view">
                                        <label class="small fw-700 text-muted mb-2">Mobile Number</label>
                                        <div class="input-group border rounded-3 p-1 mb-4" style="border-color: #dee2e6 !important;">
                                            <span class="input-group-text bg-transparent border-0 d-flex align-items-center gap-2 px-3">
                                                <img src="https://flagcdn.com/w20/in.png" alt="India" width="20">
                                                <span class="fw-bold fw-700">+91</span>
                                            </span>
                                            <input type="text" id="phone-input" class="form-control border-0 shadow-none fw-700" placeholder="Enter Mobile Number" style="font-size: 16px;">
                                        </div>
                                        <button type="button" onclick="sendLoginOtp()" id="mobile-continue-btn" class="btn btn-primary w-100 rounded-pill fw-800 py-3 shadow-sm mb-4" style="height: 56px; background: #0076f7;">CONTINUE</button>
                                        
                                        <div class="text-center position-relative mb-4">
                                            <hr class="opacity-10">
                                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 x-small fw-700 text-muted italic">Or Join With</span>
                                        </div>
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="javascript:void(0)" class="social-login-btn border rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_\"G\"_logo.svg\" width="20" alt="Google">
                                            </a>
                                        </div>
                                    </div>

                                    <!-- OTP View -->
                                    <div id="otp-verify-view" class="d-none">
                                        <div class="text-center mb-4">
                                            <h4 class="fw-800 text-navy mb-2">Verify Mobile</h4>
                                            <p class="text-muted small">Enter the 4-digit code (Use 1234)</p>
                                        </div>
                                        <div class="d-flex justify-content-center mb-4">
                                            <input type="text" id="otp-input" class="form-control text-center fw-900 border" maxlength="4" style="width: 140px; height: 56px; font-size: 24px; letter-spacing: 5px; border-radius: 12px; border-color: #dee2e6 !important;" placeholder="0000">
                                        </div>
                                        <button type="button" onclick="verifyLoginOtp()" class="btn btn-primary w-100 rounded-pill fw-800 py-3 shadow-sm mb-3" style="height: 56px; background: #0076f7;">VERIFY & LOGIN</button>
                                        <div class="text-center"><a href="javascript:void(0)" onclick="resetMobileView()" class="small text-primary fw-bold text-decoration-none">Change Number</a></div>
                                    </div>
                                </div>

                                <!-- Email Login Panel -->
                                <div class="tab-pane fade" id="email-panel">
                                    <div class="mb-4">
                                        <label class="small fw-700 text-muted mb-2">Email Address</label>
                                        <input type="email" id="email-input" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="name@example.com" style="height: 54px; border-color: #dee2e6 !important;">
                                    </div>
                                    <div class="mb-5">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="small fw-700 text-muted">Password</label>
                                            <a href="javascript:void(0)" onclick="showForgotPassword()" class="small text-decoration-none fw-bold" style="color:#0076f7;">Forgot?</a>
                                        </div>
                                        <input type="password" id="pass-input" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="••••••••" style="height: 54px; border-color: #dee2e6 !important;">
                                    </div>
                                    <button type="button" onclick="loginWithEmail()" class="btn btn-navy w-100 rounded-pill fw-800 py-3 shadow-sm mb-4" style="height: 56px; background: #002f55; color: white;">SIGN IN</button>
                                </div>
                                
                                <!-- Forgot Password Panel -->
                                <div class="tab-pane fade" id="forgot-password-panel">
                                    <div id="forgot-email-view">
                                        <div class="mb-4">
                                            <label class="small fw-700 text-muted mb-2">Registered Email Address</label>
                                            <input type="email" id="forgot-email-input" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="name@example.com" style="height: 54px; border-color: #dee2e6 !important;">
                                        </div>
                                        <button type="button" onclick="sendPasswordResetOtp()" class="btn btn-navy w-100 rounded-pill fw-800 py-3 shadow-sm mb-4" style="height: 56px; background: #002f55; color: white;">SEND RESET OTP</button>
                                        <div class="text-center"><a href="javascript:void(0)" onclick="resetLoginView()" class="small text-primary fw-bold text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back to Login</a></div>
                                    </div>
                                    
                                    <div id="forgot-otp-view" class="d-none">
                                        <div class="mb-4 text-center">
                                            <h5 class="fw-800 text-navy mb-2">Verify & Reset</h5>
                                            <p class="text-muted small">Enter the 4-digit code (Use 1234) and your new password.</p>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <input type="text" id="forgot-otp-input" class="form-control text-center fw-900 border" maxlength="4" style="width: 140px; height: 50px; font-size: 20px; letter-spacing: 5px; border-radius: 12px; border-color: #dee2e6 !important;" placeholder="0000">
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" id="new-password-input" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="New Password" style="height: 54px; border-color: #dee2e6 !important;">
                                        </div>
                                        <button type="button" onclick="verifyPasswordResetOtp()" class="btn btn-primary w-100 rounded-pill fw-800 py-3 shadow-sm mb-3" style="height: 56px; background: #0076f7;">UPDATE PASSWORD</button>
                                        <div class="text-center"><a href="javascript:void(0)" onclick="resetLoginView()" class="small text-primary fw-bold text-decoration-none">Back to Login</a></div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5 pt-4 border-top">
                                <p class="small text-muted fw-bold mb-3">Don't have an account? <a href="javascript:void(0)" onclick="switchToSignupModal()" class="text-primary text-decoration-none">Sign Up</a></p>
                                <p class="x-small text-muted fw-bold mb-0">By continuing, you agree to our <a href="#" class="text-navy text-decoration-none">Terms of Service</a> & <a href="#" class="text-navy text-decoration-none">Privacy Policy</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchToSignupModal() {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal')).hide();
        setTimeout(() => {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('signupModal')).show();
        }, 400);
    }

    function resetMobileView() {
        document.getElementById('mobile-entry-view').classList.remove('d-none');
        document.getElementById('otp-verify-view').classList.add('d-none');
    }

    function sendLoginOtp() {
        const phone = document.getElementById('phone-input').value;
        if(!phone) { 
            Swal.fire({ icon: 'warning', title: 'Action Required', text: 'Please enter a mobile number.' });
            return;
        }

        const btn = document.getElementById('mobile-continue-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> SENDING...'; btn.disabled = true;

        const formData = new FormData();
        formData.append('phone', phone);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/login/send-otp', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('mobile-entry-view').classList.add('d-none');
                document.getElementById('otp-verify-view').classList.remove('d-none');
                Swal.fire({ icon: 'success', title: 'OTP Sent', text: 'Use 1234 to login.', timer: 2000 });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
            }
            btn.innerHTML = 'CONTINUE'; btn.disabled = false;
        });
    }

    function verifyLoginOtp() {
        const otp = document.getElementById('otp-input').value;
        const phone = document.getElementById('phone-input').value;
        const btn = document.querySelector('#otp-verify-view .btn');
        btn.innerHTML = 'VERIFYING...'; btn.disabled = true;

        const formData = new FormData();
        formData.append('phone', phone);
        formData.append('otp', otp);
        formData.append('redirect_to', window.location.href);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/login/verify-otp', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) { window.location.href = data.redirect; }
            else { 
                Swal.fire({ icon: 'error', title: 'Invalid OTP', text: data.message });
                btn.innerHTML = 'VERIFY & LOGIN'; btn.disabled = false;
            }
        });
    }

    function loginWithEmail() {
        const email = document.getElementById('email-input').value;
        const pass = document.getElementById('pass-input').value;
        const btn = document.querySelector('#email-panel .btn');
        btn.innerHTML = 'SIGNING IN...'; btn.disabled = true;

        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', pass);
        formData.append('redirect_to', window.location.href);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/login-unified', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) { window.location.href = data.redirect; }
            else { 
                Swal.fire({ icon: 'error', title: 'Login Failed', text: data.message });
                btn.innerHTML = 'SIGN IN'; btn.disabled = false;
            }
        });
    }

    function showForgotPassword() {
        document.getElementById('loginMethodTabsContainer').classList.add('d-none');
        document.getElementById('mobile-panel').classList.remove('show', 'active');
        document.getElementById('email-panel').classList.remove('show', 'active');
        document.getElementById('forgot-password-panel').classList.add('show', 'active');
        document.querySelector('.text-center h1').innerText = 'Reset Password';
        document.querySelector('.text-center p').innerText = 'Enter email to receive an OTP.';
        document.getElementById('forgot-email-view').classList.remove('d-none');
        document.getElementById('forgot-otp-view').classList.add('d-none');
    }

    function resetLoginView() {
        document.getElementById('loginMethodTabsContainer').classList.remove('d-none');
        document.getElementById('forgot-password-panel').classList.remove('show', 'active');
        
        let isMobile = document.getElementById('mobile-login-tab').classList.contains('active');
        if (isMobile) {
            document.getElementById('mobile-panel').classList.add('show', 'active');
        } else {
            document.getElementById('email-panel').classList.add('show', 'active');
        }
        
        document.querySelector('.text-center h1').innerText = 'User Login';
        document.querySelector('.text-center p').innerText = 'Select your preferred login method.';
    }

    function sendPasswordResetOtp() {
        const email = document.getElementById('forgot-email-input').value;
        if(!email) { 
            Swal.fire({ icon: 'warning', title: 'Action Required', text: 'Please enter your email.' });
            return;
        }

        const btn = document.querySelector('#forgot-email-view .btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> SENDING...'; btn.disabled = true;

        const formData = new FormData();
        formData.append('email', email);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/password/forgot-otp', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('forgot-email-view').classList.add('d-none');
                document.getElementById('forgot-otp-view').classList.remove('d-none');
                document.querySelector('.text-center p').innerText = 'Enter the OTP and new password.';
                Swal.fire({ icon: 'success', title: 'OTP Sent', text: 'Use 1234 for testing.', timer: 2000 });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
            }
            btn.innerHTML = 'SEND RESET OTP'; btn.disabled = false;
        });
    }

    function verifyPasswordResetOtp() {
        const email = document.getElementById('forgot-email-input').value;
        const otp = document.getElementById('forgot-otp-input').value;
        const newPassword = document.getElementById('new-password-input').value;
        
        if(!otp || !newPassword) {
            Swal.fire({ icon: 'warning', title: 'Action Required', text: 'Please enter OTP and a new password.' });
            return;
        }

        const btn = document.querySelector('#forgot-otp-view .btn');
        btn.innerHTML = 'UPDATING...'; btn.disabled = true;

        const formData = new FormData();
        formData.append('email', email);
        formData.append('otp', otp);
        formData.append('password', newPassword);
        formData.append('redirect_to', window.location.href);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/password/reset-otp', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Success', text: 'Password reset successfully. You will be logged in now.', timer: 2000 });
                setTimeout(() => window.location.href = data.redirect, 1500);
            }
            else { 
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
                btn.innerHTML = 'UPDATE PASSWORD'; btn.disabled = false;
            }
        });
    }
</script>

<style>
    .social-login-btn {
        transition: all 0.2s ease;
        text-decoration: none;
        background: #fff;
    }
    .social-login-btn:hover {
        transform: translateY(-2px);
        background: #f8f9fa;
        border-color: #0076f7 !important;
    }
    #loginMethodTabs .nav-link { color: #6c757d; border: none; }
    #loginMethodTabs .nav-link.active { background: #0076f7; color: white; }
    .btn-navy { background: #002f55; color: white; }
    .btn-navy:hover { background: #001a33; color: white; }
    .object-fit-cover { object-fit: cover; }
</style>

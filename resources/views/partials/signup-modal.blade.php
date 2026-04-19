<!-- ====== UNIFIED SIGNUP MODAL (SPLIT SCREEN - UNIFIED FORM) ====== -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden" style="border-radius: 24px; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.3);">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" data-bs-dismiss="modal" style="z-index: 10;"></button>
                <div class="row g-0">
                    <!-- Left Slide (Promo Image) -->
                    <div class="col-lg-5 d-none d-lg-block overflow-hidden" style="min-height: 650px;">
                        <img src="/img/login_promo.png" class="w-100 h-100 object-fit-cover" alt="Join Trip Zant">
                    </div>

                    <!-- Right Form Column -->
                    <div class="col-lg-7 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                        <div class="mx-auto w-100" style="max-width: 440px;">
                            <div class="text-center mb-5">
                                <h1 class="fw-900 text-navy mb-1" id="signup-modal-title" style="font-size: 28px;">Create Account</h1>
                                <p class="text-muted small fw-bold">Join Trip Zant and explore the world!</p>
                            </div>

                            <div id="signup-form-container">
                                <form id="modal-unified-signup-form" class="text-start">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="small fw-700 text-muted mb-1">Full Name</label>
                                        <input type="text" name="name" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="John Doe" style="height: 50px;" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="small fw-700 text-muted mb-1">Email Address</label>
                                        <input type="email" name="email" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="name@example.com" style="height: 50px;" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="small fw-700 text-muted mb-1">Phone Number</label>
                                        <div class="input-group border rounded-3 p-1" style="border-color: #dee2e6 !important;">
                                            <span class="input-group-text bg-transparent border-0 fw-bold px-3">+91</span>
                                            <input type="text" name="phone" class="form-control border-0 shadow-none fw-700 px-0" placeholder="Enter Mobile Number" style="font-size: 16px;" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small fw-700 text-muted mb-1">Password</label>
                                        <input type="password" name="password" class="form-control border rounded-3 p-3 shadow-none fw-700" placeholder="••••••••" style="height: 50px;" required>
                                    </div>
                                    <button type="submit" id="unified-signup-btn" class="btn btn-primary w-100 rounded-pill fw-800 py-3 shadow-sm mb-3" style="height: 54px; background: #0076f7;">
                                        CREATE ACCOUNT
                                    </button>
                                </form>
                            </div>

                            <!-- OTP Verify View (Hidden Initially) -->
                            <div id="register-otp-view" class="d-none text-center">
                                <div class="p-3 bg-success bg-opacity-10 rounded-circle d-inline-block mb-3">
                                    <i class="fas fa-mobile-alt text-success fs-3"></i>
                                </div>
                                <h4 class="fw-800 text-navy mb-2">Verify Mobile</h4>
                                <p class="text-muted small">We've sent a code to your mobile.<br>Use <strong>1234</strong> to verify.</p>
                                <div class="my-4 d-flex justify-content-center">
                                    <input type="text" id="register-otp-input" maxlength="4" class="form-control text-center fw-900 border" style="width: 140px; height: 56px; font-size: 24px; letter-spacing: 5px; border-radius: 12px; border-color: #dee2e6 !important;" placeholder="0000">
                                </div>
                                <button type="button" onclick="finalizeSignup()" id="finalize-signup-btn" class="btn btn-success w-100 rounded-pill fw-800 py-3 shadow-sm" style="height: 54px;">VERIFY & COMPLETE</button>
                                <div class="text-center mt-3"><a href="javascript:void(0)" onclick="resetSignupForms()" class="small text-primary fw-bold text-decoration-none">Change Details</a></div>
                            </div>

                            <div class="text-center mt-5 pt-4 border-top">
                                <p class="small text-muted fw-bold mb-0">Already have an account? <a href="javascript:void(0)" onclick="switchToLoginModal()" class="text-primary text-decoration-none">Sign In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="signup-user-id-store">

<script>
    function switchToLoginModal() {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('signupModal')).hide();
        setTimeout(() => {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal')).show();
        }, 400);
    }

    function resetSignupForms() {
        document.getElementById('signup-form-container').classList.remove('d-none');
        document.getElementById('register-otp-view').classList.add('d-none');
        document.getElementById('signup-modal-title').innerText = 'Create Account';
    }

    // Unified Signup Submit
    document.getElementById('modal-unified-signup-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('unified-signup-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> PROCESSING...'; btn.disabled = true;

        fetch('/register', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('signup-user-id-store').value = data.user_id;
                document.getElementById('signup-form-container').classList.add('d-none');
                document.getElementById('register-otp-view').classList.remove('d-none');
                document.getElementById('signup-modal-title').innerText = 'Verify Account';
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
                btn.innerHTML = 'CREATE ACCOUNT'; btn.disabled = false;
            }
        });
    });

    function finalizeSignup() {
        const otp = document.getElementById('register-otp-input').value;
        const userId = document.getElementById('signup-user-id-store').value;
        const btn = document.getElementById('finalize-signup-btn');
        btn.innerHTML = 'VERIFYING...'; btn.disabled = true;

        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('otp', otp);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/verify-otp', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Welcome!', text: 'Verified successfully.', timer: 2000, showConfirmButton: false });
                setTimeout(() => window.location.href = data.redirect, 1500);
            } else {
                Swal.fire({ icon: 'error', title: 'Invalid OTP', text: data.message });
                btn.innerHTML = 'VERIFY & COMPLETE'; btn.disabled = false;
            }
        });
    }
</script>

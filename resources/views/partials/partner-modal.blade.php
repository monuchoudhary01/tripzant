<!-- ====== DYNAMIC PARTNER AUTH MODAL ====== -->
<div class="modal fade" id="partnerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-2xl overflow-hidden" style="border-radius: 30px; background: #fff;">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" data-bs-dismiss="modal" style="z-index: 10;"></button>
                <div class="row g-0">
                    <!-- Left Sidebar (Marketing) -->
                    <div class="col-lg-4 d-none d-lg-block p-5 text-white" style="background: #002f55;">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h1 class="fw-900 mb-2 mt-5" style="font-size: 34px;">Partner with Trip Zant</h1>
                                <p class="opacity-75 small fw-bold mb-5">Join the world's most innovative B2B travel ecosystem. Expand your reach and maximize revenue.</p>
                                
                                <div class="mt-5 d-flex flex-column gap-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 bg-white bg-opacity-10 rounded-3 text-warning"><i class="fas fa-chart-line fs-5"></i></div>
                                        <div><h6 class="mb-0 fw-bold">Dynamic Growth</h6><p class="x-small opacity-50 mb-0">Scale your operations globally.</p></div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 bg-white bg-opacity-10 rounded-3 text-success"><i class="fas fa-shield-alt fs-5"></i></div>
                                        <div><h6 class="mb-0 fw-bold">Secure Settlement</h6><p class="x-small opacity-50 mb-0">Real-time payments and auditing.</p></div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 bg-white bg-opacity-10 rounded-3 text-info"><i class="fas fa-headset fs-5"></i></div>
                                        <div><h6 class="mb-0 fw-bold">24/7 Expert Support</h6><p class="x-small opacity-50 mb-0">Dedicated account managers.</p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-5 text-center">
                                <h2 class="fw-900 text-white opacity-25">Tripzant.com</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Right Form Column -->
                    <div class="col-lg-8 p-4 p-md-5 bg-white">
                        <!-- Switcher Tabs -->
                        <div class="d-flex justify-content-center mb-4">
                            <ul class="nav nav-pills bg-light p-1 rounded-pill shadow-sm" id="partnerTab" role="tablist" style="border: 1px solid #f1f5f9;">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill px-5 fw-800 tracking-wider" id="partner-signup-tab" data-bs-toggle="pill" data-bs-target="#partner-signup" type="button" style="font-size: 11px;">APPLY NOW</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-pill px-5 fw-800 tracking-wider" id="partner-login-tab" data-bs-toggle="pill" data-bs-target="#partner-login" type="button" style="font-size: 11px;">PARTNER LOGIN</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="partnerTabContent">
                            <!-- Signup View -->
                            <div class="tab-pane fade show active" id="partner-signup">
                                <div class="text-center mb-4">
                                    <h1 class="fw-900 text-navy mb-1" style="font-size: 28px;">Partner Registration</h1>
                                    <p class="text-muted small fw-bold">Join as a provider. All applications are manually reviewed.</p>
                                </div>

                                <form id="dynamic-partner-form" class="row g-4">
                                    @csrf
                                    <!-- Core Details -->
                                    <div class="col-md-6 text-start">
                                        <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Partner Vertical</label>
                                        <select name="role" id="partner-vertical-select" class="form-select border-0 bg-light p-3 fw-bold" style="height: 54px; border-radius: 12px;" required onchange="renderDynamicFields(this.value)">
                                            <option value="" disabled selected>Select Category</option>
                                            <option value="hotel-partner">Hotel Provider</option>
                                            <option value="cargo">International Cargo Partner</option>
                                            <option value="b2b">Travel Agent / Agency</option>
                                            <option value="corporate">Corporate Business</option>
                                            <option value="supplier">Tour & Package Supplier</option>
                                            <option value="affiliate">Local Service Provider / Affiliate</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 text-start">
                                        <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Primary Business Email</label>
                                        <input type="email" name="email" class="form-control border-0 bg-light p-3 shadow-none" placeholder="admin@tripzant.com" style="height: 54px; border-radius: 12px;" required>
                                    </div>
                                    
                                    <div class="col-md-6 text-start">
                                        <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Auth Password</label>
                                        <input type="password" name="password" class="form-control border-0 bg-light p-3 shadow-none" placeholder="••••••••" style="height: 54px; border-radius: 12px;" required>
                                    </div>
                                    <div class="col-md-6 text-start">
                                        <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control border-0 bg-light p-3 shadow-none" placeholder="••••••••" style="height: 54px; border-radius: 12px;" required>
                                    </div>

                                    <div class="col-12 py-3">
                                        <hr class="opacity-10 m-0">
                                    </div>

                                    <!-- Dynamic Fields Container -->
                                    <div id="dynamic-fields-row" class="row g-4 m-0 p-0 text-start">
                                        <div class="col-12 text-center py-4">
                                            <p class="text-muted small fw-bold mb-0"><i class="fas fa-info-circle me-2"></i> Select a partner category to see specialized fields.</p>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" id="partner-submit-btn" class="btn btn-navy w-100 py-3 rounded-pill fw-900 shadow-lg" disabled>
                                            SUBMIT ONBOARDING REQUEST <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <p class="small text-muted mb-0 fw-bold">Already a registered partner? <a href="javascript:void(0)" onclick="switchToPartnerLogin()" class="text-primary text-decoration-none">Login here</a></p>
                                    </div>
                                </form>
                            </div>

                            <!-- Login View -->
                            <div class="tab-pane fade" id="partner-login">
                                <div class="text-center mb-4">
                                    <h1 class="fw-900 text-navy mb-1" style="font-size: 28px;">Partner Login</h1>
                                    <p class="text-muted small fw-bold">Access your provider dashboard</p>
                                </div>
                                <form id="partner-login-form" class="row g-3">
                                    @csrf
                                    <div class="col-12 text-start">
                                        <label class="small fw-bold text-muted mb-2">BUSINESS EMAIL</label>
                                        <input type="email" name="email" class="form-control rounded-3 p-3 shadow-none border" placeholder="email@company.com" required>
                                    </div>
                                    <div class="col-12 text-start">
                                        <label class="small fw-bold text-muted mb-2">PASSWORD</label>
                                        <input type="password" name="password" class="form-control rounded-3 p-3 shadow-none border" placeholder="••••••••" required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" id="partner-login-btn" class="btn btn-navy w-100 py-3 rounded-pill fw-900 shadow-lg">ACCESS PORTAL <i class="fas fa-sign-in-alt ms-2"></i></button>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <p class="small text-muted mb-0">Want to join? <a href="javascript:void(0)" onclick="switchToPartnerSignup()" class="text-primary fw-bold">Apply for account</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function renderDynamicFields(role) {
        const container = document.getElementById('dynamic-fields-row');
        const submitBtn = document.getElementById('partner-submit-btn');
        submitBtn.disabled = false;
        
        let html = '';
        
        // Common Fields
        const commonHtml = `
            <div class="col-md-6 text-start">
                <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Contact Person</label>
                <input type="text" name="contact_name" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="Full Name" style="height: 54px; border-radius: 12px;" required>
            </div>
            <div class="col-md-6 text-start">
                <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Mobile Number</label>
                <input type="text" name="phone" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="+91 99999 00000" style="height: 54px; border-radius: 12px;" required>
            </div>
        `;

        if (role === 'hotel-partner') {
            html = commonHtml + `
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Hotel Name</label>
                    <input type="text" name="business_name" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="Grand Royal Hotel" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Total Rooms</label>
                    <input type="number" name="total_rooms" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="e.g. 50" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-12 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Property Location</label>
                    <input type="text" name="location" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="City, State" style="height: 54px; border-radius: 12px;" required>
                </div>
            `;
        } else if (role === 'cargo') {
            html = commonHtml + `
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Company Name</label>
                    <input type="text" name="business_name" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="Express Logistics Ltd" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Pickup City</label>
                    <input type="text" name="pickup_city" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="e.g. Mumbai" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Delivery Zones</label>
                    <input type="text" name="delivery_zones" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="e.g. PAN India, International" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Weight Capacity (KG)</label>
                    <input type="text" name="capacity" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="e.g. 5000kg daily" style="height: 54px; border-radius: 12px;" required>
                </div>
            `;
        } else if (role === 'b2b') {
            html = commonHtml + `
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Agency Name</label>
                    <input type="text" name="business_name" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="Fly High Travels" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">IATA / License No</label>
                    <input type="text" name="license_no" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="Optional for non-IATA" style="height: 54px; border-radius: 12px;">
                </div>
                <div class="col-12 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Office Address</label>
                    <textarea name="address" class="form-control border-0 bg-light p-3 shadow-none fw-bold" rows="2" placeholder="Full Registered Address" style="border-radius: 12px;"></textarea>
                </div>
            `;
        } else if (role === 'affiliate') {
            html = commonHtml + `
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Service Brand Name</label>
                    <input type="text" name="business_name" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="e.g. Rahul Hair Studio" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Service Category</label>
                    <select name="service_category" class="form-select border-0 bg-light p-3 shadow-none fw-bold" style="height: 54px; border-radius: 12px;" required>
                        <option value="" disabled selected>Select category</option>
                        <option value="Barber">Barber / Salon</option>
                        <option value="Tutor">Home Tutor</option>
                        <option value="Cleaner">Home Cleaner</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Photographer">Photographer</option>
                    </select>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Base Pricing (INR/HR)</label>
                    <input type="number" name="pricing" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="e.g. 500" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Service Location</label>
                    <input type="text" name="location" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="City, Area" style="height: 54px; border-radius: 12px;" required>
                </div>
            `;
        } else {
            // General Corporate/Supplier
            html = commonHtml + `
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">Business Name</label>
                    <input type="text" name="business_name" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="Enter Company Name" style="height: 54px; border-radius: 12px;" required>
                </div>
                <div class="col-md-6 text-start">
                    <label class="x-small fw-800 text-muted mb-2 text-uppercase letter-spacing-1">GST Number</label>
                    <input type="text" name="gst_number" class="form-control border-0 bg-light p-3 shadow-none fw-bold" placeholder="GSTN..." style="height: 54px; border-radius: 12px;" required>
                </div>
            `;
        }
        
        container.innerHTML = html;
    }

    function switchToPartnerLogin() {
        bootstrap.Tab.getInstance(document.getElementById('partner-login-tab')).show();
    }
    function switchToPartnerSignup() {
        bootstrap.Tab.getInstance(document.getElementById('partner-signup-tab')).show();
    }

    // Handle Signup Submission
    document.getElementById('dynamic-partner-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('partner-submit-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> PROCESSING...';
        btn.disabled = true;

        fetch('{{ route('partner.register') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Onboarding Requested!',
                    text: 'Your request has been successfully submitted. You will be notified via email or message once it is reviewed.',
                    confirmButtonColor: '#002f55'
                }).then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('partnerModal')).hide();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Submission Error', text: data.message });
                btn.innerHTML = 'SUBMIT ONBOARDING REQUEST <i class="fas fa-paper-plane ms-2"></i>';
                btn.disabled = false;
            }
        });
    });

    // Handle Login Submission
    document.getElementById('partner-login-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('partner-login-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> VERIFYING...';
        btn.disabled = true;

        fetch('{{ route('partner.login.submit') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: new FormData(this)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || '/dashboard';
            } else {
                Swal.fire({ icon: 'error', title: 'Login Failed', text: data.message });
                btn.innerHTML = 'ACCESS PORTAL <i class="fas fa-sign-in-alt ms-2"></i>';
                btn.disabled = false;
            }
        });
    });
</script>

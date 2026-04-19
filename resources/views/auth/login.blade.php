<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Tripzant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #000;
            overflow: hidden;
        }

        /* ── Background travel image ── */
        .tz-bg {
            position: fixed;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=80') center/cover no-repeat;
            filter: brightness(0.45);
            z-index: 0;
        }

        /* ── Full-screen dark overlay for centering ── */
        .tz-overlay {
            position: fixed;
            inset: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.45);
        }

        /* ── Modal wrapper ── */
        .tz-modal-wrap {
            position: relative;
            display: flex;
            width: 820px;
            max-width: 100%;
            min-height: 490px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.08);
            animation: modalIn 0.35s cubic-bezier(0.34,1.56,0.64,1);
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.94) translateY(16px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ── Left image panel ── */
        .tz-modal-img {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=900&q=85') center/cover no-repeat;
            position: relative;
            min-height: 490px;
        }
        .tz-modal-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(0,60,120,0.55) 0%, rgba(0,20,60,0.75) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 32px 28px;
        }
        .tz-modal-img-badge {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 100px;
            margin-bottom: 14px;
            width: fit-content;
        }
        .tz-modal-img h2 {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.25;
            text-shadow: 0 2px 12px rgba(0,0,0,0.4);
        }
        .tz-modal-img h2 span { color: #fbbf24; }
        .tz-modal-img p {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            margin-top: 8px;
            line-height: 1.5;
        }

        /* ── Right form panel ── */
        .tz-modal-form {
            width: 360px;
            flex-shrink: 0;
            background: #fff;
            padding: 36px 32px 28px;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .tz-close {
            position: absolute;
            top: 16px; right: 18px;
            background: #f1f5f9;
            border: none;
            width: 32px; height: 32px;
            border-radius: 50%;
            font-size: 15px;
            color: #64748b;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .tz-close:hover { background: #e2e8f0; color: #1e293b; }

        .tz-form-title {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            text-align: center;
            margin-bottom: 4px;
        }
        .tz-form-sub {
            font-size: 13px;
            color: #64748b;
            text-align: center;
            margin-bottom: 22px;
        }

        /* Tabs */
        .tz-tabs {
            display: flex;
            background: #f1f5f9;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 22px;
        }
        .tz-tab {
            flex: 1;
            background: transparent;
            border: none;
            border-radius: 8px;
            padding: 9px 10px;
            font-size: 12px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.3px;
        }
        .tz-tab.active {
            background: #1a56db;
            color: #fff;
            box-shadow: 0 2px 8px rgba(26,86,219,0.35);
        }
        .tz-tab:hover:not(.active) { color: #1e293b; background: #e2e8f0; }

        /* Fields */
        .tz-field { margin-bottom: 16px; }
        .tz-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 7px;
            letter-spacing: 0.3px;
        }
        .tz-input-wrap { position: relative; display: flex; align-items: center; }
        .tz-flag {
            position: absolute;
            left: 12px;
            display: flex; align-items: center; gap: 5px;
            font-size: 13px; font-weight: 600; color: #334155;
            pointer-events: none;
            user-select: none;
        }
        .tz-flag img { width: 20px; border-radius: 3px; }
        .tz-flag-divider {
            position: absolute;
            left: 68px;
            height: 20px;
            border-left: 1.5px solid #d1d5db;
        }
        .tz-input {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 11px;
            padding: 13px 14px 13px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .tz-input.with-flag { padding-left: 84px; }
        .tz-input.with-icon { padding-left: 42px; }
        .tz-input:focus {
            border-color: #1a56db;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }
        .tz-input::placeholder { color: #94a3b8; }
        .tz-input-icon {
            position: absolute; left: 14px;
            color: #94a3b8; font-size: 14px;
            pointer-events: none;
        }
        .tz-pwd-toggle {
            position: absolute; right: 13px;
            background: none; border: none;
            color: #94a3b8; cursor: pointer; font-size: 14px;
        }
        .tz-forgot {
            float: right;
            font-size: 12px;
            color: #1a56db;
            text-decoration: none;
            font-weight: 500;
        }
        .tz-forgot:hover { text-decoration: underline; }

        /* Continue / Submit button */
        .tz-btn-main {
            width: 100%;
            background: #1a56db;
            color: #fff;
            border: none;
            border-radius: 11px;
            padding: 13px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.25s;
            margin-top: 4px;
        }
        .tz-btn-main:hover { background: #1648c7; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(26,86,219,0.35); }
        .tz-btn-main:active { transform: none; }
        .tz-btn-main:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        /* Divider */
        .tz-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 18px 0;
            color: #94a3b8; font-size: 12px;
        }
        .tz-divider::before, .tz-divider::after {
            content: ''; flex: 1;
            border-top: 1px solid #e2e8f0;
        }

        /* Social */
        .tz-social { display: flex; justify-content: center; gap: 12px; margin-bottom: 18px; }
        .tz-social-btn {
            width: 44px; height: 44px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .tz-social-btn:hover { border-color: #1a56db; box-shadow: 0 4px 12px rgba(26,86,219,0.15); transform: translateY(-1px); }
        .tz-social-btn img { width: 20px; height: 20px; }

        /* Error alert */
        .tz-error {
            display: none;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 14px;
            align-items: center; gap: 8px;
        }

        /* Info alert */
        .tz-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }

        .tz-signup-txt {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-top: auto;
            padding-top: 12px;
        }
        .tz-signup-txt a { color: #1a56db; font-weight: 600; text-decoration: none; }
        .tz-signup-txt a:hover { text-decoration: underline; }

        .tz-terms-txt {
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.5;
            margin-top: 8px;
        }
        .tz-terms-txt a { color: #64748b; text-decoration: underline; }

        /* OTP boxes */
        .tz-otp-row { display: flex; gap: 10px; justify-content: center; margin: 6px 0 14px; }
        .tz-otp-box {
            width: 52px; height: 52px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            text-align: center;
            font-size: 20px; font-weight: 700;
            color: #0f172a;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .tz-otp-box:focus { border-color: #1a56db; box-shadow: 0 0 0 3px rgba(26,86,219,0.1); background: #fff; }

        /* Responsive */
        @media (max-width: 640px) {
            .tz-modal-img { display: none; }
            .tz-modal-form { width: 100%; border-radius: 20px; }
        }
    </style>
</head>
<body>
    <div class="tz-bg"></div>

    <div class="tz-overlay">
    <div class="tz-modal-wrap">
        <!-- Left: Travel Image Panel -->
        <div class="tz-modal-img">
            <div class="tz-modal-img-overlay">
                <div class="tz-modal-img-badge">✈ Limited Time Offer</div>
                <h2>Great <span>Summer Escape</span><br>Sale</h2>
                <p>Save up to 40% on hotels &amp; flights.<br>Book your dream vacation today.</p>
            </div>
        </div>

        <!-- Right: Login Form -->
        <div class="tz-modal-form">
            <button class="tz-close" onclick="window.history.back()" title="Close">
                <i class="fas fa-times"></i>
            </button>

            <div class="tz-form-title">User Login</div>
            <div class="tz-form-sub">Select your preferred login method.</div>

            @if(session('info'))
            <div class="tz-info">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
            @endif

            <div id="tz-error" class="tz-error">
                <i class="fas fa-exclamation-circle"></i>
                <span id="tz-error-txt"></span>
            </div>

            <!-- Tabs -->
            <div class="tz-tabs">
                <button class="tz-tab active" id="tab-mobile" onclick="switchTab('mobile')">📱 MOBILE LOGIN</button>
                <button class="tz-tab" id="tab-email" onclick="switchTab('email')">✉ EMAIL LOGIN</button>
            </div>

            <!-- ===== MOBILE LOGIN ===== -->
            <div id="sec-mobile">
                <!-- Step 1: Enter phone -->
                <div id="mobile-s1">
                    <div class="tz-field">
                        <label>Mobile Number</label>
                        <div class="tz-input-wrap">
                            <div class="tz-flag">
                                <img src="https://flagcdn.com/w40/in.png" alt="IN"> +91
                            </div>
                            <div class="tz-flag-divider"></div>
                            <input type="tel" id="mob-phone" class="tz-input with-flag"
                                   placeholder="Enter Mobile Number" maxlength="10">
                        </div>
                    </div>
                    <button class="tz-btn-main" onclick="sendOtp()">CONTINUE</button>
                </div>

                <!-- Step 2: OTP -->
                <div id="mobile-s2" style="display:none;">
                    <div class="tz-field">
                        <label style="text-align:center; display:block;">Enter OTP sent to your number</label>
                        <div class="tz-otp-row">
                            <input type="text" maxlength="1" class="tz-otp-box" id="o1" oninput="otpNext(this,'o2')">
                            <input type="text" maxlength="1" class="tz-otp-box" id="o2" oninput="otpNext(this,'o3')">
                            <input type="text" maxlength="1" class="tz-otp-box" id="o3" oninput="otpNext(this,'o4')">
                            <input type="text" maxlength="1" class="tz-otp-box" id="o4">
                        </div>
                        <p style="text-align:center; font-size:12px; color:#64748b;">
                            Didn't receive? <a href="#" style="color:#1a56db; font-weight:600;" onclick="resendOtp(event)">Resend OTP</a>
                        </p>
                    </div>
                    <button class="tz-btn-main" onclick="verifyOtp()">VERIFY &amp; LOGIN</button>
                    <button type="button" onclick="switchMobileStep(1)"
                        style="width:100%; background:none; border:none; color:#64748b; font-size:13px; margin-top:10px; cursor:pointer;">
                        ← Change number
                    </button>
                </div>
            </div>

            <!-- ===== EMAIL LOGIN ===== -->
            <div id="sec-email" style="display:none;">
                <div class="tz-field">
                    <label>Email Address</label>
                    <div class="tz-input-wrap">
                        <i class="fas fa-envelope tz-input-icon"></i>
                        <input type="email" id="em-email" class="tz-input with-icon"
                               placeholder="name@example.com" autocomplete="email">
                    </div>
                </div>
                <div class="tz-field">
                    <label>
                        Password
                        <a href="#" class="tz-forgot">Forgot password?</a>
                    </label>
                    <div class="tz-input-wrap">
                        <i class="fas fa-lock tz-input-icon"></i>
                        <input type="password" id="em-pass" class="tz-input with-icon"
                               placeholder="Enter password" autocomplete="current-password">
                        <button type="button" class="tz-pwd-toggle" onclick="togglePwd()">
                            <i class="fas fa-eye" id="eye-ic"></i>
                        </button>
                    </div>
                </div>
                <button class="tz-btn-main" id="em-btn" onclick="doEmailLogin()">SIGN IN</button>
            </div>

            <!-- Divider + Social -->
            <div class="tz-divider">Or Join With</div>
            <div class="tz-social">
                <button class="tz-social-btn" title="Google" onclick="alert('Google login coming soon!')">
                    <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google">
                </button>
                <button class="tz-social-btn" title="Apple" onclick="alert('Apple login coming soon!')">
                    <i class="fab fa-apple" style="font-size:20px; color:#1e293b;"></i>
                </button>
                <button class="tz-social-btn" title="Facebook" onclick="alert('Facebook login coming soon!')">
                    <i class="fab fa-facebook" style="font-size:20px; color:#1877f2;"></i>
                </button>
            </div>

            <div class="tz-signup-txt">
                Don't have an account? <a href="/register">Sign Up</a>
            </div>
            <div class="tz-terms-txt">
                By continuing, you agree to our
                <a href="#">Terms of Service</a> &amp; <a href="#">Privacy Policy</a>
            </div>
        </div><!-- /.tz-modal-form -->
    </div><!-- /.tz-modal-wrap -->
    </div><!-- /.tz-overlay -->

<script>
// ── Tab switching ──
function switchTab(tab) {
    clearError();
    document.getElementById('sec-mobile').style.display = tab === 'mobile' ? 'block' : 'none';
    document.getElementById('sec-email').style.display  = tab === 'email'  ? 'block' : 'none';
    document.getElementById('tab-mobile').classList.toggle('active', tab === 'mobile');
    document.getElementById('tab-email').classList.toggle('active', tab === 'email');
}

function switchMobileStep(step) {
    document.getElementById('mobile-s1').style.display = step === 1 ? 'block' : 'none';
    document.getElementById('mobile-s2').style.display = step === 2 ? 'block' : 'none';
    clearError();
}

// ── Error helper ──
function showError(msg) {
    const box = document.getElementById('tz-error');
    document.getElementById('tz-error-txt').textContent = msg;
    box.style.display = 'flex';
}
function clearError() { document.getElementById('tz-error').style.display = 'none'; }

// ── Send OTP ──
function sendOtp() {
    clearError();
    const phone = document.getElementById('mob-phone').value.trim();
    if (!phone || phone.length < 10) return showError('Please enter a valid 10-digit mobile number.');

    fetch('/login/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ phone })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) switchMobileStep(2);
        else showError(d.message || 'Failed to send OTP.');
    })
    .catch(() => showError('Network error. Please try again.'));
}

function resendOtp(e) { e.preventDefault(); sendOtp(); }

// ── OTP boxes navigation ──
function otpNext(el, nextId) {
    if (el.value && nextId) document.getElementById(nextId)?.focus();
}

// ── Verify OTP ──
function verifyOtp() {
    clearError();
    const phone = document.getElementById('mob-phone').value.trim();
    const otp   = ['o1','o2','o3','o4'].map(id => document.getElementById(id).value).join('');
    if (otp.length < 4) return showError('Please enter the complete 4-digit OTP.');

    fetch('/login/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ phone, otp })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) window.location.href = d.redirect || '/';
        else showError(d.message || 'Invalid OTP. Please try again.');
    })
    .catch(() => showError('Network error. Please try again.'));
}

// ── Email Login ──
function togglePwd() {
    const i = document.getElementById('em-pass');
    const ic = document.getElementById('eye-ic');
    i.type = i.type === 'password' ? 'text' : 'password';
    ic.classList.toggle('fa-eye'); ic.classList.toggle('fa-eye-slash');
}

function doEmailLogin() {
    clearError();
    const email = document.getElementById('em-email').value.trim();
    const pass  = document.getElementById('em-pass').value;
    if (!email) return showError('Please enter your email address.');
    if (!pass)  return showError('Please enter your password.');

    const btn = document.getElementById('em-btn');
    btn.disabled = true;
    btn.textContent = 'Signing in...';

    fetch('/login-unified', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ email, password: pass })
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        btn.textContent = 'SIGN IN';
        if (d.success) {
            btn.textContent = '✓ Success! Redirecting...';
            btn.style.background = '#10b981';
            setTimeout(() => window.location.href = d.redirect || '/', 700);
        } else {
            showError(d.message || 'Invalid credentials. Please try again.');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'SIGN IN';
        showError('Network error. Please try again.');
    });
}

// Auto-focus phone on load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('mob-phone').focus();
});

// OTP boxes: support backspace
document.querySelectorAll('.tz-otp-box').forEach((box, idx, boxes) => {
    box.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && idx > 0) boxes[idx - 1].focus();
    });
});
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Login' }} — Tripzant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: rgba(15, 23, 42, 0.6);
            --border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: var(--text-main);
        }

        /* Animated Background */
        .bg-visual {
            position: fixed;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1600&q=80') center/cover no-repeat;
            filter: brightness(0.3) blur(8px);
            z-index: -1;
            transform: scale(1.1);
            animation: moveBg 20s infinite alternate ease-in-out;
        }

        @keyframes moveBg {
            from { transform: scale(1.1) translate(0, 0); }
            to { transform: scale(1.2) translate(-2%, -2%); }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-area h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-area p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 8px;
            padding-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
            transition: color 0.3s;
        }

        .form-input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px 14px 48px;
            color: #fff;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            border-color: var(--primary);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .form-input:focus + i {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .error-alert {
            display: none;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 24px;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .footer-note {
            text-align: center;
            margin-top: 32px;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Loader */
        .loader {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-visual"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-area">
                <h1>Tripzant</h1>
                <p>Admin Portal</p>
            </div>

            <div id="error-box" class="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span id="error-msg"></span>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input type="email" id="email" class="form-input" placeholder="admin@tripzant.com" required>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" class="form-input" placeholder="••••••••" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button id="login-btn" class="btn-login" onclick="handleLogin()">
                <span>Sign In</span>
                <div class="loader"></div>
            </button>
        </div>

        <div class="footer-note">
            &copy; {{ date('Y') }} Tripzant. Internal Access Only.
        </div>
    </div>

    <script>
        function handleLogin() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const btn = document.getElementById('login-btn');
            const errorBox = document.getElementById('error-box');
            const errorMsg = document.getElementById('error-msg');
            const loader = btn.querySelector('.loader');
            const btnText = btn.querySelector('span');

            if (!email || !password) {
                showError('Please enter both email and password.');
                return;
            }

            // UI State
            btn.disabled = true;
            btnText.style.display = 'none';
            loader.style.display = 'block';
            errorBox.style.display = 'none';

            fetch('{{ route('admin.login.submit') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btnText.style.display = 'block';
                    loader.style.display = 'none';
                    btnText.textContent = 'Success! Redirecting...';
                    btn.style.background = '#10b981';
                    setTimeout(() => {
                        window.location.href = data.redirect || '/admin-dashboard';
                    }, 800);
                } else {
                    resetBtn();
                    showError(data.message || 'Login failed. Please try again.');
                }
            })
            .catch(err => {
                resetBtn();
                showError('Network error. Please check your connection.');
                console.error(err);
            });

            function showError(msg) {
                errorMsg.textContent = msg;
                errorBox.style.display = 'block';
            }

            function resetBtn() {
                btn.disabled = false;
                btnText.style.display = 'block';
                loader.style.display = 'none';
            }
        }

        // Allow Enter key to submit
        document.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                handleLogin();
            }
        });
    </script>
</body>
</html>

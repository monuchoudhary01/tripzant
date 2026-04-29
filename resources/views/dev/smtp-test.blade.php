<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMTP Mail Tester | Tripzant</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,0.3);
        }
        .card-header {
            background: linear-gradient(135deg, #005eb8, #003366);
            padding: 30px;
            color: white;
        }
        .card-header h1 { font-size: 22px; font-weight: 900; margin-bottom: 4px; }
        .card-header p { font-size: 13px; opacity: 0.7; }
        .card-body { padding: 30px; }

        /* Config grid */
        .config-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 25px;
        }
        .config-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
        }
        .config-item .label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 3px; }
        .config-item .value { font-size: 13px; font-weight: 700; color: #1e293b; word-break: break-all; }
        .config-item .value.ok { color: #16a34a; }
        .config-item .value.warn { color: #d97706; }

        label { font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block; }
        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
            outline: none;
            margin-bottom: 15px;
            background: #fafafa;
        }
        input:focus, textarea:focus { border-color: #005eb8; background: #fff; }
        textarea { height: 80px; resize: vertical; }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #005eb8, #003366);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: opacity 0.2s, transform 0.2s;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        /* Result box */
        .result {
            margin-top: 20px;
            padding: 18px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            display: none;
        }
        .result.success { background: #f0fdf4; border: 2px solid #86efac; color: #166534; }
        .result.error   { background: #fef2f2; border: 2px solid #fca5a5; color: #991b1b; }
        .result pre { font-size: 11px; margin-top: 8px; white-space: pre-wrap; word-break: break-all; opacity: 0.8; }

        .spinner { display: none; width: 18px; height: 18px; border: 3px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .divider { height: 1px; background: #f1f5f9; margin: 20px 0; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <h1>📧 SMTP Mail Tester</h1>
        <p>Tripzant · Test your SMTP configuration live</p>
    </div>
    <div class="card-body">

        <!-- Current SMTP Config -->
        <div class="config-grid">
            <div class="config-item">
                <div class="label">MAILER</div>
                <div class="value {{ config('mail.default') === 'smtp' ? 'ok' : 'warn' }}">{{ strtoupper(config('mail.default')) }}</div>
            </div>
            <div class="config-item">
                <div class="label">HOST</div>
                <div class="value">{{ config('mail.mailers.smtp.host') ?? '—' }}</div>
            </div>
            <div class="config-item">
                <div class="label">PORT</div>
                <div class="value">{{ config('mail.mailers.smtp.port') ?? '—' }}</div>
            </div>
            <div class="config-item">
                <div class="label">ENCRYPTION</div>
                <div class="value">{{ strtoupper(config('mail.mailers.smtp.encryption') ?? 'none') }}</div>
            </div>
            <div class="config-item">
                <div class="label">FROM ADDRESS</div>
                <div class="value">{{ config('mail.from.address') ?? '—' }}</div>
            </div>
            <div class="config-item">
                <div class="label">USERNAME</div>
                <div class="value {{ config('mail.mailers.smtp.username') ? 'ok' : 'warn' }}">
                    {{ config('mail.mailers.smtp.username') ? '✓ Set' : '✗ Missing' }}
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Test Form -->
        <form id="testForm">
            @csrf
            <label>Send Test Email To</label>
            <input type="email" id="toEmail" name="to" placeholder="recipient@gmail.com" 
                   value="{{ auth()->user()->email ?? '' }}" required>

            <label>Subject</label>
            <input type="text" id="subject" name="subject" value="Tripzant SMTP Test - {{ now()->format('d M Y H:i') }}">

            <label>Message</label>
            <textarea id="body" name="body">Hello! This is a test email from Tripzant to verify SMTP is working correctly. Sent at: {{ now()->format('d M Y H:i:s') }}</textarea>

            <button class="btn" type="submit" id="sendBtn">
                <span id="btnText">🚀 SEND TEST EMAIL</span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>

        <div class="result" id="result"></div>
    </div>
</div>

<script>
document.getElementById('testForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('sendBtn');
    const btnText = document.getElementById('btnText');
    const spinner = document.getElementById('spinner');
    const result = document.getElementById('result');

    btn.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'block';
    result.style.display = 'none';

    try {
        const res = await fetch('/dev/smtp-test/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: JSON.stringify({
                to:      document.getElementById('toEmail').value,
                subject: document.getElementById('subject').value,
                body:    document.getElementById('body').value,
            })
        });

        const data = await res.json();

        result.className = 'result ' + (data.success ? 'success' : 'error');
        result.style.display = 'block';
        result.innerHTML = `
            <strong>${data.success ? '✅ Mail Sent Successfully!' : '❌ Mail Failed!'}</strong>
            <pre>${data.message || ''}</pre>
        `;
    } catch(err) {
        result.className = 'result error';
        result.style.display = 'block';
        result.innerHTML = `<strong>❌ Request Error</strong><pre>${err.message}</pre>`;
    } finally {
        btn.disabled = false;
        btnText.style.display = 'block';
        spinner.style.display = 'none';
    }
});
</script>
</body>
</html>

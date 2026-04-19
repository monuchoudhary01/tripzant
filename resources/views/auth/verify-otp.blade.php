@extends('layouts.app')

@section('title', "Verify Account — Trip Zant Enterprise")

@section('content')
<section class="py-5 partner-verify-section" style="background: linear-gradient(135deg, #0b3d61 0%, #001f3f 100%); min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg text-center p-5" style="border-radius: 32px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="mb-5">
                         <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg mb-4" style="width: 80px; height: 80px; font-size: 32px;">
                            <i class="fas fa-shield-alt"></i>
                         </div>
                         <h3 class="fw-900 text-navy mb-2 uppercase tracking-wide">Secure Verification</h3>
                         <p class="text-muted small fw-600">Enter the 4-digit security code sent to your mobile.</p>
                    </div>

                    <div class="otp-inputs d-flex justify-content-center gap-3 mb-5">
                        <input type="text" class="form-control otp-box text-center fw-900 fs-1" maxlength="1" style="width: 60px; height: 75px; border-radius: 16px; border: 2px solid #e2e8f0; background: #fff; color: #0b3d61;">
                        <input type="text" class="form-control otp-box text-center fw-900 fs-1" maxlength="1" style="width: 60px; height: 75px; border-radius: 16px; border: 2px solid #e2e8f0; background: #fff; color: #0b3d61;">
                        <input type="text" class="form-control otp-box text-center fw-900 fs-1" maxlength="1" style="width: 60px; height: 75px; border-radius: 16px; border: 2px solid #e2e8f0; background: #fff; color: #0b3d61;">
                        <input type="text" class="form-control otp-box text-center fw-900 fs-1" maxlength="1" style="width: 60px; height: 75px; border-radius: 16px; border: 2px solid #e2e8f0; background: #fff; color: #0b3d61;">
                    </div>

                    <p class="text-muted small mb-4 fw-bold">Use static test code: <span class="text-primary fs-5">1234</span></p>

                    <button type="button" id="final-verify-btn" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg uppercase letter-spacing-1">Verify & Finalize Account <i class="fas fa-check-circle ms-2"></i></button>

                    <div class="mt-4">
                        <button class="btn btn-link text-muted small fw-bold text-decoration-none shadow-none">Didn't receive code? Resend SMS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Handle OTP Box Auto-focus
    const boxes = document.querySelectorAll('.otp-box');
    boxes.forEach((box, i) => {
        box.addEventListener('keyup', (e) => {
            if (e.target.value.length === 1 && i < boxes.length - 1) {
                boxes[i + 1].focus();
            }
            if (e.key === 'Backspace' && i > 0) {
                boxes[i - 1].focus();
            }
        });
    });

    document.getElementById('final-verify-btn').addEventListener('click', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('user_id');
        const redirect = urlParams.get('redirect');

        if (otp.length < 4) { alert('Please enter all digits'); return; }

        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> VERIFYING...';
        this.disabled = true;

        const payload = { user_id: userId, otp: otp };
        if (redirect) payload.redirect = redirect;

        fetch('/verify-otp', {
            method: 'POST',
            body: JSON.stringify(payload),
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
                alert('Invalid OTP. Use 1234');
                this.innerHTML = 'Verify & Finalize Account <i class="fas fa-check-circle ms-2"></i>';
                this.disabled = false;
            }
        })
        .catch(err => {
            alert('Connection Error');
            this.innerHTML = 'Verify & Finalize Account <i class="fas fa-check-circle ms-2"></i>';
            this.disabled = false;
        });
    });
</script>

<style>
    .otp-box:focus {
        border-color: #0b3d61 !important;
        box-shadow: 0 0 0 4px rgba(11, 61, 97, 0.1);
        transform: translateY(-2px);
    }
    .letter-spacing-1 { letter-spacing: 1px; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection

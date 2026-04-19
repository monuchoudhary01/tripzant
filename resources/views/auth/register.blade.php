@extends('layouts.app')

@section('title', 'Join Tripzant — ' . ucfirst($role) . ' Registration')

@section('content')
<div class="auth-wrapper" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
    <div class="auth-container" style="max-width: {{ $role == 'user' ? '450px' : '650px' }}; width: 100%;">
        <div class="auth-card" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 32px; padding: 48px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div class="text-center mb-5">
                <a href="/">
                    <img src="/img/logo.svg" alt="Tripzant" height="40" class="mb-4" style="filter: brightness(0) invert(1);">
                </a>
                <h2 style="color: #fff; font-weight: 800; font-size: 28px; letter-spacing: -0.5px; margin-bottom: 8px;">
                    @if($role == 'user') Create Your Account @else Business Partnership @endif
                </h2>
                <p style="color: #94a3b8; font-size: 15px;">
                    @if($role == 'user') Join thousands of travelers worldwide @else Apply for our {{ strtoupper($role) }} portal access @endif
                </p>
            </div>

            <form id="register-form">
                @csrf
                <div class="row">
                    @if($role == 'corporate')
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">Company Name</label>
                            <input type="text" name="company_name" required placeholder="Acme Corp" class="auth-input">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">GST Number</label>
                            <input type="text" name="gst_number" placeholder="Optional" class="auth-input">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">Contact Person</label>
                            <input type="text" name="contact_person" required placeholder="John Doe" class="auth-input">
                        </div>
                    @elseif($role == 'b2b')
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">Agency Name</label>
                            <input type="text" name="agency_name" required placeholder="Global Travels" class="auth-input">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">Full Name</label>
                            <input type="text" name="name" required placeholder="Agent Owner Name" class="auth-input">
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="auth-label">Business Address</label>
                            <textarea name="address" required placeholder="Complete office address" class="auth-input" style="height: 80px;"></textarea>
                        </div>
                    @elseif($role == 'supplier')
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">Company Name</label>
                            <input type="text" name="company_name" required placeholder="Tour Operator Name" class="auth-input">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="auth-label">Contact Person</label>
                            <input type="text" name="name" required placeholder="Owner Name" class="auth-input">
                        </div>
                    @else
                        <div class="col-md-12 mb-4">
                            <label class="auth-label">Full Name</label>
                            <input type="text" name="name" required placeholder="John Doe" class="auth-input">
                        </div>
                    @endif

                    <div class="col-md-6 mb-4">
                        <label class="auth-label">Email Address</label>
                        <input type="email" name="email" required placeholder="name@domain.com" class="auth-input">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="auth-label">Phone Number</label>
                        <input type="text" name="phone" required placeholder="+91 XXXXX XXXXX" class="auth-input">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="auth-label">Password</label>
                        <input type="password" name="password" required placeholder="Create a strong password" class="auth-input">
                    </div>
                </div>

                <div class="mb-5" style="display: flex; align-items: flex-start;">
                    <input type="checkbox" id="terms" required style="width: 18px; height: 18px; border-radius: 6px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); cursor: pointer; margin-top: 2px;">
                    <label for="terms" style="color: #94a3b8; font-size: 13px; margin-left: 10px; cursor: pointer;">
                        By clicking, I agree to Tripzant's <a href="#" style="color: #6366f1; text-decoration: none;">Terms of Service</a> and <a href="#" style="color: #6366f1; text-decoration: none;">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" id="submit-btn" style="width: 100%; background: #6366f1; color: #fff; border: none; border-radius: 14px; padding: 16px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);">
                    @if($role == 'user') Complete Signup @else Submit Application @endif
                </button>
            </form>

            <div class="text-center mt-5">
                <p style="color: #94a3b8; font-size: 14px;">Already have an account? 
                    <a href="{{ $role == 'user' ? '/login' : ($role == 'corporate' ? '/corporate/login' : ($role == 'b2b' ? '/agent/login' : '/supplier/login')) }}" 
                       style="color: #6366f1; font-weight: 700; text-decoration: none; margin-left: 4px;">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-label {
        display: block; 
        color: #94a3b8; 
        font-size: 12px; 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        margin-bottom: 8px;
    }
    .auth-input {
        width: 100%; 
        background: rgba(255, 255, 255, 0.05); 
        border: 1px solid rgba(255, 255, 255, 0.1); 
        border-radius: 14px; 
        padding: 14px 18px; 
        color: #fff; 
        font-size: 15px; 
        outline: none; 
        transition: all 0.3s ease;
    }
    .auth-input:focus {
        border-color: #6366f1 !important;
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    button:hover {
        background: #4f46e5 !important;
        transform: translateY(-1px);
    }
    button:active {
        transform: translateY(0);
    }
</style>

<script>
document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submit-btn');
    const originalText = btn.innerText;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;

    const formData = new FormData(this);
    
    // Determine the post URL based on role
    let postUrl = '/register';
    const role = '{{ $role }}';
    if(role === 'corporate') postUrl = '/corporate/register';
    else if(role === 'b2b') postUrl = '/agent/register';
    else if(role === 'supplier') postUrl = '/supplier/register';

    fetch(postUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            if(data.redirect) {
                window.location.href = data.redirect;
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    confirmButtonColor: '#6366f1'
                }).then(() => {
                    window.location.href = '/login';
                });
            }
        } else {
            alert(data.message);
            btn.innerText = originalText;
            btn.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Registration failed. Please check inputs.');
        btn.innerText = originalText;
        btn.disabled = false;
    });
});
</script>

<!-- SweetAlert2 for nice notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

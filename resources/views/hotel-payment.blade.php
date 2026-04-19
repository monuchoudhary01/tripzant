@extends('layouts.app')

@section('title', "Payment & Confirmation — Tripzant BNB")

@section('content')
<div class="py-5" style="background: #f0f4f8; min-height: 100vh;">
    <div class="container">
        <!-- Progress Steps -->
        <div class="row justify-content-center mb-5 animate-up">
            <div class="col-lg-6">
                <div class="d-flex justify-content-between position-relative">
                    <div class="step-line border-top border-primary border-2 position-absolute w-100 top-50 start-0 z-0"></div>
                    <div class="step-point bg-primary text-white rounded-circle d-flex align-items-center justify-content-center position-relative z-1" style="width: 32px; height: 32px; font-size: 14px; font-weight: 800;">1</div>
                    <div class="step-point bg-primary text-white rounded-circle d-flex align-items-center justify-content-center position-relative z-1" style="width: 32px; height: 32px; font-size: 14px; font-weight: 800;">2</div>
                    <div class="step-point bg-primary text-white rounded-circle d-flex align-items-center justify-content-center position-relative z-1" style="width: 32px; height: 32px; font-size: 14px; font-weight: 800;">3</div>
                </div>
                <div class="d-flex justify-content-between mt-2 x-small fw-900 text-uppercase text-navy letter-spacing-1">
                    <span>SELECT ROOM</span>
                    <span>GUEST INFO</span>
                    <span>PAYMENT</span>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-4 animate-up" style="animation-delay: 0.1s;">
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center gap-3">
                         <div class="p-3 bg-navy text-white rounded-4 shadow-sm"><i class="fas fa-wallet"></i></div>
                         <div>
                            <h5 class="fw-900 text-navy mb-0">Choose Payment Method</h5>
                            <p class="text-muted small mb-0">Select your preferred b2b payment option.</p>
                         </div>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-50">
                        <!-- Wallet Section -->
                        <div class="payment-method-v2 active mb-4 p-4 rounded-4 border-primary border border-2 shadow-sm bg-white" onclick="selectPayment(this)">
                             <div class="d-flex justify-content-between align-items-center mb-3">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="payment-icon bg-primary text-white fs-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;"><i class="fas fa-wallet"></i></div>
                                     <div>
                                         <h6 class="fw-900 text-navy mb-0">AGENT WALLET</h6>
                                         <span class="x-small text-muted fw-bold">Instant Confirmation</span>
                                     </div>
                                 </div>
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="payType" id="payWallet" checked>
                                 </div>
                             </div>
                             <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                 <span class="small fw-700 text-muted">CURRENT BALANCE</span>
                                 <span class="fw-900 text-navy h5 mb-0">₹4,25,800</span>
                             </div>
                             <div class="mt-3 x-small text-success fw-900"><i class="fas fa-check-circle me-1"></i> Funds are available for this booking.</div>
                        </div>

                        <!-- Bank Transfer Section -->
                        <div class="payment-method-v2 mb-4 p-4 rounded-4 border border-1 shadow-sm bg-white" onclick="selectPayment(this)">
                             <div class="d-flex justify-content-between align-items-center">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="payment-icon bg-light text-navy fs-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;"><i class="fas fa-university"></i></div>
                                     <div>
                                         <h6 class="fw-900 text-navy mb-0">CREDIT LIMIT / TOP-UP</h6>
                                         <span class="x-small text-muted fw-bold">Manual Review Required</span>
                                     </div>
                                 </div>
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="payType" id="payCredit">
                                 </div>
                             </div>
                        </div>

                        <!-- Card Section -->
                        <div class="payment-method-v2 p-4 rounded-4 border border-1 shadow-sm bg-white" onclick="selectPayment(this)">
                             <div class="d-flex justify-content-between align-items-center">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="payment-icon bg-light text-navy fs-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;"><i class="fas fa-credit-card"></i></div>
                                     <div>
                                         <h6 class="fw-900 text-navy mb-0">NET BANKING / RAZORPAY</h6>
                                         <span class="x-small text-muted fw-bold">Extra Payment Gateway Charges Apply</span>
                                     </div>
                                 </div>
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="payType" id="payOnline">
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Final Action -->
                <div class="card border-0 shadow rounded-4 p-4 bg-white mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="text-muted small fw-bold mb-0">TOTAL AMOUNT TO PAY</h6>
                            <h2 class="fw-900 text-navy mb-0" style="font-size:36px;">₹93,950</h2>
                        </div>
                        <i class="fas fa-shield-alt text-success display-4 opacity-25"></i>
                    </div>
                    <button type="button" class="btn btn-navy w-100 py-3 rounded-pill fw-bold shadow-lg hover-glow d-flex align-items-center justify-content-center" id="payNowBtn">
                        CONFIRM & PAY NOW <i class="fas fa-lock ms-2"></i>
                    </button>
                    <p class="x-small text-center text-muted mt-3 mb-0 fw-bold"><i class="fas fa-info-circle me-1"></i> By clicking pay now, you agree to our booking terms and conditions.</p>
                </div>
            </div>

            <!-- Booking Preview Overlay -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0 border-bottom">
                         <h6 class="fw-900 text-navy mb-0 x-small text-uppercase letter-spacing-1">BOOKING OVERVIEW</h6>
                    </div>
                    <div class="card-body p-4">
                         <div class="d-flex align-items-start gap-3 mb-4">
                              <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=100&auto=format&fit=crop&q=80" class="rounded-3 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                              <div>
                                  <h6 class="fw-900 text-navy mb-1" style="font-size:15px;">Taj Exotica Resort & Spa</h6>
                                  <p class="x-small text-muted mb-2 fw-700">Garden Villa Room</p>
                                  <div class="d-flex gap-2">
                                      <span class="badge bg-light text-navy x-small fw-800">12 NOV - 15 NOV</span>
                                      <span class="badge bg-light text-navy x-small fw-800">1 ROOM</span>
                                  </div>
                              </div>
                         </div>
                         <hr class="my-3 opacity-10">
                         <div class="mb-4">
                              <h6 class="x-small text-muted fw-900 text-uppercase mb-2 letter-spacing-1">GUESTS</h6>
                              <div class="small fw-700 text-navy mb-1">RAHUL SHARMA (Adult)</div>
                              <div class="small fw-700 text-navy">PRIYA SHARMA (Adult)</div>
                         </div>
                    </div>
                </div>

                <!-- Simulating API Loading State (Hidden by default) -->
                <div id="paymentLoadingOverlay" class="d-none">
                     <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                          <div class="spinner-grow text-primary mb-4" role="status" style="width: 60px; height: 60px;"></div>
                          <h5 class="fw-900 text-navy">Deducting from Wallet...</h5>
                          <p class="text-muted small">Generating your booking voucher and E-Ticket.</p>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectPayment(el) {
    document.querySelectorAll('.payment-method-v2').forEach(item => {
        item.classList.remove('active', 'border-primary', 'border-2');
        item.classList.add('border-1');
        item.querySelector('input').checked = false;
        item.querySelector('.payment-icon').classList.replace('bg-primary', 'bg-light');
        item.querySelector('.payment-icon').classList.replace('text-white', 'text-navy');
    });
    
    el.classList.add('active', 'border-primary', 'border-2');
    el.classList.remove('border-1');
    el.querySelector('input').checked = true;
    el.querySelector('.payment-icon').classList.replace('bg-light', 'bg-primary');
    el.querySelector('.payment-icon').classList.replace('text-navy', 'text-white');
}

document.getElementById('payNowBtn')?.addEventListener('click', async function() {
    const btn = this;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
    btn.classList.add('disabled');

    // 1. Check if user is logged in
    let user = null;
    try {
        const res = await fetch('/api/user', { credentials: 'same-origin' });
        if (res.status === 401) {
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
            return;
        }
        user = await res.json();
    } catch (e) {
        Swal.fire('Error', 'Could not check login status.', 'error');
        btn.innerHTML = 'CONFIRM & PAY NOW <i class="fas fa-lock ms-2"></i>';
        btn.classList.remove('disabled');
        return;
    }

    // 2. Collect booking/guest details from your page (replace with real values)
    const bookingData = {
        hotel_code: 'TAJEXO', // TODO: Replace with actual hotel code
        room_type: 'Garden Villa Room', // TODO: Replace with actual room type
        check_in: '2026-11-12', // TODO: Replace with actual check-in
        check_out: '2026-11-15', // TODO: Replace with actual check-out
        guests: [
            { name: 'Rahul', surname: 'Sharma', type: 'AD' },
            { name: 'Priya', surname: 'Sharma', type: 'AD' }
        ], // TODO: Replace with actual guest data
        rate_key: 'SAMPLE_RATE_KEY', // TODO: Replace with actual rate key
        holder_name: 'Rahul', // TODO: Replace with actual primary guest name
        holder_surname: 'Sharma', // TODO: Replace with actual primary guest surname
        email: 'rahul@example.com' // TODO: Replace with actual email
    };

    // 3. Call backend booking API
    try {
        const res = await fetch('/api/hotel/book', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            body: JSON.stringify(bookingData)
        });
        const data = await res.json();
        if (res.ok && data.success) {
            window.location.href = '/hotel/confirmation?ref=' + encodeURIComponent(data.booking.reference);
        } else {
            Swal.fire('Booking Failed', data.error || 'Booking failed.', 'error');
            btn.innerHTML = 'CONFIRM & PAY NOW <i class="fas fa-lock ms-2"></i>';
            btn.classList.remove('disabled');
        }
    } catch (e) {
        Swal.fire('Booking Failed', 'Booking failed. Please try again.', 'error');
        btn.innerHTML = 'CONFIRM & PAY NOW <i class="fas fa-lock ms-2"></i>';
        btn.classList.remove('disabled');
    }
});
</script>

<style>
.text-navy { color: #02234b; }
.btn-navy { background: #02234b; color: #fff; }
.btn-navy:hover { background: #001f3f; color: #fff; }
.x-small { font-size: 11px; }
.letter-spacing-1 { letter-spacing: 1px; }

.payment-method-v2 { cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.payment-method-v2:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.hover-glow:hover { box-shadow: 0 0 20px rgba(var(--primary-rgb), 0.4) !important; }
</style>
@endsection

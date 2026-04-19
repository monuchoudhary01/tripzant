@extends('layouts.app')

@section('title', "Request Hotel Quote — Tripzant B2B Portal")

@section('content')
<div class="py-5" style="background: #f0f4f8; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden animate-up">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500&auto=format&fit=crop&q=80" class="h-100 w-100" style="object-fit: cover;">
                            </div>
                            <div class="col-md-8 p-4 bg-white d-flex flex-column justify-content-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-2" style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">
                                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/hotels" class="text-decoration-none text-muted">Hotels</a></li>
                                        <li class="breadcrumb-item active text-primary" aria-current="page">Request Quote</li>
                                    </ol>
                                </nav>
                                <span class="badge bg-primary-light text-primary mb-2 align-self-start py-2 px-3 fw-bold" style="background:rgba(11, 61, 97, 0.1);">HOTEL QUOTATION REQUEST</span>
                                <h2 class="fw-900 text-navy mb-1" style="font-size:24px;">Taj Exotica Resort & Spa</h2>
                                <p class="text-muted mb-0 fw-600 small"><i class="fas fa-map-marker-alt text-danger me-2"></i>Benaulim, South Goa, India</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-up" style="animation-delay: 0.1s;">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 bg-primary text-white rounded-4 shadow-sm"><i class="fas fa-file-contract"></i></div>
                            <div>
                                <h5 class="fw-900 text-navy mb-0">Request Details</h5>
                                <p class="text-muted small mb-0">Customize your requirements for the best offer.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form id="hotelQuoteForm">
                            <div class="row g-4">
                                <!-- Agent Info -->
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Agent Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-user-tie text-navy"></i></span>
                                        <input type="text" class="form-control rounded-end-3 border-0 bg-light py-2 fw-bold text-navy" value="Global Travel Solutions" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Agent Contact</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-phone text-navy"></i></span>
                                        <input type="text" class="form-control rounded-end-3 border-0 bg-light py-2 fw-bold text-navy" value="+91 98765-43210" readonly>
                                    </div>
                                </div>

                                <!-- Stay Details -->
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Check-in Date</label>
                                    <div class="input-group shadow-sm-hover transition-03">
                                        <span class="input-group-text bg-white border-light-subtle text-primary"><i class="fas fa-calendar-check-o"></i></span>
                                        <input type="date" class="form-control rounded-end-3 border-light-subtle py-2 fw-bold" value="2025-11-12">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Check-out Date</label>
                                    <div class="input-group shadow-sm-hover transition-03">
                                        <span class="input-group-text bg-white border-light-subtle text-primary"><i class="fas fa-calendar-times-o"></i></span>
                                        <input type="date" class="form-control rounded-end-3 border-light-subtle py-2 fw-bold" value="2025-11-15">
                                    </div>
                                </div>

                                <!-- Guests & Rooms -->
                                <div class="col-md-4 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Rooms</label>
                                    <select class="form-select rounded-3 border-light-subtle py-2 fw-bold">
                                        <option value="1">1 Room</option>
                                        <option value="2">2 Rooms</option>
                                        <option value="3">3 Rooms</option>
                                        <option value="4">4+ Rooms</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Adults</label>
                                    <select class="form-select rounded-3 border-light-subtle py-2 fw-bold">
                                        <option value="1">1 Adult</option>
                                        <option value="2" selected>2 Adults</option>
                                        <option value="3">3 Adults</option>
                                        <option value="4">4+ Adults</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Children</label>
                                    <select class="form-select rounded-3 border-light-subtle py-2 fw-bold">
                                        <option value="0">0 Children</option>
                                        <option value="1">1 Child</option>
                                        <option value="2">2 Children</option>
                                    </select>
                                </div>

                                <!-- Additional Options -->
                                <div class="col-md-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Special Requests (Optional)</label>
                                    <textarea class="form-control rounded-4 border-light-subtle py-3 fw-bold" rows="3" placeholder="e.g. Twin beds, Late check-in, Honeymoon decor..."></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-800 small text-uppercase text-muted letter-spacing-1">Expected Budget (Optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-light-subtle text-success fw-bold">₹</span>
                                        <input type="number" class="form-control rounded-end-3 border-light-subtle py-2 fw-bold" placeholder="Maximum budget for the stay">
                                    </div>
                                    <p class="x-small text-muted mt-2"><i class="fas fa-info-circle me-1"></i> Providing a budget helps the hotel give you a more tailored quotation.</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-12 mt-4">
                                    <div class="d-flex flex-column flex-md-row gap-3">
                                        <button type="button" class="btn btn-navy flex-grow-1 py-3 rounded-pill fw-bold shadow hover-glow" id="submitQuoteBtn">
                                            SUBMIT QUOTE REQUEST <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                        <button type="button" class="btn btn-success px-4 py-3 rounded-pill fw-bold" title="Send via WhatsApp (BETA)">
                                            <i class="fab fa-whatsapp fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast (MMT Style) -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="quoteSuccessToast" class="toast hide border-0 rounded-4 shadow-lg bg-navy text-white overflow-hidden" role="alert">
        <div class="d-flex align-items-center">
            <div class="p-3 bg-success text-white rounded-start-4"><i class="fas fa-check-circle fs-4"></i></div>
            <div class="toast-body p-3">
                <h6 class="fw-bold mb-1">Request Success!</h6>
                <p class="small mb-0 opacity-75">Your request was sent. Redirecting...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('submitQuoteBtn')?.addEventListener('click', function() {
    const btn = this;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> SENDING...';
    btn.classList.add('disabled');
    
    // Collect Data
    const formData = {
        _token: "{{ csrf_token() }}",
        type: 'hotel_quote',
        name: "{{ Auth::user()->name ?? 'Guest User' }}",
        email: "{{ Auth::user()->email ?? 'guest@example.com' }}",
        phone: "{{ Auth::user()->phone ?? '' }}",
        hotel_name: "{{ $hotel_name ?? 'Taj Exotica' }}",
        check_in: document.querySelector('input[type="date"]').value,
        check_out: document.querySelectorAll('input[type="date"]')[1].value,
        rooms: document.querySelectorAll('select')[0].value,
        adults: document.querySelectorAll('select')[1].value,
        children: document.querySelectorAll('select')[2].value,
        requests: document.querySelector('textarea').value,
        budget: document.querySelector('input[type="number"]').value
    };

    fetch("{{ route('enquiry.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const toastElem = document.getElementById('quoteSuccessToast');
            toastElem.querySelector('.toast-body p').innerText = data.message;
            const toast = new bootstrap.Toast(toastElem);
            toast.show();
            
            setTimeout(() => {
                window.location.href = "{{ route('agent.hotel.requests') }}";
            }, 2500);
        } else {
            alert('Error: ' + data.message);
            btn.innerHTML = 'SUBMIT QUOTE REQUEST <i class="fas fa-paper-plane ms-2"></i>';
            btn.classList.remove('disabled');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerHTML = 'SUBMIT QUOTE REQUEST <i class="fas fa-paper-plane ms-2"></i>';
        btn.classList.remove('disabled');
    });
});
</script>

<style>
.bg-primary-light { background: rgba(11, 61, 97, 0.1); }
.text-navy { color: #02234b; }
.bg-navy { background: #02234b; }
.btn-navy { background: #02234b; color: #fff; }
.btn-navy:hover { background: #001f3f; color: #fff; box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; }
.letter-spacing-1 { letter-spacing: 1px; }
.x-small { font-size: 11px; }

.form-control, .form-select { border-width: 1.5px; transition: all 0.3s; }
.form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 10px rgba(var(--primary-rgb), 0.1); }

.animate-up { animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.shadow-sm-hover:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.hover-glow:hover { box-shadow: 0 0 20px rgba(var(--primary-rgb), 0.4); }
</style>
@endsection

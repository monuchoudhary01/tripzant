@extends('layouts.app')

@section('content')
<div class="main-content" style="background: #f8fafc; min-height: 100vh; padding-top: 100px;">
    <!-- Hero Section -->
    <div class="container mb-5">
        <div class="bg-navy p-5 rounded-4 shadow-lg text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="position-absolute top-0 end-0 p-5 opacity-10">
                <i class="fas fa-shipping-fast fa-10x"></i>
            </div>
            <div class="row align-items-center position-relative">
                <div class="col-lg-7">
                    <h1 class="display-4 fw-900 mb-3">Global Cargo & Logistics</h1>
                    <p class="lead opacity-75 mb-4">Send parcels, boxes, or heavy cargo anywhere in the world with real-time tracking and best-in-class pricing.</p>
                    <div class="d-flex gap-3">
                        <a href="#book" class="btn btn-primary px-4 py-3 rounded-pill fw-bold">Book Shipment</a>
                        <a href="{{ route('cargo.tracking') }}" class="btn btn-outline-light px-4 py-3 rounded-pill fw-bold">Track Shipment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="container" id="book">
        <div class="row g-4">
            <!-- Left: Booking Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-800 text-navy mb-4"><i class="fas fa-calculator me-2 text-primary"></i> Estimage Shipment Cost</h5>
                    
                    <form id="cargoCalcForm" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">PICKUP CITY / PORT</label>
                            <input type="text" name="origin" class="form-control custom-input" placeholder="e.g. Delhi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">DELIVERY CITY / PORT</label>
                            <input type="text" name="destination" class="form-control custom-input" placeholder="e.g. Dubai" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">WEIGHT (KG)</label>
                            <input type="number" name="weight" step="0.1" class="form-control custom-input" placeholder="2.5" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">PACKAGE TYPE</label>
                            <select name="package_type" class="form-select custom-input">
                                <option value="box">Box / Carton</option>
                                <option value="documents">Documents</option>
                                <option value="pallet">Pallet</option>
                                <option value="heavy">Heavy Machinery</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">DELIVERY SPEED</label>
                            <select name="delivery_type" class="form-select custom-input">
                                <option value="standard">Standard (5-7 Days)</option>
                                <option value="express">Express (2-3 Days)</option>
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-navy w-100 py-3 rounded-3 fw-bold shadow">
                                <i class="fas fa-search me-2"></i> Calculate Price & Continue
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Price Result (Hidden Initially) -->
                <div id="priceResult" class="d-none mt-4">
                    <div class="card border-primary border-2 shadow-lg rounded-4 overflow-hidden">
                        <div class="bg-primary p-3 text-white text-center fw-bold text-uppercase small">Estimated Quote Found</div>
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-900 text-navy mb-0">₹ <span id="resPrice">0</span></h2>
                                <p class="text-muted small mb-0">+ GST & Insurance | <span id="resDays">5-7 Days</span></p>
                            </div>
                            <button class="btn btn-navy px-4 py-2 rounded-pill fw-bold" onclick="showBookingStep()">Proceed to Book</button>
                        </div>
                    </div>
                </div>

                <!-- Booking Step (Hidden Initially) -->
                <div id="bookingStep" class="d-none mt-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-800 text-navy mb-4"><i class="fas fa-user-edit me-2 text-primary"></i> Sender & Receiver Details</h5>
                        <form id="cargoBookForm">
                            <div class="row g-3">
                                <div class="col-md-6 border-end pe-md-4">
                                    <h6 class="fw-bold small text-primary mb-3 text-uppercase">Sender Information</h6>
                                    <div class="mb-3">
                                        <input type="text" name="sender[name]" class="form-control custom-input small" placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="sender[phone]" class="form-control custom-input small" placeholder="Mobile Number" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="sender[address]" class="form-control custom-input small" placeholder="Pickup Address" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-md-4">
                                    <h6 class="fw-bold small text-success mb-3 text-uppercase">Receiver Information</h6>
                                    <div class="mb-3">
                                        <input type="text" name="receiver[name]" class="form-control custom-input small" placeholder="Recipient Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="receiver[phone]" class="form-control custom-input small" placeholder="Mobile Number" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="receiver[address]" class="form-control custom-input small" placeholder="Delivery Address" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 border-top pt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow">Confirm & Place Booking</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Info Panel -->
            <div class="col-lg-4">
                <!-- Tracking Quick Check -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h6 class="fw-800 text-navy mb-3">Quick Tracking</h6>
                    <div class="input-group mb-2">
                        <input type="text" id="trackInput" class="form-control custom-input" placeholder="Tracking ID (e.g. TRP-CRG-...)">
                        <button class="btn btn-primary" onclick="quickTrack()"><i class="fas fa-search"></i></button>
                    </div>
                    <p class="x-small text-muted mb-0">Real-time status of your shipments.</p>
                </div>

                <!-- Features -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-800 text-navy mb-3">Service Guarantee</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="small fw-bold text-muted">Full Insurance Coverage Available</span>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="small fw-bold text-muted">Door-to-Door Pickup & Delivery</span>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="small fw-bold text-muted">Global Partner Network</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="small fw-bold text-muted">Expert Handling (Box/Crate)</span>
                        </li>
                    </ul>
                </div>

                <!-- Recent Support -->
                <div class="card bg-navy p-4 rounded-4 shadow-sm text-white border-0">
                    <h6 class="fw-800 mb-3">Heavy Loads?</h6>
                    <p class="small opacity-75 mb-3">For commercial or multi-container shipments, get a custom quote from our experts.</p>
                    <a href="mailto:cargo@tripzant.com" class="btn btn-light w-100 btn-sm rounded-pill fw-bold">Contact Bulk Desk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    let calculationData = null;

    document.getElementById('cargoCalcForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch("{{ route('cargo.calculate') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                calculationData = data;
                document.getElementById('resPrice').innerText = data.estimated_price.toLocaleString();
                document.getElementById('resDays').innerText = data.estimated_days;
                document.getElementById('priceResult').classList.remove('d-none');
                document.getElementById('bookingStep').classList.add('d-none');
            }
        });
    });

    function showBookingStep() {
        document.getElementById('bookingStep').classList.remove('d-none');
        window.scrollTo({ top: document.getElementById('bookingStep').offsetTop - 100, behavior: 'smooth' });
    }

    document.getElementById('cargoBookForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        @if(!auth()->check())
            const authModal = new bootstrap.Modal(document.getElementById('unifiedAuthModal'));
            authModal.show();
            return;
        @endif

        const mainForm = new FormData(document.getElementById('cargoCalcForm'));
        const detailForm = new FormData(this);
        const combinedData = new FormData();

        // Combine both forms
        for(let pair of mainForm.entries()) combinedData.append(pair[0], pair[1]);
        for(let pair of detailForm.entries()) combinedData.append(pair[0], pair[1]);
        combinedData.append('total_price', calculationData.estimated_price);

        fetch("{{ route('cargo.book') }}", {
            method: 'POST',
            body: combinedData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('Success! Your Tracking ID: ' + data.tracking_id);
                window.location.href = "{{ route('dashboard.bookings') }}"; // Redirect to history
            }
        });
    });

    function quickTrack() {
        const id = document.getElementById('trackInput').value;
        if(!id) return;
        window.location.href = "{{ route('cargo.tracking') }}?tracking_id=" + id;
    }
</script>

<style>
    .bg-navy { background: #0f172a; }
    .text-navy { color: #0f172a; }
    .fw-800 { font-weight: 800; }
    .fw-900 { font-weight: 900; }
    .custom-input {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }
    .custom-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .x-small { font-size: 11px; }
</style>
@endsection

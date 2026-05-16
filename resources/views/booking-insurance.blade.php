@extends('layouts.app')

@section('title', 'Select Travel Insurance | Tripzant.com')

@section('styles')
<style>
    :root {
        --primary-blue: #008cff;
        --dark-navy: #1a202c;
        --soft-gray: #f7fafc;
        --border-color: #e2e8f0;
        --success-green: #10b981;
    }

    body { background-color: #f0f5f9; font-family: 'Plus Jakarta Sans', sans-serif; }

    .insurance-container { padding: 40px 0; }
    
    .section-title { font-size: 32px; font-weight: 900; color: var(--dark-navy); margin-bottom: 30px; letter-spacing: -0.5px; }

    /* Left Sidebar Cards */
    .trip-summary-card { background: #fff; border-radius: 16px; padding: 24px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 20px; position: relative; }
    .edit-icon { position: absolute; top: 20px; right: 20px; color: var(--primary-blue); cursor: pointer; transition: 0.3s; }
    .edit-icon:hover { transform: scale(1.1); }
    .summary-location { font-size: 20px; font-weight: 900; color: var(--dark-navy); display: block; margin-bottom: 8px; }
    .summary-details { font-size: 13px; font-weight: 700; color: #718096; display: flex; gap: 15px; align-items: center; }
    .dot-sep { width: 4px; height: 4px; background: #cbd5e0; border-radius: 50%; }

    .category-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid var(--border-color); }
    .category-title { font-size: 15px; font-weight: 800; color: var(--dark-navy); display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .category-desc { font-size: 12px; color: #718096; line-height: 1.6; font-weight: 500; }

    /* Right Panel - Plans */
    .plans-header { margin-bottom: 25px; }
    .plans-title { font-size: 18px; font-weight: 800; color: var(--dark-navy); margin-bottom: 15px; }
    .filter-group { display: flex; gap: 10px; flex-wrap: wrap; }
    .filter-btn { padding: 8px 20px; border-radius: 10px; border: 1.5px solid var(--border-color); background: #fff; color: #4a5568; font-size: 13px; font-weight: 700; transition: 0.3s; cursor: pointer; }
    .filter-btn.active { background: #fff; border-color: var(--primary-blue); color: var(--primary-blue); box-shadow: 0 4px 12px rgba(0, 140, 255, 0.15); }

    /* Insurance Plan Card */
    .plan-card { background: #fff; border-radius: 20px; border: 1px solid var(--border-color); margin-bottom: 20px; overflow: hidden; transition: 0.3s; position: relative; }
    .plan-card:hover { border-color: var(--primary-blue); transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.06); }
    .plan-card.selected { border: 2.5px solid var(--primary-blue); background: #f0f9ff; }

    .plan-badge-row { padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; background: #fff; }
    .badge-wrap { display: flex; gap: 8px; align-items: center; }
    .badge-recommended { background: #9b51e0; color: #fff; font-size: 10px; font-weight: 900; text-transform: uppercase; padding: 4px 10px; border-radius: 4px; letter-spacing: 0.5px; }
    .badge-insurance { color: #9b51e0; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .compare-wrap { display: flex; align-items: center; gap: 8px; color: #718096; font-size: 13px; font-weight: 600; cursor: pointer; }
    .compare-checkbox { width: 16px; height: 16px; border-radius: 4px; }

    .plan-main-body { padding: 25px; }
    .plan-title-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
    .plan-name { font-size: 20px; font-weight: 900; color: var(--dark-navy); margin-bottom: 4px; }
    .plan-sub { font-size: 12px; color: #718096; font-weight: 600; }

    .price-section { text-align: right; }
    .you-pay-text { font-size: 11px; font-weight: 900; color: var(--success-green); text-transform: uppercase; margin-bottom: 2px; }
    .current-price { font-size: 22px; font-weight: 900; color: var(--dark-navy); }
    .old-price { font-size: 14px; text-decoration: line-through; color: #a0aec0; margin-right: 5px; }
    .price-per { font-size: 11px; font-weight: 700; color: #718096; display: block; }

    .provider-strip { background: #f8fafc; border: 1px solid #edf2f7; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
    .provider-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .provider-logo-name { display: flex; align-items: center; gap: 12px; }
    .provider-logo { width: 24px; height: 24px; background: #fff; border: 1px solid #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; }
    .provider-name { font-size: 13px; font-weight: 800; color: var(--dark-navy); }
    .tnc-link { color: var(--primary-blue); font-size: 11px; font-weight: 800; text-decoration: none; border-bottom: 1px dashed var(--primary-blue); }

    .benefits-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; border-top: 1px solid #edf2f7; padding-top: 12px; }
    .benefit-item { text-align: left; }
    .benefit-label { font-size: 11px; font-weight: 600; color: #718096; display: block; }
    .benefit-value { font-size: 12px; font-weight: 800; color: var(--dark-navy); }
    .more-benefits { color: var(--primary-blue); font-size: 11px; font-weight: 800; text-decoration: none; }

    .buy-now-btn { background: var(--primary-blue); color: #fff; font-weight: 900; border: none; padding: 12px 35px; border-radius: 10px; font-size: 15px; box-shadow: 0 4px 15px rgba(0, 140, 255, 0.3); transition: 0.3s; }
    .buy-now-btn:hover { background: #007ae6; transform: scale(1.02); }

    .responsive-flex { display: flex; justify-content: space-between; align-items: center; }
    @media (max-width: 768px) {
        .benefits-grid { grid-template-columns: repeat(2, 1fr); }
        .responsive-flex { flex-direction: column; align-items: flex-start; gap: 15px; }
        .buy-now-btn { width: 100%; }
        .price-section { text-align: left; margin-bottom: 15px; }
    }
</style>
@endsection

@section('content')
<div class="insurance-container">
    <div class="container">
        <h1 class="section-title text-center text-md-start">Recommended Plans for Your Trip</h1>
        
        <div class="row g-4">
            <!-- Left Column: Summary & Info -->
            <div class="col-lg-4">
                <!-- Trip Summary Card -->
                <div class="trip-summary-card">
                    <i class="fas fa-pencil-alt edit-icon"></i>
                    <span class="summary-location">Thailand</span>
                    <div class="summary-details">
                        <span>3 Apr'26 - 7 Apr'26</span>
                        <div class="dot-sep"></div>
                        <span>1 Traveller</span>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="category-card">
                    <div class="category-title">
                        <img src="https://imgak.mmtcdn.com/flights/assets/media/dt/common/icons/insurance_icon.png" width="24" alt="Icon">
                        International Travel + Medical Insurance
                    </div>
                    <p class="category-desc">
                        Comprehensive plans for safer trips, including country-specific coverage, trip delay/cancellation coverage, and unexpected medical expenses abroad.
                    </p>
                    <div class="mt-3">
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <i class="fas fa-check-circle text-success x-small"></i>
                            <span class="x-small fw-bold text-dark">Medical emergencies up to $250k</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <i class="fas fa-check-circle text-success x-small"></i>
                            <span class="x-small fw-bold text-dark">Passport and baggage loss</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <i class="fas fa-check-circle text-success x-small"></i>
                            <span class="x-small fw-bold text-dark">Flight delay compensation</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Plans -->
            <div class="col-lg-8">
                <div class="plans-header">
                    <h2 class="plans-title">Choose plan for your Trip</h2>
                    <div class="d-flex align-items-center gap-3">
                        <span class="x-small fw-900 text-muted uppercase">Sum Insured per Person</span>
                        <div class="filter-group">
                            <div class="filter-btn active">All</div>
                            <div class="filter-btn">$50000</div>
                            <div class="filter-btn">$100000</div>
                            <div class="filter-btn">$250000</div>
                        </div>
                    </div>
                </div>

                @foreach($plans as $p)
                @php $benefits = json_decode($p->benefits, true); @endphp
                <div class="plan-card {{ $p->is_recommended ? 'selected' : '' }}">
                    <div class="plan-badge-row">
                        <div class="badge-wrap">
                            @if($p->is_recommended)
                                <span class="badge-recommended">RECOMMENDED</span>
                            @endif
                            <span class="badge-insurance">INSURANCE</span>
                        </div>
                        <label class="compare-wrap">
                            <input type="checkbox" class="compare-checkbox">
                            Compare
                        </label>
                    </div>
                    
                    <div class="plan-main-body">
                        <div class="plan-title-section">
                            <div>
                                <h3 class="plan-name">{{ $p->name }}</h3>
                                <p class="plan-sub">Use wallet cash to pay now & save 10% extra</p>
                            </div>
                            <div class="price-section">
                                <div class="you-pay-text">You Pay</div>
                                <div>
                                    @if($p->old_price)
                                        <span class="old-price">₹{{ number_format($p->old_price, 0) }}</span>
                                    @endif
                                    <span class="current-price">₹{{ number_format($p->price, 0) }}</span>
                                </div>
                                <span class="price-per">per person</span>
                            </div>
                        </div>

                        <div class="provider-strip">
                            <div class="provider-info">
                                <div class="provider-logo-name">
                                    <div class="provider-logo">
                                        <img src="{{ $p->provider_logo }}" width="16" alt="LOGO">
                                    </div>
                                    <span class="provider-name">{{ $p->provider }}</span>
                                </div>
                                <a href="#" class="tnc-link">T&Cs</a>
                            </div>
                            
                            <div class="benefits-grid">
                                @foreach(array_slice($benefits, 0, 3) as $benefit)
                                <div class="benefit-item">
                                    <span class="benefit-label">Coverage</span>
                                    <span class="benefit-value">{{ $benefit }}</span>
                                </div>
                                @endforeach
                                <div class="benefit-item text-end">
                                    <a href="#" class="more-benefits">{{ count($benefits) - 3 }} More Benefits</a>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button onclick="selectPlan('{{ $p->id }}')" class="buy-now-btn">BUY NOW</button>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="alert alert-secondary border-0 rounded-4 p-4 mt-5">
                    <div class="d-flex gap-4">
                        <i class="fas fa-shield-alt fa-3x text-muted opacity-25"></i>
                        <div>
                            <h6 class="fw-900 text-dark mb-1">Why Buy Insurance?</h6>
                            <p class="small text-muted mb-0">Travel plans can change. Insurance protects you from massive medical bills abroad, flight cancellations, and lost belongings, ensuring peace of mind throughout your journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectPlan(planId) {
        if (!confirm('Proceed to book this insurance plan?')) return;

        fetch("{{ route('booking.insurance.post') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ plan_id: planId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Success! Your insurance has been booked. Reference: ' + data.booking_id);
                window.location.href = "{{ localized_url('/') }}";
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
    }

    // Toggle active state for filters
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(el => el.classList.remove('active'));
            btn.classList.add('active');
        });
    });
</script>
@endsection

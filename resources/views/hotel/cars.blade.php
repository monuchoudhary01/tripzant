@extends('layouts.hotel_master')

@section('title', 'Self-Drive & Rental Fleet | Hotel Partner Super App')

@section('styles')
<style>
    .ps-car-card { background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--ps-border); transition: 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .ps-car-card:hover { border-color: var(--ps-accent); transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .ps-car-img { height: 180px; background-size: contain; background-repeat: no-repeat; background-position: center; padding: 20px; }
    .ps-car-spec { font-size: 11px; font-weight: 800; color: #64748b; background: #f8fafc; padding: 6px 12px; border-radius: 8px; flex: 1; text-align: center; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Car Rental Ecosystem</h2>
        <p class="text-muted fw-600 mb-0">Direct access to the city's top self-drive and chauffeur fleets for your high-value guests.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-light rounded-pill px-4 fw-800 border-0">SELF-DRIVE</button>
        <button class="btn btn-light rounded-pill px-4 fw-800 border-0">CHAUFFEUR-DRIVEN</button>
    </div>
</div>

<div class="row g-4">
    <!-- Car 1 -->
    <div class="col-md-4">
        <div class="ps-car-card">
            <div class="ps-car-img" style="background-image: url('https://freepngimg.com/download/car/5-2-car-png-hd.png');"></div>
            <div class="p-4 pt-0">
                 <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">SUV • MANUAL</div>
                 <h5 class="outfit fw-800 text-navy mb-4">Mahindra XUV 700 AX7</h5>
                 
                 <div class="d-flex gap-2 mb-4">
                      <div class="ps-car-spec"><i class="fas fa-gas-pump me-1"></i> PETROL</div>
                      <div class="ps-car-spec"><i class="fas fa-users me-1"></i> 7 SEATER</div>
                      <div class="ps-car-spec"><i class="fas fa-tachometer-alt me-1"></i> UNLIMITED</div>
                 </div>

                 <div class="d-flex justify-content-between align-items-center mb-4">
                      <div class="h5 fw-900 text-navy mb-0 outfit">₹3,450 / day</div>
                      <span class="tiny text-success fw-900 border px-2 py-1 rounded">COMMISSION: ₹510</span>
                 </div>
                 
                 <button class="btn ps-btn-primary w-100 py-3 rounded-pill">RENT FOR CLIENT</button>
            </div>
        </div>
    </div>

    <!-- Car 2 -->
    <div class="col-md-4">
        <div class="ps-car-card">
            <div class="ps-car-img" style="background-image: url('https://freepngimg.com/download/car/2-2-car-png-file.png');"></div>
            <div class="p-4 pt-0">
                 <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">PREMIUM • AUTO</div>
                 <h5 class="outfit fw-800 text-navy mb-4">Audi A6 Business Matrix</h5>
                 
                 <div class="d-flex gap-2 mb-4">
                      <div class="ps-car-spec"><i class="fas fa-gas-pump me-1"></i> DIESEL</div>
                      <div class="ps-car-spec"><i class="fas fa-users me-1"></i> 5 SEATER</div>
                      <div class="ps-car-spec"><i class="fas fa-shield-alt me-1"></i> INSURED</div>
                 </div>

                 <div class="d-flex justify-content-between align-items-center mb-4">
                      <div class="h5 fw-900 text-navy mb-0 outfit">₹12,800 / day</div>
                      <span class="tiny text-success fw-900 border px-2 py-1 rounded">COMMISSION: ₹1,900</span>
                 </div>
                 
                 <button class="btn ps-btn-primary w-100 py-3 rounded-pill">RENT FOR CLIENT</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="ps-car-card">
            <div class="ps-car-img" style="background-image: url('https://freepngimg.com/download/car/1-2-car-png-picture.png');"></div>
            <div class="p-4 pt-0">
                 <div class="tiny fw-800 text-muted uppercase ls-1 mb-1">SEDAN • AUTO</div>
                 <h5 class="outfit fw-800 text-navy mb-4">Toyota Camry Hybrid</h5>
                 
                 <div class="d-flex gap-2 mb-4">
                      <div class="ps-car-spec"><i class="fas fa-gas-pump me-1"></i> HYBRID</div>
                      <div class="ps-car-spec"><i class="fas fa-users me-1"></i> 5 SEATER</div>
                      <div class="ps-car-spec"><i class="fas fa-wifi me-1"></i> CONNECTED</div>
                 </div>

                 <div class="d-flex justify-content-between align-items-center mb-4">
                      <div class="h5 fw-900 text-navy mb-0 outfit">₹6,200 / day</div>
                      <span class="tiny text-success fw-900 border px-2 py-1 rounded">COMMISSION: ₹950</span>
                 </div>
                 
                 <button class="btn ps-btn-primary w-100 py-3 rounded-pill">RENT FOR CLIENT</button>
            </div>
        </div>
    </div>
</div>
@endsection

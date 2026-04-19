@extends('layouts.app')

@section('title', "Global Visa Assistance — Fast, Secure & Online | Trip Zant")
@section('active-visa', 'active')

@section('styles')
<style>
    /* Hero Section */
    .visa-hero-v2 {
        background: url('https://images.unsplash.com/photo-1544016768-982d1554f0b9?w=1600&auto=format&fit=crop&q=80') center/cover no-repeat;
        padding: 120px 0 160px;
        position: relative;
        color: #fff;
    }
    .visa-hero-v2::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(180deg, rgba(11, 61, 97, 0.9), rgba(11, 61, 97, 0.4));
    }
    
    /* Modern Search Widget */
    .visa-widget-box {
        background: #fff; 
        border-radius: 20px; 
        padding: 10px;
        margin-top: -60px; 
        position: relative; 
        z-index: 10;
        box-shadow: 0 30px 60px rgba(11, 61, 97, 0.15);
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .widget-grid {
        display: flex;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
    }
    .widget-item-v {
        flex: 1;
        padding: 20px 25px; 
        border-right: 1px solid #f1f5f9;
        transition: 0.3s; 
        cursor: pointer;
    }
    .widget-item-v:last-child { border-right: none; }
    .widget-item-v:hover { background: rgba(var(--primary-rgb), 0.05); }
    
    .widget-label-v { 
        font-size: 11px; font-weight: 800; color: #64748b; 
        text-transform: uppercase; letter-spacing: 1px; 
        margin-bottom: 8px; display: block; 
    }
    .widget-val-v { 
        font-size: 18px; font-weight: 900; color: var(--navy); 
        margin: 0; border: none; background: transparent; 
        width: 100%; outline: none; 
    }
    .widget-val-v::placeholder { color: #cbd5e1; font-weight: 700; }
    
    /* Floating Search Button */
    .btn-search-v {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff; 
        padding: 12px 60px; 
        border-radius: 50px; 
        font-size: 20px; 
        font-weight: 900;
        border: none; 
        text-transform: uppercase;
        box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.3);
        transition: 0.3s;
        margin-top: -25px;
        display: inline-block;
        text-decoration: none;
    }
    .btn-search-v:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 15px 30px rgba(var(--primary-rgb), 0.4);
        color: #fff;
    }

    /* Cards and Badges */
    .icon-box-v { 
        width: 60px; height: 60px; border-radius: 18px; 
        background: rgba(var(--primary-rgb), 0.1); 
        color: var(--primary); display: flex; 
        align-items: center; justify-content: center; 
        font-size: 24px; margin-bottom: 20px; 
    }
    .pop-dest-card { border-radius: 20px; border: 1.5px solid #f1f5f9; padding: 20px; transition: 0.3s; height: 100%; position: relative; }
    .pop-dest-card:hover { border-color: var(--primary); transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
    .approval-badge { position: absolute; top: 15px; right: 15px; font-size: 9px; font-weight: 900; background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 5px 12px; border-radius: 50px; }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="visa-hero-v2">
    <div class="container text-center position-relative" style="z-index: 2;">
        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2 mb-4 fw-bold" style="font-size:12px; letter-spacing:1px; border:1px solid rgba(255,255,255,0.2);">
            <i class="fas fa-passport me-2"></i> POWERED BY EXPERTS
        </span>
        <h1 class="display-3 fw-900 mb-3 tracking-tight">Apply for a Visa : <span class="highlight-orange">On Time</span></h1>
        <p class="fs-4 text-white-50 opacity-75">Hassle-free visa services with 99% approval guarantee.</p>
    </div>
</section>

<!-- Modern Search Widget -->
<div class="container">
    <div class="visa-widget-box">
        <div class="widget-grid">
            <!-- 1. Destination -->
            <div class="widget-item-v">
                <span class="widget-label-v">Select Destination</span>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-location-dot text-primary fs-5"></i>
                    <input type="text" class="widget-val-v" placeholder="Where are you going?" value="Dubai (UAE)">
                </div>
            </div>
            
            <!-- 2. Departure Date -->
            <div class="widget-item-v">
                <span class="widget-label-v">Date of Departure</span>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-calendar-days text-primary fs-5"></i>
                    <input type="text" class="widget-val-v" value="{{ date('d M, Y') }}">
                </div>
            </div>
            
            <!-- 3. Return Date -->
            <div class="widget-item-v">
                <span class="widget-label-v">Date of Return</span>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-calendar-check text-primary fs-5"></i>
                    <input type="text" class="widget-val-v" value="{{ date('d M, Y', strtotime('+7 days')) }}">
                </div>
            </div>
            
            <!-- 4. Visa Type -->
            <div class="widget-item-v" style="border-right: none;">
                <span class="widget-label-v">Visa Type</span>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-id-badge text-primary fs-5"></i>
                    <select class="widget-val-v border-0 bg-transparent fw-900" style="-webkit-appearance: none; appearance: none;">
                        <option>Tourist Visa</option>
                        <option>Business Visa</option>
                        <option>Student Visa</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Center Floating Search Button -->
        <a href="{{ route('visa.listing') }}" class="btn-search-v">SEARCH</a>
    </div>
</div>

<!-- Most Visited Countries -->
<section class="py-5 mt-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-4">
            <h3 class="fw-900 text-navy mb-0">Most-visited Countries</h3>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-navy rounded-circle" style="width: 36px; height: 36px;"><i class="fas fa-chevron-left"></i></button>
                <button class="btn btn-sm btn-outline-navy rounded-circle" style="width: 36px; height: 36px;"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        
        <div class="row g-4">
            @php
            $popCities = [
                ['name' => 'United Arab Emirates', 'flag' => '🇦🇪', 'price' => '6,950', 'tag' => 'E-VISA', 'color' => 'primary'],
                ['name' => 'Thailand', 'flag' => '🇹🇭', 'price' => '0', 'tag' => 'DAC', 'color' => 'warning'],
                ['name' => 'Vietnam', 'flag' => '🇻🇳', 'price' => '2,500', 'tag' => 'E-VISA', 'color' => 'primary'],
                ['name' => 'Indonesia', 'flag' => '🇮🇩', 'price' => '3,000', 'tag' => 'EVOA', 'color' => 'success'],
            ];
            @endphp
            @foreach($popCities as $c)
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('visa.detail', ['country' => strtolower($c['name'])]) }}" class="text-decoration-none">
                    <div class="pop-dest-card">
                        <span class="approval-badge">99.5% HI-APPROVAL</span>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="fs-2">{{ $c['flag'] }}</span>
                            <span class="badge bg-{{ $c['color'] }} bg-opacity-10 text-{{ $c['color'] }} fw-900 small rounded-pill px-3">{{ $c['tag'] }}</span>
                        </div>
                        <h5 class="fw-900 text-navy mb-1">{{ $c['name'] }}</h5>
                        <p class="small text-muted fw-bold mb-4">Get your visa by {{ date('d Apr', strtotime('+5 days')) }}<br><span class="text-primary">100k+ Visas Processed</span></p>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div class="fw-900 text-navy fs-5">₹{{ $c['price'] }} <span class="x-small text-muted fw-bold" style="font-size:10px;">+ FEES</span></div>
                            <i class="fas fa-chevron-right text-primary"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Trip Zant Visa -->
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="display-6 fw-900 text-navy mb-4">Why Trip Zant <span class="highlight-orange">Visa?</span></h2>
                <div class="row g-4">
                    <div class="col-md-6 d-flex gap-3">
                        <div class="icon-box-v flex-shrink-0"><i class="fas fa-bolt"></i></div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">Ultra Fast</h6>
                            <p class="small text-muted fw-bold mb-0">90% of visas approved within 72 hours.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex gap-3">
                        <div class="icon-box-v flex-shrink-0" style="color:var(--green); background:rgba(34, 197, 94, 0.1);"><i class="fas fa-file-shield"></i></div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">Secure & Legal</h6>
                            <p class="small text-muted fw-bold mb-0">Official partners with embassy portals.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex gap-3">
                        <div class="icon-box-v flex-shrink-0" style="color:var(--orange); background:rgba(235, 141, 47, 0.1);"><i class="fas fa-headset"></i></div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">Expedite Support</h6>
                            <p class="small text-muted fw-bold mb-0">Personal visa officer for every customer.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex gap-3">
                        <div class="icon-box-v flex-shrink-0" style="color:var(--blue); background:rgba(37, 99, 235, 0.1);"><i class="fas fa-tag"></i></div>
                        <div>
                            <h6 class="fw-900 text-navy mb-1">Best Rates</h6>
                            <p class="small text-muted fw-bold mb-0">Zero hidden service fees during checkout.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-5 rounded-4" style="background: linear-gradient(45deg, var(--navy), #003366); color: #fff;">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="p-3 bg-white bg-opacity-20 rounded-circle"><i class="fas fa-quote-left fs-3"></i></div>
                        <h4 class="mb-0 fw-900">Satisfied Travelers</h4>
                    </div>
                    <p class="fs-5 opacity-75 mb-4 italic">"MMT visa service was a savior. I got my Dubai tourist visa in just 2 days without going anywhere. Zero documentation hassle!"</p>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;color:var(--navy);font-weight:900;">RG</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Rahul Gupta</h6>
                            <span class="x-small opacity-50">Traveled to UAE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

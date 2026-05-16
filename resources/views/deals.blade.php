@extends('layouts.app')

@section('title', "Latest Travel Deals & Bank Offers | Trip Zant")

@section('styles')
<style>
    .deals-hero {
        background: linear-gradient(135deg, #0a305f 0%, #1e4b8f 100%);
        padding: 80px 0 60px;
        color: #fff;
        text-align: center;
    }
    .deal-tabs-wrapper {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 10px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        border-bottom: 1px solid #f1f5f9;
    }
    .deal-nav {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 5px;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .deal-nav::-webkit-scrollbar { display: none; }
    
    .deal-tab-btn {
        background: transparent;
        border: 1px solid transparent;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 700;
        color: #64748b;
        white-space: nowrap;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .deal-tab-btn i { font-size: 16px; }
    .deal-tab-btn:hover { color: var(--primary); background: #f8fafc; }
    .deal-tab-btn.active {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
    }

    .deal-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .deal-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        border-color: var(--primary);
    }
    .deal-img {
        height: 160px;
        position: relative;
        overflow: hidden;
    }
    .deal-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .deal-card:hover .deal-img img { transform: scale(1.1); }
    
    .deal-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(10, 48, 95, 0.8);
        backdrop-filter: blur(4px);
        color: #fff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .deal-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .deal-title { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 8px; line-height: 1.4; }
    .deal-desc { font-size: 13px; color: #64748b; margin-bottom: 20px; line-height: 1.6; }
    
    .deal-footer {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px dashed #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .promo-box {
        background: #fff;
        border: 1px dashed #cbd5e1;
        padding: 8px 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .promo-code { font-family: monospace; font-weight: 900; color: var(--navy); font-size: 16px; }
    .copy-btn { color: var(--primary); cursor: pointer; transition: transform 0.2s; }
    .copy-btn:hover { transform: scale(1.2); }

    .book-btn {
        background: var(--primary);
            color: #fff;
    padding: 3px 11px;
    border-radius: 50px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s;
    }
    .book-btn:hover { background: var(--navy); color: #fff; transform: scale(1.05); }

    .category-icon {
        width: 45px;
        height: 45px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 20px;
        margin-bottom: 15px;
    }

    /* Bank Special Card */
    .bank-card { border-left: 5px solid var(--primary); }
    .bank-logo-wrap {
        width: 60px;
        height: 60px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        overflow: hidden;
    }
    .bank-logo-wrap img { width: 35px; height: 35px; object-fit: contain; }
</style>
@endsection

@section('content')
<div class="deals-hero">
    <div class="container">
        <h1 class="display-4 fw-900 mb-3">Amazing Travel Deals</h1>
        <p class="lead opacity-75">Exclusive discounts on flights, hotels, and more. Grab them before they're gone!</p>
    </div>
</div>

<div class="deal-tabs-wrapper">
    <div class="container">
        <div class="deal-nav">
            <button class="deal-tab-btn active" onclick="filterDeals('all', this)">
                <i class="fas fa-th-large"></i> All Offers
            </button>
            @php
                $icons = [
                    'flights' => 'fa-plane',
                    'hotels' => 'fa-hotel',
                    'homestays' => 'fa-home',
                    'cabs' => 'fa-taxi',
                    'trains' => 'fa-train',
                    'holidays' => 'fa-umbrella-beach',
                    'insurance' => 'fa-shield-alt',
                    'esim' => 'fa-sim-card',
                    'bank_offer' => 'fa-university'
                ];
            @endphp
            @foreach($categories as $key => $label)
                <button class="deal-tab-btn" onclick="filterDeals('{{ $label }}', this)">
                    <i class="fas {{ $icons[$key] ?? 'fa-tag' }}"></i> {{ $label }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<div class="py-5 bg-light">
    <div class="container">
        <div class="row g-4" id="dealsContainer">
            @foreach($offers as $offer)
            <div class="col-lg-3 col-md-6 deal-item" data-category="{{ $offer->category }}">
                <div class="deal-card {{ $offer->category == 'Bank Offer' ? 'bank-card' : '' }}" style="{{ $offer->color_code ? 'border-top: 5px solid '.$offer->color_code : '' }}">
                    <div class="deal-img">
                        <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}">
                        <div class="deal-badge">{{ $offer->category }}</div>
                    </div>
                    <div class="deal-body">
                        @if($offer->category == 'Bank Offer' && $offer->image_url)
                            <div class="bank-logo-wrap" style="{{ $offer->color_code ? 'border: 2px solid '.$offer->color_code : '' }}">
                                <img src="{{ $offer->image_url }}" alt="Bank Logo">
                            </div>
                        @else
                            <div class="category-icon">
                                <i class="fas {{ $icons[$offer->category] ?? 'fa-tag' }}"></i>
                            </div>
                        @endif
                        
                        <h4 class="deal-title">{{ $offer->title }}</h4>
                        <p class="deal-desc">{{ $offer->description }}</p>
                        
                        @if($offer->discount_text)
                            <div class="alert alert-success py-2 px-3 rounded-pill d-inline-block border-0 mb-4" style="font-size: 12px; font-weight: 800;">
                                <i class="fas fa-percentage me-2"></i> {{ $offer->discount_text }}
                            </div>
                        @endif

                        <div class="deal-footer">
                            @if($offer->promo_code)
                            <div class="promo-box">
                                <span class="promo-code">{{ $offer->promo_code }}</span>
                                <i class="far fa-copy copy-btn" onclick="copyCode('{{ $offer->promo_code }}', this)"></i>
                            </div>
                            @endif
                            <a href="{{ $offer->link_url ?: '#' }}" class="book-btn">Grab Deal</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div id="noDeals" class="text-center py-5 d-none">
            <i class="fas fa-search display-1 text-muted opacity-25 mb-4"></i>
            <h3 class="text-muted">No deals found for this category</h3>
            <p>Try switching to another category or check back later!</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterDeals(category, btn) {
        // Update Active Button
        document.querySelectorAll('.deal-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const items = document.querySelectorAll('.deal-item');
        let count = 0;

        items.forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'block';
                item.classList.add('animate__animated', 'animate__fadeIn');
                count++;
            } else {
                item.style.display = 'none';
            }
        });

        // Toggle empty state
        const noDeals = document.getElementById('noDeals');
        if (count === 0) {
            noDeals.classList.remove('d-none');
        } else {
            noDeals.classList.add('d-none');
        }
    }

    function copyCode(code, icon) {
        navigator.clipboard.writeText(code).then(() => {
            const originalClass = icon.className;
            icon.className = 'fas fa-check text-success';
            setTimeout(() => {
                icon.className = originalClass;
            }, 2000);
        });
    }
</script>
@endsection

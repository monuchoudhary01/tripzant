@extends('layouts.app')

@section('title', 'Country-wise Travel Guide | Trip\'Stay Explorer')

@section('styles')
<style>
    .country-hero {
        background: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&auto=format&fit=crop&q=80') center/cover;
        position: relative;
        padding: 120px 0;
        color: #fff;
    }
    .country-hero::before {
        content: ''; position: absolute; top: 0; right: 0; bottom: 0; left: 0;
        background: linear-gradient(0deg, rgba(var(--primary-rgb), 0.95), rgba(var(--primary-rgb), 0.5));
    }
    .search-explorer {
        background: #fff; border-radius: 50px; padding: 10px 25px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .region-pill {
        padding: 12px 25px; border-radius: 50px; background: #fff;
        border: 1px solid #f1f5f9; cursor: pointer; transition: 0.3s;
        font-weight: 800; font-size: 14px; color: var(--navy);
    }
    .region-pill:hover { border-color: var(--primary); color: var(--primary); }
    .region-pill.active { background: var(--primary); color: #fff; border-color: var(--primary); }
</style>
@endsection

@section('content')
<div class="country-hero">
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-5 fw-900 mb-4 animate-up">Explore the world by <span class="highlight-orange">Destination</span></h1>
        
        <div class="search-explorer d-flex align-items-center gap-3 animate-up delay-1">
            <i class="fas fa-magnifying-glass text-muted fs-5"></i>
            <input type="text" class="form-control border-0 shadow-none fs-5 fw-600" placeholder="Search a country or region (e.g. Switzerland, Europe)...">
            <button class="btn btn-primary rounded-pill px-5 py-3 fw-900 border-0 shadow">EXPLORE</button>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex gap-3 mb-5 overflow-auto pb-4">
        <div class="region-pill active">All Regions</div>
        <div class="region-pill">Europe 🇪🇺</div>
        <div class="region-pill">Asia 🌏</div>
        <div class="region-pill">Middle East 🕌</div>
        <div class="region-pill">Oceania 🇦🇺</div>
        <div class="region-pill">Americas 🇺🇸</div>
        <div class="region-pill">Africa 🌋</div>
    </div>

    <div class="row g-4">
        @php
        $countries = [
            ['name' => 'United Arab Emirates', 'flag' => '🇦🇪', 'trend' => 'Best in Sep (₹18k)', 'desc' => 'Desert luxury, world-class shopping.'],
            ['name' => 'Switzerland', 'flag' => '🇨🇭', 'trend' => 'Best in Apr (₹52k)', 'desc' => 'Alpine landscapes, snowy peaks.'],
            ['name' => 'Japan', 'flag' => '🇯🇵', 'trend' => 'Best in Nov (₹45k)', 'desc' => 'Cherry blossoms, ancient temples.'],
            ['name' => 'Thailand', 'flag' => '🇹🇭', 'trend' => 'Best in Sep (₹12k)', 'desc' => 'Islands, street food and night life.'],
            ['name' => 'Iceland', 'flag' => '🇮🇸', 'trend' => 'Best in Feb (₹65k)', 'desc' => 'Northern lights, volcanic terrain.'],
            ['name' => 'Bali (Indonesia)', 'flag' => '🇮🇩', 'trend' => 'Best in Mar (₹22k)', 'desc' => 'Tropical paradise and surfing.'],
        ];
        @endphp
        @foreach($countries as $c)
        <div class="col-lg-4 col-md-6">
            <div class="card-premium p-4 h-100 hover-lift d-flex flex-column" 
                 style="background:rgba(var(--primary-rgb), 0.01); border: 1.5px solid #f1f5f9; border-radius: 24px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="display-6">{{ $c['flag'] }}</span>
                    <span class="badge bg-success-light text-success fw-900 x-small px-3 rounded-pill" style="background: rgba(34, 197, 94, 0.1);">{{ $c['trend'] }}</span>
                </div>
                <h4 class="fw-900 text-navy mb-2">{{ $c['name'] }}</h4>
                <p class="text-muted small fw-bold mb-5 flex-grow-1">{{ $c['desc'] }}</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-navy rounded-pill flex-grow-1 fw-bold small">VIEW TRENDS</button>
                    <button class="btn btn-navy rounded-pill flex-grow-1 fw-bold small">HOTELS</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

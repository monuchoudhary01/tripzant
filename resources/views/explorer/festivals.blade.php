@extends('layouts.app')

@section('title', 'Global Festivals Directory | Trip\'Stay Explorer')

@section('styles')
<style>
    .festival-hero {
        background: url('https://images.unsplash.com/photo-1549417229-aa67d3263c09?w=1600&auto=format&fit=crop&q=80') center/cover;
        position: relative;
        padding: 100px 0;
        color: #fff;
    }
    .festival-hero::before {
        content: ''; position: absolute; top: 0; right: 0; bottom: 0; left: 0;
        background: linear-gradient(0deg, rgba(11, 61, 97, 0.95), rgba(11, 61, 97, 0.6));
    }
    .fest-card {
        background: #fff; border-radius: 20px; overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f1f5f9;
        height: 100%;
    }
    .fest-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); border-color: var(--primary); }
    .fest-img { height: 180px; width: 100%; object-fit: cover; }
    .fest-icon { 
        width: 48px; height: 48px; border-radius: 12px; background: rgba(var(--primary-rgb), 0.1);
        color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px;
    }
</style>
@endsection

@section('content')
<div class="festival-hero">
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-900 mb-3">Plan your journey around <span class="highlight-orange">Experiences</span></h1>
        <p class="fs-5 text-white-50">Discover the world's most vibrant cultures and festivals each month.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-lg-6">
            <h2 class="fw-900 text-navy mb-0">Monthly Festivals Directory</h2>
        </div>
        <div class="col-lg-6">
            <div class="d-flex gap-2 justify-content-lg-end mt-3 mt-lg-0">
                <button class="btn btn-outline-navy rounded-pill px-4 fw-bold active small">All Festivals</button>
                <button class="btn btn-outline-navy rounded-pill px-4 fw-bold small">Cultural</button>
                <button class="btn btn-outline-navy rounded-pill px-4 fw-bold small">Music</button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @php
        $festivals = [
            ['name' => 'Rio Carnival', 'location' => 'Rio de Janeiro, Brazil', 'month' => 'February', 'icon' => '🎭', 'img' => 'https://images.unsplash.com/photo-1549417229-aa67d3263c09?w=600&q=80'],
            ['name' => 'Holi Festival', 'location' => 'Varanasi, India', 'month' => 'March', 'icon' => '🎨', 'img' => 'https://images.unsplash.com/photo-1547842602-bc3f7895aa97?w=600&q=80'],
            ['name' => 'Cherry Blossom', 'location' => 'Kyoto, Japan', 'month' => 'April', 'icon' => '🌸', 'img' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&q=80'],
            ['name' => 'Tomorrowland', 'location' => 'Boom, Belgium', 'month' => 'July', 'icon' => '🎧', 'img' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&q=80'],
            ['name' => 'Oktoberfest', 'location' => 'Munich, Germany', 'month' => 'October', 'icon' => '🍻', 'img' => 'https://images.unsplash.com/photo-1532634812-d8581ccd7dc1?w=600&q=80'],
            ['name' => 'Diwali', 'location' => 'All India', 'month' => 'October/November', 'icon' => '🪔', 'img' => 'https://images.unsplash.com/photo-1577744486770-020ab432da65?w=600&q=80'],
        ];
        @endphp
        @foreach($festivals as $f)
        <div class="col-lg-4 col-md-6">
            <div class="fest-card d-flex flex-column">
                <img src="{{ $f['img'] }}" class="fest-img" alt="">
                <div class="p-4 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small fw-800 text-primary">{{ $f['month'] }}</div>
                        <div class="fs-4">{{ $f['icon'] }}</div>
                    </div>
                    <h5 class="fw-900 text-navy mb-1">{{ $f['name'] }}</h5>
                    <p class="text-muted small fw-bold mb-4"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $f['location'] }}</p>
                    <button class="btn btn-navy w-100 rounded-pill py-2 fw-bold small">Explore Destination</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="marketplace-area py-5" style="background: #ffffff; min-height: 100vh;">
    <div class="container">
        <!-- Search & Filter Area -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark display-5 mb-3">{{ __('labels.marketplace_title', [], 'Service Marketplace') }}</h1>
            <p class="text-muted fs-5">{{ __('labels.find_best_pro', [], 'Find the best local professionals near you') }}</p>
            
            <div class="search-bar-container mx-auto mt-5" style="max-width: 800px;">
                <div class="search-bar p-2 bg-white shadow-lg rounded-pill border d-flex align-items-center">
                    <div class="flex-grow-1 px-4 border-end text-start">
                        <label class="small fw-bold text-dark d-block">{{ __('labels.where', [], 'Where') }}</label>
                        <input type="text" placeholder="{{ __('labels.search_location', [], 'Search location') }}" class="border-0 w-100 outline-none" style="outline: none;">
                    </div>
                    <div class="flex-grow-1 px-4 border-end text-start">
                        <label class="small fw-bold text-dark d-block">{{ __('labels.service', [], 'Service') }}</label>
                        <select class="border-0 w-100 outline-none bg-transparent" style="outline: none;">
                            <option>{{ __('labels.all_services', [], 'All Services') }}</option>
                            <option>{{ __('categories.barber', [], 'Barber') }}</option>
                            <option>{{ __('categories.tutor', [], 'Tutor') }}</option>
                            <option>{{ __('categories.cleaner', [], 'Cleaner') }}</option>
                        </select>
                    </div>
                    <div class="px-2">
                        <button class="btn btn-primary rounded-circle p-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #ff385c; border-color: #ff385c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="categories-scroll d-flex gap-4 mb-5 overflow-auto pb-3 no-scrollbar justify-content-center">
            @php 
                $cats = [
                    ['key' => 'barber', 'label' => 'Barber'],
                    ['key' => 'tutor', 'label' => 'Tutor'],
                    ['key' => 'cleaner', 'label' => 'Cleaner'],
                    ['key' => 'plumber', 'label' => 'Plumber'],
                    ['key' => 'electrician', 'label' => 'Electrician'],
                    ['key' => 'gardener', 'label' => 'Gardener'],
                    ['key' => 'chef', 'label' => 'Chef'],
                    ['key' => 'mover', 'label' => 'Mover']
                ]; 
            @endphp
            @foreach($cats as $cat)
            <div class="category-item text-center cursor-pointer opacity-50 hover-opacity-100 transition">
                <div class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <span class="small fw-bold">{{ __('categories.' . $cat['key'], [], $cat['label']) }}</span>
            </div>
            @endforeach
        </div>

        <!-- Listings Grid -->
        <div class="row g-4">
            @forelse($providers as $provider)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('marketplace.provider', $provider->id) }}" class="text-decoration-none text-dark">
                    <div class="card border-0 marketplace-card h-100">
                        <div class="position-relative mb-3 overflow-hidden rounded-4" style="aspect-ratio: 1/1;">
                            <img src="https://source.unsplash.com/featured/?{{ $provider->service_category }},profile&sig={{ $provider->id }}" class="w-100 h-100 object-fit-cover transition transform hover-scale" alt="{{ $provider->name }}">
                            <div class="position-absolute top-0 end-0 p-3">
                                <button class="btn btn-light rounded-circle p-2 shadow-sm opacity-75 hover-opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="px-1">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0">{{ $provider->provider_location }}</h6>
                                <div class="small d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    <span>4.9</span>
                                </div>
                            </div>
                            <p class="text-muted small mb-1">{{ $provider->service_category }} by {{ $provider->name }}</p>
                            <p class="text-muted small mb-2">Available Tomorrow</p>
                            <p class="mb-0"><span class="fw-bold">{{ format_price($provider->pricing, 'INR') }}</span> <span class="text-muted">hour</span></p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">No providers found in this area.</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .marketplace-card:hover .hover-scale { transform: scale(1.05); }
    .transition { transition: all 0.3s ease; }
    .cursor-pointer { cursor: pointer; }
    .hover-opacity-100:hover { opacity: 1 !important; }
    .category-item { min-width: 80px; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endsection

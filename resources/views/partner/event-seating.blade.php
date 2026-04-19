@extends('layouts.app')

@section('title', "Seating & Pricing — Partner Portal | Trip Zant")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 90vh;">
    <x-partner-sidebar active="events" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-900 text-navy mb-1 breadcrumb-title"><i class="fas fa-arrow-left me-3" style="cursor:pointer;" onclick="history.back()"></i> Seating Arrangement & Dynamic Pricing</h2>
                    <p class="text-muted small mb-0">Sunburn Music Festival 2026 · 28-30 Dec 2026</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-navy rounded-pill px-4 fw-bold bg-white shadow-sm">
                        <i class="fas fa-save me-2"></i> Save Layout
                    </button>
                    <button class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fas fa-rocket me-2"></i> Publish Ticketing
                    </button>
                </div>
            </div>

            <!-- Pricing Configurator (Meta AI Style) -->
            <div class="row g-4 mb-5">
                <div class="col-xl-3">
                    <div class="price-zone-card bg-white p-4 rounded-4 shadow-sm border hvr-grow" style="border-left: 6px solid #14b8a6 !important;">
                        <h6 class="fw-900 text-navy mb-2">💎 VIP Zone</h6>
                        <p class="text-muted small mb-3">Front row, exclusive access.</p>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">₹</span>
                            <input type="number" class="form-control border-0 bg-light fw-bold" value="12500" placeholder="Price">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="price-zone-card bg-white p-4 rounded-4 shadow-sm border hvr-grow" style="border-left: 6px solid #8b5cf6 !important;">
                        <h6 class="fw-900 text-navy mb-2">💠 Platinum</h6>
                        <p class="text-muted small mb-3">Premium seating, better views.</p>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">₹</span>
                            <input type="number" class="form-control border-0 bg-light fw-bold" value="8500" placeholder="Price">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="price-zone-card bg-white p-4 rounded-4 shadow-sm border hvr-grow" style="border-left: 6px solid #3b82f6 !important;">
                        <h6 class="fw-900 text-navy mb-2">⭐ Diamond</h6>
                        <p class="text-muted small mb-3">Middle section, high demand.</p>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">₹</span>
                            <input type="number" class="form-control border-0 bg-light fw-bold" value="5200" placeholder="Price">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="price-zone-card bg-white p-4 rounded-4 shadow-sm border hvr-grow" style="border-left: 6px solid #fbbf24 !important;">
                        <h6 class="fw-900 text-navy mb-2">🏆 Gold</h6>
                        <p class="text-muted small mb-3">Standard tier, wide availability.</p>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">₹</span>
                            <input type="number" class="form-control border-0 bg-light fw-bold" value="2800" placeholder="Price">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visual Seating Layout (Reference replication) -->
            <div class="bg-white p-5 rounded-5 shadow-lg border-0 text-center position-relative overflow-hidden">
                <div class="mb-5">
                    <h5 class="fw-900 text-navy mb-1 text-uppercase">Stage / Performance Area</h5>
                    <div class="mx-auto mt-4 rounded-4" style="height: 120px; width: 60%; background: linear-gradient(135deg, #0b3d61 0%, #001f3f 100%); border: 3px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); font-size: 11px;">Misty Stage Interactive Visualizer</div>
                </div>

                <div class="seating-grid py-5" style="max-width: 900px; margin: 0 auto;">
                    @for($row=1; $row<=12; $row++)
                        <div class="d-flex justify-content-center gap-2 mb-2">
                            <div class="text-muted fw-bold me-3 text-uppercase" style="width: 20px; font-size: 10px;">{{ chr(64 + $row) }}</div>
                            @for($col=1; $col<=30; $col++)
                                @php
                                    $color = '#cbd5e1'; // Standard
                                    if($row <= 3) $color = '#14b8a6'; // VIP
                                    elseif($row <= 6) $color = '#8b5cf6'; // Platinum
                                    elseif($row <= 9) $color = '#3b82f6'; // Diamond
                                    else $color = '#fbbf24'; // Gold
                                @endphp
                                <div class="seat-dot" style="background-color: {{ $color }};" data-bs-toggle="tooltip" title="{{ chr(64 + $row) }}{{ $col }}"></div>
                                @if($col == 10 || $col == 20) <div style="width: 20px;"></div> @endif
                            @endfor
                        </div>
                    @endfor
                </div>

                <div class="mt-5 d-flex justify-content-center gap-4 py-4 border-top">
                    <div class="d-flex align-items-center gap-2 small fw-bold text-navy"><div class="seat-dot" style="background-color: #14b8a6; width:12px; height:12px; margin:0;"></div> VIP</div>
                    <div class="d-flex align-items-center gap-2 small fw-bold text-navy"><div class="seat-dot" style="background-color: #8b5cf6; width:12px; height:12px; margin:0;"></div> Platinum</div>
                    <div class="d-flex align-items-center gap-2 small fw-bold text-navy"><div class="seat-dot" style="background-color: #3b82f6; width:12px; height:12px; margin:0;"></div> Diamond</div>
                    <div class="d-flex align-items-center gap-2 small fw-bold text-navy"><div class="seat-dot" style="background-color: #fbbf24; width:12px; height:12px; margin:0;"></div> Gold</div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .breadcrumb-title i:hover { color: #f97316; transform: translateX(-4px); transition: all 0.2s ease; }
    .price-zone-card { border-radius: 20px; border: 1px solid #eef2f6 !important; }
    .seat-dot {
        width: 14px;
        height: 14px;
        border-radius: 4px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .seat-dot:hover {
        transform: scale(1.3);
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        z-index: 10;
        filter: brightness(1.1);
    }
    .form-control:focus {
        background: #fff !important;
        box-shadow: none;
    }
</style>
@endsection

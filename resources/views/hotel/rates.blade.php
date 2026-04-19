@extends('layouts.app')

@section('title', "Inventory Pricing — Partner Portal")

@section('content')
<div class="hotel-portal-wrapper d-flex" style="background: #f8fafc; min-height: 100vh;">
    <x-hotel-sidebar active="rates" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h2 class="fw-900 text-navy mb-1">Room Pricing & Rates</h2>
                <p class="text-muted small fw-bold mb-0">Control contracted rates (BAR) and season markups across all room categories.</p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-navy rounded-pill px-4 fw-900 shadow-sm x-small">SET SPECIAL RATES</button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white mb-4">
                    <h5 class="fw-900 text-navy mb-5 uppercase small tracking-1">Active Rate Tiers</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="x-small text-muted fw-bold uppercase border-bottom">
                                <tr>
                                    <th class="py-3">ROOM CATEGORY</th>
                                    <th class="py-3">BASE RATE (BAR)</th>
                                    <th class="py-3">AGENT NET RATE</th>
                                    <th class="py-3">LAST UPDATE</th>
                                    <th class="py-3 text-end">MODIFY</th>
                                </tr>
                            </thead>
                            <tbody class="small fw-bold">
                                <tr class="py-4">
                                    <td class="ps-4">Deluxe Pool Room</td>
                                    <td class="text-navy fw-900">₹14,500</td>
                                    <td class="text-primary fw-900">₹12,400</td>
                                    <td class="text-muted small">03 APR (13:10)</td>
                                    <td class="text-end pe-4"><button class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fas fa-pencil-alt"></i></button></td>
                                </tr>
                                <tr class="py-4">
                                    <td class="ps-4">Executive Suite</td>
                                    <td class="text-navy fw-900">₹24,500</td>
                                    <td class="text-primary fw-900">₹21,800</td>
                                    <td class="text-muted small">01 APR (10:14)</td>
                                    <td class="text-end pe-4"><button class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fas fa-pencil-alt"></i></button></td>
                                </tr>
                                <tr class="py-4">
                                    <td class="ps-4 text-warning">Luxury Villa</td>
                                    <td class="text-navy fw-900">₹42,000</td>
                                    <td class="text-primary fw-900">₹38,500</td>
                                    <td class="text-muted small">05 MAR (09:00)</td>
                                    <td class="text-end pe-4"><button class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fas fa-pencil-alt"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-primary text-white h-auto mb-4 border-start border-4 border-warning shadow-sm position-relative overflow-hidden">
                    <h6 class="fw-900 mb-4 uppercase x-small">Dynamic Markup</h6>
                    <div class="p-3 bg-white bg-opacity-10 rounded-4 mb-4">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <span class="small fw-bold opacity-75">Weekend Surge (Fixed)</span>
                            <span class="badge bg-warning text-dark fw-900">+15%</span>
                        </div>
                        <div class="progress h-1 mb-2" style="height: 4px;"><div class="progress-bar bg-warning" style="width: 15%;"></div></div>
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-4">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <span class="small fw-bold opacity-75">Seasonal Hike (Global)</span>
                            <span class="badge bg-green text-dark fw-900">+25%</span>
                        </div>
                        <div class="progress h-1 mb-2" style="height: 4px;"><div class="progress-bar bg-green" style="width: 25%;"></div></div>
                    </div>
                    <div class="bg-blur-orb-sm"></div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white h-auto mb-4">
                    <h6 class="fw-900 text-navy mb-4 uppercase x-small">Cancellation Policy</h6>
                    <p class="x-small text-muted fw-bold mb-4 italic">Standard Non-Refundable rates yield 10% more bookings annually.</p>
                    <button class="btn btn-outline-primary w-100 rounded-pill fw-bold py-3 uppercase x-small">UPDATE POLICY</button>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .bg-blur-orb-sm { position: absolute; width: 100px; height: 100px; background: rgba(255,193,7,0.2); border-radius: 50%; top: -40px; right: -40px; filter: blur(20px); }
    .btn-navy { background: #001f3f; color: #fff; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .bg-green { background: #48bb78; }
</style>
@endsection

@extends('layouts.app')

@section('content')
<div class="main-content" style="background: #f1f5f9; min-height: 100vh; padding-top: 50px;">
    <div class="container px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-900 text-navy">Cargo Pricing Rules</h3>
            <a href="{{ route('admin.cargo.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">Back to Bookings</a>
        </div>

        <div class="row g-4">
            <!-- Add Rate -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-800 text-navy mb-4">New Pricing Rule</h5>
                    <form action="{{ route('admin.cargo.rates.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">ORIGIN CITY/REGION</label>
                            <input type="text" name="origin" class="form-control bg-light border-0 py-2 px-3 fw-bold" placeholder="e.g. Delhi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">DESTINATION CITY/REGION</label>
                            <input type="text" name="destination" class="form-control bg-light border-0 py-2 px-3 fw-bold" placeholder="e.g. Dubai" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">BASE FEE</label>
                                <input type="number" name="base_fee" class="form-control bg-light border-0 py-2 px-3 fw-bold" value="500">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">RATE PER KG</label>
                                <input type="number" name="rate_per_kg" class="form-control bg-light border-0 py-2 px-3 fw-bold" placeholder="150" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">EXPRESS MULTIPLIER</label>
                            <input type="number" step="0.1" name="express_multiplier" class="form-control bg-light border-0 py-2 px-3 fw-bold" value="1.5">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Save Pricing Rule</button>
                    </form>
                </div>
            </div>

            <!-- Rates List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-uppercase x-small fw-800 text-muted">
                                    <th class="ps-4">Origin → Destination</th>
                                    <th>Base Fee</th>
                                    <th>Rate/KG</th>
                                    <th>Express</th>
                                    <th class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rates as $r)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-navy">{{ $r->origin }} → {{ $r->destination }}</div>
                                    </td>
                                    <td>₹{{ number_format($r->base_fee) }}</td>
                                    <td class="fw-bold text-primary">₹{{ number_format($r->rate_per_kg) }}</td>
                                    <td>{{ $r->express_multiplier }}x</td>
                                    <td class="text-end pe-4">
                                        @if($r->is_active)
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">ACTIVE</span>
                                        @else
                                            <span class="badge bg-light text-muted px-3 py-2 rounded-pill">INACTIVE</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #0f172a; }
    .fw-800 { font-weight: 800; }
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
</style>
@endsection

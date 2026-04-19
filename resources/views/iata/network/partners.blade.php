@extends('layouts.iata_panel')

@section('title', 'My Partners | IATA Collaboration')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-800 text-navy mb-0 outfit">Approved Partner Network</h4>
        <button class="btn btn-iata rounded-pill px-4 fw-800" data-bs-toggle="modal" data-bs-target="#commissionModal">
            <i class="fas fa-percentage me-2"></i> Global Commission Setup
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white border border-light overflow-hidden">
        <div class="table-responsive">
            <table class="table table-premium mb-0">
                <thead>
                    <tr>
                        <th>Partner Agent</th>
                        <th>IATA ID</th>
                        <th>Connection Date</th>
                        <th>Tickets (MTD)</th>
                        <th>Current Profit Split</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $partners = [
                        ['name' => 'Swift Wings India', 'id' => 'IATA-440292', 'date' => '02 Apr 2024', 'tkts' => '24', 'split' => '60% (Me) / 40% (Partner)'],
                        ['name' => 'Royal Emirates Travel', 'id' => 'IATA-880112', 'date' => '28 Mar 2024', 'tkts' => '12', 'split' => '₹500 Fixed/Ticket'],
                        ['name' => 'Singapore High-Flyers', 'id' => 'IATA-110022', 'date' => '05 Apr 2024', 'tkts' => '8', 'split' => '50% / 50%'],
                    ];
                    @endphp
                    @foreach($partners as $p)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar bg-blue-soft rounded-circle d-flex align-items-center justify-content-center fw-800" style="width: 36px; height: 36px; font-size: 12px;">{{ substr($p['name'], 0, 1) }}</div>
                                <div class="fw-800 text-navy">{{ $p['name'] }}</div>
                            </div>
                        </td>
                        <td><span class="fw-700 text-primary">{{ $p['id'] }}</span></td>
                        <td class="small fw-700 text-muted">{{ $p['date'] }}</td>
                        <td><span class="badge bg-light text-navy border fw-800 px-3">{{ $p['tkts'] }}</span></td>
                        <td><span class="fw-900 text-success outfit">{{ $p['split'] }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-light btn-sm fw-800 border-0 rounded-pill px-3 me-1" title="Setup Commission"><i class="fas fa-cog me-1"></i> Setup</button>
                            <button class="btn btn-light btn-sm fw-800 border-0 rounded-pill px-3" title="View Bookings"><i class="fas fa-eye me-1"></i> Bookings</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Commission Setup Modal -->
<div class="modal fade" id="commissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-800 text-navy outfit">Setup Commission Split</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <p class="text-muted small fw-600 mb-4">Define how profits will be shared for bookings issued via your system by partner agents.</p>
                
                <form>
                    <div class="mb-4">
                        <label class="form-label small fw-800 text-muted uppercase">Split Method</label>
                        <div class="d-flex gap-3">
                            <div class="form-check card-select flex-grow-1 p-3 border rounded-3 position-relative">
                                <input class="form-check-input stretched-link" type="radio" name="splitType" id="typePercent" checked>
                                <label class="form-check-label fw-800 ms-1" for="typePercent">Percentage (%)</label>
                            </div>
                            <div class="form-check card-select flex-grow-1 p-3 border rounded-3 position-relative">
                                <input class="form-check-input stretched-link" type="radio" name="splitType" id="typeFixed">
                                <label class="form-check-label fw-800 ms-1" for="typeFixed">Fixed Amount</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label small fw-800 text-muted uppercase">Your Share</label>
                            <div class="input-group">
                                <input type="number" class="form-control border-0 bg-light py-2 fw-800" value="60">
                                <span class="input-group-text bg-light border-0 fw-800">%</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-800 text-muted uppercase">Partner Share</label>
                            <div class="input-group">
                                <input type="number" class="form-control border-0 bg-light py-2 fw-800" value="40">
                                <span class="input-group-text bg-light border-0 fw-800">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 small fw-700 d-flex gap-3">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>Profits are calculated as: <br><span class="text-navy fw-800">Markup + Airline Commission</span></div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="button" class="btn btn-iata py-3 fw-800 outfit" data-bs-dismiss="modal">SAVE COMMISSION RULES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-blue-soft { background-color: #eff6ff; color: #1e40af; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .card-select:hover { border-color: var(--iata-blue) !important; background: #f8fafc; }
    .card-select .form-check-input:checked ~ label { color: var(--iata-blue); }
</style>
@endsection

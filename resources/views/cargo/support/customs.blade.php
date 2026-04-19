@extends('layouts.user_dashboard')

@section('title', 'Customs Clearance | TripZant Cargo')

@section('content')
<div class="container-fluid py-4 min-vh-100" style="background-color: #f8f9fa;">
    <!-- Government / Border Shield Style Header -->
    <div class="row mb-5">
        <div class="col-12 bg-dark text-white p-5 rounded-4 shadow-lg position-relative overflow-hidden">
            <div class="d-md-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                <div>
                    <h2 class="fw-bold mb-1"><i class="fas fa-shield-alt text-warning me-2"></i> Border Customs & Compliance</h2>
                    <p class="opacity-75 mb-0 small">Module 4: Institutional Clearance Management - International Trade Monitoring</p>
                </div>
                <div class="text-md-end mt-3 mt-md-0">
                    <span class="badge bg-warning text-dark px-4 py-2 rounded-pill fw-bold">OFFICIAL PORTAL</span>
                </div>
            </div>
            <!-- Decorative Shield Icon Background -->
            <i class="fas fa-landmark position-absolute end-0 bottom-0 opacity-10" style="font-size: 15rem; transform: translate(20%, 20%); z-index: 1;"></i>
        </div>
    </div>

    <div class="row g-4">
        <!-- Clearance Queue -->
        <div class="col-xl-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h5 class="mb-0 fw-bold">Compliance Review Queue</h5>
                    <div class="btn-group">
                        <button class="btn btn-outline-dark btn-sm active">Awaiting Review</button>
                        <button class="btn btn-outline-dark btn-sm">Released</button>
                        <button class="btn btn-outline-dark btn-sm">Held / Seized</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small fw-bold text-muted">
                            <tr>
                                <th class="ps-4">Declaration Ref</th>
                                <th>Category</th>
                                <th>Item Value</th>
                                <th>Compliance Check</th>
                                <th class="text-end pe-4">Decision</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($declarations as $d)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">{{ $d->booking_ref }}</span><br>
                                    <small class="text-muted italic">{{ $d->origin_country }} → {{ $d->destination_country }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-navy">{{ $d->customs->category ?? 'Unknown' }}</span>
                                </td>
                                <td>
                                    <h6 class="mb-0 fw-bold text-success">${{ number_format($d->customs->declared_value ?? 0, 2) }}</h6>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($d->customs->no_dangerous_goods ?? false)
                                            <span class="badge bg-soft-success text-success"><i class="fas fa-check me-1"></i> No Danger Goods</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Check Goods</span>
                                        @endif
                                        <button class="btn btn-link btn-sm p-0 m-0 text-decoration-none small text-primary fw-bold" onclick="viewDocs('{{ $d->booking_ref }}')">View Docs</button>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-success rounded-pill px-3 shadow-none fw-bold" onclick="clearCustoms('{{ $d->booking_ref }}')">Release</button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-none fw-bold" onclick="holdCustoms('{{ $d->booking_ref }}')">Hold</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted small italic">Queue empty. All declarations cleared.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Activity Panel -->
        <div class="col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <h1 class="fw-bold text-dark mb-1">{{ $declarations->count() }}</h1>
                    <small class="text-muted text-uppercase fw-bold letter-spacing-1">Pending Clearance</small>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span>Released Today</span>
                        <span class="fw-bold text-dark">42</span>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mb-4">
                        <span>Audit Rate</span>
                        <span class="fw-bold text-success">98.5%</span>
                    </div>
                    <button class="btn btn-dark w-100 rounded-pill py-2 small fw-bold">Download Daily Log</button>
                </div>
            </div>

            <div class="card bg-gradient-dark text-white border-0 shadow-sm rounded-4 overlay p-4 overflow-hidden">
                <div class="position-relative" style="z-index: 2;">
                    <h6 class="fw-bold mb-2">Audit Compliance</h6>
                    <p class="small opacity-75 mb-3">Ensure all digital signatures and category declarations match the provided invoice documents.</p>
                    <i class="fas fa-fingerprint fa-2x opacity-50"></i>
                </div>
                <div class="position-absolute end-0 bottom-0 opacity-10" style="font-size: 5rem;">
                    <i class="fas fa-file-contract"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function clearCustoms(ref) {
        Swal.fire({
            title: 'Release Shipment #'+ref+'?',
            text: 'System will update record to "In Transit" and notify the user.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Approve & Release'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('cargo.support.status') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ booking_ref: ref, status: 'In Transit', description: 'Customs clearance completed. Released for final transit.' })
                })
                .then(res => res.json())
                .then(() => {
                    Swal.fire('Released!', 'Shipment has been cleared by border control.', 'success').then(() => location.reload());
                });
            }
        });
    }

    function holdCustoms(ref) {
        Swal.fire({
            title: 'Hold for Audit?',
            input: 'text',
            inputPlaceholder: 'Reason for hold (e.g. Valuation mismatch)',
            icon: 'warning',
            showCancelButton: true
        }).then(result => {
             if(result.isConfirmed) {
                fetch('{{ route('cargo.support.status') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ booking_ref: ref, status: 'Customs', description: 'Held for audit: ' + result.value })
                })
                .then(res => res.json())
                .then(() => location.reload());
             }
        });
    }

    function viewDocs(ref) {
        Swal.fire({
            title: 'Declaration Documents',
            html: '<b>Category:</b> Personal Effects<br><b>Signature:</b> SECURE_VERIFIED<br><b>Value:</b> Authenticated',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Invoice Placeholder',
        })
    }
</script>

<style>
    .bg-gradient-dark { background: linear-gradient(135deg, #1e293b, #0f172a); }
    .bg-soft-success { background: rgba(28, 200, 138, 0.1); }
    .bg-soft-danger { background: rgba(231, 74, 59, 0.1); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .text-navy { color: #0f172a; }
</style>
@endsection

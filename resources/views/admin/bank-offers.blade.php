@extends('layouts.admin')
@section('title', 'Bank Offers | Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-900 text-navy mb-1"><i class="fas fa-credit-card me-2 text-primary"></i> Bank Offers Manager</h3>
        <p class="text-muted small mb-0">Create and manage credit/debit card discount offers shown on the flight listing page.</p>
    </div>
    <button class="btn btn-admin-primary" onclick="openOfferModal()">
        <i class="fas fa-plus me-2"></i> Add New Offer
    </button>
</div>

<!-- Offer Cards Grid -->
<div class="row g-4" id="offerGrid">
    @forelse($offers as $offer)
    <div class="col-md-4" id="offer-card-{{ $offer->id }}">
        <div class="card-admin h-100 position-relative" style="border-left: 5px solid {{ $offer->color_code }};border-radius:16px;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center gap-3">
                    @if($offer->logo)
                        <img src="{{ $offer->logo }}" alt="{{ $offer->bank_name }}" style="width:48px;height:48px;object-fit:contain;border-radius:10px;border:1px solid #e2e8f0;">
                    @else
                        <div class="rounded-3 d-flex align-items-center justify-content-center fw-900 fs-5 text-white" style="width:48px;height:48px;background:{{ $offer->color_code }};">
                            {{ strtoupper(substr($offer->bank_name, 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <h6 class="fw-900 mb-0 text-navy">{{ $offer->display_name }}</h6>
                        <span class="text-muted x-small fw-700">{{ $offer->bank_name }}</span>
                    </div>
                </div>
                <div class="form-check form-switch ms-2 mt-1">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="toggle-{{ $offer->id }}"
                           {{ $offer->is_active ? 'checked' : '' }}
                           onchange="toggleOffer({{ $offer->id }}, this)">
                </div>
            </div>

            <div class="p-3 rounded-3 mb-3" style="background:{{ $offer->color_code }}15;">
                <div class="fw-900 text-navy fs-4">
                    @if($offer->discount_type === 'percentage')
                        {{ $offer->discount_value }}% OFF
                    @else
                        ₹{{ number_format($offer->discount_value) }} OFF
                    @endif
                </div>
                @if($offer->tagline)
                    <div class="text-muted small fw-700">{{ $offer->tagline }}</div>
                @endif
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                @if($offer->promo_code)
                <span class="badge rounded-pill fw-800" style="background:{{ $offer->color_code }}20;color:{{ $offer->color_code }};font-size:11px;">
                    <i class="fas fa-tag me-1"></i>{{ $offer->promo_code }}
                </span>
                @endif
                @if($offer->max_discount)
                <span class="badge bg-light text-dark fw-700" style="font-size:11px;">Max ₹{{ number_format($offer->max_discount) }}</span>
                @endif
                @if($offer->min_amount)
                <span class="badge bg-light text-dark fw-700" style="font-size:11px;">Min ₹{{ number_format($offer->min_amount) }}</span>
                @endif
            </div>

            <div class="d-flex gap-2 mt-auto">
                <button class="btn btn-sm btn-outline-primary rounded-pill fw-800 flex-grow-1"
                        onclick='openOfferModal(@json($offer))'>
                    <i class="fas fa-edit me-1"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-danger rounded-pill fw-800"
                        onclick="deleteOffer({{ $offer->id }})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted" id="emptyState">
        <i class="fas fa-credit-card fa-3x mb-3 opacity-25"></i>
        <h5 class="fw-800">No Bank Offers Yet</h5>
        <p class="small">Click "Add New Offer" to create the first bank offer.</p>
    </div>
    @endforelse
</div>

<!-- Create/Edit Modal -->
<div class="modal fade" id="offerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 p-4" style="background:#0b3d61;">
                <h5 class="modal-title fw-900 text-white mb-0" id="offerModalTitle">
                    <i class="fas fa-credit-card me-2"></i> Add Bank Offer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="offerForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="offerId" name="_offer_id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-800 text-muted small uppercase">Bank Name (key) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" name="bank_name" id="f_bank_name" placeholder="e.g. HDFC, SBI, ICICI" required>
                            <div class="form-text">Used internally for filtering — no spaces recommended.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-800 text-muted small uppercase">Display Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" name="display_name" id="f_display_name" placeholder="e.g. HDFC Credit Card" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-800 text-muted small uppercase">Promo Code</label>
                            <input type="text" class="form-control rounded-3" name="promo_code" id="f_promo_code" placeholder="e.g. HDFC500">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-800 text-muted small uppercase">Brand Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color rounded-start-3" name="color_code" id="f_color_code" value="#0b3d61" style="width:60px;">
                                <input type="text" class="form-control rounded-end-3" id="f_color_text" value="#0b3d61" oninput="document.getElementById('f_color_code').value=this.value">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-800 text-muted small uppercase">Tagline</label>
                            <input type="text" class="form-control rounded-3" name="tagline" id="f_tagline" placeholder="e.g. Save up to ₹1500 on HDFC Credit Cards">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-800 text-muted small uppercase">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" name="discount_type" id="f_discount_type" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (₹)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-800 text-muted small uppercase">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" class="form-control rounded-3" name="discount_value" id="f_discount_value" placeholder="e.g. 10 or 500" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-800 text-muted small uppercase">Max Discount (₹)</label>
                            <input type="number" class="form-control rounded-3" name="max_discount" id="f_max_discount" placeholder="e.g. 1500">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-800 text-muted small uppercase">Min Booking Amount (₹)</label>
                            <input type="number" class="form-control rounded-3" name="min_amount" id="f_min_amount" placeholder="e.g. 3000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-800 text-muted small uppercase">Sort Order</label>
                            <input type="number" class="form-control rounded-3" name="sort_order" id="f_sort_order" value="0">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="f_is_active" name="is_active" checked>
                                <label class="form-check-label fw-800" for="f_is_active">Active</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-800 text-muted small uppercase">Bank Logo</label>
                            <input type="file" class="form-control rounded-3" name="logo" id="f_logo" accept="image/*">
                            <div class="form-text">PNG/SVG recommended. Leave blank to use initials.</div>
                            <div id="logoPreview" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-800" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-primary rounded-pill px-5 fw-900" id="offerSubmitBtn">
                        <i class="fas fa-save me-2"></i> Save Offer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ── Bootstrap Modal init (after DOM + Bootstrap JS are ready) ──────────────
let offerModal;
document.addEventListener('DOMContentLoaded', function () {
    offerModal = new bootstrap.Modal(document.getElementById('offerModal'));

    document.getElementById('f_color_code').addEventListener('input', function () {
        document.getElementById('f_color_text').value = this.value;
    });

    document.getElementById('f_logo').addEventListener('change', function () {
        const preview = document.getElementById('logoPreview');
        if (this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => preview.innerHTML =
                `<img src="${e.target.result}" style="height:40px;object-fit:contain;border-radius:8px;border:1px solid #e2e8f0;">`;
            reader.readAsDataURL(this.files[0]);
        }
    });

    document.getElementById('offerForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const btn = document.getElementById('offerSubmitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';

        const formData = new FormData(this);
        const id  = document.getElementById('offerId').value;
        const url = id ? `/admin/bank-offers/${id}` : '/admin/bank-offers';
        if (id) formData.append('_method', 'PUT');

        try {
            const res  = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                offerModal.hide();
                await Swal.fire({ icon: 'success', title: 'Saved!', text: data.message, timer: 2000, showConfirmButton: false });
                location.reload();
            } else {
                throw new Error(data.message || 'Error saving offer.');
            }
        } catch (err) {
            Swal.fire('Error', err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save me-2"></i> Save Offer';
        }
    });
});

// ── Global functions called from onclick="" attributes ─────────────────────
function openOfferModal(offer) {
    offer = offer || null;
    document.getElementById('offerForm').reset();
    document.getElementById('logoPreview').innerHTML = '';
    document.getElementById('f_color_code').value = '#0b3d61';
    document.getElementById('f_color_text').value = '#0b3d61';
    document.getElementById('offerModalTitle').innerHTML = '<i class="fas fa-credit-card me-2"></i> Add Bank Offer';
    document.getElementById('offerId').value = '';

    if (offer) {
        document.getElementById('offerModalTitle').innerHTML   = '<i class="fas fa-edit me-2"></i> Edit Bank Offer';
        document.getElementById('offerId').value               = offer.id;
        document.getElementById('f_bank_name').value           = offer.bank_name      || '';
        document.getElementById('f_display_name').value        = offer.display_name   || '';
        document.getElementById('f_promo_code').value          = offer.promo_code     || '';
        document.getElementById('f_tagline').value             = offer.tagline        || '';
        document.getElementById('f_color_code').value          = offer.color_code     || '#0b3d61';
        document.getElementById('f_color_text').value          = offer.color_code     || '#0b3d61';
        document.getElementById('f_discount_type').value       = offer.discount_type  || 'percentage';
        document.getElementById('f_discount_value').value      = offer.discount_value || '';
        document.getElementById('f_max_discount').value        = offer.max_discount   || '';
        document.getElementById('f_min_amount').value          = offer.min_amount     || '';
        document.getElementById('f_sort_order').value          = offer.sort_order     || 0;
        document.getElementById('f_is_active').checked         = (offer.is_active == 1 || offer.is_active === true);
        if (offer.logo) {
            document.getElementById('logoPreview').innerHTML =
                `<img src="${offer.logo}" style="height:40px;object-fit:contain;border-radius:8px;border:1px solid #e2e8f0;">`;
        }
    }
    offerModal.show();
}

async function toggleOffer(id, checkbox) {
    try {
        const res  = await fetch(`/admin/bank-offers/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        });
        const data = await res.json();
        if (!data.success) checkbox.checked = !checkbox.checked;
    } catch {
        checkbox.checked = !checkbox.checked;
    }
}

async function deleteOffer(id) {
    const result = await Swal.fire({
        title: 'Delete Offer?',
        text:  'This will remove the offer from the frontend immediately.',
        icon:  'warning',
        showCancelButton:   true,
        confirmButtonText:  'Yes, Delete',
        confirmButtonColor: '#dc3545'
    });
    if (!result.isConfirmed) return;

    const res  = await fetch(`/admin/bank-offers/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const data = await res.json();
    if (data.success) {
        document.getElementById(`offer-card-${id}`)?.remove();
        Swal.fire({ icon: 'success', title: 'Deleted!', timer: 1500, showConfirmButton: false });
    }
}
</script>
@endpush
@endsection

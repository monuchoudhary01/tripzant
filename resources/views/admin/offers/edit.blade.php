@extends('layouts.admin')

@section('title', 'Edit Offer | Trip Zant Admin')

@section('admin_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.offers.index') }}">Offers</a></li>
                    <li class="breadcrumb-item active">Edit Offer</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Edit Campaign: <span class="text-primary">{{ $offer->title }}</span></h4>
                <a href="{{ route('admin.offers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                    <i class="bx bx-left-arrow-alt me-1"></i> Back to List
                </a>
            </div>

            <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Left Column: Basic Info -->
                    <div class="col-lg-7">
                        <div class="card-sneat border-0 shadow-sm mb-4">
                            <div class="card-header border-bottom">
                                <h5 class="card-title mb-0 fw-bold"><i class="bx bx-info-circle me-2 text-primary"></i> General Information</h5>
                            </div>
                            <div class="card-body pt-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Offer Headline <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control form-control-lg border-2" value="{{ $offer->title }}" required />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Offer Description</label>
                                    <textarea name="description" class="form-control border-2" rows="4">{{ $offer->description }}</textarea>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                        <select name="category" class="form-select border-2" id="categorySelect" required onchange="toggleBankFields()">
                                            @foreach(['Flights', 'Hotels', 'Homestays', 'Cabs', 'Trains', 'Holidays', 'Insurance', 'eSIM', 'Bank Offer', 'General'] as $cat)
                                                <option value="{{ $cat }}" {{ $offer->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Display Priority</label>
                                        <input type="number" name="sort_order" class="form-control border-2" value="{{ $offer->sort_order }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Specific Fields -->
                        <div id="bankFields" class="card-sneat border-0 shadow-sm mb-4 border-start border-warning border-5" style="display: {{ $offer->category == 'Bank Offer' ? 'block' : 'none' }};">
                            <div class="card-header border-bottom">
                                <h5 class="card-title mb-0 fw-bold"><i class="bx bxs-bank me-2 text-warning"></i> Bank Discount Configuration</h5>
                            </div>
                            <div class="card-body pt-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Partner Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control border-2" value="{{ $offer->bank_name }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Applicable Cards</label>
                                        <input type="text" name="card_type" class="form-control border-2" value="{{ $offer->card_type }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Min Transaction Value (₹)</label>
                                        <input type="number" name="min_amount" class="form-control border-2" value="{{ $offer->min_amount }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Max Discount (₹)</label>
                                        <input type="number" name="max_discount" class="form-control border-2" value="{{ $offer->max_discount }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Valid Until</label>
                                        <input type="date" name="valid_till" class="form-control border-2" value="{{ $offer->valid_till }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Media & Actions -->
                    <div class="col-lg-5">
                        <div class="card-sneat border-0 shadow-sm mb-4">
                            <div class="card-header border-bottom">
                                <h5 class="card-title mb-0 fw-bold"><i class="bx bx-image-alt me-2 text-success"></i> Visuals & Links</h5>
                            </div>
                            <div class="card-body pt-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Banner Image</label>
                                    
                                    <!-- Toggle Between URL and Upload -->
                                    <ul class="nav nav-pills mb-3" id="imageMethodTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active btn-sm py-1" id="url-tab" data-bs-toggle="pill" data-bs-target="#url-method" type="button" role="tab">Image URL</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-sm py-1 ms-2" id="upload-tab" data-bs-toggle="pill" data-bs-target="#upload-method" type="button" role="tab">Upload File</button>
                                        </li>
                                    </ul>
                                    
                                    <div class="tab-content p-0 border-0 shadow-none">
                                        <div class="tab-pane fade show active" id="url-method" role="tabpanel">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-2"><i class="bx bx-link"></i></span>
                                                <input type="text" name="image_url" id="imageInput" class="form-control border-2" value="{{ $offer->image_url }}" onchange="previewImage(this.value)" />
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="upload-method" role="tabpanel">
                                            <input type="file" name="image_file" class="form-control border-2" accept="image/*" onchange="previewFile(this)" />
                                        </div>
                                    </div>

                                    <div id="imagePreviewContainer" class="mt-3 text-center">
                                        <img id="imagePreview" src="{{ $offer->image_url }}" class="img-fluid rounded-3 shadow-sm border border-light" style="max-height: 200px;" />
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Redirection URL</label>
                                    <input type="text" name="link_url" class="form-control border-2" value="{{ $offer->link_url }}" />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Promo Code</label>
                                    <input type="text" name="promo_code" class="form-control border-2 border-dashed text-center fw-bold text-uppercase" value="{{ $offer->promo_code }}" style="background: #f8fafc;" />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Brand Color Code</label>
                                    <div class="input-group">
                                        <input type="color" name="color_code" class="form-control form-control-color border-2" value="{{ $offer->color_code ?: '#696cff' }}" title="Choose brand color">
                                        <input type="text" class="form-control border-2 ms-2" value="{{ $offer->color_code }}" placeholder="#000000" oninput="this.previousElementSibling.value = this.value">
                                    </div>
                                    <small class="text-muted">Accent color for bank logos or badges.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Discount Label Text</label>
                                    <input type="text" name="discount_text" class="form-control border-2" value="{{ $offer->discount_text }}" />
                                </div>
                            </div>
                        </div>

                        <div class="card-sneat border-0 shadow-sm bg-label-primary">
                            <div class="card-body p-4 text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow rounded-pill fw-bold">
                                    <i class="bx bx-save me-2"></i> Update Campaign
                                </button>
                                <p class="mt-3 mb-0 small opacity-75 text-dark">Changes will be reflected immediately on the homepage.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus { border-color: var(--sneat-primary); box-shadow: 0 0 0 0.125rem rgba(105, 108, 255, 0.15); }
    .border-2 { border-width: 1.5px !important; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
</style>

<script>
    function toggleBankFields() {
        const category = document.getElementById('categorySelect').value;
        const bankFields = document.getElementById('bankFields');
        bankFields.style.display = (category === 'Bank Offer') ? 'block' : 'none';
    }

    function previewFile(input) {
        const container = document.getElementById('imagePreviewContainer');
        const img = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewImage(url) {
        const img = document.getElementById('imagePreview');
        if(url) {
            img.src = url;
        }
    }
</script>
@endsection

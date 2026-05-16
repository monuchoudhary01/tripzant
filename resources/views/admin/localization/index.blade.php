@extends('layouts.admin')

@section('title', 'Localization Management')

@section('admin_content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-900 text-navy">Localization & Settings</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <ul class="nav nav-pills mb-4" id="localization-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill px-4 fw-bold" data-bs-toggle="pill" data-bs-target="#translations" type="button"><i class="fas fa-language me-2"></i> Translation Strings</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-bold" data-bs-toggle="pill" data-bs-target="#countries" type="button"><i class="fas fa-globe-americas me-2"></i> Countries</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-bold" data-bs-toggle="pill" data-bs-target="#currencies" type="button"><i class="fas fa-money-bill-wave me-2"></i> Currencies</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-bold" data-bs-toggle="pill" data-bs-target="#languages" type="button"><i class="fas fa-font me-2"></i> Languages</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        <!-- TRANSLATIONS TAB -->
        <div class="tab-pane fade show active" id="translations" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-navy mb-0">Manage Translation Strings</h5>
                    <button class="btn btn-navy rounded-pill btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#translationModal">
                        <i class="fas fa-plus"></i> Add Key
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Group</th>
                                    <th>Key</th>
                                    <th>Translations (JSON)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($translations as $trans)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $trans->group }}</span></td>
                                    <td class="fw-bold">{{ $trans->key }}</td>
                                    <td>
                                        <pre class="mb-0 small bg-light p-2 rounded"><code>{{ json_encode($trans->text, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary rounded-pill edit-trans-btn" 
                                                data-id="{{ $trans->id }}"
                                                data-group="{{ $trans->group }}"
                                                data-key="{{ $trans->key }}"
                                                data-text="{{ json_encode($trans->text) }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.localization.translations.destroy', $trans->id) }}" method="POST" onsubmit="return confirm('Delete this translation?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-language fa-3x mb-3 text-light"></i>
                                        <h5>No translations found</h5>
                                        <p>Start adding keys to manage multi-language support dynamically.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($translations->hasPages())
                        <div class="mt-3">{{ $translations->links() }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- COUNTRIES TAB -->
        <div class="tab-pane fade" id="countries" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-navy mb-0">Active Countries / Regions</h5>
                    <button class="btn btn-navy rounded-pill btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#countryModal">
                        <i class="fas fa-plus"></i> Add Country
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ISO Code</th>
                                    <th>Name</th>
                                    <th>Default Currency</th>
                                    <th>Timezone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($countries as $country)
                                <tr>
                                    <td class="fw-bold"><img src="https://flagcdn.com/24x18/{{ strtolower($country->iso_code) }}.png" class="me-2 rounded-1">{{ $country->iso_code }}</td>
                                    <td>{{ $country->name }}</td>
                                    <td><span class="badge bg-primary">{{ $country->currency_code }}</span></td>
                                    <td><small>{{ $country->timezone }}</small></td>
                                    <td>{!! $country->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                    <td>
                                        <form action="{{ route('admin.localization.countries.destroy', $country->id) }}" method="POST" onsubmit="return confirm('Delete this country?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- CURRENCIES TAB -->
        <div class="tab-pane fade" id="currencies" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-navy mb-0">Supported Currencies</h5>
                    <button class="btn btn-navy rounded-pill btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#currencyModal">
                        <i class="fas fa-plus"></i> Add Currency
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Symbol</th>
                                    <th>Exchange Rate (Base AUD)</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($currencies as $curr)
                                <tr>
                                    <td class="fw-bold">{{ $curr->code }}</td>
                                    <td><h5><span class="badge bg-light text-dark border">{{ $curr->symbol }}</span></h5></td>
                                    <td>{{ number_format($curr->exchange_rate, 6) }}</td>
                                    <td>{!! $curr->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                    <td>
                                        <form action="{{ route('admin.localization.currencies.destroy', $curr->id) }}" method="POST" onsubmit="return confirm('Delete this currency?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- LANGUAGES TAB -->
        <div class="tab-pane fade" id="languages" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-navy mb-0">Supported Languages</h5>
                    <button class="btn btn-navy rounded-pill btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#languageModal">
                        <i class="fas fa-plus"></i> Add Language
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages as $lang)
                                <tr>
                                    <td class="fw-bold">{{ $lang->code }}</td>
                                    <td>{{ $lang->name }}</td>
                                    <td>{!! $lang->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                    <td>
                                        <form action="{{ route('admin.localization.languages.destroy', $lang->id) }}" method="POST" onsubmit="return confirm('Delete this language?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-trash"></i></button>
                                        </form>
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

<!-- ================= MODALS ================= -->

<!-- Translation Modal -->
<div class="modal fade" id="translationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content border-0 shadow" action="{{ route('admin.localization.translations.store') }}" method="POST" id="transForm">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Manage Translation</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Group (e.g., 'home', 'validation')</label>
                        <input type="text" name="group" class="form-control" required id="transGroup">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Key (e.g., 'welcome_message')</label>
                        <input type="text" name="key" class="form-control" required id="transKey">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold mb-0">Translations per Language</label>
                        <p class="small text-muted mb-2">Fill in the translation for each supported language.</p>
                        
                        <div id="languageInputs">
                            @foreach($languages as $lang)
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold" style="width:60px;">{{ strtoupper($lang->code) }}</span>
                                <input type="text" name="text[{{ $lang->code }}]" class="form-control trans-input" placeholder="{{ $lang->name }} translation">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill">Save Translation</button>
            </div>
        </form>
    </div>
</div>

<!-- Country Modal -->
<div class="modal fade" id="countryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow" action="{{ route('admin.localization.countries.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add / Edit Country</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">ISO Code (e.g., IN, US)</label>
                    <input type="text" name="iso_code" class="form-control" required maxlength="2" style="text-transform: uppercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Country Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Default Currency Code</label>
                    <input type="text" name="currency_code" class="form-control" required maxlength="3" style="text-transform: uppercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Default Timezone</label>
                    <input type="text" name="timezone" class="form-control" required placeholder="Asia/Kolkata">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary rounded-pill w-100">Save Country</button>
            </div>
        </form>
    </div>
</div>

<!-- Currency Modal -->
<div class="modal fade" id="currencyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow" action="{{ route('admin.localization.currencies.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add / Edit Currency</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Currency Code (e.g., INR, USD)</label>
                    <input type="text" name="code" class="form-control" required maxlength="3" style="text-transform: uppercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Symbol (e.g., ₹, $)</label>
                    <input type="text" name="symbol" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Exchange Rate (vs Base AUD)</label>
                    <input type="number" step="0.000001" name="exchange_rate" class="form-control" required placeholder="1.000000">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary rounded-pill w-100">Save Currency</button>
            </div>
        </form>
    </div>
</div>

<!-- Language Modal -->
<div class="modal fade" id="languageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow" action="{{ route('admin.localization.languages.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add / Edit Language</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Language Code (e.g., en, hi)</label>
                    <input type="text" name="code" class="form-control" required maxlength="2" style="text-transform: lowercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Native Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="English, Hindi (हिंदी)">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary rounded-pill w-100">Save Language</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Translation Edit button populator
        const editBtns = document.querySelectorAll('.edit-trans-btn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const group = this.dataset.group;
                const key = this.dataset.key;
                const textObj = JSON.parse(this.dataset.text);

                document.getElementById('transGroup').value = group;
                document.getElementById('transKey').value = key;

                // Reset inputs
                document.querySelectorAll('.trans-input').forEach(input => input.value = '');
                
                // Populate existing translations
                for(let langCode in textObj) {
                    const input = document.querySelector(`input[name="text[${langCode}]"]`);
                    if(input) {
                        input.value = textObj[langCode];
                    }
                }

                new bootstrap.Modal(document.getElementById('translationModal')).show();
            });
        });
    });
</script>
@endpush

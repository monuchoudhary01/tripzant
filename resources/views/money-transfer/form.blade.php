@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-navy p-4 text-white">
                        <h4 class="mb-1 fw-bold">Recipient Details</h4>
                        <p class="mb-0 opacity-50">Transferring via {{ ucfirst($providerSlug) }}</p>
                    </div>
                    <div class="card-body p-5">
                        <form id="transferForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="provider_slug" value="{{ $providerSlug }}">
                            
                            <!-- Transfer Mode -->
                            <div class="mb-5">
                                <label class="form-label fw-bold mb-3">Transfer Type</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="type" id="type_w2w" value="wallet_to_wallet" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary w-100 p-4 rounded-4" for="type_w2w">
                                            <i class="fas fa-wallet fa-2x d-block mb-2"></i>
                                            <div class="fw-bold">Internal</div>
                                            <small class="opacity-75">Wallet to Wallet</small>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="type" id="type_bank" value="wallet_to_bank" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 p-4 rounded-4" for="type_bank">
                                            <i class="fas fa-university fa-2x d-block mb-2"></i>
                                            <div class="fw-bold">Bank</div>
                                            <small class="opacity-75">External Transfer</small>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="type" id="type_intl" value="international" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 p-4 rounded-4" for="type_intl">
                                            <i class="fas fa-globe fa-2x d-block mb-2"></i>
                                            <div class="fw-bold">International</div>
                                            <small class="opacity-75">Worldwide Swift/ACH</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Sections -->
                            <div id="recipient_section">
                                <h5 class="fw-bold mb-4 border-bottom pb-2">Recipient Info</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">FULL NAME</label>
                                        <input type="text" name="recipient_details[name]" class="form-control form-control-lg border-0 bg-light" placeholder="e.g. John Doe" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">PHONE NUMBER</label>
                                        <input type="text" name="recipient_details[phone]" class="form-control form-control-lg border-0 bg-light" placeholder="+91 ...">
                                    </div>
                                </div>
                                <div id="bank_details_fields" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-muted">BANK ACCOUNT NUMBER / IBAN</label>
                                            <input type="text" name="recipient_details[account_number]" class="form-control form-control-lg border-0 bg-light" placeholder="Enter bank account number">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">IFSC CODE / SWIFT / BSB</label>
                                            <input type="text" name="recipient_details[bank_code]" class="form-control form-control-lg border-0 bg-light" placeholder="Bank Branch Code">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">BANK NAME</label>
                                            <input type="text" name="recipient_details[bank_name]" class="form-control form-control-lg border-0 bg-light" placeholder="e.g. ICICI Bank, CommBank">
                                        </div>
                                    </div>
                                </div>
                                <div id="wallet_user_fields">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-muted">RECIPIENT USER ID OR EMAIL</label>
                                            <input type="text" name="recipient_details[user_identifier]" class="form-control form-control-lg border-0 bg-light" placeholder="Trip Zant Email or User ID">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="bg-light p-4 rounded-4 my-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sending Amount</span>
                                    <span class="fw-bold">1,000 AUD</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Transfer Fee</span>
                                    <span class="text-success">0.00 AUD</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Exchange Rate</span>
                                    <span class="text-muted">1 AUD = 55.42 INR</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold fs-5">Total Recipient Gets</span>
                                    <span class="fw-bold fs-5 text-primary">55,420 INR</span>
                                </div>
                            </div>

                            <button type="button" id="submitTransfer" class="btn btn-navy btn-lg w-100 py-3 rounded-3 fw-bold shadow">
                                Confirm & Transfer Now <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #0d1b3e; }
    .btn-navy { background-color: #0d1b3e; color: white; }
    .btn-navy:hover { background-color: #08122a; color: white; }
    .transition-all { transition: all 0.3s ease; }
</style>

<script>
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankFields = document.getElementById('bank_details_fields');
            const walletFields = document.getElementById('wallet_user_fields');
            if(this.value === 'wallet_to_wallet') {
                bankFields.style.display = 'none';
                walletFields.style.display = 'block';
            } else {
                bankFields.style.display = 'block';
                walletFields.style.display = 'none';
            }
        });
    });

    document.getElementById('submitTransfer').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';

        // Mocking API call for now
        setTimeout(() => {
            Swal.fire({
                title: 'Success!',
                text: 'Your money transfer has been initiated successfully.',
                icon: 'success',
                confirmButtonText: 'View Status'
            }).then(() => {
                window.location.href = "{{ route('money-transfer.index') }}";
            });
        }, 1500);
    });
</script>
@endsection

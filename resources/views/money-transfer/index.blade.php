@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold text-navy">Global Money Transfer</h1>
                <p class="lead text-muted">Send money anywhere in the world, instantly and securely.</p>
            </div>
            <div class="col-md-6 text-end">
                <div class="d-inline-flex gap-3 bg-white p-3 rounded-4 shadow-sm">
                    @foreach($wallets as $wallet)
                    <div class="text-start px-3 border-end last-child:border-0" style="border-right: 1px solid #eee">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem">{{ $wallet->currency }} Balance</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($wallet->balance, 2) }} {{ $wallet->currency }}</h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Transfer Form Card -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-5 p-5 bg-navy text-white d-flex flex-column justify-content-center">
                        <div class="mb-5">
                            <h3 class="fw-bold mb-4">Send globally, spend locally</h3>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex align-items-center">
                                    <span class="badge bg-primary rounded-circle p-2 me-3"><i class="fas fa-check"></i></span>
                                    <span>Real-time exchange rates</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <span class="badge bg-primary rounded-circle p-2 me-3"><i class="fas fa-check"></i></span>
                                    <span>No hidden fees, transparent pricing</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <span class="badge bg-primary rounded-circle p-2 me-3"><i class="fas fa-check"></i></span>
                                    <span>Transfer in minutes, not days</span>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-auto">
                            <div class="p-3 bg-white bg-opacity-10 rounded-3">
                                <small class="d-block text-white-50">Current Mid-market Rate</small>
                                <h5 class="mb-0">1 AUD = 55.42 INR <span class="text-success ms-2" style="font-size: 0.8rem">+0.05%</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 p-5 bg-white">
                        <form action="{{ route('money-transfer.comparison') }}" method="GET">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">You Send</label>
                                <div class="input-group input-group-lg bg-light rounded-3 p-1">
                                    <input type="number" name="amount" class="form-control border-0 bg-light" value="1000" id="sendAmount">
                                    <select name="from_currency" class="form-select border-0 bg-light fw-bold" style="max-width: 120px;">
                                        <option value="AUD" selected>AUD</option>
                                        <option value="USD">USD</option>
                                        <option value="INR">INR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4 position-relative text-center">
                                <div class="position-absolute top-50 start-50 translate-middle bg-white rounded-circle shadow-sm p-2" style="z-index: 1;">
                                    <i class="fas fa-exchange-alt fa-rotate-90 text-primary"></i>
                                </div>
                                <hr class="my-0">
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-bold small text-uppercase text-muted">Recipient Gets</label>
                                <div class="input-group input-group-lg bg-light rounded-3 p-1">
                                    <input type="text" id="getAmount" class="form-control border-0 bg-light fw-bold text-primary" readonly value="55,420">
                                    <select name="to_currency" class="form-select border-0 bg-light fw-bold" style="max-width: 120px;">
                                        <option value="INR" selected>INR</option>
                                        <option value="AUD">AUD</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="from_country" value="Australia">
                            <input type="hidden" name="to_country" value="India">

                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-3 fw-bold shadow">
                                Compare Providers <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <h3 class="fw-bold mb-4">Recent Transfers</h3>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Reference</th>
                            <th>Recipient</th>
                            <th>Amount</th>
                            <th>Exchange Rate</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransfers as $tx)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $tx->transfer_ref }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $tx->recipient_details['name'] ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $tx->type }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ number_format($tx->source_amount, 2) }} {{ $tx->source_currency }}</div>
                                <small class="text-success font-monospace">{{ number_format($tx->target_amount, 2) }} {{ $tx->target_currency }}</small>
                            </td>
                            <td>1 : {{ $tx->exchange_rate }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $tx->status === 'success' ? 'success' : ($tx->status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($tx->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4 text-muted small">{{ $tx->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">No recent transfers found. Start your first transfer above!</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #0d1b3e; }
    .text-navy { color: #0d1b3e; }
    .btn-primary { background-color: #00b9ff; border-color: #00b9ff; }
    .btn-primary:hover { background-color: #0098d3; border-color: #0098d3; }
    .last-child\:border-0:last-child { border-right: none !important; }
</style>

<script>
    document.getElementById('sendAmount').addEventListener('input', function(e) {
        const rate = 55.42;
        const val = e.target.value;
        document.getElementById('getAmount').value = (val * rate).toLocaleString();
    });
</script>
@endsection

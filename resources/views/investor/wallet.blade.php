@extends('layouts.app')

@section('title', "Investor Wallet - Manage Funds | Trip Zant")

@section('styles')
<style>
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .wallet-card-investor {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        border-radius: 30px; color: #fff; padding: 50px;
        position: relative; overflow: hidden;
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.2);
    }
    .fund-action-btn {
        background: #fff; color: #0f172a; border-radius: 15px; padding: 15px 30px; 
        font-weight: 900; transition: 0.3s; 
    }
    .fund-action-btn:hover { background: #1eccd1; color: #fff; transform: translateY(-3px); }
</style>
@endsection

@section('content')
<div class="py-5" style="background: #f8fafc; min-height: 95vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <a href="{{ route('investor.dashboard') }}" class="text-decoration-none small fw-bold text-muted uppercase"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
                        <h2 class="fw-900 text-navy mt-2">Capital & Wallet Management</h2>
                    </div>
                </div>

                <!-- Wallet Card -->
                <div class="wallet-card-investor mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="mb-4">
                                <h6 class="fw-900 uppercase opacity-50 mb-2">AVAILABLE FUNDING CAPITAL</h6>
                                <h1 class="display-3 fw-900 mb-0">₹5,40,250.00</h1>
                            </div>
                            <div class="d-flex gap-3">
                                <button class="fund-action-btn border-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                                    <i class="fas fa-plus-circle me-2"></i> ADD CAPITAL
                                </button>
                                <button class="btn btn-outline-light rounded-pill px-4 fw-900 small" style="border-width: 2px;">
                                    <i class="fas fa-arrow-down me-2"></i> WITHDRAW PROFITS
                                </button>
                            </div>
                        </div>
                        <div class="col-md-5 text-end d-none d-md-block">
                             <div class="p-4 bg-white bg-opacity-10 rounded-4 text-start">
                                 <h6 class="fw-900 x-small uppercase mb-3">Wallet Status</h6>
                                 <div class="d-flex justify-content-between mb-2">
                                     <span class="x-small fw-bold opacity-75 text-white">Minimum Balance</span>
                                     <span class="x-small fw-900 text-white">₹50,000</span>
                                 </div>
                                 <div class="d-flex justify-content-between">
                                     <span class="x-small fw-bold opacity-75 text-white">Daily Funding Limit</span>
                                     <span class="x-small fw-900 text-white">₹10,00,000</span>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Fund Transactions -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-900 text-navy mb-4">Capital Flow History</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">DATE</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">TRANSACTION TYPE</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">REFERENCE</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">AMOUNT</th>
                                    <th class="border-0 x-small fw-900 py-3 text-navy">WALLET BALANCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="small fw-bold">02 Apr 2026</td>
                                    <td><span class="badge bg-primary-light text-primary rounded-pill x-small px-3 fw-900">FUND ADDITION</span></td>
                                    <td class="small fw-900 text-navy">Bank Transfer #8821</td>
                                    <td class="small fw-900 text-success">+₹2,00,000</td>
                                    <td class="small fw-800">₹5,40,250</td>
                                </tr>
                                <tr>
                                    <td class="small fw-bold">01 Apr 2026</td>
                                    <td><span class="badge bg-danger-subtle text-danger rounded-pill x-small px-3 fw-900">BOOKING DEDUCTION</span></td>
                                    <td class="small fw-900 text-navy">Flight TS-FL-1284</td>
                                    <td class="small fw-900 text-danger">-₹48,500</td>
                                    <td class="small fw-800">₹3,40,250</td>
                                </tr>
                                <tr>
                                    <td class="small fw-bold">01 Apr 2026</td>
                                    <td><span class="badge bg-success-subtle text-success rounded-pill x-small px-3 fw-900">EARN CREDIT</span></td>
                                    <td class="small fw-900 text-navy">Comm (TS-FL-1284)</td>
                                    <td class="small fw-900 text-success">+₹100</td>
                                    <td class="small fw-800">₹3,40,350</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-body p-5 text-center">
                <div class="icon-box-lg mx-auto mb-4 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-landmark fs-1"></i>
                </div>
                <h4 class="fw-900 text-navy mb-2">Increase Capital Pool</h4>
                <p class="small text-muted mb-4 fw-bold uppercase">Add liquidity to fund more flight bookings</p>
                
                <div class="mb-4 text-start">
                    <label class="form-label small fw-900 text-navy uppercase">Direct Investment Amount (INR)</label>
                    <div class="input-group border border-light rounded-4 overflow-hidden mb-3">
                        <span class="input-group-text bg-light border-0 fw-900">₹</span>
                        <input type="number" class="form-control border-0 py-3 fw-900" value="50000">
                    </div>
                    
                    <div class="row g-2">
                        <div class="col-4"><button class="btn btn-outline-dark w-100 rounded-pill small fw-900 py-2">₹1L</button></div>
                        <div class="col-4"><button class="btn btn-outline-dark w-100 rounded-pill small fw-900 py-2">₹2L</button></div>
                        <div class="col-4"><button class="btn btn-outline-dark w-100 rounded-pill small fw-900 py-2">₹5L</button></div>
                    </div>
                </div>
                
                <button class="btn btn-dark w-100 py-3 rounded-pill fw-900 mb-3 shadow-lg" style="background:#0f172a;">INITIATE FUND ADDITION</button>
                <button class="btn btn-link text-muted fw-bold small text-decoration-none" data-bs-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>
@endsection

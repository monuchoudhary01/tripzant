@extends('layouts.app')

@section('title', "Agent Credit Request — Tripzant B2B")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="credit-request" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">Credit Limit Request (Overdraft)</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Apply for Temporary Ticketing Limit | Emergency Booking Funds</p>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-xl-6">
                    <div class="card border-0 shadow-lg rounded-5 bg-white p-5 h-100">
                        <h6 class="fw-900 text-navy mb-5 uppercase tracking-wide">Submit Credit Request</h6>
                        <form action="#" method="POST">
                             <div class="mb-4 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">REQUESTED LIMIT (INR)</label>
                                 <input type="number" class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" placeholder="Ex: 5,00,000">
                             </div>
                             <div class="mb-4 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">REPAYMENT TIMELINE (DAYS)</label>
                                 <select class="form-select border-0 bg-light rounded-4 py-3 fw-bold shadow-none">
                                     <option value="7">7 Days</option>
                                     <option value="15">15 Days</option>
                                     <option value="30">30 Days</option>
                                 </select>
                             </div>
                             <div class="mb-5 text-start">
                                 <label class="x-small fw-900 text-muted uppercase mb-2">PURPOSE OF CREDIT</label>
                                 <textarea class="form-control border-0 bg-light rounded-4 py-3 fw-bold shadow-none" rows="3" placeholder="Ex: Bulk group booking for corporate client."></textarea>
                             </div>
                             <button type="button" class="btn btn-navy w-100 rounded-pill py-3 fw-900 x-small uppercase shadow-lg">SUBMIT FOR APPROVAL <i class="fas fa-paper-plane ms-2"></i></button>
                        </form>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm rounded-5 bg-light p-5 h-100 border-dashed border-primary">
                         <h6 class="fw-900 text-navy mb-4 uppercase tracking-wide opacity-75">Credit Policy Hub</h6>
                         <ul class="d-flex flex-column gap-4 small fw-bold text-muted p-0 m-0" style="list-style: none;">
                             <li class="d-flex gap-3"><i class="fas fa-check-circle text-primary mt-1"></i> <span>Minimum wallet turnover of ₹2,00,000/month required for credit eligibility.</span></li>
                             <li class="d-flex gap-3"><i class="fas fa-check-circle text-primary mt-1"></i> <span>0% Interest if repaid within the selected timeline.</span></li>
                             <li class="d-flex gap-3"><i class="fas fa-check-circle text-primary mt-1"></i> <span>Late fees of 2% applicable post the due date.</span></li>
                             <li class="d-flex gap-3"><i class="fas fa-exclamation-triangle text-warning mt-1"></i> <span>Ticketing will be blocked if credit limit is exceeded or repayment is overdue.</span></li>
                         </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .text-navy { color: #001f3f !important; }
    .bg-navy { background: #001f3f !important; }
    .border-dashed { border-style: dashed !important; }
    .border-primary { border-color: #0b3d61 !important; }
</style>
@endsection

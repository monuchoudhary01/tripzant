@extends('layouts.app')

@section('title', "Help Center — Tripzant B2B Support")

@section('content')
<div class="partner-dashboard-wrapper d-flex" style="background: #f8fafc; min-height: 100vh; font-family: 'Outfit', sans-serif;">
    <x-partner-sidebar active="support-help" />

    <main class="flex-grow-1 p-5 overflow-auto">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4 border-light">
                <div>
                     <h2 class="fw-900 text-navy mb-1" style="font-size: 28px;">B2B Knowledge Hub (Help Center)</h2>
                     <p class="text-muted small fw-bold mb-0 opacity-75">Operational Guidelines | GDS Node Protocols | Financial FAQs</p>
                </div>
            </div>

            <div class="row g-5 mt-4">
                <div class="col-xl-9">
                    <div class="d-flex flex-column gap-5">
                       @foreach([
                           ['cat' => 'TICKETING & GDS', 'topics' => [
                               'How to generate an instant PNR from Amadeus inventory?',
                               'Correction guidelines for misspelled passenger names.',
                               'Seat selection protocol post-issuance.'
                           ]],
                           ['cat' => 'WALLET & FINANCIALS', 'topics' => [
                               'Understanding Settlement Cycles (T+0 vs T+2).',
                               'How to apply for an emergency Credit Limit (Overdraft)?',
                               'Downloading Tax Compliant GST Invoices.'
                           ]],
                           ['cat' => 'SUB-AGENTS & ACCESS', 'topics' => [
                               'How to add and manage Sub-Agent wallet permissions?',
                               'Two-Factor Authentication (2FA) setup guide.',
                               'Managing Markup Rules for specific flight routes.'
                           ]]
                       ] as $hc)
                       <div class="card border-0 shadow-sm rounded-5 bg-white p-5 animate-up">
                            <h6 class="fw-900 text-primary mb-5 uppercase tracking-widest border-bottom border-light pb-4">{{ $hc['cat'] }}</h6>
                            <div class="d-flex flex-column gap-4 text-start">
                                @foreach($hc['topics'] as $topic)
                                <a href="#" class="text-navy text-decoration-none d-flex justify-content-between align-items-center px-4 py-3 bg-light rounded-4 border hover-up-sm transition-all border-light">
                                     <span class="small fw-bold opacity-75">{{ $topic }}</span>
                                     <i class="fas fa-chevron-right x-small opacity-50"></i>
                                </a>
                                @endforeach
                            </div>
                       </div>
                       @endforeach
                    </div>
                </div>

                <div class="col-xl-3 sticky-top" style="top: 100px; height: fit-content;">
                    <div class="card border-0 shadow-lg rounded-5 bg-navy text-white p-5 overflow-hidden">
                        <div class="position-relative" style="z-index: 2;">
                             <h6 class="fw-900 mb-5 uppercase tracking-wide opacity-50">Instant Desk</h6>
                             <div class="d-flex flex-column gap-4">
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white rounded-circle p-2 px-3 fw-900 text-navy"><i class="fas fa-phone"></i></div>
                                     <div class="x-small fw-bold">1800-TRIPZANT-B2B</div>
                                 </div>
                                 <div class="d-flex align-items-center gap-3">
                                     <div class="bg-white rounded-circle p-2 px-3 fw-900 text-navy"><i class="fas fa-envelope"></i></div>
                                     <div class="x-small fw-bold">support@tripzant.com</div>
                                 </div>
                             </div>
                             <button class="btn btn-warning w-100 rounded-pill py-3 fw-900 x-small uppercase mt-5 shadow-sm">CHAT WITH GDS EXPERT</button>
                        </div>
                        <div style="position:absolute; right:-50px; bottom:-50px; width:200px; height:200px; background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius:50%;"></div>
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
    .bg-light { background: #f8fafc !important; }
    .animate-up { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .hover-up-sm:hover { transform: translateY(-5px); border-color: #0b3d6110 !important; }
    .transition-all { transition: all 0.2s ease; }
</style>
@endsection

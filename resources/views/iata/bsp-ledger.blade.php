@extends('layouts.iata_panel')

@section('title', 'BSP Ledger | IATA Agent Panel')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-800 text-navy mb-0 outfit">BSP Financial Ledger</h4>
        <div class="d-flex align-items-baseline gap-2">
            <span class="text-muted fw-700 small uppercase">Credit Balance:</span>
            <span class="h4 fw-900 text-success outfit mb-0">₹8,45,200</span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light mb-5">
        <div class="table-responsive">
            <table class="table table-premium mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description / Reference</th>
                        <th>Type</th>
                        <th>Debit (-)</th>
                        <th>Credit (+)</th>
                        <th class="text-end">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $ledgers = [
                        ['date' => '07 Apr 2024', 'desc' => 'Ticket Issued: 098-9920485123 (AI-102)', 'type' => 'Sale', 'debit' => '₹6,250', 'credit' => '-', 'bal' => '₹8,45,200'],
                        ['date' => '07 Apr 2024', 'desc' => 'Ticket Issued: 532-1140992834 (6E-284)', 'type' => 'Sale', 'debit' => '₹4,350', 'credit' => '-', 'bal' => '₹8,51,450'],
                        ['date' => '06 Apr 2024', 'desc' => 'BSP Weekly Settlement - Week 4 Mar', 'type' => 'Payment', 'debit' => '-', 'credit' => '₹42,000', 'bal' => '₹8,55,800'],
                        ['date' => '05 Apr 2024', 'desc' => 'Refund Processed: 532-8842210993', 'type' => 'Refund', 'debit' => '-', 'credit' => '₹3,200', 'bal' => '₹8,13,800'],
                        ['date' => '04 Apr 2024', 'desc' => 'Top Up: Bank Transfer (Ref: 4882193)', 'type' => 'Add Funds', 'debit' => '-', 'credit' => '₹5,00,000', 'bal' => '₹8,10,600'],
                    ];
                    @endphp
                    @foreach($ledgers as $l)
                    <tr>
                        <td class="fw-700 small text-muted">{{ $l['date'] }}</td>
                        <td>
                            <div class="fw-800 text-navy">{{ $l['desc'] }}</div>
                            <div class="x-small fw-700 text-muted uppercase mt-1">{{ $l['type'] }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $l['type'] == 'Sale' ? 'bg-danger-subtle text-danger' : ($l['type'] == 'Refund' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary') }} rounded-pill px-3 py-1 x-small fw-800 uppercase">
                                {{ $l['type'] }}
                            </span>
                        </td>
                        <td class="text-danger fw-800">{{ $l['debit'] }}</td>
                        <td class="text-success fw-800">{{ $l['credit'] }}</td>
                        <td class="text-end fw-900 outfit">{{ $l['bal'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

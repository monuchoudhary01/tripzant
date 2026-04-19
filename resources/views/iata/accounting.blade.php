@extends('layouts.iata_panel')

@section('title', 'Accounting Hub | IATA Agent Panel')

@section('iata_content')
<div class="mb-5">
    <h4 class="fw-800 text-navy mb-4 outfit">Accounting Hub</h4>
    
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5 border border-light h-100">
                <h6 class="fw-800 text-navy mb-4 outfit uppercase border-bottom pb-3">General Ledger Summary</h6>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between p-3 bg-light rounded-3">
                        <span class="fw-700 text-muted">Total Receivables</span>
                        <span class="fw-900 text-navy">₹1,45,200</span>
                    </div>
                    <div class="d-flex justify-content-between p-3 bg-light rounded-3">
                        <span class="fw-700 text-muted">Total Payables</span>
                        <span class="fw-900 text-navy">₹82,400</span>
                    </div>
                    <div class="d-flex justify-content-between p-3 bg-primary-subtle rounded-3">
                        <span class="fw-800 text-primary">Net Profit (MTD)</span>
                        <span class="fw-900 text-primary">₹62,800</span>
                    </div>
                </div>
                <button class="btn btn-iata mt-4 w-100">View Detailed Sales Ledger</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5 border border-light h-100">
                <h6 class="fw-800 text-navy mb-4 outfit uppercase border-bottom pb-3">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-sm small">
                        <thead>
                            <tr class="text-muted fw-800 uppercase" style="font-size: 10px;">
                                <th>Ref</th>
                                <th>Category</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-700">TXN-4421</td>
                                <td>Corporate Booking</td>
                                <td class="text-end fw-800">₹24,500</td>
                            </tr>
                            <tr>
                                <td class="fw-700">TXN-4420</td>
                                <td>GDS Fee Settlement</td>
                                <td class="text-end fw-800 text-danger">(-₹1,200)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

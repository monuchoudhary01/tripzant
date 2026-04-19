@extends('layouts.iata_panel')

@section('title', 'BSP Sales Report | IATA Agent Panel')

@section('iata_content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-800 text-navy mb-0 outfit">BSP Sales Report</h4>
        <div class="d-flex gap-3">
            <button class="btn btn-light border fw-800"><i class="fas fa-file-excel me-2 text-success"></i> Export Excel</button>
            <button class="btn btn-iata fw-800"><i class="fas fa-print me-2"></i> Print Report</button>
        </div>
    </div>

    <!-- Period Selector -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4 border border-light">
        <form class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-800 text-muted uppercase">Billing Period</label>
                <select class="form-select border-0 bg-light fw-700">
                    <option>April 2024 - Week 1 (01-07)</option>
                    <option>March 2024 - Week 4 (24-31)</option>
                    <option>March 2024 - Week 3 (17-23)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-800 text-muted uppercase">Airline Wise</label>
                <select class="form-select border-0 bg-light fw-700">
                    <option>All Airlines</option>
                    <option>Air India</option>
                    <option>IndiGo</option>
                    <option>Vistara</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-800 text-muted uppercase">Date Range</label>
                <div class="input-group">
                    <input type="date" class="form-control border-0 bg-light fw-700" value="{{ date('Y-m-01') }}">
                    <span class="input-group-text bg-light border-0 fw-800">to</span>
                    <input type="date" class="form-control border-0 bg-light fw-700" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100 fw-800 py-2">Filter Data</button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="bg-white p-4 rounded-4 border border-light shadow-sm">
                <div class="text-muted small fw-800 uppercase mb-1">Gross Sales</div>
                <div class="h3 fw-900 text-navy outfit mb-0">₹12,45,800</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white p-4 rounded-4 border border-light shadow-sm">
                <div class="text-muted small fw-800 uppercase mb-1">Total Tax</div>
                <div class="h3 fw-900 text-navy outfit mb-0">₹1,85,400</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-white p-4 rounded-4 border border-light shadow-sm">
                <div class="text-muted small fw-800 uppercase mb-1">Commission Earned</div>
                <div class="h3 fw-900 text-success outfit mb-0">₹42,500</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-navy p-4 rounded-4 border border-light shadow-sm text-white">
                <div class="text-white-50 small fw-800 uppercase mb-1">Net Payable</div>
                <div class="h3 fw-900 outfit mb-0">₹11,02,900</div>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="table-container">
        <table class="table table-premium mb-0">
            <thead>
                <tr>
                    <th>Ticket Number</th>
                    <th>Issue Date</th>
                    <th>Airline</th>
                    <th>Base Fare</th>
                    <th>Taxes</th>
                    <th>Comm %</th>
                    <th>Comm Amt</th>
                    <th class="text-end">Payable</th>
                </tr>
            </thead>
            <tbody>
                @php
                $reports = [
                    ['tkt' => '098-9920485123', 'date' => '07 Apr', 'airline' => 'Air India', 'base' => '₹4,800', 'tax' => '₹1,250', 'cp' => '3%', 'camt' => '₹144', 'payable' => '₹5,906'],
                    ['tkt' => '532-1140992834', 'date' => '07 Apr', 'airline' => 'IndiGo', 'base' => '₹3,500', 'tax' => '₹850', 'cp' => '0%', 'camt' => '₹0', 'payable' => '₹4,350'],
                    ['tkt' => '228-5520114882', 'date' => '06 Apr', 'airline' => 'Vistara', 'base' => '₹6,200', 'tax' => '₹1,450', 'cp' => '5%', 'camt' => '₹310', 'payable' => '₹7,340'],
                    ['tkt' => '098-9920400114', 'date' => '06 Apr', 'airline' => 'Air India', 'base' => '₹12,500', 'tax' => '₹3,200', 'cp' => '3%', 'camt' => '₹375', 'payable' => '₹15,325'],
                ];
                @endphp
                @foreach($reports as $r)
                <tr>
                    <td class="fw-800 font-monospace">{{ $r['tkt'] }}</td>
                    <td class="fw-700 text-muted">{{ $r['date'] }}</td>
                    <td class="fw-800">{{ $r['airline'] }}</td>
                    <td class="fw-700">{{ $r['base'] }}</td>
                    <td class="fw-700">{{ $r['tax'] }}</td>
                    <td class="fw-800 text-primary">{{ $r['cp'] }}</td>
                    <td class="fw-800 text-success">{{ $r['camt'] }}</td>
                    <td class="fw-900 text-end">{{ $r['payable'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-light">
                <tr class="fw-900 outfit text-navy fs-5">
                    <td colspan="3" class="text-end">TOTALS</td>
                    <td>₹27,000</td>
                    <td>₹6,750</td>
                    <td>-</td>
                    <td class="text-success">₹829</td>
                    <td class="text-end">₹32,921</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

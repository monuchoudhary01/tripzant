@extends('layouts.iata_panel')

@section('title', 'Intelligence Reports | IATA Agent Panel')

@section('iata_content')
<div class="mb-5">
    <h4 class="fw-800 text-navy mb-4 outfit">Intelligence & Operational Reports</h4>
    
    <div class="row g-4">
        @php
        $reports = [
            ['title' => 'Ticket Issuance Report', 'desc' => 'Detailed list of all tickets issued across all airlines.', 'icon' => 'fa-ticket-alt', 'color' => 'blue'],
            ['title' => 'Refund & Void Analysis', 'desc' => 'Tracking of all refund requests and voided tickets.', 'icon' => 'fa-undo', 'color' => 'orange'],
            ['title' => 'Airline-wise Sales', 'desc' => 'Performance breakdown by specific carriers.', 'icon' => 'fa-plane', 'color' => 'teal'],
            ['title' => 'Agent Commission Report', 'desc' => 'Earnings and incentive tracking report.', 'icon' => 'fa-coins', 'color' => 'green'],
            ['title' => 'Passenger Manifests', 'desc' => 'Consolidated passenger records for group bookings.', 'icon' => 'fa-users', 'color' => 'purple'],
            ['title' => 'Financial Audit Log', 'desc' => 'Complete trail of all financial movements.', 'icon' => 'fa-shield-alt', 'color' => 'navy'],
        ];
        @endphp

        @foreach($reports as $r)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 border border-light h-100 report-card">
                <div class="stats-icon bg-{{ $r['color'] }}-soft mb-4">
                    <i class="fas {{ $r['icon'] }}"></i>
                </div>
                <h6 class="fw-800 text-navy outfit mb-2">{{ $r['title'] }}</h6>
                <p class="text-muted small fw-600 mb-4">{{ $r['desc'] }}</p>
                <div class="mt-auto">
                    <button class="btn btn-light w-100 fw-800 py-2 border small">Generate Report</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .report-card { transition: 0.3s; }
    .report-card:hover { transform: translateY(-8px); border-color: var(--iata-blue-light) !important; box-shadow: 0 15px 30px rgba(0,0,0,0.05) !important; }
    .bg-navy-soft { background-color: #f1f5f9; color: #0f172a; }
</style>
@endsection

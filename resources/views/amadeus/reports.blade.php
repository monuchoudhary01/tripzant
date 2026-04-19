@extends('layouts.b2b_master')

@section('title', 'Financial Reports | Amadeus Partner Panel')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 12px;">
            <div class="stat-icon bg-success text-white mx-auto mb-3">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="text-muted small fw-700 uppercase">Gross Profit (MTD)</div>
            <h3 class="outfit mt-1 mb-0">₹1,24,500</h3>
        </div>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header">
        <h5 class="mb-0">Performance Insights</h5>
    </div>
    <div class="p-4" style="height: 300px;">
        <canvas id="performanceChart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script>
    new Chart(document.getElementById('performanceChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [{ label: 'Profit', data: [85000, 92000, 110000, 124500], backgroundColor: '#0052cc' }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endsection

@extends('layouts.user_dashboard')

@section('title', 'Job History')

@section('content')
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Completed Missions</h6>
        <div class="input-group input-group-sm w-auto">
            <input type="text" class="form-control border-end-0" placeholder="Search Ref...">
            <button class="btn btn-outline-secondary border-start-0"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light small text-muted">
                <tr>
                    <th class="ps-4">Mission ID</th>
                    <th>Date</th>
                    <th>Route</th>
                    <th>Weight</th>
                    <th class="text-end pe-4">Result</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                <tr>
                    <td class="ps-4 fw-bold text-primary">{{ $item->booking_ref }}</td>
                    <td>{{ $item->updated_at->format('d M, Y') }}</td>
                    <td>{{ $item->origin_city }} <i class="fas fa-long-arrow-alt-right mx-1 opacity-50"></i> {{ $item->destination_city }}</td>
                    <td>{{ $item->weight }} KG</td>
                    <td class="text-end pe-4">
                        <span class="badge bg-soft-success text-success rounded-pill px-3">Completed</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-box-open d-block h1 opacity-20 mb-3"></i>
                        No completed jobs found yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $history->links() }}
    </div>
</div>
@endsection

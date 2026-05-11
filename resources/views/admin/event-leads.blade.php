@extends('layouts.admin')

@section('title', 'Melbourne Event Leads | Admin Dashboard')

@section('admin_content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-900 text-navy mb-0">Customer Leads</h2>
            <p class="text-muted small mb-0">Tracking visitors and registrations from marketing events</p>
        </div>
        <div class="bg-primary-light text-primary px-4 py-2 rounded-pill fw-bold">
            Total Leads: {{ count($leads) }}
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold">DATE</th>
                            <th class="py-3 text-muted small fw-bold">NAME</th>
                            <th class="py-3 text-muted small fw-bold">EMAIL / PHONE</th>
                            <th class="py-3 text-muted small fw-bold">RAFFLE CODE</th>
                            <th class="py-3 text-muted small fw-bold text-end pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                        <tr>
                            <td class="ps-4 small fw-bold text-muted">{{ $lead->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <h6 class="fw-bold text-navy mb-0">{{ $lead->name }}</h6>
                                <span class="badge bg-success text-white x-small">Melbourne Event</span>
                            </td>
                            <td>
                                <div class="fw-bold small">{{ $lead->email }}</div>
                                <div class="text-muted x-small">{{ $lead->phone ?? 'No Phone' }}</div>
                            </td>
                            <td>
                                @if($lead->raffle_code)
                                    <span class="badge bg-primary fs-6">{{ $lead->raffle_code }}</span>
                                @else
                                    <span class="text-muted small">Not generated</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.event-leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Delete this lead?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-circle p-2"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">No leads captured yet.</div>
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
    .bg-primary-light { background: rgba(11, 61, 97, 0.05); }
    .bg-orange-light { background: rgba(249, 115, 22, 0.1); }
    .text-orange { color: #f97316; }
    .x-small { font-size: 11px; }
</style>
@endsection

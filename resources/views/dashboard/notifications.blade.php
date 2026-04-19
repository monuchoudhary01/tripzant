@extends('layouts.dashboard')

@section('title', 'Notifications | Trip\'Stay')

@section('dashboard_content')
<div class="notifications-page">
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-900 text-navy mb-1">Your Notifications</h4>
            <p class="text-muted small">Stay updated with your trip alerts and offers.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($notifications as $n)
        @php
            $data = $n->data;
            $title = $data['title'] ?? 'Notification';
            $msg = $data['message'] ?? $data['msg'] ?? '';
            $icon = $data['icon'] ?? 'fa-bell';
            $color = $data['color'] ?? '#0b3d61';
        @endphp
        <div class="col-12">
            <div class="dashboard-card border-start border-5 p-4 rounded-4 shadow-sm bg-white" style="border-left-color: {{ $color }} !important; transition: all 0.3s ease; opacity: {{ $n->read_at ? '0.7' : '1' }};">
                <div class="d-flex align-items-center gap-4">
                    <div class="p-3 bg-light rounded-circle text-navy fs-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: {{ $color }}15 !important; color: {{ $color }} !important;"><i class="fas {{ $icon }}"></i></div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-900 text-navy mb-0">{{ $title }}</h6>
                            <span class="text-muted x-small fw-bold">{{ $n->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-muted small mb-0 fw-bold">{{ $msg }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 bg-white rounded-4 border shadow-sm">
            <div class="mb-4">
                <i class="fas fa-bell-slash display-3 text-muted opacity-25"></i>
            </div>
            <h5 class="fw-900 text-navy">No Notifications</h5>
            <p class="text-muted small">You're all caught up! Any new updates about your bookings or account will appear here.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $notifications->links() }}
    </div>
</div>

<style>
    .x-small { font-size: 11px; }
</style>
@endsection

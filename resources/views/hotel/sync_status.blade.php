@extends('layouts.hotel_master')

@section('title', 'Real-time Sync Log | Hotel CRS & Channel Manager')

@section('styles')
<style>
    .ps-sync-log-card { background: #fff; border-radius: 20px; border: 1px solid var(--ps-border); padding: 30px; }
    .ps-sync-status-indicator { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .ps-sync-table th { background: #f8fafc; border-bottom: 2px solid var(--ps-border); padding: 15px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; }
    .ps-sync-table td { padding: 15px; border-bottom: 1px solid var(--ps-border); font-size: 13px; font-weight: 700; color: #1e293b; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Real-time Synchronization Log</h2>
        <p class="text-muted fw-600 mb-0">Monitor 2-way data flow between your CRS and connected OTA channels.</p>
    </div>
    <div class="d-flex align-items-center gap-3">
         <span class="tiny fw-800 text-muted uppercase">Health Status:</span>
         <div class="h5 fw-900 text-success mb-0 outfit"><i class="fas fa-check-circle me-1"></i> OPTIMAL</div>
    </div>
</div>

<div class="ps-sync-log-card shadow-sm border-0">
    <div class="table-responsive">
        <table class="ps-sync-table w-100">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Source / Destination</th>
                    <th>Sync Action</th>
                    <th>Payload Context</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-muted">10:45 AM</td>
                    <td><div class="fw-900 text-navy">Booking.com <i class="fas fa-arrow-right mx-2 text-muted"></i> Internal CRS</div></td>
                    <td><span class="badge bg-soft-blue text-primary px-3 py-1 rounded-pill fw-800" style="background:#eef2ff;">NEW BOOKING</span></td>
                    <td>Room: Superior Twin • Guest: Mark J.</td>
                    <td><span class="text-success fw-900"><i class="fas fa-check me-1"></i> SUCCESS</span></td>
                </tr>
                <tr>
                    <td class="text-muted">10:44 AM</td>
                    <td><div class="fw-900 text-navy">Internal CRS <i class="fas fa-arrow-right mx-2 text-muted"></i> All OTAs</div></td>
                    <td><span class="badge bg-light text-muted px-3 py-1 rounded-pill fw-800">INVENTORY UPDATE</span></td>
                    <td>Update: -1 Unit (All Channels)</td>
                    <td><span class="text-success fw-900"><i class="fas fa-check me-1"></i> PUSHED</span></td>
                </tr>
                <tr>
                    <td class="text-muted">10:30 AM</td>
                    <td><div class="fw-900 text-navy">Agoda <i class="fas fa-arrow-right mx-2 text-muted"></i> Internal CRS</div></td>
                    <td><span class="badge bg-soft-blue text-primary px-3 py-1 rounded-pill fw-800" style="background:#eef2ff;">CANCELLATION</span></td>
                    <td>Room: Executive Suite • Ref: #AG-981</td>
                    <td><span class="text-success fw-900"><i class="fas fa-check me-1"></i> AUTO-RESTORED</span></td>
                </tr>
                <tr>
                    <td class="text-muted">10:15 AM</td>
                    <td><div class="fw-900 text-navy">Trip.com <i class="fas fa-arrow-right mx-2 text-muted"></i> Internal CRS</div></td>
                    <td><span class="badge bg-danger text-white px-3 py-1 rounded-pill fw-800 border-0">SYNC ERROR</span></td>
                    <td>Rate Plan Mapping Missed</td>
                    <td><span class="text-danger fw-900">RETRYING...</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

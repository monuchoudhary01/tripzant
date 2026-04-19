@extends('layouts.hotel_master')

@section('title', 'Pipeline | Negotiation Board')

@section('styles')
<style>
    .kanban-board { display: flex; gap: 20px; overflow-x: auto; padding-bottom: 30px; min-height: calc(100vh - 250px); }
    .kanban-column { min-width: 300px; width: 300px; background: #f1f5f9; border-radius: 20px; padding: 20px; display: flex; flex-direction: column; gap: 15px; }
    .kanban-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .kanban-title { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; }
    .kanban-count { background: #e2e8f0; padding: 2px 10px; border-radius: 100px; font-size: 11px; font-weight: 800; color: #1e293b; }
    
    .kanban-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; cursor: move; transition: 0.2s; position: relative; }
    .kanban-card:hover { border-color: var(--h-accent); box-shadow: 0 10px 20px rgba(0,0,0,0.05); transform: translateY(-3px); }
    .kanban-tag { font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; margin-bottom: 8px; display: inline-block; }
    .tag-group { background: #eff6ff; color: #2563eb; }
    .tag-urgent { background: #fee2e2; color: #ef4444; }
    
    .kanban-price { font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 10px; }
    .kanban-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9; }
    .form-control-custom { background: #f8fafc; border: 2px solid transparent; border-radius: 12px; padding: 12px 18px; font-weight: 700; width: 100%; transition: 0.3s; }
    .form-control-custom:focus { background: #fff; border-color: #2563eb; outline: none; }
    .form-label-custom { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 1px; margin-bottom: 8px; display: block; }
</style>
@endsection

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-end">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -2px; font-size: 38px;">Negotiation Pipeline</h2>
        <p class="text-muted fw-600 mb-0">Drag and drop leads to update workflow stages and monitor conversion.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-5 fw-800" style="background:#2563eb; border:none; height:50px;" data-bs-toggle="modal" data-bs-target="#newLeadModal">
        <i class="fas fa-plus me-2"></i> CREATE NEW DEAL
    </button>
</div>

<div class="kanban-board">
    <!-- NEW LEAD -->
    <div class="kanban-column">
        <div class="kanban-header">
            <span class="kanban-title">New Lead</span>
            <span class="kanban-count">3</span>
        </div>
        
        <div class="kanban-card" onclick="location.href='{{ route('hotel.details') }}'">
            <span class="kanban-tag tag-urgent">Inbound</span>
            <h6 class="outfit fw-800 text-navy mb-1">Sydney Group - 10 Pax</h6>
            <p class="text-muted tiny fw-700 mb-0"><i class="fas fa-calendar me-1"></i> May 25 - Jun 02</p>
            <div class="kanban-footer">
                 <img src="https://ui-avatars.com/api/?name=Mark+Agency&background=eff6ff&color=2563eb&bold=true" class="rounded-circle" width="24">
                 <span class="tiny text-muted fw-700">2m ago</span>
            </div>
        </div>

        <div class="kanban-card" onclick="location.href='{{ route('hotel.details') }}'">
            <span class="kanban-tag tag-group">Family Trip</span>
            <h6 class="outfit fw-800 text-navy mb-1">UK Family - 4 Pax</h6>
            <p class="text-muted tiny fw-700 mb-0"><i class="fas fa-calendar me-1"></i> Jun 12 - Jun 18</p>
            <div class="kanban-footer">
                 <img src="https://ui-avatars.com/api/?name=Sarah+B&background=eff6ff&color=2563eb" class="rounded-circle" width="24">
                 <span class="tiny text-muted fw-700">45m ago</span>
            </div>
        </div>
    </div>

    <!-- QUOTATION SENT -->
    <div class="kanban-column">
        <div class="kanban-header">
            <span class="kanban-title">Quotation Sent</span>
            <span class="kanban-count">5</span>
        </div>
        
        <div class="kanban-card" onclick="location.href='{{ route('hotel.details') }}'">
            <span class="kanban-tag tag-group">Corporate</span>
            <h6 class="outfit fw-800 text-navy mb-1">Singapore Hub - 2 Pax</h6>
            <div class="kanban-price">₹85,000</div>
            <div class="kanban-footer">
                 <span class="badge bg-warning rounded-pill tiny py-1">Awaiting Response</span>
            </div>
        </div>
    </div>

    <!-- NEGOTIATION -->
    <div class="kanban-column">
        <div class="kanban-header">
            <span class="kanban-title">Negotiation</span>
            <span class="kanban-count">2</span>
        </div>
        
        <div class="kanban-card" onclick="location.href='{{ route('hotel.details') }}'">
            <span class="kanban-tag tag-group">MICE</span>
            <h6 class="outfit fw-800 text-navy mb-1">Dubai Peak Conf.</h6>
            <div class="kanban-price">₹12,40,000</div>
            <div class="kanban-footer">
                 <div class="d-flex align-items-center gap-1">
                      <i class="fas fa-comments text-primary small"></i>
                      <span class="tiny fw-800 text-primary">Chat Active</span>
                 </div>
            </div>
        </div>
    </div>

    <!-- CONFIRMED -->
    <div class="kanban-column">
        <div class="kanban-header">
            <span class="kanban-title">Confirmed</span>
            <span class="kanban-count">1</span>
        </div>
        
        <div class="kanban-card" style="border-left: 5px solid #22c55e;" onclick="location.href='{{ route('hotel.confirm') }}'">
            <span class="kanban-tag tag-group" style="background:#f0fdf4; color:#16a34a;">Sold</span>
            <h6 class="outfit fw-800 text-navy mb-1">NYC Delegates</h6>
            <div class="kanban-price">₹45,500</div>
            <div class="kanban-footer">
                 <span class="tiny text-success fw-900 bg-light px-2 py-1 rounded">Voucher Issued</span>
            </div>
        </div>
    </div>

    <!-- LOST -->
    <div class="kanban-column">
        <div class="kanban-header">
            <span class="kanban-title">Lost</span>
            <span class="kanban-count">0</span>
        </div>
    </div>
</div>
<!-- NEW LEAD MODAL -->
<div class="modal fade" id="newLeadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title outfit fw-900 text-navy">Initiate New Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-4">
                        <label class="form-label-custom">Client / Agency Name</label>
                        <input type="text" class="form-control-custom" placeholder="e.g. Thomas Cook India">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Lead Category</label>
                            <select class="form-control-custom">
                                <option>Group Arrival</option>
                                <option>Corporate Stay</option>
                                <option>MICE Event</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Total Pax</label>
                            <input type="number" class="form-control-custom" placeholder="e.g. 15">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-custom">Destination Context</label>
                        <input type="text" class="form-control-custom" placeholder="e.g. London Agents Inbound">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-800 border-0 shadow-sm" style="background:#2563eb;">
                        CREATE DEAL IN PIPELINE
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

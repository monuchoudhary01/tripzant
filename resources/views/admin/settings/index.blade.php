@extends('layouts.admin')

@section('title', 'System Settings | Command Center')

@section('admin_content')
<div class="row g-4">
    <div class="col-12">
        <h2 class="fw-900 text-navy mb-4">System Master Settings</h2>
        
        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <!-- Markup Rules -->
    <div class="col-xl-8">
        <div class="card-admin shadow-sm border-0 rounded-5 p-5 bg-white">
            <h5 class="fw-900 text-navy mb-5 d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary p-2 rounded-circle fs-6"><i class="fas fa-percent"></i></div>
                Dynamic Markup Management
            </h5>
            
            <form action="{{ route('admin.settings.markup.update') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="bg-light">
                            <tr class="x-small fw-800 text-muted uppercase">
                                <th class="py-3 ps-4">Module</th>
                                <th class="py-3">Role</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Value</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="small fw-bold">
                            @foreach($markupSettings as $markup)
                            <input type="hidden" name="markups[{{$markup->id}}][id]" value="{{$markup->id}}">
                            <tr class="border-bottom">
                                <td class="py-4 ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 bg-light text-navy rounded-3" style="width:35px; height:35px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas {{ $markup->module == 'flight' ? 'fa-plane' : ($markup->module == 'hotel' ? 'fa-hotel' : 'fa-box') }}"></i>
                                        </div>
                                        <span class="uppercase tracking-wider">{{ $markup->module }}</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-navy text-white px-3 py-1 rounded-pill">{{ $markup->user_role }}</span></td>
                                <td>
                                    <select name="markups[{{$markup->id}}][type]" class="form-select border-0 bg-light rounded-pill px-3 py-1 small fw-bold">
                                        <option value="fixed" {{ $markup->markup_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percent" {{ $markup->markup_type == 'percent' ? 'selected' : '' }}>Percent</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm" style="width: 100px;">
                                        <input type="number" step="0.01" name="markups[{{$markup->id}}][value]" value="{{ $markup->markup_value }}" class="form-control border-0 bg-light rounded-pill px-3 fw-900 text-navy">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="markups[{{$markup->id}}][active]" {{ $markup->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5 text-end">
                    <button type="submit" class="btn btn-navy rounded-pill px-5 py-3 fw-900 uppercase">Save Markup Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Global Config -->
    <div class="col-xl-4">
        <div class="card-admin shadow-sm border-0 rounded-5 p-5 bg-white mb-4">
            <h5 class="fw-900 text-navy mb-5 d-flex align-items-center gap-3">
                <div class="bg-orange-light text-orange p-2 rounded-circle fs-6"><i class="fas fa-cog"></i></div>
                Site Configuration
            </h5>
            
            <form action="{{ route('admin.settings.global.update') }}" method="POST">
                @csrf
                <div class="row g-4">
                    @foreach($globalSettings->get('general', []) as $item)
                        <div class="col-12">
                            <label class="x-small fw-800 text-muted uppercase mb-2">{{ str_replace('_', ' ', $item->key) }}</label>
                            <input type="text" name="settings[{{$item->key}}]" value="{{ $item->value }}" class="form-control border-0 bg-light rounded-pill px-4 py-3 fw-bold text-navy">
                            <p class="x-small text-muted mt-2 mb-0 opacity-50">{{ $item->description }}</p>
                        </div>
                    @endforeach
                    
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-orange w-100 rounded-pill py-3 fw-900 uppercase">Save Configuration</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Payment Gateway Config -->
        <div class="card-admin shadow-sm border-0 rounded-5 p-5 bg-white">
            <h5 class="fw-900 text-navy mb-5 d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary p-2 rounded-circle fs-6"><i class="fas fa-credit-card"></i></div>
                Payment Gateway
            </h5>
            
            <form action="{{ route('admin.settings.global.update') }}" method="POST">
                @csrf
                <div class="row g-4">
                    @foreach($globalSettings->get('payment', []) as $item)
                        <div class="col-12">
                            <label class="x-small fw-800 text-muted uppercase mb-2">{{ str_replace('_', ' ', $item->key) }}</label>
                            <input type="text" name="settings[{{$item->key}}]" value="{{ $item->value }}" class="form-control border-0 bg-light rounded-pill px-4 py-3 fw-bold text-navy">
                            <p class="x-small text-muted mt-2 mb-0 opacity-50">{{ $item->description }}</p>
                        </div>
                    @endforeach
                    
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-navy w-100 rounded-pill py-3 fw-900 uppercase">Update Gateway</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .x-small { font-size: 11px; }
    .uppercase { text-transform: uppercase; }
    .tracking-wider { letter-spacing: 0.1em; }
    .text-navy { color: #001f3f; }
    .btn-navy { background: #001f3f; color: #fff; border: none; }
    .btn-navy:hover { background: #000; color: #fff; }
    .bg-primary-subtle { background: rgba(11, 61, 97, 0.1); color: #0b3d61; }
    .bg-orange-light { background: #fffcf0; color: #f97316; }
    .btn-orange { background: #f97316; color: #fff; border: none; }
</style>
@endsection

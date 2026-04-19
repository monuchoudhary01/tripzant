@extends('layouts.admin')

@section('title', 'Manage Cargo Providers')

@section('admin_content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">Cargo Providers</h2>
            <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addProviderModal">
                <i class="fas fa-plus me-2"></i> Add New Provider
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">Logo</th>
                        <th>Provider Name</th>
                        <th>Base Rate</th>
                        <th>Per KG Rate</th>
                        <th>Commission %</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                    <tr>
                        <td class="ps-4">
                            <img src="{{ $provider->logo_url }}" height="30" alt="Logo">
                        </td>
                        <td><span class="fw-bold">{{ $provider->name }}</span></td>
                        <td>${{ number_format($provider->base_rate, 2) }}</td>
                        <td>${{ number_format($provider->per_kg_rate, 2) }}</td>
                        <td>{{ $provider->commission_percentage }}%</td>
                        <td>
                            <span class="badge {{ $provider->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                {{ $provider->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-icon border-0"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-icon border-0 text-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

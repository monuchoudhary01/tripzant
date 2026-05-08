@extends('layouts.admin')

@section('title', 'System Roles Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">System /</span> Roles Management
    </h4>

    <div class="card card-sneat">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Defined User Roles ({{ $roles->count() }})</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Slug</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <i class="bx bx-shield-quarter text-primary me-3"></i>
                            <strong>{{ $role->name }}</strong>
                        </td>
                        <td><span class="badge bg-label-info">{{ $role->slug }}</span></td>
                        <td>{{ $role->created_at->format('d M, Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
</style>
@endsection

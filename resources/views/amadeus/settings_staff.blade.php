@extends('layouts.b2b_master')

@section('title', 'Staff Management | Amadeus Partner Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit">Staff Management</h4>
        <p class="text-muted small mb-0">Add, remove, and manage your agency's team members and their access levels.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm px-4 fw-700 bg-white border border-primary text-primary"><i class="fas fa-user-plus me-2"></i> ADD NEW USER</button>
    </div>
</div>

<div class="b2b-table-card">
    <div class="card-header border-0 pb-0">
        <h5 class="mb-0">Team Members (3)</h5>
    </div>
    <div class="table-responsive mt-3">
        <table class="table b2b-table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th>User Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-700">Neil Udukala</td>
                    <td>neil@amadeus.com</td>
                    <td><span class="badge bg-primary rounded-pill tiny fw-700">ADMIN</span></td>
                    <td class="small">07 Apr 2024, 10:12 AM</td>
                    <td><span class="text-success fw-700 small"><i class="fas fa-check-circle me-1"></i> ACTIVE</span></td>
                    <td>
                        <button class="btn btn-light btn-sm px-2"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-light btn-sm px-2 text-danger"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-700">John Miller</td>
                    <td>john.miller@amadeus.com</td>
                    <td><span class="badge bg-info rounded-pill tiny fw-700">MANAGER</span></td>
                    <td class="small">05 Apr 2024, 02:45 PM</td>
                    <td><span class="text-success fw-700 small"><i class="fas fa-check-circle me-1"></i> ACTIVE</span></td>
                    <td>
                        <button class="btn btn-light btn-sm px-2"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-light btn-sm px-2 text-danger"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-700">Robert King</td>
                    <td>robert@amadeus.com</td>
                    <td><span class="badge bg-secondary rounded-pill tiny fw-700">TICKETING AGENT</span></td>
                    <td class="small">01 Apr 2024, 09:30 AM</td>
                    <td><span class="text-danger fw-700 small"><i class="fas fa-lock me-1"></i> DISABLED</span></td>
                    <td>
                        <button class="btn btn-light btn-sm px-2"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-light btn-sm px-2 text-success"><i class="fas fa-undo"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

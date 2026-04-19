@extends('layouts.b2b_master')

@section('title', 'Markup & Commission | Amadeus Partner Panel')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="b2b-table-card">
            <div class="card-header">
                <h5 class="mb-0">Airline-wise Markup Rules</h5>
            </div>
            <div class="table-responsive">
                <table class="table b2b-table mb-0">
                    <thead>
                        <tr>
                            <th>Airline</th>
                            <th>Service</th>
                            <th>Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Air India</td>
                            <td>Domestic Economy</td>
                            <td class="fw-700">₹350 / Pax</td>
                            <td><span class="b2b-badge badge-success">Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
            <h6 class="fw-800 mb-4 outfit uppercase">Global Settings</h6>
            <div class="mb-3">
                <label class="form-label-b2b">Global Domestic Markup (₹)</label>
                <input type="number" class="form-control-b2b" value="250">
            </div>
            <button class="btn btn-b2b-primary w-100 mt-2">SAVE SETTINGS</button>
        </div>
    </div>
</div>
@endsection

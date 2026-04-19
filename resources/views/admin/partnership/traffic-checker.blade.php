@extends('layouts.admin')

@section('title', 'Website Traffic Checker | TripZant')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-admin text-center py-5 shadow-lg border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);">
            <div class="mb-4">
                <div class="icon-circle bg-navy text-white mx-auto mb-3" style="width: 80px; height: 80px; line-height: 80px; font-size: 32px; border-radius: 50%;">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <h2 class="fw-900 text-navy">Global Traffic Intelligence</h2>
                <p class="text-muted px-5">Analyze any website's traffic, audience, and revenue potential instantly using our deep analytics engine.</p>
            </div>

            <form action="{{ route('admin.partnership.fetch') }}" method="POST" class="px-5">
                @csrf
                <div class="search-container position-relative mb-4">
                    <input type="url" name="url" class="form-control form-control-lg rounded-pill ps-4 py-3 border-2" 
                           placeholder="Enter website URL (e.g., https://www.travelblog.com)" required
                           style="border-color: #e2e8f0; font-size: 1.1rem;">
                    <button type="submit" class="btn btn-navy position-absolute end-0 top-0 mt-2 me-2 rounded-pill px-4 py-2">
                        Get Analytics <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>

            <div class="row mt-5 g-4 px-4 text-start">
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-4 border">
                        <i class="fas fa-chart-line text-primary mb-2"></i>
                        <h6 class="fw-bold mb-1">Precise Traffic</h6>
                        <small class="text-muted">Get monthly visitor counts and page views accurately.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-4 border">
                        <i class="fas fa-users-rays text-warning mb-2"></i>
                        <h6 class="fw-bold mb-1">Source Analysis</h6>
                        <small class="text-muted">Detect where traffic comes from: Organic, Social, or Ads.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-4 border">
                        <i class="fas fa-map-location-dot text-success mb-2"></i>
                        <h6 class="fw-bold mb-1">Global Reach</h6>
                        <small class="text-muted">Identify top countries and audience demographics.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus {
        box-shadow: 0 0 0 4px rgba(11, 61, 97, 0.1);
        border-color: #0b3d61;
    }
</style>
@endpush

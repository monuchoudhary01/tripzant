@extends('layouts.hotel_master')

@section('title', 'Property Management | Partner Super App')

@section('content')
<div class="mb-5 d-flex justify-content-between align-items-center border-bottom pb-4">
    <div>
        <h2 class="outfit fw-900 text-navy mb-1" style="letter-spacing: -1.5px; font-size: 32px;">Asset Management</h2>
        <p class="text-muted fw-600 mb-0">Update your hotel's profile, photos, and core amenities for dynamic distribution.</p>
    </div>
    <button class="ps-btn-primary px-5 py-2">PUBLISH CHANGES</button>
</div>

<div class="row g-5">
    <div class="col-lg-7">
        <div class="bg-white p-5 rounded-4 border border-faint mb-4">
             <h5 class="outfit fw-800 text-navy mb-4">Basic Profile Detail</h5>
             <div class="mb-4">
                  <label class="small fw-800 text-muted uppercase mb-2">Display Name</label>
                  <input type="text" class="form-control py-3 fw-700 bg-light border-0" value="Radisson Blu Plaza Hotel, Delhi Airport">
             </div>
             <div class="row g-3 mb-4">
                  <div class="col-md-6">
                       <label class="small fw-800 text-muted uppercase mb-2">Star Rating</label>
                       <select class="form-select py-3 fw-700 bg-light border-0">
                           <option>5 Star Luxury</option>
                           <option>4 Star Boutique</option>
                       </select>
                  </div>
                  <div class="col-md-6">
                       <label class="small fw-800 text-muted uppercase mb-2">Total Room Count</label>
                       <input type="number" class="form-control py-3 fw-700 bg-light border-0" value="120">
                  </div>
             </div>
             <div class="mb-4">
                  <label class="small fw-800 text-muted uppercase mb-2">Property Description</label>
                  <textarea rows="4" class="form-control fw-700 bg-light border-0">A world-class luxury hotel located near IGI Airport. Offering 120 rooms, 3 restaurants, and an award-winning spa.</textarea>
             </div>
        </div>

        <div class="bg-white p-5 rounded-4 border border-faint">
             <h5 class="outfit fw-800 text-navy mb-4">Photo Gallery</h5>
             <div class="row g-3">
                  <div class="col-3">
                       <div class="ratio ratio-1x1 bg-light rounded border-2 border-dashed d-flex align-items-center justify-content-center">
                            <i class="fas fa-plus text-muted"></i>
                       </div>
                  </div>
                  @for($i=1; $i<=3; $i++)
                  <div class="col-3">
                       <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=200" class="img-fluid rounded shadow-sm">
                  </div>
                  @endfor
             </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="bg-white p-5 rounded-4 border border-faint mb-4 text-center">
             <img src="https://ui-avatars.com/api/?name=RB&background=101828&color=fff&bold=true&size=100" class="rounded-pill mb-3">
             <h5 class="outfit fw-900 text-navy mb-1">Upload Hotel Logo</h5>
             <p class="text-muted small fw-600">Standard: 512x512px (PNG/JPG)</p>
             <button class="btn btn-sm btn-outline-dark px-4 py-2 mt-2 rounded-pill small fw-800">CHANGE BRANDING</button>
        </div>

        <div class="bg-white p-5 rounded-4 border border-faint">
             <h5 class="outfit fw-800 text-navy mb-4">Core Amenities</h5>
             @foreach(['Free Wi-Fi', 'Swimming Pool', '24h Room Service', 'Business Center', 'Free Parking'] as $amenity)
             <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" checked>
                  <label class="form-check-label fw-700 small text-navy ms-2">{{ $amenity }}</label>
             </div>
             @endforeach
        </div>
    </div>
</div>
@endsection

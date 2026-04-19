@extends('layouts.hotel_master')

@section('title', 'Guest Profile | QuikHotel B2B')

@section('styles')
<style>
    .h-step-line {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 40px;
    }
    .h-step { width: 40px; height: 40px; border-radius: 12px; background: #fff; border: 2px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #94a3b8; font-size: 14px; position: relative; }
    .h-step.active { background: #2563eb; border-color: #2563eb; color: #fff; box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2); }
    .h-step-label { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
    .h-step.active + .h-step-label { color: #1e293b; }
    
    .h-form-group { margin-bottom: 15px; }
    .h-form-group label { display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 1px; margin-bottom: 8px; }
    .h-form-group input, .h-form-group select { background: #f8fafc; border: 2px solid transparent; border-radius: 12px; padding: 14px 18px; font-weight: 700; width: 100%; transition: 0.3s; color: #1e293b; }
    .h-form-group input:focus { background: #fff; border-color: #2563eb; outline: none; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1); }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="h-step-line">
            <div class="h-step active">1</div>
            <div class="h-step-label">Guest Profile</div>
            <div class="h-step" style="width: 30px; height: 2px; background: #e2e8f0;"></div>
            <div class="h-step">2</div>
            <div class="h-step-label">Review & Pay</div>
            <div class="h-step" style="width: 30px; height: 2px; background: #e2e8f0;"></div>
            <div class="h-step">3</div>
            <div class="h-step-label">Confirmation</div>
        </div>

        <div class="h-glass-card border-0 mb-4 p-5">
            <h4 class="outfit fw-900 text-navy mb-4">Primary Guest Particulars</h4>
            <div class="row g-4">
                 <div class="col-md-3">
                     <div class="h-form-group">
                         <label>Title</label>
                         <select>
                             <option>Mr.</option>
                             <option>Mrs.</option>
                             <option>Ms.</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-9">
                     <div class="h-form-group">
                         <label>Full Legal Name (As in Passport)</label>
                         <input type="text" placeholder="First & Middle Name + Last Name" value="AMANKUMAR GUPTA">
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="h-form-group">
                         <label>Contact Email</label>
                         <input type="email" placeholder="guest@email.com" value="aman@example.com">
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="h-form-group">
                         <label>Handheld Number</label>
                         <input type="text" placeholder="+91 00000 00000" value="+91 9876543210">
                     </div>
                 </div>
            </div>
        </div>

        <div class="h-glass-card border-0 mb-5 p-5">
            <h4 class="outfit fw-900 text-navy mb-4">Room 1 Configuration</h4>
            <p class="text-muted small fw-600 mb-4">Selected: Superior King Room • Airport View</p>
            <div class="row g-4">
                 <div class="col-md-2">
                     <div class="h-form-group">
                         <label>Title</label>
                         <select><option>Ms.</option></select>
                     </div>
                 </div>
                 <div class="col-md-5">
                     <div class="h-form-group">
                         <label>Guest 2 - First Name</label>
                         <input type="text" placeholder="First Name" value="PRIYA">
                     </div>
                 </div>
                 <div class="col-md-5">
                     <div class="h-form-group">
                         <label>Guest 2 - Last Name</label>
                         <input type="text" placeholder="Last Name" value="SHARMA">
                     </div>
                 </div>
            </div>
        </div>

        <div class="h-glass-card border-0 mb-5 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="outfit fw-900 text-navy mb-0">Corporate GST Billing?</h4>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="gstSwitch">
                </div>
            </div>
            <p class="text-muted small fw-600 mb-0">Enable this to add tax invoice details for ITR compliance.</p>
        </div>
    </div>

    <!-- Sticky Price Sidebar -->
    <div class="col-lg-4">
        <div class="sticky-top" style="top: 130px;">
             <div class="h-glass-card shadow-lg border-2 border-primary border-opacity-10 mb-4 p-5">
                 <h6 class="outfit fw-900 text-navy mb-4">Booking Valuation</h6>
                 <div class="d-flex justify-content-between mb-2">
                     <span class="fw-700 text-muted small">Stay Subtotal (2 Guests)</span>
                     <span class="fw-700 text-navy small">₹14,500</span>
                 </div>
                 <div class="d-flex justify-content-between mb-2">
                     <span class="fw-700 text-muted small">Taxes & Levies</span>
                     <span class="fw-700 text-navy small">₹2,610</span>
                 </div>
                 <hr class="my-4 op-2">
                 <div class="d-flex justify-content-between mb-5">
                     <span class="fw-900 text-navy h5 mb-0">Aggregate Total</span>
                     <span class="fw-900 text-navy h3 mb-0 outfit">₹17,110</span>
                 </div>

                 <div class="bg-success text-white p-3 rounded-4 mb-5 text-center">
                     <div class="fw-800" style="font-size: 11px;">ESTIMATED PROFIT: ₹2,450</div>
                 </div>

                 <button class="btn btn-premium w-100 py-3 rounded-pill" onclick="location.href='{{ route('hotel.confirm') }}'">AUTHORIZE & BOOK</button>
                 <button class="btn btn-link w-100 text-decoration-none tiny fw-800 text-muted mt-3 uppercase">Terms & Cancellation Policy</button>
             </div>
        </div>
    </div>
</div>
@endsection

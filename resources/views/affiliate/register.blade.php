@extends('layouts.app')

@section('content')
<div class="signup-container py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="registration-card p-5" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.1); color: white;">
                    <div class="text-center mb-5">
                        <h2 style="font-weight: 800; letter-spacing: -1px; background: linear-gradient(to right, #60a5fa, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Become a Service Provider</h2>
                        <p class="text-white-50">Grow your business with Trip Zant Marketplace & Affiliate System</p>
                    </div>

                    <form action="{{ route('affiliate.register.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label text-white-50">Full Name</label>
                                <input type="text" name="name" class="form-control text-white" placeholder="e.g. John Doe" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50">Email</label>
                                <input type="email" name="email" class="form-control text-white" placeholder="email@example.com" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50">Mobile Number</label>
                                <input type="text" name="phone" class="form-control text-white" placeholder="+91" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-white-50">Service Category</label>
                                <select name="service_category" class="form-select text-white" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                                    <option value="Barber">Barber</option>
                                    <option value="Tutor">Home Tutor</option>
                                    <option value="Cleaner">Home Cleaner</option>
                                    <option value="Plumber">Plumber</option>
                                    <option value="Photographer">Photographer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50">Base Pricing (₹/hr)</label>
                                <input type="number" name="pricing" class="form-control text-white" placeholder="499" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50">Location</label>
                                <input type="text" name="location" class="form-control text-white" placeholder="City, Area" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50">Password</label>
                                <input type="password" name="password" class="form-control text-white" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control text-white" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; height: 50px;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-5 py-3" style="border-radius: 12px; background: linear-gradient(to right, #3b82f6, #8b5cf6); border: none; font-weight: 700; font-size: 1.1rem; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);">
                            Submit Application
                        </button>
                    </form>

                    <div class="text-center mt-4 text-white-50">
                        Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control::placeholder { color: rgba(255,255,255,0.3); }
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.08);
        border-color: #60a5fa;
        color: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

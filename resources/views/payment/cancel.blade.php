@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-warning" style="font-size: 80px;"></i>
                    </div>
                    <h2 class="mb-3">Payment Cancelled</h2>
                    <p class="text-muted mb-4">The payment process for <strong>{{ $gateway }}</strong> was cancelled or interrupted.</p>
                    
                    <p class="mb-4">If you encountered any issues, please contact our support team.</p>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('test.mpgs') }}" class="btn btn-outline-primary px-4">Try Again</a>
                        <a href="{{ route('home') }}" class="btn btn-primary px-4">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 80px;"></i>
                    </div>
                    <h2 class="mb-3">Gateway Error</h2>
                    <p class="text-danger mb-4"><strong>Message:</strong> {{ $message }}</p>
                    
                    <p class="text-muted mb-4">There was an issue connecting to the Mastercard MPGS gateway. Please check your credentials and API status.</p>

                    <a href="{{ route('home') }}" class="btn btn-primary px-5">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

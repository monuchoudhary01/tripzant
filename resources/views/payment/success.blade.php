@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    </div>
                    <h2 class="mb-3">Payment Successful!</h2>
                    <p class="text-muted mb-4">Your payment via <strong>{{ $gateway }}</strong> has been processed successfully.</p>
                    
                    <div class="bg-light p-4 rounded mb-4 text-left">
                        <h6>Transaction Details:</h6>
                        <hr>
                        @if(isset($data))
                            @foreach($data as $key => $value)
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">{{ ucfirst($key) }}:</span>
                                    <span>{{ is_array($value) ? json_encode($value) : $value }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <a href="{{ localized_url('/') }}" class="btn btn-primary btn-lg px-5">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.user_dashboard')

@section('title', 'Track Shipment | TripZant')

@section('content')
<div class="container-fluid py-4" style="background-color: #f0f2f5;">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('cargo.dashboard.index') }}">Cargo Dashboard</a></li>
                    <li class="breadcrumb-item active">Shipment Tracking</li>
                </ol>
            </nav>
            <h3 class="fw-bold">Shipment #{{ $booking->booking_ref }}</h3>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div id="tracking-map" style="height: 480px; background-color: #f1f3f5; position: relative;">
                    <!-- Real-time Tracking Map Hook -->
                    <div id="google-map-root" class="h-100 w-100"></div>
                    
                    <div class="map-overlay-center text-center py-5 d-none" id="map-loader">
                        <i class="fas fa-satellite-dish fa-spin fa-2x text-primary mb-2"></i>
                        <p class="small fw-bold">Connecting to Live GPS Satellite...</p>
                    </div>
                </div>
            </div>
        </div>

<script async src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initTrackingMap"></script>
<script>
    let map, marker, directionsService, directionsRenderer;

    function initTrackingMap() {
        // Initial center at origin or current status
        const myLatLng = { lat: {{ $booking->tracking->last()->latitude ?? -37.8136 }}, lng: {{ $booking->tracking->last()->longitude ?? 144.9631 }} };
        
        map = new google.maps.Map(document.getElementById("google-map-root"), {
            zoom: 12,
            center: myLatLng,
            styles: [
                { "featureType": "all", "elementType": "labels.text.fill", "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}] },
                { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#fefefe"}, {"lightness": 20}] }
            ]
        });

        marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "Shipment Current Location",
            icon: {
                url: "https://cdn-icons-png.flaticon.com/512/754/754848.png", // Delivery Truck Icon
                scaledSize: new google.maps.Size(40, 40)
            }
        });

        // Simulating Real-time Movement (Module 3: Live Vehicle Movement)
        setInterval(() => {
            // Fetch updated location via AJAX in real implementation
            console.log("Polling updated GPS coordinates...");
        }, 30000);
    }
</script>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Shipment Progress</h5>
                <div class="tracking-timeline">
                    @php
                        $statuses = [
                            'Pickup scheduled', 
                            'Picked up', 
                            'Warehouse received', 
                            'Customs clearance', 
                            'In Transit', 
                            'Out for delivery', 
                            'Delivered'
                        ];
                        $currentIdx = array_search($booking->status, $statuses);
                        if($currentIdx === false) $currentIdx = 0; // Fallback
                    @endphp

                    @foreach($statuses as $index => $status)
                    <div class="timeline-item d-flex pb-4 @if($index <= $currentIdx) active @endif">
                        <div class="timeline-status-icon me-3">
                            <div class="status-circle @if($index < $currentIdx) bg-success @elseif($index == $currentIdx) bg-primary @else bg-light @endif">
                                @if($index < $currentIdx)
                                <i class="fas fa-check text-white small"></i>
                                @else
                                <div class="inner-dot"></div>
                                @endif
                            </div>
                            @if(!$loop->last)
                            <div class="status-line"></div>
                            @endif
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1 fw-bold @if($index > $currentIdx) text-muted @endif">{{ $status }}</h6>
                            @if($index == $currentIdx)
                                @php $log = $booking->tracking->where('status', $status)->first(); @endphp
                                <p class="mb-0 small text-muted">{{ $log->description ?? 'Parcel has reached this stage.' }}</p>
                                @if($log)
                                    <small class="text-primary fw-bold">{{ $log->created_at->format('H:i A, d M') }}</small>
                                @else
                                    <small class="text-primary fw-bold">{{ $booking->updated_at->format('H:i A, d M') }}</small>
                                @endif
                            @elseif($index < $currentIdx)
                                @php $log = $booking->tracking->where('status', $status)->first(); @endphp
                                @if($log)
                                    <small class="text-muted">{{ $log->created_at->format('d M, H:i') }}</small>
                                @else
                                    <small class="text-muted opacity-50">Completed</small>
                                @endif
                            @else
                                <small class="text-muted opacity-50 italic">Scheduled</small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Shipment Sidebar -->
        <div class="col-md-4">
            <!-- Tax Exemption Module -->
            @if(isset($exemption))
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-navy text-white overflow-hidden">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-uppercase ls-1">Tax Exemption Letter</h6>
                        <span class="badge bg-success rounded-pill px-3">CERTIFIED</span>
                    </div>
                    <div class="bg-white rounded-4 p-3 mb-3 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('/cargo/verify/'.$booking->tracking_id)) }}" class="img-fluid rounded-3" style="max-width: 120px;">
                        <div class="mt-2 text-dark x-small font-monospace">{{ $booking->tracking_id }}</div>
                    </div>
                    <p class="small opacity-75 mb-4">Your shipment is eligible for tax exemption. Download the official certification for customs.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('cargo.dashboard.label.shipping', $booking->booking_ref) }}" target="_blank" class="btn btn-warning text-dark rounded-pill btn-sm fw-bold"><i class="fas fa-print me-1"></i> Print Shipping Label</a>
                        <a href="{{ route('cargo.dashboard.letter.download', $booking->booking_ref) }}" target="_blank" class="btn btn-primary rounded-pill btn-sm">Download Official PDF</a>
                        <a href="{{ url('/cargo/verify/'.$booking->tracking_id) }}" target="_blank" class="btn btn-outline-light rounded-pill btn-sm">Preview Verification</a>
                    </div>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Sender & Receiver</h5>
                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-soft-primary me-3">
                            <i class="fas fa-arrow-up text-primary small"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px;">FROM</small>
                            <h6 class="mb-1 fw-bold">{{ $booking->sender_details['name'] ?? 'N/A' }}</h6>
                            <p class="small text-muted mb-0">{{ $booking->sender_details['address'] ?? 'No address provided' }}</p>
                        </div>
                    </div>
                    <div class="d-flex border-top pt-4">
                        <div class="icon-circle bg-soft-success me-3">
                            <i class="fas fa-arrow-down text-success small"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px;">TO</small>
                            <h6 class="mb-1 fw-bold">{{ $booking->receiver_details['name'] ?? 'N/A' }}</h6>
                            <p class="small text-muted mb-0">{{ $booking->receiver_details['address'] ?? 'No address provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-gradient-dark text-white">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Item Details</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <small class="opacity-75 d-block">Weight</small>
                            <span class="fw-bold">{{ $booking->weight }} KG</span>
                        </div>
                        <div class="col-6">
                            <small class="opacity-75 d-block">Type</small>
                            <span class="fw-bold">{{ $booking->parcel_type }}</span>
                        </div>
                        <div class="col-6">
                            <small class="opacity-75 d-block">Urgency</small>
                            <span class="fw-bold">{{ $booking->urgency }}</span>
                        </div>
                        <div class="col-6">
                            <small class="opacity-75 d-block">Insurance</small>
                            <span class="fw-bold">{{ $booking->insurance->insurance_plan ?? 'None' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <i class="fas fa-headset fa-2x text-muted mb-3"></i>
                <h6 class="fw-bold">Need Help?</h6>
                <p class="small text-muted">Contact our cargo support for any issues with your shipment.</p>
                <button class="btn btn-outline-primary rounded-pill w-100">Live Support Chat</button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1); }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); }
    .bg-gradient-dark { background: linear-gradient(135deg, #2c3e50, #000000); }
    
    .timeline-status-icon { position: relative; width: 30px; }
    .status-circle { 
        width: 14px; height: 14px; border-radius: 50%; margin: 6px auto; position: relative; z-index: 2;
        display: flex; align-items: center; justify-content: center;
    }
    .status-line { 
        position: absolute; top: 14px; left: 14px; width: 2px; height: 100%; 
        background-color: #e9ecef; z-index: 1; 
    }
    .timeline-item.active .status-line { background-color: #4e73df; }
    .timeline-item.active .status-circle { box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1); }
    .inner-dot { width: 6px; height: 6px; background-color: #dee2e6; border-radius: 50%; }
    .status-circle.bg-primary .inner-dot { background-color: white; }

    .icon-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
</style>
@endsection

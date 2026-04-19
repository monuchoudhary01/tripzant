@extends('layouts.hotel_master')
@section('title', 'Webhook Logs | Automation Engine')
@section('content')
<div class="p-5 text-center shadow-sm rounded-5 bg-white border border-faint">
    <div class="h1 text-primary opacity-25 mb-4"><i class="fas fa-robot fa-3x"></i></div>
    <h3 class="outfit fw-900 text-navy mb-3">Live XML Webhook Stream</h3>
    <p class="text-muted fw-700 mx-auto" style="max-width: 500px;">This real-time terminal listens to incoming traffic from Booking.com & Agoda. New Booking IDs will appear here automatically.</p>
    <div class="bg-dark p-4 rounded-4 text-start mt-5" style="max-height: 400px; overflow: auto; font-family: monospace; font-size: 13px; color: #10b981; line-height: 2;">
         <div>[2026-04-07 17:05:22] - INFO: XML Listener Active on Port 8000</div>
         <div>[2026-04-07 17:08:44] - SUCCESS: Incoming POST /webhooks/booking-com -> Status 200 OK</div>
         <div>[2026-04-07 17:08:45] - PROCESS: Parsing Reservation #88271... Completed in 12ms</div>
         <div>[2026-04-07 17:08:46] - AUTO: Inventory Reduced for 'Deluxe Suite' (-1)</div>
         <div class="animate__animated animate__pulse animate__infinite mt-2">-- Listening for new OTA signals --</div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Voucher - #HTL-AU-98122</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; padding: 40px; }
        .voucher-paper { background: #fff; width: 800px; margin: 0 auto; padding: 60px; border-radius: 4px; box-shadow: 0 4px 30px rgba(0,0,0,0.05); position: relative; }
        .v-header { border-bottom: 2px solid #f1f5f9; padding-bottom: 30px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; }
        .v-logo { font-size: 24px; font-weight: 800; color: #0f172a; }
        .v-badge { background: #dcfce7; color: #16a34a; font-weight: 800; padding: 8px 16px; border-radius: 4px; font-size: 11px; text-transform: uppercase; }
        
        .section-title { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 5px; }
        .data-row { margin-bottom: 30px; }
        .data-label { color: #64748b; font-size: 12px; font-weight: 600; }
        .data-value { color: #0f172a; font-size: 15px; font-weight: 800; }
        
        .booking-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .booking-table th { background: #f8fafc; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 12px; text-align: left; }
        .booking-table td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #1e293b; font-weight: 700; }
        
        .qr-area { text-align: right; }
        .qr-placeholder { width: 100px; height: 100px; background: #f8fafc; border: 1px solid #e2e8f0; display: inline-block; padding: 10px; }
        
        @media print {
            body { background: #fff; padding: 0; }
            .voucher-paper { box-shadow: none; width: 100%; border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="text-center no-print mb-4">
    <button class="btn btn-dark px-5 py-2 fw-bold" onclick="window.print()">PRINT VOUCHER</button>
    <a href="{{ route('hotel.confirm') }}" class="btn btn-light px-4 py-2 fw-bold ms-2">BACK</a>
</div>

<div class="voucher-paper">
    <div class="v-header">
        <div>
            <div class="v-logo">HotelDeal <small class="text-muted" style="font-size: 10px; vertical-align: middle;">SERVICE VOUCHER</small></div>
            <div class="small fw-bold text-muted">Booking Reference: #HTL-AU-98122</div>
        </div>
        <div class="qr-area">
             <div class="v-badge mb-3">CONFIRMED & PREPAID</div>
             <div class="qr-placeholder"><img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=HTL-AU-98122" width="80"></div>
        </div>
    </div>

    <div class="row data-row">
        <div class="col-6">
            <div class="section-title">Property Information</div>
            <div class="data-value" style="font-size: 18px;">Radisson Blu Plaza Hotel</div>
            <div class="data-label">Mahipalpur, Near IGI Airport, New Delhi, India</div>
            <div class="data-label mt-1">Phone: +91 11-26779000</div>
        </div>
        <div class="col-6 text-end">
            <div class="section-title">Check-in / Check-out</div>
            <div class="data-value">Check-in: 25 May 2024 (14:00)</div>
            <div class="data-value">Check-out: 02 June 2024 (12:00)</div>
            <div class="data-label mt-1">Duration: 8 Nights Stay</div>
        </div>
    </div>

    <div class="section-title">Passenger Detail (Main Guest)</div>
    <div class="row data-row">
        <div class="col-4">
            <div class="data-label">Primary Guest</div>
            <div class="data-value">Mr. Mark Sydney</div>
        </div>
        <div class="col-4">
            <div class="data-label">Travelers</div>
            <div class="data-value">10 Adults (Group)</div>
        </div>
        <div class="col-4">
            <div class="data-label">Nationality</div>
            <div class="data-value">Australian</div>
        </div>
    </div>

    <div class="section-title">Inclusions & Accommodation</div>
    <table class="booking-table">
        <thead>
            <tr>
                <th>Room Category</th>
                <th>Quantity</th>
                <th>Meal Plan</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Superior Twin Room</td>
                <td>5 Rooms</td>
                <td>Breakfast Buffet (BB)</td>
                <td>Non-Smoking, High Floor Requested</td>
            </tr>
        </tbody>
    </table>

    <div class="row mt-5">
        <div class="col-7">
            <div class="section-title">Important Instructions</div>
            <ul class="tiny text-muted fw-bold ps-3" style="font-size: 11px;">
                <li>Please present this voucher and a valid Photo ID at the time of check-in.</li>
                <li>Standard Check-in time is 14:00 hrs and Check-out is 12:00 hrs.</li>
                <li>Incidental charges (Mini-bar, Phone, Laundry) to be paid directly to the hotel.</li>
                <li>For any assistance, contact our 24/7 helpline: +91 99999 99999</li>
            </ul>
        </div>
        <div class="col-5">
             <div class="bg-light p-4 rounded text-center">
                  <div class="tiny fw-bold text-muted uppercase">Authorized Issuing Signature</div>
                  <div class="mt-4" style="font-family: 'Dancing Script', cursive; font-size: 24px; color: #1e40af;">Team HotelDeal</div>
                  <div class="border-top mt-2 pt-1 tiny text-muted">EasiTrip B2B Terminal</div>
             </div>
        </div>
    </div>
</div>

</body>
</html>

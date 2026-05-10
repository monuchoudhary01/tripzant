<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hotel Voucher - {{ $booking->booking_reference }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 0; }
        .header { background: #0f172a; color: #fff; padding: 30px; text-align: center; }
        .voucher-title { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .ref { font-size: 14px; opacity: 0.7; }
        .content { padding: 40px; }
        .hotel-name { font-size: 20px; font-weight: bold; color: #0077ff; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table td { padding: 15px; border: 1px solid #eee; }
        .label { font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px; }
        .val { font-size: 14px; font-weight: bold; color: #333; }
        .pax-section { margin-top: 20px; }
        .pax-title { font-size: 16px; font-weight: bold; margin-bottom: 15px; background: #f8fafc; padding: 10px; border-left: 4px solid #0077ff; }
        .pax-list { list-style: none; padding: 0; }
        .pax-item { padding: 8px 0; border-bottom: 1px solid #f1f1f1; font-size: 13px; }
        .footer { position: fixed; bottom: 30px; width: 100%; text-align: center; font-size: 10px; color: #999; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; background: #eefdf3; color: #10b981; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="voucher-title">HOTEL ACCOMMODATION VOUCHER</div>
        <div class="ref">Booking ID: {{ $booking->booking_reference }} | Booked On: {{ $booking->created_at->format('d M Y') }}</div>
    </div>

    <div class="content">
        <div class="hotel-name">{{ $details['hotel_name'] ?? 'Premium Hotel' }}</div>
        
        <table class="details-table">
            <tr>
                <td>
                    <div class="label">Check In</div>
                    <div class="val">{{ date('D, d M Y', strtotime($details['check_in'])) }}</div>
                </td>
                <td>
                    <div class="label">Check Out</div>
                    <div class="val">{{ date('D, d M Y', strtotime($details['check_out'])) }}</div>
                </td>
                <td style="text-align: right;">
                    <div class="label">Status</div>
                    <div class="status-badge">{{ strtoupper($booking->status) }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label">Room Category</div>
                    <div class="val">{{ $details['room_name'] ?? 'Standard Room' }}</div>
                </td>
                <td>
                    <div class="label">Guests</div>
                    <div class="val">{{ $details['adults'] ?? 1 }} Adults, {{ $details['children'] ?? 0 }} Children</div>
                </td>
                <td style="text-align: right;">
                    <div class="label">Amount Paid</div>
                    <div class="val">₹{{ number_format($booking->total_amount, 2) }}</div>
                </td>
            </tr>
        </table>

        <div class="pax-section">
            <div class="pax-title">Traveler Manifest</div>
            <ul class="pax-list">
                @foreach($details['paxes'] ?? [] as $pax)
                    <li class="pax-item">
                        <strong>{{ $pax['title'] ?? 'Mr' }}. {{ $pax['name'] }} {{ $pax['surname'] }}</strong> - {{ ucfirst($pax['type'] ?? 'Adult') }}
                    </li>
                @endforeach
                @if(empty($details['paxes']))
                    <li class="pax-item text-muted">Guest details not found.</li>
                @endif
            </ul>
        </div>

        <div style="margin-top: 40px; padding: 20px; background: #fffbeb; border-radius: 10px; font-size: 12px; border: 1px solid #fde68a;">
            <strong>Important Information:</strong>
            <ul style="margin-top: 10px; color: #92400e;">
                <li>Please present this voucher and a valid photo ID at the time of check-in.</li>
                <li>Standard check-in time is usually 2:00 PM and check-out is 11:00 AM.</li>
                <li>Any additional charges like mini-bar, laundry, etc. must be paid directly to the hotel.</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        Tripzant.com - Your Gateway to the World | Support: support@tripzant.com | Secure Booking Service
    </div>
</body>
</html>

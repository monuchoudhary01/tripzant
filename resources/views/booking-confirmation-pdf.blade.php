<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket - {{ $pnr }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .header {
            background-color: #003366;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #10b981;
        }
        .content {
            padding: 30px;
        }
        .pnr-box {
            background-color: #f0f7ff;
            border: 2px dashed #005eb8;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .pnr-code {
            font-size: 28px;
            font-weight: bold;
            color: #005eb8;
            letter-spacing: 2px;
        }
        .status {
            color: #15803d;
            font-weight: bold;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8fafc;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #666; }
        .small { font-size: 12px; }
        .leg-title {
            background: #003366;
            color: white;
            padding: 8px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .section-title {
            color: #003366;
            border-bottom: 2px solid #005eb8;
            padding-bottom: 5px;
            margin-bottom: 15px;
            margin-top: 30px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TRIPZANT E-TICKET</h1>
        <p>Booking Confirmed & Ticketed</p>
    </div>

    <div class="content">
        <div style="float: right;">
            <p class="small text-muted" style="margin:0;">TRANSACTION ID</p>
            <p class="fw-bold" style="margin:0;">#{{ $booking->booking_reference ?? 'N/A' }}</p>
        </div>
        <div style="clear: both;"></div>

        @foreach($legs as $idx => $leg)
            @php 
                $legDepCity = $leg['departure_city'] ?? ($leg['dep_city'] ?? '???');
                $legArrCity = $leg['arrival_city'] ?? ($leg['arr_city'] ?? '???');
                $legDepTime = $leg['departure_at'] ?? ($leg['dep_time'] ?? now());
                $legArrTime = $leg['arrival_at'] ?? ($leg['arr_time'] ?? now()->addHours(2));
            @endphp
            <div class="leg-title">
                Flight {{ $idx + 1 }}: {{ $legDepCity }} to {{ $legArrCity }}
            </div>
            
            <div class="pnr-box">
                <div class="small text-muted" style="margin-bottom:5px;">{{ $idx === 0 ? 'AIRLINE PNR' : 'RETURN PNR' }}</div>
                <div class="pnr-code">{{ $pnrs[$idx] ?? $pnr ?? '------' }}</div>
            </div>

            <table>
                <tr>
                    <td width="50%">
                        <div class="small text-muted">DEPARTURE</div>
                        <div class="fw-bold" style="font-size:18px;">{{ $legDepCity }}</div>
                        <div>{{ date('D, M d, Y - H:i', strtotime($legDepTime)) }}</div>
                    </td>
                    <td width="50%" style="text-align:right;">
                        <div class="small text-muted">ARRIVAL</div>
                        <div class="fw-bold" style="font-size:18px;">{{ $legArrCity }}</div>
                        <div>{{ date('D, M d, Y - H:i', strtotime($legArrTime)) }}</div>
                    </td>
                </tr>
            </table>
        @endforeach

        <h3 class="section-title">Flight Details</h3>
        <table>
            <tr>
                <th>Airline</th>
                <th>Flight No</th>
                <th>From - To</th>
                <th>Cabin</th>
            </tr>
            @foreach($legs as $leg)
            <tr>
                <td class="fw-bold">{{ $leg['airline_name'] ?? ($leg['airline'] ?? 'N/A') }}</td>
                <td>{{ $leg['airline_code'] ?? '' }} {{ $leg['flight_number'] ?? '' }}</td>
                <td>{{ $leg['departure_city'] }} - {{ $leg['arrival_city'] }}</td>
                <td>{{ ucfirst(strtolower($leg['cabin'] ?? 'Economy')) }}</td>
            </tr>
            @endforeach
        </table>

        <h3 class="section-title">Passenger Details</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Seat</th>
                <th>Status</th>
            </tr>
            @php
                $passengers = [];
                if(isset($dbPassengers) && $dbPassengers->count() > 0) {
                    foreach($dbPassengers as $p) {
                        $passengers[] = [
                            'title' => $p->title,
                            'first_name' => $p->first_name,
                            'last_name' => $p->last_name,
                            'seat' => $p->seat_number
                        ];
                    }
                }
            @endphp
            @forelse($passengers as $tIdx => $p)
            <tr>
                <td class="fw-bold">{{ $p['first_name'] ?? 'Guest' }} {{ $p['last_name'] ?? '' }}</td>
                <td>{{ $p['title'] ?? 'Mr' }} · Adult</td>
                <td class="fw-bold" style="color: #005eb8;">{{ $p['seat'] ?? 'Auto' }}</td>
                <td style="color: #15803d; font-weight:bold;">ALLOCATED</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">No passenger details found.</td>
            </tr>
            @endforelse
        </table>

        <table style="width: 50%; float: right; margin-top: 20px;">
            <tr>
                <th style="background: transparent; text-align:right;">Total Paid:</th>
                <td style="text-align:right; font-size:20px; font-weight:bold; color:#005eb8;">
                    Rs. {{ number_format($booking->total_amount ?? 0) }}
                </td>
            </tr>
        </table>
        <div style="clear: both;"></div>

        <div class="footer">
            Thank you for booking with Tripzant.<br>
            For support, contact us at support@tripzant.com
        </div>
    </div>
</body>
</html>

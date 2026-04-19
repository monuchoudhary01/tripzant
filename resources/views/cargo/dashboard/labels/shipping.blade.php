<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shipping Label - {{ $booking->tracking_id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; padding: 0; margin: 0; background: #eee; }
        .label-container { width: 100mm; height: 150mm; background: white; margin: 20px auto; border: 2px solid #000; padding: 10px; position: relative; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #000; padding-bottom: 5px; margin-bottom: 10px; align-items: center; }
        .logo { font-weight: 800; font-size: 20px; color: #000; letter-spacing: -1px; }
        .partner-logo { font-size: 14px; font-weight: bold; background: #000; color: white; padding: 2px 8px; }
        
        .routing-info { font-size: 40px; font-weight: 900; text-align: center; border-bottom: 2px solid #000; margin-bottom: 10px; padding: 5px 0; }
        
        .address-box { font-size: 12px; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .address-title { font-weight: bold; text-transform: uppercase; font-size: 10px; color: #666; margin-bottom: 2px; }
        
        .barcode-section { text-align: center; margin-top: 15px; }
        .barcode-img { width: 80%; height: 60px; border: 1px solid #eee; }
        .tracking-id { font-family: 'Courier New', monospace; font-weight: bold; font-size: 16px; margin-top: 5px; }
        
        .qr-section { position: absolute; bottom: 15px; right: 15px; }
        .parcel-type { font-size: 14px; font-weight: bold; text-transform: uppercase; border: 2px solid #000; padding: 4px 10px; display: inline-block; margin-top: 10px; }
        
        .instructions { font-size: 8px; color: #333; margin-top: 15px; border-top: 1px solid #000; pt-2; }
        
        @media print {
            body { background: white; }
            .label-container { margin: 0; border: none; width: 100%; height: auto; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div style="text-align: center; margin-top: 20px;" class="btn-print">
        <button onclick="window.print()" style="padding: 10px 30px; border-radius: 50px; background: #001f3f; color: white; border: none; cursor: pointer; font-weight: bold;">Print Label</button>
    </div>

    <div class="label-container">
        <div class="header">
            <div class="logo text-uppercase">TRIPZANT CARGO</div>
            <div class="partner-logo">{{ strtoupper($carrier ?? 'DHL GLOBAL') }}</div>
        </div>

        <div class="routing-info">{{ strtoupper(substr($booking->origin_city, 0, 3)) }} - {{ strtoupper(substr($booking->destination_city, 0, 3)) }}</div>

        <div class="address-box">
            <div class="address-title">From / Consignor</div>
            <div style="font-weight: bold;">{{ $sender->name ?? 'Sender Name' }}</div>
            <div>{{ $sender->address ?? 'Pick-up Address' }}</div>
            <div>Phone: {{ $sender->phone ?? 'N/A' }}</div>
        </div>

        <div class="address-box">
            <div class="address-title">To / Consignee</div>
            <div style="font-weight: bold;">{{ $receiver->name ?? 'Receiver Name' }}</div>
            <div>{{ $receiver->address ?? 'Delivery Address' }}</div>
            <div>Phone: {{ $receiver->phone ?? 'N/A' }}</div>
        </div>

        <div class="parcel-type">{{ $booking->parcel_type }} - {{ $booking->weight }} KG</div>

        <div class="barcode-section">
            <div style="font-size: 10px; text-transform: uppercase; font-weight: bold;">TripZant Global Tracking</div>
            <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $booking->tracking_id }}&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&quitemargin=0&modulewidth=bw" class="barcode-img">
            <div class="tracking-id">{{ $booking->tracking_id }}</div>
        </div>

        <div class="qr-section">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data={{ urlencode(url('/cargo/verify/'.$booking->tracking_id)) }}">
        </div>

        <div class="instructions">
            <strong>GLOBAL VIRTUAL HUB INSTRUCTIONS:</strong><br>
            1. Affix this label securely to the parcel.<br>
            2. TripZant Agent will collect from Consignor.<br>
            3. Must be dropped at <strong>ANY Nearest {{ $carrier ?? 'Global' }} Hub</strong>.<br>
            4. Digital manifest verified. No commercial resale.
        </div>
    </div>
</body>
</html>

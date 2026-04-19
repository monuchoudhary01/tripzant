<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tax Exemption Certificate - {{ $booking->tracking_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f4f4; font-family: 'Times New Roman', serif; }
        .certificate-container { background: white; width: 210mm; min-height: 297mm; margin: 20px auto; padding: 40px; box-shadow: 0 0 10px rgba(0,0,0,0.1); position: relative; border: 15px solid #001f3f; }
        .header-logo { color: #001f3f; font-weight: 800; font-size: 28px; border-bottom: 2px solid #001f3f; padding-bottom: 10px; margin-bottom: 30px; letter-spacing: 1px; }
        .qr-code { position: absolute; top: 100px; right: 40px; text-align: center; }
        .section-title { background: #001f3f; color: white; padding: 5px 15px; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; font-size: 14px; }
        .details-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .declaration-box { margin-top: 40px; border: 1px dashed #001f3f; padding: 20px; font-style: italic; font-size: 14px; color: #333; }
        @media print {
            body { background: white; }
            .certificate-container { margin: 0; box-shadow: none; border: none; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center mt-3 btn-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill shadow">Save as PDF / Print Certificate</button>
    </div>

    <div class="certificate-container">
        <div class="header-logo text-uppercase">TRIPZANT CARGO GLOBAL</div>
        
        <div class="qr-code text-center">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('/cargo/verify/'.$booking->tracking_id)) }}" class="mb-2">
            <div class="small fw-bold font-monospace">{{ $booking->tracking_id }}</div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <div class="section-title">Consignor (Sender)</div>
                <div class="ps-2">
                    <h5 class="fw-bold mb-1">{{ $sender->name ?? 'John Doe' }}</h5>
                    <p class="mb-0 text-muted">{{ $sender->address ?? 'Australia Branch' }}</p>
                    <p class="mb-0 text-muted">{{ $sender->phone ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="section-title">Consignee (Receiver)</div>
                <div class="ps-2">
                    <h5 class="fw-bold mb-1">{{ $receiver->name ?? 'Receiver Name' }}</h5>
                    <p class="mb-0 text-muted">{{ $receiver->address ?? 'Destination Address' }}</p>
                    <p class="mb-0 text-muted">{{ $receiver->phone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="section-title">Official Shipment Manifest</div>
            <table class="w-100 details-table">
                <tr><td>Booking Reference:</td><td class="fw-bold">{{ $booking->booking_ref }}</td></tr>
                <tr><td>Tracking ID:</td><td class="fw-bold fs-5">{{ $booking->tracking_id }}</td></tr>
                <tr><td>Item Description:</td><td class="fw-bold">{{ $item->desc ?? 'Cargo Contents' }}</td></tr>
                <tr><td>Category / Purpose:</td><td class="fw-bold">{{ $item->cat ?? 'Personal Use' }}</td></tr>
                <tr><td>Weight (KG):</td><td class="fw-bold">{{ $booking->weight }} KG</td></tr>
                <tr><td>Declared Value:</td><td class="fw-bold text-success">${{ number_format($item->val ?? 110, 2) }} AUD</td></tr>
            </table>
        </div>

        <div class="declaration-box text-center">
            <strong>OFFICIAL DECLARATION OF TAX EXEMPTION</strong><br>
            It is hereby certified that the goods described above are shipped for non-commercial personal use and fall under the legal threshold for tax exemption. 
            The contents have been digitally verified and contain no prohibited substances as per international aviation security protocols.
        </div>

        <div class="mt-5 pt-5 row">
            <div class="col-6 text-center">
                <div class="border-top pt-2" style="width: 150px; margin: 0 auto;">Authorized Signature</div>
                <small class="d-block text-muted">TripZant Logistics Hub</small>
            </div>
            <div class="col-6 text-center">
                <div class="border-top pt-2" style="width: 150px; margin: 0 auto;">Date of Issue</div>
                <small class="d-block text-muted">{{ date('d M, Y') }}</small>
            </div>
        </div>

        <footer class="mt-5 text-center small text-muted border-top pt-4">
            Verification ID: {{ hash('sha256', $booking->tracking_id) }}<br>
            Visit <strong>tripzant.com/verify</strong> to check authenticity.
        </footer>
    </div>
</body>
</html>

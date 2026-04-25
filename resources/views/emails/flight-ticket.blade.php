<!DOCTYPE html>
<html>
<head>
    <title>Flight Ticket Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #003366;">Hello!</h2>
        <p>Thank you for booking with Tripzant.</p>
        <p>Your flight booking (Reference: <strong>{{ $booking->booking_reference }}</strong>) is confirmed and ticketed.</p>
        <p>Please find your E-Ticket attached as a PDF document.</p>
        <br>
        <p>Safe travels!</p>
        <p><strong>Tripzant Team</strong></p>
    </div>
</body>
</html>

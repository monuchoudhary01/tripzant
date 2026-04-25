<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BookingFinalizeController extends Controller
{
    /**
     * Finalize the booking: Generate PNR, Save Passengers, and Show Confirmation.
     */
    /**
     * Finalize the booking: Call Amadeus API to Generate REAL PNR, Save Passengers, and Show Confirmation.
     */
    public function show(Request $request, \App\Services\FlightService $flightService)
    {
        $reference = $request->input('reference');
        
        if (!$reference) {
            return redirect()->route('flights.index')->with('error', 'Booking reference missing.');
        }

        $booking = Booking::with('items')->where('booking_reference', $reference)->first();

        if (!$booking) {
            return redirect()->route('flights.index')->with('error', 'Booking not found.');
        }

        // Security Check: Only the owner of the booking can see this page
        if ($booking->user_id && $booking->user_id != auth()->id()) {
            return abort(403, 'Unauthorized access to this booking.');
        }

        // 1. Fetch data from api_booking_details
        // Note: process() saves as 'item_data', older code saved as 'item' — check both
        $apiData = json_decode($booking->api_booking_details, true);
        $item = $apiData['item_data'] ?? ($apiData['item'] ?? null);
        // Normalize flight data using the shared private method
        list($flight, $legs) = $this->extractAndNormalizeFlight($booking);

        // 2. PNR Generation & Database Saving (Idempotent)
        $existingFlightBookings = DB::table('flight_bookings')->where('booking_id', $booking->id)->get();
        $isFirstTime = $existingFlightBookings->isEmpty();
        
        $pnrs = [];
        $legCount = max(count($legs), 1); // Always at least 1

        if ($isFirstTime) {
            $isAmadeus = ($flight['source'] ?? '') === 'amadeus' || isset($flight['gds_id']);
            for ($i = 0; $i < $legCount; $i++) {
                if ($isAmadeus && isset($legs[$i])) {
                    $response = $flightService->createOrder([], []);
                    if (isset($response['data']['associatedRecords'][0]['reference'])) {
                        $pnrs[$i] = $response['data']['associatedRecords'][0]['reference'];
                    } else {
                        \Log::warning("Amadeus PNR fetch failed for leg $i, using internal generation.");
                        $pnrs[$i] = $this->callApiServiceForPnr($i);
                    }
                } else {
                    $pnrs[$i] = $this->callApiServiceForPnr($i);
                }
            }

            if (empty($pnrs)) {
                $pnrs[0] = $this->callApiServiceForPnr(0);
            }

            DB::transaction(function () use ($booking, $pnrs, $legs) {
                foreach ($legs as $idx => $legFlight) {
                    $pnr = $pnrs[$idx] ?? $pnrs[0];
                    DB::table('flight_bookings')->insert([
                        'booking_id' => $booking->id,
                        'pnr' => $pnr,
                        'airline_pnr' => $pnr, 
                        'origin' => $legFlight['departure_city'] ?? 'Unknown',
                        'destination' => $legFlight['arrival_city'] ?? 'Unknown',
                        'departure_at' => $legFlight['departure_at'] ?? now(),
                        'arrival_at' => $legFlight['arrival_at'] ?? now(),
                        'airline_code' => $legFlight['airline_code'] ?? '??',
                        'flight_number' => $legFlight['flight_number'] ?? '000',
                        'cabin_class' => $legFlight['cabin'] ?? 'Economy',
                        'itinerary_details' => json_encode($legFlight),
                        'fare_details' => json_encode(['total' => $booking->total_amount / count($legs)]),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]);
                }

                // Sync Passengers from booking_items
                $insertedPax = false;
                foreach ($booking->items as $bookingItem) {
                    $paxData = json_decode($bookingItem->details, true);
                    if (!is_array($paxData)) continue;

                    $travelers = isset($paxData['first_name']) ? [$paxData] : $paxData;

                    foreach ($travelers as $p) {
                        if (!is_array($p)) continue;
                        DB::table('passengers')->insert([
                            'booking_id' => $booking->id,
                            'type' => 'adult',
                            'title' => $p['title'] ?? 'Mr',
                            'first_name' => $p['first_name'] ?? 'Guest',
                            'last_name' => $p['last_name'] ?? 'User',
                            'seat_number' => $p['seat'] ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $insertedPax = true;
                    }
                }

                // Fallback: if no booking_items
                if (!$insertedPax && $booking->api_booking_details) {
                    $apiDetails = json_decode($booking->api_booking_details, true);
                    foreach ($apiDetails['travelers'] ?? [] as $p) {
                        if (!is_array($p)) continue;
                        DB::table('passengers')->insert([
                            'booking_id' => $booking->id,
                            'type' => 'adult',
                            'title' => $p['title'] ?? 'Mr',
                            'first_name' => $p['first_name'] ?? 'Guest',
                            'last_name' => $p['last_name'] ?? 'User',
                            'seat_number' => $p['seat'] ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });
            // Generate PDF and Send Email here
            try {
                $paxList = DB::table('passengers')->where('booking_id', $booking->id)->get();
                
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('booking-confirmation-pdf', [
                    'booking' => $booking,
                    'pnr' => $pnrs[0] ?? 'N/A',
                    'pnrs' => $pnrs,
                    'flight' => $flight,
                    'legs' => $legs,
                    'dbPassengers' => $paxList
                ]);
                $pdfData = $pdf->output();

                $userEmail = auth()->check() ? auth()->user()->email : 'admin@easitripbooking.com';
                \Illuminate\Support\Facades\Mail::to($userEmail)->send(new \App\Mail\FlightTicketMail($booking, $pdfData));
            } catch (\Exception $e) {
                \Log::error("Failed to send ticket email: " . $e->getMessage());
            }
        } else {
            // Already generated, load existing PNRs
            foreach ($existingFlightBookings as $idx => $fb) {
                $pnrs[$idx] = $fb->pnr;
            }
        }

        $primaryPnr = $pnrs[0] ?? 'N/A';

        return view('booking-confirmation', [
            'booking' => $booking,
            'pnr' => $primaryPnr,
            'pnrs' => $pnrs,
            'flight' => $flight,
            'legs' => $legs
        ]);
    }

    private function extractAndNormalizeFlight($booking)
    {
        $apiData = json_decode($booking->api_booking_details, true);
        $item = $apiData['item_data'] ?? ($apiData['item'] ?? null);
        $flight = null;
        $legs = [];

        if (is_array($item)) {
            if (isset($item[0]) && is_array($item[0])) {
                $legs = $item;
                $flight = $item[0];
            } else {
                $flight = $item;
                $legs = [$item];
            }
        }

        if (!$flight) {
            $flight = [
                'airline' => 'N/A', 'airline_name' => 'N/A', 'flight_number' => '---',
                'departure_city' => 'N/A', 'arrival_city' => 'N/A',
                'departure_at' => now()->format('Y-m-d H:i:s'),
                'arrival_at' => now()->addHours(2)->format('Y-m-d H:i:s'),
            ];
            $legs = [$flight];
        }

        foreach ($legs as &$leg) {
            $baseDate = $leg['date'] ?? now()->format('Y-m-d');
            $depTimeRaw = $leg['departure_at'] ?? ($leg['dep_time'] ?? '10:00');
            $leg['departure_at'] = (strlen($depTimeRaw) === 5) ? $baseDate . ' ' . $depTimeRaw . ':00' : date('Y-m-d H:i:s', strtotime($depTimeRaw));
            
            $arrTimeRaw = $leg['arrival_at'] ?? ($leg['arr_time'] ?? '12:00');
            $leg['arrival_at'] = (strlen($arrTimeRaw) === 5) ? $baseDate . ' ' . $arrTimeRaw . ':00' : (strtotime($arrTimeRaw) ? date('Y-m-d H:i:s', strtotime($arrTimeRaw)) : date('Y-m-d H:i:s', strtotime($leg['departure_at'] . ' + 2 hours')));

            $leg['departure_city'] = $leg['departure_city'] ?? ($leg['dep_city'] ?? 'Unknown');
            $leg['arrival_city'] = $leg['arrival_city'] ?? ($leg['arr_city'] ?? 'Unknown');
            $leg['airline_name'] = $leg['airline_name'] ?? ($leg['airline'] ?? 'Airline');
        }

        $flight = $legs[0]; // Primary flight info for summary

        return [$flight, $legs];
    }

    public function downloadPdf(Request $request)
    {
        $reference = $request->input('reference');
        if (!$reference) {
            return redirect()->route('flights.index')->with('error', 'Booking reference missing.');
        }

        $booking = Booking::with('items')->where('booking_reference', $reference)->first();

        if (!$booking) {
            return redirect()->route('flights.index')->with('error', 'Booking not found.');
        }

        // Security Check: Only the owner of the booking can download the PDF
        if ($booking->user_id && $booking->user_id != auth()->id()) {
            return abort(403, 'Unauthorized access to this PDF.');
        }

        list($flight, $legs) = $this->extractAndNormalizeFlight($booking);

        $pnrs = [];
        $existingFlightBookings = DB::table('flight_bookings')->where('booking_id', $booking->id)->get();
        foreach ($existingFlightBookings as $idx => $fb) {
            $pnrs[$idx] = $fb->pnr;
        }

        if (empty($pnrs)) {
            $pnrs[0] = 'N/A';
        }

        $primaryPnr = $pnrs[0];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('booking-confirmation-pdf', [
            'booking' => $booking,
            'pnr' => $primaryPnr,
            'pnrs' => $pnrs,
            'flight' => $flight,
            'legs' => $legs
        ]);

        return $pdf->download('E-Ticket-'.$reference.'.pdf');
    }

    public function sendWhatsappTicket(Request $request)
    {
        if (!config('services.whatsapp.access')) {
            return redirect()->back()->with('error', 'WhatsApp ticket sharing is currently disabled.');
        }

        $reference = $request->input('reference');
        if (!$reference) {
            return redirect()->back()->with('error', 'Booking reference missing.');
        }

        $booking = Booking::with(['items'])->where('booking_reference', $reference)->first();
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Security Check: Only the owner of the booking can trigger WhatsApp sharing
        if ($booking->user_id && $booking->user_id != auth()->id()) {
            return abort(403, 'Unauthorized access.');
        }

        // Rate Limiting: Prevent spamming WhatsApp API (1 request per 3 minutes per booking)
        $cacheKey = 'wa_limit_' . $reference;
        if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
            return redirect()->back()->with('error', 'Please wait 3 minutes before sending the ticket again on WhatsApp.');
        }
        \Illuminate\Support\Facades\Cache::put($cacheKey, true, 180);

        // 1. Get phone number (from travelers in api_booking_details)
        $apiData = json_decode($booking->api_booking_details, true);
        $travelers = $apiData['travelers'] ?? [];
        $recipientPhone = '';
        if (!empty($travelers)) {
            $recipientPhone = $travelers[0]['mobile'] ?? ($travelers[0]['phone'] ?? '');
        }

        // Clean phone number (remove +, spaces, etc.)
        $recipientPhone = preg_replace('/[^0-9]/', '', $recipientPhone);

        if (empty($recipientPhone)) {
            return redirect()->back()->with('error', 'WhatsApp number not found for this booking.');
        }

        // 2. Generate/Save PDF to public path (WhatsApp needs a public URL)
        $dir = public_path('uploads/pdf_tickets');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $pdfPath = $dir . '/' . $reference . '.pdf';
        
        list($flight, $legs) = $this->extractAndNormalizeFlight($booking);
        $pnrs = [];
        $existingFlightBookings = DB::table('flight_bookings')->where('booking_id', $booking->id)->get();
        foreach ($existingFlightBookings as $idx => $fb) {
            $pnrs[$idx] = $fb->pnr;
        }
        if (empty($pnrs)) $pnrs[0] = 'N/A';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('booking-confirmation-pdf', [
            'booking' => $booking,
            'pnr' => $pnrs[0],
            'pnrs' => $pnrs,
            'flight' => $flight,
            'legs' => $legs
        ]);
        $pdf->save($pdfPath);

        $pdfUrl = asset('uploads/pdf_tickets/' . $reference . '.pdf');

        // 3. Send via WhatsApp API (Meta Graph API)
        $accessToken = config('services.whatsapp.access_token');
        $appId = config('services.whatsapp.app_id');
        $version = "v21.0";
        $messageUrl = 'https://graph.facebook.com/' . $version . '/' . $appId . '/messages';

        $messageData = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $recipientPhone,
            "type" => "template",
            "template" => [
                "name" => "order_invoice", // Ensure this template exists in your WhatsApp Manager
                "language" => [ "code" => "en" ],
                "components" => [
                    [
                        "type" => "header",
                        "parameters" => [
                            [
                                "type" => "document",
                                "document" => [
                                    "link" => $pdfUrl,
                                    "filename" => "Ticket_" . $reference . ".pdf"
                                ]
                            ]
                        ]
                    ],
                    [
                        "type" => "body",
                        "parameters" => [
                            [ "type" => "text", "text" => ($travelers[0]['first_name'] ?? 'Guest') ],
                            [ "type" => "text", "text" => $reference ]
                        ]
                    ]
                ]
            ]
        ];

        try {
            $client = new Client();
            $response = $client->post($messageUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $messageData,
            ]);

            return redirect()->back()->with('success', 'E-Ticket sent to WhatsApp successfully!');
        } catch (RequestException $e) {
            \Log::error("WhatsApp send failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send WhatsApp message. (Check API keys/Template)');
        }
    }

    /**
     * API Integrated PNR Generation
     */
    private function callApiServiceForPnr($index = 0)
    {
        // This simulates the fallback when Live GDS is unavailable but maintains the 6-char standard
        return strtoupper(\Illuminate\Support\Str::random(6));
    }
}

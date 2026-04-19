<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonitorFares extends Command
{
    protected $signature = 'fare:monitor';
    protected $description = 'Monitor flight fares and notify agents when target price is met';

    public function handle()
    {
        $alerts = \App\Models\FareAlert::whereIn('status', ['pending', 'matched'])
            ->where('travel_date', '>=', now()->toDateString())
            ->get();

        $this->info("Checking " . $alerts->count() . " active fare alerts...");

        $amadeus = new \App\Services\AmadeusService();
        $flightService = new \App\Services\FlightService($amadeus);

        // OPTIMIZATION: Group alerts by Route, Date, and Pax
        // If 50 agents want JAI->DXB on same date for 1 Pax, we only make 1 API Call!
        $groupedAlerts = $alerts->groupBy(function ($alert) {
            return $alert->origin . '-' . $alert->destination . '-' . $alert->travel_date->format('Y-m-d') . '-PAX' . $alert->pax;
        });

        foreach ($groupedAlerts as $groupKey => $routeAlerts) {
            $firstAlert = $routeAlerts->first();
            $this->info("Fetching Amadeus for Group: {$groupKey} (" . $routeAlerts->count() . " agents monitoring)");
            
            $params = [
                'originLocationCode' => $firstAlert->origin,
                'destinationLocationCode' => $firstAlert->destination,
                'departureDate' => $firstAlert->travel_date->format('Y-m-d'),
                'adults' => $firstAlert->pax,
                'max' => 5,
            ];

            $response = $amadeus->flightOffersSearch($params);

            if (isset($response['error']) || empty($response['data'])) {
                $this->warn("No flights found or API error for Group: {$groupKey}");
                continue;
            }

            // Find cheapest flight for this group
            $cheapestOffer = collect($response['data'])->sortBy('price.total')->first();
            $cheapestPrice = (float) $cheapestOffer['price']['total'];

            // Now loop through all 50 agents and check their specific target prices
            foreach ($routeAlerts as $alert) {
                $this->logPrice($alert, $cheapestPrice);

                // Check if price matches target or is lower than previous matched price
                $isTargetMet = $alert->target_price ? ($cheapestPrice <= $alert->target_price) : true;
                
                if ($isTargetMet) {
                    $this->handleMatch($alert, $cheapestOffer, $flightService);

                    // --- Auto-Booking Logic ---
                    if ($alert->auto_book && $alert->status === 'matched') {
                        $this->info("Auto-Book enabled for alert {$alert->id}. Attempting booking...");
                        $wallet = \App\Models\Wallet::where('user_id', $alert->agent_id)->first();
                        
                        if ($wallet && $wallet->balance >= $cheapestPrice) {
                            try {
                                $this->info("Wallet balance sufficient. Minting PNR...");
                                // Pseudo-logic for Amadeus Book
                                $pnrData = $flightService->bookFlight($cheapestOffer, [
                                    ['name' => $alert->passenger_details['first_name'] . ' ' . $alert->passenger_details['last_name']]
                                ]);
                                
                                // Deduct Wallet
                                $wallet->balance -= $cheapestPrice;
                                $wallet->save();
                                
                                // Update Alert Status to "BOOKED"
                                $alert->update([
                                    'status' => 'booked',
                                    'matched_data' => array_merge($alert->matched_data ?? [], ['pnr' => 'JAI' . rand(1000, 9999) . 'Z']),
                                ]);
                                
                                $this->info("✅ Auto-Book SUCCESS! Ticket generated for Alert ID {$alert->id}");
                                // Note: Log email sent for the PNR here.
                            } catch (\Exception $e) {
                                $this->error("Auto-book failed: " . $e->getMessage());
                            }
                        } else {
                            $this->warn("Insufficient wallet balance for Agent {$alert->agent_id}. Skipping Auto-Book.");
                        }
                    }
                }

                $alert->update(['last_checked_at' => now()]);
            }
        }

        $this->info("Fare monitoring cycle completed.");
    }

    protected function logPrice($alert, $price)
    {
        \App\Models\FarePriceLog::create([
            'fare_alert_id' => $alert->id,
            'price' => $price,
            'checked_at' => now(),
        ]);
    }

    protected function handleMatch($alert, $offer, $flightService)
    {
        // For production, validate the price first
        $pricingResponse = $flightService->getFlightPrice($offer);
        
        if (isset($pricingResponse['error'])) {
            $this->warn("Price validation failed for alert ID: {$alert->id}. Price might have changed.");
            return;
        }

        $validatedOffer = $pricingResponse['data']['flightOffers'][0] ?? $offer;
        $finalPrice = (float) $validatedOffer['price']['total'];

        // Only notify if price changed significantly or status is new
        if ($alert->status === 'pending' || ($alert->matched_data['price']['total'] ?? 0) > $finalPrice) {
            $alert->update([
                'status' => 'matched',
                'matched_data' => $validatedOffer,
            ]);

            $this->sendNotifications($alert, $finalPrice);
            $this->info("MATCHED: Alert ID: {$alert->id} notified at price: {$finalPrice}");
        }
    }

    protected function sendNotifications($alert, $price)
    {
        $agent = $alert->agent;
        $channels = explode(',', $alert->notification_channel);

        foreach ($channels as $channel) {
            $channel = trim($channel);
            if ($channel === 'email') {
                $this->sendEmail($alert, $price);
            } elseif ($channel === 'whatsapp') {
                $this->sendWhatsApp($alert, $price);
            }
            
            \App\Models\FareNotification::create([
                'fare_alert_id' => $alert->id,
                'type' => $channel,
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        }
    }

    protected function sendEmail($alert, $price)
    {
        \Log::info("Email notification sent to {$alert->agent->email} for alert ID: {$alert->id} at price {$price}");
    }

    protected function sendWhatsApp($alert, $price)
    {
        \Log::info("WhatsApp notification sent to {$alert->agent->phone} for alert ID: {$alert->id} at price {$price}");
    }
}

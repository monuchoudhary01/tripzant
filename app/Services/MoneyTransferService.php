<?php

namespace App\Services;

use App\Models\MoneyTransfer;
use App\Models\TransferProvider;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MoneyTransferService
{
    /**
     * Get real-time exchange rate
     */
    public function getExchangeRate($from, $to)
    {
        // Mocking rates for now - normally would call Wise or ExchangeRate-API
        $mockRates = [
            'AUD_INR' => 55.42,
            'AUD_USD' => 0.65,
            'USD_INR' => 83.21,
            'INR_AUD' => 0.018,
            'USD_AUD' => 1.54,
            'INR_USD' => 0.012
        ];

        $key = "{$from}_{{$to}}";
        return $mockRates[$key] ?? 1.0;
    }

    /**
     * Get available providers for a transfer
     */
    public function getProviders($fromCountry, $fromCurrency, $toCountry, $toCurrency, $amount)
    {
        $providers = [
            [
                'id' => 1,
                'name' => 'TripZant Wallet',
                'slug' => 'wallet',
                'type' => 'Internal',
                'rate' => $this->getExchangeRate($fromCurrency, $toCurrency),
                'fee' => 0,
                'delivery' => 'Instant',
                'score' => 9.5,
                'best_deal' => true
            ],
            [
                'id' => 2,
                'name' => 'Wise',
                'slug' => 'wise',
                'type' => 'Bank Transfer',
                'rate' => $this->getExchangeRate($fromCurrency, $toCurrency) * 0.995,
                'fee' => $amount * 0.005,
                'delivery' => '1-2 Days',
                'score' => 9.0,
                'best_deal' => false
            ],
            [
                'id' => 3,
                'name' => 'Stripe Payout',
                'slug' => 'stripe',
                'type' => 'Card/Bank',
                'rate' => $this->getExchangeRate($fromCurrency, $toCurrency) * 0.98,
                'fee' => $amount * 0.015,
                'delivery' => 'Instant',
                'score' => 8.5,
                'best_deal' => false
            ]
        ];

        // Filter based on currencies (Mock logic)
        if ($toCountry === 'India') {
            $providers[] = [
                'id' => 4,
                'name' => 'Razorpay / IMPS',
                'slug' => 'razorpay',
                'type' => 'Local Bank',
                'rate' => $this->getExchangeRate($fromCurrency, $toCurrency) * 0.99,
                'fee' => 50, // Flat fee in INR? 
                'delivery' => 'In Minutes',
                'score' => 9.2,
                'best_deal' => false
            ];
        }

        return $providers;
    }

    /**
     * Create a new transfer record
     */
    public function createTransfer($data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::findOrFail($data['user_id']);
            
            // Check Source Wallet
            $sourceWallet = Wallet::where('user_id', $user->id)
                ->where('currency', $data['source_currency'])
                ->first();

            if (!$sourceWallet || $sourceWallet->balance < $data['source_amount']) {
                throw new \Exception("Insufficient balance in {$data['source_currency']} wallet");
            }

            // Create Transfer Record
            $transfer = MoneyTransfer::create([
                'transfer_ref' => 'TRZ' . strtoupper(Str::random(10)),
                'user_id' => $user->id,
                'type' => $data['type'],
                'source_currency' => $data['source_currency'],
                'source_amount' => $data['source_amount'],
                'target_currency' => $data['target_currency'],
                'target_amount' => $data['target_amount'],
                'exchange_rate' => $data['exchange_rate'],
                'fee' => $data['fee'] ?? 0,
                'provider_id' => $data['provider_id'] ?? null,
                'recipient_details' => $data['recipient_details'],
                'status' => 'pending',
                'status_history' => [['status' => 'pending', 'time' => now()]],
                'metadata' => $data['metadata'] ?? []
            ]);

            // Lock source funds
            $sourceWallet->decrement('balance', $data['source_amount']);

            // Create Ledger entry
            Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $sourceWallet->id,
                'type' => 'transfer_out',
                'amount' => $data['source_amount'],
                'currency' => $data['source_currency'],
                'description' => "Transfer to {$data['target_currency']} ({$transfer->transfer_ref})",
                'reference_id' => $transfer->id,
                'status' => 'success'
            ]);

            return $transfer;
        });
    }

    /**
     * Process transfer (Interacting with external APIs)
     */
    public function executeTransfer(MoneyTransfer $transfer)
    {
        $transfer->update(['status' => 'processing']);
        
        try {
            // Logic for different providers
            $provider = $transfer->provider;
            
            if ($transfer->type === 'wallet_to_wallet') {
                return $this->processInternalTransfer($transfer);
            }

            // Mock external calls
            // if ($provider->slug === 'wise') { ... }
            
            // Success mock
            $transfer->update([
                'status' => 'success',
                'status_history' => array_merge($transfer->status_history, [['status' => 'success', 'time' => now()]])
            ]);

            return ['success' => true, 'transfer' => $transfer];

        } catch (\Exception $e) {
            $transfer->update(['status' => 'failed', 'metadata' => array_merge($transfer->metadata, ['error' => $e->getMessage()])]);
            // Reverse funds? or leave it for manual admin intervention
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function processInternalTransfer(MoneyTransfer $transfer)
    {
        $recipientId = $transfer->recipient_details['user_id'] ?? null;
        if (!$recipientId) throw new \Exception("Recipient user ID missing for internal transfer");

        $recipient = User::findOrFail($recipientId);
        
        // Find or create target wallet
        $targetWallet = Wallet::firstOrCreate(
            ['user_id' => $recipient->id, 'currency' => $transfer->target_currency],
            ['balance' => 0]
        );

        $targetWallet->increment('balance', $transfer->target_amount);

        // Success transaction for recipient
        Transaction::create([
            'user_id' => $recipient->id,
            'wallet_id' => $targetWallet->id,
            'type' => 'transfer_in',
            'amount' => $transfer->target_amount,
            'currency' => $transfer->target_currency,
            'description' => "Received from {$transfer->user->name} ({$transfer->transfer_ref})",
            'reference_id' => $transfer->id,
            'status' => 'success'
        ]);

        $transfer->update(['status' => 'success']);
        return ['success' => true];
    }
}

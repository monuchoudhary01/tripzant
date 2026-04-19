<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Deduct balance for a booking.
     */
    public function deduct(User $user, $amount, $description = 'Flight Booking')
    {
        return DB::transaction(function () use ($user, $amount, $description) {
            $wallet = $user->wallet; // Assuming a hasOne relationship

            if (!$wallet) return ['success' => false, 'message' => 'Wallet not found'];

            $availableBalance = $wallet->balance + $wallet->credit_limit;

            if ($availableBalance < $amount) {
                return ['success' => false, 'message' => 'Insufficient funds'];
            }

            $wallet->decrement('balance', $amount);

            // Log transaction
            DB::table('wallet_transactions')->insert([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'debit',
                'description' => $description,
                'created_at' => now(),
            ]);

            return ['success' => true, 'balance' => $wallet->balance];
        });
    }

    /**
     * Add balance (Top-up).
     */
    public function deposit(User $user, $amount, $description = 'Wallet Top-up')
    {
        return DB::transaction(function () use ($user, $amount, $description) {
            $wallet = $user->wallet;
            $wallet->increment('balance', $amount);

            DB::table('wallet_transactions')->insert([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'credit',
                'description' => $description,
                'created_at' => now(),
            ]);

            return ['success' => true, 'balance' => $wallet->balance];
        });
    }
}

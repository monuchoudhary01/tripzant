<?php

namespace App\Services;

use App\Models\User;
use App\Models\Commission;
use App\Models\Booking;

class CommissionService
{
    /**
     * Calculate and record commission for a booking
     */
    public static function processBookingCommission($booking)
    {
        $user = User::find($booking->user_id);
        if ($user && $user->referred_by) {
            $referrer = User::find($user->referred_by);
            if ($referrer && $referrer->role === User::ROLE_AFFILIATE) {
                // Calculate 10% commission (Recommended by user)
                $commissionAmount = $booking->total_amount * 0.10;

                Commission::create([
                    'user_id' => $referrer->id,
                    'referred_user_id' => $user->id,
                    'booking_id' => $booking->id,
                    'amount' => $commissionAmount,
                    'type' => 'booking',
                    'status' => 'pending',
                    'description' => '10% commission for booking #' . $booking->id
                ]);
            }
        }
    }
}

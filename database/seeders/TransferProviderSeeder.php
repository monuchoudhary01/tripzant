<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransferProvider;

class TransferProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            [
                'name' => 'TripZant Internal Wallet',
                'slug' => 'wallet',
                'type' => 'internal',
                'supported_currencies' => ['AUD', 'INR', 'USD'],
                'base_fee' => 0,
                'fee_percentage' => 0,
                'estimated_delivery_minutes' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Wise (TransferWise)',
                'slug' => 'wise',
                'type' => 'international',
                'supported_currencies' => ['AUD', 'INR', 'USD', 'EUR', 'GBP'],
                'base_fee' => 1.50,
                'fee_percentage' => 0.5,
                'estimated_delivery_minutes' => 1440,
                'is_active' => true,
            ],
            [
                'name' => 'Stripe Payouts',
                'slug' => 'stripe',
                'type' => 'local_bank',
                'supported_currencies' => ['AUD', 'USD', 'EUR'],
                'base_fee' => 2.00,
                'fee_percentage' => 1.0,
                'estimated_delivery_minutes' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Razorpay X',
                'slug' => 'razorpay',
                'type' => 'local_bank',
                'supported_currencies' => ['INR'],
                'base_fee' => 5.00,
                'fee_percentage' => 0.1,
                'estimated_delivery_minutes' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($providers as $provider) {
            TransferProvider::updateOrCreate(['slug' => $provider['slug']], $provider);
        }
    }
}

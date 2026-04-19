<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CargoProvider;
use App\Models\CargoPromoCode;
use Illuminate\Support\Facades\Hash;

class CargoSystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Users (Admin + Test User + Cargo Agent)
        $admin = User::firstOrCreate(['email' => 'admin@tripzant.com'], [
            'name' => 'TripZant Admin',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        $user = User::firstOrCreate(['email' => 'user@tripzant.com'], [
            'name' => 'John Doe',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);

        $agent = User::firstOrCreate(['email' => 'agent@tripzant.com'], [
            'name' => 'Cargo Agent',
            'password' => Hash::make('password'),
            'role' => 'agent'
        ]);

        // 2. Create Cargo Providers (Module 5)
        $providers = [
            [
                'name' => 'DHL Express',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/b3/DHL_Logo.svg',
                'base_rate' => 50.00,
                'per_kg_rate' => 5.50,
                'commission_percentage' => 12.50,
                'rating' => 4.8,
                'supported_countries' => ['Australia', 'India', 'USA', 'UK', 'Singapore'],
            ],
            [
                'name' => 'FedEx Priority',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/9d/FedEx_Express_logo.svg',
                'base_rate' => 45.00,
                'per_kg_rate' => 6.20,
                'commission_percentage' => 10.00,
                'rating' => 4.6,
                'supported_countries' => ['Australia', 'India', 'USA', 'Global'],
            ],
            [
                'name' => 'AusPost International',
                'logo_url' => 'https://pbs.twimg.com/profile_images/1640520448135897088/VvX_o_Y3_400x400.jpg',
                'base_rate' => 30.00,
                'per_kg_rate' => 4.50,
                'commission_percentage' => 8.00,
                'rating' => 4.2,
                'supported_countries' => ['Australia', 'India', 'UK', 'New Zealand'],
            ]
        ];

        foreach ($providers as $p) {
            CargoProvider::create($p);
        }

        // 3. Create Promo Codes
        CargoPromoCode::create([
            'code' => 'CARGO50',
            'type' => 'flat',
            'value' => 50.00,
            'min_booking_value' => 200.00,
            'expiry_date' => now()->addMonths(6),
        ]);

        CargoPromoCode::create([
            'code' => 'TRIPZANT10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_booking_value' => 100.00,
            'expiry_date' => now()->addMonths(6),
        ]);
    }
}

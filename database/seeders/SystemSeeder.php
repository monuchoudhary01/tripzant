<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Tour;
use App\Models\EsimPlan;
use App\Models\InsurancePlan;
use App\Models\Homestay;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'B2B Agent', 'slug' => 'b2b'],
            ['name' => 'Corporate', 'slug' => 'corporate'],
            ['name' => 'Supplier', 'slug' => 'supplier'],
            ['name' => 'IATA Agent', 'slug' => 'iata'],
            ['name' => 'User', 'slug' => 'user'],
            ['name' => 'Amadeus Partner', 'slug' => 'amadeus-partner'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }

        // 2. Seed Users
        $roles_to_seed = [
            ['email' => 'admin@tripzant.com', 'name' => 'Super Admin', 'role_slug' => 'super-admin', 'role_str' => 'admin'],
            ['email' => 'user@tripzant.com', 'name' => 'Regular User', 'role_slug' => 'user', 'role_str' => 'user'],
            ['email' => 'agent@tripzant.com', 'name' => 'B2B Agent', 'role_slug' => 'b2b', 'role_str' => 'b2b'],
            ['email' => 'iata@tripzant.com', 'name' => 'IATA Agent', 'role_slug' => 'iata', 'role_str' => 'iata'],
            ['email' => 'corporate@tripzant.com', 'name' => 'Corporate User', 'role_slug' => 'corporate', 'role_str' => 'corporate'],
            ['email' => 'supplier@tripzant.com', 'name' => 'Tour Supplier', 'role_slug' => 'supplier', 'role_str' => 'supplier'],
            ['email' => 'amadeus@tripzant.com', 'name' => 'Amadeus Partner', 'role_slug' => 'amadeus-partner', 'role_str' => 'amadeus-partner'],
        ];

        foreach ($roles_to_seed as $u) {
            $role = Role::where('slug', $u['role_slug'])->first();
            if ($role) {
                User::updateOrCreate(
                    ['email' => $u['email']],
                    [
                        'name' => $u['name'],
                        'password' => Hash::make('password123'),
                        'role_id' => $role->id,
                        'role' => $u['role_str']
                    ]
                );
            }
        }

        // 3. Seed Tours (Dynamic Home Page) - Commented out for pure API-driven experience
        /*
        $tours = [
            [
                'title' => 'Golden Triangle: Delhi, Agra & Jaipur',
                'slug' => 'golden-triangle-delhi-agra-jaipur',
                'description' => 'Explore the rich heritage of India with our 6-day Golden Triangle tour.',
                'location' => 'North India',
                'price' => 24999.00,
                'duration' => '6 Days, 5 Nights',
                'images' => json_encode(['https://images.unsplash.com/photo-1548013146-72479768b921?w=800&auto=format&fit=crop&q=80']),
                'itinerary' => json_encode(['Day 1: Arrival in Delhi', 'Day 2: Delhi Sightseeing', 'Day 3: Delhi to Agra']),
                'is_active' => true,
            ],
            [
                'title' => 'Kerala Backwaters & Houseboat',
                'slug' => 'kerala-backwaters-houseboat',
                'description' => 'Experience the serenity of Gods Own Country with our backwater tour.',
                'location' => 'Kerala',
                'price' => 18500.00,
                'duration' => '4 Days, 3 Nights',
                'images' => json_encode(['https://images.unsplash.com/photo-1506038634487-60a69ae4b7b1?w=800&auto=format&fit=crop&q=80']),
                'itinerary' => json_encode(['Day 1: Arrival in Kochi', 'Day 2: Munnar Hills', 'Day 3: Alleppey Houseboat']),
                'is_active' => true,
            ],
            [
                'title' => 'Bali Coastal Escape',
                'slug' => 'bali-coastal-escape',
                'description' => 'Relax on the beautiful beaches of Bali with this all-inclusive package.',
                'location' => 'Bali, Indonesia',
                'price' => 45000.00,
                'duration' => '7 Days, 6 Nights',
                'images' => json_encode(['https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&auto=format&fit=crop&q=80']),
                'itinerary' => json_encode(['Day 1: Arrival in Denpasar', 'Day 2: Ubud Exploring', 'Day 3: Beach Relaxation']),
                'is_active' => true,
            ],
            [
                'title' => 'Dubai Desert Safari & City Tour',
                'slug' => 'dubai-desert-safari',
                'description' => 'Experience the magic of Arabia with a desert safari and sightseeing.',
                'location' => 'Dubai, UAE',
                'price' => 32000.00,
                'duration' => '5 Days, 4 Nights',
                'images' => json_encode(['https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&auto=format&fit=crop&q=80']),
                'itinerary' => json_encode(['Day 1: Burj Khalifa', 'Day 2: Desert Safari', 'Day 3: Old Dubai']),
                'is_active' => true,
            ],
            [
                'title' => 'Shimla & Manali Snow Tour',
                'slug' => 'shimla-manali-snow',
                'description' => 'Enjoy the snow-capped mountains of Himachal Pradesh.',
                'location' => 'Himachal, India',
                'price' => 15500.00,
                'duration' => '6 Days, 5 Nights',
                'images' => json_encode(['https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=800&auto=format&fit=crop&q=80']),
                'itinerary' => json_encode(['Day 1: Shimla Arrival', 'Day 2: Kufri', 'Day 3: Manali Drive']),
                'is_active' => true,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::updateOrCreate(['slug' => $tour['slug']], $tour);
        }
        */

        // 4. Seed eSIM Plans
        $esims = [
            ['country' => 'USA', 'country_code' => 'US', 'region' => 'USA', 'data_allowance' => '10GB', 'validity' => '30 Days', 'price' => 25.00, 'provider' => 'Airalo', 'is_active' => true],
            ['country' => 'UK', 'country_code' => 'GB', 'region' => 'United Kingdom', 'data_allowance' => '5GB', 'validity' => '15 Days', 'price' => 12.00, 'provider' => 'Holafly', 'is_active' => true],
            ['country' => 'Thailand', 'country_code' => 'TH', 'region' => 'Thailand', 'data_allowance' => 'Unlimited', 'validity' => '7 Days', 'price' => 10.00, 'provider' => 'Sim2Fly', 'is_active' => true],
            ['country' => 'UAE', 'country_code' => 'AE', 'region' => 'United Arab Emirates', 'data_allowance' => '3GB', 'validity' => '7 Days', 'price' => 15.00, 'provider' => 'Airalo', 'is_active' => true],
            ['country' => 'Singapore', 'country_code' => 'SG', 'region' => 'Singapore', 'data_allowance' => '10GB', 'validity' => '30 Days', 'price' => 18.00, 'provider' => 'Airalo', 'is_active' => true],
            ['country' => 'Europe', 'country_code' => 'EU', 'region' => 'Europe (Regional)', 'data_allowance' => '20GB', 'validity' => '30 Days', 'price' => 45.00, 'provider' => 'Orange', 'is_active' => true],
        ];

        foreach ($esims as $sim) {
            EsimPlan::create($sim);
        }

        // 5. Seed Insurance Plans
        $insurance = [
            ['plan_name' => 'Standard Domestic', 'coverage_type' => 'Domestic', 'price' => 499.00, 'benefits' => 'Medical: 5L, Cancellation: 50k', 'provider' => 'Religare', 'is_active' => true],
            ['plan_name' => 'Premium International', 'coverage_type' => 'International', 'price' => 2499.00, 'benefits' => 'Medical: $50k, Loss of Baggage: $500', 'provider' => 'TATA AIG', 'is_active' => true],
        ];

        foreach ($insurance as $ins) {
            InsurancePlan::create($ins);
        }

        // 6. Seed Homestays
        $homestays = [
            ['title' => 'Mountain View Villa', 'city' => 'Manali', 'price_per_night' => 3500.00, 'description' => 'A cozy villa with breathtaking mountain views.', 'is_active' => true],
            ['title' => 'Beach Side Cottage', 'city' => 'Goa', 'price_per_night' => 4500.00, 'description' => 'Walk to the beach in 2 minutes.', 'is_active' => true],
            ['title' => 'Tea Garden Boutique Stay', 'city' => 'Munnar', 'price_per_night' => 2800.00, 'description' => 'Stay in the middle of lush tea gardens.', 'is_active' => true],
        ];

        foreach ($homestays as $home) {
            Homestay::create($home);
        }

        // 7. Seed Markups
        $markups = [
            ['module' => 'flight', 'user_role' => 'user', 'markup_type' => 'percent', 'markup_value' => 5.00],
            ['module' => 'hotel', 'user_role' => 'user', 'markup_type' => 'percent', 'markup_value' => 10.00],
            ['module' => 'tour', 'user_role' => 'user', 'markup_type' => 'percent', 'markup_value' => 15.00],
            ['module' => 'flight', 'user_role' => 'b2b', 'markup_type' => 'percent', 'markup_value' => 2.00],
        ];

        foreach ($markups as $m) {
            \App\Models\MarkupSetting::create($m);
        }

        // 8. Seed Trains
        $trains = [
            [
                'train_number' => '12002',
                'train_name' => 'Bhopal Shatabdi Express',
                'origin' => 'New Delhi',
                'destination' => 'Bhopal',
                'departure_time' => '06:00:00',
                'arrival_time' => '14:25:00',
                'base_fare' => 1250.00,
                'classes' => json_encode(['CC', 'EC']),
                'days_running' => 'Daily',
                'is_active' => true,
            ],
            [
                'train_number' => '12952',
                'train_name' => 'Mumbai Rajdhani',
                'origin' => 'New Delhi',
                'destination' => 'Mumbai Central',
                'departure_time' => '16:25:00',
                'arrival_time' => '08:15:00',
                'base_fare' => 2800.00,
                'classes' => json_encode(['3A', '2A', '1A']),
                'days_running' => 'Daily',
                'is_active' => true,
            ],
        ];

        foreach ($trains as $t) {
            \App\Models\Train::create($t);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WebsiteAnalyticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websites = [
            [
                'domain' => 'travelblog.com',
                'name' => 'The Global Nomad',
                'monthly_traffic' => '250K',
                'traffic_count' => 250000,
                'category' => 'Travel & Lifestyle',
                'status' => 'partnered',
                'contact_email' => 'hello@travelblog.com',
                'contact_phone' => '+1 415-555-0123',
                'total_bookings' => 145,
                'revenue_generated' => 1250.50,
            ],
            [
                'domain' => 'techgear.net',
                'name' => 'TechGear Reviews',
                'monthly_traffic' => '400K',
                'traffic_count' => 400000,
                'category' => 'Technology',
                'status' => 'contacted',
                'contact_email' => 'partners@techgear.net',
                'contact_phone' => '+1 212-555-4567',
                'total_bookings' => 0,
                'revenue_generated' => 0.00,
            ],
            [
                'domain' => 'adventurehikes.org',
                'name' => 'Adventure Hikes',
                'monthly_traffic' => '85K',
                'traffic_count' => 85000,
                'category' => 'Adventure Travel',
                'status' => 'partnered',
                'contact_email' => 'admin@adventurehikes.org',
                'contact_phone' => '+44 20 7946 0958',
                'total_bookings' => 42,
                'revenue_generated' => 480.25,
            ],
            [
                'domain' => 'newsweek-travel.com',
                'name' => 'NewsWeek Travel Section',
                'monthly_traffic' => '1.2M',
                'traffic_count' => 1200000,
                'category' => 'News & Media',
                'status' => 'new',
                'contact_email' => 'editor@newsweek-travel.com',
                'contact_phone' => '+1 310-555-7890',
                'total_bookings' => 0,
                'revenue_generated' => 0.00,
            ],
            [
                'domain' => 'budgettrips.in',
                'name' => 'Budget Trips India',
                'monthly_traffic' => '150K',
                'traffic_count' => 150000,
                'category' => 'Travel Deals',
                'status' => 'partnered',
                'contact_email' => 'contact@budgettrips.in',
                'contact_phone' => '+91 98765 43210',
                'total_bookings' => 89,
                'revenue_generated' => 670.00,
            ]
        ];

        foreach ($websites as $web) {
            \App\Models\WebsiteAnalytic::create(array_merge($web, [
                'traffic_sources' => [
                    'Direct' => rand(20, 40) . '%',
                    'Organic' => rand(30, 60) . '%',
                    'Social' => rand(5, 15) . '%',
                    'Ads' => rand(5, 10) . '%',
                ],
                'top_countries' => ['USA', 'UK', 'India', 'Canada', 'Australia'],
                'social_links' => [
                    'facebook' => 'https://facebook.com/' . $web['domain'],
                    'twitter' => 'https://twitter.com/' . $web['domain'],
                    'instagram' => 'https://instagram.com/' . $web['domain'],
                ]
            ]));
        }
    }
}

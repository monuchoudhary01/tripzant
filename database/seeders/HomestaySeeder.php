<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Homestay;

class HomestaySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Marine Drive Luxury Apartment',
                'subtitle' => 'Marine Drive, Kochi',
                'city' => 'Kochi',
                'price_per_night' => 4500,
                'rating' => 4.6,
                'reviews_count' => 210,
                'image_url' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500',
                'property_type' => 'Apartment',
                'amenities' => ['Wifi', 'Kitchen', 'AC'],
                'bedrooms' => 2,
                'is_superhost' => true
            ],
            [
                'title' => 'Riverside Heritage Villa',
                'subtitle' => 'Fort Kochi, Kochi',
                'city' => 'Kochi',
                'price_per_night' => 12500,
                'rating' => 4.9,
                'reviews_count' => 85,
                'image_url' => 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=500',
                'property_type' => 'Villa',
                'amenities' => ['Pool', 'Garden', 'Breakfast'],
                'bedrooms' => 4,
                'is_superhost' => true
            ],
            [
                'title' => 'Backwater View Cottage',
                'subtitle' => 'Cherai Beach, Kochi',
                'city' => 'Kochi',
                'price_per_night' => 6800,
                'rating' => 4.7,
                'reviews_count' => 145,
                'image_url' => 'https://images.unsplash.com/photo-1587381420270-4e9a0e256f66?w=500',
                'property_type' => 'Cottage',
                'amenities' => ['Backwater View', 'Wifi', 'Kitchen'],
                'bedrooms' => 1,
                'is_superhost' => false
            ],
            [
                'title' => 'Spice Garden Farmhouse',
                'subtitle' => 'Mattancherry, Kochi',
                'city' => 'Kochi',
                'price_per_night' => 8200,
                'rating' => 4.8,
                'reviews_count' => 67,
                'image_url' => 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=500',
                'property_type' => 'Farmhouse',
                'amenities' => ['Organic Garden', 'Bonfire'],
                'bedrooms' => 3,
                'is_superhost' => false
            ],
        ];

        foreach ($data as $item) {
            Homestay::create($item);
        }
    }
}

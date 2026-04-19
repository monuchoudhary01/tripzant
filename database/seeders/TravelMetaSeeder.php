<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Train;
use App\Models\Homestay;

class TravelMetaSeeder extends Seeder
{
    public function run()
    {
        // Trains
        $trains = [
            ['train_no' => '12423', 'name' => 'Rajdhani Express', 'origin' => 'New Delhi', 'destination' => 'Guwahati', 'origin_code' => 'NDLS', 'destination_code' => 'GHY', 'departure_time' => '16:10', 'arrival_time' => '19:00', 'price' => 2850.00],
            ['train_no' => '12002', 'name' => 'Shatabdi Express', 'origin' => 'New Delhi', 'destination' => 'Bhopal', 'origin_code' => 'NDLS', 'destination_code' => 'BPL', 'departure_time' => '06:00', 'arrival_time' => '14:00', 'price' => 1250.00],
            ['train_no' => '12952', 'name' => 'Mumbai Rajdhani', 'origin' => 'New Delhi', 'destination' => 'Mumbai', 'origin_code' => 'NDLS', 'destination_code' => 'MMCT', 'departure_time' => '16:30', 'arrival_time' => '08:35', 'price' => 3100.00],
        ];

        foreach ($trains as $t) {
            Train::updateOrCreate(['train_no' => $t['train_no']], $t);
        }

        // Homestays
        $homestays = [
            ['title' => 'Mountain View Villa', 'subtitle' => 'Entire Villa • Riverside', 'city' => 'Manali', 'price_per_night' => 4500.00, 'rating' => 4.8, 'image_url' => 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=800', 'property_type' => 'Villa'],
            ['title' => 'Fort Kochi Heritage Villa', 'subtitle' => 'Entire Villa • Historic Charm', 'city' => 'Kochi', 'price_per_night' => 12500.00, 'rating' => 4.9, 'image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800', 'property_type' => 'Villa'],
            ['title' => 'Backwater Retreat', 'subtitle' => 'Private Room • Lake View', 'city' => 'Kochi', 'price_per_night' => 4500.00, 'rating' => 4.7, 'image_url' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800', 'property_type' => 'Cottage'],
        ];

        foreach ($homestays as $h) {
            Homestay::updateOrCreate(['title' => $h['title']], $h);
        }
    }
}

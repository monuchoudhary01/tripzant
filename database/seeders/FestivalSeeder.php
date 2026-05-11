<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Festival;

class FestivalSeeder extends Seeder
{
    public function run(): void
    {
        $festivals = [
            [
                'name' => 'Rio Carnival',
                'location' => 'Rio de Janeiro, Brazil',
                'month' => 'February',
                'category' => 'Cultural',
                'icon' => '🎭',
                'image_url' => 'https://images.unsplash.com/photo-1549417229-aa67d3263c09?w=800',
                'description' => 'The biggest carnival in the world, featuring samba parades and street parties.',
            ],
            [
                'name' => 'Holi Festival',
                'location' => 'Varanasi, India',
                'month' => 'March',
                'category' => 'Cultural',
                'icon' => '🎨',
                'image_url' => 'https://images.unsplash.com/photo-1547842602-bc3f7895aa97?w=800',
                'description' => 'The festival of colors, celebrating the arrival of spring and victory of good over evil.',
            ],
            [
                'name' => 'Cherry Blossom',
                'location' => 'Kyoto, Japan',
                'month' => 'April',
                'category' => 'Nature',
                'icon' => '🌸',
                'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=800',
                'description' => 'Experience the stunning Sakura season across Japan\'s ancient capital.',
            ],
            [
                'name' => 'Tomorrowland',
                'location' => 'Boom, Belgium',
                'month' => 'July',
                'category' => 'Music',
                'icon' => '🎧',
                'image_url' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800',
                'description' => 'One of the world\'s largest and most iconic electronic dance music festivals.',
            ],
            [
                'name' => 'Oktoberfest',
                'location' => 'Munich, Germany',
                'month' => 'October',
                'category' => 'Cultural',
                'icon' => '🍻',
                'image_url' => 'https://images.unsplash.com/photo-1532634812-d8581ccd7dc1?w=800',
                'description' => 'The world\'s largest Volksfest, featuring a beer festival and a travelling funfair.',
            ],
            [
                'name' => 'Diwali',
                'location' => 'All India',
                'month' => 'October/November',
                'category' => 'Cultural',
                'icon' => '🪔',
                'image_url' => 'https://images.unsplash.com/photo-1577744486770-020ab432da65?w=800',
                'description' => 'The festival of lights, celebrating the triumph of light over darkness.',
            ],
        ];

        foreach ($festivals as $fest) {
            Festival::create($fest);
        }
    }
}

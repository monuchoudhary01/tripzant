<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MasterServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample Tours
        \App\Models\Tour::updateOrCreate(['title' => 'Goa Backwater Kayaking'], [
            'duration' => '3 Hours',
            'price' => 1500.00,
            'status' => 'Live',
            'image' => 'https://images.unsplash.com/photo-1544551763-47a18411987c?q=80&w=600&auto=format&fit=crop',
            'description' => 'Explore the serene mangroves and backwaters of Goa at sunset.',
            'location' => 'Goa'
        ]);

        \App\Models\Tour::updateOrCreate(['title' => 'Old Goa Heritage Walk'], [
            'duration' => '4 Hours',
            'price' => 850.00,
            'status' => 'Draft',
            'image' => 'https://images.unsplash.com/photo-1548013146-72479768bbaa?q=80&w=600&auto=format&fit=crop',
            'description' => 'A guided journey through the historic cathedrals and colonial architecture.',
            'location' => 'Goa'
        ]);

        \App\Models\Tour::updateOrCreate(['title' => 'Scuba Diving at Grand Island'], [
            'duration' => '6 Hours',
            'price' => 4500.00,
            'status' => 'Live',
            'image' => 'https://images.unsplash.com/photo-1544551763-8dd44758c2ae?q=80&w=600&auto=format&fit=crop',
            'description' => 'Discover the vibrant underwater life and shipwrecks in crystal clear water.',
            'location' => 'Goa'
        ]);

        // Sample Homestays
        \App\Models\Homestay::updateOrCreate(['name' => 'Riverside Retreat'], [
            'city' => 'Kochi',
            'price_per_night' => 2500.00,
            'address' => 'Near Backwaters, Fort Kochi',
            'image' => 'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?q=80&w=600&auto=format&fit=crop',
            'rating' => 4.5
        ]);

        \App\Models\Homestay::updateOrCreate(['name' => 'Mountain Mist Villa'], [
            'city' => 'Munnar',
            'price_per_night' => 4500.00,
            'address' => 'Top Station Road, Munnar',
            'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=600&auto=format&fit=crop',
            'rating' => 4.8
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Master Administrator', 'slug' => 'admin'],
            ['name' => 'Individual Traveler', 'slug' => 'user'],
            ['name' => 'Standard B2B Agent', 'slug' => 'agent'],
            ['name' => 'IATA Agent', 'slug' => 'iata'],
            ['name' => 'Corporate Business', 'slug' => 'corporate'],
            ['name' => 'Investor', 'slug' => 'investor'],
            ['name' => 'Hotel Partner', 'slug' => 'hotel-partner'],
            ['name' => 'Amadeus GDS Partner', 'slug' => 'amadeus-partner'],
            ['name' => 'Tour Builder / Supplier', 'slug' => 'tour-builder'],
            ['name' => 'Local Service Provider', 'slug' => 'local-provider'],
            ['name' => 'Accounting Specialist', 'slug' => 'accounting'],
            ['name' => 'Cargo System Partner', 'slug' => 'cargo'],
            ['name' => 'Affiliate Marketer', 'slug' => 'affiliate'],
            ['name' => 'Partner B2B Portal', 'slug' => 'partner'],
            ['name' => 'Visa Service Provider', 'slug' => 'visa-provider'],
            ['name' => 'Agent Global Partner', 'slug' => 'iata-network'],
            ['name' => 'Smart Travel Explorer', 'slug' => 'explorer'],
        ];

        $slugs = collect($roles)->pluck('slug')->toArray();
        Role::whereNotIn('slug', $slugs)->delete();

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}

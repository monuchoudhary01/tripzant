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
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Customer', 'slug' => 'user'],
            ['name' => 'Hotel Provider', 'slug' => 'hotel-partner'],
            ['name' => 'International Cargo Partner', 'slug' => 'cargo'],
            ['name' => 'Travel Agent / Agency', 'slug' => 'b2b'],
            ['name' => 'Agent', 'slug' => 'agent'],
            ['name' => 'Corporate Business', 'slug' => 'corporate'],
            ['name' => 'Tour & Package Supplier', 'slug' => 'supplier'],
            ['name' => 'Local Service Provider / Affiliate', 'slug' => 'affiliate'],
            ['name' => 'IATA Agent', 'slug' => 'iata'],
            ['name' => 'Amadeus Partner', 'slug' => 'amadeus-partner'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}

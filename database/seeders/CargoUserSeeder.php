<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CargoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'cargo@gmail.com'],
            [
                'name' => 'Cargo Logistics Partner',
                'password' => Hash::make('cargo123'),
                'role' => 'cargo',
                'status' => 'active',
                'is_verified' => true
            ]
        );
    }
}

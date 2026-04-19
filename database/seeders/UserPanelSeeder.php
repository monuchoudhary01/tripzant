<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\IataAgentProfile;
use App\Models\AmadeusPartnerProfile;
use App\Models\CorporateProfile;
use App\Models\TourSupplierProfile;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class UserPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Master Admin',
                'email' => 'admin@tripzant.com',
                'password' => 'admin123',
                'role' => User::ROLE_SUPER_ADMIN,
                'status' => 'active',
                'is_verified' => true
            ],
            [
                'name' => 'Amadeus Partner',
                'email' => 'amadeus@tripzant.com',
                'password' => 'partner123',
                'role' => User::ROLE_AMADEUS_PARTNER,
                'status' => 'active',
                'is_verified' => true
            ],
            [
                'name' => 'IATA Agent',
                'email' => 'iata@tripzant.com',
                'password' => 'agent123',
                'role' => User::ROLE_IATA_AGENT,
                'status' => 'active',
                'is_verified' => true
            ],
            [
                'name' => 'Corporate Admin',
                'email' => 'corporate@tripzant.com',
                'password' => 'corp123',
                'role' => User::ROLE_CORPORATE,
                'status' => 'active',
                'is_verified' => true
            ],
            [
                'name' => 'B2B Travel Agent',
                'email' => 'b2b@tripzant.com',
                'password' => 'b2b123',
                'role' => User::ROLE_B2B_AGENT,
                'status' => 'active',
                'is_verified' => true
            ],
            [
                'name' => 'Tour Supplier',
                'email' => 'tour@tripzant.com',
                'password' => 'tour123',
                'role' => User::ROLE_TOUR_SUPPLIER,
                'status' => 'active',
                'is_verified' => true
            ]
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'status' => $userData['status'],
                    'is_verified' => $userData['is_verified'],
                    'otp' => '1234'
                ]
            );

            // Create Profiles
            switch ($user->role) {
                case User::ROLE_IATA_AGENT:
                    IataAgentProfile::updateOrCreate(['user_id' => $user->id], ['iata_code' => '7788990', 'agency_name' => 'Global Travel IATA']);
                    break;
                case User::ROLE_AMADEUS_PARTNER:
                    AmadeusPartnerProfile::updateOrCreate(['user_id' => $user->id], ['office_id_pcc' => 'DELUA2100', 'agency_name' => 'Amadeus Global Partner']);
                    break;
                case User::ROLE_CORPORATE:
                    CorporateProfile::updateOrCreate(['user_id' => $user->id], ['company_name' => 'Tripzant Corp']);
                    break;
                case User::ROLE_TOUR_SUPPLIER:
                    TourSupplierProfile::updateOrCreate(['user_id' => $user->id], ['company_name' => 'Elite Tours Supplier']);
                    break;
            }

            // Create Wallet for non-customers
            if ($user->role !== User::ROLE_CUSTOMER) {
                Wallet::updateOrCreate(['user_id' => $user->id], ['balance' => 50000.0, 'credit_limit' => 100000.0]);
            }
        }
    }
}

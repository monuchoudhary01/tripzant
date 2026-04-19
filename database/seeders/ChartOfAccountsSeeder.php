<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChartOfAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            // Assets
            ['name' => 'Cash in Hand', 'code' => '1001', 'type' => 'asset', 'is_system' => true],
            ['name' => 'Bank Account', 'code' => '1002', 'type' => 'asset', 'is_system' => true],
            ['name' => 'Accounts Receivable (Customers)', 'code' => '1100', 'type' => 'asset', 'is_system' => true],
            
            // Liabilities
            ['name' => 'Accounts Payable (Suppliers)', 'code' => '2100', 'type' => 'liability', 'is_system' => true],
            ['name' => 'Amadeus Payable', 'code' => '2101', 'type' => 'liability', 'is_system' => true],
            ['name' => 'HotelBeds Payable', 'code' => '2102', 'type' => 'liability', 'is_system' => true],
            
            // Revenue
            ['name' => 'Flight Booking Revenue', 'code' => '4001', 'type' => 'revenue', 'is_system' => true],
            ['name' => 'Hotel Booking Revenue', 'code' => '4002', 'type' => 'revenue', 'is_system' => true],
            ['name' => 'Service Charges', 'code' => '4100', 'type' => 'revenue', 'is_system' => true],
            
            // Expenses
            ['name' => 'Cost of Sales (Flights)', 'code' => '5001', 'type' => 'expense', 'is_system' => true],
            ['name' => 'Cost of Sales (Hotels)', 'code' => '5002', 'type' => 'expense', 'is_system' => true],
            ['name' => 'Office Rent', 'code' => '5100', 'type' => 'expense', 'is_system' => false],
            ['name' => 'Salaries', 'code' => '5101', 'type' => 'expense', 'is_system' => false],
            ['name' => 'Software Subscription', 'code' => '5200', 'type' => 'expense', 'is_system' => false],
        ];

        foreach ($accounts as $account) {
            \App\Models\Accounting\Account::updateOrCreate(['code' => $account['code']], $account);
        }
    }
}

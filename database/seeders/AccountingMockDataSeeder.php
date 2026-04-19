<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountingMockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Ensure accounts exist
        $this->call(ChartOfAccountsSeeder::class);

        $faker = \Faker\Factory::create();
        $accounts = \App\Models\Accounting\Account::all();
        $receivableAcc = $accounts->where('code', '1100')->first();
        $bankAcc = $accounts->where('code', '1002')->first();
        $payableAcc = $accounts->where('code', '2100')->first();
        $revenueAccFlight = $accounts->where('code', '4001')->first();
        $revenueAccHotel = $accounts->where('code', '4002')->first();
        $expenseAccRent = $accounts->where('code', '5100')->first();
        $expenseAccSalary = $accounts->where('code', '5101')->first();

        // 2. Create some bookings and matching accounting entries
        for ($i = 0; $i < 20; $i++) {
            $type = $faker->randomElement(['flight', 'hotel']);
            $cost = $faker->numberBetween(5000, 50000);
            $selling = $cost + $faker->numberBetween(500, 5000);
            $margin = $selling - $cost;

            $booking = \App\Models\Booking::create([
                'user_id' => 1,
                'booking_type' => $type,
                'api_reference' => 'mock-' . strtoupper($faker->bothify('??###')),
                'net_price' => $cost,
                'selling_price' => $selling,
                'status' => 'confirmed',
                'payment_status' => $faker->randomElement(['confirmed', 'pending']),
                'booking_details' => json_encode(['mock' => true])
            ]);

            // Create Journal
            $journal = \App\Models\Accounting\JournalEntry::create([
                'entry_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'reference_type' => 'booking',
                'reference_id' => $booking->id,
                'description' => "Mock booking for {$type}",
                'created_by' => 1
            ]);

            // Ledger Lines
            \App\Models\Accounting\LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $receivableAcc->id,
                'debit' => $selling,
                'credit' => 0,
                'description' => "Receivable from customer"
            ]);
            $receivableAcc->increment('balance', $selling);

            $revAcc = ($type == 'flight') ? $revenueAccFlight : $revenueAccHotel;
            \App\Models\Accounting\LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $revAcc->id,
                'debit' => 0,
                'credit' => $margin,
                'description' => "Booking Margin"
            ]);
            $revAcc->increment('balance', $margin);

            \App\Models\Accounting\LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $payableAcc->id,
                'debit' => 0,
                'credit' => $cost,
                'description' => "Payable to provider"
            ]);
            $payableAcc->increment('balance', $cost);

            // Create Invoice
            $taxAmount = $selling * 0.18;
            \App\Models\Accounting\Invoice::create([
                'invoice_number' => 'INV-' . strtoupper($faker->bothify('??###')),
                'booking_id' => $booking->id,
                'user_id' => 1,
                'invoice_date' => $journal->entry_date,
                'due_date' => (clone $journal->entry_date)->add(new \DateInterval('P7D')),
                'subtotal' => $selling,
                'tax_amount' => $taxAmount,
                'total_amount' => $selling + $taxAmount,
                'status' => $faker->randomElement(['paid', 'unpaid', 'partially_paid']),
                'amount_paid' => $faker->randomElement([0, $selling + $taxAmount, ($selling + $taxAmount)/2])
            ]);

            // Track Cost of Sales (COGS) in Ledger
            $costAccCode = ($type == 'flight') ? '5001' : '5002';
            $costAcc = $accounts->where('code', $costAccCode)->first();
            
            \App\Models\Accounting\LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $costAcc->id,
                'debit' => $cost,
                'credit' => 0,
                'description' => "Cost of Sales for {$type}"
            ]);
            $costAcc->increment('balance', $cost);
        }

        // 3. Create some manual expenses
        for ($j = 0; $j < 5; $j++) {
            $amount = $faker->numberBetween(1000, 10000);
            \App\Models\Accounting\Expense::create([
                'title' => $faker->randomElement(['Office Rent', 'Electricity', 'Internet', 'Marketing']),
                'account_id' => $faker->randomElement([$expenseAccRent->id, $expenseAccSalary->id]),
                'amount' => $amount,
                'expense_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'payment_method' => 'Bank Transfer'
            ]);
            
            // Should also create ledger for expenses
            $journal = \App\Models\Accounting\JournalEntry::create([
                'entry_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'reference_type' => 'expense',
                'reference_id' => $j + 1,
                'description' => "Manual expense",
                'created_by' => 1
            ]);
            
            \App\Models\Accounting\LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $expenseAccRent->id, // Simplified
                'debit' => $amount,
                'credit' => 0,
                'description' => "Office Expense"
            ]);
            \App\Models\Accounting\LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $bankAcc->id,
                'debit' => 0,
                'credit' => $amount,
                'description' => "Payment from Bank"
            ]);
        }
    }
}

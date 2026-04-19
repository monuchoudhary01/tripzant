<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Accounting\Account;
use App\Models\Accounting\JournalEntry;
use App\Models\Accounting\LedgerEntry;
use App\Models\Accounting\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AccountingService
{
    /**
     * Post accounting entries for a confirmed booking
     */
    public function postBookingEntries(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $totalAmount = $booking->selling_price;
            $supplierCost = $booking->net_price;
            $margin = $totalAmount - $supplierCost;

            // 1. Create Journal Entry
            $journal = JournalEntry::create([
                'entry_date' => Carbon::now(),
                'reference_type' => 'booking',
                'reference_id' => $booking->id,
                'description' => "Booking confirmed: {$booking->booking_type} (#{$booking->id})",
                'created_by' => auth()->id() ?? 1,
            ]);

            // Determine accounts based on booking type
            $revenueAccountCode = $booking->booking_type == 'flight' ? '4001' : '4002';
            $supplierAccountCode = '2100'; // Generic for now, could be specific (2101, 2102)

            $receivableAccount = Account::where('code', '1100')->first();
            $revenueAccount = Account::where('code', $revenueAccountCode)->first();
            $payableAccount = Account::where('code', $supplierAccountCode)->first();

            // 2. Ledger Entries (Double Entry)
            
            // Debit: Accounts Receivable (Full Amount from Customer)
            LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $receivableAccount->id,
                'debit' => $totalAmount,
                'credit' => 0,
                'description' => "Receivable from customer for booking #{$booking->id}"
            ]);
            $receivableAccount->increment('balance', $totalAmount);

            // Credit: Revenue (The Margin)
            LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $revenueAccount->id,
                'debit' => 0,
                'credit' => $margin,
                'description' => "Revenue margin for booking #{$booking->id}"
            ]);
            $revenueAccount->increment('balance', $margin);

            // Credit: Supplier Payable (The net cost to be paid to supplier)
            LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $payableAccount->id,
                'debit' => 0,
                'credit' => $supplierCost,
                'description' => "Payable to supplier for booking #{$booking->id}"
            ]);
            $payableAccount->increment('balance', $supplierCost);

            // 3. Generate Invoice
            $this->generateInvoice($booking);

            return $journal;
        });
    }

    public function generateInvoice(Booking $booking)
    {
        $invoiceNumber = 'INV-' . strtoupper(uniqid());
        
        return Invoice::create([
            'invoice_number' => $invoiceNumber,
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'invoice_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7),
            'subtotal' => $booking->selling_price,
            'tax_amount' => 0, // Simplified
            'total_amount' => $booking->selling_price,
            'status' => 'unpaid'
        ]);
    }

    public function recordPayment(Invoice $invoice, $amount, $method)
    {
        return DB::transaction(function () use ($invoice, $amount, $method) {
            $invoice->increment('amount_paid', $amount);
            if ($invoice->amount_paid >= $invoice->total_amount) {
                $invoice->status = 'paid';
            } else {
                $invoice->status = 'partially_paid';
            }
            $invoice->save();

            // Accounting entries for payment
            $journal = JournalEntry::create([
                'entry_date' => Carbon::now(),
                'reference_type' => 'payment',
                'reference_id' => $invoice->id,
                'description' => "Payment received for Invoice #{$invoice->invoice_number}",
                'created_by' => auth()->id() ?? 1,
            ]);

            $bankAccount = Account::where('code', '1002')->first();
            $receivableAccount = Account::where('code', '1100')->first();

            // Debit: Bank Asset
            LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $bankAccount->id,
                'debit' => $amount,
                'credit' => 0,
                'description' => "Bank deposit from customer for Invoice #{$invoice->invoice_number}"
            ]);
            $bankAccount->increment('balance', $amount);

            // Credit: Accounts Receivable (Decrease)
            LedgerEntry::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $receivableAccount->id,
                'debit' => 0,
                'credit' => $amount,
                'description' => "Receivable cleared for Invoice #{$invoice->invoice_number}"
            ]);
            $receivableAccount->decrement('balance', $amount);

            return $invoice;
        });
    }
}

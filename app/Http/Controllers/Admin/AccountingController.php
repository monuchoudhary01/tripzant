<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Account;
use App\Models\Accounting\JournalEntry;
use App\Models\Accounting\LedgerEntry;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\Expense;
use App\Models\Booking;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Account::where('type', 'revenue')->sum('balance');
        $totalExpenses = Account::where('type', 'expense')->sum('balance');
        $totalReceivable = Account::where('code', '1100')->value('balance');
        $totalPayable = Account::where('code', '2100')->value('balance');
        
        $profit = $totalRevenue - $totalExpenses;
        
        $recentTransactions = JournalEntry::with('ledgerEntries.account')
            ->orderBy('entry_date', 'desc')
            ->limit(10)
            ->get();

        return view('admin.accounting.dashboard', compact(
            'totalRevenue', 'totalExpenses', 'totalReceivable', 
            'totalPayable', 'profit', 'recentTransactions'
        ));
    }

    public function ledger()
    {
        $accounts = Account::all();
        $entries = LedgerEntry::with(['journalEntry', 'account'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.accounting.ledger', compact('accounts', 'entries'));
    }

    public function invoices()
    {
        $invoices = Invoice::with(['user', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.accounting.invoices', compact('invoices'));
    }

    public function payments()
    {
        // Simple mock view of journal entries that are payments
        $payments = JournalEntry::where('reference_type', 'payment')
            ->with(['ledgerEntries.account'])
            ->orderBy('entry_date', 'desc')
            ->paginate(20);
        return view('admin.accounting.payments', compact('payments'));
    }

    public function expenses()
    {
        $expenses = Expense::with('account')->orderBy('expense_date', 'desc')->paginate(20);
        return view('admin.accounting.expenses', compact('expenses'));
    }

    public function reports()
    {
        $revenueAccounts = Account::where('type', 'revenue')->get();
        $expenseAccounts = Account::where('type', 'expense')->get();
        
        // Category wise breakdown
        $flightRev = Account::where('code', '4001')->value('balance') ?? 0;
        $hotelRev = Account::where('code', '4002')->value('balance') ?? 0;
        
        // Assuming we track cost of sales for flights and hotels in 5001 and 5002
        $flightCost = Account::where('code', '5001')->value('balance') ?? 0;
        $hotelCost = Account::where('code', '5002')->value('balance') ?? 0;

        $flightProfit = $flightRev - $flightCost;
        $hotelProfit = $hotelRev - $hotelCost;

        return view('admin.accounting.reports', compact(
            'revenueAccounts', 'expenseAccounts', 
            'flightRev', 'hotelRev', 'flightCost', 'hotelCost',
            'flightProfit', 'hotelProfit'
        ));
    }

    public function gst()
    {
        $invoices = Invoice::where('tax_amount', '>', 0)->paginate(20);
        return view('admin.accounting.gst', compact('invoices'));
    }

    public function syncView()
    {
        return view('admin.accounting.sync');
    }

    public function syncNow($platform)
    {
        // Mock sync logic
        return back()->with('success', "Successfully synced data to {$platform}!");
    }
}

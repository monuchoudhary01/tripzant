<?php

namespace App\Http\Controllers;

use App\Models\MoneyTransfer;
use App\Models\Wallet;
use App\Services\MoneyTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoneyTransferController extends Controller
{
    protected $transferService;

    public function __construct(MoneyTransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        // Ensure wallets exist for the 3 main currencies
        $currencies = ['AUD', 'INR', 'USD'];
        foreach ($currencies as $curr) {
            Wallet::firstOrCreate(
                ['user_id' => $user->id, 'currency' => $curr],
                ['balance' => 0]
            );
        }

        $wallets = $user->wallets;
        $recentTransfers = $user->moneyTransfers()->latest()->take(5)->get();

        return view('money-transfer.index', compact('wallets', 'recentTransfers'));
    }

    public function comparison(Request $request)
    {
        $from = $request->input('from_currency', 'AUD');
        $to = $request->input('to_currency', 'INR');
        $amount = $request->input('amount', 1000);
        $fromCountry = $request->input('from_country', 'Australia');
        $toCountry = $request->input('to_country', 'India');

        $providers = $this->transferService->getProviders($fromCountry, $from, $toCountry, $to, $amount);
        $rate = $this->transferService->getExchangeRate($from, $to);

        return view('money-transfer.comparison', compact('providers', 'rate', 'from', 'to', 'amount', 'fromCountry', 'toCountry'));
    }

    public function showTransferForm($providerSlug)
    {
        return view('money-transfer.form', compact('providerSlug'));
    }
}

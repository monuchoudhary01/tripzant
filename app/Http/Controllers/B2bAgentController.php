<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

class B2bAgentController extends Controller
{
    /**
     * Dashboard (Home Page)
     */
    public function dashboard()
    {
        $user = Auth::user();
        $wallet = \App\Models\Wallet::firstOrCreate(['user_id' => $user->id], ['balance' => 0.00]);
        $recentTransactions = \App\Models\Transaction::where('user_id', $user->id)->latest()->limit(5)->get();
        
        $bookings = \App\Models\Booking::where('user_id', $user->id)->latest()->get();
        $recentBookings = $bookings->take(4);
        
        $totalBookingsCount = $bookings->count();
        $totalEarnings = $bookings->sum('markup');

        // Fare Monitoring Stats
        $activeAlertsCount = \App\Models\FareAlert::where('agent_id', $user->id)->where('status', 'monitoring')->count();
        $matchedAlertsCount = \App\Models\FareAlert::where('agent_id', $user->id)->where('status', 'matched')->count();

        return view('partner.dashboard', compact(
            'wallet', 
            'recentTransactions', 
            'recentBookings', 
            'totalBookingsCount', 
            'totalEarnings',
            'activeAlertsCount',
            'matchedAlertsCount'
        ));
    }

    /**
     * Flight Flow
     */
    public function searchPage() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        AuditLogService::log('B2B', 'Search', 'B2B Agent accessed search page');
        return view('agent.b2b.search', compact('wallet')); 
    }

    public function flightListing() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.listing', compact('wallet')); 
    }

    public function paxDetails() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.pax-details', compact('wallet')); 
    }

    public function reviewPage() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.review', compact('wallet')); 
    }
    
    public function issueTicket(Request $request)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->first();
        $netFare = $request->net_fare ?? 5000; // Mock

        if (!$wallet || $wallet->balance < $netFare) {
            return back()->with('error', 'Insufficient balance. Please top-up wallet to continue booking.');
        }

        // Deduct Wallet
        $wallet->balance -= $netFare;
        $wallet->save();

        // Log Transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'deduction',
            'amount' => $netFare,
            'description' => 'Flight Booking: ' . ($request->flight_code ?? 'Domestic Sector'),
            'status' => 'success'
        ]);

        AuditLogService::log('B2B', 'Booking', 'B2B Agent issued ticket', $request->all(), ['net_fare' => $netFare]);

        return redirect()->route('agent.b2b.success', ['id' => rand(1000, 9999)]);
    }

    public function bookingSuccess($id) 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.success', compact('id', 'wallet')); 
    }

    public function myBookings() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('agent.b2b.bookings', compact('wallet', 'bookings')); 
    }

    /**
     * Wallet System
     */
    public function addMoney() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.wallet-add', compact('wallet')); 
    }
    
    public function topUp(Request $request)
    {
        $user = Auth::user();
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        $amount = $request->amount;

        $wallet->balance += $amount;
        $wallet->save();

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'topup',
            'amount' => $amount,
            'description' => 'Wallet Recharge via Gateway',
            'status' => 'success'
        ]);

        AuditLogService::log('B2B', 'Wallet', 'B2B Agent topped up wallet', ['amount' => $amount]);

        return back()->with('success', 'Wallet recharged successfully!');
    }

    public function walletHistory() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        $recentTransactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return view('agent.b2b.wallet-history', compact('wallet', 'recentTransactions')); 
    }
    public function creditRequest() { return view('agent.b2b.credit-request'); }

    /**
     * Reports
     */
    public function reportBookings() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('agent.b2b.reports-bookings', compact('wallet', 'bookings')); 
    }

    public function reportTransactions() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return view('agent.b2b.reports-transactions', compact('wallet', 'transactions')); 
    }

    public function reportProfit() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        $profits = Booking::where('user_id', Auth::id())->where('status', 'confirmed')->sum('markup');
        return view('agent.b2b.reports-profit', compact('wallet', 'profits')); 
    }

    /**
     * Management & Others
     */
    public function paxList() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.passengers', compact('wallet')); 
    }

    public function markupSettings() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.markups', compact('wallet')); 
    }

    public function supportTickets() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.tickets', compact('wallet')); 
    }

    public function helpCenter() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.help', compact('wallet')); 
    }

    public function profile() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.profile', compact('wallet')); 
    }

    public function changePassword() 
    { 
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.password', compact('wallet')); 
    }

    /**
     * Fare Monitoring
     */
    public function fareAlerts()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        $alerts = \App\Models\FareAlert::where('agent_id', Auth::id())->latest()->get();
        return view('agent.b2b.fare-alerts', compact('wallet', 'alerts'));
    }

    public function createFareAlert()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()], ['balance' => 0.00]);
        return view('agent.b2b.fare-alert-create', compact('wallet'));
    }

    public function storeFareAlert(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'travel_date' => 'required|date|after_or_equal:today',
            'pax' => 'required|integer|min:1',
            'target_price' => 'nullable|numeric',
            'notification_channel' => 'required',
            'passenger_details' => 'nullable|array',
        ]);

        $autoBook = $request->has('auto_book') ? true : false;
        
        \App\Models\FareAlert::create([
            'agent_id' => Auth::id(),
            'origin' => strtoupper($request->origin),
            'destination' => strtoupper($request->destination),
            'travel_date' => $request->travel_date,
            'pax' => $request->pax,
            'target_price' => $request->target_price,
            'auto_book' => $autoBook,
            'passenger_details' => $autoBook && $request->has('passenger_details') ? $request->passenger_details : null,
            'notification_channel' => is_array($request->notification_channel) ? implode(',', $request->notification_channel) : $request->notification_channel,
            'status' => 'pending'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Fare tracking active! We will notify you when price drops.']);
        }

        return redirect()->route('agent.b2b.fare-alerts')->with('success', 'Fare alert created successfully!');
    }

    public function deleteFareAlert($id)
    {
        $alert = \App\Models\FareAlert::where('agent_id', Auth::id())->findOrFail($id);
        $alert->delete();
        return back()->with('success', 'Fare alert deleted.');
    }
}

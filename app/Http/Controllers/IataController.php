<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\IataAgentProfile;
use Illuminate\Support\Facades\Auth;

class IataController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('agent.login');
        }

        // Ensure wallet exists
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        
        // Ensure profile exists or handle null
        $profile = IataAgentProfile::where('user_id' , $user->id)->first();
        
        return view('iata.dashboard', compact('user', 'wallet', 'profile'));
    }

    public function riskControl()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('agent.login');
        }
        // Mocking automated data for demonstration
        $stats = [
            'deposit' => 10000000, // ₹1 Cr
            'credit_limit' => 105000000, // ₹10.5 Cr
            'sales_at_risk' => 42050880, // ₹4.2 Cr
            'days_until_remittance' => 4,
            'status' => 'ACTIVE'
        ];

        return view('iata.bsp-control', compact('stats'));
    }

    public function simulateTicketing(Request $request)
    {
        // Automation logic: Validate credit, issue PNR, update exposure
        return response()->json([
            'success' => true,
            'pnr' => 'RT'.rand(100, 999).'V',
            'exposure_update' => '41.2%'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commission;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Show registration form for providers
     */
    public function showRegistration()
    {
        return view('affiliate.register');
    }

    /**
     * Handle provider registration
     */
    public function handleRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'service_category' => 'required|string',
            'pricing' => 'required|numeric',
            'location' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_AFFILIATE,
            'service_category' => $request->service_category,
            'pricing' => $request->pricing,
            'provider_location' => $request->location,
            'is_approved' => false, // Pending admin approval
        ]);

        return redirect()->route('login')->with('success', 'Registration submitted! Please wait for admin approval.');
    }

    /**
     * Affiliate Dashboard
     */
    public function dashboard()
    {
        $provider = Auth::user();
        
        // Auto-approve if status is active (compatibility with existing admin panel)
        if ($provider->status === 'active' && !$provider->is_approved) {
            $provider->update(['is_approved' => true]);
        }

        if (!$provider->is_approved) {
            return view('affiliate.pending');
        }

        // Ensure affiliate code exists
        if (!$provider->affiliate_code) {
            $code = strtoupper(Str::slug($provider->service_category ?? 'AFF') . rand(100, 999));
            $provider->update(['affiliate_code' => $code]);
        }

        $referralsCount = User::where('referred_by', $provider->id)->count();
        $totalEarnings = Commission::where('user_id', $provider->id)->sum('amount');
        $pendingCommission = Commission::where('user_id', $provider->id)->where('status', 'pending')->sum('amount');
        $paidCommission = Commission::where('user_id', $provider->id)->where('status', 'paid')->sum('amount');

        $recentReferrals = User::where('referred_by', $provider->id)->latest()->take(5)->get();

        return view('affiliate.dashboard', compact('provider', 'referralsCount', 'totalEarnings', 'pendingCommission', 'paidCommission', 'recentReferrals'));
    }

    /**
     * Admin: List all providers
     */
    public function adminIndex()
    {
        $providers = User::where('role', User::ROLE_AFFILIATE)->get();
        return view('admin.affiliates.index', compact('providers'));
    }

    /**
     * Admin: Approve provider and generate code
     */
    public function adminApprove($id)
    {
        $user = User::findOrFail($id);
        
        // Generate unique affiliate code
        $code = strtoupper(Str::slug($user->service_category) . rand(100, 999));
        
        $user->update([
            'is_approved' => true,
            'affiliate_code' => $code
        ]);

        return back()->with('success', 'Provider approved! Affiliate code generated: ' . $code);
    }

    /**
     * Admin: List all withdrawal requests
     */
    public function adminWithdrawals()
    {
        $withdrawals = Withdrawal::with('user')->latest()->get();
        return view('admin.affiliates.withdrawals', compact('withdrawals'));
    }

    /**
     * Admin: Mark withdrawal as paid
     */
    public function adminMarkPaid($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->update(['status' => 'paid']);

        // Optionally update associated commissions to 'paid' if they were part of this withdrawal
        Commission::where('user_id', $withdrawal->user_id)
            ->where('status', 'pending')
            ->update(['status' => 'paid']);

        return back()->with('success', 'Withdrawal marked as paid and commissions updated.');
    }

    /**
     * User Tracking Logic (Called during User Registration)
     * This is a helper method to be used in AuthController
     */
    public static function trackReferral($newUser)
    {
        $referredByCode = request()->cookie('referred_by');
        if ($referredByCode) {
            $referrer = User::where('affiliate_code', $referredByCode)->first();
            if ($referrer) {
                $newUser->update(['referred_by' => $referrer->id]);

                // Optional: Generate signup bonus commission
                Commission::create([
                    'user_id' => $referrer->id,
                    'referred_user_id' => $newUser->id,
                    'amount' => 10, // Default ₹10 signup bonus
                    'type' => 'signup',
                    'status' => 'pending',
                    'description' => 'Signup bonus for referring ' . $newUser->name
                ]);
            }
        }
    }
}

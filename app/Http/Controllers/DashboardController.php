<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Booking;
use App\Models\Wallet;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();
        
        $stats = [
            'bookings' => \App\Models\Booking::where('user_id', $userId)->count(),
            'wishlist' => \App\Models\Wishlist::where('user_id', $userId)->count(),
            'searches' => \App\Models\SavedSearch::where('user_id', $userId)->count(),
            'wallet'   => \App\Models\Wallet::where('user_id', $userId)->first()->balance ?? 0,
        ];

        $recentBookings = \App\Models\Booking::where('user_id', $userId)
            ->with(['flightBooking'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentBookings', 'user'));
    }

    public function bookings(Request $request)
    {
        $userId = Auth::id();
        $query = Booking::where('user_id', $userId)->latest();

        // 1. Filter by Reference / ID / Keyword
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('booking_reference', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', 'like', '%' . $searchTerm . '%');
            });
        }

        // 2. Filter by Type (Flight/Hotel)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 3. Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Filter by Date Range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        if (method_exists(Booking::class, 'flightBooking')) {
            $query->with(['flightBooking', 'passengers']);
        }

        $bookings = $query->paginate(15);
        return view('dashboard.bookings', compact('bookings'));
    }

    public function profile()
    {
        return view('dashboard.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function wallet()
    {
        $user = Auth::user();
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id], ['balance' => 0]);
        $transactions = $user->transactions()->latest()->take(10)->get();
        return view('dashboard.wallet', compact('wallet', 'transactions'));
    }

    public function wishlist()
    {
        $wishlistItems = \App\Models\Wishlist::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.wishlist', compact('wishlistItems'));
    }

    public function searches()
    {
        $savedSearches = \App\Models\SavedSearch::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.searches', compact('savedSearches'));
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(10);
        Auth::user()->unreadNotifications->markAsRead();
        return view('dashboard.notifications', compact('notifications'));
    }

    public function priceAlerts()
    {
        $alerts = \App\Models\FareAlert::where('agent_id', Auth::id())->latest()->get();
        return view('dashboard.price-alerts', compact('alerts'));
    }

    public function storePriceAlert(Request $request)
    {
        $request->validate([
            'origin' => 'required|size:3',
            'destination' => 'required|size:3',
            'travel_date' => 'required|date',
            'target_price' => 'required|numeric',
        ]);

        \App\Models\FareAlert::create([
            'agent_id' => Auth::id(),
            'origin' => strtoupper($request->origin),
            'destination' => strtoupper($request->destination),
            'travel_date' => $request->travel_date,
            'target_price' => $request->target_price,
            'status' => 'pending',
            'notification_channel' => $request->channel ?? 'email',
        ]);

        return back()->with('success', 'Price alert set successfully! We will notify you when the price drops.');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match.');
        }

        $user->update(['password' => \Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function updateSettings(Request $request)
    {
        // Simple placeholder for preference update
        return back()->with('success', 'Notification preferences saved!');
    }

    public function deactivateAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been permanently deactivated.');
    }
}

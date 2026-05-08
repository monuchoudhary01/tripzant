<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Stats
        $stats = [
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount') ?: 0,
            'total_bookings' => Booking::count(),
            'active_users' => User::where('status', 'active')->count(),
            'flight_bookings' => Booking::where('type', 'flight')->count(),
            'hotel_bookings' => Booking::where('type', 'hotel')->count(),
            'tour_bookings' => \App\Models\Tour::count(),
            'homestays' => \App\Models\Homestay::count(),
            'trains' => \App\Models\Train::count(),
            'visa_requests' => 0, // Placeholder
            'esim_plans' => \App\Models\EsimPlan::count(),
            'insurance_plans' => \App\Models\InsurancePlan::count(),
            'total_partners' => \App\Models\User::whereIn('role', ['b2b', 'iata'])->count(),
            'wallet_balance' => Wallet::sum('balance') ?: 0,
        ];

        // API Status Mock Data
        $apiStatus = [
            ['name' => 'Amadeus GDS', 'status' => 'Online', 'latency' => '120ms', 'class' => 'success'],
            ['name' => 'Google Flights', 'status' => 'Online', 'latency' => '85ms', 'class' => 'success'],
            ['name' => 'HotelBeds', 'status' => 'Degraded', 'latency' => '450ms', 'class' => 'warning'],
            ['name' => 'TravelPayouts', 'status' => 'Online', 'latency' => '110ms', 'class' => 'success'],
        ];

        // Analytics Graph Data (Last 7 Days)
        $analytics = [
            'labels' => [],
            'data' => []
        ];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $analytics['labels'][] = now()->subDays($i)->format('D');
            $analytics['data'][] = Booking::whereDate('created_at', $date)->count();
        }

        $recentBookings = Booking::with('user')->latest()->take(10)->get();
        $recentTransactions = Transaction::with('user')->latest()->take(8)->get();
        $activities = AuditLog::latest()->take(10)->get();

        // Service Split Data (Donut Chart)
        $serviceSplit = [
            'labels' => ['Flights', 'Hotels', 'Tours', 'Cargo'],
            'data' => [
                Booking::where('type', 'flight')->sum('total_amount'),
                Booking::where('type', 'hotel')->sum('total_amount'),
                Booking::where('type', 'tour')->sum('total_amount') ?? 0,
                \App\Models\CargoBooking::sum('total_price') ?? 0,
            ]
        ];

        // Top 5 Agents by Revenue
        $topAgents = User::whereIn('role', ['b2b', 'iata'])
            ->withSum(['bookings' => function($q) { $q->where('status', 'confirmed'); }], 'total_amount')
            ->orderBy('bookings_sum_total_amount', 'desc')
            ->take(5)
            ->get();

        // Popular Destinations (Mock or logic if routes are stored)
        $popularDestinations = [
            ['route' => 'DEL - BOM', 'count' => 145, 'trend' => 'up'],
            ['route' => 'DXB - LHR', 'count' => 98, 'trend' => 'up'],
            ['route' => 'BLR - SIN', 'count' => 67, 'trend' => 'down'],
        ];

        // System Access Directory Counts
        $roleCounts = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats', 'recentBookings', 'recentTransactions', 'activities', 
            'analytics', 'apiStatus', 'serviceSplit', 'topAgents', 'popularDestinations',
            'roleCounts'
        ));
    }
}

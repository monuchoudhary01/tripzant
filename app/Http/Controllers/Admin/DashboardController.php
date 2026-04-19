<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\ApiLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Real counts
        $totalPartners = User::whereIn('role', [
            User::ROLE_B2B_AGENT, 
            User::ROLE_IATA_AGENT, 
            User::ROLE_CORPORATE, 
            User::ROLE_AMADEUS_PARTNER
        ])->count();
        
        $totalBookings = Booking::count();
        $totalFlightBookings = Booking::where('type', 'flight')->count();
        $totalHotelBookings = Booking::where('type', 'hotel')->count();
        
        // Revenue breakdown
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');
        
        // Recent activities from Audit Logs
        $activities = AuditLog::latest()->take(10)->get();
        
        // Monthly growth (Last 12 months)
        $monthlyData = Booking::select(
            DB::raw('sum(total_amount) as revenue'), 
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->take(12)
        ->get()
        ->reverse();

        return view('admin.dashboard', compact(
            'totalPartners', 'totalBookings', 'totalFlightBookings', 
            'totalHotelBookings', 'totalRevenue', 'activities', 'monthlyData'
        ));
    }
}

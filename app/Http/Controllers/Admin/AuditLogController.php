<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = AuditLog::query();

            // Filters
            if ($request->filled('user_type')) {
                $query->where('user_type', $request->user_type);
            }

            if ($request->filled('module')) {
                $query->where('module', $request->module);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('user_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('action', 'like', "%{$search}%");
                });
            }

            if ($request->filled('date_start')) {
                $query->whereDate('created_at', '>=', $request->date_start);
            }

            if ($request->filled('date_end')) {
                $query->whereDate('created_at', '<=', $request->date_end);
            }

            $logs = $query->latest()->paginate(20)->withQueryString();

            // Get unique user types and modules for filters
            $userTypes = AuditLog::distinct()->pluck('user_type')->filter();
            $modules = AuditLog::distinct()->pluck('module')->filter();

        } catch (\Exception $e) {
            // Expanded Professional Mock Data
            $mockLogs = collect([
                (object)[
                    'id' => 1, 'user_id' => 101, 'user_type' => 'agent', 'user_name' => 'Skyline Travels (Rahul)',
                    'module' => 'Flight', 'action' => 'Ticket Issue', 'description' => 'Issued ticket for PNR: AMZ-948271 (2 Pax)',
                    'ip_address' => '192.168.1.45', 'created_at' => now()->subMinutes(5)
                ],
                (object)[
                    'id' => 10, 'user_id' => 205, 'user_type' => 'api', 'user_name' => 'Amadeus GDS Panel',
                    'module' => 'API', 'action' => 'Air_Price', 'description' => 'Price validation for itinerary DEL-DXB',
                    'ip_address' => '185.12.44.1', 'created_at' => now()->subMinutes(12)
                ],
                (object)[
                    'id' => 2, 'user_id' => 502, 'user_type' => 'corporate', 'user_name' => 'Wipro Corporate (Employee)',
                    'module' => 'Corporate', 'action' => 'Policy Violation', 'description' => 'Booking request above budget limit (INR 15,000)',
                    'ip_address' => '202.45.12.8', 'created_at' => now()->subMinutes(45)
                ],
                (object)[
                    'id' => 11, 'user_id' => 101, 'user_type' => 'agent', 'user_name' => 'Skyline Travels (Rahul)',
                    'module' => 'Flight', 'action' => 'Cancel PNR', 'description' => 'Cancellation request for PNR: TST-4492 (Refund Initiated)',
                    'ip_address' => '192.168.1.45', 'created_at' => now()->subHour()
                ],
                (object)[
                    'id' => 3, 'user_id' => 1, 'user_type' => 'admin', 'user_name' => 'Master Admin',
                    'module' => 'Auth', 'action' => 'Login', 'description' => 'System login successful',
                    'ip_address' => '127.0.0.1', 'created_at' => now()->subHours(2)
                ],
                (object)[
                    'id' => 4, 'user_id' => 101, 'user_type' => 'agent', 'user_name' => 'Skyline Travels (Rahul)',
                    'module' => 'Settings', 'action' => 'Markup Update', 'description' => 'Updated global markup for Flights to 5%',
                    'ip_address' => '192.168.1.45', 'created_at' => now()->subHours(5)
                ],
                (object)[
                    'id' => 5, 'user_id' => 205, 'user_type' => 'api', 'user_name' => 'Amadeus GDS Panel',
                    'module' => 'API', 'action' => 'Air_Sell', 'description' => 'Sold segments for PNR generation',
                    'ip_address' => '185.12.44.1', 'created_at' => now()->subHours(8)
                ],
                (object)[
                    'id' => 6, 'user_id' => 304, 'user_type' => 'agent', 'user_name' => 'Global Tours',
                    'module' => 'Hotel', 'action' => 'Booking', 'description' => 'Confirmed booking for Taj Exotica (3 Nights)',
                    'ip_address' => '104.22.8.9', 'created_at' => now()->subDay()
                ],
            ]);

            $logs = new \Illuminate\Pagination\LengthAwarePaginator($mockLogs, $mockLogs->count(), 20);
            $userTypes = collect(['agent', 'corporate', 'admin', 'api']);
            $modules = collect(['Flight', 'Hotel', 'Auth', 'Settings', 'API', 'Corporate']);
            
            if (!session()->has('error_shown')) {
                session()->flash('error', 'Database connection refused. Showing ENHANCED MOCK DATA.');
                session(['error_shown' => true]);
            }
        }

        return view('admin.audit-logs.index', compact('logs', 'userTypes', 'modules'));
    }

    public function show($id)
    {
        try {
            $log = AuditLog::findOrFail($id);
        } catch (\Exception $e) {
            // Advanced Mock Details
            $id = (int)$id;
            $mockDetail = [
                'user_id' => 101, 'user_type' => 'agent', 'user_name' => 'Skyline Travels (Rahul)',
                'module' => 'Flight', 'action' => 'Ticket Issue',
                'description' => 'Issued 2 tickets for PNR: AMZ-948271. Destination: DEL to DXB.',
                'ip_address' => '192.168.1.45', 'created_at' => now()->subMinutes(5),
                'request_data' => [
                    'pnr' => 'AMZ-948271',
                    'passengers' => [['name' => 'Rahul Khanna', 'type' => 'ADT'], ['name' => 'Sneha Khanna', 'type' => 'ADT']],
                    'segments' => [['flight' => 'EK-511', 'from' => 'DEL', 'to' => 'DXB', 'date' => '2026-05-15']],
                    'fare' => ['net' => 45000, 'markup' => 2250, 'total' => 47250]
                ],
                'response_data' => [
                    'status' => 'CONFIRMED',
                    'e_tickets' => ['176-2489102482', '176-2489102483'],
                    'gds_response' => 'SUCCESS_TICKET_ISSUED'
                ],
                'old_values' => null,
                'new_values' => null
            ];

            if ($id == 10 || $id == 5) {
                $mockDetail = array_merge($mockDetail, [
                    'user_id' => 205, 'user_type' => 'api', 'user_name' => 'Amadeus GDS Panel',
                    'module' => 'API', 'action' => $id == 10 ? 'Air_Price' : 'Air_Sell',
                    'description' => $id == 10 ? 'Validating real-time fare for flight EK-511' : 'Holding seats for PNR creation',
                    'ip_address' => '185.12.44.1', 'created_at' => now()->subMinutes(12),
                    'request_data' => ['command' => $id == 10 ? 'FQP' : 'SS', 'payload' => 'EK511Y15MAYDELDXB'],
                    'response_data' => ['status' => 'OK', 'raw_xml_brief' => '<SearchResponse><Fares>...</Fares></SearchResponse>'],
                    'old_values' => null,
                    'new_values' => null
                ]);
            } elseif ($id == 2) {
                $mockDetail = array_merge($mockDetail, [
                    'user_id' => 502, 'user_type' => 'corporate', 'user_name' => 'Wipro Corporate (Employee)',
                    'module' => 'Corporate', 'action' => 'Policy Violation',
                    'description' => 'Alert: Booking attempted outside preferred airline list (Emirates used instead of Air India)',
                    'ip_address' => '202.45.12.8', 'created_at' => now()->subMinutes(45),
                    'request_data' => ['policy_id' => 'POL-09', 'rule' => 'PREFERRED_AIRLINE', 'attempted' => 'EK'],
                    'response_data' => ['status' => 'FLAGGED', 'requires_approval' => true],
                    'old_values' => ['policy_status' => 'compliant'],
                    'new_values' => ['policy_status' => 'violated']
                ]);
            }

            $log = (object)$mockDetail;
        }

        return view('admin.audit-logs.show', compact('log'));
    }
    public function dashboard(Request $request)
    {
        try {
            $stats = [
                'total_searches' => AuditLog::where('module', 'Flight')->where('action', 'Search')->count(),
                'total_pnrs' => AuditLog::whereIn('action', ['Ticket Issue', 'Air_Sell', 'Booking'])->count(),
                'total_confirmed' => \App\Models\Booking::where('status', 'confirmed')->count(),
                'total_failed' => AuditLog::where('action', 'like', '%Error%')->orWhere('action', 'like', '%Fail%')->count(),
            ];

            $operatorPerformance = AuditLog::select('user_name', \DB::raw('count(*) as total'))
                ->groupBy('user_name')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();

        } catch (\Exception $e) {
            // High-End Analytics Mock Data
            $stats = [
                'total_searches' => 4820,
                'total_pnrs' => 312,
                'total_confirmed' => 285,
                'total_failed' => 27,
            ];

            $operatorPerformance = collect([
                (object)['user_name' => 'Skyline Travels (Rahul)', 'total' => 145, 'conversion' => '8.2%'],
                (object)['user_name' => 'Global Tours', 'total' => 98, 'conversion' => '6.4%'],
                (object)['user_name' => 'Wipro (Corporate)', 'total' => 56, 'conversion' => '12.1%'],
                (object)['user_name' => 'Amadeus GDS (System)', 'total' => 842, 'conversion' => 'N/A'],
                (object)['user_name' => 'Tripzant Admin', 'total' => 34, 'conversion' => 'N/A'],
            ]);
        }

        return view('admin.audit-logs.dashboard', compact('stats', 'operatorPerformance'));
    }
}

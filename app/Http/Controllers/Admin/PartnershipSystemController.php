<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteAnalytic;
use Illuminate\Http\Request;

class PartnershipSystemController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_websites' => WebsiteAnalytic::count(),
            'high_traffic' => WebsiteAnalytic::where('traffic_count', '>=', 50000)->count(),
            'partnerships' => WebsiteAnalytic::where('status', 'partnered')->count(),
            'total_revenue' => WebsiteAnalytic::sum('revenue_generated'),
        ];

        $recentWebsites = WebsiteAnalytic::latest()->take(5)->get();
        $topPartners = WebsiteAnalytic::where('status', 'partnered')
            ->orderBy('revenue_generated', 'desc')
            ->take(5)
            ->get();

        return view('admin.partnership.dashboard', compact('stats', 'recentWebsites', 'topPartners'));
    }

    public function index(Request $request)
    {
        $query = WebsiteAnalytic::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('traffic')) {
            if ($request->traffic == '10k') $query->where('traffic_count', '>=', 10000);
            if ($request->traffic == '50k') $query->where('traffic_count', '>=', 50000);
            if ($request->traffic == '100k') $query->where('traffic_count', '>=', 100000);
        }

        $websites = $query->latest()->paginate(15);

        return view('admin.partnership.websites', compact('websites'));
    }

    public function create()
    {
        return view('admin.partnership.traffic-checker');
    }

    public function fetchTraffic(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        
        $domain = parse_url($request->url, PHP_URL_HOST);
        
        // Mocking API call to SimilarWeb / Ubersuggest
        $mockData = [
            'domain' => $domain,
            'name' => ucfirst(explode('.', $domain)[0]),
            'monthly_traffic' => rand(10, 500) . 'K',
            'traffic_count' => rand(10000, 500000),
            'traffic_sources' => [
                'Direct' => rand(20, 40) . '%',
                'Organic' => rand(30, 60) . '%',
                'Social' => rand(5, 15) . '%',
                'Ads' => rand(5, 10) . '%',
            ],
            'top_countries' => ['USA', 'UK', 'India', 'Canada', 'Australia'],
            'category' => 'Travel & Hospitality',
            'contact_email' => 'admin@' . $domain,
            'contact_phone' => '+1 800-456-' . rand(1000, 9999),
            'social_links' => [
                'facebook' => 'https://facebook.com/' . $domain,
                'twitter' => 'https://twitter.com/' . $domain,
                'instagram' => 'https://instagram.com/' . $domain,
            ]
        ];

        $website = WebsiteAnalytic::updateOrCreate(
            ['domain' => $domain],
            $mockData
        );

        return redirect()->route('admin.partnership.show', $website->id)
            ->with('success', 'Traffic data fetched successfully!');
    }

    public function show($id)
    {
        $website = WebsiteAnalytic::findOrFail($id);
        return view('admin.partnership.details', compact('website'));
    }

    public function updateStatus(Request $request, $id)
    {
        $website = WebsiteAnalytic::findOrFail($id);
        $website->update(['status' => $request->status]);
        
        return back()->with('success', 'Status updated successfully!');
    }

    public function widget()
    {
        return view('admin.partnership.widget');
    }

    public function revenue()
    {
        $partners = WebsiteAnalytic::where('status', 'partnered')
            ->orderBy('revenue_generated', 'desc')
            ->get();
        return view('admin.partnership.revenue', compact('partners'));
    }
}

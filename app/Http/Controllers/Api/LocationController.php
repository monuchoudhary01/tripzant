<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TravelPayoutsFlightService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $travelPayoutsService;

    public function __construct(TravelPayoutsFlightService $travelPayoutsService)
    {
        $this->travelPayoutsService = $travelPayoutsService;
    }

    public function autocomplete(Request $request)
    {
        $request->validate([
            'term' => 'required|string|min:2',
            'locale' => 'sometimes|string',
            'types' => 'sometimes|array'
        ]);

        $term = $request->query('term');
        $locale = $request->query('locale', 'en');
        $types = $request->query('types', ['city', 'airport']);

        $results = $this->travelPayoutsService->autocomplete($term, $locale, $types);

        return response()->json($results);
    }
}

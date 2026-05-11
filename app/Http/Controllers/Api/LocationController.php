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

    /**
     * @OA\Get(
     *     path="/locations/autocomplete",
     *     tags={"Locations"},
     *     summary="Location Autocomplete",
     *     description="Search for cities and airports based on a term",
     *     @OA\Parameter(name="term", in="query", required=true, @OA\Schema(type="string", example="Ja")),
     *     @OA\Parameter(name="locale", in="query", required=false, @OA\Schema(type="string", example="en")),
     *     @OA\Parameter(name="types[]", in="query", required=false, @OA\Schema(type="array", @OA\Items(type="string", example="city"))),
     *     @OA\Response(response=200, description="List of locations")
     * )
     */
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

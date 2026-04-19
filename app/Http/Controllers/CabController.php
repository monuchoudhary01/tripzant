<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferService;

class CabController extends Controller
{
    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function index(Request $request)
    {
        $params = [
            'startLocation' => $request->from ?? 'PMI',
            'endLocation' => $request->to ?? 'PMI',
            'startDateTime' => $request->date ?? date('Y-m-d\TH:i:s', strtotime('+2 days')),
            'passengers' => $request->passengers ?? 2,
        ];

        $results = $this->transferService->search($params);

        return view('cab-listing', [
            'transfers' => $results['data'] ?? [],
            'params' => $params
        ]);
    }
}

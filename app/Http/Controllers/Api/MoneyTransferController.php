<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MoneyTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoneyTransferController extends Controller
{
    protected $transferService;

    public function __construct(MoneyTransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    /**
     * @OA\Get(
     *     path="/get-exchange-rate",
     *     tags={"Money Transfer"},
     *     summary="Get Exchange Rate",
     *     @OA\Parameter(name="from", in="query", required=true, @OA\Schema(type="string", example="USD")),
     *     @OA\Parameter(name="to", in="query", required=true, @OA\Schema(type="string", example="INR")),
     *     @OA\Response(response=200, description="Exchange rate result")
     * )
     */
    public function getExchangeRate(Request $request)
    {
        $request->validate([
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
        ]);

        $rate = $this->transferService->getExchangeRate($request->from, $request->to);

        return response()->json([
            'success' => true,
            'from' => $request->from,
            'to' => $request->to,
            'rate' => $rate,
            'timestamp' => now()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/get-providers",
     *     tags={"Money Transfer"},
     *     summary="Get Transfer Providers",
     *     @OA\Parameter(name="from_country", in="query", required=true, @OA\Schema(type="string", example="US")),
     *     @OA\Parameter(name="from_currency", in="query", required=true, @OA\Schema(type="string", example="USD")),
     *     @OA\Parameter(name="to_country", in="query", required=true, @OA\Schema(type="string", example="IN")),
     *     @OA\Parameter(name="to_currency", in="query", required=true, @OA\Schema(type="string", example="INR")),
     *     @OA\Parameter(name="amount", in="query", required=true, @OA\Schema(type="number", example=100)),
     *     @OA\Response(response=200, description="List of providers")
     * )
     */
    public function getProviders(Request $request)
    {
        $request->validate([
            'from_country' => 'required|string',
            'from_currency' => 'required|string|size:3',
            'to_country' => 'required|string',
            'to_currency' => 'required|string|size:3',
            'amount' => 'required|numeric|min:1',
        ]);

        $providers = $this->transferService->getProviders(
            $request->from_country,
            $request->from_currency,
            $request->to_country,
            $request->to_currency,
            $request->amount
        );

        return response()->json([
            'success' => true,
            'providers' => $providers
        ]);
    }

    /**
     * @OA\Post(
     *     path="/create-transfer",
     *     tags={"Money Transfer"},
     *     summary="Create a Money Transfer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","type","source_currency","source_amount","target_currency","target_amount","exchange_rate","recipient_details"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="type", type="string", enum={"wallet_to_wallet","wallet_to_bank","international"}),
     *             @OA\Property(property="source_currency", type="string"),
     *             @OA\Property(property="source_amount", type="number"),
     *             @OA\Property(property="target_currency", type="string"),
     *             @OA\Property(property="target_amount", type="number"),
     *             @OA\Property(property="exchange_rate", type="number"),
     *             @OA\Property(property="recipient_details", type="object")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Transfer created successfully")
     * )
     */
    public function createTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:wallet_to_wallet,wallet_to_bank,international',
            'source_currency' => 'required|string|size:3',
            'source_amount' => 'required|numeric|min:1',
            'target_currency' => 'required|string|size:3',
            'target_amount' => 'required|numeric|min:1',
            'exchange_rate' => 'required|numeric',
            'provider_id' => 'nullable|exists:transfer_providers,id',
            'recipient_details' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $transfer = $this->transferService->createTransfer($request->all());
            
            // Auto-execute for now? Or wait for confirmation
            $result = $this->transferService->executeTransfer($transfer);

            return response()->json([
                'success' => true,
                'message' => 'Transfer initiated successfully',
                'transfer' => $transfer,
                'execution_result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/webhook/payment-status",
     *     tags={"Money Transfer"},
     *     summary="Payment Webhook",
     *     description="Webhook endpoint for payment status updates",
     *     @OA\Response(response=200, description="Received")
     * )
     */
    public function handleWebhook(Request $request)
    {
        // Handle Wise, Stripe, Razorpay webhooks
        // Logic to update transfer status based on external reference
        return response()->json(['status' => 'received']);
    }
}

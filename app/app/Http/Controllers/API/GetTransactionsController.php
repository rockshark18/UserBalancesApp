<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetTransactionsRequest;
use App\Services\TransactionService;
use App\Util\RealLagSimulation;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetTransactionsController extends Controller // NOTE:
{
    public function __invoke(GetTransactionsRequest $request,
                             TransactionService $transactionService
    ): JsonResponse
    {
        RealLagSimulation::handle(10,400);

        try {
            $user = JWTAuth::parseToken()->authenticate();

            $limit  = $request->input('limit', null);
            $search = $request->input('search', null);
            $transactions = $transactionService->getByUserEmail($user->email, $limit, $search);

            return response()->json([
                'success'=>true,
                'search'=>$search,
                'data' => [
                    'transactions' => $transactions,
                ],
            ], 200);

        }catch (Exception $e){
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage(),
            ],400);
        }
    }
}

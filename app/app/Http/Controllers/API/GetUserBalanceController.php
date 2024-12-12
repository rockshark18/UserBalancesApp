<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserBalanceRequest;
use App\Services\UserBalanceService;
use App\Util\RealLagSimulation;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetUserBalanceController extends Controller
{
    public function __invoke(GetUserBalanceRequest $request,
                             UserBalanceService $userBalanceService
    ): JsonResponse
    {
        RealLagSimulation::handle(10,400);

        try {
            $user = JWTAuth::parseToken()->authenticate();
            $userbalance = $userBalanceService->getBalance($user);

            return response()->json([
                'success'=>true,
                'data' => [
                    'userbalance' => $userbalance,
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

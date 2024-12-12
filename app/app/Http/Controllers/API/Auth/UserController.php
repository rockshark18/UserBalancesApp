<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'success'=>false,
                    'error' => 'Пользователь не найден'
                ], 404);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success'=>false,
                'error' => 'Неверный токен'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'user'=>$user
        ]);
    }
}



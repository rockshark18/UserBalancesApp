<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success'=>false,
                    'error' => 'Неверный логин или пароль'
                ], 401);
            }

            $user = auth()->user();
            $accessToken = JWTAuth::claims([
                'role' => $user->role
            ])->fromUser($user);

            return response()->json([
                'success'=>true,
                'access_token' => $accessToken,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success'=>false,
                'error' => 'Не удалось создать токен'
            ], 500);
        }
    }
}



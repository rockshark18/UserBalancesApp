<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'success'=>true,
            'message' => 'Пользователь успешно деаутифицировался'
        ]);
    }
}

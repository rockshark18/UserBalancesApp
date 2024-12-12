<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function __invoke(Request $request, UserService $userService): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',//|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            $user = $userService->createUser(
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
            );
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('user','token'), 201);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage(),
            ],400);
        }
    }
}



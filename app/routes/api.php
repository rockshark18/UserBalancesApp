<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CreateTransactionController;
use App\Http\Controllers\API\GetTransactionsController;
use App\Http\Controllers\API\GetUserBalanceController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\UserController;
use App\Http\Middleware\JwtMiddleware;

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/user', UserController::class);
});

Route::middleware(JwtMiddleware::class)->prefix('v1')
    ->group(function () {
        Route::post('/transactions/create', CreateTransactionController::class);
        Route::post('/transactions',        GetTransactionsController::class);
        Route::get('/userbalance',         GetUserBalanceController::class);
    }
);



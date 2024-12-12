<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Jobs\CreateTransactionJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Sleep;

class CreateTransactionController extends Controller
{
    public function __invoke(CreateTransactionRequest $request): JsonResponse
    {
        $email = $request->input('user_email');
        $amount = $request->input('amount');
        $description = $request->input('description');

        $amount = bcadd($amount, '0', 2);

        // push  job to queue
        dispatch(new CreateTransactionJob($email, $amount, $description));

        return response()->json([
            'success'=>true,
            'message' => "Transaction added to Job Queue",
            'data' => [
                'user_email' => $email,
                'amount'     => $amount,
                'description'=> $description,
            ],
        ], 201);
    }
}

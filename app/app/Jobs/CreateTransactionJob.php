<?php

namespace App\Jobs;

use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Exception;

class CreateTransactionJob implements ShouldQueue
{
    use Queueable;

    protected string $email;
    protected string $amount;
    protected string $description;

    public function __construct(string $email, string $amount, string $description)
    {
        $this->email        = $email;
        $this->amount       = $amount;
        $this->description  = $description;
    }

    public function handle(UserService $userService,
                           TransactionService $transactionService): void
    {
        try {
            $user = $userService->findByEmail($this->email);
            $transactionService->createTransaction($user, $this->amount, $this->description);
        }catch (Exception $e) {
            throw new Exception('CreateTransactionJob error: '.$e->getMessage());
        }
    }
}

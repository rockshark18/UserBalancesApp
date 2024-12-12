<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Exception;

class TransactionService
{
    protected UserBalanceService $userBalanceService;

    public function __construct(UserBalanceService $userBalanceService){
        $this->userBalanceService = $userBalanceService;
    }

    public function createTransaction(
        User $user,
        string $amount,     // NOTE: Я не использую 'float' из-за вероятности потерять точность, только bcmath(bcadd и т.д.) и хранение в string
        string $description,
    ): void
    {
        try {
            $this->userBalanceService->incrementBalance($user, $amount);

            $type = TransactionType::INCOME;
            if ($amount < 0.0){
                $type = TransactionType::EXPENSE;
            }

            $user->transactions()->create([
                    'type'      => $type,
                    'amount'    => $amount,
                    'desc'      => $description,
                ]);
        }catch (Exception $e){
            throw new Exception('> TransactionService.createTransaction'.PHP_EOL. $e->getMessage(), 0, $e);
        }
    }

    public function getByUserEmail(string $email, ?int $limit, ?string $search = null)
    {
        /*
            SELECT transactions.*
            FROM transactions
            INNER JOIN users ON transactions.user_id = users.id
            WHERE users.email = 'user@abc.com'
            ORDER BY transactions.created_at DESC
            LIMIT 10;
        */

        try {
            $query = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
                ->where('users.email', $email)
                ->select('transactions.*')
                ->orderBy('transactions.created_at', 'desc'); // Сортируем по убыванию даты

            if (!is_null($search)) {
                $query->whereRaw('LOWER(transactions.desc) LIKE ?', ['%' . mb_strtolower($search, 'UTF-8') . '%']);
            }
            if (!is_null($limit)) {
                $query->take($limit);
            }
            return $query->get();//->reverse()->values(); // теперь приводим записи к оригинальному порядку, закомментировал т.к. всё равно сортировка проводится на фронте
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}

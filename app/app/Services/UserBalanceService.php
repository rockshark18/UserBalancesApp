<?php

namespace App\Services;

use App\Models\User;
use Exception;

class UserBalanceService
{
    public function incrementBalance(User $user,
                                     string $amount // NOTE: Я не использую 'float' из-за вероятности потерять точность, только bcmath(bcadd и т.д.) и хранение в string
    ) : void
    {
        try {
            //$modifiedBalance = $user->balance->balance + $amount; // NOTE: old implementation, float
            $modifiedBalance = bcadd($user->balance->balance, $amount, 2);

            if ($modifiedBalance < 0) {
                throw new Exception('Insufficient balance. Abort');
            }

            $user->balance->update(['balance' => $modifiedBalance]);
        }catch (Exception $e){
            throw new Exception('> UserBalanceService.incrementBalance'.PHP_EOL. $e->getMessage(), 0, $e);
        }

    }

    public function getBalance(User $user)
    {
        try {
            return $user->balance;
        }catch (Exception $e){
            throw new Exception('> UserBalanceService.getBalance'.PHP_EOL. $e->getMessage(), 0, $e);
        }

    }
}

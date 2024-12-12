<?php

namespace App\Console\Commands;

use App\Jobs\CreateTransactionJob;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateTransactionCommand extends Command
{
    protected $description = 'Command for add/sub user balance +/- N sum';

    protected $signature = 'transaction:create {user_email} {amount} {description}';

    public function handle() : void
    {
        $email          = $this->argument('user_email');
        $description    = $this->argument('description');

        // Удаление обратного слэша для вариантов с экранированием
        // типа docker exec -it userbalances.app php artisan transaction:process vasya@gmail.com '\-1000' 'Купил цветы'
        $amount = str_replace('\\', '', $this->argument('amount'));
        if (!is_numeric($amount)) {
            $this->error('ERROR: The amount field must be a number.');
            return;
        }
        $amount = bcadd($amount,'0', 2);

        $validator = Validator::make([
            'user_email' => $email,
            'amount'     => $amount,
            'description'=> $description,
        ], [
            'user_email'    => 'required|email',
            'amount'        => 'required|numeric',
            'description'   => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $this->error('ERROR: Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        dispatch(new CreateTransactionJob($email, $amount, $description));
        $this->info("OK: Transaction added to Job Queue | User: `{$email}` Amount: `{$amount}`, Desc: `{$description}`");
    }
}



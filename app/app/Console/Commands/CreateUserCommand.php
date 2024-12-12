<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    protected $description = 'Command for make new user by `name`, `email`, `password`';

    protected $signature = 'user:create {name} {email} {password}';

    public function handle(UserService $userService): void
    {
        $name       = $this->argument('name');
        $email      = $this->argument('email');
        $password   = $this->argument('password');

        $validator = Validator::make([
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
        ], [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'password'  => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        try {
            $user = $userService->createUser(
                $name,
                $email,
                $password
            );
            $this->info("OK: User `{$user->email}` created.");
        } catch (Exception $e) {
            $this->error('ERROR: User is not created.');
            $this->error('Details:');
            $this->error($e->getMessage());
        }
    }
}

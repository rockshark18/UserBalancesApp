<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function findByEmail(string $email): User
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user){
                throw new Exception("User `{$email}` not found", 0);
            }
            return $user;
        }catch (Exception $e){
            throw new Exception('> UserService.findByEmail' .PHP_EOL . $e->getMessage(), 0, $e);
        }
    }

    public function createUser(string $name, string $email, string $password): User
    {
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $user->balance()->create(['balance' => 0]);
            return $user;
        } catch (Exception $e) {
            throw new Exception('> UserService.createUser'.PHP_EOL.'Failed to create user: ' . $e->getMessage(), 0, $e);
        }
    }
}

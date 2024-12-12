<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBalance extends Model
{
    protected $table = 'user_balances';

    protected $fillable = ['user_id', 'balance'];

    protected $casts = [
        'balance' => 'decimal:2', // NOTE: Я не использую 'float' из-за вероятности потерять точность, только bcmath(bcadd и т.д.) и хранение в string
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

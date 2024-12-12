<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    public $timestamps = false; // NOTE: we not using updated_at ! only createa_at

    protected $fillable = ['user_id', 'type', 'amount', 'desc'];

    protected $casts = [
        'type' => TransactionType::class,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

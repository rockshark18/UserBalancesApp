<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->timestamps();

            $table->index('user_id'); // Добавление индекса для user_id
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_balances');
    }
};
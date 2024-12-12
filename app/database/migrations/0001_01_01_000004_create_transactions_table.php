<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type', 32); // Income / Expense
            $table->decimal('amount', 15, 2);
            $table->text('desc');
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id'); // Добавление индекса для user_id
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};


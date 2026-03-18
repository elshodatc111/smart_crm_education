<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('balans', function (Blueprint $table) {$table->id();
            $table->decimal('cash', 15, 2)->default(0);
            $table->decimal('card', 15, 2)->default(0);
            $table->decimal('cash_salary', 15, 2)->default(0);
            $table->decimal('card_salary', 15, 2)->default(0);
            $table->decimal('cash_exson', 15, 2)->default(0);
            $table->decimal('card_exson', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('balans');
    }
};

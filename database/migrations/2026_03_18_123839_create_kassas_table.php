<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('kassas', function (Blueprint $table) {$table->id();
            $table->decimal('cash', 15, 2)->default(0);
            $table->decimal('card', 15, 2)->default(0);
            $table->decimal('output_cash_pending', 15, 2)->default(0);
            $table->decimal('output_card_pending', 15, 2)->default(0);
            $table->decimal('cost_cash_pending', 15, 2)->default(0);
            $table->decimal('cost_card_pending', 15, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('kassas');
    }
};

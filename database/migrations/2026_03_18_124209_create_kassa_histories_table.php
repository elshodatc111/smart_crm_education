<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('kassa_histories', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2);
            $table->enum('type', [
                'output_cash',
                'output_card',
                'cost_cash',
                'cost_card',
                'return_cash',
                'return_card',
            ]);
            $table->string('description')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'canceled', 'success'])->default('pending');
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }



    public function down(): void{
        Schema::dropIfExists('kassa_histories');
    }
};

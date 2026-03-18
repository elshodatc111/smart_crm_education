<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('chegirma_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('group_user_id')->constrained('group_users')->cascadeOnDelete();
            $table->date('start_data');
            $table->date('end_data');
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'success', 'cancel'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void{
        Schema::dropIfExists('chegirma_histories');
    }
};

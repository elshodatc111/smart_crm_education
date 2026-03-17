<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('payment',10,2)->default(0);
            $table->decimal('discount',10,2)->default(0);
            $table->unsignedInteger('discount_day')->default(3);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void{
        Schema::dropIfExists('payment_settings');
    }
};

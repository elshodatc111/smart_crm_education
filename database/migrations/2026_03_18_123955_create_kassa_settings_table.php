<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('kassa_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('cash_exson')->default(0);
            $table->unsignedTinyInteger('card_exson')->default(0);
            $table->unsignedTinyInteger('cash_salary')->default(0);
            $table->unsignedTinyInteger('card_salary')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('kassa_settings');
    }
};

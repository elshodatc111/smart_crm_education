<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('setting_sms', function (Blueprint $table) {
            $table->id();
            $table->boolean('visit_sms')->default(true);
            $table->boolean('payment_sms')->default(true);
            $table->boolean('password_sms')->default(true);
            $table->boolean('birthday_sms')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('setting_sms');
    }
};
